<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ClassModel;
use App\Models\Timetable;

class TimetableController extends Controller
{
    public function index()
    {
        $classId = (int)($_GET['class'] ?? 0);
        $classes = (new ClassModel())->paginate(1, 100)['items'];
        $entries = $classId ? (new Timetable())->forClass($classId) : [];
        return $this->view('timetable/index', compact('classes', 'entries', 'classId'));
    }
}
