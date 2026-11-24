<?php
/** Classe de base des modèles : accès à la connexion PDO unique + petites aides de requête. */
abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::pdo();
    }

    protected function rows(string $sql, array $params = []): array
    {
        $st = $this->db->prepare($sql);
        $st->execute($params);
        return $st->fetchAll();
    }

    protected function row(string $sql, array $params = []): ?array
    {
        $st = $this->db->prepare($sql);
        $st->execute($params);
        $r = $st->fetch();
        return $r ?: null;
    }

    protected function value(string $sql, array $params = [])
    {
        $st = $this->db->prepare($sql);
        $st->execute($params);
        return $st->fetchColumn();
    }

    protected function run(string $sql, array $params = []): int
    {
        $st = $this->db->prepare($sql);
        $st->execute($params);
        return $st->rowCount();
    }

    public function lastId(): int
    {
        return (int) $this->db->lastInsertId();
    }
}
