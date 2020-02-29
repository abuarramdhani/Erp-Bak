<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_User extends CI_Controller
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
		$this->load->model('MonitoringDeliverySparepart/M_usermng');

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
		$username = $this->session->username;
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title'] = 'User Management';
		$data['Menu'] = 'User Management';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_usermng->dataUser();
		// echo "<pre>"; print_r($data['data']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		
		// $cek = $this->M_usermng->cekHak($user);
		$this->load->view('MonitoringDeliverySparepart/V_User', $data);
		$this->load->view('V_Footer',$data);
		}
		
		function getSeksi()
	{
		$par 	= $this->input->post('par');
		$data = $this->M_usermng->seksi($par);
    	echo json_encode($data[0]['seksi']);
	}

	function getDept()
	{
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_usermng->deptclass($term);
    echo json_encode($data);
	}
    
  function saveUser(){
		$hak_akses		= $this->input->post('hak_akses');
		$seksi				= $this->input->post('seksiUser');
		$no_induk 		= $this->input->post('noInduk');
		$depart 			= $this->input->post('department');
		// echo "<pre>";print_r($depart);exit();

		$cek = $this->M_usermng->cekData($seksi, $no_induk);
		if (!empty($cek)) {
			$update = $this->M_usermng->updateUser($hak_akses, $depart, $cek[0]['id']);
		}else {
			$save = $this->M_usermng->saveUser($seksi, $no_induk, $depart, $hak_akses);
		}

		redirect(base_url('MonitoringDeliverySparepart/UserManagement'));
	}

	function deleteData($id, $no_induk){
		$delete = $this->M_usermng->deleteUser($id, $no_induk);

		redirect(base_url('MonitoringDeliverySparepart/UserManagement'));
	}

}