<?php $settings = $siteData['settings'] ?? []; ?>
<footer class="footer pt-5 pb-4">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="d-flex align-items-center mb-3">
                    <span class="brand-mark me-2"><i class="fa-solid fa-hand-holding-heart"></i></span>
                    <div class="fw-bold text-white">DernekWeb</div>
                </div>
                <p class="mb-3">Dayanışma projelerimizi şeffaf raporlar ve güvenli bağış altyapısıyla destekliyoruz.</p>
                <div class="d-flex gap-3">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-md-3">
                <h6 class="fw-bold mb-3">Kurumsal</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="about.php">Hakkımızda</a></li>
                    <li class="mb-2"><a href="events.php">Etkinlikler</a></li>
                    <li class="mb-2"><a href="news.php">Haberler</a></li>
                    <li class="mb-2"><a href="contact.php">İletişim</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="fw-bold mb-3">Hızlı İşlemler</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="donate.php">Online Bağış</a></li>
                    <li class="mb-2"><a href="contact.php">Destek Talebi</a></li>
                    <li class="mb-2"><a href="admin/login.php">Yönetim Paneli</a></li>
                    <li class="mb-2"><a href="#">Bülten Üyeliği</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="fw-bold mb-3">İletişim</h6>
                <p class="mb-1"><i class="fa-solid fa-location-dot me-2"></i><?= sanitize($settings['info_address'] ?? 'İstanbul, Türkiye'); ?></p>
                <p class="mb-1"><i class="fa-solid fa-phone me-2"></i><?= sanitize($settings['info_phone'] ?? '+90 312 123 45 67'); ?></p>
                <p class="mb-3"><i class="fa-solid fa-envelope me-2"></i><?= sanitize($settings['info_email'] ?? 'destek@dernekweb.com'); ?></p>
                <div class="d-flex gap-2">
                    <span class="badge bg-light text-dark">KVKK</span>
                    <span class="badge bg-light text-dark">Açık Rıza</span>
                    <span class="badge bg-light text-dark">Gizlilik</span>
                </div>
            </div>
        </div>
        <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center text-white-50 small mt-4">
            <span>© <?= date('Y'); ?> DernekWeb · Tüm hakları saklıdır.</span>
            <div class="d-flex gap-3 align-items-center">
                <span class="small">Paylaşımlı hosting uyumlu</span>
                <span class="small">MySQL + phpMyAdmin hazır</span>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
