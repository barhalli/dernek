<?php
namespace App\Models;

use App\Core\Model;

class ParentModel extends Model
{
    public function create(array $data): int
    {
        $stmt = $this->db()->prepare('INSERT INTO parents (user_id, phone, created_at) VALUES (:user_id,:phone,NOW())');
        $stmt->execute($data);
        return (int)$this->db()->lastInsertId();
    }
}
