<?php
class M_PenerimaanAwal extends CI_Model {

	var $oracle;
    public function __construct(){
    	parent::__construct();
      	$this->load->database();
      	$this->oracle = $this->load->database('oracle', TRUE);
  		$this->load->library('encrypt');
  		$this->load->helper('url');
    }

    function getListVendor($key){
    	$sql = "SELECT vendor_name FROM ap_suppliers
				   WHERE vendor_name LIKE '%$key%'
				   AND rownum < 11";
		$query = $this->oracle->query($sql);
		return $query->result();
    }

    function getListItem($key){
    	$sql = "SELECT segment1, description  
				FROM mtl_system_items_b
				WHERE segment1 LIKE '%$key%'
				AND rownum < 11
				OR description LIKE '%$key%'
				AND rownum < 11
				GROUP BY segment1, description";		
		$query = $this->oracle->query($sql);
		return $query->result();
    }

    function loadVendor($PO){
    	$sql = "SELECT asup.vendor_name 
				FROM po_headers_all pha, 
				ap_suppliers asup 
				WHERE pha.vendor_id = asup.vendor_id
				AND pha.segment1 = $PO";
		$query = $this->oracle->query($sql);
		return $query->result();
    }

    function loadPoLine($PO){
    	$sql = "SELECT msib.segment1, pl.item_description,
				pll.quantity, 0 ISI
				FROM po_lines_all pl,
				po_line_locations_all pll,
				mtl_parameters mp,
				po_headers_all pha,
				mtl_system_items_b msib
				WHERE pl.po_line_id = pll.po_line_id
				AND pl.po_header_id = pha.po_header_id
				AND pll.ship_to_organization_id = mp.organization_id
				AND msib.inventory_item_id = pl.item_id
				AND msib.ORGANIZATION_ID = pll.ship_to_organization_id
				AND pll.quantity - pll.quantity_received > 0
				AND pll.closed_CODE = 'OPEN'
				AND pha.segment1 = $PO
				ORDER BY pl.item_description";
		$query = $this->oracle->query($sql);
		return $query->result();
    }

    function generateSJ(){
    	$sql 	= "SELECT KHS_MO_FROM_KANBAN.nextval FROM dual";
    	$query 	= $this->oracle->query($sql);
    	return $query->result();
    }

    function insertDataAwal($po,$sj,$vendor,$item,$desc,$qtySJ,$rcptDate,$spDate,$qtyActual,$qtyPO){
    	$sql="INSERT INTO KHS_DATA_RECEIPT_PPB VALUES(
			  '$po','$sj','$vendor','$item','$desc', 
			  $qtySJ, $rcptDate, TO_DATE('$spDate', 'mm/dd/yyyy'),0,'$qtyPO')";
		echo $sql;
		$query = $this->oracle->query($sql);
    }

}
