<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ClassModel;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Assessment;
use App\Models\Enrollment;

class ReportController extends Controller
{
    protected Attendance $attendance;
    protected Grade $grades;
    protected Assessment $assessments;
    protected \PDO $db;

    public function __construct()
    {
        $this->attendance = new Attendance();
        $this->grades = new Grade();
        $this->assessments = new Assessment();
        $this->db = require __DIR__ . '/../Config/database.php';
    }

    public function index()
    {
        return $this->view('reports/index');
    }

    public function attendance()
    {
        $classId = (int)($_GET['class'] ?? 0);
        $start = $_GET['start'] ?? date('Y-m-01');
        $end = $_GET['end'] ?? date('Y-m-t');
        $classes = (new ClassModel())->paginate(1, 100)['items'];
        $records = $classId ? $this->attendance->listByClassAndRange($classId, $start, $end) : [];
        $summary = [];
        foreach ($records as $record) {
            $key = $record['student_id'];
            if (!isset($summary[$key])) {
                $summary[$key] = [
                    'name' => $record['first_name'] . ' ' . $record['last_name'],
                    'Present' => 0,
                    'Late' => 0,
                    'Absent' => 0,
                    'Excused' => 0,
                ];
            }
            $summary[$key][$record['status']]++;
        }
        return $this->view('reports/attendance', compact('classes', 'classId', 'start', 'end', 'summary'));
    }

    public function grades()
    {
        $classId = (int)($_GET['class'] ?? 0);
        $assessmentId = (int)($_GET['assessment'] ?? 0);
        $classes = (new ClassModel())->paginate(1, 100)['items'];
        $assessments = $classId ? $this->assessments->byClass($classId) : [];
        $stats = $assessmentId ? $this->grades->statistics($assessmentId) : [];
        $records = $assessmentId ? $this->grades->listForAssessment($assessmentId) : [];
        return $this->view('reports/grades', compact('classes', 'classId', 'assessments', 'assessmentId', 'stats', 'records'));
    }

    public function risk()
    {
        $classId = (int)($_GET['class'] ?? 0);
        $threshold = (float)($_GET['threshold'] ?? 50);
        $absenceLimit = (int)($_GET['absence'] ?? 5);
        $classes = (new ClassModel())->paginate(1, 100)['items'];
        $students = $classId ? (new Enrollment())->studentsOfClass($classId) : [];
        $risks = [];
        foreach ($students as $student) {
            $stmt = $this->db->prepare('SELECT AVG(g.score) as avg_score FROM grades g JOIN assessments a ON a.id = g.assessment_id WHERE g.student_id = :student AND a.class_id = :class');
            $stmt->execute(['student' => $student['id'], 'class' => $classId]);
            $avg = (float)$stmt->fetchColumn();

            $attendanceSummary = $this->attendance->summaryForStudent($student['id'], date('Y-01-01'), date('Y-12-31'));
            $absent = 0;
            foreach ($attendanceSummary as $item) {
                if ($item['status'] === 'Absent') {
                    $absent = (int)$item['total'];
                }
            }

            if (($avg > 0 && $avg < $threshold) || $absent >= $absenceLimit) {
                $risks[] = [
                    'name' => $student['first_name'] . ' ' . $student['last_name'],
                    'average' => round($avg, 2),
                    'absent' => $absent,
                ];
            }
        }

        return $this->view('reports/risk', compact('classes', 'classId', 'risks', 'threshold', 'absenceLimit'));
    }
}
