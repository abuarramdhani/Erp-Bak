<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Index extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('ciqrcode');
		$this->load->library('upload');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('P2K3V2/P2K3Admin/M_dtmasuk');
		$this->load->model('P2K3V2/MainMenu/M_order');
		$this->checkSession();
		date_default_timezone_set("Asia/Jakarta");
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if ($this->session->is_logged) {
		} else {
			redirect('index');
		}
	}

	public function standar()
	{
		$user1 = $this->session->user;
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Kebutuhan APD';
		$data['Menu'] = 'Kebutuhan APD';
		$data['SubMenuOne'] = 'Standar';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		$noind = $this->session->user;
		$ks = $this->input->post('k3_adm_ks');
		if (empty($ks)) {
			$ks = $kodesie;
		}
		$baru = '1999-01-01 01:10:10';
		$cek_terbaru = $this->M_dtmasuk->cek_terbaru($ks);
		if (!isset($cek_terbaru) || !empty($cek_terbaru)) {
			$baru = $cek_terbaru[0]['tgl_approve_tim'];
		}
		$data['list'] = $this->M_dtmasuk->getListAprove($ks, $baru);
		$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($ks);
		$data['seksi'] = '';
		$data['seksi'] = $this->M_dtmasuk->cekseksi($ks);
		// echo "<pre>";
		// print_r($data['list']);exit();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Standar', $data);
		$this->load->view('V_Footer', $data);
	}

	public function order()
	{
		$user1 = $this->session->user;
		$user_id = $this->session->userid;
		$noind = $this->session->user;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Kebutuhan APD';
		$data['Menu'] = 'Kebutuhan APD';
		$data['SubMenuOne'] = 'Order';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$pr = $this->input->post('k3_periode');
		$ks = $this->input->post('k3_adm_ks');
		$m = substr($pr, 0, 2);
		$y = substr($pr, 5, 5);
		$periode = $pr;
		$pr = $y . '-' . $m;
		// echo $pr;exit();
		if (empty($pr)) {
			$pr = date('Y-m');
			$periode = date('m - Y');
			$ks = $kodesie;
		}
		$data['pr'] = $periode;
		if ($ks == 'semua') {
			$ks = '';
		}


		// $data['listtobon'] = $this->M_dtmasuk->listtobon2($ks, $pr);
		$data['listtobon'] = $this->M_dtmasuk->listtobonHitung2($ks, $pr);
		$jml = '';
		// echo "<pre>";
		// print_r($data['listtobon']);exit();
		// foreach ($data['listtobon'] as $key) {
		// 	$a = $key['jml_item'];
		// 	$b = $key['jml_pekerja'];
		// 	$c = $key['jml_kebutuhan_umum'];
		// 	$d = $key['jml_kebutuhan_staff'];
		// 	$e = $key['jml_pekerja_staff'];
		// 	$a = explode(',', $a);
		// 	print_r($a);
		// 	$b = explode(',', $b);
		// 	$hit = count($a);
		// 	for ($i=0; $i < $hit; $i++) {
		// 		$jml += ($a[$i]*$b[$i]);
		// 	}
		// 	$jml = $jml+$c+($d*$e);
		// 	$push = array("total"=> $jml);
		// 	array_splice($key,4,1,$push);
		// 	$new[] = $key;
		// 	$data['listtobon'] = $new;
		// 	$jml = 0;
		// }
		// echo "<pre>";
		$data['seksi'] = $this->M_dtmasuk->cekseksi($ks);
		if (empty($data['seksi'])) {
			$data['seksi'] = array('section_name' 	=>	'');
			$data['seksi'] = array('0' 	=>	$data['seksi']);
		}
		if ($ks == '') {
			$data['seksi'] = array('section_name' 	=>	'SEMUA SEKSI');
			$data['seksi'] = array('0' 	=>	$data['seksi']);
		}
		// print_r($data['listtobon']);exit();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Order', $data);
		$this->load->view('V_Footer', $data);
	}

	public function perhitungan()
	{
		// print_r($_POST);exit();
		// echo "<pre>";
		$user1 = $this->session->user;
		$user_id = $this->session->userid;

		$data['Title'] = 'Perhitungan APD';
		$data['Menu'] = 'Perhitungan APD';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$pr = $this->input->post('k3_periode');
		$val = $this->input->post('validasi');
		$m = substr($pr, 0, 2);
		$y = substr($pr, 5, 5);
		$periode = $pr;
		$pr = $y . '-' . $m;
		if (strlen($pr) < 3) {
			$pr = date('Y-m');
			$periode = date('m - Y',  strtotime(" +1 months"));
		}
		$data['toHitung'] = '';
		$data['run'] = '0';
		$data['pr'] = $periode;
		if ($val == 'hitung') {
			// $data['toHitung'] = $this->M_dtmasuk->toHitung($pr);
			$data['toHitung'] = $this->M_dtmasuk->listperhitunganBySeksi($pr, 'not like'); //bukan tks
			$data['toHitung2'] = $this->M_dtmasuk->listperhitunganBySeksi($pr, 'like'); //tks
			// echo "<pre>";
			// print_r($data['toHitung']);
			// print_r($data['toHitung2']);
			// exit();

			// echo "<pre>";
			foreach ($data['toHitung'] as $key) {
				$kode = $key['item_kode'];
				$stok = $this->M_dtmasuk->stokOracle($kode, 'PNL-DM');
				$po = $this->M_dtmasuk->OutstandingPO($kode);
				$totalPO = 0;
				$poarr = array();
				if (!empty($po)) {
					foreach ($po as $p) {
						if (substr($p['PO_NUM'], 0, 2) == substr(date('Y'), 0, 2) && $p['LOCATION_CODE'] == 'PNL-DM') {
							$totalPO += $p['OUTSTANDING_PO_QTY'];
							$poarr[] = $p['PO_NUM'];
						}
					}
				}
				$key['po'] = $totalPO;
				$key['ponum'] = implode(', ', $poarr);
				$a = $key['jml_kebutuhan'];
				$b = $key['ttl_bon'];
				$out = ($a - $b);
				$key['outBon'] = $out;
				$key['stokg'] = $stok;

				$jpp = ceil(($a * 1.1) + $out - $stok - $totalPO);
				$key['jpp'] = ($jpp < 0) ? 0 : $jpp;

				$new[] = $key;
				$data['toHitung'] = $new;
				// print_r($po);
			}

			foreach ($data['toHitung2'] as $row) {
				$kode = $row['item_kode'];
				//tks saat ini 2 gudang
				$stok = $this->M_dtmasuk->stokOracle($kode, "PNL-TKS");
				$stok += $this->M_dtmasuk->stokOracle($kode, "PNL-NPR");
				$po = $this->M_dtmasuk->OutstandingPO($kode);
				$totalPO = 0;
				$poarr = array();
				if (!empty($po)) {
					foreach ($po as $p) {
						if (substr($p['PO_NUM'], 0, 2) == substr(date('Y'), 0, 2) && ($p['LOCATION_CODE'] == 'PNL-TKS' || $p['LOCATION_CODE'] == 'PNL-NPR')) {
							$totalPO += $p['OUTSTANDING_PO_QTY'];
							$poarr[] = $p['PO_NUM'];
						}
					}
				}
				$row['po'] = $totalPO;
				$row['ponum'] = implode(', ', $poarr);
				$a = $row['jml_kebutuhan'];
				$b = $row['ttl_bon'];
				$out = ($a - $b);
				$row['outBon'] = $out;
				$row['stokg'] = $stok;

				$jpp = ceil(($a * 1.1) + $out - $stok - $totalPO);
				$row['jpp'] = ($jpp < 0) ? 0 : $jpp;

				$new2[] = $row;
				$data['toHitung2'] = $new2;
				// print_r($po);
			}
			$data['run'] = '1';
		}
		// echo "<pre>";
		// print_r($data['toHitung']);exit();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Perhitungan', $data);
		$this->load->view('V_Footer', $data);
	}

	public function monitoring()
	{
		$user1 = $this->session->user;
		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring APD';
		$data['Menu'] = 'Monitoring APD';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$pr = $this->input->post('k3_periode');
		$sub = $this->input->post('p2k3_admin_monitor');

		$m = substr($pr, 0, 2);
		$y = substr($pr, 5, 5);
		$periode = $pr;
		$pr = $y . '-' . $m;
		// echo $pr;exit();
		if (empty($pr)) {
			$pr = date('Y-m');
			$periode = date('m - Y');
		}
		if (empty($sub)) {
			$sub = '0';
		}
		$data['pr'] = $periode;

		$noind = $this->session->user;
		$data['listOrder'] = $this->M_dtmasuk->getOrder($pr);
		$data['listOrder2'] = $this->M_dtmasuk->getOrder2($pr);
		// print_r($data['listOrder2']);exit();
		$data['jumlah'] = $this->M_dtmasuk->getjmlSeksi();
		$data['jumlahDepan'] = $this->M_dtmasuk->getjmlSeksiDepan($pr);
		$data['sub'] = $sub;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Monitoring', $data);
		$this->load->view('V_Footer', $data);
	}

	public function inputBon()
	{
		// print_r($_POST);exit();
		$user1 = $this->session->user;
		$user_id = $this->session->userid;
		$noind = $this->session->user;

		$data['Title'] = 'Order';
		$data['Menu'] = 'Input Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$ks = $this->input->post('k3_adm_ks');
		$pr = $this->input->post('k3_periode');
		$m = substr($pr, 0, 2);
		$y = substr($pr, 5, 5);
		$periode = $pr;
		$pr = $y . '-' . $m;
		// echo $pr;exit();
		if (empty($pr)) {
			$pr = date('Y-m');
			$periode = date('m - Y');
		}
		$data['pr'] = $periode;
		$data['ks'] = $ks;
		$data['pri'] = $pr;
		$data['listtobon'] = $this->M_dtmasuk->listtobon($ks, $pr);
		$jml = '';
		// echo "<pre>";
		// print_r($data['listtobon']);exit();
		foreach ($data['listtobon'] as $key) {
			$a = $key['jml_item'];
			$b = $key['jml_pekerja'];
			$a = explode(',', $a);
			$b = explode(',', $b);
			$hit = count($a);
			for ($i = 0; $i < $hit; $i++) {
				$jml += ($a[$i] * $b[$i]);
			}
			$push = array("total" => $jml);
			array_splice($key, 4, 1, $push);
			$new[] = $key;
			$data['listtobon'] = $new;
			$jml = 0;
		}
		$data['seksi'] = $this->M_dtmasuk->cekseksi($ks);
		if (empty($data['seksi'])) {
			$data['seksi'] = array('section_name' 	=>	'');
		}
		// print_r($new);
		// exit();
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Bon', $data);
		$this->load->view('V_Footer', $data);
	}

	public function getSeksiAprove()
	{
		$item = $_GET['s'];
		$item = strtoupper($item);
		$data = $this->M_dtmasuk->getSeksiApprove($item);
		echo json_encode($data);
	}
	public function getSeksiAprove2()
	{
		$item = '';
		$item = strtoupper($item);
		$data = $this->M_dtmasuk->getSeksiApprove2($item);
		// echo json_encode($data);
		// echo '<option></option>';
		echo '<option selected value="semua">SEMUA SEKSI</option>';
		foreach ($data as $key) {
			echo '<option value="' . $key['substring'] . '">' . $key['substring'] . ' - ' . $key['section_name'] . '</option>';
		}
	}

	public function getSeksiAprove3()
	{
		$item = '';
		$item = strtoupper($item);
		$data = $this->M_dtmasuk->getSeksiApprove2($item);
		// echo json_encode($data);
		// echo '<option></option>';
		echo '<option selected value="semua">SEMUA SEKSI</option>';
		foreach ($data as $key) {
			echo '<option value="' . $key['section_name'] . '">' . $key['substring'] . ' - ' . $key['section_name'] . '</option>';
		}
	}

	public function submitBon()
	{
		// print_r($_POST);exit();
		$tgl = date('Y-m-d H:i:s');
		$noind = $this->session->user;
		$apd = $this->input->post('p2k3_apd');
		$bon = $this->input->post('p2k3_jmlBon');
		$pr = $this->input->post('p2k3_pr');
		$ks = $this->input->post('p2k3_ks');
		$jml_k = $this->input->post('p2k3_jmlKebutuhan');
		$sisa_saldo = $this->input->post('p2k3_sisaSaldo');

		for ($i = 0; $i < count($apd); $i++) {
			$data = array(
				'periode'	=>	$pr,
				'kodesie'	=>	$ks,
				'tgl_bon'	=>	$tgl,
				'item_code'	=>	$apd[$i],
				'jml_bon'	=>	$bon[$i],
				'input_by'	=>	$noind,
				'jml_kebutuhan'	=>	$jml_k[$i],
				'sisa_saldo'	=>	$sisa_saldo[$i],
			);
			$input = $this->M_dtmasuk->insertBon($data);
			//insert to sys.t_log_activity
			$aksi = 'P2K3 V2';
			$detail = "Submit Bon Periode=$pr item=" . $apd[$i];
			$this->log_activity->activity_log($aksi, $detail);
			//
		}
		redirect('p2k3adm_V2/Admin/inputBon');
	}

	public function hitung()
	{
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;
		$noind = $this->session->user;

		$data['Title'] = 'Order';
		$data['Menu'] = 'Input Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		$data['master_apd'] = $this->M_dtmasuk->getApdmaster();

		$pr = $this->input->post('k3_periode');
		$ks = $this->input->post('k3_seksi');
		$apd = $this->input->post('k3_apd');
		if (!is_numeric($ks)) {
			$ks = '';
		}
		$m = substr($pr, 0, 2);
		$y = substr($pr, 5, 5);
		$periode = $pr;
		$pr = $y . '-' . $m;
		if (empty($pr)) {
			$pr = date('Y-m');
			$periode = date('m - Y');
		}
		$data['pr'] = $periode;
		$run = '0';
		$jml = 0;
		$validasi = $this->input->post('validasi');
		if ($validasi == 'hitung') {
			$delPeriode = $this->M_dtmasuk->delPeriode($pr, $ks, $apd);
			$list = array();
			$data['allKs'] = $this->M_dtmasuk->allKs($pr, $ks);
			foreach ($data['allKs'] as $key) {
				$record = $this->M_dtmasuk->getlistHitung($pr, $key['kodesie']);
				$new = array();
				foreach ($record as $row) {
					if (!empty($apd) && !in_array($row['kode_item'], $apd)) {
						continue;
					}
					$a = $row['jml_item'];
					$b = $row['jml_pekerja'];
					$c = $row['jml_kebutuhan_umum'];
					$d = $row['jml_kebutuhan_staff'];
					$e = $row['jml_pekerja_staff'];
					$a = explode(',', $a);
					$b = explode(',', $b);
					$hit = count($a);
					for ($i = 0; $i < $hit; $i++) {
						$jml += ($a[$i] * $b[$i]);
					}
					$jml = ceil($jml + $c + ($d * $e));

					$push = array("total" => $jml);
					array_splice($row, 4, 1, $push);
					$new[] = $row;

					$item = array(
						'periode'	=>	$pr,
						'item_kode'	=>	$row['kode_item'],
						'kodesie'	=>	$row['kodesie'],
						'jml_kebutuhan'	=>	$jml,
					);
					$inpHitung = $this->M_dtmasuk->inpHitung($item);
					$jml = 0;
				}
				$list[] = $new;
			}

			$data['listHitung'] = $list;

			$run = '1';
		}
		$data['run'] = $run;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Hitung', $data);
		$this->load->view('V_Footer', $data);
	}

	public function inputStandarTIM()
	{
		// print_r($_POST);exit();
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;
		$noind = $this->session->user;

		$data['Title'] = 'Input Standar Kebutuhan Seksi';
		$data['Menu'] = 'Input Standar Kebutuhan Seksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		$act = '0';
		$ks = $this->input->post('k3_adm_ks');
		if (!empty($ks)) {
			$act = '1';
		}
		if (empty($ks)) {
			$ks = $kodesie;
		}
		$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($ks);
		$data['act'] = $act;
		$data['seksi'] = $this->M_dtmasuk->cekseksi($ks);
		$data['kodesie'] = $ks;
		// print_r($data['seksi']);exit();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Input_Standar_TIM', $data);
		$this->load->view('V_Footer', $data);
	}

	public function inputOrderTIM()
	{
		// print_r($_POST);exit();
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;
		$noind = $this->session->user;

		$data['Title'] = 'Input Order Seksi';
		$data['Menu'] = 'Input Order Seksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		$act = '0';
		$ks = $this->input->post('k3_adm_ks');
		$pr = $this->input->post('k3_periode');
		if (!empty($ks)) {
			$act = '1';
			if (!empty($pr)) {
				$m = substr($pr, 0, 2);
				$y = substr($pr, 5, 5);
				$pr = $y . '-' . $m;
			} else {
				$pr = date("Y-m", strtotime(" +1 months"));
			}
			$cek = $this->M_order->cekOrder($ks, $pr);
			if ($cek > 0) {
				$act = '2';
			}
			$m = substr($pr, 5, 2);
			$y = substr($pr, 0, 4);
			$pr = $m . ' - ' . $y;
		}
		$data['pr'] = $pr;
		$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($ks);
		$data['act'] = $act;
		$data['seksi'] = $this->M_dtmasuk->cekseksi($ks);
		$data['kodesie'] = $ks;
		$data['max_pekerja']	= 	count($this->M_order->maxPekerja($ks));
		// print_r($data['max_pekerja']);exit();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Input_Order_TIM', $data);
		$this->load->view('V_Footer', $data);
	}

	public function saveInputStandar()
	{
		$noind = $this->session->user;
		// $kodesie = $this->session->kodesie;
		$kodesie = $this->input->post('p2k3_adm_kodesie');
		$daftar_pekerjaan	= $this->M_order->daftar_pekerjaan($kodesie);
		$item = $this->input->post('txtKodeItem');
		$umum = $this->input->post('txtkebUmum');
		$staff = $this->input->post('txtkebStaff');
		$jumlah = $this->input->post('p2k3_isk_standar');
		$tgl_input = date('Y-m-d H:i:s');

		// implode kdpekerjaan
		foreach ($daftar_pekerjaan as $key) {
			$kd[] = $key['kdpekerjaan'];
		}
		$kd_pkj = implode(',', $kd);

		//implode jumlah
		$a = 0;
		for ($i = 0; $i < count($item); $i++) {
			$getbulan = $this->M_dtmasuk->getBulan($item[$i]);
			for ($x = $a; $x < (count($daftar_pekerjaan) * ($i + 1)); $x++) {
				$jml[$i][] = (round($jumlah[$x] / $getbulan, 2));
			}

			$itemUmum = (round($umum[$i] / $getbulan, 2));
			$itemStaf = (round($staff[$i] / $getbulan, 2));
			$data = array(
				'kode_item'	=>	$item[$i],
				'kd_pekerjaan'	=> $kd_pkj,
				'jml_item'	=>	implode(',', $jml[$i]),
				'kodesie'	=>	$kodesie,
				'tgl_input'	=>	$tgl_input,
				'status'	=>	'3',
				'tgl_approve'	=>	$tgl_input,
				'tgl_approve_tim'	=>	$tgl_input,
				'approve_by'	=>	$noind,
				'approve_tim_by'	=>	$noind,
				'jml_kebutuhan_umum'	=>	$itemUmum,
				'jml_kebutuhan_staff'	=>	$itemStaf,
			);
			$a += count($daftar_pekerjaan);
			//insert to sys.t_log_activity
			$aksi = 'P2K3 V2';
			$detail = "Input Standar Kode_item= " . $item[$i] . " Status=3";
			$this->log_activity->activity_log($aksi, $detail);
			//
			$input = $this->M_order->save_standar($data);
		}
		redirect('p2k3adm_V2/Admin/inputStandarTIM');
	}

	public function saveInputOrder()
	{
		$noind = $this->session->user;
		$kodesie  = $this->input->post('p2k3_adm_kodesie');
		$daftar_pekerjaan	= $this->M_order->daftar_pekerjaan($kodesie);
		$jml = $this->input->post('pkjJumlah');
		$staff = $this->input->post('staffJumlah');
		$periode = $this->input->post('k3_periode');
		// print_r($_POST); print_r($daftar_pekerjaan);exit();
		$m = substr($periode, 0, 2);
		$y = substr($periode, 5, 5);
		$periode = $y . '-' . $m;

		foreach ($daftar_pekerjaan as $key) {
			$kd[] = $key['kdpekerjaan'];
		}
		$kd_pkj = implode(',', $kd);
		$jml_pkj = implode(',', $jml);
		$tgl_input = date('Y-m-d H:i:s');
		$ks = substr($kodesie, 0, 7);
		// echo $ks;exit();
		$data = array(
			'kd_pekerjaan'	=> $kd_pkj,
			'jml_pekerja'	=>	$jml_pkj,
			'jml_pekerja_staff'	=>	$staff,
			'kodesie'	=>	$ks,
			'tgl_input'	=>	$tgl_input,
			'status'	=>	'1',
			'periode'	=>	$periode,
			'tgl_approve'	=>	date('Y-m-d H:i:s'),
			'approve_by'	=>	$noind,
		);
		$inputPkj = $this->M_order->inputPkj($data);
		//insert to sys.t_log_activity
		$aksi = 'P2K3 V2';
		$detail = "Save Input order kd_pkj=$kd_pkj kodesie=$ks";
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect('p2k3adm_V2/Admin/inputOrderTIM');
	}

	public function detail_seksi()
	{
		$id_kebutuhan = $this->input->post('phoneData');
		// echo $id_kebutuhan;exit();
		if (isset($id_kebutuhan) and !empty($id_kebutuhan)) {
			$records = $this->M_dtmasuk->detail_seksi($id_kebutuhan);
			if (empty($records)) {
				echo '<center><ul class="list-group"><li class="list-group-item">' . 'Semua Seksi Telah Order' . '</li></ul></center>';
			} else {
				echo '<table class="table table-bordered table-hover table-striped text-center">
				<tr>
					<th width="10%">NO</th>
					<th width="20%">KODESIE</th>
					<th>NAMA SEKSI</th>
				</tr>';
				$i = 1;
				$search = array('0', '1', '2');
				$change = array('Pending', 'Approved', 'Rejected');
				foreach ($records as $key) {
					echo '<tr>
					<td>' . $i . '</td>
					<td>' . $key["kodesie"] . '</td>
					<td>' . $key["seksi"] . '</td>
				</tr>';
					$i++;
				}
				echo '</table>';
			}
		} else {
			echo '<center><ul class="list-group"><li class="list-group-item">' . 'Data Kosong' . '</li></ul></center>';
		}
	}

	public function MonitoringBon()
	{
		$user1 = $this->session->user;
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Monitoring Bon';
		$data['Menu'] = 'Monitoring Bon';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$pr = $this->input->post('k3_periode');
		$ks = $this->input->post('k3_adm_ks');
		$m = substr($pr, 0, 2);
		$y = substr($pr, 5, 5);
		$periode = $pr;
		$pr = $y . '-' . $m;
		if ($pr == '-') {
			$pr = date('Y-m');
			$periode = date('m - Y');
			$ks = $kodesie;
			// echo $pr;exit();
		}
		$seksi = $this->M_dtmasuk->cekseksi($ks);
		$data['kodesie'] = $ks;
		if (empty($data['seksi'])) {
			$seksi = array(array('section_name' => ''));
		}
		if ($ks == 'semua') {
			$seksi = array(array('section_name' => 'SEMUA SEKSI'));
		}
		$data['seksi'] = $seksi;
		if ($ks == 'semua') {
			$ks = '';
		}
		$data['pr'] = $periode;
		$data['period'] = $pr;
		// echo "<pre>";
		// $data['monitorbon'] = $this->M_dtmasuk->monitorbon($ks, $pr);
		$data['monitorbon'] = $this->M_dtmasuk->monitorbonOracle($ks, $pr);
		$count = count($data['monitorbon']);
		$a = array();
		for ($i = 0; $i < $count; $i++) {
			$a[] = array_change_key_case($data['monitorbon'][$i], CASE_LOWER);
		}
		$data['monitorbon'] = $a;
		// print_r($data['monitorbon']);exit();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Monitoring_bon', $data);
		$this->load->view('V_Footer', $data);
	}

	public function ajaxRow($ks, $pr)
	{
		$datha = $this->M_dtmasuk->monitorbon($ks, $pr);
		// $tes[] = array_values($datha);
		// echo "<pre>"; print_r($tes);exit();
		echo json_encode(array('data' => $datha));
	}

	public function RiwayatKebutuhan($ks = false)
	{
		$user1 = $this->session->user;
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Riwayat';
		$data['Menu'] = 'Riwayat';
		$data['SubMenuOne'] = 'Standar Kebutuhan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		if (empty($ks)) {
			$ks = $this->input->post('k3_adm_ks');
		}
		if (empty($ks)) {
			$ks = $kodesie;
		}
		$baru = '1999-01-01 01:10:10';
		$cek_terbaru = $this->M_dtmasuk->cek_terbaru($ks);
		if (!isset($cek_terbaru) || !empty($cek_terbaru)) {
			$baru = $cek_terbaru[0]['tgl_approve_tim'];
		}
		// $data['list'] = $this->M_dtmasuk->getListAprove($ks, $baru);
		$data['inputStandar'] = $this->M_order->getInputstd($ks);
		// echo "<pre>";
		// print_r($data['inputStandar']);exit();
		$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($ks);
		$data['seksi'] = '';
		$data['seksi'] = $this->M_dtmasuk->cekseksi($ks);


		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Riwayat_Kebutuhan', $data);
		$this->load->view('V_Footer', $data);
	}

	public function editRiwayatKebutuhan($id, $ks)
	{
		$user1 = $this->session->user;
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Riwayat';
		$data['Menu'] = 'Riwayat';
		$data['SubMenuOne'] = 'Standar Kebutuhan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['seksi'] = $this->M_dtmasuk->cekseksi($ks);
		$data['ks'] = $ks;
		$data['inputStandar'] = $this->M_order->getInputstd3($id);
		$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($ks);
		$data['id'] = $id;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Edit_Riwayat', $data);
		$this->load->view('V_Footer', $data);
	}


	public function SaveEditRiwayatKebutuhan()
	{
		// print_r($_POST);exit();
		$id = $this->input->post('id');
		$ks = $this->input->post('ks');
		$item = $this->input->post('item');
		$jmlUmum = $this->input->post('jmlUmum');
		$jmlUmum = round($jmlUmum / $item, 2);
		$staffJumlah = $this->input->post('staffJumlah');
		$staffJumlah = round($staffJumlah / $item, 2);
		$pkjJumlah = $this->input->post('pkjJumlah');
		$arr = array();
		foreach ($pkjJumlah as $key) {
			$arr[] = round($key / $item, 2);
		}
		$pkj = implode(',', $arr);
		// echo $pkj.' - ';
		// echo $jmlUmum.' - ';
		// echo $staffJumlah.' - ';
		// exit();

		$update = $this->M_dtmasuk->updateRiwayat($id, $jmlUmum, $staffJumlah, $pkj);
		if ($update) {
			//insert to sys.t_log_activity
			$aksi = 'P2K3 V2';
			$detail = "Update riwayat ID= " . $id;
			$this->log_activity->activity_log($aksi, $detail);
			//
			redirect('p2k3adm_V2/Admin/RiwayatKebutuhan/' . $ks);
		}
	}

	public function hapusRiwayatKebutuhan($id, $ks)
	{
		// echo $id;
		$delRiwayatKeb = $this->M_order->delRiwayatKeb($id);
		if ($delRiwayatKeb) {
			//insert to sys.t_log_activity
			$aksi = 'P2K3 V2';
			$detail = "Hapus riwayat kebutuhan ID= " . $id;
			$this->log_activity->activity_log($aksi, $detail);
			//
			redirect('p2k3adm_V2/Admin/RiwayatKebutuhan/' . $ks);
		}
	}

	public function hapusRiwayatOrder($id, $ks)
	{
		// echo $id;
		$delRiwayatOr = $this->M_order->delRiwayatOr($id);
		if ($delRiwayatOr) {
			//insert to sys.t_log_activity
			$aksi = 'P2K3 V2';
			$detail = "Hapus riwayat Order ID= " . $id;
			$this->log_activity->activity_log($aksi, $detail);
			//
			redirect('p2k3adm_V2/Admin/Riwayatorder/' . $ks);
		}
	}

	public function RiwayatOrder($kosie = false)
	{
		$user1 = $this->session->user;
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Riwayat';
		$data['Menu'] = 'Riwayat';
		$data['SubMenuOne'] = 'Order';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$ks = $this->input->post('k3_adm_ks');
		if (empty($ks)) {
			$ks = $kodesie;
		}
		if (!empty($kosie)) {
			$ks = $kosie;
		}
		$baru = '1999-01-01 01:10:10';
		$cek_terbaru = $this->M_dtmasuk->cek_terbaru($ks);
		if (!isset($cek_terbaru) || !empty($cek_terbaru)) {
			$baru = $cek_terbaru[0]['tgl_approve_tim'];
		}
		$data['tampil_data'] 		= $this->M_order->tampil_data($ks);
		$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($ks);
		$data['seksi'] = '';
		$data['seksi'] = $this->M_dtmasuk->cekseksi($ks);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Riwayat_Order', $data);
		$this->load->view('V_Footer', $data);
	}

	public function Email()
	{
		$user1 = $this->session->user;
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Setup';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Email';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['email'] = $this->M_dtmasuk->getEmail();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Setup_Email', $data);
		$this->load->view('V_Footer', $data);
	}

	public function addEmail()
	{
		$email = $this->input->post('email');
		$addEmail = $this->M_dtmasuk->addEmail($email);
	}
	public function editEmail()
	{
		$email = $this->input->post('email');
		$id = $this->input->post('id');
		$addEmail = $this->M_dtmasuk->editEmail($id, $email);
	}

	public function hapusEmail()
	{
		$id = $this->input->post('id');
		$addEmail = $this->M_dtmasuk->hapusEmail($id);
	}

	public function MasterItem()
	{
		$user1 = $this->session->user;
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Setup';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Master Item';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['Item'] = $this->M_dtmasuk->GetMasterItem();
		$data['Oracle'] = $this->M_dtmasuk->getItemOracle();
		// echo "<pre>";
		// print_r($data['Oracle']);exit();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Setup_Master_Item', $data);
		$this->load->view('V_Footer', $data);
	}

	public function EditMasterItem()
	{
		// print_r($_POST);exit();
		$kode_item = $this->input->post('kode_item');
		$bulan = $this->input->post('et_bulan_item');

		if (!empty($_FILES['et_file_item']['name'])) {
			$direktori_file		= $_FILES['et_file_item']['name'];
			$ekstensi_file		= pathinfo($direktori_file, PATHINFO_EXTENSION);
			$nama_file			= $kode_item . '.' . $ekstensi_file;
			// echo $nama_file;exit();
			if (!is_dir('./assets/upload/P2K3/item')) {
				mkdir('./assets/upload/P2K3/item', 0777, true);
				chmod('./assets/upload/P2K3/item', 0777);
			}
			$config['upload_path']          = './assets/upload/P2K3/item';
			// $config['allowed_types']        = 'jpg|png|gif|';
			$config['allowed_types']        = '*';
			$config['max_size']				= 50000;
			$config['file_name']		 	= $nama_file;
			$config['overwrite'] 			= TRUE;


			$this->upload->initialize($config);

			if ($this->upload->do_upload('et_file_item')) {
				$this->upload->data();
			} else {
				$errorinfo = $this->upload->display_errors();
				echo $errorinfo;
				exit();
			}

			$data = array(
				'xbulan'	=>	$bulan,
				'nama_file'	=>	$nama_file,
			);
		} else {
			$data = array(
				'xbulan'	=>	$bulan,
			);
		}
		$updete = $this->M_dtmasuk->updete($data, $kode_item);
		//insert to sys.t_log_activity
		$aksi = 'P2K3 V2';
		$detail = "Update kode item= " . $kode_item;
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect('p2k3adm_V2/Admin/MasterItem');
	}

	public function HapusMasterItem()
	{

		$id = $this->input->post('hapus_id');

		$delete = $this->M_dtmasuk->delItem($id);
		//insert to sys.t_log_activity
		$aksi = 'P2K3 V2';
		$detail = "Hapus master item ID= " . $id;
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect('p2k3adm_V2/Admin/MasterItem');
	}

	public function AddMasterItem()
	{
		// print_r($_POST);
		$val = $this->input->post('item');
		$val = explode('-', $val);

		$namaItem = $val[0];
		$kodeItem = $val[1];

		$satuan = $this->input->post('setItem');
		$xbulan = $this->input->post('xbulan');

		if (!empty($_FILES['et_file_item']['name'])) {
			$direktori_file		= $_FILES['et_file_item']['name'];
			$ekstensi_file		= pathinfo($direktori_file, PATHINFO_EXTENSION);
			$nama_file			= $kodeItem . '.' . $ekstensi_file;
			// echo $nama_file;exit();
			if (!is_dir('./assets/upload/P2K3/item')) {
				mkdir('./assets/upload/P2K3/item', 0777, true);
				chmod('./assets/upload/P2K3/item', 0777);
			}
			$config['upload_path']          = './assets/upload/P2K3/item';
			// $config['allowed_types']        = 'jpg|png|gif|';
			$config['allowed_types']        = '*';
			$config['max_size']				= 50000;
			$config['file_name']		 	= $nama_file;
			$config['overwrite'] 			= TRUE;


			$this->upload->initialize($config);

			if ($this->upload->do_upload('et_file_item')) {
				$this->upload->data();
			} else {
				$errorinfo = $this->upload->display_errors();
				echo $errorinfo;
				exit();
			}

			$data = array(
				'kode_item'	=>	$kodeItem,
				'item'		=>	$namaItem,
				'satuan'	=>	$satuan,
				'xbulan'	=>	$xbulan,
				'nama_file'	=>	$nama_file,
			);
		} else {
			$data = array(
				'kode_item'	=>	$kodeItem,
				'item'		=>	$namaItem,
				'satuan'	=>	$satuan,
				'xbulan'	=>	$xbulan,
				'nama_file'	=>	'-',
			);
		}

		$insert = $this->M_dtmasuk->insertItem($data);
		//insert to sys.t_log_activity
		$aksi = 'P2K3 V2';
		$detail = "Menambah master item kode= " . $kode_item;
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect('p2k3adm_V2/Admin/MasterItem');
	}

	public function getFoto()
	{
		header('Content-Type: application/json');

		$kode = $this->input->post('id');
		$getFoto = $this->M_dtmasuk->getFoto($kode);
		if (empty($getFoto)) {
			$poto = '';
			$nama = '';
			$kode = '';
		} else {
			$nama = $getFoto[0]['item'];
			$poto = $getFoto[0]['nama_file'];
			$kode = $getFoto[0]['kode_item'];
		}

		$data['nama'] = $nama;
		$data['foto'] = $poto;
		$data['kode'] = $kode;
		echo json_encode($data);
	}

	public function CetakBon($id)
	{

		/* 
			dk/2020-06-08
			// redirect ke fungsi cetak pdf di c_Order
		*/
		redirect('P2K3_V2/Order/PDF/' . $id);

		// $file = './assets/upload/P2K3/PDF/' . $id . '-Bon-Bppbg.pdf';
		// $filename = $id . '-Bon-Bppbg.pdf'; /* Note: Always use .pdf at the end. */
		// // echo $filename;exit();

		// header('Content-type: application/pdf');
		// header('Content-Disposition: inline; filename="' . $filename . '"');
		// header('Content-Transfer-Encoding: binary');
		// header('Content-Length: ' . filesize($file));
		// header('Accept-Ranges: bytes');

		// @readfile($file);
	}

	public function CetakBongagal($id)
	{
		echo '<pre>';
		$getBon = $this->M_dtmasuk->getBon($id);
		print_r($getBon);
		exit();

		//pdf

		$this->load->library('ciqrcode');
		if (!is_dir('./assets/img/temp_qrcode')) {
			mkdir('./assets/img/temp_qrcode', 0777, true);
			chmod('./assets/img/temp_qrcode', 0777);
		}
		$lembar = ceil(count($getBon) / 10);
		// echo $lembar;exit();
		$y = 0;
		$k = 1;
		for ($i = 0; $i < $lembar; $i++) {
			$max = (10 * $k);
			$data_array_2 = array();
			for ($x = $y; $x < $max; $x++) {
				if ($x < count($getBon)) {
					// echo $getBon[$x]['item_code'];
					$data_array_2[] = array(
						'kode' => $getBon[$x]['item_code'],
						'nama' => $getBon[$x]['item'],
						'satuan' => $getBon[$x]['satuan'],
						'diminta' => $getBon[$x]['jml_bon'],
						'account' => $getBon[$x]['account'],
						'ket' => 'UNTUK KEBUTUHAN APD PERIODE ' . $getBon[$x]['periode'],
					);
				} else {
					$data_array_2[] = array(
						'kode' => '',
						'nama' => '',
						'satuan' => '',
						'diminta' => '',
						'ket' => '',
						'account' => '',
						'produk' => '',
						'exp' => '',
						'lokasi_simpanku' => ''
					);
				}
				// echo $x;
			}
			// print_r($data_array_2);
			// exit();

			$data_array[] = array(
				'nomor' => $id,
				'tgl' => $getBon[0]['tanggal'],
				'gudang' => 'PNL-NPR',
				// 'seksi' => '',
				'seksi' => $getBon[0]['seksi_bon'],
				'pemakai' => $getBon[0]['pemakai'],
				'rdPemakai' => 'Seksi',
				'fungsi' => 'BARANG P2K3 & APD',
				'cost' => $getBon[0]['cost_center'],
				'kocab' => $getBon[0]['kode_cabang'],
				'data_body' => $data_array_2,
			);
			$y = $y + 10;
			$k++;
		}
		// 		print_r($data_array);
		// exit();
		$params['data']		= $id;
		$params['level']	= 'H';
		$params['size']		= 10;
		$config['black']	= array(224, 255, 255);
		$config['white']	= array(70, 130, 180);
		$params['savename'] = './assets/img/temp_qrcode/' . $id . '.png';
		$this->ciqrcode->generate($params);

		$data['kumpulandata'] = $data_array;
		// print_r($data_array);
		// exit;
		$this->load->library('Pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('', array(210, 148.5), 0, '', 10, 10, 5, 0, 0, 5, 'P');
		$pdf->setAutoTopMargin = 'stretch';
		$pdf->setAutoBottomMargin = 'stretch';
		$filename = $nomor_urut . '-Bon-Bppbg.pdf';
		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
		$html = $this->load->view('P2K3V2/Order/V_pdfBon', $data, true);
		// echo ($html);
		// exit();


		$pdf->setFooter('<div style="float: left; margin-right: 30px; width:200px">
  		<i style="font-size: 10px;margin-right: 10%">FRM-WHS-02-PDN-02 (Rev.04)</i>
  	</div>
  	<div style="float: left; width: 350px; background-color=red">
  		<i style="padding-left: 60%; font-size: 10px;margin-left: 10%">**) Pengebonan komponen/material produksi harus disetujui PPIC</i>
  	</div>
  	<div style="float: right; width: 100px">
  		<i style="padding-left: 60%; font-size: 10px;margin-left: 10%">Hal. {PAGENO} dari {nb}</i>
  	</div>');
		$pdf->WriteHTML($stylesheet, 1);
		$pdf->WriteHTML($html);
		$pdf->Output($filename, 'I');
	}

	public function cekHitung()
	{
		$pr = $this->input->post('pr');
		$ks = $this->input->post('kodesie');
		if (!is_numeric($ks)) {
			$ks = '';
		}
		$m = substr($pr, 0, 2);
		$y = substr($pr, 5, 5);
		$per = $y . '-' . $m;
		$data['allKs'] = $this->M_dtmasuk->allKs($per, $ks);
		$arrTable = array();
		foreach ($data['allKs'] as $key) {
			$table = '';
			$record = $this->M_dtmasuk->getlistHitung($per, $key['kodesie']);
			$table .= '<table class="table table-bordered table-hover table-striped text-center">
					<caption style="color:#000"><b>' . $key['kodesie'] . ' - ' . $key['section_name'] . '</b></caption>
					<tr>
						<th style="width:20px;">No</th>
						<th style="width:200px;">Kode Item</th>
						<th style="width:200px;">Item</th>
						<th style="width:200px;">Data Standar Kebutuhan</th>
						<th style="width:200px;">Tanggal Approve Standar</th>
						<th style="width:200px;">Data Order</th>
					</tr>';
			$i = 1;
			foreach ($record as $row) {
				$a = $row['jml_item'];
				$b = $row['jml_pekerja'];
				$ax = explode(',', $a);
				$bx = explode(',', $b);
				if (count($ax) !== count($bx)) {
					$table .= '<tr class="aw SmityWeberJegerMenJensen aw ">
					<td>' . $i . '</td>
					<td>' . $row["kode_item"] . '</td>
					<td>' . $row["item"] . '</td>
					<td>' . $row["jml_item"] . '</td>
					<td>' . $row["tgl_approve_tim"] . '</td>
					<td>' . $row["jml_pekerja"] . '</td>
				</tr>';
					$i++;
				} else {
					// $table .= '<tr></tr>';
					$table .= '';
				}
			}
			$table .= '</table><br>';
			$arrTable[] = $table;
		}
		$newTable = '';
		foreach ($arrTable as $key) {
			if (strrpos($key, 'SmityWeberJegerMenJensen') !== false) {
				$newTable .= $key;
			} else {
				//do not
			}
		}
		// print_r($arrTable);
		// exit();

		$cekDuplikat = $this->M_dtmasuk->cekDuplikat();
		if (count($cekDuplikat) > 0) {
			$newTable .= '<hr><table class="table table-bordered table-hover table-striped text-center">
						<caption style="color:red"><b>TERDAPAT DATA GANDA PADA STANDAR KEBUTUHAN YANG DIGUNAKAN!!!</b></caption>
						<tr>
							<th style="width:20px;">No</th>
							<th style="width:200px;">Kode Item</th>
							<th style="width:200px;">Item</th>
							<th style="width:200px;">Kodesie</th>
							<th style="width:200px;">Seksi</th>
						</tr>';
			$x = 1;
			foreach ($cekDuplikat as $key) {
				$newTable .= '<tr class="aw SmityWeberJegerMenJensen aw ">
						<td>' . $x . '</td>
						<td>' . $key["kode_item"] . '</td>
						<td>' . $key["item"] . '</td>
						<td>' . $key["kodesie"] . '</td>
						<td>' . $key["section_name"] . '</td>
					</tr>';
				$x++;
			}
			$newTable .= '</table>
				<p style="color:red"><b>Silahkan hapus data yang tidak dipakai pada menu Riwayat Standar Kebutuhan.</b></p>';
		}
		if (strlen($newTable) < 10) {
			echo '<center><ul class="list-group"><li class="list-group-item">Data Aman</li></ul></center>';
		} else {
			echo $newTable;
		}
	}

	public function monitoring_stok()
	{
		$user1 = $this->session->user;
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'P2K3 TIM V2 Monitoring Stok';
		$data['Menu'] = 'Monitoring Stok';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['stokTks'] = $this->M_dtmasuk->getStokGudang('PNL-TKS');
		$data['stokPusat'] = $this->M_dtmasuk->getStokGudang('PNL-DM');
		// echo "<pre>";
		// print_r($data['stokPusat']);exit();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Monitoring_Stok', $data);
		$this->load->view('V_Footer', $data);
	}
}
