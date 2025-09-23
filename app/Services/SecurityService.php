<?php
namespace App\Services;

class SecurityService
{
    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public static function generateToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }

    public static function log(string $message): void
    {
        $config = require __DIR__ . '/../Config/config.php';
        $logFile = $config['storage']['logs_path'];
        $dir = dirname($logFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $entry = sprintf("[%s] %s\n", date('Y-m-d H:i:s'), $message);
        file_put_contents($logFile, $entry, FILE_APPEND);
    }
}
