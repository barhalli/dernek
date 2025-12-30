<?php
require __DIR__ . '/config/database.php';
require __DIR__ . '/includes/functions.php';

$siteData = load_data($pdo);
$pageTitle = 'Hakkımızda | DernekWeb';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>
<section class="page-hero py-5">
    <div class="container">
        <p class="text-uppercase text-primary fw-bold label-pill mb-2">Kurumsal</p>
        <h1 class="section-title mb-3">Hakkımızda</h1>
        <p class="text-muted col-lg-7">DernekWeb; insan odaklı yardım, eğitim ve dayanışma projelerini dijitalde görünür kılmak için tasarlanmış modern bir şablondur. Paylaşımlı hosting üzerinde çalışır, güvenli PDO ile veritabanına bağlanır.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4 align-items-start">
            <div class="col-lg-6">
                <h3 class="fw-bold mb-3">Misyonumuz</h3>
                <p class="text-muted">Toplumun her kesiminden bireylerin dayanışmaya katılmasını kolaylaştırmak; bağış, gönüllü ve etkinlik süreçlerini tek merkezden yönetmek.</p>
                <ul class="list-unstyled text-muted">
                    <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i>Dijitalde güvenilir bir marka dili</li>
                    <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i>Bootstrap 5.3 ile hızlı özelleştirme</li>
                    <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i>PhpMyAdmin üzerinden kolay veri yönetimi</li>
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Değerlerimiz</h5>
                        <div class="d-flex flex-column gap-3 text-muted">
                            <div class="d-flex">
                                <div class="icon-circle me-3"><i class="fa-solid fa-shield-heart"></i></div>
                                <div>
                                    <div class="fw-semibold">Şeffaflık</div>
                                    <p class="mb-0">Tüm bağış akışları ve raporlar veritabanında tutulur, gerektiğinde dışa aktarılır.</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="icon-circle me-3"><i class="fa-solid fa-people-group"></i></div>
                                <div>
                                    <div class="fw-semibold">Katılımcılık</div>
                                    <p class="mb-0">Gönüllü ve destekçi hikâyeleri için içerik modülleri hazır gelir.</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="icon-circle me-3"><i class="fa-solid fa-earth-americas"></i></div>
                                <div>
                                    <div class="fw-semibold">Sürdürülebilirlik</div>
                                    <p class="mb-0">Düşük kaynak tüketen, önbelleğe alınabilir front-end kurgusu.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <p class="text-uppercase text-primary fw-bold label-pill mb-2">Programlar</p>
                <h2 class="section-title mb-0">Sahadaki çalışmalarımız</h2>
            </div>
            <a class="btn btn-outline-primary" href="events.php">Etkinlik Takvimi</a>
        </div>
        <div class="row g-4">
            <?php foreach ($siteData['programs'] as $program): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 card-hover border-0 shadow-sm">
                        <div class="card-body">
                            <div class="icon-circle mb-3"><i class="fa-solid <?= $program['icon']; ?>"></i></div>
                            <h5 class="fw-bold mb-2"><?= $program['title']; ?></h5>
                            <p class="text-muted mb-0"><?= $program['description']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
