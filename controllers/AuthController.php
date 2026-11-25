
<?php

session_start();

require_once __DIR__ . '/../models/User.php';

$userModel = new User();

// Récupération de l'action
$action = $_GET['action'] ?? '';


// ===============================
// INSCRIPTION
// ===============================

if ($action === 'register') {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Vérification des champs
        if (
            $nom === '' ||
            $prenom === '' ||
            $email === '' ||
            $password === '' ||
            $confirmPassword === ''
        ) {
            exit("Tous les champs sont obligatoires.");
        }

        // Vérification email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            exit("Adresse email invalide.");
        }

        // Vérification mot de passe
        if (strlen($password) < 8) {
            exit("Le mot de passe doit contenir au moins 8 caractères.");
        }

        if ($password !== $confirmPassword) {
            exit("Les mots de passe ne correspondent pas.");
        }

        // Vérifier si email existe
        if ($userModel->getUserByEmail($email)) {
            exit("Cet email existe déjà.");
        }

        // Hasher le mot de passe
        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        // Enregistrer l'utilisateur
        try {

            $userModel->register(
                $nom,
                $prenom,
                $email,
                $hashedPassword
            );

            header("Location: ../views/connexion.php?success=1");
            exit();

        } catch (PDOException $e) {

            exit("Erreur lors de l'inscription.");

        }
    }
}


// ===============================
// CONNEXION
// ===============================

elseif ($action === 'login') {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            exit("Veuillez remplir tous les champs.");
        }

        // Chercher l'utilisateur
        $user = $userModel->getUserByEmail($email);

        // Vérifier les identifiants
        if (
            $user &&
            password_verify($password, $user['password'])
        ) {

            // Nouvelle session sécurisée
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Redirection selon le rôle
            if ($user['role'] === 'admin') {

                header("Location: ../views/admin.php");

            } else {

                header("Location: ../views/dashboard.php");

            }

            exit();

        } else {

            header("Location: ../views/connexion.php?error=1");
            exit();

        }
    }
}

else {

    http_response_code(400);
    echo "Action invalide.";

}

?>
