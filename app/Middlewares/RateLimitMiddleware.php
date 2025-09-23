<?php
namespace App\Middlewares;

class RateLimitMiddleware
{
    public static function handle(callable $next)
    {
        $config = require __DIR__ . '/../Config/config.php';
        $settings = $config['security']['rate_limit']['login'];
        $key = sha1(($_SERVER['REMOTE_ADDR'] ?? 'cli') . ($_POST['email'] ?? 'unknown'));
        $file = $config['storage']['cache_path'] . '/rl_' . $key . '.json';

        $attempts = ['count' => 0, 'expires_at' => time()];
        if (file_exists($file)) {
            $attempts = json_decode(file_get_contents($file), true) ?: $attempts;
        }

        if ($attempts['count'] >= $settings['max_attempts'] && $attempts['expires_at'] > time()) {
            http_response_code(429);
            exit('Çok fazla giriş denemesi. Lütfen birkaç dakika sonra tekrar deneyiniz.');
        }

        register_shutdown_function(function () use ($file, $settings) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (!empty($_SESSION['rate_limit_failed'])) {
                $current = ['count' => 0, 'expires_at' => time()];
                if (file_exists($file)) {
                    $current = json_decode(file_get_contents($file), true) ?: $current;
                }
                $current['count'] = ($current['count'] ?? 0) + 1;
                $current['expires_at'] = time() + ($settings['decay_minutes'] * 60);
                file_put_contents($file, json_encode($current));
                unset($_SESSION['rate_limit_failed']);
            } elseif (!empty($_SESSION['user']) && file_exists($file)) {
                unlink($file);
            }
        });

        return $next();
    }
}
