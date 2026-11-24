<div class="wrap" style="padding:80px 0;text-align:center">
    <h1>Accès refusé</h1>
    <p class="muted"><?= e($message ?: 'Vous n\'avez pas l\'autorisation d\'accéder à cette page.') ?></p>
    <p><a class="btn btn-primary" href="<?= e(url('home')) ?>">Retour à l'accueil</a></p>
</div>
