// Recherche dans le tableau des utilisateurs

const searchInput = document.getElementById("searchInput");

if (searchInput) {
  searchInput.addEventListener("input", function () {
    const recherche = this.value.toLowerCase();

    const lignes = document.querySelectorAll("#usersTable tbody tr");

    lignes.forEach(function (ligne) {
      const contenu = ligne.textContent.toLowerCase();

      ligne.style.display = contenu.includes(recherche) ? "" : "none";
    });
  });
}
