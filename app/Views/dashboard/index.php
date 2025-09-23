<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white shadow rounded p-4">
        <h2 class="text-lg font-semibold mb-2">Sınıflarım</h2>
        <ul class="divide-y">
            <?php foreach ($classes as $class): ?>
                <li class="py-2 flex justify-between">
                    <span><?= e($class['name']) ?> (<?= e($class['year']) ?>)</span>
                    <a href="/attendance/take?class=<?= e($class['id']) ?>" class="text-indigo-600 text-sm">Bugün yoklama al</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="bg-white shadow rounded p-4">
        <h2 class="text-lg font-semibold mb-2">Yaklaşan Etkinlikler</h2>
        <ul class="space-y-2">
            <?php foreach ($upcomingAssessments as $assessment): ?>
                <li class="border rounded px-3 py-2">
                    <div class="font-medium text-indigo-600"><?= e($assessment['title']) ?> - <?= e($assessment['class_name']) ?></div>
                    <div class="text-sm text-gray-600"><?= e($assessment['date']) ?> · <?= e($assessment['type']) ?></div>
                </li>
            <?php endforeach; ?>
            <?php if (empty($upcomingAssessments)): ?>
                <li class="text-sm text-gray-500">Yaklaşan etkinlik bulunmuyor.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white shadow rounded p-4">
        <h2 class="text-lg font-semibold mb-2">Duyurular</h2>
        <div class="space-y-3 max-h-64 overflow-y-auto">
            <?php foreach ($announcements as $announcement): ?>
                <article class="border rounded px-3 py-2">
                    <h3 class="font-medium text-indigo-600"><?= e($announcement['title']) ?></h3>
                    <p class="text-sm text-gray-600"><?= nl2br(e(substr($announcement['body'], 0, 160))) ?>...</p>
                </article>
            <?php endforeach; ?>
            <?php if (empty($announcements)): ?>
                <p class="text-sm text-gray-500">Henüz duyuru yok.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="bg-white shadow rounded p-4">
        <h2 class="text-lg font-semibold mb-2">Bugünkü Program</h2>
        <ul class="space-y-2">
            <?php foreach ($todaySchedule as $item): ?>
                <li class="border rounded px-3 py-2">
                    <div class="font-medium"><?= e($item['subject_name']) ?> (<?= e($item['class_name']) ?>)</div>
                    <div class="text-sm text-gray-600"><?= e(substr($item['start_time'], 0,5)) ?> - <?= e(substr($item['end_time'],0,5)) ?></div>
                </li>
            <?php endforeach; ?>
            <?php if (empty($todaySchedule)): ?>
                <li class="text-sm text-gray-500">Bugün ders programı bulunmuyor.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<div class="mt-6 bg-white shadow rounded p-4">
    <h2 class="text-lg font-semibold mb-4">Bugünkü Yoklama Durumu</h2>
    <?php if (!empty($todayAttendance)): ?>
        <?php foreach ($todayAttendance as $className => $records): ?>
            <h3 class="font-medium text-indigo-600 mb-2"><?= e($className) ?></h3>
            <div class="overflow-x-auto mb-4">
                <table class="min-w-full text-sm">
                    <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-2 py-1">Öğrenci</th>
                        <th class="px-2 py-1">Durum</th>
                        <th class="px-2 py-1">Not</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($records as $record): ?>
                        <tr class="border-b">
                            <td class="px-2 py-1"><?= e($record['first_name'] . ' ' . $record['last_name']) ?></td>
                            <td class="px-2 py-1"><?= e($record['status']) ?></td>
                            <td class="px-2 py-1"><?= e($record['note']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-sm text-gray-500">Bugün için yoklama kaydı bulunmuyor.</p>
    <?php endif; ?>
</div>
