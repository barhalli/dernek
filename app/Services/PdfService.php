<?php
namespace App\Services;

class PdfService
{
    public function download(string $title, string $html): void
    {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $title . '.pdf"');
        if (class_exists('TCPDF')) {
            $pdf = new \TCPDF();
            $pdf->AddPage();
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output($title . '.pdf', 'I');
            exit;
        }
        // Fallback: provide printable HTML
        echo '<html><head><meta charset="utf-8"><title>' . htmlspecialchars($title) . '</title></head><body>';
        echo '<p>PDF kütüphanesi bulunamadı. Bu içerik tarayıcı yazdır seçeneği ile PDF olarak kaydedilebilir.</p>';
        echo $html;
        echo '</body></html>';
        exit;
    }
}
