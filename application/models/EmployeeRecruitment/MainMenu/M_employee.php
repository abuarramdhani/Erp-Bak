<?php
class M_employee extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
        }
		
		public function getEmployee($id = FALSE)
		{		//$id = str_replace("~", " ", $id);
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('er.er_employee_all');		
						//$this->db->limit(50);						
						$this->db->order_by('employee_code', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{						
						if(gettype($id) == 'integer')
						{
							$this->db->select('*');
							$this->db->from('er.er_employee_all');
							//$this->db->like('upper(customer_name)', $id);
							$this->db->where('employee_id', $id);
							$this->db->order_by('employee_code', 'ASC');
						}
						else{
							$this->db->select('*');
							$this->db->from('er.er_employee_all');
							$this->db->like('upper(employee_code)', $id);
							//$this->db->or_like('customer_id', $id);
							$this->db->order_by('name', 'ASC');
						}
						
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getEmployeeNum($id = FALSE)
		{		//$id = str_replace("~", " ", $id);
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('er.er_employee_all');					
						$this->db->order_by('employee_code', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{						
						
							$this->db->select('*');
							$this->db->from('er.er_employee_all');
							$this->db->like('upper(employee_code)', $id);
							//$this->db->or_like('customer_id', $id);
							$this->db->order_by('name', 'ASC');
						
						
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getEmployeeService($id = FALSE)
		{		//$id = str_replace("~", " ", $id);
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('er.er_employee_all');					
						$this->db->order_by('employee_code', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{	
							$this->db->select('*');
							$this->db->from('er.er_employee_all');
							$this->db->like('upper(employee_code)', $id);
							//$this->db->or_like('customer_id', $id);
							$this->db->order_by('name', 'ASC');
						
						
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getEmployeeByKey($id){
			$sql = "select * from er.er_employee_all where upper(employee_code) like '%$id%' or upper(employee_name) like '%$id%' order by employee_code asc limit 50";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function getEmployeeById($id){
			$sql = "select * from er.er_employee_all where employee_code='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
}