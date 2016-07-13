<?php
class M_user extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
				$this->load->library('session');
        }
		
		public function getUser($user_id=FALSE)
		{	if($user_id === FALSE){
				$sql = "select * from sys.vi_sys_user";
			}else{
				$sql = "select * from sys.vi_sys_user  where user_id=$user_id";
			}						
			
			$query = $this->db->query($sql);
			return $query->result_array();
				
		}
		 
		public function checkUser($user,$pwd)
		{							
			$sql = "select * from sys.sys_user where user_name = '$usr' and user_password = '$pwd'";
			$query = $this->db->query($sql);
			return $query->result_array();
				
		}
		 
		public function setUser($data)
		{
			

			//$slug = url_title($this->input->post('title'), 'dash', TRUE);

			return $this->db->insert('sys.sys_user', $data);
		}
		
		public function updateUser($data, $user_id)
		{		
				$this->db->where('user_id',$user_id);
				$this->db->update('sys.sys_user', $data); 

		}
		
		public function getCustomerByName($id){
			$sql="select * from cr.vi_cr_customer where upper(customer_name) like '%$id%' order by customer_name limit 50";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getOwnerByName($id){
			$sql="select * from cr.vi_cr_customer where owner='Y' and upper(customer_name) like '%$id%' order by customer_name limit 50";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getCustomerNoGroup($id) {
			$sql="select cust.* from cr.vi_cr_customer cust where upper(cust.customer_name) like '%$id%' and cust.customer_id not in (select cust_group.customer_id from cr.vi_cr_customer_group_customers cust_group)order by cust.customer_name limit 50";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getUserResponsibility($user_id=FALSE,$responsbility_id="")
		{	
			if($responsbility_id==""){
				$and = "";
			}else{
				$and = "AND sugm.user_group_menu_id = $responsbility_id";
			}
			
			$sql = "SELECT su.user_id,sugm.user_group_menu_id, sugm.user_group_menu_name, smod.module_name,smod.module_link
					FROM sys.sys_user su,
					sys.sys_user_application sua,
					sys.sys_user_group_menu sugm,
					sys.sys_module smod
					WHERE 
					1 = 1
					AND su.user_id = sua.user_id
					AND sua.user_group_menu_id = sugm.user_group_menu_id
					AND smod.module_id= sugm.module_id
					AND su.user_id=$user_id
					$and
					order by sugm.user_group_menu_name;
					";					
			
			$query = $this->db->query($sql);
			return $query->result_array();
				
		}
		
		public function getUserReport($report_name=FALSE,$responsbility_id="",$user_id="")
		{	
			if($responsbility_id==""){
				$and = "";
			}else{
				$and = "AND sugm.user_group_menu_id = $responsbility_id";
			}
			
			$sql = "SELECT su.user_id, sugm.user_group_menu_name, sugm.user_group_menu_id,
					sr.report_id,sr.report_name,sr.report_link
					FROM sys.sys_user su,
					sys.sys_user_application sua,
					sys.sys_user_group_menu sugm,
					sys.sys_report sr,
					sys.sys_report_group_list srgl
					WHERE 
					1 = 1
					AND su.user_id = sua.user_id
					AND sua.user_group_menu_id = sugm.user_group_menu_id
					AND srgl.report_group_id = sugm.report_group_id
					AND sr.report_id = srgl.report_id
					AND upper(sr.report_name) like '%$report_name%'
					AND su.user_id = $user_id
					$and
					ORDER BY sugm.user_group_menu_name,sr.report_name
					limit 50;
					";					
			
			$query = $this->db->query($sql);
			return $query->result_array();
				
		}
		
		public function getUserMenu($user_id=FALSE,$user_group_menu_id="")
		{	if($user_group_menu_id==""){
				$and = "";
			}else{
				$and = "AND sugm.user_group_menu_id = $user_group_menu_id";
			}
				
				$sql = "SELECT su.user_id, sugm.user_group_menu_name,sugm.user_group_menu_id,smgl.menu_sequence,
						sm.menu_id,smgl.root_id,sm.menu_title,sm.menu_link
						FROM sys.sys_user su,
						sys.sys_user_application sua,
						sys.sys_user_group_menu sugm,
						sys.sys_menu sm,
						sys.sys_menu_group_list smgl
						WHERE 
						1 = 1
						AND su.user_id = sua.user_id
						AND sua.user_group_menu_id = sugm.user_group_menu_id
						AND smgl.group_menu_id = sugm.group_menu_id
						AND sm.menu_id = smgl.menu_id
						AND su.user_id=$user_id
						$and
						AND smgl.menu_level = 1
						ORDER BY sugm.user_group_menu_name,smgl.menu_level,smgl.menu_sequence
						";					
			
			$query = $this->db->query($sql);
			return $query->result_array();
				
		}
		
		public function getMenuLv2($user_id=FALSE,$user_group_menu_id="")
		{	if($user_group_menu_id==""){
				$and = "";
			}else{
				$and = "AND sugm.user_group_menu_id = $user_group_menu_id";
			}	
				$sql = "SELECT su.user_id, sugm.user_group_menu_name,sugm.user_group_menu_id,smgl.menu_sequence,
						sm.menu_id,smgl.root_id,sm.menu_title,sm.menu_link
						FROM sys.sys_user su,
						sys.sys_user_application sua,
						sys.sys_user_group_menu sugm,
						sys.sys_menu sm,
						sys.sys_menu_group_list smgl
						WHERE 
						1 = 1
						AND su.user_id = sua.user_id
						AND sua.user_group_menu_id = sugm.user_group_menu_id
						AND smgl.group_menu_id = sugm.group_menu_id
						AND sm.menu_id = smgl.menu_id
						AND su.user_id=$user_id
						$and
						AND smgl.menu_level = 2
						ORDER BY sugm.user_group_menu_name,smgl.menu_level,smgl.menu_sequence
						";					
			
			$query = $this->db->query($sql);
			return $query->result_array();
				
		}
		
		public function getMenuLv3($user_id=FALSE,$user_group_menu_id="")
		{	if($user_group_menu_id==""){
				$and = "";
			}else{
				$and = "AND sugm.user_group_menu_id = $user_group_menu_id";
			}
				$sql = "SELECT su.user_id, sugm.user_group_menu_name,sugm.user_group_menu_id,smgl.menu_sequence,
						sm.menu_id,smgl.root_id,sm.menu_title,sm.menu_link
						FROM sys.sys_user su,
						sys.sys_user_application sua,
						sys.sys_user_group_menu sugm,
						sys.sys_menu sm,
						sys.sys_menu_group_list smgl
						WHERE 
						1 = 1
						AND su.user_id = sua.user_id
						AND sua.user_group_menu_id = sugm.user_group_menu_id
						AND smgl.group_menu_id = sugm.group_menu_id
						AND sm.menu_id = smgl.menu_id
						AND su.user_id=$user_id
						$and
						AND smgl.menu_level = 3
						ORDER BY sugm.user_group_menu_name,smgl.menu_level,smgl.menu_sequence
						";					
			
			$query = $this->db->query($sql);
			return $query->result_array();
				
		}
		
}