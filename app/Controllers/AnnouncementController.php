<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Flash;
use App\Helpers\Validator;
use App\Models\Announcement;
use App\Models\ClassModel;
use App\Services\StorageService;
use App\Services\MailService;

class AnnouncementController extends Controller
{
    protected Announcement $announcements;

    public function __construct()
    {
        $this->announcements = new Announcement();
    }

    public function index()
    {
        $user = current_user();
        $announcements = $this->announcements->visibleForUser($user['id'], $user['role']);
        return $this->view('announcements/index', compact('announcements'));
    }

    public function create()
    {
        $classes = (new ClassModel())->paginate(1, 100)['items'];
        return $this->view('announcements/create', compact('classes'));
    }

    public function store()
    {
        $validator = Validator::make($_POST)
            ->required('title', 'Başlık zorunludur.')
            ->required('body', 'Duyuru metni zorunludur.');

        if (!$validator->passes()) {
            Flash::add('error', 'Lütfen zorunlu alanları doldurun.');
            $this->back();
        }

        $path = null;
        if (!empty($_FILES['attachment']['name'])) {
            $storage = new StorageService();
            $stored = $storage->storeUploadedFile($_FILES['attachment'], 'announcements');
            if (!$stored) {
                Flash::add('error', 'Dosya yüklenemedi. İzin verilen format: pdf, docx, xlsx, png, jpg.');
                $this->back();
            }
            $path = $stored;
        }

        $data = [
            'class_id' => $_POST['class_id'] ?: null,
            'title' => $_POST['title'],
            'body' => $_POST['body'],
            'visible_from' => $_POST['visible_from'] ?: date('Y-m-d H:i:s'),
            'visible_to' => $_POST['visible_to'] ?: null,
            'attachment_path' => $path,
        ];
        $this->announcements->create($data);

        // Bildirim e-postası (örnek)
        $mail = new MailService();
        $mail->send(config('mail')['from_email'], 'Yeni Duyuru: ' . $data['title'], '<p>' . e($data['body']) . '</p>');

        Flash::add('success', 'Duyuru oluşturuldu.');
        $this->redirect('/announcements');
    }
}
