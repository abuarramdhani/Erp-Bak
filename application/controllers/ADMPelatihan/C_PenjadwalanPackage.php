<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_PenjadwalanPackage extends CI_Controller {

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
		$this->load->model('ADMPelatihan/M_penjadwalanpackage');
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
		
		$data['Menu'] = 'Penjadwalan';
		$data['SubMenuOne'] = 'Penjadwalan Paket Pelatihan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}
		
		$data['GetScheduledPackage'] = $this->M_penjadwalanpackage->GetScheduledPackage();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/PenjadwalanPackage/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	//HALAMAN OPSI CREATE PENJADWALAN PAKET
	public function tocreate(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Penjadwalan';
		$data['SubMenuOne'] = 'Penjadwalan Paket Pelatihan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}

		$data['GetPackage'] = $this->M_penjadwalanpackage->GetPackage();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/PenjadwalanPackage/V_ToCreate',$data);
		$this->load->view('V_Footer',$data);
	}

	//HALAMAN CREATE PENJADWALAN PAKET
	public function create($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Penjadwalan';
		$data['SubMenuOne'] = 'Penjadwalan Paket Pelatihan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}

		$data['GetPackageId'] = $this->M_penjadwalanpackage->GetPackageId($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/PenjadwalanPackage/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	//SAVE PENJADWALAN PAKET PELATIHAN YANG DIBUAT
	public function add(){
		$pkgid		= $this->input->post('txtPackageId');
		$schname	= $this->input->post('txtSchedulingName');
		$trgtype	= $this->input->post('txtTrainingType');
		$ptctype	= $this->input->post('txtParticipantType');
		
		$this->M_penjadwalanpackage->AddSchedule($pkgid,$schname,$trgtype,$ptctype);
		$maxid		= $this->M_penjadwalanpackage->GetMaxIdSchedulingPackage();
		$pkgschid	= $maxid[0]->package_scheduling_id;

		// redirect('ADMPelatihan/Penjadwalan/CreatebyPackage/'.$pkgschid);
		redirect('ADMPelatihan/PenjadwalanPackage/Schedule/'.$pkgschid);
	}

	//HALAMAN VIEW PENJADWALAN PAKET PELATIHAN
	public function view($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Penjadwalan';
		$data['SubMenuOne'] = 'Penjadwalan Paket Pelatihan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}
		
		$data['GetScheduledPackageId'] = $this->M_penjadwalanpackage->GetScheduledPackageId($id);
		//$data['GetPackageTraining'] = $this->M_masterpackage->GetPackageTrainingNum($num);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/PenjadwalanPackage/V_View',$data);
		$this->load->view('V_Footer',$data);
	}

	//HALAMAN PENJADWALAN PELATIHAN YANG TERDAFTAR DALAM PAKET
	public function schedule($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Penjadwalan';
		$data['SubMenuOne'] = 'Penjadwalan Paket Pelatihan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}

		$training		= $this->M_penjadwalanpackage->GetPackageIdNumber($id);
		$training_id	= $training[0]->package_id;
		
		$data['GetPackageTraining'] = $this->M_penjadwalanpackage->GetPackageTrainingId($training_id);
		$data['GetScheduledTraining'] = $this->M_penjadwalanpackage->GetScheduledTraining($id);
		$data['id'] = $id;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/PenjadwalanPackage/V_Schedule',$data);
		$this->load->view('V_Footer',$data);
	}

	//HAPUS RECORD PENJADWALAN
	public function delete($id){
		$schid			= $this->M_penjadwalanpackage->DeletePackageScheduling2($id);

		foreach ($schid as $loop) {
			$schedulingid	= $loop->scheduling_id;

			$this->M_penjadwalanpackage->DeletePackageScheduling3($schedulingid);
			$this->M_penjadwalanpackage->DeletePackageScheduling4($schedulingid);
		}

		$this->M_penjadwalanpackage->DeletePackageScheduling5($id);
		$this->M_penjadwalanpackage->DeletePackageScheduling1($id);
		
		redirect('ADMPelatihan/PenjadwalanPackage');
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
}
