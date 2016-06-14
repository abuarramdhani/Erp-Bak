<?php

	class M_relation extends CI_Model {
		
		public function __construct()
		{
			parent::__construct();
		}

	//Menampilkan data relation
		public function relation()
		{
			$sql = "select *,(select string_agg(cn.contact_number,',')
						from sf.relation_contact_number cn
						where cn.relation_id=sr.relation_id) as contact_number from sf.relation sr, sys.sys_organization so, sys.sys_area_city_regency sc
					where sr.org_id = so.org_id and sr.city = sc.city_regency_id
					ORDER BY sr.relation_id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function relation_id_row()
		{
			$sql = "select cn.contact_number
					from sf.relation_contact_number cn, sf.relation sr, sys.sys_area_city_regency sc
					where sr.city = sc.city_regency_id and cn.relation_id =  sr.relation_id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	//Menambahkan data relation
		function save_data_relation($relation_name,$npwp,$oracle_cust_id,$city_regency_id,$org_id)
		{
			//QUERY ini menambahkan data di baris baru di tabel sf.relation
			$sql = "insert into sf.relation(relation_name,npwp,oracle_cust_id,city,org_id)
					values('$relation_name','$npwp','$oracle_cust_id','$city_regency_id','$org_id')";
			$query = $this->db->query($sql);
			
			$sql = "select lastval() as ins_id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		function save_data_relation_number($relation_name,$contact_number,$relation_id)
		{
			$sql="	INSERT INTO sf.relation_contact_number(
						relation_contact_description, contact_number, 
						relation_id
					)
					VALUES(
						'".$relation_name."','".$contact_number."', 
						'".$relation_id."'
					)";
				$query = $this->db->query($sql);
		}
		
		public function data_city()
		{
			$sql = "select * from sys.sys_area_city_regency";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
	//Mengedit data relation
		public function search_data_relation($relation_id)
		{
			$sql = "select * from sf.relation where relation_id = '$relation_id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		//Select data contact_number yang akan diedit
		public function search_data_relation_cn($relation_id)
		{
			$sql = "select contact_number from sf.relation_contact_number where relation_id = '$relation_id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function data_branch()
		{
			$sql = "select * from sys.sys_organization";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function saveeditrelation($relation_id,$relation_name,$npwp,$oracle_cust_id,$city_regency_id,$org_id)
		{
			$sql = "update sf.relation set	relation_name='$relation_name', npwp='$npwp', oracle_cust_id='$oracle_cust_id',
											city='$city_regency_id', org_id='$org_id'
					where relation_id = '$relation_id'";
			$query = $this->db->query($sql);
		}
		
		function save_edit_relation_number($relation_name,$contact_number,$relation_id)
		{
			$sql="	INSERT INTO sf.relation_contact_number(
						relation_contact_description, contact_number, 
						relation_id
					)
					VALUES(
						'".$relation_name."','".$contact_number."', 
						'".$relation_id."'
					)";
				$query = $this->db->query($sql);
		}
		
	//Menghapus data relation
		public function deleterelation($relation_id)
		{
			$sql = "delete from sf.relation where relation_id = '$relation_id'";
			$query = $this->db->query($sql);
			return;
		}
		
		public function deleterelation_contact($relation_id)
		{
			$sql = "delete from sf.relation_contact_number where relation_id = '$relation_id'";
			$query = $this->db->query($sql);
			return;
		}
	}
?>