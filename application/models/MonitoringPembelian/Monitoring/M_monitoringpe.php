<?php 
class M_monitoringpe extends CI_Model
{
	
	public function __construct()
		{
			parent::__construct();
			$this->load->database();
			$this->oracle = $this->load->database('oracle',true);
		}
	public function getData(){
		$sql = "SELECT distinct ppf.PERSON_ID, kmpt.UPDATE_ID,kmpt.UPDATE_DATE, kmpt.SEGMENT1, kmpt.DESCRIPTION, kmpt.PRIMARY_UOM_CODE, kmpt.SECONDARY_UOM_CODE, kmpt.FULL_NAME, kmpt.PREPROCESSING_LEAD_TIME, kmpt.PREPARATION_PO, kmpt.DELIVERY, kmpt.FULL_LEAD_TIME, kmpt.POSTPROCESSING_LEAD_TIME, kmpt.TOTAL_LEADTIME, kmpt.MINIMUM_ORDER_QUANTITY, kmpt.FIXED_LOT_MULTIPLIER, kmpt.ATTRIBUTE18, kmpt.STATUS, kmpt.KETERANGAN  
			FROM KHS_MONITORING_PEMBELIAN_TEMP kmpt, per_people_f ppf
			WHERE kmpt.STATUS  = 'UNAPPROVED'
			AND kmpt.FULL_NAME = ppf.FULL_NAME";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function getDataHistory(){
		$sql = "SELECT kmpt.UPDATE_ID,kmpt.UPDATE_DATE, kmpt.SEGMENT1, kmpt.DESCRIPTION, kmpt.PRIMARY_UOM_CODE, kmpt.SECONDARY_UOM_CODE, kmpt.FULL_NAME, kmpt.PREPROCESSING_LEAD_TIME, kmpt.PREPARATION_PO, kmpt.DELIVERY, kmpt.FULL_LEAD_TIME, kmpt.POSTPROCESSING_LEAD_TIME, kmpt.TOTAL_LEADTIME, kmpt.MINIMUM_ORDER_QUANTITY, kmpt.FIXED_LOT_MULTIPLIER, kmpt.ATTRIBUTE18, kmpt.STATUS, kmpt.KETERANGAN 
			FROM KHS_MONITORING_PEMBELIAN_TEMP kmpt
			ORDER BY STATUS DESC";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}


	public function getDataUpdatePE($id){
		$sql = "SELECT kmpt.UPDATE_DATE, kmpt.SEGMENT1, kmpt.DESCRIPTION, kmpt.PRIMARY_UOM_CODE, kmpt.SECONDARY_UOM_CODE, kmpt.FULL_NAME, kmpt.PREPROCESSING_LEAD_TIME, kmpt.PREPARATION_PO, kmpt.DELIVERY, kmpt.FULL_LEAD_TIME, kmpt.POSTPROCESSING_LEAD_TIME, kmpt.TOTAL_LEADTIME, kmpt.MINIMUM_ORDER_QUANTITY, kmpt.FIXED_LOT_MULTIPLIER, kmpt.ATTRIBUTE18, kmpt.STATUS, kmpt.KETERANGAN  
			FROM KHS_MONITORING_PEMBELIAN_TEMP kmpt
			WHERE kmpt.SEGMENT1 ='$id'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function UpdatePembelianPE($data){

			for ($j = 0 ; $j < sizeof($data) ; $j++) { 
				
				if ($data[$j]['STATUS'] == 'REJECTED') {
					$this->oracle->set('STATUS',$data[$j]['STATUS']);
					$this->oracle->where('SEGMENT1', $data[$j]['SEGMENT1']);
					$this->oracle->where('UPDATE_ID', $data[$j]['UPDATE_ID']);
					$this->oracle->update('KHS_MONITORING_PEMBELIAN_TEMP');

				} elseif ($data[$j]['STATUS'] == 'APPROVED') {
					$this->oracle->set('STATUS',$data[$j]['STATUS']);
					$this->oracle->where('SEGMENT1', $data[$j]['SEGMENT1']);
					$this->oracle->where('UPDATE_ID', $data[$j]['UPDATE_ID']);
					$this->oracle->update('KHS_MONITORING_PEMBELIAN_TEMP');

					$this->oracle->set('PREPROCESSING_LEAD_TIME',$data[$j]['PREPROCESSING_LEAD_TIME']);
					$this->oracle->set('ATTRIBUTE6',$data[$j]['PREPARATION_PO']);
					$this->oracle->set('ATTRIBUTE8',$data[$j]['DELIVERY']);
					$this->oracle->set('FULL_LEAD_TIME',$data[$j]['FULL_LEAD_TIME']);
					$this->oracle->set('POSTPROCESSING_LEAD_TIME',$data[$j]['POSTPROCESSING_LEAD_TIME']);
					$this->oracle->set('MINIMUM_ORDER_QUANTITY',$data[$j]['MINIMUM_ORDER_QUANTITY']);
					$this->oracle->set('FIXED_LOT_MULTIPLIER',$data[$j]['FIXED_LOT_MULTIPLIER']);
					$this->oracle->set('ATTRIBUTE18',$data[$j]['ATTRIBUTE18']);
					$this->oracle->set('BUYER_ID', $data[$j]['BUYER_ID']);
					$this->oracle->where('SEGMENT1', $data[$j]['SEGMENT1']);
					$this->oracle->update('MTL_SYSTEM_ITEMS_B');


				} elseif ($data[$j]['STATUS'] == 'UNAPPROVED') {

				}

			}
	}

	public function getdataEmailPembelian(){
		$sql = "SELECT CATEGORY, EMAIL FROM KHS_MONITORING_PEMBELIAN_EMAIL WHERE CATEGORY = 'PEMBELIAN'";
		$query = $this->oracle->query($sql);
		return $query->result_array();		
	}
	public function getdataEmailPE(){
		$sql = "SELECT CATEGORY, EMAIL FROM KHS_MONITORING_PEMBELIAN_EMAIL WHERE CATEGORY = 'PE'";
		$query = $this->oracle->query($sql);
		return $query->result_array();		
	}
	public function UpdateEmailPE($email){
		$sql = "INSERT INTO KHS_MONITORING_PEMBELIAN_EMAIL (CATEGORY, EMAIL) VALUES ('PE','$email')";
		$query = $this->oracle->query($sql);
	}
	public function HapusEmailPE($email){
		$sql = "DELETE FROM KHS_MONITORING_PEMBELIAN_EMAIL WHERE CATEGORY = 'PE' AND EMAIL = '$email'";
		$query = $this->oracle->query($sql);
	}

}