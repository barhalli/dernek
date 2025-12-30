<?php $settings = $siteData['settings'] ?? []; ?>
<div class="topbar d-none d-lg-block">
    <div class="container d-flex justify-content-between align-items-center py-2 small">
        <div class="d-flex align-items-center gap-3 text-white-50">
            <span><i class="fa-solid fa-bullhorn me-1"></i> <?= sanitize($settings['topbar_note'] ?? 'Şeffaflık ve güven ile 18 ilde aktifiz.'); ?></span>
            <span><i class="fa-solid fa-phone me-1"></i> <?= sanitize($settings['info_phone'] ?? '+90 312 123 45 67'); ?></span>
            <span><i class="fa-solid fa-envelope me-1"></i> <?= sanitize($settings['info_email'] ?? 'info@dernekweb.com'); ?></span>
            <span><i class="fa-solid fa-location-dot me-1"></i> <?= sanitize($settings['info_address'] ?? 'Ankara, Türkiye'); ?></span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a class="text-white" href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
            <a class="text-white" href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            <a class="text-white" href="#" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
            <a class="text-white" href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
        </div>
    </div>
</div>
<header class="navbar navbar-expand-lg navbar-light main-nav shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center fw-bold" href="<?= url_for(''); ?>">
            <span class="brand-mark me-2"><i class="fa-solid fa-hand-holding-heart"></i></span>
            DernekWeb
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Menüyü Aç">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="<?= url_for(''); ?>">ANA SAYFA</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url_for('about.php'); ?>">HAKKIMIZDA</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url_for('events.php'); ?>">ETKİNLİKLER</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url_for('news.php'); ?>">HABERLER</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url_for('donate.php'); ?>">BAĞIŞ</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url_for('contact.php'); ?>">İLETİŞİM</a></li>
                <li class="nav-item"><a class="btn btn-primary nav-cta" href="<?= sanitize($settings['hero_primary_link'] ?? url_for('donate.php')); ?>"><?= sanitize($settings['hero_primary_cta'] ?? 'Hızlı Bağış'); ?></a></li>
            </ul>
        </div>
    </div>
</header>
