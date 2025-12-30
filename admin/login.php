<?php
require_once __DIR__ . '/init.php';

if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    if ($user === $adminSettings['user'] && $pass === $adminSettings['pass']) {
        $_SESSION['admin_logged_in'] = true;
        $target = $_GET['redirect'] ?? 'dashboard.php';
        header('Location: ' . $target);
        exit;
    }
    $error = 'Kullanıcı adı veya şifre hatalı.';
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetim Girişi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:48px;height:48px;">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <h5 class="fw-bold">Yönetim Paneli</h5>
                            <p class="text-muted small mb-0">Lütfen admin bilgilerinizle giriş yapın.</p>
                        </div>
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= $error; ?></div>
                        <?php endif; ?>
                        <form method="post" class="vstack gap-3">
                            <div>
                                <label class="form-label">Kullanıcı Adı</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div>
                                <label class="form-label">Şifre</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
                        </form>
                        <p class="text-muted small mt-3 mb-0">Varsayılan bilgiler config.php içinde güncellenebilir.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
