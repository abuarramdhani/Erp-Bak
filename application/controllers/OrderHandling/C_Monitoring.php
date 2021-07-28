<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monitoring extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('PHPMailerAutoload');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('OrderHandling/M_monitoring');
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	//---------------------------------------------------------MONITOIRNG ORDER / ORDER MASUK-----------------------------------------------------
	public function Monitoring()
	{
		$username = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Order Masuk Tim Handling';
		$data['Menu'] = 'Order Masuk';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderHandling/V_Monitoring', $data);
		$this->load->view('V_Footer',$data);
	}
    
	public function data_order(){
		$getdata = $this->M_monitoring->getdataorder(0);
		foreach ($getdata as $key => $value) {
			$pengorder = $this->M_monitoring->getPengorder($value['created_by']);
			$getdata[$key]['pengorder'] = $pengorder[0]['nama'];
			$getdata[$key]['section_name'] = $pengorder[0]['seksi'];
		}
		$data['data'] = $getdata;
		$this->load->view('OrderHandling/ajax/V_Monitoring_Table', $data);
	}
	
	public function approve_order(){
		$id_order 	= $this->input->post('id_order');
		$id_revisi 	= $this->input->post('id_revisi');
		if ($id_revisi == 0) {
			$this->M_monitoring->update_approve($id_order, 1, date('Y-m-d H:i:s'), $this->session->user, '');
		}else {
			$this->M_monitoring->update_approve2($id_order, 1, date('Y-m-d H:i:s'), $this->session->user, '', $id_revisi);
		}
	}
	
	public function reject_order(){
		$id_order 	= $this->input->post('id_order');
		$id_revisi 	= $this->input->post('id_revisi');
		$alasan 	= $this->input->post('alasan');
		if ($id_revisi == 0) {
			$this->M_monitoring->update_approve($id_order, -1, date('Y-m-d H:i:s'), $this->session->user, $alasan);
		}else {
			$this->M_monitoring->update_approve2($id_order, -1, date('Y-m-d H:i:s'), $this->session->user, $alasan, $id_revisi);
		}
	}


	//-----------------------------------------------------------PLOTTING ORDER----------------------------------------------------------------
	public function Plotting()
	{
		$username = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Plotting Order';
		$data['Menu'] = 'Plotting Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderHandling/V_Plotting_Order', $data);
		$this->load->view('V_Footer',$data);
	}

	public function data_plotting(){
		$data['blm_plot'] 	= $this->M_monitoring->getdataorder(1);
		$getdata 			= $this->M_monitoring->getdata_plotting();
		$tgl 				= $this->list_tanggal_plotting($getdata);
		foreach ($getdata as $key => $value) {
			for ($i=0; $i < count($tgl) ; $i++) { 
				$getdata[$key][$tgl[$i]] = 0;
			}
			$tanggal1 	= new DateTime($value['plot_startdate']);
			$tanggal2 	= new DateTime($value['plot_enddate']);
			$end 		= $tanggal2->modify('+1 day'); 
			$interval 	= new DateInterval('P1D');
			$daterange 	= new DatePeriod($tanggal1, $interval ,$end);
			foreach ($daterange as $date) {
				$tanggal 	= $date->format("dmY");
				if (in_array($tanggal, $tgl)) {
					$getdata[$key][$tanggal] = 1;
				}
			}
		}
		$bulan = array();
		for ($t=0; $t < count($tgl) ; $t++) { 
			$bln = substr($tgl[$t],2,2);
			if (array_search($bln, array_column($bulan, 'bulan')) !== false) {
				$bulan[$bln]['jumlah'] += 1;
			}else {
				$bulan[$bln]['bulan'] = $bln;
				$bulan[$bln]['jumlah'] = 1;
			}
		}
		$data['data'] 	= $getdata;
		$data['tgl'] 	= $tgl;
		$data['bulan'] 	= $bulan;
		// echo "<pre>";print_r($data);exit();
		$this->load->view('OrderHandling/ajax/V_Plotting_Table', $data);
	}

	public function list_tanggal_plotting($getdata){
		$i = 0;
		$tanggalnya = array();
		foreach ($getdata as $key => $value) {
			$tanggal1 	= new DateTime($value['plot_startdate']);
			$tanggal2 	= new DateTime($value['plot_enddate']);
			$end 		= $tanggal2->modify('+1 day'); 
			$interval 	= new DateInterval('P1D');
			$daterange 	= new DatePeriod($tanggal1, $interval ,$end);
			foreach ($daterange as $date) {
				$tanggal 	= $date->format("dmY");
				if (!in_array($tanggal, $tanggalnya)) {
					array_push($tanggalnya, $tanggal);
					$i++;
				}
			}
		}
		return $tanggalnya;
	}
	
	public function plotting_order(){
		$data['data'] = $this->M_monitoring->getdataorder(1);
		// echo "<pre>";print_r($data);exit();
		$this->load->view('OrderHandling/ajax/V_Plotting_Modal', $data);
	}
	
	public function periode_plot(){
		$data['id_order'] 	= $this->input->post('id_order');
		$data['id_revisi'] 	= $this->input->post('id_revisi');
		// echo "<pre>";print_r($data);exit();
		$this->load->view('OrderHandling/ajax/V_PeriodePlot_Modal', $data);
	}

	public function save_plotting_order(){
		$id_order = $this->input->post('id_order');
		$id_revisi = $this->input->post('id_revisi');
		$datanya = array(
					'order_number' 		=> $id_order,
					'plotting' 			=> 'Y',
					'plot_date' 		=> date('Y-m-d H:i:s'),
					'plot_by' 			=> $this->session->user,
					'plot_startdate' 	=> $this->input->post('tgl_awal'),
					'plot_enddate' 		=> $this->input->post('tgl_akhir')
		);
		$this->M_monitoring->insert_plotting($datanya);
		if ($id_revisi == 0) {
			$this->M_monitoring->update_status(2, $id_order);
		}else {
			$this->M_monitoring->update_status2(2, $id_order, $id_revisi);
		}
		redirect(base_url("OrderHandling/PlottingOrder"));
	}

	
	//-----------------------------------------------------------IN PROGRESS ORDER----------------------------------------------------------------
	public function InProgress()
	{
		$username = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'In Progress Order';
		$data['Menu'] = 'Order In Progress';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderHandling/V_Inprogres_Order', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function data_inprogress(){
		$getdata = $this->M_monitoring->getdata_inprogress();
		foreach ($getdata as $key => $value) {
			$progres = $this->db->select('op.*')->where("op.order_number = '".$value['order_number']."'")->get('oth.tprogress op')->result_array();
			if (!empty($progres)) { // hitung timer yang sedang berjalan
				$start_date = !empty($value['date_dummy']) ? strtotime($value['date_dummy']) : (
					$value['action'] == 1 ? strtotime(date('Y-m-d H:i:s')) : strtotime($progres[0]['start_date'])
				);
				$selisih 	= strtotime(date('Y-m-d H:i:s')) -  $start_date;
				$jam 		= floor($selisih/(60*60));
				$menit 		= $selisih - $jam * (60 * 60);
				$htgmenit 	= floor($menit/60) * 60;
				$detik 		= $menit - $htgmenit;
				$getdata[$key]['jam']   = sprintf("%02d", $jam);
				$getdata[$key]['menit'] = sprintf("%02d", (floor($menit/60)));
				$getdata[$key]['detik'] = sprintf("%02d", $detik);
				$getdata[$key]['start_date'] = $progres[0]['start_date'];
				$getdata[$key]['finish_date'] = $progres[0]['finish_date'];
			}else {
				$getdata[$key]['jam'] = $getdata[$key]['menit'] = $getdata[$key]['detik'] = sprintf("%02d", 00);
				$getdata[$key]['start_date'] = $getdata[$key]['finish_date'] = '';
			}
		}
		$data['data'] = $getdata;
		// echo "<pre>";print_r($data);exit();
		$this->load->view('OrderHandling/ajax/V_Inprogres_Table', $data);
	}

	public function save_mulai_progres(){
		$id_order = $this->input->post('id_order');
		$date = date('Y-m-d H:i:s');
		$cek = $this->db->select('op.*')->where("op.order_number = '".$id_order."'")->get('oth.tprogress op')->result_array();
		if (empty($cek)) {
			$this->M_monitoring->update_mulai_progres($id_order, $date);
		}else {
			$this->M_monitoring->update_action_selesai($id_order, 0, date('Y-m-d H:i:s'), '');
		}
	}
	
	public function save_persiapan_progres(){
		$id_order 	= $this->input->post('id_order');
		$id_revisi 	= $this->input->post('id_revisi');
		$persiapan 	= $this->input->post('persiapan');
		$this->M_monitoring->update_persiapan_progres($id_order, $persiapan);
	}
	
	public function save_pengelasan_progres(){
		$id_order 	= $this->input->post('id_order');
		$id_revisi 	= $this->input->post('id_revisi');
		$pengelasan = $this->input->post('pengelasan');
		$this->M_monitoring->update_pengelasan_progres($id_order, $pengelasan);
	}
	
	public function save_pengecatan_progres(){
		$id_order 	= $this->input->post('id_order');
		$id_revisi 	= $this->input->post('id_revisi');
		$pengecatan = $this->input->post('pengecatan');
		$this->M_monitoring->update_pengecatan_progres($id_order, $pengecatan);
	}
	
	public function save_dummy_progres(){
		$id_order 	= $this->input->post('id_order');
		$waktunya	= $this->waktu_inprogress($id_order);
		$this->M_monitoring->update_action_selesai($id_order, 1, 'NULL', ", time = '$waktunya'");
	}
	
	public function save_selesai_progres(){
		$id_order 	= $this->input->post('id_order');
		$id_revisi 	= $this->input->post('id_revisi');
		$end_date 	= date('Y-m-d H:i:s');
		$waktunya	= $this->waktu_inprogress($id_order);
		$this->M_monitoring->update_selesai_progres($id_order, $end_date, $waktunya);
		if ($id_revisi == 0) {
			$this->M_monitoring->update_status(3, $id_order);
		}else {
			$this->M_monitoring->update_status2(3, $id_order, $id_revisi);
		}
	}

	public function waktu_inprogress($id_order){
		$time		= ($this->input->post('jam')*3600) + ($this->input->post('menit')*60) + $this->input->post('detik');
		$dummy		= $this->db->select('op.time')->where("op.order_number = '".$id_order."'")->get('oth.tprogress op')->result_array();
		$dummy		= explode(':', $dummy[0]['time']);
		$dummy_time = !empty($dummy[0]) ? ($dummy[0]*3600) + ($dummy[1]*60) + $dummy[2] : 0;
		$waktu		= $time + $dummy_time;
		$jam 		= floor($waktu/(60*60));
		$menit 		= $waktu - $jam * (60 * 60);
		$htgmenit 	= floor($menit/60) * 60;
		$detik 		= $menit - $htgmenit;
		$waktunya	= sprintf("%02d", $jam).':'.sprintf("%02d", (floor($menit/60))).':'.sprintf("%02d", $detik);
		return $waktunya;
	}

	public function selesai_progress(){
		$data['no'] 		= $this->input->post('no');
		$data['id_order'] 	= $this->input->post('id_order');
		$data['id_revisi'] 	= $this->input->post('id_revisi');
		$data['qty'] 		= $this->input->post('qty');
		$inprogress			= $this->db->select('op.*')->where("op.order_number = '".$data['id_order']."'")->get('oth.tprogress op')->result_array();
		$data['inprogress']	= $inprogress[0];
		$this->load->view('OrderHandling/ajax/V_SelesaiProgress_Modal', $data);
	}
	
	//-----------------------------------------------------------ACHIEVEMENT ORDER----------------------------------------------------------------
	public function Achievement()
	{
		$username = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Achievement Order';
		$data['Menu'] = 'Achievement Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderHandling/V_Achievement', $data);
		$this->load->view('V_Footer',$data);
	}

	public function data_achievement(){
		$data['data'] 	= $this->M_monitoring->getdata_achiev(date('Y-m-d'),date('Y-m-d'));
		$data['ket'] 	= 'today';
		$this->load->view('OrderHandling/ajax/V_Achievement_Table', $data);
	}
	
	public function data_sch_achievement(){
		$tgl_awal 		= $this->input->post('tgl_awal');
		$tgl_akhir 		= $this->input->post('tgl_akhir');
		$data['data'] 	= $this->M_monitoring->getdata_achiev($tgl_awal, $tgl_akhir);
		$data['ket'] 	= 'sch';
		$this->load->view('OrderHandling/ajax/V_Achievement_Table', $data);
	}

}