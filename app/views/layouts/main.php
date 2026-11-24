<?php
$route = $_GET['r'] ?? 'home';
$on = fn(string $p) => $route === $p || str_starts_with($route, $p . '/');
$homeOn = in_array($route, ['home', 'home/index'], true);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?></title>
    <meta name="description" content="AgriTwin : suivez vos exploitations, vos parcelles et accédez à des conseils agricoles simples et fiables.">
    <link rel="stylesheet" href="<?= e(asset('css/front.css')) ?>">
</head>
<body>
<a class="skip" href="#contenu">Aller au contenu</a>
<header class="site-header">
    <div class="wrap bar">
        <a class="brand" href="<?= e(url('home')) ?>"><span class="brand-mark">🌱</span> AgriTwin</a>
        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="menu" aria-label="Menu">☰</button>
        <nav id="menu" class="menu" aria-label="Navigation principale">
            <a href="<?= e(url('home')) ?>" class="<?= $homeOn ? 'on' : '' ?>">Accueil</a>
            <a href="<?= e(url('cultures')) ?>" class="<?= $on('cultures') ? 'on' : '' ?>">Cultures</a>
            <a href="<?= e(url('conseils')) ?>" class="<?= $on('conseils') ? 'on' : '' ?>">Conseils</a>
            <a href="<?= e(url('home/about')) ?>" class="<?= $route === 'home/about' ? 'on' : '' ?>">À propos</a>
            <a href="<?= e(url('contact')) ?>" class="<?= $on('contact') ? 'on' : '' ?>">Contact</a>
            <span class="menu-sep"></span>
            <?php if ($authUser): ?>
                <a class="btn btn-sm btn-primary" href="<?= e(Auth::homeUrl()) ?>"><?= $authUser['role'] === 'admin' ? 'Administration' : 'Mon espace' ?></a>
                <form method="post" action="<?= e(url('auth/logout')) ?>" class="inline"><?= Csrf::field() ?><button class="btn btn-sm btn-ghost" type="submit">Déconnexion</button></form>
            <?php else: ?>
                <a class="btn btn-sm btn-ghost" href="<?= e(url('auth/login')) ?>">Connexion</a>
                <a class="btn btn-sm btn-primary" href="<?= e(url('auth/register')) ?>">Créer un compte</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main id="contenu">
    <?php partial('flash', ['flashes' => $flashes]); ?>
    <?= $content ?>
</main>

<footer class="site-footer">
    <div class="wrap foot">
        <div>
            <p class="brand"><span class="brand-mark">🌱</span> AgriTwin</p>
            <p class="muted-on-dark"><?= e(APP_SLOGAN) ?></p>
        </div>
        <div>
            <p class="foot-title">Découvrir</p>
            <a href="<?= e(url('cultures')) ?>">Catalogue des cultures</a>
            <a href="<?= e(url('conseils')) ?>">Conseils agricoles</a>
            <a href="<?= e(url('home/about')) ?>">À propos du projet</a>
        </div>
        <div>
            <p class="foot-title">Mon compte</p>
            <?php if ($authUser): ?>
                <a href="<?= e(Auth::homeUrl()) ?>"><?= $authUser['role'] === 'admin' ? 'Administration' : 'Mon espace' ?></a>
            <?php else: ?>
                <a href="<?= e(url('auth/login')) ?>">Connexion</a>
                <a href="<?= e(url('auth/register')) ?>">Créer un compte</a>
            <?php endif; ?>
            <a href="<?= e(url('contact')) ?>">Nous écrire</a>
        </div>
    </div>
    <div class="wrap legal">Projet universitaire AgriTwin · <?= date('Y') ?></div>
</footer>
<script src="<?= e(asset('js/front.js')) ?>"></script>
</body>
</html>
