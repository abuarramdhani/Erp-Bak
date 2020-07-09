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
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_replacecomp');
		$this->load->model('ManufacturingOperationUP2L/Ajax/M_ajax');

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
		$this->load->view('ManufacturingOperationUP2L/ReplaceComp/V_index', $data);
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
		$this->load->view('ManufacturingOperationUP2L/ReplaceComp/V_view', $data);
		$this->load->view('V_Footer',$data);
	}

	public function clearJob($id)
	{
		$this->M_replacecomp->deleteRejectComp($id);
		redirect(base_url('ManufacturingOperationUP2L/Job/ReplaceComp/viewJob/'.$id));
	}

	public function submitJobForm($id)
	{
		$this->load->library('Pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8','A4-L', 0, '', 9, 9, 9, 9); 
		$filename = 'Report_Job_'.$id.'.pdf';
		$data['jobHeader'] = $this->M_replacecomp->getJobHeader($id);
		$data['jobLine'] = $this->M_replacecomp->getJobLine($id);
		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$html = $this->load->view('ManufacturingOperationUP2L/ReplaceComp/V_reportform', $data, true);
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');
	}

	public function submitJobKIB($id)
	{
		$this->load->library('Pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8','A4-P', 0, '', 9, 9, 9, 9); 
		$filename = 'Report_Job_'.$id.'.pdf';
		$data['jobHeader'] = $this->M_replacecomp->getJobHeader($id);
		$data['jobLine'] = $this->M_replacecomp->getJobLine($id);
		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$html = $this->load->view('ManufacturingOperationUP2L/ReplaceComp/V_reportkib', $data, true);
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');
	}

	public function deleteRejectComp($id,$crID)
	{
		$this->M_ajax->deleteRejectComp($crID);
		redirect(base_url('ManufacturingOperationUP2L/Job/ReplaceComp/viewJob/'.$id));
	}
}