<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property M_transaksi $M_transaksi
 * @property M_pilihan $M_pilihan
 */
class Transaksi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Memuat model yang dibutuhkan untuk operasional GASRA
        $this->load->model('M_transaksi');
        $this->load->model('M_pilihan');
        
        // Proteksi: Pastikan user sudah login
        if($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
    }

    /**
     * Halaman index dialihkan ke list laporan
     */
    public function index() {
        redirect(base_url('laporan'));
    }

    /**
     * Memanggil view form tambah transaksi
     */
    public function tambah() {
        // Mengambil data dropdown dari model pilihan
        $data['customers'] = $this->M_pilihan->get_customer();
        $data['trailers'] = $this->M_pilihan->get_trailer();
        $data['user_now'] = $this->session->userdata('nama');
        
        // Pastikan file view ini ada di folder views
        $this->load->view('v_tambah_transaksi', $data);
    }

    /**
     * Memproses data input ke database
     */
    public function aksi_tambah() {
        // Membersihkan format waktu dari datetime-local
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
            $this->session->set_flashdata('pesan', '<div class="alert alert-success">Log transaksi berhasil disimpan!</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Gagal menyimpan data ke SQL Server.</div>');
        }

        redirect(base_url('laporan')); 
    }

    /**
     * Menampilkan form edit berdasarkan ID
     */
    public function edit($id) {
        $data['transaksi'] = $this->M_transaksi->get_data_by_id($id);
        $data['customers'] = $this->M_pilihan->get_customer();
        $data['trailers'] = $this->M_pilihan->get_trailer();
        $data['user_now'] = $this->session->userdata('nama');

        if(!$data['transaksi']) {
            show_404();
        }

        $this->load->view('v_edit_transaksi', $data);
    }

    /**
     * Update data transaksi
     */
    public function aksi_edit() {
        $id = $this->input->post('id_transaksi');
        $tgl_kirim = str_replace('T', ' ', $this->input->post('tgl_kirim'));
        $tgl_ambil = str_replace('T', ' ', $this->input->post('tgl_ambil'));

        $data = array(
            'customer'   => $this->input->post('customer'),
            'craddle'    => $this->input->post('craddle'),
            'tgl_kirim'  => $tgl_kirim,
            'tgl_ambil'  => $tgl_ambil,
            'p_awal'     => $this->input->post('p_awal'),
            'p_akhir'    => $this->input->post('p_akhir'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $update = $this->M_transaksi->update_data($id, $data);

        if($update) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success">Data berhasil diperbarui!</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Gagal memperbarui data.</div>');
        }

        redirect(base_url('laporan'));
    }

    /**
     * Hapus data transaksi
     */
    public function hapus($id) {
        $hapus = $this->M_transaksi->hapus_data($id);
        
        if($hapus) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success">Data berhasil dihapus.</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Gagal menghapus data.</div>');
        }
        
        redirect(base_url('laporan'));
    }
}