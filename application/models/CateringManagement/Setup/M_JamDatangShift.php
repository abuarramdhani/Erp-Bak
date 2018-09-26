<?php 
Defined('BASEPATH') or exit('No direct script Access Allowed');
/**
 * 
 */
class M_JamDatangShift extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	public function getJamDatangShift1(){
		$sql = "select * from \"Catering\".tbatas_datang_shift where fs_kd_shift ='1';";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getJamDatangShift2(){
		$sql = "select * from \"Catering\".tbatas_datang_shift where fs_kd_shift ='2';";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getCheckJamDatangShift($kd,$hari){
		$sql = "select * from \"Catering\".tbatas_datang_shift where fs_kd_shift='$kd' and fs_hari='$hari'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function insertJamDatangShift($data){
		$fs_kd_shift = $data['fs_kd_shift'];
		$fs_nama_shift = $data['fs_nama_shift'];
		$fs_hari = $data['fs_hari'];
		$fs_jam_awal = $data['fs_jam_awal'];
		$fs_jam_akhir = $data['fs_jam_akhir'];

		$sql = "insert into \"Catering\".tbatas_datang_shift
				(fs_kd_shift, fs_nama_shift, fs_hari, fs_jam_awal, fs_jam_akhir)
				values('$fs_kd_shift', '$fs_nama_shift', '$fs_hari', cast('$fs_jam_awal' as time), cast('$fs_jam_akhir' as time));";
		$this->personalia->query($sql);
	}

	public function updateJamDatangShift($data,$kd,$hari){
		$fs_hari = $data['fs_hari'];
		$fs_jam_awal = $data['fs_jam_awal'];
		$fs_jam_akhir = $data['fs_jam_akhir'];
		$sql = "update \"Catering\".tbatas_datang_shift set fs_hari='$fs_hari', fs_jam_awal= cast('$fs_jam_awal' as time), fs_jam_akhir= cast('$fs_jam_akhir' as time) where fs_kd_shift='$kd' and fs_hari='$hari'";
		echo $sql;exit();
	}

	public function deleteJamDatangShift($kd,$hr){
		$this->personalia->where('fs_kd_shift',$kd);
		$this->personalia->where('fs_hari',$hr);
		$this->personalia->delete("\"Catering\".tbatas_datang_shift");
	}

}
?>