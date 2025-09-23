<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-semibold">Öğrenciler</h1>
    <a href="/students/import" class="bg-indigo-600 text-white px-4 py-2 rounded">Toplu İçe Aktar</a>
</div>
<form method="GET" class="mb-4 flex space-x-2">
    <select name="class" class="border rounded px-3 py-2">
        <option value="">Tüm Sınıflar</option>
        <?php foreach ($classes as $class): ?>
            <option value="<?= e($class['id']) ?>" <?= $selectedClass == $class['id'] ? 'selected' : '' ?>><?= e($class['name']) ?></option>
        <?php endforeach; ?>
    </select>
    <button class="bg-gray-200 px-3 py-2 rounded">Filtrele</button>
</form>
<div class="bg-white shadow rounded">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-100 text-left">
        <tr>
            <th class="px-4 py-2">No</th>
            <th class="px-4 py-2">Ad Soyad</th>
            <th class="px-4 py-2">Sınıf</th>
            <th class="px-4 py-2"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($students as $student): ?>
            <tr class="border-b">
                <td class="px-4 py-2"><?= e($student['number']) ?></td>
                <td class="px-4 py-2"><?= e($student['first_name'] . ' ' . $student['last_name']) ?></td>
                <td class="px-4 py-2"><?= e($student['class_name'] ?? '-') ?></td>
                <td class="px-4 py-2 text-right"><a href="/students/<?= e($student['id']) ?>" class="text-indigo-600">Görüntüle</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $totalPages = ceil($total / $perPage); ?>
<?php if ($totalPages > 1): ?>
    <div class="mt-4 flex space-x-2">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="/students?page=<?= $i ?>&class=<?= e($selectedClass) ?>" class="px-3 py-1 rounded <?= $page == $i ? 'bg-indigo-600 text-white' : 'bg-white border' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
<?php endif; ?>
