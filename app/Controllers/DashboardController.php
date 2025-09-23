<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ClassModel;
use App\Models\Assessment;
use App\Models\Announcement;
use App\Models\Timetable;
use App\Models\Attendance;
use App\Services\CacheService;

class DashboardController extends Controller
{
    public function index()
    {
        $user = current_user();
        $cache = new CacheService();
        $classes = $cache->remember('dashboard_classes_' . $user['id'], 300, function () use ($user) {
            $classModel = new ClassModel();
            if ($user['role'] === 'teacher') {
                return $classModel->allForTeacher($user['id']);
            }
            return $classModel->paginate(1, 100)['items'];
        });

        $announcementModel = new Announcement();
        $announcements = $announcementModel->visibleForUser($user['id'], $user['role']);

        $assessmentModel = new Assessment();
        $upcomingAssessments = [];
        foreach ($classes as $class) {
            $assessments = $assessmentModel->byClass($class['id']);
            foreach ($assessments as $assessment) {
                if ($assessment['date'] >= date('Y-m-d')) {
                    $assessment['class_name'] = $class['name'];
                    $upcomingAssessments[] = $assessment;
                }
            }
        }
        usort($upcomingAssessments, fn($a, $b) => strcmp($a['date'], $b['date']));
        $upcomingAssessments = array_slice($upcomingAssessments, 0, 5);

        $timetableModel = new Timetable();
        $todaySchedule = [];
        $weekday = (int)date('w');
        $weekday = $weekday === 0 ? 6 : $weekday - 1; // Pazartesi 0
        foreach ($classes as $class) {
            $entries = $timetableModel->forClass($class['id']);
            foreach ($entries as $entry) {
                if ((int)$entry['weekday'] === $weekday) {
                    $entry['class_name'] = $class['name'];
                    $todaySchedule[] = $entry;
                }
            }
        }

        $attendanceModel = new Attendance();
        $todayAttendance = [];
        foreach ($classes as $class) {
            $records = $attendanceModel->listByClassAndRange($class['id'], date('Y-m-d'), date('Y-m-d'));
            if ($records) {
                $todayAttendance[$class['name']] = $records;
            }
        }

        return $this->view('dashboard/index', compact('classes', 'announcements', 'upcomingAssessments', 'todaySchedule', 'todayAttendance'));
    }
}
