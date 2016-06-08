<?php
class M_customer extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
        }
		
		public function getCustomer($id = FALSE,$jenis=FALSE)
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
							$this->db->order_by('customer_name', 'ASC');*/
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
		}
		
		public function getCustomerActive($id = FALSE,$jenis=FALSE)
		{		//$id = str_replace("~", " ", $id);
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer');
						$this->db->where('end_date', NULL);						
						$this->db->order_by('customer_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{						
						if($jenis == 'INTEGER')
						{
							$this->db->select('*');
							$this->db->from('cr.vi_cr_customer');
							//$this->db->like('upper(customer_name)', $id);
							$this->db->where('end_date', NULL);	
							$this->db->where('customer_id', $id);
							$this->db->order_by('customer_name', 'ASC');
						}
						else{
							$this->db->select('*');
							$this->db->from('cr.vi_cr_customer');
							$this->db->where('end_date', NULL);	
							$this->db->like('upper(customer_name)', $id);
							//$this->db->or_like('customer_id', $id);
							$this->db->order_by('customer_name', 'ASC');
						}
						
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getCustomerId()
		{							
						$this->db->select('customer_id');
						$this->db->from('cr.vi_cr_customer');
						$this->db->limit(1);
						//$this->db->or_like('customer_id', $id);
						$this->db->order_by('customer_id', 'DESC');

						$query = $this->db->get();
						return $query->result_array();
				
		}
		
		public function getCustomerDriver($id = FALSE)
		{							
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer');
						$this->db->where('driver', 'Y');
						$this->db->where('end_date', NULL);	
						$this->db->like('upper(customer_name)', $id);
						$this->db->order_by('customer_name', 'ASC');

						$query = $this->db->get();
						return $query->result_array();
				
		}
		
		public function getCustomerOwner($id = FALSE)
		{					
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer');
						$this->db->where('owner', 'Y');
						$this->db->where('end_date', NULL);	
						$this->db->order_by('customer_name', 'ASC');

						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer');
						$this->db->where('owner', 'Y');
						$this->db->where('end_date', NULL);	
						$this->db->like('upper(customer_name)', $id);
						$this->db->order_by('customer_name', 'ASC');

						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		
		public function getCustomerSite($id = FALSE)
		{		//$id = str_replace("~", " ", $id);
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_site');					
						$this->db->order_by('site_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_site');
						$this->db->where('customer_id', $id);
						$this->db->order_by('site_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		public function getCustomerSiteDetails($id = FALSE)
		{		//$id = str_replace("~", " ", $id);
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.cr_customer_site');					
						$this->db->order_by('site_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.cr_customer_site');
						$this->db->where('customer_site_id', $id);
						$this->db->order_by('site_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function postUpdate($data, $id)
		{		$this->load->helper('url');
				$this->db->where('customer_id',$id);
				$this->db->update('cr.cr_customers', $data); 
		}
		
		public function postUpdateGroup($data, $id_cust)
		{		$this->load->helper('url');
				$this->db->where('customer_id',$id_cust);
				$this->db->update('cr.cr_customers', $data); 
		}
		
		public function postUpdateSite($data, $id)
		{		$this->load->helper('url');
				$this->db->where('customer_site_id',$id);
				$this->db->update('cr.cr_customer_site', $data);
		}
		
		public function setCustomer($data)
		{
			$this->load->helper('url');

			//$slug = url_title($this->input->post('title'), 'dash', TRUE);

			return $this->db->insert('cr.cr_customers', $data);
		}
		
		public function setCustomerSite($data)
		{
			$this->load->helper('url');

			//$slug = url_title($this->input->post('title'), 'dash', TRUE);

			return $this->db->insert('cr.cr_customer_site', $data);
		}
		
		public function getCustomerSearch($name,$village,$city,$category)
		{	
			if(($name == null) and ($village == null) and ($city == null) and ($category == null)){
				$condition = "";
				
			}else{
				$condition = "where";
			}
			
			if($name == null){
				$a = "";
			}else{
				$a = "upper(customer_name) like '%$name%'";
			}
			
			if($village == null){
				$b = "";
				$p1 = "";
			}else{
				$b = "upper(village) like '%$village%'";
				if($name == null){
					$p1 = "";
				}else{
					$p1 = "and";
				}
			}
			
			if($city == null){
				$c = "";
				$p2 = "";
			}else{
				$c = "upper(city_regency) like '%$city%'";
				if(($name == null) and ($village == null)){
					$p2 = "";
				}else{
					$p2 = "and";
				}
			}
			
			if($category == null){
				$d = "";
				$p3 = "";
			}else{
				$d = "customer_category_id = '$category'";
				if(($name == null) and ($village == null) and ($city == null)){
					$p3 = "";
				}else{
					$p3 = "and";
				}
			}
			
			
			
			$sql = "select * from cr.vi_cr_customer $condition $a $p1 $b $p2 $c $p3 $d order by customer_name asc";
			
			$query = $this->db->query($sql);
			return $query->result_array();
			
				
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
		
}