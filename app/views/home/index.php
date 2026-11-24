<section class="hero">
    <div class="wrap hero-grid">
        <div>
            <h1>Voir plus loin,<br>cultiver mieux.</h1>
            <p class="lead">AgriTwin rassemble vos exploitations, vos parcelles et leurs mesures dans un même endroit, pour décider avec des données claires plutôt qu'au jugé.</p>
            <div class="hero-actions">
                <?php if ($authUser): ?>
                    <a class="btn btn-citrus" href="<?= e(Auth::homeUrl()) ?>"><?= $authUser['role'] === 'admin' ? 'Ouvrir l\'administration' : 'Ouvrir mon espace' ?></a>
                <?php else: ?>
                    <a class="btn btn-citrus" href="<?= e(url('auth/register')) ?>">Créer mon espace agriculteur</a>
                    <a class="btn btn-ghost" href="<?= e(url('auth/login')) ?>">Se connecter</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="plan">
            <svg viewBox="0 0 560 450" role="img" aria-label="Exemple de plan d'exploitation : cinq parcelles avec leur humidité du sol et une courbe sur 30 jours">
                <rect width="560" height="450" rx="14" fill="#f6f8f5"/>
                <g stroke="#fff" stroke-width="3">
                    <rect x="20" y="20" width="215" height="150" rx="6" fill="#8fc08a"/>
                    <rect x="245" y="20" width="140" height="88" rx="6" fill="#d7e0a0"/>
                    <rect x="245" y="118" width="140" height="102" rx="6" fill="#a9cfa4"/>
                    <rect x="395" y="20" width="145" height="200" rx="6" fill="#cfe3c8"/>
                    <rect x="20" y="180" width="215" height="40" rx="6" fill="#e9d79a"/>
                </g>
                <g fill="#3d8b5a" opacity=".55">
                    <circle cx="420" cy="55" r="5"/><circle cx="450" cy="55" r="5"/><circle cx="480" cy="55" r="5"/><circle cx="510" cy="55" r="5"/>
                    <circle cx="420" cy="95" r="5"/><circle cx="450" cy="95" r="5"/><circle cx="480" cy="95" r="5"/><circle cx="510" cy="95" r="5"/>
                    <circle cx="420" cy="135" r="5"/><circle cx="450" cy="135" r="5"/><circle cx="480" cy="135" r="5"/><circle cx="510" cy="135" r="5"/>
                    <circle cx="420" cy="175" r="5"/><circle cx="450" cy="175" r="5"/><circle cx="480" cy="175" r="5"/><circle cx="510" cy="175" r="5"/>
                </g>
                <g font-family="Segoe UI,Arial,sans-serif" font-size="13" font-weight="600" fill="#1b261e">
                    <rect x="32" y="32" width="150" height="26" rx="13" fill="#fff"/><circle cx="46" cy="45" r="5" fill="#e59b1f"/><text x="58" y="50">Agrumes · 41 %</text>
                    <rect x="257" y="32" width="116" height="26" rx="13" fill="#fff"/><circle cx="271" cy="45" r="5" fill="#e59b1f"/><text x="283" y="50">Blé · 33 %</text>
                    <rect x="257" y="130" width="124" height="26" rx="13" fill="#fff"/><circle cx="271" cy="143" r="5" fill="#e59b1f"/><text x="283" y="148">Tomates · 45 %</text>
                    <rect x="407" y="32" width="122" height="26" rx="13" fill="#fff"/><circle cx="421" cy="45" r="5" fill="#e59b1f"/><text x="433" y="50">Oliviers · 29 %</text>
                    <rect x="32" y="187" width="128" height="26" rx="13" fill="#fff"/><circle cx="46" cy="200" r="5" fill="#e59b1f"/><text x="58" y="205">Jachère · 24 %</text>
                </g>
                <rect x="20" y="236" width="520" height="194" rx="10" fill="#fff"/>
                <text x="36" y="264" font-family="Segoe UI,Arial,sans-serif" font-size="14" font-weight="700" fill="#173d27">Humidité du sol — 30 derniers jours</text>
                <g stroke="#e3ebe4" stroke-width="1"><line x1="36" y1="290" x2="524" y2="290"/><line x1="36" y1="335" x2="524" y2="335"/><line x1="36" y1="380" x2="524" y2="380"/></g>
                <polyline fill="none" stroke="#2f7449" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                    points="36,350 76,338 116,344 156,318 196,326 236,300 276,312 316,336 356,360 396,332 436,306 476,312 524,296"/>
                <circle cx="524" cy="296" r="6" fill="#e59b1f" stroke="#fff" stroke-width="2"/>
                <text x="36" y="412" font-family="Segoe UI,Arial,sans-serif" font-size="12" fill="#5d6e62">Illustration : exemple de suivi d'une exploitation</text>
            </svg>
        </div>
    </div>
</section>

<section class="section wrap">
    <div class="features">
        <div class="feature">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="8" height="8" rx="1"/><rect x="13" y="3" width="8" height="5" rx="1"/><rect x="13" y="10" width="8" height="11" rx="1"/><rect x="3" y="13" width="8" height="8" rx="1"/></svg>
            <h3>Déclarez vos parcelles</h3>
            <p>Créez vos exploitations, découpez-les en parcelles et associez chaque parcelle à sa culture. AgriTwin vérifie que les surfaces restent cohérentes.</p>
        </div>
        <div class="feature">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 20h18"/><path d="M5 16l4-5 4 3 6-8"/><circle cx="19" cy="6" r="1.5"/></svg>
            <h3>Suivez l'évolution</h3>
            <p>Notez l'humidité du sol, la température et le pH, puis visualisez l'évolution de chaque parcelle au fil des semaines.</p>
        </div>
        <div class="feature">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21c-5 0-8-3-8-8 5 0 8 2 8 8z"/><path d="M12 21c0-6 3-9 8-9 0 5-3 9-8 9z"/><path d="M12 13V6"/></svg>
            <h3>Appliquez de bons conseils</h3>
            <p>Irrigation, fertilisation, protection des cultures : des conseils rédigés par l'équipe, classés par thème et faciles à retrouver.</p>
        </div>
    </div>
</section>

<div class="band">
    <div class="wrap numbers">
        <div><strong><?= (int) $stats['agriculteurs'] ?></strong><span>agriculteurs inscrits</span></div>
        <div><strong><?= (int) $stats['parcelles'] ?></strong><span>parcelles suivies</span></div>
        <div><strong><?= (int) $stats['cultures'] ?></strong><span>cultures au catalogue</span></div>
        <div><strong><?= (int) $stats['conseils'] ?></strong><span>conseils publiés</span></div>
    </div>
</div>

<section class="section wrap">
    <div class="section-head">
        <div><h2>Derniers conseils</h2><p class="muted">Des recommandations pratiques, à appliquer dès cette saison.</p></div>
        <a class="btn btn-ghost" href="<?= e(url('conseils')) ?>">Tous les conseils</a>
    </div>
    <?php if ($conseils): ?>
        <div class="grid-3"><?php foreach ($conseils as $c) partial('conseil_card', ['c' => $c]); ?></div>
    <?php else: ?>
        <div class="empty"><h3>Aucun conseil publié pour le moment</h3><p>Revenez bientôt.</p></div>
    <?php endif; ?>
</section>

<section class="section wrap" style="padding-top:0">
    <div class="section-head">
        <div><h2>Le catalogue des cultures</h2><p class="muted">Saison, cycle et caractéristiques de chaque culture.</p></div>
        <a class="btn btn-ghost" href="<?= e(url('cultures')) ?>">Voir le catalogue</a>
    </div>
    <?php if ($cultures): ?>
        <div class="grid-3"><?php foreach ($cultures as $c) partial('culture_card', ['c' => $c]); ?></div>
    <?php else: ?>
        <div class="empty"><h3>Le catalogue est vide</h3></div>
    <?php endif; ?>
</section>

<?php if (!$authUser): ?>
<section class="wrap">
    <div class="cta">
        <div><h2>Prêt à suivre vos parcelles ?</h2><p>L'inscription est gratuite et prend moins d'une minute.</p></div>
        <a class="btn btn-citrus" href="<?= e(url('auth/register')) ?>">Créer mon compte</a>
    </div>
</section>
<?php endif; ?>
