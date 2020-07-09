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
				  //redirect('');
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

	public function loadDataCek(){
		$SJ = $this->input->post('sj');
		$data = $this->M_pengecekan->loadDataCek($SJ);
		echo json_encode($data);
	}

	public function updateData(){
		
		$qtyActual = $this->input->post('qtyActual');
		$SJ		   = $this->input->post('SJ');
		$itemName  = $this->input->post('itemName');
		$itemDesc  = $this->input->post('itemDesc');
		
		$data = $this->M_pengecekan->updateData($qtyActual,$SJ,$itemName,$itemDesc);
		$PO_HEADER_ID = $this->M_pengecekan->getPoHeaderId($SJ);
		$value['PO_HEADER_ID'] = $PO_HEADER_ID[0]['PO_HEADER_ID'];

		$PO_INVENTORY_ITEM_ID = $this->M_pengecekan->getInventoryItemId($itemName);
		$value['PO_INVENTORY_ITEM_ID'] = $PO_INVENTORY_ITEM_ID[0]['INVENTORY_ITEM_ID'];

		$PO_LINE_ID = $this->M_pengecekan->getPoLineId($SJ,$value['PO_INVENTORY_ITEM_ID']);
		$value['PO_LINE_ID'] = $PO_LINE_ID[0]['PO_LINE_ID'];

		$value['QTY'] = $qtyActual;
		$value['IP_ADDRESS'] = $this->get_client_ip();


		$this->M_pengecekan->insertTemp($value);
		echo json_encode($value);
	}

	public function runAPIone(){
		
		$SJ = $this->input->post('SJ');
		// $data = $this->M_pengecekan->updateData($qtyActual,$SJ,$itemName,$itemDesc);
		
		$PO_HEADER_ID = $this->M_pengecekan->getPoHeaderId($SJ);
		$value['PO_HEADER_ID'] = $PO_HEADER_ID[0]['PO_HEADER_ID'];

		$NO_PO = $this->M_pengecekan->getNoPo($SJ);
		
		$value['IP_ADDRESS'] = $this->get_client_ip();
		$value['NO_PO'] = $NO_PO[0]['SEGMENT1'];
		$value['GROUP_ID'] = '';
		if($this->M_pengecekan->runAPIone($value)){
	
			$GROUP_ID = $this->M_pengecekan->getGroupId($value['PO_HEADER_ID']);
			$value['GROUP_ID'] = $GROUP_ID[0]['GROUP_ID'];
	
		}

		echo json_encode($value['GROUP_ID']);

	}

	public  function runAPItwo(){
		$SJ = $this->input->post('SJ');
		$PO_HEADER_ID = $this->M_pengecekan->getPoHeaderId($SJ);
		$data['PO_HEADER_ID'] = $PO_HEADER_ID[0]['PO_HEADER_ID'];

		$GROUP_ID = $this->input->post('GROUP_ID');
		$value = '';
		if($this->M_pengecekan->runAPItwo($GROUP_ID)){
			$hasil = $this->M_pengecekan->getReceiptNumber($data['PO_HEADER_ID']);
			$value = $hasil[0]['RECEIPT_NUM'];
		}
		echo json_encode($value);
	}

	public function deleteAll(){
		$ip = $this->get_client_ip();
		$this->M_pengecekan->deleteAll($ip);
		echo json_encode($ip);
	}

	function get_client_ip() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDEDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
 }