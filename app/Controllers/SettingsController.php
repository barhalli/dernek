<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Flash;
use App\Helpers\Validator;
use App\Models\Setting;
use App\Services\StorageService;

class SettingsController extends Controller
{
    protected Setting $settings;
    protected \PDO $db;

    public function __construct()
    {
        $this->settings = new Setting();
        $this->db = require __DIR__ . '/../Config/database.php';
    }

    public function index()
    {
        $values = [
            'school_year' => $this->settings->get('school_year', date('Y')),
            'term' => $this->settings->get('term', '1'),
            'smtp_host' => $this->settings->get('smtp_host', config('mail')['host']),
            'smtp_port' => $this->settings->get('smtp_port', config('mail')['port']),
            'smtp_username' => $this->settings->get('smtp_username', config('mail')['username']),
            'smtp_password' => $this->settings->get('smtp_password', config('mail')['password']),
            'smtp_encryption' => $this->settings->get('smtp_encryption', config('mail')['encryption']),
            'smtp_from_email' => $this->settings->get('smtp_from_email', config('mail')['from_email']),
            'smtp_from_name' => $this->settings->get('smtp_from_name', config('mail')['from_name']),
        ];
        return $this->view('settings/index', compact('values'));
    }

    public function saveGeneral()
    {
        $validator = Validator::make($_POST)
            ->required('school_year', 'Okul yılı zorunludur.')
            ->required('term', 'Dönem zorunludur.');
        if (!$validator->passes()) {
            Flash::add('error', 'Lütfen formu doldurun.');
            $this->back();
        }
        $this->settings->set('school_year', $_POST['school_year']);
        $this->settings->set('term', $_POST['term']);
        Flash::add('success', 'Genel ayarlar güncellendi.');
        $this->redirect('/settings');
    }

    public function saveSmtp()
    {
        $validator = Validator::make($_POST)
            ->required('smtp_host', 'SMTP sunucusu zorunludur.')
            ->required('smtp_port', 'Port zorunludur.')
            ->required('smtp_username', 'Kullanıcı adı zorunludur.')
            ->required('smtp_from_email', 'Gönderen e-posta zorunludur.');
        if (!$validator->passes()) {
            Flash::add('error', 'Lütfen formu doldurun.');
            $this->back();
        }
        foreach (['smtp_host','smtp_port','smtp_username','smtp_password','smtp_encryption','smtp_from_email','smtp_from_name'] as $key) {
            $this->settings->set($key, $_POST[$key] ?? '');
        }
        Flash::add('success', 'SMTP ayarları kaydedildi.');
        $this->redirect('/settings');
    }

    public function downloadBackup()
    {
        $type = $_POST['type'] ?? 'database';
        if ($type === 'database') {
            $sql = $this->exportDatabase();
            header('Content-Type: application/sql');
            header('Content-Disposition: attachment; filename="sinifnizam_' . date('Ymd_His') . '.sql"');
            echo $sql;
            exit;
        }
        if ($type === 'uploads') {
            $file = (new StorageService())->createUploadsZip();
            if (!$file) {
                Flash::add('error', 'Yedek oluşturulamadı.');
                $this->back();
            }
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            readfile($file);
            exit;
        }
        Flash::add('error', 'Geçersiz yedek türü.');
        $this->back();
    }

    protected function exportDatabase(): string
    {
        $sql = "SET NAMES utf8mb4;\nSET FOREIGN_KEY_CHECKS=0;\n";
        $tables = $this->db->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);
        foreach ($tables as $table) {
            $create = $this->db->query('SHOW CREATE TABLE `' . $table . '`')->fetch(\PDO::FETCH_ASSOC);
            $sql .= "\nDROP TABLE IF EXISTS `$table`;\n" . $create['Create Table'] . ";\n\n";
            $rows = $this->db->query('SELECT * FROM `' . $table . '`')->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $values = array_map([$this->db, 'quote'], array_values($row));
                $sql .= 'INSERT INTO `' . $table . '` (`' . implode('`,`', array_keys($row)) . '`) VALUES (' . implode(',', $values) . ");\n";
            }
        }
        return $sql;
    }
}
