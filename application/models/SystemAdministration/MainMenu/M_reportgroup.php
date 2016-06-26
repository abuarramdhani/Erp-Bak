<?php
class M_reportgroup extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
				$this->load->library('session');
        }
		
		public function getReportGroup($report_group_id=FALSE)
		{	if($report_group_id === FALSE){
				$sql = "select *, 
						(select count(*) from  sys.sys_report_group_list srgl where srg.report_group_id = srgl.report_group_id) report
						from sys.sys_report_group srg order by coalesce(last_update_date,creation_date) desc nulls last";
			}else{
				$sql = "select * from sys.sys_report_group  where report_group_id=$report_group_id";
			}						
			
			$query = $this->db->query($sql);
			return $query->result_array();
				
		}
		 
		public function getReportGroupList($report_group_id=FALSE,$report_group_list_id=FALSE)
		{	if($report_group_list_id === FALSE){
				$and1 = "";
			}else{
				$and1 = "AND report_group_list_id = $report_group_list_id";
			}
			if($report_group_id === FALSE){
				$sql = "select * from sys.sys_report_group_list order by coalesce(last_update_date,creation_date) desc nulls last";
			}else{
				$sql = "select * from sys.sys_report_group_list  where report_group_id=$report_group_id
						$and1";
			}						
			
			$query = $this->db->query($sql);
			return $query->result_array();
				
		}
		 
		public function setReportGroup($data)
		{
			return $this->db->insert('sys.sys_report_group', $data);
		}
		
		public function setReportGroupList($data)
		{
			return $this->db->insert('sys.sys_report_group_list', $data);
		}
		
		public function updateReportGroupList($data, $report_group_list_id)
		{		
				$this->db->where('report_group_list_id',$report_group_list_id);
				$this->db->update('sys.sys_report_group_list', $data); 

		}
		
		
		
}