<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Flash;
use App\Helpers\Validator;
use App\Models\ClassModel;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Timetable;

class ClassController extends Controller
{
    protected ClassModel $classes;

    public function __construct()
    {
        $this->classes = new ClassModel();
    }

    public function index()
    {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $data = $this->classes->paginate($page, 10);
        return $this->view('classes/index', [
            'classes' => $data['items'],
            'total' => $data['total'],
            'page' => $page,
            'perPage' => 10,
        ]);
    }

    public function create()
    {
        $teachers = (new User())->all();
        return $this->view('classes/create', compact('teachers'));
    }

    public function store()
    {
        $validator = Validator::make($_POST)
            ->required('name', 'Sınıf adı zorunludur.')
            ->required('grade_level', 'Düzey zorunludur.')
            ->required('year', 'Yıl zorunludur.')
            ->required('teacher_id', 'Sınıf öğretmeni seçiniz.');

        if (!$validator->passes()) {
            Flash::add('error', 'Formdaki eksikleri kontrol edin.');
            $this->back();
        }

        $this->classes->create([
            'name' => $_POST['name'],
            'grade_level' => $_POST['grade_level'],
            'year' => $_POST['year'],
            'teacher_id' => $_POST['teacher_id'],
        ]);

        Flash::add('success', 'Sınıf başarıyla oluşturuldu.');
        $this->redirect('/classes');
    }

    public function show($id)
    {
        $class = $this->classes->find((int)$id);
        if (!$class) {
            Flash::add('error', 'Sınıf bulunamadı.');
            $this->redirect('/classes');
        }
        $students = (new Enrollment())->studentsOfClass($class['id']);
        $schedule = (new Timetable())->forClass($class['id']);
        return $this->view('classes/show', compact('class', 'students', 'schedule'));
    }

    public function edit($id)
    {
        $class = $this->classes->find((int)$id);
        $teachers = (new User())->all();
        return $this->view('classes/edit', compact('class', 'teachers'));
    }

    public function update($id)
    {
        $validator = Validator::make($_POST)
            ->required('name', 'Sınıf adı zorunludur.')
            ->required('grade_level', 'Düzey zorunludur.')
            ->required('year', 'Yıl zorunludur.')
            ->required('teacher_id', 'Sınıf öğretmeni seçiniz.');

        if (!$validator->passes()) {
            Flash::add('error', 'Formdaki eksikleri kontrol edin.');
            $this->back();
        }

        $this->classes->update((int)$id, [
            'name' => $_POST['name'],
            'grade_level' => $_POST['grade_level'],
            'year' => $_POST['year'],
            'teacher_id' => $_POST['teacher_id'],
        ]);

        Flash::add('success', 'Sınıf güncellendi.');
        $this->redirect('/classes/' . $id);
    }
}
