<?php 
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
* 
*/
class M_nominal extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getnominal($gk,$gn=FALSE){
		$nilai = '';
		if ($gn !== FALSE) {
			$nilai = "and gol_nilai = $gn";
		}

		$sql = "select * from pk.pk_kenaikan 
				where gol_kerja = '$gk'
				$nilai 
				order by gol_kerja, gol_nilai";
		// echo $sql;exit();
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getgk(){
		$sql = "select distinct cast(gol_kerja as int) from pk.pk_kenaikan order by cast(gol_kerja as int)";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getgn(){
		$sql = "select distinct gol_nilai from pk.pk_kenaikan order by gol_nilai";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getNominalByID($id){
		$sql = "select * from pk.pk_kenaikan where id_kenaikan = $id";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function updateKenaikanNominal($id,$kenaikan){
		$sql = "update pk.pk_kenaikan set nominal_kenaikan = '$kenaikan' where id_kenaikan = $id";
		$this->db->query($sql);
	}

	public function deleteKenaikanNominal($id){
		$sql = "delete from pk.pk_kenaikan where id_kenaikan = $id";
		$this->db->query($sql);
	}

}
?>