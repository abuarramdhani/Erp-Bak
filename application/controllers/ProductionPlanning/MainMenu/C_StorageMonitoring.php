<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_StorageMonitoring extends CI_Controller {

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
        $this->load->model('ProductionPlanning/MainMenu/M_storagemonitoring');
        $this->load->model('ProductionPlanning/MainMenu/M_dataplan');
		$this->load->model('ProductionPlanning/MainMenu/M_monitoring');
    }
	
	public function checkSession()
    {
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
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $data['storagepp']      = $this->M_storagemonitoring->getStoragePP();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('ProductionPlanning/MainMenu/StorageMonitoring/V_Index',$data);
        $this->load->view('V_Footer',$data);
    }

    public function Open()
    {
        $storage_name = $this->input->post('storage_name');
        $data['storage'] = $this->M_storagemonitoring->getStoragePP($storage_name);
        $data['section']        = $this->M_dataplan->getSection();
        // $data['plan']	= $this->
        // $data['secAchieve']     = $datDailyAchieve;
        $data['infoJob']        = $this->M_monitoring->getInfoJobs();
        $data['achieveAll']     = $this->M_monitoring->getAchievementAllFab();

		$this->load->view('ProductionPlanning/MainMenu/StorageMonitoring/V_StorageMonitoring',$data);
    }
}