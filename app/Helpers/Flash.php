<?php
namespace App\Helpers;

class Flash
{
    const SESSION_KEY = '_flash_messages';

    public static function add(string $type, string $message): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION[self::SESSION_KEY][$type][] = $message;
    }

    public static function get(): array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $messages = $_SESSION[self::SESSION_KEY] ?? [];
        unset($_SESSION[self::SESSION_KEY]);
        return $messages;
    }
}
