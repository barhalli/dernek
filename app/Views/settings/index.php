<h1 class="text-2xl font-semibold mb-4">Sistem Ayarları</h1>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <form action="/settings/general" method="POST" class="bg-white shadow rounded p-4 space-y-4">
        <h2 class="text-lg font-semibold">Genel</h2>
        <?= csrf_field() ?>
        <div>
            <label class="block text-sm font-medium">Okul Yılı</label>
            <input type="text" name="school_year" value="<?= e($values['school_year']) ?>" class="mt-1 w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium">Dönem</label>
            <input type="text" name="term" value="<?= e($values['term']) ?>" class="mt-1 w-full border rounded px-3 py-2" required>
        </div>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded">Kaydet</button>
    </form>
    <form action="/settings/smtp" method="POST" class="bg-white shadow rounded p-4 space-y-4 lg:col-span-2">
        <h2 class="text-lg font-semibold">SMTP Ayarları</h2>
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Sunucu</label>
                <input type="text" name="smtp_host" value="<?= e($values['smtp_host']) ?>" class="mt-1 w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium">Port</label>
                <input type="number" name="smtp_port" value="<?= e($values['smtp_port']) ?>" class="mt-1 w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium">Kullanıcı Adı</label>
                <input type="text" name="smtp_username" value="<?= e($values['smtp_username']) ?>" class="mt-1 w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium">Şifre</label>
                <input type="password" name="smtp_password" value="<?= e($values['smtp_password']) ?>" class="mt-1 w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Şifreleme</label>
                <input type="text" name="smtp_encryption" value="<?= e($values['smtp_encryption']) ?>" class="mt-1 w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium">Gönderen E-posta</label>
                <input type="email" name="smtp_from_email" value="<?= e($values['smtp_from_email']) ?>" class="mt-1 w-full border rounded px-3 py-2" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium">Gönderen Adı</label>
                <input type="text" name="smtp_from_name" value="<?= e($values['smtp_from_name']) ?>" class="mt-1 w-full border rounded px-3 py-2">
            </div>
        </div>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded">Kaydet</button>
    </form>
</div>
<div class="mt-6 bg-white shadow rounded p-4">
    <h2 class="text-lg font-semibold mb-2">Yedekleme</h2>
    <form action="/settings/backup" method="POST" class="space-y-2">
        <?= csrf_field() ?>
        <label class="block text-sm font-medium">Yedek Türü</label>
        <select name="type" class="border rounded px-3 py-2">
            <option value="database">Veritabanı (.sql)</option>
            <option value="uploads">Dosya yüklemeleri (.zip)</option>
        </select>
        <button class="bg-green-600 text-white px-4 py-2 rounded">Yedeği İndir</button>
    </form>
</div>
