<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class C_Index extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('KeluarMasukKendaraan/M_riwayat');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('KeluarMasukKendaraan/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}

	public function KendaraanDinas()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Kendaraan Dinas';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$tgl = $this->input->post('tgl-DL');
		if (strlen($tgl) < 2) {
			$tgl = date("Y-m-d");
		}

		$data['RiwayatDL'] = $this->M_riwayat->riwayatDL();
		$data['tgl'] = $tgl;
		// print_r($data['RiwayatDL']);exit();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('KeluarMasukKendaraan/RiwayatKMK/V_DinasLuar',$data);
		$this->load->view('V_Footer',$data);
	}

	public function KendaraanUmum()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Kendaraan Umum';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$tgl = $this->input->post('tgl-DL');
		if (strlen($tgl) < 2) {
			$tgl = date("Y-m-d");
		}

		$data['RiwayatDL'] = $this->M_riwayat->riwayatUm();
		$data['tgl'] = $tgl;
		// print_r($data['RiwayatDL']);exit();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('KeluarMasukKendaraan/RiwayatKMK/V_KendaraanUmum',$data);
		$this->load->view('V_Footer',$data);
	}
}