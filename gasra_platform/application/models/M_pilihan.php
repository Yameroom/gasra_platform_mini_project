<?php
/**
 * @property CI_DB_query_builder $db
 */
class M_pilihan extends CI_Model {
    
    public function get_customer() {
        return $this->db->get('dbo.m_customer')->result();
    }

    public function get_trailer() {
        return $this->db->get('dbo.m_trailer')->result();
    }
}