<?php
namespace App\Models;

use App\Core\Model;

class Student extends Model
{
    public function paginate(int $page = 1, int $perPage = 20, ?int $classId = null): array
    {
        $offset = ($page - 1) * $perPage;
        $sql = 'SELECT SQL_CALC_FOUND_ROWS s.*, c.name AS class_name FROM students s LEFT JOIN enrollments e ON e.student_id = s.id AND e.active = 1 LEFT JOIN classes c ON c.id = e.class_id';
        $params = [];
        if ($classId) {
            $sql .= ' WHERE c.id = :classId';
            $params['classId'] = $classId;
        }
        $sql .= ' ORDER BY s.last_name, s.first_name LIMIT :offset, :limit';
        $stmt = $this->db()->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll();
        $total = $this->db()->query('SELECT FOUND_ROWS()')->fetchColumn();
        return ['items' => $items, 'total' => (int)$total];
    }

    public function create(array $data): int
    {
        $stmt = $this->db()->prepare('INSERT INTO students (number, first_name, last_name, birthdate, gender, parent_id, status, created_at) VALUES (:number,:first_name,:last_name,:birthdate,:gender,:parent_id,:status,NOW())');
        $stmt->execute($data);
        return (int)$this->db()->lastInsertId();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db()->prepare('SELECT * FROM students WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }
}
