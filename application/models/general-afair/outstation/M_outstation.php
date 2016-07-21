<?php
class M_outstation extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function select_employee($employee_id){
		$sql="select * from er.er_employee_all emp, er.er_section sec where emp.section_code = sec.section_code AND emp.employee_id = '$employee_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}
?>