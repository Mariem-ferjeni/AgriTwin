<?php $f = fn($k) => isset($errors[$k]) ? 'field invalid' : 'field'; $g = fn($k) => isset($pwdErrors[$k]) ? 'field invalid' : 'field'; ?>
<div class="page-title"><h1>Mon profil</h1></div>
<div class="grid-2 align-start">
    <div class="card">
        <h2>Mes informations</h2>
        <form method="post" action="<?= e(url('espace/updateProfil')) ?>" novalidate>
            <?= Csrf::field() ?>
            <div class="form-row">
                <div class="<?= $f('prenom') ?>"><label for="prenom">Prénom</label><input id="prenom" name="prenom" value="<?= e($old['prenom']) ?>" required>
                    <?php if (isset($errors['prenom'])): ?><p class="error"><?= e($errors['prenom']) ?></p><?php endif; ?></div>
                <div class="<?= $f('nom') ?>"><label for="nom">Nom</label><input id="nom" name="nom" value="<?= e($old['nom']) ?>" required>
                    <?php if (isset($errors['nom'])): ?><p class="error"><?= e($errors['nom']) ?></p><?php endif; ?></div>
            </div>
            <div class="<?= $f('email') ?>"><label for="email">Email</label><input id="email" type="email" name="email" value="<?= e($old['email']) ?>" required>
                <?php if (isset($errors['email'])): ?><p class="error"><?= e($errors['email']) ?></p><?php endif; ?></div>
            <div class="<?= $f('telephone') ?>"><label for="tel">Téléphone</label><input id="tel" name="telephone" value="<?= e($old['telephone']) ?>">
                <?php if (isset($errors['telephone'])): ?><p class="error"><?= e($errors['telephone']) ?></p><?php endif; ?></div>
            <button class="btn btn-primary" type="submit">Enregistrer</button>
        </form>
    </div>
    <div class="card">
        <h2>Changer le mot de passe</h2>
        <form method="post" action="<?= e(url('espace/updateMotDePasse')) ?>" novalidate>
            <?= Csrf::field() ?>
            <div class="<?= $g('actuel') ?>"><label for="actuel">Mot de passe actuel</label><input id="actuel" type="password" name="actuel" autocomplete="current-password" required>
                <?php if (isset($pwdErrors['actuel'])): ?><p class="error"><?= e($pwdErrors['actuel']) ?></p><?php endif; ?></div>
            <div class="<?= $g('nouveau') ?>"><label for="nouveau">Nouveau mot de passe</label><input id="nouveau" type="password" name="nouveau" autocomplete="new-password" required>
                <p class="help">8 caractères minimum, avec une lettre et un chiffre.</p>
                <?php if (isset($pwdErrors['nouveau'])): ?><p class="error"><?= e($pwdErrors['nouveau']) ?></p><?php endif; ?></div>
            <div class="<?= $g('confirmation') ?>"><label for="conf">Confirmer</label><input id="conf" type="password" name="confirmation" autocomplete="new-password" required>
                <?php if (isset($pwdErrors['confirmation'])): ?><p class="error"><?= e($pwdErrors['confirmation']) ?></p><?php endif; ?></div>
            <button class="btn btn-primary" type="submit">Modifier le mot de passe</button>
        </form>
    </div>
</div>
