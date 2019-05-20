<?php
class M_menu extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
				$this->load->library('session');
        }
		
		public function getMenu($menu_id=FALSE)
		{	if($menu_id === FALSE){
				$sql = "select * from sys.sys_menu order by coalesce(last_update_date,creation_date) desc nulls last";
			}else{
				$sql = "select * from sys.sys_menu  where menu_id=$menu_id";
			}						
			
			$query = $this->db->query($sql);
			return $query->result_array();
				
		}
		 
		public function setMenu($data)
		{
			return $this->db->insert('sys.sys_menu', $data);
		}
		
		public function updateMenu($data, $menu_id) {
			$this->db->where('menu_id',$menu_id)->update('sys.sys_menu', $data); 
		}

		public function deleteMenu($menu_id) {
			$this->db->where('menu_id', $menu_id)->delete('sys.sys_menu');
			return ($this->db->affected_rows() != 1) ? false : true;
		}

		// public function getQty() {
		// 	$qty = $this->db->select('QTY')->get('tabel');
		// 	return ($qty->result_array()) ? $qty->result_array() : '';
		// }
}