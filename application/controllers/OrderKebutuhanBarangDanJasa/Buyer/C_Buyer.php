<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Buyer extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('OrderKebutuhanBarangDanJasa/Requisition/M_requisition');
		$this->load->model('OrderKebutuhanBarangDanJasa/Approver/M_approver');
		$this->load->model('OrderKebutuhanBarangDanJasa/Pengelola/M_pengelola');
		$this->load->model('OrderKebutuhanBarangDanJasa/Puller/M_puller');
        $this->load->model('OrderKebutuhanBarangDanJasa/Purchasing/M_purchasing');
        $this->load->model('OrderKebutuhanBarangDanJasa/Buyer/M_buyer');
        	  
		 if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
         }
        if($this->session->is_logged == FALSE){
            redirect();
        }
    }

    public function index()
	{   
		$user_id = $this->session->userid;
		
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
     
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/V_Index',$data);
        $this->load->view('V_Footer',$data);
    }

    public function ListDetailApprovedPurchasing()
    {
        $user_id = $this->session->userid;
        $noind = $this->session->user;
		
		$data['Menu'] = 'List Detail Approved Order';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['list_detail'] = $this->M_buyer->DetailApprovedOrder($noind);

        $this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Purchasing/V_DetailApprovedPurchasing',$data);
        $this->load->view('V_Footer',$data);
    }
}