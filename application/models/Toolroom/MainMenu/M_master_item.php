<?php
class M_master_item extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
				$this->load->library('session');
        }
		
		public function getItemUsable($item_id=FALSE)
		{	
			if($item_id === FALSE){
				$sql = "select * from tr.tr_master_item order by item_id";
			}else{
				$sql = "select * from tr.tr_master_item  where item_id='$item_id' order by item_id";
			}						
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function saveUsableItem($data){
			return $this->db->insert('tr.tr_master_item', $data);
		}
		
		public function updateUsableItem($data,$id){
			$this->db->where('item_id',$id);
			$this->db->update('tr.tr_master_item', $data); 
		}
		
		public function deleteUsableItem($id){
			$this->db->where('item_id', $id);
			$this->db->delete('tr.tr_master_item'); 
		}
		
		public function getGroupItemUsable($item_id=FALSE){
			if($item_id === FALSE){
				$sql = "select * from tr.tr_master_item_group";
			}else{
				$sql = "select * from tr.tr_master_item_group  where item_group_id='$item_id'";
			}						
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function getListGroupItemUsable($id){
			$sql = "select * from tr.tr_master_item where item_group_id='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function saveUsableItemGroup($data){
			return $this->db->insert('tr.tr_master_item_group', $data);
		}
		
		public function deleteUsableItemGroup($id){
			$this->db->where('item_group_id', $id);
			$this->db->delete('tr.tr_master_item_group'); 
		}
		
		public function updateUsableGroupItem($data,$id){
			$this->db->where('item_group_id',$id);
			$this->db->update('tr.tr_master_item_group', $data); 
		}
		
}