<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-semibold">Mesajlar</h1>
    <div class="space-x-2">
        <a href="/messages" class="px-3 py-2 rounded <?= empty($sent) ? 'bg-indigo-600 text-white' : 'bg-white border' ?>">Gelen Kutusu</a>
        <a href="/messages/sent" class="px-3 py-2 rounded <?= !empty($sent) ? 'bg-indigo-600 text-white' : 'bg-white border' ?>">Gönderilenler</a>
        <a href="/messages/compose" class="bg-green-600 text-white px-4 py-2 rounded">Yeni Mesaj</a>
    </div>
</div>
<div class="bg-white shadow rounded">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-100 text-left">
        <tr>
            <th class="px-4 py-2">Konu</th>
            <th class="px-4 py-2">Gönderen/Alıcı</th>
            <th class="px-4 py-2">Tarih</th>
            <th class="px-4 py-2"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($messages as $message): ?>
            <tr class="border-b">
                <td class="px-4 py-2"><?= e($message['subject']) ?></td>
                <td class="px-4 py-2"><?= e($message['from_name'] ?? $message['to_name'] ?? '') ?></td>
                <td class="px-4 py-2"><?= e($message['created_at']) ?></td>
                <td class="px-4 py-2 text-right"><a href="/messages/<?= e($message['id']) ?>" class="text-indigo-600">Görüntüle</a></td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($messages)): ?>
            <tr><td colspan="4" class="px-4 py-4 text-center text-gray-500">Mesaj bulunamadı.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
