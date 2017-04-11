<?php
class M_approvalclaim extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
        }
		
		public function getApprovalClaim($id = FALSE)
		{		
			if ($id === FALSE)
			{		
				$sql	= "	SELECT cac.claim_approval_id, cac.employee_id, eeea.employee_code, eeea.employee_name,
							cac.location_code, eel.location_name, cac.status, cac.start_date, cac.end_date
							FROM cr.cr_approval_claim cac, er.er_location eel, er.er_employee_all eeea
							WHERE cac.employee_id = eeea.employee_id AND cac.location_code = eel.location_code
							order by cac.last_update_date desc";
			}
			else{
				$sql	= "	SELECT cac.claim_approval_id, cac.employee_id, eeea.employee_code, eeea.employee_name,
							cac.location_code, eel.location_name, cac.status, cac.start_date, cac.end_date
							FROM cr.cr_approval_claim cac, er.er_location eel, er.er_employee_all eeea
							WHERE cac.employee_id = eeea.employee_id AND cac.location_code = eel.location_code
								AND cac.claim_approval_id = '$id'";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function getBranch()
		{
			$sql	= "SELECT * FROM er.er_location order by location_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function getEmployee()
		{
			$sql	= "SELECT * FROM er.er_employee_all order by employee_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function create($branch,$employee,$startdate,$enddate,$creator,$createdate)
		{
			if ($startdate == '') {$startdate = "NULL";}else{$startdate = "'$startdate'";}
			if ($enddate == '') {$enddate = "NULL";}else{$enddate = "'$enddate'";}

			$sql	= "INSERT INTO cr.cr_approval_claim(
							location_code,employee_id,start_date,end_date,created_by,creation_date
							)
						VALUES(
							'".$branch."',
							'".$employee."',
							$startdate,
							$enddate,
							'".$creator."',
							'".$createdate."'
						)";
			$query = $this->db->query($sql);
		}

		public function update($id,$branch,$employee,$startdate,$enddate,$updator,$updatedate)
		{
			if ($startdate == '') {$startdate = "NULL";}else{$startdate = "'$startdate'";}
			if ($enddate == '') {$enddate = "NULL";}else{$enddate = "'$enddate'";}

			$sql	= 	"UPDATE cr.cr_approval_claim SET
							location_code 	= '$branch',
							employee_id 	= '$employee',
							start_date 		= $startdate,
							end_date 		= $enddate,
							last_updated_by = '$updator',
							last_update_date= '$updatedate'
						WHERE claim_approval_id = '$id'
						";
			$query = $this->db->query($sql);
		}

		public function delete($id)
		{
			$sql 	= "	DELETE FROM cr.cr_approval_claim
						WHERE claim_approval_id = '$id'";
			$query 	= $this->db->query($sql);
		}
}