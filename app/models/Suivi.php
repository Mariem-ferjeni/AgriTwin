<?php
class Suivi extends Model
{
    public function forParcelle(int $pid): array
    {
        return $this->rows('SELECT * FROM suivi_parcelle WHERE id_parcelle = ? ORDER BY date_suivi DESC, id_suivi DESC', [$pid]);
    }

    public function create(int $pid, array $d): int
    {
        $this->run('INSERT INTO suivi_parcelle (id_parcelle, date_suivi, humidite_sol, temperature, ph_sol, observation) VALUES (?, ?, ?, ?, ?, ?)',
            [$pid, $d['date_suivi'], $d['humidite_sol'], $d['temperature'], $d['ph_sol'], $d['observation']]);
        return $this->lastId();
    }

    /** Une mesure, seulement si sa parcelle appartient à $uid. */
    public function findOwned(int $sid, int $uid): ?array
    {
        return $this->row('SELECT s.* FROM suivi_parcelle s
            JOIN parcelle p ON p.id_parcelle = s.id_parcelle
            JOIN exploitation e ON e.id_exploitation = p.id_exploitation
            WHERE s.id_suivi = ? AND e.id_utilisateur = ?', [$sid, $uid]);
    }

    public function delete(int $sid): void { $this->run('DELETE FROM suivi_parcelle WHERE id_suivi = ?', [$sid]); }

    public function latestForUser(int $uid, int $n = 5): array
    {
        return $this->rows('SELECT s.*, p.nom AS parcelle, p.id_parcelle FROM suivi_parcelle s
            JOIN parcelle p ON p.id_parcelle = s.id_parcelle
            JOIN exploitation e ON e.id_exploitation = p.id_exploitation
            WHERE e.id_utilisateur = ? ORDER BY s.date_suivi DESC, s.id_suivi DESC LIMIT ' . (int) $n, [$uid]);
    }

    public function countForUser(int $uid): int
    {
        return (int) $this->value('SELECT COUNT(*) FROM suivi_parcelle s
            JOIN parcelle p ON p.id_parcelle = s.id_parcelle
            JOIN exploitation e ON e.id_exploitation = p.id_exploitation WHERE e.id_utilisateur = ?', [$uid]);
    }
}
