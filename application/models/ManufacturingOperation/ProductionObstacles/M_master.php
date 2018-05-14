<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_master extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function induk()
    {
    	$sql="SELECT mi.induk,
                    mi.cetak,
                    mi.kategori,
                    mi.hambatan,
                    mi.id,
                    (SELECT '<ul><li>'||string_agg(mc.cabang,'</li><li>')||'</li></ul>' FROM MO.MO_MASTER_CABANG mc WHERE mc.induk_id = mi.id) cabang
                    FROM MO.MO_MASTER_INDUK mi";
    	$query = $this->db->query($sql);
    	return $query->result_array();
    }

    public function saveInduk($induk,$type,$kategori,$hambatan,$user_id)
    {
    	$sql="insert into mo.mo_master_induk (induk,cetak,kategori,hambatan,creation_date,updated_by)
    											values ('$induk','$type','$kategori','$hambatan',current_timestamp,$user_id)";
    	$query = $this->db->query($sql);
    	return;
    }

     public function cabang()
    {
    	$sql="select 
                mc.id,
                mc.cabang,
                mi.induk
         from mo.mo_master_cabang mc,
            mo.mo_master_induk mi
            where mc.induk_id = mi.id";
    	$query = $this->db->query($sql);
    	return $query->result_array();
    }

    public function saveCabang($cabang,$induk,$user_id)
    {
    	$sql="insert into mo.mo_master_cabang (cabang,induk_id,creation_date,updated_by)
    											values ('$cabang','$induk',current_timestamp,$user_id)";
    	$query = $this->db->query($sql);
    	return;
    }

    public function getDataCbgbyId($id)
    {
        $sql = "select mc.id,
                mc.cabang,
                mi.induk,
                mc.induk_id
         from mo.mo_master_cabang mc,
            mo.mo_master_induk mi 
         where mc.id = $id
         and mc.induk_id = mi.id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function saveUpdateCabang($induk, $cabang, $id)
    {
        $sql = "update mo.mo_master_cabang set cabang='$cabang', induk_id= $induk,  where id=$id";
        $query = $this->db->query($sql);
        return $query;
    }


     public function getDataIndbyId($id)
    {
        $sql = "select mi.id,
                mi.induk,
                mi.cetak,
                mi.hambatan,
                mi.kategori
         from 
            mo.mo_master_induk mi 
         where mi.id = $id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function saveUpdateInduk($id,$hambatan,$cetakan,$kategori,$induk)
    {
        $sql = "update mo.mo_master_induk set hambatan='$hambatan', cetak='$cetakan', kategori='$kategori', induk='$induk' where id=$id";
        $query = $this->db->query($sql);
        return $query;
    }

}
?>