<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Flash;
use App\Models\ClassModel;
use App\Models\Enrollment;
use App\Models\Attendance;
use App\Services\ExportService;
use App\Services\PdfService;

class AttendanceController extends Controller
{
    protected Attendance $attendance;

    public function __construct()
    {
        $this->attendance = new Attendance();
    }

    public function takeForm()
    {
        $classId = (int)($_GET['class'] ?? 0);
        $date = $_GET['date'] ?? date('Y-m-d');
        $classes = (new ClassModel())->paginate(1, 100)['items'];
        $students = $classId ? (new Enrollment())->studentsOfClass($classId) : [];
        $records = $classId ? $this->attendance->listByClassAndRange($classId, $date, $date) : [];
        $existing = [];
        foreach ($records as $record) {
            $existing[$record['student_id']] = $record;
        }
        return $this->view('attendance/take', compact('classes', 'students', 'classId', 'date', 'existing'));
    }

    public function submit()
    {
        $classId = (int)($_POST['class_id'] ?? 0);
        $date = $_POST['date'] ?? date('Y-m-d');
        if (!$classId) {
            Flash::add('error', 'Sınıf seçiniz.');
            $this->back();
        }

        $rows = [];
        foreach ($_POST['status'] ?? [] as $studentId => $status) {
            $status = in_array($status, ['Present', 'Late', 'Absent', 'Excused'], true) ? $status : 'Present';
            $rows[] = [
                'class_id' => $classId,
                'student_id' => $studentId,
                'date' => $date,
                'status' => $status,
                'note' => $_POST['note'][$studentId] ?? null,
            ];
        }
        $this->attendance->mark($rows);
        Flash::add('success', 'Yoklama kaydedildi.');
        $this->redirect('/attendance/take?class=' . $classId . '&date=' . $date);
    }

    public function list()
    {
        $classId = (int)($_GET['class'] ?? 0);
        $start = $_GET['start'] ?? date('Y-m-01');
        $end = $_GET['end'] ?? date('Y-m-t');
        $classes = (new ClassModel())->paginate(1, 100)['items'];
        $records = $classId ? $this->attendance->listByClassAndRange($classId, $start, $end) : [];
        return $this->view('attendance/list', compact('classes', 'records', 'classId', 'start', 'end'));
    }

    public function export()
    {
        $classId = (int)($_GET['class'] ?? 0);
        $start = $_GET['start'] ?? date('Y-m-01');
        $end = $_GET['end'] ?? date('Y-m-t');
        $format = $_GET['format'] ?? 'csv';
        if (!$classId) {
            Flash::add('error', 'Sınıf seçiniz.');
            $this->redirect('/attendance/list');
        }
        $records = $this->attendance->listByClassAndRange($classId, $start, $end);
        $headers = ['Öğrenci', 'Tarih', 'Durum', 'Not'];
        $rows = array_map(function ($record) {
            return [
                $record['first_name'] . ' ' . $record['last_name'],
                $record['date'],
                $record['status'],
                $record['note'],
            ];
        }, $records);

        if ($format === 'pdf') {
            $html = '<h1>Yoklama Raporu</h1><table border="1" cellpadding="4" cellspacing="0">';
            $html .= '<tr><th>' . implode('</th><th>', $headers) . '</th></tr>';
            foreach ($rows as $row) {
                $html .= '<tr><td>' . implode('</td><td>', array_map('e', $row)) . '</td></tr>';
            }
            $html .= '</table>';
            (new PdfService())->download('yoklama_' . $classId, $html);
        }

        (new ExportService())->export($headers, $rows, 'yoklama_' . $classId, $format);
    }
}
