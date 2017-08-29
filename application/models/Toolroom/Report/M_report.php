<?php
class M_report extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
				$this->load->library('session');
        }
		
		public function getShift(){
			$personalia = $this->load->database("personalia",true);
			$sql = "select * from \"Presensi\".tshiftpekerja";
			$query = $personalia->query($sql);
			return $query->result_array();
		}
		
		
}