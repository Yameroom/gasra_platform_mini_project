<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 */
class Login extends CI_Controller {

    public function index() {
        // Jika user sudah login, arahkan langsung ke Dashboard
        if($this->session->userdata('status') == "login"){
            redirect(base_url('index.php/dashboard'));
        }
        $this->load->view('v_login');
    }

    public function aksi_login() {
        $user_input = $this->input->post('username');
        $pass_input = $this->input->post('password');

        // 1. Cari user berdasarkan username di tabel dbo.Users (SSMS)
        $user = $this->db->get_where("dbo.Users", array('username' => $user_input))->row();

        // 2. Jika user ditemukan
        if ($user) {
            // 3. Verifikasi password hash (sesuai standar Android Studio/PHP)
            if (password_verify($pass_input, $user->password)) {
                
                // Set data session secara lengkap
                $data_session = array(
                    'id_user'  => $user->id,
                    'username' => $user->username, // Digunakan untuk filter History Kalkulator
                    'nama'     => $user->nama_lengkap,
                    'status'   => "login"
                );
                
                $this->session->set_userdata($data_session);
                
                // Berhasil login: arahkan ke Dashboard
                redirect(base_url('index.php/dashboard'));
                
            } else {
                // Password tidak cocok
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger text-center">Password atau Username Salah!</div>');
                redirect(base_url('index.php/login'));
            }
        } else {
            // Username tidak ada di database
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger text-center">Username tidak ditemukan!</div>');
            redirect(base_url('index.php/login'));
        }
    }

    public function logout() {
        // Bersihkan seluruh data session dan kembali ke form login
        $this->session->sess_destroy();
        redirect(base_url('index.php/login'));
    }
}