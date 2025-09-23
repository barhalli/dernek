<form action="/sifre-yenile" method="POST" class="space-y-4">
    <?= csrf_field() ?>
    <input type="hidden" name="token" value="<?= e($token ?? '') ?>">
    <div>
        <label class="block text-sm font-medium text-gray-700">Yeni Şifre</label>
        <input type="password" name="password" class="mt-1 w-full border rounded px-3 py-2" required>
    </div>
    <button class="w-full bg-indigo-600 text-white px-4 py-2 rounded">Şifreyi Güncelle</button>
</form>
