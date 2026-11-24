<?php $f = fn($k) => isset($errors[$k]) ? 'field invalid' : 'field';
$hums = array_reverse(array_map(fn($s) => $s['humidite_sol'] !== null ? (float) $s['humidite_sol'] : null, array_slice($suivis, 0, 12))); ?>
<a class="back" href="<?= e(url('exploitations/show', ['id' => $p['id_exploitation']])) ?>">← <?= e($p['exploitation']) ?></a>
<div class="page-title"><div><h1>Suivi : <?= e($p['nom']) ?></h1>
    <p class="muted" style="margin:0"><?= e(number_format((float) $p['superficie'], 2, ',', ' ')) ?> ha · <?= e($p['culture'] ?? 'Sans culture') ?> · <?= etat_badge($p['etat']) ?></p></div></div>
<div class="grid-form">
    <div class="card">
        <h2>Ajouter une mesure</h2>
        <form method="post" action="<?= e(url('suivis/store', ['parcelle' => $p['id_parcelle']])) ?>" novalidate>
            <?= Csrf::field() ?>
            <div class="<?= $f('date_suivi') ?>"><label for="d">Date</label><input id="d" type="date" name="date_suivi" max="<?= date('Y-m-d') ?>" value="<?= e($old['date_suivi']) ?>" required>
                <?php if (isset($errors['date_suivi'])): ?><p class="error"><?= e($errors['date_suivi']) ?></p><?php endif; ?></div>
            <div class="form-row">
                <div class="<?= $f('humidite_sol') ?>"><label for="h">Humidité (%)</label><input id="h" name="humidite_sol" inputmode="decimal" value="<?= e($old['humidite_sol']) ?>">
                    <?php if (isset($errors['humidite_sol'])): ?><p class="error"><?= e($errors['humidite_sol']) ?></p><?php endif; ?></div>
                <div class="<?= $f('temperature') ?>"><label for="t">Température (°C)</label><input id="t" name="temperature" inputmode="decimal" value="<?= e($old['temperature']) ?>">
                    <?php if (isset($errors['temperature'])): ?><p class="error"><?= e($errors['temperature']) ?></p><?php endif; ?></div>
            </div>
            <div class="<?= $f('ph_sol') ?>"><label for="ph">pH du sol</label><input id="ph" name="ph_sol" inputmode="decimal" value="<?= e($old['ph_sol']) ?>">
                <?php if (isset($errors['ph_sol'])): ?><p class="error"><?= e($errors['ph_sol']) ?></p><?php endif; ?></div>
            <div class="<?= $f('observation') ?>"><label for="o">Observation</label><textarea id="o" name="observation" style="min-height:90px"><?= e($old['observation']) ?></textarea>
                <?php if (isset($errors['observation'])): ?><p class="error"><?= e($errors['observation']) ?></p><?php endif; ?></div>
            <button class="btn btn-primary btn-block" type="submit">Enregistrer la mesure</button>
        </form>
    </div>
    <div>
        <?php $spark = sparkline($hums); if ($spark): ?>
        <div class="card" style="margin-bottom:20px"><h3>Évolution de l'humidité</h3><?= $spark ?><p class="meta" style="margin:6px 0 0">Les <?= count(array_filter($hums, fn($v) => $v !== null)) ?> dernières mesures renseignées</p></div>
        <?php endif; ?>
        <h2>Historique</h2>
        <?php if ($suivis): ?>
        <div class="table-wrap"><table class="table">
            <thead><tr><th>Date</th><th>Humidité</th><th>Temp.</th><th>pH</th><th>Observation</th><th></th></tr></thead>
            <tbody><?php foreach ($suivis as $s): ?>
                <tr><td><?= e(format_date($s['date_suivi'])) ?></td>
                    <td><?= $s['humidite_sol'] !== null ? e(number_format((float) $s['humidite_sol'], 1, ',', '')) . ' %' : '—' ?></td>
                    <td><?= $s['temperature'] !== null ? e(number_format((float) $s['temperature'], 1, ',', '')) . ' °C' : '—' ?></td>
                    <td><?= $s['ph_sol'] !== null ? e($s['ph_sol']) : '—' ?></td>
                    <td><?= e($s['observation'] ?? '') ?></td>
                    <td><form method="post" action="<?= e(url('suivis/destroy', ['id' => $s['id_suivi']])) ?>" class="inline" data-confirm="Supprimer cette mesure ?"><?= Csrf::field() ?><button class="btn btn-sm btn-danger" type="submit">Supprimer</button></form></td></tr>
            <?php endforeach; ?></tbody></table></div>
        <?php else: ?><div class="empty"><h3>Aucune mesure pour cette parcelle</h3><p>Utilisez le formulaire pour enregistrer la première.</p></div><?php endif; ?>
    </div>
</div>
