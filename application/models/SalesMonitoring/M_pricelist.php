<?php
class M_pricelist extends CI_Model {

        public function __construct()
        {
            $this->load->database();
			$this->load->library('encrypt');
        }
		
		//read (compatible)
		public function viewPricelist()
		{
			$sql = "select * from sf.pricelist_index sfp, im.im_master_items imm where sfp.pricelist_index_id = imm.item_id order by pricelist_index_id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	
		//download data as CSV (compatible)
		function downloadpricelistcsv()
		{	
			$this->load->dbutil();
			$q=$this->db->query("select sfp.item_code, imm.item_name, sfp.price from sf.pricelist_index sfp, im.im_master_items imm where sfp.pricelist_index_id = imm.item_id order by pricelist_index_id");
			$delimiter = ",";
			$newline = "\r\n";
			return $this->dbutil->csv_from_result($q,$delimiter,$newline);
		}
		
		//download data as XML (compatible)
		function downloadpricelistxml()
		{	
			$this->load->dbutil();
			$query = $this->db->query("select sfp.item_code, imm.item_name, sfp.price from sf.pricelist_index sfp, im.im_master_items imm where sfp.pricelist_index_id = imm.item_id order by pricelist_index_id");
			$config = array (
								  'root'    => 'root',
								  'element' => 'element', 
								  'newline' => "\n", 
								  'tab'    => "\t"
							);

			return $this->dbutil->xml_from_result($query, $config);
		}
		
		//create
		public function insertPricelist($itemcode,$price,$startdate,$enddate,$lastupdated,$lastupdateby,$creationdate,$createdby)
		{
			$sql = "insert into sf.pricelist_index(item_code,price,start_date,end_date,last_updated,last_update_by,creation_date,created_by)values('$itemcode','$price',$startdate,$enddate,$lastupdated,$lastupdateby,$creationdate,'$createdby')";
			$query = $this->db->query($sql);
			return;
		}
		
		//update
		public function updatePricelist($id,$itemcode,$price,$startdate,$enddate,$lastupdated,$lastupdateby,$creationdate,$createdby)
		{
			$sql = "update sf.pricelist_index set 
			item_code='$itemcode',price='$price',start_date='$startdate',end_date=$enddate,last_updated=$lastupdated,last_update_by='$lastupdateby',creation_date='$creationdate',created_by='$createdby' where pricelist_index_id='$id'";
			$query = $this->db->query($sql);
			return;
		}
		
	
		//delete
		public function deletePricelist($id)
		{
			$sql = "delete from sf.pricelist_index where pricelist_index_id='$id'";
			$query = $this->db->query($sql);
			return;
		}
		
		//get data for update
		function searchPricelist($id)
		{
			$sql = "select * from sf.pricelist_index where pricelist_index_id='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
	
		
}
?>