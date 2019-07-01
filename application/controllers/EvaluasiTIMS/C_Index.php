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
		// print_r($_POST);exit();
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
		// echo $term;exit();
		$listJp = $this->M_index->listJp2($term);

		echo json_encode($listJp);
	}
	public function getPenilaian2()
	{
		// print_r($_POST);exit();
		$term = $this->input->post('s');
		// echo $term;exit();
		$listJp = $this->M_index->listJp3($term);

		echo json_encode($listJp);
		// header('Content-Type: application/json');
	}

	public function SubmitStandarPenilaian()
	{
		$noind = $this->session->user;
		// print_r($_POST);exit();
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
		// echo $lh;exit();
		if (!empty($lh)) {
			$jp = $this->M_index->listJp3($lh);
			$t = $jp[0]['std_m'];
			$tim = $jp[0]['std_tim'];
			$tims = $jp[0]['std_tims'];
			// print_r($jp);exit();
			$val = '1';
			$a = array();
			$vali = $this->M_index->getVal2($lh);
			// print_r($vali);exit();
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
			// echo "<pre>";
			// print_r($listHarian);
			// exit();
			// print_r($a);
		}
		$data['val'] = $val;
		// print_r($last_col);exit();
		$data['jumlah'] = $a;
		$data['jp'] = $jp;
		$data['idi'] = $lh;

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
		// echo $b;exit();
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

		// print_r($jp);exit();
		if ($a == '1') {
			$data['listLt'] = $this->M_index->listLt($b, $t, $tim, $tims, $vali);
		}elseif ($a == '2') {
			$data['listLt'] = $this->M_index->listLt2($b, $t, $tim, $tims, $vali);
		}
		$data['jp'] = $jp[0]['jenis_penilaian'];
		$data['jpi'] = $a;
		$data['dept'] = 'Departemen '.$b;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_TIMS_harian_lihat',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Bulanan()
	{
		// echo "<pre>";
		// print_r($_POST);exit();
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = 'TIMS Bulanan';
		$data['Menu'] = 'TIMS Bulanan';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$pr = $this->input->post('et_periode');
		$jenisPenilaian = $this->input->post('et_jenis_jp');
		$pilih = $this->input->post('evt_pilih');
		$bagian = strtoupper($this->input->post('evt_departemen'));
		$s = '';
		$namaPilihan = '';
		$val = '0';
		$data['jp'] = '';
		if (!empty($pr) || !empty($jenisPenilaian)) {
			$val = '1';
			$jp = $this->M_index->listJp3($jenisPenilaian);
			// echo $jenisPenilaian;exit();
			$t = $jp[0]['std_m'];
			$tim = $jp[0]['std_tim'];
			$tims = $jp[0]['std_tims'];
			$data['jp'] = $jp[0]['jenis_penilaian'];
			$data['jpi'] = $jenisPenilaian;
			$vali = $this->M_index->getVal2($jenisPenilaian);

			if ($pilih == '1') {
				$s = "et.dept = '$bagian'";
				$namaPilihan = 'Departemen';
			}elseif ($pilih == '2') {
				$s = "et.bidang = '$bagian'";
				$namaPilihan = 'Bidang';
			}elseif ($pilih == '3') {
				$s = "et.unit = '$bagian'";
				$namaPilihan = 'Unit';
			}else{
				$s = "et.dept like '%%'";
			}

			$tanggal = explode(' - ', $pr);
			$tgl1 = $tanggal[0];
			$tgl2 = $tanggal[1];
			if ($jenisPenilaian == '1') {
				$getlist = $this->M_index->listBl($tgl1, $tgl2, $t, $tim, $tims, $vali, $s);
			}elseif ($jenisPenilaian == '2') {
				$getlist = $this->M_index->listBl2($tgl1, $tgl2, $t, $tim, $tims, $vali, $s);
			}
			// echo "<pre>"; print_r($getlist);exit();
			$data['listLt'] = $getlist;
		}
		$data['val'] = $val;
		$data['pr'] = $pr;
		$data['nama'] = $namaPilihan.' '.$bagian;
		$data['s'] = $s;


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_TIMS_bulanan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function LamaEvaluasi()
	{
		// print_r($_POST);exit();
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
		// print_r($val);exit();
		$data['sesi'] = $val;
      	// print_r($data['sesi']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_Lama_evaluasi',$data);
		$this->load->view('V_Footer',$data);
	}

	public function InputLamaEvaluasi()
	{
		// echo "<pre>";
		// print_r($_POST);exit();
		$val = $this->input->post('et_rd_le');
		$val2 = $this->input->post('et_rd_le2');
		$arr = array(
			$val, $val2
			);
		for ($i=0; $i < count($arr) ; $i++) { 
			$send = $this->M_index->saveLama(($i+1), $arr[$i]);
		}

		if ($send) {
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
		// exit();
		$this->load->library('pdf');
		$pdf 	=	$this->pdf->load();
		$pdf 	=	new mPDF('utf-8', array(216,330), 10, "timesnewroman", 10, 10, 55, 30, 0, 0, 'P');
		// $pdf 	=	new mPDF();
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
		// print_r($_GET);exit();
		$term = $this->input->get('s');
		$term = strtoupper($term);
		$id = $this->input->get('id');

		$getKadept = $this->M_index->getKadept($term, $id);
		// $getKadept = array_column($getKadept, 'pilih');
		// $getKadept = array_unique($getKadept);
		$getKadept = array_map("unserialize", array_unique(array_map("serialize", $getKadept)));

		echo json_encode($getKadept);
	}

	public function getNamaKadept()
	{
		$id = $this->input->post('id');
		$texts = strtoupper($this->input->post('text'));
		$text = '';

		$getNamaKadept = $this->M_index->getNamaKadept($id, $texts);
		$hit = count($getNamaKadept);
		if ($hit > 1) {
			for ($i=0; $i < $hit; $i++) { 
				if ($i == ($hit-1)) {
					$text .= $getNamaKadept[$i]['nama'];
				}else{
					$text .= $getNamaKadept[$i]['nama'].'/';
				}
			}
			$getNamaKadept = array(array(
				'nama' => $text,
				));
		}
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
		// print_r($_POST);exit();
		$no_surat = $this->input->post('evt_no_surat');
		$pilih = $this->input->post('evt_pilih');
		$bagian = $this->input->post('evt_departemen');
		$lampiran_a = $this->input->post('evt_lampiran_angka');
		$lampiran_s = $this->input->post('evt_lampiran_satuan');
		$pdev = $this->input->post('evt_pdev');
		$pdev = $this->M_index->getNama($pdev);
		$kepada = $this->input->post('evt_kepada');
		$isi = $this->input->post('evt_isi');
		$alasan = $this->input->post('evt_alasan');
		$alasan = str_replace('<p>', '', $alasan);
		$alasan = str_replace('</p>', '', $alasan);
		$tanggal = $this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime(date('Y-m-d'))));

		if ($pilih == '1') {
			$pilih = 'Departemen';
		}elseif ($pilih == '2') {
			$pilih = 'Bidang';
		}else{
			$pilih = 'Unit';
		}


		$templateMemo = $this->M_index->getMemo();
		// echo $pdev;exit();

		$parameterUbah = array(
				'[nomor_surat]',
				'[nama_departemen]',
				'[jml_lampiran]',
				'[satuan_lampiran]',
				'[kepada]',
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
		// echo "<pre>";
		// print_r($_POST);exit();
		$noind = $this->session->user;
		$no_surat = $this->input->post('evt_no_surat');
		$departemen = $this->input->post('evt_departemen');
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
				'bagian' => $departemen,
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
			);
		$save = $this->M_index->saveMemo($data);
		if ($save) {
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
		// print_r($data['memo']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('EvaluasiTIMS/V_Edit_Memo',$data);
		$this->load->view('V_Footer',$data);
	}

	public function saveEditMemo()
	{
		// echo "<pre>";
		// print_r($_POST);exit();
		$noind = $this->session->user;
		$no_surat = $this->input->post('evt_no_surat');
		$id = $this->input->post('evt_id');
		$departemen = $this->input->post('evt_departemen');
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
				'bagian' => $departemen,
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
			);
		$save = $this->M_index->saveEditMemo($data, $id);
		if ($save) {
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
		$pdf 	=	new mPDF('utf-8', array(216,330), 10, "timesnewroman", 10, 10, 55, 30, 0, 0, 'P');
		// $pdf 	=	new mPDF();
		$data = str_replace('<ol>', '<ol style="text-align: justify;">', $data);
		$isi = $data;
		$filename	=	'Preview Memo.pdf';

		$pdf->AddPage();
		$pdf->SetTitle('Preview');
		$pdf->WriteHTML($isi);

		$data['pdf'] = $pdf->Output($filename, 'I');

		// echo json_decode($data['pdf']);
	}

	public function exportBulanan()
	{
		// print_r($_POST);exit();
		$jenisPenilaian = $this->input->post('jp');
		$tanggal = $this->input->post('tgl');
		$nama = $this->input->post('nama');
		$s = $this->input->post('ess');
		$data['nama'] = $nama;
		$data['jenis'] = 'bulanan';

		$jp = $this->M_index->listJp3($jenisPenilaian);
		// echo $jenisPenilaian;exit();
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
		// echo "<pre>"; print_r($getlist);exit();
		$data['listLt'] = $getlist;
		$data['tgl1'] = $this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime($tgl1)));
		$data['tgl2'] = $this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime($tgl2)));

		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="filename.pdf"');
		$this->load->library('pdf');
		$pdf 	=	$this->pdf->load();
		$pdf 	=	new mPDF('utf-8', array(216,330), 10, "timesnewroman", 10, 10, 10, 10, 0, 0, 'L');
		// $pdf 	=	new mPDF();
		$filename	=	'Evaluasi TIMS Bulanan '.$jp[0]['jenis_penilaian'].' '.$this->input->post('tgl').'.pdf';
		if ($jenisPenilaian == '1') {
			$html = $this->load->view('EvaluasiTIMS/V_Export_Php',$data, true);
		}elseif ($jenisPenilaian == '2') {
			$html = $this->load->view('EvaluasiTIMS/V_Export_Php2',$data, true);
		}
		$pdf->AddPage();
		$pdf->SetTitle('Evaluasi TIMS Bulanan '.$jp[0]['jenis_penilaian'].' '.$this->input->post('tgl'));
		$pdf->WriteHTML($html, 2);

		$data['pdf'] = $pdf->Output($filename, 'I');
	}

	public function exportHarian()
	{
		// print_r($_POST);exit();
		$jenisPenilaian = $this->input->post('jp');
		$tanggal = $this->input->post('tgl');
		$nama = $this->input->post('nama');
		$data['nama'] = $nama;
		$b = substr($nama, 11);

		$vali = $this->M_index->getVal2($jenisPenilaian);
		$data['jenis'] = 'harian';
		$jp = $this->M_index->listJp3($jenisPenilaian);
		$t = $jp[0]['std_m'];
		$tim = $jp[0]['std_tim'];
		$tims = $jp[0]['std_tims'];
		$data['tims'] = array(
			$t,$tim,$tims
			);

		// print_r($b);exit();
		if ($jenisPenilaian == '1') {
			$getlist = $this->M_index->listLt($b, $t, $tim, $tims, $vali);
		}elseif ($jenisPenilaian == '2') {
			$getlist = $this->M_index->listLt2($b, $t, $tim, $tims, $vali);
		}
		// echo "<pre>"; print_r($getlist);exit();
		$data['tgl2'] = $this->personalia->konversitanggalIndonesia(date('Y-m-d'));
		$data['listLt'] = $getlist;
		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="filename.pdf"');
		$this->load->library('pdf');
		$pdf 	=	$this->pdf->load();
		$pdf 	=	new mPDF('utf-8', array(216,330), 10, "timesnewroman", 10, 10, 10, 10, 0, 0, 'L');
		// $pdf 	=	new mPDF();
		$filename	=	'Evaluasi TIMS Harian '.$jp[0]['jenis_penilaian'].' '.$tanggal.'.pdf';
		if ($jenisPenilaian == '1') {
			$html = $this->load->view('EvaluasiTIMS/V_Export_Php',$data, true);
		}elseif ($jenisPenilaian == '2') {
			$html = $this->load->view('EvaluasiTIMS/V_Export_Php2',$data, true);
		}
		$pdf->AddPage();
		$pdf->SetTitle('Evaluasi TIMS Harian '.$jp[0]['jenis_penilaian'].' '.$tanggal);
		$pdf->WriteHTML($html, 2);

		$data['pdf'] = $pdf->Output($filename, 'I');
	}
}