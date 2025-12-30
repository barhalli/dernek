<?php
require __DIR__ . '/config/database.php';
require __DIR__ . '/includes/functions.php';

$siteData = load_data($pdo);
$pageTitle = 'DernekWeb | Toplumsal Dayanışma Platformu';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>
<section class="hero py-5 py-lg-6 position-relative">
    <div class="container position-relative z-1">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge rounded-pill mb-3">Paylaşımlı hosting uyumlu · Güvenli · Hızlı</span>
                <h1 class="display-4 fw-bold mb-3">Dayanışma için <span class="text-warning">sürdürülebilir</span> bir dijital merkez</h1>
                <p class="lead text-white-50 mb-4">DernekWeb; gönüllü yönetimi, bağış süreçleri ve etkinlik takibini tek platformda buluşturan, mobil uyumlu ve veritabanı destekli bir kurumsal web sitesidir.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a class="btn btn-warning btn-lg fw-semibold px-4" href="donate.php">Bağış Yap</a>
                    <a class="btn btn-outline-light btn-lg fw-semibold px-4" href="contact.php">İletişime Geç</a>
                </div>
                <div class="d-flex flex-wrap gap-3 mt-4 text-white-50 small">
                    <span><i class="fa-solid fa-database me-2"></i>MySQL + phpMyAdmin hazır</span>
                    <span><i class="fa-solid fa-shield-halved me-2"></i>Paylaşımlı hosting uyumlu</span>
                    <span><i class="fa-solid fa-mobile-screen me-2"></i>Mobil odaklı tasarım</span>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-circle me-3"><i class="fa-solid fa-gauge-high"></i></div>
                            <div>
                                <div class="fw-semibold">Hızlı kurulum</div>
                                <small class="text-muted">config.php ile dakikalar içinde aktif</small>
                            </div>
                        </div>
                        <ul class="list-unstyled mb-0 text-muted small">
                            <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i>Bootstrap 5.3 & Font Awesome (jsDelivr)</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i>SEO başlık ve meta ayarları</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i>Örnek SQL şeması ve sahte veriler</li>
                            <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i>Temiz PHP + PDO veri erişimi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <svg class="hero-curve" viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path fill="#f8fafc" d="M0,64L80,64C160,64,320,64,480,85.3C640,107,800,149,960,160C1120,171,1280,149,1360,138.7L1440,128L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
    </svg>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($siteData['stats'] as $stat): ?>
                <div class="col-6 col-md-3">
                    <div class="stat-card text-center card-hover">
                        <div class="stat-value mb-2"><?= $stat['value']; ?></div>
                        <div class="text-muted fw-semibold"><?= $stat['label']; ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <p class="text-uppercase text-primary fw-bold label-pill mb-2">Programlar</p>
                <h2 class="section-title mb-0">Toplumsal etki yaratan odak alanlarımız</h2>
            </div>
            <a class="btn btn-outline-primary" href="about.php">Detaylı İncele</a>
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

<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <p class="text-uppercase text-primary fw-bold label-pill mb-2">Bağış Akışı</p>
                <h2 class="section-title mb-3">Şeffaf bağış süreçleri ve etkisi ölçülen projeler</h2>
                <p class="text-muted">PHP + MySQL altyapımız bağışların kaydedilmesini, raporlanmasını ve phpMyAdmin üzerinden izlenmesini sağlar. Paylaşımlı hosting uyumlu yapı sayesinde ek sunucu erişimine gerek kalmadan kurulumu tamamlayabilirsiniz.</p>
                <ul class="list-unstyled text-muted">
                    <li class="mb-2"><i class="fa-solid fa-circle-check text-primary me-2"></i>SSL uyumlu ve responsif tasarım</li>
                    <li class="mb-2"><i class="fa-solid fa-circle-check text-primary me-2"></i>Örnek SQL şeması ile hızlı başlangıç</li>
                    <li class="mb-2"><i class="fa-solid fa-circle-check text-primary me-2"></i>Etkinlik, haber ve mesaj tabloları hazır</li>
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="donate-card p-4 p-lg-5 shadow-lg">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-white text-primary me-3"><i class="fa-solid fa-hand-holding-heart"></i></div>
                        <div>
                            <div class="fw-semibold">Anında katkı</div>
                            <small class="text-white-50">Bağış formu + otomatik kayıt</small>
                        </div>
                    </div>
                    <form class="row g-3" action="donate.php" method="get">
                        <div class="col-md-8">
                            <label class="form-label">Bağış Tutarı</label>
                            <div class="input-group">
                                <span class="input-group-text">₺</span>
                                <input type="number" name="amount" class="form-control" placeholder="500" min="10" step="10">
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button class="btn btn-warning w-100" type="submit">Devam Et</button>
                        </div>
                    </form>
                    <div class="mt-4 small text-white-50">
                        <i class="fa-solid fa-lock me-2"></i>Veriler SSL ve PDO ile güvenli aktarılır.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <p class="text-uppercase text-primary fw-bold label-pill mb-2">Etkinlik Takvimi</p>
                <h2 class="section-title mb-0">Yaklaşan buluşma ve çalıştaylar</h2>
            </div>
            <a class="btn btn-outline-primary" href="events.php">Tüm etkinlikler</a>
        </div>
        <div class="row g-4">
            <?php foreach ($siteData['events'] as $event): ?>
                <div class="col-lg-4">
                    <div class="card h-100 card-hover border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center text-muted small mb-2">
                                <i class="fa-regular fa-calendar me-2"></i>
                                <span><?= date('d M Y', strtotime($event['date'])); ?> · <?= $event['location']; ?></span>
                            </div>
                            <h5 class="fw-bold mb-2"><?= $event['title']; ?></h5>
                            <p class="text-muted mb-3"><?= $event['summary']; ?></p>
                            <a class="text-primary fw-semibold" href="events.php"><span>Detaylar</span> <i class="fa-solid fa-arrow-right-long ms-1"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-5">
                <p class="text-uppercase text-primary fw-bold label-pill mb-2">Öne çıkanlar</p>
                <h2 class="section-title mb-3">Haberler ve başarı hikâyeleri</h2>
                <p class="text-muted">Veritabanındaki haber tabloları sayesinde ekip kolayca yeni duyurular ekler, ziyaretçiler aradıklarını hızla bulur.</p>
                <a class="btn btn-outline-primary" href="news.php">Tüm haberler</a>
            </div>
            <div class="col-lg-7">
                <div class="row g-3">
                    <?php foreach (array_slice($siteData['news'], 0, 3) as $news): ?>
                        <div class="col-md-12">
                            <div class="card card-hover border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center text-muted small mb-2">
                                        <i class="fa-regular fa-newspaper me-2"></i>
                                        <span><?= date('d M Y', strtotime($news['date'])); ?> · <?= $news['author']; ?></span>
                                    </div>
                                    <h5 class="fw-bold mb-2"><?= $news['title']; ?></h5>
                                    <p class="text-muted mb-0"><?= $news['summary']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <p class="text-uppercase text-primary fw-bold label-pill mb-2">Ekip & Destekçiler</p>
                        <h2 class="section-title mb-3">Birlikte büyüyen topluluk</h2>
                        <p class="text-muted">Partner logoları, gönüllü hikâyeleri ve destekçi referansları tek sayfada toplanır. Tasarım tamamen Bootstrap 5 ve özel CSS ile düzenlenmiştir.</p>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <?php foreach ($siteData['partners'] as $partner): ?>
                                <span class="partner-tag"><?= $partner; ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <p class="text-uppercase text-primary fw-bold label-pill mb-2">Deneyimler</p>
                        <h2 class="section-title mb-3">Gönüllüler ne diyor?</h2>
                        <div class="d-flex flex-column gap-3">
                            <?php foreach ($siteData['testimonials'] as $testimonial): ?>
                                <div class="testimonial">
                                    <p class="mb-2 fst-italic">“<?= $testimonial['quote']; ?>”</p>
                                    <div class="fw-semibold mb-0"><?= $testimonial['name']; ?> · <span class="text-muted"><?= $testimonial['role']; ?></span></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
