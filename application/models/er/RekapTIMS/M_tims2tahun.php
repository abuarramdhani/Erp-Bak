<?php
defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
  * 
  */
 class M_tims2tahun extends CI_Model
 {
 	
 	function __construct()
 	{
 		parent::__construct();
 		$this->personalia = $this->load->database('personalia',TRUE);
 	}

 	public function getData($tglawal,$tglakhir){
 		$sql = "select * from \"Presensi\".trekap_tims where created_date = (select distinct created_date from \"Presensi\".trekap_tims where tanggal_awal_rekap = '$tglawal' and tanggal_akhir_rekap = '$tglakhir' order by created_date desc limit 1) and left(noind,1) not in('F','R','Q','L','Z','M') order by kodesie,noind";
 		// echo $sql;exit();
 		$result = $this->personalia->query($sql);
 		return $result->result_array();
 	}

 	public function getperiode(){
 		$sql = "select tanggal_awal_rekap,tanggal_akhir_rekap 
		 		from \"Presensi\".trekap_tims 
		 		group by tanggal_awal_rekap,tanggal_akhir_rekap 
		 		order by tanggal_awal_rekap,tanggal_akhir_rekap";
		$result = $this->personalia->query($sql);
 		return $result->result_array();
 	}
 } ?>