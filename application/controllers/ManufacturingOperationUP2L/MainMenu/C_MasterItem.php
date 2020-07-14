<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class C_MasterItem extends CI_Controller
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
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_masteritem');
		$this->load->model('ManufacturingOperationUP2L/Ajax/M_ajax');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!$this->session->is_logged){
			redirect('');
		}
	}

	public function index($message=FALSE)
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] 		= 'Master';
		$data['Menu'] 		= 'Manufacturing Operation';
		$data['SubMenuOne'] = 'Master Item';
		$data['SubMenuTwo'] = '';


		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['message'] 		= $message;

		$data['master'] = $this->M_masteritem->monitor();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperationUP2L/master/V_MasterItem', $data);
		$this->load->view('V_Footer',$data);
	}
	public function updateMasIt()
	{
		$user_id 	= $this->session->userid;
		$type 	 	= $this->input->post('txtType');
		$kodBar  	= $this->input->post('txtKodeBarang');
		$namBar  	= $this->input->post('txtNamaBarang');
		$proses  	= $this->input->post('txtProses');
		$kodPros 	= $this->input->post('txtKodeProses');
		$berat   	= $this->input->post('tBerat');
		$SK      	= $this->input->post('txtSK');
		$JS      	= $this->input->post('txtJS');
		$tglBerlaku = $this->input->post('tglBerlaku');
		$jenis   	= $this->input->post('txtJenis');
		$id      	= $this->input->post('txtId');
		

		$data = $this->M_masteritem->updateMasterItem($type,$kodBar,$namBar,$proses,$kodPros,$SK,$JS,$tglBerlaku,$user_id,$id,$jenis,$berat);
		redirect(base_url('ManufacturingOperationUP2L/MasterItem'));

	}

}