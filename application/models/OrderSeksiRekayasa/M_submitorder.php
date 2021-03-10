<?php 
class M_submitorder extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getSeksi($kodesie){
        $sql = "SELECT section_name 
        FROM er.er_section
        WHERE section_code = '$kodesie'";
        $query = $this->db->query($sql);
		return $query->result_array();
    }

    function setOrder($data) {
		$this->db->insert('osr.osr_order', $data);
    }
    
    function getOrder($id) {
        $sql = "SELECT ord.*
        FROM osr.osr_order ord
        WHERE ord.id_order = $id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getMyOrder($no_induk, $status = FALSE){
        if($status === FALSE) {
            $sql = "SELECT ord.*
            FROM osr.osr_order ord
            WHERE ord.no_induk = '$no_induk'
            ORDER BY ord.id_order DESC";
            $query = $this->db->query($sql);
        } else {    
            $sql = "SELECT ord.*
            FROM osr.osr_order ord
            WHERE ord.no_induk = '$no_induk'
            AND ord.status = $status
            ORDER BY ord.id_order DESC";
            $query = $this->db->query($sql);
        }

        return $query->result_array();
    }

    public function upOtorisasi($data)
    {
      $this->db->where('id_order', $data['id_order'])->update('osr.osr_order', $data);
    }

    function getMonOrder($status = FALSE){
        if($status === FALSE) {
            $sql = "SELECT ord.*
            FROM osr.osr_order ord
            ORDER BY ord.id_order DESC";
            $query = $this->db->query($sql);
        } else {    
            $sql = "SELECT ord.*
            FROM osr.osr_order ord
            WHERE ord.status = $status
            ORDER BY ord.id_order DESC";
            $query = $this->db->query($sql);
        }

        return $query->result_array();
    }

    public function terimaOrder($id_order, $status){
        $this->db->where('id_order', $id_order)->update('osr.osr_order', ['status' => $status]);
        if ($this->db->affected_rows() == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    function getEmail($id_order) {
        $sql = "SELECT ord.*, ea.internal_mail
        FROM osr.osr_order ord LEFT JOIN er.er_employee_all ea ON ord.no_induk = ea.employee_code
        WHERE ord.id_order = $id_order";
        $query = $this->db->query($sql);
        return $query->result_array();
	}

}
?>