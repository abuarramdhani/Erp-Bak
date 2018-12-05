<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class C_trackingInvoice extends CI_Controller{

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('TrackingInvoice/M_trackingInvoice');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }

    public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function TrackingInvoice(){

		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$nama_vendor = $this->M_trackingInvoice->getVendorName();

		$data['getVendorName'] =$nama_vendor;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TrackingInvoice/V_searchInvoice',$data);
		$this->load->view('V_Footer',$data);
	}

	public function btn_search(){
		$nama_vendor = $this->input->post('vendor_name');
		$po_number = $this->input->post('po_number');
		$any_keyword = $this->input->post('any_keyword');
		$invoice_number = $this->input->post('invoice_number');
		$invoice_date = $this->input->post('invoice_date');

		$param_inv = '';

		if ($nama_vendor != '' OR $nama_vendor != NULL) {
			if ($param_inv=='') {$param_inv.='AND(';} else{$param_inv.='OR';}
			$param_inv .= "ami.vendor_name LIKE '$nama_vendor%'";
		}

		if ($po_number != '' OR $po_number != NULL) {
			if ($param_inv=='') {$param_inv.='AND(';} else{$param_inv.='OR';}
			$param_inv .= "aaipo.po_detail LIKE '$po_number%'";
		}

		if ($invoice_number != '' OR $invoice_number != NULL) {
			if ($param_inv=='') {$param_inv.='AND(';} else{$param_inv.='OR';}
			$param_inv .= "ami.invoice_number LIKE '$invoice_number%'";
		}

		if ($invoice_date != '' OR $invoice_date != NULL) {
			if ($param_inv=='') {$param_inv.='AND(';} else{$param_inv.='OR';}
			$param_inv .= "ami.invoice_date LIKE '$invoice_date%'";
		}

		if ($param_inv!='') {$param_inv.=')';}

		$tabel = $this->M_trackingInvoice->searchMonitoringInvoice($param_inv);

		$status = array();
		foreach ($tabel as $tb => $value) {
			$po_detail = $value['PO_DETAIL'];
			if ($po_detail) {
				$explode_po_detail = explode('<br>', $po_detail);
				if (!$explode_po_detail) {
					$explode_po_detail = $po_detail;
				}

				$n = 0;
				$po_detail2 = array();
				foreach ($explode_po_detail as $po => $value2) {
					$explode_lagi = explode('-', $value2);

					$po_num = $explode_lagi[0];
					$line_num = $explode_lagi[1];
					$lppb_num = $explode_lagi[2];

					$match = $this->M_trackingInvoice->checkStatusLPPB($po_num,$line_num);

					if (!$match) {
						$statusLppb = 'No Status';
					}else{
						$statusLppb = $match[$n]['STATUS'];
					}

					$po_detail2[$po] = $value2.' - '.$statusLppb;
				}
				$status[$value['INVOICE_ID']] = $po_detail2;
				$n++;
			}		
		}

		$data['invoice'] = $tabel;
		$data['status'] = $status;
		$return = $this->load->view('TrackingInvoice/V_tableSearch',$data,TRUE);
		
		echo ($return);
	}

	public function DetailInvoice($invoice_id){

		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['invoice'] = $this->M_trackingInvoice->detailInvoice($invoice_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TrackingInvoice/V_detailTrackingInvoice',$data);
		$this->load->view('V_Footer',$data);
	}

}