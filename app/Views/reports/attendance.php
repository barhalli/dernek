<h1 class="text-2xl font-semibold mb-4">Devamsızlık Raporu</h1>
<form method="GET" class="mb-4 flex flex-wrap gap-2">
    <select name="class" class="border rounded px-3 py-2">
        <option value="">Sınıf Seçin</option>
        <?php foreach ($classes as $class): ?>
            <option value="<?= e($class['id']) ?>" <?= ($classId ?? null) == $class['id'] ? 'selected' : '' ?>><?= e($class['name']) ?></option>
        <?php endforeach; ?>
    </select>
    <input type="date" name="start" value="<?= e($start ?? '') ?>" class="border rounded px-3 py-2">
    <input type="date" name="end" value="<?= e($end ?? '') ?>" class="border rounded px-3 py-2">
    <button class="bg-gray-200 px-4 py-2 rounded">Filtrele</button>
</form>
<?php if (!empty($summary)): ?>
    <div class="bg-white shadow rounded p-4 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Öğrenci</th>
                <th class="px-4 py-2">Katıldı</th>
                <th class="px-4 py-2">Geç</th>
                <th class="px-4 py-2">Yok</th>
                <th class="px-4 py-2">İzinli</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($summary as $item): ?>
                <tr class="border-b">
                    <td class="px-4 py-2"><?= e($item['name']) ?></td>
                    <td class="px-4 py-2"><?= e($item['Present']) ?></td>
                    <td class="px-4 py-2"><?= e($item['Late']) ?></td>
                    <td class="px-4 py-2"><?= e($item['Absent']) ?></td>
                    <td class="px-4 py-2"><?= e($item['Excused']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <canvas id="attendanceChart" class="mt-6"></canvas>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('attendanceChart');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode(array_column($summary, 'name')) ?>,
                    datasets: [
                        {label: 'Katıldı', data: <?= json_encode(array_column($summary, 'Present')) ?>, backgroundColor: '#4ade80'},
                        {label: 'Yok', data: <?= json_encode(array_column($summary, 'Absent')) ?>, backgroundColor: '#f87171'},
                    ]
                },
                options: {responsive: true, scales: {x: {stacked: true}, y: {stacked: true}}}
            });
        });
    </script>
<?php else: ?>
    <p class="text-sm text-gray-500">Veri bulunamadı. Filtre seçin.</p>
<?php endif; ?>
