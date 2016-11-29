<?php

	class M_config extends CI_Model {
		
		public function __construct()
		{
			parent::__construct();
		}

		public function config()
		{
			$sql = "select * from sf.morning_greeting_config";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function search_data_config($parameter)
		{
			$sql = "select * from sf.morning_greeting_config where parameter = '$parameter'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	
		public function saveconfig($parameter,$value)
		{
			$sql = "update sf.morning_greeting_config set parameter='$parameter',value='$value' where parameter='$parameter' or value='$value'";
			$query = $this->db->query($sql);
			return;
		}

	}
?>