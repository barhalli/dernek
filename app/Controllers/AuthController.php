<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Flash;
use App\Helpers\Validator;
use App\Models\User;
use App\Services\SecurityService;
use App\Services\MailService;

class AuthController extends Controller
{
    protected User $users;
    protected \PDO $db;

    public function __construct()
    {
        $this->users = new User();
        $this->db = require __DIR__ . '/../Config/database.php';
    }

    public function showLoginForm()
    {
        if (current_user()) {
            $this->redirect('/');
        }
        $messages = flash_messages();
        return $this->view('auth/login', compact('messages'), 'auth');
    }

    public function login()
    {
        $validator = Validator::make($_POST)
            ->required('email', 'E-posta zorunludur.')
            ->required('password', 'Şifre zorunludur.')
            ->email('email', 'E-posta formatı hatalı.');

        if (!$validator->passes()) {
            $_SESSION['rate_limit_failed'] = true;
            Flash::add('error', 'Giriş bilgileri eksik veya hatalı.');
            $this->back();
        }

        $user = $this->users->findByEmail($_POST['email']);
        if (!$user || !SecurityService::verifyPassword($_POST['password'], $user['password_hash'])) {
            $_SESSION['rate_limit_failed'] = true;
            Flash::add('error', 'E-posta veya şifre hatalı.');
            $this->back();
        }

        if ($user['status'] !== 'active') {
            Flash::add('error', 'Hesabınız pasif durumda. Yönetici ile iletişime geçin.');
            $this->back();
        }

        unset($_SESSION['rate_limit_failed']);
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];

        Flash::add('success', 'Hoş geldiniz, ' . $user['name']);
        $this->redirect('/');
    }

    public function logout()
    {
        session_destroy();
        session_start();
        Flash::add('success', 'Güvenli çıkış yapıldı.');
        $this->redirect('/login');
    }

    public function forgotForm()
    {
        $messages = flash_messages();
        return $this->view('auth/forgotten', compact('messages'), 'auth');
    }

    public function sendResetLink()
    {
        $validator = Validator::make($_POST)
            ->required('email', 'E-posta zorunludur.')
            ->email('email', 'E-posta formatı hatalı.');

        if (!$validator->passes()) {
            Flash::add('error', 'Geçerli bir e-posta giriniz.');
            $this->back();
        }

        $user = $this->users->findByEmail($_POST['email']);
        if (!$user) {
            Flash::add('success', 'Eğer kayıtlıysanız şifre sıfırlama bağlantısı e-postanıza gönderildi.');
            $this->back();
        }

        $token = SecurityService::generateToken(16);
        $expires = date('Y-m-d H:i:s', time() + 3600);
        $stmt = $this->db->prepare('INSERT INTO password_resets (user_id, token, expires_at) VALUES (:user_id,:token,:expires_at) ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at)');
        $stmt->execute([
            'user_id' => $user['id'],
            'token' => $token,
            'expires_at' => $expires,
        ]);

        $mail = new MailService();
        $link = base_url('sifre-yenile?token=' . $token);
        $body = '<p>Merhaba ' . e($user['name']) . ',</p><p>Şifrenizi sıfırlamak için aşağıdaki bağlantıya tıklayın:</p><p><a href="' . $link . '">' . $link . '</a></p><p>Bu bağlantı 60 dakika boyunca geçerlidir.</p>';
        $mail->send($user['email'], 'SınıfNizam Şifre Sıfırlama', $body);

        Flash::add('success', 'Eğer kayıtlıysanız şifre sıfırlama bağlantısı e-postanıza gönderildi.');
        $this->back();
    }

    public function resetForm()
    {
        $token = $_GET['token'] ?? null;
        $messages = flash_messages();
        return $this->view('auth/reset', compact('token', 'messages'), 'auth');
    }

    public function resetPassword()
    {
        $validator = Validator::make($_POST)
            ->required('token', 'Token bulunamadı.')
            ->required('password', 'Yeni şifre zorunludur.');

        if (!$validator->passes()) {
            Flash::add('error', 'Lütfen formu eksiksiz doldurun.');
            $this->back();
        }

        $stmt = $this->db->prepare('SELECT * FROM password_resets WHERE token = :token AND expires_at >= NOW()');
        $stmt->execute(['token' => $_POST['token']]);
        $reset = $stmt->fetch();

        if (!$reset) {
            Flash::add('error', 'Token geçersiz veya süresi dolmuş.');
            $this->back();
        }

        $hash = SecurityService::hashPassword($_POST['password']);
        $this->users->update((int)$reset['user_id'], ['password_hash' => $hash]);

        $this->db->prepare('DELETE FROM password_resets WHERE user_id = :user')->execute(['user' => $reset['user_id']]);

        Flash::add('success', 'Şifreniz yenilendi. Lütfen giriş yapınız.');
        $this->redirect('/login');
    }
}
