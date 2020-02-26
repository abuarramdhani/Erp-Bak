<?php defined('BASEPATH') OR die('No direct script access allowed');
class M_monitoringassy extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function dataassy($department, $kodeassy)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT msib.segment1
				,msib.description
				,bor.ASSEMBLY_ITEM_ID
				,msib2.SEGMENT1 COMPONENT_CODE
				,msib2.DESCRIPTION COMPONENT_DESC
				,bic.ATTRIBUTE1 from_subinv
				,mil2.SEGMENT1 from_locator
				,bic.SUPPLY_SUBINVENTORY pull_subinv
				,mil.SEGMENT1 pull_locator
				,khs_inv_qty_att(msib2.ORGANIZATION_ID,msib2.INVENTORY_ITEM_ID,bic.ATTRIBUTE1 ,bic.ATTRIBUTE2,'') onhand
				,bd.DEPARTMENT_CLASS_CODE dept_class
				from bom_operational_routings bor
				,bom_operation_sequences bos
				,bom_departments bd
				,bom_bill_of_materials bom
				,bom_inventory_components bic
				,mtl_system_items_b msib2
				,mtl_system_items_b msib
				,mtl_item_locations mil
				,mtl_item_locations mil2
				where bor.ROUTING_SEQUENCE_ID = bos.ROUTING_SEQUENCE_ID
				and bos.DISABLE_DATE is null
				and bos.DEPARTMENT_ID = bd.department_id
				and bor.ORGANIZATION_ID = bd.ORGANIZATION_ID
				and bor.ALTERNATE_ROUTING_DESIGNATOR is null
				and bos.OPERATION_SEQ_NUM = (select min(bos1.OPERATION_SEQ_NUM)
				from bom_operation_sequences bos1
				where bos1.ROUTING_SEQUENCE_ID = bor.ROUTING_SEQUENCE_ID 
				and bos1.DISABLE_DATE is null)
				$department
				and msib.inventory_ITEM_ID = bor.ASSEMBLY_ITEM_ID
				and msib.ORGANIZATION_ID = bor.ORGANIZATION_ID
				and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
				and bom.bill_sequence_id = bic.bill_sequence_id
				and bom.ASSEMBLY_ITEM_ID = msib.inventory_item_id
				and bom.organization_id = msib.organization_id
				and bic.COMPONENT_ITEM_ID = msib2.inventory_item_id
				and bom.ORGANIZATION_ID = msib2.ORGANIZATION_ID
				and bom.ALTERNATE_BOM_DESIGNATOR is null
				and bic.DISABLE_DATE is null
				and bic.ATTRIBUTE1 is not null
				and bic.SUPPLY_LOCATOR_ID = mil.INVENTORY_LOCATION_ID (+)
				and bic.ATTRIBUTE2 = mil2.INVENTORY_LOCATION_ID (+)
				--- JIKA MENAMBAHLAN PARAMETER ASSY
				$kodeassy";

		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function selectassy($term)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "	SELECT distinct msib.segment1
					from bom_operational_routings bor
					,bom_operation_sequences bos
					,bom_departments bd
					,bom_bill_of_materials bom
					,bom_inventory_components bic
					,mtl_system_items_b msib2
					,mtl_system_items_b msib
					,mtl_item_locations mil
					,mtl_item_locations mil2
					where bor.ROUTING_SEQUENCE_ID = bos.ROUTING_SEQUENCE_ID
					and bos.DISABLE_DATE is null
					and bos.DEPARTMENT_ID = bd.department_id
					and bor.ORGANIZATION_ID = bd.ORGANIZATION_ID
					and bor.ALTERNATE_ROUTING_DESIGNATOR is null
					and bos.OPERATION_SEQ_NUM = (select min(bos1.OPERATION_SEQ_NUM)
					from bom_operation_sequences bos1
					where bos1.ROUTING_SEQUENCE_ID = bor.ROUTING_SEQUENCE_ID 
					and bos1.DISABLE_DATE is null)
					and bd.DEPARTMENT_CLASS_CODE = 'WELD' 
					and msib.inventory_ITEM_ID = bor.ASSEMBLY_ITEM_ID
					and msib.ORGANIZATION_ID = bor.ORGANIZATION_ID
					and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
					and bom.bill_sequence_id = bic.bill_sequence_id
					and bom.ASSEMBLY_ITEM_ID = msib.inventory_item_id
					and bom.organization_id = msib.organization_id
					and bic.COMPONENT_ITEM_ID = msib2.inventory_item_id
					and bom.ORGANIZATION_ID = msib2.ORGANIZATION_ID
					and bom.ALTERNATE_BOM_DESIGNATOR is null
					and bic.DISABLE_DATE is null
					-- and bic.ATTRIBUTE1 is not null
					and bic.SUPPLY_LOCATOR_ID = mil.INVENTORY_LOCATION_ID (+)
					and bic.ATTRIBUTE2 = mil2.INVENTORY_LOCATION_ID (+)
					and msib.SEGMENT1 LIKE '%$term%'";

		$query = $oracle->query($sql);
		return $query->result_array();
	}

		function selectdept($term)
	{
		$oracle = $this->load->database('oracle',TRUE);
// 		$sql = "SELECT distinct bd.DEPARTMENT_CLASS_CODE dept_class
// 					from bom_operational_routings bor
// 					,bom_operation_sequences bos
// 					,bom_departments bd
// 					,bom_bill_of_materials bom
// 					,bom_inventory_components bic
// 					,mtl_system_items_b msib2
// 					,mtl_system_items_b msib
// 					,mtl_item_locations mil
// 					,mtl_item_locations mil2
// 					where bor.ROUTING_SEQUENCE_ID = bos.ROUTING_SEQUENCE_ID
// 					and bos.DISABLE_DATE is null
// 					and bos.DEPARTMENT_ID = bd.department_id
// 					and bor.ORGANIZATION_ID = bd.ORGANIZATION_ID
// 					and bor.ALTERNATE_ROUTING_DESIGNATOR is null
// 					and bos.OPERATION_SEQ_NUM = (select min(bos1.OPERATION_SEQ_NUM)
// 					from bom_operation_sequences bos1
// 					where bos1.ROUTING_SEQUENCE_ID = bor.ROUTING_SEQUENCE_ID 
// 					and bos1.DISABLE_DATE is null)
// 					and bd.DEPARTMENT_CLASS_CODE LIKE '%$term%' 
// 					and msib.inventory_ITEM_ID = bor.ASSEMBLY_ITEM_ID
// 					and msib.ORGANIZATION_ID = bor.ORGANIZATION_ID
// 					and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
// 					and bom.bill_sequence_id = bic.bill_sequence_id
// 					and bom.ASSEMBLY_ITEM_ID = msib.inventory_item_id
// 					and bom.organization_id = msib.organization_id
// 					and bic.COMPONENT_ITEM_ID = msib2.inventory_item_id
// 					and bom.ORGANIZATION_ID = msib2.ORGANIZATION_ID
// 					and bom.ALTERNATE_BOM_DESIGNATOR is null
// 					and bic.DISABLE_DATE is null
// 					-- and bic.ATTRIBUTE1 is not null
// 					and bic.SUPPLY_LOCATOR_ID = mil.INVENTORY_LOCATION_ID (+)
// 					and bic.ATTRIBUTE2 = mil2.INVENTORY_LOCATION_ID (+)
// 					--- JIKA MENAMBAHLAN PARAMETER ASSY
// --					and msib.SEGMENT1 = 'AAL1000001AA-0'";

			$sql = "SELECT distinct dept, description 
				  	FROM KHS_DEPT_ROUT_CLASS_V
				  	WHERE dept LIKE '%$term%'";

		$query = $oracle->query($sql);
		return $query->result_array();
	}

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



}