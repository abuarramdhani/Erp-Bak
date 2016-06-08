<?php
class M_salesomset extends CI_Model {

        public function __construct()
        {
            parent::__construct();
        }
		
		//read
		public function viewSalesomset($thismonth,$thisyear)
		{
			$sql = "select * from sf.sales_omset so, sys.sys_organization org where so.org_id=org.org_id AND so.month=$thismonth AND so.year=$thisyear order by sales_omset_id limit 200";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
			
		//download data as CSV
		function downloadSalesomsetcsv()
		{	
			$this->load->dbutil();
			$q=$this->db->query("select * from sf.sales_omset order by sales_omset_id");
			$delimiter = ",";
			$newline = "\r\n";
			return $this->dbutil->csv_from_result($q,$delimiter,$newline);
		}
		
		//download data as XML
		function downloadSalesomsetxml()
		{	
			$this->load->dbutil();
			$query = $this->db->query("select * from sf.sales_omset order by sales_omset_id");
			$config = array (
								  'root'    => 'root',
								  'element' => 'element', 
								  'newline' => "\n", 
								  'tab'    => "\t"
							);

			return $this->dbutil->xml_from_result($query, $config);
		}
		
		//Full data
		public function viewFullsalesomset()
		{
			$sql = "select * from sf.sales_omset so, sys.sys_organization org where so.org_id=org.org_id order by sales_omset_id limit 200";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//source organization
		public function viewOrganization()
		{
			$sql = "select * from sys.sys_organization";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//source year
		public function viewYear()
		{
			$sql = "select distinct(year) from sf.sales_omset order by year";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//profilter
		public function filterSalesomset($month,$year,$organization)
		{
			$sql = "select * from sf.sales_omset so, sys.sys_organization org where (so.org_id=org.org_id) AND (so.month=$month) AND (so.year=$year) AND (so.org_id=$organization)order by sales_omset_id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
}
?>