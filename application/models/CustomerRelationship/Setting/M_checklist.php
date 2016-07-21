<?php
class M_Checklist extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
        }
		
		public function getChecklist($id = FALSE)
		{		
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.cr_connect_checklist');					
						$this->db->order_by('no_urut_checklist', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$query = $this->db->get_where('cr.cr_connect_checklist', array('id_checklist' => $id));
						return $query->result_array();
				}
		}
		
		public function getChecklistActive($id = FALSE)
		{		
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.cr_connect_checklist');	
						$this->db->where('end_date', NULL);	
						$this->db->order_by('no_urut_checklist', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.cr_connect_checklist');	
						$this->db->where('end_date', NULL);	
						$this->db->where('id_checklist', $id);	
						$this->db->order_by('no_urut_checklist', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function setChecklist($data)
		{
			$this->load->helper('url');

			return $this->db->insert('cr.cr_connect_checklist', $data);
		}
		
		public function postUpdate($data, $id)
		{		$this->load->helper('url');
				$this->db->where('id_checklist',$id);
				$this->db->update('cr.cr_connect_checklist', $data); 

		}
		
		public function getMaxSequence($id=FALSE)
		{
			$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select_max('no_urut_checklist');
						$this->db->from('cr.cr_connect_checklist');	
						$this->db->where('end_date', NULL);	
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select_max('no_urut_checklist');
						$this->db->from('cr.cr_connect_checklist');	
						$this->db->where('end_date', NULL);	
						$this->db->where('id_checklist', $id);	
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
}