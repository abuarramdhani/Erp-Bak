<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ini_set('memory_limit', '-1');

class C_Produksi extends CI_Controller {
	
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
		// print_r($min3);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Grapic/V_IndexProd',$data);
		$this->load->view('V_Footer',$data);
	}

	public function openPDF()
	{
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
					$kodeDept = $depart[$x];

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
						$hasil[$x][] = $banyak[0]['count'];
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
			} else{
				
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
		} else{
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

	public function grapicBaru() {
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
				$val = $all[$x];
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

					$hasil[$x][] = $banyak[0]['count'];
				}
				$min =  round((1.3 * $hasil[0] / 100),0);
				$data['min'.$x] = $min;
				$data['target'.$x] = $hasil[$x];

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
			$val = $all[$x];
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

				$hasil[$x][] = $banyak[0]['count'];
			}
			$min =  round((1.3 * $hasil[0] / 100),0);
			$data['min'.$x] = $min;
			$data['target'.$x] = $hasil[$x];

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
		$data['Title'] = 'Efisiensi SDM Dept. Produksi';
		$data['Menu'] = 'Efisiensi SDM Dept. Produksi';
		$data['submit'] = ($this->input->post('buttonSubmit')) ? 'true' : 'false';
		if($data['submit'] == 'true') {
			$nama = array(
				'Dept. Produksi',
				'Dept. Produksi - Pusat',
				'Dept. Produksi - Tuksono',
				'Dept. Produksi - Seksi Cetakan & Pasir Cetak & Inti Cor Dan Pel&Pen-TKS',
				'Dept. Produksi - Seksi Desain A',
				'Dept. Produksi - Melati',
				'Dept. Produksi - Seksi Administrasi Desain',
				'Dept. Produksi - Seksi Assembly',
				'Dept. Produksi - Seksi Assembly Gear Trans',
				'Dept. Produksi - Seksi Assembly-TKS',
				'Dept. Produksi - Seksi Cetakan & Pasir Cetak & Inti Cor Dan Peleburan-Penuangan',
				'Dept. Produksi - Pekerja Tidak Langsung / InDirect Labour',
				'Dept. Produksi - Pekerja Langsung / Direct Labour',
				'Dept. Produksi - Seksi Desain B',
				'Dept. Produksi - Seksi Desain C',
				'Dept. Produksi - Seksi DOJO Desain',
				'Dept. Produksi - Seksi DOJO Foundry',
				'Dept. Produksi - Seksi DOJO Machining',
				'Dept. Produksi - Seksi Finishing',
				'Dept. Produksi - Seksi Finishing-TKS',
				'Dept. Produksi - Seksi Gudang Blank Material-TKS',
				'Dept. Produksi - Seksi Gudang D & E',
				'Dept. Produksi - Seksi Gudang Komponen',
				'Dept. Produksi - Seksi Gudang Material Dan Bahan Penolong',
				'Dept. Produksi - Seksi Gudang Pengadaan dan Blank Material',
				'Dept. Produksi - Seksi Gudang Produksi Dan Ekpedisi',
				'Dept. Produksi - Seksi Gudang Produksi Dan Ekpedisi-TKS',
				'Dept. Produksi - Seksi Heat Treatmen-TKS',
				'Dept. Produksi - Seksi Lab. Kimia dan Pasir Cetak',
				'Dept. Produksi - Seksi Machining 1',
				'Dept. Produksi - Seksi Machining A-TKS',
				'Dept. Produksi - Seksi Machining B',
				'Dept. Produksi - Seksi Machining B-TKS',
				'Dept. Produksi - Seksi Machining C',
				'Dept. Produksi - Seksi Machining C-TKS',
				'Dept. Produksi - Seksi Machining D',
				'Dept. Produksi - Seksi Machining D-TKS',
				'Dept. Produksi - Seksi Machining E',
				'Dept. Produksi - Seksi Machining Prototype',
				'Dept. Produksi - Seksi Maintenace',
				'Dept. Produksi - Seksi Maintenace-TKS',
				'Dept. Produksi - Seksi Maintenace Dan Pengembangan Alat',
				'Dept. Produksi - Seksi Maintenace Dan Pengembangan Alat-TKS',
				'Dept. Produksi - Seksi Painting Dan Packaging',
				'Dept. Produksi - Seksi Painting Dan Packaging-TKS',
				'Dept. Produksi - Seksi Penerimaan Barang Gudang',
				'Dept. Produksi - Seksi Penerimaan Barang Gudang-TKS',
				'Dept. Produksi - Seksi Pengeluaran Barang Gudang',
				'Dept. Produksi - Seksi Pengeluaran Barang Gudang-TKS',
				'Dept. Produksi - Seksi Pengembangan Prototype A',
				'Dept. Produksi - Seksi Pengembangan Prototype B',
				'Dept. Produksi - Seksi Pola',
				'Dept. Produksi - Seksi Pola/Pattern-TKS',
				'Dept. Produksi - Seksi Potong AS',
				'Dept. Produksi - Seksi PPC & Gudang dan Administrasi',
				'Dept. Produksi - Seksi PPC Tool Making',
				'Dept. Produksi - Seksi PPIC',
				'Dept. Produksi - Seksi PPIC-TKS',
				'Dept. Produksi - Seksi PPIC&Gudang Dan Administrasi-TKS',
				'Dept. Produksi - Seksi PPIC Prototype Desain',
				'Dept. Produksi - Seksi Production And Inventory ERP Application',
				'Dept. Produksi - Seksi Production Engineering',
				'Dept. Produksi - Seksi Production Engineering-DOJO',
				'Dept. Produksi - Seksi QC Desain Riset Dan Testing',
				'Dept. Produksi - Seksi Quality Assurance',
				'Dept. Produksi - Seksi Quality Control',
				'Dept. Produksi - Seksi Quality Control-TKS',
				'Dept. Produksi - Seksi Quality Engineering',
				'Dept. Produksi - Seksi Quality - TKS',
				'Dept. Produksi - Seksi Rekayasa Dan Rebuilding Mensin',
				'Dept. Produksi - Seksi Riset Dan Testing Alat Uji',
				'Dept. Produksi - Seksi Riset Dan Testing Cultivator',
				'Dept. Produksi - Seksi Riset Dan Testing Harvester',
				'Dept. Produksi - Seksi Riset Dan Testing Pengembangan',
				'Dept. Produksi - Seksi Riset Dan Testing PPIC',
				'Dept. Produksi - Seksi Riset Dan Testing Quick Truck',
				'Dept. Produksi - Seksi Riset Dan Testing Traktor 2W',
				'Dept. Produksi - Seksi Riset Dan Testing Traktor 4W',
				'Dept. Produksi - Seksi Sheet Metal-TKS',
				'Dept. Produksi - Seksi Tool Making 1',
				'Dept. Produksi - Seksi Tool Making A',
				'Dept. Produksi - Seksi Tool Making B',
				'Dept. Produksi - Seksi Tool Warehouse',
				'Dept. Produksi - Seksi Tool Warehouse-TKS',
				'Dept. Produksi - Seksi Welding A',
				'Dept. Produksi - Seksi Welding B',
				'Dept. Produksi - Seksi Welding-TKS',
				'Dept. Produksi - Seksi Machining A',
				'Dept. Produksi Atasan Seksi'
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
				if ($val == 0) {
					$kodeDept = 3;
					$banyak = $this->M_index->pekerjaDepartemen($now, $kodeDept, $sqlPKL, $lokasi_kerja);
					$banyak1 = $this->M_index->pekerjaOperator($now, $sqlPKL, 'and (b.jenispekerjaan=true or b.kdpekerjaan is null)');
					$banyak2 = $this->M_index->pekerjaOperator($now, $sqlPKL, 'and (b.jenispekerjaan=false)');
				} else if ($val == 1) {
					$kodeDept = 3;
					$banyak = $this->M_index->pekerjaDepartemen($now, $kodeDept, $sqlPKL, "and lokasi_kerja = '01'");
				} else if ($val == 2) {
					$kodeDept = 3;
					$banyak = $this->M_index->pekerjaDepartemen($now, $kodeDept, $sqlPKL, "and lokasi_kerja = '02'");
				} else if ($val == 3) {
					//Dept. Produksi - Seksi CETAKAN,PASIR CETAK & INTI COR,PELEBURAN-PENUANGAN-TKS
					$kodeSeksi = 'CETAKAN, PASIR CETAK&INTI COR, PEL&PEN - TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 4) {
					//Dept. Produksi - Seksi DESAIN A
					$kodeSeksi = 'DESAIN A';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 5) {
					//dept produksi melati
					$kodeDept = 3;
					$banyak = $this->M_index->pekerjaDepartemen($now, $kodeDept, $sqlPKL, "and lokasi_kerja = '03'");
				} else if ($val == 6) {
					//Dept. Produksi - Seksi Administrasi Desain
					$kodeSeksi = 'ADMINISTRASI DESAIN';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 7) {
					//Dept. Produksi - Seksi ASSEMBLY
					$kodeSeksi = 'ASSEMBLY';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 8) {
					//Dept. Produksi - Seksi ASSEMBLY GEAR TRANS
					$kodeSeksi = 'ASSEMBLY GEAR TRANS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 9) {
					//Dept. Produksi - Seksi ASSEMBLY-TKS
					$kodeSeksi = 'ASSEMBLY-TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 10) {
					//Dept. Produksi - Seksi CETAKAN,PASIR CETAK & INTI COR,PELEBURAN-PENUANGAN
					$kodeSeksi = 'CETAKAN,PASIR CETAK & INTI COR,PELEBURAN-PENUANGAN';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 11) {
					//non penunjang atau direct
					$banyak = $this->M_index->pekerjaOperator($now, $sqlPKL, 'and (b.jenispekerjaan=true or b.kdpekerjaan is null)');
				} else if ($val == 12) {
					//penunjang atau in-direct
					$banyak = $this->M_index->pekerjaOperator($now, $sqlPKL, 'and (b.jenispekerjaan=false)');
				} else if ($val == 13) {
					//Dept. Produksi - Seksi DESAIN B
					$kodeSeksi = 'DESAIN B';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 14) {
					//Dept. Produksi - Seksi DESAIN C
					$kodeSeksi = 'DESAIN C';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 15) {
					//Dept. Produksi - Seksi DOJO DESAIN
					$kodeSeksi = 'DOJO DESAIN';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 16) {
					//Dept. Produksi - Seksi DOJO FOUNDRY
					$kodeSeksi = 'DOJO FOUNDRY';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 17) {
					//Dept. Produksi - Seksi DOJO MACHINING
					$kodeSeksi = 'DOJO MACHINING';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 18) {
					//Dept. Produksi - Seksi FINISHING
					$kodeSeksi = 'FINISHING';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 19) {
					//Dept. Produksi - Seksi FINISHING-TKS
					$kodeSeksi = 'FINISHING - TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 20) {
					//Dept. Produksi - Seksi GUDANG BLANK MATERIAL-TKS
					$kodeSeksi = 'GUDANG BLANK MATERIAL-TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 21) {
					//Dept. Produksi - GUDANG D & E
					$kodeSeksi = 'GUDANG D & E';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 22) {
					//Dept. Produksi - Seksi GUDANG KOMPONEN
					$kodeSeksi = 'GUDANG KOMPONEN';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 23) {
					//Dept. Produksi - Seksi GUDANG MATERIAL & BAHAN PENOLONG
					$kodeSeksi = 'GUDANG MATERIAL & BAHAN PENOLONG';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 24) {
					//Dept. Produksi - Seksi GUDANG PENGADAAN & BLANK MATERIAL
					$kodeSeksi = 'GUDANG PENGADAAN & BLANK MATERIAL';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 25) {
					//Dept. Produksi - Seksi GUDANG PRODUKSI & EKSPEDISI
					$kodeSeksi = 'GUDANG PRODUKSI & EKSPEDISI';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 26) {
					//Dept. Produksi - Seksi GUDANG PRODUKSI & EKSPEDISI TKS
					$kodeSeksi = 'GUDANG PRODUKSI & EKSPEDISI - TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 27) {
					//Dept. Produksi - Seksi HEAT TREATMENT
					$kodeSeksi = 'HEAT TREATMENT - TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 28) {
					//Dept. Produksi - Seksi LABORATORIUM KIMIA & PASIR CETAK
					$kodeSeksi = 'LABORATORIUM KIMIA & PASIR CETAK';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 29) {
					//Dept. Produksi - Seksi MACHINING 1
					$kodeSeksi = 'MACHINING 1';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 30) {
					//Dept. Produksi - Seksi MACHINING A-TKS
					$kodeSeksi = 'MACHINING A - TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 31) {
					//Dept. Produksi - Seksi MACHINING B
					$kodeSeksi = 'MACHINING B';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 32) {
					//Dept. Produksi - Seksi MACHINING B-TKS
					$kodeSeksi = 'MACHINING B - TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 33) {
					//Dept. Produksi - Seksi MACHINING C
					$kodeSeksi = 'MACHINING C';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 34) {
					//Dept. Produksi - Seksi MACHINING C-TKS
					$kodeSeksi = 'MACHINING C - TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 35) {
					//Dept. Produksi - Seksi MACHINING D
					$kodeSeksi = 'MACHINING D';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 36) {
					//Dept. Produksi - Seksi MACHINING D-TKS
					$kodeSeksi = 'MACHINING D - TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 37) {
					//Dept. Produksi - Seksi MACHINING E
					$kodeSeksi = 'MACHINING E';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 38) {
					//Dept. Produksi - Seksi MACHINING PROTOTYPE
					$kodeSeksi = 'MACHINING PROTOTYPE';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 39) {
					//Dept. Produksi - Seksi MAINTENANCE
					$kodeSeksi = 'MAINTENANCE';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 40) {
					//Dept. Produksi - Seksi MAINTENANCE-TKS
					$kodeSeksi = 'MAINTENANCE - TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 41) {
					//Dept. Produksi - Seksi MAINTENANCE & PENGEMBANGAN ALAT
					$kodeSeksi = 'MAINTENANCE & PENGEMBANGAN ALAT';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 42) {
					//Dept. Produksi - Seksi MAINTENANCE & PENGEMBANGAN ALAT-TKS
					$kodeSeksi = 'MAINTENANCE & PENGEMBANGAN ALAT - TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 43) {
					//Dept. Produksi - Seksi PAINTING & PACKAGING
					$kodeSeksi = 'PAINTING & PACKAGING';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 44) {
					//Dept. Produksi - Seksi PAINTING & PACKAGING-TKS
					$kodeSeksi = 'PAINTING & PACKAGING - TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 45) {
					//Dept. Produksi - Seksi PENERIMAAN BARANG GUDANG
					$kodeSeksi = 'PENERIMAAN BARANG GUDANG';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 46) {
					//Dept. Produksi - Seksi PENERIMAAN BARANG GUDANG-TKS
					$kodeSeksi = 'PENERIMAAN BARANG GUDANG-TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 47) {
					//Dept. Produksi - Seksi PENGELUARAN BARANG GUDANG
					$kodeSeksi = 'PENGELUARAN BARANG GUDANG';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 48) {
					//Dept. Produksi - Seksi PENGELUARAN BARANG GUDANG-TKS
					$kodeSeksi = 'PENGELUARAN BARANG GUDANG-TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 49) {
					//Dept. Produksi - Seksi PENGEMBANGAN PROTOTYPE A
					$kodeSeksi = 'PENGEMBANGAN PROTOTYPE A';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 50) {
					//Dept. Produksi - Seksi PENGEMBANGAN PROTOTYPE B
					$kodeSeksi = 'PENGEMBANGAN PROTOTYPE B';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 51) {
					//Dept. Produksi - Seksi POLA
					$kodeSeksi = 'POLA';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 52) {
					//Dept. Produksi - Seksi POLA/PATTERN-TKS
					$kodeSeksi = 'POLA/PATTERN - TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 53) {
					//Dept. Produksi - Seksi POTONG AS
					$kodeSeksi = 'POTONG AS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 54) {
					//Dept. Produksi - Seksi PPC, GUDANG DAN ADMINISTRASI
					$kodeSeksi = 'PPC, GUDANG & ADMINISTRASI';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 55) {
					//Dept. Produksi - Seksi PPC TOOL MAKING
					$kodeSeksi = 'PPC TOOL MAKING';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 56) {
					//Dept. Produksi - Seksi PPIC
					$kodeSeksi = 'PPIC';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 57) {
					//Dept. Produksi - Seksi PPIC TKS
					$kodeSeksi = 'PPIC - TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 58) {
					//Dept. Produksi - Seksi PPIC, GUDANG & ADMINISTRASI-TKS
					$kodeSeksi = 'PPIC, GUDANG, ADM - TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 59) {
					//Dept. Produksi - Seksi PPIC PROTOTYPE DESAIN
					$kodeSeksi = 'PPIC PROTOTYPE DISAIN';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 60) {
					//Dept. Produksi - Seksi PRODUCTION AND INVENTORY ERP APPLICATION
					$kodeSeksi = 'PRODUCTION AND INVENTORY ERP APPLICATION';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 61) {
					//Dept. Produksi - Seksi PRODUCTION ENGINEERING
					$kodeSeksi = 'PRODUCTION ENGINEERING';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 62) {
					//Dept. Produksi - Seksi PRODUCTION ENGINEERING-DOJO
					$kodeSeksi = 'PRODUCTION ENGINEERING - DOJO';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 63) {
					//Dept. Produksi - Seksi QC DESAIN , RISET & TESTING
					$kodeSeksi = 'QC DESAIN, RISET & TESTING';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 64) {
					//Dept. Produksi - Seksi QUALITY ASSURANCE
					$kodeSeksi = 'QUALITY ASSURANCE';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 65) {
					//Dept. Produksi - Seksi QUALITY CONTROL
					$kodeSeksi = 'QUALITY CONTROL';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 66) {
					//Dept. Produksi - Seksi QUALITY CONTROL-TKS
					$kodeSeksi = 'QUALITY CONTROL - TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 67) {
					//Dept. Produksi - Seksi QUALITY ENGINEERING
					$kodeSeksi = 'QUALITY ENGINEERING';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 68) {
					//Dept. Produksi - Seksi QUALITY-TKS
					$kodeSeksi = 'QUALITY - TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 69) {
					//Dept. Produksi - Seksi REKAYASA & REBUILDING MESIN
					$kodeSeksi = 'REKAYASA & REBUILDING MESIN';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 70) {
					//Dept. Produksi - Seksi RISET & TESTING ALAT UJI
					$kodeSeksi = 'RISET & TESTING ALAT UJI';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 71) {
					//Dept. Produksi - Seksi RISET & TESTING CULTIVATOR
					$kodeSeksi = 'RISET & TESTING CULTIVATOR';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 72) {
					//Dept. Produksi - Seksi RISET & TESTING HARVESTER
					$kodeSeksi = 'RISET & TESTING HARVESTER';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 73) {
					//Dept. Produksi - Seksi RISET & TESTING PENGEMBANGAN
					$kodeSeksi = 'RISET & TESTING PENGEMBANGAN';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 74) {
					//Dept. Produksi - Seksi RISET & TESTING PPIC
					$kodeSeksi = 'RISET & TESTING PPIC';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 75) {
					//Dept. Produksi - Seksi RISET & TESTING QUICK TRUCK
					$kodeSeksi = 'RISET & TESTING QUICK TRUCK';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 76) {
					//Dept. Produksi - Seksi RISET & TESTING TRAKTOR 2W
					$kodeSeksi = 'RISET & TESTING TRAKTOR 2W';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 77) {
					//Dept. Produksi - Seksi RISET & TESTING TRAKTOR 4W
					$kodeSeksi = 'RISET & TESTING TRAKTOR 4W';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 78) {
					//Dept. Produksi - Seksi SHEET METAL-TKS
					$kodeSeksi = 'SHEET METAL - TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 79) {
					//Dept. Produksi - Seksi TOOL MAKING 1
					$kodeSeksi = 'TOOL MAKING 1';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 80) {
					//Dept. Produksi - Seksi TOOL MAKING A
					$kodeSeksi = 'TOOL MAKING A';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 81) {
					//Dept. Produksi - Seksi Tool MAKING B
					$kodeSeksi = 'TOOL MAKING B';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 82) {
					//Dept. Produksi - Seksi TOOL WARE HOUSE
					$kodeSeksi = 'TOOL WARE HOUSE';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 83) {
					//Dept. Produksi - Seksi Tool WARE HOUSE-TKS
					$kodeSeksi = 'TOOL WARE HOUSE - TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 84) {
					//Dept. Produksi - Seksi WELDING A
					$kodeSeksi = 'WELDING A';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 85) {
					//Dept. Produksi - Seksi WELDING B
					$kodeSeksi = 'WELDING B';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 86) {
					//Dept. Produksi - Seksi WELDING-TKS
					$kodeSeksi = 'WELDING-TKS';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 87) {
					//Dept. Produksi - Seksi MACHINING A
					$kodeSeksi = 'MACHINING A';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				} else if ($val == 88) {
					//Dept. Produksi - Atasan Seksi
					$kodeSeksi = '-';
					$banyak = $this->M_index->pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL);
				}
				$hasil[] = (count($banyak) >= 1) ? $banyak[0]['count'] : 0;
				if($val == 0) {
					$hasil1[] = (count($banyak1) >= 1) ? $banyak1[0]['count'] : 0;
					$hasil2[] = (count($banyak2) >= 1) ? $banyak2[0]['count'] : 0;
				}
			}
			if ($val == 0) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
				$min1 =  round((1.15 * $hasil1[0] / 100), 2);
				$minAg1 =  round((1.3 * $hasil1[0] / 100), 2);
				$min2 =  round((1.15 * $hasil2[0] / 100), 2);
				$minAg2 =  round((1.3 * $hasil2[0] / 100), 2);
			} else if ($val == 1) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 2) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 3) {
				$min =  round((1.25 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 4) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 5) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 6) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 7) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 8) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 9) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 10) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 11) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 12) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 13) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 14) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 15) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 16) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 17) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 18) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 19) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 20) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 21) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 22) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 23) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 24) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 25) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 26) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 27) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 28) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 29) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 30) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 31) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 32) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 33) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 34) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 35) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 36) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 37) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 38) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 39) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 40) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 41) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 42) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 43) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 44) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 45) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 46) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 47) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 48) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 49) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 50) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 51) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 52) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 53) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 54) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 55) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 56) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 57) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 58) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 59) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 60) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 61) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 62) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 63) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 64) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 65) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 66) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 67) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 68) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 69) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 70) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 71) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 72) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 73) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 74) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 75) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 76) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 77) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 78) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 79) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 80) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 81) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 82) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 83) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 84) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 85) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 86) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 87) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else if ($val == 88) {
				$min =  round((1.15 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			} else {
				$min =  round((1.3 * $hasil[0] / 100), 2);
				$minAg =  round((1.3 * $hasil[0] / 100), 2);
			}
			if($val == 'tabelseksi') {
				$data['nama'] = 'Pekerja Langsung & Tidak Langsung Per Seksi Dept. Produksi';
				$data['tabelseksi'] = $this->M_index->pekerjaAllSeksiDeptProduksi(date('m-d'), 'and (c.jenispekerjaan=true or c.kdpekerjaan is null)', 'and (c.jenispekerjaan=false)', $sqlPKL);
			} else {
				$data['nama'] = trim($nama[$val]);
				$data['min'] = $min;
				$data['minAg'] = $minAg;
				$data['target'] = $hasil;
				if($val == 0) {
					$data['min1'] = $min1;
					$data['minAg1'] = $minAg1;
					$data['target1'] = $hasil1;
					$data['min2'] = $min2;
					$data['minAg2'] = $minAg2;
					$data['target2'] = $hasil2;
				}
			}
		}
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('Grapic/V_DeptProd', $data);
		$this->load->view('V_Footer', $data);
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
		// if (is_null($addData[0]['denahrumah'])) {
		// 	echo 'asa';
		// }

	}

	public function TrendJumlahPekerja() {
		$user_id = $this->session->userid;
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'Trend Jumlah Pekerja';
		$data['Menu'] = 'Trend Jumlah Pekerja';

		$tahun = $this->input->post('select_tahun');
		$pkl = $this->input->post('pkl');

		if ($tahun) {
			if ($pkl) {
				$sqlPKL = "and left(noind,1) not in('L','Z','M')";
				$data['pkl'] = 'Dengan PKL, Magang & TKPW';
				$data['truePKL'] = 'true';
			} else{
				$sqlPKL = "and left(noind,1) not in('F','G','L','N','Q','L','Z','M')";
				$data['pkl'] = '';
				$data['truePKL'] = 'true';
			}

			$bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');

		}

		$data['tabel2016']=$this->M_index->getTrend('2016',"and left(noind,1) not in('F','G','L','N','Q','L','Z','M')");
		$data['tabel2017']=$this->M_index->getTrend('2017',"and left(noind,1) not in('F','G','L','N','Q','L','Z','M')");
		$data['tabel2018']=$this->M_index->getTrend('2018',"and left(noind,1) not in('F','G','L','N','Q','L','Z','M')");
		$data['tabel2019']=$this->M_index->getTrend('2019',"and left(noind,1) not in('F','G','L','N','Q','L','Z','M')");
		
		$data['tabel2016pkl']=$this->M_index->getTrend('2016',"and left(noind,1) not in('L','Z','M')");
		$data['tabel2017pkl']=$this->M_index->getTrend('2017',"and left(noind,1) not in('L','Z','M')");
		$data['tabel2018pkl']=$this->M_index->getTrend('2018',"and left(noind,1) not in('L','Z','M')");
		$data['tabel2019pkl']=$this->M_index->getTrend('2019',"and left(noind,1) not in('L','Z','M')");

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Grapic/V_Trend_Pekerja',$data);
		$this->load->view('V_Footer',$data);
	}
}