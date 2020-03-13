<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_SudahPPIC extends CI_Controller
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
		$this->load->model('MonitoringPicklist/M_picklistppic');

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

		$data['Title'] = 'Sudah Approve PPIC';
		$data['Menu'] = 'Sudah Approve PPIC';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPicklist/PPIC/V_SudahPPIC');
		$this->load->view('V_Footer',$data);
	}

	function searchData(){
		$dept 	 = $this->input->post('dept');
		$tanggal = $this->input->post('tanggal');

		$data['data'] = $this->M_picklistppic->getDataSudah($dept, $tanggal);
		// echo "<pre>";print_r($tanggal);exit();
		
		$this->load->view('MonitoringPicklist/PPIC/V_TblSudahPPIC', $data);
	}

	function recallData(){
		$nojob = $this->input->post('nojob');
		$picklist = $this->input->post('picklist');
		$cek = $this->M_picklistppic->cekapprove($picklist, $nojob);
		// echo "<pre>";print_r($nojob);exit();
		if (empty($cek)) {
			$recall = $this->M_picklistppic->recallPPIC($picklist, $nojob);
		}
		
	}


}