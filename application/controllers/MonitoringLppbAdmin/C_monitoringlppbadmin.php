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

		$cek_section = $this->M_monitoringlppbadmin->cekSessionGudang();

		if ($cek_section) { //jika dia input lppb dengan source gudang terakhir yg di inputkan 
			$data['gudang'] = $this->M_monitoringlppbadmin->getOpsiGudang($cek_section[0]['SOURCE']);
			$data['gudang2'] = $this->M_monitoringlppbadmin->getOpsiGudang2();
		}else{
			$data['gudang'] = $this->M_monitoringlppbadmin->getOpsiGudang2();
		}

		// print_r($data['gudang']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbAdmin/V_mainmenu',$data);
		$this->load->view('V_Footer',$data);
	}

	public function showGudang()
	{
		$id_gudang = $this->input->post('id_gudang');

		$getGudang = $this->M_monitoringlppbadmin->showKhsLppbBatch($id_gudang);
		$data['lppb'] = $getGudang;
		$return = $this->load->view('MonitoringLppbAdmin/V_gudangLppb',$data,TRUE);
		
		echo ($return);
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

		$data['inventory'] = $this->M_monitoringlppbadmin->getInventory();
		$data['gudang'] = $this->M_monitoringlppbadmin->getOpsiGudang2();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbAdmin/V_addlppbnumber',$data);
		$this->load->view('V_Footer',$data);
	}

	public function addNomorLPPB(){
		$lppb_info = $this->input->post('info_lppb');
		$lppb_numberFrom = $this->input->post('lppb_numberFrom');
		$lppb_number = $this->input->post('lppb_number');
		$io = $this->input->post('inventory_organization');

		$query = '';
		if ($io !=  '' or $io != null) {
			$query .= "AND mp.organization_id LIKE '$io'";
		}else{
			$query .= "";
		}

		$searchNumberLppb = $this->M_monitoringlppbadmin->searchNumberLppb($lppb_numberFrom,$lppb_number,$query);
		$data['lppb'] = $searchNumberLppb;

		if ($searchNumberLppb) {
			// echo json_encode($searchNumberLppb);
			$returnView = $this->load->view('MonitoringLppbAdmin/V_showtablelppb',$data,TRUE);
			echo ($returnView);
		}else{
			// echo json_encode(false);
			echo "Data tidak ditemukan ... ";
		}

	}

	public function saveLppbNumber()
	{
		$lppb_number = str_replace(' ', '', $this->input->post('lppb_number'));
		$status = $this->input->post('status');
		$lppb_info = $this->input->post('lppb_info');
		$date = date('d-m-Y H:i:s');
		$organization_id = $this->input->post('organization_id');
		$id_gudang = $this->input->post('id_gudang');
		$po_number = $this->input->post('po_number');
		$po_header_id = $this->input->post('po_header_id');
		// $line_num = $this->input->post('line_num');

		$cek_section = $this->M_monitoringlppbadmin->checkSectionName($id_gudang);
		// echo "<pre>";

		$tanggal = strtoupper(date('dMY'));
		$batch = $cek_section[0]['SECTION_KEYWORD'].'-'.$tanggal;
		$checkLengthBatch = $this->M_monitoringlppbadmin->checkLengthBatch($batch);
		$running_number = $this->M_monitoringlppbadmin->checkGroupBatch($batch,$checkLengthBatch[0]['LENGTH']);

		if ($running_number[0]['BATCH'] == 0) {
			$group_batch = $cek_section[0]['SECTION_KEYWORD'].'-'.$tanggal; 
		}else{
			$group_batch = $cek_section[0]['SECTION_KEYWORD'].'-'.$tanggal.'-'.$running_number[0]['BATCH']; 
		}
		// print_r($group_batch);
		// exit();

		$dataid = $this->M_monitoringlppbadmin->saveLppbNumber($date,$lppb_info,$cek_section[0]['SECTION_NAME'],$group_batch,$id_gudang);

		$id = $dataid[0]['BATCH_NUMBER'];

		$exp_lppb_num = explode(',', $lppb_number);
		foreach ($exp_lppb_num as $ln => $val) {
			$no=0;
			$exp_org_id = explode(',', $organization_id);
			$exp_po_num = explode(',',$po_number);
			$exp_header_id = explode(',',$po_header_id);
			// $exp_line_num = explode(',',$line_num);
			$id2 = $this->M_monitoringlppbadmin->saveLppbNumber2($id,$exp_lppb_num[$ln],$date,$exp_org_id[$ln],$exp_po_num[$ln],$exp_header_id[$ln]);
			$id3 = $this->M_monitoringlppbadmin->batch_detail_id($id);
			$this->M_monitoringlppbadmin->saveLppbNumber3($id3[$ln]['BATCH_DETAIL_ID'],$date);
		}
		$no++;
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

		$data['inventory'] = $this->M_monitoringlppbadmin->getInventory();

		$match = $this->M_monitoringlppbadmin->getBatchDetailId($id);
		$lppb_number1 = $match[0]['LPPB_NUMBER'];
		foreach ($match as $key => $value) {
			$lppb_number2 = $match[$key]['LPPB_NUMBER'];
		}
		$rangeLppb = "AND rsh.receipt_num between $lppb_number1 and $lppb_number2";
		$kondisi = "";
		$searchLppb = $this->M_monitoringlppbadmin->lppbBatchDetail($id,$rangeLppb);
		$jumlahData = $this->M_monitoringlppbadmin->cekJumlahData($id,$kondisi);
		$data['lppb'] = $searchLppb;
		$data['jml'] = $jumlahData;

		// echo "<pre>";
		// print_r($searchLppb);
		// exit();


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbAdmin/V_detaillppbnumber',$data);
		$this->load->view('V_Footer',$data);
	}

	public function deleteNumberBatch(){
		$batch_number = $this->input->post('batch_number');
		$this->M_monitoringlppbadmin->deleteNumberBatch($batch_number);
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
		$lppb_number = str_replace(' ', '', $this->input->post('lppb_number'));
		$date = date('d-m-Y H:i:s');
		$batch_number = $this->input->post('batch_number');
		$organization_id = $this->input->post('organization_id');
		$po_number = $this->input->post('po_number');
		$po_header_id = $this->input->post('po_header_id');
		// $po_line_id = $this->input->post('po_line_id');
		$id_lppb = $this->input->post('id_lppb');

		$dataid = $this->M_monitoringlppbadmin->saveEditLppbNumber($batch_number);

		$id = $dataid[0]['BATCH_NUMBER'];

		$expLppb = explode(',', $lppb_number);

		foreach ($expLppb as $ln => $val) {
			$exp_org_id = explode(',', $organization_id);
			$exp_po_num = explode(',',$po_number);
			$exp_po_header = explode(',',$po_header_id);
			// $exp_po_line_id = explode(',',$po_line_id);
			$id2 = $this->M_monitoringlppbadmin->saveEditLppbNumber2($batch_number,$expLppb[$ln],$date,$exp_org_id[$ln],$exp_po_num[$ln],$exp_po_header[$ln]);
			$id3 = $this->M_monitoringlppbadmin->limitBatchDetId($id,$id_lppb);
			$this->M_monitoringlppbadmin->saveEditLppbNumber3($id3[$ln]['BATCH_DETAIL_ID'],$date);
		}
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

	public function showRejectLppb()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$detailLppb = $this->M_monitoringlppbadmin->showRejectLppb();
		$data['lppb'] = $detailLppb;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbAdmin/V_rejectlppb',$data);
		$this->load->view('V_Footer',$data);
	}

	public function detailRejectLppb($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$match = $this->M_monitoringlppbadmin->getBatchDetailId($id);
		$no=0;
		$lppb_number1 = $match[0]['LPPB_NUMBER'];
		foreach ($match as $key => $value) {
			$lppb_number2 = $match[$key]['LPPB_NUMBER'];
		}$no++;
		$rangeLppb = "AND rsh.receipt_num between '$lppb_number1' and '$lppb_number2'";
		$kondisi = "AND klbd.status in (4,7)";
		$searchLppb = $this->M_monitoringlppbadmin->showRejectDetail($id,$rangeLppb);
		$jumlahData = $this->M_monitoringlppbadmin->cekJumlahData($id,$kondisi);
		$data['lppb'] = $searchLppb;
		$data['jml'] = $jumlahData;


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbAdmin/V_rejectDetailLppb',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Finish()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['lppb'] = $this->M_monitoringlppbadmin->finishLppbKasie();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbAdmin/V_finishlppb',$data);
		$this->load->view('V_Footer',$data);
	}

	public function FinishDetail($batch_number)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$match = $this->M_monitoringlppbadmin->getBatchDetailId($batch_number);
		$lppb_number1 = $match[0]['LPPB_NUMBER'];
		foreach ($match as $key => $value) {
			$lppb_number2 = $match[$key]['LPPB_NUMBER'];
		}
		$rangeLppb = "AND rsh.receipt_num between '$lppb_number1' and '$lppb_number2'";
		$kondisi = "AND klbd.status in (2,3,5,6)";
		$searchLppb = $this->M_monitoringlppbadmin->finishdetail($batch_number,$rangeLppb);
		$jumlahData = $this->M_monitoringlppbadmin->cekJumlahData($batch_number,$kondisi);
		$data['lppb'] = $searchLppb;
		$data['jml'] = $jumlahData;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbAdmin/V_finishdetail',$data);
		$this->load->view('V_Footer',$data);
	}

	public function deleteAllRows(){
		$batch_number = $this->input->post('batch_number');
		$this->M_monitoringlppbadmin->deleteAllRows($batch_number);
	}

}