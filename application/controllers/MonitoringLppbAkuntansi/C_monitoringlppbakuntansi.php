<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class C_monitoringlppbakuntansi extends CI_Controller{

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
		$this->load->model('MonitoringLppbAkuntansi/M_monitoringlppbakuntansi');
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

		$data['lppb'] = $this->M_monitoringlppbakuntansi->monitoringLppbAkuntansi();
		$data['gudang'] = $this->M_monitoringlppbakuntansi->getOpsiGudang();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbAkuntansi/V_unprocessedlppbakuntansi',$data);
		$this->load->view('V_Footer',$data);
	}

	public function showGudangByAkuntansi()
	{
		$id_gudang = $this->input->post('id_gudang');

		$getGudang = $this->M_monitoringlppbakuntansi->gudangLppbAkuntansi($id_gudang);
		$data['lppb'] = $getGudang;
		$return = $this->load->view('MonitoringLppbAkuntansi/V_lppbgudangakt',$data,TRUE);
		
		echo ($return);
	}
	
	public function detailLppbAkuntansi()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$batch_number = $this->input->post('batch_number');
		$detailLppb = $this->M_monitoringlppbakuntansi->getBatchDetailId($batch_number);
		
		$lppb_number1 = $detailLppb[0]['LPPB_NUMBER'];
		foreach ($detailLppb as $key => $value) {
			$lppb_number2 = $detailLppb[$key]['LPPB_NUMBER'];
		}
		$kondisi = "AND klbd.status = 5";
		$searchLppb = $this->M_monitoringlppbakuntansi->detailLppbAkuntansi($batch_number);
		$jumlahData = $this->M_monitoringlppbakuntansi->cekJumlahData($batch_number,$kondisi);
		$data['detailLppb'] = $searchLppb;
		$data['jml'] = $jumlahData;

		if (!empty($data['detailLppb'])) {
				
			$this->load->view('MonitoringLppbAkuntansi/V_detaillppbakuntansi',$data);

			}else{
			echo "<script> Swal.fire({
  									type: 'error',
  									title: 'Maaf...',
 									text: 'Data Kosong',
									}) </script>";
			echo "<script>$('#mdlDetailAkt').modal('hide')</script>";
			}

		// $this->load->view('V_Header',$data);
		// $this->load->view('V_Sidemenu',$data);
		// $this->load->view('V_Footer',$data);
	}

	public function openDetailLppb($batch_number)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		// $batch_number = $this->input->post('batch_number');
		$detailLppb = $this->M_monitoringlppbakuntansi->getBatchDetailId($batch_number);
		
		$lppb_number1 = $detailLppb[0]['LPPB_NUMBER'];
		foreach ($detailLppb as $key => $value) {
			$lppb_number2 = $detailLppb[$key]['LPPB_NUMBER'];
		}
		$kondisi = "AND klbd.status = 5";
		$searchLppb = $this->M_monitoringlppbakuntansi->detailLppbAkuntansi($batch_number);
		$jumlahData = $this->M_monitoringlppbakuntansi->cekJumlahData($batch_number,$kondisi);
		$data['detailLppb'] = $searchLppb;
		$data['jml'] = $jumlahData;

		// if (!empty($data['detailLppb'])) {
				

			// }else{
			// echo "<script> Swal.fire({
  	// 								type: 'error',
  	// 								title: 'Maaf...',
 		// 							text: 'Data Kosong',
			// 						}) </script>";
			// echo "<script>$('#mdlDetailAkt').modal('hide')</script>";
			// }

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbAkuntansi/V_detaillppbakuntansi',$data);
		$this->load->view('V_Footer',$data);
	}

	public function saveActionLppbNumber(){
		$proses = $this->input->post('hdnProses[]');
		$alasan = $this->input->post('alasan_reject[]');
		$id = $this->input->post('id[]');
		$date = $this->input->post('tglTerimaTolak[]');
		$batch_number = $this->input->post('batch_number');

		foreach ($proses as $p => $value) {
			
			$this->M_monitoringlppbakuntansi->saveProsesAkuntansi($proses[$p],$date[$p],$batch_number,$id[$p]);
			$this->M_monitoringlppbakuntansi->saveProsesAkuntansi2($proses[$p],$alasan[$p],$date[$p],$id[$p]);
		}

		
		redirect('MonitoringLppbAkuntansi/Unprocess');
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

		$data['lppb'] = $this->M_monitoringlppbakuntansi->finishLppbAkt();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbAkuntansi/V_finishlppbakt',$data);
		$this->load->view('V_Footer',$data);
	}

	public function finishDetail()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$batch_number= $this->input->post('batch_number');

		$detailLppb = $this->M_monitoringlppbakuntansi->getBatchDetailId($batch_number);
		$lppb_number1 = $detailLppb[0]['LPPB_NUMBER'];
		foreach ($detailLppb as $key => $value) {
			$lppb_number2 = $detailLppb[$key]['LPPB_NUMBER'];
		}
		// $rangeLppb = "AND rsh.receipt_num between '$lppb_number1' and '$lppb_number2'";
		$kondisi = "AND klbd.status = 6";
		$searchLppb = $this->M_monitoringlppbakuntansi->finishdetail($batch_number);
		$jumlahData = $this->M_monitoringlppbakuntansi->cekJumlahData($batch_number,$kondisi);
		$data['detailLppb'] = $searchLppb;
		$data['jml'] = $jumlahData;

		if (!empty($data['detailLppb'])) {
				
			$this->load->view('MonitoringLppbAkuntansi/V_finishdetailakt',$data);

			}else{
			echo "<script> Swal.fire({
  									type: 'error',
  									title: 'Maaf...',
 									text: 'Data Kosong',
									}) </script>";
			echo "<script>$('#mdlFinishAkt').modal('hide')</script>";
			}
                                                                                                         
		// $this->load->view('V_Header',$data);
		// $this->load->view('V_Sidemenu',$data);
		// $this->load->view('MonitoringLppbAkuntansi/V_finishdetailakt',$data);
		// $this->load->view('V_Footer',$data);
	}

	public function Reject()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['lppb'] = $this->M_monitoringlppbakuntansi->rejectlppbakuntansi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbAkuntansi/V_rejectlppb',$data);
		$this->load->view('V_Footer',$data);
	}

	public function RejectLppb()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$batch_number = $this->input->post('batch_number');

		$detailLppb = $this->M_monitoringlppbakuntansi->getBatchDetailId($batch_number);
		$lppb_number1 = $detailLppb[0]['LPPB_NUMBER'];
		foreach ($detailLppb as $key => $value) {
			$lppb_number2 = $detailLppb[$key]['LPPB_NUMBER'];
		}
		$rangeLppb = "AND rsh.receipt_num between $lppb_number1 and $lppb_number2";
		$kondisi = "AND klbd.status = 7";
		$searchLppb = $this->M_monitoringlppbakuntansi->rejectdetailakuntansi($batch_number,$rangeLppb);
		$jumlahData = $this->M_monitoringlppbakuntansi->cekJumlahData($batch_number,$kondisi);
		$data['detailLppb'] = $searchLppb;
		$data['jml'] = $jumlahData;
		if (!empty($data['detailLppb'])) {
				
			$this->load->view('MonitoringLppbAkuntansi/V_rejectdetail',$data);

			}else{
			echo "<script> Swal.fire({
  									type: 'error',
  									title: 'Maaf...',
 									text: 'Data Kosong',
									}) </script>";
			echo "<script>$('#mdlRejectAkt').modal('hide')</script>";
			}
		// $this->load->view('V_Header',$data);
		// $this->load->view('V_Sidemenu',$data);
		// $this->load->view('V_Footer',$data);
	}

}