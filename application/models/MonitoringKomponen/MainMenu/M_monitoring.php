<?php
class M_monitoring extends CI_Model {

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
			$query = $oracle->query("select msib.SEGMENT1, msib.DESCRIPTION from mtl_system_items msib where msib.SEGMENT1 like '$c%' and msib.ORGANIZATION_ID='102'"
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
	
	public function MonitoringKomponen($tgl,$inv_from,$loc_from,$inv_to,$loc_des,$cd_kom,$sort,$lap,$separated){
		$oracle = $this->load->database("oracle", true);
		$query = $oracle->query("select 
								msi.SEGMENT1 ,msi.DESCRIPTION, sum(moqd.PRIMARY_TRANSACTION_QUANTITY) onhand,
								msi.MAX_MINMAX_QUANTITY, (msi.MAX_MINMAX_QUANTITY - sum(moqd.PRIMARY_TRANSACTION_QUANTITY)) boleh_kirim,
                                (CASE WHEN (sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msi.MAX_MINMAX_QUANTITY) > 0
                                     THEN 'TIDAK'
                                     ELSE 'BOLEH'
                                 END) status, msi.UNIT_VOLUME, msi.ATTRIBUTE14,
									min((case when (select (select flv.DESCRIPTION from FND_LOOKUP_Values flv where flv.LOOKUP_TYPE = 'ITEM_TYPE' and flv.LOOKUP_CODE = msib_type.ITEM_TYPE) ITEM_TYPE 
								  from mtl_system_items_b msib_type where msib_type.INVENTORY_ITEM_ID = msi.INVENTORY_ITEM_ID and msib_type.ORGANIZATION_ID = msi.ORGANIZATION_ID) like 'KHS%Buy%' then 'Suplier'
								  when ((select msib2.SEGMENT1 from mtl_system_items_b msib2 where msib2.SEGMENT1 like (select 'JAC'||substr(msib3.SEGMENT1,1,(LENGTH(msib3.SEGMENT1))-2)||'%' from mtl_system_items_b msib3 where msib3.SEGMENT1 = msi.SEGMENT1 AND msib3.ORGANIZATION_ID = 102 AND ROWNUM = 1 ) and rownum = 1)) is not null then 'Subkon'
								  else
								  (NVL((select fm.ATTRIBUTE2 || fm.ATTRIBUTE3 from FM_MATL_DTL fm 
								  where fm.INVENTORY_ITEM_ID = msi.INVENTORY_ITEM_ID
								  and rownum =1),(NVL((select mil.SEGMENT1 from mtl_item_locations mil
								  where mil.INVENTORY_LOCATION_ID = (select bor.COMPLETION_LOCATOR_ID 
															   from bom_operational_routings bor 
															   where bor.ASSEMBLY_ITEM_ID = msi.INVENTORY_ITEM_ID
															   and bor.ORGANIZATION_ID = msi.ORGANIZATION_ID
															   and rownum = 1)),(select bor.COMPLETION_SUBINVENTORY 
								  from bom_operational_routings bor 
								  where bor.ASSEMBLY_ITEM_ID = msi.INVENTORY_ITEM_ID
								  and bor.ORGANIZATION_ID = msi.ORGANIZATION_ID
								  and rownum = 1)))))end)) asal_komp,
                                  kil.LOKASI,
                                  moqd.SUBINVENTORY_CODE 
							from 
								mtl_onhand_quantities_detail moqd,
								mtl_system_items_b msi,
								khsinvlokasisimpan kil
							where 
								moqd.INVENTORY_ITEM_ID=msi.INVENTORY_ITEM_ID
								and msi.ORGANIZATION_ID='102'
								and moqd.SUBINVENTORY_CODE='KOM1-DM'
								and moqd.SUBINVENTORY_CODE=kil.SUBINV
								and msi.INVENTORY_ITEM_ID=kil.INVENTORY_ITEM_ID
								and kil.KELOMPOK is null
								$inv_from $inv_to $loc_from $cd_kom
							group by
								$sort $separated msi.DESCRIPTION,
								moqd.SUBINVENTORY_CODE,msi.MAX_MINMAX_QUANTITY, kil.LOKASI,
                                msi.UNIT_VOLUME, msi.ATTRIBUTE14 
							order by $sort");
		return $query->result_array();
	}
	
}