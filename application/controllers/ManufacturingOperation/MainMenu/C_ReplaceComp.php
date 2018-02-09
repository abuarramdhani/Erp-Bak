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
			redirect('index');
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
				'ITEM_NUM'				=> $val['ITEM_NUM'],
				'SEGMENT1'				=> $val['SEGMENT1'],
				'COMPONENT_QUANTITY'	=> $val['COMPONENT_QUANTITY'],
				'PRIMARY_UOM_CODE'		=> $val['PRIMARY_UOM_CODE'],
				'SUPPLY_TYPESUPPLY_TYPE'=> $val['SUPPLY_TYPE'],
				'SUBINVENTORY_CODE'		=> $val['SUBINVENTORY_CODE'],
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
		$user_id = $this->session->userid;
		$subinv = $this->input->post('subinvFormReject');
		$paperSize = $this->input->post('paperSize');
		$jobHeader = $this->M_replacecomp->getJobHeader($id);
		$jobReplacementNumber 	= $this->M_replacecomp->getJobReplacementNumber($id);

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
			if ($paperSize == 'A4') {
				$pdf = new mPDF('utf-8','A4-L', 0, '', 9, 9, 9, 9);
			}elseif ($paperSize == 'A5') {
				$pdf = new mPDF('utf-8','A5-L', 0, '', 9, 9, 9, 9);
			}
			$filename = 'Report_Job_'.$id.'_'.$subinv.'.pdf';
			$data['jobHeader'] = $jobHeader;
			$data['jobLineReject'] = $this->M_replacecomp->getJobLineReject($id,$subinv);
			$data['subinv'] = $subinv;
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
		$jobReplacementNumber 	= $this->M_replacecomp->getJobReplacementNumber($id);

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
				'created_by'			=> $user_id,
				'created_date'			=> date('Y-m-d')
			);
			$jobReplacementNumber = $this->M_replacecomp->setJobReplacementNumber($inputData);

			$data['replacement_number']		= $jobReplacementNumber[0]['replacement_number'];
		}else{
			$data['replacement_number']		= $jobReplacementNumber[0]['replacement_number'];
		}

		$data['jobHeader']		= $jobHeader;
		$data['jobLineReject']	= $this->M_replacecomp->getJobLineReject($id);
		$pdf 					= $this->pdf->load();
		$pdf 					= new mPDF('utf-8','A4-P', 0, '', 4, 4, 9, 9);
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