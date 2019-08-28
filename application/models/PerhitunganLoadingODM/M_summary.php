<?php defined('BASEPATH') or die('No direct script access allowed');
class M_summary extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->load->library('csvimport');
        $this->oracle = $this->load->database('oracle',true);
    }

    function viewdata($deptclass,$deptcode,$monthPeriode2){
		$sql="SELECT * from KHS_TAMPUNG_LOAD_ODM 
        WHERE DEPARTMENT_CLASS='$deptclass' 
        AND RESOURCES='$deptcode' 
        AND PERIODE='$monthPeriode2'";
		$query=$this->oracle->query($sql);
		// return($sql);
		return $query->result_array();
	}

}