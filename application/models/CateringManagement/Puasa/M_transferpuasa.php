<?php
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 * 
 */
class M_transferpuasa extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia',TRUE);
	}

	public function deletePuasa($awal,$akhir){
		$sql = "delete from \"Catering\".tpuasa where fd_tanggal between '$awal' and '$akhir'";
		$this->personalia->query($sql);
	}

	public function getPekerjaPuasa(){
		$sql = " select noind,
						tempat_makan 
				 From hrd_khs.tpribadi 
				 where  hrd_khs.tpribadi.puasa = '1' and keluar = '0'
				 group by 	hrd_khs.tpribadi.Noind,
				 			tempat_makan 
				 ORDER BY 	tempat_makan, 
				 			hrd_khs.tpribadi.Noind";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function insertPuasa($tgl,$noind,$tmpMakan){
		$sql = "insert into \"Catering\".tpuasa 
				(fd_tanggal,fs_noind,fs_tempat_makan,fb_status)
				values
				('$tgl','$noind','$tmpMakan','1')";
		$this->personalia->query($sql);
	}

	public function getHariSelanjutnya($tgl,$p1,$p2){
		$sql = "select to_char(cast('$tgl' as date)+ interval '1 days', 'dd') tgl,
						split_part(to_char(cast('$tgl' as date)+ interval '1 days', 'month'),' ',1) bln,
						to_char(cast('$tgl' as date)+ interval '1 days', 'yyyy') thn,
						cast('$tgl' as date) - cast('$p1' as date) periode1,
						cast('$p2' as date) - cast('$p1' as date) periode2";
		$result = $this->personalia->query($sql);
		return $result->result_array();				
	}
}
?>