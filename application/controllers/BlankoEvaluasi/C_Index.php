<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		$this->checkSession();
    }

	private function checkSession() {
		if($this->session->userdata('is_logged')!=1) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
			redirect();
		}
	}

	public function index() {
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Blanko Evaluasi';
		$data['SubMenuOne'] = '';
		$data['Title'] = 'Blanko Evaluasi';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BlankoEvaluasi/V_Index');
		$this->load->view('BlankoEvaluasi/V_Footer',$data);
	}
}