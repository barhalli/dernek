<?php
namespace App\Models;

use App\Core\Model;

class ClassModel extends Model
{
    public function paginate(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->db()->prepare('SELECT SQL_CALC_FOUND_ROWS c.*, u.name AS teacher_name FROM classes c LEFT JOIN users u ON u.id = c.teacher_id ORDER BY c.year DESC, c.name LIMIT :offset, :limit');
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll();
        $total = $this->db()->query('SELECT FOUND_ROWS()')->fetchColumn();
        return ['items' => $items, 'total' => (int)$total];
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db()->prepare('SELECT * FROM classes WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db()->prepare('INSERT INTO classes (name, grade_level, year, teacher_id, created_at, updated_at) VALUES (:name,:grade_level,:year,:teacher_id,NOW(),NOW())');
        $stmt->execute($data);
        return (int)$this->db()->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        $sql = 'UPDATE classes SET ' . implode(',', $fields) . ', updated_at = NOW() WHERE id = :id';
        $data['id'] = $id;
        $stmt = $this->db()->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db()->prepare('DELETE FROM classes WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function allForTeacher(int $teacherId): array
    {
        $stmt = $this->db()->prepare('SELECT * FROM classes WHERE teacher_id = :teacher ORDER BY year DESC');
        $stmt->execute(['teacher' => $teacherId]);
        return $stmt->fetchAll();
    }
}
