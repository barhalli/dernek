<?php
namespace App\Models;

use App\Core\Model;

class FileModel extends Model
{
    public function create(array $data): int
    {
        $stmt = $this->db()->prepare('INSERT INTO files (owner_user_id, class_id, path, filename, size, mime, visibility, created_at) VALUES (:owner_user_id,:class_id,:path,:filename,:size,:mime,:visibility,NOW())');
        $stmt->execute($data);
        return (int)$this->db()->lastInsertId();
    }

    public function listForUser(int $userId, string $role): array
    {
        $sql = 'SELECT f.*, c.name AS class_name FROM files f LEFT JOIN classes c ON c.id = f.class_id WHERE f.owner_user_id = :user';
        $params = ['user' => $userId];
        if ($role === 'admin') {
            $sql = 'SELECT f.*, c.name AS class_name, u.name AS owner_name FROM files f LEFT JOIN classes c ON c.id = f.class_id LEFT JOIN users u ON u.id = f.owner_user_id ORDER BY f.created_at DESC';
            $params = [];
        }
        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
