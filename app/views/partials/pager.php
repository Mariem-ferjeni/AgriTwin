<?php if (($pager['pages'] ?? 1) > 1): ?>
<nav class="pager" aria-label="Pagination">
    <?php if ($pager['page'] > 1): ?><a href="<?= e(self_url(['page' => $pager['page'] - 1])) ?>">← Précédent</a><?php endif; ?>
    <?php for ($i = 1; $i <= $pager['pages']; $i++): ?>
        <a href="<?= e(self_url(['page' => $i])) ?>" class="<?= $i === $pager['page'] ? 'on' : '' ?>" <?= $i === $pager['page'] ? 'aria-current="page"' : '' ?>><?= $i ?></a>
    <?php endfor; ?>
    <?php if ($pager['page'] < $pager['pages']): ?><a href="<?= e(self_url(['page' => $pager['page'] + 1])) ?>">Suivant →</a><?php endif; ?>
</nav>
<?php endif; ?>
