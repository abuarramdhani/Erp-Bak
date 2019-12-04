<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Approve extends CI_Controller {


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

		$data['data'] = $this->M_approve->getDevice($user);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemAdministration/MainMenu/Android/Approve/V_index',$data);
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

		$data['android'] = $this->M_approve->getDeviceById($user,$id);
		if(empty($data['android'])){
			redirect(base_url('SystemAdministration/Android/ApproveAtasan'));
		}else{			
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SystemAdministration/MainMenu/Android/Approve/V_edit',$data);
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
		if($optSubmit == 'Request Remove'){
			$this->M_approve->RequestRemoveById($user,$id,$keterangan);
			redirect(base_url('SystemAdministration/Android/ApproveAtasan'));
		}elseif($optSubmit == 'Approve'){
			$this->M_approve->approveAtasanById($user,$id,$keterangan,$noinduk,$namaPekerja);
			redirect(base_url('SystemAdministration/Android/ApproveAtasan'));
		}elseif ($optSubmit == 'Reject') {
			$this->M_approve->rejectDAtasanById($user,$id,$keterangan);
			redirect(base_url('SystemAdministration/Android/ApproveAtasan'));
		}else{
			redirect(base_url('SystemAdministration/Android/ApproveAtasan'));
		}
	}

}

?>