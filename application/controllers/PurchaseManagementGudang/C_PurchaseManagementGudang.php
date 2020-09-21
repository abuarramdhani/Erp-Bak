<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_PurchaseManagementGudang extends CI_Controller
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

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		// echo $this->session->responsibility_id; exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		if ($this->session->responsibility_id == 2569) {
			$this->load->view('PurchaseManagementGudang/NonConformity/V_Index', $data);
		}else{
			$this->load->view('PurchaseManagementGudang/V_index', $data);
		}
		$this->load->view('V_Footer',$data);
	}

} ?>