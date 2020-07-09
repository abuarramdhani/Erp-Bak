<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_cdr extends CI_Controller {

	public function __construct()
		{
			parent::__construct();
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('MorningGreeting/cdr/M_cdr');
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->helper('url');
			$this->checkSession();
		}
		
	public function checkSession(){
			if($this->session->is_logged){

			}else{
				redirect('');
			}
		}
		
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['cdr']=$this->M_cdr->cdr('sf.morning_greeting_cdr');
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MorningGreeting/cdr/V_cdr',$data);
		$this->load->view('V_Footer',$data);
	}
	
}
