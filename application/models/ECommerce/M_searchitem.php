<?php
class M_searchitem extends CI_Model {

	public function __construct()
	{
		 $this->load->database();
		$this->load->library('encrypt');
	}

	public function getAllOrganization()
	{
		$oracle = $this->load->database('oracle', TRUE);
		$sql="SELECT
				hou.ORGANIZATION_ID,hou.NAME,hou.ATTRIBUTE30
			FROM
				HR_ORGANIZATION_UNITS hou
			WHERE 
				hou.NAME LIKE '%jual%'
			order by 1";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	public function getSubInventoryByOrganization($org_id)
	{
		$oracle = $this->load->database('oracle', TRUE);
		$sql="SELECT
				secondary_inventory_name subinventory,
				description,
				subinventory_type,
				organization_id,
				asset_inventory,
				quantity_tracked,
				inventory_atp_code,
				availability_type,
				reservable_type,
				locator_type,
				picking_order,
				dropping_order,
				location_id,
				status_id
			FROM mtl_secondary_inventories
			WHERE organization_id=$org_id
			ORDER BY subinventory";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	public function getItemBySubInventory($org_id,$sub_code)
	{
		$oracle = $this->load->database('oracle', TRUE);
		$sql="SELECT
				msib.SEGMENT1,
				msib.DESCRIPTION,
				msib.PRIMARY_UOM_CODE,
				sum(moq.TRANSACTION_QUANTITY) qty,
				moq.SUBINVENTORY_CODE
			FROM
				MTL_ONHAND_QUANTITIES moq,
				MTL_SYSTEM_ITEMS_B msib
			WHERE
				msib.INVENTORY_ITEM_ID = moq.INVENTORY_ITEM_ID
				AND 
				msib.ORGANIZATION_ID = moq.ORGANIZATION_ID
				AND 
				moq.SUBINVENTORY_CODE LIKE '$sub_code'
				AND 
				moq.ORGANIZATION_ID = $org_id
			GROUP BY
				msib.SEGMENT1
				,msib.PRIMARY_UOM_CODE
				,moq.SUBINVENTORY_CODE
				,msib.DESCRIPTION";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	public function getItemFromToko($item_code)
	{
		$tokoquick = $this->load->database('tokoquick', TRUE);
		$sql="SELECT
				distinct ps_product.id_product,
				ps_product_lang.name,
				ps_product.reference,
				ps_stock_available.quantity,
				ps_product.price,
				ps_product.weight,
				ps_product.width,
				ps_product.height,
				ps_product.depth,
				ps_image_shop.id_image
			FROM
				ps_product
			JOIN ps_product_lang ON
				ps_product.id_product = ps_product_lang.id_product
			JOIN ps_stock_available ON
				ps_product_lang.id_product = ps_stock_available.id_product
			LEFT JOIN ps_image_shop ON
				ps_stock_available.id_product = ps_image_shop.id_product
			WHERE
				ps_product_lang.id_lang = '2'
				AND
				ps_product.reference = '$item_code'
			ORDER BY
				ps_product.id_product";
		$query = $tokoquick->query($sql);
		return $query->result_array();
	}

}
?>