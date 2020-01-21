<?php
class M_loginApi extends CI_Model {

        public function __construct()
        {
        $this->load->database();
	$this->load->library('encrypt');
        }

        function loginApi($usr)
        {
        $sql = "
                select sys.user_password from sys.sys_user as sys
                left join er.er_employee_all as er on upper(trim(sys.user_name)) = upper(trim(er.employee_code))
                where sys.user_name = upper(trim('$usr'))
                and er.resign = 0
                ";
        $query = $this->db->query($sql);
        $row = $query->num_rows();
                if($row == 1){
                        return true;
                }else{
                        return false;
                }
        }

}