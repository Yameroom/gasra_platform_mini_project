<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 */
class M_kalkulator extends CI_Model {

    // Jalankan SP Kalkulator & Simpan History
    public function hitung_aga8($data) {
        // Menggunakan 7 parameter sesuai SP sp_kalkulatorAGA8WithHistory
        $sql = "EXEC dbo.sp_kalkulatorAGA8WithHistory 
                @Username = ?, 
                @P_bar = ?, 
                @T_celsius = ?, 
                @LWC = ?, 
                @CO2 = ?, 
                @N2 = ?, 
                @SpecificGravity = ?";
        
        $params = [
            $data['username'], // Ini berisi nama_lengkap dari controller
            $data['p'],
            $data['t'],
            $data['lwc'],
            $data['co2'],
            $data['n2'],
            $data['sg']
        ];

        return $this->db->query($sql, $params)->row();
    }

    // Ambil History hitungan user berdasarkan nama_lengkap
    public function get_history($nama_lengkap) {
        // Keamanan: Jika nama_lengkap kosong, kembalikan array kosong
        if (empty($nama_lengkap)) {
            return array();
        }
        
        // Filter berdasarkan kolom 'username' di tabel history yang berisi nama_lengkap user
        $this->db->where('username', $nama_lengkap);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('dbo.HistoryKalkulatorAGA8')->result();
    }
}