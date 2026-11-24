<?php
class Parcelle extends Model
{
    const ETATS = [
        'en_preparation' => 'En préparation',
        'plantee'        => 'Plantée',
        'en_croissance'  => 'En croissance',
        'recoltee'       => 'Récoltée',
    ];
    const SOLS = ['Argileux', 'Sableux', 'Limoneux', 'Calcaire', 'Humifère', 'Mixte'];

    public function forExploitation(int $eid): array
    {
        return $this->rows("SELECT p.*, c.nom AS culture,
            (SELECT COUNT(*) FROM suivi_parcelle s WHERE s.id_parcelle = p.id_parcelle) AS nb_suivis
            FROM parcelle p LEFT JOIN culture c ON c.id_culture = p.id_culture
            WHERE p.id_exploitation = ? ORDER BY p.nom", [$eid]);
    }

    public function forUser(int $uid): array
    {
        return $this->rows("SELECT p.*, c.nom AS culture, e.nom AS exploitation
            FROM parcelle p JOIN exploitation e ON e.id_exploitation = p.id_exploitation
            LEFT JOIN culture c ON c.id_culture = p.id_culture
            WHERE e.id_utilisateur = ? ORDER BY e.nom, p.nom", [$uid]);
    }

    /** Parcelle + exploitation parente, seulement si elle appartient à $uid. */
    public function findOwned(int $pid, int $uid): ?array
    {
        return $this->row("SELECT p.*, c.nom AS culture, e.nom AS exploitation, e.superficie_totale
            FROM parcelle p JOIN exploitation e ON e.id_exploitation = p.id_exploitation
            LEFT JOIN culture c ON c.id_culture = p.id_culture
            WHERE p.id_parcelle = ? AND e.id_utilisateur = ?", [$pid, $uid]);
    }

    /** Surface déjà affectée aux parcelles d'une exploitation (hors une parcelle éventuelle). */
    public function areaUsed(int $eid, int $exceptId = 0): float
    {
        return (float) $this->value('SELECT COALESCE(SUM(superficie), 0) FROM parcelle WHERE id_exploitation = ? AND id_parcelle <> ?', [$eid, $exceptId]);
    }

    public function create(array $d): int
    {
        $this->run('INSERT INTO parcelle (id_exploitation, nom, superficie, type_sol, id_culture, date_plantation, etat) VALUES (?, ?, ?, ?, ?, ?, ?)',
            [$d['id_exploitation'], $d['nom'], $d['superficie'], $d['type_sol'], $d['id_culture'], $d['date_plantation'], $d['etat']]);
        return $this->lastId();
    }

    public function update(int $id, array $d): void
    {
        $this->run('UPDATE parcelle SET nom = ?, superficie = ?, type_sol = ?, id_culture = ?, date_plantation = ?, etat = ? WHERE id_parcelle = ?',
            [$d['nom'], $d['superficie'], $d['type_sol'], $d['id_culture'], $d['date_plantation'], $d['etat'], $id]);
    }

    public function delete(int $id): void { $this->run('DELETE FROM parcelle WHERE id_parcelle = ?', [$id]); }

    public function countForUser(int $uid): int
    {
        return (int) $this->value('SELECT COUNT(*) FROM parcelle p JOIN exploitation e ON e.id_exploitation = p.id_exploitation WHERE e.id_utilisateur = ?', [$uid]);
    }

    public function countAll(): int { return (int) $this->value('SELECT COUNT(*) FROM parcelle'); }
}
