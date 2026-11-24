<?php
/** Protection CSRF : un jeton secret par session, vérifié sur chaque formulaire POST. */
class Csrf
{
    public static function token(): string
    {
        if (empty($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf'];
    }

    public static function field(): string
    {
        return '<input type="hidden" name="_csrf" value="' . e(self::token()) . '">';
    }

    public static function check(): void
    {
        $sent = $_POST['_csrf'] ?? '';
        if (!is_string($sent) || !hash_equals(self::token(), $sent)) {
            http_response_code(403);   // code standard (419 est transformé en erreur 500 par Apache)
            die('<!DOCTYPE html><meta charset="utf-8"><title>Formulaire expiré</title>'
              . '<body style="font-family:Arial;padding:40px"><h2>Formulaire expiré ou invalide</h2>'
              . '<p>Par sécurité, l\'action a été refusée. Revenez à la page précédente, rechargez-la puis recommencez.</p>'
              . '<p><a href="' . e(base_url() . '/index.php') . '">Retour à l\'accueil</a></p></body>');
        }
    }
}
