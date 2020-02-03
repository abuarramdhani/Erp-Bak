<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_data extends CI_Model {

    public function __construct()
    {
        parent::__construct();        
        $this->load->database();
    }

    public function selectAllRegisteredUser()
    {
        return $this->db
            ->order_by('id', 'ASC')
            ->get('ap.ap_spt')
            ->result_array();
    }

    public function selectRegisteredUser($id)
    {
        return $this->db
            ->get_where('ap.ap_spt', ['id' => $id])
            ->result_array();
    }

    public function countAllRegisteredUser()
    {
        return $this->db->count_all_results('ap.ap_spt');
    }

    public function updateRegisteredUser($id, $data)
    {
        $this->db
            ->where('id', $id)
            ->update('ap.ap_spt', $data);
    }

    public function deleteRegisteredUser($id)
    {
        $this->db->delete('ap.ap_spt', ['id' => $id]);
    }

}