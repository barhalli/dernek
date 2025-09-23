<h1 class="text-2xl font-semibold mb-4">Yeni Mesaj</h1>
<form action="/messages" method="POST" class="bg-white shadow rounded p-4 space-y-4">
    <?= csrf_field() ?>
    <div>
        <label class="block text-sm font-medium">Alıcı</label>
        <select name="to_user_id" class="mt-1 w-full border rounded px-3 py-2" required>
            <?php foreach ($users as $recipient): ?>
                <option value="<?= e($recipient['id']) ?>"><?= e($recipient['name']) ?> (<?= e($recipient['role']) ?>)</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium">Sınıf (opsiyonel)</label>
        <select name="class_id" class="mt-1 w-full border rounded px-3 py-2">
            <option value="">Seçilmedi</option>
            <?php foreach ($classes as $class): ?>
                <option value="<?= e($class['id']) ?>"><?= e($class['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium">Konu</label>
        <input type="text" name="subject" class="mt-1 w-full border rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block text-sm font-medium">Mesaj</label>
        <textarea name="body" rows="6" class="mt-1 w-full border rounded px-3 py-2" required></textarea>
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded">Gönder</button>
</form>
