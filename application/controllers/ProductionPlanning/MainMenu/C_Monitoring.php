<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Monitoring extends CI_Controller {

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
		$this->load->model('ProductionPlanning/MainMenu/M_monitoring');
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
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['section'] 		= $this->M_dataplan->getSection($user_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductionPlanning/MainMenu/Monitoring/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}

    public function Open()
    {
    	$user_id 	= $this->session->userid;
    	$section 	= $this->input->post('section');
    	$datplan 	= array();
    	$datsec 	= array();
    	foreach ($section as $val) {
    		$datplan[] = $this->M_dataplan->getDataPlan($id=false,$val);
    	}

        $data['section']        = $this->M_dataplan->getSection();
    	$data['infoJob'] 		= $this->M_monitoring->getInfoJobs();
    	$data['selectedSection']= $section;
    	
    	$data['highPriority']= array();
    	$data['normalPriority']= array();

    	foreach ($datplan as $dp => $val1) {
    		foreach ($val1 as $key => $val2) {
    			if ($val2['priority'] == '1') {
    				$data['highPriority'][$dp][$key] = $val2;
    			}else{
    				$data['normalPriority'][$dp][$key] = $val2;
    			}
    		}
    	}
    	
        $this->load->view('ProductionPlanning/MainMenu/Monitoring/V_Monitoring', $data);
    }
}