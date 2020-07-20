<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_CarJatuhTempo extends CI_Controller
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
		$this->load->model('MonitoringFlowOut/M_internal');

		$this->checkSession();
	}

	public function checkSession()
	{
		if ($this->session->is_logged) { } else {
			redirect('');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'CAR Jatuh Tempo';
		$data['Menu'] = 'CAR Jatuh Tempo';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['dats']  = $this->M_internal->getInternalLess();

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MonitoringFlowOut/V_CarJatuhTempo', $data);
		$this->load->view('V_Footer', $data);
	}
	public function search()
	{
		$txtTglMFO1 = $this->input->post('txtTglMFO1');
		$txtTglMFO2 = $this->input->post('txtTglMFO2');
		$slcSeksiFAjx = $this->input->post('slcSeksiFAjx');
		
		$newtxtTglMFO1 = date('Y-m-d', strtotime($txtTglMFO1));
		$newtxtTglMFO2 = date('Y-m-d', strtotime($txtTglMFO2));
		$data['dats'] = $this->M_internal->getInternalbyDate($newtxtTglMFO1, $newtxtTglMFO2, $slcSeksiFAjx);
		if (empty($data['dats'])){
			echo "<center><h3 style='color:red;'>Data tidak ditemukan</h3></center>";
		} else {
		return $this->load->view('MonitoringFlowOut/V_ViewResultCar', $data);
		}
	}
}
