<?php
class M_dataassets extends CI_Model {

    public function __construct()
    {
	   parent::__construct();
        $this->load->database();
		$this->load->library('encrypt');
		$this->load->helper('url');
    }
	
	public function array_interlace() { 
		$args = func_get_args(); 
		$total = count($args); 

		if($total < 2) { 
			return FALSE; 
		} 
		
		$i = 0; 
		$j = 0; 
		$arr = array(); 
		
		foreach($args as $arg) { 
			foreach($arg as $v) { 
				$arr[$j] = $v; 
				$j += $total; 
			} 
			
			$i++; 
			$j = $i; 
		} 
		
		ksort($arr); 
		return array_values($arr); 
	} 	
	
	public function GetDataAssets($asset_data_id = FALSE)
	{
		if ($asset_data_id === FALSE){
			$sql = "SELECT * FROM fa.fa_data_assets order by asset_data_id desc";}
		else {
			$sql = "SELECT * FROM fa.fa_data_assets WHERE asset_data_id = $asset_data_id";
		}
		$query = $this->db->query( $sql );
		return $query->result_array();
	}
	
	public function GetDataAssetHistories($asset_data_id = FALSE)
	{
		if ($asset_data_id === FALSE){
			$sql = "SELECT * FROM fa.fa_data_asset_histories ";}
		else {
			$sql = "SELECT * FROM fa.fa_data_asset_histories WHERE asset_data_id = $asset_data_id
					order by creation_date desc";
		}
		$query = $this->db->query( $sql );
		return $query->result_array();
	}
	
	public function TambahDataAssets($data)
	{
		return $this->db->insert('fa.fa_data_assets', $data);
	}

	public function TambahDataAssetHistories($data)
	{
		return $this->db->insert('fa.fa_data_asset_histories', $data);
	}

	function UpdateDataAssets($asset_data_id, $data)
	{
		$this->db->update('fa.fa_data_assets', $data, array('asset_data_id' => $asset_data_id));
	}

	public function getLocation()
	{
		$db2= $this->load->database('oracle', TRUE);
		$sql = $db2->query("select * from HR_LOCATIONS_V");
		return $sql->result_array();
	}

	public function getItemCode()
	{
		$db2= $this->load->database('oracle', TRUE);
		$sql = $db2->query("SELECT ORGANIZATION_ID, DESCRIPTION, SEGMENT1 FROM MTL_SYSTEM_ITEMS_B WHERE END_DATE_ACTIVE is null AND rownum <= 50");
		return $sql->result_array();
	}

	public function getLocationSelect2($term = FALSE)
	{
		if ($term===FALSE){
			$sql = "select segment1||'-'||segment2||'-'||segment3 location from FA_LOCATIONS where rownum<=20";
		}
		else {
			$sql = "select segment1||'-'||segment2||'-'||segment3 location from FA_LOCATIONS where segment1||'-'||segment2||'-'||segment3 like  '%$term%' and rownum<=20";
		}
		if ($term===FALSE){
			$sql2 = "select location from fa.fa_data_assets group by location LIMIT 20";
		}
		else {
			$sql2 = "select location from fa.fa_data_assets where location like  '%$term%' group by location LIMIT 20 ";
		}
		$query1 = $this->db->query($sql2);
		$db2= $this->load->database('oracle', TRUE);
		$query2 = $db2->query($sql);
		// return $query->result();
		$row_set1 = array();
		$row_set2 = array();
		if($query1->num_rows() > 0){
			foreach ($query1->result_array() as $row){
				$row_set1[] = htmlentities(stripslashes($row['location'])); //build an array
			}
		}
		if(count($query2) > 0){
			foreach ($query2->result_array() as $row){
				$row_set2[] = htmlentities(stripslashes($row['LOCATION'])); //build an array
			}
		}
		$row = $this->array_interlace($row_set2,$row_set1);
		// sort($row);
		echo json_encode($row); //format the array into json data
	}
	
	public function getTagNumberJson($term = FALSE)
	{
		if ($term===FALSE){
			$sql = "select tag_number from fa.fa_data_assets group by tag_number LIMIT 20";
		}
		else {
			$sql = "select tag_number from fa.fa_data_assets WHERE upper(tag_number) like '%$term%' group by tag_number LIMIT 20";
		}
		$query1 = $this->db->query($sql);
		// return $query->result();
		if($query1->num_rows() > 0){
			foreach ($query1->result_array() as $row){
				$row_set1[] = htmlentities(stripslashes($row['tag_number'])); //build an array
			}
		}
		echo json_encode($row_set1);
	}
	
	public function getAssetCategory($term = FALSE)
	{
		if ($term===FALSE){
			$sql = "select asset_category from fa.fa_data_assets group by asset_category LIMIT 20";
		}
		else {
			$sql = "select asset_category from fa.fa_data_assets WHERE upper(asset_category) like '%$term%' group by asset_category LIMIT 20";
		}
		$query1 = $this->db->query($sql);
		// return $query->result();
		if($query1->num_rows() > 0){
			foreach ($query1->result_array() as $row){
				$row_set1[] = htmlentities(stripslashes($row['asset_category'])); //build an array
			}
		}
		echo json_encode($row_set1);
	}

	public function getSpecificationSelect2($term = FALSE)
	{
		if ($term===FALSE){
			$sql = "select specification from fa.fa_data_assets group by specification LIMIT 20";
		}
		else {
			$sql = "select specification from fa.fa_data_assets WHERE upper(specification) like '%$term%' group by specification LIMIT 20";
		}
		$query1 = $this->db->query($sql);
		// return $query->result();
		if($query1->num_rows() > 0){
			foreach ($query1->result_array() as $row){
				$row_set1[] = htmlentities(stripslashes($row['specification'])); //build an array
			}
		}
		echo json_encode($row_set1);
	}
	
	public function getItemCodeSelect2($term = FALSE)
	{
		if ($term===FALSE){
			$sql = "select  SEGMENT1||' : '||DESCRIPTION item_code from MTL_SYSTEM_ITEMS_B where rownum<=50 group by SEGMENT1,DESCRIPTION";
		}
		else {
			$sql = "select  SEGMENT1||' : '||DESCRIPTION item_code from MTL_SYSTEM_ITEMS_B WHERE SEGMENT1||' : '||DESCRIPTION like '%$term%' and rownum<=50  group by SEGMENT1,DESCRIPTION";
		}
		$db2= $this->load->database('oracle', TRUE);
		$query1 = $db2->query($sql);
		// return $query->result();
		if($query1->num_rows() > 0){
			foreach ($query1->result_array() as $row){
				$row_set1[] = htmlentities(stripslashes($row['ITEM_CODE'])); //build an array
			}
		}
		echo json_encode($row_set1);
	}
	
	public function getBppbaNumber($term)
	{
		if($term===FALSE){
			$sql = "select bppba_number from fa.fa_data_assets group by bppba_number LIMIT 20";
		}
		else {
			$sql = "select bppba_number from fa.fa_data_assets WHERE upper(bppba_number) like '%$term%' group by bppba_number LIMIT 20";
		}
		$query1 = $this->db->query($sql);
		// return $query->result();
		if($query1->num_rows() > 0){
			foreach ($query1->result_array() as $row){
				$row_set1[] = htmlentities(stripslashes($row['bppba_number'])); //build an array
			}
		}
		echo json_encode($row_set1);
	}
	
	public function getLpaNumber($term)
	{
		if($term===FALSE){
			$sql = "select lpa_number from fa.fa_data_assets group by lpa_number LIMIT 20";
		}
		else {
			$sql = "select lpa_number from fa.fa_data_assets WHERE upper(lpa_number) like '%$term%' group by lpa_number LIMIT 20";
		}
		$query1 = $this->db->query($sql);
		// return $query->result();
		if($query1->num_rows() > 0){
			foreach ($query1->result_array() as $row){
				$row_set1[] = htmlentities(stripslashes($row['lpa_number'])); //build an array
			}
		}
		echo json_encode($row_set1);
	}
	
	public function getTransferNumber($term)
	{
		if($term===FALSE){
			$sql = "select transfer_number from fa.fa_data_assets group by transfer_number LIMIT 20";
		}
		else {
			$sql = "select transfer_number from fa.fa_data_assets WHERE upper(transfer_number) like '%$term%' group by transfer_number LIMIT 20";
		}
		$query1 = $this->db->query($sql);
		// return $query->result();
		if($query1->num_rows() > 0){
			foreach ($query1->result_array() as $row){
				$row_set1[] = htmlentities(stripslashes($row['transfer_number'])); //build an array
			}
		}
		echo json_encode($row_set1);
	}
	
	public function getRetirementNumber($term)
	{
		if($term===FALSE){
			$sql = "select retirement_number from fa.fa_data_assets group by retirement_number LIMIT 20";
		}
		else {
			$sql = "select retirement_number from fa.fa_data_assets WHERE upper(retirement_number) like '%$term%' group by retirement_number LIMIT 20";
		}
		$query1 = $this->db->query($sql);
		// return $query->result();
		if($query1->num_rows() > 0){
			foreach ($query1->result_array() as $row){
				$row_set1[] = htmlentities(stripslashes($row['retirement_number'])); //build an array
			}
		}
		echo json_encode($row_set1);
	}
	
	public function getPpNumber($term)
	{
		if($term===FALSE){
			$sql = "select pp_number from fa.fa_data_assets group by pp_number LIMIT 20";
		}
		else {
			$sql = "select pp_number from fa.fa_data_assets WHERE upper(pp_number) like '%$term%' group by pp_number LIMIT 20";
		}
		$query1 = $this->db->query($sql);
		// return $query->result();
		if($query1->num_rows() > 0){
			foreach ($query1->result_array() as $row){
				$row_set1[] = htmlentities(stripslashes($row['pp_number'])); //build an array
			}
		}
		echo json_encode($row_set1);
	}
	
	public function getPoNumber($term)
	{
		if($term===FALSE){
			$sql = "select po_number from fa.fa_data_assets group by po_number LIMIT 20";
		}
		else {
			$sql = "select po_number from fa.fa_data_assets WHERE upper(po_number) like '%$term%' group by po_number LIMIT 20";
		}
		$query1 = $this->db->query($sql);
		// return $query->result();
		if($query1->num_rows() > 0){
			foreach ($query1->result_array() as $row){
				$row_set1[] = htmlentities(stripslashes($row['po_number'])); //build an array
			}
		}
		echo json_encode($row_set1);
	}
	
	public function getPrNumber($term)
	{
		if($term===FALSE){
			$sql = "select pr_number from fa.fa_data_assets group by pr_number LIMIT 20";
		}
		else {
			$sql = "select pr_number from fa.fa_data_assets WHERE upper(pr_number) like '%$term%' group by pr_number LIMIT 20";
		}
		$query1 = $this->db->query($sql);
		// return $query->result();
		if($query1->num_rows() > 0){
			foreach ($query1->result_array() as $row){
				$row_set1[] = htmlentities(stripslashes($row['pr_number'])); //build an array
			}
		}
		echo json_encode($row_set1);
	}
	
	public function getUploadOracle($term = FALSE)
	{
		if($term===FALSE){
			$sql = "select national_identifier||' - '||first_name||decode(first_name,null,'',' ')||middle_names||decode(middle_names,null,'',' ')||last_name name
					from per_people_f ppf where national_identifier is not null and national_identifier not like '.%' and national_identifier not like '-%'
					and rownum <= 20 group by national_identifier,first_name,middle_names,last_name
					";
		}
		else {
			$sql = "select national_identifier||' - '||first_name||decode(first_name,null,'',' ')||middle_names||decode(middle_names,null,'',' ')||last_name name
					from per_people_f ppf where national_identifier is not null and national_identifier not like '.%' and national_identifier not like '-%'
					and national_identifier||' - '||first_name||decode(first_name,null,'',' ')||middle_names||decode(middle_names,null,'',' ')||last_name like upper('%$term%')
					and rownum <= 20 group by national_identifier,first_name,middle_names,last_name
					";
		}
		$db2= $this->load->database('oracle', TRUE);
		$query1 = $db2->query($sql);
		return $query1->result();
		
	}
	
	public function getBppbaDate($bppba_number)
	{
		$sql= $this->db->query("select * from fa.fa_data_assets WHERE bppba_number='$bppba_number'");
		return $sql->result_array();
	}

	public function getLpaDate($lpa_number)
	{
		$sql= $this->db->query("select * from fa.fa_data_assets WHERE lpa_number='$lpa_number'");
		return $sql->result_array();
	}

	public function getTransferDate($transfer_number)
	{
		$sql= $this->db->query("select * from fa.fa_data_assets WHERE transfer_number='$transfer_number'");
		return $sql->result_array();
	}

	public function getRetirementDate($retirement_number)
	{
		$sql= $this->db->query("select * from fa.fa_data_assets WHERE retirement_number='$retirement_number'");
		return $sql->result_array();
	}

	public function getAddByDate($add_by)
	{
		$sql= $this->db->query("select * from fa.fa_data_assets WHERE add_by='$add_by'");
		return $sql->result_array();
	}
	
	public function getTagNumber($tag_number)
	{
		$sql= $this->db->query("select * from fa.fa_data_assets WHERE tag_number='$tag_number'");
		return $sql->result_array();
	}
	
	public function getOldNumber($old_number)
	{
		$sql= $this->db->query("select * from fa.fa_data_assets WHERE old_number='$old_number'");
		return $sql->result_array();
	}
	
	public function getDuplicate($tag_number,$old_number)
	{
		$sql= $this->db->query("select * from fa.fa_data_assets WHERE (old_number='$old_number'
		or tag_number='$tag_number')");
		return $sql->result_array();
	}
	
	public function getTagNumberId($tag_number,$id)
	{
		$sql= $this->db->query("select * from fa.fa_data_assets WHERE asset_data_id = $id");
		return $sql->result_array();
	}
}