<div class="wrap">
    <div class="page-head"><h1>Catalogue des cultures</h1><p>Retrouvez la saison, le cycle et les caractéristiques de chaque culture.</p></div>
    <form class="toolbar" method="get" action="<?= e(base_url() . '/index.php') ?>">
        <input type="hidden" name="r" value="cultures">
        <div class="field"><label for="q">Rechercher</label><input id="q" type="search" name="q" value="<?= e($f['q']) ?>" placeholder="Nom, variété…"></div>
        <div class="field"><label for="type">Type</label><select id="type" name="type" data-autosubmit><option value="">Tous</option>
            <?php foreach ($types as $t): ?><option value="<?= e($t) ?>" <?= $f['type'] === $t ? 'selected' : '' ?>><?= e($t) ?></option><?php endforeach; ?></select></div>
        <div class="field"><label for="saison">Saison</label><select id="saison" name="saison" data-autosubmit><option value="">Toutes</option>
            <?php foreach ($saisons as $s): ?><option value="<?= e($s) ?>" <?= $f['saison'] === $s ? 'selected' : '' ?>><?= e($s) ?></option><?php endforeach; ?></select></div>
        <div class="field"><button class="btn btn-primary" type="submit">Filtrer</button></div>
        <?php if ($f['q'] || $f['type'] || $f['saison']): ?><div class="field"><a class="btn btn-ghost" href="<?= e(url('cultures')) ?>">Réinitialiser</a></div><?php endif; ?>
    </form>
    <?php if ($cultures): ?>
        <p class="muted"><?= (int) $pager['total'] ?> culture(s)</p>
        <div class="grid-3"><?php foreach ($cultures as $c) partial('culture_card', ['c' => $c]); ?></div>
        <?php partial('pager', ['pager' => $pager]); ?>
    <?php else: ?>
        <div class="empty"><h3>Aucune culture ne correspond</h3><p>Essayez d'autres mots-clés ou réinitialisez les filtres.</p></div>
    <?php endif; ?>
</div>
