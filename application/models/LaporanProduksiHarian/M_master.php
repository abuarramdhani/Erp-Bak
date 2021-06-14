<?php defined('BASEPATH') OR die('No direct script access allowed');
class M_master extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	  $this->oracle = $this->load->database('oracle',TRUE);
		$this->lantuma = $this->load->database('lantuma', TRUE);
	}

	function kodePart($variable, $product) // dari TSKK 
	{
	$where_product = '';
	if (!empty($product)) {
		$where_product .= "AND NVL (ffvt.description, '000') in";
		$where_product .= '(\''.implode('\',\'',$product).'\')';
	}

	// $sql="SELECT msib.segment1
	//      ,msib.description
	//      from mtl_system_items_b msib
	//      where msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
	//      and msib.organization_id = 81
	//      AND (msib.DESCRIPTION LIKE '%$variable%'
	//    OR msib.SEGMENT1 LIKE '%$variable%')";

	$sql = "SELECT msib.segment1, msib.description
							FROM fnd_flex_values ffv, fnd_flex_values_tl ffvt,
									 mtl_system_items_b msib
						 WHERE ffv.flex_value_set_id = 1013710
							 AND ffv.flex_value_id = ffvt.flex_value_id
							 AND ffv.end_date_active IS NULL
							 AND ffv.summary_flag = 'N'
							 AND ffv.enabled_flag = 'Y'
							 AND ffv.flex_value = SUBSTR (msib.segment1, 1, 3)
							 AND (msib.DESCRIPTION LIKE '%$variable%'
										OR msib.SEGMENT1 LIKE '%$variable%')
							 $where_product
							 AND msib.organization_id = 81
							 AND msib.inventory_item_status_code = 'Active'
					ORDER BY 1";

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
		$data = $this->db->query("SELECT *
															 FROM lph.lph_rencana_kerja_operator
															 WHERE $shift
															 AND tanggal BETWEEN '$range[0]' AND '$range[1]'")->result_array();
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

}
