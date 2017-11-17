<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_JurnalPenilaianPersonalia extends CI_Controller {

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
		$this->load->model('JurnalPenilaian/M_penilaiankinerja');
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
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		// echo "<pre>";
		// var_dump($_POST);
		// print_r($data);
		// echo "</pre>";
		// exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/JurnalPenilaian/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}

	//HALAMAN CREATE
	public function create(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Create Penilaian';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['department'] = $this->M_penilaiankinerja->GetDepartemen($term=FALSE);
		$data['unit'] = $this->M_penilaiankinerja->GetUnit($term=FALSE);
		$data['section'] = $this->M_penilaiankinerja->GetSeksi($term=FALSE);
		$data['pekerja'] = $this->M_penilaiankinerja->GetNoInduk($term=FALSE);
		$data['number'] = 1;


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/JurnalPenilaian/V_Create',$data);
		$this->load->view('V_Footer',$data);	
	}

	// ADD MASTER PENILAIAN KINERJA
	public function add()
	{
		$startdate = $this->input->post('txtDate1');
		$enddate = $this->input->post('txtDate2');
		$dept = $this->input->post('slcDepartemenPK');
		$unit = $this->input->post('slcUnitPK');
		$section = $this->input->post('slcSectionPK');

		// echo "<pre>";
		// var_dump($_POST);
		// print_r($insertId);
		// echo "</pre>";
		// exit();
		$insertId = $this->M_penilaiankinerja->AddMaster($startdate, $enddate, $dept, $unit, $section);

	}
	

//----------------------------------- JAVASCRIPT RELATED --------------------//
//----------------------------------- JAVASCRIPT RELATED --------------------//
	public function GetDepartemen(){
		$term = $this->input->get("term");
		$data = $this->M_penilaiankinerja->GetDepartemen($term);
		$count = count($data);
		echo "[";
		foreach ($data as $data) {
			$count--;
			echo '{
					"Nama_Departemen":"'.$data['department_name'].'"
				}';
			if ($count !== 0) {
				echo ",";
			}
		}
		echo "]";
	}

	public function GetUnit(){
		$term = $this->input->get("term");
		$data = $this->M_penilaiankinerja->GetUnit($term);
		$count = count($data);
		echo "[";
		foreach ($data as $data) {
			$count--;
			echo '{
					"Nama_Unit":"'.$data['unit_name'].'"
				}';
			if ($count !== 0) {
				echo ",";
			}
		}
		echo "]";
	}

	public function GetSeksi(){
		$term = $this->input->get("term");
		$data = $this->M_penilaiankinerja->GetSeksi($term);
		$count = count($data);
		echo "[";
		foreach ($data as $data) {
			$count--;
			echo '{
					"Nama_Seksi":"'.$data['section_name'].'"
				}';
			if ($count !== 0) {
				echo ",";
			}
		}
		echo "]";
	}

	public function GetNoInduk(){
		$term = $this->input->get("term");
		$data = $this->M_penilaiankinerja->GetNoInduk($term);
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


}
