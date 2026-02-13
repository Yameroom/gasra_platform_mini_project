<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property M_transaksi $M_transaksi
 * @property M_pilihan $M_pilihan
 */
class Transaksi extends CI_Controller { // Nama Class HARUS Transaksi

    public function __construct() {
        parent::__construct();
        // Load model yang benar-benar dibutuhkan untuk input data
        $this->load->model('M_transaksi');
        $this->load->model('M_pilihan');
        
        // Proteksi login
        if($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
    }

    public function index() {
        redirect(base_url('laporan'));
    }

    /**
     * Menampilkan form untuk input transaksi baru
     */
    public function tambah() {
        // Mengambil data untuk dropdown di form
        $data['customers'] = $this->M_pilihan->get_customer();
        $data['trailers'] = $this->M_pilihan->get_trailer();
        $data['user_now'] = $this->session->userdata('nama');
        
        // Memanggil view form tambah
        $this->load->view('v_tambah_transaksi', $data);
    }

    /**
     * Memproses penyimpanan data dari form ke SQL Server
     */
    public function aksi_tambah() {
        // Membersihkan format datetime-local
        $tgl_kirim = str_replace('T', ' ', $this->input->post('tgl_kirim'));
        $tgl_ambil = str_replace('T', ' ', $this->input->post('tgl_ambil'));

        $data = array(
            'customer'   => $this->input->post('customer'),
            'craddle'    => $this->input->post('craddle'),
            'tgl_kirim'  => $tgl_kirim,
            'tgl_ambil'  => $tgl_ambil,
            'p_awal'     => $this->input->post('p_awal'),
            'p_akhir'    => $this->input->post('p_akhir'),
            'created_at' => date('Y-m-d H:i:s')
        );

        $simpan = $this->M_transaksi->simpan_data($data);

        if($simpan) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success">Transaksi Berhasil Disimpan!</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Gagal menyimpan data.</div>');
        }

        redirect(base_url('laporan'));
    }

    // Fungsi tambahan untuk edit dan hapus tetap sama seperti sebelumnya
    public function edit($id) {
        $data['transaksi'] = $this->M_transaksi->get_data_by_id($id);
        $data['customers'] = $this->M_pilihan->get_customer();
        $data['trailers'] = $this->M_pilihan->get_trailer();
        
        if(!$data['transaksi']) { show_404(); }
        $this->load->view('v_edit_transaksi', $data);
    }

    public function hapus($id) {
        $this->M_transaksi->hapus_data($id);
        redirect(base_url('laporan'));
    }
}