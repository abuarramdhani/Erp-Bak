<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_AllDoc extends CI_Controller
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
		$this->load->library('upload');
		$this->load->library('General');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('DocumentStandarization/MainMenu/M_general');

		$this->load->library('upload');

		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();

		define('direktoriUpload', './assets/upload/IA/StandarisasiDokumen/');
	}
	
	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}
	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'All Document';
		$data['Menu'] = 'Dokumen';
		$data['SubMenuOne'] = 'All Document';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['AllDocument'] = $this->M_general->ambilSemuaDokumen();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/AllDoc/V_index', $data);
		$this->load->view('V_Footer',$data);
	}	
}