<?php include __DIR__ . '/layout/header.php';

$contactMessages = [];
$donations = [];
if ($pdo) {
    $contactMessages = $pdo->query('SELECT name, email, phone, message, created_at FROM contact_messages ORDER BY created_at DESC LIMIT 50')->fetchAll();
    $donations = $pdo->query('SELECT fullname, email, phone, amount, note, created_at FROM donations ORDER BY created_at DESC LIMIT 50')->fetchAll();
}
?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h4 mb-1">Form Kayıtları</h1>
        <p class="text-muted mb-0">İletişim ve bağış formlarını görüntüleyin.</p>
    </div>
</div>
<?php if (!$pdo): ?>
    <div class="alert alert-warning">Veritabanı bağlantısı kurulamadı. Kayıtları görebilmek için config.php ayarlarını güncelleyin.</div>
<?php endif; ?>
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="card-title">İletişim Mesajları</h5>
        <?php if (!$pdo): ?>
            <p class="text-muted small mb-0">Bağlantı olmadığı için kayıt gösterilemiyor.</p>
        <?php elseif (empty($contactMessages)): ?>
            <p class="text-muted small mb-0">Henüz kayıt yok.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Ad Soyad</th><th>E-posta</th><th>Telefon</th><th>Mesaj</th><th>Tarih</th></tr></thead>
                    <tbody>
                    <?php foreach ($contactMessages as $message): ?>
                        <tr>
                            <td><?= sanitize($message['name']); ?></td>
                            <td><?= sanitize($message['email']); ?></td>
                            <td><?= sanitize($message['phone']); ?></td>
                            <td><?= sanitize($message['message']); ?></td>
                            <td><?= date('d.m.Y H:i', strtotime($message['created_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="card shadow-sm border-0" id="donations">
    <div class="card-body">
        <h5 class="card-title">Bağışlar</h5>
        <?php if (!$pdo): ?>
            <p class="text-muted small mb-0">Bağlantı olmadığı için kayıt gösterilemiyor.</p>
        <?php elseif (empty($donations)): ?>
            <p class="text-muted small mb-0">Henüz kayıt yok.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Ad Soyad</th><th>E-posta</th><th>Telefon</th><th>Tutar</th><th>Not</th><th>Tarih</th></tr></thead>
                    <tbody>
                    <?php foreach ($donations as $donation): ?>
                        <tr>
                            <td><?= sanitize($donation['fullname']); ?></td>
                            <td><?= sanitize($donation['email']); ?></td>
                            <td><?= sanitize($donation['phone']); ?></td>
                            <td>₺<?= number_format((float) $donation['amount'], 2); ?></td>
                            <td><?= sanitize($donation['note']); ?></td>
                            <td><?= date('d.m.Y H:i', strtotime($donation['created_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include __DIR__ . '/layout/footer.php';
