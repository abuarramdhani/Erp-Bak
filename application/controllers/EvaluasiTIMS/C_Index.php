<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*
*/
class C_Index extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('personalia');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('EvaluasiTIMS/M_index');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = '';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function InputJenisPenilaian()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'Setup';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Jenis Penilaian';
		$data['SubMenuTwo'] = '';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_Jenis_penilaian',$data);
		$this->load->view('V_Footer',$data);
	}

	public function JenisPenilaian()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'Setup';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Jenis Penilaian';
		$data['SubMenuTwo'] = '';

		$data['listJp'] = $this->M_index->listJp();
      	// print_r($data['listJp']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_Jenis_penilaian_list',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SubmitJenisPenilaian()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$noind = $this->session->user;
		$jp = strtoupper($this->input->post('et_jenis_penilaian'));
		$data = array(
			'jenis_penilaian'	=>	$jp,
			'created_by'		=>	$noind,
			'created_date'		=>	date('Y-m-d H:i:s'),
			);
		$inputjp = $this->M_index->inputjp($data);
		if ($inputjp) {
			//insert to t_log
	            $aksi = 'EVALUASI TIMS';
	            $detail = 'ADD JENIS PENILAIAN '.$jp;
	            $this->log_activity->activity_log($aksi, $detail);
	        //
			redirect('EvaluasiTIMS/Setup/JenisPenilaian');
		}
	}

	public function StandarPenilaian()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'Setup';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Standar Penilaian';
		$data['SubMenuTwo'] = '';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_Standar_penilaian',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getPenilaian()
	{
		$term = strtoupper($this->input->get('s'));
		$listJp = $this->M_index->listJp2($term);

		echo json_encode($listJp);
	}
	public function getPenilaian2()
	{
		$term = $this->input->post('s');
		$listJp = $this->M_index->listJp3($term);

		echo json_encode($listJp);
	}

	public function SubmitStandarPenilaian()
	{
		$noind = $this->session->user;
		$id = $this->input->post('et_select_jp');
		$t = $this->input->post('et_input_t');
		$tim = $this->input->post('et_input_tim');
		$tims = $this->input->post('et_input_tims');
		$data = array(
			'std_m'		=>	$t,
			'std_tim'	=>	$tim,
			'std_tims'	=>	$tims,
			'last_update_date'	=>	date('Y-m-d H:i:s'),
			'last_update_by'	=>	$noind,
			);

		$updateJp = $this->M_index->updateJp($id, $data);
		if ($updateJp) {
			//insert to t_log
	            $aksi = 'EVALUASI TIMS';
	            $detail = 'UPDATE JENIS PENILAIAN ID='.$id;
	            $this->log_activity->activity_log($aksi, $detail);
	        //
			redirect('EvaluasiTIMS/Setup/JenisPenilaian');
		}
	}

	public function Harian()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'TIMS Harian';
		$data['Menu'] = 'TIMS Harian';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$val = '0';
		$jb = array('jenis_penilaian'	=>	'');
		$a = '';
		$jp = '';
		$lh = $this->input->post('et_s_harian');
		if (!empty($lh)) {
			$jp = $this->M_index->listJp3($lh);
			$t = $jp[0]['std_m'];
			$tim = $jp[0]['std_tim'];
			$tims = $jp[0]['std_tims'];
			$val = '1';
			$a = array();
			$vali = $this->M_index->getVal2($lh);
			if ($lh == '1') {
				$listHarian = $this->M_index->listHarian($t, $tim, $tims, $vali);
			}elseif ($lh == '2') {
				$listHarian = $this->M_index->listHarian2($t, $tim, $tims, $vali);
			}
			$s = 0;
			foreach ($listHarian as $key => $subkey) {
				if($subkey['pred_lolos'] == 'LOLOS' || $subkey['pred_lolos'] == 'LEBIH DARI 2 TAHUN'){
					unset($listHarian[$key]);
				}
				$s++;
			}
			$listDept = array('KEUANGAN', 'PEMASARAN', 'PERSONALIA', 'PRODUKSI');
			$last_col = array_column($listHarian, 'count', 'dept');
			foreach ($listDept as $key) {
				if (array_key_exists($key, $last_col)) {
					$a[] = $last_col[$key];
				}else{
					$a[] = '0';
				}
			}
		}
		$data['val'] = $val;
		$data['jumlah'] = $a;
		$data['jp'] = $jp;
		$data['idi'] = $lh;
		$data['LamaEvaluasi'] = $this->M_index->getVal();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_TIMS_harian',$data);
		$this->load->view('V_Footer',$data);
	}

	public function LihatHarian($a = false, $b = false)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'TIMS Harian';
		$data['Menu'] = 'TIMS Harian';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$vali = $this->M_index->getVal2($a);
		if ($b == '1') {
			$b = 'KEUANGAN';
		}elseif ($b == '2') {
			$b = 'PEMASARAN';
		}elseif ($b == '3') {
			$b = 'PERSONALIA';
		}else{
			$b = 'PRODUKSI';
		}
		$jp = $this->M_index->listJp3($a);
		$t = $jp[0]['std_m'];
		$tim = $jp[0]['std_tim'];
		$tims = $jp[0]['std_tims'];

		if ($a == '1') {
			$data['listLt'] = $this->M_index->listLt($b, $t, $tim, $tims, $vali);
		}elseif ($a == '2') {
			$data['listLt'] = $this->M_index->listLt2($b, $t, $tim, $tims, $vali);
		}
		$data['jp'] = $jp[0]['jenis_penilaian'];
		$data['jpi'] = $a;
		$data['dept'] = 'Departemen '.$b;
		$data['LamaEvaluasi'] = $this->M_index->getVal();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_TIMS_harian_lihat',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Bulanan()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'TIMS Bulanan';
		$data['Menu'] = 'TIMS Bulanan';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['LamaEvaluasi'] = $this->M_index->getVal();

		$pr = $this->input->post('et_periode');
		$jenisPenilaian = $this->input->post('et_jenis_jp');
		$pilih = $this->input->post('evt_pilih');
		$s = '';
		$namaPilihan = '';
		$val = '0';
		$data['jp'] = '';
		$listSeksi = '';
		if (!empty($pr) || !empty($jenisPenilaian)) {
			$bagian = $this->input->post('evt_departemen');
			if (!empty($bagian)) {
				$bagian = array_map('strtoupper', $bagian);
			}
			$val = '1';
			$jp = $this->M_index->listJp3($jenisPenilaian);
			$t = $jp[0]['std_m'];
			$tim = $jp[0]['std_tim'];
			$tims = $jp[0]['std_tims'];
			$data['jp'] = $jp[0]['jenis_penilaian'];
			$data['jpi'] = $jenisPenilaian;
			$vali = $this->M_index->getVal2($jenisPenilaian);

			$in = '';
			$hitung = count($bagian);
			for ($i=0; $i < $hitung; $i++) {
				if ($i == ($hitung-1)) {
					$in .= "'".$bagian[$i]."'";
					$listSeksi .= $bagian[$i];
				}else{
					$in .= "'".$bagian[$i]."', ";
					$listSeksi .= $bagian[$i].', ';
				}
			}
			if ($pilih == '1') {
				$s = "upper(trim(et.dept)) in ($in)";
				$namaPilihan = 'Departemen';
			}elseif ($pilih == '2') {
				$s = "upper(trim(et.bidang)) in ($in)";
				$namaPilihan = 'Bidang';
			}elseif ($pilih == '3') {
				$s = "upper(trim(et.unit)) in ($in)";
				$namaPilihan = 'Unit';
			}elseif ($pilih == '4') {
				$s = "upper(trim(et.seksi)) in ($in)";
				$namaPilihan = 'Seksi';
			}else{
				$s = "et.seksi like '%%'";
			}

			$tanggal = explode(' - ', $pr);
			$tgl1 = $tanggal[0];
			$tgl2 = $tanggal[1];
			if ($jenisPenilaian == '1') {
				$getlist = $this->M_index->listBl($tgl1, $tgl2, $t, $tim, $tims, $vali, $s);
			}elseif ($jenisPenilaian == '2') {
				$getlist = $this->M_index->listBl2($tgl1, $tgl2, $t, $tim, $tims, $vali, $s);
			}
			$data['listLt'] = $getlist;
		}
		$data['val'] = $val;
		$data['pr'] = $pr;
		$data['nama'] = $namaPilihan.' '.$listSeksi;
		$data['s'] = $s;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_TIMS_bulanan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function LamaEvaluasi()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'Setup';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Lama Evaluasi';
		$data['SubMenuTwo'] = '';

		$val = $this->M_index->getVal();
		$data['sesi'] = $val;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_Lama_evaluasi',$data);
		$this->load->view('V_Footer',$data);
	}

	public function InputLamaEvaluasi()
	{
		$val = $this->input->post('et_rd_le');
		$val2 = $this->input->post('et_rd_le2');
		$arr = array(
			$val, $val2
			);
		for ($i=0; $i < count($arr) ; $i++) {
			$send = $this->M_index->saveLama(($i+1), $arr[$i]);
		}

		if ($send) {
			//insert to t_log
	            $aksi = 'EVALUASI TIMS';
	            $detail = 'UPDATE LAMA PENILAIAN ID='.($i+1);
	            $this->log_activity->activity_log($aksi, $detail);
	        //
			redirect('EvaluasiTIMS/Setup/LamaEvaluasi');
		}
		echo "error occurred";
	}

	public function Memo()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'Memo';
		$data['Menu'] = 'Memo';
		$data['SubMenuOne'] = 'Memo';
		$data['SubMenuTwo'] = '';

		$data['listMemo'] = $this->M_index->getListMemo();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_Memo',$data);
		$this->load->view('V_Footer',$data);
	}

	public function AddMemo()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'Memo';
		$data['Menu'] = 'Memo';
		$data['SubMenuOne'] = 'Memo';
		$data['SubMenuTwo'] = '';


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_Tambah_Memo',$data);
		$this->load->view('V_Footer',$data);
	}

	public function previewcetak($no_surat)
	{
		$this->load->library('pdf');
		$pdf 	=	$this->pdf->load();
		$pdf 	=	new mPDF('utf-8', array(216,330), 11, "timesnewroman", 10, 10, 55, 30, 0, 0, 'P');
		$isi = $this->M_index->getMemo($no_surat);
		$judul = $this->M_index->getMemo2($no_surat);
		$filename	=	'EvaluasiTIMS-'.str_replace('/', '_', 'Memo').'.pdf';

		$pdf->AddPage();
		$pdf->SetTitle($judul[0]['nomor_surat']);
		$pdf->WriteHTML($isi);

		$pdf->Output($filename, 'I');
	}

	public function getKadept()
	{
		$term = $this->input->get('s');
		$term = strtoupper($term);
		$id = $this->input->get('id');

		$getKadept = $this->M_index->getKadept($term, $id);
		// $getKadept = array_column($getKadept, 'pilih');
		// $getKadept = array_unique($getKadept);
		$getKadept = array_map("unserialize", array_unique(array_map("serialize", $getKadept)));
		// exit();

		echo json_encode($getKadept);
	}

	public function getNamaKadept()
	{
		$id = $this->input->post('id');
		$ks = $this->input->post('ks');
		$texts = strtoupper($this->input->post('text'));
		$text = '';

		$getNamaKadept = $this->M_index->getNamaKadept($id, $texts, $ks);
		// $hit = count($getNamaKadept);
		// if ($hit > 1) {
		// 	for ($i=0; $i < $hit; $i++) {
		// 		if ($i == ($hit-1)) {
		// 			$text .= $getNamaKadept[$i]['nama'];
		// 		}else{
		// 			$text .= $getNamaKadept[$i]['nama'].'/';
		// 		}
		// 	}
		// 	$getNamaKadept = array(array(
		// 		'nama' => $text,
		// 		));
		// }
			$option = '<option disabled selected>Pilih Salah Satu</option>';
		foreach ($getNamaKadept as $key) {
			$option .= '<option value="'.$key['nama'].'">'.$key['nama'].'</option>';
		}
		$getNamaKadept = $option;
		echo json_encode($getNamaKadept);
		exit();
	}

	public function getPdev()
	{
		$term = $this->input->get('s');

		$getPdev = $this->M_index->getPdev($term);

		echo json_encode($getPdev);
	}

	public function previewMemo()
	{
		$no_surat = $this->input->post('evt_no_surat');
		$pilih = $this->input->post('evt_pilih');
		$bagian = $this->input->post('evt_departemen');
		$lampiran_a = $this->input->post('evt_lampiran_angka');
		$lampiran_s = $this->input->post('evt_lampiran_satuan');
		$pdev = $this->input->post('evt_pdev');
		$kepada = $this->input->post('evt_kepada');
		$isi = $this->input->post('evt_isi');
		$alasan = $this->input->post('evt_alasan');

		if (empty($no_surat)) {
			echo "Nomor Surat Kosong";
			exit();
		}elseif (empty($pilih)) {
			echo "Kolom Pilih Kosong";
			exit();
		}elseif ($pilih && empty($bagian)) {
			echo "Departemen/Bidang/Unit/Seksi Kosong";
			exit();
		}elseif (empty($lampiran_a)) {
			echo "Lampiran Angka Kosong";
			exit();
		}elseif (empty($lampiran_s)) {
			echo "Lampiran Satuan Kosong";
			exit();
		}elseif (empty($pdev)) {
			echo "Kolom People Development Kosong";
			exit();
		}elseif (empty($kepada)) {
			echo "Kolom Kepada Kosong";
			exit();
		}
		$var = '';
		if (gettype($bagian) == 'string') {
			$bagian = explode(' | ', $bagian);
			$bagian = $bagian[0];
		}else{
			for ($i=0; $i < count($bagian); $i++) {
				$x = explode(' | ', $bagian[$i]);
				if ($i == (count($bagian)-1)) {
					$var .=	$x[0];
				}else{
					$var .=	$x[0].', ';
				}
			}
			$bagian = $var;
		}
		$pdev = $this->M_index->getNama($pdev);
		$alasan = str_replace('<p>', '', $alasan);
		$alasan = str_replace('</p>', '', $alasan);
		$isi = str_replace('<table>', '<table border="1" cellpadding="8" style="border-collapse: collapse; text-align:center;">', $isi);
		$tanggal = $this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime(date('Y-m-d'))));

		if ($pilih == '1') {
			$pilih = 'Departemen';
		}elseif ($pilih == '2') {
			$pilih = 'Bidang';
		}elseif ($pilih == '3') {
			$pilih = 'Unit';
		}else{
			$pilih = 'Seksi';
		}

		$kdu = $this->M_index->getKDU();
		$kdu = $kdu->row()->no_kdu;

		$templateMemo = $this->M_index->getMemo();
		if ($lampiran_s == '-') {
			$templateMemo = str_replace('[jml_lampiran] ([satuan_lampiran])&nbsp;lembar', '-', $templateMemo);
		}

		$parameterUbah = array(
				'[nomor_surat]',
				'[nama_departemen]',
				'[jml_lampiran]',
				'[satuan_lampiran]',
				'[kepada]',
				'[nomor_kdu]',
				'[isi_memo]',
				'[alasan]',
				'[tanggal]',
				'[pdev]',
				'[pilih]',
				'<ol>'
			);
		$parameterDiubah = array(
				$no_surat,
				$bagian,
				$lampiran_a,
				$lampiran_s,
				$kepada,
				$kdu,
				$isi,
				$alasan,
				$tanggal,
				$pdev,
				$pilih,
				'<ol style="text-align: justify;">'
			);
		$data['preview'] 	=	str_replace($parameterUbah, $parameterDiubah, $templateMemo);

		echo json_encode($data);
	}

	public function saveMemo()
	{
		$noind = $this->session->user;
		$no_surat = $this->input->post('evt_no_surat');
		$departemen = $this->input->post('evt_departemen');
		foreach ($departemen as $key) {
			$x = explode(' | ', $key);
			$y[] = $x[0];
			$z[] = $x[1];
		}
		// $departemen = explode(' | ', $departemen);
		$dep = implode(',', $y);
		$potongan = implode(',', $z);
		$lampiran_a = $this->input->post('evt_lampiran_angka');
		$lampiran_s = $this->input->post('evt_lampiran_satuan');
		$pdev = $this->input->post('evt_pdev');
		$kepada = $this->input->post('evt_kepada');
		$isi = $this->input->post('evt_isi');
		$result = $this->input->post('evt_result');
		$result = str_replace('<ol>', '<ol style="text-align: justify;">', $result);
		$alasan = $this->input->post('evt_alasan');
		$pilih = $this->input->post('evt_pilih');
		$tanggal = date('Y-m-d');

		$data = array(
				'nomor_surat' => $no_surat,
				'bagian' => $dep,
				'lampiran' => $lampiran_a,
				'kepada' => $kepada,
				'kasie_pdev' => $pdev,
				'alasan' => $alasan,
				'isi' => $isi,
				'create_by' => $noind,
				'create_date' => $tanggal,
				'memo' => $result,
				'lampiran_satuan' => $lampiran_s,
				'pilih' => $pilih,
				'potongan_kodesie' => $potongan,
			);
		$save = $this->M_index->saveMemo($data);
		if ($save) {
			//insert to t_log
				$aksi = 'EVALUASI TIMS';
				$detail = 'Save Memo Nomor Surat='.$no_surat.' Dibuat oleh='.$noind;
				$this->log_activity->activity_log($aksi, $detail);
			//
			redirect('EvaluasiTIMS/Setup/Memo');
		}
	}

	public function EditMemo($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'Memo';
		$data['Menu'] = 'Memo';
		$data['SubMenuOne'] = 'Memo';
		$data['SubMenuTwo'] = '';

		$data['memo'] = $this->M_index->getRowMemo($id);
        $y = explode(',', $data['memo'][0]['potongan_kodesie']);
		$data['namaKadept'] = $this->M_index->getNamaKadept2($data['memo'][0]['pilih'], $y[0], $data['memo'][0]['kepada']);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_Edit_Memo',$data);
		$this->load->view('V_Footer',$data);
	}

	public function saveEditMemo()
	{
		$noind = $this->session->user;
		$no_surat = $this->input->post('evt_no_surat');
		$id = $this->input->post('evt_id');
		$departemen = $this->input->post('evt_departemen');
		foreach ($departemen as $key) {
			$x = explode(' | ', $key);
			$y[] = $x[0];
			$z[] = $x[1];
		}
		// $departemen = explode(' | ', $departemen);
		$dep = implode(',', $y);
		$potongan = implode(',', $z);
		$lampiran_a = $this->input->post('evt_lampiran_angka');
		$lampiran_s = $this->input->post('evt_lampiran_satuan');
		$pdev = $this->input->post('evt_pdev');
		$kepada = $this->input->post('evt_kepada');
		$isi = $this->input->post('evt_isi');
		$result = $this->input->post('evt_result');
		$result = str_replace('<ol>', '<ol style="text-align: justify;">', $result);
		$alasan = $this->input->post('evt_alasan');
		$pilih = $this->input->post('evt_pilih');
		$tanggal = date('Y-m-d');

		$data = array(
				'nomor_surat' => $no_surat,
				'bagian' => $dep,
				'lampiran' => $lampiran_a,
				'kepada' => $kepada,
				'kasie_pdev' => $pdev,
				'alasan' => $alasan,
				'isi' => $isi,
				'create_by' => $noind,
				'memo' => $result,
				'lampiran_satuan' => $lampiran_s,
				'pilih' => $pilih,
				'potongan_kodesie' => $potongan,
			);
		$save = $this->M_index->saveEditMemo($data, $id);
		if ($save) {
			//insert to t_log
				$aksi = 'EVALUASI TIMS';
				$detail = 'Update Memo Nomor Surat='.$no_surat.' Dibuat oleh='.$noind;
				$this->log_activity->activity_log($aksi, $detail);
			//
			redirect('EvaluasiTIMS/Setup/Memo');
		}
	}

	public function testPreview()
	{
		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="filename.pdf"');
		$data = $this->input->post('data');
		$no = $this->input->post('no');
		$this->load->library('pdf');
		$pdf 	=	$this->pdf->load();
		$pdf 	=	new mPDF('utf-8', array(216,330), 11, "timesnewroman", 10, 10, 55, 30, 0, 0, 'P');
		// $pdf 	=	new mPDF();
		$data = str_replace('<ol>', '<ol style="text-align: justify;">', $data);
		$isi = $data;
		ob_end_clean();
		$filename	=	'Preview Memo.pdf';
		$pdf->AddPage();
		$pdf->SetTitle('Preview');
		$pdf->shrink_tables_to_fit = 1;
		$pdf->use_kwt = true;
		$pdf->WriteHTML(utf8_encode($isi));

		$pdf->Output($filename, 'I');

		// echo json_decode($data['pdf']);
	}

	public function exportBulanan()
	{
		$jenisPenilaian = $this->input->post('jp');
		$tanggal = $this->input->post('tgl');
		$nama = $this->input->post('nama');
		$s = $this->input->post('ess');
		$data['ket'] = $this->input->post('tx_keterangan');
		$data['nama'] = $nama;
		$data['jenis'] = 'bulanan';

		$jp = $this->M_index->listJp3($jenisPenilaian);
		$kdu = $this->M_index->getKDU();
		$data['kdu'] = $kdu->row()->no_kdu;
		$t = $jp[0]['std_m'];
		$tim = $jp[0]['std_tim'];
		$tims = $jp[0]['std_tims'];
		$data['jp'] = $jp[0]['jenis_penilaian'];
		$data['jpi'] = $jenisPenilaian;
		$vali = $this->M_index->getVal2($jenisPenilaian);
		$data['tims'] = array(
			$t,$tim,$tims
			);

		$tanggal = explode(' - ', $tanggal);
		$tgl1 = $tanggal[0];
		$tgl2 = $tanggal[1];
		if ($jenisPenilaian == '1') {
			$getlist = $this->M_index->listBl($tgl1, $tgl2, $t, $tim, $tims, $vali, $s);
		}elseif ($jenisPenilaian == '2') {
			$getlist = $this->M_index->listBl2($tgl1, $tgl2, $t, $tim, $tims, $vali, $s);
		}
		$data['listLt'] = $getlist;
		$data['tgl1'] = $this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime($tgl1)));
		$data['tgl2'] = $this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime($tgl2)));

		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="filename.pdf"');
		$this->load->library('pdf');
		$pdf 	=	$this->pdf->load();
		$pdf 	=	new mPDF('utf-8', array(216,330), 11, "timesnewroman", 5, 5, 10, 10, 0, 0, 'L');
		$filename	=	'Evaluasi TIMS Bulanan '.$jp[0]['jenis_penilaian'].' '.$this->input->post('tgl').'.pdf';
		if ($jenisPenilaian == '1') {
			$html = $this->load->view('EvaluasiTIMS/V_Export_Php',$data, true);
		}elseif ($jenisPenilaian == '2') {
			$html = $this->load->view('EvaluasiTIMS/V_Export_Php2',$data, true);
		}
		$pdf->AddPage();
		$pdf->autoScriptToLang = true;
		$pdf->autoLangToFont = true;
		$pdf->SetTitle('Evaluasi TIMS Bulanan '.$jp[0]['jenis_penilaian'].' '.$this->input->post('tgl'));
		$pdf->WriteHTML($html, 2);

		$data['pdf'] = $pdf->Output($filename, 'I');
	}

	public function exportHarian()
	{
		$jenisPenilaian = $this->input->post('jp');
		$tanggal = $this->input->post('tgl');
		$nama = $this->input->post('nama');
		$data['ket'] = $this->input->post('tx_keterangan');
		$data['nama'] = $nama;
		$b = substr($nama, 11);

		$vali = $this->M_index->getVal2($jenisPenilaian);
		$data['jenis'] = 'harian';
		$jp = $this->M_index->listJp3($jenisPenilaian);
		$kdu = $this->M_index->getKDU();
		$data['kdu'] = $kdu->row()->no_kdu;

		$t = $jp[0]['std_m'];
		$tim = $jp[0]['std_tim'];
		$tims = $jp[0]['std_tims'];
		$data['tims'] = array(
			$t,$tim,$tims
			);

		if ($jenisPenilaian == '1') {
			$getlist = $this->M_index->listLt($b, $t, $tim, $tims, $vali);
		}elseif ($jenisPenilaian == '2') {
			$getlist = $this->M_index->listLt2($b, $t, $tim, $tims, $vali);
		}

		$data['tgl2'] = $this->personalia->konversitanggalIndonesia(date('Y-m-d'));
		$data['listLt'] = $getlist;
		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="filename.pdf"');
		$this->load->library('pdf');
		$pdf 	=	$this->pdf->load();
		$pdf 	=	new mPDF('utf-8', array(216,330), 11, "timesnewroman", 5, 5, 10, 10, 0, 0, 'L');
		// $pdf 	=	new mPDF();
		$filename	=	'Evaluasi TIMS Harian '.$jp[0]['jenis_penilaian'].' '.$tanggal.'.pdf';
		if ($jenisPenilaian == '1') {
			$html = $this->load->view('EvaluasiTIMS/V_Export_Php',$data, true);
		}elseif ($jenisPenilaian == '2') {
			$html = $this->load->view('EvaluasiTIMS/V_Export_Php2',$data, true);
		}
		$pdf->AddPage();
		$pdf->autoScriptToLang = true;
		$pdf->autoLangToFont = true;
		$pdf->SetTitle('Evaluasi TIMS Harian '.$jp[0]['jenis_penilaian'].' '.$tanggal);
		$pdf->WriteHTML($html, 2);

		$data['pdf'] = $pdf->Output($filename, 'I');
	}

	public function EditNomorKDU()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'Setup';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Edit Nomor KDU';
		$data['SubMenuTwo'] = '';

		$kdu = $this->M_index->getKDU();
		$data['kdu'] = $kdu->row()->no_kdu;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_Edit_KDU',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SubmitKdu()
	{
		$noind = $this->session->user;
		$kdu = $this->input->post('et_kdu');
		$data = array(
			'no_kdu'	=>	$kdu,
			);
		$save = $this->M_index->saveKdu($data);
		if ($save) {
			//insert to t_log
				$aksi = 'EVALUASI TIMS';
				$detail = 'Update KDU Nomor='.$kdu.' oleh='.$noind;
				$this->log_activity->activity_log($aksi, $detail);
			//
			redirect('EvaluasiTIMS/Setup/EditNomorKDU');
		}
	}

	public function detail_perpanjangan()
	{
		$noind = $_POST['noind'];
		$nilai = $_POST['nilai'];

		$jp = $this->M_index->listJp3($nilai);
		$t = $jp[0]['std_m'];
		$tim = $jp[0]['std_tim'];
		$tims = $jp[0]['std_tims'];

		$res = $this->M_index->getPerpanjangan($noind, $t, $tim, $tims);
		if (!empty($res)) {
		echo '<label class="col-md-3" style="font-weight: bold;">Periode OJT </label>:     <label> '.date('d-M-Y', strtotime($res[0]['tanggal_awal_rekap'])).' sd '.date('d-M-Y', strtotime($res[0]['tanggal_akhir_rekap'])).'</label><br>
				<label class="col-md-3" style="font-weight: bold;">No Induk </label>:     <label> '.$res[0]['noind'].'</label><br>
                <label class="col-md-3" style="font-weight: bold;">Nama </label>:     <label> '.$res[0]['nama'].'</label><br>
                <label class="col-md-3" style="font-weight: bold;">Tanggal Masuk </label>:     <label> '.date('d-M-Y', strtotime($res[0]['tgl_masuk'])).'</label><br>
                <label class="col-md-3" style="font-weight: bold;">Unit </label>:     <label> '.$res[0]['unit'].'</label><br>
                <label class="col-md-3" style="font-weight: bold;">Seksi </label>:     <label> '.$res[0]['seksi'].'</label><br>
                <label class="col-md-3" style="font-weight: bold;">Lama Kerja </label>:     <label> '.$res[0]['masa_kerja'].'</label>
                <br>
                <div class="col-md-12" style="overflow-x:scroll;">
                <table class="table table-bordered text-center">
                	<thead class="bg-primary">
	                	<tr>
		                	<td>T</td>
		                	<td>I</td>
		                	<td>M</td>
		                	<td>S</td>
		                	<td>PSP</td>
		                	<td>IP</td>
		                	<td>CT</td>
		                	<td>SP</td>
		                	<td>TIM</td>
		                	<td>TIMS</td>
		                	<td>Prediksi M</td>
		                	<td>Prediksi TIM</td>
		                	<td>Prediksi TIMS</td>
		                	<td>Prediksi Lolos</td>
	                	</tr>
	                </thead>
	                <tbody>
	                	<tr>
	                		<td>'.$res[0]['telat'].'</td>
                            <td>'.$res[0]['ijin'].'</td>
                            <td>'.$res[0]['mangkir'].'</td>
                            <td>'.$res[0]['sk'].'</td>
                            <td>'.$res[0]['psp'].'</td>
                            <td>'.$res[0]['ip'].'</td>
                            <td>'.$res[0]['ct'].'</td>
                            <td>'.$res[0]['sp'].'</td>
                            <td>'.$res[0]['tim'].'</td>
                            <td>'.$res[0]['tims'].'</td>
                            <td>'.round($res[0]['pred_m'],2).'</td>
                            <td>'.round($res[0]['pred_tim'],2).'</td>
                            <td>'.round($res[0]['pred_tims'],2).'</td>
                            <td>'.$res[0]['pred_lolos'].'</td>
	                	<tr>
	                </tbody>
                </table>';
		}else{
			echo '<center><ul class="list-group"><li class="list-group-item">'.'Data Kosong'.'</li></ul></center>';
		}
	}

	public function getLamaEval()
	{
		$a = $this->input->post('s');
		$vali = $this->M_index->getVal2($a);

		$ret = '';
		if ($a == '1') {
			$ret = 'Lama Evaluasi OJT :'.$vali.' bulan';
		}else{
			$ret = 'Lama Evaluasi Non OJT :'.$vali.' bulan';
		}
		$ret = str_replace('"', '', $ret);
		echo $ret;
	}
}
