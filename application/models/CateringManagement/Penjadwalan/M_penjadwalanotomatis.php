<?php
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 * 
 */
class M_penjadwalanotomatis extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia',TRUE);
	}

	public function deleteAllByPeriode($periode,$i,$lokasi){
		$sql1 = "delete from \"Catering\".tjadwal
				where to_char(fd_tanggal,'month') like '%".$periode['0']."%' 
				and to_char(fd_tanggal,'YYYY') = '".$periode['1']."'
				and to_char(fd_tanggal,'dd') >= '".$i."'
				and lokasi = '$lokasi'";
		$this->personalia->query($sql1);

		$sql2 = "delete from \"Catering\".turutanjadwal
				where to_char(fd_tanggal,'month') like '%".$periode['0']."%' 
				and to_char(fd_tanggal,'YYYY') = '".$periode['1']."'
				and to_char(fd_tanggal,'dd') >= '".$i."'
				and lokasi = '$lokasi'";
		$this->personalia->query($sql2);
	}

	public function getDate(){
		$sql = "select to_char(current_date, 'month YYYY') tanggal";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getDateNow(){
		$sql = "select to_char(current_date, 'DD') tanggal";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getCateringActive($lokasi){
		$sql = "select * from \"Catering\".tkatering 
				where fb_status = '1' 
				and lokasi_kerja::int = $lokasi
 				order by fs_kd_katering";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getCateringCount($lokasi){
		$sql = "select COUNT(*) AS jml2 
				from \"Catering\".tkatering 
				where fb_status = '1' 
				and lokasi_kerja::int = $lokasi
				group by fb_status;";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getCateringUrutan($kd,$periode,$mulai,$lokasi){
		$sql = "select fn_urutan_jadwal 
				from \"Catering\".tUrutanJadwal 
				where fs_kd_katering = '$kd'   
				and fd_tanggal < '".$mulai." ".$periode['0']." ".$periode['1']."' 
				and lokasi = '$lokasi'
				order by fd_tanggal desc limit 1;";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getCateringNonActiveUrutan($periode,$mulai,$lokasi){
		$sql = "select ur.fn_urutan_jadwal 
				from \"Catering\".tUrutanJadwal ur inner join 
				\"Catering\".tkatering cat on ur.fs_kd_katering = cat.fs_kd_katering 
				where (ur.fd_tanggal < '".$mulai." ".$periode['0']." ".$periode['1']."') and (cat.fb_status = '0') 
				and lokasi = '$lokasi'
				order by ur.fd_tanggal desc limit 1";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getFirstDay($periode){
		$sql = "select to_char(cast('01 ".$periode['0']." ".$periode['1']."' as date),'DD') tanggal;";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}
	public function getLastDay($periode){
		$sql = "select to_char(((cast('01 ".$periode['0']." ".$periode['1']."' as date)+ interval '1 month')- interval '1 day'),'DD') tanggal;";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getDay($periode,$d){
		$sql = "select to_char(cast('".$d." ".$periode['0']." ".$periode['1']."' as date), 'd') hari,
				to_char(cast('".$d." ".$periode['0']." ".$periode['1']."' as date), 'dd') tanggal,
				to_char(cast('".$d." ".$periode['0']." ".$periode['1']."' as date), 'MM/YYYY') bulan,
				to_char(cast('".$d." ".$periode['0']." ".$periode['1']."' as date), 'YYYY-MM-DD') lengkap";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getPuasa($periode,$d){
		$sql = "select * from \"Catering\".tpuasa where fd_tanggal = '".$d." ".$periode['0']." ".$periode['1']."' ";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getLibur($periode,$d){
		$sql = "select * from \"Dinas_Luar\".tlibur where tanggal = '".$d." ".$periode['0']." ".$periode['1']."'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getDetailJadwal($hari,$urutan){
		$sql = "select * 
				from \"Catering\".tdetailjadwal 
				where fn_urutan_jadwal = ".$urutan." 
				and fs_hari = '".$hari."';";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function insertJadwal($data){
		$this->personalia->insert("\"Catering\".tjadwal",$data);
	}

	public function insertUrutanJadwal($data){
		$this->personalia->insert("\"Catering\".turutanjadwal",$data);
	}
}
?>