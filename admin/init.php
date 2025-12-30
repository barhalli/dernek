<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

$siteData = load_data($pdo);

$adminSettings = $settings['admin'] ?? [
    'user' => 'admin',
    'pass' => 'change-me',
];

function is_logged_in(): bool
{
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function require_login(): void
{
    if (!is_logged_in()) {
        $redirect = urlencode($_SERVER['REQUEST_URI'] ?? 'dashboard.php');
        header('Location: login.php?redirect=' . $redirect);
        exit;
    }
}
