<?php
defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_setuppernyataan extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getPernyataan(){
		$sql = "select *, 
						case when set_active = true then 
							'Aktif'
						else 
							'Non Aktif'
						end set_active
				from pd.pnbp_pernyataan pp 
				left join pd.pnbp_aspek pa 
				on pa.id_aspek = pp.id_aspek::int 
				left join pd.pnbp_kelompok pk 
				on pk.id_kelompok = pa.id_kelompok::int";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getIndikator($ind){
		$sql = "select * 
				from pd.pnbp_aspek pa
				left join pd.pnbp_kelompok pk 
				on pk.id_kelompok = pa.id_kelompok::int
				where upper(pa.nama_aspek) like upper('%$ind%')
				or upper(pk.kelompok) like upper('%$ind%')";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function insertPernyataan($data){
		$this->db->insert('pd.pnbp_pernyataan',$data);
		return;
	}

	public function deletePernyataan($id){
		$sql = "delete from pd.pnbp_pernyataan
				where id_pernyataan = $id";
		$this->db->query($sql);
		return ;
	}

	public function updatePernyataan($data,$id_pernyataan){
		$this->db->where('id_pernyataan',$id_pernyataan);
		$this->db->update('pd.pnbp_pernyataan',$data);
		return ;
	}
}
?>