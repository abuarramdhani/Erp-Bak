<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Master extends CI_Controller {

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
		$this->load->model('SettingKalibrasi/M_settingkalibrasi');
		  
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
		$data['Title'] = 'Order Tim Handling';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SettingKalibrasi/V_Index', $data);
		$this->load->view('V_Footer',$data);
		
	}

    public function setting()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['Title'] = 'Order Tim Handling';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SettingKalibrasi/Setting/V_Setting', $data);
		$this->load->view('V_Footer',$data);
		
	}

	public function inactive()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['Title'] = 'Order Tim Handling';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SettingKalibrasi/Inactive/V_Inactive', $data);
		$this->load->view('V_Footer',$data);
		
	}
	

	public function getKalibrasi()
	{
	  $data['getKalibrasi'] = $this->M_settingkalibrasi->getKalibrasi();
	  // echo "<pre>";print_r($data['getSaranaHandling']);die;
	  if (!empty($data['getKalibrasi'])) {
		$this->load->view('SettingKalibrasi/Setting/V_TableKalibrasi', $data);
	  }else {
		echo 0;
	  }
	}

	public function getKalibrasiInactive()
	{
	  $data['getKalibrasiInactive'] = $this->M_settingkalibrasi->getKalibrasiInactive();
	  // echo "<pre>";print_r($data['getSaranaHandling']);die;
	  if (!empty($data['getKalibrasiInactive'])) {
		$this->load->view('SettingKalibrasi/Inactive/V_TableKalibrasiInactive', $data);
	  }else {
		echo 0;
	  }
	}

	public function tambahKalibrasi()
	{
	  $data = [
		'no_alat_ukur' => $this->input->post('no_alat_ukur'),
		'jenis_alat_ukur' => $this->input->post('jenis_alat_ukur'),
		'last_calibration' => $this->input->post('last_calibration'),
		'next_calibration' => $this->input->post('next_calibration'),
		'lead_time' => $this->input->post('lead_time'),
		'status' => $this->input->post('status'),
		
	  ];
	  $no_alat_ukur = $this->input->post('no_alat_ukur');
	  $check = $this->M_settingkalibrasi->checkNoAlatUkur($no_alat_ukur);
	//   echo "<pre>";print_r($data['check']);die;
	if (!empty($check)) {
		echo 0;
	}else {
	  $insert = $this->M_settingkalibrasi->tambahKalibrasi($data);
	  echo json_encode($insert);
	  redirect(site_url('SettingKalibrasi/Setting'));
	}	  
	}

	public function deleteKalibrasi()
	{
	  $id = $this->input->post('id');
	  $this->M_settingkalibrasi->deleteKalibrasi($id);
	}

	public function updateKalibrasi()
	{
		$no_alat_ukur_first = $this->input->post('no_alat_ukur_first');
		$id = $this->input->post('id');
		$no_alat_ukur = $this->input->post('no_alat_ukur');
		$jenis_alat_ukur = $this->input->post('jenis_alat_ukur');
		$last_calibration = $this->input->post('last_calibration');
		$next_calibration = $this->input->post('next_calibration');
		$lead_time = $this->input->post('lead_time');
		$status = $this->input->post('status');

		// echo $id, "<br>";
		// echo $no_alat_ukur_first, "<br>";
		// echo $jenis_alat_ukur, "<br>";
		// echo $last_calibration, "<br>";
		// echo $next_calibration, "<br>";
		// echo $lead_time, "<br>";
		// echo $status, "<br>";
		// die;
		// $no_alat_ukur = $this->input->post('no_alat_ukur');
	    // $check = $this->M_settingkalibrasi->checkNoAlatUkur($no_alat_ukur);
		$checkexcept = $this->M_settingkalibrasi->checkNoAlatUkurExcept($no_alat_ukur, $no_alat_ukur_first);
		// echo '<pre>';print_r($checkexcept);die;
	if (empty($checkexcept)){
		$this->M_settingkalibrasi->updateKalibrasi($id, $no_alat_ukur, $jenis_alat_ukur, $last_calibration, $next_calibration, $lead_time, $status);		
		// if (in_array($no_alat_ukur, $checkexcept)) {
		// 	echo 0;
		// }
	}else {	
		echo 10;	
	};
	}
}