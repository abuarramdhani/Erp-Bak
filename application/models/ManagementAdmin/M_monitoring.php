<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_monitoring extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getData($tanggal,$pekerja,$pekerjaan){
		$sql = "select *,	(	select concat(noind,' - ',nama_pekerja) 
								from ma.ma_pekerja pkj 
								where pkj.id_pekerja = cast(pls.id_pekerja as int)
							) pekerja ,
							case when status_tercapai = false then
								(select case when status_isi = '0' then
											'Quick1953'
										else
											alasan 
										end
								from ma.ma_pending pnd 
								where cast(pnd.id_pelaksanaan as int) = pls.id_pelaksanaan)
							else
								''
							end alasan
				from ma.ma_pelaksanaan pls
				where status_selesai = '1' $tanggal $pekerja $pekerjaan";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getPekerjaan(){
		$sql = "select * from ma.ma_target";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

}

?>