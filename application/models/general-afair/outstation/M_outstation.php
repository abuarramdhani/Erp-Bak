<?php
class M_outstation extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function select_employee($employee_id){
		$sql="select * from er.er_employee_all emp left join er.er_section sec on emp.section_code = sec.section_code left join ga.ga_outstation_position pst on pst.position_id = emp.outstation_position where emp.employee_id = '$employee_id' and (emp.resign = 0 OR resign is null)";

		$query = $this->db->query($sql);
		return $query->result_array();
	}
}
?>