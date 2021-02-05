<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Tracking extends CI_Controller
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
		$this->load->model('KapasitasGdSparepart/M_tracking');

		$this->checkSession();
	}

	public function checkSession(){
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index(){
		$user = $this->session->user;
		$user_id = $this->session->userid;

		$data['Title'] = 'Tracking SPB/DO';
		$data['Menu'] = 'Tracking SPB/DO';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_tracking->getDataSPB();
		// echo "<pre>"; print_r($data['data']); exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('KapasitasGdSparepart/V_Tracking', $data);
		$this->load->view('V_Footer',$data);
	}

	public function pendingSPB(){
		$jenis = $this->input->post('jenis');
		$no_spb = $this->input->post('nodoc');

		$this->M_tracking->savePending($jenis, $no_spb);
	}

	public function deletependingSPB(){
		$jenis = $this->input->post('jenis');
		$no_spb = $this->input->post('nodoc');

		$this->M_tracking->deletePending($jenis, $no_spb);
	}

}
