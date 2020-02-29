<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/** this menu created by DK-PKL 2019
 *  ticket from EDP/reny sulistya
 *  sorry for bad code :(
 *  write : 6 agst 2019
 */
class C_Istimewa extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PermohonanCuti/M_permohonancuti');
		//------cek hak akses halaman-------//
		$this->load->library('access');
		$this->access->page();
		//---------------^_^----------------//
		$this->checkSession();
	}

	public function checkSession()
	{
		if(!$this->session->is_logged){
			redirect('index');
		}
	}

	public function index(){
		$user_id = $this->session->userid;
		$noind = $this->session->user;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Surat Permohonan Cuti';
		$data['Menu'] = 'Surat Permohonan Cuti Istimewa';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Info'] = $this->M_permohonancuti->getPekerja($noind);
		$data['Cuti'] = $this->M_permohonancuti->getCutiIstimewa();
		$approval1 = $this->M_permohonancuti->getApproval($noind, $kodesie);
		if(empty($approval1)){ //this function is hidden error for user kd_jabatan >= 05
			$data['approval1'] = $approval1;
			$data['kdjbtn1'] = '-';
			$data['emptyapp'] = '1';
		}else{
			$data['approval1'] = $approval1;
			$data['kdjbtn1'] = $data['approval1']['0']['kd_jabatan'];
			$data['emptyapp'] = '0';
		}

		$this->load->model('PermohonanCuti/M_approval'); //force to load M_approval
		$data['kd_jabatan'] = $this->M_approval->getKdJbtn($noind); //get kd_jabatan user who login

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PermohonanCuti/PermohonanCuti/V_Istimewa',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Insert(){ //insert if passed authorization -> see function below
		date_default_timezone_set('Asia/Jakarta'); //force to set localtime indonesia WIB
		$noind = $this->session->user;

		$jenisCuti = $_POST['slc_JenisCutiIstimewa'];
		$approval1 = $_POST['slc_approval1'];
		$approval2 = $_POST['slc_approval2'];

		if(isset($_POST['txtPengambilanCuti']) && !empty($_POST['txtPengambilanCuti'])) {
			$ambilcuti = $_POST['txtPengambilanCuti'];
			$tglambilcuti = explode(",",$ambilcuti);

			function date_sort($a, $b){
				return strtotime($a) - strtotime($b);
			}
			usort($tglambilcuti, "date_sort");

			$ambil = new DateTime($tglambilcuti['0']);

			$mindate = $tglambilcuti['0'];
			$mindate = strtotime($mindate);
			$today = time();
			$difference = $mindate - $today;
			$days = floor($difference / (60*60*24) );
			$mintglambil = "3";
			$noind = $this->session->user;
			$tahun = date('Y');
			$sisacuti = $this->M_permohonancuti->getSisaCuti($noind,$tahun);
		}
		if(isset($_POST['txtPerkiraanLahir']) && !empty($_POST['txtPerkiraanLahir'])){
			$hpl = $_POST['txtPerkiraanLahir'];
			$before = $_POST['txtSebelumLahir'];
			$after = $_POST['txtSetelahLahir'];
			$tgl_hpl = date('Y-m-d',strtotime($hpl));
		}else{
			$tgl_hpl = NULL;
		}

		switch ($jenisCuti) {
			case '4':
			$keterangan = "PCZ";
			break;
			case '5':
			$keterangan = "CIK";
			break;
			case '6':
			$keterangan = "CM";
			break;
			case '7':
			$keterangan = "CK";
			break;
			case '8':
			$keterangan = "CPA";
			break;
			case '9':
			$keterangan = "CS";
			break;
			case '10':
			$keterangan = "CBA";
			break;
			case '11':
			$keterangan = "CIK";
			break;
			case '12':
			$keterangan = "CPP";
			break;
			case '14':
 			$keterangan = "CK";
 			break;
			default:
			$keterangan = "-";
			break;
		}

			// ----------------------- Insert --------------------//
			// lm_pengajuan_cuti //
		$pengajuan = array(
			'tgl_pengajuan' => date('Y-m-d'),
			'noind' => $noind,
			'keterangan' => $keterangan,
			'status' => '0',
			'tanggal_status' => date('Y-m-d H:i:s'),
			'lm_tipe_cuti_id' => '2',
			'lm_jenis_cuti_id' => $jenisCuti,
			'lm_keperluan_id' => NULL,
			'tgl_hpl' => $tgl_hpl
		);

		$this->M_permohonancuti->insertCuti($pengajuan);
		$pengajuan_id = $this->db->insert_id();

			//lm_pengajuan_cuti_tgl_ambil//
		if(isset($ambilcuti)){
			for ($i=0; $i < count($tglambilcuti) ; $i++) {
				$tglambil = array(
					'lm_pengajuan_cuti_id' => $pengajuan_id,
					'tgl_pengambilan' => $tglambilcuti[$i]
				);
				$this->M_permohonancuti->insertTglAmbil($tglambil);
			}
		}

			//lm_pengajuan_cuti_tgl_ambil//
		if(isset($hpl)){
			$jumlah = $before+$after;

			$date 	= date_create($hpl);
			$date1 	= date_create($hpl);
			$before = '-'.$before;
			$after 	= $after;
			$before = date_add($date,date_interval_create_from_date_string($before."days"));
			$after 	= date_add($date1,date_interval_create_from_date_string($after."days"));
			$before = date_format($before, 'd-m-Y');
			$after 	= date_format($after, 'd-m-Y');

			$start_date = $before;
			$end_date   = $after;

			$start    = new DateTime($start_date);
			$end      = new DateTime($end_date);
			$interval = new DateInterval('P1D');
			$period   = new DatePeriod($start, $interval, $end);

			$hpl = array();
			$i = '0';
			foreach ($period as $day) {
				$hpl[$i] = $day->format('Y-m-d');
				$i++;
			}
			array_push($hpl, date('Y-m-d', strtotime($end_date)));

			$banyak = count($hpl);
			for ($i=0; $i < $banyak ; $i++) {
				$ambil = array(
					'lm_pengajuan_cuti_id' => $pengajuan_id,
					'tgl_pengambilan' => $hpl[$i]
				);
				$this->M_permohonancuti->insertTglAmbil($ambil);
			}
		}

			// lm_approval_cuti //
		$appr1 = array(
			'approver' => $approval1,
			'level' => '1',
			'status' => '0',
			'lm_pengajuan_cuti_id' => $pengajuan_id,
			'alasan' => NULL,
			'ready' => '1'
		);
		$this->M_permohonancuti->insertApproval($appr1);

		$appr2 = array(
			'approver' => $approval2,
			'level' => '2',
			'status' => '1',
			'lm_pengajuan_cuti_id' => $pengajuan_id,
			'alasan' => NULL,
			'ready' => '0'
		);
		$this->M_permohonancuti->insertApproval($appr2);

		$appr3 = array(
			'approver' => 'EDP',
			'level' => '3',
			'status' => '1',
			'lm_pengajuan_cuti_id' => $pengajuan_id,
			'alasan' => NULL,
			'ready' => '0'
		);
		$this->M_permohonancuti->insertApproval($appr3);

			// lm_pengajuan_cuti_thread //
		$getnama = $this->M_permohonancuti->getNama($noind);
		$thread = array(
			'lm_pengajuan_cuti_id' => $pengajuan_id,
			'status' => '0',
			'detail' => '( Created ) - '.$getnama['0']['nama'].' telah membuat surat permohonan cuti istimewa baru',
			'waktu' => date('Y-m-d H:i:s')
		);
		$this->M_permohonancuti->insertThread($thread);
		//insert to sys.log_activity
		$aksi = 'Permohonan Cuti';
		$detail = "Insert Cuti Istimewa id=$pengajuan_id";
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect('PermohonanCuti/DraftCuti');
			// --------------------------------------------------------------------//
	}

	public function getHakCuti(){ //get max day to cuti for cuti Istimewa
		$keterangan = $_POST['ket'];
		if($keterangan == '-'){
			$data = '-';
		}else{
			$query = $this->M_permohonancuti->getHakCuti($keterangan);
			$data = $query['0']['hari_maks'];
		}
		echo json_encode($data);
	}

	public function getOtorisasi(){
		$jenisCuti = $_POST['jenis_cuti'];

		if(isset($_POST['tanggal'])) {
			$ambilcuti = $_POST['tanggal'];
			$hakcuti = $_POST['hak_cuti'];

			//array tgl ambil//
			$tglambilcuti = explode(",",$ambilcuti);

			function date_sort($a, $b){
				return strtotime($a) - strtotime($b);
			}
			usort($tglambilcuti, "date_sort");

			$ambil = new DateTime($tglambilcuti['0']);

			$mindate = $tglambilcuti['0'];
			$mindate = strtotime($mindate);
			$today = time();
			$difference = $mindate - $today;
			$days = floor($difference / (60*60*24) );
			$mintglambil = "3";
			$noind = $this->session->user;
			$tahun = date('Y');
			$sisacuti = $this->M_permohonancuti->getSisaCuti($noind,$tahun);
		}
		if(isset($_POST['hpl'])){
			$hpl = $_POST['hpl'];
			$before = $_POST['before'];
			$after = $_POST['after'];
		}

		//-------------------Otorisiasi Istimewa----------------//
		//1,2,4//
		$notif='';
		if ($jenisCuti == '4' OR $jenisCuti == '5' OR $jenisCuti == '7') {
			if($difference <= 0){
				// do nothing
			}else{
				$notif = '7';
			}
		}elseif ($jenisCuti == '6') {
			$ambil1 = $before;
			$ambil2 = $after;
			$jumlah = $before+$after;

			$date = date_create($hpl);
			$date1 = date_create($hpl);
			$before = '-'.$before;
			$after = $after;
			$before = date_add($date,date_interval_create_from_date_string($before."days"));
			$after =  date_add($date1,date_interval_create_from_date_string($after."days"));
			$before = date_format($before, 'd-m-Y');
			$after = date_format($after, 'd-m-Y');
			$beforeHPL = date('d F Y', strtotime($before));
			$afterHPL = date('d F Y', strtotime($after));

			if($jumlah > '90'){
				$notif = '9';
			}
		}elseif ($jenisCuti == "8" OR $jenisCuti == "9" OR $jenisCuti == "10" OR $jenisCuti == "12") {
			if($days < '3'){
				$notif = '10';
			}
		}elseif ($jenisCuti == '11'){
			if (count($tglambilcuti) > $hakcuti ){
				$notif = '9';
			}
		}
		if(isset($tglambilcuti)){
			if(count($tglambilcuti) > $hakcuti){
				$notif = '9';
			}
		}

		$data = array(
			'1' => "Sisa Cuti = 0",
			'2' => "Pekerja Belum Memiliki Cuti",
			'3' => "Pengajuan Cuti Tahunan min. H-6 pengambilan cuti",
			'4' => "Bukan Merupakan Cuti Mendadak",
			'5' => "Bukan Merupakan Cuti Susulan",
			'6' => "Jumlah Pengambilan Cuti Melebihi Sisa Cuti",
			'7' => "Bukan kejadian yang Terencana",
			'8' => "Harus mengirimkan Dokumen(Bukti) ke seksi Hubker",
			'9' => "Jumlah Cuti Melebihi Ketentuan",
			'10' => "Bukan termasuk acara mendadak (Acara yang terencana)",
			'11' => "Harap mengirimkan surat HPL dari Dokter / Rumah sakit",
			'12' => "Membuat surat pernyatan siap menanggung resiko"
		);
		if(!empty($notif)){
			$notif = $data[$notif];
		}else{
			$notif = "-";
		}
		if($jenisCuti == '6'){
			$data = array();
			$data['0'] = $notif;
			$data['1'] = $beforeHPL;
			$data['2'] = $afterHPL;
			$data['3'] = $ambil1;
			$data['4'] = $ambil2;
			$data['5'] = $jumlah;
			echo json_encode($data);
		}else{
			$data = array();
			$data['0'] = $notif;
			echo json_encode($data);
		}
	}
}
