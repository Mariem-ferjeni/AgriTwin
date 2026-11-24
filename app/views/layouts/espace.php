<?php
$route = $_GET['r'] ?? 'espace';
$on = fn(array $ps) => (bool) array_filter($ps, fn($p) => $route === $p || str_starts_with($route, $p . '/'));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?></title>
    <link rel="stylesheet" href="<?= e(asset('css/front.css')) ?>">
</head>
<body class="espace-body">
<a class="skip" href="#contenu">Aller au contenu</a>
<div class="app">
    <aside class="app-side">
        <a class="brand" href="<?= e(url('home')) ?>"><span class="brand-mark">🌱</span> AgriTwin</a>
        <p class="side-user"><strong><?= e($authUser['prenom'] . ' ' . $authUser['nom']) ?></strong><span>Agriculteur</span></p>
        <nav class="side-nav" aria-label="Espace personnel">
            <a href="<?= e(url('espace')) ?>" class="<?= in_array($route, ['espace', 'espace/index'], true) ? 'on' : '' ?>">Tableau de bord</a>
            <a href="<?= e(url('exploitations')) ?>" class="<?= $on(['exploitations', 'parcelles', 'suivis']) ? 'on' : '' ?>">Mes exploitations</a>
            <a href="<?= e(url('espace/profil')) ?>" class="<?= $route === 'espace/profil' ? 'on' : '' ?>">Mon profil</a>
            <a href="<?= e(url('conseils')) ?>">Conseils agricoles</a>
            <a href="<?= e(url('cultures')) ?>">Catalogue des cultures</a>
        </nav>
        <form method="post" action="<?= e(url('auth/logout')) ?>" class="side-logout"><?= Csrf::field() ?><button class="btn btn-ghost-dark" type="submit">Se déconnecter</button></form>
    </aside>
    <main id="contenu" class="app-main">
        <?php partial('flash', ['flashes' => $flashes]); ?>
        <?= $content ?>
    </main>
</div>
<script src="<?= e(asset('js/front.js')) ?>"></script>
</body>
</html>
