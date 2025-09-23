<?php
$lockFile = __DIR__ . '/install.lock';
if (file_exists($lockFile)) {
    exit('Kurulum zaten tamamlanmış görünüyor. install.lock dosyasını silmeden tekrar kurulum yapılamaz.');
}

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbHost = trim($_POST['db_host'] ?? '');
    $dbName = trim($_POST['db_name'] ?? '');
    $dbUser = trim($_POST['db_user'] ?? '');
    $dbPass = trim($_POST['db_pass'] ?? '');

    if (!$dbHost || !$dbName || !$dbUser) {
        $error = 'Lütfen tüm zorunlu alanları doldurun.';
    } else {
        try {
            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $dbHost, $dbName);
            $pdo = new PDO($dsn, $dbUser, $dbPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            $sql = file_get_contents(__DIR__ . '/database.sql');
            $statements = array_filter(array_map('trim', preg_split('/;\s*\n/', $sql)));
            foreach ($statements as $statement) {
                if ($statement !== '') {
                    $pdo->exec($statement);
                }
            }

            $configPath = __DIR__ . '/app/Config/config.php';
            $configContent = file_get_contents($configPath);
            $replace = [
                "'host' => '" => "'host' => '$dbHost'",
                "'name' => '" => "'name' => '$dbName'",
                "'user' => '" => "'user' => '$dbUser'",
            ];
            foreach ($replace as $search => $value) {
                $configContent = preg_replace("/" . preg_quote($search, '/') . "[^']*'/", $value . "'", $configContent, 1);
            }
            $configContent = preg_replace("/'pass' => '[^']*'/", "'pass' => '$dbPass'", $configContent, 1);
            file_put_contents($configPath, $configContent);

            file_put_contents($lockFile, 'Kurulum ' . date('c') . ' tarihinde tamamlandı.');
            $success = 'Kurulum tamamlandı. Yönetim paneline <a href="public/index.php" class="underline">buradan</a> erişebilirsiniz.';
        } catch (Exception $e) {
            $error = 'Kurulum sırasında hata oluştu: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>SınıfNizam Kurulum</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="bg-white shadow-lg rounded-lg p-8 w-full max-width-screen-md" style="max-width:560px;">
    <h1 class="text-2xl font-bold text-indigo-600 mb-4">SınıfNizam Kurulum Sihirbazı</h1>
    <p class="text-sm text-gray-600 mb-6">Paylaşımlı hosting ortamınıza hoş geldiniz. Lütfen veritabanı bağlantı bilgilerinizi giriniz.</p>
    <?php if ($error): ?>
        <div class="mb-4 px-4 py-3 bg-red-100 text-red-700 rounded"><?= $error ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="mb-4 px-4 py-3 bg-green-100 text-green-700 rounded"><?= $success ?></div>
    <?php else: ?>
    <form method="POST" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Veritabanı Sunucusu</label>
            <input type="text" name="db_host" value="<?= htmlspecialchars($_POST['db_host'] ?? 'localhost', ENT_QUOTES, 'UTF-8') ?>" class="mt-1 w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Veritabanı Adı</label>
            <input type="text" name="db_name" value="<?= htmlspecialchars($_POST['db_name'] ?? 'sinifnizam', ENT_QUOTES, 'UTF-8') ?>" class="mt-1 w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Kullanıcı Adı</label>
            <input type="text" name="db_user" value="<?= htmlspecialchars($_POST['db_user'] ?? 'root', ENT_QUOTES, 'UTF-8') ?>" class="mt-1 w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Şifre</label>
            <input type="password" name="db_pass" value="<?= htmlspecialchars($_POST['db_pass'] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="mt-1 w-full border rounded px-3 py-2">
        </div>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded w-full">Kurulumu Tamamla</button>
    </form>
    <p class="text-xs text-gray-500 mt-4">Kurulum sonunda bu dosya otomatik olarak kilitlenir. Yeniden kurulum gerektiğinde install.lock dosyasını siliniz.</p>
    <?php endif; ?>
</div>
</body>
</html>
