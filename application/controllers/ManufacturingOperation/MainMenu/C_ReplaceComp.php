<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_ReplaceComp extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ManufacturingOperation/MainMenu/M_replacecomp');
		$this->load->model('ManufacturingOperation/Ajax/M_ajax');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Replacement Component';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/ReplaceComp/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function viewJob($id)
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Replacement Component';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu']		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$jobLine 				= $this->M_replacecomp->getJobLine($id);
		$jobLineReject 			= $this->M_replacecomp->getJobLineReject($id);
		$data['jobHeader']		= $this->M_replacecomp->getJobHeader($id);
		$data['jobLineReject']	= $jobLineReject;
		$dataJobLine			= array();
		foreach ($jobLine as $key => $val) {
			$reject = 0;
			foreach ($jobLineReject as $value) {
				if ($val['SEGMENT1'] == $value['component_code']) {
					$reject += $value['return_quantity'];
				}
			}

			$dataJobLine[$key] = array(
				'WIP_ENTITY_NAME'		=> $val['WIP_ENTITY_NAME'],
				'ASSY'					=> $val['ASSY'],
				'DESCRIPTION'			=> $val['DESCRIPTION'],
				'SEKSI'					=> $val['SEKSI'],
				'OPERATION_SEQ_NUM'		=> $val['OPERATION_SEQ_NUM'],
				'SEGMENT1'				=> $val['SEGMENT1'],
				'COMPONENT_QUANTITY'	=> $val['QUANTITY_ISSUED'],
				'PRIMARY_UOM_CODE'		=> $val['PRIMARY_UOM_CODE'],
				'SUPPLY_TYPESUPPLY_TYPE'=> $val['SUPPLY_TYPE'],
				'SUBINVENTORY_CODE'		=> $val['SUBINVENTORY_CODE'],
				'ASAL'					=> $val['ASAL'],
				'INVENTORY_ITEM_ID'		=> $val['INVENTORY_ITEM_ID'],
				'ORGANIZATION_ID'		=> $val['ORGANIZATION_ID'],
				'REJECT_QTY'			=> $reject
			);
		}

		$data['jobLine']	= $dataJobLine;
		$data['id']			= $id;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/ReplaceComp/V_view', $data);
		$this->load->view('V_Footer',$data);
	}

	public function clearJob($id)
	{
		$this->M_replacecomp->deleteRejectComp($id);
		redirect(base_url('ManufacturingOperation/Job/ReplaceComp/viewJob/'.$id));
	}

	public function submitJobForm($id)
	{
		$user_id	= $this->session->userid;
		$subinv 	= $this->input->post('subinvFormReject');
		$jobHeader 	= $this->M_replacecomp->getJobHeader($id);

		// ------ GENERATE REJECT NUMBER ------
			$jobReplacementNumber 	= $this->M_replacecomp->getJobReplacementNumber($id,$subinv);
			if (empty($jobReplacementNumber)) {
				$codeNumber = date('ym');
				$lastNumber = $this->M_replacecomp->getLatestJobReplacementNumber($codeNumber);

				if (!empty($lastNumber)) {
					$nextNumber = strval(intval(substr($lastNumber[0]['max'], 4))+1);
					$tambahanKarakter = '';

					for ($i=5; $i > strlen($nextNumber) ; $i--) { 
						$tambahanKarakter .= '0';
					}
					$finalNumber = strval($tambahanKarakter.$nextNumber);

				}else{
					$nextNumber = '00001';
				}
				$replacement_number = $codeNumber.$finalNumber;
				$inputData = array(
					'replacement_number'	=> $replacement_number,
					'job_number'			=> $id,
					'assy_code'				=> $jobHeader[0]['SEGMENT1'],
					'assy_description'		=> $jobHeader[0]['DESCRIPTION'],
					'section'				=> $jobHeader[0]['SEKSI'],
					'subinventory_code'		=> $subinv,
					'created_by'			=> $user_id,
					'created_date'			=> date('Y-m-d')
				);
				$jobReplacementNumber = $this->M_replacecomp->setJobReplacementNumber($inputData);

				$data['replacement_number']		= $jobReplacementNumber[0]['replacement_number'];
			}else{
				$data['replacement_number']		= $jobReplacementNumber[0]['replacement_number'];
			}
		// ------ GENERATE QRCODE ------
			$this->load->library('ciqrcode');
			// ------ create directory temporary qrcode ------
				if(!is_dir('./assets/upload/ManufacturingOperation'))
				{
					mkdir('./assets/upload/ManufacturingOperation', 0777, true);
					chmod('./assets/upload/ManufacturingOperation', 0777);
				}
				if(!is_dir('./assets/upload/ManufacturingOperation/temp'))
				{
					mkdir('./assets/upload/ManufacturingOperation/temp', 0777, true);
					chmod('./assets/upload/ManufacturingOperation/temp', 0777);
				}
				if(!is_dir('./assets/upload/ManufacturingOperation/temp/qrcode'))
				{
					mkdir('./assets/upload/ManufacturingOperation/temp/qrcode', 0777, true);
					chmod('./assets/upload/ManufacturingOperation/temp/qrcode', 0777);
				}
			$params['data']		= $data['replacement_number'];
			$params['level']	= 'H';
			$params['size']		= 10;
			$params['black']	= array(255,255,255);
			$params['white']	= array(0,0,0);
			$params['savename'] = './assets/upload/ManufacturingOperation/temp/qrcode/'.$data['replacement_number'].'.png';
			$this->ciqrcode->generate($params);
		// ------ GENERATE PDF ------
			$this->load->library('Pdf');
			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8','A5-L', 0, '', 4, 4, 4, 4);
			$filename				= 'Report_Job_'.$id.'_'.$subinv.'.pdf';
			$jobLineReject 			= $this->M_replacecomp->getJobLineReject($id,$subinv);
			$rowCount = 0;
			$rowPerPage = 15;
			$page = 0;
			$RejectPerPage = array();
			foreach ($jobLineReject as $value) {
				// ---- masukin data ke page mana ----
					if ($rowCount < $rowPerPage) {
						$RejectPerPage[$page][] = $value;
					}elseif ($rowCount >= $rowPerPage) {
						$page++;
						$rowCount = 0;
						$RejectPerPage[$page][] = $value;
					}
				// ---- baca panjang data deskripsi ----
					if (strlen($value['component_description']) > strlen($value['return_information'])) {
						$panjangData = strlen($value['component_description']);
					}else{
						$panjangData = strlen($value['return_information']);
					}
				// ---- cek data udah memakan berapa row ----
					if ($panjangData < 37) {
						$rowCount += 1;
					}elseif ($panjangData >= 37 && $panjangData < 74) {
						$rowCount += 2;
					}elseif ($panjangData >= 74 && $panjangData < 111) {
						$rowCount += 3;
					}elseif ($panjangData >= 111 && $panjangData < 148) {
						$rowCount += 4;
					}elseif ($panjangData >= 148 && $panjangData < 185) {
						$rowCount += 5;
					}elseif ($panjangData >= 185 && $panjangData < 222) {
						$rowCount += 6;
					}else{
						$rowCount += 7;
					}
			}
			for ($i=$rowCount; $i < 15; $i++) { 
				$RejectPerPage[$page][] = array(
					'component_code'		=> '',
					'component_description' => '',
					'uom'					=> '',
					'picklist_quantity'		=> '',
					'return_quantity'		=> '',
					'return_information'	=> '',
				);
			}
			$dataPerPage = array();
			for ($i=0; $i <= $page ; $i++) { 
				$dataPerPage[] = array(
					'i'	=> $i,
					'WIP_ENTITY_NAME'	=> $jobHeader[0]['WIP_ENTITY_NAME'],
					'RELEASE'			=> $jobHeader[0]['RELEASE'],
					'SEGMENT1'			=> $jobHeader[0]['SEGMENT1'],
					'DESCRIPTION'		=> $jobHeader[0]['DESCRIPTION'],
					'SEKSI'				=> $jobHeader[0]['SEKSI'],
					'DATA_BODY'			=> $RejectPerPage[$i]
				);
			}
			$data['rejectData']		= $dataPerPage;
			$data['subinv']			= $subinv;
			$html = $this->load->view('ManufacturingOperation/ReplaceComp/V_reportform', $data, true);
			$pdf->WriteHTML($html,0);
			$pdf->Output($filename, 'I');
		if(is_file($params['savename'])){
			unlink($params['savename']);
		}
	}

	public function submitJobKIB($id)
	{
		$user_id = $this->session->userid;
		$this->load->library('Pdf');
		$jobHeader				= $this->M_replacecomp->getJobHeader($id);
		$subinvReject 			= $this->M_ajax->getRejectSubInv($id);
		$replacement_number_tmp	= array();
		foreach ($subinvReject as $value) {
			$jobReplacementNumber 	= $this->M_replacecomp->getJobReplacementNumber($id, $value['subinventory_code']);

			if (empty($jobReplacementNumber)) {
				$codeNumber = date('ym');
				$lastNumber = $this->M_replacecomp->getLatestJobReplacementNumber($codeNumber);

				if (!empty($lastNumber)) {
					$nextNumber = strval(intval(substr($lastNumber[0]['max'], 4))+1);
					$tambahanKarakter = '';

					for ($i=5; $i > strlen($nextNumber) ; $i--) { 
						$tambahanKarakter .= '0';
					}
					$finalNumber = strval($tambahanKarakter.$nextNumber);

				}else{
					$nextNumber = '00001';
				}
				$replacement_number = $codeNumber.$finalNumber;
				$inputData = array(
					'replacement_number'	=> $replacement_number,
					'job_number'			=> $id,
					'assy_code'				=> $jobHeader[0]['SEGMENT1'],
					'assy_description'		=> $jobHeader[0]['DESCRIPTION'],
					'section'				=> $jobHeader[0]['SEKSI'],
					'subinventory_code'		=> $value['subinventory_code'],
					'created_by'			=> $user_id,
					'created_date'			=> date('Y-m-d')
				);
				$jobReplacementNumber = $this->M_replacecomp->setJobReplacementNumber($inputData);

				$replacement_number_tmp[]		= array(
					'job_number'			=> $id,
					'replacement_number'	=> $jobReplacementNumber[0]['replacement_number'],
					'subinventory_code'		=> $value['subinventory_code'],
				);
			}else{
				$replacement_number_tmp[]		= array(
					'job_number'			=> $id,
					'replacement_number'	=> $jobReplacementNumber[0]['replacement_number'],
					'subinventory_code'		=> $value['subinventory_code'],
				);
			}
		}

		$data['replacement_number'] = $replacement_number_tmp;
		$data['jobHeader']		= $jobHeader;
		$data['jobLineReject']	= $this->M_replacecomp->getJobLineReject($id);
		$pdf 					= $this->pdf->load();
		$pdf 					= new mPDF('utf-8','A4-P', 0, '', 3, 3, 3, 3);
		$filename				= 'KIB_Report_Job_'.$id.'.pdf';
		$html = $this->load->view('ManufacturingOperation/ReplaceComp/V_reportkib', $data, true);
		$pdf->WriteHTML($html,0);
		$pdf->Output($filename, 'I');
	}

	public function deleteRejectComp($id,$crID)
	{
		$this->M_ajax->deleteRejectComp($crID);
		redirect(base_url('ManufacturingOperation/Job/ReplaceComp/viewJob/'.$id));
	}
}