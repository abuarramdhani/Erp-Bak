<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_settingdata extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->oracle_dev = $this->load->database('oracle_dev', true);
        $this->oracle = $this->load->database('oracle', true);
    }
    
    public function getAlasan($term){
      $sql = "select * from mcl.mcl_tbl_alasan $term";
      $query = $this->db->query($sql);
      return $query->result_array();
    }
    
    public function saveAlasan($data){
        $this->db->trans_start();
        $this->db->insert('mcl.mcl_tbl_alasan',$data);
        $this->db->trans_complete();
    }
      
    public function delAlasan($id){
        $sql = "delete from mcl.mcl_tbl_alasan where id = $id";
        $query = $this->db->query($sql);
    }

    
}