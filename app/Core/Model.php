<?php
namespace App\Core;

use PDO;

abstract class Model
{
    protected static ?PDO $db = null;

    public function __construct()
    {
        if (self::$db === null) {
            self::$db = require __DIR__ . '/../Config/database.php';
        }
    }

    protected function db(): PDO
    {
        if (self::$db === null) {
            self::$db = require __DIR__ . '/../Config/database.php';
        }
        return self::$db;
    }
}
