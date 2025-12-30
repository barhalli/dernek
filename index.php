<?php
require __DIR__ . '/config/database.php';
require __DIR__ . '/includes/functions.php';

$siteData = load_data($pdo);
$pageTitle = 'DernekWeb | Toplumsal Dayanışma Platformu';
include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>
<section class="hero-modern">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <div class="hero-tag mb-3"><i class="fa-solid fa-rocket"></i> Dernek Yazılım · Paylaşımlı hosting hazır</div>
                <h1 class="display-5 fw-bold mb-3">Güçlü bir dernek sitesi ile <span class="text-warning">daha çok insana</span> ulaşın</h1>
                <p class="lead text-white-75 mb-3">Tüm sayfaları yönetim panelinden düzenleyebileceğiniz modern, veritabanı destekli ve mobil uyumlu dernek altyapısı.</p>
                <ul class="list-unstyled hero-list text-white-75 mb-4">
                    <li><i class="fa-solid fa-circle-check me-2 text-warning"></i>MySQL + phpMyAdmin şeması ve örnek veriler</li>
                    <li><i class="fa-solid fa-circle-check me-2 text-warning"></i>Program, etkinlik, haber ve bağış kayıtları hazır</li>
                    <li><i class="fa-solid fa-circle-check me-2 text-warning"></i>Bootstrap 5 ve Font Awesome (jsDelivr) ile hızlı yükleme</li>
                </ul>
                <div class="d-flex flex-wrap gap-3">
                    <a class="btn btn-light text-primary fw-semibold px-4" href="donate.php">Bağış Yap</a>
                    <a class="btn btn-outline-light fw-semibold px-4" href="contact.php">İletişime Geç</a>
                </div>
                <div class="mini-stats">
                    <?php foreach (array_slice($siteData['stats'], 0, 4) as $stat): ?>
                        <div class="mini-stat">
                            <div class="small text-white-50"><?= $stat['label']; ?></div>
                            <div class="fw-bold fs-5"><?= $stat['value']; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-figure">
                    <img class="w-100" src="https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=1400&q=80" alt="Dernek paneli">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="stat-strip">
    <div class="container">
        <div class="row g-4">
            <?php foreach (array_slice($siteData['stats'], 0, 4) as $stat): ?>
                <div class="col-6 col-md-3">
                    <div class="item">
                        <div class="stat-icon"><i class="fa-solid fa-star"></i></div>
                        <div>
                            <div class="fw-bold fs-5 mb-0"><?= $stat['value']; ?></div>
                            <small class="text-white-75"><?= $stat['label']; ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card-sleek h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=400&q=80" class="rounded-circle" width="70" height="70" alt="Kurucu">
                        <div>
                            <div class="fw-bold">Dernek Kurucu</div>
                            <div class="text-muted small">Projelerden sorumlu yönetici</div>
                        </div>
                    </div>
                    <p class="mb-3">“Koşulsuz sevgi ve dayanışma ile daha yaşanabilir bir toplum inşa ediyoruz.”</p>
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="badge bg-light text-dark">Vizyon</span>
                        <span class="badge bg-light text-dark">Şeffaflık</span>
                        <span class="badge bg-light text-dark">Katılımcılık</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card-sleek h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <p class="label-pill mb-1"><i class="fa-solid fa-bell"></i> Güncel içerikler</p>
                            <h2 class="section-title mb-0">Duyurular · Haberler · Etkinlikler</h2>
                        </div>
                        <a class="btn btn-outline-primary" href="news.php">Tümü</a>
                    </div>
                    <ul class="nav nav-pills news-tabs mb-3" id="contentTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="news-tab" data-bs-toggle="pill" data-bs-target="#news" type="button" role="tab">Haberler</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="events-tab" data-bs-toggle="pill" data-bs-target="#events" type="button" role="tab">Etkinlikler</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="testimonials-tab" data-bs-toggle="pill" data-bs-target="#testimonials" type="button" role="tab">Referanslar</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="contentTabsContent">
                        <div class="tab-pane fade show active" id="news" role="tabpanel">
                            <?php foreach (array_slice($siteData['news'], 0, 3) as $news): ?>
                                <div class="d-flex align-items-start py-2 border-bottom">
                                    <div class="icon-circle me-3"><i class="fa-regular fa-newspaper"></i></div>
                                    <div>
                                        <div class="small text-muted mb-1"><?= date('d.m.Y', strtotime($news['date'])); ?></div>
                                        <div class="fw-semibold mb-1"><?= $news['title']; ?></div>
                                        <div class="text-muted small"><?= $news['summary']; ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="tab-pane fade" id="events" role="tabpanel">
                            <?php foreach (array_slice($siteData['events'], 0, 3) as $event): ?>
                                <div class="d-flex align-items-start py-2 border-bottom">
                                    <div class="icon-circle me-3"><i class="fa-regular fa-calendar"></i></div>
                                    <div>
                                        <div class="small text-muted mb-1"><?= date('d.m.Y', strtotime($event['date'])); ?> · <?= $event['location']; ?></div>
                                        <div class="fw-semibold mb-1"><?= $event['title']; ?></div>
                                        <div class="text-muted small"><?= $event['summary']; ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="tab-pane fade" id="testimonials" role="tabpanel">
                            <?php foreach ($siteData['testimonials'] as $testimonial): ?>
                                <div class="d-flex align-items-start py-2 border-bottom">
                                    <div class="icon-circle me-3"><i class="fa-solid fa-quote-left"></i></div>
                                    <div>
                                        <div class="fw-semibold mb-1"><?= $testimonial['name']; ?> · <span class="text-muted"><?= $testimonial['role']; ?></span></div>
                                        <div class="text-muted small fst-italic">“<?= $testimonial['quote']; ?>”</div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <p class="label-pill mb-2"><i class="fa-solid fa-layer-group"></i> Odak Alanlarımız</p>
                <h2 class="section-title mb-0">Programlar ve projeler</h2>
            </div>
            <a class="btn btn-outline-primary" href="about.php">Detaylı İncele</a>
        </div>
        <div class="row g-4">
            <?php foreach ($siteData['programs'] as $program): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card-sleek h-100 card-hover text-center">
                        <div class="icon-circle mx-auto mb-3"><i class="fa-solid <?= $program['icon']; ?>"></i></div>
                        <h5 class="fw-bold mb-2"><?= $program['title']; ?></h5>
                        <p class="text-muted mb-0"><?= $program['description']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="card-sleek h-100">
                    <p class="label-pill mb-2"><i class="fa-solid fa-hand-holding-heart"></i> Bağış akışı</p>
                    <h2 class="section-title mb-3">İhtiyaç sahiplerine hızlı ulaşan bağışlar</h2>
                    <p class="text-muted">PDO tabanlı formlar bağışları ve iletişim taleplerini otomatik olarak veritabanına kaydeder. Yönetim panelinden geçmiş kayıtları inceleyip dışa aktarabilirsiniz.</p>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2"><i class="fa-solid fa-circle-check text-primary me-2"></i>SSL uyumlu Bootstrap form yapısı</li>
                        <li class="mb-2"><i class="fa-solid fa-circle-check text-primary me-2"></i>phpMyAdmin ile anlık kontrol</li>
                        <li class="mb-2"><i class="fa-solid fa-circle-check text-primary me-2"></i>Admin panelinden yayınlama ve düzenleme</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-sleek h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle me-3"><i class="fa-solid fa-credit-card"></i></div>
                        <div>
                            <div class="fw-semibold">Online Bağış</div>
                            <div class="text-muted small">Dakikalar içinde formu doldur, kaydedilsin.</div>
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
                            <button class="btn btn-primary w-100" type="submit">Devam Et</button>
                        </div>
                    </form>
                    <div class="border-top mt-3 pt-3">
                        <div class="d-flex align-items-start gap-3">
                            <div class="icon-circle"><i class="fa-solid fa-envelope-open-text"></i></div>
                            <div>
                                <div class="fw-semibold">İletişim Talepleri</div>
                                <div class="text-muted small">Form kayıtlarını panelden inceleyin, yanıtlayın.</div>
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
                <p class="label-pill mb-2"><i class="fa-solid fa-image"></i> Galeri</p>
                <h2 class="section-title mb-0">Fotoğraflar ve videolar</h2>
            </div>
            <a class="btn btn-outline-primary" href="events.php">Galeriye Git</a>
        </div>
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="gallery-card">
                    <img src="https://images.unsplash.com/photo-1545239351-1141bd82e8a6?auto=format&fit=crop&w=1400&q=80" alt="Toplantı">
                    <span class="badge bg-primary">Foto Galeri</span>
                </div>
            </div>
            <div class="col-lg-4 d-flex flex-column gap-4">
                <div class="gallery-card">
                    <img src="https://images.unsplash.com/photo-1529333166433-0f3f7e2b2f77?auto=format&fit=crop&w=800&q=80" alt="Video">
                    <span class="badge bg-danger"><i class="fa-solid fa-play"></i> Video</span>
                </div>
                <div class="gallery-card">
                    <img src="https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=800&q=80" alt="Saha çalışması">
                    <span class="badge bg-primary">Saha Çalışması</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <p class="label-pill mb-2"><i class="fa-solid fa-handshake"></i> İş Ortakları</p>
                <h2 class="section-title mb-3">Güvenilir sponsor ve destekçiler</h2>
                <p class="text-muted">Programlarımızı güçlendiren kurum ve markalarla sürdürülebilir iş birlikleri yürütüyoruz.</p>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <?php foreach ($siteData['partners'] as $partner): ?>
                        <span class="badge bg-light text-dark px-3 py-2 fw-semibold"><?= $partner; ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <p class="label-pill mb-2"><i class="fa-solid fa-comments"></i> Referanslar</p>
                <div class="card-sleek h-100">
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($siteData['testimonials'] as $testimonial): ?>
                            <div>
                                <div class="fw-semibold mb-1"><?= $testimonial['name']; ?> <span class="text-muted">· <?= $testimonial['role']; ?></span></div>
                                <div class="text-muted fst-italic">“<?= $testimonial['quote']; ?>”</div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
