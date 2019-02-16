<?php
defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_setupindikator extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getKelompok($kel){
		$sql = "select * from pd.pnbp_kelompok 
				where upper(kelompok) like upper('%$kel%')";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getIndikator(){
		$sql = "select * 
				from pd.pnbp_aspek pa
				left join pd.pnbp_kelompok pk 
				on pk.id_kelompok = pa.id_kelompok::int";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function insertIndikator($kel,$ind){
		$sql = "insert into pd.pnbp_aspek
				(id_kelompok,nama_aspek)
				values('$kel','$ind')";
		$this->db->query($sql);
		return;
	}

	public function deleteIndikator($id){
		$sql = "delete from pd.pnbp_aspek 
				where id_aspek = $id";
		$this->db->query($sql);
		return ;
	}

	public function updateIndikator($id_kelompok,$aspek,$id_aspek){
		$sql = "update pd.pnbp_aspek 
				set id_kelompok = '$id_kelompok',
					nama_aspek = '$aspek' 
				where id_aspek = $id_aspek";
		$this->db->query($sql);
		return ;
	}
}
?>