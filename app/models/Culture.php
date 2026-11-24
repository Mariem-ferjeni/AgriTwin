<?php
class Culture extends Model
{
    public function search(array $f, int $page, int $per): array
    {
        $where = []; $p = [];
        if (($f['q'] ?? '') !== '') {
            $where[] = '(nom LIKE ? OR variete LIKE ? OR description LIKE ?)';
            $like = '%' . $f['q'] . '%'; array_push($p, $like, $like, $like);
        }
        if (($f['type'] ?? '') !== '')   { $where[] = 'type_culture = ?'; $p[] = $f['type']; }
        if (($f['saison'] ?? '') !== '') { $where[] = 'saison = ?';       $p[] = $f['saison']; }
        $w = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $total = (int) $this->value("SELECT COUNT(*) FROM culture $w", $p);
        $pg = paginate($total, $per, $page);
        $rows = $this->rows("SELECT * FROM culture $w ORDER BY nom LIMIT " . (int) $pg['per'] . ' OFFSET ' . (int) $pg['offset'], $p);
        return ['rows' => $rows, 'pager' => $pg];
    }

    public function all(): array { return $this->rows('SELECT * FROM culture ORDER BY nom'); }
    public function find(int $id): ?array { return $this->row('SELECT * FROM culture WHERE id_culture = ?', [$id]); }
    public function types(): array { return array_column($this->rows('SELECT DISTINCT type_culture FROM culture ORDER BY type_culture'), 'type_culture'); }
    public function seasons(): array { return array_column($this->rows("SELECT DISTINCT saison FROM culture WHERE saison IS NOT NULL AND saison <> '' ORDER BY saison"), 'saison'); }
    public function latest(int $n): array { return $this->rows('SELECT * FROM culture ORDER BY id_culture DESC LIMIT ' . (int) $n); }
    public function countAll(): int { return (int) $this->value('SELECT COUNT(*) FROM culture'); }

    public function create(array $d): int
    {
        $this->run('INSERT INTO culture (nom, type_culture, variete, saison, duree_cycle, description) VALUES (?, ?, ?, ?, ?, ?)',
            [$d['nom'], $d['type_culture'], $d['variete'] ?: null, $d['saison'] ?: null, $d['duree_cycle'], $d['description'] ?: null]);
        return $this->lastId();
    }

    /** Nombre de parcelles qui cultivent cette culture. */
    public function usageCount(int $id): int { return (int) $this->value('SELECT COUNT(*) FROM parcelle WHERE id_culture = ?', [$id]); }
}
