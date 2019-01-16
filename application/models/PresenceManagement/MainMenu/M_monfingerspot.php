<?php 
defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_monfingerspot extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->Mysql = $this->load->database('quickcom',TRUE);

	}

	public function getDataScanLog(){
		$sql = "select 	device_sn,
						device_name ,
						id_lokasi,
						lokasi.lokasi_kerja,
						(
							select count(id_scanlog) 
							from db_datapresensi.tb_scanlog_history scan2 
							where scan2.sn = dev.device_sn 
							and scan2.workcode = '1'
						) scan_delete,
						(
							select count(id_scanlog) 
							from db_datapresensi.tb_scanlog_history scan2 
							where scan2.sn = dev.device_sn
						) scan_total,
						(
						select case when count(id_scanlog) -(select count(id_scanlog) from db_datapresensi.tb_scanlog_history scan2 where scan2.sn = dev.device_sn and scan2.workcode = '1') >=100000 THEN
						 	1
						when count(id_scanlog) - (select count(id_scanlog) from db_datapresensi.tb_scanlog_history scan2 where scan2.sn = dev.device_sn and scan2.workcode = '1') >=50000 THEN
							2
						ELSE
							3
						end a
						from db_datapresensi.tb_scanlog_history scan2 
						where scan2.sn = dev.device_sn
						) status_warning
				from db_datapresensi.tb_device dev
				left join hrd_khs.tlokasi_kerja lokasi
				on lokasi.id_ = dev.office
				order by (select count(id_scanlog) from db_datapresensi.tb_scanlog_history scan2 where scan2.sn = dev.device_sn) desc";
		$result = $this->Mysql->query($sql);
		return $result->result_array();
	}
}
?>