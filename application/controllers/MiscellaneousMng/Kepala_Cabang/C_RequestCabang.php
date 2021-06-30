<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RequestCabang extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('PHPMailerAutoload');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MiscellaneousMng/M_request');
		date_default_timezone_set('Asia/Jakarta');

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

		$data['Title'] = '';
		$data['Menu'] = 'Request Miscellaneous';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $data['view'] = 'Cabang';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MiscellaneousMng/V_Request', $data);
		$this->load->view('V_Footer',$data);
	}
	// detail kepala cabang ada di C_RequestAskanit
	
	public function submitCabang(){
		$id_header 	= $this->input->post('id_header');
		$id_item 	= $this->input->post('id_item[]');
		$action 	= $this->input->post('action[]');
		$note 		= $this->input->post('note[]');
		$pic 		= $this->session->user;
		$tgl		= date('Y-m-d H:i:s');

		for ($i=0; $i < count($id_item); $i++) { 
			$cek = $this->M_request->getdataCabang('where id_item = '.$id_item[$i].'');
			if (empty($cek)) {
				$act = empty($action[$i]) ? 'Approve' : $action[$i];
				$this->M_request->saveCabang($id_item[$i], $act, $note[$i], $pic, $tgl);
			}
		}

		$this->M_request->updateHeader('Proses Approve Ka. Seksi Utama / Aska / Ka. Unit', $id_header);

		redirect(base_url("MiscellaneousCabang/Request"));
	}

}