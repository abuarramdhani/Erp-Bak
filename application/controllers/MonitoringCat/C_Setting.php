<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Setting extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('PHPMailerAutoload');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringCat/M_moncat');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Setting Cat';
		$data['Menu'] = 'Setting Cat';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringCat/V_Setting', $data);
		$this->load->view('V_Footer',$data);
	}
    
	public function getitemsetting(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_moncat->getitemsetting($term);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}

	public function view_setting(){
		$data['data'] = $this->M_moncat->getSettingCat();
		// echo "<pre>";print_r($data);exit();
		$this->load->view('MonitoringCat/ajax/V_Setting_Table', $data);
	}
    
	public function submit_setting_cat(){
		$kode_item 	= $this->input->post('kode_item');
		$konversi 	= $this->input->post('konversi');
		$this->M_moncat->save_setting_cat($kode_item, $konversi);
	}
	
	public function hapus_setting(){
		$inv = $this->input->post('inv');
		$this->M_moncat->hapus_setting_cat($inv);
	}

	public function edit_setting(){
		$inv = $this->input->post('inv');
		$qty = $this->input->post('qty');
		$this->M_moncat->update_setting_cat($inv, $qty);
	}
    
}