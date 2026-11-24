<?php
class Utilisateur extends Model
{
    const ROLES = ['admin' => 'Administrateur', 'agriculteur' => 'Agriculteur'];

    public function find(int $id): ?array
    {
        return $this->row('SELECT id_utilisateur, nom, prenom, email, telephone, role, date_inscription FROM utilisateur WHERE id_utilisateur = ?', [$id]);
    }

    /** Avec le mot de passe haché : uniquement pour la connexion. */
    public function findByEmail(string $email): ?array
    {
        return $this->row('SELECT * FROM utilisateur WHERE email = ?', [strtolower(trim($email))]);
    }

    public function emailTaken(string $email, int $exceptId = 0): bool
    {
        return (int) $this->value('SELECT COUNT(*) FROM utilisateur WHERE email = ? AND id_utilisateur <> ?', [strtolower(trim($email)), $exceptId]) > 0;
    }

    /** $d['mot_de_passe'] est en clair : il est haché ici (password_hash / bcrypt). */
    public function create(array $d): int
    {
        $this->run(
            'INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, telephone, role) VALUES (?, ?, ?, ?, ?, ?)',
            [trim($d['nom']), trim($d['prenom']), strtolower(trim($d['email'])), password_hash($d['mot_de_passe'], PASSWORD_DEFAULT), trim($d['telephone'] ?? ''), $d['role'] ?? 'agriculteur']
        );
        return $this->lastId();
    }

    public function update(int $id, array $d): void
    {
        $this->run(
            'UPDATE utilisateur SET nom = ?, prenom = ?, email = ?, telephone = ?, role = ? WHERE id_utilisateur = ?',
            [trim($d['nom']), trim($d['prenom']), strtolower(trim($d['email'])), trim($d['telephone'] ?? ''), $d['role'], $id]
        );
    }

    public function updateProfile(int $id, array $d): void
    {
        $this->run('UPDATE utilisateur SET nom = ?, prenom = ?, email = ?, telephone = ? WHERE id_utilisateur = ?',
            [trim($d['nom']), trim($d['prenom']), strtolower(trim($d['email'])), trim($d['telephone'] ?? ''), $id]);
    }

    public function updatePassword(int $id, string $plain): void
    {
        $this->run('UPDATE utilisateur SET mot_de_passe = ? WHERE id_utilisateur = ?', [password_hash($plain, PASSWORD_DEFAULT), $id]);
    }

    public function rehashIfNeeded(int $id, string $plain, string $hash): void
    {
        if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
            $this->updatePassword($id, $plain);
        }
    }

    public function delete(int $id): void { $this->run('DELETE FROM utilisateur WHERE id_utilisateur = ?', [$id]); }
    public function countAll(): int { return (int) $this->value('SELECT COUNT(*) FROM utilisateur'); }
    public function countByRole(string $role): int { return (int) $this->value('SELECT COUNT(*) FROM utilisateur WHERE role = ?', [$role]); }
    public function all(): array { return $this->rows('SELECT id_utilisateur, nom, prenom, email, telephone, role FROM utilisateur ORDER BY id_utilisateur DESC'); }
}
