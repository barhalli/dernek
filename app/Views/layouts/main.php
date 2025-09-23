<?php
$messages = flash_messages();
$user = current_user();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title><?= e(config('app_name')) ?> - Yönetim</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="<?= asset('app.css') ?>">
    <script src="<?= asset('app.js') ?>" defer></script>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex">
    <aside class="w-64 bg-white shadow-lg min-h-screen hidden md:block">
        <div class="p-6 border-b">
            <h1 class="text-xl font-bold text-indigo-600">SınıfNizam</h1>
            <p class="text-sm text-gray-500">Merhaba, <?= e($user['name'] ?? '') ?></p>
        </div>
        <nav class="p-4 space-y-2">
            <a href="/" class="block px-3 py-2 rounded hover:bg-indigo-50">Gösterge Paneli</a>
            <a href="/classes" class="block px-3 py-2 rounded hover:bg-indigo-50">Sınıflar</a>
            <a href="/students" class="block px-3 py-2 rounded hover:bg-indigo-50">Öğrenciler</a>
            <a href="/attendance/take" class="block px-3 py-2 rounded hover:bg-indigo-50">Yoklama</a>
            <a href="/grades" class="block px-3 py-2 rounded hover:bg-indigo-50">Notlar</a>
            <a href="/announcements" class="block px-3 py-2 rounded hover:bg-indigo-50">Duyurular</a>
            <a href="/timetable" class="block px-3 py-2 rounded hover:bg-indigo-50">Ders Programı</a>
            <a href="/reports" class="block px-3 py-2 rounded hover:bg-indigo-50">Raporlar</a>
            <a href="/files" class="block px-3 py-2 rounded hover:bg-indigo-50">Dosyalar</a>
            <a href="/messages" class="block px-3 py-2 rounded hover:bg-indigo-50">Mesajlar</a>
            <a href="/settings" class="block px-3 py-2 rounded hover:bg-indigo-50">Ayarlar</a>
        </nav>
    </aside>
    <div class="flex-1">
        <header class="bg-white shadow px-4 py-3 flex justify-between items-center">
            <button class="md:hidden" onclick="document.querySelector('aside').classList.toggle('hidden')">☰</button>
            <h2 class="text-lg font-semibold">Yönetim Paneli</h2>
            <form action="/logout" method="POST" class="inline">
                <?= csrf_field() ?>
                <button class="text-sm text-red-500 hover:text-red-700">Çıkış</button>
            </form>
        </header>
        <main class="p-6">
            <?php if (!empty($messages)): ?>
                <div class="space-y-2 mb-4">
                    <?php foreach ($messages as $type => $items): ?>
                        <?php foreach ($items as $message): ?>
                            <div data-alert class="border-l-4 px-4 py-2 flex justify-between items-center <?= $type === 'success' ? 'border-green-500 bg-green-50 text-green-800' : ($type === 'error' ? 'border-red-500 bg-red-50 text-red-800' : 'border-yellow-500 bg-yellow-50 text-yellow-800') ?>">
                                <span><?= e($message) ?></span>
                                <button data-close class="text-sm">Kapat</button>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?= $content ?>
        </main>
    </div>
</div>
</body>
</html>
