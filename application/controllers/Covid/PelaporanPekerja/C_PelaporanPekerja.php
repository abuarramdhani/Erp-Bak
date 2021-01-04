<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

class C_PelaporanPekerja extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('General');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('Covid/MonitoringCovid/M_monitoringcovid');
		date_default_timezone_set('Asia/Jakarta');

		$user = $this->session->user;
		if (empty($user) || $user == '') {
			$this->session->set_userdata('user', NULL);
		}
	}

	public function index()
	{
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Index',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function diri_sendiri(){
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_DiriSendiri',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function anggota_keluarga(){
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_AnggotaKeluarga',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function kedatangan_tamu()
	{
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_KedatanganTamu',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function melaksanakan_acara()
	{
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Melaksanakan',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function menghadiri_acara()
	{
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Menghadiri',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function interaksi()
	{
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Interaksi',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function satu_rumah()
	{
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Satu_Rumah',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function beda_rumah()
	{
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Beda_Rumah',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function dalam_perusahaan()
	{
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Dalam_Perusahaan',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function Monitoring()
	{
		$periode = $this->input->get('periode');
		if (strlen($periode) < 23 && !empty($periode)) {
			die('Periode Invalid (๑◕︵◕๑)');
		}
		if (!empty($periode)) {
			$exp = explode(' - ', $periode);
			$min = $exp[0];
			$max = $exp[1];
		}

		if (empty($periode)) {
			$min = date('Y-m-01', strtotime('-1 month'));
			$max = date('Y-m-t', strtotime('+1 month'));
		}
		$start = strtotime($min);
		$end = strtotime($max);
		$min = date('Y-m-01', strtotime($min));
		$max = date('Y-m-t', strtotime($max));
		$data['list'] = $this->M_monitoringcovid->monitoringlist2($min, $max);
		$data['periode'] = $min.' - '.$max;
		$month = $start;
		$lmonth = array();
		$x = 0;
		while($month < $end)
		{
			$lmonth[$x]['bulan'] = date('Y-m-d', $month);
			$lmonth[$x]['jumlah'] = date('t', $month);
			$month = strtotime("+1 month", $month);
			$x++;
		}
		$libur = $this->M_monitoringcovid->getLiburKhs($min, $max);
		$data['libur'] = array_column($libur, 'tanggal');
		// echo "<pre>";
		// print_r($data);exit();
		$data['wfhPst'] = $this->M_monitoringcovid->getTotalIsolasiWFH('01');
		$data['wfhTks'] = $this->M_monitoringcovid->getTotalIsolasiWFH('02');
		$data['wfoPst'] = $this->M_monitoringcovid->getTotalIsolasiWFO('01');
		$data['wfoTks'] = $this->M_monitoringcovid->getTotalIsolasiWFO('02');
		$data['akanSelesai'] = $this->M_monitoringcovid->pekerjaAkanSelesaiIS();
		$data['bulan'] = $lmonth;
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Monitoring',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function getInfoIsolasi()
	{
		// print_r($_GET);
		$arr = array();
		$id = $this->input->get('id');
		$detail = $this->M_monitoringcovid->getPekerjaById($id);
		$interaksi = $this->M_monitoringcovid->getMulaiInteraksi($id);
		$test = $this->M_monitoringcovid->getHasilTest($id);
		$mulai = $detail->mulai_isolasi;
		$selesai = $detail->selesai_isolasi;
		$noind = $detail->noind;
		$presensi = $this->M_monitoringcovid->getDataPres($noind, $mulai, $selesai);
		// print_r($presensi);exit();
		$tglPres = array_column($presensi, 'tanggal');
		$kdPres = array_column($presensi, 'kd_ket');
		$alPres = array_column($presensi, 'alasan');

		if (!empty($interaksi)) {
			$range = $interaksi['range_tgl_interaksi'];
			$tglinteraksi = $interaksi['tgl_interaksi'];
			if (strpos($interaksi['kasus'], 'Konfirmasi Covid 19')) {
				$jnsint = '#ff0000';
			}else{
				$jnsint = '#4b1f6f';
			}

			if (empty($range)) {
				$tgl_interaksi = $tglinteraksi;
			}else{
				$exrange = explode(' - ', $range);
				$tgl_interaksi = date('Y-m-d', strtotime($exrange[0]));
			}
			// if($mulai > $tglinteraksi){
			// 	$mulai = $tglinteraksi;
			// }

			$arr['r'.$tgl_interaksi][] = $jnsint;
		}
		$st = ['','Negatif', 'Non Reaktif', 'Reaktif', 'Positif'];
		if (!empty($test)) {
			foreach ($test as $t) {
				if (!empty($t['tgl_keluar_tes'])) {
					$tgltes = $t['tgl_keluar_tes'];
				}else{
					$tgltes = $t['tgl_tes'];
				}

				$jnstes = $t['jenis_tes'];
				$hsltes = $t['hasil_tes'];
				if (strpos($jnstes, 'PCR') !== false) {
					if ($hsltes == '1') {
						$arr['r'.$tgltes][] = '#0084d1';
					}elseif ($hsltes == '4') {
						$arr['r'.$tgltes][] = '#000000';
					}else{
						$arr['r'.$tgltes][] = '#cccccc';
					}
				}
				if (strpos($jnstes, 'Serology') !== false) {
					if ($hsltes == '2') {
						$arr['r'.$tgltes][] = '#ff00ff';
					}elseif ($hsltes == '3') {
						$arr['r'.$tgltes][] = '#7e0021';
					}else{
						$arr['r'.$tgltes][] = '#aecf00';
					}
				}
				if (strpos($jnstes, 'Antigen') !== false) {
					if ($hsltes == '2') {
						$arr['r'.$tgltes][] = '#ff8080';
					}elseif ($hsltes == '3') {
						$arr['r'.$tgltes][] = '#ff950e';
					}else{
						$arr['r'.$tgltes][] = '#83caff';
					}
				}
			}
		}
		
		function trimz($arr)
		{
			return substr($arr, 0,10);
		}
		$tglPres = array_map('trimz', $tglPres);

		$begin = new DateTime($mulai);
		$end = new DateTime($selesai.'+1 day');

		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);

		$x = 1;
		$lastwarna = '#ffff00';
		foreach ($period as $dt) {
			$d = 'r'.$dt->format("Y-m-d");
			$e = $dt->format("Y-m-d");
			// banyak if heheheh, berkonsentrasilah kawan (づ｡ ◕‿‿◕｡) づ

			$index = array_search($e, $tglPres);
			if ($index === false) {
				$arr[$d][] = $lastwarna;
				continue;
			}

			$found = false;
			
			if (strpos($kdPres[$index], 'PRM') !== false) {
				if (strpos($alPres[$index], 'WFH') !== false) {
					$arr[$d][] = '#ffff00';
					$lastwarna = '#ffff00';
				}else{
					$arr[$d][] = '#996633';
					$lastwarna = '#996633';
				}
				$found = true;
			}elseif (strpos($kdPres[$index], 'PKJ') !== false) {
				$arr[$d][] = '#00ff00';
				$lastwarna = '#00ff00';
				$found = true;
			}elseif (strpos($kdPres[$index], 'PSK') !== false){
				$arr[$d][] = '#ffff00';
				$lastwarna = '#ffff00';
				$found = true;
			}
			
			if(!$found){
				$arr[$d][] = '#FBE7C6';
				// $lastwarna = '#00ff00';
			}
			$x++;
		}
		ksort($arr,2);
		// print_r($arr);exit();

		$arrWarna = ['#ff0000', '#4b1f6f','#00ff00','#ffff00','#996633','#0084d1','#000000','#cccccc','#ff00ff','#7e0021','#aecf00','#ff8080','#ff950e','#83caff', '#FBE7C6'];
		$arrNwarna = [
		'Kontak dengan Positif',
		'Kontak dengan Probable Positif',
		'Ngantor',
		'Isolasi di Rumah',
		'Isolasi di kantor',
		'PCR (Negatif)',
		'PCR (Positif)',
		'PCR (Belum ada Hasil)',
		'Tes Antibody (Non Reaktif)',
		'Tes Antibody (Reaktif)',
		'Tes Antibody (Belum ada Hasil)',
		'Tes Antigen (Non Reaktif)',
		'Tes Antigen (Reaktif)',
		'Tes Antigen (Belum ada Hasil)',
		'???'
		];

		$arrClass = [
		'cvd_warna1',
		'cvd_warna2',
		'cvd_warna3',
		'cvd_warna4',
		'cvd_warna5',
		'cvd_warna6',
		'cvd_warna7',
		'cvd_warna8',
		'cvd_warna9',
		'cvd_warna10',
		'cvd_warna11',
		'cvd_warna12',
		'cvd_warna13',
		'cvd_warna14',
		'cvd_warna15',
		];
		$num = 0;
		foreach ($arr as $key => $value) {
			$jum = 80/count($arr[$key]);
			$div = '';
			foreach ($arr[$key] as $k) {
				$ind = array_search($k, $arrWarna);
				if ($ind === false) {
					$ind = 14;
				}
				$warna = $arrWarna[$ind];
				$desc = $arrNwarna[$ind];
				if (strpos($desc, 'Isolasi') !== false) {
					$num++;
					$tex = $num;
				}else{
					$tex = '';
				}
				$div .= '<div data-toggle="popover"
    data-placement="left" class="'.$arrClass[$ind].'" style=" margin: 0 auto; text-align:center; vertical-align: middle; line-height: '.$jum.'px; width:31px; height:'.$jum.'px; background-color:'.$k.'">
    	'.$tex.'
    </div>';
			}
			$arr[$key] = $div;
		}
		$data['data'] = $arr;
		echo json_encode($data);
	}
}