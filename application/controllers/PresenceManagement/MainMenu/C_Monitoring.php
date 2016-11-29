<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Monitoring extends CI_Controller {

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
		$this->load->model('PresenceManagement/MainMenu/M_monitoring');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	//===========================
	// 	PRESENCE MANAGEMENT START
	//===========================
	
	public function index(){	
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Catering List';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['device'] = $this->M_monitoring->GetDeviceList();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PresenceManagement/MainMenu/Monitoring/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function Show($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Catering List';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['registered'] = $this->M_monitoring->GetRegisteredPeople($id);
		$data['device'] = $this->M_monitoring->GetSpesificDeviceList($id);
		$data['lokasi'] = $this->M_monitoring->GetLocation($id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PresenceManagement/MainMenu/Monitoring/V_List',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	public function Create(){	
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Catering List';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['maxfinger'] = $this->M_monitoring->maxfinger();
		$data['office'] = $this->M_monitoring->office();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PresenceManagement/MainMenu/Monitoring/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function Delete(){
		
		$loc	= $this->input->get('location');
		$id	= $this->input->get('noind');
		$checkloc = $this->M_monitoring->checkloc($id);
		if($checkloc->num_rows() > 1){
			$this->M_monitoring->DelRegisteredPerson($loc,$id);
		}else{
			$this->M_monitoring->UpdateRegisteredPerson($loc,$id);
		}
		redirect('PresenceManagement/Monitoring/Show/'.$loc.'');
		
	}
	
	public function ChangeName(){
		
		$loc	= $this->input->post('txtLocation');
		$name		= strtoupper($this->input->post('txtName'));
		$this->M_monitoring->UpdateNameLocation($loc,$name);
		redirect('PresenceManagement/Monitoring');
		
	}
	
	public function Mutation(){
		
		$tgt= $this->input->post('txtTarget');
		$loc= $this->input->post('txtLocation');
		$id	= $this->input->post('txtID');
		$this->M_monitoring->MutationRegisteredPerson($tgt,$loc,$id);
		redirect('PresenceManagement/Monitoring/Show/'.$loc.'');
		
	}
	
	public function Register(){
		
		$loc= $this->input->post('txtLocation');
		$id	= $this->input->post('txtID');
		$checkloc = $this->M_monitoring->checkloc($id);
		if($checkloc->num_rows() > 1){
			// echo "insert";
			$result	= $this->M_monitoring->insertPerson($id,$loc);
		}else{
			// echo "update";
			$result	= $this->M_monitoring->updatePerson($id,$loc);
		}
		 redirect('PresenceManagement/Monitoring/Show/'.$loc.'');
	}
	
	public function JsonNoind(){
		
		$q = strtoupper($this->input->get('term')); //variabel kode pegawai
		$loc = $this->input->get('loc'); //variabel kode pegawai
		$result = $this->M_monitoring->getPerson($q,$loc);
		echo json_encode($result);
	}
	
	public function Access(){
		
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Catering List';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['registered'] = $this->M_monitoring->GetAccessablePeople();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PresenceManagement/MainMenu/Monitoring/V_Access',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	public function Refresh(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Catering List';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PresenceManagement/MainMenu/Monitoring/V_Refresh',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function SaveDevice(){
		$sn	= strtoupper($this->input->post('txtSN'));
		$vc	= strtoupper($this->input->post('txtVC'));
		$ac	= strtoupper($this->input->post('txtAC'));
		$idloc	= $this->input->post('txtIdLocation');
		$loc	= $this->input->post('txtLocation');
		$off	= $this->input->post('txtOffice');
		$ip	= $this->input->post('txtIP');
		$check	= $this->M_monitoring->checkDevice($sn);
		if($check<1){
			$this->M_monitoring->inserttblokasi($idloc,$loc,$off);
			$this->M_monitoring->inserttbdevice($sn,$vc,$ac,$idloc);
			$this->M_monitoring->inserttbmysql($idloc,$ip);
			$this->M_monitoring->inserttbpostgres($idloc,$ip);
		}
		redirect('PresenceManagement/Monitoring');
	}
	
	public function SettingDev($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Catering List';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['device'] = $this->M_monitoring->GetSpesificDevice($id);
		$data['office'] = $this->M_monitoring->office();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PresenceManagement/MainMenu/Monitoring/V_Setting',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function ListPerson(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Catering List';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['person'] = $this->M_monitoring->GetListPerson();
		$data['location'] = $this->M_monitoring->getListLocation();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PresenceManagement/MainMenu/Monitoring/V_ListPerson',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//=========================
	// 	PRESENCE MANAGEMENT END
	//=========================
}
