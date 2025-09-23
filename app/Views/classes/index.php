<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-semibold">Sınıflar</h1>
    <a href="/classes/create" class="bg-indigo-600 text-white px-4 py-2 rounded">Yeni Sınıf</a>
</div>
<div class="bg-white shadow rounded">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-100 text-left">
        <tr>
            <th class="px-4 py-2">Adı</th>
            <th class="px-4 py-2">Yıl</th>
            <th class="px-4 py-2">Öğretmen</th>
            <th class="px-4 py-2">İşlemler</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($classes as $class): ?>
            <tr class="border-b">
                <td class="px-4 py-2"><?= e($class['name']) ?></td>
                <td class="px-4 py-2"><?= e($class['year']) ?></td>
                <td class="px-4 py-2"><?= e($class['teacher_name'] ?? '') ?></td>
                <td class="px-4 py-2 space-x-2">
                    <a href="/classes/<?= e($class['id']) ?>" class="text-indigo-600">Detay</a>
                    <a href="/classes/<?= e($class['id']) ?>/edit" class="text-green-600">Düzenle</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $totalPages = ceil($total / $perPage); ?>
<?php if ($totalPages > 1): ?>
    <div class="mt-4 flex space-x-2">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="/classes?page=<?= $i ?>" class="px-3 py-1 rounded <?= $page == $i ? 'bg-indigo-600 text-white' : 'bg-white border' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
<?php endif; ?>
