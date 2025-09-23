<h1 class="text-2xl font-semibold mb-4">Dosya Yönetimi</h1>
<form action="/files" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded p-4 space-y-4 mb-6">
    <?= csrf_field() ?>
    <div>
        <label class="block text-sm font-medium">Dosya</label>
        <input type="file" name="file" class="mt-1" required>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">İlişkili Sınıf</label>
            <select name="class_id" class="mt-1 w-full border rounded px-3 py-2">
                <option value="">Genel</option>
                <?php foreach ($classes as $class): ?>
                    <option value="<?= e($class['id']) ?>"><?= e($class['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium">Görünürlük</label>
            <select name="visibility" class="mt-1 w-full border rounded px-3 py-2">
                <option value="private">Sadece ben</option>
                <option value="class">Sınıf üyeleri</option>
                <option value="public">Tüm kullanıcılar</option>
            </select>
        </div>
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded">Yükle</button>
</form>
<div class="bg-white shadow rounded overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-100 text-left">
        <tr>
            <th class="px-4 py-2">Dosya</th>
            <th class="px-4 py-2">Sınıf</th>
            <th class="px-4 py-2">Boyut</th>
            <th class="px-4 py-2">Görünürlük</th>
            <th class="px-4 py-2"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($files as $file): ?>
            <tr class="border-b">
                <td class="px-4 py-2"><?= e($file['filename']) ?></td>
                <td class="px-4 py-2"><?= e($file['class_name'] ?? '-') ?></td>
                <td class="px-4 py-2"><?= number_format($file['size'] / 1024, 1) ?> KB</td>
                <td class="px-4 py-2"><?= e($file['visibility']) ?></td>
                <td class="px-4 py-2 text-right"><a href="/files/download?path=<?= e($file['path']) ?>" class="text-indigo-600">İndir</a></td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($files)): ?>
            <tr><td colspan="5" class="px-4 py-4 text-center text-gray-500">Dosya bulunamadı.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
