<?php
class M_salestarget extends CI_Model {

        public function __construct()
        {
            parent::__construct();
        }

		//read (updated)
		public function viewSalestarget($thismonth,$thisyear)
		{
			$sql = "select * from sf.sales_target st, sys.sys_organization org where st.org_id=org.org_id AND st.month=$thismonth AND st.year=$thisyear order by sales_target_id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}						  
						  
		//download data as CSV (updated)
		function downloadSalestargetcsv()
		{	
			$this->load->dbutil();
			$q=$this->db->query("select org.org_name, st.order_type, st.month, st.year, st.target from sf.sales_target st, sys.sys_organization org where st.org_id=org.org_id order by sales_target_id");
			$delimiter = ",";
			$newline = "\r\n";
			return $this->dbutil->csv_from_result($q,$delimiter,$newline);
		}
		
		//download data as XML (updated)
		function downloadSalestargetxml()
		{	
			$this->load->dbutil();
			$query = $this->db->query("select org.org_name, st.order_type, st.month, st.year, st.target from sf.sales_target st, sys.sys_organization org where st.org_id=org.org_id order by sales_target_id");
			$config = array (
								  'root'    => 'root',
								  'element' => 'element', 
								  'newline' => "\n", 
								  'tab'    => "\t"
							);

			return $this->dbutil->xml_from_result($query, $config);
		}
		
		//Full Data
		public function viewFullsalestarget()
		{
			$sql = "select * from sf.sales_target st, sys.sys_organization org where st.org_id=org.org_id order by sales_target_id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}			
		
		//source organization (updated)
		public function viewOrganization()
		{
			$sql = "select * from sys.sys_organization";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//source year (updated)
		public function viewYear()
		{
			$sql = "select distinct(year) from sf.sales_target order by year";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//create (updated)
		public function insertSalestarget($ordertype,$month,$year,$target,$orgid,$startdate,$enddate,$lastupdated,$lastupdateby,$creationdate,$createdby)
		{
			$sql = "insert into sf.sales_target
			(order_type,month,year,target,org_id,start_date,end_date,last_updated,last_update_by,creation_date,created_by)values('$ordertype','$month','$year','$target','$orgid',$startdate,$enddate,$lastupdated,$lastupdateby,$creationdate,'$createdby')";
			$query = $this->db->query($sql);
			return;
		}
		
		//update (updated)
		public function updateSalestarget($id,$orgid,$ordertype,$target,$month,$year,$lastupdateby)
		{
			$sql = "update sf.sales_target set org_id='$orgid', order_type='$ordertype', target='$target',month='$month',year='$year', last_updated=now(), last_update_by=$lastupdateby where sales_target_id=$id";
			$query = $this->db->query($sql);
			return;
		}
		
		//delete
		public function deleteSalestarget($id)
		{
			$sql = "delete from sf.sales_target where sales_target_id='$id'";
			$query = $this->db->query($sql);
			return;
		}
		
		//get data for update
		function searchSalestarget($id)
		{
			$sql = "select * from sf.sales_target where sales_target_id='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//profilter
		public function filterSalestarget($month,$year,$organization)
		{
			$sql = "select * from sf.sales_target st, sys.sys_organization org where (st.org_id=org.org_id) AND (st.month=$month) AND (st.year=$year) AND (st.org_id=$organization)order by sales_target_id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
}
?>