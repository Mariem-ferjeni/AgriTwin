<?php
class Message extends Model
{
    public function create(array $d): void
    {
        $this->run('INSERT INTO message_contact (nom, email, sujet, message) VALUES (?, ?, ?, ?)', [$d['nom'], $d['email'], $d['sujet'], $d['message']]);
    }
    public function all(): array { return $this->rows('SELECT * FROM message_contact ORDER BY date_envoi DESC, id_message DESC'); }
    public function countUnread(): int { return (int) $this->value('SELECT COUNT(*) FROM message_contact WHERE lu = 0'); }
    public function markRead(int $id): void { $this->run('UPDATE message_contact SET lu = 1 WHERE id_message = ?', [$id]); }
    public function delete(int $id): void { $this->run('DELETE FROM message_contact WHERE id_message = ?', [$id]); }
}
