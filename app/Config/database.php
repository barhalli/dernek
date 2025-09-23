<?php
$config = require __DIR__ . '/config.php';

$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s',
    $config['db']['host'],
    $config['db']['name'],
    $config['db']['charset']
);

try {
    $pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
} catch (PDOException $e) {
    if ($config['debug']) {
        die('Veritabanı bağlantısı başarısız: ' . $e->getMessage());
    }
    error_log('DB CONNECTION ERROR: ' . $e->getMessage());
    die('Veritabanı bağlantısı kurulamadı. Lütfen daha sonra tekrar deneyiniz.');
}

return $pdo;
