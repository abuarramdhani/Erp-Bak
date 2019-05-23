<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MonitoringOmsetAkuntansi extends CI_Controller {
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
		$this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('MonitoringOmsetAkuntansi/M_MonitoringOmsetAkuntansi');
        	  
		 if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
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
        
        $data['query'] = $this->M_MonitoringOmsetAkuntansi->mntrgomst();
        $user = $this->input->get('usr');

        $order = array();
        foreach ($data['query'] as $key => $q) {
        if (!array_key_exists($q['ORDER_NUMBER'],$order)) {
            $order[$q['ORDER_NUMBER']]=array();
         }
             array_push($order[$q['ORDER_NUMBER']],$q);
         }

        $data['order'] = $order;
        $data['user'] = $user;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('MonitoringOmsetAkuntansi/V_Index',$data);
        $this->load->view('V_Footer',$data);
    }

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}

    public function print_mntrgomst()
    {
        $this->checkSession();

        $data['query'] = $this->M_MonitoringOmsetAkuntansi->mntrgomst();
        $order = array();
        foreach ($data['query'] as $key => $q) {
        if (!array_key_exists($q['ORDER_NUMBER'],$order)) {
            $order[$q['ORDER_NUMBER']]=array();
         }
            array_push($order[$q['ORDER_NUMBER']],$q);
         }
        $data['order'] = $order;

        $this->load->view('MonitoringOmsetAkuntansi/V_Print',$data);  
    }

    public function print_mntrgomst_fltr()
    {
        $this->checkSession();

        $start = $this->input->post('minCompletionIA');
        $end = $this->input->post('maxCompletionIA');

        if ($start=='' && $end=='' )
        {
            $data['query'] = $this->M_MonitoringOmsetAkuntansi->mntrgomst();
        }
        else {
            $data['query'] = $this->M_MonitoringOmsetAkuntansi->mntrgomst_fltr($start,$end);
        }

        $order = array();
        foreach ($data['query'] as $key => $q) {
            if (!array_key_exists($q['ORDER_NUMBER'],$order)) {
                $order[$q['ORDER_NUMBER']]=array();
            }
            array_push($order[$q['ORDER_NUMBER']],$q);
        }
        $data['order'] = $order;
        $this->load->view('MonitoringOmsetAkuntansi/V_Print',$data);  
    }
}

