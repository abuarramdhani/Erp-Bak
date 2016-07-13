<?php
class M_province extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
        }
		
		public function getProvince($id = FALSE)
		{		
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('dll.dll_indonesian_provinces');					
						$this->db->order_by('province_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$query = $this->db->get_where('dll.dll_indonesian_provinces', array('dll_indonesian_provinces' => $id));
						return $query->result_array();
				}
		}
		
		public function getCustomerGroupMember($id = FALSE)
		{		
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_group');					
						$this->db->order_by('customer_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$query = $this->db->get_where('cr.vi_cr_customer_group', array('customer_group_id' => $id));
						return $query->result_array();
				}
		}
		
		public function postUpdate($data, $id)
		{		$this->load->helper('url');
				$this->db->where('customer_group_id',$id);
				$this->db->update('cr.cr_customer_group', $data); 

		}
		
		public function setCustomerGroup($data)
		{
			$this->load->helper('url');

			//$slug = url_title($this->input->post('title'), 'dash', TRUE);

			return $this->db->insert('cr.cr_customer_group', $data);
		}
		
		public function getAllProvince()
		{
			$sql = "select * from dll.dll_indonesian_provinces";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getAllProvinceArea($id = FALSE)
		{	
			if($id===FALSE){
				$sql = "select * from dll.dll_province order by province_name";
			}else{
				$sql = "select * from dll.dll_province where province_id in ($id) order by province_name;";
			}
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getAllRegencyArea($id)
		{
			$sql = "select * from dll.dll_city_regency where province_id='$id' order by regency_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getAllDistrictArea($id)
		{
			$sql = "select * from dll.dll_district where city_regency_id='$id' order by district_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getAllVillageArea($dis_id)
		{
			$sql = "select * from dll.dll_village where district_id='$dis_id' order by village_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getRegencyByProvince($id)
		{	if($id===FALSE){
				$sql = "select * from dll.dll_city_regency order by regency_name";
			}else{
				$sql = "select * from dll.dll_city_regency where province_id in ($id) order by regency_name";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getRegencyByRegencyProvince($id)
		{	if($id===FALSE){
				$sql = "select * from dll.dll_city_regency
						union
						select * from dll.dll_city_regency order by province_id";
			}else{
				$sql = "select * from dll.dll_city_regency where province_id in ($id)
						union
						select * from dll.dll_city_regency where city_regency_id in ($id) order by province_id";
									}
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getRegencyAndProvince($id)
		{	if($id===FALSE){
				$sql = "select province_id,province_name from dll.dll_province
						union
						select city_regency_id ,regency_name from dll.dll_city_regency order by province_name";
			}else{
				$sql = "select province_id,province_name from dll.dll_province where province_id in ($id)
						union
						select city_regency_id ,regency_name from dll.dll_city_regency where city_regency_id in ($id) order by province_name";
									}
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getRegencies($id)
		{	if($id===FALSE){
				$sql = "select * from dll.dll_city_regency order by regency_name";
			}else{
				$sql = "select * from dll.dll_city_regency where city_regency_id in ($id) order by regency_name";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getDistrictByRegency($id)
		{
			$sql = "select * from dll.dll_district where city_regency_id='$id' order by district_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function getVillageByDistrict($dis_id){
			$sql = "select * from dll.dll_village where district_id='$dis_id' order by village_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getProvByName($id){
			$sql="select * from dll.dll_indonesian_area_all where area_level='1' and area_name='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getRegByName($prov_id,$reg_id){
			$sql="select * from dll.dll_indonesian_area_all where area_level='2' and province_id='$prov_id' and area_name='$reg_id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getDisByName($prov_id,$reg_id,$dis_id){
			$sql="select * from dll.dll_indonesian_area_all where area_level='3' and province_id='$prov_id' and city_id='$reg_id' and area_name='$dis_id'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getVilByName($prov_id,$reg_id,$dis_id,$vil_id){
			$sql="select * from dll.dll_indonesian_area_all where area_level='4' and province_id='$prov_id' and city_id='$reg_id' and district_id='$dis_id' and area_name='$vil_id'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		
		public function getProvinceById($id){
			$sql="select * from dll.dll_province where province_id='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getCityById($prov_id,$city_id){
			$sql="select * from dll.dll_indonesian_area_all where area_level='2'  and province_id='$prov_id' and city_id='$city_id'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getDistrictById($prov_id,$city_id,$district_id){
			$sql="select * from dll.dll_indonesian_area_all where area_level='3' and province_id='$prov_id' and city_id='$city_id' and district_id='$district_id'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getVillageById($prov_id,$city_id,$district_id,$village_id){
			$sql="select * from dll.dll_indonesian_area_all where area_level='4' and province_id='$prov_id' and city_id='$city_id' and district_id='$district_id' and village_id='$village_id'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		

		
}