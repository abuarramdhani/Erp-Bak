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
		$this->load->library('General');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('JurnalPenilaian/M_bobot');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
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
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Bobot Nilai';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['GetBobot'] 		= $this->M_bobot->GetBobot();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/BobotNilai/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}

	//HALAMAN CREATE
	public function create()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Create';
		$data['SubMenuOne'] = 'Bobot Nilai';
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
		$aspek 		= filter_var(strtoupper($this->input->post('txtAspek')), FILTER_SANITIZE_SPECIAL_CHARS);
		$singkatan 	= strtolower($this->input->post('txtSingkatan'));
		$bobot 		= $this->input->post('txtBobot');
		$desc 		= filter_var($this->input->post('txtDesc'), FILTER_SANITIZE_SPECIAL_CHARS);

		$real 		= "t_".$singkatan;
		$konversi 	= "n_".$singkatan;

		$inputBobot 	=	array(
								'aspek'						=>	$aspek,
								'bobot'						=>	$bobot,
								'description'				=>	$desc,
								'singkatan'					=>	$singkatan,
								'last_update_timestamp'		=>	$this->general->ambilWaktuEksekusi(),
								'creation_timestamp'		=>	$this->general->ambilWaktuEksekusi(),
							);

		$insertId = $this->M_bobot->AddMaster($inputBobot);
		$createColumn = $this->M_bobot->createColum($real,$konversi);
		redirect('PenilaianKinerja/MasterBobot');
	}

	// DELETE
	public function delete($idBobot)
	{	
		$singkatan = $this->M_bobot->get_bobot_by_id($idBobot);
		$real = "t_".$singkatan->singkatan;
		$konversi = "n_".$singkatan->singkatan;
		$dropColumn = $this->M_bobot->dropColum($real,$konversi);
		$this->M_bobot->DeleteBobot($idBobot);
		redirect('PenilaianKinerja/MasterBobot');
	}

	// VIEW
	public function view($idBobot)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Create Penilaian';
		$data['SubMenuOne'] = 'Bobot Nilai';
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
		$data['SubMenuOne'] = 'Bobot Nilai';
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
		$aspek 	= $this->input->post('txtAspek');
		$singkatan 	= $this->input->post('txtSingkatan');
		$bobot 	= $this->input->post('txtBobot');
		$desc 	= $this->input->post('txtDesc');

		$updateBobot 	=	array(
								'aspek'					=>	$aspek,
								'bobot'					=>	$bobot,
								'description'			=>	$desc,
								'singkatan'				=>	$singkatan,
								'last_update_timestamp'	=>	$this->general->ambilWaktuEksekusi()
							);

		$this->M_bobot->Update($updateBobot, $idBobot);
		redirect('PenilaianKinerja/MasterBobot');
	}

//----------------------------------- JAVASCRIPT RELATED --------------------//
//----------------------------------- JAVASCRIPT RELATED --------------------//
	

}
