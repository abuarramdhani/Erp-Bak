<?php defined('BASEPATH') OR die('No direct script access allowed');
class M_master extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	  $this->oracle = $this->load->database('oracle',TRUE);
	}

	function getShift($date=FALSE)
	{
		if ($date === FALSE) {
			$date = date('Y/m/d');
		}
		return $this->oracle->query("SELECT BCS.SHIFT_NUM,BCS.DESCRIPTION
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
																  ORDER BY BCS.SHIFT_NUM asc")->result_array();
	}

}
