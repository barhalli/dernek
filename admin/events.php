<?php include __DIR__ . '/layout/header.php';

$notice = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        $notice = 'Veritabanı bağlantısı yok. Lütfen config ayarlarınızı kontrol edin.';
    } else {
        $action = $_POST['action'] ?? '';
        if ($action === 'create') {
            $stmt = $pdo->prepare('INSERT INTO events (title, slug, event_date, location, cover_image, summary, details, cta_label, cta_link) VALUES (:title, :slug, :event_date, :location, :cover_image, :summary, :details, :cta_label, :cta_link)');
            $stmt->execute([
                ':title' => sanitize($_POST['title'] ?? ''),
                ':slug' => sanitize($_POST['slug'] ?? ''),
                ':event_date' => $_POST['event_date'] ?? date('Y-m-d'),
                ':location' => sanitize($_POST['location'] ?? ''),
                ':cover_image' => sanitize($_POST['cover_image'] ?? ''),
                ':summary' => sanitize($_POST['summary'] ?? ''),
                ':details' => sanitize($_POST['details'] ?? ''),
                ':cta_label' => sanitize($_POST['cta_label'] ?? 'Kayıt Ol'),
                ':cta_link' => sanitize($_POST['cta_link'] ?? '#'),
            ]);
            $notice = 'Etkinlik eklendi.';
        }
        if ($action === 'update') {
            $stmt = $pdo->prepare('UPDATE events SET title = :title, slug = :slug, event_date = :event_date, location = :location, cover_image = :cover_image, summary = :summary, details = :details, cta_label = :cta_label, cta_link = :cta_link WHERE id = :id');
            $stmt->execute([
                ':title' => sanitize($_POST['title'] ?? ''),
                ':slug' => sanitize($_POST['slug'] ?? ''),
                ':event_date' => $_POST['event_date'] ?? date('Y-m-d'),
                ':location' => sanitize($_POST['location'] ?? ''),
                ':cover_image' => sanitize($_POST['cover_image'] ?? ''),
                ':summary' => sanitize($_POST['summary'] ?? ''),
                ':details' => sanitize($_POST['details'] ?? ''),
                ':cta_label' => sanitize($_POST['cta_label'] ?? 'Kayıt Ol'),
                ':cta_link' => sanitize($_POST['cta_link'] ?? '#'),
                ':id' => (int) ($_POST['id'] ?? 0),
            ]);
            $notice = 'Etkinlik güncellendi.';
        }
        if ($action === 'delete') {
            $stmt = $pdo->prepare('DELETE FROM events WHERE id = :id');
            $stmt->execute([':id' => (int) ($_POST['id'] ?? 0)]);
            $notice = 'Etkinlik silindi.';
        }
    }
}
$items = $pdo ? fetch_events($pdo) : ($siteData['events'] ?? []);
?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h4 mb-1">Etkinlikler</h1>
        <p class="text-muted mb-0">Takvimi ve açıklamaları yönetin.</p>
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
        <h5 class="card-title">Yeni Etkinlik</h5>
        <form method="post" class="row g-3">
            <input type="hidden" name="action" value="create">
            <div class="col-md-6">
                <label class="form-label">Başlık</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tarih</label>
                <input type="date" name="event_date" class="form-control" value="<?= date('Y-m-d'); ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Lokasyon</label>
                <input type="text" name="location" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control" placeholder="ornek-etkinlik" required>
            </div>
            <div class="col-md-8">
                <label class="form-label">Kapak Görseli (URL)</label>
                <input type="url" name="cover_image" class="form-control" placeholder="https://cdn..." required>
            </div>
            <div class="col-md-12">
                <label class="form-label">Özet</label>
                <textarea name="summary" class="form-control" rows="2" required></textarea>
            </div>
            <div class="col-md-12">
                <label class="form-label">Detay</label>
                <textarea name="details" class="form-control" rows="3" required></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">CTA Başlığı</label>
                <input type="text" name="cta_label" class="form-control" value="Kayıt Ol" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">CTA Link</label>
                <input type="url" name="cta_link" class="form-control" value="#" required>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Kaydet</button>
            </div>
        </form>
    </div>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="card-title">Mevcut Etkinlikler</h5>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Başlık</th><th>Tarih</th><th>Lokasyon</th><th>Özet</th><th class="text-end">İşlemler</th></tr></thead>
                <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= sanitize($item['title']); ?></td>
                        <td><?= isset($item['date']) ? sanitize($item['date']) : sanitize($item['event_date']); ?></td>
                        <td><?= sanitize($item['location']); ?></td>
                        <td><?= sanitize($item['summary']); ?></td>
                        <td class="text-end">
                            <?php if ($pdo): ?>
                                <form method="post" class="row g-2 align-items-center">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?? 0; ?>">
                                    <div class="col-md-2"><input type="text" name="title" class="form-control form-control-sm" value="<?= sanitize($item['title']); ?>" required></div>
                                    <div class="col-md-2"><input type="text" name="slug" class="form-control form-control-sm" value="<?= sanitize($item['slug'] ?? ''); ?>" required></div>
                                    <div class="col-md-2"><input type="date" name="event_date" class="form-control form-control-sm" value="<?= isset($item['date']) ? sanitize($item['date']) : sanitize($item['event_date']); ?>" required></div>
                                    <div class="col-md-2"><input type="text" name="location" class="form-control form-control-sm" value="<?= sanitize($item['location']); ?>" required></div>
                                    <div class="col-md-2"><input type="text" name="cta_label" class="form-control form-control-sm" value="<?= sanitize($item['cta_label'] ?? 'Kayıt Ol'); ?>" required></div>
                                    <div class="col-md-2 d-flex gap-2">
                                        <button class="btn btn-sm btn-outline-primary" type="submit">Kaydet</button>
                                    </div>
                                    <div class="col-md-4 mt-2"><input type="url" name="cover_image" class="form-control form-control-sm" value="<?= sanitize($item['cover_image'] ?? ''); ?>" placeholder="Kapak görseli" required></div>
                                    <div class="col-md-4 mt-2"><input type="url" name="cta_link" class="form-control form-control-sm" value="<?= sanitize($item['cta_link'] ?? '#'); ?>" placeholder="Kayıt linki" required></div>
                                    <div class="col-md-4 mt-2"><input type="text" name="summary" class="form-control form-control-sm" value="<?= sanitize($item['summary']); ?>" placeholder="Özet" required></div>
                                    <div class="col-12 mt-2"><textarea name="details" class="form-control form-control-sm" rows="2" placeholder="Detay" required><?= sanitize($item['details'] ?? ''); ?></textarea></div>
                                </form>
                                <form method="post" class="mt-2" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
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
