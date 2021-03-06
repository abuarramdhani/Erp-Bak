<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {

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
		$this->load->model('MonitoringDeliverySparepart/M_monmng');
		  
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
		$user = $this->session->user;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['Title'] = 'Monitoring Delivery Sparepart';
		$cek = $this->M_monmng->cekHak($user);
		$UserMenu = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		// echo "<pre>"; print_r($data['UserMenu']);exit();
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		if (empty($cek)) {
			$hak = '';
			$this->load->view('MonitoringDeliverySparepart/V_Salah', $data);
		}else {
			$hak = $cek[0]['hak_akses'];
			if ($hak == 'Seksi') {
				$data['UserMenu'][] = $UserMenu[2];
			}else {
				$data['UserMenu'] = $UserMenu;
			}
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringDeliverySparepart/V_Index', $data);
			$this->load->view('V_Footer',$data);
		}

		
	}

	
}