<?php

	class M_relation extends CI_Model {
		
		public function __construct()
		{
			parent::__construct();
		}

	//Menampilkan data relation
		public function relation()
		{
			$sql = "select *,(select string_agg(cn.contact_number,', ')
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
		
		public function province()
		{
			$sql = "select * from sys.sys_area_province";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function data_city($pr_id)
		{
			$sql = "select * from sys.sys_area_city_regency where province_id='$pr_id' order by regency_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
	//Mengedit data relation
		public function search_data_relation($relation_id)
		{
			$sql = "select *
					from sf.relation sr, sys.sys_area_city_regency sc, sys.sys_area_province sp
					where sr.city = sc.city_regency_id AND sp.province_id = sc.province_id AND sr.relation_id = '$relation_id'";
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
		
/*		public function getRelation($id = FALSE,$jenis=FALSE)
		{		//$id = str_replace("~", " ", $id);
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer');
						//$this->db->where('end_date', NULL);						
						$this->db->order_by('customer_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{						
						if($jenis == 'INTEGER')
						{
							/*$this->db->select('*');
							$this->db->from('cr.vi_cr_customer');
							//$this->db->like('upper(customer_name)', $id);
							$this->db->where_in('customer_id', $id);
							$this->db->order_by('customer_name', 'ASC');
							$sql = "select * from cr.vi_cr_customer where customer_id in ($id) order by customer_name asc";
							
							$query = $this->db->query($sql);
							return $query->result_array();
						}
						else{
							$this->db->select('*');
							$this->db->from('cr.vi_cr_customer');
							$this->db->like('upper(customer_name)', $id);
							//$this->db->or_like('customer_id', $id);
							$this->db->order_by('customer_name', 'ASC');
							
							$query = $this->db->get();
							return $query->result_array();
						}
						
				}
		}*/

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