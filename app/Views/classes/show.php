<h1 class="text-2xl font-semibold mb-4"><?= e($class['name']) ?> - Detay</h1>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <section class="bg-white shadow rounded p-4">
        <h2 class="text-lg font-semibold mb-2">Öğrenciler</h2>
        <ul class="space-y-2 max-h-64 overflow-y-auto">
            <?php foreach ($students as $student): ?>
                <li class="border rounded px-3 py-2 flex justify-between">
                    <span><?= e($student['first_name'] . ' ' . $student['last_name']) ?></span>
                    <a href="/students/<?= e($student['id']) ?>" class="text-sm text-indigo-600">Profili</a>
                </li>
            <?php endforeach; ?>
            <?php if (empty($students)): ?>
                <li class="text-sm text-gray-500">Bu sınıfta öğrenci bulunmuyor.</li>
            <?php endif; ?>
        </ul>
    </section>
    <section class="bg-white shadow rounded p-4">
        <h2 class="text-lg font-semibold mb-2">Haftalık Program</h2>
        <ul class="space-y-2 max-h-64 overflow-y-auto">
            <?php foreach ($schedule as $item): ?>
                <li class="border rounded px-3 py-2">
                    <div class="font-medium"><?= e($item['subject_name'] ?? 'Ders') ?> · Gün: <?= e($item['weekday']) ?></div>
                    <div class="text-sm text-gray-600"><?= e(substr($item['start_time'],0,5)) ?> - <?= e(substr($item['end_time'],0,5)) ?></div>
                </li>
            <?php endforeach; ?>
            <?php if (empty($schedule)): ?>
                <li class="text-sm text-gray-500">Program bilgisi bulunmuyor.</li>
            <?php endif; ?>
        </ul>
    </section>
</div>
