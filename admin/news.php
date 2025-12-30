<?php include __DIR__ . '/layout/header.php';

$notice = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        $notice = 'Veritabanı bağlantısı yok. Lütfen config ayarlarınızı kontrol edin.';
    } else {
        $action = $_POST['action'] ?? '';
        if ($action === 'create') {
            $stmt = $pdo->prepare('INSERT INTO news (title, slug, summary, content, cover_image, category, author, published_at) VALUES (:title, :slug, :summary, :content, :cover_image, :category, :author, :published_at)');
            $stmt->execute([
                ':title' => sanitize($_POST['title'] ?? ''),
                ':slug' => sanitize($_POST['slug'] ?? ''),
                ':summary' => sanitize($_POST['summary'] ?? ''),
                ':content' => sanitize($_POST['content'] ?? ''),
                ':cover_image' => sanitize($_POST['cover_image'] ?? ''),
                ':category' => sanitize($_POST['category'] ?? 'Genel'),
                ':author' => sanitize($_POST['author'] ?? 'Editör'),
                ':published_at' => $_POST['published_at'] ?? date('Y-m-d'),
            ]);
            $notice = 'Haber eklendi.';
        }
        if ($action === 'update') {
            $stmt = $pdo->prepare('UPDATE news SET title = :title, slug = :slug, summary = :summary, content = :content, cover_image = :cover_image, category = :category, author = :author, published_at = :published_at WHERE id = :id');
            $stmt->execute([
                ':title' => sanitize($_POST['title'] ?? ''),
                ':slug' => sanitize($_POST['slug'] ?? ''),
                ':summary' => sanitize($_POST['summary'] ?? ''),
                ':content' => sanitize($_POST['content'] ?? ''),
                ':cover_image' => sanitize($_POST['cover_image'] ?? ''),
                ':category' => sanitize($_POST['category'] ?? 'Genel'),
                ':author' => sanitize($_POST['author'] ?? 'Editör'),
                ':published_at' => $_POST['published_at'] ?? date('Y-m-d'),
                ':id' => (int) ($_POST['id'] ?? 0),
            ]);
            $notice = 'Haber güncellendi.';
        }
        if ($action === 'delete') {
            $stmt = $pdo->prepare('DELETE FROM news WHERE id = :id');
            $stmt->execute([':id' => (int) ($_POST['id'] ?? 0)]);
            $notice = 'Haber silindi.';
        }
    }
}
$items = $pdo ? fetch_news($pdo) : ($siteData['news'] ?? []);
?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h4 mb-1">Haberler</h1>
        <p class="text-muted mb-0">Duyuruları ve içerikleri yönetin.</p>
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
        <h5 class="card-title">Yeni Haber</h5>
        <form method="post" class="row g-3">
            <input type="hidden" name="action" value="create">
            <div class="col-md-8">
                <label class="form-label">Başlık</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Yayın Tarihi</label>
                <input type="date" name="published_at" class="form-control" value="<?= date('Y-m-d'); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Slug (detay URL)</label>
                <input type="text" name="slug" class="form-control" placeholder="ornek-haber" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Kapak Görseli (URL)</label>
                <input type="url" name="cover_image" class="form-control" placeholder="https://cdn..." required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Özet</label>
                <textarea name="summary" class="form-control" rows="2" required></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Kategori</label>
                <input type="text" name="category" class="form-control" value="Genel" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Yazar</label>
                <input type="text" name="author" class="form-control" value="Editör" required>
            </div>
            <div class="col-md-12">
                <label class="form-label">İçerik</label>
                <textarea name="content" class="form-control" rows="4" required></textarea>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Kaydet</button>
            </div>
        </form>
    </div>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="card-title">Mevcut Haberler</h5>
        <?php foreach ($items as $item): ?>
            <div class="border rounded p-3 mb-3">
                <form method="post" class="row g-3">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?= $item['id'] ?? 0; ?>">
                    <div class="col-md-8">
                        <label class="form-label">Başlık</label>
                        <input type="text" name="title" class="form-control" value="<?= sanitize($item['title']); ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Yayın Tarihi</label>
                        <input type="date" name="published_at" class="form-control" value="<?= date('Y-m-d', strtotime($item['date'] ?? $item['published_at'])); ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" value="<?= sanitize($item['slug'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kapak Görseli</label>
                        <input type="url" name="cover_image" class="form-control" value="<?= sanitize($item['cover_image'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Özet</label>
                        <textarea name="summary" class="form-control" rows="2" required><?= sanitize($item['summary']); ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="category" class="form-control" value="<?= sanitize($item['category'] ?? 'Genel'); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Yazar</label>
                        <input type="text" name="author" class="form-control" value="<?= sanitize($item['author']); ?>" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">İçerik</label>
                        <textarea name="content" class="form-control" rows="3" required><?= sanitize($item['content']); ?></textarea>
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
