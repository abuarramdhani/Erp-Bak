<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterKategoriPenilaian extends CI_Controller {

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
		$this->load->model('JurnalPenilaian/M_kategorinilai');
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
		$data['SubMenuOne'] = 'Kategori Nilai';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['number'] = 1;
		$data['GetKatNil'] 		= $this->M_kategorinilai->GetKatNil();
		$idKatNil				= $this->input->post('txtIdKatNil');
		// echo "<pre>";
		// // var_dump($_POST);
		// print_r($data['GetKatNil']);
		// echo "</pre>";
		// exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/KategoriNilai/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}

	//HALAMAN CREATE
	public function create(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Create';
		$data['SubMenuOne'] = 'Kategori Nilai';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['number'] = 1;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/KategoriNilai/V_Create',$data);
		$this->load->view('V_Footer',$data);	
	}
	
	// ADD 
	public function add()
	{
		$date 		= $this->input->post('txtDate');
		$kat 		= $this->input->post('txtKategori');
		$std_nilai 	= $this->input->post('txtStandar');

		$insertId = $this->M_kategorinilai->AddMaster($date, $kat, $std_nilai);
		redirect('PenilaianKinerja/MasterKategoriPenilaian');
	}

	// DELETE
	public function delete($idKatNil)
	{	
		$this->M_kategorinilai->DeleteKatNil($idKatNil);
		redirect('PenilaianKinerja/MasterKategoriPenilaian');
	}

	// VIEW
	public function view($idKatNil)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Create Penilaian';
		$data['SubMenuOne'] = 'Kategori Nilai';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['GetKatNil'] 		= $this->M_kategorinilai->GetKatNil($idKatNil);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/KategoriNilai/V_View',$data);
		$this->load->view('V_Footer',$data);	
	}

	// VIEW EDIT
	public function edit($idKatNil)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Create Penilaian';
		$data['SubMenuOne'] = 'Kategori Nilai';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['GetKatNil'] 		= $this->M_kategorinilai->GetKatNil($idKatNil);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/KategoriNilai/V_Edit',$data);
		$this->load->view('V_Footer',$data);	
	}

	// SAVE EDIT
	public function update($idKatNil)
	{
		$idKatNil= $this->input->post('txtIdKatNil');
		$date 		= $this->input->post('txtDate');
		$kat 		= $this->input->post('txtKategori');
		$std_nilai 	= $this->input->post('txtStandar');

		$this->M_kategorinilai->Update($date, $kat, $std_nilai, $idKatNil);
		redirect('PenilaianKinerja/MasterKategoriPenilaian');
	}
//----------------------------------- JAVASCRIPT RELATED --------------------//
//----------------------------------- JAVASCRIPT RELATED --------------------//
	


}
