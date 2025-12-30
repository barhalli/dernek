<?php include __DIR__ . '/layout/header.php';

$counts = [
    'stats' => $pdo ? (int) $pdo->query('SELECT COUNT(*) FROM stats')->fetchColumn() : count($siteData['stats'] ?? []),
    'programs' => $pdo ? (int) $pdo->query('SELECT COUNT(*) FROM programs')->fetchColumn() : count($siteData['programs'] ?? []),
    'events' => $pdo ? (int) $pdo->query('SELECT COUNT(*) FROM events')->fetchColumn() : count($siteData['events'] ?? []),
    'news' => $pdo ? (int) $pdo->query('SELECT COUNT(*) FROM news')->fetchColumn() : count($siteData['news'] ?? []),
];

$recentMessages = [];
$recentDonations = [];
if ($pdo) {
    $recentMessages = $pdo->query('SELECT name, email, created_at FROM contact_messages ORDER BY created_at DESC LIMIT 5')->fetchAll();
    $recentDonations = $pdo->query('SELECT fullname, amount, created_at FROM donations ORDER BY created_at DESC LIMIT 5')->fetchAll();
}
?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h4 mb-1">Kontrol Paneli</h1>
        <p class="text-muted mb-0">Site istatistiklerini ve formları yönetin.</p>
    </div>
    <a class="btn btn-primary" href="<?= url_for('index.php'); ?>" target="_blank"><i class="fa-solid fa-up-right-from-square me-2"></i>Siteyi Aç</a>
</div>
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">İstatistik Kartları</div>
                <div class="h3 mb-0"><?= $counts['stats']; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Program</div>
                <div class="h3 mb-0"><?= $counts['programs']; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Etkinlik</div>
                <div class="h3 mb-0"><?= $counts['events']; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Haber</div>
                <div class="h3 mb-0"><?= $counts['news']; ?></div>
            </div>
        </div>
    </div>
</div>
<div class="row g-3">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Son İletişim Mesajları</h5>
                    <a class="small" href="messages.php">Tümü</a>
                </div>
                <?php if (!$pdo): ?>
                    <p class="text-muted small mb-0">Veritabanı bağlantısı olmadığı için örnek veriler gösterilmiyor.</p>
                <?php elseif (empty($recentMessages)): ?>
                    <p class="text-muted small mb-0">Henüz kayıt yok.</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentMessages as $message): ?>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold"><?= sanitize($message['name']); ?></div>
                                    <div class="text-muted small"><?= sanitize($message['email']); ?></div>
                                </div>
                                <span class="badge bg-light text-dark"><?= date('d.m.Y', strtotime($message['created_at'])); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Son Bağışlar</h5>
                    <a class="small" href="messages.php#donations">Tümü</a>
                </div>
                <?php if (!$pdo): ?>
                    <p class="text-muted small mb-0">Veritabanı bağlantısı olmadığı için örnek veriler gösterilmiyor.</p>
                <?php elseif (empty($recentDonations)): ?>
                    <p class="text-muted small mb-0">Henüz kayıt yok.</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentDonations as $donation): ?>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold"><?= sanitize($donation['fullname']); ?></div>
                                    <div class="text-muted small">₺<?= number_format((float) $donation['amount'], 2); ?></div>
                                </div>
                                <span class="badge bg-light text-dark"><?= date('d.m.Y', strtotime($donation['created_at'])); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/layout/footer.php';
