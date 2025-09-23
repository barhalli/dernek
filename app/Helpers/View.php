<?php
namespace App\Helpers;

class View
{
    public static string $basePath = __DIR__ . '/../Views/';

    public static function render(string $view, array $data = [], string $layout = 'main')
    {
        $content = self::renderPartial($view, $data);
        $layoutPath = self::$basePath . 'layouts/' . $layout . '.php';

        if (!file_exists($layoutPath)) {
            throw new \RuntimeException('Layout bulunamadı: ' . $layoutPath);
        }

        $data['content'] = $content;
        extract($data);
        include $layoutPath;
    }

    public static function renderPartial(string $view, array $data = [])
    {
        $viewPath = self::$basePath . $view . '.php';
        if (!file_exists($viewPath)) {
            throw new \RuntimeException('View bulunamadı: ' . $viewPath);
        }
        extract($data);
        ob_start();
        include $viewPath;
        return ob_get_clean();
    }
}
