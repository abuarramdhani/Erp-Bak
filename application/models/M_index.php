<?php
class M_index extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
        }
		
		 function login($usr, $pwd)
		{
          $sql = "select * from sys.sys_user where user_name = '" . $usr . "' and user_password = '" . $pwd . "'";
          $query = $this->db->query($sql);
          $row = $query->num_rows();
		  if($row == 1){
			  return true;
		  }else{
			  return false;
		  }
		}
		
		function getDetail($usr)
		{
          $sql = "	select 	su.*,
          					er.section_code,
          					er.employee_name
          	 		from 	sys.sys_user as su
							join 	er.er_employee_all as er
									on 	er.employee_id=su.employee_id
					where 	user_name = '" . $usr . "'";
          $query = $this->db->query($sql);
		  return $query->result();
		}
	
		
		
		
		

		
}