<?php include __DIR__ . '/layout/header.php';

$notice = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        $notice = 'Veritabanı bağlantısı yok. Lütfen config ayarlarınızı kontrol edin.';
    } else {
        $action = $_POST['action'] ?? '';
        if ($action === 'create') {
            $stmt = $pdo->prepare('INSERT INTO stats (label, value) VALUES (:label, :value)');
            $stmt->execute([
                ':label' => sanitize($_POST['label'] ?? ''),
                ':value' => (int) ($_POST['value'] ?? 0),
            ]);
            $notice = 'Yeni istatistik kartı eklendi.';
        }
        if ($action === 'update') {
            $stmt = $pdo->prepare('UPDATE stats SET label = :label, value = :value WHERE id = :id');
            $stmt->execute([
                ':label' => sanitize($_POST['label'] ?? ''),
                ':value' => (int) ($_POST['value'] ?? 0),
                ':id' => (int) ($_POST['id'] ?? 0),
            ]);
            $notice = 'Kart güncellendi.';
        }
        if ($action === 'delete') {
            $stmt = $pdo->prepare('DELETE FROM stats WHERE id = :id');
            $stmt->execute([':id' => (int) ($_POST['id'] ?? 0)]);
            $notice = 'Kart silindi.';
        }
    }
}
$items = $pdo ? fetch_stats($pdo) : ($siteData['stats'] ?? []);
?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h4 mb-1">İstatistik Kartları</h1>
        <p class="text-muted mb-0">Ana sayfadaki sayaçları düzenleyin.</p>
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
        <h5 class="card-title">Yeni Kart Ekle</h5>
        <form method="post" class="row g-3">
            <input type="hidden" name="action" value="create">
            <div class="col-md-6">
                <label class="form-label">Başlık</label>
                <input type="text" name="label" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Sayı</label>
                <input type="number" name="value" class="form-control" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-primary w-100" type="submit">Kaydet</button>
            </div>
        </form>
    </div>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="card-title">Mevcut Kartlar</h5>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Başlık</th><th>Değer</th><th class="text-end">İşlemler</th></tr></thead>
                <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= sanitize($item['label']); ?></td>
                        <td><?= sanitize((string) $item['value']); ?></td>
                        <td class="text-end">
                            <?php if ($pdo): ?>
                            <div class="d-inline-flex gap-2">
                                <form method="post" class="d-flex gap-2">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?? 0; ?>">
                                    <input type="text" name="label" class="form-control form-control-sm" value="<?= sanitize($item['label']); ?>" required>
                                    <input type="number" name="value" class="form-control form-control-sm" value="<?= (int) $item['value']; ?>" required>
                                    <button class="btn btn-sm btn-outline-primary" type="submit">Güncelle</button>
                                </form>
                                <form method="post" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?? 0; ?>">
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Sil</button>
                                </form>
                            </div>
                            <?php else: ?>
                                <span class="badge bg-light text-dark">Örnek veri</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include __DIR__ . '/layout/footer.php';
