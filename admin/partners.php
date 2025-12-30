<?php include __DIR__ . '/layout/header.php';

$notice = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        $notice = 'Veritabanı bağlantısı yok. Lütfen config ayarlarınızı kontrol edin.';
    } else {
        $action = $_POST['action'] ?? '';
        if ($action === 'create') {
            $stmt = $pdo->prepare('INSERT INTO partners (name) VALUES (:name)');
            $stmt->execute([':name' => sanitize($_POST['name'] ?? '')]);
            $notice = 'İş ortağı eklendi.';
        }
        if ($action === 'delete') {
            $stmt = $pdo->prepare('DELETE FROM partners WHERE id = :id');
            $stmt->execute([':id' => (int) ($_POST['id'] ?? 0)]);
            $notice = 'Kayıt silindi.';
        }
    }
}
$items = $pdo ? fetch_partners($pdo) : ($siteData['partners'] ?? []);
?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h4 mb-1">İş Ortakları</h1>
        <p class="text-muted mb-0">Sponsor ve paydaşları yönetin.</p>
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
        <h5 class="card-title">Yeni İş Ortağı</h5>
        <form method="post" class="row g-3">
            <input type="hidden" name="action" value="create">
            <div class="col-md-8">
                <label class="form-label">Ad</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Kaydet</button>
            </div>
        </form>
    </div>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="card-title">Mevcut Kayıtlar</h5>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Ad</th><th class="text-end">İşlem</th></tr></thead>
                <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= is_array($item) ? sanitize($item['name']) : sanitize($item); ?></td>
                        <td class="text-end">
                            <?php if ($pdo): ?>
                                <form method="post" onsubmit="return confirm('Silmek istediğinize emin misiniz?');" class="d-inline">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?? 0; ?>">
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Sil</button>
                                </form>
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
