<?php
require __DIR__ . '/config/database.php';
require __DIR__ . '/includes/functions.php';

$pageTitle = 'Bağış Yap | DernekWeb';
$success = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payload = [
        'fullname' => sanitize($_POST['fullname'] ?? ''),
        'email' => sanitize($_POST['email'] ?? ''),
        'phone' => sanitize($_POST['phone'] ?? ''),
        'amount' => (float) ($_POST['amount'] ?? 0),
        'note' => sanitize($_POST['note'] ?? ''),
    ];

    if (store_donation($pdo, $payload)) {
        $success = 'Bağışınız kaydedildi. Teşekkür ederiz!';
    } else {
        $error = 'İşlem sırasında bir sorun oluştu. Lütfen bilgilerinizi kontrol edin veya daha sonra tekrar deneyin.';
    }
}

include __DIR__ . '/includes/head.php';
include __DIR__ . '/includes/header.php';
?>
<section class="page-hero py-5">
    <div class="container">
        <p class="text-uppercase text-primary fw-bold label-pill mb-2">Bağış</p>
        <h1 class="section-title mb-3">Etkisi ölçülebilir bağış deneyimi</h1>
        <p class="text-muted col-lg-7">Form verileri MySQL veritabanındaki <code>donations</code> tablosuna kaydedilir. PhpMyAdmin veya PDO tabanlı admin araçlarıyla raporlayabilirsiniz.</p>
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
                            <input type="text" name="fullname" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">E-posta</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telefon</label>
                            <input type="text" name="phone" class="form-control" placeholder="5xx xxx xx xx">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tutar (₺)</label>
                            <input type="number" name="amount" class="form-control" min="10" step="10" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notunuz</label>
                            <textarea name="note" rows="3" class="form-control" placeholder="Proje tercihlerinizi paylaşın"></textarea>
                        </div>
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <div class="text-muted small"><i class="fa-solid fa-lock me-2"></i>Bilgiler SSL üzerinden güvenle iletilir.</div>
                            <button class="btn btn-primary" type="submit">Bağışımı Gönder</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Bankadan bağış</h5>
                        <p class="text-muted">Paylaşımlı hosting ortamında çevrimiçi ödeme entegre edilmemiştir. Bağışlarınızı banka transferi ile iletebilir, dekontu iletişim formu üzerinden paylaşabilirsiniz.</p>
                        <div class="bg-light border rounded-3 p-3 mb-3">
                            <div class="fw-semibold">Hesap Bilgileri</div>
                            <div class="text-muted small">DernekWeb Yardımlaşma Derneği</div>
                            <div class="text-muted small">IBAN: TR00 0000 0000 0000 0000 0000 00</div>
                        </div>
                        <h6 class="fw-bold">Sık Sorulanlar</h6>
                        <ul class="text-muted small ps-3">
                            <li>Bağışlar phpMyAdmin üzerinden dışa aktarılabilir.</li>
                            <li>Veri yedekleri <code>schema.sql</code> şemasına göre alınabilir.</li>
                            <li>SSL sertifikası olan tüm hostinglerde sorunsuz çalışır.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
