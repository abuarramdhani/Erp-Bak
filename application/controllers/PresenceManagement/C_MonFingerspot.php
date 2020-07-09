<?php 
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
  * 
  */
 class C_MonFingerspot extends CI_Controller
 {
 	
 	function __construct()
 	{
 		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('General');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PresenceManagement/MainMenu/M_monfingerspot');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
 	}

 	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring Scanlog Fingerspot';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['table'] = $this->M_monfingerspot->getDataScanLog();
		// print_r($data['table']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PresenceManagement/MonFingerspot/V_index',$data);
		$this->load->view('V_Footer',$data);
	}
 } 
?>