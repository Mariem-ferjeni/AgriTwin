
// Récupération des éléments
const pageContent = document.getElementById("page-content");
const pageTitle = document.getElementById("page-title");

// Fonction pour changer de page
function showPage(page) {

    const pages = {

        dashboard: `
    <h2>Vue générale</h2>

    <p class="description">
        Bienvenue dans votre espace AgriTwin.
    </p>

    <div class="cards">

        <div class="card" onclick="showPage('exploitation')">
            <span>🌾</span>
            <h3>Exploitations</h3>
            <h2>01</h2>
            <p>Mes exploitations</p>
        </div>

        <div class="card" onclick="showPage('parcelles')">
            <span>🗺️</span>
            <h3>Parcelles</h3>
            <h2>05</h2>
            <p>Parcelles enregistrées</p>
        </div>

        <div class="card" onclick="showPage('cultures')">
            <span>🌱</span>
            <h3>Cultures</h3>
            <h2>03</h2>
            <p>Cultures suivies</p>
        </div>

        <div class="card" onclick="showPage('simulation')">
            <span>📊</span>
            <h3>Simulations</h3>
            <h2>02</h2>
            <p>Scénarios réalisés</p>
        </div>

    </div>

    <div class="welcome-card">
        <h2>Bienvenue dans AgriTwin 🌱</h2>
        <p>
            Gérez votre exploitation agricole,
            vos parcelles et vos cultures grâce à AgriTwin.
        </p>
    </div>
`,

    };

    // Afficher le contenu
    pageContent.innerHTML = pages[page] || pages.dashboard;

    // Modifier le titre
    pageTitle.textContent = document.querySelector(
        `.sidebar nav a[data-page="${page}"]`
    )?.textContent.trim().replace(/^[^\p{L}\p{N}]+/u, "")
    || "Tableau de bord";

    // Modifier le menu actif
    document.querySelectorAll(".sidebar nav a").forEach(link => {

        link.classList.remove("active");

        if (link.dataset.page === page) {
            link.classList.add("active");
        }

    });

}

// Navigation du menu
document.querySelectorAll(".sidebar nav a").forEach(link => {

    link.addEventListener("click", function(event) {

        event.preventDefault();

        showPage(this.dataset.page);

    });

});
