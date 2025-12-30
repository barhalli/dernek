<?php
require __DIR__ . '/config/database.php';
require __DIR__ . '/includes/functions.php';

$siteData = load_data($pdo);
$pageTitle = 'Etkinlik Takvimi | DernekWeb';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>
<section class="page-hero py-5">
    <div class="container">
        <p class="text-uppercase text-primary fw-bold label-pill mb-2">Etkinlikler</p>
        <h1 class="section-title mb-3">Yaklaşan ve geçmiş etkinlikler</h1>
        <p class="text-muted col-lg-7">Etkinlikler MySQL tablosundan çekilir. PhpMyAdmin ile güncelleyebilir, yeni etkinlik ekleyebilir veya dışa aktarabilirsiniz.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($siteData['events'] as $event): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 card-hover border-0 shadow-sm position-relative">
                        <div class="card-body">
                            <div class="text-muted small mb-2"><i class="fa-regular fa-calendar me-2"></i><?= date('d M Y', strtotime($event['date'])); ?> · <?= $event['location']; ?></div>
                            <h5 class="fw-bold mb-2"><?= $event['title']; ?></h5>
                            <p class="text-muted mb-3"><?= $event['summary']; ?></p>
                            <a class="btn btn-outline-primary btn-sm" href="contact.php">Katılmak istiyorum</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
