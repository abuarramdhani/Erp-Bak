<?php
class M_menugroup extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
				$this->load->library('session');
        }
		
		public function getMenuGroup($menu_group_id=FALSE)
		{	if($menu_group_id === FALSE){
				$sql = "select *, 
						(select count(*) from  sys.sys_menu_group_list smgl where smg.group_menu_id = smgl.group_menu_id) menu
						from sys.sys_menu_group smg order by coalesce(last_update_date,creation_date) desc nulls last";
			}else{
				$sql = "select * from sys.sys_menu_group  where menu_group_id=$menu_group_id";
			}						
			
			$query = $this->db->query($sql);
			return $query->result_array();
				
		}
		 
		public function getMenuGroupList($menu_group_id=FALSE,$menu_group_list_id=FALSE)
		{	if($menu_group_list_id === FALSE){
				$and1 = "";
			}else{
				$and1 = "AND menu_group_list_id = $menu_group_list_id";
			}
			if($menu_group_id === FALSE){
				$sql = "select * from sys.sys_menu_group_list order by coalesce(last_update_date,creation_date) desc nulls last";
			}else{
				$sql = "select * from sys.sys_menu_group_list  where menu_group_id=$menu_group_id
						$and1";
			}						
			
			$query = $this->db->query($sql);
			return $query->result_array();
				
		}
		 
		public function setMenuGroup($data)
		{
			return $this->db->insert('sys.sys_menu_group', $data);
		}
		
		public function setMenuGroupList($data)
		{
			return $this->db->insert('sys.sys_menu_group_list', $data);
		}
		
		public function updateMenuGroupList($data, $menu_group_list_id)
		{		
				$this->db->where('menu_group_list_id',$menu_group_list_id);
				$this->db->update('sys.sys_menu_group_list', $data); 

		}
		
		
		
}