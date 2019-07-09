<?php defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		if($this->session->userdata('logged_in') != TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}

	public function index() {
		if(!$this->session->is_logged) { redirect(''); }
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = $data['UserMenu'][0]['user_group_menu_name'];
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('LaporanKerjaHarian/PekerjaBatch/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}
}