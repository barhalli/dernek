<form action="/sifre-sifirla" method="POST" class="space-y-4">
    <?= csrf_field() ?>
    <div>
        <label class="block text-sm font-medium text-gray-700">Kayıtlı E-posta</label>
        <input type="email" name="email" class="mt-1 w-full border rounded px-3 py-2" required>
    </div>
    <button class="w-full bg-indigo-600 text-white px-4 py-2 rounded">Sıfırlama Bağlantısı Gönder</button>
</form>
