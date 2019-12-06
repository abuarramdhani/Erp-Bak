<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Personalia extends CI_Controller {


	public function __construct()
    {
    	parent::__construct();

    	$this->load->helper('url');
    	$this->load->helper('html');
    	$this->load->library('session');
    	$this->load->helper(array('form', 'url'));
	    $this->load->library('form_validation');

    	$this->load->model('SystemAdministration/MainMenu/M_user');
    	$this->load->model('SystemAdministration/MainMenu/Android/M_approve');
    }
	
	public function index()
	{
		$user_id = $this->session->userid;
		$user = $this->session->user;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$data['Title']		= 'Mobile Approval';
		
		$data['UserMenu']		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_approve->getDevicePersonalia($user);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemAdministration/MainMenu/Android/Approve/V_personalia',$data);
		$this->load->view('V_Footer',$data);
	}

	public function edit($id){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$data['Title']		= 'Mobile Approval';
		
		$data['UserMenu']		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['android'] = $this->M_approve->getDevicePersonaliaById($user,$id);
		if(empty($data['android'])){
			redirect(base_url('SystemAdministration/Android/ApprovePersonalia'));
		}else{			
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SystemAdministration/MainMenu/Android/Approve/V_update',$data);
			$this->load->view('V_Footer',$data);
		}
	}

	public function updateData($id){
		$user = $this->session->user;
		$optSubmit = $this->input->post('txtSubmit');
		$keterangan  = $this->input->post('andro-ket');
		$noinduk 		= $this->input->post('noindukKaryawan');
		$noinduk 		= strtoupper($noinduk);
		$namaPekerja	= $this->input->post('andro-employee');

		// echo "<pre>";print_r($_POST);exit();
		if($optSubmit == 'Remove'){
			$this->M_approve->RemoveById($user,$id,$keterangan);
			redirect(base_url('SystemAdministration/Android/ApprovePersonalia'));
		}elseif($optSubmit == 'Approve'){
			$this->M_approve->approveDeviceById($user,$id,$keterangan,$noinduk,$namaPekerja);
			redirect(base_url('SystemAdministration/Android/ApprovePersonalia'));
		}elseif ($optSubmit == 'Reject') {
			$this->M_approve->rejectDeviceById($user,$id,$keterangan);
			redirect(base_url('SystemAdministration/Android/ApprovePersonalia'));
		}else{
			redirect(base_url('SystemAdministration/Android/ApprovePersonalia'));
		}
	}

}

?>