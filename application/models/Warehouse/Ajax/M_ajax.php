<?php
class M_ajax extends CI_Model {
    public function __construct()
    {
    	$this->oracle = $this->load->database ('oracle', TRUE);
    }
	
	function getSPB($id)
	{
		$sql	= "SELECT DISTINCT mtrh.request_number no_spb, mtrl.line_number,
		                msib.segment1 item_code, msib.description item_desc,
		                mtrl.quantity,
		                khs_inv_qty_att (mtrl.organization_id,
		                                 mtrl.inventory_item_id,
		                                 -- 'SP-YSP',
		                                 'SP-DM',
		                                 '',
		                                 ''
		                                ) qty_onhand
		           FROM mtl_txn_request_headers mtrh,
		                mtl_txn_request_lines mtrl,
		                mtl_system_items_b msib
		          WHERE mtrh.header_id = mtrl.header_id
		            AND msib.inventory_item_id = mtrl.inventory_item_id
		            AND mtrh.request_number = '$id'
		            -- AND mtrl.organization_id = 225
		       ORDER BY no_spb, line_number";

		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
}