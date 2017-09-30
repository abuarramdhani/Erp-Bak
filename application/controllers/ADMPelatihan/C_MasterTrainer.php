<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterTrainer extends CI_Controller {

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
		$this->load->model('ADMPelatihan/M_mastertrainer');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
    //HALAMAN INDEX
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Trainer';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['trainer'] = $this->M_mastertrainer->GetTrainer();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterTrainer/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//HALAMAN CREATE TRAINER INTERNAL
	public function CreateInternal(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Trainer';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterTrainer/V_CreateInternal',$data);
		$this->load->view('V_Footer',$data);	
	}

	//HALAMAN CREATE TRAINER EKSTERNAL
	public function CreateExternal(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Trainer';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterTrainer/V_CreateExternal',$data);
		$this->load->view('V_Footer',$data);	
	}

	//SUBMIT TRAINER INTERNAL YANG SUDAH DIBUAT
	public function AddInternal(){
		$result		= $this->input->post('slcEmployee');
		$myArray 	= explode('-', $result[0]);
		
		$noind 		= $myArray[0];
		$tname 		= $myArray[1];
		$status		= 1;	

		$this->M_mastertrainer->AddTrainer($noind,$tname,$status);
		redirect('ADMPelatihan/MasterTrainer');
	}

	//SUBMIT TRAINER EKSTERNAL YANG SUDAH DIBUAT
	public function AddExternal(){
		$noind	= '-';
		$tname	= $this->input->post('txtNamaTrainer');
		$status	= 0;

		$this->M_mastertrainer->AddTrainer($noind,$tname,$status);

		redirect('ADMPelatihan/MasterTrainer');
	}

	//MENGHAPUS TRAINER DARI DATABASE
	public function delete($id){
		$this->M_mastertrainer->DeleteTrainer($id);
		redirect('ADMPelatihan/MasterTrainer');
	}

	//HALAMAN EDIT
	public function edit($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Trainer';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['detail'] = $this->M_mastertrainer->GetTrainerId($id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterTrainer/V_Edit',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//SUBMIT PERUBAHAN YANG TELAH DIBUAT
	public function update(){
		$id			= $this->input->post('txtIdTrainer');
		$noind 		= $this->input->post('txtNoind');
		$tname 		= $this->input->post('txtNamaTrainer');
		$status		= $this->input->post('slcStatus');

		$this->M_mastertrainer->UpdateTrainer($id,$noind,$tname,$status);
		
		redirect('ADMPelatihan/MasterTrainer');
	}
	
	//MENGAMBIL DAFTAR PEKERJA BERHUBUNGAN DENGAN AJAX/JAVASCRIPT
	public function GetNoInduk(){
		$term = $this->input->get("term");
		$data = $this->M_mastertrainer->GetNoInduk($term);
		$count = count($data);
		echo "[";
		foreach ($data as $data) {
			$count--;
			echo '{"NoInduk":"'.$data['employee_code'].'","Nama":"'.$data['employee_name'].'"}';
			if ($count !== 0) {
				echo ",";
			}
		}
		echo "]";
	}

	//MENGAMBIL DAFTAR PEKERJA BERHUBUNGAN DENGAN AJAX/JAVASCRIPT
	// public function GetApplicant(){
	// 	$term = $this->input->get("term");
	// 	$data = $this->M_mastertrainer->GetApplicant($term);
	// 	$count = count($data);
	// 	echo "[";
	// 	foreach ($data as $data) {
	// 		$count--;
	// 		echo '{"NoInduk":"'.$data['kodelamaran'].'","Nama":"'.$data['nama'].'"}';
	// 		if ($count !== 0) {
	// 			echo ",";
	// 		}
	// 	}
	// 	echo "]";
	// }

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
}
