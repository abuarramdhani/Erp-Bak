<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_InputComponent extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('SystemAdministration/MainMenu/M_user');
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

	public function index($message=NULL)
	{
		$data = array (
			'message' => $message,
        );
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['title'] = 'Component Data Input';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StorageLocation/MainMenu/V_InputComponent',$data);
		$this->load->view('V_Footer',$data);
	}
}