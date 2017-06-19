<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_InputData extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('SaveLocation/MainMenu/M_Monitoring');
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->checkSession();
		// $this->load->model('lokasi-simpan/M_Lokasi_Simpan');
	}

	public function checkSession(){
		if($this->session->is_logged){
		}else{
			redirect('index');
		}
	}

	public function upload($message = NULL)
	{
		$data = array (
			'message' => $message,
            );
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['title'] = 'Upload From File';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SaveLocation/MainMenu/V_Upload',$data);
		$this->load->view('V_Footer',$data);
	}

	public function input_assy($message = NULL)
	{
		$data = array (
			'message' => $message,
            );
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['title'] = 'Sub Assy Data Input';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SaveLocation/MainMenu/V_InputAssy',$data);
		$this->load->view('V_Footer',$data);
	}

	public function input_comp($message=NULL)
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
		$this->load->view('SaveLocation/MainMenu/V_InputComponent',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Correction()
	{
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['title'] = 'Correction Save Location';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SaveLocation/MainMenu/V_koreksi');
		$this->load->view('V_Footer',$data);
	}

	// public function monitoring()
	// {
	// 	$this->load->view('lokasi-simpan/Template/V_header');
	// 	$this->load->view('lokasi-simpan/Template/V_navbar');
	// 	$this->load->view('lokasi-simpan/Template/V_sidebar');
	// 	$this->load->view('lokasi-simpan/lokasi-simpan/V_Monitoring');
	// 	$this->load->view('lokasi-simpan/Template/V_footer');
	// 	$this->load->view('lokasi-simpan/Template/V_mainfooter');
	// }

}