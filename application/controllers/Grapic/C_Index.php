<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ini_set('memory_limit', '-1');

class C_Index extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('Grapic/M_index');
		$this->checkSession();
	}

	public function checkSession() {
		if(!$this->session->is_logged) { redirect(''); }
	}

	public function index() {
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'Grapic';

		$bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus');
		$jumlah = array('6','4','4','4','4','4','6','4');
		$data['akhir'] = array_combine($bulan, $jumlah);
		$begin = new DateTime('2019-01-01');
		$end = new DateTime('2019-08-28');
		$data['tgl'] = new DatePeriod($begin, new DateInterval('P14D'), $end);
		$begin = new DateTime('2019-01-01');
		$date = date('Y-m-d');
		$end = new DateTime($date);
		$daterange = new DatePeriod($begin, new DateInterval('P14D'), $end);
		$a = 3631;
		for ($i=0; $i < 18; $i++) { 
			$target[] = $a;
			$a = $a - 47; 
		}
		$data['target'] = $target;
		foreach($daterange as $date) {
			$now =  $date->format("m-d");
			$banyak = $this->M_index->banyak($now);
			$hasil[] = $banyak[0]['count'];
		}
		$data['karyawan'] = $hasil;
		$data['banyak'] = count($hasil);
		for ($i=0; $i < count($hasil)-1; $i++) { 
			$min[] = $hasil[$i+1] - $hasil[$i];
		}
		for ($i=0; $i < count($hasil)-1; $i++) { 
			$rate[] = $min[$i] / $hasil[0] * 100;
		}
		for ($i=0; $i < count($hasil)-1; $i++) { 
			$rateup[] = round($rate[$i],1);
		}
		$data['min'] = $min;
		$data['rateup'] =  $rateup;

		// trgt Turun Akumulasi
		for ($i=0; $i < 18-1; $i++) { 
			$min2[] = $target[$i+1] - $target[0];
		}
		for ($i=0; $i < 18-1; $i++) { 
			$rate2[] = $min2[$i] / $target[0] * 100;
		}
		for ($i=0; $i < 18-1; $i++) { 
			$rateup2[] = round($rate2[$i],1);
		}
		$data['min2'] = $min2;
		$data['rateup2'] =  $rateup2;

		// Jml Turun Akumulasi
		for ($i=0; $i < count($hasil)-1; $i++) { 
			$min3[] = $hasil[$i+1] - $hasil[0];
		}
		for ($i=0; $i < count($hasil)-1; $i++) { 
			$rate3[] = $min3[$i] / $hasil[0] * 100;
		}
		for ($i=0; $i < count($hasil)-1; $i++) { 
			$rateup3[] = round($rate3[$i],1);
		}

		$data['min3'] = $min3;
		$data['rateup3'] =  $rateup3;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Grapic/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function openPDF() {
		$bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus');
		$jumlah = array('6','4','4','4','4','4','6','4');
		$data['akhir'] = array_combine($bulan, $jumlah);
		// print_r($data['akhir']);exit();
		$begin = new DateTime('2019-01-01');
		$end = new DateTime('2019-08-28');

		$data['tgl'] = new DatePeriod($begin, new DateInterval('P14D'), $end);

		$begin = new DateTime('2019-01-01');
		$date = date('Y-m-d');
		$end = new DateTime($date);

		$daterange = new DatePeriod($begin, new DateInterval('P14D'), $end);

		$a = 3631;
		for ($i=0; $i < 18; $i++) { 
			$target[] = $a;
			$a = $a - 47; 
		}
		$data['target'] = $target;

		foreach($daterange as $date) {
			$now =  $date->format("m-d");
			$banyak = $this->M_index->banyak($now);
			$hasil[] = $banyak[0]['count'];
		}
		// print_r($hasil);
		// exit();
		$data['karyawan'] = $hasil;
		$data['banyak'] = count($hasil);

		for ($i=0; $i < count($hasil)-1; $i++) { 
			$min[] = $hasil[$i+1] - $hasil[$i];
		}
		for ($i=0; $i < count($hasil)-1; $i++) { 
			$rate[] = $min[$i] / $hasil[0] * 100;
		}
		for ($i=0; $i < count($hasil)-1; $i++) { 
			$rateup[] = round($rate[$i],1);
		}
		$data['min'] = $min;
		$data['rateup'] =  $rateup;


		for ($i=0; $i < 18-1; $i++) { 
			$min2[] = $target[$i+1] - $target[0];
		}
		for ($i=0; $i < 18-1; $i++) { 
			$rate2[] = $min2[$i] / $target[0] * 100;
		}
		for ($i=0; $i < 18-1; $i++) { 
			$rateup2[] = round($rate2[$i],1);
		}
		$data['min2'] = $min2;
		$data['rateup2'] =  $rateup2;

		// Jml Turun Akumulasi
		for ($i=0; $i < count($hasil)-1; $i++) { 
			$min3[] = $hasil[$i+1] - $hasil[0];
		}
		for ($i=0; $i < count($hasil)-1; $i++) { 
			$rate3[] = $min3[$i] / $hasil[0] * 100;
		}
		for ($i=0; $i < count($hasil)-1; $i++) { 
			$rateup3[] = round($rate3[$i],1);
		}
		$data['min3'] = $min3;
		$data['rateup3'] =  $rateup3;

		$data['img'] = $this->input->post('myChart');
		$data['img2'] = $this->input->post('myChartBar');
		$data['img3'] = $this->input->post('myChartBar2');
		// echo "<pre>";print_r($_POST);exit();
		
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4-l', 8, '', 5, 5, 30, 15, 10, 20);
		$filename = 'Grapic Efisiensi SDM.pdf';

		// $this->load->view('ADMCabang/Presensi/V_presensi1_pdf', $data);
		// exit();
		$html = $this->load->view('Grapic/V_Export_pdf', $data, true);
		// $pdf->setHTMLHeader('<center></center>
		// 	');
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

	public function Graph() {
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'Grapic';

		$proses = $this->input->post('bt_ps');
		if ($proses == 'true') {
			$ict = $this->input->post('grICT');
			$ictSql = '';
			$ictStat = '';
			if ($ict) {
				$ictSql = "";
				$ictStat = 'dengan ICT';
			} else{
				$ictSql = "and a.kodesie NOT LIKE '101030%'";
				$ictStat = 'Tanpa ICT';
			}
			$data['proses'] = 'true';
			$data['ICT'] = $ictStat;

			$dept = $this->input->post('grDept');
			if ($dept) {
				$data['dept'] = 'true';
				if ($dept == 'SEMUA DEPARTEMEN') {
					$dept = 'KEUANGAN, PEMASARAN, PERSONALIA, PRODUKSI';
					$depart = explode(', ', $dept);
				} else{
					$depart[] = $dept;
				}
				$data['jumlahDept'] = count($depart);
				for ($x=0; $x < count($depart); $x++) { 
					$kodeDept = $depart;

					$bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus');
					$jumlah = array('6','4','4','4','4','4','6','4');
					$data['akhir'] = array_combine($bulan, $jumlah);
					// print_r($data['akhir']);exit();
					$begin = new DateTime('2019-01-01');
					$end = new DateTime('2019-08-28');

					$data['tgl'] = new DatePeriod($begin, new DateInterval('P14D'), $end);

					$begin = new DateTime('2019-01-01');
					$date = date('Y-m-d');
					$end = new DateTime($date);

					$daterange = new DatePeriod($begin, new DateInterval('P14D'), $end);

					$a = 3631;
					for ($i=0; $i < 18; $i++) { 
						$target[] = $a;
						$a = $a - 47; 
					}
					$data['target'] = $target;

					foreach($daterange as $date) {
						$now =  $date->format("m-d");
						$banyak = $this->M_index->banyakPekDept($now, $ictSql, $kodeDept);
						$hasil[] = $banyak[0]['count'];
					}
					$data['karyawan'] = $hasil;
					$data['banyak'] = count($hasil);

					for ($i=0; $i < count($hasil)-1; $i++) { 
						$min[] = $hasil[$i+1] - $hasil[$i];
					}
					for ($i=0; $i < count($hasil)-1; $i++) { 
						$rate[] = $min[$i] / $hasil[0] * 100;
					}
					for ($i=0; $i < count($hasil)-1; $i++) { 
						$rateup[] = round($rate[$i],1);
					}
					$data['min'.$x] = $min;
					$data['rateup'.$x] =  $rateup;

					//Trgt Turun Akumulasi
					for ($i=0; $i < 18-1; $i++) { 
						$min2[] = $target[$i+1] - $target[0];
					}
					for ($i=0; $i < 18-1; $i++) { 
						$rate2[] = $min2[$i] / $target[0] * 100;
					}
					for ($i=0; $i < 18-1; $i++) { 
						$rateup2[] = round($rate2[$i],1);
					}
					$data['min2'.$x] = $min2;
					$data['rateup2'.$x] =  $rateup2;

					// Jml Turun Akumulasi
					for ($i=0; $i < count($hasil)-1; $i++) { 
						$min3[] = $hasil[$i+1] - $hasil[0];
					}
					for ($i=0; $i < count($hasil)-1; $i++) { 
						$rate3[] = $min3[$i] / $hasil[0] * 100;
					}
					for ($i=0; $i < count($hasil)-1; $i++) { 
						$rateup3[] = round($rate3[$i],1);
					}
					$data['min3'.$x] = $min3;
					$data['rateup3'.$x] =  $rateup3;
					// echo "<pre>";
					// print_r($data);
				}
					// exit();
			}
			//print_r($depart);
			// exit();
			
			// $bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus');
			// $jumlah = array('6','4','4','4','4','4','6','4');
			// $data['akhir'] = array_combine($bulan, $jumlah);
			// // print_r($data['akhir']);exit();
			// $begin = new DateTime('2019-01-01');
			// $end = new DateTime('2019-08-28');

			// $data['tgl'] = new DatePeriod($begin, new DateInterval('P14D'), $end);

			// $begin = new DateTime('2019-01-01');
			// $date = date('Y-m-d');
			// $end = new DateTime($date);

			// $daterange = new DatePeriod($begin, new DateInterval('P14D'), $end);

			// $a = 3631;
			// for ($i=0; $i < 18; $i++) { 
			// 	$target[] = $a;
			// 	$a = $a - 47; 
			// }
			// $data['target'] = $target;

			// foreach($daterange as $date) {
			// 	$now =  $date->format("m-d");
			// 	$banyak = $this->M_index->banyakPekerja($now, $ictSql);
			// 	$hasil[] = $banyak[0]['count'];
			// }
			// // print_r($hasil);
			// // exit();
			// $data['karyawan'] = $hasil;
			// $data['banyak'] = count($hasil);

			// for ($i=0; $i < count($hasil)-1; $i++) { 
			// 	$min[] = $hasil[$i+1] - $hasil[$i];
			// }
			// for ($i=0; $i < count($hasil)-1; $i++) { 
			// 	$rate[] = $min[$i] / $hasil[0] * 100;
			// }
			// for ($i=0; $i < count($hasil)-1; $i++) { 
			// 	$rateup[] = round($rate[$i],1);
			// }
			// $data['min'] = $min;
			// $data['rateup'] =  $rateup;

			// //Trgt Turun Akumulasi
			// for ($i=0; $i < 18-1; $i++) { 
			// 	$min2[] = $target[$i+1] - $target[0];
			// }
			// for ($i=0; $i < 18-1; $i++) { 
			// 	$rate2[] = $min2[$i] / $target[0] * 100;
			// }
			// for ($i=0; $i < 18-1; $i++) { 
			// 	$rateup2[] = round($rate2[$i],1);
			// }
			// $data['min2'] = $min2;
			// $data['rateup2'] =  $rateup2;

			// // Jml Turun Akumulasi
			// for ($i=0; $i < count($hasil)-1; $i++) { 
			// 	$min3[] = $hasil[$i+1] - $hasil[0];
			// }
			// for ($i=0; $i < count($hasil)-1; $i++) { 
			// 	$rate3[] = $min3[$i] / $hasil[0] * 100;
			// }
			// for ($i=0; $i < count($hasil)-1; $i++) { 
			// 	$rateup3[] = round($rate3[$i],1);
			// }
			// $data['min3'] = $min3;
			// $data['rateup3'] =  $rateup3;

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('Grapic/V_Graph',$data);
			$this->load->view('V_Footer',$data);
		} else {
			$data['proses'] = 'false';
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('Grapic/V_Graph',$data);
			$this->load->view('V_Footer',$data);
		}
	}

	public function data()
	{
		$term = strtoupper($this->input->post('term'));
		$dept = $this->input->post('dept');
		$data = $this->M_index->data($term, $dept);
		// echo $term;
		echo json_encode($data);
	}

	public function grapicBaru()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'Grapic';

		$submit = $this->input->post('btSubmit');
		$pkl = $this->input->post('pkl');
		$sqlPKL = '';
		if ($pkl) {
			$sqlPKL = "and left(noind,1) not in('L','Z','M')";
			$data['pkl'] = 'Dengan PKL, Magang & TKPW';
			$data['truePKL'] = 'true';
		} else{
			$sqlPKL = "and left(noind,1) not in('F','G','L','N','Q','L','Z','M')";
			$data['pkl'] = '';
			$data['truePKL'] = 'true';
		}
		$val = $this->input->post('txtData');
		$data['val'] = $val;
		// echo $val;exit();
		$data['submit'] = 'false';
		if ($submit == 'true') {
			$data['submit'] = $submit;
			$nama =  'SEMUA, Dept. Produksi, Dept. Personalia, Dept. Keuangan, Dept. Pemasaran, Dept. Produksi - Pusat, Dept. Produksi - Tuksono, Dept. Pemasaran - Pusat, Dept. Pemasaran - Cabang / Showroom / POS, Akuntansi, ICT, IA, Pengembangan Sistem, Purchasing, Semua Data';
			if ($val == '0') {
				$all = array('1','2','3','4','5','6','7','8','9','10','11','12','13');
			} else{
				$all[] = $val;
			}
			// print_r($all);exit();
			$hitungAll = count($all);
			$data['hitung'] = $hitungAll;
			$bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus');
			$jumlah = array('6','4','4','4','4','4','6','4');
			$data['akhir'] = array_combine($bulan, $jumlah);

			$begin = new DateTime('2019-01-01');
			$end = new DateTime('2019-08-28');
			$data['tgl'] = new DatePeriod($begin, new DateInterval('P14D'), $end);

			$begin = new DateTime('2019-01-01');
			$date = date('Y-m-d');
			$end = new DateTime($date);
			$daterange = new DatePeriod($begin, new DateInterval('P14D'), $end);
			for ($x=0; $x < $hitungAll; $x++) { 
				$val = $all;
				foreach($daterange as $date) {
					$now =  $date->format("m-d");
					$lokasi_kerja = '';
					if ($val >= '1' && $val <= '4' ) {
						$dept = 'PRODUKSI, PERSONALIA, KEUANGAN, PEMASARAN';
						$dept = explode(', ', $dept);
						$kodeDept = $dept[$val-1];

						$banyak = $this->M_index->pekerjaDepartemen($now, $kodeDept, $sqlPKL, $lokasi_kerja);
					} else if ($val == '5') {
						$lokasi_kerja = "and lokasi_kerja = '01'";
						$kodeDept = 'PRODUKSI';
						$banyak = $this->M_index->pekerjaDepartemen($now, $kodeDept, $sqlPKL, $lokasi_kerja);
					} else if ($val == '6') {
						$lokasi_kerja = "and lokasi_kerja = '02'";
						$kodeDept = 'PRODUKSI';
						$banyak = $this->M_index->pekerjaDepartemen($now, $kodeDept, $sqlPKL, $lokasi_kerja);
					} else if ($val == '7') {
						$lokasi_kerja = "and lokasi_kerja = '01'";
						$kodeDept = 'PEMASARAN';
						$banyak = $this->M_index->pekerjaDepartemen($now, $kodeDept, $sqlPKL, $lokasi_kerja);
					} else if ($val == '8') {
						$lokasi_kerja = "and lokasi_kerja not in('01','02','03')";
						$kodeDept = 'PEMASARAN';
						$banyak = $this->M_index->pekerjaDepartemen($now, $kodeDept, $sqlPKL, $lokasi_kerja);
					} else if ($val == '9') {
						$kodeUnit = 'AKUNTANSI';
						$banyak = $this->M_index->pekerjaUnit($now, $kodeUnit, $sqlPKL);
					} else if ($val == '10') {
						$kodeUnit = 'INFORMATION & COMMUNICATION TECHNOLOGY';
						$banyak = $this->M_index->pekerjaUnit($now, $kodeUnit, $sqlPKL);
						// print_r($banyak);exit();
					} else if ($val == '11') {
						$kodeUnit = 'INTERNAL AUDIT';
						$banyak = $this->M_index->pekerjaUnit($now, $kodeUnit, $sqlPKL);
					} else if ($val == '12') {
						$kodeUnit = 'PENGEMBANGAN SISTEM';
						$banyak = $this->M_index->pekerjaUnit($now, $kodeUnit, $sqlPKL);
					} else if ($val == '13') {
						$kodeUnit = 'PEMBELIAN';
						$banyak = $this->M_index->pekerjaUnit($now, $kodeUnit, $sqlPKL);
					} else if ($val == '14') {
						$banyak = $this->M_index->semuaData($now, $sqlPKL);
					}

					$hasil[] = $banyak[0]['count'];
				}
				$min = round((1.3 * $hasil[0] / 100),0);
				$data['min'.$x] = $min;
				$data['target'.$x] = $hasil;

				$namaex = explode(', ', $nama);
				$data['nama'.$x] = $namaex[$val];

				// print_r($nama);exit();
			}
			

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('Grapic/V_GrapicBaru',$data);
			$this->load->view('V_Footer',$data);
		} else{
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('Grapic/V_GrapicBaru',$data);
			$this->load->view('V_Footer',$data);
		}

	}

	public function export_baru()
	{
		$loop = $this->input->post('SDMloop'); //1
		$pkl = $this->input->post('SDMpkl'); //true
		$val = $this->input->post('SDMval'); //0-13
		$div = $this->input->post('SDMdiv'); //div

		// echo '<img src="'.$div.'" />';
		// $val = 13;
		// // echo $div;
		// exit();
		// $submit = $this->input->post('btSubmit');
		// $pkl = $this->input->post('pkl');
		// $sqlPKL = '';
		if ($pkl == 'true') {
			$sqlPKL = "and left(noind,1) not in('L','Z','M')";
			$data['pkl'] = 'Dengan PKL, Magang & TKPW';
		} else{
			$sqlPKL = "and left(noind,1) not in('F','G','L','N','Q','L','Z','M')";
			$data['pkl'] = '';
		}
		// $val = $this->input->post('txtData');
		// $data['val'] = $val;
		// echo $val;exit();
		// $data['submit'] = 'false';
		// if ($submit == 'true') {
			// $data['submit'] = $submit;
		$nama =  'SEMUA, Dept. Produksi, Dept. Personalia, Dept. Keuangan, Dept. Pemasaran, Dept. Produksi - Pusat, Dept. Produksi - Tuksono, Dept. Pemasaran - Pusat, Dept. Pemasaran - Cabang / Showroom / POS, Akuntansi, ICT, IA, Pengembangan Sistem, Purchasing, Semua Data';
		if ($val == '0') {
			$all = array('1','2','3','4','5','6','7','8','9','10','11','12','13');
		} else{
			$all[] = $val;
		}
			// print_r($all);exit();
		$hitungAll = count($all);
		$data['hitung'] = $hitungAll;
		$bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus');
		$jumlah = array('6','4','4','4','4','4','6','4');
		$data['akhir'] = array_combine($bulan, $jumlah);

		$begin = new DateTime('2019-01-01');
		$end = new DateTime('2019-08-28');
		$data['tgl'] = new DatePeriod($begin, new DateInterval('P14D'), $end);

		$begin = new DateTime('2019-01-01');
		$date = date('Y-m-d');
		$end = new DateTime($date);
		$daterange = new DatePeriod($begin, new DateInterval('P14D'), $end);
		for ($x=0; $x < $hitungAll; $x++) { 
			$val = $all;
			foreach($daterange as $date) {
				$now =  $date->format("m-d");
				$lokasi_kerja = '';
				if ($val >= '1' && $val <= '4' ) {
					$dept = 'PRODUKSI, PERSONALIA, KEUANGAN, PEMASARAN';
					$dept = explode(', ', $dept);
					$kodeDept = $dept[$val-1];

					$banyak = $this->M_index->pekerjaDepartemen($now, $kodeDept, $sqlPKL, $lokasi_kerja);
				} else if ($val == '5') {
					$lokasi_kerja = "and lokasi_kerja = '01'";
					$kodeDept = 'PRODUKSI';
					$banyak = $this->M_index->pekerjaDepartemen($now, $kodeDept, $sqlPKL, $lokasi_kerja);
				} else if ($val == '6') {
					$lokasi_kerja = "and lokasi_kerja = '02'";
					$kodeDept = 'PRODUKSI';
					$banyak = $this->M_index->pekerjaDepartemen($now, $kodeDept, $sqlPKL, $lokasi_kerja);
				} else if ($val == '7') {
					$lokasi_kerja = "and lokasi_kerja = '01'";
					$kodeDept = 'PEMASARAN';
					$banyak = $this->M_index->pekerjaDepartemen($now, $kodeDept, $sqlPKL, $lokasi_kerja);
				} else if ($val == '8') {
					$lokasi_kerja = "and lokasi_kerja not in('01','02','03')";
					$kodeDept = 'PEMASARAN';
					$banyak = $this->M_index->pekerjaDepartemen($now, $kodeDept, $sqlPKL, $lokasi_kerja);
				} else if ($val == '9') {
					$kodeUnit = 'AKUNTANSI';
					$banyak = $this->M_index->pekerjaUnit($now, $kodeUnit, $sqlPKL);
				} else if ($val == '10') {
					$kodeUnit = 'INFORMATION & COMMUNICATION TECHNOLOGY';
					$banyak = $this->M_index->pekerjaUnit($now, $kodeUnit, $sqlPKL);
						// print_r($banyak);exit();
				} else if ($val == '11') {
					$kodeUnit = 'INTERNAL AUDIT';
					$banyak = $this->M_index->pekerjaUnit($now, $kodeUnit, $sqlPKL);
				} else if ($val == '12') {
					$kodeUnit = 'PENGEMBANGAN SISTEM';
					$banyak = $this->M_index->pekerjaUnit($now, $kodeUnit, $sqlPKL);
				} else if ($val == '13') {
					$kodeUnit = 'PEMBELIAN';
					$banyak = $this->M_index->pekerjaUnit($now, $kodeUnit, $sqlPKL);
				} else if ($val == '14') {
					$banyak = $this->M_index->semuaData($now, $sqlPKL);
				}

				$hasil[] = $banyak[0]['count'];
			}
			$min = round((1.3 * $hasil[0] / 100),0);
			$data['min'.$x] = $min;
			$data['target'.$x] = $hasil;

			$namaex = explode(', ', $nama);
			$data['nama'.$x] = $namaex[$val];


			$data['img'] = $this->input->post('imyChart');
			$data['img2'] = $this->input->post('imyChartbar');
			$data['img3'] = $this->input->post('imyChartbar2');
			$data['div'] = $div;
		// echo "<pre>";print_r($_POST);exit();

			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8', 'A4-l', 8, '', 5, 5, 30, 15, 10, 20);
			$filename = 'Grapic Efisiensi SDM.pdf';

			$html = $this->load->view('Grapic/V_Export_Baru', $data, true);
			$pdf->WriteHTML($html, 2);
			$pdf->Output($filename, 'I');	
		}
		// }
	}

	public function exportGambar()
	{
		// print_r($_POST);exit();
		// $data['img'] = $this->input->post('imyChart');
		// $data['img2'] = $this->input->post('imyChartbar');
		// $data['img3'] = $this->input->post('imyChartbar2');
		// $data['div'] = $this->input->post('SDMdiv');
		$data['chart1'] = $this->input->post('data1');
		$data['chart2'] = $this->input->post('data2');
		$data['chart3'] = $this->input->post('data3');
		$data['tabel'] = $this->input->post('data4');
		echo count($data['tabel']);
		exit();
		// $val[] = ("13", "0", "1","2","3","4","5","6","7","8","9","10", "11", "12","14","15","16","17","18");
		$nama =  'Dept. Produksi, Dept. Personalia, Dept. Keuangan, Dept. Pemasaran, Dept. Produksi - Pusat, Dept. Produksi - Tuksono, Dept. Pemasaran - Pusat, Dept. Pemasaran - Cabang / Showroom / POS, Akuntansi, ICT, IA, Pengembangan Sistem, Purchasing, Semua Data, CABANG PERWAKILAN JAKARTA, CABANG PERWAKILAN MEDAN, CABANG PERWAKILAN TANJUNG KARANG, CABANG PERWAKILAN YOGYAKARTA, PEMASARAN 2, PEMASARAN 6';
		// $nama = explode(', ', $nama);
		// $head = $nama[$val];

		// $pkl = $this->input->post('SDMpkl');
		// if ($pkl == 'true') {
		// 	$text = 'dengan PKL';
		// } else{
		// 	$text = 'tanpa PKL';
		// }
		// echo '<img src="'.$data['div'].'" />';
		// exit();
		// sleep(3);

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4-l', 8, '', 5, 5, 30, 15, 10, 20);
		$filename = 'Grapic Efisiensi SDM.pdf';

		$pdf->setHTMLHeader('<div style="text-align: center"><h1>'.$head.' '.$text.'</h1></div>');

		$html = $this->load->view('Grapic/V_Export_Gambar', $data, true);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

	public function getData()
	{
		ini_set('memory_limit', '-1');
		$selet = $this->M_index->getData();
		$myfile = fopen("testfile.txt", "w");
		foreach ($selet as $key) {
			if (is_null($key['noind'])) {
				$noind 				= 'NULL';
			} else{
				$noind				= "'".$key['noind']."'";
			}
			if (is_null($key['nama'])) {
				$nama 				= 'NULL';
			} else{
				$nama				= "'".$key['nama']."'";
			}
			if (is_null($key['lokasi'])) {
				$lokasi 				= 'NULL';
			} else{
				$lokasi				= "'".$key['lokasi']."'";
			}
			if (is_null($key['jenkel'])) {
				$jenkel 				= 'NULL';
			} else{
				$jenkel				= "'".$key['jenkel']."'";
			}
			if (is_null($key['agama'])) {
				$agama 				= 'NULL';
			} else{
				$agama				= "'".$key['agama']."'";
			}
			if (is_null($key['templahir'])) {
				$templahir 				= 'NULL';
			} else{
				$templahir				= "'".$key['templahir']."'";
			}
			if (is_null($key['tgllahir'])) {
				$tgllahir 				= 'NULL';
			} else{
				$tgllahir				= "'".$key['tgllahir']."'";
			}
			if (is_null($key['goldarah'])) {
				$goldarah 				= 'NULL';
			} else{
				$goldarah				= "'".$key['goldarah']."'";
			}
			if (is_null($key['alamat'])) {
				$alamat 				= 'NULL';
			} else{
				$alamat				= "'".$key['alamat']."'";
			}
			if (is_null($key['desa'])) {
				$desa 				= 'NULL';
			} else{
				$desa				= "'".$key['desa']."'";
			}
			if (is_null($key['kec'])) {
				$kec 				= 'NULL';
			} else{
				$kec				= "'".$key['kec']."'";
			}
			if (is_null($key['kab'])) {
				$kab 				= 'NULL';
			} else{
				$kab				= "'".$key['kab']."'";
			}
			if (is_null($key['prop'])) {
				$prop 				= 'NULL';
			} else{
				$prop				= "'".$key['prop']."'";
			}
			if (is_null($key['kodepos'])) {
				$kodepos 				= 'NULL';
			} else{
				$kodepos				= "'".$key['kodepos']."'";
			}
			if (is_null($key['denahrumah'])) {
				$denahrumah 				= 'NULL';
			} else{
				$denahrumah				= "'".$key['denahrumah']."'";
			}
			if (is_null($key['statrumah'])) {
				$statrumah 				= 'NULL';
			} else{
				$statrumah				= "'".$key['statrumah']."'";
			}
			if (is_null($key['telepon'])) {
				$telepon 				= 'NULL';
			} else{
				$telepon				= "'".$key['telepon']."'";
			}
			if (is_null($key['nohp'])) {
				$nohp 				= 'NULL';
			} else{
				$nohp				= "'".$key['nohp']."'";
			}
			if (is_null($key['gelard'])) {
				$gelard 				= 'NULL';
			} else{
				$gelard				= "'".$key['gelard']."'";
			}
			if (is_null($key['gelarb'])) {
				$gelarb 				= 'NULL';
			} else{
				$gelarb				= "'".$key['gelarb']."'";
			}
			if (is_null($key['pendidikan'])) {
				$pendidikan 				= 'NULL';
			} else{
				$pendidikan				= "'".$key['pendidikan']."'";
			}
			if (is_null($key['jurusan'])) {
				$jurusan 				= 'NULL';
			} else{
				$jurusan				= "'".$key['jurusan']."'";
			}
			if (is_null($key['sekolah'])) {
				$sekolah 				= 'NULL';
			} else{
				$sekolah				= "'".$key['sekolah']."'";
			}
			if (is_null($key['statnikah'])) {
				$statnikah 				= 'NULL';
			} else{
				$statnikah				= "'".$key['statnikah']."'";
			}
			if (is_null($key['tglnikah'])) {
				$tglnikah 				= 'NULL';
			} else{
				$tglnikah				= "'".$key['tglnikah']."'";
			}
			if (is_null($key['jumanak'])) {
				$jumanak 				= 'NULL';
			} else{
				$jumanak				= "'".$key['jumanak']."'";
			}
			if (is_null($key['jumsdr'])) {
				$jumsdr 				= 'NULL';
			} else{
				$jumsdr				= "'".$key['jumsdr']."'";
			}
			if (is_null($key['diangkat'])) {
				$diangkat 				= 'NULL';
			} else{
				$diangkat				= "'".$key['diangkat']."'";
			}
			if (is_null($key['masukkerja'])) {
				$masukkerja 				= 'NULL';
			} else{
				$masukkerja				= "'".$key['masukkerja']."'";
			}
			if (is_null($key['kodesie'])) {
				$kodesie 				= 'NULL';
			} else{
				$kodesie				= "'".$key['kodesie']."'";
			}
			if (is_null($key['golkerja'])) {
				$golkerja 				= 'NULL';
			} else{
				$golkerja				= "'".$key['golkerja']."'";
			}
			if (is_null($key['asal_outsourcing'])) {
				$asal_outsourcing 				= 'NULL';
			} else{
				$asal_outsourcing				= "'".$key['asal_outsourcing']."'";
			}
			if (is_null($key['kd_jabatan'])) {
				$kd_jabatan 				= 'NULL';
			} else{
				$kd_jabatan				= "'".$key['kd_jabatan']."'";
			}
			if (is_null($key['jabatan'])) {
				$jabatan 				= 'NULL';
			} else{
				$jabatan				= "'".$key['jabatan']."'";
			}
			if (is_null($key['npwp'])) {
				$npwp 				= 'NULL';
			} else{
				$npwp				= "'".$key['npwp']."'";
			}
			if (is_null($key['lmkontrak'])) {
				$lmkontrak 				= 'NULL';
			} else{
				$lmkontrak				= "'".$key['lmkontrak']."'";
			}
			if (is_null($key['akhkontrak'])) {
				$akhkontrak 				= 'NULL';
			} else{
				$akhkontrak				= "'".$key['akhkontrak']."'";
			}
			if (is_null($key['statpajak'])) {
				$statpajak 				= 'NULL';
			} else{
				$statpajak				= "'".$key['statpajak']."'";
			}
			if (is_null($key['jtanak'])) {
				$jtanak 				= 'NULL';
			} else{
				$jtanak				= "'".$key['jtanak']."'";
			}
			if (is_null($key['jtbknanak'])) {
				$jtbknanak 				= 'NULL';
			} else{
				$jtbknanak				= "'".$key['jtbknanak']."'";
			}
			if (is_null($key['tglspsi'])) {
				$tglspsi 				= 'NULL';
			} else{
				$tglspsi				= "'".$key['tglspsi']."'";
			}
			if (is_null($key['nospsi'])) {
				$nospsi 				= 'NULL';
			} else{
				$nospsi				= "'".$key['nospsi']."'";
			}
			if (is_null($key['tglkop'])) {
				$tglkop 				= 'NULL';
			} else{
				$tglkop				= "'".$key['tglkop']."'";
			}
			if (is_null($key['nokoperasi'])) {
				$nokoperasi 				= 'NULL';
			} else{
				$nokoperasi				= "'".$key['nokoperasi']."'";
			}
			if (is_null($key['keluar'])) {
				$keluar 				= 'NULL';
			} else{
				$keluar				= "'".$key['keluar']."'";
			}
			if (is_null($key['tglkeluar'])) {
				$tglkeluar 				= 'NULL';
			} else{
				$tglkeluar				= "'".$key['tglkeluar']."'";
			}
			if (is_null($key['sebabklr'])) {
				$sebabklr 				= 'NULL';
			} else{
				$sebabklr				= "'".$key['sebabklr']."'";
			}
			if (is_null($key['photo'])) {
				$photo 				= 'NULL';
			} else{
				$photo				= "'".$key['photo']."'";
			}
			if (is_null($key['path_photo'])) {
				$path_photo 				= 'NULL';
			} else{
				$path_photo				= "'".$key['path_photo']."'";
			}
			if (is_null($key['tempat_makan'])) {
				$tempat_makan 				= 'NULL';
			} else{
				$tempat_makan				= "'".$key['tempat_makan']."'";
			}
			if (is_null($key['tempat_makan1'])) {
				$tempat_makan1 				= 'NULL';
			} else{
				$tempat_makan1				= "'".$key['tempat_makan1']."'";
			}
			if (is_null($key['tempat_makan2'])) {
				$tempat_makan2 				= 'NULL';
			} else{
				$tempat_makan2				= "'".$key['tempat_makan2']."'";
			}
			if (is_null($key['statusrekening'])) {
				$statusrekening 				= 'NULL';
			} else{
				$statusrekening				= "'".$key['statusrekening']."'";
			}
			if (is_null($key['point'])) {
				$point 				= 'NULL';
			} else{
				$point				= "'".$key['point']."'";
			}
			if (is_null($key['frektim'])) {
				$frektim 				= 'NULL';
			} else{
				$frektim				= "'".$key['frektim']."'";
			}
			if (is_null($key['frekct'])) {
				$frekct 				= 'NULL';
			} else{
				$frekct				= "'".$key['frekct']."'";
			}
			if (is_null($key['freksk'])) {
				$freksk 				= 'NULL';
			} else{
				$freksk				= "'".$key['freksk']."'";
			}
			if (is_null($key['ruang'])) {
				$ruang 				= 'NULL';
			} else{
				$ruang				= "'".$key['ruang']."'";
			}
			if (is_null($key['ang_upamk'])) {
				$ang_upamk 				= 'NULL';
			} else{
				$ang_upamk				= "'".$key['ang_upamk']."'";
			}
			if (is_null($key['nokeb'])) {
				$nokeb 				= 'NULL';
			} else{
				$nokeb				= "'".$key['nokeb']."'";
			}
			if (is_null($key['kd_jbt_dl'])) {
				$kd_jbt_dl 				= 'NULL';
			} else{
				$kd_jbt_dl				= "'".$key['kd_jbt_dl']."'";
			}
			if (is_null($key['puasa'])) {
				$puasa 				= 'NULL';
			} else{
				$puasa				= "'".$key['puasa']."'";
			}
			if (is_null($key['almt_kost'])) {
				$almt_kost 				= 'NULL';
			} else{
				$almt_kost				= "'".$key['almt_kost']."'";
			}
			if (is_null($key['ganti'])) {
				$ganti 				= 'NULL';
			} else{
				$ganti				= "'".$key['ganti']."'";
			}
			if (is_null($key['kd_pkj'])) {
				$kd_pkj 				= 'NULL';
			} else{
				$kd_pkj				= "'".$key['kd_pkj']."'";
			}
			if (is_null($key['noind_baru'])) {
				$noind_baru 				= 'NULL';
			} else{
				$noind_baru				= "'".$key['noind_baru']."'";
			}
			if (is_null($key['kode_status_kerja'])) {
				$kode_status_kerja 				= 'NULL';
			} else{
				$kode_status_kerja				= "'".$key['kode_status_kerja']."'";
			}
			if (is_null($key['kantor_asal'])) {
				$kantor_asal 				= 'NULL';
			} else{
				$kantor_asal				= "'".$key['kantor_asal']."'";
			}
			if (is_null($key['lokasi_kerja'])) {
				$lokasi_kerja 				= 'NULL';
			} else{
				$lokasi_kerja				= "'".$key['lokasi_kerja']."'";
			}
			if (is_null($key['nik'])) {
				$nik 				= 'NULL';
			} else{
				$nik				= "'".$key['nik']."'";
			}
			if (is_null($key['no_kk'])) {
				$no_kk 				= 'NULL';
			} else{
				$no_kk				= "'".$key['no_kk']."'";
			}
			if (is_null($key['last_action'])) {
				$last_action 				= 'NULL';
			} else{
				$last_action				= "'".$key['last_action']."'";
			}
			if (is_null($key['last_action_date'])) {
				$last_action_date 				= 'NULL';
			} else{
				$last_action_date				= "'".$key['last_action_date']."'";
			}
			if (is_null($key['bpjs_kes'])) {
				$bpjs_kes 				= 'NULL';
			} else{
				$bpjs_kes				= "'".$key['bpjs_kes']."'";
			}
			if (is_null($key['tglberlaku_kes'])) {
				$tglberlaku_kes 				= 'NULL';
			} else{
				$tglberlaku_kes				= "'".$key['tglberlaku_kes']."'";
			}
			if (is_null($key['bpjs_ket'])) {
				$bpjs_ket 				= 'NULL';
			} else{
				$bpjs_ket				= "'".$key['bpjs_ket']."'";
			}
			if (is_null($key['tglberlaku_ket'])) {
				$tglberlaku_ket 				= 'NULL';
			} else{
				$tglberlaku_ket				= "'".$key['tglberlaku_ket']."'";
			}
			if (is_null($key['bpjs_jht'])) {
				$bpjs_jht 				= 'NULL';
			} else{
				$bpjs_jht				= "'".$key['bpjs_jht']."'";
			}
			if (is_null($key['tglberlaku_jht'])) {
				$tglberlaku_jht 				= 'NULL';
			} else{
				$tglberlaku_jht				= "'".$key['tglberlaku_jht']."'";
			}

			$txt = "INSERT INTO hrd_khs.tpribadi (noind, nama, lokasi, jenkel, agama, templahir, tgllahir, goldarah, alamat, desa, kec, kab, prop, kodepos, denahrumah, statrumah, telepon, nohp, gelard, gelarb, pendidikan, jurusan, sekolah, statnikah, tglnikah, jumanak, jumsdr, diangkat, masukkerja, kodesie, golkerja, asal_outsourcing, kd_jabatan, jabatan, npwp, lmkontrak, akhkontrak, statpajak, jtanak, jtbknanak, tglspsi, nospsi, tglkop, nokoperasi, keluar, tglkeluar, sebabklr, photo, path_photo, tempat_makan, tempat_makan1, tempat_makan2, statusrekening, point, frektim, frekct, freksk, ruang, ang_upamk, nokeb, kd_jbt_dl, puasa, almt_kost, ganti, kd_pkj, noind_baru, kode_status_kerja, kantor_asal, lokasi_kerja, nik, no_kk, last_action, last_action_date, bpjs_kes, tglberlaku_kes, bpjs_ket, tglberlaku_ket, bpjs_jht, tglberlaku_jht) 
			VALUES($noind,
			$nama,
			$lokasi,
			$jenkel,
			$agama,
			$templahir,
			$tgllahir,
			$goldarah,
			$alamat,
			$desa,
			$kec,
			$kab,
			$prop,
			$kodepos,
			$denahrumah,
			$statrumah,
			$telepon,
			$nohp,
			$gelard,
			$gelarb,
			$pendidikan,
			$jurusan,
			$sekolah,
			$statnikah,
			$tglnikah,
			$jumanak,
			$jumsdr,
			$diangkat,
			$masukkerja,
			$kodesie,
			$golkerja,
			$asal_outsourcing,
			$kd_jabatan,
			$jabatan,
			$npwp,
			$lmkontrak,
			$akhkontrak,
			$statpajak,
			$jtanak,
			$jtbknanak,
			$tglspsi,
			$nospsi,
			$tglkop,
			$nokoperasi,
			$keluar,
			$tglkeluar,
			$sebabklr,
			$photo,
			$path_photo,
			$tempat_makan,
			$tempat_makan1,
			$tempat_makan2,
			$statusrekening,
			$point,
			$frektim,
			$frekct,
			$freksk	,
			$ruang,
			$ang_upamk,
			$nokeb,
			$kd_jbt_dl,
			$puasa,
			$almt_kost,
			$ganti,
			$kd_pkj,
			$noind_baru,
			$kode_status_kerja,
			$kantor_asal,
			$lokasi_kerja,
			$nik,
			$no_kk,
			$last_action,
			$last_action_date,
			$bpjs_kes,
			$tglberlaku_kes,
			$bpjs_ket,
			$tglberlaku_ket,
			$bpjs_jht,
			$tglberlaku_jht);
			";
			fwrite($myfile, $txt);
			// echo $txt;exit();
		}
		fclose($myfile);
		$wkt = date('Y-m-d');
		// echo $wkt;
		$wkt2 = date('H:i:s');
		// exit();

		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=DataSql_".$wkt."_".$wkt2.".txt");
		header("Content-Type: application/txt");
		header("Content-Transfer-Encoding: binary");
		header('Content-Length: ' . filesize('testfile.txt'));
		readfile('testfile.txt');
	}

	public function input()
	{
		set_time_limit(0);
		$this->load->library('upload');
		$nama_materi = $this->input->post('fileToUpload');
		// print_r($_FILES['fileToUpload']['name']);
		$filee = $_FILES['fileToUpload']['tmp_name'];
		$nama = $_FILES['fileToUpload']['name'];
		
		//upload an image options
		$config = array();
		$config['upload_path'] 	 = 'assets/upload/SDM';
		$config['allowed_types'] = 'txt';
		$config['max_size']      = '50000';
		$config['file_name']     = $nama_materi;
		$config['overwrite'] 	 = TRUE;			

		$this->upload->initialize($config);
		if ($this->upload->do_upload('fileToUpload')) {
			$this->upload->data();
			chmod('./assets/upload/SDM/'.$nama, 0777);
		} else {
			$errorinfo = $this->upload->display_errors();
			echo $errorinfo;
		}
		$dataSql = file_get_contents('./assets/upload/SDM/'.$nama);
		$ex = explode(';', $dataSql);
		$i = count($ex);
		$x = 1;
		$daftarNoind = '';
		// echo count($ex); exit();
		foreach ($ex as $key) {
			if ($x == 1) {
				$noind = substr($key, 834, 5);
			} else{
				$noind = substr($key, 838, 5);
			}
			$noind = "'".$noind."'";
			$daftarNoind[] = $noind;
			// if ($x == $i) {
			// 	$daftarNoind .= "'".$noind."'";
			// } else{
			// 	$daftarNoind .= "'".$noind."', ";
			// }
			// echo $key;
			// echo strpos($key,"('");
			// echo substr($key, 834, 5);
			// exit();
			$x++;
		}
		array_pop($daftarNoind);
			// echo $daftarNoind[3288];exit();
		$listNoind = implode(', ', $daftarNoind);
			// echo $listNoind.'<br>';
		$deletList = $this->M_index->hapusList($listNoind);
			// print_r($daftarNoind);
			// $delet = $this->M_index->hapus($noind);
		$addData = $this->M_index->addData($dataSql);
		echo "Data berhasil di Transfer";
		// if (is_null($addData[0]['denahrumah'])) {
		// 	echo 'asa';
		// }

	}

	public function grapicTabs() {
		$user_id = $this->session->userid;
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'Efisiensi SDM';
		$data['Menu'] = 'Efisiensi SDM';
		$data['submit'] = ($this->input->post('buttonSubmit')) ? 'true' : 'false';
		if($data['submit'] == 'true') {
			$nama = array(
				'Dept. Personalia',
				'Dept. Keuangan',
				'Dept. Pemasaran',
				'Dept. Pemasaran - Pusat',
				'Dept. Pemasaran - Cabang / Showroom / POS',
				'Dept. Keuangan Unit Akuntansi',
				'Dept. Keuangan Unit ICT',
				'Dept. Keuangan Unit Internal Audit',
				'Dept. Keuangan Unit Pengembangan Sistem',
				'Dept. Keuangan Unit Pembelian Subkontraktor',
				'Semua Data',
				'Semua Pekerja Tidak Langsung / InDirect Labour',
				'Semua Pekerja Langsung / Direct Labour',
				'Dept. Personalia Unit Civil Maintenance',
				'Dept. Keuangan Unit Pembelian Supplier',
				'Dept. Keuangan Unit Pengembangan Pembelian',
				'Dept. Keuangan Atasan',
				'Dept. Personalia Atasan',
				'Dept. Personalia Unit ELECTRONIC DATA PROCESSING',
				'Dept. Personalia Unit GENERAL AFFAIR & HUBUNGAN KERJA',
				'Dept. Personalia Unit PELATIHAN',
				'Dept. Personalia Unit PEOPLE DEVELOPMENT',
				'Dept. Personalia Unit RECRUITMENT & SELECTION',
				'Dept. Personalia Unit WASTE MANAGEMENT',
				'Dept. Pemasaran Atasan',
				'Dept. Pemasaran Unit CABANG JAKARTA',
				'Dept. Pemasaran Unit CABANG MAKASSAR',
				'Dept. Pemasaran Unit CABANG MEDAN',
				'Dept. Pemasaran Unit CABANG PERWAKILAN JAKARTA',
				'Dept. Pemasaran Unit CABANG PERWAKILAN MAKASSAR',
				'Dept. Pemasaran Unit CABANG PERWAKILAN MEDAN',
				'Dept. Pemasaran Unit CABANG PERWAKILAN SURABAYA',
				'Dept. Pemasaran Unit CABANG PERWAKILAN TANJUNG KARANG',
				'Dept. Pemasaran Unit CABANG PERWAKILAN YOGYAKARTA',
				'Dept. Pemasaran Unit CABANG SURABAYA',
				'Dept. Pemasaran Unit CABANG TANJUNG KARANG',
				'Dept. Pemasaran Unit CABANG YOGYAKARTA',
				'Dept. Pemasaran Unit PEMASARAN 1',
				'Dept. Pemasaran Unit PEMASARAN 2',
				'Dept. Pemasaran Unit PEMASARAN 3',
				'Dept. Pemasaran Unit PEMASARAN 4',
				'Dept. Pemasaran Unit PEMASARAN 5',
				'Dept. Pemasaran Unit PEMASARAN DEMO & PURNA JUAL',
				'Dept. Pemasaran Unit PEMASARAN EXPORT & DIRECT SELLING PRODUCT',
				'Dept. Pemasaran Unit PEMASARAN JOB ORDER',
				'Dept. Pemasaran Unit PEMASARAN PROMOSI',
				'Dept. Pemasaran Unit PEMASARAN SPARE PART',
				'Dept. Pemasaran Unit PEMASARAN SPECIAL CUSTOMER',
				'Dept. Pemasaran Unit PEMASARAN SUPPORT',
				'Dept. Pemasaran Unit PEMASARAN TR-2',
				'Dept. Pemasaran Unit VDE & GENSET AUDIT & PENGEMB. ORG. PMS & CAB',
				'Dept. Pemasaran Atasan Seksi',
				'Dept. Pemasaran Seksi AUDIT PEMASARAN & CABANG',
				'Dept. Pemasaran Seksi CABANG JAKARTA',
				'Dept. Pemasaran Seksi CABANG MAKASSAR',
				'Dept. Pemasaran Seksi CABANG MEDAN',
				'Dept. Pemasaran Seksi CABANG PERWAKILAN JAKARTA',
				'Dept. Pemasaran Seksi CABANG PERWAKILAN MAKASSAR',
				'Dept. Pemasaran Seksi CABANG PERWAKILAN MEDAN',
				'Dept. Pemasaran Seksi CABANG PERWAKILAN SURABAYA',
				'Dept. Pemasaran Seksi CABANG PERWAKILAN TANJUNG KARANG',
				'Dept. Pemasaran Seksi CABANG PERWAKILAN YOGYAKARTA',
				'Dept. Pemasaran Seksi CABANG SURABAYA',
				'Dept. Pemasaran Seksi CABANG TANJUNG KARANG',
				'Dept. Pemasaran Seksi CABANG YOGYAKARTA',
				'Dept. Pemasaran Seksi CUSTOMER CARE',
				'Dept. Pemasaran Seksi CUSTOMER CARE & KLAIM',
				'Dept. Pemasaran Seksi DEMO & PURNA JUAL',
				'Dept. Pemasaran Seksi DEMO & SERVICE AREA I',
				'Dept. Pemasaran Seksi DEMO & SERVICE AREA II',
				'Dept. Pemasaran Seksi ***DESAIN PROMOSI',
				'Dept. Pemasaran Seksi DESAIN PROMOSI',
				'Dept. Pemasaran Seksi DIGITAL MARKETING & KOMUNITAS QUICK',
				'Dept. Pemasaran Seksi DIGITAL MARKETING&KOMUNITAS QUICK',
				'Dept. Pemasaran Seksi ***PEMASARAN ALAT TRANSPORTASI',
				'Dept. Pemasaran Seksi PEMASARAN ALAT TRANSPORTASI AREA I',
				'Dept. Pemasaran Seksi PEMASARAN ALAT TRANSPORTASI AREA II',
				'Dept. Pemasaran Seksi ***PEMASARAN EXPORT',
				'Dept. Pemasaran Seksi PEMASARAN EXPORT',
				'Dept. Pemasaran Seksi PEMASARAN HARVESTER',
				'Dept. Pemasaran Seksi PEMASARAN JOB ORDER',
				'Dept. Pemasaran Seksi PEMASARAN MESIN PERTANIAN A',
				'Dept. Pemasaran Seksi PEMASARAN MESIN PERTANIAN B',
				'Dept. Pemasaran Seksi PEMASARAN ONLINE',
				'Dept. Pemasaran Seksi PEMASARAN SPARE PART AREA I',
				'Dept. Pemasaran Seksi PEMASARAN SPARE PART AREA II',
				'Dept. Pemasaran Seksi PEMASARAN SPARE PART AREA III',
				'Dept. Pemasaran Seksi PEMASARAN SPARE PART ENGINE',
				'Dept. Pemasaran Seksi PEMASARAN SP (SAP & BDL)',
				'Dept. Pemasaran Seksi PEMASARAN TR-2 AREA I',
				'Dept. Pemasaran Seksi PEMASARAN TR-2 AREA II',
				'Dept. Pemasaran Seksi PEMASARAN TR-2 AREA III',
				'Dept. Pemasaran Seksi PEMASARAN TR4&COMBINE HARVESTER',
				'Dept. Pemasaran Seksi PEMASARAN TRAKTOR RODA 4',
				'Dept. Pemasaran Seksi PEMASARAN VDE & GENSET',
				'Dept. Pemasaran Seksi PENGEMBANGAN & PENYEDIAAN PRD TR-2',
				'Dept. Pemasaran Seksi PENGIRIMAN PRODUK',
				'Dept. Pemasaran Seksi PENJUALAN SPARE PART',
				'Dept. Pemasaran Seksi POS BANYUASIN',
				'Dept. Pemasaran Seksi POS SAMARINDA',
				'Dept. Pemasaran Seksi POS SAMPIT',
				'Dept. Pemasaran Seksi PRODUKSI PROMOSI',
				'Dept. Pemasaran Seksi PUSAT PELATIHAN PELANGGAN & STANDARISASI',
				'Dept. Pemasaran Seksi RISET & IMPLEMENTASI PROMOSI',
				'Dept. Pemasaran Seksi SHOWROOM BANJARMASIN',
				'Dept. Pemasaran Seksi SHOWROOM JAMBI',
				'Dept. Pemasaran Seksi SHOWROOM PALU',
				'Dept. Pemasaran Seksi SHOWROOM PEKANBARU',
				'Dept. Pemasaran Seksi SHOWROOM PONTIANAK',
				'Dept. Pemasaran Seksi SHOWROOM SIDRAP',
				'Dept. Pemasaran Seksi SISTEM PENGEMBANGAN ORGANISASI CABANG & ORACLE',
				'Dept. Pemasaran Seksi SPECIAL CUSTOMER BARAT',
				'Dept. Pemasaran Seksi SPECIAL CUSTOMER MOS',
				'Dept. Pemasaran Seksi ***SPECIAL CUSTOMER PUSAT',
				'Dept. Pemasaran Seksi SPECIAL CUSTOMER PUSAT',
				'Dept. Pemasaran Seksi SPECIAL CUSTOMER QUALITY CONTROL',
				'Dept. Pemasaran Seksi SPECIAL CUSTOMER TENGAH',
				'Dept. Pemasaran Seksi SPECIAL CUSTOMER TIME KEEPER',
				'Dept. Pemasaran Seksi SPECIAL CUSTOMER TIMUR',
				'Dept. Pemasaran Seksi TOKO ONLINE'
			);
			$data['filterData'] = $this->input->post('filterData');
			$data['withPKL'] = $this->input->post('withPKL');
			$val = $data['filterData'];
			if ($data['withPKL']) {
				$sqlPKL = "and left(noind,1) not in('L','Z','M')";
				$data['pkl'] = 'Dengan PKL, Magang & TKPW';
				$data['truePKL'] = 'true';
			} else {
				$sqlPKL = "and left(noind,1) not in('F','G','L','N','Q','L','Z','M')";
				$data['pkl'] = '';
				$data['truePKL'] = 'true';
			}
			$bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
			$jumlah = array(6, 4, 4, 4, 4, 4, 6, 4, 4, 4, 4, 4);
			$data['akhir'] = array_combine($bulan, $jumlah);
			$begin = new DateTime('2019-01-01');
			$end = new DateTime('2019-12-31');
			$data['tgl'] = new DatePeriod($begin, new DateInterval('P14D'), $end);
			$begin = new DateTime('2019-01-01');
			$date = date('Y-m-d');
			$end = new DateTime($date);
			$end->setTime(0, 0, 1);
			$daterange = new DatePeriod($begin, new DateInterval('P14D'), $end);
			foreach($daterange as $date) {
				$now =  $date->format('m-d');
				$lokasi_kerja = '';
				if ($val >= 0 && $val <= 2) {
					$dept = array(4, 1, 2);
					$kodeDept = $dept[$val];
					$banyak = $this->M_index->pekerjaDepartemen($now, $kodeDept, $sqlPKL, $lokasi_kerja);
				} else if ($val == 3) {
					$lokasi_kerja = "and lokasi_kerja = '01'";
					$kodeDept = '2';
					$banyak = $this->M_index->pekerjaDepartemen($now, $kodeDept, $sqlPKL, $lokasi_kerja);
				} else if ($val == 4) {
					$lokasi_kerja = "and lokasi_kerja not in('01','02','03')";
					$kodeDept = '2';
					$banyak = $this->M_index->pekerjaDepartemen($now, $kodeDept, $sqlPKL, $lokasi_kerja);
				} else if ($val == 5) {
					$kodeUnit = 'AKUNTANSI';
					$banyak = $this->M_index->pekerjaUnitKeuangan($now, $kodeUnit, $sqlPKL);
				} else if ($val == 6) {
					$kodeUnit = 'INFORMATION & COMMUNICATION TECHNOLOGY';
					$banyak = $this->M_index->pekerjaUnitKeuangan($now, $kodeUnit, $sqlPKL);
				} else if ($val == 7) {
					$kodeUnit = 'INTERNAL AUDIT';
					$banyak = $this->M_index->pekerjaUnitKeuangan($now, $kodeUnit, $sqlPKL);
				} else if ($val ==  8) {
					$kodeUnit = 'PENGEMBANGAN SISTEM';
					$banyak = $this->M_index->pekerjaUnitKeuangan($now, $kodeUnit, $sqlPKL);
				} else if ($val == 9) {
					$kodeUnit = 'PEMBELIAN SUBKONTRAKTOR';
					$banyak = $this->M_index->pekerjaUnitKeuangan($now, $kodeUnit, $sqlPKL);
				} else if ($val == 10) {
					$banyak = $this->M_index->semuaData($now, $sqlPKL);
					$kode = 'and (b.jenispekerjaan=true or b.kdpekerjaan is null)';
					$banyak1 = $this->M_index->pekerjaOperatorAll($now, $sqlPKL, $kode);
					$kode = 'and (b.jenispekerjaan=false)';
					$banyak2 = $this->M_index->pekerjaOperatorAll($now, $sqlPKL, $kode);
				} else if ($val == 11) {
					$kode = 'and (b.jenispekerjaan=true or b.kdpekerjaan is null)';
					$banyak = $this->M_index->pekerjaOperatorAll($now, $sqlPKL, $kode);
				} else if ($val == 12) {
					$kode = 'and (b.jenispekerjaan=false)';
					$banyak = $this->M_index->pekerjaOperatorAll($now, $sqlPKL, $kode);
				} else if ($val == 13) {
					$kodeUnit = 'CIVIL MAINTENANCE';
					$banyak = $this->M_index->pekerjaUnitPersonalia($now, $kodeUnit, $sqlPKL);
				} else if ($val == 14) {
					$kodeUnit = 'PEMBELIAN SUPPLIER';
					$banyak = $this->M_index->pekerjaUnitKeuangan($now, $kodeUnit, $sqlPKL);
				} else if ($val == 15) {
					$kodeUnit = 'PENGEMBANGAN PEMBELIAN';
					$banyak = $this->M_index->pekerjaUnitKeuangan($now, $kodeUnit, $sqlPKL);
				} else if ($val == 16) {
					$kodeUnit = '-';
					$banyak = $this->M_index->pekerjaUnitKeuangan($now, $kodeUnit, $sqlPKL);
				} else if ($val == 17) {
					$kodeUnit = '-';
					$banyak = $this->M_index->pekerjaUnitPersonalia($now, $kodeUnit, $sqlPKL);
				} else if ($val == 18) {
					$kodeUnit = 'ELECTRONIC DATA PROCESSING';
					$banyak = $this->M_index->pekerjaUnitPersonalia($now, $kodeUnit, $sqlPKL);
				} else if ($val == 19) {
					$kodeUnit = 'GENERAL AFFAIR & HUBUNGAN KERJA';
					$banyak = $this->M_index->pekerjaUnitPersonalia($now, $kodeUnit, $sqlPKL);
				} else if ($val == 20) {
					$kodeUnit = 'PELATIHAN';
					$banyak = $this->M_index->pekerjaUnitPersonalia($now, $kodeUnit, $sqlPKL);
				} else if ($val == 21) {
					$kodeUnit = 'PEOPLE DEVELOPMENT';
					$banyak = $this->M_index->pekerjaUnitPersonalia($now, $kodeUnit, $sqlPKL);
				} else if ($val == 22) {
					$kodeUnit = 'RECRUITMENT & SELECTION';
					$banyak = $this->M_index->pekerjaUnitPersonalia($now, $kodeUnit, $sqlPKL);
				} else if ($val == 23) {
					$kodeUnit = 'WASTE MANAGEMENT';
					$banyak = $this->M_index->pekerjaUnitPersonalia($now, $kodeUnit, $sqlPKL);
				} else if ($val == 24) {
					$kodeUnit = '-';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 25) {
					$kodeUnit = 'CABANG JAKARTA';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 26) {
					$kodeUnit = 'CABANG MAKASSAR';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 27) {
					$kodeUnit = 'CABANG MEDAN';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 28) {
					$kodeUnit = 'CABANG PERWAKILAN JAKARTA';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 29) {
					$kodeUnit = 'CABANG PERWAKILAN MAKASSAR';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 30) {
					$kodeUnit = 'CABANG PERWAKILAN MEDAN';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 31) {
					$kodeUnit = 'CABANG PERWAKILAN SURABAYA';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 32) {
					$kodeUnit = 'CABANG PERWAKILAN TANJUNG KARANG';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 33) {
					$kodeUnit = 'CABANG PERWAKILAN YOGYAKARTA';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 34) {
					$kodeUnit = 'CABANG SURABAYA';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 35) {
					$kodeUnit = 'CABANG TANJUNG KARANG';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 36) {
					$kodeUnit = 'CABANG YOGYAKARTA';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 37) {
					$kodeUnit = 'PEMASARAN 1';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 38) {
					$kodeUnit = 'PEMASARAN 2';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 39) {
					$kodeUnit = 'PEMASARAN 3';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 40) {
					$kodeUnit = 'PEMASARAN 4';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 41) {
					$kodeUnit = 'PEMASARAN 5';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 42) {
					$kodeUnit = 'PEMASARAN DEMO & PURNA JUAL';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 43) {
					$kodeUnit = 'PEMASARAN EXPORT&DIRECT SELLING PRODUCT';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 44) {
					$kodeUnit = 'PEMASARAN JOB ORDER';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 45) {
					$kodeUnit = 'PEMASARAN PROMOSI';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 46) {
					$kodeUnit = 'PEMASARAN SPARE PART';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 47) {
					$kodeUnit = 'PEMASARAN SPECIAL CUSTOMER';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 48) {
					$kodeUnit = 'PEMASARAN SUPPORT';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 49) {
					$kodeUnit = 'PEMASARAN TR-2';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 50) {
					$kodeUnit = 'VDE&GENSET AUDIT&PENGEMB. ORG. PMS&CAB';
					$banyak = $this->M_index->pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL);
				} else if ($val == 51) {
					$kodeSeksi = '-';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 52) {
					$kodeSeksi = 'AUDIT PEMASARAN&CABANG';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 53) {
					$kodeSeksi = 'CABANG JAKARTA';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 54) {
					$kodeSeksi = 'CABANG MAKASSAR';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 55) {
					$kodeSeksi = 'CABANG MEDAN';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 56) {
					$kodeSeksi = 'CABANG PERWAKILAN JAKARTA';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 57) {
					$kodeSeksi = 'CABANG PERWAKILAN MAKASSAR';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 58) {
					$kodeSeksi = 'CABANG PERWAKILAN MEDAN';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 59) {
					$kodeSeksi = 'CABANG PERWAKILAN SURABAYA';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 60) {
					$kodeSeksi = 'CABANG PERWAKILAN TANJUNG KARANG';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 61) {
					$kodeSeksi = 'CABANG PERWAKILAN YOGYAKARTA';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 62) {
					$kodeSeksi = 'CABANG SURABAYA';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 63) {
					$kodeSeksi = 'CABANG TANJUNG KARANG';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 64) {
					$kodeSeksi = 'CABANG YOGYAKARTA';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 65) {
					$kodeSeksi = 'CUSTOMER CARE';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 66) {
					$kodeSeksi = 'CUSTOMER CARE & KLAIM';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 67) {
					$kodeSeksi = 'DEMO & PURNA JUAL';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 68) {
					$kodeSeksi = 'DEMO & SERVICE AREA I';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 69) {
					$kodeSeksi = 'DEMO & SERVICE AREA II';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 70) {
					$kodeSeksi = '***DESAIN PROMOSI';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 71) {
					$kodeSeksi = 'DESAIN PROMOSI';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 72) {
					$kodeSeksi = 'DIGITAL MARKETING & KOMUNITAS QUICK';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 73) {
					$kodeSeksi = 'DIGITAL MARKETING&KOMUNITAS QUICK';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 74) {
					$kodeSeksi = '***PEMASARAN ALAT TRANSPORTASI';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 75) {
					$kodeSeksi = 'PEMASARAN ALAT TRANSPORTASI AREA I';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 76) {
					$kodeSeksi = 'PEMASARAN ALAT TRANSPORTASI AREA II';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 77) {
					$kodeSeksi = '***PEMASARAN EXPORT';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 78) {
					$kodeSeksi = 'PEMASARAN EXPORT';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 79) {
					$kodeSeksi = 'PEMASARAN HARVESTER';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 80) {
					$kodeSeksi = 'PEMASARAN JOB ORDER';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 81) {
					$kodeSeksi = 'PEMASARAN MESIN PERTANIAN A';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 82) {
					$kodeSeksi = 'PEMASARAN MESIN PERTANIAN B';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 83) {
					$kodeSeksi = 'PEMASARAN ONLINE';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 84) {
					$kodeSeksi = 'PEMASARAN SPARE PART AREA I';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 85) {
					$kodeSeksi = 'PEMASARAN SPARE PART AREA II';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 86) {
					$kodeSeksi = 'PEMASARAN SPARE PART AREA III';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 87) {
					$kodeSeksi = 'PEMASARAN SPARE PART ENGINE';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 88) {
					$kodeSeksi = 'PEMASARAN SP (SAP&BDL)';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 89) {
					$kodeSeksi = 'PEMASARAN TR-2 AREA I';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 90) {
					$kodeSeksi = 'PEMASARAN TR-2 AREA II';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 91) {
					$kodeSeksi = 'PEMASARAN TR-2 AREA III';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 92) {
					$kodeSeksi = 'PEMASARAN TR4&COMBINE HARVESTER';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 93) {
					$kodeSeksi = 'PEMASARAN TRAKTOR RODA 4';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 94) {
					$kodeSeksi = 'PEMASARAN VDE&GENSET';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 95) {
					$kodeSeksi = 'PENGEMBANGAN & PENYEDIAAN PRD TR-2';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 96) {
					$kodeSeksi = 'PENGIRIMAN PRODUK';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 97) {
					$kodeSeksi = 'PENJUALAN SPARE PART';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 98) {
					$kodeSeksi = 'POS BANYUASIN';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 99) {
					$kodeSeksi = 'POS SAMARINDA';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 100) {
					$kodeSeksi = 'POS SAMPIT';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 101) {
					$kodeSeksi = 'PRODUKSI PROMOSI';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 102) {
					$kodeSeksi = 'PUSAT PELATIHAN PELANGGAN & STANDARISASI';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 103) {
					$kodeSeksi = 'RISET&IMPLEMENTASI PROMOSI';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 104) {
					$kodeSeksi = 'SHOWROOM BANJARMASIN';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 105) {
					$kodeSeksi = 'SHOWROOM JAMBI';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 106) {
					$kodeSeksi = 'SHOWROOM PALU';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 107) {
					$kodeSeksi = 'SHOWROOM PEKANBARU';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 108) {
					$kodeSeksi = 'SHOWROOM PONTIANAK';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 109) {
					$kodeSeksi = 'SHOWROOM SIDRAP';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 110) {
					$kodeSeksi = 'SISTEM PENGEMBANGAN ORGANISASI CABANG&ORACLE';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 111) {
					$kodeSeksi = 'SPECIAL CUSTOMER BARAT';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 112) {
					$kodeSeksi = 'SPECIAL CUSTOMER MOS';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 113) {
					$kodeSeksi = '***SPECIAL CUSTOMER PUSAT';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 114) {
					$kodeSeksi = 'SPECIAL CUSTOMER PUSAT';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 115) {
					$kodeSeksi = 'SPECIAL CUSTOMER QUALITY CONTROL';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 116) {
					$kodeSeksi = 'SPECIAL CUSTOMER TENGAH';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 117) {
					$kodeSeksi = 'SPECIAL CUSTOMER TIME KEEPER';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 118) {
					$kodeSeksi = 'SPECIAL CUSTOMER TIMUR';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 119) {
					$kodeSeksi = 'TOKO ONLINE';
					$banyak = $this->M_index->pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL);
				}
				$hasil[] = (count($banyak) >= 1) ? $banyak[0]['count'] : 0;
				if($val == 10) {
					$hasil1[] = (count($banyak1) >= 1) ? $banyak1[0]['count'] : 0;
					$hasil2[] = (count($banyak2) >= 1) ? $banyak2[0]['count'] : 0;
				}
			}
			if ($val >= 0 && $val <= 2) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 3) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 4) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 5) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 6) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 7) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 8) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 9) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 10) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
				$min1 = round((1.15 * $hasil1[0] / 100), 2);
				$minAg1 = round((1.3 * $hasil1[0] / 100), 2);
				$min2 = round((1.15 * $hasil2[0] / 100), 2);
				$minAg2 = round((1.3 * $hasil2[0] / 100), 2);
			} else if ($val == 11) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 12) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 13) {
				$min = round((1.25 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 14) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 15) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 16) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 17) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 18) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 19) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 20) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 21) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 22) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 23) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 24) {
				$min = round((1.3 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 25) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 26) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 27) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 28) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 29) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 30) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 31) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 32) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 33) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 34) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 35) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 36) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 37) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 38) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 39) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 40) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 41) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 42) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 43) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 44) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 45) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 46) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 47) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 48) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 49) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 50) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 51) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 52) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 53) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 54) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 55) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 56) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 57) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 58) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 59) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 60) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 61) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 62) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 63) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 64) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 65) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 66) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 67) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 68) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 69) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 70) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 71) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 72) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 73) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 74) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 75) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 76) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 77) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 78) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 79) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 80) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 81) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 82) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 83) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 84) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 85) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 86) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 87) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 88) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 89) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 90) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 91) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 92) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 93) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 94) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 95) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 96) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 97) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 98) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 99) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 100) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 101) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 102) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 103) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 104) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 105) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 106) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 107) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 108) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 109) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 110) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 111) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 112) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 113) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 114) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 115) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 116) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 117) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 118) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 119) {
				$min = round((1.15 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			} else {
				$min = round((1.3 * $hasil[0] / 100), 2);
				$minAg = round((1.3 * $hasil[0] / 100), 2);
			}
			$data['min'] = $min;
			$data['minAg'] = $minAg;
			$data['target'] = $hasil;
			if($val == 10) {
				$data['min1'] = $min1;
				$data['minAg1'] = $minAg1;
				$data['target1'] = $hasil1;
				$data['min2'] = $min2;
				$data['minAg2'] = $minAg2;
				$data['target2'] = $hasil2;
			}
			$data['nama'] = trim($nama[$val]);
		}
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Grapic/V_Grapic_Tabs',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getDatav2() {
		$selet = $this->M_index->getDatav2();
		$i = count($selet);
		$x = 1;
		$myfile = fopen("testfile.txt", "w");
		foreach ($selet as $key) {
			if ($x == $i) {
				$txt = $key['noind'].'/'.$key['kodesie'].'/'.$key['tglkeluar'].'/'.$key['keluar'];
			} else{
				$txt = $key['noind'].'/'.$key['kodesie'].'/'.$key['tglkeluar'].'/'.$key['keluar'].',';
			}
			$x++;
			fwrite($myfile, $txt);
		}
		// echo "<pre>";
		// print_r($selet);

		fclose($myfile);
		$wkt = date('Y-m-d');
		// echo $wkt;
		$wkt2 = date('H:i:s');
		// exit();

		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=DataSql_".$wkt."_".$wkt2.".txt");
		header("Content-Type: application/txt");
		header("Content-Transfer-Encoding: binary");
		header('Content-Length: ' . filesize('testfile.txt'));
		readfile('testfile.txt');
	}

	public function inputv2()
	{
		$this->load->library('upload');
		$nama_materi = $this->input->post('fileToUpload');
		// print_r($_FILES['fileToUpload']['name']);
		$filee = $_FILES['fileToUpload']['tmp_name'];
		$nama = $_FILES['fileToUpload']['name'];
		
		//upload an image options
		$config = array();
		$config['upload_path'] 	 = 'assets/upload/SDM';
		$config['allowed_types'] = 'txt';
		$config['max_size']      = '50000';
		$config['file_name']     = $nama_materi;
		$config['overwrite'] 	 = TRUE;			

		if (!file_exists('./assets/upload/SDM')) {
			mkdir('./assets/upload/SDM', 0777, true);
		}

		$this->upload->initialize($config);
		if ($this->upload->do_upload('fileToUpload')) {
			$this->upload->data();
			chmod('./assets/upload/SDM/'.$nama, 0777);
		} else {
			$errorinfo = $this->upload->display_errors();
			echo $errorinfo;
		}
		// exit();
		$dataSql = file_get_contents('./assets/upload/SDM/'.$nama);
		$line= explode(',', $dataSql);
		// print_r($ex);exit();
		foreach ($line as $key) {
			$val = explode('/', $key);
			$cekNoind = $this->M_index->cekNoind($val[0]);
			if ($cekNoind == '1') {
				$updateData = $this->M_index->updateData($val[0],$val[1],$val[2],$val[3]);
			} else{

			}
			exit();
		}
		$addData = $this->M_index->addData($dataSql);
		if ($addData) {
			echo "Data berhasil di Transfer";
		} else{
			echo "Error Muncul";
		}
	}

	public function TrendJumlahPekerja() {
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'Trend Jumlah Pekerja';
		$data['Menu'] = 'Trend Jumlah Pekerja';
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('Grapic/V_Trend_Pekerja', $data);
		$this->load->view('V_Footer', $data);
	}

	public function getTrendJumlahPekerjaEmployee() {
		$data['tabel2018'] = $this->M_index->getTrend('2018',"and left(noind,1) not in('F','G','L','N','Q','L','Z','M')");
		$data['tabel2019'] = $this->M_index->getTrend('2019',"and left(noind,1) not in('F','G','L','N','Q','L','Z','M')");
		echo json_encode($data);
	}

	public function getTrendJumlahPekerjaPkl() {
		$data['tabel2018pkl'] = $this->M_index->getTrend('2018',"and left(noind,1) not in('L','Z','M')");
		$data['tabel2019pkl'] = $this->M_index->getTrend('2019',"and left(noind,1) not in('L','Z','M')");
		echo json_encode($data);
	}
}