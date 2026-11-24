<?php $edit = $p !== null; $f = fn($k) => isset($errors[$k]) ? 'field invalid' : 'field';
$action = $edit ? url('parcelles/update', ['id' => $p['id_parcelle']]) : url('parcelles/store', ['exploitation' => $e['id_exploitation']]); ?>
<a class="back" href="<?= e(url('exploitations/show', ['id' => $e['id_exploitation']])) ?>">← <?= e($e['nom']) ?></a>
<div class="page-title"><h1><?= $edit ? 'Modifier la parcelle' : 'Nouvelle parcelle' ?></h1></div>
<div class="card form-card">
    <p class="meta">Surface encore disponible dans « <?= e($e['nom']) ?> » : <strong><?= e(number_format(max(0, $libre), 2, ',', ' ')) ?> ha</strong></p>
    <?php if ($errors): ?><div class="alert-box" role="alert">Le formulaire contient des erreurs, merci de les corriger.</div><?php endif; ?>
    <form method="post" action="<?= e($action) ?>" novalidate>
        <?= Csrf::field() ?>
        <div class="<?= $f('nom') ?>"><label for="nom">Nom de la parcelle</label><input id="nom" name="nom" value="<?= e($old['nom'] ?? '') ?>" required>
            <?php if (isset($errors['nom'])): ?><p class="error"><?= e($errors['nom']) ?></p><?php endif; ?></div>
        <div class="form-row">
            <div class="<?= $f('superficie') ?>"><label for="sup">Superficie (hectares)</label><input id="sup" name="superficie" inputmode="decimal" value="<?= e($old['superficie'] ?? '') ?>" required>
                <?php if (isset($errors['superficie'])): ?><p class="error"><?= e($errors['superficie']) ?></p><?php endif; ?></div>
            <div class="<?= $f('type_sol') ?>"><label for="sol">Type de sol</label><select id="sol" name="type_sol"><option value="">— Non précisé —</option>
                <?php foreach (Parcelle::SOLS as $s): ?><option value="<?= e($s) ?>" <?= ($old['type_sol'] ?? '') === $s ? 'selected' : '' ?>><?= e($s) ?></option><?php endforeach; ?></select>
                <?php if (isset($errors['type_sol'])): ?><p class="error"><?= e($errors['type_sol']) ?></p><?php endif; ?></div>
        </div>
        <div class="<?= $f('id_culture') ?>"><label for="cul">Culture</label><select id="cul" name="id_culture"><option value="">— Aucune pour le moment —</option>
            <?php foreach ($cultures as $c): ?><option value="<?= (int) $c['id_culture'] ?>" <?= (string) ($old['id_culture'] ?? '') === (string) $c['id_culture'] ? 'selected' : '' ?>><?= e($c['nom']) ?> (<?= e($c['type_culture']) ?>)</option><?php endforeach; ?></select>
            <?php if (isset($errors['id_culture'])): ?><p class="error"><?= e($errors['id_culture']) ?></p><?php endif; ?></div>
        <div class="form-row">
            <div class="<?= $f('date_plantation') ?>"><label for="dp">Date de plantation</label><input id="dp" type="date" name="date_plantation" value="<?= e($old['date_plantation'] ?? '') ?>">
                <?php if (isset($errors['date_plantation'])): ?><p class="error"><?= e($errors['date_plantation']) ?></p><?php endif; ?></div>
            <div class="<?= $f('etat') ?>"><label for="etat">État</label><select id="etat" name="etat">
                <?php foreach (Parcelle::ETATS as $k => $l): ?><option value="<?= e($k) ?>" <?= ($old['etat'] ?? 'en_preparation') === $k ? 'selected' : '' ?>><?= e($l) ?></option><?php endforeach; ?></select>
                <?php if (isset($errors['etat'])): ?><p class="error"><?= e($errors['etat']) ?></p><?php endif; ?></div>
        </div>
        <div class="form-actions"><button class="btn btn-primary" type="submit"><?= $edit ? 'Enregistrer' : 'Ajouter la parcelle' ?></button>
            <a class="btn btn-ghost" href="<?= e(url('exploitations/show', ['id' => $e['id_exploitation']])) ?>">Annuler</a></div>
    </form>
</div>
