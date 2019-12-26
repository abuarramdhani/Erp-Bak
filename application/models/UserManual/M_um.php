<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class M_um extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->personalia   =   $this->load->database('personalia', TRUE) ;
        $this->erp          =   $this->load->database('erp_db', TRUE);
	}

	public function tabel()
	{
		$sql =  "select um.*, sm.* from um.um_manual um inner join sys.sys_user_group_menu sm on sm.module_id = um.module_id
				order by sm.user_group_menu_name asc";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function mylist($id, $keyword)
	{
		$sql = "select * from sys.sys_user_group_menu where user_group_menu_id::text like '%$keyword%' or upper(user_group_menu_name) like '%$keyword%' order by user_group_menu_id asc";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function add($res, $file, $user)
	{
		date_default_timezone_set("Asia/Bangkok");
		$tgl = date("Y-m-d");
		// echo $user; exit();
		$sql = "insert into um.um_manual (module_id, path_file, created_date, created_by, last_update)
				values ('$res', '$file', '$tgl', '$user', '$tgl')";
		$query = $this->db->query($sql);
	}

	public function delete($no)
	{
		$sql = "delete from um.um_manual where id_um = '$no'";
		$query = $this->db->query($sql);
	}

	public function ceknama($no)
	{
		$sql = "select path_file from um.um_manual where id_um = '$no'";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function edit($res, $file, $id)
	{
		date_default_timezone_set("Asia/Bangkok");
		$tgl = date("Y-m-d");
		$sql = "update um.um_manual set module_id = '$res', path_file = '$file', last_update = '$tgl'
				where id_um = '$id'";

		$query = $this->db->query($sql);
		// echo $sql; exit();
	}
}
