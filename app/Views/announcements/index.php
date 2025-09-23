<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-semibold">Duyurular</h1>
    <a href="/announcements/create" class="bg-indigo-600 text-white px-4 py-2 rounded">Yeni Duyuru</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <?php foreach ($announcements as $announcement): ?>
        <article class="bg-white shadow rounded p-4">
            <h2 class="text-lg font-semibold text-indigo-600"><?= e($announcement['title']) ?></h2>
            <p class="text-sm text-gray-500 mb-2">Görüntülenebilir: <?= e($announcement['visible_from']) ?></p>
            <p class="text-sm text-gray-700 mb-2"><?= nl2br(e(substr($announcement['body'], 0, 200))) ?>...</p>
            <?php if (!empty($announcement['attachment_path'])): ?>
                <a href="/files/download?path=<?= e($announcement['attachment_path']) ?>" class="text-sm text-green-600">Ek dosyayı indir</a>
            <?php endif; ?>
        </article>
    <?php endforeach; ?>
    <?php if (empty($announcements)): ?>
        <p class="text-sm text-gray-500">Duyuru bulunamadı.</p>
    <?php endif; ?>
</div>
