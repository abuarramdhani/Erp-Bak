<?php
class M_ServiceProblem extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
        }
		
		public function getServiceProblem($id = FALSE)
		{		
				
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.cr_service_problems');					
						$this->db->order_by('service_problem_name', 'ASC');
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$query = $this->db->get_where('cr.cr_service_problems', array('service_problem_id' => $id));
						return $query->result_array();
				}
		}
		
		public function getServiceProblemName($id = FALSE)
		{		
				
					
						$this->db->select('*');
						$this->db->from('cr.cr_service_problems');	
						$this->db->where('active', 'Y');
						$this->db->like("service_problem_name", $id);
						//$this->db->or_like('service_problem_name', $id);
						$this->db->order_by('service_problem_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				
				/*
				$dd[''] = 'Please Select';
				if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
					// tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
						$dd[$row->service_problem_id] = $row->service_problem_name." ".$row->service_line_status_name;
					}
				}
				return $dd;*/
		}
		
		public function getServiceProblemName2($id = FALSE)
		{		
				
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.cr_service_problems');	
						$this->db->where('active', 'Y');
						$this->db->order_by('service_problem_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						
						$this->db->select('*');
						$this->db->from('cr.cr_service_problems');	
						$this->db->where('active', 'Y');
						$this->db->like('service_line_status_name', $id);
						$this->db->order_by('service_problem_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				
				
		}
		
		public function postUpdate($data, $id)
		{		
				$this->db->where('service_problem_id',$id);
				$this->db->update('cr.cr_service_problems', $data); 

		}
		
		public function deleteContacts($id)
		{		
				$this->db->where('customer_contact_id',$id);
				$this->db->delete('cr.cr_customer_contacts'); 

		}
		
		public function setServiceProblem($data)
		{
			$this->load->helper('url');

			//$slug = url_title($this->input->post('title'), 'dash', TRUE);

			return $this->db->insert('cr.cr_service_problems', $data);
		}
		

		
}