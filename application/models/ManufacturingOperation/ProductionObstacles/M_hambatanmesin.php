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
    	$sql = "insert into mo.mo_hambatan_mesin (induk, cabang, mulai, selesai, cetak, updated_by, last_updated, kategori)
    			values ('$induk', '$cabang', '$mulai', '$selesai', '$type', '$user', current_timestamp, 'umum')";
    	$query = $this->db->query($sql);
    	return;
    }

    public function saveHmabatanPerMesin($induk,$cabang,$mulai,$selesai,$type,$user)
    {
        $sql = "insert into mo.mo_hambatan_mesin (induk, cabang, mulai, selesai, cetak, updated_by, last_updated, kategori)
                values ('$induk', '$cabang', '$mulai', '$selesai', '$type', '$user', current_timestamp, 'permesin')";
        $query = $this->db->query($sql);
        return;
    }

    public function selectHmabatanUmum()
    {
    	$sql = "select * from mo.mo_hambatan_mesin where kategori = 'umum'";
    	$query = $this->db->query($sql);
    	return $query->result_array();
    }

    public function selectHmabatanPerMesin()
    {
        
        $sql = "select * from mo.mo_hambatan_mesin where kategori = 'permesin'";
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
                        mm.kategori,
                        mm.cabang,
                        mm.mulai,
                        mm.selesai,
                        (select id from mo.mo_master_induk mi where mi.induk = mm.induk) induk_id
                from mo.mo_hambatan_mesin mm
                 where id = $id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function updateHambatanUmum($id,$ind1,$cabang,$mulai,$selesai,$type,$user_id)
    {
        $sql = "update mo.mo_hambatan_mesin set induk = '$ind1', cabang = '$cabang', mulai = '$mulai', selesai = '$selesai', cetak = '$type', updated_by = $user_id, last_updated = current_timestamp where id = $id";
        $query = $this->db->query($sql);
        return $query;
    }
}