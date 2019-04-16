<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_settingMinMaxOPM extends CI_Controller {

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
		$this->load->model('SettingMinMaxOPM/M_settingminmaxopm');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }

	public function checkSession()
	{
		if($this->session->is_logged){		
		}else{
			redirect();
		}
	}

	//------------------------show the dashboard-----------------------------
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SettingMinMaxOPM/V_Index');
		$this->load->view('V_Footer',$data);
	}

	public function Edit()
	{

		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['route'] = $this->M_settingminmaxopm->TampilRoutingClass();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SettingMinMaxOPM/V_Tampil');
		$this->load->view('V_Footer',$data);
	}

	public function EditbyRoute()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		if ($this->session->flashdata('route') == null) 
		{
			$route = $this->input->post('routing_class');
		} 
		elseif ($this->session->flashdata('route') != null)
		{
			$route = $this->session->flashdata('route');
		}
		
		$data['route'] = $this->M_settingminmaxopm->TampilRoutingClass();
		$data['minmax'] = $this->M_settingminmaxopm->TampilDataMinMax($route);
		$data['routeaktif'] = $route;

		if ($data['minmax'] == null) {
			$this->session->set_flashdata('kosong', 'Data Kosong, Mohon Untuk Memilih Ulang Routing Class');
			redirect(base_url('SettingMinMaxOPM/Edit/'));
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SettingMinMaxOPM/V_Tampil_byRoute');
		$this->load->view('V_Footer',$data);
	}

	public function EditItem($route, $itemcode)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['routeaktif'] = $route;
		$data['item_minmax'] = $this->M_settingminmaxopm->TampilDataItemMinMax($route,$itemcode);
		$data['No_induk'] = $this->session->user;;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SettingMinMaxOPM/V_Tampil_Edit_Minmax');
		$this->load->view('V_Footer',$data);
	}

	public function SaveMinMax()
	{	
		$induk = $this->input->post('induk');
		$route = $this->input->post('route');
		$itemcode = $this->input->post('segment1');
		$min 	= $this->input->post('min');
		$max 	= $this->input->post('max');
		$rop 	= $this->input->post('rop');
		
		$data =$this->M_settingminmaxopm->save($itemcode, $min, $max, $rop, $induk);

		$this->session->set_flashdata('route', $route);
		redirect(base_url('SettingMinMaxOPM/EditbyRoute/'));
	}
}