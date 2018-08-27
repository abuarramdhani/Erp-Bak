<?php
class M_transaction extends CI_Model {
    public function __construct()
    {
    	$this->oracle = $this->load->database ('oracle', TRUE);
    }
	
	function insertPacking($dt)
	{
		$this->oracle->insert('KHS_PACKINGLIST_TRANSACTIONS', $dt);
	}
	
	function deletePackingList($id)
	{
		$this->oracle->where('MO_NUMBER', $id);
		$this->oracle->delete('KHS_PACKINGLIST_TRANSACTIONS');
	}

	public function getPackinglistDestination($spbNumber)
	{
		$sql = "
			SELECT
				mp.organization_code || '<br>' || hou.name || '<br>' || hou.address_line_1 || '<br>' || hou.town_or_city kepada_yth,
				REPLACE( mtrh.ATTRIBUTE4, '#', '<br>' ) dikirim_kepada
			FROM
				mtl_txn_request_headers mtrh,
				HR_ORGANIZATION_UNITS_V hou,
				mtl_parameters mp
			WHERE
				hou.ORGANIZATION_ID = mtrh.attribute1
				AND mp.organization_id = mtrh.attribute1
				AND mtrh.request_number = '$spbNumber'
			UNION ALL
			 SELECT
				DISTINCT bill_loc.address2 || '<br>' || bill_loc.address1 || '<br>' || bill_loc.city || ', ' || bill_loc.province || ', ' || bill_loc.country kepada_yth,
				ship_loc.address2 || '<br>' || ship_loc.address1 || '<br>' || ship_loc.city || ', ' || ship_loc.province || ', ' || ship_loc.country dikirim_kepada
			FROM
				mtl_txn_request_headers mtrh,
				oe_order_headers_all ooha,
				wsh_delivery_details wdd,
				hz_cust_site_uses_all bill_su,
				hz_party_sites bill_ps,
				hz_locations bill_loc,
				hz_cust_acct_sites_all bill_cas,
				hz_cust_site_uses_all ship_su,
				hz_cust_acct_sites_all ship_cas,
				hz_party_sites ship_ps,
				hz_locations ship_loc
			WHERE
				wdd.SOURCE_HEADER_ID = ooha.HEADER_ID
				AND mtrh.request_number = TO_CHAR( wdd.BATCH_ID )
				AND mtrh.MOVE_ORDER_TYPE = 3
				AND mtrh.request_number = '$spbNumber'
				AND ooha.invoice_to_org_id = bill_su.site_use_id(+)
				AND bill_su.cust_acct_site_id = bill_cas.cust_acct_site_id(+)
				AND bill_cas.party_site_id = bill_ps.party_site_id(+)
				AND bill_loc.location_id(+)= bill_ps.location_id
				AND ooha.ship_to_org_id = ship_su.site_use_id(+)
				AND ship_su.cust_acct_site_id = ship_cas.cust_acct_site_id(+)
				AND ship_cas.party_site_id = ship_ps.party_site_id(+)
				AND ship_loc.location_id(+)= ship_ps.location_id
		";

		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function getPackinglistTotalPack($spbNumber)
	{
		$sql = "
			SELECT count(*) total
			FROM
			  (SELECT bb.packing_code
			   FROM khs_packinglist_transactions bb
			   WHERE bb.mo_number='$spbNumber'
			   GROUP BY bb.packing_code
			   ORDER BY substr(bb.packing_code,3),
			            substr(bb.packing_code,1,1))
		";

		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function getPackingCode($spbNumber)
	{
		$sql = "
			SELECT packing_code
			FROM khs_packinglist_transactions
			WHERE mo_number= '$spbNumber'
			GROUP BY packing_code
			ORDER BY packing_code
		";

		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function getPackingList($spbNumber, $packCode)
	{
		$sql = "
			SELECT
				rownum rn,
				kpt.mo_number,
				kpt.packing_qty,
				kpt.packing_code,
				msib.segment1,
				msib.description,
				msib.primary_uom_code,
				SUBSTR( kpt.packing_code, 3 ) code_box,
				SUBSTR( kpt.packing_code, 1, 1 ) no_box,
				(
					SELECT
						COUNT( bx.code ) jumlah
					FROM
						(
							SELECT
								mo_number,
								packing_code,
								SUBSTR( packing_code, 3 ) code,
								SUBSTR( packing_code, 1, 1 ) no_box
							FROM
								khs_packinglist_transactions
							WHERE
								mo_number = NVL( '$spbNumber', mo_number )
							GROUP BY
								packing_code,
								mo_number
							ORDER BY
								packing_code
						) bx
					WHERE
						bx.code = SUBSTR( kpt.packing_code, 3 )
						AND bx.mo_number = kpt.mo_number
					GROUP BY
						bx.code
				) jumlah
			FROM
				khs_packinglist_transactions kpt,
				mtl_system_items_b msib
			WHERE
				kpt.mo_number = NVL( '$spbNumber', kpt.mo_number )
				AND kpt.packing_code = '$packCode'
				AND kpt.inventory_item_id = msib.inventory_item_id
				AND msib.organization_id = 81
			ORDER BY
				kpt.mo_number,
				kpt.packing_code
		";

		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
}