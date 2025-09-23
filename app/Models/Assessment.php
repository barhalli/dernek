<?php
namespace App\Models;

use App\Core\Model;

class Assessment extends Model
{
    public function create(array $data): int
    {
        $stmt = $this->db()->prepare('INSERT INTO assessments (class_id, subject_id, title, type, max_score, date) VALUES (:class_id,:subject_id,:title,:type,:max_score,:date)');
        $stmt->execute($data);
        return (int)$this->db()->lastInsertId();
    }

    public function byClass(int $classId): array
    {
        $stmt = $this->db()->prepare('SELECT a.*, s.name AS subject_name FROM assessments a JOIN subjects s ON s.id = a.subject_id WHERE a.class_id = :class ORDER BY a.date DESC');
        $stmt->execute(['class' => $classId]);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db()->prepare('SELECT * FROM assessments WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }
}
