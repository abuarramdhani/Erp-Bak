<?php 
class m_input extends CI_Model
{
	
	public function __construct()
		{
			parent::__construct();
			$this->load->database();
			$this->oracle = $this->load->database('oracle_dev',true);
		}
	public function getData(){
		$sql = "SELECT kmpt.UPDATE_ID, kmpt.UPDATE_DATE, kmpt.SEGMENT1, kmpt.DESCRIPTION, kmpt.PRIMARY_UOM_CODE, kmpt.SECONDARY_UOM_CODE, kmpt.FULL_NAME, kmpt.PREPROCESSING_LEAD_TIME, kmpt.PREPARATION_PO, kmpt.DELIVERY, kmpt.FULL_LEAD_TIME, kmpt.POSTPROCESSING_LEAD_TIME, kmpt.TOTAL_LEADTIME, kmpt.MINIMUM_ORDER_QUANTITY, kmpt.FIXED_LOT_MULTIPLIER, kmpt.ATTRIBUTE18, kmpt.STATUS, kmpt.KETERANGAN, kmpt.CETAK
			FROM KHS_MONITORING_PEMBELIAN_TEMP kmpt
			ORDER BY kmpt.UPDATE_ID";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
}

?>