<article class="card conseil-card">
    <?php if (!empty($c['nom_categorie'])): ?><span class="badge badge-cat"><?= e($c['nom_categorie']) ?></span><?php endif; ?>
    <h3><a href="<?= e(url('conseils/show', ['id' => $c['id_conseil']])) ?>"><?= e($c['titre']) ?></a></h3>
    <p><?= e(truncate($c['contenu'], 130)) ?></p>
    <p class="meta"><?= e(format_date($c['date_publication'])) ?></p>
</article>
