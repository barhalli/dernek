<?php
namespace App\Services;

use ZipArchive;

class StorageService
{
    protected string $uploadsPath;
    protected string $backupPath;

    public function __construct()
    {
        $config = require __DIR__ . '/../Config/config.php';
        $this->uploadsPath = realpath($config['storage']['uploads_path']);
        $this->backupPath = $config['storage']['backup_path'];
        if (!is_dir($this->backupPath)) {
            mkdir($this->backupPath, 0755, true);
        }
    }

    public function storeUploadedFile(array $file, string $subdir = ''): ?string
    {
        $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'png', 'jpg', 'jpeg'];
        $maxSize = 5 * 1024 * 1024;

        if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] > $maxSize) {
            return null;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed, true)) {
            return null;
        }

        $mime = mime_content_type($file['tmp_name']);
        $allowedMime = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'image/png',
            'image/jpeg',
        ];
        if (!in_array($mime, $allowedMime, true)) {
            return null;
        }

        $subdir = trim($subdir, '/');
        $targetDir = $this->uploadsPath . ($subdir ? '/' . $subdir : '');
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $filename = uniqid('file_', true) . '.' . $ext;
        $targetPath = $targetDir . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return null;
        }

        return str_replace($this->uploadsPath, '', $targetPath);
    }

    public function createUploadsZip(): ?string
    {
        $zip = new ZipArchive();
        $filename = $this->backupPath . '/uploads_' . date('Ymd_His') . '.zip';

        if ($zip->open($filename, ZipArchive::CREATE) !== true) {
            return null;
        }

        $this->addFolderToZip($this->uploadsPath, $zip);
        $zip->close();
        return $filename;
    }

    protected function addFolderToZip(string $folder, ZipArchive $zip, string $parent = ''): void
    {
        $files = scandir($folder);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $folder . '/' . $file;
            $localName = ($parent ? $parent . '/' : '') . $file;
            if (is_dir($path)) {
                $zip->addEmptyDir($localName);
                $this->addFolderToZip($path, $zip, $localName);
            } else {
                $zip->addFile($path, $localName);
            }
        }
    }
}
