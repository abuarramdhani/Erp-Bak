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



}