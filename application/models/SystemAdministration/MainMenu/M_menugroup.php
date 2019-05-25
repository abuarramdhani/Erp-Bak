<?php

class M_menugroup extends CI_Model {

	public function __construct() {
		$this->load->database();
		$this->load->library('encrypt');
		$this->load->helper('url');
		$this->load->library('session');
	}
		
	public function getMenuGroup($menu_group_id=FALSE) {
		if($menu_group_id === FALSE){
			$sql = "select *, 
					(select count(*) from  sys.sys_menu_group_list smgl where smg.group_menu_id = smgl.group_menu_id) menu
					from sys.sys_menu_group smg";
		} else {
			$sql = "select * from sys.sys_menu_group  where group_menu_id=$menu_group_id";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
		 
	public function getMenuGroupList($menu_group_id=FALSE, $menu_group_list_id=FALSE) {
		if($menu_group_list_id === FALSE) {
			$and1 = "";
		} else {
			$and1 = "AND group_menu_list_id = $menu_group_list_id";
		}
		if($menu_group_id === FALSE) {
			$sql = "select * from sys.sys_menu_group_list where 1=1 $and1 
					order by menu_sequence";
		} else {
			$sql = "select * from sys.sys_menu_group_list  where group_menu_id=$menu_group_id
					and menu_level=1 $and1 order by menu_sequence";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
		
	public function getMenuGroupListSub($menu_group_list_id=FALSE, $sub_menu_group_list_id=FALSE) {
		if($sub_menu_group_list_id === FALSE) {
			$and1 = "";
		} else {
			$and1 = "AND group_menu_list_id = $sub_menu_group_list_id";
		}
		if($menu_group_list_id === FALSE) {
			$sql = "select * from sys.sys_menu_group_list order by menu_sequence";
		} else {
			$sql = "select * from sys.sys_menu_group_list  where root_id=$menu_group_list_id
					$and1 order by menu_sequence";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
		
	public function setMenuGroup($data) {
		return $this->db->insert('sys.sys_menu_group', $data);
	}
	
	public function setMenuGroupList($data) {
		return $this->db->insert('sys.sys_menu_group_list', $data);
	}
	
	public function updateMenuGroupList($data, $menu_group_list_id) {	
		$this->db->where('group_menu_list_id', $menu_group_list_id)->update('sys.sys_menu_group_list', $data);
	}

	public function deleteMenuGroupList($group_menu_id) {
		if(empty($group_menu_id)) return false;
		$this->db->where('group_menu_id', $group_menu_id)->delete('sys.sys_menu_group_list');
		$this->db->where('group_menu_id', $group_menu_id)->delete('sys.sys_menu_group');
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	public function deleteSubMenu($group_id, $id) {
		if(empty($id) || empty($group_id)) return false;
		$this->db->where('group_menu_id', $group_id)->where('group_menu_list_id', $id)->delete('sys.sys_menu_group_list');
		return ($this->db->affected_rows() != 1) ? false : true;
	}
}