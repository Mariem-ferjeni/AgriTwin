
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - AgriTwin</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eaf5ed;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 30px;
            width: 350px;
            border-radius: 12px;
            box-shadow: 0 4px 15px #0002;
        }

        h2 {
            text-align: center;
            color: #287a40;
        }

        input {
            width: 100%;
            padding: 11px;
            margin: 8px 0 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #287a40;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #1d5e30;
        }

        .message {
            text-align: center;
            padding: 8px;
            border-radius: 5px;
            margin-bottom: 12px;
        }

        .success {
            background: #d4edda;
            color: #155724;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
        }

        p {
            text-align: center;
        }

        a {
            color: #287a40;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Connexion AgriTwin</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="message success">
            Inscription réussie ! Connectez-vous.
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="message error">
            Email ou mot de passe incorrect.
        </div>
    <?php endif; ?>

    <form action="../controllers/AuthController.php?action=login"
          method="POST">

        <label>Email :</label>
        <input type="email" name="email" required>

        <label>Mot de passe :</label>
        <input type="password" name="password" required>

        <button type="submit">Se connecter</button>

    </form>

    <p>
        Vous n'avez pas de compte ?
        <a href="inscription.php">Créer un compte</a>
    </p>

</div>

</body>
</html>
