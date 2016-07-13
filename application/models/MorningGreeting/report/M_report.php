<?php

	class M_report extends CI_Model {
		
		public function __construct()
		{
			parent::__construct();
		}
		
	//Menampilkan data branch
		public function data_branch()
		{
			$sql = "select * from sys.sys_organization";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

//----------------------------------------------REPORT ALL ------------------------------------------------
	//Menampilkan semua data report
		public function searchReportAll($rangeAllStart,$rangeAllEnd)
		{
			$sql = "SELECT *, count(cdr.*) AS r, count(sch.*) AS p
					FROM sf.morning_greeting_cdr cdr, sf.morning_greeting_schedule sch, sys.sys_organization org
					WHERE org.org_id = cdr.org_id AND cdr.org_id = sch.org_id
							AND cdr.calldate BETWEEN '$rangeAllStart' AND '$rangeAllEnd'
					GROUP BY cdr.cdr_id, sch.schedule_id, org.org_id
					ORDER BY cdr.calldate desc";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//download data as CSV (REPORT by RELATION)
		function showAllDownloadCsv($rangeAllStart,$rangeAllEnd)
		{	
			$this->load->dbutil();
			$q=$this->db->query("
					SELECT cdr.calldate, count(cdr.*) AS r, count(sch.*) AS p
					FROM sf.morning_greeting_cdr cdr, sf.morning_greeting_schedule sch, sys.sys_organization org
					WHERE org.org_id = cdr.org_id AND cdr.org_id = sch.org_id
							AND cdr.calldate BETWEEN '$rangeAllStart' AND '$rangeAllEnd'
					GROUP BY cdr.cdr_id, sch.schedule_id, org.org_id
					ORDER BY cdr.calldate desc");
			$delimiter = ",";
			$newline = "\r\n";
			return $this->dbutil->csv_from_result($q,$delimiter,$newline);
		}
		
		//download data as XML (REPORT by RELATION)
		function showAllDownloadXml($rangeAllStart,$rangeAllEnd)
		{	
			$this->load->dbutil();
			$query = $this->db->query("
					SELECT cdr.calldate, count(cdr.*) AS r, count(sch.*) AS p
					FROM sf.morning_greeting_cdr cdr, sf.morning_greeting_schedule sch, sys.sys_organization org
					WHERE org.org_id = cdr.org_id AND cdr.org_id = sch.org_id
							AND cdr.calldate BETWEEN '$rangeAllStart' AND '$rangeAllEnd'
					GROUP BY cdr.cdr_id, sch.schedule_id, org.org_id
					ORDER BY cdr.calldate desc");
			$config = array (
								  'root'    => 'root',
								  'element' => 'element', 
								  'newline' => "\n", 
								  'tab'    => "\t"
							);

			return $this->dbutil->xml_from_result($query, $config);
		}

//----------------------------------------------REPORT by BRANCH ------------------------------------------------
		//Menampilkan data report BRANCH
		public function searchReportByBranch($org_id,$rangeBranchStart,$rangeBranchEnd)
		{
			$sql = "	SELECT *, count(cdr.*) AS r, count(sch.*) AS p
						FROM sf.morning_greeting_cdr cdr, sf.morning_greeting_schedule sch, sys.sys_organization org
						WHERE org.org_id = cdr.org_id AND cdr.org_id = sch.org_id
							AND cdr.org_id = '$org_id' AND cdr.calldate BETWEEN '$rangeBranchStart' AND '$rangeBranchEnd'
						GROUP BY cdr.cdr_id, sch.schedule_id, org.org_id
						ORDER BY cdr.calldate desc";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//download data as CSV (REPORT by RELATION)
		function showByBranchDownloadCsv($org_id,$rangeBranchStart,$rangeBranchEnd)
		{	
			$this->load->dbutil();
			$q=$this->db->query("
						SELECT cdr.calldate, count(cdr.*) AS r, count(sch.*) AS p
						FROM sf.morning_greeting_cdr cdr, sf.morning_greeting_schedule sch, sys.sys_organization org
						WHERE org.org_id = cdr.org_id AND cdr.org_id = sch.org_id
							AND cdr.org_id = '$org_id' AND cdr.calldate BETWEEN '$rangeBranchStart' AND '$rangeBranchEnd'
						GROUP BY cdr.cdr_id, sch.schedule_id, org.org_id
						ORDER BY cdr.calldate desc");
			$delimiter = ",";
			$newline = "\r\n";
			return $this->dbutil->csv_from_result($q,$delimiter,$newline);
		}
		
		//download data as XML (REPORT by RELATION)
		function showByBranchDownloadXml($org_id,$rangeBranchStart,$rangeBranchEnd)
		{	
			$this->load->dbutil();
			$query = $this->db->query("
						SELECT cdr.calldate, count(cdr.*) AS r, count(sch.*) AS p
						FROM sf.morning_greeting_cdr cdr, sf.morning_greeting_schedule sch, sys.sys_organization org
						WHERE org.org_id = cdr.org_id AND cdr.org_id = sch.org_id
							AND cdr.org_id = '$org_id' AND cdr.calldate BETWEEN '$rangeBranchStart' AND '$rangeBranchEnd'
						GROUP BY cdr.cdr_id, sch.schedule_id, org.org_id
						ORDER BY cdr.calldate desc");
			$config = array (
								  'root'    => 'root',
								  'element' => 'element', 
								  'newline' => "\n", 
								  'tab'    => "\t"
							);

			return $this->dbutil->xml_from_result($query, $config);
		}

//----------------------------------------------REPORT by RELATION ------------------------------------------------
		//Menampilkan data report RELATION
		public function searchReportByRelation($org_id) 
		{
			$sql = "	SELECT *
						FROM sf.relation rlt, sys.sys_organization org, sys.sys_area_city_regency acr
						WHERE org.org_id = rlt.org_id AND rlt.city = acr.city_regency_id AND rlt.org_id = '$org_id'
						";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//download data as CSV (REPORT by RELATION)
		function downloadcsv($org_id)
		{	
			$this->load->dbutil();
			$q=$this->db->query("SELECT rlt.oracle_cust_id, rlt.relation_name, acr.regency_name
						FROM sf.relation rlt, sys.sys_organization org, sys.sys_area_city_regency acr
						WHERE org.org_id = rlt.org_id AND rlt.city = acr.city_regency_id AND rlt.org_id = '$org_id'");
			$delimiter = ",";
			$newline = "\r\n";
			return $this->dbutil->csv_from_result($q,$delimiter,$newline);
		}
		
		//download data as XML (REPORT by RELATION)
		function downloadxml($org_id)
		{	
			$this->load->dbutil();
			$query = $this->db->query("SELECT rlt.oracle_cust_id, rlt.relation_name, acr.regency_name
						FROM sf.relation rlt, sys.sys_organization org, sys.sys_area_city_regency acr
						WHERE org.org_id = rlt.org_id AND rlt.city = acr.city_regency_id AND rlt.org_id = '$org_id'");
			$config = array (
								  'root'    => 'root',
								  'element' => 'element', 
								  'newline' => "\n", 
								  'tab'    => "\t"
							);

			return $this->dbutil->xml_from_result($query, $config);
		}
		 
		public function reportDataBranch($org_id)
		{
			$sql = "	SELECT org_name, org_id
						FROM sys.sys_organization
						WHERE org_id = '$org_id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	}
?>