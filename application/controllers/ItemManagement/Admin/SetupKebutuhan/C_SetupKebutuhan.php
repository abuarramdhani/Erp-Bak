<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_SetupKebutuhan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		$this->load->model('ItemManagement/Admin/M_setupkebutuhan');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Master Item';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['SetupKebutuhan'] = $this->M_setupkebutuhan->SetupKebutuhanList();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ItemManagement/Admin/SetupKebutuhan/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getSeksi(){
		$term = $this->input->get('term');

		$seksi = $this->M_setupkebutuhan->getSeksi($term);

		echo json_encode($seksi);
	}

	public function getKodePekerjaan(){
		$term = $this->input->get('term');

		$kodepkj = $this->M_setupkebutuhan->getKodePekerjaan($term);

		echo json_encode($kodepkj);
	}

	public function getKodeBarang(){
		$term = $this->input->get('term');

		$kodebrg = $this->M_setupkebutuhan->getKodeBarang($term);

		echo json_encode($kodebrg);
	}

	public function getDetail(){
		$kode_barang = $this->input->get('kode_barang');
		$modul = $this->input->get('modul');
		$detail = $this->M_setupkebutuhan->getDetail($kode_barang);

		foreach ($detail as $det) {
			if ($modul == 'nama') {
				echo $det['detail'];
			}
			elseif($modul == 'stok'){
				echo $det['stok'];
			}
		}
	}
}
