<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_IsolasiMandiri extends CI_Controller
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
		$this->load->model('MasterPekerja/Surat/IsolasiMandiri/M_isolasimandiri');
		$this->load->model('Covid/MonitoringCovid/M_monitoringcovid');
		$this->load->model('ADMCabang/M_monitoringpresensi');
		$this->load->model('Consumable/M_consumable');
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Surat Isolasi Mandiri';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Isolasi Mandiri';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/IsolasiMandiri/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Tambah($encrypted_id = FALSE){
		$atasan = array();
		if ($encrypted_id !== FALSE) {
			$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted_id);
			$plaintext_string = $this->encrypt->decode($plaintext_string);
			$data['data'] = $this->M_monitoringcovid->getPekerjaById($plaintext_string);
			$data['kepada'] = $data['data']->atasan;
			$pkj = $this->M_consumable->getDetailPekerja($data['data']->noind)->row_array();
			$ks = substr($pkj['kodesie'], 0,7);
			$kst = substr($ks, 0,1);
			// print_r($pkj);exit();
			if ($pkj['kd_jabatan'] <= 14) {
				//spv ke atas
				$atasan = $this->M_isolasimandiri->getAtasanIS($pkj['kd_jabatan'], $kst);
			}else{
				//operator
				$atasan = $this->M_isolasimandiri->getAtasanIS2($ks);
				if (empty($atasan)) {
					$ks = substr($ks, 0,4);
					$atasan = $this->M_isolasimandiri->getAtasanIS2($ks);
				}
			}
			$data['atasan'] = $atasan;
			$data['encrypted_id'] = $encrypted_id;
			$data['tembusan'] = $this->M_isolasimandiri->getTembusanD($kst);
		}
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Surat Isolasi Mandiri';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Isolasi Mandiri';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/IsolasiMandiri/V_tambah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Pekerja(){
		$key = $this->input->get('term');
		$data = $this->M_isolasimandiri->getPekerjaByKey($key);
		echo json_encode($data);
	}

	public function Preview(){
		$kepada = $this->input->get('simTo');
		$pekerja = $this->input->get('simPekerja');
		$wawancara = $this->input->get('simWawancara');
		$mulai = $this->input->get('simMulai');
		$selesai = $this->input->get('simSelesai');
		$hari = $this->input->get('simHari');
		$status = $this->input->get('simStatus');
		$dibuat = $this->session->user;
		$menyetujui = $this->input->get('simMenyetujui');
		$mengetahui = $this->input->get('simMengetahui');
		$cetak = $this->input->get('simCetak');
		$noSurat = $this->input->get('simNo');
		$tembusan = $this->input->get('simTembusan');

		$tgl = $this->input->get('tgl');
		$status = $this->input->get('st');
		$alasan = $this->input->get('al');
		// for ($i=0; $i < count($alasan); $i++) { 
		// 	if ($alasan[$i] == '') {
		// 		$alasan[$i] = 'WFO';
		// 	}
		// 	if (strpos($alasan[$i], 'WFO') || strpos($alasan[$i], 'PKJ')) {
		// 		$alasan[$i] = 'WFO';
		// 	}
		// }
		$lama1 = $tgl[0];
		$c = count($tgl);
		$lama2 = $tgl[$c-1];

		$lastx = '';
		$q = 0;
		$arr = array();
		for ($i=0; $i < (count($tgl)-1); $i++) { 
			if ($alasan[$i] != $alasan[$i+1] && (strpos($alasan[$i+1], 'WFO') !== false || strpos($alasan[$i], 'WFO') !== false || $alasan[$i+1] == 'TERHITUNG PKJ')) {
				$arr[$q][] = $i;
				$q++;
				$lastx = '1';
			}else{
				$arr[$q][] = $i;
				$lastx = '2';
			}
		}
		$qq = count($alasan);
		if (isset($alasan[$qq-2]) && $alasan[$qq-1] == $alasan[$qq-2]) {
			$arr[$q][] = $qq-1;
		}else{
			if ($lastx == '2') {
				$q++;
			}
			$arr[$q][] = $qq-1;
		}
		for ($i=0; $i < count($arr); $i++) {
			$fi = $arr[$i][0];
			$li = $arr[$i][count($arr[$i])-1];
			$awl = date('d M Y', strtotime($tgl[$fi]));
			$akh = date('d M Y', strtotime($tgl[$li]));
			$jml = date_diff(date_create($akh), date_create($awl))->format('%d')+1;
			$arr2[] = array(
				'awal' => $awl,
				'akhir' => $akh,
				'jml'	=> date_diff(date_create($akh), date_create($awl))->format('%d')+1,
				'sta'	=> $status[$fi],
				'st' => $alasan[$fi],
				);
		}
		// print_r($arr2);exit();
		//table
		$data['arr2'] = $arr2;
		$data['qq'] = date_diff(date_create($lama2), date_create($lama1))->format('%d')+1;
		$tabl = $this->load->view('MasterPekerja/Surat/IsolasiMandiri/V_Tabel',$data, true);
		// echo $tabl;exit();

		$pekerja_arr = $this->M_isolasimandiri->getDetailPekerjaByNoind($pekerja);
		$tembusanarr = $this->M_isolasimandiri->getDetailPekerjaByNoind($tembusan);
		$kepada_arr = $this->M_isolasimandiri->getDetailPekerjaByNoind($kepada);
		$dibuat_arr = $this->M_isolasimandiri->getDetailPekerjaByNoind($dibuat);
		$menyetujui_arr = $this->M_isolasimandiri->getDetailPekerjaByNoind($menyetujui);
		$mengetahui_arr = $this->M_isolasimandiri->getDetailPekerjaByNoind($mengetahui);

		if ($status == "PRM") {
			$status = "dirumahkan";
		}else{
			$status = "pekerja sakit keterangan dokter";
		}

		$surat_array = $this->M_isolasimandiri->getSuratIsolasiMandiriTemplate();
		$surat_text = $surat_array[0]['isi_surat'];
		$surat_text = str_replace("surat_isolasi_mandiri_no_surat", $noSurat, $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_kepada_nama", ucwords(strtolower($kepada_arr[0]['nama'])), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_kepada_jabatan", ucwords(strtolower($kepada_arr[0]['jabatan'])), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_pekerja_nama", ucwords(strtolower($pekerja_arr[0]['nama'])), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_pekerja_noind", $pekerja_arr[0]['noind'], $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_pekerja_unit", ucwords(strtolower($pekerja_arr[0]['unit'])), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_hari_wawancara", strftime('%A',strtotime($wawancara)), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_tanggal_wawancara", strftime('%d %B %Y',strtotime($wawancara)), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_hari_angka", $hari, $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_hari_kalimat", $this->readNumber($hari), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_tanggal_mulai", strftime('%d %B %Y',strtotime($mulai)), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_tanggal_selesai", strftime('%d %B %Y',strtotime($selesai)), $surat_text);
		// $surat_text = str_replace("surat_isolasi_mandiri_status", $status, $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_tanggal_dibuat", strftime('%d %B %Y',strtotime($cetak)), $surat_text);
		// $surat_text = str_replace("surat_isolasi_mandiri_mengetahui_nama", ucwords(strtolower($mengetahui_arr[0]['nama'])), $surat_text);
		// $surat_text = str_replace("surat_isolasi_mandiri_menyetujui_nama", ucwords(strtolower($menyetujui_arr[0]['nama'])), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_dibuat_nama", ucwords(strtolower($dibuat_arr[0]['nama'])), $surat_text);
		$surat_text = str_replace("nama_tembusan", ucwords(strtolower($tembusanarr[0]['nama'])), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_dibuat_table", $tabl, $surat_text);

		$data = array(
			'surat' => $surat_text,
			'get_' => $_GET,
			'surat_asli' => $surat_array
		);
		echo json_encode($data);
		
	}

	public function Simpan($encrypted_id = FALSE){
		if ($encrypted_id !== FALSE) {
			$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted_id);
			$plaintext_string = $this->encrypt->decode($plaintext_string);
		}

		$user = $this->session->userdata('user');
		$tanggal_cetak = $this->input->post('txtMPSuratIsolasiMandiriCetakTanggal');
		$nomor = $this->M_isolasimandiri->getLastNoSuratByTanggalCetak($tanggal_cetak);
		if (!empty($nomor)) {
			$no = ($nomor[0]['nomor'] + 1)."";
			if (strlen($no) < 3) {
				for ($i=strlen($no); $i < 3; $i++) { 
					$no = "0".$no;
				}
			}
		}else{
			$no = "001";
		}
		$bulan_romawi = array(
			1 	=> "I",
			2 	=> "II",
			3 	=> "III",
			4 	=> "IV",
			5 	=> "V",
			6 	=> "VI",
			7 	=> "VII",
			8 	=> "VIII",
			9 	=> "IX",
			10 	=> "X",
			11 	=> "XI",
			12 	=> "XII"
		);
		$no_surat = $no."/TIM-COVID19/".$bulan_romawi[intval(date('m', strtotime($tanggal_cetak)))].'/'.date('y', strtotime($tanggal_cetak));


		$pekerja = $this->input->post('slcMPSuratIsolasiMandiriPekerja');
		$alasan = $this->input->post('slcMPSuratIsolasiMandiriAlasan');

		$mulai = $this->input->post('txtMPSuratIsolasiMandiriMulaiIsolasiTanggal');
		$selesai = $this->input->post('txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal');
		$status = $this->input->post('slcMPSuratIsolasiMandiriStatus');
		if (isset($plaintext_string) && !empty($plaintext_string)) {

			$data_insert = array(
				'pekerja' 				=> $pekerja,
				'kepada' 				=> $this->input->post('slcMPSuratIsolasiMandiriTo'),
				'tembusan' 				=> $this->input->post('slcMPSuratIsolasiMandiriTembusan'),
				'dibuat' 				=> $user,
				'no_surat' 				=> $no_surat,
				'tgl_wawancara' 		=> $this->input->post('txtMPSuratIsolasiMandiriWawancaraTanggal'),
				'tgl_mulai' 			=> $mulai,
				'tgl_selesai' 			=> $selesai,
				'jml_hari' 				=> $this->input->post('txtMPSuratIsolasiMandiriJumlahHari'),
				'tgl_cetak' 			=> $this->input->post('txtMPSuratIsolasiMandiriCetakTanggal'),
				'isi_surat' 			=> str_replace("surat_isolasi_mandiri_no_surat",$no_surat,$this->input->post('txtMPSuratIsolasiMandiriSurat')),
				'created_by' 			=> $this->session->user,
				'cvd_pekerja_id' 		=> $plaintext_string
			);
		}else{
			$data_insert = array(
				'pekerja' 				=> $pekerja,
				'kepada' 				=> $this->input->post('slcMPSuratIsolasiMandiriTo'),
				'tembusan' 				=> $this->input->post('slcMPSuratIsolasiMandiriTembusan'),
				'dibuat' 				=> $user,
				'no_surat' 				=> $no_surat,
				'tgl_wawancara' 		=> $this->input->post('txtMPSuratIsolasiMandiriWawancaraTanggal'),
				'tgl_mulai' 			=> $mulai,
				'tgl_selesai' 			=> $selesai,
				'jml_hari' 				=> $this->input->post('txtMPSuratIsolasiMandiriJumlahHari'),
				'tgl_cetak' 			=> $this->input->post('txtMPSuratIsolasiMandiriCetakTanggal'),
				'isi_surat' 			=> str_replace("surat_isolasi_mandiri_no_surat",$no_surat,$this->input->post('txtMPSuratIsolasiMandiriSurat')),
				'created_by' 			=> $this->session->user
			);

		}

		//hapus datatim
		$tim = $this->input->post('tim');
		if (!empty($tim)) {
			foreach ($tim as $k) {
				$ex = explode('|', $k);
				$tglt = $ex[0];
				$wkt1 = $ex[1];
				$wkt2 = $ex[2];

				$deltim = $this->M_isolasimandiri->delTim($tglt, $wkt1, $wkt2, $pekerja);

				$arl = array(
					'wkt'	=>	date('Y-m-d H:i:s'),
					'menu'	=>	'TIM-COVID19->MonitoringCovid',
					'ket'	=>	'DELETE DATA TIM tanggal '.$tglt.' noind '.$pekerja,
					'noind'	=>	$this->session->user,
					'jenis'	=>	'DELETE DATA TIM tanggal '.$tglt.' noind '.$pekerja,
					'program'	=>	'ERP - Tim Covid 19',
					);
				$this->M_isolasimandiri->instoLog($arl);
			}
		}

		//delete presensi di tanggal mulai - selesai jika pkj
		// $dataPrez = $this->M_isolasimandiri->getDataPresensiIs($pekerja, $mulai, $selesai);
		// $arl = array(
		// 	'wkt'	=>	date('Y-m-d H:i:s'),
		// 	'transaksi'	=>	'DELETE DATA Presensi & edit presensi tanggal '.$mulai.' sampai '.$selesai.' noind '.$pekerja,
		// 	'keterangan'	=>	json_encode($dataPrez),
		// 	'program'	=>	'TIM-COVID19->MonitoringCovid',
		// 	'tgl_proses'	=>	date('Y-m-d H:i:s'),
		// 	);
		// $this->M_isolasimandiri->instoLog2($arl);
		// $del = $this->M_isolasimandiri->delEditPres($pekerja, $mulai, $selesai, 'PKJ');
		// $del2 = $this->M_isolasimandiri->delTdataPres($pekerja, $mulai, $selesai, 'PKJ');
		//insert ke tdatapresensi dan tinput_edit_presensi
		$begin = new DateTime($mulai);
		$akh = $selesai;
		$end = new DateTime(date('Y-m-d', strtotime($akh.'+1 day')));
		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);
		$y = date('Y');
		$now = date('Y-m-d H:i:s');
		$libur = array_column($this->M_monitoringpresensi->getLiburPerusahaan($y), 'tanggal');
		$shift = $this->M_isolasimandiri->getShiftIs($pekerja, $mulai, $selesai);
		$sh = array_column($shift, 'tanggal');
		$pkj = $this->M_consumable->getDetailPekerja($pekerja)->row_array();
		$arr = array();
		$arr2 = array();
		$tglPer = $this->input->post('tgl_perperiode');
		$arStatus = $this->input->post('slcMPSuratIsolasiMandiriStatus2');
		$arAlasan = $this->input->post('slcMPSuratIsolasiMandiriAlasan2');
		for ($i=0; $i < count($arStatus); $i++) { 
			if ($arStatus[$i] == 'PKJ' || $arStatus[$i] == 'PSK') {
				array_splice($arAlasan, $i, 0, '');
			}
		}
		// echo "<pre>";
		// print_r($arStatus);
		// print_r($arAlasan);exit();
		$zx = 0;
		$batas = '2020-12-03';
		foreach ($tglPer as $dt) {
			$d = $dt.' 00:00:00';
			if (!in_array($d, $sh) || $arStatus[$zx] == 'PKJ') {
				$zx++;
				continue;
			}
			$day = date('D', strtotime($d));
			if ($day == 'Sun') {
				$zx++;
				continue;
			}
			if (strtotime($dt) < strtotime($batas)) {
				$zx++;
				continue;
			}

			$tgl = $d;
			$arrx = array(
				'tanggal1'	=>	$tgl,
				'tanggal2'	=>	$now,
				'noind'	=>	$pekerja,
				'kodesie'	=>	$pkj['kodesie'],
				'masuk'	=>	'0',
				'keluar'	=>	'0',
				'medmasuk'	=>	'00:00:00',
				'medkeluar'	=>	'00:00:00',
				'kd_ket'	=>	$arStatus[$zx],
				'keterangan'	=>	'Dirumahkan',
				'susulan'	=>	false,
				'mangkir_berpoint'	=>	false,
				'opttim'	=>	false,
				'optpres'	=>	false,
				'user_'	=>	$user,
				'status'	=>	'02',
				'create_timestamp'	=>	$now,
				'appr_'	=>	$user,
				'approve_timestamp'	=>	'9999-12-12 00:00:00',
				'alasan'	=>	$arAlasan[$zx],
				);

			$arry = array(
				'tanggal'	=>	$tgl,
				'noind'	=>	$pekerja,
				'kodesie'	=>	$pkj['kodesie'],
				'masuk'	=>	'0',
				'keluar'	=>	'0',
				'kd_ket'	=>	$arStatus[$zx],
				'total_lembur'	=>	'0',
				'ket'	=>	'biasa',
				'user_'	=>	$user,
				'noind_baru'	=>	$pkj['noind_baru'],
				'create_timestamp'	=>	$now,
				'alasan'	=>	$arAlasan[$zx],
				);

			$presensi = $this->M_isolasimandiri->getdPresensi($pekerja, $tgl);
			if (!empty($presensi)) {
				$arrx['masuk'] = $presensi['masuk'];
				$arrx['keluar'] = $presensi['keluar'];
				$arrx['medmasuk'] = $presensi['masuk'];
				$arrx['medkeluar'] = $presensi['keluar'];

				$arry['masuk'] = $presensi['masuk'];
				$arry['keluar'] = $presensi['keluar'];
			}
			$arr[] = $arrx;
			$arr2[] = $arry;
			$zx++;
		}

		// print_r($arr2);
		// exit();
		if (!empty($arr)) {
			$arll = array(
					'wkt'	=>	date('Y-m-d H:i:s'),
					'menu'	=>	'TIM-COVID19->MonitoringCovid',
					'ket'	=>	$mulai.' - '.$selesai.' noind '.$pekerja,
					'noind'	=>	$this->session->user,
					'jenis'	=>	'Insert Status PRM ke tdatapresensi & tinput_edit_presensi',
					'program'	=>	'ERP - Tim Covid 19',
				);
			$this->M_isolasimandiri->instoLog($arll);

			$insertBatch = $this->M_isolasimandiri->insEditPresensi($arr);
			$insertBatch2 = $this->M_isolasimandiri->insTdataPresensi($arr2);
		}
		$insert_id = $this->M_isolasimandiri->insertSuratIsolasiMandiri($data_insert);
		if (isset($plaintext_string) && !empty($plaintext_string)) {
			$data_pekerja = array(
				'jml_hari' 			=> $this->input->post('txtMPSuratIsolasiMandiriJumlahHari'),
				'status_kondisi_id' => '1',
				'mulai_isolasi' 	=> $this->input->post('txtMPSuratIsolasiMandiriMulaiIsolasiTanggal'),
				'selesai_isolasi' 	=> $this->input->post('txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal'),
				'pic_followup'		=> $this->session->user,
				'isolasi_id' 		=> $insert_id
			);
			$this->M_monitoringcovid->updatePekerjaById($data_pekerja,$plaintext_string);
			$zx = 0;
			foreach ($tglPer as $dt) {
				$arrz[] = array(
					'isolasi_id'=> $insert_id,
					'tanggal'	=> $dt,
					'status'	=> $arStatus[$zx],
					'alasan'	=> $arAlasan[$zx],
					);
				$zx++;
			}
			if (isset($arrz) && !empty($arrz)) {
				$inswaktuIsolasi = $this->M_isolasimandiri->insWktIs($arrz);
			}
			
			$encrypted_string = $this->encrypt->encode($plaintext_string);
			$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
			redirect(base_url('Covid/MonitoringCovid/MemoIsolasi/'.$encrypted_string));
		}else{
			redirect(base_url('MasterPekerja/Surat/SuratIsolasiMandiri'));
		}
	}

	public function Hapus($id_encoded){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id_encoded);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$id = $plaintext_string;

		$this->M_isolasimandiri->deleteSuratIsolasiMandiriByID($id);

		redirect(base_url('MasterPekerja/Surat/SuratIsolasiMandiri'));
	}

	public function PDF($id_encoded){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id_encoded);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$id = $plaintext_string;
		
		$data['data'] = $this->M_isolasimandiri->getSuratIsolasiMandiriById($id);

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4', 10, "timesnewroman", 20, 20, 50, 20, 20, 5);
		$filename = 'Surat Tugas Pekerja'.$value.'.pdf';
		// $this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_pcetak', $data);
		$html = $this->load->view('MasterPekerja/Surat/IsolasiMandiri/V_cetak', $data, true);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

	public function readNumber($number){
		if (strlen($number."") <= 4) {
			$num = $number."";
			$retval = "";
			$panjang = strlen($num);
			for ($i= ($panjang - 1); $i >= 0; $i--) { 
				$index = ($panjang - 1) - $i;
				// echo $num[$i].' - '.$i.' - '.$num[$index];
				if ($i == 0) {
					if ($panjang > 1) {
						if ($num[$index - 1] != "1" && $num[$index] != "0") {
							$retval .= $this->readNumber2($num[$index]);
						}
					}else{
						$retval .= $this->readNumber2($num[$index]);
					}
				}elseif ($i == 1) {
					if ($num[$index] == "1") {
						if ($num[$index + 1] == "0") {
							$retval .= " sepuluh ";
						}elseif($num[$index + 1] == "1"){
							$retval .= " sebelas ";
						}else{
							$retval .= $this->readNumber2($num[$index + 1]);
							$retval .= " belas ";
						}
					}elseif($num[$index] == "0"){
						$retval .= "";
					}else{
						$retval .= $this->readNumber2($num[$index]);
						$retval .= " puluh ";

					}
				}elseif ($i == 2) {
					if ($num[$index] == "1") {
						$retval .= " seratus ";
					}elseif($num[$index] == "0"){
						$retval .= "";
					}else{
						$retval .= $this->readNumber2($num[$index]);
						$retval .= " ratus ";
					}
				}elseif ($i == 3) {
					if ($num[$index] == "1") {
						$retval .= " seribu ";
					}elseif($num[$index] == "0"){
						$retval .= "";
					}else{
						$retval .= $this->readNumber2($num[$index]);
						$retval .= " ribu ";

					}
				}
				// echo "<br>";
			}

			return $retval;
			// echo $retval;
		}else{
			return "max 9999";
		}
	}

	public function readNumber2($number){
		$number_array = array (
			0 => "nol",
			1 => "satu",
			2 => "dua",
			3 => "tiga",
			4 => "empat",
			5 => "lima",
			6 => "enam",
			7 => "tujuh",
			8 => "delapan",
			9 => "sembilan"
		);

		return $number_array[$number];
	}

	public function Ubah($id_encoded,$encrypted_pekerja_id = FALSE){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id_encoded);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$id = $plaintext_string;

		$data['data'] = $this->M_isolasimandiri->getSuratIsolasiMandiriById($id);
		if (!empty($data['data'])) {
			$pkj = $this->M_consumable->getDetailPekerja($data['data'][0]['pekerja'])->row_array();
			$ks = substr($pkj['kodesie'], 0,7);
			$kst = substr($ks, 0,1);
			if ($pkj['kd_jabatan'] <= 14) {
				//spv ke atas
				$atasan = $this->M_isolasimandiri->getAtasanIS($pkj['kd_jabatan'], $kst);
			}else{
				//operator
				$atasan = $this->M_isolasimandiri->getAtasanIS2($ks);
			}
			$data['tembusan'] = $this->M_isolasimandiri->getTembusanD($kst);
		}
		$data['atasan'] = $atasan;
		// print_r($data['atasan']);exit();
		$data['id_encoded'] = $id_encoded;
		$data['isolasi_id'] = $id;
		$data['encrypted_pekerja_id'] = $encrypted_pekerja_id;

		// print_r($data['pres']);exit();
		$data['pres'] = $this->M_isolasimandiri->getPresensiIsCvd($id);
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Surat Isolasi Mandiri';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Isolasi Mandiri';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/IsolasiMandiri/V_edit',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update($id_encoded,$encrypted_pekerja_id = FALSE){
		$enc = $id_encoded;
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id_encoded);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$id = $plaintext_string;
		// print_r($_POST);exit();
		$user = $this->session->userdata('user');
		$data = $this->M_isolasimandiri->getSuratIsolasiMandiriById($id)[0];
		$awal_lama = $data['tgl_mulai'];
		$akhir_lama = $data['tgl_selesai'];

		$mulai = $this->input->post('txtMPSuratIsolasiMandiriMulaiIsolasiTanggal');
		$selesai = $this->input->post('txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal');
		$status = $this->input->post('slcMPSuratIsolasiMandiriStatus');
		$pkj = $this->input->post('slcMPSuratIsolasiMandiriPekerja');
		$no_surat = $this->input->post('txtMPSuratIsolasiMandiriNoSurat');
		$alasan = $this->input->post('slcMPSuratIsolasiMandiriAlasan');
		$data_update = array(
			'pekerja' 				=> $pkj,
			'kepada' 				=> $this->input->post('slcMPSuratIsolasiMandiriTo'),
			'tembusan' 				=> $this->input->post('slcMPSuratIsolasiMandiriTembusan'),
			'dibuat' 				=> $user,
			'no_surat' 				=> $no_surat,
			'tgl_wawancara' 		=> $this->input->post('txtMPSuratIsolasiMandiriWawancaraTanggal'),
			'tgl_mulai' 			=> $mulai,
			'tgl_selesai' 			=> $selesai,
			'jml_hari' 				=> $this->input->post('txtMPSuratIsolasiMandiriJumlahHari'),
			'tgl_cetak' 			=> $this->input->post('txtMPSuratIsolasiMandiriCetakTanggal'),
			'isi_surat' 			=> str_replace("surat_isolasi_mandiri_no_surat",$no_surat,$this->input->post('txtMPSuratIsolasiMandiriSurat')),
			'created_by' 			=> $this->session->user
		);

		$this->M_isolasimandiri->updateSuratIsolasiMandiriByID($data_update,$id);

		if ($encrypted_pekerja_id !== FALSE) {
			$plaintext_pekerja_id = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted_pekerja_id);
			$plaintext_pekerja_id = $this->encrypt->decode($plaintext_pekerja_id);

			$data_pekerja = array(
				'jml_hari' 			=> $this->input->post('txtMPSuratIsolasiMandiriJumlahHari'),
				'status_kondisi_id' => '1',
				'pic_followup'		=> $this->session->user,
				'mulai_isolasi' 	=> $this->input->post('txtMPSuratIsolasiMandiriMulaiIsolasiTanggal'),
				'selesai_isolasi' 	=> $selesai
			);
			
			$this->M_monitoringcovid->updatePekerjaById($data_pekerja,$plaintext_pekerja_id);
			$baru = $selesai;
			$now = date('Y-m-d');
			$batas = '2020-12-03';
			// hapus presensi dulu
			if (strtotime($awal_lama) < strtotime($batas)) {
				$awal_lama = $batas;
			}
			if (strtotime($akhir_lama) > strtotime($batas)) {
				//log presensi
				$dataPrez = $this->M_isolasimandiri->getDataPresensiIs2($pkj, $awal_lama, $akhir_lama);
				$arl = array(
					'wkt'	=>	date('Y-m-d H:i:s'),
					'transaksi'	=>	'DELETE DATA Presensi & edit presensi tanggal '.$mulai.' sampai '.$selesai.' noind '.$pkj,
					'keterangan'	=>	json_encode($dataPrez),
					'program'	=>	'TIM-COVID19->MonitoringCovid',
					'tgl_proses'	=>	date('Y-m-d H:i:s'),
					);
				$this->M_isolasimandiri->instoLog2($arl);
				$del = $this->M_isolasimandiri->delEditPres2($pkj, $awal_lama, $akhir_lama, $data['status']);
				$del2 = $this->M_isolasimandiri->delTdataPres2($pkj, $awal_lama, $akhir_lama, $data['status']);
				$ard = array(
					'wkt'	=>	date('Y-m-d H:i:s'),
					'menu'	=>	'TIM-COVID19->MonitoringCovid',
					'ket'	=>	$awal_lama.' - '.$akhir_lama.' noind '.$pkj,
					'noind'	=>	$this->session->user,
					'jenis'	=>	'Delet Absensi Status != PKJ ke tdatapresensi & tinput_edit_presensi',
					'program'	=>	'ERP - Tim Covid 19',
					);
				$this->M_isolasimandiri->instoLog($ard);

			}
			//lalu insert kembali :)
			$tglPer = $this->input->post('tgl_perperiode');
			$arStatus = $this->input->post('slcMPSuratIsolasiMandiriStatus2');
			$arAlasan = $this->input->post('slcMPSuratIsolasiMandiriAlasan2');
			$begin = new DateTime($this->input->post('txtMPSuratIsolasiMandiriMulaiIsolasiTanggal'));
			$akh = $selesai;
			$end = new DateTime(date('Y-m-d', strtotime($akh.'+1 day')));

			$interval = DateInterval::createFromDateString('1 day');
			$period = new DatePeriod($begin, $interval, $end);
			$y = date('Y');
			$now = date('Y-m-d H:i:s');
			$libur = array_column($this->M_monitoringpresensi->getLiburPerusahaan($y), 'tanggal');
			$shift = $this->M_isolasimandiri->getShiftIs($pkj, $mulai, $selesai);
			$sh = array_column($shift, 'tanggal');
			$detailpkj = $this->M_consumable->getDetailPekerja($pkj)->row_array();
			$arr = array();
			$arr2 = array();
			$zx = 0;
			foreach ($tglPer as $dt) {
				$d = $dt.' 00:00:00';
				if (!in_array($d, $sh) || $arStatus[$zx] == 'PKJ') {
					$zx++;
					continue;
				}
				$day = date('D', strtotime($d));
				if ($day == 'Sun') {
					continue;
				}
				$tgl = $dt;
				if (strtotime($tgl) < strtotime($batas)) {
					$zx++;
					continue;
				}
				$arrx = array(
					'tanggal1'	=>	$tgl,
					'tanggal2'	=>	$now,
					'noind'	=>	$pkj,
					'kodesie'	=>	$detailpkj['kodesie'],
					'masuk'	=>	'0',
					'keluar'	=>	'0',
					'medmasuk'	=>	'00:00:00',
					'medkeluar'	=>	'00:00:00',
					'kd_ket'	=>	$arStatus[$zx],
					'keterangan'	=>	'Dirumahkan',
					'susulan'	=>	false,
					'mangkir_berpoint'	=>	false,
					'opttim'	=>	false,
					'optpres'	=>	false,
					'user_'	=>	$user,
					'status'	=>	'02',
					'create_timestamp'	=>	$now,
					'appr_'	=>	$user,
					'approve_timestamp'	=>	'9999-12-12 00:00:00',
					'alasan'	=>	$arAlasan[$zx],
					);

				$arry = array(
					'tanggal'	=>	$tgl,
					'noind'	=>	$pkj,
					'kodesie'	=>	$detailpkj['kodesie'],
					'masuk'	=>	'0',
					'keluar'	=>	'0',
					'kd_ket'	=>	$arStatus[$zx],
					'total_lembur'	=>	'0',
					'ket'	=>	'biasa',
					'user_'	=>	$user,
					'noind_baru'	=>	$detailpkj['noind_baru'],
					'create_timestamp'	=>	$now,
					'alasan'	=>	$arAlasan[$zx],
					);

				$presensi = $this->M_isolasimandiri->getdPresensi($pkj, $tgl);
				if (!empty($presensi)) {
					$arrx['masuk'] = $presensi['masuk'];
					$arrx['keluar'] = $presensi['keluar'];
					$arrx['medmasuk'] = $presensi['masuk'];
					$arrx['medkeluar'] = $presensi['keluar'];

					$arry['masuk'] = $presensi['masuk'];
					$arry['keluar'] = $presensi['keluar'];
				}
				$arr[] = $arrx;
				$arr2[] = $arry;
				$zx++;
			}
			// print_r($arr2);
			// exit();
			if (!empty($arr)) {
				$insertBatch = $this->M_isolasimandiri->insEditPresensi($arr);
				$insertBatch2 = $this->M_isolasimandiri->insTdataPresensi($arr2);
				$arll = array(
					'wkt'	=>	date('Y-m-d H:i:s'),
					'menu'	=>	'TIM-COVID19->MonitoringCovid',
					'ket'	=>	$mulai.' - '.$selesai.' noind '.$pkj,
					'noind'	=>	$this->session->user,
					'jenis'	=>	'Insert Status '.$status.' ke tdatapresensi & tinput_edit_presensi',
					'program'	=>	'ERP - Tim Covid 19',
					);
				$this->M_isolasimandiri->instoLog($arll);
			}

			//hapus datatim
			$tim = $this->input->post('tim');
			if (!empty($tim)) {
				foreach ($tim as $k) {
					$ex = explode('|', $k);
					$tglt = $ex[0];
					$wkt1 = $ex[1];
					$wkt2 = $ex[2];

					$deltim = $this->M_isolasimandiri->delTim($tglt, $wkt1, $wkt2, $pekerja);

					$arl = array(
						'wkt'	=>	date('Y-m-d H:i:s'),
						'menu'	=>	'TIM-COVID19->MonitoringCovid',
						'ket'	=>	'DELETE DATA TIM tanggal '.$tglt.' noind '.$pekerja,
						'noind'	=>	$this->session->user,
						'jenis'	=>	'DELETE DATA TIM tanggal '.$tglt.' noind '.$pekerja,
						'program'	=>	'ERP - Tim Covid 19',
						);
					$this->M_isolasimandiri->instoLog($arl);
				}
			}

			//delete dulu lah cuyy
			$del = $this->M_monitoringcovid->delwktIs($id);
			//reinsert cvd_waktu_isolasi
			$zx = 0;
			foreach ($tglPer as $dt) {
				if ($arStatus[$zx] == 'PKJ' || $arStatus[$zx] == 'PSK') {
					$als = '';
				}else{
					$als = $arAlasan[$zx];
				}
				$arrz[] = array(
					'isolasi_id'=> $id,
					'tanggal'	=> $dt,
					'status'	=> $arStatus[$zx],
					'alasan'	=> $als,
					);
				$zx++;
			}
			if (isset($arrz) && !empty($arrz)) {
				$inswaktuIsolasi = $this->M_isolasimandiri->insWktIs($arrz);
			}

			$pkjId = $this->M_isolasimandiri->getpkjID($id);
			$encrypted_string = $this->encrypt->encode($pkjId);
			$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
			redirect(base_url('Covid/MonitoringCovid/MemoIsolasi/'.$encrypted_string));
		}else{
			redirect(base_url('MasterPekerja/Surat/SuratIsolasiMandiri'));
		}
	}

	public function ListPekerja(){
		$list = $this->M_isolasimandiri->user_table();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $key) {
			$no++;
			$encrypted_string = $this->encrypt->encode($key->id_isolasi_mandiri);
			$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
			$row = array();
			$row[] = $no;
			$row[] = '	<a href="'.site_url('MasterPekerja/Surat/SuratIsolasiMandiri/Ubah/'.$encrypted_string).'" class="btn btn-primary">Edit</a>
						<a href="'.site_url('MasterPekerja/Surat/SuratIsolasiMandiri/PDF/'.$encrypted_string).'" target="_blank" class="btn btn-warning">PDF</a>
						<a href="'.site_url('MasterPekerja/Surat/SuratIsolasiMandiri/Hapus/'.$encrypted_string).'" class="btn btn-danger" onclick="return confirm(\'apakah anda yakin ingin menghapus data ini ?\')">Delete</a>';
			$row[] = $key->no_surat;
			$row[] = $key->pekerja;
			$row[] = $key->tgl_wawancara;
			$row[] = $key->tgl_cetak;

			$data[] = $row;
		}

		$output = array(
			'draw' => $_POST['draw'],
			'recordsTotal' =>$this->M_isolasimandiri->count_all(),
			'recordsFiltered' => $this->M_isolasimandiri->count_filtered(),
			'data' => $data
		);

		echo json_encode($output);
	}

	public function cekTinput()
	{
		//untuk alert perubahan
		// print_r($_GET);
		$awal_lama = $this->input->get('awal_lama');
		$awal_baru = $this->input->get('awal_baru');
		$akhir_lama = $this->input->get('akhir_lama');
		$akhir_baru = $this->input->get('akhir_baru');
		$pkj = $this->input->get('pkj');
		$text = array();
		$now = date('Y-m-d');

		//jika tanggal awal berubah
		if (strtotime($awal_baru) > strtotime($awal_lama) && strtotime($awal_lama) <= strtotime($now)) {
			if (strtotime($awal_baru) >= strtotime($akhir_lama)) {
				$sampai1 = $akhir_lama;
			}elseif (strtotime($awal_baru) >= strtotime($now)) {
				$sampai1 = $now;
			}else{
				$sampai1 = $awal_baru;
			}

			$earlier = new DateTime($awal_lama);
			$later = new DateTime($sampai1);

			$diff = $later->diff($earlier)->format("%a");
			if ($diff > 1) {
				$as = ' s.d '.date('d M Y', strtotime($sampai1.'-1 day'));
			}else{
				$as = '';
			}
			$text[] = '*MOHON MELAKUKAN PERUBAHAN DATA ABSENSI PEKERJA PADA TANGGAL '.date('d M Y', strtotime($awal_lama)).$as;
		}

		//jika tanggal lama berubah
		if (strtotime($akhir_baru) < strtotime($now) && strtotime($akhir_baru) < strtotime($akhir_lama)) {
			if (strtotime($akhir_lama) > strtotime($now)) {
				$sampai2 = $now;
			}else{
				$sampai2 = $akhir_baru;
			}
			$earlier = new DateTime($akhir_baru);
			$later = new DateTime($sampai2);

			$diff = $later->diff($earlier)->format("%a");
			if ($diff > 1) {
				$as = ' s.d '.date('d M Y', strtotime($sampai2));
			}else{
				$as = '';
			}
			$text[] = '*MOHON MELAKUKAN PERUBAHAN DATA ABSENSI PEKERJA PADA TANGGAL '.date('d M Y', strtotime($akhir_baru.'+1 day')).$as;
		}

		$text = implode(' dan ',$text);
		
		echo $text;
	}

	public function cekTimIs()
	{
		//alert jika ada data tim di dalam periode
		$pkj = $this->input->get('pkj');
		$awal = $this->input->get('awal');
		$akhir = $this->input->get('akhir');

		$tim = $this->M_isolasimandiri->getTimIs($pkj, $awal, $akhir);

		if (empty($tim)) {
			$txt = '';
		}else{
			$txt = '<label style="color:red;">* Pekerja Memiliki Data TIM pada periode tersebut. Checklist Data Tim yang ingin di hapus</label><br>';
			foreach ($tim as $key) {
				$val = $key['tanggal'].'|'.$key['masuk'].'|'.$key['keluar'];
				$tgl = date('d M Y', strtotime($key['tanggal']));
				$txt .= '<label><input type="checkbox" name="tim[]" value="'.$val.'" /> '.$tgl.' ('.$key['point'].')</label><br>';
			}
		}
		echo $txt;
	}

	public function getIsolasiRow()
	{
		$mulai = $this->input->get('mulai');
		$selesai = $this->input->get('selesai');
		$pkj = $this->input->get('pkj');
		$isolasi_id = $this->input->get('isolasi_id');
		if ($isolasi_id != '') {
			$cvdWktIs = $this->M_isolasimandiri->getPresensiIsCvd($isolasi_id);
			$arTgl = array_column($cvdWktIs, 'tanggal');
		}else{
			$arTgl = array();
		}

		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod(new DateTime($mulai), $interval, new DateTime($selesai.'+1 day'));
		$txt = '';
		$shift = $this->M_isolasimandiri->getShiftIs($pkj, $mulai, $selesai);
		// print_r($shift);exit();
		$llibur = $this->M_isolasimandiri->getTliburIs($mulai, $selesai);
		$sh = array_column($shift, 'tanggal');
		$sl = array_column($llibur, 'tanggal');
		$gakadaShift = array();
		foreach ($period as $k) {
			$d = $k->format("Y-m-d").' 00:00:00';
			$d2 = $k->format("Y-m-d");
			$hari = date('D', strtotime($d2));
			if($hari == 'Sun')
			{
				continue;
			}
			if (in_array($d, $sh) || in_array($d, $sl)) {
				continue;
			}
			$gakadaShift[] = $d2;
		}
		$xc = 0;
		foreach ($period as $k) {
			$d = $k->format("Y-m-d").' 00:00:00';
			if (!in_array($d, $sh)) {
				// continue;
			}
			$tgl = $k->format("Y-m-d");

			if ($xc == 0) {
				$sama = '<td>
								<label><input type="checkbox" id="cvd_samastatus"/> Samakan Status</label>
								<br>
								<label><input type="checkbox" id="cvd_samaalasan"/> Samakan Alasan</label>
							</td>';
			}else{
				$sama = '<td></td>';
			}
			if (in_array($tgl, $arTgl)) {
				$idi = array_search($tgl, $arTgl);
				$a = ''; $b = ''; $c = ''; $d = ''; $e = ''; $f = ''; $g = ''; $h = ''; $i = ''; $j = ''; $k = ''; $l = ''; $m = ''; $n = ''; $o = ''; $p = ''; $q = ''; $r = ''; $s = ''; $t = ''; $u = ''; $v = ''; $w = ''; $x = '';
				$status = $cvdWktIs[$idi]['status'];
				$alasan = $cvdWktIs[$idi]['alasan'];
				if ($status == 'PMR') {
					$a = 'selected';
				}elseif ($status == 'PSK') {
					$b = 'selected';
				}elseif ($status == 'PKJ') {
					$c = 'selected';
				}

				if ($alasan == 'ISOLASI DIRI - DL - WFO') {
					$d = 'selected';
				}elseif ($alasan == 'ISOLASI DIRI - DL - WFH') {
					$e = 'selected';
				}elseif ($alasan == 'ISOLASI DIRI - DL - NON WFH') {
					$f = 'selected';
				}elseif ($alasan == 'TERHITUNG PKJ') {
					$g = 'selected';
				}elseif ($alasan == 'ISOLASI DIRI - TERDAMPAK - WFO') {
					$h = 'selected';
				}elseif ($alasan == 'ISOLASI DIRI - TERDAMPAK - WFH') {
					$i = 'selected';
				}elseif ($alasan == 'ISOLASI DIRI - TERDAMPAK - NON WFH') {
					$j = 'selected';
				}elseif ($alasan == 'ISOLASI DIRI - NON DL - WFO') {
					$k = 'selected';
				}elseif ($alasan == 'ISOLASI DIRI - NON DL - WFH') {
					$l = 'selected';
				}elseif ($alasan == 'ISOLASI DIRI - NON DL - NON WFH') {
					$m = 'selected';
				}elseif ($alasan == 'ISOLASI DIRI - SENGAJA - WFO') {
					$n = 'selected';
				}elseif ($alasan == 'ISOLASI DIRI - SENGAJA - WFH') {
					$o = 'selected';
				}elseif ($alasan == 'ISOLASI DIRI - SENGAJA - NON WFH') {
					$p = 'selected';
				}elseif ($alasan == 'ISOLASI DIRI - PENYEBAB - WFO') {
					$q = 'selected';
				}elseif ($alasan == 'ISOLASI DIRI - PENYEBAB - WFH') {
					$r = 'selected';
				}elseif ($alasan == 'ISOLASI DIRI - PENYEBAB - WFH') {
					$s = 'selected';
				}elseif ($alasan == 'NON ISOLASI DIRI - NON DL -WFH') {
					$t = 'selected';
				}elseif ($alasan == 'NON ISOLASI DIRI - NON DL - NON WFH') {
					$u = 'selected';
				}
				$txt .= '<tr>
							<td style="text-align: center;">'.$tgl.'
							<input hidden name="tgl_perperiode[]" value="'.$tgl.'">
							</td>
							<td>
								<select class="select2 cvd_status_table" data-placeholder="Status Isolasi Mandiri" name="slcMPSuratIsolasiMandiriStatus2[]" id="slcMPSuratIsolasiMandiriStatus" style="width: 100%" required>
									<option '.$a.'>PRM</option>
									<option '.$b.'>PSK</option>
									<option '.$c.'>PKJ</option>
								</select>
							</td>
							<td>
								<select class="select2 cvd_alasan_table" data-placeholder="Alasan" name="slcMPSuratIsolasiMandiriAlasan2[]" id="slcMPSuratIsolasiMandiriAlasan" style="width: 100%" required>
									<option></option>
									<option '.$d.'>ISOLASI DIRI - DL - WFO</option>
									<option '.$e.'>ISOLASI DIRI - DL - WFH</option>
									<option '.$f.'>ISOLASI DIRI - DL - NON WFH</option>
									<option '.$g.'>TERHITUNG PKJ</option>
									<option '.$h.'>ISOLASI DIRI - TERDAMPAK - WFO</option>
									<option '.$i.'>ISOLASI DIRI - TERDAMPAK - WFH</option>
									<option '.$j.'>ISOLASI DIRI - TERDAMPAK - NON WFH</option>
									<option '.$k.'>ISOLASI DIRI - NON DL - WFO</option>
									<option '.$l.'>ISOLASI DIRI - NON DL - WFH</option>
									<option '.$m.'>ISOLASI DIRI - NON DL - NON WFH</option>
									<option '.$n.'>ISOLASI DIRI - SENGAJA - WFO</option>
									<option '.$o.'>ISOLASI DIRI - SENGAJA - WFH</option>
									<option '.$p.'>ISOLASI DIRI - SENGAJA - NON WFH</option>
									<option '.$q.'>ISOLASI DIRI - PENYEBAB - WFO</option>
									<option '.$r.'>ISOLASI DIRI - PENYEBAB - WFH</option>
									<option '.$s.'>ISOLASI DIRI - PENYEBAB - NON WFH</option>
								</select>
							</td>
							'.$sama.'
						</tr>';
			}else{
				$txt .= '<tr>
							<td style="text-align: center;">'.$tgl.'
							<input hidden name="tgl_perperiode[]" value="'.$tgl.'">
							</td>
							<td>
								<select class="select2 cvd_status_table" data-placeholder="Status Isolasi Mandiri" name="slcMPSuratIsolasiMandiriStatus2[]" id="slcMPSuratIsolasiMandiriStatus" style="width: 100%" required>
									<option>PRM</option>
									<option>PSK</option>
									<option>PKJ</option>
								</select>
							</td>
							<td>
								<select class="select2 cvd_alasan_table" data-placeholder="Alasan" name="slcMPSuratIsolasiMandiriAlasan2[]" id="slcMPSuratIsolasiMandiriAlasan" style="width: 100%" required>
									<option></option>
									<option>ISOLASI DIRI - DL - WFO</option>
									<option>ISOLASI DIRI - DL - WFH</option>
									<option>ISOLASI DIRI - DL - NON WFH</option>
									<option>TERHITUNG PKJ</option>
									<option>ISOLASI DIRI - TERDAMPAK - WFO</option>
									<option>ISOLASI DIRI - TERDAMPAK - WFH</option>
									<option>ISOLASI DIRI - TERDAMPAK - NON WFH</option>
									<option>ISOLASI DIRI - NON DL - WFO</option>
									<option>ISOLASI DIRI - NON DL - WFH</option>
									<option>ISOLASI DIRI - NON DL - NON WFH</option>
									<option>ISOLASI DIRI - SENGAJA - WFO</option>
									<option>ISOLASI DIRI - SENGAJA - WFH</option>
									<option>ISOLASI DIRI - SENGAJA - NON WFH</option>
									<option>ISOLASI DIRI - PENYEBAB - WFO</option>
									<option>ISOLASI DIRI - PENYEBAB - WFH</option>
									<option>ISOLASI DIRI - PENYEBAB - NON WFH</option>
								</select>
							</td>
							'.$sama.'
						</tr>';
			}
			$xc++;
		}
		if (!empty($gakadaShift)) {
			$txt .= '<tr>
			<td colspan="4">
			<label style="color: red;">*Pekerja tidak memiliki Shift pada tanggal : '.implode(', ', $gakadaShift).'</label>
			</td>
			</tr>';
		}
		echo $txt;
	}

	public function cekPresensiIs()
	{
		$pkj = $this->input->get('pkj');
		$awal = $this->input->get('awal');
		$akhir = $this->input->get('akhir');

		$pres = $this->M_isolasimandiri->getDataPresensiIs($pkj, $awal, $akhir);
		$tgl = array_column($pres, 'tanggal');
		function maparr($d)
		{
			return substr($d, 0,10);
		}
		$tgl = array_map("maparr",$tgl);
		$imtgl = implode(', ', $tgl);
		if (!empty($pres)) {
			$txt = '<label style="color:red;">* Pekerja Tersebut memiliki Presensi pada tanggal : '.$imtgl.'</label>';
		}else{
			$txt = '';
		}

		echo $txt;
	}
}