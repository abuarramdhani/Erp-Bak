<?php defined('BASEPATH') OR die('No direct script access allowed');
class M_moveorderopm extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function search($date,$dept,$shift,$atr, $ket)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "select *
				from khs_qweb_ect_listjob kqel
				where trunc (kqel.TANGGAL) = '$date'
				and kqel.DEPARTMENT_CLASS_CODE = '$dept'
				$shift
				and kqel.KET = '$ket'
				order by 1";
		// echo "<pre>";
		// print_r($sql);
		// exit();			
		$query = $oracle->query($sql);
		return $query->result_array();
		// return $sql;
	}

	function search2($job_no) //----------------->>
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "select *
				from khs_qweb_ect_listall kqel
				where kqel.NO_JOB in ($job_no)
				order by 1 ";
		
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	
	function count_itemMGA($job_no) //----------------->>
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "select nvl (khs_hitung_stiker ('$job_no'),0) stiker
				from dual";
		
		$query = $oracle->query($sql);
		return $query->result_array();
	}


	function getBody($job_no,$atr,$dept) //----------------->>
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT DISTINCT 
		we.wip_entity_id job_id
	   ,we.wip_entity_name
	   ,msib2.segment1 komponen
	   ,msib2.description komp_desc
	   ,msib2.inventory_item_id
	   ,wro.required_quantity
	   ,wro.quantity_per_assembly
	   ,msib2.primary_uom_code
	   ,wdj.ORGANIZATION_ID
	   ,wro.attribute1 gudang_asal
	   ,mil.inventory_location_id locator_asal_id
	   ,mil.segment1 locator_asal
	   ,wro.supply_subinventory gudang_tujuan
	   ,wro.supply_locator_id locator_tujuan_id
	   ,mil2.segment1 locator_tujuan
	   ,khs_inv_qty_oh (wdj.organization_id, wro.inventory_item_id, wro.attribute1, wro.attribute2, '')
				 - (NVL ((SELECT SUM (mtrl.quantity) - SUM (NVL (mtrl.quantity_delivered, 0)) quantity
							 FROM mtl_txn_request_headers mtrh,
								 mtl_txn_request_lines mtrl
							 WHERE mtrh.header_id = mtrl.header_id
							 AND mtrl.line_status IN (3, 7)
							 AND mtrh.header_status IN (3, 7)
							 AND mtrl.inventory_item_id = wro.inventory_item_id
							 AND mtrh.organization_id = wro.organization_id
							 AND mtrl.from_subinventory_code = wro.attribute1
							 AND NVL (mtrl.from_locator_id, 0) = NVL (wro.attribute2, 0)
						 GROUP BY mtrl.inventory_item_id), 0)) atr
	   ,(SELECT SUM (moqd.primary_transaction_quantity)
				 FROM mtl_onhand_quantities_detail moqd
				 WHERE moqd.organization_id = wdj.organization_id
					 AND moqd.inventory_item_id = wro.inventory_item_id
					 AND moqd.subinventory_code = wro.attribute1
					 AND NVL (moqd.locator_id, 0) = NVL (wro.attribute2, 0)) onhand_cob
	   ,bd.department_class_code dept_class
	   ,bcs.description
	   ,wdj.scheduled_start_date
	   ,(NVL ((SELECT   SUM (mtrl.quantity)
						 FROM mtl_txn_request_headers mtrh,
								 mtl_txn_request_lines mtrl,
								 mtl_system_items_b msib_komp
						 WHERE mtrh.header_id = mtrl.header_id
							 AND mtrh.organization_id = msib_komp.organization_id
							 AND mtrl.inventory_item_id =msib_komp.inventory_item_id
							 AND mtrl.line_status IN (3, 7)
							 AND mtrh.header_status IN (3, 7)
							 AND mtrl.inventory_item_id = wro.inventory_item_id
							 AND mtrh.organization_id = wro.organization_id
							 AND mtrl.from_subinventory_code = wro.attribute1
							 AND NVL (mtrl.from_locator_id, 0) = NVL (wro.attribute2, 0)
					 GROUP BY mtrl.inventory_item_id), 0)) mo,
				 (  (SELECT SUM (moqd.primary_transaction_quantity)
					 FROM mtl_onhand_quantities_detail moqd
					 WHERE moqd.organization_id = wdj.organization_id
					 AND moqd.inventory_item_id = wro.inventory_item_id
					 AND moqd.subinventory_code = wro.attribute1
					 AND NVL (moqd.locator_id, 0) = NVL (wro.attribute2, 0))
				 - (NVL ((SELECT     SUM (mtrl.quantity)
								 - SUM (NVL (mtrl.quantity_delivered, 0))
																	 quantity
							 FROM mtl_txn_request_headers mtrh,
								 mtl_txn_request_lines mtrl,
								 mtl_system_items_b msib_komp
							 WHERE mtrh.header_id = mtrl.header_id
							 AND mtrh.organization_id =
													 msib_komp.organization_id
							 AND mtrl.inventory_item_id =
												 msib_komp.inventory_item_id
							 --
							 AND mtrl.line_status IN (3, 7)
							 AND mtrh.header_status IN (3, 7)
							 AND mtrl.inventory_item_id =
														 wro.inventory_item_id
							 AND mtrh.organization_id = wro.organization_id
							 AND mtrl.from_subinventory_code =
																 wro.attribute1
							 AND NVL (mtrl.from_locator_id, 0) =
													 NVL (wro.attribute2, 0)
						 GROUP BY mtrl.inventory_item_id),
						 0
						 )
				 )
				 ) kurang
		 FROM wip_entities we,
				 wip_discrete_jobs wdj,
				 mtl_system_items_b msib,
				 wip_requirement_operations wro,
				 mtl_system_items_b msib2,
				 mtl_item_locations mil,
				 mtl_item_locations mil2,
				 wip_operations wo,
				 bom_calendar_shifts bcs,
				 bom_departments bd,
				 bom_operational_routings bor
		 WHERE we.wip_entity_id = wdj.wip_entity_id
			 AND we.organization_id = wdj.organization_id
			 AND we.primary_item_id = msib.inventory_item_id
			 AND we.organization_id = msib.organization_id
			 AND wdj.wip_entity_id = wro.wip_entity_id
			 AND wro.inventory_item_id = msib2.inventory_item_id
			 AND wro.organization_id = msib2.organization_id
			 AND wro.attribute2 = mil.inventory_location_id(+)
			 AND wro.supply_locator_id = mil2.inventory_location_id(+)
			 --routing
			 AND wdj.common_routing_sequence_id = bor.routing_sequence_id
			 --
			 AND wo.wip_entity_id = wdj.wip_entity_id
			 AND wo.organization_id = we.organization_id
			 AND wo.department_id = bd.department_id
			 AND khs_shift (wdj.scheduled_start_date) = bcs.shift_num
			 -- INT THE TRUTH IT WILL USED --
			 AND wro.attribute1 IS NOT NULL
			 -- INT THE TRUTH ABOVE IT WILL USED --
			 AND we.wip_entity_name = '$job_no'               --'D191103750'
			 AND bd.department_class_code = '$dept'
			 --
			 AND msib2.inventory_item_id NOT IN (
				 SELECT DISTINCT msib.inventory_item_id
							 FROM mtl_system_items_b msib,
								 gmd_recipe_validity_rules grvr,
								 gmd_recipes_b grb,
								 gmd_routings_b grtb
							 WHERE msib.inventory_item_id =
														 grvr.inventory_item_id
							 AND msib.organization_id = grvr.organization_id
							 AND grvr.recipe_id = grb.recipe_id
							 AND grvr.validity_rule_status = 700
							 AND grvr.end_date IS NULL
							 AND grb.recipe_status = 700
							 AND grb.routing_id = grtb.routing_id
							 AND grtb.routing_class = 'SHMT')
 union
 --opm
 SELECT DISTINCT 
		we.wip_entity_id
	   ,we.wip_entity_name
	   ,msib2.segment1 komponen
	   ,msib2.description komp_desc
	   ,msib2.inventory_item_id
	   ,wro.required_quantity
	   ,wro.quantity_per_assembly
	   ,msib2.primary_uom_code
	   ,101 organization_id
	   ,'SM-TKS' gudang_asal
	   ,NULL locator_asal_id
	   ,NULL locator_asal
	   ,wro.supply_subinventory gudang_tujuan
	   ,wro.supply_locator_id locator_tujuan_id
	   ,mil2.segment1 locator_tujuan
	   ,khs_inv_qty_att ('101',msib2.inventory_item_id,'SM-TKS','','')
				 - NVL ((SELECT SUM (kkk.qty_kib)
						 FROM khs_kib_kanban kkk
						 WHERE kkk.inventory_trans_flag = 'N'
						 AND kkk.primary_item_id = msib2.inventory_item_id),
					 0
					 ) atr
	   ,(SELECT SUM (moqd.primary_transaction_quantity)
				 FROM mtl_onhand_quantities_detail moqd
				 WHERE moqd.organization_id = wdj.organization_id
					 AND moqd.inventory_item_id = wro.inventory_item_id
					 AND moqd.subinventory_code = wro.attribute1
					 AND NVL (moqd.locator_id, 0) = NVL (wro.attribute2, 0))
																 onhand_cob
	   ,'SHMT' dept_class
	   ,bcs.description
 --      ,bd.department_class_code dept_class
 --      ,bcs.description
	   ,wdj.scheduled_start_date
	   ,
				 NVL ((SELECT SUM (kkk.qty_kib)
						 FROM khs_kib_kanban kkk
					 WHERE kkk.inventory_trans_flag = 'N'
						 AND kkk.primary_item_id = msib2.inventory_item_id),
					 0
					 ) mo
	   ,khs_inv_qty_att ('101',msib2.inventory_item_id,'SM-TKS','','') kurang
		 FROM wip_entities we,
				 wip_discrete_jobs wdj,
				 mtl_system_items_b msib,
				 wip_requirement_operations wro,
				 mtl_system_items_b msib2,
				 mtl_item_locations mil,
				 mtl_item_locations mil2,
				 wip_operations wo,
				 bom_calendar_shifts bcs,
				 bom_departments bd,
				 bom_operational_routings bor,
				 --
				 gmd_recipe_validity_rules grvr,
								 gmd_recipes_b grb,
								 gmd_routings_b grtb
		 WHERE we.wip_entity_id = wdj.wip_entity_id
			 AND we.organization_id = wdj.organization_id
			 AND we.primary_item_id = msib.inventory_item_id
			 AND we.organization_id = msib.organization_id
			 AND wdj.wip_entity_id = wro.wip_entity_id
			 AND wro.inventory_item_id = msib2.inventory_item_id
			 AND wro.organization_id = msib2.organization_id
			 AND wro.attribute2 = mil.inventory_location_id(+)
			 AND wro.supply_locator_id = mil2.inventory_location_id(+)
			 --routing
			 AND wdj.common_routing_sequence_id = bor.routing_sequence_id
			 --
			 AND wo.wip_entity_id = wdj.wip_entity_id
			 AND wo.organization_id = we.organization_id
			 AND wo.department_id = bd.department_id
			 AND khs_shift (wdj.scheduled_start_date) = bcs.shift_num
			 -- INT THE TRUTH IT WILL USED --
			 AND wro.attribute1 IS NOT NULL
			 -- INT THE TRUTH ABOVE IT WILL USED --
			 AND we.wip_entity_name = '$job_no'--P_NO_JOB --'D210900682'
			 AND bd.department_class_code = '$dept'--P_DEPT_CLASS --'$dept'
			 --
			 and msib2.INVENTORY_ITEM_ID = grvr.inventory_item_id
							 AND  grvr.organization_id = 101
							 AND grvr.recipe_id = grb.recipe_id
							 AND grvr.validity_rule_status = 700
							 AND grvr.end_date IS NULL
							 and grtb.ROUTING_VERS = 1
							 AND grb.recipe_status = 700
							 AND grb.routing_id = grtb.routing_id
							 AND grtb.routing_class = 'SHMT'
 --            AND msib2.inventory_item_id IN (
 --                SELECT DISTINCT msib.inventory_item_id
 --                            FROM mtl_system_items_b msib,
 --                                gmd_recipe_validity_rules grvr,
 --                                gmd_recipes_b grb,
 --                                gmd_routings_b grtb
 --                            WHERE msib.inventory_item_id = grvr.inventory_item_id
 --                            AND msib.organization_id = grvr.organization_id
 --                            AND grvr.recipe_id = grb.recipe_id
 --                            AND grvr.validity_rule_status = 700
 --                            AND grvr.end_date IS NULL
 --                            AND grb.recipe_status = 700
 --                            AND grb.routing_id = grtb.routing_id
 --                            AND grtb.routing_class = 'SHMT')
		 ORDER BY 11 ASC";
                // return $sql;
		$query = $oracle->query($sql);
		return $query->result_array();
	}


	function getShift($date=FALSE)
	{
		$oracle = $this->load->database('oracle',TRUE);
		if ($date === FALSE) {
			$date = date('Y/m/d');
		}
		$sql = "SELECT BCS.SHIFT_NUM,BCS.DESCRIPTION
				from BOM_SHIFT_TIMES bst
				    ,BOM_CALENDAR_SHIFTS bcs
				    ,bom_shift_dates bsd
				where bst.CALENDAR_CODE = bcs.CALENDAR_CODE
				  and bst.SHIFT_NUM = bcs.SHIFT_NUM
				  and bcs.CALENDAR_CODE='KHS_CAL'
				  and bst.shift_num = bsd.shift_num
				  and bst.calendar_code=bsd.calendar_code
				  --and bsd.SEQ_NUM is not null
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
		// $sql = "SELECT mtrh.REQUEST_NUMBER from mtl_txn_request_headers mtrh, wip_entities we
		// 		    where mtrh.ATTRIBUTE1 = we.WIP_ENTITY_ID
		// 		    and mtrh.ORGANIZATION_ID = we.ORGANIZATION_ID
		// 		and we.WIP_ENTITY_NAME = '$no'
		// 		order by 1";
		$sql = "SELECT distinct
						mtrh.REQUEST_NUMBER
					,mtrl.FROM_SUBINVENTORY_CODE
					,mil.SEGMENT1 locator 
				from mtl_txn_request_headers mtrh
					,wip_entities we
					,mtl_txn_request_lines mtrl
					,mtl_item_locations mil
				where mtrh.ATTRIBUTE1 = we.WIP_ENTITY_ID
				and mtrh.ORGANIZATION_ID = we.ORGANIZATION_ID
				and mtrl.HEADER_ID = mtrh.HEADER_ID
				and mtrl.FROM_LOCATOR_ID = mil.INVENTORY_LOCATION_ID (+)
				and we.WIP_ENTITY_NAME = '$no'
				union
				SELECT distinct
					kkk.KIBCODE request_number
					,kkk.FROM_SUBINVENTORY_CODE
					,mil.SEGMENT1 locator 
				from wip_entities we
					,khs_kib_kanban kkk
					,mtl_item_locations mil
				where kkk.ORDER_ID = we.WIP_ENTITY_ID
				and kkk.ORGANIZATION_ID = 101
				and kkk.FROM_LOCATOR_ID = mil.INVENTORY_LOCATION_ID (+)
				and we.WIP_ENTITY_NAME = '$no'
				order by 1";
		
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
--                 mtl_system_items_b msib_compnt, --JOB
		wip_entities we, wip_discrete_jobs wdj,
		wip_requirement_operations wro, 
		wip_operations wo, 
		BOM_DEPARTMENTS bd, -- produk 
		mtl_system_items_b msib_produk, --shift 
		BOM_SHIFT_TIMES bst, 
		BOM_CALENDAR_SHIFTS bcs 
		WHERE mtrh.ATTRIBUTE1 = we.WIP_ENTITY_ID 
		AND we.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID 
		AND wdj.primary_item_id = msib_produk.INVENTORY_ITEM_ID 
		AND wdj.ORGANIZATION_ID = msib_produk.ORGANIZATION_ID -- wro 
--                 AND msib_compnt.inventory_item_id = wro.INVENTORY_ITEM_ID 
--                 AND msib_compnt.organization_id = wro.organization_id 
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
UNION
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
		kkk.FROM_SUBINVENTORY_CODE lokasi, 
		bcs.DESCRIPTION || '(' || TO_CHAR( TO_DATE( bst.FROM_TIME, 'SSSSS' ), 'HH24:MI:SS' )|| ' s/d ' || TO_CHAR( TO_DATE( bst.to_TIME, 'SSSSS' ), 'HH24:MI:SS' )|| ')' SCHEDULE, 
		kkk.KIBCODE move_order_no
		FROM khs_kib_kanban kkk, --mtl_txn_request_lines mtrl, --MTL_MATERIAL_TRANSACTIONS_TEMP mmtt, --blm transact 
--                 mtl_system_items_b msib_compnt, --JOB
		wip_entities we, wip_discrete_jobs wdj,
		wip_requirement_operations wro, 
		wip_operations wo, 
		BOM_DEPARTMENTS bd, -- produk 
		mtl_system_items_b msib_produk, --shift 
		BOM_SHIFT_TIMES bst, 
		BOM_CALENDAR_SHIFTS bcs 
		WHERE kkk.ORDER_ID = we.WIP_ENTITY_ID 
		AND we.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID 
		AND wdj.primary_item_id = msib_produk.INVENTORY_ITEM_ID 
		AND wdj.ORGANIZATION_ID = msib_produk.ORGANIZATION_ID -- wro 
--                 AND msib_compnt.inventory_item_id = wro.INVENTORY_ITEM_ID 
--                 AND msib_compnt.organization_id = wro.organization_id 
		AND wro.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID 
		AND wro.organization_id = wdj.organization_id 
		AND wro.wip_entity_id = wo.WIP_ENTITY_ID 
		AND wro.OPERATION_SEQ_NUM = wo.OPERATION_SEQ_NUM 
		AND wo.DEPARTMENT_ID = bd.DEPARTMENT_ID -- shift 
		AND bst.CALENDAR_CODE = 'KHS_CAL' 
		AND bst.SHIFT_NUM = khs_shift(wdj.scheduled_start_date) 
		AND bst.calendar_code = bcs.calendar_code 
		AND bcs.shift_num = bst.shift_num --hard_code 
		AND kkk.KIBCODE = '$moveOrderAwal'
--                 AND mmtt.SUBINVENTORY_CODE NOT LIKE 'INT%' 
		GROUP BY msib_produk.segment1, 
			msib_produk.description, 
			msib_produk.inventory_item_id, 
			msib_produk.organization_id, 
			bd.DEPARTMENT_CLASS_CODE, 
			we.WIP_ENTITY_NAME, 
			wdj.start_quantity, 
			kkk.FROM_SUBINVENTORY_CODE , 
			bcs.DESCRIPTION,bst.FROM_TIME,bst.to_TIME, 
			kkk.KIBCODE ,wdj.DATE_RELEASED,wdj.SCHEDULED_START_DATE 
		ORDER BY job_no --mmtt.SUBINVENTORY_CODE
		";

		// echo "<pre>";
		// echo "header";
		// echo $sql;
		// exit();

		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getDetail($moveOrderAwal=FALSE, $moveOrderAkhir=FALSE)
	{
		$oracle = $this->load->database('oracle',TRUE);
		if ($moveOrderAwal==FALSE || $moveOrderAkhir==FALSE) {
			$moveOrder = '';
		}else{
			$moveOrder = "AND mtrh.request_number BETWEEN NVL('$moveOrderAwal', mtrh.request_number ) AND NVL('$moveOrderAkhir', mtrh.request_number )";
		}

		$sql = "SELECT
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
		wdj.start_quantity, -- ntar di sum
		--component
		msib_compnt.SEGMENT1 kode_komponen,
		msib_compnt.description kode_desc,
		msib_compnt.inventory_item_id item_id_komponen,
		msib_compnt.organization_id org_id_komponen,
		wro.QUANTITY_PER_ASSEMBLY Qty_UNIT,
		mtrl.QUANTITY qty_minta,
		mtrl.FROM_SUBINVENTORY_CODE lokasi,
		mil.SEGMENT1 lokator ,
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
		BOM_CALENDAR_SHIFTS bcs,
		mtl_item_locations mil
		where mtrh.header_id = mtrl.header_id
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
		and mtrh.request_number = '$moveOrderAwal'
		-- and mtrl.FROM_SUBINVENTORY_CODE not like 'INT%'
		and wro.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
		and mtrl.FROM_LOCATOR_ID = mil.INVENTORY_LOCATION_ID(+)
		UNION
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
		kkk.KIBCODE move_order_no,
		we.WIP_ENTITY_NAME job_no,
		wdj.start_quantity, -- ntar di sum
		--component
		msib_compnt.SEGMENT1 kode_komponen,
		msib_compnt.description kode_desc,
		msib_compnt.inventory_item_id item_id_komponen,
		msib_compnt.organization_id org_id_komponen,
		wro.QUANTITY_PER_ASSEMBLY Qty_UNIT,
		kkk.SCHEDULED_QUANTITY qty_minta,
		kkk.FROM_SUBINVENTORY_CODE lokasi,
		mil.SEGMENT1 lokator ,
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
		msib_compnt.PRIMARY_UOM_CODE uom,
		kkk.CREATION_DATE,
		(
		case
		when(
		select
		lokasi
		from
		khsinvlokasisimpan kls
		where
		subinv = kkk.FROM_SUBINVENTORY_CODE
		and inventory_item_id = kkk.PRIMARY_ITEM_ID
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
		subinv = kkk.FROM_SUBINVENTORY_CODE
		and inventory_item_id = kkk.PRIMARY_ITEM_ID
		and kls.KELOMPOK is not null
		and rownum = 1
		) is null then(
		select
		lokasi
		from
		khsinvlokasisimpan kls
		where
		subinv = kkk.FROM_SUBINVENTORY_CODE
		and inventory_item_id = kkk.PRIMARY_ITEM_ID
		and rownum = 1
		)
		else(
		select
		lokasi
		from
		khsinvlokasisimpan kls
		where
		subinv = kkk.FROM_SUBINVENTORY_CODE
		and inventory_item_id = kkk.PRIMARY_ITEM_ID
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
		subinv = kkk.FROM_SUBINVENTORY_CODE
		and inventory_item_id = kkk.PRIMARY_ITEM_ID
		and kls.KELOMPOK = KHS_INV_UTILITIES_PKG.GET_KLMPK_PRODUCT(msib_produk.inventory_item_id)
		and rownum = 1
		)
		end
		) loc,
		khs_inv_qty_atr(
		msib_compnt.organization_id,
		msib_compnt.inventory_item_id,
		kkk.FROM_SUBINVENTORY_CODE,
		'',
		''
		) ATR
		from
		khs_kib_kanban kkk,
		mtl_system_items_b msib_compnt, --JOB
		wip_entities we,
		wip_discrete_jobs wdj,
		wip_requirement_operations wro,
		wip_operations wo,
		BOM_DEPARTMENTS bd, -- produk
		mtl_system_items_b msib_produk, --shift
		BOM_SHIFT_TIMES bst,
		BOM_CALENDAR_SHIFTS bcs,
		mtl_item_locations mil
		where kkk.ORDER_ID = we.WIP_ENTITY_ID
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
		and kkk.KIBCODE = '$moveOrderAwal'
		and kkk.FROM_SUBINVENTORY_CODE = 'SM-TKS'
		-- and mtrl.FROM_SUBINVENTORY_CODE not like 'INT%'
		and wro.INVENTORY_ITEM_ID = kkk.PRIMARY_ITEM_ID
		and kkk.FROM_LOCATOR_ID = mil.INVENTORY_LOCATION_ID(+)
		order by 23 -- lokasi simpan";
		
		// echo "<pre>";
		// echo "$sql";
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
		$sql = "DELETE from CREATE_MO_KIB_TEMP where IP_ADDRESS = '$ip' and JOB_ID = '$job_id' ";
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


	function createMO($ip_address,$job_id,$subInv,$locator,$subInvFrom,$locatorFrom,$user_id,$nomor_mo)
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
		// echo ':P_PARAM9 = '.$nomor_mo.'<br>';
		// echo ':P_PARAM10 = '.$user_id.'<br>';

		// exit();
		// $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
		$conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
			if (!$conn) {
	   			 $e = oci_error();
	    		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			}
		  
		// $sql =  "BEGIN APPS.KHS_CREATE_MO_JOB(:P_PARAM1,:P_PARAM2,:P_PARAM3,:P_PARAM4,:P_PARAM5,:P_PARAM6,:P_PARAM7,:P_PARAM8,:P_PARAM9,:P_PARAM10); END;";
		$sql =  "BEGIN APPS.KHSCREATEMO.create_job_header(:P_PARAM1,:P_PARAM2,:P_PARAM3,:P_PARAM4,:P_PARAM5,:P_PARAM6,:P_PARAM7,:P_PARAM8,:P_PARAM9,:P_PARAM10); END;";

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
		oci_bind_by_name($stmt,':P_PARAM9',$nomor_mo);
		oci_bind_by_name($stmt,':P_PARAM10',$user_id);

		
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
	
	function createKIB($department,$nomor_mo, $nojob, $user)
	{

		$status = null;
		// echo "<pre>";
		// echo ':P_PARAM1 = '.$nojob.'<br>'; 
		// echo ':P_PARAM2 = '.$department.'<br>';
		// echo ':P_PARAM3 = '.$nomor_mo.'<br>';
		// echo ':P_PARAM4 = '.$user.'<br>';

		// exit();
		// $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
		$conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
			if (!$conn) {
	   			 $e = oci_error();
	    		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			}
		  
		// $sql =  "BEGIN APPS.KHS_CREATE_MO_JOB(:P_PARAM1,:P_PARAM2,:P_PARAM3,:P_PARAM4,:P_PARAM5,:P_PARAM6,:P_PARAM7,:P_PARAM8,:P_PARAM9,:P_PARAM10); END;";
		$sql =  "BEGIN APPS.khs_picklist_job_opm(:P_PARAM1,:P_PARAM2,:P_PARAM3,:P_PARAM4); END;";

		// $param4 = '';


		//Statement does not change
		$stmt = oci_parse($conn,$sql);                     
		oci_bind_by_name($stmt,':P_PARAM1',$nojob);           
		oci_bind_by_name($stmt,':P_PARAM2',$department); 
		oci_bind_by_name($stmt,':P_PARAM3',$nomor_mo);
		oci_bind_by_name($stmt,':P_PARAM4',$user);

		
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
		$sql = "SELECT   wro.inventory_item_id, wro.required_quantity req,
                khs_inv_qty_oh (wdj.organization_id, wro.inventory_item_id, wro.attribute1, wro.attribute2, '')
                - (NVL ((SELECT SUM (mtrl.quantity) - SUM (NVL (mtrl.quantity_delivered, 0)) quantity
                            FROM mtl_txn_request_headers mtrh,
                                mtl_txn_request_lines mtrl
                            WHERE mtrh.header_id = mtrl.header_id
                            AND mtrl.line_status IN (3, 7)
                            AND mtrh.header_status IN (3, 7)
                            AND mtrl.inventory_item_id = wro.inventory_item_id
                            AND mtrh.organization_id = wro.organization_id
                            AND mtrl.from_subinventory_code = wro.attribute1
                            AND NVL (mtrl.from_locator_id, 0) = NVL (wro.attribute2, 0)
                        GROUP BY mtrl.inventory_item_id), 0)) atr
        FROM wip_entities we,
                wip_discrete_jobs wdj,
                wip_requirement_operations wro,
                wip_operations wo,
                bom_operational_routings bor
        WHERE we.wip_entity_id = wdj.wip_entity_id
            AND we.organization_id = wdj.organization_id
            AND wdj.wip_entity_id = wro.wip_entity_id
            AND wdj.common_routing_sequence_id = bor.routing_sequence_id
            AND wo.wip_entity_id = wdj.wip_entity_id
            AND wo.organization_id = we.organization_id
            AND wro.attribute1 IS NOT NULL
            AND we.wip_entity_name = '$job'                      --'D191103750'
            AND wro.inventory_item_id NOT IN (
                SELECT DISTINCT msib.inventory_item_id
                            FROM mtl_system_items_b msib,
                                gmd_recipe_validity_rules grvr,
                                gmd_recipes_b grb,
                                gmd_routings_b grtb
                            WHERE msib.inventory_item_id = grvr.inventory_item_id
                            AND msib.organization_id = grvr.organization_id
                            AND grvr.recipe_id = grb.recipe_id
                            AND grvr.validity_rule_status = 700
                            AND grvr.end_date IS NULL
                            AND grb.recipe_status = 700
                            AND grb.routing_id = grtb.routing_id
                            AND grtb.routing_class = 'SHMT')
        UNION
        SELECT   wro.inventory_item_id, wro.required_quantity req,
                khs_inv_qty_att ('101', wro.inventory_item_id, 'SM-TKS', '', '')
                - NVL ((SELECT SUM (kkk.qty_kib)
                        FROM khs_kib_kanban kkk
                        WHERE kkk.inventory_trans_flag = 'N'
                        AND kkk.primary_item_id = wro.inventory_item_id), 0) atr
        FROM wip_entities we,
                wip_discrete_jobs wdj,
                wip_requirement_operations wro,
                wip_operations wo,
                bom_operational_routings bor
        WHERE we.wip_entity_id = wdj.wip_entity_id
            AND we.organization_id = wdj.organization_id
            AND wdj.wip_entity_id = wro.wip_entity_id
            AND wdj.common_routing_sequence_id = bor.routing_sequence_id
            AND wo.wip_entity_id = wdj.wip_entity_id
            AND wo.organization_id = we.organization_id
            AND wro.attribute1 IS NOT NULL
            AND we.wip_entity_name = '$job'                      --'D191103750'
            AND wro.inventory_item_id IN (
                SELECT DISTINCT msib.inventory_item_id
                            FROM mtl_system_items_b msib,
                                gmd_recipe_validity_rules grvr,
                                gmd_recipes_b grb,
                                gmd_routings_b grtb
                            WHERE msib.inventory_item_id = grvr.inventory_item_id
                            AND msib.organization_id = grvr.organization_id
                            AND grvr.recipe_id = grb.recipe_id
                            AND grvr.validity_rule_status = 700
                            AND grvr.end_date IS NULL
                            AND grb.recipe_status = 700
                            AND grb.routing_id = grtb.routing_id
                            AND grtb.routing_class = 'SHMT')
        ORDER BY 3 ASC";
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


	// function checkJob($job_id) {
	// 	$oracle = $this->load->database('oracle',TRUE);
	// 	$sql = "SELECT distinct we.WIP_ENTITY_NAME from wip_entities we where we.WIP_ENTITY_ID = $job_id ";
	// 	$query = $oracle->query($sql);
	// 	return $query->result_array();
	// }

	function getKurang($job,$atr)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT distinct wro.REQUIRED_QUANTITY req ,msib2.SEGMENT1 item_code
				,msib2.DESCRIPTION item_desc ,wro.ATTRIBUTE1 gudang_asal  $atr
                     from wip_entities we
                    ,wip_discrete_jobs wdj
                    ,mtl_system_items_b msib
                    ,wip_requirement_operations wro 
                    ,mtl_system_items_b msib2
--                    ,bom_bill_of_materials bom
--                    ,bom_inventory_components bic
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
--                and bom.BILL_SEQUENCE_ID = bic.BILL_SEQUENCE_ID
--                and bom.ASSEMBLY_ITEM_ID = msib.INVENTORY_ITEM_ID
--                and bom.ORGANIZATION_ID = msib.ORGANIZATION_ID
--                and bic.COMPONENT_ITEM_ID = msib2.INVENTORY_ITEM_ID
--                and wdj.COMMON_BOM_SEQUENCE_ID = bom.COMMON_BILL_SEQUENCE_ID
                and wro.ATTRIBUTE2 = mil.INVENTORY_LOCATION_ID(+)
                and wro.SUPPLY_LOCATOR_ID = mil2.INVENTORY_LOCATION_ID(+)
                --routing
                and wdj.COMMON_ROUTING_SEQUENCE_ID = bor.ROUTING_SEQUENCE_ID
                --
                and wo.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
                and wo.ORGANIZATION_ID = we.ORGANIZATION_ID
                and wo.DEPARTMENT_ID = bd.DEPARTMENT_ID
                and khs_shift(wdj.SCHEDULED_START_DATE) = bcs.SHIFT_NUM
                -- INT THE TRUTH IT WILL USED --
                and wro.ATTRIBUTE1 is not null
                -- INT THE TRUTH ABOVE IT WILL USED --
                and we.WIP_ENTITY_NAME = '$job'--'D191103750'";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getShift2($shift)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "select distinct BCS.SHIFT_NUM,BCS.DESCRIPTION
				from BOM_SHIFT_TIMES bst
				    ,BOM_CALENDAR_SHIFTS bcs
				    ,bom_shift_dates bsd
				where bst.CALENDAR_CODE = bcs.CALENDAR_CODE
				  and bst.SHIFT_NUM = bcs.SHIFT_NUM
				  and bcs.CALENDAR_CODE='KHS_CAL'
				  and bst.shift_num = bsd.shift_num
				  and bst.calendar_code=bsd.calendar_code
				  and BCS.SHIFT_NUM = '$shift'
				  and bsd.SEQ_NUM is not null
				  ORDER BY BCS.SHIFT_NUM asc";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getDescDept($dept)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = " SELECT distinct dept, description 
				  FROM KHS_DEPT_ROUT_CLASS_V
				  WHERE dept = '$dept'
				  ORDER BY dept asc";
		$query = $oracle->query($sql);
		return $query->result_array();
	}
	
	function getPerbedaan($no_mo, $subinv, $lokator)
	{		
		$oracle = $this->load->database('oracle',TRUE);
		if ($lokator != '') {
			$lokator = "and (kqem.BOM_FROM_LOC = '$lokator' or kqem.JOB_FROM_LOC = '$lokator')";
		}else {
			$lokator = "and (kqem.BOM_FROM_LOC is null and kqem.JOB_FROM_LOC is null)";
		}
		$sql = "with kqem as
				(
				select distinct 
					kqem.*
					,case when kqem.job_from_subinv is null 
							and kqem.bom_from_subinv is not null
							and kqem.code is null
							then 'KOMPONEN DI MO GUDANG : ' || kqem.required_quantity || ' PCS'
							when nvl (kqem.job_comp_qty,0) <> nvl (kqem.bom_comp_qty,0)
							and kqem.code is null
							then 'LAYANI QTY SESUAI JOB : ' || kqem.required_quantity || ' PCS'
							when kqem.code = 'ITEM JOB'
							then 'TAMBAHAN KOMPONEN : ' || kqem.required_quantity || ' PCS'
							when kqem.code = 'ITEM BOM'
							then 'TIDAK PERLU DILAYANI'
					else null
					end perbedaan
				from khs_qweb_ect_jobom_mo kqem
					,mtl_txn_request_headers mtrh
				where mtrh.REQUEST_NUMBER = '$no_mo'
				and (kqem.BOM_FROM_SUBINV = '$subinv' or kqem.JOB_FROM_SUBINV = '$subinv')
                $lokator
				and kqem.JOB_ID = mtrh.ATTRIBUTE1
				)
				select *
				from kqem
				where kqem.perbedaan is not null
				order by kqem.COMPONENT";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	public function getItemSudahPicklist($nojob){
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT
				mtrh.request_number,
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
				wdj.start_quantity, -- ntar di sum
				--component
				msib_compnt.SEGMENT1 kode_komponen,
				msib_compnt.description kode_desc,
				msib_compnt.inventory_item_id item_id_komponen,
				msib_compnt.organization_id org_id_komponen,
				wro.QUANTITY_PER_ASSEMBLY Qty_UNIT,
				mtrl.QUANTITY qty_minta,
				mtrl.FROM_SUBINVENTORY_CODE lokasi,
				mil.SEGMENT1 lokator ,
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
				BOM_CALENDAR_SHIFTS bcs,
				mtl_item_locations mil
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
--                            and mtrh.request_number = 'D201010892-1'
				and we.WIP_ENTITY_NAME = '$nojob'
				-- and mtrl.FROM_SUBINVENTORY_CODE not like 'INT%'
				and wro.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
				and mtrl.FROM_LOCATOR_ID = mil.INVENTORY_LOCATION_ID(+)
				order by
				mtrl.LINE_ID,
				we.WIP_ENTITY_NAME,
				mtrl.FROM_SUBINVENTORY_CODE,
				msib_compnt.SEGMENT1";
		$query = $oracle->query($sql);
		return $query->result_array();
	}


}