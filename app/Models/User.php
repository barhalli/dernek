<?php
namespace App\Models;

use App\Core\Model;

class User extends Model
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db()->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() ?: null;
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db()->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function all(): array
    {
        $stmt = $this->db()->query('SELECT * FROM users ORDER BY name');
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->db()->prepare('INSERT INTO users (name, email, password_hash, role, status, created_at, updated_at) VALUES (:name,:email,:password_hash,:role,:status,NOW(),NOW())');
        $stmt->execute($data);
        return (int)$this->db()->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        $sql = 'UPDATE users SET ' . implode(',', $fields) . ', updated_at = NOW() WHERE id = :id';
        $data['id'] = $id;
        $stmt = $this->db()->prepare($sql);
        return $stmt->execute($data);
    }
}
