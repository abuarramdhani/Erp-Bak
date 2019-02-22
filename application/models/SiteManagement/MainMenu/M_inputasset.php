<?php 
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_inputasset extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getAsset(){
		$sql = "select  ia.id_input_asset, 
						ia.no_pp,
						ia.no_ppa,
						ia.tgl_pp,
						ak.kategori,
						ja.jenis_asset,
						pa.perolehan, 
						es.section_name seksi,
						concat(ea.employee_code,' - ',ea.employee_name) requester
				from sm.sm_input_asset ia
				inner join er.er_section es
					on es.section_code = ia.seksi_pemakai
				inner join er.er_employee_all ea
					on ea.employee_code = ia.requester
				inner join sm.sm_asset_kategori ak
					on ak.id_kat = ia.id_kat
				inner join sm.sm_jenis_asset ja
					on ja.id_jenis = ia.id_jenis
				inner join sm.sm_perolehan_asset pa
					on pa.id_perolehan = ia.id_perolehan";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getJenisAsset(){
		$sql = "select * from sm.sm_jenis_asset";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getKategoriAsset(){
		$sql = "select * from sm.sm_asset_kategori";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getPerolehanAsset(){
		$sql = "select * from sm.sm_perolehan_asset";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getRequesterAsset($noind){
		$sql = "select employee_code noind, employee_name nama from er.er_employee_all where (employee_code like '$noind%' or employee_name like '%$noind%' or new_employee_code like '$noind%') and resign = '0'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getSeksiPemakaiAsset($kd_sie = FALSE){
		if (isset($kd_sie) and !empty($kd_sie)) {
			$sql = "select section_code kodesie, section_name seksi from er.er_section where section_code = '$kd_sie'";
		}else{
			$sql = "select section_code kodesie, section_name seksi 
					from er.er_section 
					where section_code like '%00' 
					and section_name not like '-%' 
					order by section_code";
		}
		
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getItemAsset($item){
		$sql = "select kode_item, nama_item from sm.sm_master_item where upper(nama_item) like '%$item%'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function insertAsset($data){
		$this->db->insert('sm.sm_input_asset',$data);
		return $this->db->insert_id();
	}

	public function insertDetailAsset($data){
		$this->db->insert('sm.sm_input_asset_detail',$data);
	}

	public function deleteAssetByID($id){
		$this->db->where('id_input_asset', $id);
		$this->db->delete('sm.sm_input_asset');
		$this->db->where('id_input_asset', $id);
		$this->db->delete('sm.sm_input_asset_detail');
	}

	public function deleteAssetDetailByID($id){
		$this->db->where('id_input_asset', $id);
		$this->db->delete('sm.sm_input_asset_detail');
	}

	public function getAssetByID($id){
		$sql = "select *, to_char(ia.tgl_pp, 'dd month yyyy') tanggal 
				from sm.sm_input_asset ia
				inner join er.er_employee_all ea
					on ea.employee_code = ia.requester
				inner join er.er_section es
					on es.section_code = ia.seksi_pemakai 
				where id_input_asset = '$id'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function updateAsset($data,$id){
		$this->db->where('id_input_asset',$id);
		$this->db->update('sm.sm_input_asset',$data);
		return $id;
	}

	public function getAssetDetailByID($id){
		$sql = "select * 
				from sm.sm_input_asset_detail where id_input_asset ='$id'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}
}
?>