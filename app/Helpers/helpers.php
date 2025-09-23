<?php
use App\Helpers\Csrf;
use App\Helpers\Flash;

if (!function_exists('config')) {
    function config(?string $key = null, $default = null)
    {
        static $config;
        if (!$config) {
            $config = require __DIR__ . '/../Config/config.php';
        }
        if ($key === null) {
            return $config;
        }
        return $config[$key] ?? $default;
    }
}

if (!function_exists('base_url')) {
    function base_url(string $path = ''): string
    {
        $base = config('base_url');
        return rtrim($base, '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string
    {
        return base_url('assets/' . ltrim($path, '/'));
    }
}

if (!function_exists('e')) {
    function e(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        return '<input type="hidden" name="' . e(Csrf::key()) . '" value="' . e(Csrf::token()) . '">';
    }
}

if (!function_exists('old')) {
    function old(string $key, $default = '')
    {
        return $_SESSION['_old'][$key] ?? $default;
    }
}

if (!function_exists('set_old')) {
    function set_old(array $data): void
    {
        $_SESSION['_old'] = $data;
    }
}

if (!function_exists('clear_old')) {
    function clear_old(): void
    {
        unset($_SESSION['_old']);
    }
}

if (!function_exists('flash_messages')) {
    function flash_messages(): array
    {
        return Flash::get();
    }
}

if (!function_exists('current_user')) {
    function current_user(): ?array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['user'] ?? null;
    }
}

if (!function_exists('authorize')) {
    function authorize(array $roles): bool
    {
        $user = current_user();
        if (!$user) {
            return false;
        }
        return in_array($user['role'], $roles, true);
    }
}
