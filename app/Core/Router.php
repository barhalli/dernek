<?php
namespace App\Core;

use App\Middlewares\AuthMiddleware;
use App\Middlewares\CsrfMiddleware;
use App\Middlewares\RateLimitMiddleware;

class Router
{
    protected array $routes = [];
    protected array $globalMiddlewares = [];
    protected string $basePath = '';

    public function setBasePath(string $basePath): void
    {
        $this->basePath = '/' . trim($basePath, '/');
        if ($this->basePath === '/') {
            $this->basePath = '';
        }
    }

    public function add(string $method, string $path, array $handler, array $middlewares = []): void
    {
        $method = strtoupper($method);
        $this->routes[$method][] = [
            'path' => $path,
            'handler' => $handler,
            'middlewares' => $middlewares,
            'regex' => $this->convertPathToRegex($path),
        ];
    }

    public function addMiddleware(callable $middleware): void
    {
        $this->globalMiddlewares[] = $middleware;
    }

    protected function convertPathToRegex(string $path): string
    {
        $pattern = preg_replace('#\{([a-zA-Z0-9_]+)\}#', '(?P<$1>[^/]+)', $path);
        return '#^' . rtrim($pattern, '/') . '$#';
    }

    public function dispatch(string $method, string $uri)
    {
        $method = strtoupper($method);
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';

        if ($this->basePath !== '' && strpos($path, $this->basePath) === 0) {
            $path = substr($path, strlen($this->basePath));
        }

        $uri = '/' . trim($path, '/');
        if ($uri === '/') {
            $uri = '/';
        }

        $routes = $this->routes[$method] ?? [];
        foreach ($routes as $route) {
            if (preg_match($route['regex'], $uri, $matches)) {
                $params = [];
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $params[$key] = $value;
                    }
                }

                $middlewares = array_merge($this->globalMiddlewares, $this->resolveMiddlewares($route['middlewares']));

                $handler = $route['handler'];
                return $this->runMiddlewares($middlewares, function () use ($handler, $params) {
                    [$controllerClass, $method] = $handler;
                    $controller = new $controllerClass();
                    return call_user_func_array([$controller, $method], $params);
                });
            }
        }

        http_response_code(404);
        echo 'Sayfa bulunamadı.';
    }

    protected function resolveMiddlewares(array $middlewares): array
    {
        $resolved = [];
        foreach ($middlewares as $middleware) {
            switch ($middleware['type'] ?? $middleware) {
                case 'auth':
                    $resolved[] = [AuthMiddleware::class, 'handle'];
                    break;
                case 'csrf':
                    $resolved[] = [CsrfMiddleware::class, 'handle'];
                    break;
                case 'rate_limit':
                    $resolved[] = [RateLimitMiddleware::class, 'handle'];
                    break;
                default:
                    if (is_callable($middleware)) {
                        $resolved[] = $middleware;
                    }
                    break;
            }
        }
        return $resolved;
    }

    protected function runMiddlewares(array $middlewares, callable $destination)
    {
        $handler = array_reduce(
            array_reverse($middlewares),
            function ($next, $middleware) {
                return function () use ($middleware, $next) {
                    return call_user_func($middleware, $next);
                };
            },
            $destination
        );

        return $handler();
    }
}
