<?php 
class M_monitoring extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->oracle = $this->load->database('oracle',true);
	}	
	public function getData(){
		$sql = "select msib.segment1 
						,msib.description
						,msib.PRIMARY_UOM_CODE
						,msib.SECONDARY_UOM_CODE
				        ,ppf.FULL_NAME
				        ,msib.PREPROCESSING_LEAD_TIME
				        ,msib.attribute6
                        ,msib.attribute8
				        ,msib.FULL_LEAD_TIME
				        ,msib.POSTPROCESSING_LEAD_TIME
				        ,msib.PREPROCESSING_LEAD_TIME+msib.FULL_LEAD_TIME+msib.POSTPROCESSING_LEAD_TIME total_leadtime
				        ,msib.MINIMUM_ORDER_QUANTITY
				        ,msib.FIXED_LOT_MULTIPLIER
				        ,msib.attribute18
				        ,msib.RECEIVE_CLOSE_TOLERANCE
						,msib.QTY_RCV_TOLERANCE
				        from mtl_system_items_b msib
						,per_people_f ppf
				        where msib.BUYER_ID = ppf.PERSON_ID
				        and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
				        and msib.PLANNING_MAKE_BUY_CODE = 2
				        and msib.organization_id = 81";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
	public function getDataCsv(){
		$sql = "select msib.segment1 
						,msib.description
						,msib.PRIMARY_UOM_CODE
						,msib.SECONDARY_UOM_CODE
				        ,ppf.FULL_NAME
				        ,msib.PREPROCESSING_LEAD_TIME
				        ,msib.attribute6
                        ,msib.attribute8
				        ,msib.POSTPROCESSING_LEAD_TIME
				        ,msib.MINIMUM_ORDER_QUANTITY
				        ,msib.FIXED_LOT_MULTIPLIER
				        ,msib.attribute18
				        ,msib.RECEIVE_CLOSE_TOLERANCE
						,msib.QTY_RCV_TOLERANCE
				        from mtl_system_items_b msib
						,per_people_f ppf
				        where msib.BUYER_ID = ppf.PERSON_ID
				        and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
				        and msib.PLANNING_MAKE_BUY_CODE = 2
				        and msib.organization_id = 81
				        ORDER BY msib.segment1";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
	public function getBuyer(){
		$sql = "select ppf.NATIONAL_IDENTIFIER, ppf.FULL_NAME from per_people_f ppf
        		where ppf.EFFECTIVE_END_DATE > sysdate
        		and ppf.PERSON_TYPE_ID = 6
        		and ppf.ATTRIBUTE3 like '%PEMBELIAN%'";
        $query = $this->oracle->query($sql);
		return $query->result_array();
	}
	public function savePerubahan($data){
			for ($j = 0 ; $j < sizeof($data) ; $j++) { 
				$this->oracle->insert('KHS_MONITORING_PEMBELIAN_TEMP', $data[$j]);
			}
		}
	public function searchItem($data){
			$sql = "select msib.segment1 
					,msib.description
					,msib.PRIMARY_UOM_CODE
					,msib.SECONDARY_UOM_CODE
					,msib.buyer_id
					,ppf.FULL_NAME
					,msib.PREPROCESSING_LEAD_TIME
					,msib.attribute6
                    ,msib.attribute8
					,msib.FULL_LEAD_TIME
					,msib.POSTPROCESSING_LEAD_TIME
					,msib.PREPROCESSING_LEAD_TIME+msib.FULL_LEAD_TIME+msib.POSTPROCESSING_LEAD_TIME total_leadtime
					,msib.MINIMUM_ORDER_QUANTITY
					,msib.FIXED_LOT_MULTIPLIER
					,msib.RECEIVE_CLOSE_TOLERANCE
					,msib.QTY_RCV_TOLERANCE
					,msib.attribute18
					from mtl_system_items_b msib
					,per_people_f ppf
					where msib.BUYER_ID = ppf.PERSON_ID
					and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
					and msib.PLANNING_MAKE_BUY_CODE = 2
					and msib.organization_id = 81
					AND (msib.DESCRIPTION LIKE '%$data%' 
               		OR msib.SEGMENT1 LIKE '%$data%')";
        $query = $this->oracle->query($sql);
		return $query->result_array();
	}	
	public function getApprover(){
		$sql = "select * from fnd_flex_values ffv where ffv.FLEX_VALUE_SET_ID = '1018344' order by flex_value";
		// $sql = "select distinct ppf.FIRST_NAME ||' '|| ppf.LAST_NAME name from khs_approver_po kap, per_people_f ppf where kap.APPROVER_PERSON_ID = ppf.PERSON_ID";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
	public function getApproverN(){
		$sql = "select flex_value from fnd_flex_values ffv where ffv.FLEX_VALUE_SET_ID = '1018344' and ffv.FLEX_VALUE_ID = '302279'";
		// $sql = "select kap.*, ppf.FIRST_NAME ||' '|| ppf.LAST_NAME name from khs_approver_po kap, per_people_f ppf where kap.APPROVER_PERSON_ID = ppf.PERSON_ID AND kap.APPROVER_ITEM_GROUP = 'N'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
	public function getApproverQ(){
		$sql = "select flex_value from fnd_flex_values ffv where ffv.FLEX_VALUE_SET_ID = '1018344' and ffv.FLEX_VALUE_ID = '302279'";
		// $sql = "select kap.*, ppf.FIRST_NAME ||' '|| ppf.LAST_NAME name from khs_approver_po kap, per_people_f ppf where kap.APPROVER_PERSON_ID = ppf.PERSON_ID AND kap.APPROVER_ITEM_GROUP = 'Q'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
	public function getApproverG(){
		$sql = "select flex_value from fnd_flex_values ffv where ffv.FLEX_VALUE_SET_ID = '1018344' and ffv.FLEX_VALUE_ID = '302281'";
		// $sql = "select kap.*, ppf.FIRST_NAME ||' '|| ppf.LAST_NAME name from khs_approver_po kap, per_people_f ppf where kap.APPROVER_PERSON_ID = ppf.PERSON_ID AND kap.APPROVER_ITEM_GROUP = 'G'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
	public function getApproverH(){
		$sql = "select flex_value from fnd_flex_values ffv where ffv.FLEX_VALUE_SET_ID = '1018344' and ffv.FLEX_VALUE_ID = '302281'";
		// $sql = "select kap.*, ppf.FIRST_NAME ||' '|| ppf.LAST_NAME name from khs_approver_po kap, per_people_f ppf where kap.APPROVER_PERSON_ID = ppf.PERSON_ID AND kap.APPROVER_ITEM_GROUP = 'H'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}public function getApproverI(){
		$sql = "select flex_value from fnd_flex_values ffv where ffv.FLEX_VALUE_SET_ID = '1018344' and ffv.FLEX_VALUE_ID = '302281'";
		// $sql = "select kap.*, ppf.FIRST_NAME ||' '|| ppf.LAST_NAME name from khs_approver_po kap, per_people_f ppf where kap.APPROVER_PERSON_ID = ppf.PERSON_ID AND kap.APPROVER_ITEM_GROUP = 'I'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}public function getApproverL(){
		$sql = "select flex_value from fnd_flex_values ffv where ffv.FLEX_VALUE_SET_ID = '1018344' and ffv.FLEX_VALUE_ID = '302283'";
		// $sql = "select kap.*, ppf.FIRST_NAME ||' '|| ppf.LAST_NAME name from khs_approver_po kap, per_people_f ppf where kap.APPROVER_PERSON_ID = ppf.PERSON_ID AND kap.APPROVER_ITEM_GROUP = 'L'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}public function getApproverP(){
		$sql = "select flex_value from fnd_flex_values ffv where ffv.FLEX_VALUE_SET_ID = '1018344' and ffv.FLEX_VALUE_ID = '302283'";
		// $sql = "select kap.*, ppf.FIRST_NAME ||' '|| ppf.LAST_NAME name from khs_approver_po kap, per_people_f ppf where kap.APPROVER_PERSON_ID = ppf.PERSON_ID AND kap.APPROVER_ITEM_GROUP = 'P'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}public function getApproverS(){
		$sql = "select flex_value from fnd_flex_values ffv where ffv.FLEX_VALUE_SET_ID = '1018344' and ffv.FLEX_VALUE_ID = '302283'";
		// $sql = "select kap.*, ppf.FIRST_NAME ||' '|| ppf.LAST_NAME name from khs_approver_po kap, per_people_f ppf where kap.APPROVER_PERSON_ID = ppf.PERSON_ID AND kap.APPROVER_ITEM_GROUP = 'S'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}public function getApproverR(){
		$sql = "select flex_value from fnd_flex_values ffv where ffv.FLEX_VALUE_SET_ID = '1018344' and ffv.FLEX_VALUE_ID = '302284'";
		// $sql = "select kap.*, ppf.FIRST_NAME ||' '|| ppf.LAST_NAME name from khs_approver_po kap, per_people_f ppf where kap.APPROVER_PERSON_ID = ppf.PERSON_ID AND kap.APPROVER_ITEM_GROUP = 'R'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}public function getApproverJ(){
		$sql = "select flex_value from fnd_flex_values ffv where ffv.FLEX_VALUE_SET_ID = '1018344' and ffv.FLEX_VALUE_ID = '302283'";
		// $sql = "select distinct ppf.FIRST_NAME ||' '|| ppf.LAST_NAME name from khs_approver_po kap, per_people_f ppf where kap.APPROVER_PERSON_ID = ppf.PERSON_ID AND kap.APPROVER_PERSON_ID = '1513'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}public function getApproverJASA01(){
		$sql = "select flex_value from fnd_flex_values ffv where ffv.FLEX_VALUE_SET_ID = '1018344' and ffv.FLEX_VALUE_ID = '302281'";
		// $sql = "select kap.*, ppf.FIRST_NAME ||' '|| ppf.LAST_NAME name from khs_approver_po kap, per_people_f ppf where kap.APPROVER_PERSON_ID = ppf.PERSON_ID AND kap.APPROVER_ITEM_GROUP = 'JASA01'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}public function getApproverJANG(){
		$sql = "select flex_value from fnd_flex_values ffv where ffv.FLEX_VALUE_SET_ID = '1018344' and ffv.FLEX_VALUE_ID = '302281'";
		// $sql = "select kap.*, ppf.FIRST_NAME ||' '|| ppf.LAST_NAME name from khs_approver_po kap, per_people_f ppf where kap.APPROVER_PERSON_ID = ppf.PERSON_ID AND kap.APPROVER_ITEM_GROUP = 'JANG'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}public function getApproverlain(){
		$sql = "select flex_value from fnd_flex_values ffv where ffv.FLEX_VALUE_SET_ID = '1018344' and ffv.FLEX_VALUE_ID = '302284'";
		// $sql = "select distinct ppf.FIRST_NAME ||' '|| ppf.LAST_NAME name from khs_approver_po kap, per_people_f ppf where kap.APPROVER_PERSON_ID = ppf.PERSON_ID AND kap.APPROVER_PERSON_ID = '444'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
	public function cekNomor($num)
    {
        $sql = "SELECT * FROM KHS_MONITORING_PEMBELIAN_TEMP WHERE UPDATE_ID LIKE '%$num'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function getdataEmailPE(){
		$sql = "SELECT CATEGORY, EMAIL FROM KHS_MONITORING_PEMBELIAN_EMAIL WHERE CATEGORY = 'PE'";
		$query = $this->oracle->query($sql);
		return $query->result_array();		
	}
	public function getdataEmailPembelian(){
		$sql = "SELECT CATEGORY, EMAIL FROM KHS_MONITORING_PEMBELIAN_EMAIL WHERE CATEGORY = 'PEMBELIAN'";
		$query = $this->oracle->query($sql);
		return $query->result_array();		
	}
	public function UpdateEmailPembelian($email){
		$sql = "INSERT INTO KHS_MONITORING_PEMBELIAN_EMAIL (CATEGORY, EMAIL) VALUES ('PEMBELIAN','$email')";
		$query = $this->oracle->query($sql);
	}
	public function HapusEmailPembelian($email){
		$sql = "DELETE FROM KHS_MONITORING_PEMBELIAN_EMAIL WHERE CATEGORY = 'PEMBELIAN' AND EMAIL = '$email'";
		$query = $this->oracle->query($sql);
	}

	public function getdataPDF($nodok){
		$sql = "select * from KHS_MONITORING_PEMBELIAN_TEMP WHERE UPDATE_ID = '$nodok' AND CETAK = '0' ORDER BY SEGMENT1";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function setCetak($nodok){
		$sql = "UPDATE KHS_MONITORING_PEMBELIAN_TEMP SET CETAK = '1' WHERE UPDATE_ID = '$nodok'";
		$query = $this->oracle->query($sql);
	}
}