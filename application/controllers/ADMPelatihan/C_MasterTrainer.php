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
		$data['SubMenuOne'] = 'Master Trainer';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
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
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
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
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
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

		$experience  		= $this->input->post('txtPengalaman');	
		$experience_date 	= $this->input->post('txtTanggalPengalaman');	
		$certificated 		= $this->input->post('txtSertifikat');	
		$certificated_date 	= $this->input->post('txtTanggalSertifikat');	
		$team 				= $this->input->post('txtKegiatan');	
		$team_date			= $this->input->post('txtTanggalkegiatan');	
		$jabatan			= $this->input->post('txtJabatan');	

		//save+ambil id dari master trainer------------------------------------
		$id=$this->M_mastertrainer->AddTrainer($noind,$tname,$status);
		//---------------------------------------------------------------------
		$i=0;
		foreach ($experience as $loop) {
			$data_experience[$i]= array(
				'noind' 		=> $noind, 
				'trainer_id'	=> $id, 
				'training_name' => $experience[$i], 
				'training_date' => $experience_date[$i]
			);
			if (!empty($experience[$i])) {
				$this->M_mastertrainer->AddExperience($data_experience[$i]);
			}
			$i++;
		}
		
		$j=0;
		foreach ($certificated as $loop) {
			$data_certificated[$j]= array(
				'noind' 		=> $noind, 
				'trainer_id'	=> $id,
				'training_name' => $certificated[$j], 
				'training_date' => $certificated_date[$j], 
			);
			if (!empty($certificated[$j])) {
				$this->M_mastertrainer->AddCertificated($data_certificated[$j]);
			}
			$j++;
		}

		$k=0;
		foreach ($team as $key => $value) {
			$data_team[$k]=array(
				'noind' 	=> $noind, 
				'trainer_id'=> $id,
				'kegiatan' 	=> $team[$k], 
				'date' 		=> $team_date[$k], 
				'jabatan'	=> $jabatan[$k], 
			);
			if (!empty($team[$k])) {
				$this->M_mastertrainer->AddTrainerTeam($data_team[$k]);
			}
			$k++;
		}

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

	//HALAMAN View
	public function view($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Trainer';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
		$trainer= $this->M_mastertrainer->GetTrainerId($id);
		$noind=$trainer[0]['noind'];
		$nama_trainer=$trainer[0]['trainer_name'];
		$data['detail']=$trainer; 

		$data['tgllahirtrainer']=$this->M_mastertrainer->GetTanggalLahirTrainer($noind);
		$tgllahirtrain=$data['tgllahirtrainer'][0]['tgllahir'];

		$nama=str_replace('  ', '', $nama_trainer);
		$data['GetInfonofilter'] = $this->M_mastertrainer->GetAllInfo($nama);
		$infoall=$data['GetInfonofilter'];

		$tanggal= array();
		foreach ($infoall as $ia) {
			if ($ia['tgllahir']==$tgllahirtrain) {
				array_push($tanggal, $ia['noind']);
				$data['tanggal']=$tanggal;
			}
		}
		$cektanggal = implode("','", $data['tanggal']);
		$data['GetAllInfo'] = $this->M_mastertrainer->GetAllInfoFiltered($cektanggal);

		$data['GetExperience'] = $this->M_mastertrainer->GetExperience($noind);
		$data['GetCertificate'] = $this->M_mastertrainer->GetCertificate($noind);
		$data['GetTeam'] = $this->M_mastertrainer->GetTeam($noind);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterTrainer/V_View',$data);
		$this->load->view('V_Footer',$data);
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
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
		$trainer= $this->M_mastertrainer->GetTrainerId($id);
		$noind=$trainer[0]['noind'];
		$nama_trainer=$trainer[0]['trainer_name'];
		$data['detail']=$trainer; 

		$data['tgllahirtrainer']=$this->M_mastertrainer->GetTanggalLahirTrainer($noind);
		$tgllahirtrain=$data['tgllahirtrainer'][0]['tgllahir'];

		$nama=str_replace('  ', '', $nama_trainer);
		$data['GetInfonofilter'] = $this->M_mastertrainer->GetAllInfo($nama);
		$infoall=$data['GetInfonofilter'];

		$tanggal= array();
		foreach ($infoall as $ia) {
			if ($ia['tgllahir']==$tgllahirtrain) {
				array_push($tanggal, $ia['noind']);
				$data['tanggal']=$tanggal;
			}
		}
		$cektanggal = implode("','", $data['tanggal']);
		$data['GetAllInfo'] = $this->M_mastertrainer->GetAllInfoFiltered($cektanggal);

		$data['GetExperience'] = $this->M_mastertrainer->GetExperience($noind);
		$data['GetCertificate'] = $this->M_mastertrainer->GetCertificate($noind);
		$data['GetTeam'] = $this->M_mastertrainer->GetTeam($noind);
	
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
		// $status		= $this->input->post('slcStatus');
		$experience  		= $this->input->post('txtPengalaman');	
		$experience_date 	= $this->input->post('txtTanggalPengalaman');
		$idex 				= $this->input->post('idPengalaman');

		$certificated 		= $this->input->post('txtSertifikat');	
		$certificated_date 	= $this->input->post('txtTanggalSertifikat');	
		$id_cert		 	= $this->input->post('idsertifikat');	

		$team 				= $this->input->post('txtKegiatan');	
		$team_date			= $this->input->post('txtTanggalkegiatan');
		$jabatan			= $this->input->post('txtJabatan');
		$id_team			= $this->input->post('idteam');

		$this->M_mastertrainer->UpdateTrainer($id,$noind,$tname);
		
		$i=0;
		foreach ($experience as $ex) {
			$data_experience = array(
				'training_name' => $experience[$i], 
				'training_date' => $experience_date[$i]
			);

			if ($idex[$i]== '0') {
				$b = $this->M_mastertrainer->InsertEx($id, $experience[$i], $experience_date[$i], $noind);
			}else{
				$this->M_mastertrainer->updatePublic('pl.pl_experience', 'id_exp', $data_experience, $idex[$i]);
			}
			$i++;
		}

		$j=0;
		foreach ($certificated as $ex) {
			$data_certificated = array(
				'noind' 		=> $noind, 
				'trainer_id'	=> $id,
				'training_name' => $certificated[$j], 
				'training_date' => $certificated_date[$j]
			);

			if ($id_cert[$j]== '0') {
				$b = $this->M_mastertrainer->AddCertificated($data_certificated);
			}else{
				$this->M_mastertrainer->updatePublic('pl.pl_certificated_training', 'id_cert', $data_certificated, $id_cert[$j]);
			}
			$j++;
		}

		$k=0;
		foreach ($team as $ex) {
			$data_team = array(
				'noind' 		=> $noind, 
				'trainer_id'	=> $id,
				'kegiatan' 		=> $team[$k], 
				'date' 			=> $team_date[$k],
				'jabatan'		=> $jabatan[$k],
			);

			if ($id_team[$k]== '0') {
				$b = $this->M_mastertrainer->AddTrainerTeam($data_team);
			}else{
				$this->M_mastertrainer->updatePublic('pl.pl_trainer_team', 'id_team', $data_team, $id_team[$k]);
			}
			$k++;
		}
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
			echo '{"NoInduk":"'.$data['noind'].'","Nama":"'.$data['nama'].'"}';
			if ($count !== 0) {
				echo ",";
			}
		}
		echo "]";
	}

	public function GetNoIndukTraining(){
		$term = $this->input->get("term");
		$training = $this->input->get("training");
		$data = $this->M_mastertrainer->GetNoIndukTraining($term,$training);
		$count = count($data);
		echo "[";
		foreach ($data as $data) {
			$count--;
			echo '{"NoInduk":"'.$data['employee_code'].'","Nama":"'.$data['name'].'"}';
			if ($count !== 0) {
				echo ",";
			}
		}
		echo "]";
	}

	public function delete_exp($trainer_id,$idex)
		{		
			
			$delete = $this->M_mastertrainer->delete_exp($trainer_id,$idex);
		}
	public function delete_sertifikat($trainer_id,$idser)
		{		
			
			$delete = $this->M_mastertrainer->delete_sertifikat($trainer_id,$idser);
		}
	public function delete_team($trainer_id,$idteam)
		{		
			
			$delete = $this->M_mastertrainer->delete_team($trainer_id,$idteam);
		}

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
}
