<?php
return [
    'app_name' => 'SınıfNizam',
    'environment' => 'production',
    'debug' => false,
    'base_url' => rtrim((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost') . dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/'),
    'timezone' => 'Europe/Istanbul',
    'locale' => 'tr_TR',
    'db' => [
        'host' => 'localhost',
        'name' => 'sinifnizam',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ],
    ],
    'mail' => [
        'host' => 'smtp.example.com',
        'port' => 587,
        'username' => 'no-reply@example.com',
        'password' => '',
        'from_email' => 'no-reply@example.com',
        'from_name' => 'SınıfNizam',
        'encryption' => 'tls',
    ],
    'security' => [
        'csrf_token_key' => '_csrf_token',
        'remember_login_days' => 14,
        'rate_limit' => [
            'login' => [
                'max_attempts' => 5,
                'decay_minutes' => 15,
            ],
        ],
    ],
    'storage' => [
        'uploads_path' => __DIR__ . '/../Storage/uploads',
        'logs_path' => __DIR__ . '/../Storage/logs/app.log',
        'cache_path' => __DIR__ . '/../Storage/cache',
        'backup_path' => __DIR__ . '/../Storage/backups',
    ],
    'cron' => [
        'token' => 'degistir-bu-anahtari',
    ],
];
