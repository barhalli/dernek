<?php
namespace App\Helpers;

class Csrf
{
    public static function token(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $key = self::key();
        if (empty($_SESSION[$key])) {
            $_SESSION[$key] = bin2hex(random_bytes(32));
        }
        return $_SESSION[$key];
    }

    public static function key(): string
    {
        $config = require __DIR__ . '/../Config/config.php';
        return $config['security']['csrf_token_key'] ?? '_csrf_token';
    }

    public static function check(?string $token): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $key = self::key();
        if (!$token || empty($_SESSION[$key])) {
            return false;
        }
        $valid = hash_equals($_SESSION[$key], $token);
        if ($valid) {
            unset($_SESSION[$key]);
        }
        return $valid;
    }
}
