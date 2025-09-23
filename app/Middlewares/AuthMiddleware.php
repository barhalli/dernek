<?php
namespace App\Middlewares;

use App\Helpers\Response;

class AuthMiddleware
{
    public static function handle(callable $next)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['user'])) {
            Response::redirect('/login');
        }
        return $next();
    }
}
