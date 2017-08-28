<?php
class M_Lppb extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	public function getSupplier(){
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("
			SELECT
				POV.VENDOR_ID,
				POV.VENDOR_NAME
			FROM
    			PO_VENDORS POV
    		ORDER BY
    			POV.VENDOR_NAME
		");
		return $query->result_array();
	}

	public function getInventory(){
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("
			SELECT 
				MP.ORGANIZATION_CODE, 
				MP.ORGANIZATION_ID
			FROM 
				MTL_PARAMETERS MP
			WHERE
				MP.ORGANIZATION_CODE LIKE 'Y%'
				OR
				MP.ORGANIZATION_ID IN (101, 102)
    		ORDER BY
    			MP.ORGANIZATION_CODE
		");
		return $query->result_array();
	}

	public function getLppbdata($tglawal, $tglakhir, $sqlSupplier, $sqlInventory, $sqlPo, $sortTerima){
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("
			SELECT DISTINCT
			    POV.VENDOR_NAME VENDOR,
			    MP.ORGANIZATION_CODE INVENTORY,
			    RSH.RECEIPT_NUM,
			    TO_CHAR(RSH.CREATION_DATE,'DD-MON-YYYY') RECEIPT_DATE,
			    POH.SEGMENT1 PO_NUM,
			    (SELECT KAL.TGL_TERIMA FROM KHS_AP_LPPB KAL WHERE KAL.PO_NUMBER=POH.SEGMENT1 AND KAL.RECEIPT_NUM=RSH.RECEIPT_NUM) TGL_TERIMA,
			    ATT.NAME TERMS_PO,
			    (SELECT KAL.TERIMA FROM KHS_AP_LPPB KAL WHERE KAL.PO_NUMBER=POH.SEGMENT1 AND KAL.RECEIPT_NUM=RSH.RECEIPT_NUM) TERIMA,
                (SELECT SUM (RT.QUANTITY) FROM RCV_TRANSACTIONS RT WHERE RSH.SHIPMENT_HEADER_ID = RT.SHIPMENT_HEADER_ID AND POH.PO_HEADER_ID = RT.PO_HEADER_ID AND RT.QUANTITY_BILLED IS NOT NULL) QAUNTITY,
                (SELECT SUM (RT.QUANTITY_BILLED) FROM RCV_TRANSACTIONS RT WHERE RSH.SHIPMENT_HEADER_ID = RT.SHIPMENT_HEADER_ID AND POH.PO_HEADER_ID = RT.PO_HEADER_ID AND RT.QUANTITY_BILLED IS NOT NULL) QUANTITY_BILLED
            FROM
			    RCV_SHIPMENT_HEADERS RSH,
			    MTL_PARAMETERS MP,
			    AP_TERMS_TL ATT,
			    PO_VENDORS POV,
			    PO_HEADERS_ALL POH,
			    RCV_TRANSACTIONS RT
			WHERE 
			    RSH.SHIPMENT_HEADER_ID = RT.SHIPMENT_HEADER_ID
			    AND
			    RSH.ORGANIZATION_ID = MP.ORGANIZATION_ID
			    AND
			    POH.PO_HEADER_ID = RT.PO_HEADER_ID
			    AND
			    RSH.VENDOR_ID = POV.VENDOR_ID
			    AND
			    ATT.TERM_ID = POH.TERMS_ID
			    AND 
			    RT.TRANSACTION_TYPE = 'RECEIVE'
			    AND
                RT.QUANTITY_BILLED IS NOT NULL
                AND
                QUANTITY-QUANTITY_BILLED > '0'
                AND
			    RSH.CREATION_DATE BETWEEN '$tglawal' AND '$tglakhir'
			    $sqlSupplier
			    $sqlInventory
			    $sqlPo
			    $sortTerima
		");
		return $query->result_array();
	}
	
	public function addTerima($vendor, $inventory, $receipt_num, $receipt_date, $po_num, $terms_po, $terima, $tgl_terima)
	{
		$oracle = $this->load->database("oracle",true);
		$check = $this->countAPLPPB($receipt_num, $po_num);
		if ($check[0]['COUNT(*)'] == '0') {
			$query = $oracle->query("
									INSERT INTO
									APPS.KHS_AP_LPPB
									(VENDOR_NAME, ORGANIZATION_CODE, RECEIPT_NUM, RECEIPT_DATE, PO_NUMBER, TERMS_PO, TERIMA, TGL_TERIMA)
									VALUES
									('$vendor', '$inventory', '$receipt_num', '$receipt_date', '$po_num', '$terms_po', '$terima', '$tgl_terima')
									");
		}else{
			$query = $oracle->query("
									UPDATE
									APPS.KHS_AP_LPPB KAL
									SET
									KAL.TERIMA = '$terima',
									KAL.TGL_TERIMA = '$tgl_terima'
									WHERE
									KAL.PO_NUMBER = '$po_num'
									AND
									KAL.RECEIPT_NUM = '$receipt_num'
									");
		};
		return $query;
	}

	public function countAPLPPB($receipt_num, $po_num)
	{
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("
								SELECT COUNT(*)
								FROM APPS.KHS_AP_LPPB KAL
								WHERE KAL.RECEIPT_NUM = $receipt_num AND KAL.PO_NUMBER = $po_num
								");

		return $query->result_array();
	}
}