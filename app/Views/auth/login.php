<form action="/login" method="POST" class="space-y-4">
    <?= csrf_field() ?>
    <div>
        <label class="block text-sm font-medium text-gray-700">E-posta</label>
        <input type="email" name="email" class="mt-1 w-full border rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Şifre</label>
        <input type="password" name="password" class="mt-1 w-full border rounded px-3 py-2" required>
    </div>
    <div class="flex justify-between items-center">
        <a href="/sifre-sifirla" class="text-sm text-indigo-600">Şifremi unuttum</a>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded">Giriş Yap</button>
    </div>
</form>
