<?php
/** Connexion PDO unique (pattern « singleton »). */
class Database
{
    private static ?PDO $pdo = null;

    public static function pdo(): PDO
    {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO(
                    'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
                    DB_USER,
                    DB_PASS,
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                    ]
                );
            } catch (PDOException $e) {
                error_log('AgriTwin - connexion MySQL impossible : ' . $e->getMessage());
                http_response_code(500);
                die(APP_DEBUG
                    ? 'Erreur de connexion à la base : ' . htmlspecialchars($e->getMessage())
                    : 'Service momentanément indisponible. Vérifiez que MySQL est démarré et que la base « agritwin » est importée.');
            }
        }
        return self::$pdo;
    }
}
