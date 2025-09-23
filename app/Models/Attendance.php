<?php
namespace App\Models;

use App\Core\Model;

class Attendance extends Model
{
    public function mark(array $rows): bool
    {
        $sql = 'INSERT INTO attendances (class_id, student_id, date, status, note) VALUES (:class_id,:student_id,:date,:status,:note)
            ON DUPLICATE KEY UPDATE status = VALUES(status), note = VALUES(note)';
        $stmt = $this->db()->prepare($sql);
        foreach ($rows as $row) {
            $stmt->execute($row);
        }
        return true;
    }

    public function listByClassAndRange(int $classId, string $startDate, string $endDate): array
    {
        $stmt = $this->db()->prepare('SELECT a.*, s.first_name, s.last_name FROM attendances a JOIN students s ON s.id = a.student_id WHERE a.class_id = :class AND a.date BETWEEN :start AND :end ORDER BY a.date DESC');
        $stmt->execute([
            'class' => $classId,
            'start' => $startDate,
            'end' => $endDate,
        ]);
        return $stmt->fetchAll();
    }

    public function summaryForStudent(int $studentId, string $startDate, string $endDate): array
    {
        $stmt = $this->db()->prepare('SELECT status, COUNT(*) as total FROM attendances WHERE student_id = :student AND date BETWEEN :start AND :end GROUP BY status');
        $stmt->execute([
            'student' => $studentId,
            'start' => $startDate,
            'end' => $endDate,
        ]);
        return $stmt->fetchAll();
    }
}
