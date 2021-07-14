<?php defined('BASEPATH') OR die('No direct script access allowed');
class M_revisimasteritem extends CI_Model
{
	
	function __construct() {
		parent::__construct();
        $this->oracle = $this->load->database('oracle_dev',TRUE);
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

    function insertData($arrayItem) {        
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
                '{$arrayItem['item_code']}',
                '{$arrayItem['item_desc']}',
                {$arrayItem['org_id']},
                '{$arrayItem['inventory_item_status_code']}',
                {$arrayItem['trx_type']}
            )";
        $query = $this->oracle->query($insertSql);
		// echo "<pre>";
		// print_r($insertSql);
		// exit();
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
                 AND msib.segment1 LIKE '%$d%'
            ORDER BY 1";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getDescription($item_code) {
        $sql = "SELECT msib.description item_desc
                FROM mtl_system_items_b msib
               WHERE msib.organization_id = 81
                 AND msib.inventory_item_status_code = 'Active'
                 AND msib.segment1 LIKE '%$item_code%'
            ORDER BY 1";
        $query = $this->oracle->query($sql);
        // return $query;
        return $query->row_array();
    }

}