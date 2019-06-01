<?php
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 * 
 */
class M_jadwalpengiriman extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia',TRUE);
	}

	public function getPekerjaPersonalia(){
		$sql = "select noind,concat(split_part(nama,' ',1),' ',split_part(nama,' ',2),' ',left(split_part(nama,' ',3),1)) nama from hrd_khs.tpribadi where kodesie like '4%' and keluar = '0' order by noind;";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getCateringActive(){
		$sql = "select fs_kd_katering kode,fs_nama_katering nama from \"Catering\".tkatering where fb_status = '1';";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getCateringActiveByKd($kd){
		$sql = "select fs_nama_katering nama from \"Catering\".tkatering where fb_status = '1' and fs_kd_katering = '$kd';";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getTampilPesanan($kd_katering,$bln){
		$sql = "select ttp.*,
				tk.fs_nama_katering,
				cast((split_part(split_part(fs_tanggal,'/',1),' - ',1)) as int) tanggal1,
				(case when fs_tanggal like '%-%' then split_part(split_part(fs_tanggal,'/',1),' - ',2) else '0' end) tanggal2,
				to_char(cast(concat((split_part(split_part(fs_tanggal,'/',1),' - ',1)),' $bln')as date), 'd') hari1, 
				(case when fs_tanggal like '%-%' then to_char(cast(concat((split_part(split_part(fs_tanggal,'/',1),' - ',2)),' October 2018')as date), 'd') else '0' end) hari2,
				split_part(fs_tanggal,'/',2) bulan,
				split_part(fs_tanggal,'/',3) tahun 
				from \"Catering\".ttampilpesanan ttp
				join \"Catering\".tkatering tk on tk.fs_kd_katering = ttp.fs_kd_katering
				where fs_tanggal like (concat('%',to_char(cast('01 $bln' as date),'/mm/yyyy'))) and ttp.fs_kd_katering = '$kd_katering' 
				order by fs_index;";
		$result = $this->personalia->query($sql);
		return $result->result_array();		
	}

	public function getKeteranganJadwalPengiriman($kd_katering,$shift,$tgl,$bln){
		$sql = "select * 
				from \"Catering\".tket_tampilpesanan 
				where fs_kd_katering = '$kd_katering' and fs_kd_shift = '$shift' and lower(fs_tanggal) like lower(concat(split_part('$tgl','/',1),' $bln ',split_part('$tgl','/',3)));";
		$result = $this->personalia->query($sql);
		return $result->result_array();	
	}

	public function getWaktuJadwalPengiriman($shift,$hari){
		$sql = "select fs_jam_datang from \"Catering\".tjam_datangpesan where fs_hari = '$hari' and fs_kd_shift = '$shift';";
		$result = $this->personalia->query($sql);
		return $result->result_array();	
	}

	public function getCheckKeterangan($tgl,$kd,$shift){
		$sql = "select * from \"Catering\".tket_tampilpesanan where fs_tanggal = '$tgl' and fs_kd_katering = '$kd' and fs_kd_shift = '$shift';";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function insertKeterangan($tgl,$kd,$shift,$ket){
		$sql = "insert into \"Catering\".tket_tampilpesanan
				(fs_tanggal, fs_kd_katering, fs_kd_shift, fs_keterangan)
				values('$tgl', '$kd', '$shift', '$ket');";
		$this->personalia->query($sql);
	}

	public function updateKeterangan($tgl,$kd,$shift,$ket){
		$sql = "update \"Catering\".tket_tampilpesanan
				set fs_keterangan='$ket'
				where fs_tanggal='$tgl' and fs_kd_katering='$kd' and fs_kd_shift='$shift';";
		$this->personalia->query($sql);
	}
}
?>