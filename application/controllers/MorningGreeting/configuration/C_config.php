<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_config extends CI_Controller {

	public function __construct()
		{
			parent::__construct();
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('MorningGreeting/config/M_config');
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
		$data['config']=$this->M_config->config('sf.morning_greeting_config');
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MorningGreeting/config/V_config',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function editConfig($parameter)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$search_data = $this->M_config->search_data_config($parameter);
		$data['search'] = $search_data;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MorningGreeting/config/V_editconfig',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function saveconfig()
		{
			$parameter = $this->input->post('parameter');
			$value = $this->input->post('value');
			$this->M_config->saveconfig($parameter,$value);
			redirect(base_url('MorningGreeting/configuration'));
		}
}
