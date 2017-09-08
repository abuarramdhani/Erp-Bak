<?php
class M_bonassets extends CI_Model {

    public function __construct()
    {
	   parent::__construct();
        $this->load->database();
		$this->load->library('encrypt');
		$this->load->helper('url');
    }

    public function search($receiptnum, $ponum)
    {
    	$db= $this->load->database('oracle', TRUE);
		$sql = $db->query("
			SELECT DISTINCT
			msib.segment1 KODE
			,pla.item_description DESKRIPSI
			,rsh.receipt_num NO_RECEIPT
			,rt.quantity+NVL((select min(rt2.QUANTITY)
			    from rcv_transactions rt2 , rcv_shipment_headers rsh2
			    where rt2.shipment_header_id = rsl.shipment_header_id
			    AND rt2.shipment_line_id = rsl.shipment_line_id
			    AND rt2.po_header_id = pha1.po_header_id
			    AND rt2.PO_LINE_ID = pla.PO_LINE_ID
			    AND rt2.SHIPMENT_HEADER_ID = rsh.SHIPMENT_HEADER_ID
			    AND rsh2.RECEIPT_NUM = rsh.RECEIPT_NUM
			    AND rt2.TRANSACTION_TYPE = 'CORRECT' ),0) QUANTITY
			,prl.reference_num NO_PP
			,pha1.segment1 NO_PO
			FROM
			rcv_shipment_headers rsh
			,rcv_shipment_lines rsl
			,mtl_system_items_b msib
			,rcv_transactions rt
			,ap_suppliers aps
			,ap_supplier_sites_all apsite
			,mtl_parameters mp
			,po_headers_all pha1--segment1 ponum
			,po_lines_all pla
			,po_requisition_headers_all prh
			,po_requisition_lines_all prl
			,po_distributions_all pda
			,po_req_distributions_all prda
			,per_all_people_f papf2
			WHERE
			rsh.shipment_header_id = rsl.shipment_header_id
			AND rt.shipment_header_id = rsl.shipment_header_id
			AND rt.shipment_line_id = rsl.shipment_line_id
			AND msib.inventory_item_id = rsl.item_id
			AND rt.vendor_id = aps.vendor_id
			AND aps.vendor_id = apsite.vendor_id
			AND rt.po_header_id = pha1.po_header_id
			AND pla.po_line_id = rt.po_line_id
			AND msib.organization_id = 81
			AND rt.transaction_type = 'RECEIVE'
			AND rt.destination_type_code = 'RECEIVING'
			AND rsh.ship_to_org_id = mp.organization_id
			AND pla.po_header_id = pha1.po_header_id
			AND pda.po_header_id = pla.po_header_id
			AND pla.po_line_id = pda.po_line_id
			AND pda.req_distribution_id = prda.distribution_id(+)
			AND prda.requisition_line_id = prl.requisition_line_id(+)
			AND prh.requisition_header_id(+) = prl.requisition_header_id 
			AND papf2.person_id = prl.to_person_id
			AND prl.reference_num like '%$receiptnum%'
			AND pha1.segment1 like '%$ponum%'
			");
		return $sql->result_array();
    }

    public function getSeksi($userCode){
		$sql = "select section_name from er.vi_er_employee_data where employee_code='$userCode'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function setDataAsset($data){
		return $this->db->insert('fa.fa_asset_belum_proses', $data);
	}

	public function getDocNum(){
		$sql = "select num from fa.fa_last_doc_num order by num desc limit 1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function updateDocNum($number){
		$numberArr = $this->M_bonassets->getDocNum();
		$prevNum = $numberArr[0]['num'];
		if ($prevNum <= $number) {
			$this->db->query("UPDATE fa.fa_last_doc_num SET num = '".$number."'");
		}
		
	}

}