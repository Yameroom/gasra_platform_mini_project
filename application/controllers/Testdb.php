<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**

 * @property CI_Session $session

 * @property CI_Input $input

 * @property CI_DB_query_builder $db

 */

class Testdb extends CI_Controller {

    public function index() {
        // --- Cek Database Pertama (Default) ---
        echo "<h3>Database Utama (DB_CradleApp):</h3>";
        if ($this->db->initialize()) {
            echo "Koneksi Berhasil! <br>";
            echo "Nama Database: " . $this->db->database;
        } else {
            echo "Koneksi Gagal.";
        }

        echo "<hr>";

        // --- Cek Database Kedua (AdventureWorks2019) ---
        echo "<h3>Database Kedua (AdventureWorks2019):</h3>";
        
        // Load database kedua
        $db2 = $this->load->database('db_kedua', TRUE);

        if ($db2->conn_id) {
            echo "Koneksi Berhasil! <br>";
            echo "Nama Database: " . $db2->database;
        } else {
            echo "Koneksi Gagal.";
        }
    }
}