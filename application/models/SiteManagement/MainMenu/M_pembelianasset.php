<?php 
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_pembelianasset extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getNoPP($no){
		$sql = "select id_input_asset, no_pp
				from sm.sm_input_asset where no_pp like '$no%'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getNoPPByID($id){
		$sql = "select no_pp
				from sm.sm_input_asset where id_input_asset = '$id'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getBarangByID($id){
		$sql = "select 	iad.id_input_asset_detail,
						iad.nama_item,
						iad.kode_item,
						iad.jumlah_diminta,
						es.section_name seksi 
				from sm.sm_input_asset_detail iad 
				inner join sm.sm_input_asset ia 
					on ia.id_input_asset = iad.id_input_asset
				inner join er.er_section es
					on es.section_code = ia.seksi_pemakai
				where iad.id_input_asset = ".$id.";";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getCostCenter($id){
		$id = strtoupper($id);
		$sql = "select * 
		from sm.sm_cost_center 
		where upper(code_cost) like '%$id%' 
		 or upper(seksi_cost) like'%$id%'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function insertPembelianAsset($data,$tag,$user){
		$id_asset = $data['0'];
		$id_asset_detail = $data['1'];
		$no_bppba = $data['2'];
		$tanggal_pembelian = $data['3'];
		$kode_cost_center = $data['4'];
		$jumlah_diterima = $data['5'];

		$sql = "insert into sm.sm_pembelian_asset
				(no_pp,no_bppba,tgl_beli,seksi_pemakai,kode_item,nama_item,tag_number,code_cost,created_date,created_by)
				select 	ia.no_pp,
						'$no_bppba',
						'$tanggal_pembelian',
						es.section_name seksi,
						iad.kode_item,
						iad.nama_item,
						'$tag',
						'$kode_cost_center',
						current_date,
						'$user'
				from sm.sm_input_asset_detail iad 
				inner join sm.sm_input_asset ia 
					on ia.id_input_asset = iad.id_input_asset
				inner join er.er_section es
					on es.section_code = ia.seksi_pemakai
				where iad.id_input_asset_detail = '$id_asset_detail'";
		$this->db->query($sql);
	}

	public function getPembelianAsset(){
		$sql = "select distinct no_pp,
								no_bppba,
								tgl_beli,
								seksi_pemakai, 
								concat(kode_item,' - ',nama_item) as item, 
								concat(cc.code_cost,' - ',cc.seksi_cost) cost_center
				from sm.sm_pembelian_asset pa
				inner join sm.sm_cost_center cc
					on cc.code_cost = pa.code_cost";
		$result = $this->db->query($sql);
		return $result->result_array();
	}
}
?>