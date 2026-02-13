<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 */
class M_transaksi extends CI_Model {

    // Nama tabel didefinisikan di satu tempat agar mudah jika ada perubahan
    private $table = 'dbo.DataTransaksiCradle';

    /**
     * 1. Ambil data mentah (Sesuai tabel)
     * Digunakan untuk Dashboard & Pencarian Mentah
     */
    public function get_all_data() {
        $this->db->order_by('id_transaksi', 'DESC');
        return $this->db->get($this->table)->result();
    }

    /**
     * 2. Simpan Data Baru
     * Digunakan oleh Controller Transaksi/aksi_tambah
     */
    public function simpan_data($data) {
        return $this->db->insert($this->table, $data);
    }

    /**
     * 3. Ambil data tunggal berdasarkan ID (DATA MENTAH)
     * Digunakan oleh Controller Transaksi/edit untuk mengisi value form
     */
    public function get_data_by_id($id) {
        $this->db->where('id_transaksi', $id);
        return $this->db->get($this->table)->row();
    }

    /**
     * 4. Update Data
     * Digunakan oleh Controller Transaksi/aksi_edit
     */
    public function update_data($id, $data) {
        $this->db->where('id_transaksi', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * 5. Hapus Data Permanen
     * Digunakan oleh Controller Transaksi/hapus
     */
    public function hapus_data($id) {
        $this->db->where('id_transaksi', $id);
        return $this->db->delete($this->table);
    }

    /**
     * 6. Mengambil laporan kalkulasi teknis dari Stored Procedure
     * Menggunakan Parameter Binding untuk keamanan SQL Injection
     */
    public function get_book_report($customer = NULL, $year = NULL, $month = NULL) {
        // Parameter binding mencegah penulisan tanda petik manual
        $sql = "EXEC dbo.sp_bookreportAGA8Android 
                @Customer = ?, 
                @Year = ?, 
                @Month = ?, 
                @Period = 1";

        $params = [
            $customer ? $customer : NULL,
            $year ? $year : NULL,
            $month ? $month : NULL
        ];

        return $this->db->query($sql, $params)->result();
    }

    /**
     * 7. Ambil Detail Transaksi Lengkap (Hasil Hitungan SP)
     * Mencari data spesifik dari hasil eksekusi Stored Procedure
     */
    public function get_detail_transaksi($id) {
        // Kita panggil SP tanpa filter agar mendapatkan semua kalkulasi
        $data_laporan = $this->get_book_report();
        
        foreach ($data_laporan as $row) {
            // id_transaksi harus ada di dalam output SELECT Stored Procedure
            if ($row->id_transaksi == $id) {
                return $row;
            }
        }
        return null;
    }

    /**
     * 8. Ambil Data Khusus untuk Halaman Analytics
     * Memanfaatkan SP yang sama namun difokuskan pada data tahunan
     */
    public function get_analytics_data($year) {
        $sql = "EXEC dbo.sp_bookreportAGA8Android 
                @Customer = NULL, 
                @Year = ?, 
                @Month = NULL, 
                @Period = 1";

        return $this->db->query($sql, [$year])->result();
    }
}