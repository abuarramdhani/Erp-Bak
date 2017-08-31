<?php
class M_dataplan extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function getDataPlan($id = FALSE)
	{
		if ($id === FALSE){
      		$this->db->select('*');
      		$this->db->from('pp.pp_daily_plans');
      		$this->db->order_by('priority, created_date', 'ASC');
          $query = $this->db->get();
        }else{
          $this->db->select('*');
          $this->db->from('pp.pp_daily_plans');
          $this->db->where('section_id', $id);
          $this->db->order_by('priority, created_date', 'ASC');
       		$query = $this->db->get();
       	}
       	return $query->result_array();
    }

    public function getSection($id = FALSE, $section_id = FALSE)
    {
    	if ($id == FALSE) {
    		$this->db->select('*');
      	$this->db->from('pp.pp_section');
      	$this->db->order_by('section_id', 'ASC');
    	}elseif ($section_id == FALSE) {
    		$this->db->select('ps.*');
      	$this->db->from('pp.pp_section ps, pp.pp_user_group pug, pp.pp_user pu');
        $this->db->where('ps.section_id = pug.section_id AND pug.pp_user_id = pu.pp_user_id');
      	$this->db->where('pu.user_id', $id);
      	$this->db->order_by('ps.section_name', 'ASC');
    	}else{
        $this->db->select('ps.*');
        $this->db->from('pp.pp_section ps, pp.pp_user_group pug, pp.pp_user pu');
        $this->db->where('ps.section_id = pug.section_id AND pug.pp_user_id = pu.pp_user_id');
        $this->db->where('pu.user_id', $id);
        $this->db->where('ps.section_id', $section_id);
        $this->db->order_by('ps.section_name', 'ASC');
      }
    	$query = $this->db->get();
      return $query->result_array();
    }

    public function insertDataPlan($dataIns)
    {
      $this->db->insert('pp.pp_daily_plans', $dataIns);
    }

    // public function getPlanMonthly()
    // {
    //   $sql = "SELECT
    //             to_char(dp.created_date, 'dd') as date,
    //             to_char(dp.created_date, 'Mon') as mon,
    //             extract(year from dp.created_date) as yyyy,
    //             count(*) as plan
    //           FROM pp.pp_daily_plans dp
    //           WHERE dp.section_id = 9
    //           GROUP BY 1,2,3";
              
    //   $query = $this->db->query($sql);
    //   return $query->result_array();
    // }
}