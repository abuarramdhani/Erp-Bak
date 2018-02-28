<?php
class M_module extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
				$this->load->library('session');
        }
		
		public function getModule($module_id=FALSE)
		{	if($module_id === FALSE){
				$sql = "select * from sys.sys_module order by module_name";
			}else{
				$sql = "select * from sys.sys_module  where module_id=$module_id
						order by module_name";
			}						
			
			$query = $this->db->query($sql);
			return $query->result_array();
				
		}
		 
		public function createModule($data)
		{
			$this->db->insert('sys.sys_module' ,$data);
		}

		public function updateModule($data, $module_id)
		{		
				$this->db->where('module_id',$module_id);
				$this->db->update('sys.sys_module', $data); 

		}

		
		
}