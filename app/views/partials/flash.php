<?php if (!empty($flashes)): ?>
<div class="wrap flashes" role="status">
    <?php foreach ($flashes as $f): ?>
        <div class="flash flash-<?= e($f['type']) ?>"><?= e($f['msg']) ?></div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
