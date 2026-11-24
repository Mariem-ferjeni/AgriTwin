<?php
$adminUser = Auth::user();
$messagesNonLus = (new Message())->countUnread();
?>
<header class="topbar">
    <div class="page-title">
        Administration
    </div>

    <div class="topbar-right">
        <div class="search-box">
            <span>⌕</span>
            <input type="text" id="searchInput" placeholder="Rechercher...">
        </div>

        <a class="notification-button" href="messages.php" title="Messages de contact">
            ✉<?php if ($messagesNonLus > 0): ?><span class="notif-count"><?= (int) $messagesNonLus ?></span><?php endif; ?>
        </a>

        <div class="admin-profile">
            <div class="admin-avatar"><?= htmlspecialchars(mb_strtoupper(mb_substr($adminUser['prenom'], 0, 1))) ?></div>
            <div>
                <strong><?= htmlspecialchars($adminUser['prenom'] . ' ' . $adminUser['nom']) ?></strong>
                <small>Administrateur</small>
            </div>
        </div>

        <a class="topbar-link" href="<?= htmlspecialchars(url('home')) ?>" target="_blank" rel="noopener">Voir le site</a>
        <form method="post" action="<?= htmlspecialchars(url('auth/logout')) ?>" class="logout-form">
            <?= Csrf::field() ?>
            <button type="submit" class="logout-button">Déconnexion</button>
        </form>
    </div>
</header>

<?php foreach (flash_pull() as $f): ?>
    <div class="flash-admin flash-admin-<?= htmlspecialchars($f['type']) ?>"><?= htmlspecialchars($f['msg']) ?></div>
<?php endforeach; ?>
