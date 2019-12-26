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
	public function showLppbBatchAdmin() //GET OPSI GUDANG DI DRAFT
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
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbAdmin/V_mainmenu',$data);
		$this->load->view('V_Footer',$data);
	}
	public function showGudang() //FUNGSI MONITOR LPPB DI MENU DRAFT
	{
		$id_gudang = $this->input->post('id_gudang');
		$getGudang = $this->M_monitoringlppbadmin->showKhsLppbBatch($id_gudang);
		$data['lppb'] = $getGudang;
		$return = $this->load->view('MonitoringLppbAdmin/V_gudangLppb',$data,TRUE);
		
		echo ($return);
	}
	public function newLppbNumber() //FUNGSI SUBMIT LPPB
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['inventory'] = $this->M_monitoringlppbadmin->getInventory();
		// $data['status'] = $this->M_monitoringlppbadmin->getStatus();
		$data['gudang'] = $this->M_monitoringlppbadmin->getOpsiGudang2();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbAdmin/V_addlppbnumber',$data);
		$this->load->view('V_Footer',$data);

		// $this->output->cache(1);
	}
	public function addNomorLPPB(){ //FUNGSI SEARCH DI SUBMIT LPPB
		// print_r($_POST);
		$lppb_info = $this->input->post('info_lppb');
		$lppb_numberFrom = $this->input->post('lppb_numberFrom');
		$lppb_number = $this->input->post('lppb_number');
		$io = $this->input->post('inventory_organization');
		$status = $this->input->post('status_lppb');
		
		$query = '';
		if ($io !=  '' or $io != null) {
			$query .= "AND mp.organization_id LIKE '$io'";
		}else{
			$query .= "";
		}
		$queryStatus = '';
		if ($status != '' or $status != null) {
			$queryStatus .= "AND rt.transaction_type LIKE '$status'";
		}else{
			$queryStatus .= "";
		}
		$searchNumberLppb = $this->M_monitoringlppbadmin->searchNumberLppb($lppb_numberFrom,$lppb_number,$query, $queryStatus);
		$data['lppb'] = $searchNumberLppb;
		// print_r($data);exit();
		if ($searchNumberLppb) {
			$returnView = $this->load->view('MonitoringLppbAdmin/V_showtablelppb',$data,TRUE);
		}else{
			$returnView = "Data tidak ditemukan ... ";
		}
		echo $returnView;
	}
	public function addDetailNomorLPPB(){
		// echo "<pre>";print_r($_POST);
		$lppb_info = $this->input->post('info_lppb');
		$lppb_numberFrom = $this->input->post('lppb_numberFrom');
		$lppb_number = $this->input->post('lppb_number');
		$io = $this->input->post('inventory_organization');
		$status = $this->input->post('status_lppb');
		// $batch_number = $this->input->post('batch_number');

		$query = '';
		if ($io !=  '' or $io != null) {
			$query .= "AND mp.organization_id LIKE '$io'";
		}else{
			$query .= "";
		}

		$queryStatus = '';
		if ($status != '' or $status != null) {
			$queryStatus .= "AND rt.transaction_type LIKE '$status'";
		}else{
			$queryStatus .= "";
		}

		$searchNumberLppb = $this->M_monitoringlppbadmin->searchNumberLppb($lppb_numberFrom, $lppb_number, $query, $queryStatus);
		// $batch_detail_id = $this->M_monitoringlppbadmin->batch_detail_id($batch_number);
		$data['lppb'] = $searchNumberLppb;
		// $data['bdi'] = $batch_detail_id;

		if ($searchNumberLppb) {
			$returnView = $this->load->view('MonitoringLppbAdmin/V_detailshowtable',$data,TRUE);
		}else{
			$returnView = "Data tidak ditemukan ... ";
		}
		echo $returnView;
	}
	public function saveLppbNumber() //FUNGSI SAVE DI SUBMIT LPPB
	{
// 		Array
// (
//     [lppb_info] => test
//     [id_gudang] => 1
//     [lppb_number] =>  127 , 128 , 105 , 158 
//     [organization_id] =>  102 , 102 , 124 , 124 
//     [po_number] => Array
//         (
//             [0] =>  11000381 
//             [1] =>  11000381 
//             [2] =>  11001566 
//             [3] =>  11001350 
//         )

//     [po_header_id] => Array
//         (
//             [0] =>  1547 
//             [1] =>  1547 
//             [2] =>  3027 
//             [3] =>  2773 
//         )

// )
		// echo"<pre>";print_r($_POST);exit();
		$lppb_number = str_replace(' ', '', $this->input->post('lppb_number'));
		$status = $this->input->post('status');
		$lppb_info = $this->input->post('lppb_info');
		$date = date('d-m-Y H:i:s');
		$organization_id = $this->input->post('organization_id');
		$id_gudang = $this->input->post('id_gudang');
		$po_number = $this->input->post('po_number');
		$po_header_id = $this->input->post('po_header_id');
		$cek_section = $this->M_monitoringlppbadmin->checkSectionName($id_gudang);
		$tanggal = strtoupper(date('dMY'));
		$batch = $cek_section[0]['SECTION_KEYWORD'].'-'.$tanggal;
		$checkLengthBatch = $this->M_monitoringlppbadmin->checkLengthBatch($batch);
		$running_number = $this->M_monitoringlppbadmin->checkGroupBatch($batch,$checkLengthBatch[0]['LENGTH']);
		if ($running_number[0]['BATCH'] == 0) {
			$group_batch = $cek_section[0]['SECTION_KEYWORD'].'-'.$tanggal; 
		}else{
			$group_batch = $cek_section[0]['SECTION_KEYWORD'].'-'.$tanggal.'-'.$running_number[0]['BATCH']; 
		}
		$dataid = $this->M_monitoringlppbadmin->saveLppbNumber($date,$lppb_info,$batch,$group_batch,$id_gudang);
		$id = $dataid[0]['BATCH_NUMBER'];
		$exp_lppb_num = explode(',', $lppb_number);
		$exp_org_id = explode(',', $organization_id);//bikin array
		// $exp_po_num = explode(',',$po_number);
		// $exp_header_id = explode(',',$po_header_id);
		foreach ($exp_lppb_num as $key => $value) {
			$ponumb[] = explode(',', $po_number[$key]);
			$poheadid[] = explode(',', $po_header_id[$key]);
			foreach ($ponumb[$key] as $k => $data) {
				$id2 = $this->M_monitoringlppbadmin->saveLppbNumber2($id,$value,$date,$exp_org_id[$key],$data,$poheadid[$key][$k]);
				$id3 = $this->M_monitoringlppbadmin->batch_detail_id($id);
				$this->M_monitoringlppbadmin->saveLppbNumber3($id3[$key]['BATCH_DETAIL_ID'],$date);
			}
		}
		
	}
	public function detailLppb() //FUNGSI UNTUK VIEW DETAIL HASIL DARI MENU DRAFT
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$id = $this->input->post('batch_number');
		$searchLppb = $this->M_monitoringlppbadmin->lppbBatchDetail($id); //,$rangeLppb
		$jumlahData = $this->M_monitoringlppbadmin->cekJumlahData($id); //,$kondisi
		$gudang = $this->M_monitoringlppbadmin->getInventory();
		
		$data['inventory'] = $gudang;
		$data['lppb'] = $searchLppb;
		$data['jml'] = $jumlahData;

		// mencegah error

		if (!empty($data['lppb'])) {
				
			$this->load->view('MonitoringLppbAdmin/V_detaillppbnumber',$data);
			}else{
			echo "<script> Swal.fire({
  									type: 'error',
  									title: 'Maaf...',
 									text: 'Data Kosong',
									}) </script>";
			echo "<script>$('#mdlDetailAdminGudang').modal('hide')</script>";
			}
	}

	public function deleteNumberBatch(){ //DELETE BATCH
		$batch_number = $this->input->post('batch_number');
		$this->M_monitoringlppbadmin->deleteNumberBatch($batch_number);
	}
	public function submitToKasieGudang(){ //SUBMIT TO KASIE
		$status_date = date('d-m-Y H:i:s');
		$batch_number = $this->input->post('batch_number');
		$this->M_monitoringlppbadmin->submitToKasieGudang($status_date,$batch_number);
		$batch_detail_id  = $this->M_monitoringlppbadmin->getBatchDetailId($batch_number);
		foreach ($batch_detail_id as $key => $value) {
			$id = $value['BATCH_DETAIL_ID'];
			$this->M_monitoringlppbadmin->submitToKasieGudang2($status_date,$id);
		}
	}
	public function saveEditLppbNumber(){ //FUNGSI SAVE DI BAGIAN EDIT
		// echo"<pre>";print_r($_POST);
		$lppb_number = str_replace(' ', '', $this->input->post('lppb_number'));
		$date = date('d-m-Y H:i:s');
		$batch_number = $this->input->post('batch_number');
		$organization_id = $this->input->post('organization_id');
		$po_number = $this->input->post('po_number');
		$po_header_id = $this->input->post('po_header_id');
		$batch_detail_id = $this->input->post('batch_detail_id');
		$lppb_numberNew = str_replace(' ', '', $this->input->post('lppb_numberNew'));
		$organization_idNew = $this->input->post('organization_idNew');
		$po_numberNew = $this->input->post('po_numberNew');
		$po_header_idNew = $this->input->post('po_header_idNew');
		$id_lppb = $this->input->post('id_lppb');
		$expLppb = explode(',', $lppb_number);
		$expIo = explode(',', $organization_id);
		$expLppbNew = explode(',', $lppb_numberNew);
		$expIoNew = explode(',', $organization_idNew);
		$exp_po_num = explode(',',$po_number);
		$exp_po_header =  explode(',',$po_header_id);
		// $exp_batch_detail_id = explode(',',$batch_detail_id);
		$i = 0;
		foreach ($expLppb as $ln => $val) {
			$this->M_monitoringlppbadmin->saveEditLppbNumber2Update($batch_number,$expLppb[$ln],$date,$expIo[$ln],$exp_po_num[$ln],$exp_po_header[$ln]);
			$this->M_monitoringlppbadmin->saveEditLppbNumber3Update($batch_detail_id[$i],$date);
			$i++;
		}
		// echo"<pre>";
		
		if (!empty($expLppbNew[0])){
		foreach ($expLppbNew as $key => $value) {
			$ponumb[] = explode(',', $po_numberNew[$key]);
			$poheadid[] = explode(',', $po_header_idNew[$key]);
			foreach ($ponumb[$key] as $k => $data) {
				$id2 = $this->M_monitoringlppbadmin->saveEditLppbNumber2($batch_number,$value,$date,$expIoNew[$key],$data,$poheadid[$key][$k]);
				// print_r($id2);
				$id3 = $this->M_monitoringlppbadmin->getBdi($poheadid[$key][$k]);
				// print_r($id3);
				$this->M_monitoringlppbadmin->saveEditLppbNumber3($id3[0]['BATCH_DETAIL_ID'],$date);
				}
			}
		
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
	public function detailRejectLppb()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$id = $this->input->post('batch_number');
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

		if (!empty($data['lppb'])) {
				
			$this->load->view('MonitoringLppbAdmin/V_rejectDetailLppb',$data);
			}else{
			echo "<script> Swal.fire({
  									type: 'error',
  									title: 'Maaf...',
 									text: 'Data Kosong',
									}) </script>";
			echo "<script>$('#mdlRejectAdminGudang').modal('hide')</script>";
			}
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
	public function FinishDetail()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$batch_number = $this->input->post('batch_number');
		$match = $this->M_monitoringlppbadmin->getBatchDetailId($batch_number);
		$lppb_number1 = $match[0]['LPPB_NUMBER'];
		foreach ($match as $key => $value) {
			$lppb_number2 = $match[$key]['LPPB_NUMBER'];
		}
		$rangeLppb = "AND rsh.receipt_num between '$lppb_number1' and '$lppb_number2'";
		$kondisi = "AND klbd.status in (2,3,5,6)";
		$searchLppb = $this->M_monitoringlppbadmin->finishdetail($batch_number);
		$jumlahData = $this->M_monitoringlppbadmin->cekJumlahData($batch_number,$kondisi);
		$data['lppb'] = $searchLppb;
		$data['jml'] = $jumlahData;

		if (!empty($data['lppb'])) {
				
			$this->load->view('MonitoringLppbAdmin/V_finishdetail',$data);
			}else{
			echo "<script> Swal.fire({
  									type: 'error',
  									title: 'Maaf...',
 									text: 'Data Kosong',
									}) </script>";
			echo "<script>$('#mdlFinishAdminGudang').modal('hide')</script>";
			}
		
		// $this->load->view('V_Header',$data);
		// $this->load->view('V_Sidemenu',$data);
		// $this->load->view('MonitoringLppbAdmin/V_finishdetail',$data);
		// $this->load->view('V_Footer',$data);
	}
	public function deleteAllRows(){
		$batch_number = $this->input->post('batch_number');
		$this->M_monitoringlppbadmin->deleteAllRows($batch_number);
	}
}
?>