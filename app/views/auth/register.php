<?php $f = fn($k) => isset($errors[$k]) ? 'field invalid' : 'field'; ?>
<div class="wrap auth">
    <div class="card">
        <h1 style="font-size:1.7rem">Créer un compte agriculteur</h1>
        <p class="muted">Gratuit, sans engagement.</p>
        <?php if ($errors): ?><div class="alert-box" role="alert">Le formulaire contient des erreurs, merci de les corriger.</div><?php endif; ?>
        <form method="post" action="<?= e(url('auth/register')) ?>" novalidate>
            <?= Csrf::field() ?>
            <div class="form-row">
                <div class="<?= $f('prenom') ?>"><label for="prenom">Prénom</label><input id="prenom" name="prenom" value="<?= e($old['prenom']) ?>" autocomplete="given-name" required>
                    <?php if (isset($errors['prenom'])): ?><p class="error"><?= e($errors['prenom']) ?></p><?php endif; ?></div>
                <div class="<?= $f('nom') ?>"><label for="nom">Nom</label><input id="nom" name="nom" value="<?= e($old['nom']) ?>" autocomplete="family-name" required>
                    <?php if (isset($errors['nom'])): ?><p class="error"><?= e($errors['nom']) ?></p><?php endif; ?></div>
            </div>
            <div class="<?= $f('email') ?>"><label for="email">Adresse email</label><input id="email" type="email" name="email" value="<?= e($old['email']) ?>" autocomplete="email" required>
                <?php if (isset($errors['email'])): ?><p class="error"><?= e($errors['email']) ?></p><?php endif; ?></div>
            <div class="<?= $f('telephone') ?>"><label for="tel">Téléphone (facultatif)</label><input id="tel" name="telephone" value="<?= e($old['telephone']) ?>" autocomplete="tel">
                <?php if (isset($errors['telephone'])): ?><p class="error"><?= e($errors['telephone']) ?></p><?php endif; ?></div>
            <div class="<?= $f('mot_de_passe') ?>"><label for="mdp">Mot de passe</label><input id="mdp" type="password" name="mot_de_passe" autocomplete="new-password" required>
                <p class="help">8 caractères minimum, avec au moins une lettre et un chiffre.</p>
                <?php if (isset($errors['mot_de_passe'])): ?><p class="error"><?= e($errors['mot_de_passe']) ?></p><?php endif; ?></div>
            <div class="<?= $f('confirmation') ?>"><label for="conf">Confirmer le mot de passe</label><input id="conf" type="password" name="confirmation" autocomplete="new-password" required>
                <?php if (isset($errors['confirmation'])): ?><p class="error"><?= e($errors['confirmation']) ?></p><?php endif; ?></div>
            <button class="btn btn-primary btn-block" type="submit">Créer mon compte</button>
        </form>
        <p class="auth-alt">Déjà inscrit ? <a href="<?= e(url('auth/login')) ?>">Se connecter</a></p>
    </div>
</div>
