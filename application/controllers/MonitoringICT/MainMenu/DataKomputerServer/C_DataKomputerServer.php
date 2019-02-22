<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class C_DataKomputerServer extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('MonitoringICT/MainMenu/DataKomputerServer/M_datakomputerserver');

			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}
	}

	public function checkSession()
	{
		if($this->session->is_logged){
			}else{
				redirect();
			}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['server'] = $this->M_datakomputerserver->serverlist();
		// print_r($data['server']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringICT/MainMenu/DataKomputerServer/V_DataKomputerServer',$data);
		$this->load->view('V_Footer',$data);
	}

	public function tambah()
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
		$this->load->view('MonitoringICT/MainMenu/DataKomputerServer/V_Tambah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function cek_lokasi()
	{
		$text = $this->input->get('txtlokasi');
		$keyword 			=	strtoupper($this->input->get('term'));
		$daftar_lokasi = $this->M_datakomputerserver->daftar_lokasi($text, $keyword);

		echo json_encode($daftar_lokasi);
	}

	public function add()
	{
		// print_r($_POST); exit();
		$host = $this->input->post('txthostname');
		$ip = $this->input->post('txtipaddress');
		$lokasi = $this->input->post('txtlokasi');

		// echo $host.$ip.$lokasi; exit();
		$this->M_datakomputerserver->input($host, $ip, $lokasi);
		redirect('MonitoringICT/DataServer/');
	}
}