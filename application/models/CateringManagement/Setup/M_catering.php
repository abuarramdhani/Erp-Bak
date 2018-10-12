<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_catering extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	public function getCatering(){
		$sql = "select * from \"Catering\".tkatering";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function insertCatering($data){
		$this->personalia->insert("\"Catering\".tkatering",$data);
	}

	public function updateCateringByKd($data,$kd){
		$this->personalia->where("fs_kd_katering",$kd);
		$this->personalia->update("\"Catering\".tkatering",$data);
	}

	public function getCateringByKd($kd){
		$sql = "select * from \"Catering\".tkatering where fs_kd_katering = '$kd'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function deleteCateringByKd($kd){
		$this->personalia->where("fs_kd_katering",$kd);
		$this->personalia->delete("\"Catering\".tkatering");
	}
}
?>