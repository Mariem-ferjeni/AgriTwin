<div class="wrap">
    <div class="page-head"><h1>À propos d'AgriTwin</h1>
        <p>Un projet universitaire qui explore l'idée de « jumeau numérique » appliquée à l'agriculture : une représentation numérique de l'exploitation, mise à jour par l'agriculteur lui-même.</p></div>
    <div class="grid-2" style="margin-bottom:24px">
        <div class="card stack"><h2>Notre objectif</h2>
            <p>Aider les agriculteurs à garder une vue d'ensemble de leurs exploitations, à suivre l'état de leurs parcelles et à retrouver facilement des conseils adaptés à leurs cultures.</p>
            <p>Les mesures sont saisies manuellement : AgriTwin ne remplace ni un capteur ni un conseiller agricole, il organise l'information pour mieux la comprendre.</p></div>
        <div class="card stack"><h2>Ce que propose la plateforme</h2>
            <ul class="list-plain">
                <li><strong>Catalogue des cultures</strong> — saison, cycle, variétés.</li>
                <li><strong>Conseils</strong> — classés par thème (irrigation, sol, protection…).</li>
                <li><strong>Espace agriculteur</strong> — exploitations, parcelles, suivi des mesures.</li>
                <li><strong>Administration</strong> — gestion des contenus et des comptes par l'équipe.</li>
            </ul></div>
    </div>
    <div class="card" style="margin-bottom:24px"><h2>Technologies</h2>
        <p style="margin:0">PHP (architecture MVC), MySQL via PDO, HTML, CSS et JavaScript, exécutés sous XAMPP. Les mots de passe sont chiffrés, les formulaires protégés contre les attaques courantes (injection SQL, XSS, CSRF) et chaque rôle accède uniquement à ses pages.</p></div>
    <p><a class="btn btn-primary" href="<?= e(url('contact')) ?>">Nous contacter</a></p>
</div>
