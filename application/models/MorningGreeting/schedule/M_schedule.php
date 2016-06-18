<?php

	class M_schedule extends CI_Model {
		
		public function __construct()
		{
			parent::__construct();
		}
		
	//Menampilkan data
		public function schedule()
		{
			$sql = "select * from sf.morning_greeting_schedule s, sf.relation r, sys.sys_organization o
					where s.org_id = o.org_id and s.relation_id = r.relation_id
					order by s.schedule_id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	//Menambahkan data schedule
		function save_data_schedule($schedule_description,$day,$org_id,$relation_id)
		{
			$sql = "insert into sf.morning_greeting_schedule(schedule_description,day,org_id,relation_id)
					values('$schedule_description','$day','$org_id','$relation_id')";
			$query = $this->db->query($sql);
			return;			
		}
		
		function data_relation()
		{
			$sql = "select * from sf.relation sr, sys.sys_area_city_regency cr, sys.sys_organization so
					WHERE sr.org_id = so.org_id and cr.city_regency_id = sr.city
					ORDER BY sr.relation_name asc";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
	//Mengedit data schedule
		public function search_data_schedule($schedule_id)
		{
			$sql = "select * from sf.morning_greeting_schedule where schedule_id = '$schedule_id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function data_branch()
		{
			$sql = "select * from sys.sys_organization";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function saveeditschedule($schedule_id,$schedule_description,$day,$org_id,$relation_id)
		{
			$sql = "update sf.morning_greeting_schedule set schedule_description='$schedule_description',
															day='$day', org_id='$org_id',
															relation_id='$relation_id'
					where schedule_id = '$schedule_id'";
			$query = $this->db->query($sql);
			return;
		}
		
	//Menghapus data schedule
		public function deleteschedule($schedule_id)
		{
			$sql = "delete from sf.morning_greeting_schedule where schedule_id = '$schedule_id'";
			$query = $this->db->query($sql);
			return;
		}
	}
?>