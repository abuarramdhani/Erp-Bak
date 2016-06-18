<?php

	class M_extention extends CI_Model {
		
		public function __construct()
		{
			parent::__construct();
		}
		
	//Menampilkan data
		public function branch()
		{
			$sql = "select * from sf.branch_extention be, sys.sys_organization so
					where be.org_id = so.org_id
					ORDER BY be.branch_extention_id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	//Menambahkan data branch
		function save_data_branch($org_id,$ext_number)
		{
			$sql = "insert into sf.branch_extention(org_id,ext_number)values('$org_id','$ext_number')";
			$query = $this->db->query($sql);
			return;			
		}
		
	//Mengedit data branch
		public function search_data_branch($branch_extention_id)
		{
			$sql = "select * from sf.branch_extention be, sys.sys_organization so where be.org_id = so.org_id
					and be.branch_extention_id = '$branch_extention_id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function data_branch()
		{
			$sql = "select * from sys.sys_organization";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function saveeditbranch($branch_extention_id,$org_id,$ext_number)
		{
			$sql = "update sf.branch_extention set org_id='$org_id',ext_number='$ext_number'
					where branch_extention_id = '$branch_extention_id'";
			$query = $this->db->query($sql);
			return;
		}
		
	//Menghapus data branch
		public function deletebranch($branch_extention_id)
		{
			$sql = "delete from sf.branch_extention where branch_extention_id = '$branch_extention_id'";
			$query = $this->db->query($sql);
			return;
		}
	}
?>