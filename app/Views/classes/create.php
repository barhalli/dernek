<h1 class="text-2xl font-semibold mb-4">Yeni Sınıf</h1>
<form action="/classes" method="POST" class="bg-white shadow rounded p-4 space-y-4">
    <?= csrf_field() ?>
    <div>
        <label class="block text-sm font-medium">Adı</label>
        <input type="text" name="name" class="mt-1 w-full border rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block text-sm font-medium">Düzey</label>
        <input type="text" name="grade_level" class="mt-1 w-full border rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block text-sm font-medium">Yıl</label>
        <input type="text" name="year" value="<?= date('Y') ?>" class="mt-1 w-full border rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block text-sm font-medium">Sorumlu Öğretmen</label>
        <select name="teacher_id" class="mt-1 w-full border rounded px-3 py-2">
            <?php foreach ($teachers as $teacher): ?>
                <option value="<?= e($teacher['id']) ?>"><?= e($teacher['name']) ?> - <?= e($teacher['role']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded">Kaydet</button>
</form>
