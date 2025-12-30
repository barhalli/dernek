<?php
require __DIR__ . '/config/database.php';
require __DIR__ . '/includes/functions.php';

$siteData = load_data($pdo);
$pageTitle = 'Haberler | DernekWeb';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>
<section class="page-hero py-5">
    <div class="container">
        <p class="text-uppercase text-primary fw-bold label-pill mb-2">Haberler</p>
        <h1 class="section-title mb-3">Duyuru ve başarı hikâyeleri</h1>
        <p class="text-muted col-lg-7">İçerikler veritabanındaki <code>news</code> tablosundan çekilir; phpMyAdmin ile ekleme/güncelleme yapılabilir. Öne çıkan haberler ana sayfaya otomatik yansır.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($siteData['news'] as $article): ?>
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm card-hover">
                        <div class="card-body">
                            <div class="d-flex align-items-center text-muted small mb-2">
                                <i class="fa-regular fa-calendar me-2"></i>
                                <span><?= date('d M Y', strtotime($article['date'])); ?> · <?= $article['author']; ?></span>
                            </div>
                            <h5 class="fw-bold mb-2"><a class="text-decoration-none" href="news-detail.php?slug=<?= urlencode($article['slug'] ?? ''); ?>"><?= $article['title']; ?></a></h5>
                            <p class="text-muted mb-2"><?= $article['summary']; ?></p>
                            <a class="text-primary fw-semibold small" href="news-detail.php?slug=<?= urlencode($article['slug'] ?? ''); ?>">Devamını oku</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
