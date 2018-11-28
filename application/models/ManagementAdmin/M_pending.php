<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_pending extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getDataPending(){
		$sql = "select *,	(select concat(noind,' - ',nama_pekerja) 
							from ma.ma_pekerja pkj 
							where pkj.id_pekerja = cast(pls.id_pekerja as int)
							) pekerja 
				from ma.ma_pending pls ";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function insertAlasan($alasan,$id){
		$sql = "update ma.ma_pending 
				set alasan = '$alasan',
				status_isi = '1'
				where id_pending = $id";
		$this->db->query($sql);
	}

}

?>