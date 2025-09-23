<?php
namespace App\Models;

use App\Core\Model;

class Enrollment extends Model
{
    public function enroll(int $classId, int $studentId, string $year): bool
    {
        $stmt = $this->db()->prepare('INSERT INTO enrollments (class_id, student_id, year, active) VALUES (:class_id,:student_id,:year,1) ON DUPLICATE KEY UPDATE active = VALUES(active)');
        return $stmt->execute([
            'class_id' => $classId,
            'student_id' => $studentId,
            'year' => $year,
        ]);
    }

    public function studentsOfClass(int $classId): array
    {
        $stmt = $this->db()->prepare('SELECT s.* FROM enrollments e JOIN students s ON s.id = e.student_id WHERE e.class_id = :class AND e.active = 1 ORDER BY s.last_name');
        $stmt->execute(['class' => $classId]);
        return $stmt->fetchAll();
    }
}
