<?php
class M_buyingtype extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
        }
		
		public function getBuyingType($id = FALSE)
		{		
				// $this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.cr_customer_master_buying_type');
						$this->db->order_by('buying_type_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.cr_customer_master_buying_type');
						$this->db->where('buying_type_id', $id);
						$this->db->order_by('buying_type_name', 'ASC');
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getBuyingTypeName($id = FALSE)
		{		
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('cr.cr_customer_master_buying_type');
						$this->db->order_by('buying_type_name', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{
						$this->db->select('*');
						$this->db->from('cr.cr_customer_master_buying_type');
						$this->db->like('buying_type_name', $id);
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function setBuyingType($data)
		{
			$this->load->helper('url');

			return $this->db->insert('cr.cr_customer_master_buying_type', $data);
		}
		
		public function postUpdate($data, $id)
		{		$this->load->helper('url');
				$this->db->where('buying_type_id',$id);
				$this->db->update('cr.cr_customer_master_buying_type', $data); 

		}
		
		public function getAllBuyingType(){
			$sql ="select * from cr.cr_customer_master_buying_type order by buying_type_name";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function getBuyingTypes($id=FALSE){
			if($id===FALSE){
				$sql ="select * from cr.cr_customer_master_buying_type order by buying_type_name";
			}else{
				$sql ="select * from cr.cr_customer_master_buying_type 
				where buying_type_id in ($id) order by buying_type_name";
			}
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getBuyingTypeByKey($id){
			$sql ="select * from cr.cr_customer_master_buying_type where upper(buying_type_name) like '%$id%' or upper(buying_type_description) like '%$id%' order by buying_type_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
}