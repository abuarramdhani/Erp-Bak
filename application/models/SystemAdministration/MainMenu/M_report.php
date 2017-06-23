<?php
class M_report extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
				$this->load->library('session');
        }
		
		public function getReport($report_id=FALSE)
		{	if($report_id === FALSE){
				$sql = "select * from sys.sys_report order by coalesce(last_update_date,creation_date) desc nulls last";
			}else{
				$sql = "select * from sys.sys_report  where report_id=$report_id";
			}						
			
			$query = $this->db->query($sql);
			return $query->result_array();
				
		}
		 
		public function setReport($data)
		{
			return $this->db->insert('sys.sys_report', $data);
		}
		
		public function updateReport($data, $report_id)
		{		
				$this->db->where('report_id',$report_id);
				$this->db->update('sys.sys_report', $data); 

		}
		
		
		
}