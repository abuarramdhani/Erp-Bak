<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_hambatanmesin extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->oracle = $this->load->database('oracle',true);     
    }

    public function saveHmabatanUmum($induk,$cabang,$mulai,$selesai,$type,$user)
    {
    	$sql = "insert into mo.mo_hambatan_mesin (induk, cabang, mulai, selesai, cetak, updated_by, last_updated)
    			values ('$induk', '$cabang', '$mulai', '$selesai', '$type', '$user', current_timestamp)";
    	$query = $this->db->query($sql);
    	return;
    }

    public function selectHmabatanUmum()
    {
    	$sql = "select * from mo.mo_hambatan_mesin";
    	$query = $this->db->query($sql);
    	return $query->result_array();
    }
}