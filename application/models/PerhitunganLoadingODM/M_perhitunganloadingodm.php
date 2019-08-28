<?php defined('BASEPATH') or die('No direct script access allowed');
class M_PerhitunganLoadingODM extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
    }
    function depclass($data)
	{
        $sql = "SELECT distinct bd.DEPARTMENT_CLASS_CODE
        from bom_departments bd
        order by bd.DEPARTMENT_CLASS_CODE";
        $query = $this->db->query($sql);
        return $query->result_array();
	}
}