<?php
$configPath = __DIR__ . '/config.php';
$settings = file_exists($configPath)
    ? require $configPath
    : require __DIR__ . '/config.example.php';

$db = $settings['db'] ?? [];

$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $db['host'], $db['name'], $db['charset'] ?? 'utf8mb4');
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $db['user'], $db['pass'], $options);
} catch (Throwable $exception) {
    // On shared hosting we want graceful degradation rather than breaking the site.
    $pdo = null;
}
