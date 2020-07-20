<?php
defined('BASEPATH') or exit('No direct script access allowed');
/** this menu created by DK-PKL 2019
 *  ticket from EDP/reny sulistya
 *  sorry for bad code :(
 *  write : 6 agst 2019
 */
class C_Tahunan extends CI_Controller
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
		if (!$this->session->is_logged) {
			redirect('');
		}
	}

	public function index()
	{
		$user_id = $this->session->userid;
		$noind = $this->session->user;
		$tahun = date('Y');
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Surat Permohonan Cuti';
		$data['Menu'] = 'Surat Permohonan Cuti / Istirahat Tahunan';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		$data['Info'] = $this->M_permohonancuti->getPekerja($noind);

		$this->load->model('PermohonanCuti/M_approval');
		$data['kd_jabatan'] = $this->M_approval->getKdJbtn($noind);

		$data['SisaCuti'] = $this->M_permohonancuti->getSisaCuti($noind, $tahun);
		$data['Cuti'] = $this->M_permohonancuti->getCutiTahunan();
		$data['keperluan'] = $this->M_permohonancuti->getKeperluan();
		$approval1 = $this->M_permohonancuti->getApproval($noind, $kodesie);
		if (empty($approval1)) {
			$data['approval1'] = $approval1;
			$data['kdjbtn1'] = '-';
			$data['emptyapp'] = '1';
		} else {
			$data['approval1'] = $approval1;
			$data['kdjbtn1'] = $data['approval1']['0']['kd_jabatan'];
			$data['emptyapp'] = '0';
		}
		$data['mintglpengambilan'] = $this->M_permohonancuti->getTglBlhAmbil($noind, $tahun);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('PermohonanCuti/PermohonanCuti/V_Tahunan', $data);
		$this->load->view('V_Footer', $data);
		$this->output->cache(1);
	}

	public function Insert()
	{
		date_default_timezone_set('Asia/Jakarta');
		$noind = $this->session->user;

		$jenisCuti = $_POST['slc_JenisCutiTahunan'];
		if (isset($_POST['txtKeperluan']) && !empty($_POST['txtKeperluan'])) {
			$keperluan = $_POST['txtKeperluan'];
			$id_keperluan = NULL;
			$kprln = $keperluan;
		}
		if (isset($_POST['slc_Keperluan']) && !empty($_POST['slc_Keperluan'])) {
			$keperluan = $_POST['slc_Keperluan'];
			$id_keperluan = $keperluan;
			$kprln = NULL;
		}

		if ($_POST['slc_JenisCutiTahunan'] == '13') {
			$ambilcuti = explode(" - ", $_POST['txtPengambilanCutiSusulan']);
			$before = date('d-m-Y', strtotime($ambilcuti['0']));
			$after = date('d-m-Y', strtotime($ambilcuti['1']));

			$start_date = $before;
			$end_date   = $after;

			$start    = new DateTime($start_date);
			$end      = new DateTime($end_date);
			$interval = new DateInterval('P1D');
			$period   = new DatePeriod($start, $interval, $end);

			$tglambilcuti = array();
			$i = '0';
			foreach ($period as $day) {
				$tglambilcuti[$i] = $day->format('Y-m-d');
				$i++;
			}
			array_push($tglambilcuti, date('Y-m-d', strtotime($end_date)));
		} else {
			$ambilcuti = $_POST['txtPengambilanCuti'];
			$tglambilcuti = explode(",", $ambilcuti);
		}

		$approval1 = $_POST['slc_approval1'];
		if (isset($_POST['slc_approval2']) || !empty($_POST['slc_approval2'])) {
			$approval2 = $_POST['slc_approval2'];
		} else {
			$approval2 = NULL;
		}

		function date_sort($a, $b)
		{
			return strtotime($a) - strtotime($b);
		}
		usort($tglambilcuti, "date_sort");

		$tglbolehambil = $this->M_permohonancuti->getTglAmbil($noind);

		$ambil = new DateTime($tglambilcuti['0']);
		$boleh = new DateTime($tglbolehambil['0']['tgl_boleh_ambil']);

		$mindate = $tglambilcuti['0'];
		$mindate = strtotime($mindate);
		$today = time();
		$difference = $mindate - $today;
		$days = floor($difference / (60 * 60 * 24));
		$mintglambil = "6";
		$noind = $this->session->user;
		$tahun = date('Y');
		$sisacuti = $this->M_permohonancuti->getSisaCuti($noind, $tahun);

		// ----------------------- Insert --------------------//
		// lm_pengajuan_cuti //
		$pengajuan = array(
			'tgl_pengajuan' => date('Y-m-d'),
			'noind' => $noind,
			'keterangan' => 'CT',
			'status' => '0',
			'tanggal_status' => date('Y-m-d H:i:s'),
			'lm_tipe_cuti_id' => '1',
			'lm_jenis_cuti_id' => $jenisCuti,
			'lm_keperluan_id' => $id_keperluan,
			'keperluan' => $kprln,
			'tgl_hpl' => NULL
		);

		$this->M_permohonancuti->insertCuti($pengajuan);
		$pengajuan_id = $this->db->insert_id();


		//lm_pengajuan_cuti_tgl_ambil//
		for ($i = 0; $i < count($tglambilcuti); $i++) {
			$tglambil = array(
				'lm_pengajuan_cuti_id' => $pengajuan_id,
				'tgl_pengambilan' => $tglambilcuti[$i]
			);
			$this->M_permohonancuti->insertTglAmbil($tglambil);
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
			'approver' => 'Hubker',
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
			'detail' => '( Created ) - ' . $getnama['0']['nama'] . ' telah membuat surat permohonan cuti tahunan baru',
			'waktu' => date('Y-m-d H:i:s')
		);
		$this->M_permohonancuti->insertThread($thread);

		//insert to sys.log_activity
		$aksi = 'Permohonan Cuti';
		$detail = "Insert Cuti Tahunan id=$pengajuan_id";
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect('PermohonanCuti/DraftCuti');
	}

	public function getApproval2()
	{
		$noind = $_POST['noind'];
		$kodesie = $this->session->kodesie;
		$var = $this->M_permohonancuti->getApproval($noind, $kodesie);
		echo json_encode($var);
	}

	public function getOtorisasi()
	{
		$noind = $this->session->user;
		$today = time();
		$mintglambil = "6";
		$tahun = date('Y');

		$jenisCuti = $_POST['jenis_cuti'];

		$susulanEnd = explode(" - ", $_POST['tanggalsusulan']);

		$ambilcuti = $_POST['tanggal'];

		$tglambilcuti = explode(",", $ambilcuti);

		function date_sort($a, $b)
		{
			return strtotime($a) - strtotime($b);
		}
		usort($tglambilcuti, "date_sort");

		$tglbolehambil = $this->M_permohonancuti->getTglAmbil($noind);

		$ambil = new DateTime($tglambilcuti['0']);
		$boleh = new DateTime($tglbolehambil['0']['tgl_boleh_ambil']);

		$mindate = strtotime($tglambilcuti['0']);
		$difference = $mindate - $today;
		$days = floor($difference / (60 * 60 * 24) + 1);

		$sisacuti = $this->M_permohonancuti->getSisaCuti($noind, $tahun);

		//-------------------Otorisiasi Tahunan----------------//
		//istirahat tahunan//
		if ($jenisCuti == "2") {
			if ($ambil < $boleh) { //benar
				$notif = "2";
			} elseif ($days <= $mintglambil) {
				$notif = "3";
			}
			//istirahat tahunan mendadak//
		} elseif ($jenisCuti == "3") {
			if ($ambil < $boleh) {
				$notif = "2";
			} elseif ($days > 6) {
				$notif = "4";
			}
			//istirahat susulan//
		} elseif ($jenisCuti == "13") {
			$maxdate = strtotime($susulanEnd['1']);
			$mindate = strtotime($susulanEnd['0']);

			$difference = $maxdate - $today;

			$days = floor($difference / (60 * 60 * 24) + 1);
			$ambil = new DateTime($susulanEnd['0']);

			$ambilcuti = explode(" - ", $_POST['tanggalsusulan']);
			$before = date('d-m-Y', strtotime($ambilcuti['0']));
			$after = date('d-m-Y', strtotime($ambilcuti['1']));

			$start_date = $before;
			$end_date   = $after;

			$start    = new DateTime($start_date);
			$end      = new DateTime($end_date);
			$interval = new DateInterval('P1D');
			$period   = new DatePeriod($start, $interval, $end);

			$tglambilcuti = array();
			$i = '0';
			foreach ($period as $day) {
				$tglambilcuti[$i] = $day->format('Y-m-d');
				$i++;
			}
			array_push($tglambilcuti, date('Y-m-d', strtotime($end_date)));

			$today   		= date('Y-m-d');
			$yesterday	= date('Y-m-d', strtotime($today . ' -1 days'));
			$startDate 	= date('Y-m-d', $maxdate);
			$startDate 	= date('Y-m-d', strtotime($startDate . "-1 days"));
			$pkj 				= array();
			$cekTM 			= array();

			foreach ($tglambilcuti as $key) {
				$cekTM[] = $this->M_permohonancuti->cekTM($key, $_SESSION['user']); //cuti susulan hanya dpt diambil tgl dimana mangkir
			}

			if (in_array(0, $cekTM)) {
				$notif = '13';
			} else {
				if ($startDate <= $yesterday) {
					while ($startDate != $yesterday) {
						$startDate 		= date('Y-m-d', strtotime($startDate . " +1 days"));
						$cekPKJ 			= $this->M_permohonancuti->cekPKJ($startDate, $_SESSION['user']);
						if ($cekPKJ > 0) {
							$pkj[] = 1;
						} else {
							$pkj[] = 0;
						}
					}
				}
			}
			if (in_array(1, $pkj)) {
				$notif = '13';
			}
			if ($ambil < $boleh) {
				$notif = "2";
			} elseif ($days >= 0) {
				$notif = "5";
			}
		}

		$banyakharicuti = count($tglambilcuti);

		if ($sisacuti['0']['sisa_cuti'] == '0') {
			//do nothing//
		} else {
			if ($banyakharicuti > $sisacuti['0']['sisa_cuti']) {
				$notif = "6";
			}
		}

		$data = array(
			'1' 	=> "Sisa Cuti = 0",
			'2' 	=> "Pekerja Belum Memiliki Cuti",
			'3' 	=> "Pengajuan Cuti Tahunan min. H-6 pengambilan cuti",
			'4' 	=> "Bukan Merupakan Cuti Mendadak",
			'5' 	=> "Bukan Merupakan Cuti Susulan",
			'6' 	=> "Jumlah Pengambilan Cuti Melebihi Sisa Cuti",
			'7' 	=> "Bukan kejadian yang Terencana",
			'8' 	=> "Harus mengirimkan Dokumen(Bukti) ke seksi Hubker",
			'9' 	=> "Jumlah Cuti Melebihi Ketentuan",
			'10' 	=> "Bukan termasuk acara mendadak (Acara yang terencana)",
			'11' 	=> "Harap mengirimkan surat HPL dari Dokter / Rumah sakit",
			'12' 	=> "Membuat surat pernyatan siap menanggung resiko",
			'13' 	=> "Cuti tidak bisa diinput",
			'14' 	=> "Anda Masuk Kerja pada Tanggal yang diambil"
		);
		if (!empty($notif)) {
			$notif = $data[$notif];
		} else {
			$notif = "-";
		}
		echo json_encode($notif);
	}
}
