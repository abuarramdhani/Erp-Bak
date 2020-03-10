<?php 
class M_monitoringpe extends CI_Model
{
	
	public function __construct()
		{
			parent::__construct();
			$this->load->database();
			$this->oracle = $this->load->database('oracle',true);
		}

	// datatable serverside1
				public $table = "KHS_MONITORING_PEMBELIAN_TEMP";
				public $select_column = array("UPDATE_ID", "UPDATE_DATE", "SEGMENT1", "DESCRIPTION", "PRIMARY_UOM_CODE", "SECONDARY_UOM_CODE", "FULL_NAME", "PREPROCESSING_LEAD_TIME", "PREPARATION_PO", "DELIVERY", "FULL_LEAD_TIME", "POSTPROCESSING_LEAD_TIME", "TOTAL_LEADTIME"
				, "MINIMUM_ORDER_QUANTITY", "FIXED_LOT_MULTIPLIER", "ATTRIBUTE18", "STATUS", "KETERANGAN", "RECEIVE_CLOSE_TOLERANCE", "QTY_RCV_TOLERANCE");
				public $order_column = array("UPDATE_ID", null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null );

				public function make_query()
				{
						$this->oracle->select($this->select_column);
						$this->oracle->from($this->table);
						if (isset($_POST["search"]["value"])) {
								$this->oracle->like("UPDATE_ID", $_POST["search"]["value"]);
								$this->oracle->or_like("UPDATE_DATE", $_POST["search"]["value"]);
								$this->oracle->or_like("SEGMENT1", $_POST["search"]["value"]);
								$this->oracle->or_like("DESCRIPTION", $_POST["search"]["value"]);
								$this->oracle->or_like("PRIMARY_UOM_CODE", $_POST["search"]["value"]);
								$this->oracle->or_like("SECONDARY_UOM_CODE", $_POST["search"]["value"]);
								$this->oracle->or_like("FULL_NAME", $_POST["search"]["value"]);
								$this->oracle->or_like("STATUS", $_POST["search"]["value"], 'after');
						}
						if (isset($_POST["order"])) {
								$this->oracle->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
						} else {
								$this->oracle->order_by('UPDATE_ID', 'DESC');
						}
				}

				public function make_datatables()
				{
						$this->make_query();
						if ($_POST["length"] != -1) {
								$this->oracle->limit($_POST['length'], $_POST['start']);
						}
						$query = $this->oracle->get();
						return $query->result();
				}

				public function get_filtered_data()
				{
						$this->make_query();
						$query = $this->oracle->get();
						return $query->num_rows();
				}

				public function get_all_data()
				{
						$this->oracle->select($this->select_column);
						$this->oracle->from($this->table);
						return $this->oracle->count_all_results();
				}

	public function getData(){
		$sql = "SELECT distinct ppf.PERSON_ID, kmpt.UPDATE_ID,kmpt.UPDATE_DATE, kmpt.SEGMENT1, kmpt.DESCRIPTION, kmpt.PRIMARY_UOM_CODE, kmpt.SECONDARY_UOM_CODE, kmpt.FULL_NAME, kmpt.PREPROCESSING_LEAD_TIME, kmpt.PREPARATION_PO, kmpt.DELIVERY, kmpt.FULL_LEAD_TIME, kmpt.POSTPROCESSING_LEAD_TIME, kmpt.TOTAL_LEADTIME, kmpt.MINIMUM_ORDER_QUANTITY, kmpt.FIXED_LOT_MULTIPLIER, kmpt.ATTRIBUTE18, kmpt.STATUS, kmpt.KETERANGAN , kmpt.RECEIVE_CLOSE_TOLERANCE, kmpt.QTY_RCV_TOLERANCE  
			FROM KHS_MONITORING_PEMBELIAN_TEMP kmpt, per_people_f ppf
			WHERE kmpt.STATUS  = 'UNAPPROVED'
			AND kmpt.FULL_NAME = ppf.FULL_NAME";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function getDataHistory(){
		$sql = "SELECT kmpt.UPDATE_ID,kmpt.UPDATE_DATE, kmpt.SEGMENT1, kmpt.DESCRIPTION, kmpt.PRIMARY_UOM_CODE, kmpt.SECONDARY_UOM_CODE, kmpt.FULL_NAME, kmpt.PREPROCESSING_LEAD_TIME, kmpt.PREPARATION_PO, kmpt.DELIVERY, kmpt.FULL_LEAD_TIME, kmpt.POSTPROCESSING_LEAD_TIME, kmpt.TOTAL_LEADTIME, kmpt.MINIMUM_ORDER_QUANTITY, kmpt.FIXED_LOT_MULTIPLIER, kmpt.ATTRIBUTE18, kmpt.STATUS, kmpt.KETERANGAN , kmpt.RECEIVE_CLOSE_TOLERANCE, kmpt.QTY_RCV_TOLERANCE 
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

	public function getInvItemId($SEGMENT1){
		$sql = "SELECT distinct INVENTORY_ITEM_ID from mtl_system_items_b where SEGMENT1 = '$SEGMENT1'";
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

					// $this->oracle->set('FULL_LEAD_TIME',$data[$j]['FULL_LEAD_TIME']);
					// $this->oracle->set('POSTPROCESSING_LEAD_TIME',$data[$j]['POSTPROCESSING_LEAD_TIME']);
					// $this->oracle->set('MINIMUM_ORDER_QUANTITY',$data[$j]['MINIMUM_ORDER_QUANTITY']);
					// $this->oracle->set('FIXED_LOT_MULTIPLIER',$data[$j]['FIXED_LOT_MULTIPLIER']);
					// $this->oracle->set('BUYER_ID', $data[$j]['BUYER_ID']);
					// $this->oracle->set('RECEIVE_CLOSE_TOLERANCE', $data[$j]['RECEIVE_CLOSE_TOLERANCE']);
					// $this->oracle->set('QTY_RCV_TOLERANCE', $data[$j]['QTY_RCV_TOLERANCE']);
					// echo "<pre>";
					// print_r($data);
					// exit();
					// if ($data[$j]['INVENTORY_ITEM_ID'] == '') {
					// 	$inv_id = NULL;
					// } else {
						$inv_id = $data[$j]['INVENTORY_ITEM_ID'];
					// }

					// if ($data[$j]['PREPROCESSING_LEAD_TIME'] == '') {
					// 	$prelt = NULL;
					// } else {
						$prelt = $data[$j]['PREPROCESSING_LEAD_TIME'];
					// }

					// if ($data[$j]['FULL_LEAD_TIME'] == '') {
					// 	$flt = NULL;
					// } else {
						$flt = $data[$j]['FULL_LEAD_TIME'];
					// }
					// if ($data[$j]['POSTPROCESSING_LEAD_TIME'] == '') {
					// 	$postlt = NULL;
					// } else {
						$postlt = $data[$j]['POSTPROCESSING_LEAD_TIME'];
					// }
					// if ($data[$j]['MINIMUM_ORDER_QUANTITY'] == '') {
					// 	$moq = NULL;
					// } else {
						$moq = $data[$j]['MINIMUM_ORDER_QUANTITY'];
					// }
					// if ($data[$j]['FIXED_LOT_MULTIPLIER'] == '') {
					// 	$flm = NULL;
					// } else {
						$flm = $data[$j]['FIXED_LOT_MULTIPLIER'];
					// }
					// if ($data[$j]['BUYER_ID'] == '') {
					// 	$buyer = NULL;
					// } else {
						$buyer = $data[$j]['BUYER_ID'];
					// }
					// if ($data[$j]['RECEIVE_CLOSE_TOLERANCE'] == '') {
					// 	$rct = NULL;
					// } else {
						$rct = $data[$j]['RECEIVE_CLOSE_TOLERANCE'];
					// }
					// if ($data[$j]['QTY_RCV_TOLERANCE'] == '') {
					// 	$qrt = NULL;
					// } else {
						$qrt = $data[$j]['QTY_RCV_TOLERANCE'];
					// }

					$sql = "BEGIN APPS.khs_update_master_item_proc ('$inv_id', '$prelt', '$flt', '$postlt', '$moq', '$flm', '$buyer', '$rct', '$qrt' ); END;";

					// echo "<pre>";
					// print_r($sql);
					// exit();
					$query = $this->oracle->query($sql);

					// $this->oracle->set('STATUS',$data[$j]['STATUS']);
					// $this->oracle->where('SEGMENT1', $data[$j]['SEGMENT1']);
					// $this->oracle->where('UPDATE_ID', $data[$j]['UPDATE_ID']);
					// $this->oracle->update('KHS_MONITORING_PEMBELIAN_TEMP');

					$this->oracle->set('PREPROCESSING_LEAD_TIME',$data[$j]['PREPROCESSING_LEAD_TIME']);
					$this->oracle->set('ATTRIBUTE6',$data[$j]['PREPARATION_PO']);
					$this->oracle->set('ATTRIBUTE8',$data[$j]['DELIVERY']);
					// $this->oracle->set('FULL_LEAD_TIME',$data[$j]['FULL_LEAD_TIME']);
					// $this->oracle->set('POSTPROCESSING_LEAD_TIME',$data[$j]['POSTPROCESSING_LEAD_TIME']);
					// $this->oracle->set('MINIMUM_ORDER_QUANTITY',$data[$j]['MINIMUM_ORDER_QUANTITY']);
					// $this->oracle->set('FIXED_LOT_MULTIPLIER',$data[$j]['FIXED_LOT_MULTIPLIER']);
					$this->oracle->set('ATTRIBUTE18',$data[$j]['ATTRIBUTE18']);
					// $this->oracle->set('BUYER_ID', $data[$j]['BUYER_ID']);
					$this->oracle->where('SEGMENT1', $data[$j]['SEGMENT1']);
					$this->oracle->update('MTL_SYSTEM_ITEMS_B');

					///////////////////////////////////////////////////////////////////UPDATE TABEL TEMPORARY
					$this->oracle->set('STATUS',$data[$j]['STATUS']);
					$this->oracle->where('SEGMENT1', $data[$j]['SEGMENT1']);
					$this->oracle->where('UPDATE_ID', $data[$j]['UPDATE_ID']);
					$this->oracle->update('KHS_MONITORING_PEMBELIAN_TEMP');

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