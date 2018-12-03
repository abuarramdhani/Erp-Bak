<?php
class M_master_item extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
				$this->load->library('session');
        }

        public function getConsumableItem($id=FALSE)
        {
        	if ($id===FALSE) {
        		$query = $this->db->get('wh.wh_master_item_consumable');
        	}else{
        		$query = $this->db->get_where('wh.wh_master_item_consumable', array('consumable_id' => $id));
        	}

        	return $query->result_array();
        }
		
		public function getItemUsable($item_id=FALSE)
		{	
			if($item_id === FALSE){
				$sql = "select mi.item_id item_id , mi.item_name item_name ,mi.item_desc ,mi.item_qty total,
				COALESCE(sum(tl.item_qty)-sum(tl.item_qty_return),0) total_dipinjam , COALESCE(mi.item_qty - sum(tl.item_qty) + sum(tl.item_qty_return),mi.item_qty) sisa 
				from wh.wh_transaction_list tl right join wh.wh_master_item mi on tl.item_id = mi.item_id
				group by mi.item_id,tl.item_id,mi.item_qty,mi.item_desc,mi.item_name";
			}else{
				$sql = "select * from wh.wh_master_item  where item_id='$item_id' order by item_id";
			}						
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function check_item($id){
			$sql = "select * from wh.wh_master_item where item_count_id = $id";
			$query = $this->db->query($sql);
			return $query->row();
		}
		
		public function admin_check(){
			$sql = "select * from wh.wh_user_admin";
			$query = $this->db->query($sql);
			$data = $query->result_array();

			$so = array();
			foreach ($data as $values) {
				$so[] = $values['no_induk'];
			}
			return $so;
		}


		public function saveUsableItem($data){
			return $this->db->insert('wh.wh_master_item', $data);
		}
		
		public function updateUsableItem($data,$id){
			$this->db->where('item_count_id',$id);
			$this->db->update('wh.wh_master_item', $data); 
		}
		
		public function deleteUsableItem($id){
			$this->db->where('item_id', $id);
			$this->db->delete('wh.wh_master_item'); 
		}
		
		public function getGroupItemUsable($item_id=FALSE){
			if($item_id === FALSE){
				$sql = "select * from wh.wh_master_item_group";
			}else{
				$sql = "select * from wh.wh_master_item_group  where item_group_id='$item_id'";
			}						
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getListGroupItemUsable($id){
			$sql = "select * from wh.wh_master_item where item_group_id='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function saveUsableItemGroup($data){
			return $this->db->insert('wh.wh_master_item_group', $data);
		}
		
		public function deleteUsableItemGroup($id){
			$this->db->where('item_group_id', $id);
			$this->db->delete('wh.wh_master_item_group'); 
		}
		
		public function updateUsableGroupItem($data,$id){
			$this->db->where('item_group_id',$id);
			$this->db->update('wh.wh_master_item_group', $data); 
		}
		
}