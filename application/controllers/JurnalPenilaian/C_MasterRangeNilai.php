<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterRangeNilai extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->library('encryption');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('JurnalPenilaian/M_rangenilai');
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
		$data['SubMenuOne'] = 'Range Nilai';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['number'] = 1;
		$data['GetRange'] 		= $this->M_rangenilai->GetRange();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/RangeNilai/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}

	public function modification()
	{
		$idRangeNilai 	=	$this->input->post('idRangeNilai');
		$batasBawah 	=	$this->input->post('txtBatasBawah');
		$batasAtas 		=	$this->input->post('txtBatasAtas');
		$kategori 		=	$this->input->post('txtKategori');

		for ($i=0; $i < count($idRangeNilai); $i++) 
		{ 
			$idRangeNilai[$i] 	=	$this->encryption->decrypt(str_replace(array('-', '_', '~'), array('+', '/', '='), $idRangeNilai[$i]));
		}

		for ($k = 0; $k < count($idRangeNilai) ; $k++) 
		{ 			
			$dataUpdate 	=	array(
									'bts_bwh'	=> 	$batasBawah[$k],
									'bts_ats'	=>	$batasAtas[$k],
									'kategori'	=>	$kategori[$k]
								);
			$this->M_rangenilai->updateRangeNilai($dataUpdate, $idRangeNilai[$k]);
		}
		redirect('PenilaianKinerja/MasterRangeNilai');
	}

}
