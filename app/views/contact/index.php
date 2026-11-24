<?php $f = fn($k) => isset($errors[$k]) ? 'field invalid' : 'field'; ?>
<div class="wrap">
    <div class="page-head"><h1>Nous contacter</h1><p>Une question, une suggestion ? Écrivez-nous, l'équipe vous répond rapidement.</p></div>
    <div class="card form-card">
        <?php if ($errors): ?><div class="alert-box" role="alert">Le formulaire contient des erreurs, merci de les corriger.</div><?php endif; ?>
        <form method="post" action="<?= e(url('contact')) ?>" novalidate>
            <?= Csrf::field() ?>
            <div class="hp" aria-hidden="true"><label>Ne pas remplir <input name="website" tabindex="-1" autocomplete="off"></label></div>
            <div class="form-row">
                <div class="<?= $f('nom') ?>"><label for="nom">Nom</label><input id="nom" name="nom" value="<?= e($old['nom']) ?>" required>
                    <?php if (isset($errors['nom'])): ?><p class="error"><?= e($errors['nom']) ?></p><?php endif; ?></div>
                <div class="<?= $f('email') ?>"><label for="email">Email</label><input id="email" type="email" name="email" value="<?= e($old['email']) ?>" required>
                    <?php if (isset($errors['email'])): ?><p class="error"><?= e($errors['email']) ?></p><?php endif; ?></div>
            </div>
            <div class="<?= $f('sujet') ?>"><label for="sujet">Sujet</label><input id="sujet" name="sujet" value="<?= e($old['sujet']) ?>" required>
                <?php if (isset($errors['sujet'])): ?><p class="error"><?= e($errors['sujet']) ?></p><?php endif; ?></div>
            <div class="<?= $f('message') ?>"><label for="message">Message</label><textarea id="message" name="message" required><?= e($old['message']) ?></textarea>
                <?php if (isset($errors['message'])): ?><p class="error"><?= e($errors['message']) ?></p><?php endif; ?></div>
            <button class="btn btn-primary" type="submit">Envoyer le message</button>
        </form>
    </div>
</div>
