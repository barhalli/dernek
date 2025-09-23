<h1 class="text-2xl font-semibold mb-4">Sınıfı Düzenle</h1>
<form action="/classes/<?= e($class['id']) ?>/update" method="POST" class="bg-white shadow rounded p-4 space-y-4">
    <?= csrf_field() ?>
    <div>
        <label class="block text-sm font-medium">Adı</label>
        <input type="text" name="name" value="<?= e($class['name']) ?>" class="mt-1 w-full border rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block text-sm font-medium">Düzey</label>
        <input type="text" name="grade_level" value="<?= e($class['grade_level']) ?>" class="mt-1 w-full border rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block text-sm font-medium">Yıl</label>
        <input type="text" name="year" value="<?= e($class['year']) ?>" class="mt-1 w-full border rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block text-sm font-medium">Sorumlu Öğretmen</label>
        <select name="teacher_id" class="mt-1 w-full border rounded px-3 py-2">
            <?php foreach ($teachers as $teacher): ?>
                <option value="<?= e($teacher['id']) ?>" <?= $teacher['id'] == $class['teacher_id'] ? 'selected' : '' ?>><?= e($teacher['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded">Güncelle</button>
</form>
