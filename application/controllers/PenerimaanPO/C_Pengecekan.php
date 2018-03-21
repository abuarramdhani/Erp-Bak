<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class C_Pengecekan extends CI_Controller{

 		function __construct(){
	   parent::__construct();
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PenerimaanPO/M_pengecekan');
		$this->load->library('excel');
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
	}

	public function Index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['action'] = 'MonitoringKomponen/MonitoringSeksi/check';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PenerimaanPO/V_Pengecekan', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function checkSession(){
		if(!$this->session->is_logged){
			redirect();
		}
	}

	public function loadDataCek($SJ){
		$data = $this->M_pengecekan->loadDataCek($SJ);
		echo json_encode($data);
	}

	public function updateData(){
		$qtyActual = $this->input->post('qtyActual');
		$SJ		   = $this->input->post('SJ');
		$itemName  = $this->input->post('itemName');
		$itemDesc  = $this->input->post('itemDesc');
		$data = $this->M_pengecekan->updateData($qtyActual,$SJ,$itemName,$itemDesc);
		echo json_encode($data);
	}
 }