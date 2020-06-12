<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Masterproses extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		

		
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('OrderPrototype/M_order');

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

		$data['Title'] = 'Master Proses';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$proses = $this->M_order->selectproses();
		$data['proses'] = $proses;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderPrototype/Prototype/V_MasterProses',$data);
		$this->load->view('V_Footer',$data);
	}

	public function format_date($date)
	{
		$ss = explode("/",$date);
		return $ss[2]."-".$ss[1]."-".$ss[0];
	}
	public function saveproses()
	{
		$nama_proses = $this->input->post('nama_proses');

		$this->M_order->saveproses($nama_proses);

		$proses = $this->M_order->selectproses();
		$data['proses'] = $proses;


		// echo "<pre>";print_r($proses);exit();

		$this->load->view('OrderPrototype/Prototype/V_TabelProses',$data);

	}
	public function hapusproses()
	{
		$nama_proses = $this->input->post('nama_proses');
		
		$this->M_order->hapusproses($nama_proses);
	}


}