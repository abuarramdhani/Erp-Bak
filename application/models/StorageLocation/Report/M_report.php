<?php
class M_report extends CI_Model {

	var $oracle;
    public function __construct()
    {
    	parent::__construct();
      	$this->load->database();
      	$this->oracle = $this->load->database('oracle', TRUE);
    }

    function getStorageData($sub_inv,$locator,$kode_assy,$kode_item,$org_id,$sort)
    {
    	if(($sub_inv == "") and  ($locator == "") and ($kode_item == "") and ($org_id == "") and ($kode_assy == "")){
			$p = "";
		}else{
			$p = "and";
		}
			
		if($sub_inv == ""){
			$a = "";
		}else{
			$a = "kls.sub_inv = '$sub_inv'";
		}

		if($locator == ""){
			$b = "";
			$p1 = "";
		}else{
			$b = "kls.LOCATOR like upper('%$locator%')";
			if(($sub_inv == "")){
				$p1 = "";
			}else{
				$p1 = "and";
			}
		}
		
		if($kode_item == ""){
			$c = "";
			$p2 = "";
		}else{
			$c = "kls.COMPONENT like upper('%$kode_item%')";
			if(($sub_inv == "") and  ($locator == "")){
				$p2 = "";
			}else{
				$p2 = "and";
			}
		}

		if($kode_assy == ""){
			$e = "";
			$p4 = "";
		}else{
			$e = "kls.assembly = '$kode_assy'";
			if(($sub_inv == "") and  ($locator == "") and ($kode_item == "")){
				$p4 = "";
			}else{
				$p4 = "and";
			}
		}

		if($org_id == ""){
			$d = "";
			$p3 = "";
		}else{
			$d = "kls.organization_id = '$org_id'";
			if(($sub_inv == "") and  ($locator == "") and ($kode_item == "") and ($kode_assy == "")){
				$p3 = "";
			}else{
				$p3 = "and";
			}
		}
		
		$query = "	SELECT
						kls.component ITEM,
						msib.DESCRIPTION DESCRIPTION,
						kls.assembly KODE_ASSEMBLY,
						msib2.DESCRIPTION NAMA_ASSEMBLY,
						kls.assembly_type TYPE_ASSEMBLY,
						kls.sub_inv SUB_INV,
						kls.alamat_simpan ALAMAT,
						kls.LPPB_MO_KIB LMK,
						kls.picklist PICKLIST,
						(
							SELECT sum(moqd.PRIMARY_TRANSACTION_QUANTITY)
							FROM mtl_onhand_quantities_detail moqd
							WHERE moqd.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
								AND moqd.ORGANIZATION_ID = msib.ORGANIZATION_ID
								AND moqd.SUBINVENTORY_CODE = kls.SUB_INV
							GROUP BY moqd.SUBINVENTORY_CODE
						) onhand_qty,
					    (
					    	SELECT khs_inv_qty_atr(kls.ORGANIZATION_ID, msib.INVENTORY_ITEM_ID, kls.SUB_INV,  mil.INVENTORY_LOCATION_ID, null)
					    	FROM DUAL
					    ) ATR
					FROM
						mtl_system_items_b msib,
						mtl_system_items_b msib2 RIGHT JOIN khs.khslokasisimpan kls
							ON msib2.SEGMENT1 = kls.ASSEMBLY and kls.ORGANIZATION_ID = msib2.ORGANIZATION_ID
						left join mtl_item_locations mil
							ON mil.SEGMENT1  = kls.LOCATOR
					WHERE msib.SEGMENT1 = kls.COMPONENT
					AND msib.ORGANIZATION_ID = kls.ORGANIZATION_ID $p $a $p1 $b $p2 $c $p4 $e $p3 $d
					$sort";

		$sql= $this->oracle->query($query);
		return $sql->result_array();
    }
}