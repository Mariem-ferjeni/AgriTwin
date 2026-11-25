
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

if (
    isset($requiredRole) &&
    $_SESSION['role'] !== $requiredRole
) {
    http_response_code(403);
    exit("Acces interdit !");
}

?>
