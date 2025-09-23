<?php
namespace App\Models;

use App\Core\Model;

class Grade extends Model
{
    public function upsert(int $assessmentId, int $studentId, float $score, ?string $note = null): bool
    {
        $stmt = $this->db()->prepare('INSERT INTO grades (assessment_id, student_id, score, note) VALUES (:assessment_id,:student_id,:score,:note)
            ON DUPLICATE KEY UPDATE score = VALUES(score), note = VALUES(note)');
        return $stmt->execute([
            'assessment_id' => $assessmentId,
            'student_id' => $studentId,
            'score' => $score,
            'note' => $note,
        ]);
    }

    public function listForAssessment(int $assessmentId): array
    {
        $stmt = $this->db()->prepare('SELECT g.*, s.first_name, s.last_name FROM grades g JOIN students s ON s.id = g.student_id WHERE g.assessment_id = :assessment');
        $stmt->execute(['assessment' => $assessmentId]);
        return $stmt->fetchAll();
    }

    public function statistics(int $assessmentId): array
    {
        $stmt = $this->db()->prepare('SELECT AVG(score) as average, MIN(score) as min_score, MAX(score) as max_score FROM grades WHERE assessment_id = :assessment');
        $stmt->execute(['assessment' => $assessmentId]);
        $stats = $stmt->fetch();
        $scores = array_column($this->listForAssessment($assessmentId), 'score');
        sort($scores);
        $count = count($scores);
        $median = $count ? ($count % 2 ? $scores[floor($count / 2)] : ($scores[$count / 2 - 1] + $scores[$count / 2]) / 2) : 0;
        $stats['median'] = $median;
        $stats['count'] = $count;
        return $stats;
    }
}
