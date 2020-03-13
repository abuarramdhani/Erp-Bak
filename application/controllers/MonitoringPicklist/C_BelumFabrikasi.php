<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_BelumFabrikasi extends CI_Controller
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
		$this->load->model('MonitoringPicklist/M_pickfabrikasi');

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

		$data['Title'] = 'Belum Approve Fabrikasi';
		$data['Menu'] = 'Belum Approve Fabrikasi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPicklist/FABRIKASI/V_BelumFabrikasi');
		$this->load->view('V_Footer',$data);
	}

	function searchData(){
		$dept 		= $this->input->post('dept');
		$tanggal 	= $this->input->post('tanggal');

		$data['data'] = $this->M_pickfabrikasi->getdataBelum($dept, $tanggal);
		
		$this->load->view('MonitoringPicklist/FABRIKASI/V_TblBelumFabrikasi', $data);
	}

	function approveData(){
		$picklist = $this->input->post('picklist');
		$nojob = $this->input->post('nojob');
		$user = $this->session->user;
		// echo "<pre>";print_r($nojob);exit();

		$this->M_pickfabrikasi->approveData($picklist, $nojob, $user);
	}


}