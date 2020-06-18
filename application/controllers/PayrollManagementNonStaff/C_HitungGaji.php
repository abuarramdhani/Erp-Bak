<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_HitungGaji extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->library('csvimport');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PayrollManagementNonStaff/M_hitunggaji');
		$this->load->model('PayrollManagementNonStaff/M_setelan');
		$this->load->model('PayrollManagementNonStaff/M_mastergaji');

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

	public function showList(){
		$requestData= $_REQUEST;

		// print_r($requestData);exit;

		$columns = array(
			0 => 'noind',
			1 => 'noind',
			2 => 'tgl_pembayaran',
			3 => 'noind',
			4 => 'kodesie',
			5 => 'bln_gaji',
			6 => 'thn_gaji',
			7 => 'gaji_pokok',
			8 => 'insentif_prestasi',
			9 => 'insentif_kelebihan',
			10 => 'insentif_kondite',
			11 => 'insentif_masuk_sore',
			12 => 'insentif_masuk_malam',
			13 => 'ubt',
			14 => 'upamk',
			15 => 'uang_lembur',
			16 => 'tambah_kurang_bayar',
			17 => 'tambah_lain',
			18 => 'uang_dl',
			19 => 'tambah_pajak',
			20 => 'denda_insentif_kondite',
			21 => 'pot_htm',
			22 => 'pot_lebih_bayar',
			23 => 'pot_gp',
			24 => 'pot_uang_dl',
			25 => 'jht',
			26 => 'jkn',
			27 => 'jp',
			28 => 'spsi',
			29 => 'duka',
			30 => 'pot_koperasi',
			31 => 'pot_hutang_lain',
			32 => 'pot_dplk',
			33 => 'tkp',
			34 => 'hitung_insentif_prestasi',
			35 => 'hitung_insentif_kelebihan',
			36 => 'hitung_insentif_kondite',
			37 => 'hitung_ims',
			38 => 'hitung_imm',
			39 => 'hitung_ubt',
			40 => 'hitung_upamk',
			41 => 'hitung_tambah_kurang_bayar',
			42 => 'hitung_pot_htm',
			43 => 'hitung_uang_lembur',

		);

		$data_table = $this->M_hitunggaji->getHasilHitungDatatables();
		$totalData = $data_table->num_rows();
		$totalFiltered = $totalData;

		if(!empty($requestData['search']['value'])) {
			$data_table = $this->M_hitunggaji->getHasilHitungSearch($requestData['search']['value']);
			$totalFiltered = $data_table->num_rows();

			$data_table = $this->M_hitunggaji->getHasilHitungOrderLimit($requestData['search']['value'], $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
		}
		else{
			$data_table = $this->M_hitunggaji->getHasilHitungOrderLimit($searchValue = NULL, $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
		}

		$data = array();
		$no = 1;
		$data_array = $data_table->result_array();

		$json = "{";
		$json .= '"draw":'.intval( $requestData['draw'] ).',';
		$json .= '"recordsTotal":'.intval( $totalData ).',';
		$json .= '"recordsFiltered":'.intval( $totalFiltered ).',';
		$json .= '"data":[';

		$count = count($data_array);
		$no = 1;
		foreach ($data_array as $result) {
			$count--;
			$pesanError=$result['keterangan'];
			$bulan_gaji = date('F', mktime(0, 0, 0, $result['bln_gaji'], 1));
			if ($count != 0) {
				$json .= '["'.$no.'", "<form target=\'_blank\' method=\'post\' action=\''.base_url('PayrollManagementNonStaff/ProsesGaji/HitungGaji/cetakStruk').'\'><input type=\'hidden\' name=\'txtHitungHasil\' value=\''.$result['hasil_perhitungan_id'].'\'><button type=\'submit\' class=\'btn btn-primary btn-block\'><i class=\'fa fa-print\'></i> Struk</button></form> <form target=\'_blank\' method=\'post\' action=\''.base_url('PayrollManagementNonStaff/ProsesGaji/HitungGaji/cetakCrosscheckById/'.$result['noind'].'/'.$result['bln_gaji'].'/'.$result['thn_gaji']).'\'><input type=\'hidden\' name=\'txtHitungHasil\' value=\''.$result['hasil_perhitungan_id'].'\'><button type=\'submit\' class=\'btn btn-warning btn-block\'><i class=\'fa fa-list-alt\'></i> Cross Check</button></form><a href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/HitungGaji/cetakCrosscheckById/'.$result['noind'].'/'.$result['bln_gaji'].'/'.$result['thn_gaji']).'\' >CrossCheck '.$result['noind'].' PDF</a>", "'.$pesanError.'","'.$result['tgl_pembayaran'].'", "<form class=\"detail-form\" target=\"_blank\" method=\"post\" action=\"'.base_url('PayrollManagementNonStaff/ProsesGaji/HitungGaji/detail_perhitungan').'\"><input type=\"hidden\" name=\"txtNoind\" value=\"'.$result['noind'].'\"><input type=\"hidden\" name=\"txtBulan\" value=\"'.$result['bln_gaji'].'\"><input type=\"hidden\" name=\"txtTahun\" value=\"'.$result['thn_gaji'].'\"></form><a href=\"#\" onclick=\"$(this).closest(\'td\').find(\'.detail-form\').submit()\">'.$result['noind'].'</a>", "<form class=\"detail-form\" target=\"_blank\" method=\"post\" action=\"'.base_url('PayrollManagementNonStaff/ProsesGaji/HitungGaji/detail_perhitungan').'\"><input type=\"hidden\" name=\"txtNoind\" value=\"'.$result['noind'].'\"><input type=\"hidden\" name=\"txtBulan\" value=\"'.$result['bln_gaji'].'\"><input type=\"hidden\" name=\"txtTahun\" value=\"'.$result['thn_gaji'].'\"></form><a href=\"#\" onclick=\"$(this).closest(\'td\').find(\'.detail-form\').submit()\">'.$result['employee_name'].'</a>", "'.$result['section_code'].'", "'.$result['section_name'].'", "'.$bulan_gaji.'", "'.$result['thn_gaji'].'", "'.$result['gaji_pokok'].'", "'.$result['insentif_prestasi'].'", "'.$result['insentif_kelebihan'].'", "'.$result['insentif_kondite'].'", "'.$result['insentif_masuk_sore'].'", "'.$result['insentif_masuk_malam'].'", "'.$result['ubt'].'", "'.$result['upamk'].'", "'.$result['uang_lembur'].'", "'.$result['tambah_kurang_bayar'].'", "'.$result['tambah_lain'].'", "'.$result['uang_dl'].'", "'.$result['tambah_pajak'].'", "'.$result['denda_insentif_kondite'].'", "'.$result['pot_htm'].'", "'.$result['pot_lebih_bayar'].'", "'.$result['pot_gp'].'", "'.$result['pot_uang_dl'].'", "'.$result['jht'].'", "'.$result['jkn'].'", "'.$result['jp'].'", "'.$result['spsi'].'", "'.$result['duka'].'", "'.$result['pot_koperasi'].'", "'.$result['pot_hutang_lain'].'", "'.$result['pot_dplk'].'", "'.$result['tkp'].'"],';
			}
			else{
				$json .= '["'.$no.'", "<form target=\'_blank\' method=\'post\' action=\''.base_url('PayrollManagementNonStaff/ProsesGaji/HitungGaji/cetakStruk').'\'><input type=\'hidden\' name=\'txtHitungHasil\' value=\''.$result['hasil_perhitungan_id'].'\'><button type=\'submit\' class=\'btn btn-primary btn-block\'><i class=\'fa fa-print\'></i> Struk</button></form> <form target=\'_blank\' method=\'post\' action=\''.base_url('PayrollManagementNonStaff/ProsesGaji/HitungGaji/cetakCrosscheckById/'.$result['noind'].'/'.$result['bln_gaji'].'/'.$result['thn_gaji']).'\'><input type=\'hidden\' name=\'txtHitungHasil\' value=\''.$result['hasil_perhitungan_id'].'\'><button type=\'submit\' class=\'btn btn-warning btn-block\'><i class=\'fa fa-list-alt\'></i> Cross Check</button></form><a href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/HitungGaji/cetakCrosscheckById/'.$result['noind'].'/'.$result['bln_gaji'].'/'.$result['thn_gaji']).'\' >CrossCheck '.$result['noind'].' PDF</a>", "'.$pesanError.'","'.$result['tgl_pembayaran'].'", "<form class=\"detail-form\" target=\"_blank\" method=\"post\" action=\"'.base_url('PayrollManagementNonStaff/ProsesGaji/HitungGaji/detail_perhitungan').'\"><input type=\"hidden\" name=\"txtNoind\" value=\"'.$result['noind'].'\"><input type=\"hidden\" name=\"txtBulan\" value=\"'.$result['bln_gaji'].'\"><input type=\"hidden\" name=\"txtTahun\" value=\"'.$result['thn_gaji'].'\"></form><a href=\"#\" onclick=\"$(this).closest(\'td\').find(\'.detail-form\').submit()\">'.$result['noind'].'</a>", "<form class=\"detail-form\" target=\"_blank\" method=\"post\" action=\"'.base_url('PayrollManagementNonStaff/ProsesGaji/HitungGaji/detail_perhitungan').'\"><input type=\"hidden\" name=\"txtNoind\" value=\"'.$result['noind'].'\"><input type=\"hidden\" name=\"txtBulan\" value=\"'.$result['bln_gaji'].'\"><input type=\"hidden\" name=\"txtTahun\" value=\"'.$result['thn_gaji'].'\"></form><a href=\"#\" onclick=\"$(this).closest(\'td\').find(\'.detail-form\').submit()\">'.$result['employee_name'].'</a>", "'.$result['section_code'].'", "'.$result['section_name'].'", "'.$bulan_gaji.'", "'.$result['thn_gaji'].'", "'.$result['gaji_pokok'].'", "'.$result['insentif_prestasi'].'", "'.$result['insentif_kelebihan'].'", "'.$result['insentif_kondite'].'", "'.$result['insentif_masuk_sore'].'", "'.$result['insentif_masuk_malam'].'", "'.$result['ubt'].'", "'.$result['upamk'].'", "'.$result['uang_lembur'].'", "'.$result['tambah_kurang_bayar'].'", "'.$result['tambah_lain'].'", "'.$result['uang_dl'].'", "'.$result['tambah_pajak'].'", "'.$result['denda_insentif_kondite'].'", "'.$result['pot_htm'].'", "'.$result['pot_lebih_bayar'].'", "'.$result['pot_gp'].'", "'.$result['pot_uang_dl'].'", "'.$result['jht'].'", "'.$result['jkn'].'", "'.$result['jp'].'", "'.$result['spsi'].'", "'.$result['duka'].'", "'.$result['pot_koperasi'].'", "'.$result['pot_hutang_lain'].'", "'.$result['pot_dplk'].'", "'.$result['tkp'].'"]';
			}
			$no++;
		}
		$json .= ']}';

		echo $json;
	}

	public function hitung()
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
		$this->load->view('PayrollManagementNonStaff/HitungGaji/V_hitung', $data);
		$this->load->view('V_Footer',$data);
	}

	public function getMasterGaji($noind, $kodesie){
		$getMasterGaji = $this->M_hitunggaji->getMasterGaji($noind, $kodesie);
		return $getMasterGaji;
	}

	public function getKomponenAbsensi($noind, $kodesie, $bln_gaji, $thn_gaji, $gajiPokok, $insentifMasukSore, $insentifMasukMalam, $UBT, $UPAMK){
		$getKomponenAbsensi = $this->M_hitunggaji->getKomponenAbsensi($noind, $kodesie, $bln_gaji, $thn_gaji, $gajiPokok, $insentifMasukSore, $insentifMasukMalam, $UBT, $UPAMK);

		return $getKomponenAbsensi;

	}

	public function checkLKHSeksi($noind, $bln_gaji, $thn_gaji){



		return $getKomponenAbsensi;

	}

	public function getLKHSeksi($noind, $insentifPrestasi, $bln_gaji, $thn_gaji){

		// $noind = 'A1662';
		// $bln_gaji = '1';
		// $thn_gaji = '2017';
		// $insentifPrestasi = 10000;

		$firstdate = date('Y-m-01', strtotime($thn_gaji.'-'.$bln_gaji.'-01'));
		$lastdate = date('Y-m-t', strtotime($thn_gaji.'-'.$bln_gaji.'-01'));
		$getLKHSeksi = $this->M_hitunggaji->getLKHSeksi($noind, $firstdate, $lastdate);
		// print_r($getLKHSeksi);exit;

		$begin = new DateTime(date('Y-m-01 00:00:00', strtotime($thn_gaji.'-'.$bln_gaji.'-01')));
		$end = new DateTime(date('Y-m-t 23:59:59', strtotime($thn_gaji.'-'.$bln_gaji.'-01')));

		$interval = new DateInterval('P1D');

		$p = new DatePeriod($begin, $interval ,$end);
		$harike = 0;
		$ip = 0;
		$kelebihan = 0;
		$jmlkelebihan = 0;
		$pk_kondite = array();
		$pesanerror='';
		foreach ($p as $d) {
			$pencapaian_hari_ini = 0;
			$tanggal = 0;
			$pesanerror='';
			$day = $d->format('Y-m-d');
			$cekTglDiangkat = $this->M_hitunggaji->cekTglDiangkat($noind,$day);
			foreach ($getLKHSeksi as $dataLKHSeksi) {
				if ($dataLKHSeksi['tgl'] == $day) {
					$jml_baik = $dataLKHSeksi['jml_barang'] - $dataLKHSeksi['repair'] - (1.5*$dataLKHSeksi['reject']);
					// echo $dataLKHSeksi['tgl']."<br>";
					if (date('l', strtotime($dataLKHSeksi['tgl'])) == 'Sunday') {
						$target = 0;
					}
					elseif (date('l', strtotime($dataLKHSeksi['tgl'])) == 'Friday' || date('l', strtotime($dataLKHSeksi['tgl'])) == 'Saturday') {
						$target = $dataLKHSeksi['target_jumat_sabtu'];
						$waktu_cycletime = $this->M_hitunggaji->getSetelan('cycle_time_jumat_sabtu');

					}
					else{
						$target = $dataLKHSeksi['target_senin_kamis'];
						$waktu_cycletime = $this->M_hitunggaji->getSetelan('cycle_time_senin_kamis');

					}

					/*hasil rapat 26 April :
					LKH 			Target Benda
					Waktu setting 	Target setting 		Waktu Efektif
					0 				20 					Hari Panjang : 390 & Hari Pendek 330
					10 				20 					Hari Panjang : 370 & Hari Pendek 310
					30  			20 					Hari Panjang : 370 & Hari Pendek 310

					if (0 != $dataLKHSeksi['setting_time']) {
						$waktu_cycletime=$waktu_cycletime-$dataLKHSeksi['waktu_setting'];
					}*/

					if ($dataLKHSeksi['kode_barang'] == '')  {
						$pesanerror='Kode Barang kosong di LKH.<br>';
					}


					if (($dataLKHSeksi['kode_barang'] != 'ABSEN') && ($dataLKHSeksi['kode_proses']==''))  {
						$pesanerror='Kode Proses kosong di LKH.<br>';
					}

					if (''==$target) {
						$pesanerror='Target '.$dataLKHSeksi['kode_barang'].' - '.$dataLKHSeksi['kode_proses'].' tidak ditemukan.<br>';
					}

					if ((''==$target)  && ((''!=$dataLKHSeksi['kode_barang_target_sementara']) || (''!=$dataLKHSeksi['kode_proses_target_sementara']))) {
						$pesanerror='Target sementara di LKH '.$dataLKHSeksi['kode_barang'].' - '.$dataLKHSeksi['kode_proses'].' tidak ditemukan di data target.<br>';
					}

					if (''!=trim($pesanerror)) {
						$pesanerror='Error LKH Seksi : Tanggal '.$dataLKHSeksi['tgl'].'<br>'.$pesanerror.'<br>';
					}


					if ($dataLKHSeksi['kd_brg'] == 'ABSEN') {
						$target = 0;
					}

					$targe_proposional = $target/360 * (360-$dataLKHSeksi['setting_time']);

					if ($target == 0 || $target == '') {
						$proposional_target = 0;
						$cycle_time = 0;
						$equivalent = 0;
					}
					else{

						//$waktu_cycletime = $this->M_hitunggaji->getSetelan('cycle_time');
						$proposional_target = 100/$target;
						//$cycle_time = $dataLKHSeksi['waktu_setting']/$target;
						$cycle_time = $waktu_cycletime/$target;
						if ($cycle_time == 0) {
                            $equivalent = 0;
                        }
                        else{

                        	//bila waktu setting 0 maka equivalent 0
                            if (0==$dataLKHSeksi['setting_time']) {
                                $equivalent = 0;
                            }
                            else
                            {
                                $equivalent = $dataLKHSeksi['waktu_setting']/$cycle_time;
                            }
                        }
					}

					$pencapaian = ($jml_baik + $equivalent) * $proposional_target;
					// echo $pencapaian." pencapaian<br>";
					$pencapaian_hari_ini = $pencapaian_hari_ini + $pencapaian;
					$tanggal = $dataLKHSeksi['tgl'];
				}
			} //end foreach

			if ($tanggal != 0) {
				if (strtoupper(substr($noind, 0, 1)) == 'E') {
					if ($cekTglDiangkat != 0) {
						if ($pencapaian_hari_ini >= 110) {
							$ip = $ip + 1;
							$kelebihan = $kelebihan + 10;
							$jmlkelebihan++;
							$pk_kondite[] = array(
								'tanggal' => date('j', strtotime($tanggal)),
								'PK_p' => 50,
							);
						}
						elseif ($pencapaian_hari_ini >= 100 && $pencapaian_hari_ini < 110) {
							$ip = $ip + 1;
							$kelebihan = $kelebihan + $pencapaian_hari_ini - 100;
							$pencapaian_tambahan=$pencapaian_hari_ini - 100;
							if ($pencapaian_tambahan>0)
							{
							$jmlkelebihan++;
							}

							$pk_kondite[] = array(
								'tanggal' => date('j', strtotime($tanggal)),
								'PK_p' => 50,
							);
						}
						else{
							$ip = $ip + 0;
							$kelebihan = $kelebihan + 0;
							$pk_kondite[] = array(
								'tanggal' => date('j', strtotime($tanggal)),
								'PK_p' => 5,
							);
						}
					}
					else{
						$ip = $ip + 0;
						$kelebihan = $kelebihan + 0;
						$pk_kondite[] = array(
							'tanggal' => date('j', strtotime($tanggal)),
							'PK_p' => 5,
						);
					}
				}
				else{
					if ($pencapaian_hari_ini >= 110) {
						$ip = $ip + 1;
						$kelebihan = $kelebihan + 10;
						$jmlkelebihan++;
						$pk_kondite[] = array(
							'tanggal' => date('j', strtotime($tanggal)),
							'PK_p' => 50,
						);
					}
					elseif ($pencapaian_hari_ini >= 100 && $pencapaian_hari_ini < 110) {
						$ip = $ip + 1;
						$kelebihan = $kelebihan + $pencapaian_hari_ini - 100;
						$pencapaian_tambahan=$pencapaian_hari_ini - 100;
							if ($pencapaian_tambahan>0)
							{
							$jmlkelebihan++;
							}
						$pk_kondite[] = array(
							'tanggal' => date('j', strtotime($tanggal)),
							'PK_p' => 50,
						);
					}
					else{
						$ip = $ip + 0;
						$kelebihan = $kelebihan + 0;
						$pk_kondite[] = array(
							'tanggal' => date('j', strtotime($tanggal)),
							'PK_p' => 5,
						);
					}
				}
			}
		}

		$insentif_prestasi_mask = $this->M_hitunggaji->getSetelan('insentif_prestasi_maksimal');

		$resultLKHSeksi[] = array(
			'IP' => $ip,
			'totalInsentifPrestasi' => $ip * $insentifPrestasi,
			'IK' => number_format($kelebihan, 2, '.', ''),
			'totalInsentifKelebihan' => number_format($kelebihan / 10 * ($insentif_prestasi_mask - $insentifPrestasi), 0, '.', ''),
			'pk_kondite' => $pk_kondite,
			'jmlkelebihan' => $jmlkelebihan,
			'pesanError' => $pesanerror,
		);

		// print_r($resultLKHSeksi);exit;

		return $resultLKHSeksi;
	}

	// public function getInsentifMasukSore($noind, $insentifMasukSore){}
	// public function getInsentifMasukMalam($noind, $insentifMasukMalam){
	// public function getUBT($noind, $UBT){}
	// public function getUPAMK($noind, $UPAMK){}

	//Hitung IK
	public function getInsentifKondite($noind, $kodesie, $bln_gaji, $thn_gaji, $pk_kondite){

		$firstdate = date('Y-m-01', strtotime($thn_gaji.'-'.$bln_gaji.'-01'));
		$lastdate = date('Y-m-t', strtotime($thn_gaji.'-'.$bln_gaji.'-01'));
		$getInsentifKondite = $this->M_hitunggaji->getInsentifKondite($noind, $kodesie, $firstdate, $lastdate);

		$hasil_akhir = '0';
		$golA = 0;
		$golB = 0;
		$golC = 0;
		$golD = 0;
		$golE = 0;
		foreach ($getInsentifKondite as $dataInsentifKondite) {
			$PK_p = 0;
			foreach ($pk_kondite as $pk_kon) {
				if (date('j', strtotime($dataInsentifKondite['tanggal'])) == $pk_kon['tanggal']) {
					$PK_p = $pk_kon['PK_p'];
				}
			}

			$MK = $dataInsentifKondite['mk'];
			$BKI = $dataInsentifKondite['bki'];
			$BKP = $dataInsentifKondite['bkp'];
			$TKP = $dataInsentifKondite['tkp'];
			$KB = $dataInsentifKondite['kb'];
			$KK = $dataInsentifKondite['kk'];
			$KS = $dataInsentifKondite['ks'];

			$pesanerror='';
			//checkerror
			if (''==$MK ) {
				$pesanerror=$pesanerror.'MK=kosong,';
			}
			if (''==$BKI ) {
				$pesanerror=$pesanerror.'BKI=kosong,';
			}
			if (''==$BKP ) {
				$pesanerror=$pesanerror.'BKP=kosong,';
			}
			if (''==$TKP ) {
				$pesanerror=$pesanerror.'TKP=kosong,';
			}
			if (''==$KB ) {
				$pesanerror=$pesanerror.'KB=kosong,';
			}
			if (''==$KK ) {
				$pesanerror=$pesanerror.'KK=kosong,';
			}
			if (''==$KS ) {
				$pesanerror=$pesanerror.'KS=kosong,';
			}

			if (''!=trim($pesanerror))
			{
				$pesanerror='Error Kondite Tanggal:'.$dataInsentifKondite['tanggal'].' '.$pesanerror.'<br>';
			}

			if ($MK == 'A') {$MK_p = 8; }elseif ($MK == 'B') {$MK_p = 4; }else{$MK_p = 0; }

			if ($BKI == 'A') {$BKI_p = 10; }elseif ($BKI == 'B') {$BKI_p = 5; }elseif ($BKI == 'C') {$BKI_p = 2; }else{$BKI_p = 0; }

			if ($BKP == 'A') {$BKP_p = 8; }elseif ($BKP == 'B') {$BKP_p = 4; }else{$BKP_p = 0; }

			if ($TKP == 'A') {$TKP_p = 8; }elseif ($TKP == 'B') {$TKP_p = 4; }else{$TKP_p = 0; }

			if ($KB == 'A') {$KB_p = 7; }elseif ($TKP == 'B') {$KB_p = 3; }else{$KB_p = 0; }

			if ($KK == 'A') {$KK_p = 5; }elseif ($KK == 'B') {$KK_p = 3; }elseif ($KK == 'C') {$KK_p = 1;}else{$KK_p = 0; }

			if ($KS == 'A') {$KS_p = 4; }elseif ($TKP == 'B') {$KS_p = 2; }else{$KS_p = 0; }

			$nilai = $MK_p + $BKI_p + $BKP_p + $TKP_p + $KB_p + $KK_p + $KS_p + $PK_p;

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
				$golA++;
				$setelan_name = 'insentif_kondite_1';
				// $hasil_temp = 1150;
			}
			elseif ($gol == 'B') {
				$golB++;
				$setelan_name = 'insentif_kondite_2';
				// $hasil_temp = 739;
			}
			elseif ($gol == 'C') {
				$golC++;
				$setelan_name = 'insentif_kondite_3';
				// $hasil_temp = 493;
			}
			elseif ($gol == 'D') {
				$golD++;
				$setelan_name = 'insentif_kondite_4';
				// $hasil_temp = 325;
			}
			else{
				$golE++;
				$setelan_name = 'insentif_kondite_5';
				// $hasil_temp = 0;
			}

			$hasil_temp = $this->M_hitunggaji->getSetelan($setelan_name);

			$hasil_akhir = $hasil_akhir + $hasil_temp;

		}
		$resultKondite[] = array(
			'golA' => $golA,
			'golB' => $golB,
			'golC' => $golC,
			'golD' => $golD,
			'golE' => $golE,
			'konditeAkhir' => $hasil_akhir,
			'pesanError' => $pesanerror
		);

		return $resultKondite;

	}

	//Hitung Potongan
	//
	public function getPotongan($noind, $bln_gaji, $thn_gaji){
		$getPotongan = $this->M_hitunggaji->getPotongan($noind, $bln_gaji, $thn_gaji);

		return $getPotongan;
	}

	public function doHitungGaji(){
		$this->session->unset_userdata('doHitungGaji');
		$processResultArray = array();

		$kodesie = $this->input->post('cmbKodesie');
		// $kodesie = '304020';
		$bln_gaji = $this->input->post('cmbBulan');
		$thn_gaji = $this->input->post('txtTahun');
		$tgl_bayar = $this->input->post('txtTglPembayaran');

		$dataDelete = array(
			'kodesie' => $kodesie,
			'bln_gaji' => $bln_gaji,
			'thn_gaji' => $thn_gaji,
		);

		$this->M_hitunggaji->deleteHasilHitung($dataDelete);

		$getHitungGaji = $this->M_hitunggaji->getHitungGaji($noind = '', $kodesie, $bln_gaji, $thn_gaji);

		// print_r($getHitungGaji);exit;

		$pembagi_lembur = $this->M_hitunggaji->getSetelan('pembagi_lembur');
		$pembagi_gp_bulanan = $this->M_hitunggaji->getSetelan('pembagi_gp');
		$pembagi_upamk = $this->M_hitunggaji->getSetelan('pembagi_upamk');
		$persenan_jht = $this->M_hitunggaji->getSetelan('jht');
		$persenan_jkn = $this->M_hitunggaji->getSetelan('jkn');
		$persenan_jp = $this->M_hitunggaji->getSetelan('jp');
		$insentif_prestasi_mask = $this->M_hitunggaji->getSetelan('insentif_prestasi_maksimal');

		$GP = 0;
		$IPNominal = 0;
		$IMSNominal = 0;
		$IMMNominal = 0;
		$UBTNominal = 0;
		$UPAMKNominal = 0;

		$IMSNilai = 0;
		$IMMNilai = 0;
		$UBTNilai = 0;
		$UPAMKNilai = 0;

		$jamLembur = 0;
		$jmlIzin = 0;
		$jmlMangkir = 0;
		$DL = 0;
		$Tambahan = 0;
		$KurangBayar = 0;
		$tambahanLain = 0;
		$potonganLebihBayar = 0;
		$potonganGP = 0;
		$potonganDL = 0;
		$potonganSPSI = 0;
		$potonganDuka = 0;
		$potonganKoperasi = 0;
		$potonganHutangLain = 0;
		$potonganDPLK = 0;
		$potonganTKP = 0;
		$pesanError='';

		foreach ($getHitungGaji as $dataHitungGaji) {
			$noind = $dataHitungGaji['employee_code'];
			$nama = $dataHitungGaji['employee_name'];
			$dept = $dataHitungGaji['department_name'];
			$unit = $dataHitungGaji['unit_name'];
			$sect = $dataHitungGaji['section_name'];

			$GP = $dataHitungGaji['gaji_pokok'] + 0;
			$IPNominal = $dataHitungGaji['insentif_prestasi'] + 0;
			$IMSNominal = $dataHitungGaji['insentif_masuk_sore'] + 0;
			$IMMNominal = $dataHitungGaji['insentif_masuk_malam'] + 0;
			$UBTNominal = $dataHitungGaji['ubt'] + 0;
			$UPAMKNominal = $dataHitungGaji['upamk'] + 0;

			$IMSNilai = $dataHitungGaji['IMSNilai'] + 0;
			$IMMNilai = $dataHitungGaji['IMMNilai'] + 0;
			$UBTNilai = $dataHitungGaji['UBTNilai'] + 0;
			$UPAMKNilai = $dataHitungGaji['UPAMKNilai'] + 0;

			$JHT = ($persenan_jht/100) * $GP;
			$JKN = ($persenan_jkn/100) * $GP;
			$JP = ($persenan_jp/100) * $GP;

			$jamLembur = $dataHitungGaji['jam_lembur'] + 0;
			$jmlIzin = $dataHitungGaji['jml_izin'] + 0;
			$jmlMangkir = $dataHitungGaji['jml_mangkir'] + 0;
			$DL = $dataHitungGaji['DL'] + 0;
			$Tambahan = $dataHitungGaji['tambahan'] + 0;
			$KurangBayar = $dataHitungGaji['kurang_bayar'] + 0;
			$tambahanLain = $dataHitungGaji['tambahan_lain'] + 0;
			$potonganLebihBayar = $dataHitungGaji['pot_lebih_bayar'] + 0;
			$potonganGP = $dataHitungGaji['pot_gp'] + 0;
			$potonganDL = $dataHitungGaji['pot_dl'] + 0;
			$potonganSPSI = $dataHitungGaji['potongan_spsi'] + 0;
			$potonganDuka = $dataHitungGaji['pot_duka'] + 0;
			$potonganKoperasi = $dataHitungGaji['pot_koperasi'] + 0;
			$potonganHutangLain = $dataHitungGaji['pot_hutang_lain'] + 0;
			$potonganDPLK = $dataHitungGaji['potongan_dplk'] + 0;
			$potonganTKP = $dataHitungGaji['pot_tkp'] + 0;

			$IMSTotal = $IMSNilai*$IMSNominal;
			$IMMTotal = $IMMNilai*$IMMNominal;
			$UBTTotal = $UBTNilai*$UBTNominal;
			$UPAMKTotal = $UPAMKNilai*$UPAMKNominal/$pembagi_upamk;
			$uangLembur = $jamLembur*$GP/$pembagi_lembur;
			$potonganHTM = ($jmlIzin+$jmlMangkir)*$GP/$pembagi_gp_bulanan;
			$tambahanKurangBayar = $Tambahan+$KurangBayar;

			$getLKHSeksi = $this->getLKHSeksi($noind, $IPNominal, $bln_gaji, $thn_gaji);

			$IPNilai = 0;
			$IKNilai = 0;
			$IPTotal = 0;
			$IKTotal = 0;

			foreach ($getLKHSeksi as $dataLKHSeksi) {
				$IPNilai = $dataLKHSeksi['IP'];
				$IKNilai = $dataLKHSeksi['IK'];
				$IPTotal = $dataLKHSeksi['totalInsentifPrestasi'];
				$IKTotal = $dataLKHSeksi['totalInsentifKelebihan'];
				$pk_kondite = $dataLKHSeksi['pk_kondite'];
				$pesanError = $pesanError.$dataLKHSeksi['pesanError'];
			}

			$getInsentifKondite = $this->getInsentifKondite($noind, $kodesie, $bln_gaji, $thn_gaji, $pk_kondite);

			$golA = 0;
			$golB = 0;
			$golC = 0;
			$golD = 0;
			$golE = 0;
			$KonditeTotal = 0;

			foreach ($getInsentifKondite as $dataInsentifKondite) {
				$golA = $dataInsentifKondite['golA'];
				$golB = $dataInsentifKondite['golB'];
				$golC = $dataInsentifKondite['golC'];
				$golD = $dataInsentifKondite['golD'];
				$golE = $dataInsentifKondite['golE'];
				$KonditeTotal = $dataInsentifKondite['konditeAkhir'];
				$pesanError = $pesanError.$dataInsentifKondite['pesanError'];
			}

			$terima_bersih=0;

			$terima_bersih=$GP + $IPTotal + $IKTotal + $KonditeTotal + $IMSTotal + $IMMTotal + $UBTTotal + $UPAMKTotal + $uangLembur + $tambahanKurangBayar + $tambahanLain + $DL - $potonganHTM - $potonganLebihBayar - $potonganGP - $potonganDL - ($JKN + $JHT + $JP) - $potonganKoperasi - $potonganHutangLain - $potonganDPLK - ($potonganSPSI + $potonganDuka);

			$processResultArray[] = array(
				'tgl_pembayaran' => $tgl_bayar,
				'noind' => $noind,
				'employee_name' => rtrim($nama),
				'department_name' => rtrim($dept),
				'unit_name' => rtrim($unit),
				'section_name' => rtrim($sect),
				'bln_gaji' => $bln_gaji,
				'thn_gaji' => $thn_gaji,
				'gaji_pokok' => $GP,
				'jht' => $JHT,
				'jkn' => $JKN,
				'jp' => $JP,
				'insentif_masuk_sore' => $IMSTotal,
				'insentif_masuk_malam' => $IMMTotal,
				'ubt' => $UBTTotal,
				'upamk' => $UPAMKTotal,
				'uang_lembur' => $uangLembur,
				'pot_htm' => $potonganHTM,
				'uang_dl' => $DL,
				'tambah_kurang_bayar' => $tambahanKurangBayar,
				'tambah_lain' => $tambahanLain,
				'pot_lebih_bayar' => $potonganLebihBayar,
				'pot_gp' => $potonganGP,
				'pot_uang_dl' => $potonganDL,
				'spsi' => $potonganSPSI,
				'duka' => $potonganDuka,
				'pot_koperasi' => $potonganKoperasi,
				'pot_hutang_lain' => $potonganHutangLain,
				'pot_dplk' => $potonganDPLK,
				'insentif_prestasi' => $IPTotal,
				'insentif_kelebihan' => $IKTotal,
				'insentif_kondite' => $KonditeTotal,
				'hitung_insentif_prestasi' => $IPNilai.' X '.number_format($IPNominal, 0, '', '.'),
				'hitung_insentif_kelebihan' => '('.$IKNilai.'/10) X ('.number_format($insentif_prestasi_mask, 0, '', '.').' - '.number_format($IPNominal, 0, '', '.').')',
				'hitung_insentif_kondite' => $golA.'A+'.$golB.'B+'.$golC.'C+'.$golD.'D+'.$golE.'E',
				'hitung_ims' => $IMSNilai.' X '.number_format($IMSNominal, 0, '', '.'),
				'hitung_imm' => $IMMNilai.' X '.number_format($IMMNominal, 0, '', '.'),
				'hitung_ubt' => $UBTNilai.' X '.number_format($UBTNominal, 0, '', '.'),
				'hitung_upamk' => $UPAMKNilai.' X '.number_format($UPAMKNominal, 0, '', '.').' / '.$pembagi_upamk,
				'hitung_tambah_kurang_bayar' => number_format($Tambahan, 0, '', '.').' + '.number_format($tambahanKurangBayar, 0, '', '.'),
				'hitung_pot_htm' => '('.$jmlIzin.'I + '.$jmlMangkir.'M) X ('.number_format($GP, 0, '', '.').'/'.$pembagi_gp_bulanan.')',
				'hitung_uang_lembur' => $jamLembur.' jam X ('.number_format($GP, 0, '', '.').'/'.$pembagi_lembur.')',
				'terima_bersih' => $terima_bersih,
				'keterangan' =>$pesanError,
			);

			$dataInsert = array(
				'tgl_pembayaran' => $tgl_bayar,
				'noind' => $noind,
				'kodesie' => $kodesie,
				'bln_gaji' => $bln_gaji,
				'thn_gaji' => $thn_gaji,
				'gaji_pokok' => $GP,
				'insentif_prestasi' => $IPTotal,
				'insentif_kelebihan' => $IKTotal,
				'insentif_kondite' => $KonditeTotal,
				'insentif_masuk_sore' => $IMSTotal,
				'insentif_masuk_malam' => $IMMTotal,
				'ubt' => $UBTTotal,
				'upamk' => $UPAMKTotal,
				'uang_lembur' => $uangLembur,
				'tambah_kurang_bayar' => $tambahanKurangBayar,
				'tambah_lain' => $tambahanLain,
				'uang_dl' => $DL,
				'tambah_pajak' => 0,
				'denda_insentif_kondite' => 0,
				'pot_htm' => $potonganHTM,
				'pot_lebih_bayar' => $potonganLebihBayar,
				'pot_gp' => $potonganGP,
				'pot_uang_dl' => $potonganDL,
				'jht' => $JHT,
				'jkn' => $JKN,
				'jp' => $JP,
				'spsi' => $potonganSPSI,
				'duka' => $potonganDuka,
				'pot_koperasi' => $potonganKoperasi,
				'pot_hutang_lain' => $potonganHutangLain,
				'pot_dplk' => $potonganDPLK,
				'tkp' => $potonganTKP,
				'hitung_insentif_prestasi' => $IPNilai.' X '.number_format($IPNominal, 0, '', '.'),
				'hitung_insentif_kelebihan' => '('.$IKNilai.'/10) X ('.number_format($insentif_prestasi_mask, 0, '', '.').' - '.number_format($IPNominal, 0, '', '.').')',
				'hitung_insentif_kondite' => $golA.'A+'.$golB.'B+'.$golC.'C+'.$golD.'D+'.$golE.'E',
				'hitung_ims' => $IMSNilai.' X '.number_format($IMSNominal, 0, '', '.'),
				'hitung_imm' => $IMMNilai.' X '.number_format($IMMNominal, 0, '', '.'),
				'hitung_ubt' => $UBTNilai.' X '.number_format($UBTNominal, 0, '', '.'),
				'hitung_upamk' => $UPAMKNilai.' X '.number_format($UPAMKNominal, 0, '', '.').' / '.$pembagi_upamk,
				'hitung_tambah_kurang_bayar' => number_format($Tambahan, 0, '', '.').' + '.number_format($tambahanKurangBayar, 0, '', '.'),
				'hitung_pot_htm' => '('.$jmlIzin.' ijin + '.$jmlMangkir.' mangkir) X ('.number_format($GP, 0, '', '.').'/30)',
				'hitung_uang_lembur' => $jamLembur.' jam X ('.number_format($GP, 0, '', '.').'/173)',
				'terima_bersih' => $terima_bersih,
				'keterangan' => $pesanError,
			);

			$this->M_hitunggaji->setHasilHitung($dataInsert);
		}
		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Set Hitung Gaji noind=$noind";
		$this->log_activity->activity_log($aksi, $detail);
		//

		$data['hasilHitungGaji'] = $processResultArray;
		$this->session->set_userdata('doHitungGaji', $processResultArray);
		$this->load->view('PayrollManagementNonStaff/HitungGaji/V_hasil_hitung', $data);
	}

	public function cetakStruk()
	{
		$this->checkSession();

		$resultProcess = $this->session->userdata('doHitungGaji');
		$data['noind'] = $this->input->post('noind');
		$data['HitungHasil'] = $this->input->post('txtHitungHasil');
		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Cetak Struk Hitung Gaji noind=".$data['noind'];
		$this->log_activity->activity_log($aksi, $detail);
		//
		if ($data['HitungHasil'] != '') {

			$data['strukData'] = $this->M_hitunggaji->getHitungGajiById($data['HitungHasil']);
			// $html = $this->load->view('PayrollManagementNonStaff/HitungGaji/V_struk_by_id', $data, true);
		}
		else{
			if ($data['noind'] == 'NULL') {
				$data['strukData'] = $resultProcess;
			}
			else{
				$filterData = array();
				$nomor = 0;
				foreach ($resultProcess as $row) {
					if ($row['noind'] == $data['noind']) {
						$filterData[$nomor] = array (
							'tgl_pembayaran' => $row['tgl_pembayaran'],
							'noind' => $row['noind'],
							'employee_name' => $row['employee_name'],
							'department_name' => $row['department_name'],
							'unit_name' => $row['unit_name'],
							'section_name' => $row['section_name'],
							'bln_gaji' => $row['bln_gaji'],
							'thn_gaji' => $row['thn_gaji'],
							'gaji_pokok' => $row['gaji_pokok'],
							'jht' => $row['jht'],
							'jkn' => $row['jkn'],
							'jp' => $row['jp'],
							'insentif_masuk_sore' => $row['insentif_masuk_sore'],
							'insentif_masuk_malam' => $row['insentif_masuk_malam'],
							'ubt' => $row['ubt'],
							'upamk' => $row['upamk'],
							'uang_lembur' => $row['uang_lembur'],
							'pot_htm' => $row['pot_htm'],
							'uang_dl' => $row['uang_dl'],
							'tambah_kurang_bayar' => $row['tambah_kurang_bayar'],
							'tambah_lain' => $row['tambah_lain'],
							'pot_lebih_bayar' => $row['pot_lebih_bayar'],
							'pot_gp' => $row['pot_gp'],
							'pot_uang_dl' => $row['pot_uang_dl'],
							'spsi' => $row['spsi'],
							'duka' => $row['duka'],
							'pot_koperasi' => $row['pot_koperasi'],
							'pot_hutang_lain' => $row['pot_hutang_lain'],
							'pot_dplk' => $row['pot_dplk'],
							'insentif_prestasi' => $row['insentif_prestasi'],
							'insentif_kelebihan' => $row['insentif_kelebihan'],
							'insentif_kondite' => $row['insentif_kondite'],
							'hitung_insentif_prestasi' => $row['hitung_insentif_prestasi'],
							'hitung_insentif_kelebihan' => $row['hitung_insentif_kelebihan'],
							'hitung_insentif_kondite' => $row['hitung_insentif_kondite'],
							'hitung_ims' => $row['hitung_ims'],
							'hitung_imm' => $row['hitung_imm'],
							'hitung_ubt' => $row['hitung_ubt'],
							'hitung_upamk' => $row['hitung_upamk'],
							'hitung_tambah_kurang_bayar' => $row['hitung_tambah_kurang_bayar'],
							'hitung_pot_htm' => $row['hitung_pot_htm'],
							'hitung_uang_lembur' => $row['hitung_uang_lembur'],

						);
					}
				}
				$data['strukData'] = $filterData;
			}
		}
		// print_r($data['strukData']);exit;
		$html = $this->load->view('PayrollManagementNonStaff/HitungGaji/V_struk', $data, true);
		// print_r($data['strukData']);exit;

		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf = new mPDF('utf-8', array(215,140), 0, '', 3, 3, 3, 3);
		$filename = 'Struk_Gaji'.time();
		//$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
		//$pdf->WriteHTML($stylesheet);
		$pdf->WriteHTML($html);

		$pdf->Output($filename, 'I');
	}

	public function detail_perhitungan()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Detail Perhitungan';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Hitung Gaji';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$noind = $this->input->post('txtNoind');
		$bln_gaji = $this->input->post('txtBulan');
		$thn_gaji = $this->input->post('txtTahun');

		// $noind = 'A1926';
		// $bln_gaji = 1;
		// $thn_gaji = 2017;

		$firstdate = date('Y-m-01', strtotime($thn_gaji.'-'.$bln_gaji.'-01'));
		$lastdate = date('Y-m-t', strtotime($thn_gaji.'-'.$bln_gaji.'-01'));

		$data['firstdate'] = $firstdate;
		$data['lastdate'] = $lastdate;
		//echo $data['firstdate'].' and '.$data['lastdate'];

		$data['getDetailPekerja'] = $this->M_hitunggaji->getHitungGaji($noind, $kodesie = '', $bln_gaji, $thn_gaji);
		// $data['getDetailMasterGaji'] = $this->M_hitunggaji->getDetailMasterGaji($noind);
		$data['getDetailLKHSeksi'] = $this->M_hitunggaji->getLKHSeksi($noind, $firstdate, $lastdate);
		$data['getDetailKondite'] = $this->M_hitunggaji->getInsentifKondite($noind, $kodesie = '', $firstdate, $lastdate);

		$data['pembagi_lembur'] = $this->M_hitunggaji->getSetelan('pembagi_lembur');
		$data['pembagi_gp_bulanan'] = $this->M_hitunggaji->getSetelan('pembagi_gp');
		$data['pembagi_upamk'] = $this->M_hitunggaji->getSetelan('pembagi_upamk');
		$data['persenan_jht'] = $this->M_hitunggaji->getSetelan('jht');
		$data['persenan_jkn'] = $this->M_hitunggaji->getSetelan('jkn');
		$data['persenan_jp'] = $this->M_hitunggaji->getSetelan('jp');
		$data['waktu_cycletime_jumat_sabtu'] = $this->M_hitunggaji->getSetelan('cycle_time_jumat_sabtu');
		$data['waktu_cycletime_senin_kamis'] = $this->M_hitunggaji->getSetelan('cycle_time_senin_kamis');


		$data['insentif_prestasi_mask'] = $this->M_hitunggaji->getSetelan('insentif_prestasi_maksimal');
		$data['insentif_kondite_1'] = $this->M_hitunggaji->getSetelan('insentif_kondite_1');
		$data['insentif_kondite_2'] = $this->M_hitunggaji->getSetelan('insentif_kondite_2');
		$data['insentif_kondite_3'] = $this->M_hitunggaji->getSetelan('insentif_kondite_3');
		$data['insentif_kondite_4'] = $this->M_hitunggaji->getSetelan('insentif_kondite_4');
		$data['insentif_kondite_5'] = $this->M_hitunggaji->getSetelan('insentif_kondite_5');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/HitungGaji/V_detail_perhitungan', $data);
		$this->load->view('V_Footer',$data);
	}

	public function exportperhitungan(){
		$section = $this->input->post('section');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$tgl_bayar = $this->input->post('tanggal');
		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Export Hitung Gaji tahun/bulan=$year/$month";
		$this->log_activity->activity_log($aksi, $detail);
		//

		$data['hitung'] = $this->M_hitunggaji->getHitungGajiDBF($section,$month,$year);
		$pembagi_gp = $this->M_hitunggaji->getSetelan('pembagi_gp');
		$pembagi_lembur = $this->M_hitunggaji->getSetelan('pembagi_lembur');

		$col = array(
			array("KELUAR","C",1),
			array("PAYED_ON","C",12),
			array("COA","C",28),
			array("CC","C",4),
			array("DIREKTORI","C",12),
			array("TGL_TERIMA","D"),
			array("DEPT","C",15),
			array("UNIT","C",20),
			array("BAGIAN","C",15),
			array("KODESEK","C",6),
			array("KODEBAG","C",6),
			array("SUBBAG","C",35),
			array("BANK","C",3),
			array("UPJ","C",5),
			array("NO","N",3,0),
			array("NOIND","C",5),
			array("NAMAOPR","C",20),
			array("KELAS","C",1),
			array("GOLKER","C",1),
			array("GAJIP","N",12,5),
			array("UJAM","N",5,0),
			array("BASTEK","N",5,0),
			array("ASTEK","N",6,0),
			array("BJKN","N",6,0),
			array("BJP","N",6,0),
			array("BSPSI","N",5,0),
			array("SPSI","N",5,0),
			array("HMP","N",5,2),
			array("HMS","N",5,2),
			array("HMM","N",5,2),
			array("BHMP","N",5,2),
			array("BHMS","N",5,2),
			array("BHMM","N",5,2),
			array("BDENDA","N",3,0),
			array("DENDA","N",6,0),
			array("BIP","N",6,0),
			array("BIPNJ","N",6,0),
			array("BIPT","N",6,0),
			array("BIPM","N",6,0),
			array("BIKLM","N",6,0),
			array("BIKL","N",6,0),
			array("BIK","N",6,0),
			array("BIKH","N",6,0),
			array("BIC","N",6,0),
			array("JLEMBUR","N",6,2),
			array("TAMBAHAN","N",8,0),
			array("TAMBLAIN","N",8,0),
			array("JML_UM","N",6,0),
			array("BIR","N",6,0),
			array("DUKA","N",6,0),
			array("CICIL","N",6,0),
			array("POTKOP","N",8,0),
			array("POTKEL","N",8,0),
			array("POTLAIN","N",8,0),
			array("POTLAIN2","N",8,0),
			array("BPLL","N",2,0),
			array("BP1K","N",2,0),
			array("BP1","N",2,0),
			array("BP12","N",2,0),
			array("BP2","N",2,0),
			array("BP23","N",2,0),
			array("BP3","N",2,0),
			array("BP34","N",2,0),
			array("BP4","N",2,0),
			array("BP4L","N",2,0),
			array("BOTT","N",2,0),
			array("BOP","N",2,0),
			array("BOR","N",2,0),
			array("BOK","N",2,0),
			array("BDR","N",2,0),
			array("BDPS","N",2,0),
			array("BDIK","N",2,0),
			array("BOPK","N",2,0),
			array("BDU","N",2,0),
			array("BA","N",2,0),
			array("BB","N",2,0),
			array("BC","N",2,0),
			array("BD","N",2,0),
			array("BE","N",2,0),
			array("BI","N",2,0),
			array("BABS","N",2,0),
			array("BT","N",2,0),
			array("BSKD","N",2,0),
			array("BCT","N",2,0),
			array("BHL","N",2,0),
			array("SKD","N",2,0),
			array("CT","N",2,0),
			array("HL","N",2,0),
			array("I","N",5,2),
			array("ABS","N",5,0),
			array("GAJI","N",10,0),
			array("UBT","N",8,2),
			array("IMM","N",4,0),
			array("IMS","N",4,0),
			array("TERIMA","N",10,0),
			array("TGAJI","N",8,0),
			array("TGAJI1","N",8,0),
			array("HUPAMK","N",5,2),
			array("UPAMK","N",6,0),
			array("STATUS","C",1),
			array("TGK","C","1"),
			array("PTKP","N",8,0),
			array("SPTPPH21","N",8,0),
			array("T_TAKPJK","N",8,0),
			array("TTAKPJK","N",8,0),
			array("DL","N",8,0),
			array("BLKERJA","N",2,0),
			array("KPPH","C",1),
			array("TAMBAH1","N",6,0),
			array("JAMSOSTEK","N",7,0),
			array("K_TTAKPJK","C",10),
			array("POT_DPLK","N",6,0),
			array("PPH_BRUTO","N",6,0),
			array("PPH_SUBS","N",6,0),
			array("SUBTOTAL1","N",14,2),
			array("SUBT1","N",8,0),
			array("SELSUB","N",8,0),
			array("POTONGAN","N",7,0),
			array("THPDANPOT","N",10,0),
			array("GAJIPOKOK","N",7,0),
			array("GAJIMASUK","N",7,0),
			array("LEMBUR","N",7,0),
			array("INSENTIF","N",7,0),
			array("UBTHR","N",10,0),
			array("PENG_BRUTO","N",8,0),
			array("CETAK","C",5),
			array("PKJ","C",1),
			array("URUTAN","N",3,0)

		);

		$dir = 'assets/upload/';
		$filename = 'HitungGaji-temp'.time().'.dbf';

		dbase_create($dir.$filename, $col);
		$db = dbase_open($dir.$filename, 2);

		//variabel untuk perhitungan
		$jmlSKD=0;
		$jmlIjin=0;
		$jmlABS=0;
		$jmlTerlambat=0;
		$jmlCT=0;
		$jmlmangkirgp=0;
		$jmlijingp=0;

		foreach ($data['hitung'] as $htg) {

			//hitung gaji pokok perhari

			$gaji_pokok_per_hari=$htg['gaji_pokok']/$pembagi_gp;
			$gaji_pokok_per_hari=number_format($gaji_pokok_per_hari, 5, '.', '');
			$uang_lembur_per_jam=round($htg['gaji_pokok']/$pembagi_lembur);
			$jml_hari_ip=substr($htg['hitung_insentif_prestasi'],0,strpos($htg['hitung_insentif_prestasi'],"X"));

			//ambil hari jumlah hari insentif kondite
			$hariinsentifkondite=explode("+", $htg['hitung_insentif_kondite']);
			$hariinsentifkonditeA=substr($hariinsentifkondite[0], 0, -1);
			$hariinsentifkonditeB=substr($hariinsentifkondite[1], 0, -1);
			$hariinsentifkonditeC=substr($hariinsentifkondite[2], 0, -1);
			$hariinsentifkonditeD=substr($hariinsentifkondite[3], 0, -1);
			$hariinsentifkonditeE=substr($hariinsentifkondite[4], 0, -1);

			//hitungjumlah mangkir
			$posplus = strpos($htg['hitung_insentif_kondite'], '+', 1)+1;
			$posm = strpos($htg['hitung_insentif_kondite'], 'm', 1)-1;
			$jmlmangkirgp=substr($htg['hitung_insentif_kondite'], $posplus, $posm);

			//menghitung jumlah izin
			$jmlijingp=substr_count($htg['kehadiran'],'.');

			//
			$subtotal1=$htg['gaji_pokok'] + $htg['insentif_prestasi'] + $htg['insentif_kelebihan'] + $htg['insentif_kondite'] + $htg['insentif_masuk_sore'] + $htg['insentif_masuk_malam'] + $htg['ubt'] + $htg['upamk'] + $htg['uang_lembur'] + $htg['tambah_kurang_bayar'] + $htg['tambah_lain'] + $htg['uang_dl'] - $htg['pot_htm'] - $htg['pot_lebih_bayar'] - $htg['pot_gp'];
			$subtotal1plus=$htg['gaji_pokok'] + $htg['insentif_prestasi'] + $htg['insentif_kelebihan'] + $htg['insentif_kondite'] + $htg['insentif_masuk_sore'] + $htg['insentif_masuk_malam'] + $htg['ubt'] + $htg['upamk'] + $htg['uang_lembur'] + $htg['tambah_kurang_bayar'] + $htg['tambah_lain'] + $htg['uang_dl'] - $htg['pot_htm'] - $htg['pot_lebih_bayar'] - $htg['pot_gp']+$htg['jht']+$htg['jkn']+$htg['jp'];

			$jmlIjin=$htg['IK']+$htg['IKSKP']+$htg['IKSKU']+$htg['IKSKS']+$htg['IKSKM']+$htg['IKJSP']+$htg['IKJSU']+$htg['IKJSS']+$htg['IKJSM'];
			$jmlABS=$htg['ABS'];
			$jmlTerlambat=$htg['T'];
			$jmlSKD=$htg['SKD'];
			$jmlCT=$htg['cuti'];
			$jmlharitidaktarget=$htg['jmlharilkh']-$jml_hari_ip;
			//cari hari mencapai kelebihan
			$getLKHSeksi = $this->getLKHSeksi($htg['noind'] , $htg['insentif_prestasi'] , $month, $year);

			$jmlkelebihan = 0;

			//get hmp, hms, hmm
			$gethariIP['hariip'] = $this->M_hitunggaji->getHariIP($htg['noind'],$month,$year);
			$harimp=0;
			$harims=0;
			$harimm=0;

			foreach ($gethariIP['hariip'] as $datahariIP) {

				if ($datahariIP['shift']=='HMP')
				{
					$harimp=$harimp+$datahariIP['jml'];
				}
				if ($datahariIP['shift']=='HMS')
				{
					$harims=$harimp+$datahariIP['jml'];
				}
				if ($datahariIP['shift']=='HMM')
				{
					$harimm=$harimp+$datahariIP['jml'];
				}
			}

			foreach ($getLKHSeksi as $dataLKHSeksi) {
				$jmlkelebihan = $dataLKHSeksi['jmlkelebihan'];
			}

			$jmlharihanyaip=$jml_hari_ip-$jmlkelebihan;

			$data1 = array(
				'',
				$htg['location_name'],
				'',
				'',
				'',
				$htg['tgl_pembayaran'],
				$htg['department_name'],
				$htg['unit_name'],
				$htg['section_name'],
				$htg['kodesie'],
				$htg['kodesie'],
				$htg['job_name'],
				$htg['bank_code'],
				'',
				'',
				$htg['noind'],
				$htg['employee_name'],
				$htg['kelas'],
				substr($htg['noind'], 0, 1),
				(string)$gaji_pokok_per_hari,
				(string)$uang_lembur_per_jam,
				$htg['jht'],
				'',
				$htg['jkn'],
				$htg['jp'],
				$htg['spsi'],
				'',
				number_format($htg['HMP'], 2, '.', ''),
				number_format($htg['HMS'], 2, '.', ''),
				number_format($htg['HMM'], 2, '.', ''),
				number_format($harimp, 2, '.', ''), //number_format($htg['bhmp'], 2, '.', ''),
				number_format($harims, 2, '.', ''), //number_format($htg['bhms'], 2, '.', ''),
				number_format($harimm, 2, '.', ''), //number_format($htg['bhmm'], 2, '.', ''),
				$htg['denda_insentif_kondite'],
				'',
				$htg['insentif_prestasi'],
				'',
				'',
				'',
				'',
				$htg['insentif_kelebihan'],
				$htg['insentif_kondite'],
				'',
				'',
				number_format(floatval(substr($htg['hitung_uang_lembur'], 0, 2)), 2, '.', ''),
				$htg['tambahan'],
				$htg['tambah_lain'],
				$htg['jml_UM'],
				'',
				$htg['duka'],
				$htg['cicil'],
				$htg['pot_koperasi'],
				$htg['pot_lebih_bayar'],
				$htg['pot_hutang_lain'],
				$htg['pot_gp'],
				'',
				(string)$jmlharitidaktarget,
				'',
				'',
				'',
				'',
				'',
				'',
				(string)$jmlharihanyaip,
				(string)$jmlkelebihan,
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				(string)$hariinsentifkonditeA,
				(string)$hariinsentifkonditeB,
				(string)$hariinsentifkonditeC,
				(string)$hariinsentifkonditeD,
				(string)$hariinsentifkonditeE,
				number_format($jmlIjin, 0, '.', ''),
				$htg['ABS'],
				(string)$jmlTerlambat,
				(string)$jmlSKD,
				(string)$jmlCT,
				'',
				'',
				'',
				'',
				number_format($htg['jml_izin'], 2, '.', ''),
				(string)$jmlmangkirgp,
				'',
				number_format($htg['ubt'], 2, '.', ''),
				$htg['m_insentif_masuk_malam'],
				$htg['m_insentif_masuk_sore'],
				round($htg['terima_bersih']),
				'',
				'',
				number_format($htg['HUPAMK'], 2, '.', ''),
				$htg['upamk'],
				$htg['status_pajak'],
				$htg['tanggungan_pajak'],
				$htg['ptkp'],
				'',
				'',
				'',
				$htg['uang_dl'],
				$htg['bulan_kerja'],
				$htg['tanggungan_pajak'],
				'',
				'',
				'',
				$htg['pot_dplk'],
				'',
				'',
				number_format($subtotal1, 2, '.', ''),
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				(string)$subtotal1plus,
				'',
				'',
				''

			);

			dbase_add_record($db, $data1);
		}

		header('Content-type:  application/zip');
		header('Content-Length: ' . filesize($dir.$filename));
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		readfile($dir.$filename);
		ignore_user_abort(true);
		unlink($dir.$filename);
	}

	public function clear_data(){
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Clear Data';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Hitung Gaji';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/HitungGaji/V_clear', $data);
		$this->load->view('V_Footer',$data);
	}

	public function doClearData(){
		$kodesie = $this->input->post('cmbKodesie');
		$bln_gaji = $this->input->post('cmbBulan');
		$thn_gaji = $this->input->post('txtTahun');

		$dataDelete = array(
			'kodesie' => $kodesie,
			'bln_gaji' => $bln_gaji,
			'thn_gaji' => $thn_gaji,
		);

		$this->M_hitunggaji->deleteHasilHitung($dataDelete);
		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Delete Hasil Hitung Gaji tahun/bulan=$thn_gaji/$bln_gaji kodesie=$kodesie";
		$this->log_activity->activity_log($aksi, $detail);
		//
	}

	public function cetakCrosscheckById($noind,$bln_gaji,$thn_gaji)
	{
		set_time_limit(0);
		$this->checkSession();

		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Cetak Crosscheck Hitung Gaji noind=$noind";
		$this->log_activity->activity_log($aksi, $detail);
		//
		//ambil data pekerja
		$pkj=$this->M_hitunggaji->getEmployee($noind);
		foreach ($pkj as $d) {
			$data['namapkj']=$d['employee_name'];
			$data['noinduk']=$d['employee_code'];
			$data['unit_name']=$d['unit_name'];
		}

		//ambil data kelas
		$kls=$this->M_hitunggaji->getDetailMasterGaji($noind);
		foreach ($kls as $d) {
			$klsv=$this->M_setelan->getSetelanName($d['kelas']);
			foreach ( $klsv as $klsas) {
			$data['kelas']=$klsas['setelan_value'];
			}
		}

		$firstdate = date('Y-m-01', strtotime($thn_gaji.'-'.$bln_gaji.'-01'));
		$lastdate = date('Y-m-t', strtotime($thn_gaji.'-'.$bln_gaji.'-01'));

		$data['firstdate'] = $firstdate;
		$data['lastdate'] = $lastdate;
		//echo $data['firstdate'].' and '.$data['lastdate'];
		$data['getDetailPekerja'] = $this->M_hitunggaji->getHitungGaji($noind, $kodesie = '', $bln_gaji, $thn_gaji);
		$data['getDetailLKHSeksi'] = $this->M_hitunggaji->getLKHSeksi($noind, $firstdate, $lastdate);
		$data['getDetailKondite'] = $this->M_hitunggaji->getInsentifKondite($noind, $kodesie = '', $firstdate, $lastdate);

		// print_r($data['getDetailKondite']); exit;

		$data['pembagi_lembur'] = $this->M_hitunggaji->getSetelan('pembagi_lembur');
		$data['pembagi_gp_bulanan'] = $this->M_hitunggaji->getSetelan('pembagi_gp');
		$data['pembagi_upamk'] = $this->M_hitunggaji->getSetelan('pembagi_upamk');
		$data['persenan_jht'] = $this->M_hitunggaji->getSetelan('jht');
		$data['persenan_jkn'] = $this->M_hitunggaji->getSetelan('jkn');
		$data['persenan_jp'] = $this->M_hitunggaji->getSetelan('jp');
		$data['waktu_cycletime_jumat_sabtu'] = $this->M_hitunggaji->getSetelan('cycle_time_jumat_sabtu');
		$data['waktu_cycletime_senin_kamis'] = $this->M_hitunggaji->getSetelan('cycle_time_senin_kamis');
		$data['insentif_prestasi_mask'] = $this->M_hitunggaji->getSetelan('insentif_prestasi_maksimal');


		//get hasil pengerjaan

		$html = $this->load->view('PayrollManagementNonStaff/HitungGaji/V_crosscheck', $data, true);
		//$this->load->view('PayrollManagementNonStaff/HitungGaji/V_crosscheck', $data);

		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf = new mPDF('utf-8', array(215,330), 0, '', /*margin left*/ 4, /*margin right*/ 4, /*margin top*/ 10,/*margin bottom*/  10,/*margin header*/ 5,/*margin footer*/ 5,'P');


		$pdf->SetTitle('CrossCheck '.$noind.' - '.$data['namapkj'].' - '.$bln_gaji.' - '.$thn_gaji.' - '.time().'.pdf');
		$filename = 'CrossCheck '.$noind.' - '.$data['namapkj'].' - '.$bln_gaji.' - '.$thn_gaji.' - '.time().'.pdf';

		// $stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
		//$pdf->setFooter('{PAGENO}');

		$pdf->setFooter("dicetak : {DATE j-m-Y}  ---  Hal : {PAGENO} ");
		$pdf->use_kwt = true;
		$pdf->shrink_tables_to_fit=1;
		// $pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html);
		$pdf->Output($filename, 'I');
	}

	public function downloadExcel()
    {
		$filter = $this->input->get('filter');
		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Export Excel Hitung Gaji Filter=$filter";
		$this->log_activity->activity_log($aksi, $detail);
		//
		$column_table = array('', 'tgl_pembayaran', 'noind', 'employee_name', 'section_code', 'section_name', 'bln_gaji',
			'thn_gaji', 'gaji_pokok', 'insentif_prestasi', 'insentif_kelebihan', 'insentif_kondite', 'insentif_masuk_sore',
			'insentif_masuk_malam', 'ubt', 'upamk', 'uang_lembur', 'tambah_kurang_bayar', 'tambah_lain', 'uang_dl',
			'tambah_pajak', 'denda_insentif_kondite', 'pot_htm', 'pot_lebih_bayar', 'pot_gp', 'pot_uang_dl', 'jht', 'jkn', 'jp',
			'spsi', 'duka', 'pot_koperasi', 'pot_hutang_lain', 'pot_dplk', 'tkp');
		$column_view = array('No', 'Tanggal Pembayaran', 'No Induk', 'Nama', 'Kodesie', 'Nama Seksi', 'Bulan Gaji', 'Tahun Gaji',
			'Gaji Pokok', 'Insentif Prestasi', 'Insentif Kelebihan', 'Insentif Kondite', 'Insentif Masuk Sore',
			'Insentif Masuk Malam', 'UBT', 'UPAMK', 'Uang Lembur', 'Tambah Kurang Bayar', 'Tambah Lain', 'Uang DL',
			'Tambah Pajak', 'Denda Insentif Kondite', 'Potongan HTM', 'Potongan Lebih Bayar', 'Potongan Gaji Pokok',
			'Potongan Uang DL', 'JHT', 'JKN', 'JP', 'SPSI', 'Duka', 'Potongan Koperasi', 'Potongan Hutang Lain',
			'Potongan DPLK', 'TKP');
		$data_table = $this->M_hitunggaji->getHasilHitungSearch($filter)->result_array();

		$this->load->library("Excel");
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$column = 0;

		foreach($column_view as $cv){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $cv);
			$column++;
		}

		$excel_row = 2;
		foreach($data_table as $dt){
			$excel_col = 0;
			foreach($column_table as $ct){
				if($ct == ''){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($excel_col, $excel_row, $excel_row-1);
				}else{
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($excel_col, $excel_row, $dt[$ct]);
				}
				$excel_col++;
			}
			$excel_row++;
		}

		$objPHPExcel->getActiveSheet()->setTitle('Quick ERP');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		header('Content-Disposition: attachment;filename="HitungGaji.xlsx"');
		$objWriter->save("php://output");
	}

}

/* End of file C_Kondite.php */
/* Location: ./application/controllers/PayrollManagementNonStaff/C_Kondite.php */
/* Generated automatically on 2017-03-20 13:35:14 */
