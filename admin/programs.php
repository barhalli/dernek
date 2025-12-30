<?php include __DIR__ . '/layout/header.php';

$notice = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        $notice = 'Veritabanı bağlantısı yok. Lütfen config ayarlarınızı kontrol edin.';
    } else {
        $action = $_POST['action'] ?? '';
        if ($action === 'create') {
            $stmt = $pdo->prepare('INSERT INTO programs (title, description, icon) VALUES (:title, :description, :icon)');
            $stmt->execute([
                ':title' => sanitize($_POST['title'] ?? ''),
                ':description' => sanitize($_POST['description'] ?? ''),
                ':icon' => sanitize($_POST['icon'] ?? 'fa-circle-check'),
            ]);
            $notice = 'Program eklendi.';
        }
        if ($action === 'update') {
            $stmt = $pdo->prepare('UPDATE programs SET title = :title, description = :description, icon = :icon WHERE id = :id');
            $stmt->execute([
                ':title' => sanitize($_POST['title'] ?? ''),
                ':description' => sanitize($_POST['description'] ?? ''),
                ':icon' => sanitize($_POST['icon'] ?? 'fa-circle-check'),
                ':id' => (int) ($_POST['id'] ?? 0),
            ]);
            $notice = 'Program güncellendi.';
        }
        if ($action === 'delete') {
            $stmt = $pdo->prepare('DELETE FROM programs WHERE id = :id');
            $stmt->execute([':id' => (int) ($_POST['id'] ?? 0)]);
            $notice = 'Program silindi.';
        }
    }
}
$items = $pdo ? fetch_programs($pdo) : ($siteData['programs'] ?? []);
?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h4 mb-1">Programlar</h1>
        <p class="text-muted mb-0">Odak alanlarını ve simgeleri yönetin.</p>
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
        <h5 class="card-title">Yeni Program</h5>
        <form method="post" class="row g-3">
            <input type="hidden" name="action" value="create">
            <div class="col-md-4">
                <label class="form-label">Başlık</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Simge (Font Awesome)</label>
                <input type="text" name="icon" class="form-control" placeholder="fa-heart" required>
            </div>
            <div class="col-md-12">
                <label class="form-label">Açıklama</label>
                <textarea name="description" class="form-control" rows="2" required></textarea>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Kaydet</button>
            </div>
        </form>
    </div>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="card-title">Mevcut Programlar</h5>
        <?php foreach ($items as $item): ?>
            <div class="border rounded p-3 mb-3">
                <form method="post" class="row g-3 align-items-end">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?= $item['id'] ?? 0; ?>">
                    <div class="col-md-4">
                        <label class="form-label">Başlık</label>
                        <input type="text" name="title" class="form-control" value="<?= sanitize($item['title']); ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Simge</label>
                        <input type="text" name="icon" class="form-control" value="<?= sanitize($item['icon']); ?>" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Açıklama</label>
                        <textarea name="description" class="form-control" rows="2" required><?= sanitize($item['description']); ?></textarea>
                    </div>
                    <div class="col-md-12 d-flex gap-2 flex-wrap">
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
