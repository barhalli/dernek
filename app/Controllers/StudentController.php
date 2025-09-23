<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Flash;
use App\Helpers\Validator;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Enrollment;
use App\Services\ImportService;

class StudentController extends Controller
{
    protected Student $students;
    protected \PDO $db;

    public function __construct()
    {
        $this->students = new Student();
        $this->db = require __DIR__ . '/../Config/database.php';
    }

    public function index()
    {
        $classId = isset($_GET['class']) ? (int)$_GET['class'] : null;
        $page = max(1, (int)($_GET['page'] ?? 1));
        $result = $this->students->paginate($page, 20, $classId);
        $classes = (new ClassModel())->paginate(1, 100)['items'];
        return $this->view('students/index', [
            'students' => $result['items'],
            'total' => $result['total'],
            'page' => $page,
            'perPage' => 20,
            'classes' => $classes,
            'selectedClass' => $classId,
        ]);
    }

    public function show($id)
    {
        $student = $this->students->find((int)$id);
        if (!$student) {
            Flash::add('error', 'Öğrenci bulunamadı.');
            $this->redirect('/students');
        }
        $stmt = $this->db->prepare('SELECT c.name, e.year FROM enrollments e JOIN classes c ON c.id = e.class_id WHERE e.student_id = :student ORDER BY e.year DESC');
        $stmt->execute(['student' => $student['id']]);
        $enrollments = $stmt->fetchAll();
        return $this->view('students/show', compact('student', 'enrollments'));
    }

    public function importForm()
    {
        $classes = (new ClassModel())->paginate(1, 100)['items'];
        return $this->view('students/import', compact('classes'));
    }

    public function import()
    {
        $validator = Validator::make($_POST)
            ->required('class_id', 'Sınıf seçiniz.');
        if (!$validator->passes()) {
            Flash::add('error', 'Lütfen bir sınıf seçiniz.');
            $this->back();
        }
        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            Flash::add('error', 'Dosya yüklenemedi.');
            $this->back();
        }

        $tmp = tempnam(sys_get_temp_dir(), 'import');
        move_uploaded_file($_FILES['file']['tmp_name'], $tmp);

        $rows = (new ImportService())->parse($tmp);
        unlink($tmp);
        if (!$rows) {
            Flash::add('error', 'Dosya içeriği okunamadı.');
            $this->back();
        }
        $classId = (int)$_POST['class_id'];
        $year = date('Y');
        $enrollment = new Enrollment();
        $created = 0;
        foreach ($rows as $index => $row) {
            if ($index === 0 && isset($row[0]) && preg_match('/ad/i', $row[0])) {
                continue; // başlık
            }
            if (count($row) < 4) {
                continue;
            }
            $data = [
                'number' => $row[2] ?? null,
                'first_name' => $row[0] ?? '',
                'last_name' => $row[1] ?? '',
                'birthdate' => $row[3] ?? null,
                'gender' => $row[4] ?? 'X',
                'parent_id' => null,
                'status' => 'active',
            ];
            $studentId = $this->students->create($data);
            $enrollment->enroll($classId, $studentId, $year);
            $created++;
        }

        Flash::add('success', $created . ' öğrenci eklendi.');
        $this->redirect('/students?class=' . $classId);
    }
}
