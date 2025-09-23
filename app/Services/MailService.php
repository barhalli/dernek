<?php
namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;
use App\Models\Setting;

class MailService
{
    protected array $config;

    public function __construct()
    {
        $this->config = require __DIR__ . '/../Config/config.php';
        $this->hydrateFromSettings();
    }

    protected function hydrateFromSettings(): void
    {
        $setting = new Setting();
        foreach (['host','port','username','password','from_email','from_name','encryption'] as $field) {
            $value = $setting->get('smtp_' . $field);
            if ($value !== null) {
                $this->config['mail'][$field] = $field === 'port' ? (int)$value : $value;
            }
        }
    }

    public function send(string $to, string $subject, string $body): bool
    {
        $settings = $this->config['mail'];

        if (class_exists(PHPMailer::class)) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = $settings['host'];
                $mail->SMTPAuth = true;
                $mail->Username = $settings['username'];
                $mail->Password = $settings['password'];
                $mail->SMTPSecure = $settings['encryption'];
                $mail->Port = $settings['port'];
                $mail->CharSet = 'UTF-8';

                $mail->setFrom($settings['from_email'], $settings['from_name']);
                $mail->addAddress($to);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $body;

                return $mail->send();
            } catch (MailException $e) {
                error_log('Mail gönderilemedi: ' . $e->getMessage());
                return false;
            }
        }

        // Fallback basic mail()
        $headers = 'From: ' . $settings['from_name'] . ' <' . $settings['from_email'] . '>' . "\r\n" .
            'Content-Type: text/html; charset=UTF-8';
        return mail($to, $subject, $body, $headers);
    }
}
