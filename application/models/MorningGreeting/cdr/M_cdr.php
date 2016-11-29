<?php

	class M_cdr extends CI_Model {
		
		public function __construct()
		{
			parent::__construct();
		}

		public function cdr()
		{
			$sql = "select * from sf.morning_greeting_cdr";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	}
?>