<?php
namespace App\Middlewares;

use App\Helpers\Csrf;

class CsrfMiddleware
{
    public static function handle(callable $next)
    {
        $token = $_POST[Csrf::key()] ?? null;
        if (!Csrf::check($token)) {
            http_response_code(403);
            exit('Geçersiz güvenlik tokenı. Lütfen formu yeniden gönderin.');
        }
        return $next();
    }
}
