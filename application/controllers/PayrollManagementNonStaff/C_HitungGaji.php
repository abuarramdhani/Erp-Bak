<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_HitungGaji extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->library('csvimport');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PayrollManagementNonStaff/M_hitunggaji');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Hitung Gaji';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Hitung Gaji';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/HitungGaji/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function getMasterGaji($noind, $kodesie){
		$getMasterGaji = $this->M_hitunggaji->getMasterGaji($noind, $kodesie);
		return $getMasterGaji;
	}

	//alternatif
	//Hitung IMS, IMM, UBT, UPAMK, Uang Lembur, Potongan HTM
	//Parameter dapat dari getMasterGaji()

	//Hitung Tambahan Kurang Bayar, Tambahan Lain-Lain
	//Left Join pr_tambahan

	//Hitung Uang DL
	//Tanpa Parameter
	public function getKomponenAbsensi($noind, $kodesie, $bln_gaji, $thn_gaji, $gajiPokok, $insentifMasukSore, $insentifMasukMalam, $UBT, $UPAMK){
		$getKomponenAbsensi = $this->M_hitunggaji->getKomponenAbsensi($noind, $kodesie, $bln_gaji, $thn_gaji, $gajiPokok, $insentifMasukSore, $insentifMasukMalam, $UBT, $UPAMK);

		return $getKomponenAbsensi;

	}

	//Hitung IP, Kelebihan IP
	//$insentifPrestasi dapat dari getMasterGaji()
	public function getLKHSeksi($noind, $insentifPrestasi, $bln_gaji, $thn_gaji){
		$firstdate = date('Y-m-01', strtotime($thn_gaji.'-'.$bln_gaji.'-01'));
		$lastdate = date('Y-m-t', strtotime($thn_gaji.'-'.$bln_gaji.'-01'));
		$getLKHSeksi = $this->M_hitunggaji->getLKHSeksi($noind, $firstdate, $lastdate);

		$begin = new DateTime($firstdate);
		$end = new DateTime($lastdate);

		$interval = new DateInterval('P1D');

		$p = new DatePeriod($begin, $interval ,$end);
		$harike = 0;
		$ip = 0;
		$kelebihan = 0;
		foreach ($p as $d) {
			$pencapaian = 0;
			$tanggal = 0;
			$day = $d->format('Y-m-d');
			foreach ($getLKHSeksi as $dataLKHSeksi) {
				if ($dataLKHSeksi['tgl'] == $day) {
					$pencapaian = $pencapaian + $dataLKHSeksi['pencapaian'];
					$tanggal = $dataLKHSeksi['tgl'];
				}
			}
			if ($tanggal != 0) {
				if ($pencapaian >= 110) {
					$ip = $ip + 1;
					$kelebihan = $kelebihan + 10;
				}
				elseif ($pencapaian >= 100 && $pencapaian < 110) {
					$ip = $ip + 1;
					$kelebihan = $kelebihan + (100 - $pencapaian);
				}
				else{
					$ip = $ip + 0;
					$kelebihan = $kelebihan + 0;
				}
			}
		}

		$resultLKHSeksi[] = array(
			'totalInsentifPrestasi' => $ip * $insentifPrestasi,
			'totalInsentifKelebihan' => ($kelebihan/100) * $insentifPrestasi
		);

		return $resultLKHSeksi;
	}

	// public function getInsentifMasukSore($noind, $insentifMasukSore){}
	// public function getInsentifMasukMalam($noind, $insentifMasukMalam){
	// public function getUBT($noind, $UBT){}
	// public function getUPAMK($noind, $UPAMK){}

	//Hitung IK
	public function getInsentifKondite($noind, $kodesie, $bln_gaji, $thn_gaji){

		$firstdate = date('Y-m-01', strtotime($thn_gaji.'-'.$bln_gaji.'-01'));
		$lastdate = date('Y-m-t', strtotime($thn_gaji.'-'.$bln_gaji.'-01'));
		$getInsentifKondite = $this->M_hitunggaji->getInsentifKondite($noind, $kodesie, $firstdate, $lastdate);

		$hasil_akhir = '';
		foreach ($getInsentifKondite as $dataInsentifKondite) {
			$MK = $dataInsentifKondite['MK'];
			$BKI = $dataInsentifKondite['BKI'];
			$BKP = $dataInsentifKondite['BKP'];
			$TKP = $dataInsentifKondite['TKP'];
			$KB = $dataInsentifKondite['KB'];
			$KK = $dataInsentifKondite['KK'];
			$KS = $dataInsentifKondite['KS'];

			if ($MK == 'A') {$MK_p = 8; }elseif ($MK == 'B') {$MK_p = 4; }else{$MK_p = 0; }

			if ($BKI == 'A') {$BKI_p = 10; }elseif ($BKI == 'B') {$BKI_p = 5; }elseif ($BKI == 'C') {$BKI_p = 2; }else{$BKI_p = 0; }

			if ($BKP == 'A') {$BKP_p = 8; }elseif ($BKP == 'B') {$BKP_p = 4; }else{$BKP_p = 0; }

			if ($TKP == 'A') {$TKP_p = 8; }elseif ($TKP == 'B') {$TKP_p = 4; }else{$TKP_p = 0; }

			if ($KB == 'A') {$KB_p = 7; }elseif ($TKP == 'B') {$KB_p = 3; }else{$KB_p = 0; }

			if ($KK == 'A') {$KK_p = 5; }elseif ($KK == 'B') {$KK_p = 3; }elseif ($KK == 'C') {$KK_p = 1;}else{$KK_p = 0; }

			if ($KS == 'A') {$KS_p = 4; }elseif ($TKP == 'B') {$KS_p = 2; }else{$KS_p = 0; }

			$nilai = $MK_p + $BKI_p + $BKP_p + $TKP_p + $KB_p + $KK_p + $KS_p + 50;

			if ($nilai >= 91 && $nilai <= 100) {
				$gol = 'A';
			}
			elseif ($nilai >= 71 && $nilai <= 90) {
				$gol = 'B';
			}
			elseif ($nilai >= 30 && $nilai <= 70) {
				$gol = 'C';
			}
			elseif ($nilai >= 10 && $nilai <= 29) {
				$gol = 'D';
			}
			else{
				$gol = 'E';
			}

			if ($gol == 'A') {
				$hasil_temp = 1150;
			}
			elseif ($gol == 'B') {
				$hasil_temp = 739;
			}
			elseif ($gol == 'C') {
				$hasil_temp = 493;
			}
			elseif ($gol == 'D') {
				$hasil_temp = 325;
			}
			else{
				$hasil_temp = 0;
			}

			$hasil_akhir = $hasil_akhir + $hasil_temp;
		}

		return $hasil_akhir;

	}

	//Hitung Potongan
	//
	public function getPotongan($noind, $bln_gaji, $thn_gaji){
		$getPotongan = $this->M_hitunggaji->getPotongan($noind, $bln_gaji, $thn_gaji);

		return $getPotongan;
	}

	public function doHitungGaji(){
		$processResultArray = array();

		$kodesie = $this->input->post('cmbKodesie');
		// $kodesie = '304020';
		$bln_gaji = $this->input->post('cmbBulan');
		$thn_gaji = $this->input->post('txtTahun');

		$getAllEmployee = $this->M_hitunggaji->getAllEmployee($kodesie);

		foreach ($getAllEmployee as $dataAllEmployee) {
			$noind = $dataAllEmployee['employee_code'];
			$nama = $dataAllEmployee['employee_name'];

			// $noind = 'A1390';
			// $nama = 'NGADINO';

			$getMasterGaji = $this->getMasterGaji($noind, $kodesie);


			foreach ($getMasterGaji as $dataMasterGaji) {
				$gajiPokok = $dataMasterGaji['gaji_pokok'];
				$insentifPrestasi = $dataMasterGaji['insentif_prestasi'];
				$insentifMasukSore = $dataMasterGaji['insentif_masuk_sore'];
				$insentifMasukMalam = $dataMasterGaji['insentif_masuk_malam'];
				$UBT = $dataMasterGaji['ubt'];
				$UPAMK = $dataMasterGaji['upamk'];

				$JHT = (2/100) * $gajiPokok;
				$JKN = (1/100) * $gajiPokok;
				$JP = (1/100) * $gajiPokok;


				$getKomponenAbsensi = $this->getKomponenAbsensi($noind, $kodesie, $bln_gaji, $thn_gaji, $gajiPokok, $insentifMasukSore, $insentifMasukMalam, $UBT, $UPAMK);

				foreach ($getKomponenAbsensi as $dataKomponenAbsensi) {
					$insentifMasukSore = $dataKomponenAbsensi['insentifMasukSore'];
					$insentifMasukMalam = $dataKomponenAbsensi['insentifMasukMalam'];
					$UBT = $dataKomponenAbsensi['UBT'];
					$UPAMK = $dataKomponenAbsensi['UPAMK'];
					$uangLembur = $dataKomponenAbsensi['uang_lembur'];
					$potonganHTM = $dataKomponenAbsensi['potHTM'];
					$DL = $dataKomponenAbsensi['DL'];
					$tambahanKurangBayar = $dataKomponenAbsensi['tambahan_kurang_bayar'];
					$tambahanLain = $dataKomponenAbsensi['tambahan_lain'];
				}
				if (empty($insentifMasukSore)) {
					$insentifMasukSore = 0;
				}
				if (empty($insentifMasukMalam)) {
					$insentifMasukMalam = 0;
				}
				if (empty($UBT)) {
					$UBT = 0;
				}
				if (empty($UPAMK)) {
					$UPAMK = 0;
				}
				if (empty($uangLembur)) {
					$uangLembur = 0;
				}
				if (empty($potonganHTM)) {
					$potonganHTM = 0;
				}
				if (empty($DL)) {
					$DL = 0;
				}
				if (empty($tambahanKurangBayar)) {
					$tambahanKurangBayar = 0;
				}
				if (empty($tambahanLain)) {
					$tambahanLain = 0;
				}

				$getPotongan = $this->getPotongan($noind, $bln_gaji, $thn_gaji);

				foreach ($getPotongan as $dataPotongan) {
					$potonganLebihBayar = $dataPotongan['pot_lebih_bayar'];
					$potonganGP = $dataPotongan['pot_gp'];
					$potonganDL = $dataPotongan['pot_dl'];
					$potonganKoperasi = $dataPotongan['pot_koperasi'];
					$potonganHutangLain = $dataPotongan['pot_hutang_lain'];
					$potonganDPLK = $dataPotongan['pot_dplk'];

				}

				if (empty($potonganLebihBayar)) {
					$potonganLebihBayar = 0;
				}
				if (empty($potonganGP)) {
					$potonganGP = 0;
				}
				if (empty($potonganDL)) {
					$potonganDL = 0;
				}
				if (empty($potonganKoperasi)) {
					$potonganKoperasi = 0;
				}
				if (empty($potonganHutangLain)) {
					$potonganHutangLain = 0;
				}
				if (empty($potonganDPLK)) {
					$potonganDPLK = 0;
				}

				$getLKHSeksi = $this->getLKHSeksi($noind, $insentifPrestasi, $bln_gaji, $thn_gaji);

				foreach ($getLKHSeksi as $dataLKHSeksi) {
					$totalInsentifKelebihan = $dataLKHSeksi['totalInsentifPrestasi'];
					$totalInsentifKelebihan = $dataLKHSeksi['totalInsentifKelebihan'];
				}
				if (empty($totalInsentifKelebihan)) {
					$totalInsentifKelebihan = 0;
				}
				if (empty($totalInsentifKelebihan)) {
					$totalInsentifKelebihan = 0;
				}

				$getInsentifKondite = $this->getInsentifKondite($noind, $kodesie, $bln_gaji, $thn_gaji);
				if (empty($getInsentifKondite)) {
					$getInsentifKondite = 0;
				}

				$processResultArray[] = array(
					'noind' => $noind,
					'nama' => $nama,
					'gajiPokok' => $gajiPokok,
					'JHT' => $JHT,
					'JKN' => $JKN,
					'JP' => $JP,
					'insentifMasukSore' => $insentifMasukSore,
					'insentifMasukMalam' => $insentifMasukMalam,
					'UBT' => $UBT,
					'UPAMK' => $UPAMK,
					'uangLembur' => $uangLembur,
					'potonganHTM' => $potonganHTM,
					'DL' => $DL,
					'tambahanKurangBayar' => $tambahanKurangBayar,
					'tambahanLain' => $tambahanLain,
					'potonganLebihBayar' => $potonganLebihBayar,
					'potonganGP' => $potonganGP,
					'potonganDL' => $potonganDL,
					'potonganKoperasi' => $potonganKoperasi,
					'potonganHutangLain' => $potonganHutangLain,
					'potonganDPLK' => $potonganDPLK,
					'insentifPrestasi' => $totalInsentifKelebihan,
					'insentifKelebihan' => $totalInsentifKelebihan,
					'insetifKondite' => $getInsentifKondite,
				);
			}
		}

		$data['hasilHitungGaji'] = $processResultArray;

		// print_r($processResultArray);
		$this->load->view('PayrollManagementNonStaff/HitungGaji/V_hasil_hitung', $data);
	}

}

/* End of file C_Kondite.php */
/* Location: ./application/controllers/PayrollManagementNonStaff/C_Kondite.php */
/* Generated automatically on 2017-03-20 13:35:14 */