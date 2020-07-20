<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterPackage extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
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
		$this->load->model('ADMPelatihan/M_masterpackage');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	//HALAMAN INDEKS
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Paket Pelatihan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
		$data['GetPackage'] = $this->M_masterpackage->GetPackage();
		$data['TrainingType'] = $this->M_masterpackage->GetTrainingType();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterPackage/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}
	

	//HALAMAN CREATE PAKET PELATIHAN
	public function create(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Paket Pelatihan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
		$data['GetTraining'] = $this->M_masterpackage->GetTraining();
		$data['GetPackage'] = $this->M_masterpackage->GetPackageId();
		$data['trgtype'] = $this->M_masterpackage->GetTrainingType();
		$data['ptctype'] = $this->M_masterpackage->GetParticipantType();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterPackage/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	//SAVE PAKET PELATIHAN YANG DIBUAT
	public function add(){
		$pkgname	= $this->input->post('txtNamaPaket');
		$trgtype	= $this->input->post('slcJenisPaket');
		$ptctype	= $this->input->post('slcPeserta');
		
		$this->M_masterpackage->AddPackage($pkgname,$trgtype,$ptctype);
		$maxid	= $this->M_masterpackage->GetMaxIdPackage();
		
		$pkgid 		= $maxid[0]->package_id;
		$training	= $this->input->post('slcTraining');
		$day		= $this->input->post('TxtDay');
				
			$i=0;
			foreach($training as $loop){
				$data_training[$i] = array(
					'package_id' 	=> $pkgid,
					'day' 				=> $day[$i],
					'training_order' 	=> $i,
					'training_id' 		=> $training[$i],
				);
				if( !empty($training[$i]) ){
					$this->M_masterpackage->AddPackageTraining($data_training[$i]);
				}
				$i++;
			}

		redirect('ADMPelatihan/MasterPackage');
	}

	//HALAMAN VIEW PAKET PELATIHAN
	public function view($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Paket Pelatihan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
		$data['GetPackage'] = $this->M_masterpackage->GetPackageId($id);
		$data['GetPackageTraining'] = $this->M_masterpackage->GetPackageTrainingId($id);
		$data['trgtype'] = $this->M_masterpackage->GetTrainingType();
		$data['ptctype'] = $this->M_masterpackage->GetParticipantType();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterPackage/V_View',$data);
		$this->load->view('V_Footer',$data);
	}

	//HALAMAN EDIT PAKET PELATIHAN
	public function edit($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Paket Pelatihan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
		$data['GetTraining'] = $this->M_masterpackage->GetTraining();
		$data['GetPackage'] = $this->M_masterpackage->GetPackageId($id);
		$data['GetPackageTraining'] = $this->M_masterpackage->GetPackageTrainingId($id);
		$data['trgtype'] = $this->M_masterpackage->GetTrainingType();
		$data['ptctype'] = $this->M_masterpackage->GetParticipantType();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterPackage/V_Edit',$data);
		$this->load->view('V_Footer',$data);
	}

	//HAPUS PAKET PELATIHAN BESERTA DENGAN DAFTAR PELATIHANNYA
	public function delete($id){
		$this->M_masterpackage->DelPackage($id);
		$this->M_masterpackage->DelPackageTraining($id);
		redirect('ADMPelatihan/MasterPackage');
	}
	
	//MENYIMPAN PERUBAHAN YANG DILAKUKAN
	public function update()
	{
		$id			= $this->input->post('txtPackageId');
		$pkgname	= $this->input->post('txtNamaPaket');
		$trgtype	= $this->input->post('slcJenisPaket');
		$ptctype	= $this->input->post('slcPeserta');
		
		$this->M_masterpackage->UpdatePackage($id,$pkgname,$trgtype,$ptctype);
		$this->M_masterpackage->DelPackageTraining($id);
		
		$training	= $this->input->post('slcTraining');
		$day		= $this->input->post('TxtDay');
				
			$i=0;
			foreach($training as $loop){
				$data_training[$i] = array(
					'package_id' 		=> $id,
					'day' 				=> $day[$i],
					'training_order' 	=> $i,
					'training_id' 		=> $training[$i],
				);
				if( !empty($training[$i]) ){
					$this->M_masterpackage->AddPackageTraining($data_training[$i]);
				}
				$i++;
			}

		redirect('ADMPelatihan/MasterPackage');
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
}
