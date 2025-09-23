<?php
namespace App\Models;

use App\Core\Model;

class Message extends Model
{
    public function inbox(int $userId): array
    {
        $stmt = $this->db()->prepare('SELECT m.*, u.name AS from_name FROM messages m JOIN users u ON u.id = m.from_user_id WHERE m.to_user_id = :user ORDER BY m.created_at DESC');
        $stmt->execute(['user' => $userId]);
        return $stmt->fetchAll();
    }

    public function sent(int $userId): array
    {
        $stmt = $this->db()->prepare('SELECT m.*, u.name AS to_name FROM messages m JOIN users u ON u.id = m.to_user_id WHERE m.from_user_id = :user ORDER BY m.created_at DESC');
        $stmt->execute(['user' => $userId]);
        return $stmt->fetchAll();
    }

    public function thread(int $messageId, int $userId): array
    {
        $stmt = $this->db()->prepare('SELECT m.*, sender.name AS from_name, receiver.name AS to_name FROM messages m JOIN users sender ON sender.id = m.from_user_id JOIN users receiver ON receiver.id = m.to_user_id WHERE (m.id = :id OR m.parent_id = :id) AND (m.from_user_id = :user OR m.to_user_id = :user) ORDER BY m.created_at ASC');
        $stmt->execute(['id' => $messageId, 'user' => $userId]);
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->db()->prepare('INSERT INTO messages (from_user_id, to_user_id, class_id, subject, body, created_at, read_at, parent_id) VALUES (:from_user_id,:to_user_id,:class_id,:subject,:body,NOW(),NULL,:parent_id)');
        $stmt->execute($data);
        return (int)$this->db()->lastInsertId();
    }

    public function markAsRead(int $messageId, int $userId): void
    {
        $stmt = $this->db()->prepare('UPDATE messages SET read_at = NOW() WHERE id = :id AND to_user_id = :user AND read_at IS NULL');
        $stmt->execute(['id' => $messageId, 'user' => $userId]);
    }
}
