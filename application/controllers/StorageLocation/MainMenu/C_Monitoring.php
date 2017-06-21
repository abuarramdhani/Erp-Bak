<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monitoring extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('StorageLocation/MainMenu/M_Monitoring');
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->checkSession();

	}

	public function checkSession(){
		if($this->session->is_logged){
		}else{
			redirect('index');
		}
	}

	public function index()
	{
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['title'] = 'Save Location Monitoring';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StorageLocation/MainMenu/V_Monitoring',$data);
		$this->load->view('V_Footer',$data);
	}

	public function searchByKomp()
	{
		$sub_inv 	= $this->input->post('sub_inv');
		$locator 	= $this->input->post('locator');
		$kode_item 	= $this->input->post('kode_item');
		$org_id 	= $this->input->post('org');
		$data['ByKomp'] = $this->M_Monitoring->searchByKomp($sub_inv,$locator,$kode_item,$org_id);
		$this->load->view('StorageLocation/MainMenu/V_SearchByComponent',$data);
	}

	public function searchBySA()
	{
		$sub_inv = $this->input->get('sub_inv');
		$locator = $this->input->get('locator');
		$kode_assy = $this->input->get('kode_assy');
		$org_id = $this->input->get('org_id');
		$data['BySA'] = $this->M_Monitoring->searchBySA($sub_inv,$locator,$kode_assy,$org_id);
		$this->load->view('StorageLocation/MainMenu/V_SearchByAssembly',$data);
	}

	public function searchByAll()
	{
		$sub_inv = $this->input->get('sub_inv');
		$locator = $this->input->get('locator');
		$alamat = $this->input->get('alamat');
		$data['ByKomp'] = $this->M_Monitoring->searchByAll($sub_inv,$locator,$alamat);
		$this->load->view('StorageLocation/MainMenu/V_SearchByComponent',$data);
	}
}