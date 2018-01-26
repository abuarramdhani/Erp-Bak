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

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['jobHeader'] = $this->M_replacecomp->getJobHeader($id);
		$data['jobLine'] = $this->M_replacecomp->getJobLine($id);

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

	public function submitJob($id)
	{
		$this->load->library('Pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8','A4-L', 0, '', 9, 9, 9, 9); 
		$filename = 'Report_Job_'.$id.'.pdf';
		$data['jobHeader'] = $this->M_replacecomp->getJobHeader($id);
		$data['jobLine'] = $this->M_replacecomp->getJobLine($id);
		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$html = $this->load->view('ManufacturingOperation/ReplaceComp/V_report', $data, true);
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');
	}
}