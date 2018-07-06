<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Order extends CI_Controller {

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
		$this->load->model('SiteManagement/MainMenu/M_order');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{	$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->M_order->RejectbySystem();

		$data['list_order'] = $this->M_order->listOrder($user_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Order/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function getSeksi()
	{
		$seksi = $_GET['s'];
		$data = $this->M_order->getSeksi($seksi);
		echo json_encode($data);
	}

	public function FilterData()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$periode = $this->input->post('sm_tglorder');
		$seksi = $this->input->post('order_seksi');
		$jenis = $this->input->post('sm_jenisorder');

		if ($periode=='') {
			$tgl1 = '';
			$tgl2 = '';
		}else{
			$tanggal = explode('-', $periode);
			$tgl1 = date('Y-m-d', strtotime($tanggal[0]));
			$tgl2 = date('Y-m-d',strtotime($tanggal[1]));
		}

		if ($seksi == "") {
			$query_sk = "";
		}else{
			$query_sk = "and so.seksi_order='$seksi'";
		}

		if ($jenis == "") {
			$query_jn = "";
		}else{
			$query_jn = "and so.jenis_order='$jenis'";
		}

		$data['filterdata'] = $this->M_order->FilterDataOrder($tgl1,$tgl2,$query_sk,$query_jn);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Order/V_Index', $data);
		$this->load->view('V_Footer',$data);	 	
	}

	public function readData($id)
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['header'] = $this->M_order->ReadHeader($plaintext_string);
		$data['lines'] = $this->M_order->ReadLines($plaintext_string);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Order/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

	public function RemarkSOrder()
	{
		$id = $this->input->post('id_order');
		$status = $this->input->post('status');

		$this->M_order->CekStatusOrder($status,$id);
	}

	public function RejectFromAdmin()
	{
		$id = $this->input->post('id');
		$this->M_order->RejectFromAdmin($id);
	}
}