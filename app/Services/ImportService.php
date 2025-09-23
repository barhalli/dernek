<?php
namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportService
{
    public function parse(string $path): array
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if ($extension === 'xlsx' && class_exists(IOFactory::class)) {
            $spreadsheet = IOFactory::load($path);
            return $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
        }

        $rows = [];
        if (($handle = fopen($path, 'r')) !== false) {
            while (($data = fgetcsv($handle, 0, ';')) !== false) {
                $rows[] = $data;
            }
            fclose($handle);
        }
        return $rows;
    }
}
