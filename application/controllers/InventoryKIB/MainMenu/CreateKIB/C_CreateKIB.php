<?php defined('BASEPATH') OR die('No direct script access allowed');
class C_CreateKIB extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		 $this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
	        $this->load->library('ciqrcode');
	          //load the login model
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('InventoryKIB/M_createkib');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}
	}

	public function checkSession()
		{
			if($this->session->is_logged){
				}else{
					redirect();
				}

		}

	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('InventoryKIB/MainMenu/CreateKIB/V_KIB',$data);
		$this->load->view('V_Footer',$data);
	}

	public function search($no){
		// check Period
		$date = date('M-y');
		$period = $this->M_createkib->getPeriod($date);
		if ($period == 'N') {
			exit('Period Belum Dimulai, Silahkan Hubungi Akuntansi :)');
		} 		
		$data['header'] = $this->M_createkib->getHeader($no);
		$data['detail'] = $this->M_createkib->getDetail($no);
		if ($data['header']) {
			$getOrg = $this->M_createkib->getOrgFrom($no);
			$org_from = $getOrg[0]['ORGANIZATION_CODE'];
			$data['handling'] = $this->M_createkib->getHandling($data['header'][0]['ITEM_CODE'],$org_from);


			$getDefaultValue = $this->M_createkib->getDataDefault($no);
			if ($getDefaultValue) {
				$data['valdef']['to_org_id'] = ($getDefaultValue[0]['TO_ORGANIZATION_ID']) ? $getDefaultValue[0]['TO_ORGANIZATION_ID'] : '';
				$data['valdef']['to_sub_inv'] = ($getDefaultValue[0]['TO_SUBINVENTORY_CODE']) ? $getDefaultValue[0]['TO_SUBINVENTORY_CODE'] : '';
				$data['valdef']['to_locator_id'] = ($getDefaultValue[0]['TO_LOCATOR_ID']) ? $getDefaultValue[0]['TO_LOCATOR_ID'] : '';
			}else{
				$data['valdef'] =  array();
			}
		} else {
			$data['handling'] = '';
		}

		$QtyComp = $this->qtyComparation($no);
		$message = '';
		if ($QtyComp !== false) {
			if ($QtyComp[0] === false) {
				$message = "Quantity Plan dan Aktual tidak sama, tidak bisa print KIB. <br>";
				$message .=  "Quantity Plan = <b>".$QtyComp[1]."</b> ; Quantity Aktual = <b>".$QtyComp[2]."</b>";
				$data['result'] = false;
			} else {
				$data['result'] = true;

				foreach ($data['detail'] as $key => $value) {
					$status = $value['STATUS'] == 'OK' ? '1' : ($value['STATUS'] == 'REJECT' ? '2' : '3' );
					$getMO = $this->M_createkib->getMO($no,$status);
					if ($getMO == 0) {
						$getKIB = $this->M_createkib->getKIB2($status,$no,null);
						$resultMO = count($getKIB) > 0 ? '1' : '0';
					} else {
						$resultMO = $getMO > 0 ? '1' : '0';
					}
					
					$data['detail'][$key]['MO'] = $resultMO;
					$data['detail'][$key]['STATUS_ITEM'] = $status;
				}
			}			
		} else {
			$data['result'] = false;
			$message = "No data Found :( ";
		}
			$data['message'] = $message;
			$this->load->view('InventoryKIB/MainMenu/CreateKIB/V_Result',$data);
	}

	public function qtyComparation($no){
		$getQty = $this->M_createkib->getQty($no);
		if ($getQty) {
			$qty_plan   = $getQty[0]['PLAN_QTY'];
			$qty_actual = $getQty[0]['ACTUAL_QTY'];
			$comp = $qty_actual == $qty_plan ? true : false;
			$det_qty = array($comp,$qty_plan,$qty_actual);
			return $det_qty;
		} else {
			return false;
		}
		
	}

	public function getSubInv(){
		$org = $this->input->post('org');
		$getSubInv = $this->M_createkib->getSubInv($org);
			echo "<option></option>";
		foreach ($getSubInv as $key => $value) {
			echo '<option data-desc="'.$value['SUB_INV_DESC'].'" value ="'.$value['SUB_INV_CODE'].'" > '.$value['SUB_INV_CODE'].' </option>';
		}
	}

	public function getLocator(){
		$org = $this->input->post('org');
		$subInv = $this->input->post('subinv');
		$getLocator = $this->M_createkib->getLocator($org,$subInv);
		foreach ($getLocator as $key => $value) {
			echo '<option value ="'.$value['INVENTORY_LOCATION_ID'].'" > '.$value['DESCRIPTION'].' </option>';
		}
	}

	public function pdf($status,$no_batch,$kib)
	{
		$n = 0;
		$org = 'opm';
		$this->printpdf($org,$status,$no_batch,$kib,$n);
	}

	public function pdf1($status,$no_batch,$kib)
	{
		//$no_batch menampung item
		$n = 1;
		$org = 'opm';
		$this->printpdf($org,$status,$no_batch,$kib,$n);
	}

	public function pdf2($status,$no_batch,$kib)
	{
		$n = 0;
		$org = 'odm';
		$this->printpdf($org,$status,$no_batch,$kib,$n);
	}

	public function pdf3($nomorset)
	{
		$org = 'opm';
		$this->load->library('ciqrcode');
		$this->load->library('Pdf');
		$pdf 			= $this->pdf->load();
		

		$dataKIB = $this->M_createkib->getKIB3($nomorset);
		// echo "<pre>";
		// print_r($dataKIB);
		// exit();
		$dataKIBKelompok  =array();
		$arrayREQNUM = array();
		// $tanggal = $this->M_createkib->getSysdate();
		date_default_timezone_set("Asia/Jakarta");
		$tanggal = date("d-M-Y G:i:s"); 
		$a = 0;
		// echo "<PRE>";
		// print_r($tanggal);
		// exit();

		foreach ($dataKIB as $key => $value) {

			if (in_array($value['NOMORSET'], $arrayREQNUM)) {
				$indexnya = array_search($value['NOMORSET'], $arrayREQNUM);
				$dataKIBKelompok[$indexnya]['KOMPONEN'][] = array('KODE_KOMP' => $value['KODE_KOMP'],
															'QTY_KIB' => $value['QTY_KIB'],
															'DESC_KOMP' => $value['DESC_KOMP'],
															'UOM_KOMP' => $value['UOM_KOMP']
														);
			} else {
				array_push($arrayREQNUM, $value['NOMORSET']);
				$getOrg = $this->M_createkib->getOrgFrom($no_batch);
				$org_from = $getOrg[0]['ORGANIZATION_CODE'];
				$qty_handling_nu = $this->M_createkib->getHandling($value['TO_SUBINVENTORY_CODE'],$org_from);
				$indexnya = array_search($value['NOMORSET'], $arrayREQNUM);
				// $arrayREQNUM[] = $value['NOMORSET'];
				$dataKIBKelompok[$indexnya]['FROM_SUBINVENTORY_CODE'] = $value['FROM_SUBINVENTORY_CODE'];
				$dataKIBKelompok[$indexnya]['FROM_LOCATOR'] = $value['FROM_LOCATOR'];
				$dataKIBKelompok[$indexnya]['TO_SUBINVENTORY_CODE'] = $value['TO_SUBINVENTORY_CODE'];
				$dataKIBKelompok[$indexnya]['TO_LOCATOR'] = $value['TO_LOCATOR'];
				$dataKIBKelompok[$indexnya]['KODE_ASSY'] = $value['KODE_ASSY'];
				$dataKIBKelompok[$indexnya]['DESC_ASSY'] = $value['DESC_ASSY'];
				$dataKIBKelompok[$indexnya]['UOM_ASSY'] = $value['UOM_ASSY'];
				$dataKIBKelompok[$indexnya]['KOMPONEN'][] = array('KODE_KOMP' => $value['KODE_KOMP'],
														'QTY_KIB' => $value['QTY_KIB'],
														'DESC_KOMP' => $value['DESC_KOMP'],
														'UOM_KOMP' => $value['UOM_KOMP']);
				// $dataKIBKelompok[$indexnya]['DESCRIPTION'] = $value['DESCRIPTION'];
				// $dataKIBKelompok[$indexnya]['KODE_KONTAINER'] = $value['KODE_KONTAINER'];
				// $dataKIBKelompok[$indexnya]['DESKRIPSI_KONTAINER'] = $value['DESKRIPSI_KONTAINER'];
				// $dataKIBKelompok[$indexnya]['TIPE_PRODUCT'] = $value['TIPE_PRODUCT'];
				// $dataKIBKelompok[$indexnya]['PLAN_QTY'] = $value['PLAN_QTY'];
				// $dataKIBKelompok[$indexnya]['ACTUAL_QTY'] = $value['ACTUAL_QTY'];
				// $dataKIBKelompok[$indexnya]['QUANTITY'] = $value['QUANTITY'] ;
				// $dataKIBKelompok[$indexnya]['HANDLING_QTY'] = $value['HANDLING_QTY'];
				$dataKIBKelompok[$indexnya]['QTY_ASSY'] = $value['QTY_ASSY'];
				$dataKIBKelompok[$indexnya]['NOMORSET'] = $value['NOMORSET'];
				$dataKIBKelompok[$indexnya]['BATCH_NUMBER'] = $value['BATCH_NUMBER'];
				$dataKIBKelompok[$indexnya]['ALIAS_KODE'] = $value['ALIAS_KODE'];
				$dataKIBKelompok[$indexnya]['TANGGAL'] = $tanggal;
				// $a++;
			}
			
		}

		$data['dataKIB'] = $dataKIBKelompok;
		// echo "<pre>";
		$length = sizeof($data['dataKIB'][0]['KOMPONEN']);
		if ($length != 0) {
			$size = $length * 48 ;
		} else {
			$size = 48;
		} 
		
		// echo "$size";
		// print_r($data['dataKIB']);
		// exit();
		$pdf = new mPDF('utf-8',array(210,$size), 0, '', 13, 13, 0, 20, 0, 0);
		if($data['dataKIB']):
			// ------ GENERATE QRCODE ------
			if(!is_dir('./assets/img'))
			{
				mkdir('./assets/img', 0777, true);
				chmod('./assets/img', 0777);
			}

			$temp_filename = array();
			foreach ($data['dataKIB'] as $kib) {
				$params['data']		= $kib['NOMORSET'];
				$params['level']	= 'H';
				$params['size']		= 3;
				$config['black']	= array(224,255,255);
				$config['white']	= array(70,130,180);
				$params['savename'] = './assets/img/'.$kib['NOMORSET'].'.png';
				$this->ciqrcode->generate($params);
				array_push($temp_filename, $params['savename']);
			}
		endif;

		$data['dataKIB'] = $dataKIBKelompok;
		// echo "<pre>";
		// print_r($data);
		// exit();
		$filename			= 'KIB_'.time().'.pdf';
		$html = $this->load->view('InventoryKIB/MainMenu/CreateKIB/V_Pdf3',$data,true);
		// echo "$html";
		// exit();
		$pdf->WriteHTML($html,0);
		$pdf->Output($filename, 'I');
		if (!empty($temp_filename)) {
				foreach ($temp_filename as $tf) {
					if(is_file($tf)){
						unlink($tf);
					}
				}
			}


	}


	public function printpdf($org,$status,$no_batch,$kib,$n){
		$length = 370;
		if ($status == 1 || $n == 1) {
			$length = 290;
		}
		$this->load->library('ciqrcode');
		$this->load->library('Pdf');
		$pdf 			= $this->pdf->load();
		$pdf = new mPDF('utf-8',array(210,$length), 0, '', 13, 13, 0, 20, 0, 0);

		if ($status == '0' && $kib == '0') {
			exit('Status & No kib is null');
		}

		if ($kib == '0') {
			$kib = null;
		}

		if ($status == '0') {
			$status = null;
		}

		$dataKIBKelompok  =array();
		$arrayREQNUM = array();
		if ($org == 'opm') {
			if ($n == 1) {
				$dataKIB = $this->M_createkib->getKIB222($status,$no_batch,$kib);	
			} else {
				$dataKIB = $this->M_createkib->getKIB2($status,$no_batch,$kib);	
			}
		}elseif ($org == 'odm') {
			$dataKIB = $this->M_createkib->getKIB22($status,$no_batch,$kib);
		}
		// echo "<pre>";
		// print_r($dataKIB);
		// exit();
		$a = 0;
		foreach ($dataKIB as $key => $value) {

			if (in_array($value['REQUEST_NUMBER'], $arrayREQNUM)) {
				$indexnya = array_search($value['REQUEST_NUMBER'], $arrayREQNUM);
				$dataKIBKelompok[$indexnya]['OPR'][] = array('OPR_SEQ' => $value['OPR_SEQ'],
														'ACTIVITY' => $value['ACTIVITY']);
			} else {
				array_push($arrayREQNUM, $value['REQUEST_NUMBER']);
				$getOrg = $this->M_createkib->getOrgFrom($no_batch);
				$org_from = $getOrg[0]['ORGANIZATION_CODE'];
				$qty_handling_nu = $this->M_createkib->getHandling($value['TO_SUBINVENTORY_CODE'],$org_from);
				$indexnya = array_search($value['REQUEST_NUMBER'], $arrayREQNUM);
				// $arrayREQNUM[] = $value['REQUEST_NUMBER'];
				$dataKIBKelompok[$indexnya]['FROM_SUBINVENTORY_CODE'] = $value['FROM_SUBINVENTORY_CODE'];
				$dataKIBKelompok[$indexnya]['TO_SUBINVENTORY_CODE'] = $value['TO_SUBINVENTORY_CODE'];
				$dataKIBKelompok[$indexnya]['ITEM_CODE'] = $value['ITEM_CODE'];
				$dataKIBKelompok[$indexnya]['OPR'][] = array('OPR_SEQ' => $value['OPR_SEQ'],
														'ACTIVITY' => $value['ACTIVITY']);
				$dataKIBKelompok[$indexnya]['DESCRIPTION'] = $value['DESCRIPTION'];
				$dataKIBKelompok[$indexnya]['KODE_KONTAINER'] = $value['KODE_KONTAINER'];
				$dataKIBKelompok[$indexnya]['DESKRIPSI_KONTAINER'] = $value['DESKRIPSI_KONTAINER'];
				$dataKIBKelompok[$indexnya]['TIPE_PRODUCT'] = $value['TIPE_PRODUCT'];
				$dataKIBKelompok[$indexnya]['PLAN_QTY'] = $value['PLAN_QTY'];
				$dataKIBKelompok[$indexnya]['ACTUAL_QTY'] = $value['ACTUAL_QTY'];
				$dataKIBKelompok[$indexnya]['QUANTITY'] = $value['QUANTITY'] ;
				$dataKIBKelompok[$indexnya]['HANDLING_QTY'] = $value['HANDLING_QTY'];
				$dataKIBKelompok[$indexnya]['STATUS'] = $value['STATUS'];
				$dataKIBKelompok[$indexnya]['REQUEST_NUMBER'] = $value['REQUEST_NUMBER'];
				$dataKIBKelompok[$indexnya]['BATCH_NUMBER'] = $value['BATCH_NUMBER'];
				$dataKIBKelompok[$indexnya]['ALIAS_KODE'] = $value['ALIAS_KODE'];
				// $a++;
			}
			
		}
		// echo "<pre>";
		// print_r($dataKIBKelompok);
		// exit();
		if ($dataKIBKelompok) {
			$this->M_createkib->updateFlagPrint($no_batch,$kib);
		}
		$data['dataKIB'] = $dataKIBKelompok;


		if($data['dataKIB']):
			// ------ GENERATE QRCODE ------
			if(!is_dir('./assets/img'))
			{
				mkdir('./assets/img', 0777, true);
				chmod('./assets/img', 0777);
			}

			$temp_filename = array();
			foreach ($data['dataKIB'] as $kib) {
				$params['data']		= $kib['REQUEST_NUMBER'];
				$params['level']	= 'H';
				$params['size']		= 3;
				$config['black']	= array(224,255,255);
				$config['white']	= array(70,130,180);
				$params['savename'] = './assets/img/'.$kib['REQUEST_NUMBER'].'.png';
				$this->ciqrcode->generate($params);
				array_push($temp_filename, $params['savename']);
			}
		endif;
		

		$filename			= 'KIB_'.time().'.pdf';
		$html = $this->load->view('InventoryKIB/MainMenu/CreateKIB/V_Pdf',$data,true);
		$pdf->WriteHTML($html,0);
		$pdf->Output($filename, 'I');

		if (!empty($temp_filename)) {
				foreach ($temp_filename as $tf) {
					if(is_file($tf)){
						unlink($tf);
					}
				}
			}
	}


	public function submitpdf(){
		$no_batch = $this->input->post('txtNoBatch');
		$status = $this->input->post('txtStatus');
		$uom = $this->input->post('txtUom');
		$ip_address =  $this->input->ip_address();
		$subInv = $this->input->post('slcSubInvIMO');
		$locator = $this->input->post('slcLocator');
		$subInvFrom = $this->input->post('txtSubInvFrom');
		$locatorFrom = $this->input->post('txtLocatorFrom');
		$org = $this->input->post('slcOrgIMO');
		$qty_handling = $this->input->post('qtyHandling');
		$qty_target = $this->input->post('txtQtyTarget');
		$getOrg = $this->M_createkib->getOrgFrom($no_batch);
		$org_from = $getOrg[0]['ORGANIZATION_CODE'];

		//check again, chill
		$getMO = $this->M_createkib->getMO($no_batch,$status);

		if ($getMO == 0):
		//check Org 
		if($org  == $org_from){
			//get Job ID & inventory item id
			$getJobID = $this->M_createkib->getJobID($no_batch);
			if ($getJobID) {
				$job_id = $getJobID[0]['BATCH_ID'];
				$inv_item_id = $getJobID[0]['INVENTORY_ITEM_ID'];
			} else {
				exit('No job ID / Inventory Item Id');
			}

			$per_handling = ceil($qty_target/$qty_handling);
			for ($i=1; $i <= $per_handling; $i++) { 
				$qty = $i == $per_handling ? ($qty_target%$qty_handling) : $qty_handling ;
				$data = array('NO_URUT' => $i,
								'INVENTORY_ITEM_ID' => $inv_item_id,
								'QUANTITY' => $qty,
								'UOM' => $uom,
								'IP_ADDRESS' => $ip_address,
								'JOB_ID' => $job_id);
				//create TEMP
				$this->M_createkib->createTemp($data);

				//create MO
				$this->M_createkib->createMO($i,$ip_address,$job_id,$subInv,$locator,$subInvFrom,$locatorFrom,$status);

				//delete
				$this->M_createkib->deleteTemp($ip_address,$job_id);

			}
		}else{
			//get Job ID & inventory item id
			$getJobID = $this->M_createkib->getJobID($no_batch);
			if ($getJobID) {
				$job_id = $getJobID[0]['BATCH_ID'];
				$inv_item_id = $getJobID[0]['INVENTORY_ITEM_ID'];
			} else {
				exit('No job ID / Inventory Item Id');
			}

			$getDataKIB = $this->M_createkib->getDataKIB($qty_handling,$no_batch);
			$getOrgId = $this->M_createkib->getOrgId($org);
			$orgId = $getOrgId[0]['ORGANIZATION_ID'];
			$per_handling = ceil($qty_target/$qty_handling);
			for ($i=1; $i <= $per_handling; $i++) { 
				$getNumKIB = $this->M_createkib->getKIBNumber2($job_id);
				$numKIB = $getNumKIB[0]['NO_KIB'];
				$qty = $i == $per_handling ? ($qty_target%$qty_handling) : $qty_handling ;

				if ($getDataKIB) {
					foreach ($getDataKIB as $key => $value) {
						if ($key+1 == count($getDataKIB)):
						$data = array(
							'ORGANIZATION_ID' => $value['ORGANIZATION_ID'],
							'ROUTING_DEPT_CLASS' => $value['ROUTING_DEPT_CLASS'],
							'PLANED_DATE' => $value['PLANED_DATE'],
							'PLANSHIFT_NUM' => $value['PLANSHIFT_NUM'],
							'OPRN_ID' => $value['OPRN_ID'],
							'PRIMARY_ITEM_ID' => $value['PRIMARY_ITEM_ID'],
							'SCHEDULED_QUANTITY' => $value['SCHEDULED_QUANTITY'],
							'QTY_KIB' => $qty,
							'DEPARTMENT_ID' => $value['DEPARTMENT_ID'],
							'KIBCODE' => $numKIB,
							'KIB_GROUP' => $value['KIB_GROUP'],
							'INVENTORY_TRANS_FLAG' => $value['INVENTORY_TRANS_FLAG'],
							'QTY_TRANSACTION' => $value['QTY_TRANSACTION'],
							'ORDER_ID' => $value['ORDER_ID'],
							'FLAG_CANCEL' => $value['FLAG_CANCEL'],
							'CREATION_DATE' => $value['CREATION_DATE'],
							'BATCHSTEP_ID' => $value['BATCHSTEP_ID'],
							'TO_ORG_ID' => $orgId,
							'TO_SUBINVENTORY_CODE' => $subInv,
							'TO_LOCATOR_ID' => $locator,
							'ITEM_STATUS' => $status,
						);

						$this->M_createkib->saveKIB($data);
						endif;
					}
				}
				
			}

		}
		endif;

		//output
		$this->pdf($status,$no_batch,0);

	}

}