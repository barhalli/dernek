<?php include __DIR__ . '/layout/header.php';

$notice = '';
$settings = $pdo ? fetch_settings($pdo) : ($siteData['settings'] ?? []);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo) {
    foreach ($_POST['settings'] as $key => $value) {
        $stmt = $pdo->prepare('INSERT INTO site_settings (setting_key, setting_value) VALUES (:key, :val) ON DUPLICATE KEY UPDATE setting_value = :val');
        $stmt->execute([
            ':key' => sanitize($key),
            ':val' => trim($value),
        ]);
    }
    $settings = fetch_settings($pdo);
    $notice = 'Ayarlar güncellendi.';
}
?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h4 mb-1">Site Ayarları</h1>
        <p class="text-muted mb-0">Ana sayfa kahraman, iletişim ve galeri içeriklerini yönetin.</p>
    </div>
</div>
<?php if ($notice): ?>
    <div class="alert alert-success"><?= $notice; ?></div>
<?php endif; ?>
<?php if (!$pdo): ?>
    <div class="alert alert-warning">Veritabanı bağlantısı yok. Ayarlar örnek verilerden okunuyor.</div>
<?php endif; ?>
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="card-title">Hero ve Üst Bilgi</h5>
        <form method="post" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Hero Başlık</label>
                <input type="text" class="form-control" name="settings[hero_headline]" value="<?= sanitize($settings['hero_headline'] ?? ''); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Hero Etiket</label>
                <input type="text" class="form-control" name="settings[hero_tagline]" value="<?= sanitize($settings['hero_tagline'] ?? ''); ?>" required>
            </div>
            <div class="col-12">
                <label class="form-label">Hero Açıklama</label>
                <textarea class="form-control" name="settings[hero_subtitle]" rows="2" required><?= sanitize($settings['hero_subtitle'] ?? ''); ?></textarea>
            </div>
            <div class="col-md-3">
                <label class="form-label">Birincil CTA Metni</label>
                <input type="text" class="form-control" name="settings[hero_primary_cta]" value="<?= sanitize($settings['hero_primary_cta'] ?? ''); ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Birincil CTA Link</label>
                <input type="text" class="form-control" name="settings[hero_primary_link]" value="<?= sanitize($settings['hero_primary_link'] ?? ''); ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">İkincil CTA Metni</label>
                <input type="text" class="form-control" name="settings[hero_secondary_cta]" value="<?= sanitize($settings['hero_secondary_cta'] ?? ''); ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">İkincil CTA Link</label>
                <input type="text" class="form-control" name="settings[hero_secondary_link]" value="<?= sanitize($settings['hero_secondary_link'] ?? ''); ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Telefon</label>
                <input type="text" class="form-control" name="settings[info_phone]" value="<?= sanitize($settings['info_phone'] ?? ''); ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">E-posta</label>
                <input type="text" class="form-control" name="settings[info_email]" value="<?= sanitize($settings['info_email'] ?? ''); ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Adres</label>
                <input type="text" class="form-control" name="settings[info_address]" value="<?= sanitize($settings['info_address'] ?? ''); ?>" required>
            </div>
            <div class="col-12">
                <label class="form-label">Topbar Notu</label>
                <input type="text" class="form-control" name="settings[topbar_note]" value="<?= sanitize($settings['topbar_note'] ?? ''); ?>" required>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Kaydet</button>
            </div>
        </form>
    </div>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="card-title">Galeri</h5>
        <form method="post" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Hero Görseli</label>
                <input type="url" class="form-control" name="settings[gallery_primary]" value="<?= sanitize($settings['gallery_primary'] ?? ''); ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Video/İkincil</label>
                <input type="url" class="form-control" name="settings[gallery_secondary]" value="<?= sanitize($settings['gallery_secondary'] ?? ''); ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Üçüncü Görsel</label>
                <input type="url" class="form-control" name="settings[gallery_tertiary]" value="<?= sanitize($settings['gallery_tertiary'] ?? ''); ?>" required>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Güncelle</button>
            </div>
        </form>
    </div>
</div>
<?php include __DIR__ . '/layout/footer.php';
