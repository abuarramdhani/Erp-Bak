<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_cetak extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getCetakSemua($periode){
		$tgl = explode(" - ", $periode);
		$tgl1 = $tgl[0];
		$tgl2 = $tgl[1];
		$sql = "select * from ma.ma_pending pen 
				left join ma.ma_pekerja pkj
					on pkj.id_pekerja = cast(pen.id_pekerja as int) 
				where cast(start_time as date) between '$tgl1' and '$tgl2'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getCetakSebagian($pkj,$periode){
		$tgl = explode(" - ", $periode);
		$tgl1 = $tgl[0];
		$tgl2 = $tgl[1];
		$sql = "select * from ma.ma_pending pen 
				left join ma.ma_pekerja pkj
					on pkj.id_pekerja = cast(pen.id_pekerja as int) 
				where pen.id_pekerja in ($pkj)
				and cast(start_time as date) between '$tgl1' and '$tgl2'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

}

?>