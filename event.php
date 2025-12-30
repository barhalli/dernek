<?php
require __DIR__ . '/config/database.php';
require __DIR__ . '/includes/functions.php';

$siteData = load_data($pdo);
$settings = $siteData['settings'] ?? [];
$slug = $_GET['slug'] ?? '';
$event = find_event($siteData['events'], $slug);

if (!$event) {
    http_response_code(404);
    $pageTitle = 'Etkinlik Bulunamadı | DernekWeb';
    include __DIR__ . '/includes/head.php';
    include __DIR__ . '/includes/header.php';
    echo '<section class="py-5 text-center"><div class="container"><h1>Etkinlik bulunamadı</h1><p class="text-muted">Aradığınız etkinlik kaldırılmış olabilir.</p></div></section>';
    include __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle = $event['title'] . ' | Etkinlik';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>
<section class="page-hero py-5">
    <div class="container">
        <p class="text-uppercase text-primary fw-bold label-pill mb-2">Etkinlik</p>
        <h1 class="section-title mb-3"><?= sanitize($event['title']); ?></h1>
        <div class="d-flex flex-wrap gap-3 text-muted">
            <span><i class="fa-solid fa-calendar-days me-1"></i><?= date('d F Y', strtotime($event['date'])); ?></span>
            <span><i class="fa-solid fa-location-dot me-1"></i><?= sanitize($event['location']); ?></span>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-img-top ratio ratio-16x9">
                        <img class="rounded-top" src="<?= sanitize($event['cover_image'] ?? $settings['gallery_primary'] ?? ''); ?>" alt="<?= sanitize($event['title']); ?>">
                    </div>
                    <div class="card-body">
                        <p class="lead text-muted"><?= nl2br(sanitize($event['summary'])); ?></p>
                        <p class="text-muted"><?= nl2br(sanitize($event['details'] ?? '')); ?></p>
                    </div>
                </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Program Akışı</h5>
                        <ul class="list-unstyled mb-0 event-agenda">
                            <li><span class="badge bg-primary-subtle text-primary me-2">09:30</span>Açılış ve tanışma</li>
                            <li><span class="badge bg-primary-subtle text-primary me-2">11:00</span>Atölye ve saha uygulamaları</li>
                            <li><span class="badge bg-primary-subtle text-primary me-2">13:30</span>Öğle arası & networking</li>
                            <li><span class="badge bg-primary-subtle text-primary me-2">15:00</span>Panel ve soru-cevap</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Etkinlik Bilgileri</h5>
                        <div class="d-flex align-items-center mb-2 text-muted"><i class="fa-solid fa-location-dot me-2 text-primary"></i><?= sanitize($event['location']); ?></div>
                        <div class="d-flex align-items-center mb-2 text-muted"><i class="fa-solid fa-clock me-2 text-primary"></i><?= date('d F Y', strtotime($event['date'])); ?></div>
                        <div class="d-flex align-items-center mb-2 text-muted"><i class="fa-solid fa-users me-2 text-primary"></i>Kontenjan sınırlı</div>
                        <div class="d-flex align-items-center mb-3 text-muted"><i class="fa-solid fa-circle-info me-2 text-primary"></i>Katılım ücretsiz, kayıt zorunlu.</div>
                        <a class="btn btn-primary w-100 mb-2" href="<?= sanitize($event['cta_link'] ?? '#'); ?>"><?= sanitize($event['cta_label'] ?? 'Kayıt Ol'); ?></a>
                        <a class="btn btn-outline-primary w-100" href="contact.php">Soru Sor</a>
                    </div>
                </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Diğer Etkinlikler</h6>
                        <ul class="list-unstyled mb-0 small">
                            <?php foreach (array_slice($siteData['events'], 0, 4) as $other): ?>
                                <li class="mb-2">
                                    <a class="text-decoration-none" href="event.php?slug=<?= urlencode($other['slug'] ?? ''); ?>"><?= sanitize($other['title']); ?></a>
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
