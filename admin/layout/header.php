<?php
require_once __DIR__ . '/../init.php';
require_login();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetim Paneli | DernekWeb</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css">
    <style>
        body { background: #f5f7fb; }
        .sidebar { min-width: 240px; background: #0c2340; color: #fff; }
        .sidebar a { color: #dbeafe; text-decoration: none; }
        .sidebar a.active, .sidebar a:hover { color: #fff; font-weight: 600; }
        .sidebar .nav-link { padding: 0.65rem 1rem; border-radius: 0.5rem; }
        .topbar { background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .content { padding: 24px; }
    </style>
</head>
<body>
<div class="d-flex">
    <aside class="sidebar d-flex flex-column p-3 vh-100 sticky-top">
        <div class="d-flex align-items-center mb-4">
            <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width:38px;height:38px;">
                <i class="fa-solid fa-building"></i>
            </div>
            <strong>DernekWeb Admin</strong>
        </div>
        <nav class="nav flex-column gap-1">
            <a class="nav-link<?php echo str_contains($_SERVER['REQUEST_URI'], 'dashboard') ? ' active' : ''; ?>" href="/admin/dashboard.php"><i class="fa-solid fa-gauge me-2"></i>Kontrol Paneli</a>
            <a class="nav-link<?php echo str_contains($_SERVER['REQUEST_URI'], 'stats') ? ' active' : ''; ?>" href="/admin/stats.php"><i class="fa-solid fa-chart-column me-2"></i>İstatistikler</a>
            <a class="nav-link<?php echo str_contains($_SERVER['REQUEST_URI'], 'programs') ? ' active' : ''; ?>" href="/admin/programs.php"><i class="fa-solid fa-layer-group me-2"></i>Programlar</a>
            <a class="nav-link<?php echo str_contains($_SERVER['REQUEST_URI'], 'events') ? ' active' : ''; ?>" href="/admin/events.php"><i class="fa-solid fa-calendar-days me-2"></i>Etkinlikler</a>
            <a class="nav-link<?php echo str_contains($_SERVER['REQUEST_URI'], 'news') ? ' active' : ''; ?>" href="/admin/news.php"><i class="fa-solid fa-newspaper me-2"></i>Haberler</a>
            <a class="nav-link<?php echo str_contains($_SERVER['REQUEST_URI'], 'testimonials') ? ' active' : ''; ?>" href="/admin/testimonials.php"><i class="fa-solid fa-comments me-2"></i>Referanslar</a>
            <a class="nav-link<?php echo str_contains($_SERVER['REQUEST_URI'], 'partners') ? ' active' : ''; ?>" href="/admin/partners.php"><i class="fa-solid fa-handshake me-2"></i>İş Ortakları</a>
            <a class="nav-link<?php echo str_contains($_SERVER['REQUEST_URI'], 'messages') ? ' active' : ''; ?>" href="/admin/messages.php"><i class="fa-solid fa-envelope-open-text me-2"></i>Form Kayıtları</a>
            <a class="nav-link<?php echo str_contains($_SERVER['REQUEST_URI'], 'settings') ? ' active' : ''; ?>" href="/admin/settings.php"><i class="fa-solid fa-gear me-2"></i>Site Ayarları</a>
        </nav>
        <div class="mt-auto">
            <a class="btn btn-outline-light w-100" href="/admin/logout.php"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Çıkış Yap</a>
        </div>
    </aside>
    <div class="flex-grow-1">
        <header class="topbar d-flex align-items-center justify-content-between px-4 py-3">
            <div>
                <div class="small text-muted">Yönetim</div>
                <div class="fw-semibold">İçerik ve formları yönetin</div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-primary">Paylaşımlı hosting hazır</span>
            </div>
        </header>
        <main class="content">
