<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_GroupSection extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ProductionPlanning/Settings/GroupSection/M_groupsection');
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
		
		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['userGroup'] 		= $this->M_groupsection->getUserGroup();
		$data['sectionGroup'] 		= $this->M_groupsection->getSectionGroup();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductionPlanning/Settings/GroupSection/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['regUser'] 		= $this->M_groupsection->getRegisteredUser();
		$data['section'] 		= $this->M_groupsection->getPpSection();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductionPlanning/Settings/GroupSection/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function CreateSave()
	{
		$user_id = $this->session->userid;
		$section = $this->input->post('section');
		$dataUser = array(
			'user_id' 		=> $this->input->post('userCode'),
			'created_by' 	=> $user_id,
			'creation_date' => date('Y-m-d')
		);
		$saveUser = $this->M_groupsection->saveUser($dataUser);
		foreach ($section as $s) {
			$data = array(
				'pp_user_id' 	=> $saveUser,
				'section_id' 	=> $s,
				'created_by' 	=> $user_id,
				'creation_date' => date('Y-m-d')
			);
			$saveGroup = $this->M_groupsection->saveGroup($data);
		// print_r($s);
		// exit();
		}
		redirect('ProductionPlanning/Setting/GroupSection');
	}
}
