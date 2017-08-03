<?php
class M_report extends CI_Model {

	var $oracle;
    public function __construct()
    {
    	parent::__construct();
      	$this->load->database();
      	$this->oracle = $this->load->database('oracle', TRUE);
    }

    function getStorageData($sub_inv,$locator,$kode_item,$org_id)
    {
    	if(($sub_inv == "") and  ($locator == "") and ($kode_item == "") and ($org_id == "")){
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

		if($org_id == ""){
			$d = "";
			$p3 = "";
		}else{
			$d = "kls.organization_id = '$org_id'";
			if(($sub_inv == "") and  ($locator == "") and ($kode_item == "")){
				$p3 = "";
			}else{
				$p3 = "and";
			}
		}

		$query = "	SELECT DISTINCT kls.component ITEM,
						msib.DESCRIPTION DESCRIPTION,
						kls.assembly KODE_ASSEMBLY,
						msib2.DESCRIPTION NAMA_ASSEMBLY,
						kls.assembly_type TYPE_ASSEMBLY,
						kls.sub_inv SUB_INV,
						kls.alamat_simpan ALAMAT,
						kls.LPPB_MO_KIB LMK,
						kls.picklist PICKLIST,
    					(SELECT sum(moqd.PRIMARY_TRANSACTION_QUANTITY) FROM mtl_onhand_quantities_detail moqd
    					    WHERE moqd.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
    					    and moqd.ORGANIZATION_ID = msib.ORGANIZATION_ID
    					    AND moqd.SUBINVENTORY_CODE = kls.SUB_INV
    					    GROUP BY moqd.SUBINVENTORY_CODE) onhand_qty,
    					(SELECT khs_inv_qty_atr(kls.ORGANIZATION_ID, msib.INVENTORY_ITEM_ID, kls.SUB_INV,  mil.INVENTORY_LOCATION_ID, null) FROM DUAL) ATR
    				FROM mtl_system_items_b msib,
						mtl_item_locations mil RIGHT JOIN khs.khslokasisimpan kls2
							ON mil.segment1 = kls2.LOCATOR,
						mtl_secondary_inventories msi,
    					mtl_system_items_b msib2 RIGHT JOIN khs.khslokasisimpan kls
    						ON msib2.SEGMENT1 = kls.ASSEMBLY and kls.ORGANIZATION_ID = msib2.ORGANIZATION_ID
					WHERE kls.COMPONENT = msib.SEGMENT1
					    AND msib.ORGANIZATION_ID = kls.ORGANIZATION_ID
					    AND msi.SECONDARY_INVENTORY_NAME = mil.SUBINVENTORY_CODE $p $a $p1 $b $p2 $c $p3 $d
    				ORDER BY kls.component";

		$sql= $this->oracle->query($query);
		return $sql->result_array();
    }
}