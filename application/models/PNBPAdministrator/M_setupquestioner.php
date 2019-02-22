<?php 
Defined('BASEPATH') or exit('No DIrect Script Access Allowed');
/**
 * 
 */
class M_setupquestioner extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		
	}

	public function getPeriode(){
		$sql = "select * from pd.pnbp_periode order by periode_awal desc";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function insertPeriode($data){
		$this->db->insert('pd.pnbp_periode',$data);
		return ;
	}

	public function deletePeriode($id){
		$this->db->where('id_periode',$id);
		$this->db->delete('pd.pnbp_periode');
		return ;
	}

	public function getUrutanById($id){
		$sql = "select 	pk.kelompok,
						ppy.id_pernyataan,
						ppy.pernyataan,
						puq.no_urut,
						ppi.id_periode,
						(select count(*) 
						from pd.pnbp_pernyataan ppy2
						join pd.pnbp_aspek pa2
						on pa2.id_aspek = ppy2.id_aspek::int
						join pd.pnbp_kelompok pk2
						on pk2.id_kelompok = pa2.id_kelompok::int
						where pk2.id_kelompok = pk.id_kelompok
						and ppy2.set_active = '1') jumlah
				from pd.pnbp_periode ppi
				join pd.pnbp_pernyataan ppy
				on ppy.id_pernyataan = ppy.id_pernyataan
				and ppy.set_active = '1'
				join pd.pnbp_aspek pa 
				on pa.id_aspek = ppy.id_aspek::int
				join pd.pnbp_kelompok pk
				on pk.id_kelompok = pa.id_kelompok::int
				left join pd.pnbp_urutan_questioner puq 
				on puq.id_periode::int = ppi.id_periode
				and puq.id_pernyataan::int = ppy.id_pernyataan
				where ppi.id_periode = '$id'
				order by pk.id_kelompok,
				puq.no_urut::int";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getUrutanByPeriodeAndNoUrut($id_pernyataan,$id_periode){
		$sql = "select * 
				from pd.pnbp_urutan_questioner
				where id_pernyataan = '$id_pernyataan'
				and id_periode = '$id_periode'";
		$result = $this->db->query($sql);
		return $result->num_rows();
	}

	public function updateUrutan($urut,$id_pernyataan,$id_periode){
		$sql = "update pd.pnbp_urutan_questioner 
				set no_urut = '$urut'
				where id_periode = '$id_periode'
				and id_pernyataan = '$id_pernyataan'";
		$result = $this->db->query($sql);
		return ;
	}

	public function insertUrutan($data){
		$this->db->insert('pd.pnbp_urutan_questioner',$data);
		return ;
	}

	public function cekPeriode($periode1,$periode2){
		$sql = "Select * from pd.pnbp_periode
				where ('$periode1' between periode_awal and periode_akhir) 
				or ('$periode2' between periode_awal and periode_akhir) ";
		$result = $this->db->query($sql);
		return $result->num_rows();
	}
}
?>