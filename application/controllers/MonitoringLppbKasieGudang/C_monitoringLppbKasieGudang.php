<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class C_monitoringLppbKasieGudang extends CI_Controller{

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
		$this->load->model('MonitoringLppbKasieGudang/M_monitoringLppbKasieGudang');
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

		$data['lppb'] = $this->M_monitoringLppbKasieGudang->showLppbKasieGudang();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbKasieGudang/V_unprocessedLppb',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function detailLppbKasieGudang($batch_number)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$detailLppb = $this->M_monitoringLppbKasieGudang->lppbDetailKasieGudang($batch_number);

		$lppb_number = $detailLppb[0]['LPPB_NUMBER'];

		$searchLppb = $this->M_monitoringLppbKasieGudang->searchNumberLppb($lppb_number);
		$data['detailLppb'] = $detailLppb;
		$data['lppb'] = $searchLppb;
		// $data['alasan'] = $alasan;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbKasieGudang/V_detailLppbKasieGudang',$data);
		$this->load->view('V_Footer',$data);
	}

	public function saveActionLppbNumber(){
		$proses = $this->input->post('hdnProses[]');
		$alasan = $this->input->post('alasan_reject[]');
		$id = $this->input->post('id[]');
		$date = date('d-m-Y H:i:s');
		$batch_number = $this->input->post('batch_number');

		foreach ($proses as $p => $value) {
			
			$this->M_monitoringLppbKasieGudang->saveProsesLppbNumber($proses[$p],$date,$batch_number,$id[$p]);
			$this->M_monitoringLppbKasieGudang->saveProsesLppbNumber2($proses[$p],$alasan[$p],$date,$id[$p]);
		}

		redirect('MonitoringLppbKasieGudang/Unprocess');
	}

	public function SubmitKeAKuntansi(){
		$date = date('d-m-Y H:i:s');
		$batch_number = $this->input->post('batch_number');

		$this->M_monitoringLppbKasieGudang->submitToKasieAkuntansi($date,$batch_number);
		$batch_detail_id  = $this->M_monitoringLppbKasieGudang->getBatchDetailId($batch_number);

		foreach ($batch_detail_id as $key => $value) {
			$id = $value['BATCH_DETAIL_ID'];
			$this->M_monitoringLppbKasieGudang->submitToKasieAkuntansi2($date,$id);
		}

	}

}