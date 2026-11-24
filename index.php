
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AgriTwin - Agriculture intelligente</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="dashboard">

    <!-- MENU LATERAL -->
    <aside class="sidebar">

        <div class="logo">
    <div class="logo-container">
        <img src="images/logo.png" alt="Logo AgriTwin">
        <h2>AgriTwin</h2>
    </div>

    <p>Agriculture intelligente</p>
</div>

        <nav>
            <a href="#" class="active" data-page="dashboard">
                 Tableau de bord
            </a>

            <a href="#" data-page="exploitation">
                 Mon exploitation
            </a>

            <a href="#" data-page="parcelles">
                 Mes parcelles
            </a>

            <a href="#" data-page="cultures">
                 Mes cultures
            </a>

            <a href="#" data-page="conditions">
                 Conditions environnementales
            </a>

            <a href="#" data-page="simulation">
                 Simulation
            </a>

            <a href="#" data-page="conseils">
                 Conseils agricoles
            </a>
        </nav>

        <div class="logout">
            <a href="#" onclick="alert('Déconnexion à connecter avec le membre 2')">
                 Déconnexion
            </a>
        </div>

    </aside>


    <!-- CONTENU PRINCIPAL -->
    <main class="main-content">

        <!-- HEADER -->
        <header class="header">

            <div>
                <h2 id="page-title">Tableau de bord</h2>
                <p>Bienvenue sur votre espace AgriTwin</p>
            </div>

            <div class="profile">
                <span> Agriculteur</span>
            </div>

        </header>


        <!-- CONTENU DES PAGES -->
        <section class="content" id="page-content">

            <h2>Vue générale</h2>

            <p class="description">
                Gérez votre exploitation agricole en toute simplicité.
            </p>

            <div class="cards">

                <div class="card">
                    <span> </span>
                    <h3>Exploitations</h3>
                    <h2>01</h2>
                    <p>Mes exploitations</p>
                </div>

                <div class="card">
                    <span> </span>
                    <h3>Parcelles</h3>
                    <h2>05</h2>
                    <p>Parcelles enregistrées</p>
                </div>

                <div class="card">
                    <span> </span>
                    <h3>Cultures</h3>
                    <h2>03</h2>
                    <p>Cultures suivies</p>
                </div>

                <div class="card">
                    <span> </span>
                    <h3>Simulations</h3>
                    <h2>02</h2>
                    <p>Scénarios réalisés</p>
                </div>

            </div>

            <div class="welcome-card">

                <h2>Bienvenue dans AgriTwin </h2>

                <p>
                    AgriTwin est une plateforme intelligente
                    qui facilite la gestion des exploitations agricoles.
                    Gérez vos parcelles, suivez vos cultures
                    et découvrez les simulations agricoles.
                </p>

                <button onclick="showPage('exploitation')">
                    Découvrir mon exploitation
                </button>

            </div>

        </section>

    </main>

</div>

<script src="js/script.js"></script>

</body>
</html>
