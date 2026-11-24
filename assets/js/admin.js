// Recherche instantanée dans les tableaux de la page (barre de recherche du haut)

const searchInput = document.getElementById("searchInput");

if (searchInput) {
  searchInput.addEventListener("input", function () {
    const recherche = this.value.toLowerCase();

    // Fonctionne sur toutes les pages : tous les tableaux du contenu principal
    const lignes = document.querySelectorAll(".main-content table tbody tr");

    lignes.forEach(function (ligne) {
      const contenu = ligne.textContent.toLowerCase();

      ligne.style.display = contenu.includes(recherche) ? "" : "none";
    });
  });
}
