<?php
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\ClassController;
use App\Controllers\StudentController;
use App\Controllers\AttendanceController;
use App\Controllers\GradeController;
use App\Controllers\AnnouncementController;
use App\Controllers\TimetableController;
use App\Controllers\ReportController;
use App\Controllers\FileController;
use App\Controllers\MessageController;
use App\Controllers\SettingsController;
use App\Controllers\CronController;

return [
    ['method' => 'GET', 'uri' => '/', 'action' => [DashboardController::class, 'index'], 'middlewares' => [['type' => 'auth']]],

    ['method' => 'GET', 'uri' => '/login', 'action' => [AuthController::class, 'showLoginForm']],
    ['method' => 'POST', 'uri' => '/login', 'action' => [AuthController::class, 'login'], 'middlewares' => [['type' => 'rate_limit'], ['type' => 'csrf']]],
    ['method' => 'POST', 'uri' => '/logout', 'action' => [AuthController::class, 'logout'], 'middlewares' => [['type' => 'csrf'], ['type' => 'auth']]],
    ['method' => 'GET', 'uri' => '/sifre-sifirla', 'action' => [AuthController::class, 'forgotForm']],
    ['method' => 'POST', 'uri' => '/sifre-sifirla', 'action' => [AuthController::class, 'sendResetLink'], 'middlewares' => [['type' => 'csrf']]],
    ['method' => 'GET', 'uri' => '/sifre-yenile', 'action' => [AuthController::class, 'resetForm']],
    ['method' => 'POST', 'uri' => '/sifre-yenile', 'action' => [AuthController::class, 'resetPassword'], 'middlewares' => [['type' => 'csrf']]],

    ['method' => 'GET', 'uri' => '/classes', 'action' => [ClassController::class, 'index'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'GET', 'uri' => '/classes/create', 'action' => [ClassController::class, 'create'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'POST', 'uri' => '/classes', 'action' => [ClassController::class, 'store'], 'middlewares' => [['type' => 'auth'], ['type' => 'csrf']]],
    ['method' => 'GET', 'uri' => '/classes/{id}', 'action' => [ClassController::class, 'show'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'GET', 'uri' => '/classes/{id}/edit', 'action' => [ClassController::class, 'edit'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'POST', 'uri' => '/classes/{id}/update', 'action' => [ClassController::class, 'update'], 'middlewares' => [['type' => 'auth'], ['type' => 'csrf']]],

    ['method' => 'GET', 'uri' => '/students', 'action' => [StudentController::class, 'index'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'GET', 'uri' => '/students/import', 'action' => [StudentController::class, 'importForm'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'POST', 'uri' => '/students/import', 'action' => [StudentController::class, 'import'], 'middlewares' => [['type' => 'auth'], ['type' => 'csrf']]],
    ['method' => 'GET', 'uri' => '/students/{id}', 'action' => [StudentController::class, 'show'], 'middlewares' => [['type' => 'auth']]],

    ['method' => 'GET', 'uri' => '/attendance/take', 'action' => [AttendanceController::class, 'takeForm'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'POST', 'uri' => '/attendance/take', 'action' => [AttendanceController::class, 'submit'], 'middlewares' => [['type' => 'auth'], ['type' => 'csrf']]],
    ['method' => 'GET', 'uri' => '/attendance/list', 'action' => [AttendanceController::class, 'list'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'GET', 'uri' => '/attendance/export', 'action' => [AttendanceController::class, 'export'], 'middlewares' => [['type' => 'auth']]],

    ['method' => 'GET', 'uri' => '/grades', 'action' => [GradeController::class, 'index'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'GET', 'uri' => '/grades/enter', 'action' => [GradeController::class, 'enterForm'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'POST', 'uri' => '/grades/enter', 'action' => [GradeController::class, 'store'], 'middlewares' => [['type' => 'auth'], ['type' => 'csrf']]],
    ['method' => 'GET', 'uri' => '/grades/export', 'action' => [GradeController::class, 'export'], 'middlewares' => [['type' => 'auth']]],

    ['method' => 'GET', 'uri' => '/announcements', 'action' => [AnnouncementController::class, 'index'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'GET', 'uri' => '/announcements/create', 'action' => [AnnouncementController::class, 'create'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'POST', 'uri' => '/announcements', 'action' => [AnnouncementController::class, 'store'], 'middlewares' => [['type' => 'auth'], ['type' => 'csrf']]],

    ['method' => 'GET', 'uri' => '/timetable', 'action' => [TimetableController::class, 'index'], 'middlewares' => [['type' => 'auth']]],

    ['method' => 'GET', 'uri' => '/reports', 'action' => [ReportController::class, 'index'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'GET', 'uri' => '/reports/attendance', 'action' => [ReportController::class, 'attendance'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'GET', 'uri' => '/reports/grades', 'action' => [ReportController::class, 'grades'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'GET', 'uri' => '/reports/risk', 'action' => [ReportController::class, 'risk'], 'middlewares' => [['type' => 'auth']]],

    ['method' => 'GET', 'uri' => '/files', 'action' => [FileController::class, 'index'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'POST', 'uri' => '/files', 'action' => [FileController::class, 'store'], 'middlewares' => [['type' => 'auth'], ['type' => 'csrf']]],
    ['method' => 'GET', 'uri' => '/files/download', 'action' => [FileController::class, 'download'], 'middlewares' => [['type' => 'auth']]],

    ['method' => 'GET', 'uri' => '/messages', 'action' => [MessageController::class, 'inbox'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'GET', 'uri' => '/messages/sent', 'action' => [MessageController::class, 'sent'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'GET', 'uri' => '/messages/compose', 'action' => [MessageController::class, 'compose'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'POST', 'uri' => '/messages', 'action' => [MessageController::class, 'send'], 'middlewares' => [['type' => 'auth'], ['type' => 'csrf']]],
    ['method' => 'GET', 'uri' => '/messages/{id}', 'action' => [MessageController::class, 'thread'], 'middlewares' => [['type' => 'auth']]],

    ['method' => 'GET', 'uri' => '/settings', 'action' => [SettingsController::class, 'index'], 'middlewares' => [['type' => 'auth']]],
    ['method' => 'POST', 'uri' => '/settings/general', 'action' => [SettingsController::class, 'saveGeneral'], 'middlewares' => [['type' => 'auth'], ['type' => 'csrf']]],
    ['method' => 'POST', 'uri' => '/settings/smtp', 'action' => [SettingsController::class, 'saveSmtp'], 'middlewares' => [['type' => 'auth'], ['type' => 'csrf']]],
    ['method' => 'POST', 'uri' => '/settings/backup', 'action' => [SettingsController::class, 'downloadBackup'], 'middlewares' => [['type' => 'auth'], ['type' => 'csrf']]],

    ['method' => 'GET', 'uri' => '/cron/daily', 'action' => [CronController::class, 'daily']],
    ['method' => 'GET', 'uri' => '/cron/hourly', 'action' => [CronController::class, 'hourly']],
];
