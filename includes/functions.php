<?php
function load_data(?PDO $pdo = null): array
{
    $fallback = require __DIR__ . '/../data/sample_data.php';

    if (!$pdo) {
        return $fallback;
    }

    try {
        return [
            'stats' => fetch_stats($pdo) ?: $fallback['stats'],
            'programs' => fetch_programs($pdo) ?: $fallback['programs'],
            'events' => fetch_events($pdo) ?: $fallback['events'],
            'news' => fetch_news($pdo) ?: $fallback['news'],
            'testimonials' => fetch_testimonials($pdo) ?: $fallback['testimonials'],
            'partners' => fetch_partners($pdo) ?: $fallback['partners'],
        ];
    } catch (Throwable $exception) {
        return $fallback;
    }
}

function fetch_stats(PDO $pdo): array
{
    $stmt = $pdo->query('SELECT label, value FROM stats ORDER BY id ASC');
    return $stmt->fetchAll();
}

function fetch_programs(PDO $pdo): array
{
    $stmt = $pdo->query('SELECT title, description, icon FROM programs ORDER BY id ASC');
    return $stmt->fetchAll();
}

function fetch_events(PDO $pdo): array
{
    $stmt = $pdo->query('SELECT title, event_date AS date, location, summary FROM events ORDER BY event_date ASC');
    return $stmt->fetchAll();
}

function fetch_news(PDO $pdo): array
{
    $stmt = $pdo->query('SELECT title, published_at AS date, author, summary, content FROM news ORDER BY published_at DESC');
    return $stmt->fetchAll();
}

function fetch_testimonials(PDO $pdo): array
{
    $stmt = $pdo->query('SELECT name, role, quote FROM testimonials ORDER BY id ASC');
    return $stmt->fetchAll();
}

function fetch_partners(PDO $pdo): array
{
    $stmt = $pdo->query('SELECT name FROM partners ORDER BY id ASC');
    return array_column($stmt->fetchAll(), 'name');
}

function store_contact(?PDO $pdo = null, array $payload = []): bool
{
    if (!$pdo) {
        return false;
    }

    $sql = 'INSERT INTO contact_messages (name, email, phone, message) VALUES (:name, :email, :phone, :message)';
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':name' => $payload['name'] ?? '',
        ':email' => $payload['email'] ?? '',
        ':phone' => $payload['phone'] ?? '',
        ':message' => $payload['message'] ?? '',
    ]);
}

function store_donation(?PDO $pdo = null, array $payload = []): bool
{
    if (!$pdo) {
        return false;
    }

    $sql = 'INSERT INTO donations (fullname, email, phone, amount, note) VALUES (:fullname, :email, :phone, :amount, :note)';
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':fullname' => $payload['fullname'] ?? '',
        ':email' => $payload['email'] ?? '',
        ':phone' => $payload['phone'] ?? '',
        ':amount' => $payload['amount'] ?? 0,
        ':note' => $payload['note'] ?? '',
    ]);
}

function sanitize(string $value): string
{
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}
