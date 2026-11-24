<div class="wrap" style="padding-top:36px;max-width:860px">
    <a class="back" href="<?= e(url('conseils')) ?>">← Tous les conseils</a>
    <article class="card" style="padding:34px">
        <?php if ($c['nom_categorie']): ?><a class="badge badge-cat" href="<?= e(url('conseils', ['cat' => $c['id_categorie']])) ?>" style="text-decoration:none"><?= e($c['nom_categorie']) ?></a><?php endif; ?>
        <h1 style="margin-top:10px"><?= e($c['titre']) ?></h1>
        <p class="meta">Publié le <?= e(format_date($c['date_publication'])) ?></p>
        <div class="prose"><p><?= nl2br(e($c['contenu'])) ?></p></div>
    </article>
    <?php if ($similaires): ?>
        <h2 style="margin-top:40px">Dans le même thème</h2>
        <div class="grid-2"><?php foreach ($similaires as $s) partial('conseil_card', ['c' => $s]); ?></div>
    <?php endif; ?>
</div>
