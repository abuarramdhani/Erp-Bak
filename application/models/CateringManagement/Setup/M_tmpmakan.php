<?php
Defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class M_tmpmakan extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	public function getTmpMakan(){
		$sql = "select tt.fs_tempat_makan,tt.fs_tempat, tl.fs_letak,tt.fs_lokasi 
				from \"Catering\".ttempat_makan tt 
				inner join \"Catering\".tletak tl 
				on cast(tt.fs_tempat as int) = tl.fn_kd_letak
				order by tt.fs_tempat_makan;";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getLetakTmpMakan(){
		$sql = "select * from \"Catering\".tletak";
		$result= $this->personalia->query($sql);
		return $result->result_array();
	}

	public function insertTmpMakan($data){
		$this->personalia->insert("\"Catering\".ttempat_makan",$data);
	}

	public function updateTmpMakan($data,$where){
		$this->personalia->where("fs_tempat_makan",$where['fs_tempat_makan']);
		$this->personalia->where("fs_tempat",$where['fs_tempat']);
		$this->personalia->update("\"Catering\".ttempat_makan",$data);
	}

	public function deleteTmpMakan($where){
		$this->personalia->where("fs_tempat_makan",$where['fs_tempat_makan']);
		$this->personalia->where("fs_tempat",$where['fs_tempat']);
		$this->personalia->delete("\"Catering\".ttempat_makan");
	}

}

?>