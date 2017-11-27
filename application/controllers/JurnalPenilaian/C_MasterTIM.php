<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterTIM extends CI_Controller {

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
		$this->load->model('JurnalPenilaian/M_tim');
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
		
		$data['number'] = 1;
		$data['GetTIM'] 		= $this->M_tim->GetTIM();
		$idTIM				= $this->input->post('txtIdTIM');
		// echo "<pre>";
		// var_dump($_POST);
		// print_r($data);
		// echo "</pre>";
		// exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/TIM/V_Index',$data);
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
		$this->load->view('JurnalPenilaian/MasterData/TIM/V_Create',$data);
		$this->load->view('V_Footer',$data);	
	}

	// ADD 
	public function add()
	{
		$date 		= $this->input->post('txtDate');
		$btsA 		= $this->input->post('txtbts_A');
		$btsB 		= $this->input->post('txtbts_B');
		$nilai 		= $this->input->post('txtNilai');

		$insertId = $this->M_tim->AddMaster($date, $btsA, $btsB, $nilai);
		redirect('PenilaianKinerja/MasterTIM');
	}

	// DELETE
	public function delete($idTIM)
	{	
		$this->M_tim->DeleteTIM($idTIM);
		redirect('PenilaianKinerja/MasterTIM');
	}
	
	// VIEW
	public function view($idTIM)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Create Penilaian';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['GetTIM'] 		= $this->M_tim->GetTIM($idTIM);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/TIM/V_View',$data);
		$this->load->view('V_Footer',$data);	
	}

	// VIEW EDIT
	public function edit($idTIM)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Create Penilaian';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['GetTIM'] 		= $this->M_tim->GetTIM($idTIM);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/TIM/V_Edit',$data);
		$this->load->view('V_Footer',$data);	
	}

	// SAVE EDIT
	public function update($idTIM)
	{
		$idTIM		= $this->input->post('txtIdTIM');
		$date 		= $this->input->post('txtDate');
		$btsA 		= $this->input->post('txtbts_A');
		$btsB 		= $this->input->post('txtbts_B');
		$nilai 		= $this->input->post('txtNilai');

		$this->M_tim->Update($date, $btsA, $btsB, $nilai, $idTIM);
		redirect('PenilaianKinerja/MasterTIM');
	}
//----------------------------------- JAVASCRIPT RELATED --------------------//
//----------------------------------- JAVASCRIPT RELATED --------------------//
	


}
