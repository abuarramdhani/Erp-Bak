<?php
class M_Pengecekan extends CI_Model{

	var $oracle;
    public function __construct(){
    	parent::__construct();
      	$this->load->database();
      	$this->oracle = $this->load->database('oracle', TRUE);
  		$this->load->library('encrypt');
  		$this->load->helper('url');
    }

    function loadDataCek($SJ){
    	$sql = "SELECT po, vendor, 
				TO_CHAR(receipt_date, 'DD MON YYYY'), 
				TO_CHAR(sp_date, 'DD MON YYYY'), 
				item_name, item_description, 
				qty_sj, qty_actual 
				FROM khs_data_receipt_ppb 
				WHERE no_sj = '$SJ'";
		$query = $this->oracle->query($sql);
		return $query->result();
    }

    function updateData($qtyActual,$SJ,$itemName,$itemDesc){
    	$sql="UPDATE khs_data_receipt_ppb 
			  SET qty_actual = $qtyActual
			  WHERE no_sj = '$SJ' 
			  AND ITEM_NAME='$itemName' 
			  AND ITEM_DESCRIPTION='$itemDesc'";
		echo $sql;
		$query = $this->oracle->query($sql);

    }

    function getPoHeaderId($where){
    	$sql = "SELECT DISTINCT pha.PO_HEADER_ID FROM khs_data_receipt_ppb kdrp, po_headers_all pha
				WHERE kdrp.po = pha.SEGMENT1
				AND kdrp.NO_SJ = '$where'";
		
		$result = $this->oracle->query($sql);
		if($result->num_rows() > 0){
			return $result->result_array();	
		}else{
			return false;
		}
		
    }

    function getNoPo($where){
    	$sql = "SELECT DISTINCT pha.SEGMENT1 FROM khs_data_receipt_ppb kdrp, po_headers_all pha
				WHERE kdrp.po = pha.SEGMENT1
				AND kdrp.NO_SJ = '$where'";
		
		$result = $this->oracle->query($sql);
		if($result->num_rows() > 0){
			return $result->result_array();	
		}else{
			return false;
		}
		
    }

    function getInventoryItemId($where){
    	$sql = "SELECT DISTINCT msib.INVENTORY_ITEM_ID FROM mtl_system_items_b msib
				WHERE msib.SEGMENT1 = '$where'
				";
		$result = $this->oracle->query($sql);
		if($result->num_rows()  > 0){
			return $result->result_array();
		}else{
			return false;
		}
    }

    function getPoLineId($no_sj,$item_id){
    	$sql = "SELECT DISTINCT pla.PO_LINE_ID FROM khs_data_receipt_ppb kdrp, po_headers_all pha, po_lines_all pla
    			WHERE pha.PO_HEADER_ID = pla.PO_HEADER_ID
				AND kdrp.po = pha.SEGMENT1
				AND kdrp.NO_SJ = '$no_sj'
				AND pla.ITEM_ID = $item_id";
		$result = $this->oracle->query($sql);
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
			return false;
		}
    }

    public function getGroupId($where){
    	$sql = "SELECT RTI.GROUP_ID FROM RCV_TRANSACTIONS_INTERFACE RTI
				WHERE RTI.PO_HEADER_ID = $where
				ORDER BY RTI.CREATION_DATE DESC";
		$result = $this->oracle->query($sql);
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
			return false;
		}
    }

    public function insertTemp($value){
	$sql = "INSERT INTO KHS_RECEIPT_PO_TEMP (po_header_id,inventory_item_id,quantity_receipt,po_line_id,ip_address) VALUES (".$value['PO_HEADER_ID'].",".$value['PO_INVENTORY_ITEM_ID'].",".$value['QTY'].",".$value['PO_LINE_ID'].",'".$value['IP_ADDRESS']."')";
	$query = $this->oracle->query($sql);
	}

	public function runAPIone($value){
		$sql = "BEGIN
    				APPS.KHS_RECEIPT_PO ('AA TECH TSR 01','".$value['NO_PO']."',82,'".$value['IP_ADDRESS']."');
				END;
				";
		if($this->oracle->query($sql)){
			return true;
		}else{
			return false;
		}
	}

	public function runAPItwo($id){

		$sql  = "DECLARE
					v_request_id NUMBER;
				BEGIN
					apps.fnd_global.apps_initialize ( user_id => 5177, resp_id => 50630, resp_appl_id => 20003 );
						v_request_id := apps.fnd_request.submit_request ( application => 'PO',
						PROGRAM => 'RVCTP',
						argument1 => 'BATCH',
						argument2 => '$id',
						argument3 => 82);
					commit;
						dbms_output.put_line('Request Id '||v_request_id);
					END;
				";
		if($this->oracle->query($sql)){
			return true;
		}else{
			return false;
		}
	}

	public function getReceiptNumber($id){
		$sql = "SELECT max(rsh.RECEIPT_NUM) RECEIPT_NUM FROM rcv_transactions rt,rcv_shipment_headers rsh, po_headers_all pha
				WHERE rt.PO_HEADER_ID = $id
				AND rsh.SHIPMENT_HEADER_ID = rt.SHIPMENT_HEADER_ID
				AND pha.PO_HEADER_ID = rt.PO_HEADER_ID
				";
		$result = $this->oracle->query($sql);
		if($result->num_rows() > 0){
			return $result->result_array();
		}else{
			return false;
		}
	}

	public function deleteAll($ip){
		$sql = "DELETE FROM KHS_RECEIPT_PO_TEMP WHERE IP_ADDRESS = '$ip'";
		$this->oracle->query($sql);	
	}



	// public function runAPIone($value){
	// 	if (!$this->oracle) {
	// 		$m = oci_error();
	// 		trigger_error(htmlentities($m['message']), E_USER_ERROR);
	// 	}

	// 	$stid = oci_parse($this->oracle->conn_id, 'BEGIN APPS.KHS_RECEIPT_PO(:PARAMETER_1,:PARAMETER_2,:PARAMETER_3,:PARAMETER_4); end;');

	// 	$para1 = 'AA TECH TSR 01';
	// 	$para2 = 82;
	// 	oci_bind_by_name($stid, ':PARAMETER_1', $para1 ,200);
	// 	oci_bind_by_name($stid, ':PARAMETER_2',  $value['NO_PO'],200);
	// 	oci_bind_by_name($stid, ':PARAMETER_3',  $para2,200);
	// 	oci_bind_by_name($stid, ':PARAMETER_4',  $value['IP_ADDRESS'],200);
	

	// 	oci_execute($stid);
	// 	oci_free_statement($stid);
	// 	oci_close($this->oracle->conn_id);	
	// }
    //uppercase
}