<?php defined('BASEPATH') OR die('No direct script access allowed');
class M_exportmo extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function search($date1,$date2,$dept)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT distinct we.WIP_ENTITY_ID job_id
        ,we.WIP_ENTITY_NAME
        ,msib.SEGMENT1 item_code
        ,msib.DESCRIPTION item_desc
        ,wdj.start_quantity
        ,wdj.QUANTITY_COMPLETED
        ,(wdj.START_QUANTITY - wdj.QUANTITY_COMPLETED) REMAINING
        ,bd.DEPARTMENT_CLASS_CODE dept_class
        ,bcs.DESCRIPTION
        ,wdj.STATUS_TYPE
        --
        ,(CASE
              WHEN wdj.STATUS_TYPE = 3
                  THEN 'RELEASED'
              WHEN wdj.STATUS_TYPE = 7
                  THEN 'CANCELLED'
              WHEN wdj.STATUS_TYPE = 4
                  THEN 'COMPLETE'
              ELSE 
                  'UNKNOWN'
            END) STATUS
        ,mtrh.REQUEST_NUMBER PIKLIST
        --
  from wip_entities we
      ,wip_discrete_jobs wdj
      ,mtl_system_items_b msib
      ,wip_requirement_operations wro
      ,bom_bill_of_materials bom
--                    ,bom_inventory_components bic
      ,MTL_ITEM_LOCATIONS mil
      ,wip_operations wo
      ,bom_calendar_shifts bcs
      ,bom_departments bd
      ,BOM_OPERATIONAL_ROUTINGS bor
      ,mtl_txn_request_headers mtrh
  where we.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
    and we.ORGANIZATION_ID = wdj.ORGANIZATION_ID
    and we.PRIMARY_ITEM_ID = msib.INVENTORY_ITEM_ID
    and we.ORGANIZATION_ID = msib.ORGANIZATION_ID
    and mtrh.ATTRIBUTE1 = we.WIP_ENTITY_ID
    and mtrh.ORGANIZATION_ID = we.ORGANIZATION_ID
    and wdj.WIP_ENTITY_ID = wro.WIP_ENTITY_ID
--                  and bom.BILL_SEQUENCE_ID = bic.BILL_SEQUENCE_ID
    and bom.ASSEMBLY_ITEM_ID = msib.INVENTORY_ITEM_ID
    and bom.organization_id = msib.ORGANIZATION_ID
    and wdj.COMMON_BOM_SEQUENCE_ID = bom.COMMON_BILL_SEQUENCE_ID
--                  and bic.ATTRIBUTE2 = mil.INVENTORY_LOCATION_ID(+)
    --routing
    and wdj.COMMON_ROUTING_SEQUENCE_ID = bor.ROUTING_SEQUENCE_ID
    --
    and wo.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
    and wo.ORGANIZATION_ID = we.ORGANIZATION_ID
    and wo.DEPARTMENT_ID = bd.DEPARTMENT_ID
    and khs_shift(wdj.SCHEDULED_START_DATE) = bcs.SHIFT_NUM
    and wdj.STATUS_TYPE = 3
--                  and we.WIP_ENTITY_NAME = 'D191208324'
    and trunc(wdj.SCHEDULED_START_DATE) between '$date1' and '$date2' --'12-NOV-18'    --parameter
    --
  --  and bcs.SHIFT_NUM = ''      --parameter 1,  2, 3, 4,
    and bd.DEPARTMENT_CLASS_CODE = '$dept'       --parameter SUBKT, MACHA
  order by we.WIP_ENTITY_ID asc	";
		
		// echo "<pre>";
		// print_r($sql);
		// exit();			
		$query = $oracle->query($sql);
		return $query->result_array();
		// return $sql;
	}


	function getDetail($date1,$date2,$dept)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "
				SELECT
				msib_produk.segment1 PRODUK,
				msib_produk.description PRODUK_DESC,
				msib_produk.inventory_item_id,
				msib_produk.organization_id,
				KHS_INV_UTILITIES_PKG.GET_KLMPK_PRODUCT(msib_produk.inventory_item_id) kategori_produk,
				to_char(
				sysdate,
				'DD/MM/YYYY HH24:MI:SS'
				) Print_date,
				to_char(
				NVL(wdj.DATE_RELEASED,wdj.SCHEDULED_START_DATE),
				'DD/MM/YYYY HH24:MI:SS'
				) DATE_REQUIRED,
				bd.DEPARTMENT_CLASS_CODE department, --Produk
				mtrh.request_number move_order_no,
				we.WIP_ENTITY_NAME job_no,
								wdj.start_quantity
								,wdj.QUANTITY_COMPLETED
								,(wdj.START_QUANTITY - wdj.QUANTITY_COMPLETED) REMAINING
								,wdj.STATUS_TYPE
								--
											,(CASE
														WHEN wdj.STATUS_TYPE = 3
																THEN 'RELEASED'
														WHEN wdj.STATUS_TYPE = 7
																THEN 'CANCELLED'
														WHEN wdj.STATUS_TYPE = 4
																THEN 'COMPLETE'
														ELSE 
																'UNKNOWN'
													END) STATUS,
				--component
				msib_compnt.SEGMENT1 kode_komponen,
				msib_compnt.description kode_desc,
				msib_compnt.inventory_item_id item_id_komponen,
				msib_compnt.organization_id org_id_komponen,
				wro.QUANTITY_PER_ASSEMBLY Qty_UNIT,
				mtrl.QUANTITY qty_minta,
				mtrl.FROM_SUBINVENTORY_CODE lokasi,
				bcs.DESCRIPTION || '(' || to_char(
				to_date(
				bst.FROM_TIME,
				'SSSSS'
				),
				'HH24:MI:SS'
				)|| ' s/d ' || to_char(
				to_date(
				bst.to_TIME,
				'SSSSS'
				),
				'HH24:MI:SS'
				)|| ')' SCHEDULE,
				mtrl.UOM_CODE UoM,
				mtrh.CREATION_DATE,
				(
				case
				when(
				select
				lokasi
				from
				khsinvlokasisimpan kls
				where
				subinv = mtrl.FROM_SUBINVENTORY_CODE
				and inventory_item_id = mtrl.inventory_item_id
				and kls.KELOMPOK = KHS_INV_UTILITIES_PKG.GET_KLMPK_PRODUCT(msib_produk.inventory_item_id)
				and rownum = 1
				) is null then(
				case
				when(
				select
				lokasi
				from
				khsinvlokasisimpan kls
				where
				subinv = mtrl.FROM_SUBINVENTORY_CODE
				and inventory_item_id = mtrl.inventory_item_id
				and kls.KELOMPOK is not null
				and rownum = 1
				) is null then(
				select
				lokasi
				from
				khsinvlokasisimpan kls
				where
				subinv = mtrl.FROM_SUBINVENTORY_CODE
				and inventory_item_id = mtrl.inventory_item_id
				and rownum = 1
				)
				else(
				select
				lokasi
				from
				khsinvlokasisimpan kls
				where
				subinv = mtrl.FROM_SUBINVENTORY_CODE
				and inventory_item_id = mtrl.inventory_item_id
				and kls.KELOMPOK is not null
				and rownum = 1
				)
				end
				)
				else(
				select
				lokasi
				from
				khsinvlokasisimpan kls
				where
				subinv = mtrl.FROM_SUBINVENTORY_CODE
				and inventory_item_id = mtrl.inventory_item_id
				and kls.KELOMPOK = KHS_INV_UTILITIES_PKG.GET_KLMPK_PRODUCT(msib_produk.inventory_item_id)
				and rownum = 1
				)
				end
				) loc,
				khs_inv_qty_atr(
				msib_compnt.organization_id,
				msib_compnt.inventory_item_id,
				mtrl.FROM_SUBINVENTORY_CODE,
				'',
				''
				) ATR
				from
				mtl_txn_request_headers mtrh,
				mtl_txn_request_lines mtrl,
				mtl_system_items_b msib_compnt, --JOB
				wip_entities we,
				wip_discrete_jobs wdj,
				wip_requirement_operations wro,
				wip_operations wo,
				BOM_DEPARTMENTS bd, -- produk
				mtl_system_items_b msib_produk, --shift
				BOM_SHIFT_TIMES bst,
				BOM_CALENDAR_SHIFTS bcs
				where
				mtrh.header_id = mtrl.header_id
				and mtrh.ATTRIBUTE1 = we.WIP_ENTITY_ID
				and we.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
				and wdj.primary_item_id = msib_produk.INVENTORY_ITEM_ID
				and wdj.ORGANIZATION_ID = msib_produk.ORGANIZATION_ID -- wro
				and msib_compnt.INVENTORY_ITEM_ID = wro.INVENTORY_ITEM_ID
				and msib_compnt.ORGANIZATION_ID = wro.ORGANIZATION_ID
				and wro.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
				and wro.ORGANIZATION_ID = wdj.ORGANIZATION_ID
				and wro.wip_entity_id = wo.WIP_ENTITY_ID
				and wro.OPERATION_SEQ_NUM = wo.OPERATION_SEQ_NUM
				and wo.DEPARTMENT_ID = bd.DEPARTMENT_ID -- shift
				and bcs.CALENDAR_CODE = 'KHS_CAL'
				and bst.SHIFT_NUM = khs_shift(wdj.SCHEDULED_START_DATE)
				and bst.CALENDAR_CODE = bcs.CALENDAR_CODE
				and bcs.SHIFT_NUM = bst.SHIFT_NUM --hard_code
				-- and mtrl.FROM_SUBINVENTORY_CODE not like 'INT%'
				and wro.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
				and trunc(wdj.SCHEDULED_START_DATE) between '$date1' and '$date2' --'12-NOV-18'    --parameter
				and bd.DEPARTMENT_CLASS_CODE = '$dept'       --parameter SUBKT, MACHA
				order by
				mtrl.LINE_ID,
				we.WIP_ENTITY_NAME,
				mtrl.FROM_SUBINVENTORY_CODE,
				msib_compnt.SEGMENT1
		";

		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getBody($job_no,$atr,$dept) //----------------->>
	{
		$oracle = $this->load->database('oracle',TRUE);
		// $sql = "SELECT we.WIP_ENTITY_ID job_id
		// 	      ,we.WIP_ENTITY_NAME 
		// 	      ,msib2.SEGMENT1 komponen
		// 	      ,msib2.DESCRIPTION komp_desc
		// 	      ,msib2.inventory_item_id
		// 	      ,wro.REQUIRED_QUANTITY
		// 	      ,msib2.PRIMARY_UOM_CODE
		// 	      ,bic.ATTRIBUTE1 gudang_asal
		// 	      ,mil.SEGMENT1 locator_asal
		// 	      ,BIC.ATTRIBUTE2
		// 	      ,mil.INVENTORY_LOCATION_ID locator_asal_id
		// 	      ,bic.SUPPLY_SUBINVENTORY gudang_tujuan
		// 	      ,bic.SUPPLY_LOCATOR_ID locator_tujuan_id 
		// 	      ,mil2.SEGMENT1 locator_tujuan
		// 	      ,khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') atr
		// 	      ,bd.DEPARTMENT_CLASS_CODE dept_class
		// 	      ,bcs.DESCRIPTION
		// 	      ,wdj.SCHEDULED_START_DATE 
		// 	      --
		// 	      ,coalesce((nvl(
		// 	           (select sum(mtrl.QUANTITY)
		// 	              from mtl_txn_request_headers mtrh
		// 	                  ,mtl_txn_request_lines mtrl
		// 	                  ,mtl_system_items_b msib_komp
		// 	             where mtrh.HEADER_ID = mtrl.HEADER_ID
		// 	               and mtrh.ORGANIZATION_ID = msib_komp.ORGANIZATION_ID
		// 	               and mtrl.INVENTORY_ITEM_ID = msib_komp.INVENTORY_ITEM_ID
		// 	               --
		// 	               and mtrl.LINE_STATUS in (3,7)
		// 	               and mtrh.HEADER_STATUS in (3,7)
		// 	               and mtrl.INVENTORY_ITEM_ID = wro.INVENTORY_ITEM_ID
		// 	               and mtrh.ORGANIZATION_ID = wro.ORGANIZATION_ID
		// 	               and substr(mtrh.REQUEST_NUMBER,1,2) = 'PL'
		// 	               and mtrl.FROM_SUBINVENTORY_CODE = bic.ATTRIBUTE1
		// 	               and mtrl.FROM_LOCATOR_ID = bic.ATTRIBUTE2
		// 	          group by mtrl.INVENTORY_ITEM_ID
		// 	            ),0))
		// 	            ,(nvl(
		// 	           (select sum(mtrl.QUANTITY)
		// 	              from mtl_txn_request_headers mtrh
		// 	                  ,mtl_txn_request_lines mtrl
		// 	                  ,mtl_system_items_b msib_komp
		// 	             where mtrh.HEADER_ID = mtrl.HEADER_ID
		// 	               and mtrh.ORGANIZATION_ID = msib_komp.ORGANIZATION_ID
		// 	               and mtrl.INVENTORY_ITEM_ID = msib_komp.INVENTORY_ITEM_ID
		// 	               --
		// 	               and mtrl.LINE_STATUS in (3,7)
		// 	               and mtrh.HEADER_STATUS in (3,7)
		// 	               and mtrl.INVENTORY_ITEM_ID = wro.INVENTORY_ITEM_ID
		// 	               and mtrh.ORGANIZATION_ID = wro.ORGANIZATION_ID
		// 	               and substr(mtrh.REQUEST_NUMBER,1,2) = 'PL'
		// 	               and mtrl.FROM_SUBINVENTORY_CODE = bic.ATTRIBUTE1
		// 	               and mtrl.FROM_LOCATOR_ID is null
		// 	          group by mtrl.INVENTORY_ITEM_ID
		// 	            ),0))
		// 	            ) mo
		// 	,(
		// 	            (coalesce(
		// 	                (select sum(moqd.PRIMARY_TRANSACTION_QUANTITY)
		// 	                   from mtl_onhand_quantities_detail moqd
		// 	                  where moqd.ORGANIZATION_ID = wdj.ORGANIZATION_ID
		// 	                    and moqd.INVENTORY_ITEM_ID = wro.INVENTORY_ITEM_ID
		// 	                    and moqd.SUBINVENTORY_CODE = bic.ATTRIBUTE1
		// 	                    and moqd.LOCATOR_ID = bic.ATTRIBUTE2),
		// 	                (select sum(moqd.PRIMARY_TRANSACTION_QUANTITY)
		// 	                   from mtl_onhand_quantities_detail moqd
		// 	                  where moqd.ORGANIZATION_ID = wdj.ORGANIZATION_ID
		// 	                    and moqd.INVENTORY_ITEM_ID = wro.INVENTORY_ITEM_ID
		// 	                    and moqd.SUBINVENTORY_CODE = bic.ATTRIBUTE1)
		// 	                    )
		// 	                )-
		// 	               coalesce((nvl(
		// 	                   (select sum(mtrl.QUANTITY)
		// 	                      from mtl_txn_request_headers mtrh
		// 	                          ,mtl_txn_request_lines mtrl
		// 	                          ,mtl_system_items_b msib_komp
		// 	                     where mtrh.HEADER_ID = mtrl.HEADER_ID
		// 	                       and mtrh.ORGANIZATION_ID = msib_komp.ORGANIZATION_ID
		// 	                       and mtrl.INVENTORY_ITEM_ID = msib_komp.INVENTORY_ITEM_ID
		// 	                       --
		// 	                       and mtrl.LINE_STATUS in (3,7)
		// 	                       and mtrh.HEADER_STATUS in (3,7)
		// 	                       and mtrl.INVENTORY_ITEM_ID = wro.INVENTORY_ITEM_ID
		// 	                       and mtrh.ORGANIZATION_ID = wro.ORGANIZATION_ID
		// 	                       and substr(mtrh.REQUEST_NUMBER,1,2) = 'PL'
		// 	                       and mtrl.FROM_SUBINVENTORY_CODE = bic.ATTRIBUTE1
		// 	                       and mtrl.FROM_LOCATOR_ID = bic.ATTRIBUTE2
		// 	                  group by mtrl.INVENTORY_ITEM_ID
		// 	                    ),0) )
		// 	                    ,(nvl(
		// 	                   (select sum(mtrl.QUANTITY)
		// 	                      from mtl_txn_request_headers mtrh
		// 	                          ,mtl_txn_request_lines mtrl
		// 	                          ,mtl_system_items_b msib_komp
		// 	                     where mtrh.HEADER_ID = mtrl.HEADER_ID
		// 	                       and mtrh.ORGANIZATION_ID = msib_komp.ORGANIZATION_ID
		// 	                       and mtrl.INVENTORY_ITEM_ID = msib_komp.INVENTORY_ITEM_ID
		// 	                       --
		// 	                       and mtrl.LINE_STATUS in (3,7)
		// 	                       and mtrh.HEADER_STATUS in (3,7)
		// 	                       and mtrl.INVENTORY_ITEM_ID = wro.INVENTORY_ITEM_ID
		// 	                       and mtrh.ORGANIZATION_ID = wro.ORGANIZATION_ID
		// 	                       and substr(mtrh.REQUEST_NUMBER,1,2) = 'PL'
		// 	                       and mtrl.FROM_SUBINVENTORY_CODE = bic.ATTRIBUTE1
		// 	                       and mtrl.FROM_LOCATOR_ID is null
		// 	                  group by mtrl.INVENTORY_ITEM_ID
		// 	                    ),0) )
		// 	                    )
		// 	                            ) kurang
		// 	from wip_entities we
		// 	    ,wip_discrete_jobs wdj
		// 	    ,mtl_system_items_b msib
		// 	    ,wip_requirement_operations wro 
		// 	    ,mtl_system_items_b msib2
		// 	    ,bom_bill_of_materials bom
		// 	    ,bom_inventory_components bic
		// 	    ,MTL_ITEM_LOCATIONS mil
		// 	    ,MTL_ITEM_LOCATIONS mil2
		// 	    ,wip_operations wo
		// 	    ,bom_calendar_shifts bcs
		// 	    ,bom_departments bd
		// 	    ,BOM_OPERATIONAL_ROUTINGS bor
		// 	where we.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
		// 	  and we.ORGANIZATION_ID = wdj.ORGANIZATION_ID
		// 	  and we.PRIMARY_ITEM_ID = msib.INVENTORY_ITEM_ID
		// 	  and we.ORGANIZATION_ID = msib.ORGANIZATION_ID
		// 	  and wdj.WIP_ENTITY_ID = wro.WIP_ENTITY_ID
		// 	  and wro.INVENTORY_ITEM_ID = msib2.INVENTORY_ITEM_ID
		// 	  and wro.ORGANIZATION_ID = msib2.ORGANIZATION_ID
		// 	  and bom.BILL_SEQUENCE_ID = bic.BILL_SEQUENCE_ID
		// 	  and bom.ASSEMBLY_ITEM_ID = msib.INVENTORY_ITEM_ID
		// 	  and bom.ORGANIZATION_ID = msib.ORGANIZATION_ID
		// 	  and bic.COMPONENT_ITEM_ID = msib2.INVENTORY_ITEM_ID
		// 	  and wdj.COMMON_BOM_SEQUENCE_ID = bom.COMMON_BILL_SEQUENCE_ID
		// 	  and bic.ATTRIBUTE2 = mil.INVENTORY_LOCATION_ID(+)
		// 	  and bic.SUPPLY_LOCATOR_ID = mil2.INVENTORY_LOCATION_ID(+)
		// 	  --routing
		// 	  and wdj.COMMON_ROUTING_SEQUENCE_ID = bor.ROUTING_SEQUENCE_ID
		// 	  --
		// 	  and wo.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
		// 	  and wo.ORGANIZATION_ID = we.ORGANIZATION_ID
		// 	  and wo.DEPARTMENT_ID = bd.DEPARTMENT_ID
		// 	  and khs_shift(wdj.SCHEDULED_START_DATE) = bcs.SHIFT_NUM
		// 	  -- INT THE TRUTH IT WILL USED --
		// 	  and bic.WIP_SUPPLY_TYPE in (2,3)
		// 	  and bic.ATTRIBUTE1 is not null
		// 	  -- INT THE TRUTH ABOVE IT WILL USED --
		// 	  and we.WIP_ENTITY_NAME = '$job_no' --'D191100425'-- 'D191103750'
		// 	  and bd.DEPARTMENT_CLASS_CODE = '$dept'
		// 	order by bic.ATTRIBUTE1, bic.ATTRIBUTE2";

		$sql = "SELECT we.WIP_ENTITY_ID                          job_id
			      ,we.WIP_ENTITY_NAME 
			      ,msib2.SEGMENT1                                             komponen
			      ,msib2.DESCRIPTION                                         komp_desc
			      ,msib2.INVENTORY_ITEM_ID
			      ,wro.REQUIRED_QUANTITY
			      ,msib2.PRIMARY_UOM_CODE
			      ,bic.ATTRIBUTE1                                              gudang_asal
			      ,mil.INVENTORY_LOCATION_ID locator_asal_id
			      ,mil.SEGMENT1                                                 locator_asal
			      ,bic.SUPPLY_SUBINVENTORY                             gudang_tujuan
			      ,bic.SUPPLY_LOCATOR_ID                                 locator_tujuan_id 
			      ,mil2.SEGMENT1                                               locator_tujuan
			      ,khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') atr
			      ,(select sum(moqd.PRIMARY_TRANSACTION_QUANTITY)
			                   from mtl_onhand_quantities_detail moqd
			                  where moqd.ORGANIZATION_ID = wdj.ORGANIZATION_ID
			                    and moqd.INVENTORY_ITEM_ID = wro.INVENTORY_ITEM_ID
			                    and moqd.SUBINVENTORY_CODE = bic.ATTRIBUTE1
			                    and nvl(moqd.LOCATOR_ID,0) = nvl(bic.ATTRIBUTE2,0))         onhand_cob
			      ,bd.DEPARTMENT_CLASS_CODE                         dept_class
			      ,bcs.DESCRIPTION
			      ,wdj.SCHEDULED_START_DATE 
			      --
			      ,(nvl(
			           (select sum(mtrl.QUANTITY)
			              from mtl_txn_request_headers mtrh
			                  ,mtl_txn_request_lines mtrl
			                  ,mtl_system_items_b msib_komp
			             where mtrh.HEADER_ID = mtrl.HEADER_ID
			               and mtrh.ORGANIZATION_ID = msib_komp.ORGANIZATION_ID
			               and mtrl.INVENTORY_ITEM_ID = msib_komp.INVENTORY_ITEM_ID
			               --
			               and mtrl.LINE_STATUS in (3,7)
			               and mtrh.HEADER_STATUS in (3,7)
			               and mtrl.INVENTORY_ITEM_ID = wro.INVENTORY_ITEM_ID
			               and mtrh.ORGANIZATION_ID = wro.ORGANIZATION_ID
			               and substr(mtrh.REQUEST_NUMBER,1,2) = 'PL'
			               and mtrl.FROM_SUBINVENTORY_CODE = bic.ATTRIBUTE1
			               and nvl(mtrl.FROM_LOCATOR_ID,0) = nvl(bic.ATTRIBUTE2,0)
			          group by mtrl.INVENTORY_ITEM_ID
			            ),0)
			            )                                                               mo
			      ,(
			        (select sum(moqd.PRIMARY_TRANSACTION_QUANTITY)
			           from mtl_onhand_quantities_detail moqd
			          where moqd.ORGANIZATION_ID = wdj.ORGANIZATION_ID
			            and moqd.INVENTORY_ITEM_ID = wro.INVENTORY_ITEM_ID
			            and moqd.SUBINVENTORY_CODE = bic.ATTRIBUTE1
			            and nvl(moqd.LOCATOR_ID,0) = nvl(bic.ATTRIBUTE2,0)
			          )-
			        (nvl(
			           (select sum(mtrl.QUANTITY)
			              from mtl_txn_request_headers mtrh
			                  ,mtl_txn_request_lines mtrl
			                  ,mtl_system_items_b msib_komp
			             where mtrh.HEADER_ID = mtrl.HEADER_ID
			               and mtrh.ORGANIZATION_ID = msib_komp.ORGANIZATION_ID
			               and mtrl.INVENTORY_ITEM_ID = msib_komp.INVENTORY_ITEM_ID
			               --
			               and mtrl.LINE_STATUS in (3,7)
			               and mtrh.HEADER_STATUS in (3,7)
			               and mtrl.INVENTORY_ITEM_ID = wro.INVENTORY_ITEM_ID
			               and mtrh.ORGANIZATION_ID = wro.ORGANIZATION_ID
			               and substr(mtrh.REQUEST_NUMBER,1,2) = 'PL'
			               and mtrl.FROM_SUBINVENTORY_CODE = bic.ATTRIBUTE1
			               and nvl(mtrl.FROM_LOCATOR_ID,0) = nvl(bic.ATTRIBUTE2,0)
			          group by mtrl.INVENTORY_ITEM_ID
			            ),0)
			            )
			        )                                                                   kurang
			from wip_entities we
			    ,wip_discrete_jobs wdj
			    ,mtl_system_items_b msib
			    ,wip_requirement_operations wro 
			    ,mtl_system_items_b msib2
			    ,bom_bill_of_materials bom
			    ,bom_inventory_components bic
			    ,MTL_ITEM_LOCATIONS mil
			    ,MTL_ITEM_LOCATIONS mil2
			    ,wip_operations wo
			    ,bom_calendar_shifts bcs
			    ,bom_departments bd
			    ,BOM_OPERATIONAL_ROUTINGS bor
			where we.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
			  and we.ORGANIZATION_ID = wdj.ORGANIZATION_ID
			  and we.PRIMARY_ITEM_ID = msib.INVENTORY_ITEM_ID
			  and we.ORGANIZATION_ID = msib.ORGANIZATION_ID
			  and wdj.WIP_ENTITY_ID = wro.WIP_ENTITY_ID
			  and wro.INVENTORY_ITEM_ID = msib2.INVENTORY_ITEM_ID
			  and wro.ORGANIZATION_ID = msib2.ORGANIZATION_ID
			  and bom.BILL_SEQUENCE_ID = bic.BILL_SEQUENCE_ID
			  and bom.ASSEMBLY_ITEM_ID = msib.INVENTORY_ITEM_ID
			  and bom.ORGANIZATION_ID = msib.ORGANIZATION_ID
			  and bic.COMPONENT_ITEM_ID = msib2.INVENTORY_ITEM_ID
			  and wdj.COMMON_BOM_SEQUENCE_ID = bom.COMMON_BILL_SEQUENCE_ID
			  and bic.ATTRIBUTE2 = mil.INVENTORY_LOCATION_ID(+)
			  and bic.SUPPLY_LOCATOR_ID = mil2.INVENTORY_LOCATION_ID(+)
			  --routing
			  and wdj.COMMON_ROUTING_SEQUENCE_ID = bor.ROUTING_SEQUENCE_ID
			  --
			  and wo.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
			  and wo.ORGANIZATION_ID = we.ORGANIZATION_ID
			  and wo.DEPARTMENT_ID = bd.DEPARTMENT_ID
			  and khs_shift(wdj.SCHEDULED_START_DATE) = bcs.SHIFT_NUM
			  -- INT THE TRUTH IT WILL USED --
			  and bic.ATTRIBUTE1 is not null
			  -- INT THE TRUTH ABOVE IT WILL USED --
			  and we.WIP_ENTITY_NAME = '$job_no'--'D191103750'
			 and bd.DEPARTMENT_CLASS_CODE = '$dept'  
			order by bic.ATTRIBUTE1, bic.ATTRIBUTE2";
		$query = $oracle->query($sql);
		return $query->result_array();
	}


	function getShift($date=FALSE)
	{
		$oracle = $this->load->database('oracle',TRUE);
		if ($date === FALSE) {
			$date = date('Y/m/d');
		}
		$sql = "select BCS.SHIFT_NUM,BCS.DESCRIPTION
				from BOM_SHIFT_TIMES bst
				    ,BOM_CALENDAR_SHIFTS bcs
				    ,bom_shift_dates bsd
				where bst.CALENDAR_CODE = bcs.CALENDAR_CODE
				  and bst.SHIFT_NUM = bcs.SHIFT_NUM
				  and bcs.CALENDAR_CODE='KHS_CAL'
				  and bst.shift_num = bsd.shift_num
				  and bst.calendar_code=bsd.calendar_code
				  and bsd.SEQ_NUM is not null
				  and bsd.shift_date=trunc(to_date('$date','YYYY/MM/DD'))
				  ORDER BY BCS.SHIFT_NUM asc";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getDept()
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = " SELECT distinct dept, description 
				  FROM KHS_DEPT_ROUT_CLASS_V
				  ORDER BY dept asc";
		$query = $oracle->query($sql);
		return $query->result_array();
	}


	function checkPicklist($no)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT mtrh.REQUEST_NUMBER from mtl_txn_request_headers mtrh, wip_entities we
				    where mtrh.ATTRIBUTE1 = we.WIP_ENTITY_ID
				    and mtrh.ORGANIZATION_ID = we.ORGANIZATION_ID
				and we.WIP_ENTITY_NAME = '$no'";
		
		// echo "<pre>";
		// echo $sql;
		// exit();

		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getHeader($moveOrderAwal=FALSE, $moveOrderAkhir=FALSE)
	{
		$oracle = $this->load->database('oracle',TRUE);
		if ($moveOrderAwal==FALSE) {
			$moveOrder = '';
		}else{
			$moveOrder = "AND mtrh.request_number BETWEEN NVL('$moveOrderAwal', mtrh.request_number ) AND NVL('$moveOrderAkhir', mtrh.request_number )";
		}
		$sql = "
				SELECT msib_produk.segment1 PRODUK, 
                 msib_produk.description PRODUK_DESC, 
                 msib_produk.inventory_item_id, 
                 msib_produk.organization_id, 
                 KHS_INV_UTILITIES_PKG.GET_KLMPK_PRODUCT(msib_produk.inventory_item_id) kategori_produk, 
                 TO_CHAR( SYSDATE, 'DD/MM/YYYY HH24:MI:SS' ) Print_date, 
                 TO_CHAR(wdj.SCHEDULED_START_DATE, 'DD/MM/YYYY HH24:MI:SS' ) Date_Required, 
                 bd.DEPARTMENT_CLASS_CODE department, 
                 we.WIP_ENTITY_NAME job_no, 
                 wdj.start_quantity, 
                 mtrh.FROM_SUBINVENTORY_CODE lokasi, 
                 bcs.DESCRIPTION || '(' || TO_CHAR( TO_DATE( bst.FROM_TIME, 'SSSSS' ), 'HH24:MI:SS' )|| ' s/d ' || TO_CHAR( TO_DATE( bst.to_TIME, 'SSSSS' ), 'HH24:MI:SS' )|| ')' SCHEDULE, 
                 mtrh.request_number move_order_no
                 FROM mtl_txn_request_headers mtrh, --mtl_txn_request_lines mtrl, --MTL_MATERIAL_TRANSACTIONS_TEMP mmtt, --blm transact 
                 mtl_system_items_b msib_compnt, --JOB
                 wip_entities we, wip_discrete_jobs wdj, 
                 wip_requirement_operations wro, 
                 wip_operations wo, 
                 BOM_DEPARTMENTS bd, -- produk 
                 mtl_system_items_b msib_produk, --shift 
                 BOM_SHIFT_TIMES bst, 
                 BOM_CALENDAR_SHIFTS bcs 
                 WHERE 
--                 mtrh.header_id = mtrl.header_id
--                 AND mtrl.line_id = mmtt.MOVE_ORDER_LINE_ID 
--                 AND mmtt.INVENTORY_ITEM_ID = msib_compnt.INVENTORY_ITEM_ID 
--                 AND mmtt.ORGANIZATION_ID = msib_compnt.organization_id -- job 
                 mtrh.ATTRIBUTE1 = we.WIP_ENTITY_ID 
                 AND we.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID 
                 AND wdj.primary_item_id = msib_produk.INVENTORY_ITEM_ID 
                 AND wdj.ORGANIZATION_ID = msib_produk.ORGANIZATION_ID -- wro 
                 AND msib_compnt.inventory_item_id = wro.INVENTORY_ITEM_ID 
                 AND msib_compnt.organization_id = wro.organization_id 
                 AND wro.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID 
                 AND wro.organization_id = wdj.organization_id 
                 AND wro.wip_entity_id = wo.WIP_ENTITY_ID 
                 AND wro.OPERATION_SEQ_NUM = wo.OPERATION_SEQ_NUM 
                 AND wo.DEPARTMENT_ID = bd.DEPARTMENT_ID -- shift 
                 AND bst.CALENDAR_CODE = 'KHS_CAL' 
                 AND bst.SHIFT_NUM = khs_shift(wdj.scheduled_start_date) 
                 AND bst.calendar_code = bcs.calendar_code 
                 AND bcs.shift_num = bst.shift_num --hard_code 
                 AND mtrh.request_number = '$moveOrderAwal'
--                 AND mmtt.SUBINVENTORY_CODE NOT LIKE 'INT%' 
                 GROUP BY msib_produk.segment1, 
                     msib_produk.description, 
                     msib_produk.inventory_item_id, 
                     msib_produk.organization_id, 
                     mtrh.DATE_REQUIRED , 
                     bd.DEPARTMENT_CLASS_CODE, 
                     we.WIP_ENTITY_NAME, 
                     wdj.start_quantity, 
                     mtrh.FROM_SUBINVENTORY_CODE , 
                     bcs.DESCRIPTION,bst.FROM_TIME,bst.to_TIME, 
                     mtrh.request_number ,wdj.DATE_RELEASED,wdj.SCHEDULED_START_DATE 
                 ORDER BY we.WIP_ENTITY_NAME --mmtt.SUBINVENTORY_CODE
		";

		// echo "<pre>";
		// echo "header";
		// echo $sql;
		// exit();

		$query = $oracle->query($sql);
		return $query->result_array();
	}


	function getJobID($job)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT we.WIP_ENTITY_ID from wip_entities we	
				where we.WIP_ENTITY_NAME = '$job'";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getAlamat($no_mo)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = 	"SELECT poh.SEGMENT1, pvs.ADDRESS_LINE1, pvs.VENDOR_SITE_CODE , hp.PARTY_NAME, hp.CITY 
				FROM wip_entities we, po_requisition_lines_all prl, po_req_distributions_all pord, po_distributions_all pod, po_headers_all poh, ap_suppliers pav,
					ap_supplier_sites_all pvs, hz_parties hp 
		        where we.WIP_ENTITY_ID = (SELECT we.WIP_ENTITY_ID from wip_entities we    
		        where we.WIP_ENTITY_NAME = '$no_mo')
		        and prl.WIP_ENTITY_ID = we.WIP_ENTITY_ID
		        and prl.REQUISITION_LINE_ID(+) = pord.REQUISITION_LINE_ID
		        and pord.DISTRIBUTION_ID(+) = pod.REQ_DISTRIBUTION_ID
		        and pod.PO_HEADER_ID(+) = poh.PO_HEADER_ID
		        and poh.VENDOR_ID = pav.VENDOR_ID
		        and pav.VENDOR_ID = pvs.VENDOR_ID
		        and pav.PARTY_ID = hp.PARTY_ID";

		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getNomorHeader($no_mo)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT DISTINCT mtrh.HEADER_ID from mtl_txn_request_headers mtrh, wip_entities we, mtl_txn_request_lines mtrl
                    where mtrh.ATTRIBUTE1 = we.WIP_ENTITY_ID
                    and mtrh.ORGANIZATION_ID = we.ORGANIZATION_ID
                    and mtrl.HEADER_ID = mtrh.HEADER_ID
                and we.WIP_ENTITY_NAME = '$no_mo'";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function updateAttr10($id_job, $no_mo)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "UPDATE mtl_txn_request_headers mtrh
				set mtrh.ATTRIBUTE1 = '$id_job'
				where mtrh.REQUEST_NUMBER = '$no_mo'

				;

				commit

				;";
		$query = $oracle->query($sql);
	}

	function deleteTemp($ip, $job_id)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "DELETE from CREATE_MO_KIB_TEMP where IP_ADDRESS = '$ip' and JOB_ID = $job_id ";
		$oracle->trans_start();
		$oracle->query($sql);
		$oracle->trans_complete();
	}

	function createTemp($data)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$oracle->trans_start();
		$oracle->insert('CREATE_MO_KIB_TEMP',$data);
		$oracle->trans_complete();
	}


	function createMO($ip_address,$job_id,$subInv,$locator,$subInvFrom,$locatorFrom,$user_id)
	{
		// if ($locator) {
		// 	$locator = null;
		// }else{
		// 	$locator = (int) $locator;
			
		// }

		// if ($locatorFrom != null) {
		// 	$locatorFrom1 = $this->getLocatorId($locatorFrom);
		// }else{
		// 	$locatorFrom = (int) $locatorFrom;
		// }

		$username = 'AA TECH TSR 01';
		$jan = 137;
		$job_id = (int) $job_id;

		$status = null;
		// echo "<pre>";
		// echo ':P_PARAM1 = '.$subInvFrom.'<br>'; 
		// echo ':P_PARAM2 = '.$locatorFrom.'<br>';
		// echo ':P_PARAM3 = '.$subInv.'<br>';
		// echo ':P_PARAM4 = '.$locator.'<br>';
		// echo ':P_PARAM5 = '.$username.'<br>';
		// echo ':P_PARAM6 = '.$ip_address.'<br>';
		// echo ':P_PARAM7 = '.$jan.'<br>';
		// echo ':P_PARAM8 = '.$job_id.'<br>';
		// exit();
		// $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
		$conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
			if (!$conn) {
	   			 $e = oci_error();
	    		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			}
		  
		$sql =  "BEGIN APPS.KHS_CREATE_MO_PL(:P_PARAM1,:P_PARAM2,:P_PARAM3,:P_PARAM4,:P_PARAM5,:P_PARAM6,:P_PARAM7,:P_PARAM8); END;";

		// $param4 = '';


		//Statement does not change
		$stmt = oci_parse($conn,$sql);                     
		oci_bind_by_name($stmt,':P_PARAM1',$subInvFrom);           
		oci_bind_by_name($stmt,':P_PARAM2',$locatorFrom); 
		oci_bind_by_name($stmt,':P_PARAM3',$subInv);
		oci_bind_by_name($stmt,':P_PARAM4',$locator);
		oci_bind_by_name($stmt,':P_PARAM5',$username);
		oci_bind_by_name($stmt,':P_PARAM6',$ip_address);
		oci_bind_by_name($stmt,':P_PARAM7',$jan);
		oci_bind_by_name($stmt,':P_PARAM8',$job_id);
		// oci_bind_by_name($stmt,':P_PARAM9',$user_id);

		
		// if (!$data) {
  //   			$e = oci_error($conn);  // For oci_parse errors pass the connection handle
  //   			trigger_error(htmlentities($e['message']), E_USER_ERROR);
		// }
		
		// But BEFORE statement, Create your cursor
		$cursor = oci_new_cursor($conn);
		
		// Execute the statement as in your first try
		 oci_execute($stmt);
		
		// and now, execute the cursor
		oci_execute($cursor);
	}

	function getQuantityActual($job,$atr)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT wro.REQUIRED_QUANTITY req $atr
					 FROM wip_entities we
					,wip_discrete_jobs wdj
					,mtl_system_items_b msib
					,wip_requirement_operations wro
					,mtl_system_items_b msib2
					,bom_bill_of_materials bom
					,bom_inventory_components bic
					,MTL_ITEM_LOCATIONS mil
					,MTL_ITEM_LOCATIONS mil2
					,wip_operations wo
					,bom_calendar_shifts bcs
					,bom_departments bd
					,BOM_OPERATIONAL_ROUTINGS bor
					where we.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
					and we.ORGANIZATION_ID = wdj.ORGANIZATION_ID
					and we.PRIMARY_ITEM_ID = msib.INVENTORY_ITEM_ID
					and we.ORGANIZATION_ID = msib.ORGANIZATION_ID
					and wdj.WIP_ENTITY_ID = wro.WIP_ENTITY_ID
					and wro.INVENTORY_ITEM_ID = msib2.inventory_item_id
					and wro.ORGANIZATION_ID = msib2.ORGANIZATION_ID
					and bom.bill_sequence_id = bic.bill_sequence_id
					and bom.ASSEMBLY_ITEM_ID = msib.inventory_item_id
					and bom.organization_id = msib.organization_id
					and bic.COMPONENT_ITEM_ID = msib2.inventory_item_id
					and wdj.COMMON_BOM_SEQUENCE_ID = bom.COMMON_BILL_SEQUENCE_ID
					and bic.ATTRIBUTE2 = mil.INVENTORY_LOCATION_ID(+)
					and bic.SUPPLY_LOCATOR_ID = mil2.INVENTORY_LOCATION_ID(+)
					--routing
					and wdj.COMMON_ROUTING_SEQUENCE_ID = bor.ROUTING_SEQUENCE_ID
					--
					and wo.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
					and wo.ORGANIZATION_ID = we.ORGANIZATION_ID
					and wo.DEPARTMENT_ID = bd.DEPARTMENT_ID
					and khs_shift(wdj.SCHEDULED_START_DATE) = bcs.SHIFT_NUM
					-- INT THE TRUTH IT WILL USED --
					and bic.ATTRIBUTE1 is not null
					-- INT THE TRUTH ABOVE IT WILL USED --
					and we.WIP_ENTITY_NAME = '$job'
					group by we.WIP_ENTITY_ID,  we.WIP_ENTITY_NAME ,msib2.SEGMENT1, msib2.DESCRIPTION, msib2.inventory_item_id
                    ,wro.REQUIRED_QUANTITY,msib2.PRIMARY_UOM_CODE, bic.ATTRIBUTE1, mil.SEGMENT1
                    ,bic.SUPPLY_SUBINVENTORY,bic.SUPPLY_LOCATOR_ID ,mil2.SEGMENT1
                    ,wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2
                    ,bd.DEPARTMENT_CLASS_CODE, bcs.DESCRIPTION, wdj.SCHEDULED_START_DATE,we.ORGANIZATION_ID
                    order by bic.ATTRIBUTE1, bic.ATTRIBUTE2";
		$query = $oracle->query($sql);
		return $query->result_array();
	}


	function checkDepartement($param)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql ="SELECT bd.DEPARTMENT_CLASS_CODE department
                 FROM mtl_txn_request_headers mtrh, --mtl_txn_request_lines mtrl, --MTL_MATERIAL_TRANSACTIONS_TEMP mmtt, --blm transact 
                 mtl_system_items_b msib_compnt, --JOB
                 wip_entities we, wip_discrete_jobs wdj, 
                 wip_requirement_operations wro, 
                 wip_operations wo, 
                 BOM_DEPARTMENTS bd, -- produk 
                 mtl_system_items_b msib_produk, --shift 
                 BOM_SHIFT_TIMES bst, 
                 BOM_CALENDAR_SHIFTS bcs 
                 WHERE 
--                 mtrh.header_id = mtrl.header_id
--                 AND mtrl.line_id = mmtt.MOVE_ORDER_LINE_ID 
--                 AND mmtt.INVENTORY_ITEM_ID = msib_compnt.INVENTORY_ITEM_ID 
--                 AND mmtt.ORGANIZATION_ID = msib_compnt.organization_id -- job 
                 mtrh.ATTRIBUTE1 = we.WIP_ENTITY_ID 
                 AND we.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID 
                 AND wdj.primary_item_id = msib_produk.INVENTORY_ITEM_ID 
                 AND wdj.ORGANIZATION_ID = msib_produk.ORGANIZATION_ID -- wro 
                 AND msib_compnt.inventory_item_id = wro.INVENTORY_ITEM_ID 
                 AND msib_compnt.organization_id = wro.organization_id 
                 AND wro.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID 
                 AND wro.organization_id = wdj.organization_id 
                 AND wro.wip_entity_id = wo.WIP_ENTITY_ID 
                 AND wro.OPERATION_SEQ_NUM = wo.OPERATION_SEQ_NUM 
                 AND wo.DEPARTMENT_ID = bd.DEPARTMENT_ID -- shift 
                 AND bst.CALENDAR_CODE = 'KHS_CAL' 
                 AND bst.SHIFT_NUM = khs_shift(wdj.scheduled_start_date) 
                 AND bst.calendar_code = bcs.calendar_code 
                 AND bcs.shift_num = bst.shift_num --hard_code 
                 AND mtrh.request_number = '$param'
--                 AND mmtt.SUBINVENTORY_CODE NOT LIKE 'INT%' 
                 GROUP BY msib_produk.segment1, 
                     msib_produk.description, 
                     msib_produk.inventory_item_id, 
                     msib_produk.organization_id, 
                     mtrh.DATE_REQUIRED , 
                     bd.DEPARTMENT_CLASS_CODE, 
                     we.WIP_ENTITY_NAME, 
                     wdj.start_quantity, 
                     mtrh.FROM_SUBINVENTORY_CODE , 
                     bcs.DESCRIPTION,bst.FROM_TIME,bst.to_TIME, 
                     mtrh.request_number ,wdj.DATE_RELEASED,wdj.SCHEDULED_START_DATE 
                 ORDER BY we.WIP_ENTITY_NAME";
		$query = $oracle->query($sql);
		return $query->result_array();
		// return $sql;
	}

}