<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterTraining extends CI_Controller {

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
		$this->load->model('ADMPelatihan/M_mastertraining');
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
		
		$data['Menu'] = 'Master Pelatihan';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
		$data['training'] = $this->M_mastertraining->GetTraining();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterTraining/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}

	//MENGAMBIL DAFTAR TUJUAN PELATIHAN (BERHUBUNGAN DENGAN AJAX/JAVASCRIPT)
	public function GetObjective(){
		$term = $this->input->get("term");
		$data = $this->M_mastertraining->GetObjective($term);
		$count = count($data);
		echo "[";
		foreach ($data as $data) {
			$count--;
			echo '{"objective":"'.$data['purpose'].'"}';
			if ($count !== 0) {
				echo ",";
			}
		}
		echo "]";
	}



	//HALAMAN CREATE
	public function create(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master Pelatihan';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		$data['questionnaire'] = $this->M_mastertraining->GetQuestionnaire();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterTraining/V_Create',$data);
		$this->load->view('V_Footer',$data);	
	}

	//MENYIMPAN DATA BARU
	public function add(){
		$tname 		= $this->input->post('txtNamaPelatihan');
		$limit 		= $this->input->post('txtBatas');
		$limit2 		= $this->input->post('txtBatas2');
		// $status		= $this->input->post('slcStatus');
		$kapasitas	= $this->input->post('kapasitas');
		$questionnaire		= $this->input->post('slcQuestionnaire[]');
		$questionnaires 	= implode(',', $questionnaire);

		$insertId = $this->M_mastertraining->AddMaster($tname,$limit,$questionnaires,$kapasitas,$limit2);
		
		// if($status==1){
		// 	$maxid		= $this->M_mastertraining->GetMaxIdTraining();
		// 	$pkgid		= $maxid[0]->training_id;
		// 	$objective	= $this->input->post('slcObjective');
		// 		$i=0;
		// 		foreach($objective as $loop){
		// 			$data_objective[$i] = array(
		// 				'training_id' 	=> $pkgid,
		// 				'purpose' 		=> $objective[$i],
		// 				// 'objective' 	=> $objective[$i],
		// 			);
		// 			if( !empty($objective[$i]) ){
		// 				$this->M_mastertraining->AddObjective($data_objective[$i]);
		// 			}
		// 			$i++;
		// 		}
		// }

		// else {
			$maxid		= $this->M_mastertraining->GetMaxIdTraining();
			$pkgid		= $maxid[0]->training_id;
			$objective	= $this->input->post('slcObjective');
				$i=0;
				foreach($objective as $loop){
					$data_objective[$i] = array(
						'training_id' 	=> $pkgid,
						'purpose'	 	=> $objective[$i],
					);
				$pp = $this->M_mastertraining->pp($objective[$i]);
					// if( $pp[0]['count']==NULL or $pp[0]['count']==0 ){
					if( !empty($objective[$i] )){
						$this->M_mastertraining->AddObjective($data_objective[$i]);
					}
					$i++;
			}
		// }

		redirect('ADMPelatihan/MasterTraining');
	}

	//MENGHAPUS DATA YANG SUDAH ADA
	public function delete($id){
		$this->M_mastertraining->DeleteTraining($id);
		redirect('ADMPelatihan/MasterTraining');
	}
	
	//HALAMAN EDIT
	public function edit($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master Pelatihan';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
		$data['training'] = $this->M_mastertraining->GetTrainingId($id);
		$data['objective'] = $this->M_mastertraining->GetObjectiveId($id);
		$data['questionnaire'] = $this->M_mastertraining->GetQuestionnaire();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterTraining/V_Edit',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	//MENYIMPAN PERUBAHAN DATA
	public function update(){
		$id 		= $this->input->post('txtId');
		$tname 		= $this->input->post('txtNamaPelatihan');
		$limit		= $this->input->post('txtBatas');
		$limit2 	= $this->input->post('txtBatas2');
		$status		= $this->input->post('slcStatus');
		$kapasitas	= $this->input->post('kapasitas');
		$questionnaire		= $this->input->post('slcQuestionnaire');
		$questionnaires 	= implode(',', $questionnaire);
		
		

			$pkgid		= $id;
			$this->M_mastertraining->DelObjective($id);
			$objective	= $this->input->post('slcObjective');
				$i=0;
				foreach($objective as $loop){
					$data_objective[$i] = array(
						'training_id' 	=> $pkgid,
						'purpose' 		=> $objective[$i],
					);
					if( !empty($objective[$i]) ){
						$this->M_mastertraining->AddObjective($data_objective[$i]);
					}
					$i++;
			
		}


		$this->M_mastertraining->UpdateTraining($id,$tname,$limit,$status,$questionnaires,$kapasitas,$limit2);
		redirect('ADMPelatihan/MasterTraining');
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
}
