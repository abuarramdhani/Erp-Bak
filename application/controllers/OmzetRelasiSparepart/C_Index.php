<?php defined('BASEPATH') OR exit('No direct script access allowed');
class C_Index extends CI_Controller
{
	
public function __construct()
		{
			parent::__construct();
	        $this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
	          //load the login model
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}
		}

	public function checkSession(){
		if($this->session->is_logged){
			}else{
				redirect();
			}
	}

	public function index()
		{
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Laporan';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OmzetRelasiSparepart/V_Index',$data);
		$this->load->view('V_Footer',$data);

		}

	
}