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
		$sql = "select ide,kaizen_id 
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

	function getKaizenByKaizenId($kaizen_id){
		$sql = "select *
				from si.si_kaizen_akuntansi
				where kaizen_id = ?";
		return $this->db->query($sql,array($kaizen_id))->result_array();
	}

	function getSectAll($id){
		$sql = "SELECT sec.*
				FROM sys.vi_sys_user_data visu
				INNER JOIN er.er_section sec ON sec.section_code = visu.section_code
				WHERE visu.user_name = ?";
		return $this->db->query($sql,array($id))->result_array();
	}

	function getKaizenByNoind($noind){
		$sql = "select ska.kaizen_id, 
					ska.judul,
					ska.due_date_f4,
					ska.status,
					ska.created_timestamp
				from si.si_kaizen_akuntansi ska 
				where ska.pencetus_noind = ?";
		return $this->db->query($sql,array($noind))->result_array();
	}

	function getThreadByKaizenId($kaizen_id){
		$sql = "select *
				from si.si_kaizen_akuntansi_thread
				where kaizen_id = ?
				order by thread_timestamp desc";
		return $this->db->query($sql,array($kaizen_id))->result_array();
	}

} ?>