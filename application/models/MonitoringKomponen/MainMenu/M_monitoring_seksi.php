<?php
class M_monitoring_seksi extends CI_Model {

    public function __construct()
    {
	   parent::__construct();
        }

	
	public function getSubinventory($c)
		{
			$oracle = $this->load->database("oracle", true);
			$query = $oracle->query("select msi.SECONDARY_INVENTORY_NAME from mtl_secondary_inventories msi where msi.SECONDARY_INVENTORY_NAME like '%$c%'"
			);
			return $query->result_array();
		}
	
	public function getKomponen($c)
		{
			$oracle = $this->load->database("oracle", true);
			$query = $oracle->query("select msib.SEGMENT1, msib.DESCRIPTION from mtl_system_items msib where msib.SEGMENT1 like '$c%'"
			);
			return $query->result_array();
		}
		
	public function getLocator($c,$si){
		$oracle = $this->load->database("oracle", true);
		$query = $oracle->query("select msi.SECONDARY_INVENTORY_NAME,mil.SEGMENT1,mil.INVENTORY_LOCATION_ID from 
								mtl_secondary_inventories msi,
								mtl_item_locations mil
								where 
								msi.SECONDARY_INVENTORY_NAME=mil.SUBINVENTORY_CODE and
								msi.SECONDARY_INVENTORY_NAME='$si' and
								mil.SEGMENT1 like '%$c%'");
		return $query->result_array();
	}
	
	public function tableView($tgl,$inv_from,$q_loc_sour,$inv_to,$q_loc_des,$comp,$order,$lap,$group){
		$oracle = $this->load->database("oracle", true);
		$query = "select 
									msib.SEGMENT1, msib.DESCRIPTION ,
									sum(moqd.PRIMARY_TRANSACTION_QUANTITY)  onhand,
									msib.MAX_MINMAX_QUANTITY,(sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY) boleh_kirim,
										  (CASE WHEN msib.MAX_MINMAX_QUANTITY is NULL THEN NULL ELSE 
												(CASE WHEN (sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY) > 0
													 THEN 'TIDAK'
													 ELSE 'BOLEH'
												 END)
											 END) status,msib.UNIT_VOLUME,msib.ATTRIBUTE14,
										  (mil.SEGMENT1 ) asal_item,
									(select lokasi
										from khsinvlokasisimpan mil
										where mil.SUBINV = nvl(bor.ATTRIBUTE1 ,bor.ATTRIBUTE2)
										and mil.KELOMPOK is null
										and mil.inventory_item_id = msib.INVENTORY_ITEM_ID
										and rownum = 1 ) lokasi, moqd.SUBINVENTORY_CODE
								from
									mtl_system_items_b msib,
									bom_operational_routings bor,
									mtl_item_locations mil,
									mtl_onhand_quantities_detail moqd
								where 
									msib.INVENTORY_ITEM_ID = bor.ASSEMBLY_ITEM_ID
									and msib.ORGANIZATION_ID = bor.ORGANIZATION_ID
									and msib.ORGANIZATION_ID='102'
									and mil.INVENTORY_LOCATION_ID=bor.COMPLETION_LOCATOR_ID
									and moqd.INVENTORY_ITEM_ID=msib.INVENTORY_ITEM_ID
									and moqd.SUBINVENTORY_CODE=bor.ATTRIBUTE1
									$inv_from
                                    $q_loc_sour
                                    $inv_to
									$q_loc_des
                                    $comp
								group by 
									msib.INVENTORY_ITEM_ID, msib.SEGMENT1, msib.DESCRIPTION,
									bor.COMPLETION_SUBINVENTORY,bor.ATTRIBUTE1, bor.ATTRIBUTE2, 
									mil.SEGMENT1,msib.MAX_MINMAX_QUANTITY,msib.UNIT_VOLUME,msib.ATTRIBUTE14,moqd.SUBINVENTORY_CODE $group
                                $lap
								order by
									$order";
		$sql = $oracle->query($query);
		return $sql->result_array();
	}
	
}