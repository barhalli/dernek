<h1 class="text-2xl font-semibold mb-4">Not Raporu</h1>
<form method="GET" class="mb-4 flex flex-wrap gap-2">
    <select name="class" class="border rounded px-3 py-2">
        <option value="">Sınıf Seçin</option>
        <?php foreach ($classes as $class): ?>
            <option value="<?= e($class['id']) ?>" <?= ($classId ?? null) == $class['id'] ? 'selected' : '' ?>><?= e($class['name']) ?></option>
        <?php endforeach; ?>
    </select>
    <?php if ($classId): ?>
        <select name="assessment" class="border rounded px-3 py-2">
            <option value="">Değerlendirme</option>
            <?php foreach ($assessments as $assessment): ?>
                <option value="<?= e($assessment['id']) ?>" <?= ($assessmentId ?? null) == $assessment['id'] ? 'selected' : '' ?>><?= e($assessment['title']) ?></option>
            <?php endforeach; ?>
        </select>
    <?php endif; ?>
    <button class="bg-gray-200 px-4 py-2 rounded">Getir</button>
</form>
<?php if (!empty($records)): ?>
    <div class="bg-white shadow rounded p-4 mb-4">
        <p>Ortalama: <?= e(number_format($stats['average'] ?? 0, 2)) ?> · Medyan: <?= e($stats['median'] ?? 0) ?> · Min: <?= e($stats['min_score'] ?? 0) ?> · Max: <?= e($stats['max_score'] ?? 0) ?> · Öğrenci: <?= e($stats['count'] ?? 0) ?></p>
    </div>
    <div class="bg-white shadow rounded p-4 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Öğrenci</th>
                <th class="px-4 py-2">Not</th>
                <th class="px-4 py-2">Notu</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($records as $row): ?>
                <tr class="border-b">
                    <td class="px-4 py-2"><?= e($row['first_name'] . ' ' . $row['last_name']) ?></td>
                    <td class="px-4 py-2"><?= e($row['score']) ?></td>
                    <td class="px-4 py-2"><?= e($row['note']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <canvas id="gradeChart" class="mt-6"></canvas>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('gradeChart');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?= json_encode(array_column($records, 'first_name')) ?>,
                    datasets: [{label: 'Not', data: <?= json_encode(array_column($records, 'score')) ?>, borderColor: '#6366f1', tension: 0.3}]
                },
                options: {responsive: true}
            });
        });
    </script>
<?php else: ?>
    <p class="text-sm text-gray-500">Rapor için sınıf ve değerlendirme seçiniz.</p>
<?php endif; ?>
