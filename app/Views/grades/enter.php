<h1 class="text-2xl font-semibold mb-4">Not Girişi</h1>
<form method="GET" class="mb-4 flex space-x-2">
    <select name="class" class="border rounded px-3 py-2">
        <option value="">Sınıf Seçin</option>
        <?php foreach ($classes as $class): ?>
            <option value="<?= e($class['id']) ?>" <?= $classId == $class['id'] ? 'selected' : '' ?>><?= e($class['name']) ?></option>
        <?php endforeach; ?>
    </select>
    <?php if ($classId): ?>
        <select name="assessment" class="border rounded px-3 py-2">
            <option value="">Değerlendirme</option>
            <?php foreach ($assessments as $assessment): ?>
                <option value="<?= e($assessment['id']) ?>" <?= ($selectedAssessment['id'] ?? null) == $assessment['id'] ? 'selected' : '' ?>><?= e($assessment['title']) ?></option>
            <?php endforeach; ?>
        </select>
    <?php endif; ?>
    <button class="bg-gray-200 px-3 py-2 rounded">Getir</button>
</form>
<?php if ($selectedAssessment): ?>
    <div class="bg-white shadow rounded p-4 mb-4">
        <p><span class="font-medium">Değerlendirme:</span> <?= e($selectedAssessment['title']) ?> | Max Puan: <?= e($selectedAssessment['max_score']) ?></p>
        <a href="/grades/export?assessment=<?= e($selectedAssessment['id']) ?>" class="text-indigo-600 text-sm">Dışa aktar</a>
    </div>
    <form action="/grades/enter" method="POST" class="bg-white shadow rounded p-4">
        <?= csrf_field() ?>
        <input type="hidden" name="assessment_id" value="<?= e($selectedAssessment['id']) ?>">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Öğrenci</th>
                <th class="px-4 py-2">Not</th>
                <th class="px-4 py-2">Notu</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($students as $student): ?>
                <?php $record = $existing[$student['id']] ?? null; ?>
                <tr class="border-b">
                    <td class="px-4 py-2"><?= e($student['first_name'] . ' ' . $student['last_name']) ?></td>
                    <td class="px-4 py-2">
                        <input type="number" step="0.01" name="score[<?= e($student['id']) ?>]" value="<?= e($record['score'] ?? '') ?>" class="border rounded px-2 py-1" min="0" max="<?= e($selectedAssessment['max_score']) ?>">
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" name="note[<?= e($student['id']) ?>]" value="<?= e($record['note'] ?? '') ?>" class="border rounded px-2 py-1 w-full">
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded">Kaydet</button>
    </form>
<?php endif; ?>
