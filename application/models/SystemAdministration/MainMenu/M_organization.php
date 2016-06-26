<?php
class M_organization extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
				$this->load->library('session');
        }
		
		public function getOrganization($org_id=FALSE)
		{	if($org_id === FALSE){
				$sql = "select * from sys.sys_organization order by org_name";
			}else{
				$sql = "select * from sys.sys_organization  where org_id=$org_id
						order by org_name";
			}						
			
			$query = $this->db->query($sql);
			return $query->result_array();
				
		}
		 
		public function setOrganization($data)
		{
			return $this->db->insert('sys.sys_organization', $data);
		}
		
		public function updateOrganization($data, $org_id)
		{		
				$this->db->where('org_id',$org_id);
				$this->db->update('sys.sys_organization', $data); 

		}
		
		
}