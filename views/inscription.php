
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - AgriTwin</title>

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

    <h2>Créer un compte AgriTwin</h2>

    <form action="../controllers/AuthController.php?action=register"
          method="POST">

        <label>Nom :</label>
        <input type="text" name="nom" required>

        <label>Prénom :</label>
        <input type="text" name="prenom" required>

        <label>Email :</label>
        <input type="email" name="email" required>

        <label>Mot de passe :</label>
        <input type="password" name="password"
               minlength="8" required>

        <label>Confirmer le mot de passe :</label>
        <input type="password" name="confirm_password"
               minlength="8" required>

        <button type="submit">S'inscrire</button>

    </form>

    <p>
        Vous avez déjà un compte ?
        <a href="connexion.php">Se connecter</a>
    </p>

</div>

</body>
</html>
