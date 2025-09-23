<h1 class="text-2xl font-semibold mb-4">Öğrenci İçe Aktarma</h1>
<form action="/students/import" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded p-4 space-y-4">
    <?= csrf_field() ?>
    <div>
        <label class="block text-sm font-medium">Sınıf</label>
        <select name="class_id" class="mt-1 w-full border rounded px-3 py-2" required>
            <?php foreach ($classes as $class): ?>
                <option value="<?= e($class['id']) ?>"><?= e($class['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium">CSV/XLSX Dosyası</label>
        <input type="file" name="file" accept=".csv,.xlsx" class="mt-1 w-full" required>
        <p class="text-xs text-gray-500 mt-1">Format: Ad;Soyad;Numara;Doğum Tarihi;Cinsiyet</p>
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded">İçe Aktar</button>
</form>
