<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_DataPlan extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ProductionPlanning/MainMenu/M_dataplan');
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
		
		$data['Menu'] = 'Dashboard';
		
		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['plan']			= $this->M_dataplan->getDataPlan();
		$data['no']				= 1;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductionPlanning/MainMenu/DataPlan/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create()
	{
		$this->checkSession();
		$user_id  = $this->session->userid;
		$no_induk = $this->session->user;

		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['section'] 		= $this->M_dataplan->getSection();
		
		$this->form_validation->set_rules('dataPlan', 'required');

		if ($this->form_validation->run() === FALSE){
			$data['Menu'] = 'Dashboard';

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ProductionPlanning/MainMenu/DataPlan/V_Create',$data);
			$this->load->view('V_Footer',$data);
		}else{
			echo "MENDEM DUREN!";
		}
	}

	public function DownloadSample()
	{
		$this->load->helper('download');
		force_download('assets/upload/ProductionPlanning/sample-data-plans.ods', NULL);
	}
}
