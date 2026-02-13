<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property M_transaksi $M_transaksi
 * @property Pdf $pdf
 */
class Laporan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_transaksi');
        
        // Proteksi login: Tendang kembali ke halaman login jika session tidak ada
        if($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
    }

    /**
     * Menampilkan daftar seluruh laporan teknis
     */
    public function index() {
        // Mengambil data akumulasi dari model (Stored Procedure AGA8)
        $data['report'] = $this->M_transaksi->get_book_report();
        $this->load->view('v_laporan_list', $data);
    }

    /**
     * Menampilkan detail teknis dari satu transaksi spesifik
     */
    public function detail($id) {
        // Mengambil baris data spesifik berdasarkan ID
        $data['d'] = $this->M_transaksi->get_detail_transaksi($id);
        
        if(!$data['d']) {
            show_404();
        }

        $this->load->view('v_laporan_detail', $data);
    }

    /**
     * Fitur Cetak PDF untuk laporan resmi per transaksi
     * Fungsi ini dipanggil dari tombol ikon PDF di v_laporan.php
     */
public function cetak_pdf($id) {
    $data['transaksi'] = $this->M_transaksi->get_detail_transaksi($id);
    
    if(!$data['transaksi']) {
        show_404();
    }

    // Memanggil library yang baru saja kita buat
    $this->load->library('pdf');

    $filename = 'GASRA_Log_' . $id;
    $html = $this->load->view('v_pdf_template', $data, true);
    
    // Menjalankan fungsi generate di library Pdf.php
    $this->pdf->generate($html, $filename, 'A4', 'portrait');
}
}