<div class="wrap auth">
    <div class="card">
        <h1 style="font-size:1.7rem">Connexion</h1>
        <p class="muted">Accédez à votre espace AgriTwin.</p>
        <?php foreach ($errors as $err): ?><div class="alert-box" role="alert"><?= e($err) ?></div><?php endforeach; ?>
        <form method="post" action="<?= e(url('auth/login')) ?>" novalidate>
            <?= Csrf::field() ?>
            <div class="field"><label for="email">Adresse email</label>
                <input id="email" type="email" name="email" value="<?= e($email) ?>" autocomplete="email" required autofocus></div>
            <div class="field"><label for="mdp">Mot de passe</label>
                <input id="mdp" type="password" name="mot_de_passe" autocomplete="current-password" required></div>
            <button class="btn btn-primary btn-block" type="submit">Se connecter</button>
        </form>
        <p class="auth-alt">Pas encore de compte ? <a href="<?= e(url('auth/register')) ?>">Créer un compte</a></p>
    </div>
</div>
