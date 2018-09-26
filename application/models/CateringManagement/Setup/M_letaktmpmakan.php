<?php
Defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class M_letaktmpmakan extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	public function getLetakTmpMakan(){
		$sql = "select * from \"Catering\".tletak order by fn_kd_letak";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getLetakTmpMakanByKd($kd){
		$sql = "select * from \"Catering\".tletak where fn_kd_letak = '$kd'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getMaxKodeLetak(){
		$sql = "select max(fn_kd_letak)+1 kode from \"Catering\".tletak;";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function insertLetakTmpMakan($arrdata){
		$this->personalia->insert("\"Catering\".tletak",$arrdata);
	}

	public function updateLetakTmpMakan($data,$where){
		$this->personalia->where("fn_kd_letak",$where['fn_kd_letak']);
		$this->personalia->where("fs_letak",$where['fs_letak']);
		$this->personalia->update("\"Catering\".tletak",$data);
	}

	public function deleteLetakTmpMakan($where){
		$this->personalia->where("fn_kd_letak",$where['fn_kd_letak']);
		$this->personalia->where("fs_letak",$where['fs_letak']);
		$this->personalia->delete("\"Catering\".tletak");
	}
}
?>