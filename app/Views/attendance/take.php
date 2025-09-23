<h1 class="text-2xl font-semibold mb-4">Yoklama Al</h1>
<form method="GET" class="flex space-x-2 mb-4">
    <select name="class" class="border rounded px-3 py-2">
        <option value="">Sınıf Seçin</option>
        <?php foreach ($classes as $class): ?>
            <option value="<?= e($class['id']) ?>" <?= $classId == $class['id'] ? 'selected' : '' ?>><?= e($class['name']) ?></option>
        <?php endforeach; ?>
    </select>
    <input type="date" name="date" value="<?= e($date) ?>" class="border rounded px-3 py-2">
    <button class="bg-gray-200 px-4 py-2 rounded">Getir</button>
</form>
<?php if ($classId): ?>
    <form action="/attendance/take" method="POST" class="bg-white shadow rounded p-4 space-y-4">
        <?= csrf_field() ?>
        <input type="hidden" name="class_id" value="<?= e($classId) ?>">
        <input type="hidden" name="date" value="<?= e($date) ?>">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Öğrenci</th>
                <th class="px-4 py-2">Durum</th>
                <th class="px-4 py-2">Not</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($students as $student): ?>
                <?php $record = $existing[$student['id']] ?? null; ?>
                <tr class="border-b">
                    <td class="px-4 py-2"><?= e($student['first_name'] . ' ' . $student['last_name']) ?></td>
                    <td class="px-4 py-2">
                        <select name="status[<?= e($student['id']) ?>]" class="border rounded px-2 py-1">
                            <?php foreach (['Present' => 'Katıldı', 'Late' => 'Geç', 'Absent' => 'Yok', 'Excused' => 'İzinli'] as $key => $label): ?>
                                <option value="<?= $key ?>" <?= ($record['status'] ?? '') === $key ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" name="note[<?= e($student['id']) ?>]" value="<?= e($record['note'] ?? '') ?>" class="border rounded px-2 py-1 w-full">
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded">Kaydet</button>
    </form>
<?php endif; ?>
