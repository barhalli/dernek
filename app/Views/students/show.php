<h1 class="text-2xl font-semibold mb-4"><?= e($student['first_name'] . ' ' . $student['last_name']) ?></h1>
<div class="bg-white shadow rounded p-4 space-y-2">
    <p><span class="font-medium">Öğrenci No:</span> <?= e($student['number']) ?></p>
    <p><span class="font-medium">Doğum Tarihi:</span> <?= e($student['birthdate']) ?></p>
    <p><span class="font-medium">Durum:</span> <?= e($student['status']) ?></p>
</div>
<div class="mt-6 bg-white shadow rounded p-4">
    <h2 class="text-lg font-semibold mb-2">Sınıf Geçmişi</h2>
    <ul class="space-y-2">
        <?php foreach ($enrollments as $enrollment): ?>
            <li class="border rounded px-3 py-2 flex justify-between">
                <span><?= e($enrollment['name']) ?></span>
                <span><?= e($enrollment['year']) ?></span>
            </li>
        <?php endforeach; ?>
        <?php if (empty($enrollments)): ?>
            <li class="text-sm text-gray-500">Kayıt bulunamadı.</li>
        <?php endif; ?>
    </ul>
</div>
