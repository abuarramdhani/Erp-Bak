<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_location extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getlocation($userid){
    	$textq = "select '226' user_id,(select b.location_code from sys.sys_user a inner join er.er_employee_all b on a.employee_id = b.employee_id where a.user_id = '$userid') location_code;";
    	$query = $this->db->query($textq);
    	return $query->result_array();
    }

}
?>