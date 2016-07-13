<?php
class M_CustomerContacts extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
        }
		
		public function getCustomerContacts($id = FALSE,$type = FALSE,$cust_id = 100,$term= FALSE)
		{		
				
				if ($id === FALSE)
				{	if ($type === FALSE or $type === NULL)
					{
						$this->db->select('*');
						$this->db->from('cr.cr_customer_contacts');					
						$this->db->order_by('data', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
					}else{
						$sql="select * from cr.cr_customer_contacts where upper(type) LIKE '$type' 
						and connector_id = $cust_id and data LIKE '%$term%'";
						
						$query = $this->db->query($sql);
						return $query->result_array();
					}
						
				}
				else{
						$query = $this->db->get_where('cr.cr_customer_contacts', array('connector_id' => $id,
						'table' =>'cr.cr_customers'));
						return $query->result_array();
				}
		}
		
		public function getCustomerNumber($id = FALSE)
		{		
				
				if ($id === FALSE)
				{		$this->db->select('*');
						$this->db->from('cr.cr_customer_contacts');					
						$this->db->order_by('data', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$query = $this->db->get_where('cr.cr_customer_contacts', array('data' => $id,
						'table' =>'cr.cr_customers'));
						return $query->result_array();
				}
		}
		
		public function getCustomerContactsId($id = FALSE)
		{		
				
				if ($id === FALSE)
				{		$this->db->select('*');
						$this->db->from('cr.cr_customer_contacts');					
						$this->db->order_by('data', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$query = $this->db->get_where('cr.cr_customer_contacts', array('customer_contact_id' => $id,
						'table' =>'cr.cr_customers'));
						return $query->result_array();
				}
		}
		
		public function postUpdate($data, $id)
		{		
				$this->db->where('customer_contact_id',$id);
				$this->db->update('cr.cr_customer_contacts', $data); 

		}
		
		public function deleteContacts($id)
		{		
				$this->db->where('customer_contact_id',$id);
				$this->db->delete('cr.cr_customer_contacts'); 

		}
		
		public function setCustomerContacts($data)
		{
			$this->load->helper('url');

			//$slug = url_title($this->input->post('title'), 'dash', TRUE);

			return $this->db->insert('cr.cr_customer_contacts', $data);
		}
		

		
}