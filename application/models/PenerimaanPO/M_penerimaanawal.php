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
				WHERE segment1 LIKE '$key%'
				AND rownum < 11
				OR description LIKE '$key%'
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

    function Subinv($PO){
    	$sql = "SELECT DISTINCT
				hla.location_code sub_inventory
				from
				rcv_transactions rt
				,rcv_shipment_headers rsh
				,mtl_system_items_b msib
				,po_headers_all pha
				,po_lines_all pla
				,po_line_locations_all plla
				,hr_locations_all_tl hla
				where
				rsh.shipment_header_id = rt.shipment_header_id
				and msib.inventory_item_id(+) = pla.item_id
				and msib.organization_id(+) = 81 
				and plla.PO_LINE_ID = pla.po_line_id
				and plla.ship_to_location_id = hla.LOCATION_id
				and rt.transaction_type = 'DELIVER'
				and pla.po_header_id = pha.po_header_id
				and pla.po_header_id = rt.po_header_id
				and pla.po_line_id = rt.po_line_id
				and pha.segment1 = $PO";
		$query = $this->oracle->query($sql);
		return $query->result();
    }

    function loadPoLine($PO){
    // 	$sql = "SELECT msib.segment1, pl.item_description,
				// pll.quantity, 0 ISI, rt.QUANTITY qty_receipt,
				// pll.QUANTITY - rt.QUANTITY belum_deliver
				// FROM po_lines_all pl,
				// po_line_locations_all pll,
				// mtl_parameters mp,
				// po_headers_all pha,
				// mtl_system_items_b msib,
				// rcv_transactions rt
				// WHERE pl.po_line_id = pll.po_line_id
				// AND pl.po_header_id = pha.po_header_id
				// AND pll.ship_to_organization_id = mp.organization_id
				// AND msib.inventory_item_id = pl.item_id
				// AND msib.ORGANIZATION_ID = pll.ship_to_organization_id
				// AND pll.quantity - pll.quantity_received > 0
				// and pl.po_header_id = rt.po_header_id
				// and pl.po_line_id = rt.po_line_id
				// AND pll.closed_CODE = 'OPEN'
				// AND pha.segment1 = $PO
				// group by msib.segment1, pl.item_description,
				// pll.quantity, rt.QUANTITY
				// ORDER BY pl.item_description";
		$sql = "SELECT DISTINCT msib.segment1, pla.line_num, pla.item_description,
                msib.receiving_routing_id routing, pll.quantity,
                NVL
                   (SUM (rt.quantity) OVER (PARTITION BY msib.segment1),
                    0
                   ) qty_receipt,
                NVL
                   ((  pll.quantity
                     - (SUM (rt.quantity) OVER (PARTITION BY msib.segment1))
                    ),
                    0
                   ) belum_deliver,
                pll.ship_to_organization_id, pll.closed_code close_code_line,
                pha.closed_code close_code_po
           FROM po_headers_all pha,
                po_lines_all pla,
                po_line_locations_all pll,
                rcv_transactions rt,
                mtl_system_items_b msib
          WHERE pha.po_header_id = pla.po_header_id
            AND pla.po_line_id = pll.po_line_id
            AND pla.item_id = msib.inventory_item_id
            AND rt.po_header_id = pha.po_header_id
            AND pha.closed_code = 'OPEN'
            AND pha.segment1 = $PO
       ORDER BY pla.line_num
";

        //kudune iso
		$query = $this->oracle->query($sql);
		return $query->result();
    }

    function generateSJ(){
    	$sql 	= "SELECT KHS_MO_FROM_KANBAN.nextval FROM dual";
    	$query 	= $this->oracle->query($sql);
    	return $query->result();
    }

    function insertDataAwal($po,$sj,$vendor,$item,$desc,$qtySJ,$rcptDate,$spDate,$qtyActual,$qtyPO,$qtyReceipt,$keterangan,$status){
    	$sql="INSERT INTO KHS_DATA_RECEIPT_PPB VALUES(
			  '$po','$sj','$vendor','$item','$desc', 
			  $qtySJ, $rcptDate, TO_DATE('$spDate', 'dd/mm/yyyy'),0,'$qtyPO','$qtyReceipt','$keterangan','$status')";
		$query = $this->oracle->query($sql);
    }

    function selectGenerate($where,$no_sj){
    	
    	$this->oracle->select('*');
    	$this->oracle->from('KHS_DATA_RECEIPT_PPB');
    	$this->oracle->where('PO',$where);
    	$this->oracle->where('NO_SJ',$no_sj);
    	$data = $this->oracle->get();

    	if($data->num_rows() > 0){
    		return $data->result_array();
    	}else{
    		return false;
    	}


   }
    //uppercase
}
