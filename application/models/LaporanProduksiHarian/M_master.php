<?php defined('BASEPATH') OR die('No direct script access allowed');
class M_master extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	  $this->oracle = $this->load->database('oracle',TRUE);
		$this->lantuma = $this->load->database('lantuma', TRUE);
	}

	public function get_sarana($code)
	{
		$sql = "SELECT
						  msib.SEGMENT1 item_code,
						  msib.DESCRIPTION ,
						  msib.UNIT_VOLUME STD_HANDLING,
						  msib.CONTAINER_TYPE_CODE kode_kontainer,
						  FLV.MEANING deskripsi_kontainer,
						  FLV.DESCRIPTION
						FROM mtl_system_items_b msib ,
						  fnd_lookup_values flv
						WHERE msib.CONTAINER_TYPE_CODE   = flv.LOOKUP_CODE (+)
						and flv.LOOKUP_TYPE (+)            = 'CONTAINER_TYPE'
						and msib.SEGMENT1 = '$code'
						and msib.ORGANIZATION_ID = 81";
		return $this->oracle->query($sql)->row_array();
	}

	public function get_no_dies($code, $proses)
	{
		$sql = "SELECT msib.segment1
                  ,goa.ACTIVITY
                  ,goa.ATTRIBUTE1 kode_proses
                  ,mc.*
                  -- ,op.RESOURCE_COUNT qty_optr
                  from gmd_recipe_validity_rules grvr
                  ,gmd_recipes_b grb
                  ,mtl_system_items_b msib
                  ,fm_form_mst_b ffb
                  ,gmd_routings_b grtb
                  ,fm_rout_dtl frd
                  ,gmd_operations_b gob
                  ,GMD_OPERATION_ACTIVITIES GOA
                  ,(select gormc.OPRN_LINE_ID
                  ,crmbmc.RESOURCES
                  ,crmtmc.RESOURCE_DESC
                  ,gormc.PROCESS_QTY
                  ,gormc.RESOURCE_USAGE
                  ,gormc.RESOURCE_COUNT
                  ,gormc.ATTRIBUTE1 ab1,gormc.ATTRIBUTE2 ab2,gormc.ATTRIBUTE3 ab3,gormc.ATTRIBUTE4 ab4,gormc.ATTRIBUTE5 ab5,gormc.ATTRIBUTE6 ab6,gormc.ATTRIBUTE7 ab7
                  from gmd_operation_resources gormc
                  ,cr_rsrc_mst_tl crmtmc
                  ,cr_rsrc_mst_b crmbmc
                  where gormc.RESOURCES = crmtmc.RESOURCES
                  and gormc.RESOURCES = crmbmc.RESOURCES
                  and crmbmc.RESOURCE_CLASS = 'ALTBANTU') mc
                  where grvr.RECIPE_ID = grb.RECIPE_ID
                  and grvr.VALIDITY_RULE_STATUS = 700
                  and grvr.RECIPE_USE = 0
                  and grvr.END_DATE is null
                  and grvr.ORGANIZATION_ID = grb.OWNER_ORGANIZATION_ID
                  and grb.RECIPE_STATUS = 700
                  and grvr.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
                  and grvr.ORGANIZATION_ID = msib.ORGANIZATION_ID
                  --and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
                  and grb.FORMULA_ID = ffb.FORMULA_ID
                  and grb.OWNER_ORGANIZATION_ID = ffb.OWNER_ORGANIZATION_ID
                  and ffb.FORMULA_STATUS = 700
                  and grb.ROUTING_ID = grtb.ROUTING_ID(+)
                  and grtb.ROUTING_ID = frd.ROUTING_ID
                  and grtb.OWNER_ORGANIZATION_ID = gob.OWNER_ORGANIZATION_ID
                  and frd.OPRN_ID = gob.OPRN_ID
                  and frd.OPRN_ID = goa.OPRN_ID
                  and goa.OPRN_ID = gob.OPRN_ID
                  --AND grtb.ROUTING_CLASS        = 'SHMT'
                  and msib.SEGMENT1 IN ('$code')  --------------------> ISI DENGAN ITEM YANG AKAN DICARI
									and goa.ACTIVITY = '$proses'
                  and goa.OPRN_LINE_ID = mc.OPRN_LINE_ID(+)
--                        order by substr(msib.segment1,1,11)
--                        ,grb.RECIPE_VERSION
--                        ,substr(msib.segment1,1,11)||substr(msib.segment1,12,2)
--                        ,grb.RECIPE_NO
--                        ,grb.RECIPE_VERSION desc
--                        ,grtb.ROUTING_NO
--                        ,grtb.ROUTING_VERS
--                        ,frd.ROUTINGSTEP_NO
--                        ,ffb.FORMULA_NO
--                        ,ffb.FORMULA_VERS";

			return $this->oracle->query($sql)->row_array();

	}

	public function get_target_pe($code)
	{
		$sql = "SELECT msib.segment1
						-- ,msib.description
						-- ,grvr.PREFERENCE
						-- ,grb.RECIPE_ID
						-- ,grb.RECIPE_NO
						-- ,grb.RECIPE_VERSION
						-- ,ffb.FORMULA_NO
						-- ,ffb.FORMULA_VERS
						-- ,grtb.ROUTING_ID
						-- ,grtb.ROUTING_NO
						-- ,grtb.ROUTING_VERS
						-- ,grtb.ROUTING_CLASS
						-- ,frd.ROUTINGSTEP_NO
						-- ,gob.OPRN_NO
						-- ,gob.OPRN_VERS
						-- ,goa.OPRN_ID
						,goa.ACTIVITY
						,goa.ATTRIBUTE1 kode_proses
						-- ,goa.OPRN_LINE_ID
						-- ,mc.resources
						-- ,mc.resource_desc
						,round((op.RESOURCE_USAGE/op.PROCESS_QTY),5) usage
						,round(6.5/(round((op.RESOURCE_USAGE/op.PROCESS_QTY),5))) targetSK
						,round(330/390*round(6.5/(round((op.RESOURCE_USAGE/op.PROCESS_QTY),5)))) targetJS
						-- ,mc.RESOURCE_COUNT qty_mesin
						-- ,op.RESOURCE_COUNT qty_optr
						from gmd_recipe_validity_rules grvr
						,gmd_recipes_b grb
						,mtl_system_items_b msib
						,fm_form_mst_b ffb
						,gmd_routings_b grtb
						,fm_rout_dtl frd
						,gmd_operations_b gob
						,GMD_OPERATION_ACTIVITIES GOA
						,(select gorop.OPRN_LINE_ID
						,crmbop.RESOURCES
						,crmtop.RESOURCE_DESC
						,gorop.PROCESS_QTY
						,gorop.RESOURCE_USAGE
						,gorop.RESOURCE_COUNT
						from gmd_operation_resources gorop
						,cr_rsrc_mst_tl crmtop
						,cr_rsrc_mst_b crmbop
						where gorop.RESOURCES = crmtop.RESOURCES
						and gorop.RESOURCES = crmbop.RESOURCES
						and crmbop.RESOURCE_CLASS = 'OPERATOR') op
						,(select gormc.OPRN_LINE_ID
						,crmbmc.RESOURCES
						,crmtmc.RESOURCE_DESC
						,gormc.PROCESS_QTY
						,gormc.RESOURCE_USAGE
						,gormc.RESOURCE_COUNT
						from gmd_operation_resources gormc
						,cr_rsrc_mst_tl crmtmc
						,cr_rsrc_mst_b crmbmc
						where gormc.RESOURCES = crmtmc.RESOURCES
						and gormc.RESOURCES = crmbmc.RESOURCES
						and crmbmc.RESOURCE_CLASS = 'MESIN') mc
						where grvr.RECIPE_ID = grb.RECIPE_ID
						and grvr.VALIDITY_RULE_STATUS = 700
						and grvr.RECIPE_USE = 0
						and grvr.END_DATE is null
						and grvr.ORGANIZATION_ID = grb.OWNER_ORGANIZATION_ID
						and grb.RECIPE_STATUS = 700
						and grvr.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
						and grvr.ORGANIZATION_ID = msib.ORGANIZATION_ID
						--and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
						and grb.FORMULA_ID = ffb.FORMULA_ID
						and grb.OWNER_ORGANIZATION_ID = ffb.OWNER_ORGANIZATION_ID
						and ffb.FORMULA_STATUS = 700
						and grb.ROUTING_ID = grtb.ROUTING_ID(+)
						and grtb.ROUTING_ID = frd.ROUTING_ID
						and grtb.OWNER_ORGANIZATION_ID = gob.OWNER_ORGANIZATION_ID
						and frd.OPRN_ID = gob.OPRN_ID
						and frd.OPRN_ID = goa.OPRN_ID
						and goa.OPRN_ID = gob.OPRN_ID
						--AND grtb.ROUTING_CLASS        = 'SHMT'
						and msib.SEGMENT1 IN ('$code')         -----------------------------------------> ISI DENGAN ITEM YANG AKAN DICARI
						and goa.OPRN_LINE_ID = mc.OPRN_LINE_ID(+)
						and goa.OPRN_LINE_ID = op.OPRN_LINE_ID(+)
						order by substr(msib.segment1,1,11)
						,grb.RECIPE_VERSION
						,substr(msib.segment1,1,11)||substr(msib.segment1,12,2)
						,grb.RECIPE_NO
						,grb.RECIPE_VERSION desc
						,grtb.ROUTING_NO
						,grtb.ROUTING_VERS
						,frd.ROUTINGSTEP_NO
						,ffb.FORMULA_NO
						,ffb.FORMULA_VERS";

			return	$this->oracle->query($sql)->result_array();

	}

	function kodePart($variable, $product) // dari TSKK
	{


	// $sql = "SELECT msib.segment1, msib.description
	// 						FROM fnd_flex_values ffv, fnd_flex_values_tl ffvt,
	// 								 mtl_system_items_b msib
	// 					 WHERE ffv.flex_value_set_id = 1013710
	// 						 AND ffv.flex_value_id = ffvt.flex_value_id
	// 						 AND ffv.end_date_active IS NULL
	// 						 AND ffv.summary_flag = 'N'
	// 						 AND ffv.enabled_flag = 'Y'
	// 						 AND ffv.flex_value = SUBSTR (msib.segment1, 1, 3)
	// 						 AND (msib.DESCRIPTION LIKE '%$variable%'
	// 									OR msib.SEGMENT1 LIKE '%$variable%')
	// 						 $where_product
	// 						 AND msib.organization_id = 81
	// 						 AND msib.inventory_item_status_code = 'Active'
	// 				ORDER BY 1";

	$sql = "SELECT DISTINCT msib.segment1, msib.description
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
									AND grtb.routing_class = 'SHMT'
									-- AND msib.item_type = '2096'
									-- AND msib.min_minmax_quantity <> 0
									-- AND msib.max_minmax_quantity <> 0
									-- AND msib.attribute9 <> 0
									AND (msib.DESCRIPTION LIKE '%$variable%'
											 OR msib.SEGMENT1 LIKE '%$variable%')";

		 $query = $this->oracle->query($sql);
		 return $query->result_array();
		 // echo $sql;
		 // die;
	}

	//SEARCH ALAT BANTU
	public function selectAlatBantu($ab){
		$sql = "SELECT distinct tto.fs_nm_tool, tto.fs_no_tool
							from ttool tto where (
								tto.fs_nm_tool like '%$ab%' or tto.fs_no_tool like '%$ab%'
							)";
		return $this->lantuma->query($sql)->result_array();
	}

	public function get_detail_shift($where)
	{
		return $this->oracle->query("SELECT DESCRIPTION FROM BOM_CALENDAR_SHIFTS WHERE shift_num = '$where'")->row_array();
	}

	public function getMon($range, $shift)
	{
		if (!empty($shift)) {
			$shift = "shift = '$shift'";
		}else {
			$shift = 'shift IS NOT NULL';
		}
		$data = $this->db->query("SELECT rko.*
															 FROM lph.lph_rencana_kerja_operator rko
															 WHERE $shift
															 AND to_date(rko.tanggal, 'dd-mm-yyyy') BETWEEN to_date('$range[0]', 'dd-mm-yyyy') AND to_date('$range[1]', 'dd-mm-yyyy')")->result_array();
		$m = '';
		if (!empty($data)) {
			$where = $data[0]['shift'];

			$detail_shift =  $this->oracle->query("SELECT DESCRIPTION FROM BOM_CALENDAR_SHIFTS WHERE shift_num = '$where'")->row_array();
			$m = $detail_shift['DESCRIPTION'];
		}

		foreach ($data as $key => $value) {
				$data[$key]['shift_description'] = $m;
		}
		return $data;
	}

	function getShift($date=FALSE)
	{
		if ($date === FALSE) {
			$date = date('Y/m/d');
			$cek = '';
		}else {
			$cek = 'and bsd.SEQ_NUM is not null';
		}
		//uncomand jika filter ingin di akfifkan
		return $this->oracle->query("SELECT BCS.SHIFT_NUM, BCS.DESCRIPTION
												        from BOM_SHIFT_TIMES bst,
												        BOM_CALENDAR_SHIFTS bcs,
												        bom_shift_dates bsd
												        where bst.CALENDAR_CODE = bcs.CALENDAR_CODE
												        and bst.SHIFT_NUM = bcs.SHIFT_NUM
												        and bcs.CALENDAR_CODE='KHS_CAL'
												        and bst.shift_num = bsd.shift_num
												        and bst.calendar_code=bsd.calendar_code
												        $cek
												        and bsd.shift_date=trunc(to_date('$date','YYYY/MM/DD'))
												        ORDER BY BCS.SHIFT_NUM asc")->result_array();
	}

	public function employee($data)
	{
			$sql = "SELECT
							employee_code,
							employee_name
						from
							er.er_employee_all
						where
							resign = '0'
							and (employee_code like '%$data%'
							or employee_name like '%$data%')
						order by
							1";
			$response = $this->db->query($sql)->result_array();
			return $response;
	}

	public function selectMS($data)
	{
		$explode = strtoupper($data['search']['value']);
			$res = $this->db
					->query(
							"SELECT kdav.*
							FROM
									(
									SELECT
													skdav.*,
													ROW_NUMBER () OVER (ORDER BY id_num DESC) as pagination
											FROM
													(
														SELECT lpm.*
														FROM
																(SELECT * FROM lph.lph_mesin) lpm
														WHERE
																	(
																		fs_no_mesin LIKE '%{$explode}%'
																		OR fs_nama_mesin LIKE '%{$explode}%'
																	)
													) skdav

									) kdav
							WHERE
									pagination BETWEEN {$data['pagination']['from']} AND {$data['pagination']['to']}"
					)->result_array();

			return $res;
	}

	public function countAllMS()
	{
		return $this->db->query(
			"SELECT
					COUNT(*) AS \"count\"
			FROM
			(SELECT * FROM lph.lph_mesin) lph"
			)->row_array();
	}

	public function countFilteredMS($data)
	{
		$explode = strtoupper($data['search']['value']);
		return $this->db->query(
			"SELECT
						COUNT(*) AS \"count\"
					FROM
					(SELECT * FROM lph.lph_mesin) lph
					WHERE
					(
						fs_no_mesin LIKE '%{$explode}%'
						OR fs_nama_mesin LIKE '%{$explode}%'
					)"
			)->row_array();
	}

	//end mesin

	public function selectAB($data)
	{
		$explode = strtoupper($data['search']['value']);
			$res = $this->db
					->query(
							"SELECT kdav.*
							FROM
									(
									SELECT
													skdav.*,
													ROW_NUMBER () OVER (ORDER BY id DESC) as pagination
											FROM
													(
														SELECT mfo.*
														FROM
																(SELECT * FROM lph.lph_alat_bantu) mfo
														WHERE
																	(
																		fs_no_ab LIKE '%{$explode}%'
																		OR fs_proses LIKE '%{$explode}%'
																	)
													) skdav

									) kdav
							WHERE
									pagination BETWEEN {$data['pagination']['from']} AND {$data['pagination']['to']}"
					)->result_array();

			return $res;
	}

	public function countAllAB()
	{
		return $this->db->query(
			"SELECT
					COUNT(*) AS \"count\"
			FROM
			(SELECT * FROM lph.lph_alat_bantu) lph"
			)->row_array();
	}

	public function countFilteredAB($data)
	{
		$explode = strtoupper($data['search']['value']);
		return $this->db->query(
			"SELECT
						COUNT(*) AS \"count\"
					FROM
					(SELECT * FROM lph.lph_alat_bantu) lph
					WHERE
					(
						fs_no_ab LIKE '%{$explode}%'
						OR fs_proses LIKE '%{$explode}%'
					)"
			)->row_array();
	}

// 	select msib.segment1
// ,msib.description
// ,grvr.PREFERENCE
// ,grb.RECIPE_ID
// ,grb.RECIPE_NO
// ,grb.RECIPE_VERSION
// ,ffb.FORMULA_NO
// ,ffb.FORMULA_VERS
// ,grtb.ROUTING_ID
// ,grtb.ROUTING_NO
// ,grtb.ROUTING_VERS
// ,grtb.ROUTING_CLASS
// ,frd.ROUTINGSTEP_NO
// ,gob.OPRN_NO
// ,gob.OPRN_VERS
// ,goa.OPRN_ID
// ,goa.ACTIVITY
// ,goa.ATTRIBUTE1
// ,goa.OPRN_LINE_ID
// ,mc.resources
// ,mc.resource_desc
// ,round((op.RESOURCE_USAGE/op.PROCESS_QTY),5) usage
// ,round(6.5/(round((op.RESOURCE_USAGE/op.PROCESS_QTY),5))) targetSK
// ,round(330/390*round(6.5/(round((op.RESOURCE_USAGE/op.PROCESS_QTY),5)))) targetJS
// ,mc.RESOURCE_COUNT qty_mesin
// ,op.RESOURCE_COUNT qty_optr
// from gmd_recipe_validity_rules grvr
// ,gmd_recipes_b grb
// ,mtl_system_items_b msib
// ,fm_form_mst_b ffb
// ,gmd_routings_b grtb
// ,fm_rout_dtl frd
// ,gmd_operations_b gob
// ,GMD_OPERATION_ACTIVITIES GOA
// ,(select gorop.OPRN_LINE_ID
// ,crmbop.RESOURCES
// ,crmtop.RESOURCE_DESC
// ,gorop.PROCESS_QTY
// ,gorop.RESOURCE_USAGE
// ,gorop.RESOURCE_COUNT
// from gmd_operation_resources gorop
// ,cr_rsrc_mst_tl crmtop
// ,cr_rsrc_mst_b crmbop
// where gorop.RESOURCES = crmtop.RESOURCES
// and gorop.RESOURCES = crmbop.RESOURCES
// and crmbop.RESOURCE_CLASS = 'OPERATOR') op
// ,(select gormc.OPRN_LINE_ID
// ,crmbmc.RESOURCES
// ,crmtmc.RESOURCE_DESC
// ,gormc.PROCESS_QTY
// ,gormc.RESOURCE_USAGE
// ,gormc.RESOURCE_COUNT
// from gmd_operation_resources gormc
// ,cr_rsrc_mst_tl crmtmc
// ,cr_rsrc_mst_b crmbmc
// where gormc.RESOURCES = crmtmc.RESOURCES
// and gormc.RESOURCES = crmbmc.RESOURCES
// and crmbmc.RESOURCE_CLASS = 'MESIN') mc
// where grvr.RECIPE_ID = grb.RECIPE_ID
// and grvr.VALIDITY_RULE_STATUS = 700
// and grvr.RECIPE_USE = 0
// and grvr.END_DATE is null
// and grvr.ORGANIZATION_ID = grb.OWNER_ORGANIZATION_ID
// and grb.RECIPE_STATUS = 700
// and grvr.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
// and grvr.ORGANIZATION_ID = msib.ORGANIZATION_ID
// --and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
// and grb.FORMULA_ID = ffb.FORMULA_ID
// and grb.OWNER_ORGANIZATION_ID = ffb.OWNER_ORGANIZATION_ID
// and ffb.FORMULA_STATUS = 700
// and grb.ROUTING_ID = grtb.ROUTING_ID(+)
// and grtb.ROUTING_ID = frd.ROUTING_ID
// and grtb.OWNER_ORGANIZATION_ID = gob.OWNER_ORGANIZATION_ID
// and frd.OPRN_ID = gob.OPRN_ID
// and frd.OPRN_ID = goa.OPRN_ID
// and goa.OPRN_ID = gob.OPRN_ID
// --AND grtb.ROUTING_CLASS        = 'SHMT'
// and msib.SEGMENT1 IN ('ADA100A011AY-0')         -----------------------------------------> ISI DENGAN ITEM YANG AKAN DICARI
// and goa.OPRN_LINE_ID = mc.OPRN_LINE_ID(+)
// and goa.OPRN_LINE_ID = op.OPRN_LINE_ID(+)
// order by substr(msib.segment1,1,11)
// ,grb.RECIPE_VERSION
// ,substr(msib.segment1,1,11)||substr(msib.segment1,12,2)
// ,grb.RECIPE_NO
// ,grb.RECIPE_VERSION desc
// ,grtb.ROUTING_NO
// ,grtb.ROUTING_VERS
// ,frd.ROUTINGSTEP_NO
// ,ffb.FORMULA_NO
// ,ffb.FORMULA_VERS

}
