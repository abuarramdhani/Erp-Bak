<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_kaizenakuntansi extends CI_Model{
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function insertKaizen($data){
		$this->db->insert('si.si_kaizen_akuntansi',$data);
		return $this->db->insert_id();
	}

	function insertThreadKaizen($data){
		$this->db->insert('si.si_kaizen_akuntansi_thread',$data);
	}

	function getKaizenByUserStatus($noind,$status){
		$sql = "select judul,kaizen_id 
				from si.si_kaizen_akuntansi
				where status = ?
				and pencetus_noind = ?";
		return $this->db->query($sql,array($status,$noind))->result_array();
	}

	function getMasterItem($term=FALSE,$id=FALSE) {
		$oracle = $this->load->database('oracle',TRUE);
		if($id===FALSE) {	
			$sql = "SELECT DISTINCT(SEGMENT1) segment1, DESCRIPTION item_name ,INVENTORY_ITEM_ID
					FROM mtl_system_items_b 
					WHERE segment1 like '%$term%' or description like '%$term%'";
		} else {
			if($term == FALSE){
				$sql = "SELECT DISTINCT(SEGMENT1) segment1, DESCRIPTION item_name ,INVENTORY_ITEM_ID
					FROM mtl_system_items_b 
					WHERE INVENTORY_ITEM_ID = '$id'";
			}
		}
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function updateKaizenByKaizenId($data,$kaizenId){
		$this->db->where('kaizen_id', $kaizenId);
		$this->db->update('si.si_kaizen_akuntansi', $data);
	}

} ?>