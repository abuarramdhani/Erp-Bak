<?php
class M_item extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
        }
		
		public function getItem($id = FALSE)
		{		//$id = str_replace("~", " ", $id);
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('im.im_master_items');					
						$this->db->order_by('segment1', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{						
						if(gettype($id) == 'integer')
						{
							$this->db->select('*');
							$this->db->from('im.im_master_items');
							//$this->db->like('upper(customer_name)', $id);
							$this->db->where('item_id', $id);
							$this->db->order_by('segment1', 'ASC');
						}
						else{
							$this->db->select('*');
							$this->db->from('im.im_master_items');
							$this->db->like('upper(segment1)', $id);
							//$this->db->or_like('customer_id', $id);
							$this->db->order_by('segment1', 'ASC');
						}
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getItemHarvester($id = FALSE)
		{		//$id = str_replace("~", " ", $id);
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('im.im_master_items');
						$this->db->where('category_id', 2);
						$this->db->order_by('segment1', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{						
						if(gettype($id) == 'integer')
						{
							$this->db->select('*');
							$this->db->from('im.im_master_items');
							//$this->db->like('upper(customer_name)', $id);
							$this->db->where('item_id', $id);
							$this->db->where('category_id', 2);
							$this->db->order_by('segment1', 'ASC');
						}
						else{
							$this->db->select('*');
							$this->db->from('im.im_master_items');
							$this->db->where('category_id', 2);
							$this->db->like('upper(segment1)', $id);
							//$this->db->or_like('customer_id', $id);
							$this->db->order_by('segment1', 'ASC');
						}
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getItemSparePart($id = FALSE)
		{		//$id = str_replace("~", " ", $id);
				$this->load->helper('url');
				if ($id === FALSE)
				{		
						$this->db->select('*');
						$this->db->from('im.im_master_items');
						$this->db->where('category_id', 3);
						$this->db->order_by('segment1', 'ASC');
						
						$query = $this->db->get();
						return $query->result_array();
				}
				else{						
						if(gettype($id) == 'integer')
						{
							$this->db->select('*');
							$this->db->from('im.im_master_items');
							//$this->db->like('upper(customer_name)', $id);
							$this->db->where('item_id', $id);
							$this->db->where('category_id', 3);
							$this->db->order_by('segment1', 'ASC');
						}
						else{
							$this->db->select('*');
							$this->db->from('im.im_master_items');
							$this->db->where('category_id', 3);
							$this->db->like('upper(segment1)', $id);
							//$this->db->or_like('customer_id', $id);
							$this->db->order_by('segment1', 'ASC');
						}
						
						$query = $this->db->get();
						return $query->result_array();
				}
		}
		
		public function getItemId($id)
		{	if($id===FALSE){
				$sql = "select * from im.im_master_items order by segment1";
			}else{
				$sql = "select * from im.im_master_items where item_id in ($id) order by segment1";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		

		
}