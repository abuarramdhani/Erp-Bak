<?php
class M_CustomerRelation extends CI_Model {
	public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
        }
		
		
		public function getCustomerRelation($id = FALSE)
		{		
				//$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_relation_detail');					
						$this->db->order_by('start_date', 'DESC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$query = $this->db->get_where('cr.vi_cr_customer_relation_detail', array('customer_id' => $id));
						return $query->result_array();
				}
		}
		
		public function getCustomerRelationId($id = FALSE)
		{		
				//$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_relation_detail');					
						$this->db->order_by('start_date', 'DESC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_relation_detail');
						$this->db->where('relation_id', $id);
						$this->db->order_by('start_date', 'DESC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function setCustomerRelation($data)
		{
			$this->load->helper('url');

			return $this->db->insert('cr.cr_customer_relation_detail', $data);
		}
		
		public function postUpdate($data, $id)
		{		
				// $this->load->helper('url');
				$this->db->where('relation_id',$id);
				$this->db->update('cr.cr_customer_relation_detail', $data); 
		}
}