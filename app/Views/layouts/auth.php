<?php $messages = flash_messages(); ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş - SınıfNizam</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-indigo-200 to-purple-300 min-h-screen flex items-center justify-center">
<div class="bg-white shadow-xl rounded-lg p-8 w-full max-w-md">
    <h1 class="text-2xl font-bold text-center text-indigo-600 mb-6">SınıfNizam</h1>
    <?php if (!empty($messages)): ?>
        <div class="space-y-2 mb-4">
            <?php foreach ($messages as $type => $items): ?>
                <?php foreach ($items as $message): ?>
                    <div class="px-4 py-2 text-sm rounded <?= $type === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>"><?= e($message) ?></div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?= $content ?>
</div>
</body>
</html>
