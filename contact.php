<?php
require __DIR__ . '/config/database.php';
require __DIR__ . '/includes/functions.php';

$pageTitle = 'İletişim | DernekWeb';
$success = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payload = [
        'name' => sanitize($_POST['name'] ?? ''),
        'email' => sanitize($_POST['email'] ?? ''),
        'phone' => sanitize($_POST['phone'] ?? ''),
        'message' => sanitize($_POST['message'] ?? ''),
    ];

    if (store_contact($pdo, $payload)) {
        $success = 'Mesajınız alındı, en kısa sürede dönüş yapacağız.';
    } else {
        $error = 'Mesaj kaydedilemedi. Lütfen formu kontrol edip tekrar deneyin.';
    }
}

include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>
<section class="page-hero py-5">
    <div class="container">
        <p class="text-uppercase text-primary fw-bold label-pill mb-2">İletişim</p>
        <h1 class="section-title mb-3">Bizimle iletişime geçin</h1>
        <p class="text-muted col-lg-7">Form verileri MySQL <code>contact_messages</code> tablosunda saklanır. PhpMyAdmin üzerinden görüntülenebilir veya CSV olarak indirilebilir.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="contact-card shadow-sm">
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?= $success; ?></div>
                    <?php elseif ($error): ?>
                        <div class="alert alert-danger"><?= $error; ?></div>
                    <?php endif; ?>

                    <form method="post" class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Ad Soyad</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">E-posta</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telefon</label>
                            <input type="text" name="phone" class="form-control" placeholder="5xx xxx xx xx">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Mesajınız</label>
                            <textarea name="message" rows="4" class="form-control" required></textarea>
                        </div>
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <div class="text-muted small"><i class="fa-solid fa-shield-check me-2"></i>Veriler yalnızca iletişim için saklanır.</div>
                            <button class="btn btn-primary" type="submit">Gönder</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">İletişim Kanalları</h5>
                        <p class="text-muted">Saha çalışmaları, bağış süreçleri veya basın talepleri için aşağıdaki kanallardan bize ulaşabilirsiniz.</p>
                        <ul class="list-unstyled text-muted">
                            <li class="mb-2"><i class="fa-solid fa-envelope text-primary me-2"></i>info@dernekweb.org</li>
                            <li class="mb-2"><i class="fa-solid fa-phone text-primary me-2"></i>+90 212 000 00 00</li>
                            <li class="mb-2"><i class="fa-solid fa-location-dot text-primary me-2"></i>Ankara, Türkiye</li>
                        </ul>
                        <hr>
                        <h6 class="fw-bold">Çalışma Saatleri</h6>
                        <p class="text-muted mb-0">Hafta içi 09:00 - 18:00 arasında yanıt veriyoruz. Acil durumlar için formu kullanabilirsiniz.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
