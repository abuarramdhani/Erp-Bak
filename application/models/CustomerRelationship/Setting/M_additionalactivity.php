<?php
class M_additionalactivity extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
        }
		
		public function getAdditionalActivity($id = FALSE)
		{		
				
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.cr_setup_service_additional_activities');					
						$this->db->order_by('last_update_date', 'ASC');
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.cr_setup_service_additional_activities');
						$this->db->where('setup_service_additional_activity_id', $id);
						$this->db->order_by('last_update_date', 'ASC');
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getServiceProblemName($id = FALSE)
		{		
					
						$this->db->select('*');
						$this->db->from('cr.cr_setup_service_additional_activities');
						$this->db->where('setup_service_additional_activity_id', $id);
						$this->db->like("setup_service_additional_activity_id", $id);
						//$this->db->or_like('service_problem_name', $id);
						//$this->db->order_by('', 'ASC');
						
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
						$this->db->from('cr.cr_setup_service_additional_activities');	
						$this->db->where('setup_service_additional_activity_id');
						//$this->db->order_by('', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						
						$this->db->select('*');
						$this->db->from('cr.cr_setup_service_additional_activities');	
						$this->db->where('setup_service_additional_activity_id');
						//$this->db->like('service_line_status_name', $id);
						//$this->db->order_by('', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				
				
		}
		
		public function postUpdate($data, $id)
		{		
				$this->db->where('setup_service_additional_activity_id',$id);
				$this->db->update('cr.cr_setup_service_additional_activities', $data);

		}
		
		public function deleteContacts($id)
		{		
				$this->db->where('customer_contact_id',$id);
				$this->db->delete('cr.cr_customer_contacts');

		}
		
		public function setAdditionalAvtivity($data)
		{
			$this->load->helper('url');

			//$slug = url_title($this->input->post('title'), 'dash', TRUE);

			return $this->db->insert('cr.cr_setup_service_additional_activities', $data);
		}
		

		
}