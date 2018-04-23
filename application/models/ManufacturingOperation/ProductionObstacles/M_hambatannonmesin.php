<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_hambatannonmesin extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->oracle = $this->load->database('oracle',true);     
    }

    public function saveHmabatanNonMesin($induk,$cabang,$mulai,$selesai,$type,$user)
    {
    	$sql = "insert into mo.mo_hambatan_non_mesin (induk, cabang, mulai, selesai, cetak, updated_by, last_updated)
    			values ('$induk', '$cabang', '$mulai', '$selesai', '$type', '$user', current_timestamp)";
    	$query = $this->db->query($sql);
    	return;
    }


    public function selectHambatanNonMesin()
    {
    	$sql = "select * from mo.mo_hambatan_non_mesin";
    	$query = $this->db->query($sql);
    	return $query->result_array();
    }


    public function findInduk($induk)
    {
        $sql= "select * from mo.mo_master_induk where id = $induk";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getHambyid($id)
    {
        $sql = "select mm.id,
                        mm.induk,
                        mm.cetak,
                        mm.cabang,
                        mm.mulai,
                        mm.selesai,
                        (select id from mo.mo_master_induk mi where mi.induk = mm.induk
                                                                and mi.cetak = mm.cetak) induk_id
                from mo.mo_hambatan_non_mesin mm
                 where id = $id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function updateHambatan($id,$ind1,$cabang,$mulai,$selesai,$type,$user_id)
    {
        $sql = "update mo.mo_hambatan_non_mesin set induk = '$ind1', cabang = '$cabang', mulai = '$mulai', selesai = '$selesai', cetak = '$type', updated_by = $user_id, last_updated = current_timestamp where id = $id";
        $query = $this->db->query($sql);
        return $query;
    }
}