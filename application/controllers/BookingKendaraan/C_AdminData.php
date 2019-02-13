<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_AdminData extends CI_Controller {

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
		$this->load->model('BookingKendaraan/M_carimobil');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		date_default_timezone_set('Asia/Jakarta');
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
		
		$noind = $this->session->user;

		$p = $this->M_carimobil->ambilEmployeeId($noind);
		$id = $p[0]['employee_id'];

		$data['voip'] = $this->M_carimobil->ambilDataPICVoipSaved($id);
		$data['data'] = $this->M_carimobil->ambilDataPICVoip($noind);
		// echo "<pre>";
		// print_r($data);
		// exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BookingKendaraan/V_AdminData',$data);
		$this->load->view('V_Footer',$data);
	}

	public function simpanData()
	{
		$noind = $this->input->post('noind_pic');
		$voip	= $this->input->post('voip_pic');

		$data = $this->M_carimobil->ambilEmployeeId($noind);
		$id = $data[0]['employee_id'];

		$array = array(
					'voip_pic' => $voip,
				);
		$this->M_carimobil->updateVoipPIC($id,$array);

		redirect('AdminBookingKendaraan/DataKendaraan');
	}

	
}