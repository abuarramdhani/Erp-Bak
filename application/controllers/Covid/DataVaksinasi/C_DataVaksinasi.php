<?php 
Defined("BASEPATH") or exit("No Direct Script Access Allowed");

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

/**
 * 
 */
class C_DataVaksinasi extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('Covid/DataVaksinasi/M_datavaksinasi');
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged)) redirect('');
	}

	public function index()
	{
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Monitoring Data Vaksinasi';
		$data['Header']			=	'Monitoring Data Vaksinasi';
		$data['Menu'] 			= 	'Data Vaksinasi';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_datavaksinasi->getData();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Covid/DataVaksinasi/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}
}