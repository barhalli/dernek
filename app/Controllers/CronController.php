<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Services\MailService;
use App\Models\Announcement;
use App\Models\ClassModel;

class CronController extends Controller
{
    protected function authorize(): void
    {
        $config = config('cron');
        $token = $_GET['token'] ?? '';
        if (!$token || $token !== $config['token']) {
            http_response_code(401);
            exit('Yetkisiz erişim.');
        }
    }

    public function daily()
    {
        $this->authorize();
        $announcementModel = new Announcement();
        $announcements = $announcementModel->visibleForUser(0, 'admin');
        $mail = new MailService();
        foreach (array_slice($announcements, 0, 5) as $announcement) {
            $mail->send(config('mail')['from_email'], 'Günlük Hatırlatma: ' . $announcement['title'], '<p>' . e($announcement['body']) . '</p>');
        }
        echo 'Daily cron executed.';
    }

    public function hourly()
    {
        $this->authorize();
        $mail = new MailService();
        $mail->send(config('mail')['from_email'], 'Saatlik kontrol', 'Saatlik cron başarıyla çalıştı.');
        echo 'Hourly cron executed.';
    }
}
