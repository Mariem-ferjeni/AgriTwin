<?php
/** Authentification, sessions et rôles (admin / agriculteur). */
class Auth
{
    private static ?array $user = null;
    private static bool $loaded = false;

    /** Utilisateur connecté (rechargé depuis la base : un compte supprimé ou rétrogradé perd son accès tout de suite). */
    public static function user(): ?array
    {
        if (self::$loaded) {
            return self::$user;
        }
        self::$loaded = true;
        $id = $_SESSION['uid'] ?? null;
        if (!$id) {
            return null;
        }
        if (time() - ($_SESSION['last_activity'] ?? 0) > SESSION_IDLE_TIMEOUT) {
            self::forget();
            flash('error', 'Session expirée par inactivité. Veuillez vous reconnecter.');
            return null;
        }
        $u = (new Utilisateur())->find((int) $id);
        if (!$u) {
            self::forget();
            return null;
        }
        $_SESSION['last_activity'] = time();
        return self::$user = $u;
    }

    public static function check(): bool   { return self::user() !== null; }
    public static function isAdmin(): bool { return (self::user()['role'] ?? '') === 'admin'; }
    public static function isFarmer(): bool { return (self::user()['role'] ?? '') === 'agriculteur'; }

    public static function login(array $u): void
    {
        session_regenerate_id(true);               // empêche la fixation de session
        $_SESSION['uid'] = (int) $u['id_utilisateur'];
        $_SESSION['last_activity'] = time();
        unset($_SESSION['login_fails'], $_SESSION['login_block_until']);
        self::$user = null;
        self::$loaded = false;
    }

    public static function logout(): void
    {
        self::forget();
        session_regenerate_id(true);
    }

    private static function forget(): void
    {
        unset($_SESSION['uid'], $_SESSION['last_activity']);
        self::$user = null;
        self::$loaded = true;
    }

    /** Page d'accueil de chaque rôle après connexion. */
    public static function homeUrl(?array $u = null): string
    {
        $u = $u ?? self::user();
        return ($u['role'] ?? '') === 'admin' ? admin_url('dashboard.php') : url('espace');
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            $_SESSION['intended'] = $_SERVER['REQUEST_URI'] ?? '';
            flash('error', 'Veuillez vous connecter pour accéder à cette page.');
            redirect(url('auth/login'));
        }
    }

    /** Pages du Back Office : administrateurs uniquement. */
    public static function requireAdmin(): void
    {
        self::requireLogin();
        if (!self::isAdmin()) {
            flash('error', 'Accès réservé aux administrateurs.');
            redirect(url('espace'));
        }
    }

    /** Espace personnel : agriculteurs uniquement. */
    public static function requireFarmer(): void
    {
        self::requireLogin();
        if (!self::isFarmer()) {
            flash('error', 'L\'espace agriculteur est réservé aux comptes agriculteurs.');
            redirect(admin_url('dashboard.php'));
        }
    }
}
