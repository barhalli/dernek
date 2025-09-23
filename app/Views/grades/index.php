<h1 class="text-2xl font-semibold mb-4">Değerlendirmeler</h1>
<form method="GET" class="mb-4 flex space-x-2">
    <select name="class" class="border rounded px-3 py-2">
        <option value="">Sınıf Seçin</option>
        <?php foreach ($classes as $class): ?>
            <option value="<?= e($class['id']) ?>" <?= $classId == $class['id'] ? 'selected' : '' ?>><?= e($class['name']) ?></option>
        <?php endforeach; ?>
    </select>
    <button class="bg-gray-200 px-3 py-2 rounded">Getir</button>
    <?php if ($classId): ?>
        <a href="/grades/enter?class=<?= e($classId) ?>" class="bg-indigo-600 text-white px-4 py-2 rounded">Not Girişi</a>
    <?php endif; ?>
</form>
<div class="bg-white shadow rounded">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-100 text-left">
        <tr>
            <th class="px-4 py-2">Başlık</th>
            <th class="px-4 py-2">Tür</th>
            <th class="px-4 py-2">Tarih</th>
            <th class="px-4 py-2">Max Puan</th>
            <th class="px-4 py-2"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($assessments as $assessment): ?>
            <tr class="border-b">
                <td class="px-4 py-2"><?= e($assessment['title']) ?></td>
                <td class="px-4 py-2"><?= e($assessment['type']) ?></td>
                <td class="px-4 py-2"><?= e($assessment['date']) ?></td>
                <td class="px-4 py-2"><?= e($assessment['max_score']) ?></td>
                <td class="px-4 py-2 text-right">
                    <a href="/grades/enter?class=<?= e($assessment['class_id']) ?>&assessment=<?= e($assessment['id']) ?>" class="text-indigo-600 mr-2">Not Gir</a>
                    <a href="/grades/export?assessment=<?= e($assessment['id']) ?>" class="text-green-600">Dışa Aktar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($assessments)): ?>
            <tr><td colspan="5" class="px-4 py-4 text-center text-gray-500">Değerlendirme bulunamadı.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
