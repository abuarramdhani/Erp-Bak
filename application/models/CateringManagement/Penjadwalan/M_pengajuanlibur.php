<?php
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 * 
 */
class M_pengajuanlibur extends Ci_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia',TRUE);
	}

	public function getCatering(){
		$sql = "select * from \"Catering\".tkatering where fb_status='1'";
		$result= $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getTanggalPengajuanLibur($tgl){
		$sql = "update \"Catering\".tpengajuanlibur set fb_tanda = '0'";
		$this->personalia->query($sql);

		$sql = "select distinct pl.fd_tanggal 
				from \"Catering\".tpengajuanlibur pl
				where 	date_part('month',pl.fd_tanggal) = date_part('month',cast('".$tgl."  01' as date)) 
						and date_part('year',pl.fd_tanggal) = date_part('year',cast('".$tgl." 01' as date))
				order by pl.fd_tanggal";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getPengajuanLiburByTanggal($tgl){
		
		$sql = "select 	pl.fd_tanggal, 
						to_char(pl.fd_tanggal, 'month yyyy') bulan,
						to_char(pl.fd_tanggal, 'dd') tanggal,
						pl.fs_kd_katering_libur, 
						tk.fs_nama_katering nama_katering_libur, 
						pl.fs_kd_katering_pengganti,
						(
							select sb.fs_nama_katering 
							from \"Catering\".tkatering sb 
							where pl.fs_kd_katering_pengganti = sb.fs_kd_katering
						) nama_katering_pengganti
				from \"Catering\".tpengajuanlibur pl 
				inner join \"Catering\".tkatering tk on tk.fs_kd_katering = pl.fs_kd_katering_libur
				where pl.fd_tanggal = '$tgl'
				and fb_tanda = '0'
				order by pl.fs_kd_katering_libur";
		$result = $this->personalia->query($sql);
		$sql = "update \"Catering\".tpengajuanlibur set fb_tanda = '1'
				where fd_tanggal = '$tgl'
				and fb_tanda = '0'";
		$this->personalia->query($sql);
		return $result->result_array();
	}

	public function getPengajuanLiburByTanggalKd($data){
		$sql = "select pl.fd_tanggal,
						to_char(pl.fd_tanggal, 'month yyyy') bulan,
						to_char(pl.fd_tanggal, 'dd') tanggal, 
						pl.fs_kd_katering_libur, 
						tk.fs_nama_katering nama_katering_libur, 
						pl.fs_kd_katering_pengganti,
						(
							select sb.fs_nama_katering 
							from \"Catering\".tkatering sb 
							where pl.fs_kd_katering_pengganti = sb.fs_kd_katering
						) nama_katering_pengganti
				from \"Catering\".tpengajuanlibur pl 
				inner join \"Catering\".tkatering tk on tk.fs_kd_katering = pl.fs_kd_katering_libur
				where pl.fd_tanggal = (cast('".$data['tanggal']."' as timestamp) + interval '1 days')
				and pl.fs_kd_katering_libur = '".$data['libur']."'
				and pl.fs_kd_katering_pengganti = '".$data['pengganti']."'
				and fb_tanda = '0'";
		$result = $this->personalia->query($sql);
		$sql = "update \"Catering\".tpengajuanlibur set fb_tanda = '1'
				where fd_tanggal = (cast('".$data['tanggal']."' as timestamp) + interval '1 days')
				and fs_kd_katering_libur = '".$data['libur']."'
				and fs_kd_katering_pengganti = '".$data['pengganti']."'
				and fb_tanda = '0'";
		$this->personalia->query($sql);
		return $result->result_array();
	}

	public function getPengajuanLiburByData($data){
		$sql = "select pl.fd_tanggal,
						to_char(pl.fd_tanggal, 'month yyyy') bulan,
						to_char(pl.fd_tanggal, 'dd') tanggal, 
						pl.fs_kd_katering_libur, 
						tk.fs_nama_katering nama_katering_libur, 
						pl.fs_kd_katering_pengganti,
						(
							select sb.fs_nama_katering 
							from \"Catering\".tkatering sb 
							where pl.fs_kd_katering_pengganti = sb.fs_kd_katering
						) nama_katering_pengganti
				from \"Catering\".tpengajuanlibur pl 
				inner join \"Catering\".tkatering tk on tk.fs_kd_katering = pl.fs_kd_katering_libur
				where pl.fd_tanggal between '".$data['awal']."' and '".$data['akhir']."'
				and (pl.fs_kd_katering_libur = '".$data['libur']."'
				or pl.fs_kd_katering_pengganti = '".$data['pengganti']."')";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function insertPengajuanLibur($data){
		$a = explode(" ", $data['awal']);
		$b = explode(" ", $data['akhir']);
		// echo "<pre>";print_r($data);exit();
		for ($i=intval($a['0']); $i <= intval($b['0']) ; $i++) { 
			$sql = "insert into \"Catering\".tpengajuanlibur(fd_tanggal,fs_kd_katering_libur,fs_kd_katering_pengganti)
					values('".$i." ".$a['1']." ".$a['2']."','".$data['libur']."','".$data['pengganti']."')"; 
			$this->personalia->query($sql);
		}
	}

	public function updatePengajuanLibur($data){
		$sql = "update \"Catering\".tpengajuanlibur set fs_kd_katering_pengganti = '".$data['pengganti']."'
				where fd_tanggal between '".$data['awal']."' and '".$data['akhir']."' and fs_kd_katering_libur = '".$data['libur']."'";
		$this->personalia->query($sql);
	}

	public function deletePengajuanLibur($data){
		$sql = "delete from \"Catering\".tpengajuanlibur
				where fd_tanggal between '".$data['awal']."' and '".$data['akhir']."' and fs_kd_katering_libur = '".$data['libur']."' and fs_kd_katering_pengganti = '".$data['pengganti']."'";
		$this->personalia->query($sql);
	}
}
?>