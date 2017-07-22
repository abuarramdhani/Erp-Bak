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
      		$this->db->order_by('created_date', 'ASC');
       		$query = $this->db->get();
       	}else{
       		$query = $this->db->get_where('pp.pp_daily_plans', array('daily_plan_id' => $id));
       	}
       	return $query->result_array();
    }

    public function getSection($id = FALSE)
    {
    	if ($id == FALSE) {
    		$this->db->select('*');
      		$this->db->from('pp.pp_section');
      		$this->db->order_by('section_id', 'ASC');
    	}else{
    		$this->db->select('*');
      		$this->db->from('pp.pp_section');
      		$this->db->where('section_id', $id);
      		$this->db->order_by('section_id', 'ASC');
    	}
    	$query = $this->db->get();
       	return $query->result_array();
    }
}