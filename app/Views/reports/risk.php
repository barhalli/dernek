<h1 class="text-2xl font-semibold mb-4">Riskli Öğrenciler</h1>
<form method="GET" class="mb-4 flex flex-wrap gap-2">
    <select name="class" class="border rounded px-3 py-2">
        <option value="">Sınıf Seçin</option>
        <?php foreach ($classes as $class): ?>
            <option value="<?= e($class['id']) ?>" <?= ($classId ?? null) == $class['id'] ? 'selected' : '' ?>><?= e($class['name']) ?></option>
        <?php endforeach; ?>
    </select>
    <input type="number" name="threshold" value="<?= e($threshold ?? 50) ?>" class="border rounded px-3 py-2" placeholder="Not eşiği">
    <input type="number" name="absence" value="<?= e($absenceLimit ?? 5) ?>" class="border rounded px-3 py-2" placeholder="Devamsızlık">
    <button class="bg-gray-200 px-4 py-2 rounded">Getir</button>
</form>
<div class="bg-white shadow rounded p-4">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-100 text-left">
        <tr>
            <th class="px-4 py-2">Öğrenci</th>
            <th class="px-4 py-2">Ortalama</th>
            <th class="px-4 py-2">Devamsızlık</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($risks as $risk): ?>
            <tr class="border-b">
                <td class="px-4 py-2"><?= e($risk['name']) ?></td>
                <td class="px-4 py-2"><?= e($risk['average']) ?></td>
                <td class="px-4 py-2"><?= e($risk['absent']) ?></td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($risks)): ?>
            <tr><td colspan="3" class="px-4 py-4 text-center text-gray-500">Riskli öğrenci bulunamadı.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
