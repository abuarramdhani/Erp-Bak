<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterRoom extends CI_Controller {

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
		$this->load->model('ADMPelatihan/M_masterroom');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
    //HALAMAN INDEX
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Ruangan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}

		$data['room'] = $this->M_masterroom->GetRoom();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterRoom/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//HALAMAN CREATE TRAINER INTERNAL
	public function Create(){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Ruangan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterRoom/V_Create',$data);
		$this->load->view('V_Footer',$data);	
	}

	//SUBMIT TRAINER EKSTERNAL YANG SUDAH DIBUAT
	public function Add(){
		$RoomName		= $this->input->post('txtNamaRuang');
		$RoomCapacity	= $this->input->post('txtKapasitas');

		$this->M_masterroom->AddRoom($RoomName,$RoomCapacity);
		redirect('ADMPelatihan/MasterRoom');
	}

	//MENGHAPUS TRAINER DARI DATABASE
	public function delete($id){
		$this->M_masterroom->DeleteRoom($id);
		redirect('ADMPelatihan/MasterRoom');
	}

	//HALAMAN EDIT
	public function edit($id){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Ruangan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}

		$data['room'] = $this->M_masterroom->GetRoomId($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterRoom/V_Edit',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//SUBMIT PERUBAHAN YANG TELAH DIBUAT
	public function update(){
		$id				= $this->input->post('txtIdRuang');
		$RoomName 		= $this->input->post('txtNamaRuang');
		$RoomCapacity 	= $this->input->post('txtKapasitas');

		$this->M_masterroom->UpdateRoom($id,$RoomName,$RoomCapacity);
		redirect('ADMPelatihan/MasterRoom');
	}

	public function checkSession(){
		if($this->session->is_logged){
		}else{
			redirect('');
		}
	}
}
