<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Import library Dompdf
require_once("./vendor/autoload.php");
use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf {
    public function generate($html, $filename='', $paper = '', $orientation = '', $stream=TRUE)
    {
        // Konfigurasi opsi Dompdf agar bisa memuat gambar/css eksternal
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();

        if ($stream) {
            // Preview di browser atau download otomatis
            $dompdf->stream($filename.".pdf", array("Attachment" => 0));
        } else {
            return $dompdf->output();
        }
    }
}