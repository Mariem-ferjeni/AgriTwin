<div class="wrap">
    <div class="page-head"><h1>Conseils agricoles</h1><p>Des recommandations simples, classées par thème.</p></div>
    <div class="layout-2">
        <aside>
            <form method="get" action="<?= e(base_url() . '/index.php') ?>" class="field">
                <input type="hidden" name="r" value="conseils">
                <?php if ($cat): ?><input type="hidden" name="cat" value="<?= (int) $cat ?>"><?php endif; ?>
                <label for="q">Rechercher</label><input id="q" type="search" name="q" value="<?= e($q) ?>" placeholder="Mot-clé…">
            </form>
            <p style="font-weight:700;margin-bottom:6px">Thèmes</p>
            <ul class="filter-list">
                <li><a href="<?= e(self_url(['cat' => '', 'page' => ''])) ?>" class="<?= !$cat ? 'on' : '' ?>">Tous les thèmes</a></li>
                <?php foreach ($categories as $k): ?>
                    <li><a href="<?= e(self_url(['cat' => $k['id_categorie'], 'page' => ''])) ?>" class="<?= $cat === (int) $k['id_categorie'] ? 'on' : '' ?>">
                        <span><?= e($k['nom_categorie']) ?></span><span class="muted"><?= (int) $k['nb'] ?></span></a></li>
                <?php endforeach; ?>
            </ul>
        </aside>
        <div>
            <?php if ($conseils): ?>
                <div class="grid-2"><?php foreach ($conseils as $c) partial('conseil_card', ['c' => $c]); ?></div>
                <?php partial('pager', ['pager' => $pager]); ?>
            <?php else: ?>
                <div class="empty"><h3>Aucun conseil trouvé</h3><p>Modifiez votre recherche ou choisissez un autre thème.</p></div>
            <?php endif; ?>
        </div>
    </div>
</div>
