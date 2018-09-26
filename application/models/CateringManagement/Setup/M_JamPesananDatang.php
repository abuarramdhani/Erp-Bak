<?php
Defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class M_jampesanandatang extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	public function getShift(){
		$sql = "select * from \"Presensi\".tshift";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}
	
	public function getShiftByKd($kd){
		$sql = "select * from \"Presensi\".tshift where kd_shift = '$kd'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getJamPesananDatang($kd){
		$sql="select tj.*,ts.shift from \"Catering\".tjam_datangpesan tj inner join \"Presensi\".tshift ts on tj.fs_kd_shift = ts.kd_shift where fs_kd_shift = '$kd' order by fs_kd_shift";
		$result= $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getJamPesananDatangByShiftHari($shift,$hari){
		$sql="select tj.*,ts.shift from \"Catering\".tjam_datangpesan tj inner join \"Presensi\".tshift ts on tj.fs_kd_shift = ts.kd_shift where fs_kd_shift = '$shift' and fs_hari = '$hari' order by fs_kd_shift";
		$result= $this->personalia->query($sql);
		return $result->result_array();
	}

	public function insertJamPesananDatang($data){
		$shift = $data['fs_kd_shift'];
		$hari = $data['fs_hari'];
		$pesan = $data['fs_jam_pesan'];
		$datang = $data['fs_jam_datang'];

		$sql = "insert into \"Catering\".tjam_datangpesan
		(fs_kd_shift, fs_hari, fs_jam_pesan, fs_jam_datang)
		values('$shift', '$hari', cast('$pesan' as time), cast('$datang' as time));";
		$this->personalia->query($sql);
	}

	public function updateJamPesananDatang($data,$where){
		$shift = $where['fs_kd_shift'];
		$hari = $where['fs_hari'];
		$pesan = $data['fs_jam_pesan'];
		$datang = $data['fs_jam_datang'];

		$sql = "update \"Catering\".tjam_datangpesan
				set fs_jam_pesan=cast('$pesan' as time), fs_jam_datang=cast('$datang' as time)
				WHERE fs_kd_shift='$shift' and fs_hari='$hari';";
		$this->personalia->query($sql);
	}

	public function deleteJamPesananDatang($where){
		$this->personalia->where("fs_kd_shift",$where['fs_kd_shift']);
		$this->personalia->where("fs_hari",$where['fs_hari']);
		$this->personalia->delete("\"Catering\".tjam_datangpesan");
	}

}

?>