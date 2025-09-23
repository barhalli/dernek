<h1 class="text-2xl font-semibold mb-4">Mesaj Konusu</h1>
<div class="space-y-4">
    <?php foreach ($thread as $message): ?>
        <article class="bg-white shadow rounded p-4">
            <div class="flex justify-between text-sm text-gray-500 mb-2">
                <span><?= e($message['from_name']) ?> → <?= e($message['to_name']) ?></span>
                <span><?= e($message['created_at']) ?></span>
            </div>
            <h2 class="text-lg font-semibold mb-2"><?= e($message['subject']) ?></h2>
            <p class="text-sm text-gray-700"><?= nl2br(e($message['body'])) ?></p>
        </article>
    <?php endforeach; ?>
</div>
<div class="mt-6 bg-white shadow rounded p-4">
    <h2 class="text-lg font-semibold mb-2">Yanıtla</h2>
    <form action="/messages" method="POST" class="space-y-4">
        <?= csrf_field() ?>
        <input type="hidden" name="to_user_id" value="<?= e($thread[count($thread)-1]['from_user_id']) ?>">
        <input type="hidden" name="parent_id" value="<?= e($thread[0]['id']) ?>">
        <div>
            <label class="block text-sm font-medium">Konu</label>
            <input type="text" name="subject" value="RE: <?= e($thread[0]['subject']) ?>" class="mt-1 w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium">Mesaj</label>
            <textarea name="body" rows="4" class="mt-1 w-full border rounded px-3 py-2" required></textarea>
        </div>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded">Gönder</button>
    </form>
</div>
