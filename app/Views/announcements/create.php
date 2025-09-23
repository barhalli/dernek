<h1 class="text-2xl font-semibold mb-4">Yeni Duyuru</h1>
<form action="/announcements" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded p-4 space-y-4">
    <?= csrf_field() ?>
    <div>
        <label class="block text-sm font-medium">Hedef Sınıf</label>
        <select name="class_id" class="mt-1 w-full border rounded px-3 py-2">
            <option value="">Tüm sınıflar</option>
            <?php foreach ($classes as $class): ?>
                <option value="<?= e($class['id']) ?>"><?= e($class['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium">Başlık</label>
        <input type="text" name="title" class="mt-1 w-full border rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block text-sm font-medium">Duyuru Metni</label>
        <textarea name="body" rows="5" class="mt-1 w-full border rounded px-3 py-2" required></textarea>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">Yayın Başlangıcı</label>
            <input type="datetime-local" name="visible_from" class="mt-1 w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium">Yayın Bitişi</label>
            <input type="datetime-local" name="visible_to" class="mt-1 w-full border rounded px-3 py-2">
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium">Ek Dosya</label>
        <input type="file" name="attachment" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg" class="mt-1">
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded">Kaydet</button>
</form>
