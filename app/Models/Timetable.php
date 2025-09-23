<?php
namespace App\Models;

use App\Core\Model;

class Timetable extends Model
{
    public function forClass(int $classId): array
    {
        $stmt = $this->db()->prepare('SELECT t.*, s.name AS subject_name FROM timetable t JOIN subjects s ON s.id = t.subject_id WHERE t.class_id = :class ORDER BY t.weekday, t.start_time');
        $stmt->execute(['class' => $classId]);
        return $stmt->fetchAll();
    }
}
