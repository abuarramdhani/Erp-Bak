<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ReportSeksiPersonalia extends CI_Controller {

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
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
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

		// $data['section'] = $this->M_penilaiankinerja->GetSeksi($term=FALSE);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/ReportSeksiPersonalia/V_Index',$data);
		$this->load->view('JurnalPenilaian/ReportSeksiPersonalia/V_Index2',$data);
		$this->load->view('JurnalPenilaian/ReportSeksiPersonalia/V_Index3',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
//----------------------------------- JAVASCRIPT RELATED --------------------//
//----------------------------------- JAVASCRIPT RELATED --------------------//
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
}
