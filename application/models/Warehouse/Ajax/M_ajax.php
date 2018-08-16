<?php
class M_ajax extends CI_Model {
    public function __construct()
    {
    	$this->oracle = $this->load->database ('oracle', TRUE);
    }

    public function getSubInv($id)
    {
    	$sql = "
    		SELECT mtrh.FROM_SUBINVENTORY_CODE
			FROM mtl_txn_request_headers mtrh
			WHERE mtrh.REQUEST_NUMBER = '$id'
    	";

    	$query = $this->oracle->query($sql);
		return $query->result_array();
    }

	function getSPB($id, $subInv)
	{
		$sql	= "
					SELECT
						DISTINCT mtrh.request_number no_spb,
						mtrl.line_number,
						msib.segment1 item_code,
						msib.description item_desc,
						mtrl.quantity quantity_normal,
						(
							mtrl.quantity - NVL(( SELECT SUM( NVL( kpt.packing_qty, 0 )) FROM khs_packinglist_transactions kpt WHERE kpt.mo_number = mtrh.request_number AND kpt.inventory_item_id = mtrl.inventory_item_id ), 0 )
						) quantity,
						khs_inv_qty_att(
							mtrl.organization_id,
							mtrl.inventory_item_id,
							'$subInv',
							'',
							''
						) qty_att,
						khs_inv_qty_atr(
							mtrl.organization_id,
							mtrl.inventory_item_id,
							'$subInv',
							'',
							''
						) qty_atr,
						(
							SELECT
								SUM( moqd.primary_transaction_quantity )
							FROM
								mtl_onhand_quantities_detail moqd
							WHERE
								moqd.subinventory_code = '$subInv'
								AND moqd.inventory_item_id = mtrl.inventory_item_id
								AND moqd.organization_id = mtrl.organization_id
						) qty_total,
						msib.inventory_item_id
					FROM
						mtl_txn_request_headers mtrh,
						mtl_txn_request_lines mtrl,
						mtl_system_items_b msib
					WHERE
						mtrh.header_id = mtrl.header_id
						AND msib.inventory_item_id = mtrl.inventory_item_id
						AND mtrh.request_number = '$id'
						-- AND mtrl.organization_id = 225
					ORDER BY
						no_spb,
						line_number";

		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function getEkpedisi($spbnumber)
	{
		$sql = "
			SELECT mtrh.ATTRIBUTE15
			FROM mtl_txn_request_headers mtrh
			WHERE mtrh.REQUEST_NUMBER = '$spbnumber'
		";

		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
}