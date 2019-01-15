<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class C_trackinglppb extends CI_Controller{

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
		$this->load->model('TrackingLppb/M_trackinglppb');
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

		$data['vendor_name'] = $this->M_trackinglppb->getVendorName();


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TrackingLppb/V_searchlppb',$data);
		$this->load->view('V_Footer',$data);
	}

	public function btn_search(){
		$nama_vendor = $this->input->post('nama_vendor');
		$nomor_lppb = $this->input->post('nomor_lppb');
		$dateFrom = $this->input->post('dateFrom');
		$dateTo = $this->input->post('dateTo');

		$parameter = '';

		if ($nama_vendor != '' OR $nama_vendor != NULL) {
			if ($parameter=='') {$parameter.='AND (';} else{$parameter.=' AND ';}
			$parameter .= "pov.vendor_name LIKE '%$nama_vendor%'";
		}

		if ($nomor_lppb != '' OR $nomor_lppb != NULL) {
			if ($parameter=='') {$parameter.='AND (';} else{$parameter.=' AND ';}
			$parameter .= "rsh.receipt_num LIKE '$nomor_lppb'";
		}

		if ($dateFrom != '' OR $dateFrom != NULL) {
			if ($parameter=='') {$parameter.='AND (';} else{$parameter.=' AND ';}
			$parameter .= "trunc(rsh.creation_date) BETWEEN to_date('$dateFrom','dd/mm/yyyy') and to_date('$dateTo', 'dd/mm/yyyy')";
		}

		if ($parameter!='') {$parameter.=') ';}	

		$tabel = $this->M_trackinglppb->monitoringLppb($parameter);	

		$data['lppb'] = $tabel;
		$return = $this->load->view('TrackingLppb/V_table',$data,TRUE);
		
		echo ($return);
	}

}