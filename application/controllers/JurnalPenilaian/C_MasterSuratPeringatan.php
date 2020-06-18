<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterSuratPeringatan extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->library('General');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('JurnalPenilaian/M_sp');
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
		
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Surat Peringatan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['number'] = 1;
		$data['GetSP'] 	= $this->M_sp->GetSP();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/SuratPeringatan/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}

	//HALAMAN CREATE
	public function create(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Create';
		$data['SubMenuOne'] = 'Surat Peringatan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/SuratPeringatan/V_Create',$data);
		$this->load->view('V_Footer',$data);	
	}

	// ADD 
	public function add()
	{
		$noSP		= $this->input->post('txtNoSP');
		$nilai 		= $this->input->post('txtNilai');

		$inputSP	=	array(
							'sp_num'					=>	$noSP,
							'nilai'						=>	$nilai,
							'last_update_timestamp'		=> 	$this->general->ambilWaktuEksekusi(),
							'creation_timestamp'		=>	$this->general->ambilWaktuEksekusi(),
						);

		$insertId = $this->M_sp->AddMaster($inputSP);
		redirect('PenilaianKinerja/MasterSuratPeringatan');
	}

	// DELETE
	public function delete($idSP)
	{	
		$this->M_sp->DeleteSP($idSP);
		redirect('PenilaianKinerja/MasterSuratPeringatan');
	}

	// VIEW
	public function view($idSP)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Create Penilaian';
		$data['SubMenuOne'] = 'Surat Peringatan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['GetSP'] 	= $this->M_sp->GetSP($idSP);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/SuratPeringatan/V_View',$data);
		$this->load->view('V_Footer',$data);	
	}

	// VIEW EDIT
	public function edit($idSP)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Create Penilaian';
		$data['SubMenuOne'] = 'Surat Peringatan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['GetSP'] 	= $this->M_sp->GetSP($idSP);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/SuratPeringatan/V_Edit',$data);
		$this->load->view('V_Footer',$data);	
	}

	// SAVE EDIT
	public function update($idSP)
	{
		$idSP		= $this->input->post('txtIdSP');
		$noSP		= $this->input->post('txtNoSP');
		$nilai 		= $this->input->post('txtNilai');

		$updateSP 	=	array(
							'sp_num'					=>	$noSP,
							'nilai'						=>	$nilai,
							'last_update_timestamp'		=>	$this->general->ambilWaktuEksekusi(),
						);

		$this->M_sp->Update($updateSP, $idSP);
		redirect('PenilaianKinerja/MasterSuratPeringatan');
	}
//----------------------------------- JAVASCRIPT RELATED --------------------//
//----------------------------------- JAVASCRIPT RELATED --------------------//
	


}
