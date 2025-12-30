<?php include __DIR__ . '/layout/header.php';

$notice = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        $notice = 'Veritabanı bağlantısı yok. Lütfen config ayarlarınızı kontrol edin.';
    } else {
        $action = $_POST['action'] ?? '';
        if ($action === 'create') {
            $stmt = $pdo->prepare('INSERT INTO testimonials (name, role, quote) VALUES (:name, :role, :quote)');
            $stmt->execute([
                ':name' => sanitize($_POST['name'] ?? ''),
                ':role' => sanitize($_POST['role'] ?? ''),
                ':quote' => sanitize($_POST['quote'] ?? ''),
            ]);
            $notice = 'Referans eklendi.';
        }
        if ($action === 'update') {
            $stmt = $pdo->prepare('UPDATE testimonials SET name = :name, role = :role, quote = :quote WHERE id = :id');
            $stmt->execute([
                ':name' => sanitize($_POST['name'] ?? ''),
                ':role' => sanitize($_POST['role'] ?? ''),
                ':quote' => sanitize($_POST['quote'] ?? ''),
                ':id' => (int) ($_POST['id'] ?? 0),
            ]);
            $notice = 'Referans güncellendi.';
        }
        if ($action === 'delete') {
            $stmt = $pdo->prepare('DELETE FROM testimonials WHERE id = :id');
            $stmt->execute([':id' => (int) ($_POST['id'] ?? 0)]);
            $notice = 'Referans silindi.';
        }
    }
}
$items = $pdo ? fetch_testimonials($pdo) : ($siteData['testimonials'] ?? []);
?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h4 mb-1">Referanslar</h1>
        <p class="text-muted mb-0">Destekçi yorumlarını yönetin.</p>
    </div>
</div>
<?php if ($notice): ?>
    <div class="alert alert-success"><?= $notice; ?></div>
<?php endif; ?>
<?php if (!$pdo): ?>
    <div class="alert alert-warning">Veritabanı bağlantısı kurulamadı. config.php içindeki bilgileri güncelleyip tekrar deneyin.</div>
<?php endif; ?>
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="card-title">Yeni Referans</h5>
        <form method="post" class="row g-3">
            <input type="hidden" name="action" value="create">
            <div class="col-md-4">
                <label class="form-label">Ad Soyad</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Görev / Rol</label>
                <input type="text" name="role" class="form-control" required>
            </div>
            <div class="col-md-12">
                <label class="form-label">Alıntı</label>
                <textarea name="quote" class="form-control" rows="3" required></textarea>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Kaydet</button>
            </div>
        </form>
    </div>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="card-title">Mevcut Referanslar</h5>
        <?php foreach ($items as $item): ?>
            <div class="border rounded p-3 mb-3">
                <form method="post" class="row g-3">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?= $item['id'] ?? 0; ?>">
                    <div class="col-md-4">
                        <label class="form-label">Ad Soyad</label>
                        <input type="text" name="name" class="form-control" value="<?= sanitize($item['name']); ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Görev</label>
                        <input type="text" name="role" class="form-control" value="<?= sanitize($item['role']); ?>" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Alıntı</label>
                        <textarea name="quote" class="form-control" rows="3" required><?= sanitize($item['quote']); ?></textarea>
                    </div>
                    <div class="col-12 d-flex gap-2 flex-wrap">
                        <?php if ($pdo): ?>
                            <button class="btn btn-outline-primary" type="submit">Güncelle</button>
                        <?php else: ?>
                            <span class="badge bg-light text-dark">Örnek veri</span>
                        <?php endif; ?>
                    </div>
                </form>
                <?php if ($pdo): ?>
                    <form method="post" class="mt-2" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $item['id'] ?? 0; ?>">
                        <button class="btn btn-sm btn-outline-danger" type="submit">Sil</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include __DIR__ . '/layout/footer.php';
