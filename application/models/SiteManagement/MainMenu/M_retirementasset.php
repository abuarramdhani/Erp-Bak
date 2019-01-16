<?php 
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_retirementasset extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->quick = $this->load->database('quick',TRUE);
	}

	public function getTagNumber($tag){
		$sql = "select id_pembelian,tag_number from sm.sm_pembelian_asset where status_retired = '0' and tag_number like '%$tag%';";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getRetirementAsset(){
		$sql = "select id_retirement,no_retirement,tag_number,nama_barang,lokasi,rencana_penghentian
				from sm.sm_retirement_asset 
				where status_aktif = '1'
				order by created_date desc,no_retirement, tag_number";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getBarang($id){
		$sql = "select * from sm.sm_pembelian_asset where id_pembelian = '$id';";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getUsulanSeksi(){
		$sql = "select * from sm.sm_usulan_seksi";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function insertRetirementAsset($data,$tag){
		$this->db->insert('sm.sm_retirement_asset',$data);
		
		if ($data['rencana_penghentian'] == 'Sementara') {
			$arr = array(
				'status_retired' => '1');
		}else{
			$arr = array(
				'status_retired' => '2');
		}
		$this->db->where('tag_number', $tag);
		$this->db->update('sm.sm_pembelian_asset',$arr);
	}

	public function getDaerah($nama){
		$sql = "select * from db_daerah.kabupaten where nama like '%$nama%'";
		$result = $this->quick->query($sql);
		return $result->result_array();
	}

	public function nonAktifRetirementAsset($id){
		$sql = "update sm.sm_retirement_asset set status_aktif = '0'
				where id_retirement = '$id'";
		$this->db->query($sql);
	}

	public function resetStatusRetired($tag){
		$sql = "update sm.sm_pembelian_asset set status_retired = '0'
				where tag_number = '$tag'";
		$this->db->query($sql);
	}
}
?>