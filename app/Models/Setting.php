<?php
namespace App\Models;

use App\Core\Model;

class Setting extends Model
{
    public function get(string $key, $default = null)
    {
        $stmt = $this->db()->prepare('SELECT value FROM settings WHERE `key` = :key');
        $stmt->execute(['key' => $key]);
        $value = $stmt->fetchColumn();
        return $value !== false ? $value : $default;
    }

    public function set(string $key, string $value): bool
    {
        $stmt = $this->db()->prepare('INSERT INTO settings(`key`, value) VALUES (:key, :value) ON DUPLICATE KEY UPDATE value = VALUES(value)');
        return $stmt->execute(['key' => $key, 'value' => $value]);
    }
}
