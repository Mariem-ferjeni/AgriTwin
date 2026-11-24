<div class="page-title">
    <div><h1>Bonjour, <?= e($authUser['prenom']) ?></h1><p class="muted" style="margin:0">Voici l'état de vos exploitations.</p></div>
    <a class="btn btn-primary" href="<?= e(url('exploitations/create')) ?>">+ Nouvelle exploitation</a>
</div>
<div class="stats">
    <div class="stat"><strong><?= (int) $stats['exploitations'] ?></strong><span>exploitation(s)</span></div>
    <div class="stat"><strong><?= (int) $stats['parcelles'] ?></strong><span>parcelle(s)</span></div>
    <div class="stat"><strong><?= e(number_format($stats['superficie'], 1, ',', ' ')) ?></strong><span>hectares au total</span></div>
    <div class="stat"><strong><?= (int) $stats['mesures'] ?></strong><span>mesure(s) enregistrée(s)</span></div>
</div>

<?php if ($stats['exploitations'] === 0): ?>
    <div class="empty"><h3>Commencez par déclarer votre première exploitation</h3>
        <p>Renseignez son nom, sa localisation et sa superficie. Vous pourrez ensuite la découper en parcelles.</p>
        <a class="btn btn-primary" href="<?= e(url('exploitations/create')) ?>">Créer mon exploitation</a></div>
<?php else: ?>
<div class="grid-main">
    <section>
        <h2>Mes parcelles</h2>
        <?php if ($parcelles): ?>
        <div class="table-wrap"><table class="table">
            <thead><tr><th>Parcelle</th><th>Exploitation</th><th>Culture</th><th>État</th><th></th></tr></thead>
            <tbody><?php foreach ($parcelles as $p): ?>
                <tr><td><strong><?= e($p['nom']) ?></strong><br><span class="meta"><?= e(number_format((float) $p['superficie'], 2, ',', ' ')) ?> ha</span></td>
                    <td><?= e($p['exploitation']) ?></td><td><?= e($p['culture'] ?? '—') ?></td><td><?= etat_badge($p['etat']) ?></td>
                    <td><div class="actions"><a class="btn btn-sm btn-ghost" href="<?= e(url('suivis', ['parcelle' => $p['id_parcelle']])) ?>">Suivi</a></div></td></tr>
            <?php endforeach; ?></tbody></table></div>
        <?php else: ?><div class="empty"><p style="margin:0">Aucune parcelle pour l'instant. Ouvrez une exploitation pour en ajouter.</p></div><?php endif; ?>

        <h2 style="margin-top:32px">Dernières mesures</h2>
        <?php if ($mesures): ?>
        <div class="card"><ul class="list-plain"><?php foreach ($mesures as $m): ?>
            <li><strong><?= e($m['parcelle']) ?></strong> — <?= e(format_date($m['date_suivi'])) ?><br>
                <span class="meta"><?= $m['humidite_sol'] !== null ? 'Humidité ' . e(number_format((float) $m['humidite_sol'], 1, ',', '')) . ' %' : '' ?>
                <?= $m['temperature'] !== null ? ' · ' . e(number_format((float) $m['temperature'], 1, ',', '')) . ' °C' : '' ?>
                <?= $m['ph_sol'] !== null ? ' · pH ' . e($m['ph_sol']) : '' ?></span>
                <?php if ($m['observation']): ?><br><?= e(truncate($m['observation'], 110)) ?><?php endif; ?></li>
        <?php endforeach; ?></ul></div>
        <?php else: ?><div class="empty"><p style="margin:0">Aucune mesure enregistrée. Ouvrez le suivi d'une parcelle pour en ajouter.</p></div><?php endif; ?>
    </section>
    <aside>
        <h2>Conseils pour vous</h2>
        <div class="stack"><?php foreach ($conseils as $c) partial('conseil_card', ['c' => $c]); ?></div>
        <p style="margin-top:16px"><a href="<?= e(url('conseils')) ?>">Voir tous les conseils</a></p>
    </aside>
</div>
<?php endif; ?>
