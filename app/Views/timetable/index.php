<h1 class="text-2xl font-semibold mb-4">Ders Programı</h1>
<form method="GET" class="mb-4 flex space-x-2">
    <select name="class" class="border rounded px-3 py-2">
        <option value="">Sınıf Seçin</option>
        <?php foreach ($classes as $class): ?>
            <option value="<?= e($class['id']) ?>" <?= $classId == $class['id'] ? 'selected' : '' ?>><?= e($class['name']) ?></option>
        <?php endforeach; ?>
    </select>
    <button class="bg-gray-200 px-3 py-2 rounded">Getir</button>
</form>
<div class="bg-white shadow rounded p-4">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-100 text-left">
        <tr>
            <th class="px-4 py-2">Gün</th>
            <th class="px-4 py-2">Ders</th>
            <th class="px-4 py-2">Saat</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($entries as $entry): ?>
            <tr class="border-b">
                <td class="px-4 py-2"><?= e($entry['weekday']) ?></td>
                <td class="px-4 py-2"><?= e($entry['subject_name']) ?></td>
                <td class="px-4 py-2"><?= e(substr($entry['start_time'],0,5)) ?> - <?= e(substr($entry['end_time'],0,5)) ?></td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($entries)): ?>
            <tr><td colspan="3" class="px-4 py-4 text-center text-gray-500">Program bulunamadı.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
