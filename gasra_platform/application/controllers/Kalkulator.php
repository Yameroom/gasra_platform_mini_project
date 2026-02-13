<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property M_kalkulator $M_kalkulator
 */
class Kalkulator extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_kalkulator');
        
        if($this->session->userdata('status') != "login") {
            redirect(base_url("index.php/login"));
        }
    }

    public function index() {
        // PERBAIKAN: Gunakan session 'nama' (nama_lengkap) untuk filter history
        // agar sinkron dengan data ID 1-25 di database kamu
        $nama_lengkap = $this->session->userdata('nama');
        
        $data['history'] = $this->M_kalkulator->get_history($nama_lengkap);
        $data['hasil'] = null;
        
        $this->load->view('v_kalkulator', $data);
    }

    public function hitung() {
        // PERBAIKAN: Ambil nama_lengkap dari session
        $nama_lengkap = $this->session->userdata('nama');
        
        $input = [
            'username' => $nama_lengkap, // Nama lengkap dikirim ke parameter @Username di SP
            'p'   => $this->input->post('p'),
            't'   => $this->input->post('t'),
            'lwc' => $this->input->post('lwc'),
            'sg'  => $this->input->post('sg'),
            'co2' => $this->input->post('co2'),
            'n2'  => $this->input->post('n2')
        ];

        // Jalankan SP: Hasilnya akan tersimpan dengan kolom username = nama_lengkap
        $data['hasil'] = $this->M_kalkulator->hitung_aga8($input);
        
        // Ambil ulang history menggunakan nama_lengkap
        $data['history'] = $this->M_kalkulator->get_history($nama_lengkap);
        
        $this->load->view('v_kalkulator', $data);
    }
}