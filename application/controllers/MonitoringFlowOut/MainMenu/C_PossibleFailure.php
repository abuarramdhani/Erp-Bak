<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_PossibleFailure extends CI_Controller
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
		$this->load->model('MonitoringFlowOut/M_master');

		$this->checkSession();
	}

	public function checkSession()
	{
		if ($this->session->is_logged) { } else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Possible Failure';
		$data['Menu'] = 'Possible Failure';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['possibleFailure'] = $this->M_master->getPoss();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MonitoringFlowOut/Master/V_PossibleFailure', $data);
		$this->load->view('V_Footer', $data);
	}

	function setPoss()
	{
		$iniPossFail = $_POST['txtPossibleFailure'];
		$this->M_master->setPoss($iniPossFail);
		redirect('MonitoringFlowOut/PossibleFailure');
	}

	function delPoss($id)
	{
		$this->M_master->delPoss($id);
		echo 1;
	}

	function updPoss()
	{
		$id = $this->input->post('id');
		$newPoss = $this->input->post('newPoss');
		$this->M_master->updPoss($id, $newPoss);
		echo 1;
	}
}
