<?php
class M_province extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
        }
		
		public function getAllProvinceArea($id = FALSE)
		{	
			if($id===FALSE){
				$sql = "select * from sys.sys_area_province order by province_name";
			}else{
				$sql = "select * from sys.sys_area_province where province_id in ($id) order by province_name;";
			}
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getAllRegencyArea($id)
		{
			$sql = "select * from sys.sys_area_city_regency where province_id='$id' order by regency_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getAllDistrictArea($id)
		{
			$sql = "select * from sys.sys_area_district where city_regency_id='$id' order by district_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getAllVillageArea($dis_id)
		{
			$sql = "select * from sys.sys_area_village where district_id='$dis_id' order by village_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getRegencyByProvince($id)
		{	if($id===FALSE){
				$sql = "select * from sys.sys_area_city_regency order by regency_name";
			}else{
				$sql = "select * from sys.sys_area_city_regency where province_id in ($id) order by regency_name";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getRegencyByRegencyProvince($id)
		{	if($id===FALSE){
				$sql = "select * from sys.sys_area_city_regency
						union
						select * from sys.sys_area_city_regency order by province_id";
			}else{
				$sql = "select * from sys.sys_area_city_regency where province_id in ($id)
						union
						select * from sys.sys_area_city_regency where city_regency_id in ($id) order by province_id";
									}
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getRegencyAndProvince($id)
		{	if($id===FALSE){
				$sql = "select province_id,province_name from sys.sys_area_province
						union
						select city_regency_id ,regency_name from sys.sys_area_city_regency order by province_name";
			}else{
				$sql = "select province_id,province_name from sys.sys_area_province where province_id in ($id)
						union
						select city_regency_id ,regency_name from sys.sys_area_city_regency where city_regency_id in ($id) order by province_name";
									}
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getRegencies($id)
		{	if($id===FALSE){
				$sql = "select * from sys.sys_area_city_regency order by regency_name";
			}else{
				$sql = "select * from sys.sys_area_city_regency where city_regency_id in ($id) order by regency_name";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getDistrictByRegency($id)
		{
			$sql = "select * from sys.sys_area_district where city_regency_id='$id' order by district_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function getVillageByDistrict($dis_id){
			$sql = "select * from sys.sys_area_village where district_id='$dis_id' order by village_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
				
		public function getProvinceById($id){
			$sql="select * from sys.sys_area_province where province_id='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
}