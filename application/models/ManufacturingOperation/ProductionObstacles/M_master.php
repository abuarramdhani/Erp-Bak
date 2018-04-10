<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_master extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function induk($cetak)
    {
    	$sql="select * from mo.mo_master_induk where cetak ='$cetak'";
    	$query = $this->db->query($sql);
    	return $query->result_array();
    }

    public function saveInduk($induk,$type,$user_id)
    {
    	$sql="insert into mo.mo_master_induk (induk,cetak,creation_date,updated_by)
    											values ('$induk','$type',current_timestamp,$user_id)";
    	$query = $this->db->query($sql);
    	return;
    }

     public function cabang($cetak)
    {
    	$sql="select * from mo.mo_master_cabang where cetak ='$cetak'";
    	$query = $this->db->query($sql);
    	return $query->result_array();
    }

    public function saveCabang($cabang,$type,$user_id)
    {
    	$sql="insert into mo.mo_master_cabang (cabang,cetak,creation_date,updated_by)
    											values ('$cabang','$type',current_timestamp,$user_id)";
    	$query = $this->db->query($sql);
    	return;
    }
}
?>