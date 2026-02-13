<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property CI_Loader $load
 * * Anotasi fungsi eksternal agar tidak error di VS Code:
 * @method bool sqlsrv_next_result(resource $stmt)
 * @method object|null sqlsrv_fetch_object(resource $stmt)
 */
class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('status') != "login") {
            redirect(base_url("login"));
        }
    }

    public function index() {
        // Eksekusi Stored Procedure
        $query = $this->db->query("EXEC dbo.sp_GetDashboardAnalytics");
        
        $data['summary'] = $query->row();
        
        /** @var resource $stmt */
        $stmt = $query->result_id; 

        // Ambil Result Set 2 (Recent Logs)
        sqlsrv_next_result($stmt);
        $data['recent_logs'] = $this->fetch_sqlsrv_data($stmt);

        // Ambil Result Set 3 (Chart Performance)
        sqlsrv_next_result($stmt);
        $data['chart_data'] = $this->fetch_sqlsrv_data($stmt);

        // Ambil Result Set 4 (Distribution Share)
        sqlsrv_next_result($stmt);
        $data['dist_data'] = $this->fetch_sqlsrv_data($stmt);

        $data['user_now'] = $this->session->userdata('nama');
        $this->load->view('v_dashboard', $data);
    }

    /**
     * Helper untuk mengambil data manual dari resource stmt
     * @param resource $stmt
     * @return array
     */
    private function fetch_sqlsrv_data($stmt) {
        $rows = array();
        // Memastikan VS Code tahu $stmt adalah resource yang valid
        while ($row = sqlsrv_fetch_object($stmt)) {
            $rows[] = $row;
        }
        return $rows;
    }
}