<?php
class M_transaction extends CI_Model {
    public function __construct()
    {
    	$this->oracle = $this->load->database ('oracle', TRUE);
    }
	
	function insertPacking($dt)
	{
		$this->oracle->insert('KHS_PACKINGLIST_TRANSACTIONS', $dt);
	}
	
	function deletePackingList($id)
	{
		$this->oracle->where('MO_NUMBER', $id);
		$this->oracle->delete('KHS_PACKINGLIST_TRANSACTIONS');
	}

	public function getPackingCode($spbNumber)
	{
		$sql = "
			SELECT packing_code
			FROM khs_packinglist_transactions
			WHERE mo_number= '$spbNumber'
			GROUP BY packing_code
			ORDER BY packing_code
		";

		$query = $this->oracle->query($sql);
		return $query->this->result_array();
	}

	public function getPackingListSatu($spbNumber, $packCode)
	{
		$sql = "
			SELECT rownum rn, kpt.mo_number, kpt.packing_qty, kpt.packing_code, msib.segment1, msib.description, msib.primary_uom_code, substr(kpt.packing_code,3) code_box, substr(kpt.packing_code,1,1) no_box,
			  	(SELECT count(bx.code) jumlah
			  	FROM
			  		( SELECT mo_number ,
			              packing_code ,
			              substr(packing_code,3) code ,
			              substr(packing_code,1,1) no_box
			      FROM khs_packinglist_transactions
			      WHERE mo_number = nvl('$spbNumber',mo_number)
			      GROUP BY packing_code,
			               mo_number
			      ORDER BY packing_code ) bx
			   WHERE bx.code = substr(kpt.packing_code,3)
			     AND bx.mo_number = kpt.mo_number
			   GROUP BY bx.code) jumlah
			FROM khs_packinglist_transactions kpt,
			     mtl_system_items_b msib
			WHERE kpt.mo_number = nvl('$spbNumber',kpt.mo_number)
			  AND kpt.packing_code = '$packCode'
			  AND kpt.inventory_item_id = msib.inventory_item_id
			  AND msib.organization_id = 81
			ORDER BY kpt.mo_number,
			         kpt.packing_code
		";

		$query = $this->oracle->query($sql);
		return $query->this->result_array();
	}
}