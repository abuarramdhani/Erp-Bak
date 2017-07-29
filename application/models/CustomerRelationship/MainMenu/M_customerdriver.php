<?php
class M_CustomerDriver extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
        }
		
		
		public function getCustomerDriver($id = FALSE)
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
						//$query = $this->db->get_where('cr.vi_cr_customer_relation_detail', array('customer_id' => $id));
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_relation_detail');
						$this->db->where('owner_id', $id);
						$this->db->order_by('start_date', 'DESC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getCustomerDriverId($id = FALSE)
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
						//$query = $this->db->get_where('cr.vi_cr_customer_relation_detail', array('customer_id' => $id));
						$this->db->select('*');
						$this->db->from('cr.vi_cr_customer_relation_detail');
						$this->db->where('relation_id', $id);
						//$this->db->where('customer_id', $driver_id);
						$this->db->order_by('customer_name', 'DESC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function postUpdate($data, $id)
		{		//$this->load->helper('url');
				$this->db->where('relation_id',$id);
				$this->db->update('cr.cr_customer_relation_detail', $data); 

		}
		
		public function setCustomerDriver($data)
		{
			//$slug = url_title($this->input->post('title'), 'dash', TRUE);

			return $this->db->insert('cr.cr_customer_relation_detail', $data);
		}
		
		public function getDriver($id,$driver_id=FALSE){
			if($driver_id===FALSE){
				$sql="select * from cr.vi_cr_customer where driver='Y' and customer_id != $id
					and customer_id not in(select customer_id from cr.cr_customer_relation_detail where owner_id = $id )";
			}else{
				$sql="select * from cr.vi_cr_customer where driver='Y'and customer_id = $driver_id
						UNION ALL
					select * from cr.vi_cr_customer where driver='Y' and customer_id != $id
					and customer_id not in(select customer_id from cr.cr_customer_relation_detail where owner_id = $id )
					";
			}
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getDriverByName($id,$id_owner){
			$sql="select * from cr.vi_cr_customer where driver='Y' and upper(customer_name) like '%$id%' and customer_id != $id_owner order by customer_name limit 50 ";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		
}