<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class M_log extends CI_Model {
 
    public function save_log($param) {
        $sql        = $this->db->insert_string('si.si_kaizen_thread',$param);
        $ex         = $this->db->query($sql);
        return $this->db->affected_rows($sql);
    }

    function ShowLog($id) {
    	$sql 	= "SELECT * FROM si.si_kaizen_thread where kaizen_id = '$id' order by waktu desc";
    	$query	= $this->db->query($sql);
    	return $query->result_array();
    }

    function ShowLogByTitle($id, $title) {
        $sql    = "SELECT * FROM si.si_kaizen_thread where kaizen_id = '$id' and detail like '%$title%' order by waktu desc";
        $query  = $this->db->query($sql);
        return $query->result_array();
    }

    function getTemplateLog($statusid){
        $sql = "SELECT * FROM si.si_thread_template WHERE status_thread = '$statusid' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}