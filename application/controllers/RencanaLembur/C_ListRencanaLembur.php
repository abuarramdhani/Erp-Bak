<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ListRencanaLembur extends CI_Controller {


	public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('RencanaLembur/M_rencanalembur');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
		}
		$this->checkSession();
    }

	public function checkSession(){
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;
		$user  = $this->session->user;

		$data['Title'] = 'List Rencana Lembur';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_rencanalembur->getRencanaLemburByAtasan($user);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('RencanaLembur/ListRencanaLembur/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function proses(){
		// echo "<pre>";print_r($_POST);
		$action = $this->input->post('txtSubmit');
		$data = $this->input->post('chkPekerjalembur');
		if ($action == "approve") {
			if (!empty($data)) {
				foreach ($data as $dt) {
					$this->M_rencanalembur->updateRencanaLembur($dt,'1');
				}
				//insert to sys.log_activity
				$aksi = 'RENCANA LEMBUR';
				$detail = "Approve Rencana Lembur";
				$this->log_activity->activity_log($aksi, $detail);
				//
			}
		}else{
			if (!empty($data)) {
				foreach ($data as $dt) {
					$this->M_rencanalembur->updateRencanaLembur($dt,'2');
				}
				//insert to sys.log_activity
				$aksi = 'RENCANA LEMBUR';
				$detail = "Reject Rencana Lembur";
				$this->log_activity->activity_log($aksi, $detail);
				//
			}
		}

		redirect(base_url('RencanaLembur/ListRencanaLembur'));
	}
}
