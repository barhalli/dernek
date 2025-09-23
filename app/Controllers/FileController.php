<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Flash;
use App\Models\FileModel;
use App\Models\ClassModel;
use App\Services\StorageService;

class FileController extends Controller
{
    protected FileModel $files;
    protected StorageService $storage;

    public function __construct()
    {
        $this->files = new FileModel();
        $this->storage = new StorageService();
    }

    public function index()
    {
        $user = current_user();
        $files = $this->files->listForUser($user['id'], $user['role']);
        $classes = (new ClassModel())->paginate(1, 100)['items'];
        return $this->view('files/index', compact('files', 'classes'));
    }

    public function store()
    {
        $user = current_user();
        if (empty($_FILES['file']['name'])) {
            Flash::add('error', 'Dosya seçiniz.');
            $this->back();
        }
        $stored = $this->storage->storeUploadedFile($_FILES['file'], 'user_' . $user['id']);
        if (!$stored) {
            Flash::add('error', 'Dosya yüklenemedi. İzin verilen format: pdf, docx, xlsx, png, jpg.');
            $this->back();
        }
        $storageConfig = config('storage');
        $fullPath = realpath($storageConfig['uploads_path'] . $stored);
        $data = [
            'owner_user_id' => $user['id'],
            'class_id' => $_POST['class_id'] ?: null,
            'path' => $stored,
            'filename' => $_FILES['file']['name'],
            'size' => $_FILES['file']['size'],
            'mime' => $fullPath ? mime_content_type($fullPath) : $_FILES['file']['type'],
            'visibility' => $_POST['visibility'] ?? 'private',
        ];
        $this->files->create($data);
        Flash::add('success', 'Dosya yüklendi.');
        $this->redirect('/files');
    }

    public function download()
    {
        $path = $_GET['path'] ?? null;
        if (!$path) {
            Flash::add('error', 'Dosya bulunamadı.');
            $this->redirect('/files');
        }
        $storageConfig = config('storage');
        $fullPath = realpath($storageConfig['uploads_path'] . $path);
        if (!$fullPath || strpos($fullPath, realpath($storageConfig['uploads_path'])) !== 0) {
            Flash::add('error', 'Dosyaya erişim izni yok.');
            $this->redirect('/files');
        }
        if (!file_exists($fullPath)) {
            Flash::add('error', 'Dosya bulunamadı.');
            $this->redirect('/files');
        }
        header('Content-Description: File Transfer');
        header('Content-Type: ' . mime_content_type($fullPath));
        header('Content-Disposition: attachment; filename="' . basename($fullPath) . '"');
        header('Content-Length: ' . filesize($fullPath));
        readfile($fullPath);
        exit;
    }
}
