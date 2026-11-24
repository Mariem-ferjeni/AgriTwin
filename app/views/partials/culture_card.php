<article class="card culture-card">
    <div class="culture-top <?= e(culture_class($c['type_culture'])) ?>" aria-hidden="true"><?= culture_icon($c['type_culture']) ?></div>
    <div class="culture-body">
        <h3><a href="<?= e(url('cultures/show', ['id' => $c['id_culture']])) ?>"><?= e($c['nom']) ?></a></h3>
        <p class="meta"><?= e($c['type_culture']) ?><?= $c['variete'] ? ' · ' . e($c['variete']) : '' ?></p>
        <p class="chips"><?php if ($c['saison']): ?><span class="chip">Saison : <?= e($c['saison']) ?></span><?php endif; ?><span class="chip">Cycle : <?= (int) $c['duree_cycle'] ?> j</span></p>
    </div>
</article>
