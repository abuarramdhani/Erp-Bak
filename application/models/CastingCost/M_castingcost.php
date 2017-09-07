<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_castingcost extends CI_Model
{
	public function __construct()
	    {
	        parent::__construct();
	        $this->oracle = $this->load->database('oracle', TRUE);
	        $this->db = $this->load->database('default', TRUE);
	    }



	function save($data_casting)
		{
			return $this->db->insert('co.khs_request_report_hpp',$data_casting);
		}

	function getAllRequest()
		{
			$sql ="select * from co.khs_request_report_hpp where sign_confirmation =0 order by date_submition";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function getDoneRequest()
		{
			$sql ="select * from co.khs_request_report_hpp where sign_confirmation = 1 order by id desc limit 10";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	function getRequest($id)
		{
			$sql ="select * from co.khs_request_report_hpp where id = '$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	
	function getYear()
		{
			$sql ="select distinct CALENDAR_CODE from gmf_period_statuses order by calendar_code asc";
			$query = $this->oracle->query($sql);
			return $query->result_array();
		}

	function getMaterial()
		{
			$sql ="select distinct ffm.FORMULA_NO  , ffm.FORMULA_DESC1
						from FM_FORM_MST ffm , FM_MATL_DTL fmd
						where ffm.FORMULA_ID = fmd.FORMULA_ID
						AND ffm.FORMULA_NO LIKE 'FMLT%' ";
			$query = $this->oracle->query($sql);
			return $query->result_array();
		}

	function getPeriod()
		{
			$sql ="select distinct PERIOD_CODE from gmf_period_statuses order by period_code ASC";
			$query = $this->oracle->query($sql);
			return $query->result_array();
		}
	function getCostMachine()
		{
			$sql ="select * from co.khs_cost_machine order by resource";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function getCostElectric()
		{
			$sql ="select * from co.khs_electric_cost order by resource";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function save_cost_machine($resource,$cost)
		{
			$sql = "update co.khs_cost_machine set cost = $cost where resource = '$resource'";
			$query = $this->db->query($sql);
			return;
		}

	function save_cost_electric($resource,$cost)
		{
			$sql = "update co.khs_electric_cost set cost = $cost where resource = '$resource'";
			$query = $this->db->query($sql);
			return;
		}
	function updateStatus($id,$user_name)
		{
			$sql = "update co.khs_request_report_hpp set sign_confirmation = 1 , user_confirmation = '$user_name' , date_confirmation = now() where id = '$id'";
			$query = $this->db->query($sql);
			return;
		}
}