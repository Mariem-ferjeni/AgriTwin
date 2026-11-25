
<?php

require_once __DIR__ . '/../config/database.php';

class User
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Inscription d'un utilisateur
    public function register($nom, $prenom, $email, $password)
    {
        $sql = "INSERT INTO users
                (nom, prenom, email, password)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $nom,
            $prenom,
            $email,
            $password
        ]);
    }

    // Recherche d'un utilisateur par email
    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);

        return $stmt->fetch();
    }
}

?>
