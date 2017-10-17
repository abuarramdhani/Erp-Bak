<?php
class M_groupsection extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function getRegisteredUser($id = FALSE)
	{
		if ($id === FALSE){
  		$this->db->select('su.user_id, eea.employee_code, eea.employee_name');
  		$this->db->from('er.er_employee_all eea, sys.sys_user su');
      $this->db->where('eea.employee_id = su.employee_id');
  		$this->db->order_by('eea.employee_code', 'ASC');
   		$query = $this->db->get();
   	}else{
   		$query = $this->db->get_where('sys.sys_user', array('user_id' => $id));
   	}
   	return $query->result_array();
  }

  public function getPpSection()
  {
    $this->db->select('*');
    $this->db->from('pp.pp_section');
    $this->db->order_by('section_name', 'ASC');

    $query = $this->db->get();
    return $query->result_array();
  }

  public function saveUser($dataUser)
  {
    $this->db->insert('pp.pp_user', $dataUser);

    $last_insert_id = $this->db->insert_id();
    return $last_insert_id;
  }

  public function saveGroup($data)
  {
    $this->db->insert('pp.pp_user_group', $data);
  }

  public function getUserGroup($id = FALSE)
  {
    if ($id == FALSE) {
      $sql = "SELECT pu.pp_user_id,
                eea.employee_code,
                su.user_name,
                eea.employee_name
              FROM pp.pp_user pu,
                sys.sys_user su,
                ER.er_employee_all eea
              WHERE su.user_id = pu.user_id AND eea.employee_id = su.employee_id";
    }else{
      $sql = "SELECT pu.pp_user_id,
                eea.employee_code,
                su.user_name,
                su.user_id,
                eea.employee_name
              FROM pp.pp_user pu,
                sys.sys_user su,
                ER.er_employee_all eea
              WHERE su.user_id = pu.user_id AND eea.employee_id = su.employee_id
                AND pu.pp_user_id = $id
              ";
    }
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getSectionGroup()
  {
    $this->db->select('pu.pp_user_id, ps.section_id, ps.section_name, pug.section_group_id');
    $this->db->from('pp.pp_user pu, pp.pp_section ps, pp.pp_user_group pug');
    $this->db->where('pu.pp_user_id = pug.pp_user_id AND pug.section_id = ps.section_id');
    $this->db->order_by('ps.section_name', 'ASC');

    $query = $this->db->get();
    return $query->result_array();
  }
}