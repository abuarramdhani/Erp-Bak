<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Rekap extends CI_Controller {

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
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('er/RekapTIMS/M_rekapmssql');
		  
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
			redirect();
		}
	}
	
	//------------------------show the dashboard-----------------------------
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('er/RekapTIMS/V_index',$data);
		$this->load->view('V_Footer',$data);
		
	}

	//------------------------show the filtering menu-----------------------------
	public function rekapMenu()
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['status'] = $this->M_rekapmssql->statusKerja();
		$data['dept'] = $this->M_rekapmssql->dept();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('er/RekapTIMS/V_filter',$data);
		$this->load->view('V_Footer',$data);
		
	}

	//------------------------automatically post value to select section-----------------------------
	public function select_section()
	{
		$id = $this->input->post('data_name');
		$modul = $this->input->post('modul');

		echo '
			<option value=""></option>
			<option value="muach" disabled >-- PILIH SALAH SATU --</option>
		';
		if ($modul == 'bidang') {
			$data = $this->M_rekapmssql->bidang($id);
			foreach ($data as $data) {
				echo '<option value="'.$data['Bidang'].'">'.$data['Bidang'].'</option>';
			}
		}
		elseif ($modul == 'unit') {
			$data = $this->M_rekapmssql->unit($id);
			foreach ($data as $data) {
				echo '<option value="'.$data['Unit'].'">'.$data['Unit'].'</option>';
			}
		}
		elseif ($modul == 'seksi') {
			$data = $this->M_rekapmssql->seksi($id);
			foreach ($data as $data) {
				echo '<option value="'.$data['Seksi'].'">'.$data['Seksi'].'</option>';
			}
		}
	}

	//------------------------show the data REKAP TIMS-----------------------------
	public function showData()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$periode1	= $this->input->post('rekapBegin');
		$periode2	= $this->input->post('rekapEnd');
		$status 	= $this->input->post('statushubker');
		$departemen	= $this->input->post('departemen');
		$bidang 	= $this->input->post('bidang');
		$unit 		= $this->input->post('unit');
		$section 	= $this->input->post('section');
		$detail 	= $this->input->post('detail');

		//print_r($detail);
		//exit();

		$filterRekap= $this->M_rekapmssql->dataRekap($periode1,$periode2,$status,$departemen,$bidang,$unit,$section);
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['rekap'] = $this->M_rekapmssql->dataRekap($periode1,$periode2,$status,$departemen,$bidang,$unit,$section);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		if ($detail==NULL) {
			$this->load->view('er/RekapTIMS/V_rekap',$data);
		}else {
			$this->load->view('er/RekapTIMS/V_rekapDetail',$data);
		}
		$this->load->view('V_Footer',$data);
		
	}

	public function searchMonth()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('er/RekapTIMS/V_month',$data);
		$this->load->view('V_Footer',$data);
	}

	public function searchEmployee($nik)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['info'] = $this->M_rekapmssql->rekapPersonInfo($nik);
		$data['Terlambat'] = $this->M_rekapmssql->rekapPersonTerlambat($nik);
		$data['IjinPribadi'] = $this->M_rekapmssql->rekapPersonIjinPribadi($nik);
		$data['Mangkir'] = $this->M_rekapmssql->rekapPersonMangkir($nik);
		$data['IjinPerusahaan'] = $this->M_rekapmssql->rekapPersonIjinPerusahaan($nik);
		$data['SuratPeringatan'] = $this->M_rekapmssql->rekapPersonSuratPeringatan($nik);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('er/RekapTIMS/V_personal',$data);
		$this->load->view('V_Footer',$data);
	}

}
