<?php
class M_deliveryrequestapproval extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
        }
		
		public function getApprover($id = FALSE)
		{	
			if($id === FALSE){
				$sql = "select kdra.*, hou.name branch
						from khs_delivery_request_approval kdra,
						hr_operating_units hou
						where kdra.org_id = hou.organization_id(+) order by employee_number";
			}else{
				if(is_numeric($id)){
					$sql = "select kdra.*, hou.name branch
						from khs_delivery_request_approval kdra,
						hr_operating_units hou
						where kdra.org_id = hou.organization_id(+)
						and kdra.approval_id = '$id' order by employee_number";
				}else{
					$sql = "select kdra.*, hou.name branch
						from khs_delivery_request_approval kdra,
						hr_operating_units hou
						where kdra.org_id = hou.organization_id(+)
						and kdra.employee_number = '$id' 
						and kdra.active_flag = 'Y' 
						order by employee_number";
				}
				
			}						
			
			$oracle =  $this->load->database('oracle',TRUE);
			$query = $oracle->query($sql);
			return $query->result_array();
				
		}
				
		public function getOrganizationUnit($org_id = FALSE)
		{	if($org_id === FALSE){
				$sql = "select hou.*
						from 
						hr_operating_units hou";
			}else{
				$sql = "select hou.*
						from 
						hr_operating_units hou
						where hou.organization_id = $org_id";
			}						
			
			$oracle =  $this->load->database('oracle',TRUE);
			$query = $oracle->query($sql);
			return $query->result_array();
				
		}
				
		public function setApprover($data)
		{	$oracle =  $this->load->database('oracle',TRUE);
			$date = $data['CREATION_DATE'];
			unset($data['CREATION_DATE']);
			$oracle->set('CREATION_DATE',"to_date('$date','dd-Mon-yyyy HH24:MI:SS')",false);
			$oracle->insert('KHS_DELIVERY_REQUEST_APPROVAL', $data);
			
			$sql = "select APPROVAL_ID from KHS_DELIVERY_REQUEST_APPROVAL where rownum=1 order by APPROVAL_ID desc";
			$query = $oracle->query($sql);
			return $query->result_array();
		}
		
		public function updateApprover($data, $request_id)
		{		$oracle =  $this->load->database('oracle',TRUE);
				$date = $data['LAST_UPDATE_DATE'];
				unset($data['LAST_UPDATE_DATE']);
				$oracle->set('LAST_UPDATE_DATE',"to_date('$date','dd-Mon-yyyy HH24:MI:SS')",false);
				$oracle->where('APPROVAL_ID',$request_id);
				$oracle->update('KHS_DELIVERY_REQUEST_APPROVAL', $data);

		}
		
}