<?php
class Categorie extends Model
{
    public function all(): array { return $this->rows('SELECT * FROM categorie ORDER BY nom_categorie'); }

    /** Catégories avec le nombre de conseils publiés (pour les filtres du site). */
    public function withPublishedCount(): array
    {
        return $this->rows("SELECT k.id_categorie, k.nom_categorie, k.description,
            (SELECT COUNT(*) FROM conseil c WHERE c.id_categorie = k.id_categorie AND c.statut = 'Publié') AS nb
            FROM categorie k ORDER BY k.nom_categorie");
    }
}
