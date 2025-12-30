<?php
require __DIR__ . '/config/database.php';
require __DIR__ . '/includes/functions.php';

$siteData = load_data($pdo);
$settings = $siteData['settings'] ?? [];
$slug = $_GET['slug'] ?? '';
$article = find_news($siteData['news'], $slug);

if (!$article) {
    http_response_code(404);
    $pageTitle = 'Haber Bulunamadı | DernekWeb';
    include __DIR__ . '/includes/head.php';
    include __DIR__ . '/includes/header.php';
    echo '<section class="py-5 text-center"><div class="container"><h1>Haber bulunamadı</h1><p class="text-muted">Aradığınız içerik kaldırılmış olabilir.</p></div></section>';
    include __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle = $article['title'] . ' | Haber';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>
<section class="page-hero py-5">
    <div class="container">
        <p class="text-uppercase text-primary fw-bold label-pill mb-2">Haber</p>
        <h1 class="section-title mb-3"><?= sanitize($article['title']); ?></h1>
        <div class="d-flex flex-wrap gap-3 text-muted">
            <span><i class="fa-regular fa-calendar me-1"></i><?= date('d M Y', strtotime($article['date'])); ?></span>
            <span><i class="fa-regular fa-user me-1"></i><?= sanitize($article['author']); ?></span>
            <span><i class="fa-solid fa-tag me-1"></i><?= sanitize($article['category'] ?? 'Güncel'); ?></span>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-img-top ratio ratio-16x9">
                        <img class="rounded-top" src="<?= sanitize($article['cover_image'] ?? $settings['gallery_secondary'] ?? ''); ?>" alt="<?= sanitize($article['title']); ?>">
                    </div>
                    <div class="card-body">
                        <p class="lead text-muted"><?= nl2br(sanitize($article['summary'])); ?></p>
                        <p class="text-muted"><?= nl2br(sanitize($article['content'])); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">İçerik Bilgileri</h5>
                        <div class="d-flex align-items-center mb-2 text-muted"><i class="fa-solid fa-tag me-2 text-primary"></i><?= sanitize($article['category'] ?? 'Güncel'); ?></div>
                        <div class="d-flex align-items-center mb-2 text-muted"><i class="fa-solid fa-circle-info me-2 text-primary"></i>Yönetim panelinden güncellenir.</div>
                        <a class="btn btn-primary w-100" href="news.php">Tüm Haberler</a>
                    </div>
                </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Son Haberler</h6>
                        <ul class="list-unstyled mb-0 small">
                            <?php foreach (array_slice($siteData['news'], 0, 5) as $other): ?>
                                <li class="mb-2">
                                    <a class="text-decoration-none" href="news-detail.php?slug=<?= urlencode($other['slug'] ?? ''); ?>"><?= sanitize($other['title']); ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
