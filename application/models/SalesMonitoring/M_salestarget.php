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
			$sql = "select org_id, org_name, province_id, city_regency_id, district_id, village_id, address, org_code from sys.sys_organization";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//source order type (updated)
		public function viewOrderType()
		{

        	$db = $this->load->database('oracle',true);
			$sql = "SELECT * FROM oe_transaction_types_tl WHERE
						(name LIKE '%SAP%'
							OR name LIKE '%boshi%'
							OR name LIKE '%HDE%'
							OR name LIKE '%VDE%'
							OR name LIKE '%Gasket%'
							OR name LIKE '%Bando%'
							OR name LIKE '%Roll%'
							OR name LIKE '%Bearing%'
						) AND name LIKE '%DN'
						ORDER BY name";
			$query = $db->query($sql);
			return $query->result_array();
		}

		public function viewOrganization2($id)
		{
			$sql = "select org_code from sys.sys_organization where org_id = $id ";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function viewTabel($code)
		{
			$db = $this->load->database('oracle',true);
			$sql = "SELECT * FROM KHS_ORDER_TYPE_SM WHERE ORG_ID = '$code'";
			$query = $db->query($sql);
			return $query->result_array();
		}

		public function deleteOrder($code)
		{
			$db = $this->load->database('oracle',true);
			$sql = "DELETE FROM KHS_ORDER_TYPE_SM WHERE ITEM_ID = '$code'";
			$query = $db->query($sql);
		}

		public function getDataOrder($item_id)
		{
			$db = $this->load->database('oracle',true);
			$sql = "SELECT * FROM KHS_ORDER_TYPE_SM WHERE ITEM_ID = '$item_id'";
			$query = $db->query($sql);
			return $query->result_array();
		}

		public function updateOrder($item_id,$order)
		{
			$db = $this->load->database('oracle',true);
			$sql = "UPDATE KHS_ORDER_TYPE_SM SET ORDER_TYPE = '$order' WHERE ITEM_ID = '$item_id'";
			$query = $db->query($sql);
		}

		public function getCodeAndName($param)
		{
			$db = $this->load->database('oracle',true);
			$sql = "SELECT * FROM KHS_ORDER_TYPE_SM WHERE ORG_ID = '$param'";
			$query = $db->query($sql);
			return $query->result_array();
		}

		public function insertNewOrderType($order_type,$param,$code,$name)
		{
			$db = $this->load->database('oracle',true);
			$sql = "INSERT INTO KHS_ORDER_TYPE_SM (ORG_ID, ORG_CODE, ORG_NAME, ORDER_TYPE) VALUES ('$param','$code','$name','$order_type')";
			$query = $db->query($sql);
		}

		public function viewOrderType2($code)
		{
			$db = $this->load->database('oracle',true);
			$sql = "SELECT * FROM oe_transaction_types_tl WHERE
						(name LIKE '%SAP%'
							OR name LIKE '%boshi%'
							OR name LIKE '%HDE%'
							OR name LIKE '%VDE%'
							OR name LIKE '%Gasket%'
							OR name LIKE '%Bando%'
							OR name LIKE '%Roll%'
							OR name LIKE '%Bearing%'
						) AND name LIKE '%DN'
						AND name LIKE '$code%'
						ORDER BY name";
			$query = $db->query($sql);
			return $query->result_array();
		}
		
		public function viewOrderType3($code)
		{
			$db = $this->load->database('oracle',true);
			$sql = "select
                    ottt.DESCRIPTION            
                    from oe_transaction_types_tl ottt ,
                    oe_transaction_types_all otta
                    where
                    otta.TRANSACTION_TYPE_ID = ottt.TRANSACTION_TYPE_ID
                    and otta.ORG_ID = $code
                    and (ottt.name like '%SAP%'
                    or ottt.name like '%boshi%'
                    or ottt.name like '%HDE%'
                    or ottt.name like '%VDE%'
                    or ottt.name like '%Gasket%'
                    or ottt.name like '%Bando%'
                    or ottt.name like '%Roll%'
                    or ottt.name like '%Bearing%'
                    or ottt.name like '%SKF%' )
                    and ottt.name like '%DN'
                    union
                    select 'TOKOQUICK' from dual
                    ";
			$query = $db->query($sql);
			return $query->result_array();
		}

		public function viewProvince()
		{
			$sql = "select province_id, province_name from sys.sys_area_province";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function viewCity($prov_id)
		{
			$sql = "select city_regency_id, province_id, regency_name from sys.sys_area_city_regency where province_id = '$prov_id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function viewDistrict($city_id)
		{
			$sql = "select district_id, district_name, city_regency_id from sys.sys_area_district where city_regency_id = '$city_id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function viewVillage($vill_id)
		{
			$sql = "select district_id, village_id, village_name from sys.sys_area_village where district_id = '$vill_id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function viewContentSetup()
		{
			$sql = "select 
					a.org_id, 
					a.org_name, 
					a.org_code,
					b.province_name, 
					c.regency_name, 
					d.district_name, 
					e.village_name, 
					a.address
					from sys.sys_organization a
					left join sys.sys_area_province b on b.province_id = a.province_id
					left join sys.sys_area_city_regency c on c.city_regency_id = a.city_regency_id
					left join sys.sys_area_district d on d.district_id = a.district_id
					left join sys.sys_area_village e on e.village_id = a.village_id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function cekRow($org_id)
		{
			$sql = "select * from sys.sys_organization where org_id = '$org_id'";
			$query = $this->db->query($sql);
			return $query->num_rows();
		}

		public function saveSetup($province,$city,$kecamatan,$kelurahan,$alamat,$org_id,$org_code,$org_name)
		{
			$sql = "insert into sys.sys_organization (org_id, org_name, org_code, province_id, city_regency_id, district_id, village_id, address) values ($org_id, '$org_name', '$org_code', $province, $city, $kecamatan, $kelurahan, '$alamat')";
			$query = $this->db->query($sql);
		}

		public function getFiltered($org_id,$month,$year,$order_type)
		{
			$sql = "select * from 
					sf.sales_target 
					where org_id = '$org_id' and 
					month = '$month' and 
					year = '$year' and
					order_type LIKE '%$order_type%'";
			$query = $this->db->query($sql);
			return $query->num_rows();
		}

		public function deleteOrg($org_id)
		{
			$sql = "delete from sys.sys_organization where org_id = '$org_id'";
			$query = $this->db->query($sql);
		}

		public function getDataDetail($org_id)
		{
			$sql = "select 
					a.org_id, 
					a.org_name, 
					a.org_code,
					b.province_name,
					b.province_id, 
					c.regency_name,
					c.city_regency_id,
					d.district_name, 
					d.district_id,
					e.village_name, 
					e.village_id,
					a.address
					from sys.sys_organization a
					left join sys.sys_area_province b on b.province_id = a.province_id
					left join sys.sys_area_city_regency c on c.city_regency_id = a.city_regency_id
					left join sys.sys_area_district d on d.district_id = a.district_id
					left join sys.sys_area_village e on e.village_id = a.village_id
					where a.org_id = '$org_id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function updateOrg($province,$city,$kecamatan,$kelurahan,$alamat,$org_id,$org_code,$org_name)
		{
			$sql = "update sys.sys_organization 
					set 
						province_id = '$province',
						city_regency_id = '$city',
						district_id = '$kecamatan',
						village_id = '$kelurahan',
						org_code = '$org_code',
						org_id = '$org_id',
						org_name = '$org_name',
						address = '$alamat' 
					where org_id = '$org_id'";
			$query = $this->db->query($sql);
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