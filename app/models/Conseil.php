<?php
class Conseil extends Model
{
    public function published(array $f, int $page, int $per): array
    {
        $where = ["c.statut = 'Publié'"]; $p = [];
        if (($f['q'] ?? '') !== '') {
            $where[] = '(c.titre LIKE ? OR c.contenu LIKE ?)';
            $like = '%' . $f['q'] . '%'; array_push($p, $like, $like);
        }
        if (!empty($f['cat'])) { $where[] = 'c.id_categorie = ?'; $p[] = (int) $f['cat']; }
        $w = 'WHERE ' . implode(' AND ', $where);
        $total = (int) $this->value("SELECT COUNT(*) FROM conseil c $w", $p);
        $pg = paginate($total, $per, $page);
        $rows = $this->rows("SELECT c.*, k.nom_categorie FROM conseil c LEFT JOIN categorie k ON k.id_categorie = c.id_categorie
            $w ORDER BY c.date_publication DESC, c.id_conseil DESC LIMIT " . (int) $pg['per'] . ' OFFSET ' . (int) $pg['offset'], $p);
        return ['rows' => $rows, 'pager' => $pg];
    }

    public function findPublished(int $id): ?array
    {
        return $this->row("SELECT c.*, k.nom_categorie FROM conseil c LEFT JOIN categorie k ON k.id_categorie = c.id_categorie
            WHERE c.id_conseil = ? AND c.statut = 'Publié'", [$id]);
    }

    public function latestPublished(int $n): array
    {
        return $this->rows("SELECT c.*, k.nom_categorie FROM conseil c LEFT JOIN categorie k ON k.id_categorie = c.id_categorie
            WHERE c.statut = 'Publié' ORDER BY c.date_publication DESC, c.id_conseil DESC LIMIT " . (int) $n);
    }

    public function related(int $idCategorie, int $exceptId, int $n = 3): array
    {
        return $this->rows("SELECT c.*, k.nom_categorie FROM conseil c LEFT JOIN categorie k ON k.id_categorie = c.id_categorie
            WHERE c.statut = 'Publié' AND c.id_categorie = ? AND c.id_conseil <> ? ORDER BY c.date_publication DESC LIMIT " . (int) $n, [$idCategorie, $exceptId]);
    }

    public function countPublished(): int { return (int) $this->value("SELECT COUNT(*) FROM conseil WHERE statut = 'Publié'"); }

    public function create(array $d): int
    {
        $this->run('INSERT INTO conseil (titre, contenu, id_categorie, date_publication, statut) VALUES (?, ?, ?, ?, ?)',
            [$d['titre'], $d['contenu'], $d['id_categorie'], $d['date_publication'], $d['statut']]);
        return $this->lastId();
    }
}
