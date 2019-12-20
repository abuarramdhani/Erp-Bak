<?php
class M_ajax extends CI_Model {
    public function __construct()
    {
    	$this->oracle = $this->load->database ('oracle', TRUE);
    	// $this->oracle = $this->load->database ('oracle_dev', TRUE);
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

    public function checkSPB($ip){
    	$query = "SELECT * FROM KHS_PACKINGLIST_TRANSACT_TEMP WHERE IP = '$ip'";
    	$result = $this->oracle->query($query);

    	if($result->num_rows() > 0){
    		return $result->result_array();
    	}
    }

	function getSPB($id, $subInv)
	{
		$sql	= "SELECT DISTINCT mtrh.request_number no_spb, mtrl.line_number,
                msib.segment1 item_code, msib.description item_desc,msib.ATTRIBUTE26 quantity_standard,
                mtrl.quantity quantity_normal,
                mtrl.quantity_detailed quantity_allocate,
                (  mtrl.quantity_delivered
                 - NVL ((SELECT SUM (NVL (kpt.packing_qty, 0))
                           FROM khs_packinglist_transactions kpt
                          WHERE kpt.mo_number = mtrh.request_number
                            AND kpt.inventory_item_id = mtrl.inventory_item_id),
                        0
                       )
                ) quantity_transact,
                khs_inv_qty_att (mtrl.organization_id,
                                 mtrl.inventory_item_id,
                                 '$subInv',
                                 '',
                                 ''
                                ) qty_att,
                khs_inv_qty_atr (mtrl.organization_id,
                                 mtrl.inventory_item_id,
                                 '$subInv',
                                 '',
                                 ''
                                ) qty_atr,
                (SELECT SUM (moqd.primary_transaction_quantity)
                   FROM mtl_onhand_quantities_detail moqd
                  WHERE moqd.subinventory_code = '$subInv'
                    AND moqd.inventory_item_id = mtrl.inventory_item_id
                    AND moqd.organization_id = mtrl.organization_id)
                                                                    qty_total,
                msib.inventory_item_id, mtrl.line_status
           FROM mtl_txn_request_headers mtrh,
                mtl_txn_request_lines mtrl,
                mtl_system_items_b msib
          WHERE mtrh.header_id = mtrl.header_id
            AND msib.inventory_item_id = mtrl.inventory_item_id
            AND mtrh.request_number = '$id'
            AND msib.organization_id  = 81
		-- AND mtrl.organization_id = 225
		ORDER BY  no_spb, line_number";

        // echo "<pre>";
        // print_r($sql);
        // exit();

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

    public function getEkspedisiList(){
        $sql = "
            SELECT ffvv.FLEX_VALUE_MEANING eks
            from FND_FLEX_VALUES_VL ffvv
            where ffvv.FLEX_VALUE_SET_ID = 1018949
            AND ffvv.ENABLED_FLAG = 'Y'
        ";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

	public function getLastPackCode($id)
	{
		$sql = "
			SELECT
				MAX( SUBSTR( KPT.PACKING_CODE, 4 )) lastpacknumber
			FROM
				KHS_PACKINGLIST_TRANSACTIONS KPT
			WHERE
				KPT.MO_NUMBER = '$id'
		";

		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function insertTemp($data){
		return $this->oracle->insert('KHS_PACKINGLIST_TRANSACT_TEMP',$data);
	}

	public function delTemp($ip){
		$this->oracle->where('IP',$ip);
		$this->oracle->delete('KHS_PACKINGLIST_TRANSACT_TEMP');
    }
    
    public function insertError($ip){
        $sql = "INSERT INTO KHS_PACKINGLIST_TEMP_ERR
        (IP, NO_SPB )
        SELECT IP, NO_SPB
        FROM KHS_PACKINGLIST_TRANSACT_TEMP
        WHERE IP = '$ip'";

        $query = $this->oracle->query($sql);
    }

    public function delTable($ip){
        $sql = "DELETE FROM KHS_PACKINGLIST_TRANSACT_TEMP kmtt WHERE kmtt.IP = '$ip'";
        
        $query = $this->oracle->query($sql);
        $query2 = $this->oracle->query('commit');
    }
    
    

}