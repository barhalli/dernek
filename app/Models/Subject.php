<?php
namespace App\Models;

use App\Core\Model;

class Subject extends Model
{
    public function all(): array
    {
        $stmt = $this->db()->query('SELECT * FROM subjects ORDER BY name');
        return $stmt->fetchAll();
    }
}
