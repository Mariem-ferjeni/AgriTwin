<div class="wrap" style="padding-top:36px">
    <a class="back" href="<?= e(url('cultures')) ?>">← Retour au catalogue</a>
    <div class="layout-2 layout-detail">
        <div class="stack">
            <div class="card" style="padding:0;overflow:hidden">
                <div class="culture-top <?= e(culture_class($c['type_culture'])) ?>" style="height:140px;font-size:4rem" aria-hidden="true"><?= culture_icon($c['type_culture']) ?></div>
                <div style="padding:26px">
                    <h1><?= e($c['nom']) ?></h1>
                    <p class="chips" style="margin:0 0 18px"><span class="chip"><?= e($c['type_culture']) ?></span><?php if ($c['variete']): ?><span class="chip">Variété : <?= e($c['variete']) ?></span><?php endif; ?></p>
                    <div class="prose"><p><?= nl2br(e($c['description'] ?: 'Aucune description disponible pour cette culture.')) ?></p></div>
                </div>
            </div>
        </div>
        <aside class="stack">
            <div class="card"><h3>Fiche rapide</h3>
                <dl class="kv" style="grid-template-columns:110px 1fr"><dt>Type</dt><dd><?= e($c['type_culture']) ?></dd>
                    <dt>Saison</dt><dd><?= e($c['saison'] ?: '—') ?></dd>
                    <dt>Cycle</dt><dd><?= (int) $c['duree_cycle'] ?> jours</dd>
                    <dt>Parcelles</dt><dd><?= (int) $usage ?> sur AgriTwin</dd></dl></div>
            <?php if ($conseils): ?><div class="card"><h3>Conseils récents</h3><ul class="list-plain">
                <?php foreach ($conseils as $k): ?><li><a href="<?= e(url('conseils/show', ['id' => $k['id_conseil']])) ?>"><?= e($k['titre']) ?></a></li><?php endforeach; ?></ul></div><?php endif; ?>
        </aside>
    </div>
</div>
