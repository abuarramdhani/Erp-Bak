<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_penerimaanAwal extends CI_Controller {

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
		$this->load->model('PenerimaanPO/M_penerimaanawal');
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
		$this->load->view('PenerimaanPO/V_PenerimaanAwal', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function checkSession(){
		if(!$this->session->is_logged){
			redirect();
		}
	}

	public function getListVendor(){		
		$key  = $this->input->post('term');	
		$data = $this->M_penerimaanawal->getListVendor($key);		
		echo json_encode($data); 
	}

	public function getListItem(){
		$key  = $this->input->post('term');
		$data = $this->M_penerimaanawal->getListItem($key); 
		echo json_encode($data);
	}

	public function loadVendor($PO){
		$data = $this->M_penerimaanawal->loadVendor($PO);
		echo json_encode($data);
	}

	public function loadPoLine($PO){
		$data = $this->M_penerimaanawal->loadPoLine($PO);
		echo json_encode($data);
	}

	public function generateSJ(){
		$data = $this->M_penerimaanawal->generateSJ();
		echo json_encode($data);
	}

	public function insertDataAwal(){
		$po		   = $this->input->post('po');	
		$sj		   = $this->input->post('sj');	
		$vendor	   = $this->input->post('vendor');	
		$item	   = $this->input->post('item');	
		$desc	   = $this->input->post('desc');	
		$qtySJ	   = $this->input->post('qtySJ');	
		$rcptDate  = $this->input->post('rcptDate');	
		$spDate	   = $this->input->post('spDate');	
		$qtyActual = $this->input->post('qtyActual');	
		$qtyPO	   = $this->input->post('qtyPO');

		$data = $this->M_penerimaanawal->insertDataAwal($po,$sj,$vendor,$item,$desc,$qtySJ,$rcptDate,$spDate,$qtyActual,$qtyPO);
		echo json_encode($data);
	}

}
	
	
	
	