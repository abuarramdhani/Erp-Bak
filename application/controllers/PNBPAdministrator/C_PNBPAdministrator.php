<?php 

Defined('BASEPATH') or exit('No direct script access allowed');

class C_PNBPAdministrator extends CI_Controller
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
		  
	}

	public function index(){

		$this->checksession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'PNBP Administrator';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PNBPAdministrator/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
}

?>