<?php
/**
 * Point d'entrée commun : chargé par index.php (Front Office) ET par chaque page du Back Office.
 * Il prépare la configuration, l'autoload, la session et la connexion PDO unique ($pdo).
 */
require_once __DIR__ . '/../config/config.php';

ini_set('display_errors', APP_DEBUG ? '1' : '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);
date_default_timezone_set('Africa/Tunis');
mb_internal_encoding('UTF-8');

spl_autoload_register(function (string $class) {
    foreach (['core', 'models', 'controllers'] as $dir) {
        $file = __DIR__ . "/$dir/$class.php";
        if (is_file($file)) {
            require_once $file;
            return;
        }
    }
});

require_once __DIR__ . '/core/helpers.php';

// Page d'erreur propre pour toute exception non gérée
set_exception_handler(function (Throwable $e) {
    error_log('AgriTwin - ' . get_class($e) . ' : ' . $e->getMessage() . ' (' . $e->getFile() . ':' . $e->getLine() . ')');
    if (!headers_sent()) {
        http_response_code(500);
    }
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    echo '<!DOCTYPE html><meta charset="utf-8"><title>Erreur - AgriTwin</title>'
       . '<body style="font-family:Arial;padding:40px;color:#202820"><h2>Une erreur est survenue</h2>'
       . '<p>Nous n\'avons pas pu traiter votre demande. Réessayez dans un instant.</p>'
       . (APP_DEBUG ? '<pre style="background:#f3f6f4;padding:15px;white-space:pre-wrap">' . htmlspecialchars((string) $e) . '</pre>' : '')
       . '<p><a href="' . htmlspecialchars(base_url() . '/index.php') . '">Retour à l\'accueil</a></p></body>';
    exit(1);
});

ob_start();

// Sécurité des en-têtes HTTP
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: same-origin');

// Session sécurisée (cookie inaccessible au JavaScript, envoyé uniquement sur notre site)
if (session_status() === PHP_SESSION_NONE) {
    session_name('AGRITWINSESSID');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => base_url() === '' ? '/' : base_url() . '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure'   => !empty($_SERVER['HTTPS']),
    ]);
    session_start();
}

// Connexion PDO unique, variable $pdo conservée pour les pages du Back Office d'origine
require_once __DIR__ . '/../config/database.php';
