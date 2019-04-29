<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class C_monitoringlppbkasiegudang extends CI_Controller{

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
		$this->load->model('MonitoringLppbKasieGudang/M_monitoringlppbkasiegudang');
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

		$cek_section = $this->M_monitoringlppbkasiegudang->cekSessionGudang();

		if ($cek_section) {
			$data['gudang'] = $this->M_monitoringlppbkasiegudang->getOpsiGudang($cek_section[0]['SOURCE']);
			$data['gudang2'] = $this->M_monitoringlppbkasiegudang->getOpsiGudang2();
		}else{
			$data['gudang'] = $this->M_monitoringlppbkasiegudang->getOpsiGudang2();
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbKasieGudang/V_unprocessedlppb',$data);
		$this->load->view('V_Footer',$data);
	}

	public function showGudangByKasie()
	{
		$id_gudang = $this->input->post('id_gudang');

		$getGudang = $this->M_monitoringlppbkasiegudang->showLppbKasieGudang($id_gudang);
		$data['lppb'] = $getGudang;
		$return = $this->load->view('MonitoringLppbKasieGudang/V_lppbgudang',$data,TRUE);
		
		echo ($return);
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

		$match = $this->M_monitoringlppbkasiegudang->getBatchDetailId($batch_number);
		$lppb_number1 = $match[0]['LPPB_NUMBER'];
		foreach ($match as $key => $value) {
			$lppb_number2 = $match[$key]['LPPB_NUMBER'];
		}
		$rangeLppb = "AND rsh.receipt_num between $lppb_number1 and $lppb_number2";
		$kondisi = "";
		$searchLppb = $this->M_monitoringlppbkasiegudang->detailUnprocess($batch_number,$rangeLppb);
		$jumlahData = $this->M_monitoringlppbkasiegudang->cekJumlahData($batch_number,$kondisi);
		$data['lppb'] = $searchLppb;
		$data['jml'] = $jumlahData;

		// echo "<pre>";
		// print_r($searchLppb);
		// exit();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbKasieGudang/V_detaillppbkasiegudang',$data);
		$this->load->view('V_Footer',$data);
	}

	public function saveActionLppbNumber(){
		$proses = $this->input->post('hdnProses[]');
		$alasan = $this->input->post('alasan_reject[]');
		$id = $this->input->post('id[]');
		$date = $this->input->post('tglTerimaTolak[]');
		$batch_number = $this->input->post('batch_number');

		foreach ($proses as $p => $value) {
			
			$this->M_monitoringlppbkasiegudang->saveProsesLppbNumber($proses[$p],$date[$p],$batch_number,$id[$p]);
			$this->M_monitoringlppbkasiegudang->saveProsesLppbNumber2($proses[$p],$alasan[$p],$date[$p],$id[$p]);
		}

		redirect('MonitoringLppbKasieGudang/Unprocess');
	}

	public function SubmitKeAKuntansi(){
		$date = date('d-m-Y H:i:s');
		$batch_number = $this->input->post('batch_number');

		$this->M_monitoringlppbkasiegudang->submitToKasieAkuntansi($date,$batch_number);
		$batch_detail_id  = $this->M_monitoringlppbkasiegudang->getBatchDetailId($batch_number);

		foreach ($batch_detail_id as $key => $value) {
			$id = $value['BATCH_DETAIL_ID'];
			$this->M_monitoringlppbkasiegudang->submitToKasieAkuntansi2($date,$id);
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

		$data['lppb'] = $this->M_monitoringlppbkasiegudang->finishLppbKasie();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbKasieGudang/V_finishlppb',$data);
		$this->load->view('V_Footer',$data);
	}

	public function detailFinishKasie($batch_number)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$match = $this->M_monitoringlppbkasiegudang->getBatchDetailId($batch_number);
		$lppb_number1 = $match[0]['LPPB_NUMBER'];
		foreach ($match as $key => $value) {
			$lppb_number2 = $match[$key]['LPPB_NUMBER'];
		}
		$rangeLppb = "AND rsh.receipt_num between $lppb_number1 and $lppb_number2";
		$kondisi = "AND klbd.status in (3,6,5)";
		$searchLppb = $this->M_monitoringlppbkasiegudang->finishdetail($batch_number,$rangeLppb);
		$jumlahData = $this->M_monitoringlppbkasiegudang->cekJumlahData($batch_number,$kondisi);
		$data['lppb'] = $searchLppb;
		$data['jml'] = $jumlahData;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbKasieGudang/V_finishdetailkasie',$data);
		$this->load->view('V_Footer',$data);
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

		$data['lppb'] = $this->M_monitoringlppbkasiegudang->rejectlppbkasie();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbKasieGudang/V_rejectlppb',$data);
		$this->load->view('V_Footer',$data);
	}
	public function RejectLppb($batch_number)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$match = $this->M_monitoringlppbkasiegudang->getBatchDetailId($batch_number);
		$lppb_number1 = $match[0]['LPPB_NUMBER'];
		foreach ($match as $key => $value) {
			$lppb_number2 = $match[$key]['LPPB_NUMBER'];
		}
			$rangeLppb = "AND rsh.receipt_num between $lppb_number1 and $lppb_number2";
			$kondisi = "AND klbd.status in (4,7)";
			$searchLppb = $this->M_monitoringlppbkasiegudang->rejectdetail($batch_number,$rangeLppb);
			$jumlahData = $this->M_monitoringlppbkasiegudang->cekJumlahData($batch_number,$kondisi);
		$data['lppb'] = $searchLppb;
		$data['jml'] = $jumlahData;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbKasieGudang/V_rejectdetail',$data);
		$this->load->view('V_Footer',$data);
	}

}