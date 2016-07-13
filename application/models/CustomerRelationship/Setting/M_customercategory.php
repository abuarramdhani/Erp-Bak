<?php
class M_CustomerCategory extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
        }
		
		public function getCustomerCategory($id = FALSE)
		{		
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.cr_customer_category');					
						$this->db->order_by('customer_category_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$query = $this->db->get_where('cr.cr_customer_category', array('customer_category_id' => $id));
						return $query->result_array();
				}
		}
		
		public function getCustomerCategoryActive($id = FALSE)
		{		
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.cr_customer_category');	
						$this->db->where('end_date', NULL);	
						$this->db->order_by('customer_category_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.cr_customer_category');	
						$this->db->where('end_date', NULL);	
						$this->db->where('customer_category_id', $id);	
						$this->db->order_by('customer_category_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getCustomerCategoryName($id = FALSE)
		{		
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.cr_customer_category');					
						$this->db->order_by('customer_category_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.cr_customer_category');	
						$this->db->like('upper(customer_category_name)',$id);
						$this->db->order_by('customer_category_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function postUpdate($data, $id)
		{		$this->load->helper('url');
				$this->db->where('customer_category_id',$id);
				$this->db->update('cr.cr_customer_category', $data); 

		}
		
		public function setCustomerCategory($data)
		{
			$this->load->helper('url');

			//$slug = url_title($this->input->post('title'), 'dash', TRUE);

			return $this->db->insert('cr.cr_customer_category', $data);
		}
		
		public function getAllCategory($cust_id=FALSE,$relation_id=FALSE)
		{
			if($cust_id===FALSE){
				$sql ="select * from cr.cr_customer_category where end_date is NULL";
			}else{
				if($relation_id===FALSE){
				$sql ="select * from cr.cr_customer_category where end_date is NULL and customer_category_id not in 
					(select coalesce(category_id,0) from  cr.cr_customer_relation_detail where end_date is NULL and customer_id = $cust_id)";
				}else{
					$sql ="select * from cr.cr_customer_category where customer_category_id=
						(select category_id from cr.cr_customer_relation_detail where end_date is null and relation_id=$relation_id)
							UNION ALL
						select * from cr.cr_customer_category where end_date is NULL and customer_category_id not in 
						(select coalesce(category_id,0) from  cr.cr_customer_relation_detail where end_date is NULL and customer_id = $cust_id)";
				}
			}
			
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getCustomerCategoryByKey($id){
			$sql = "select * from cr.cr_customer_category where upper(customer_category_name) like '%$id%' order by customer_category_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getCustomerCategoryDriver($id=15){
			$sql = "select driver from cr.cr_customer_category where customer_category_id = $id order by customer_category_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
}