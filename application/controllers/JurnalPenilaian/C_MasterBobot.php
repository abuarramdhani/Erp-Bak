<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterBobot extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('JurnalPenilaian/M_bobot');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}

	//HALAMAN INDEX
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['GetBobot'] 		= $this->M_bobot->GetBobot();
		$idBobot				= $this->input->post('txtIdBobot');
		$data['number'] = 1;
		// echo "<pre>";
		// var_dump($_POST);
		// print_r($data);
		// echo "</pre>";
		// exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/BobotNilai/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}

	//HALAMAN CREATE
	public function create(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Create';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/BobotNilai/V_Create',$data);
		$this->load->view('V_Footer',$data);	
	}
	
	// ADD 
	public function add()
	{
		$date 	= $this->input->post('txtDate');
		$aspek 	= $this->input->post('txtAspek');
		$bobot 	= $this->input->post('txtBobot');
		$desc 	= $this->input->post('txtDesc');

		$insertId = $this->M_bobot->AddMaster($date, $aspek, $bobot, $desc);
		redirect('PenilaianKinerja/MasterBobot');
	}

	// DELETE
	public function delete($idBobot)
	{	
		$this->M_bobot->DeleteBobot($idBobot);
		redirect('PenilaianKinerja/MasterBobot');
	}

	// VIEW
	public function view($idBobot)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Create Penilaian';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['GetBobot'] = $this->M_bobot->GetBobot($idBobot);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/BobotNilai/V_View',$data);
		$this->load->view('V_Footer',$data);	
	}

	// VIEW EDIT
	public function edit($idBobot)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Create Penilaian';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['GetBobot'] = $this->M_bobot->GetBobot($idBobot);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/BobotNilai/V_Edit',$data);
		$this->load->view('V_Footer',$data);	
	}

	// SAVE EDIT
	public function update($idBobot)
	{
		$idBobot= $this->input->post('txtIdBobot');
		$date 	= $this->input->post('txtDate');
		$aspek 	= $this->input->post('txtAspek');
		$bobot 	= $this->input->post('txtBobot');
		$desc 	= $this->input->post('txtDesc');

		$this->M_bobot->Update($date, $aspek, $bobot, $desc, $idBobot);
		redirect('PenilaianKinerja/MasterBobot');
	}

//----------------------------------- JAVASCRIPT RELATED --------------------//
//----------------------------------- JAVASCRIPT RELATED --------------------//
	

}
