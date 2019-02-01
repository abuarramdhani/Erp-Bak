<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class C_monitoringlppbadmin extends CI_Controller{

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
		$this->load->model('MonitoringLppbAdmin/M_monitoringlppbadmin');
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
		$this->load->view('V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function showLppbBatchAdmin()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['lppb'] = $this->M_monitoringlppbadmin->showKhsLppbBatch();

		// echo "<pre>";
		// print_r($data['lppb']);
		// exit();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbAdmin/V_mainmenu',$data);
		$this->load->view('V_Footer',$data);
	}

	public function newLppbNumber()
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
		$this->load->view('MonitoringLppbAdmin/V_addlppbnumber',$data);
		$this->load->view('V_Footer',$data);
	}

	public function addNomorLPPB(){
		$lppb_info = $this->input->post('info_lppb');
		$lppb_number = $this->input->post('lppb_number');

		$searchNumberLppb = $this->M_monitoringlppbadmin->searchNumberLppb($lppb_number);
		$data['batch'] = $searchNumberLppb;

		echo json_encode($searchNumberLppb);
	}

	public function saveLppbNumber()
	{
		$lppb_number = $this->input->post('lppb_number[]');
		$status = $this->input->post('status');
		$lppb_info = $this->input->post('lppb_info');
		$date = date('d-m-Y H:i:s');

		$dataid = $this->M_monitoringlppbadmin->saveLppbNumber($date,$lppb_info);

		$id = $dataid[0]['BATCH_NUMBER'];

		foreach ($lppb_number as $ln => $val) {
			$no=0;
			$id2 = $this->M_monitoringlppbadmin->saveLppbNumber2($id,$lppb_number[$ln],$date);
			$id3 = $id2[$no]['BATCH_DETAIL_ID'];
			$this->M_monitoringlppbadmin->saveLppbNumber3($id3,$date);
		}
		$no++;

		redirect('MonitoringLPPB/ListBatch/newLppbNumber');
	}

	public function detailLppb($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$detailLppb = $this->M_monitoringlppbadmin->showLppbNumberDetail($id);

		$lppb_number = $detailLppb[0]['LPPB_NUMBER'];

		$searchLppb = $this->M_monitoringlppbadmin->searchNumberLppb($lppb_number);
		$data['detailLppb'] = $detailLppb;
		$data['lppb'] = $searchLppb;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbAdmin/V_detaillppbnumber',$data);
		$this->load->view('V_Footer',$data);
	}

	public function deleteNumberBatch(){
		$batch_number = $this->input->post('batch_number');
		$this->M_monitoringlppbadmin->deleteNumberBatch($batch_number);
		// redirect('MonitoringLPPB/ListBatch');
	}

	public function submitToKasieGudang(){
		$status_date = date('d-m-Y H:i:s');
		$batch_number = $this->input->post('batch_number');

		$this->M_monitoringlppbadmin->submitToKasieGudang($status_date,$batch_number);
		$batch_detail_id  = $this->M_monitoringlppbadmin->getBatchDetailId($batch_number);

		foreach ($batch_detail_id as $key => $value) {
			$id = $value['BATCH_DETAIL_ID'];
			$this->M_monitoringlppbadmin->submitToKasieGudang2($status_date,$id);
		}
	}

	public function saveEditLppbNumber()
	{
		$lppb_number = $this->input->post('lppb_number[]');
		$lppb_info = $this->input->post('lppb_info');
		$date = date('d-m-Y H:i:s');
		$batch_number = $this->input->post('batch_number');

		// echo "<pre>";
		// print_r($_POST);
		// exit();

		// $dataid = $this->M_monitoringlppbadmin->saveEditLppbNumber($lppb_info);

		// $id = $dataid[0]['BATCH_NUMBER'];

		foreach ($lppb_number as $ln => $val) {
			$no=0;
			$id2 = $this->M_monitoringlppbadmin->saveEditLppbNumber2($batch_number,$lppb_number[$ln],$date);
			$id3 = $id2[$no]['BATCH_DETAIL_ID'];
			$this->M_monitoringlppbadmin->saveEditLppbNumber3($id3,$date);
		}
		$no++;

		redirect('MonitoringLPPB/ListBatch/detailLppb/'.$batch_number);
	}

	public function deleteLppbNumber(){
		$batch_detail_id = $this->input->post('batch_detail_id');
		$this->M_monitoringlppbadmin->delBatchDetailId($batch_detail_id);
	}

	public function editable()
	{
		$lppb_number = $this->input->post('lppb_number');
		$date = date('d-m-Y H:i:s');
		$batch_detail_id = $this->input->post('batch_detail_id');

		// $data = $this->M_monitoringlppbadmin->editableLppbNumber($lppb_number,$date,$batch_detail_id);

		// echo json_encode($lppb_number);
	}

}