<?php
class M_CustomerAdditional extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
        }
		
		public function getCustomerAdditional($id = FALSE)
		{		
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.cr_customer_master_additional');					
						$this->db->order_by('additional_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.cr_customer_master_additional');
						$this->db->where('additional_id', $id);
						$this->db->order_by('additional_name', 'ASC');
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getCustomerAdditionalFiltered($id = FALSE,$cust_additional_id=FALSE)
		{		//$date_today = date("Y-m-d H:i:s");
				//$this->load->helper('url');
				if ($cust_additional_id === FALSE)
				{		
						$sql="select * from cr.cr_customer_master_additional where additional_id not in(select additional_id from cr.vi_cr_customer_additional_info where customer_id = $id )";
			
				}
				else{
					$sql="select * from cr.cr_customer_master_additional where additional_id = 
							(select additional_id from cr.vi_cr_customer_additional_info where cust_additional_id=$cust_additional_id)
								UNION ALL
							select * from cr.cr_customer_master_additional ccma where 
							ccma.additional_id not in(select COALESCE(vccai.additional_id,99999) from cr.vi_cr_customer_additional_info vccai where vccai.customer_id = $id )
							";
				}
				$query = $this->db->query($sql);
				return $query->result_array();
		}
		/* 
		public function getCustomerAdditionalId($id = FALSE)
		{		
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.cr_customer_master_additional');					
						$this->db->order_by('additional_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.cr_customer_master_additional');
						$this->db->where('additional_id', $id);
						$this->db->order_by('additional_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
		} */
		
		public function getCustomerAdditionalName($id = FALSE)
		{		
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.cr_customer_master_additional');					
						$this->db->order_by('additional_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.cr_customer_master_additional');
						$this->db->like('upper(additional_name)', $id);
						$this->db->order_by('additional_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getAdditionalInfo($id = FALSE)
		{		
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_additional_info');					
						$this->db->order_by('additional_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$query = $this->db->get_where('cr.vi_cr_customer_additional_info', array('customer_id' => $id));
						return $query->result_array();
				}
		}
		
		public function getAdditionalInfoId($id = FALSE)
		{		
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_additional_info');					
						$this->db->order_by('additional_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_additional_info');
						$this->db->where('cust_additional_id',$id);
						$this->db->order_by('additional_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function setCustomerAdditional($data)
		{
			$this->load->helper('url');

			//$slug = url_title($this->input->post('title'), 'dash', TRUE);

			return $this->db->insert('cr.cr_customer_master_additional', $data);
		}
		
		public function setAdditionalInfo($data)
		{
			$this->load->helper('url');

			//$slug = url_title($this->input->post('title'), 'dash', TRUE);

			return $this->db->insert('cr.cr_customer_additional_info', $data);
		}
		
		public function postUpdate($data, $id)
		{		
				$this->load->helper('url');
				$this->db->where('additional_id',$id);
				$this->db->update('cr.cr_customer_master_additional', $data); 

		}
		
		public function postUpdateInfo($data, $id)
		{		
				$this->load->helper('url');
				$this->db->where('cust_additional_id',$id);
				$this->db->update('cr.cr_customer_additional_info', $data); 

		}
		
		public function getAllAdditional()
		{
			$sql = "select * from cr.cr_customer_master_additional";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getAdditionalInfoByKey($id){
			$sql = "select * from cr.cr_customer_master_additional where upper(additional_name) like '%$id%' or upper(additional_description) like '%$id%' order by additional_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
}