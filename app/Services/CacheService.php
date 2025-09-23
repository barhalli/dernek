<?php
namespace App\Services;

class CacheService
{
    protected string $path;

    public function __construct()
    {
        $config = require __DIR__ . '/../Config/config.php';
        $this->path = $config['storage']['cache_path'];
        if (!is_dir($this->path)) {
            mkdir($this->path, 0755, true);
        }
    }

    public function remember(string $key, int $ttl, callable $callback)
    {
        $file = $this->path . '/' . md5($key) . '.cache';
        if (file_exists($file) && (filemtime($file) + $ttl) > time()) {
            return unserialize(file_get_contents($file));
        }

        $value = $callback();
        file_put_contents($file, serialize($value));
        return $value;
    }

    public function forget(string $key): void
    {
        $file = $this->path . '/' . md5($key) . '.cache';
        if (file_exists($file)) {
            unlink($file);
        }
    }
}
