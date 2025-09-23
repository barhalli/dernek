<?php
namespace App\Models;

use App\Core\Model;

class Announcement extends Model
{
    public function create(array $data): int
    {
        $stmt = $this->db()->prepare('INSERT INTO announcements (class_id, title, body, visible_from, visible_to, attachment_path) VALUES (:class_id,:title,:body,:visible_from,:visible_to,:attachment_path)');
        $stmt->execute($data);
        return (int)$this->db()->lastInsertId();
    }

    public function visibleForUser(int $userId, string $role): array
    {
        $sql = 'SELECT a.*, c.name AS class_name FROM announcements a LEFT JOIN classes c ON c.id = a.class_id';
        $params = [];
        if ($role === 'teacher') {
            $sql .= ' LEFT JOIN class_subjects cs ON cs.class_id = c.id WHERE (c.teacher_id = :userId OR cs.teacher_id = :userId)';
            $params['userId'] = $userId;
        } elseif ($role === 'parent' || $role === 'student') {
            $sql .= ' JOIN enrollments e ON e.class_id = c.id';
            $sql .= ' WHERE (e.student_id = :userId OR e.student_id IN (SELECT s.id FROM students s WHERE s.parent_id IN (SELECT id FROM parents WHERE user_id = :userId)))';
            $params['userId'] = $userId;
        } else {
            $sql .= ' WHERE 1=1';
        }
        $sql .= ' AND (a.visible_from IS NULL OR a.visible_from <= NOW()) AND (a.visible_to IS NULL OR a.visible_to >= NOW()) ORDER BY a.visible_from DESC';
        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
