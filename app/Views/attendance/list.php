<h1 class="text-2xl font-semibold mb-4">Yoklama Kayıtları</h1>
<form method="GET" class="flex space-x-2 mb-4">
    <select name="class" class="border rounded px-3 py-2">
        <option value="">Sınıf Seçin</option>
        <?php foreach ($classes as $class): ?>
            <option value="<?= e($class['id']) ?>" <?= $classId == $class['id'] ? 'selected' : '' ?>><?= e($class['name']) ?></option>
        <?php endforeach; ?>
    </select>
    <input type="date" name="start" value="<?= e($start) ?>" class="border rounded px-3 py-2">
    <input type="date" name="end" value="<?= e($end) ?>" class="border rounded px-3 py-2">
    <button class="bg-gray-200 px-4 py-2 rounded">Filtrele</button>
    <?php if ($classId): ?>
        <a href="/attendance/export?class=<?= e($classId) ?>&start=<?= e($start) ?>&end=<?= e($end) ?>&format=csv" class="bg-indigo-600 text-white px-4 py-2 rounded">CSV</a>
        <a href="/attendance/export?class=<?= e($classId) ?>&start=<?= e($start) ?>&end=<?= e($end) ?>&format=pdf" class="bg-purple-600 text-white px-4 py-2 rounded">PDF</a>
    <?php endif; ?>
</form>
<div class="bg-white shadow rounded overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-100 text-left">
        <tr>
            <th class="px-4 py-2">Öğrenci</th>
            <th class="px-4 py-2">Tarih</th>
            <th class="px-4 py-2">Durum</th>
            <th class="px-4 py-2">Not</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($records as $record): ?>
            <tr class="border-b">
                <td class="px-4 py-2"><?= e($record['first_name'] . ' ' . $record['last_name']) ?></td>
                <td class="px-4 py-2"><?= e($record['date']) ?></td>
                <td class="px-4 py-2"><?= e($record['status']) ?></td>
                <td class="px-4 py-2"><?= e($record['note']) ?></td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($records)): ?>
            <tr><td colspan="4" class="px-4 py-4 text-center text-gray-500">Kayıt bulunamadı.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
