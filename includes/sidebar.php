<?php
$page = basename($_SERVER['PHP_SELF']);
// Les pages ajouter_/details_/modifier_ activent le menu de leur module
$module = ['utilisateur' => 'utilisateurs.php', 'exploitation' => 'exploitations.php', 'culture' => 'cultures.php', 'conseil' => 'conseils.php', 'categorie' => 'categories.php'];
if (preg_match('/^(?:ajouter|details|modifier)_(\w+)\.php$/', $page, $m) && isset($module[$m[1]])) {
    $page = $module[$m[1]];
}
?>

<aside class="sidebar">

    <div class="logo">
        <span class="logo-icon">🌱</span>
        <span>AgriTwin</span>
    </div>

    <nav class="sidebar-menu">

        <a href="dashboard.php" class="menu-item <?= $page == 'dashboard.php' ? 'active' : '' ?>">
            <span>▦</span><span>Tableau de bord</span>
        </a>

        <a href="utilisateurs.php" class="menu-item <?= $page == 'utilisateurs.php' ? 'active' : '' ?>">
            <span>♙</span><span>Gestion des utilisateurs</span>
        </a>

        <a href="exploitations.php" class="menu-item <?= $page == 'exploitations.php' ? 'active' : '' ?>">
            <span>▤</span><span>Gestion des exploitations</span>
        </a>

        <a href="cultures.php" class="menu-item <?= $page == 'cultures.php' ? 'active' : '' ?>">
            <span>♧</span><span>Gestion des cultures</span>
        </a>

        <a href="conseils.php" class="menu-item <?= $page == 'conseils.php' ? 'active' : '' ?>">
            <span>♧</span><span>Conseils agricoles</span>
        </a>

        <a href="categories.php" class="menu-item <?= $page == 'categories.php' ? 'active' : '' ?>">
            <span>▱</span><span>Gestion des catégories</span>
        </a>

                <a href="messages.php" class="menu-item <?= $page == 'messages.php' ? 'active' : '' ?>">
            <span>✉</span><span>Messages de contact</span>
        </a>

        <a href="statistiques.php" class="menu-item <?= $page == 'statistiques.php' ? 'active' : '' ?>">
            <span>▥</span><span>Statistiques</span>
        </a>

        <a href="parametres.php" class="menu-item <?= $page == 'parametres.php' ? 'active' : '' ?>">
            <span>⚙</span><span>Paramètres</span>
        </a>

    </nav>
</aside>
