<?php defined('BASEPATH') OR die('No direct script access allowed');
class M_revisimasteritem extends CI_Model
{
	
	function __construct() {
		parent::__construct();
        $this->oracle = $this->load->database('oracle',TRUE);
	}

    function deleteKIT() {
        $del = "delete from khs_import_temp";
        $query = $this->oracle->query($del);
    }

	function runUpdate() {
        $nomorInduk = $this->session->user;
		$sql = "BEGIN KHSAPIMASTERITEM.update_master_item('$nomorInduk'); END;";
		// echo "<pre>";
		// print_r('cek');
		// exit();			
		$query = $this->oracle->query($sql);
		// return $query->result_array();
		// return $sql;
	}

    function insertDataUpdate($arrayItem) {        
        $insertSql = "insert into khs_import_temp (
            ACTION_TYPE_ID,
            ACTION_TYPE_NAME,
            ITEM,
            DESCRIPTION,
            ORGANIZATION_ID,
            INVENTORY_ITEM_STATUS_CODE,
            TRANSACTION_TYPE
            ) 
            VALUES (
                {$arrayItem['action_type_id']},
                '{$arrayItem['action_type_name']}', 
                '{$arrayItem['item']}',
                '{$arrayItem['desc']}',
                {$arrayItem['org_id']},
                '{$arrayItem['inventory_item_status_code']}',
                {$arrayItem['trx_type']}
            )";
		// echo "<pre>";
		// print_r($insertSql);
		// exit();
        $query = $this->oracle->query($insertSql);
        // return $query->result_array();
    }

    function showUpdatedData() {
        $showSql = "select msib.SEGMENT1 item
        ,msib.DESCRIPTION
        ,msib.ATTRIBUTE29 updated_by
        from khs_import_temp kit
        ,mtl_system_items_b msib
        where kit.ITEM = msib.SEGMENT1
        and kit.ORGANIZATION_ID = msib.ORGANIZATION_ID
        ";
		// echo "<pre>";
		// print_r($showSql);
		// exit();
        $query = $this->oracle->query($showSql);
        return $query->result_array();
    }

    public function listCode($d) {
        $sql = "SELECT msib.segment1, msib.description
                FROM mtl_system_items_b msib
               WHERE msib.organization_id = 81
                 AND msib.inventory_item_status_code = 'Active'
                 AND SUBSTR (msib.segment1, 1, 1) <> 'J'
                 AND (msib.segment1 LIKE '%$d%'
                 OR msib.description LIKE '%$d%')
            ORDER BY 1";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

}