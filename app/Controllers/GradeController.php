<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Flash;
use App\Helpers\Validator;
use App\Models\ClassModel;
use App\Models\Assessment;
use App\Models\Grade;
use App\Models\Enrollment;
use App\Services\ExportService;

class GradeController extends Controller
{
    protected Assessment $assessments;
    protected Grade $grades;

    public function __construct()
    {
        $this->assessments = new Assessment();
        $this->grades = new Grade();
    }

    public function index()
    {
        $classId = (int)($_GET['class'] ?? 0);
        $classes = (new ClassModel())->paginate(1, 100)['items'];
        $assessments = $classId ? $this->assessments->byClass($classId) : [];
        return $this->view('grades/index', compact('classes', 'assessments', 'classId'));
    }

    public function enterForm()
    {
        $classId = (int)($_GET['class'] ?? 0);
        $assessmentId = (int)($_GET['assessment'] ?? 0);
        $classes = (new ClassModel())->paginate(1, 100)['items'];
        $assessments = $classId ? $this->assessments->byClass($classId) : [];
        $students = $classId ? (new Enrollment())->studentsOfClass($classId) : [];
        $records = $assessmentId ? $this->grades->listForAssessment($assessmentId) : [];
        $existing = [];
        foreach ($records as $record) {
            $existing[$record['student_id']] = $record;
        }
        $selectedAssessment = $assessmentId ? $this->assessments->find($assessmentId) : null;
        return $this->view('grades/enter', compact('classes', 'assessments', 'students', 'existing', 'classId', 'selectedAssessment'));
    }

    public function store()
    {
        $assessmentId = (int)($_POST['assessment_id'] ?? 0);
        $assessment = $this->assessments->find($assessmentId);
        if (!$assessment) {
            Flash::add('error', 'Değerlendirme bulunamadı.');
            $this->back();
        }

        foreach ($_POST['score'] ?? [] as $studentId => $score) {
            if ($score === '') {
                continue;
            }
            if (!is_numeric($score) || $score < 0 || $score > $assessment['max_score']) {
                Flash::add('error', 'Geçersiz not değeri.');
                $this->back();
            }
            $this->grades->upsert($assessmentId, (int)$studentId, (float)$score, $_POST['note'][$studentId] ?? null);
        }

        Flash::add('success', 'Notlar kaydedildi.');
        $this->redirect('/grades/enter?class=' . $assessment['class_id'] . '&assessment=' . $assessmentId);
    }

    public function export()
    {
        $assessmentId = (int)($_GET['assessment'] ?? 0);
        $format = $_GET['format'] ?? 'csv';
        $assessment = $this->assessments->find($assessmentId);
        if (!$assessment) {
            Flash::add('error', 'Değerlendirme bulunamadı.');
            $this->redirect('/grades');
        }
        $records = $this->grades->listForAssessment($assessmentId);
        $headers = ['Öğrenci', 'Not', 'Notu'];
        $rows = array_map(function ($row) {
            return [
                $row['first_name'] . ' ' . $row['last_name'],
                $row['score'],
                $row['note'],
            ];
        }, $records);
        (new ExportService())->export($headers, $rows, 'notlar_' . $assessmentId, $format);
    }
}
