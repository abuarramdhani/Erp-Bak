<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_masteritem extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function insert($dataIns,$tbName)
    {
       $this->db->insert($tbName, $dataIns);
    }

    public function monitor()
    {
    	$sql="select mst.type,
    			     mst.nama_barang,
    			     mst.kode_barang,
    			     mst.kode_proses,
    			     mst.proses,
    			     mst.target_sk,
    			     mst.target_js,
    			     mst.tanggal_berlaku,
    			     mst.id,
                     mst.jenis,
                     mst.berat
    			from mo.mo_master_item mst
                order by 2";
    	$query = $this->db->query($sql);
		return $query->result_array();
    }

    public function updateMasterItem($type,$kodBar,$namBar,$proses,$kodPros,$SK,$JS,$tglBerlaku,$user_id,$id,$jenis,$berat)
    {
        $sql = "
            update mo.mo_master_item 
            SET type ='$type', kode_barang= '$kodBar', nama_barang='$namBar', proses='$proses', kode_proses='$kodPros', target_sk=$SK, target_js=$JS, tanggal_berlaku='$tglBerlaku', created_by=$user_id, creation_date=current_date, jenis='$jenis', berat='$berat'
            WHERE id =$id";
        $query = $this->db->query($sql);
    }

    public function insertMasIt($type,$kodBar,$namBar,$proses,$kodPros,$SK,$JS,$tglBerlaku,$user_id,$creation_date,$jenis,$berat)
    {
        $sql = "
            insert into mo.mo_master_item 
           (type, kode_barang, nama_barang, proses, kode_proses, target_sk, target_js, tanggal_berlaku, created_by, creation_date, jenis, berat) 
           values ('$type', '$kodBar', '$namBar', '$proses', '$kodPros', $SK, $JS, '$tglBerlaku', $user_id, current_date, '$jenis', '$berat')
          ";
        $query = $this->db->query($sql);
    }


}

/* End of file M_mixing.php */
/* Location: ./application/models/ManufacturingOperation/MainMenu/M_mixing.php */
/* Generated automatically on 2017-12-20 14:47:57 */