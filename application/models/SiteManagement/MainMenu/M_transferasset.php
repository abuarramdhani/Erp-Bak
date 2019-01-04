<?php 
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_transferasset extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getSeksi($nama){
		$nama = strtoupper($nama);
		$sql = "select * 
				from er.er_section 
				where section_code like '%$nama%' 
				or section_name like '%$nama%' 
				and section_code like '%00'
				order by section_code;";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getRequesterBaru($txt){
		$txt = strtoupper($txt);
		$sql = "select employee_name, new_employee_code, employee_code
				from er.er_employee_all
				where resign = '0'
				and (employee_code like '%$txt%' or employee_name like '%$txt%')
				order by employee_code";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function insertTransferAsset($data){
		$this->db->insert('sm.sm_transfer_asset',$data);
	}

	public function getTransferAsset(){
		$sql = "select no_blanko,tag_number,nama_barang,seksi_awal,seksi_baru from sm.sm_transfer_asset";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function updateSeksiAsset($id,$seksi){
		$sql = "insert into sm.sm_pembelian_asset_history
				(id_pembelian, no_pp, no_bppba, tgl_beli, seksi_pemakai, kode_item, nama_item, tag_number, code_cost, created_date, created_by, status_retired)
				select id_pembelian, no_pp, no_bppba, tgl_beli, seksi_pemakai, kode_item, nama_item, tag_number, code_cost, created_date, created_by, status_retired from sm.sm_pembelian_asset where id_pembelian = '$id'";
		$this->db->query($sql);
		$sql = "update sm.sm_pembelian_asset set seksi_pemakai = '$seksi' where id_pembelian = '$id'";
		$this->db->query($sql);		
	}
}
?>