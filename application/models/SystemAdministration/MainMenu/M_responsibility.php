<?php
class M_responsibility extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
		$this->load->library('encrypt');
		$this->load->helper('url');
		$this->load->library('session');
	}

	public function getResponsibility($user_group_menu_id = FALSE)
	{
		if ($user_group_menu_id === FALSE) {
			$sql = "select * from sys.vi_sys_user_group_menu order by user_group_menu_name";
		} else {
			$sql = "select * from sys.vi_sys_user_group_menu  where user_group_menu_id=$user_group_menu_id
						order by user_group_menu_name";
		}

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function setResponsibility($data)
	{
		return $this->db->insert('sys.sys_user_group_menu', $data);
	}

	public function updateResponsibility($data, $menu_id)
	{
		$this->db->where('user_group_menu_id', $menu_id);
		$this->db->update('sys.sys_user_group_menu', $data);
	}
}
