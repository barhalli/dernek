<?php
namespace App\Core;

use App\Helpers\View;
use App\Helpers\Flash;

abstract class Controller
{
    public function view(string $view, array $data = [], string $layout = 'main')
    {
        return View::render($view, $data, $layout);
    }

    public function redirect(string $path)
    {
        header('Location: ' . $path);
        exit;
    }

    public function back()
    {
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
        exit;
    }
}
