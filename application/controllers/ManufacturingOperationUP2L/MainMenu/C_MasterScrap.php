<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
//nggak disentuh total sama edwin
class C_MasterScrap extends CI_Controller
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
		$this->load->library('Excel');
        $this->load->library('upload');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_masterScrap');
		$this->load->model('ManufacturingOperationUP2L/Ajax/M_ajax');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index($message=FALSE)
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Master';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = 'Master Item';
		$data['SubMenuTwo'] = '';


		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['message'] 		= $message;

		$data['master'] = $this->M_masterScrap->monitor();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperationUP2L/master/V_MasterScrap', $data);
		$this->load->view('V_Footer',$data);
	}



	public function updateMasScrap()
	{
		$user_id = $this->session->userid;
		$desc = $this->input->post('txt_descScrap');
		$code = $this->input->post('text_kodeScrap');
		$id = $this->input->post('txtId');
		

		$data = $this->M_masterScrap->updateMasterScrap($desc,$code,$user_id,$id);
		redirect(base_url('ManufacturingOperationUP2L/MasterScrap'));

	}

	public function insertMasScrap()
	{
		$user_id = $this->session->userid;
		$desc = $this->input->post('txt_descScrap');
		$code = $this->input->post('txt_codeScrap');
		$creation_date = date('d/m/y');

		$data = $this->M_masterScrap->insertMasScrap($desc,$code,$creation_date,$user_id);
		redirect(base_url('ManufacturingOperationUP2L/MasterScrap'));

	}


}