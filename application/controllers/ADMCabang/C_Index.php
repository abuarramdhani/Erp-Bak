<?php
Defined('BASEPATH') or exit('No Direct Sekrip Akses Allowed');
/**
 * 
 */
class C_Index extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ADMCabang/M_monitoringpresensi');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'ADM Cabang';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$user = $this->session->user;
		if(substr($user, 1,1) != 'B' && substr($user, 1,1) != 'D' && substr($user, 1,1) != 'J'){
			unset($data['UserMenu'][2]);
			unset($data['UserMenu'][3]);
		}
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMCabang/V_index',$data);
		$this->load->view('V_Footer',$data);
	}
}
?>