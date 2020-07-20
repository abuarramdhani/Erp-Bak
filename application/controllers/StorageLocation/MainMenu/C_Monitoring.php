<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monitoring extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('StorageLocation/MainMenu/M_monitoring');
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
			redirect('');
		}
	}

	public function index()
	{
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['title'] = 'Monitoring';
		
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
		$org_id 	= $this->input->post('org');
		$sub_inv 	= $this->input->post('sub_inv');
		$locator 	= $this->input->post('locator');
		$component 	= $this->input->post('kode_item');
		$a 			= explode('|', $component);
		$kode_item 	= $a[0];
		$data['ByKomp'] = $this->M_monitoring->searchByKomp($sub_inv,$locator,$kode_item,$org_id);
		$this->load->view('StorageLocation/MainMenu/V_SearchByComponent',$data);
	}

	public function searchBySA()
	{
		$sub_inv 	= $this->input->post('sub_inv');
		$locator 	= $this->input->post('locator');
		$kode_assy 	= $this->input->post('kode_assy');
		$org_id 	= $this->input->post('org_id');
		$data['BySA'] = $this->M_monitoring->searchBySA($sub_inv,$locator,$kode_assy,$org_id);
		$this->load->view('StorageLocation/MainMenu/V_SearchByAssembly',$data);
	}

	public function searchByAll()
	{
		$sub_inv 	= $this->input->post('sub_inv');
		$locator 	= $this->input->post('locator');
		$alamat 	= $this->input->post('alamat');
		$data['ByKomp'] = $this->M_monitoring->searchByAll($sub_inv,$locator,$alamat);
		$this->load->view('StorageLocation/MainMenu/V_SearchByComponent',$data);
	}
}