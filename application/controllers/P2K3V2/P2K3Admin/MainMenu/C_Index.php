<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * When i trying to understanding this code
 * https://jambiekspres.co.id/foto_berita/2021/03/23/977.jpg
 * 
 */

date_default_timezone_set("Asia/Jakarta");

// array must have index of standard/actual and nama_apd
function filter_apd($array)
{
	return (@$array['standard'] || @$array['actual']) && @$array['nama_apd'];
}

class EncryptCar
{
	const key = '1';

	static function encode($str)
	{
		return str_replace(
			array(
				'+',
				'/',
				'='
			),
			array(
				'-',
				'_',
				'~'
			),
			(new CI_Encrypt)->encode($str, static::key)
		);
	}

	static function decode($encoded)
	{
		return (new CI_Encrypt)->decode(str_replace(
			array(
				'-',
				'_',
				'~'
			),
			array(
				'+',
				'/',
				'='
			),
			$encoded
		), static::key);
	}
}

class C_Index extends CI_Controller
{
	/**
	 * P2K3 Responsibility ID
	 * Nomor ini didapat dari tabel erp
	 */
	const P2K3_TIM_RESPONSIBILITY_ID = 2615;
	const P2K3_SEKSI_RESPONSIBILITY_ID = 2614;

	/**
	 * Hak akses admin
	 * - Dapat melihat data kecelakaan semua seksi
	 * - Dapat menghapus data kecelakaan
	 * - Dapat menginputkan data kecelakaan semua orang pada seksi
	 */
	protected $isAdmin = false;

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
		$this->load->library('general');
		$this->load->library('personalia');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('P2K3V2/P2K3Admin/M_dtmasuk');
		$this->load->model('P2K3V2/MainMenu/M_order');
		$this->load->model('MasterPekerja/Pekerja/PekerjaKeluar/M_pekerjakeluar');
		$this->checkSession();

		// P2K3 TIM member / ordinally user
		$this->setPrevilages();
	}

	private function setPrevilages()
	{
		// check admin p2k3
		if ($this->session->responsibility_id == self::P2K3_TIM_RESPONSIBILITY_ID) {
			$this->isAdmin = true;
		}
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if ($this->session->is_logged) { } else {
			redirect('');
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
		$data['get_list_approve_new'] = $this->M_dtmasuk->getListApproveNew($ks);

		$data['daftar_pekerjaan']	= $this->M_order->daftar_pekerjaan($ks);
		$data['seksi'] = $this->M_dtmasuk->cekseksi($ks);

		$data['ks'] = substr($ks, 0, 7);

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
		// 	$b = $key['jml_pekerja'];P2K3_TIM_RESPONSIBILITY_ID
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
				$moq = $this->M_dtmasuk->getMoq($kode)['MINIMUM_ORDER_QUANTITY'];
				if (empty($moq)) {
					$moq = 1;
				}
				$stok = $this->M_dtmasuk->stokOracle($kode, 'PNL-DM');
				$po = $this->M_dtmasuk->OutstandingPO($kode);
				$totalPO = 0;

				$poarr = array();
				if (!empty($po)) {
					foreach ($po as $p) {
						if (substr($p['PO_NUM'], 0, 2) == substr(date('Y'), 2, 2) && $p['LOCATION_CODE'] == 'PNL-DM') {
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

				$lnobon = $key['list_no_bon'];
				if (empty($lnobon)) {
					$key['transact'] = 0;
				} else {
					$key['transact'] = $this->M_dtmasuk->getttlTransactAPD($lnobon, $kode, $pr);
				}

				$jpp = ceil(($a * 1.1) + $out - $stok - $totalPO);
				$key['jpp'] = ($jpp < 0) ? 0 : ceil($jpp / $moq) * $moq;

				$new[] = $key;
				$data['toHitung'] = $new;
				// print_r($po);
			}

			foreach ($data['toHitung2'] as $row) {
				$kode = $row['item_kode'];
				//tks saat ini 2 gudang
				$moq = $this->M_dtmasuk->getMoq($kode)['MINIMUM_ORDER_QUANTITY'];
				if (empty($moq)) {
					$moq = 1;
				}
				$stok = $this->M_dtmasuk->stokOracle($kode, "PNL-TKS");
				$stok += $this->M_dtmasuk->stokOracle($kode, "PNL-NPR");
				$po = $this->M_dtmasuk->OutstandingPO($kode);
				$totalPO = 0;

				$poarr = array();
				if (!empty($po)) {
					foreach ($po as $p) {
						if (substr($p['PO_NUM'], 0, 2) == substr(date('Y'), 2, 2) && ($p['LOCATION_CODE'] == 'PNL-TKS' || $p['LOCATION_CODE'] == 'PNL-NPR')) {
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

				$lnobon = $key['list_no_bon'];
				if (empty($lnobon)) {
					$row['transact'] = 0;
				} else {
					$row['transact'] = $this->M_dtmasuk->getttlTransactAPD($lnobon, $kode, $pr);
				}

				$jpp = ceil(($a * 1.1) + $out - $stok - $totalPO);
				$row['jpp'] = ($jpp < 0) ? 0 : ceil($jpp / $moq) * $moq;

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
		$keterangan = $this->input->post('keterangan');
		$lampiran = $this->input->post('lampiran');
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
				'keterangan' => $keterangan[$i],
				'lampiran'	=> str_replace(' ', '_', $_FILES['lampiran']['name'][$i])
			);
			$a += count($daftar_pekerjaan);
			//insert to sys.t_log_activity
			$aksi = 'P2K3 V2';
			$detail = "Input Standar Kode_item= " . $item[$i] . " Status=3";
			$this->log_activity->activity_log($aksi, $detail);
			//
			$input = $this->M_order->save_standar($data);
		}

		$this->load->library('upload');
		if (!is_dir('./assets/upload/P2K3DocumentApproval')) {
			mkdir('./assets/upload/P2K3DocumentApproval', 0777, true);
			chmod('./assets/upload/P2K3DocumentApproval', 0777);
		}

		$cpt = count($_FILES['lampiran']['name']);
		// echo $cpt;
		$arrayName = array();
		$files = $_FILES;
		for ($i = 0; $i < $cpt; $i++) {
			$filename = $files['lampiran']['name'][$i];
			if (empty($filename)) continue;

			$_FILES['lampiran']['name'] = str_replace(' ', '_', $files['lampiran']['name'][$i]);
			$arrayName[] = $_FILES['lampiran']['name'];
			$_FILES['lampiran']['type'] = $files['lampiran']['type'][$i];
			$_FILES['lampiran']['tmp_name'] = $files['lampiran']['tmp_name'][$i];
			$_FILES['lampiran']['error'] = $files['lampiran']['error'][$i];
			$_FILES['lampiran']['size'] = $files['lampiran']['size'][$i];

			$this->upload->initialize($this->init_config());
			if ($this->upload->do_upload('lampiran')) {
				$this->upload->data();
			} else {
				$errorinfo = $this->upload->display_errors();
				echo $errorinfo;
				exit();
			}
		}
		redirect('p2k3adm_V2/Admin/inputStandarTIM');
	}

	function init_config()
	{
		$config = array();
		$config['upload_path'] = 'assets/upload/P2K3DocumentApproval';
		$config['allowed_types'] = 'pdf';
		$config['overwrite']     = 1;

		return $config;
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

		$pr = $this->input->get('k3_periode');
		$ks = $this->input->get('k3_adm_ks');
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

		$monitorbonSafetyShoes = $this->M_dtmasuk->getBonSafetyShoes($ks, $pr);
		$total_safety_shoes = count($monitorbonSafetyShoes);
		$bon_safety_shoes = array();
		for ($i = 0; $i < $total_safety_shoes; $i++) {
			$bon_safety_shoes[] = array_change_key_case($monitorbonSafetyShoes[$i], CASE_LOWER);
		}

		$safetyShoes = [];
		foreach ($bon_safety_shoes as $item) {
			$safetyShoes[$item['no_bon']][] = $item;
		}
		$data['monitorBonSafetyShoes'] = $safetyShoes;

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

	/**
	 * Page
	 */
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

	/**
	 * Page
	 */
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

	/**
	 * Page
	 */
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

	/**
	 * Action
	 */
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

	/**
	 * Delete action
	 */
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
		$detail = "Menambah master item kode= " . $kodeItem;
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect('p2k3adm_V2/Admin/MasterItem');
	}

	/**
	 * Get APD Foto and result json
	 */
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

	/**
	 * Print pdf
	 */
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

	/**
	 * ??
	 */
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

	/**
	 * Page
	 */
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

	/**
	 * Page
	 * 
	 * @param String next index
	 */
	public function monitoringKK($index = null)
	{
		$allIndex = 'Semua';

		if ($index !== null && $index !== $allIndex) return show_404();

		$kodesie = $this->session->kodesie;

		if ($this->isAdmin) {
			$data  = $this->general->loadHeaderandSidemenu('P2K2 - Monitoring Kecelakaan Kerja', 'Monitoring Kecelakaan Kerja', 'Monitoring Kecelakaan Kerja', '', '');
		} else {
			if ($index == $allIndex) {
				$data  = $this->general->loadHeaderandSidemenu('P2K2 - Monitoring Kecelakaan Kerja', 'Monitoring Kecelakaan Kerja', 'Monitoring Kecelakaan Kerja', 'Semua', '');
			} else {
				$data  = $this->general->loadHeaderandSidemenu('P2K2 - Monitoring Kecelakaan Kerja', 'Monitoring Kecelakaan Kerja', 'Monitoring Kecelakaan Kerja', 'Seksi', '');
			}
		}

		$data['year'] = $this->input->get('y');
		$data['isUnit'] = substr($this->session->kodesie, 5) === '0000';

		if (empty($data['year'])) redirect(current_url() . '?y=' . date('Y'));

		if ($this->isAdmin || $index == $allIndex) {
			// get all data
			$data['list'] = $this->M_dtmasuk->getK3K($data['year']);
		} elseif ($data['isUnit']) {
			$trefjabatan = $this->M_order->getTrefjabatan($this->session->user);
			$trefjabatan = array_map(function ($refjabatan) {
				return substr($refjabatan['kodesie'], 0, 5);
			}, $trefjabatan);

			$data['list'] = $this->M_dtmasuk->getK3K($data['year'], $trefjabatan);
		} else {
			// get all from their section
			$data['list'] = $this->M_dtmasuk->getK3K($data['year'], $kodesie);
		}

		$data['lokasi'] = array_column($this->M_pekerjakeluar->getLokasiKerja(), 'lokasi_kerja', 'id_');
		$data['lokasi'][999] = 'LAKA';

		$data['isAdmin'] = $index == $allIndex ? false : $this->isAdmin;
		$data['allIndex'] = $allIndex;
		$data['index'] = $index;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/V_Index', $data);
		$this->load->view('V_Footer', $data);
	}

	/**
	 * Page
	 */
	public function add_monitoringKK()
	{
		$data  = $this->general->loadHeaderandSidemenu('P2K2 - Monitoring Kecelakaan Kerja', 'Tambah Data', 'Monitoring Kecelakaan Kerja', '', '');

		$data['lokasi'] = $this->M_pekerjakeluar->getLokasiKerja();
		$data['tkp'] = $this->M_dtmasuk->getlistTKP('');

		$apd_list = require(__DIR__ . "/../Data/Apd.php");
		$apd_list_chunk = array_chunk($apd_list, 7); // 3 bagian

		$data['apd_list_chunk'] = $apd_list_chunk;


		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);

		$kd_jabatan_supervisor = 13;

		// for development
		// $kd_jabatan_supervisor = 99;

		$employee = $this->M_dtmasuk->getEmployeeByNoind($this->session->user);
		// Hanya jabatan supervisor ke atas yang dapat menambahkan kecelakaan kerja
		if ($employee->kd_jabatan <= $kd_jabatan_supervisor) {
			$this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/V_Tambah', $data);
		} else {
			$this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/Page/V_NotAllowed', [
				'text' => 'Hanya supervisor ke atas yang dapat melakukan penginputan data'
			]);
		}

		$this->load->view('V_Footer', $data);
	}

	public function detail_pkj_mkk()
	{
		$noind = $this->input->get('noind');
		$date = $this->input->get('tglKec');
		$tgl = explode(' ', $date)[0];
		$data = $this->M_dtmasuk->getdetail_pkj_mkk($noind);

		return response()->json($data);
	}

	/**
	 * ??
	 */
	public function ket_mkk()
	{
		$date = $this->input->get('tgl');
		$noind = $this->input->get('noind');
		$ex = explode(' ', $date);
		$wkt = $ex[1];
		$tgl = $ex[0];

		$shift = $this->M_dtmasuk->getShiftByPKJ($noind, $tgl);
		if (empty($shift) || $shift == '') {
			$data['success'] = '0';
			echo json_encode($data);
			return;
			exit();
		}
		// print_r($shift);exit();
		$brk = strtotime($shift['break_mulai']);
		$ist = strtotime($shift['ist_mulai']);
		$msk = strtotime($shift['jam_msk']);
		$plg = strtotime($shift['jam_plg']);
		$time = strtotime($wkt);

		if (trim($shift['kd_shift']) == '2' || trim($shift['kd_shift']) == '3') {
			if ($time >= strtotime('10:00:00') && $time <= $brk) {
				$ket1 = 'Awal - Break';
				$rng1 = 1;
			} elseif ($time >= $brk && $time <= $ist) {
				$ket1 = 'Break - Istirahat';
				$rng1 = 2;
			} elseif ($time >= $ist && $time <= $plg) {
				$ket1 = 'Istirahat - Pulang';
				$rng1 = 3;
			} else {
				$ket1 = 'Istirahat - Pulang';
				$rng1 = 3;
			}
		} else {
			if ($time <= $brk) {
				$ket1 = 'Awal - Break';
				$rng1 = 1;
			} elseif ($time >= $brk && $time <= $ist) {
				$ket1 = 'Break - Istirahat';
				$rng1 = 2;
			} elseif ($time >= $ist) {
				$ket1 = 'Istirahat - Pulang';
				$rng1 = 3;
			}
		}
		// echo $ket1;

		$rng[] = ['05:59:59', '09:00:00', '06:00:00', '09:00:00', 1];
		$rng[] = ['09:00:01', '11:45:00', '09:15:00', '11:45:00', 2];
		$rng[] = ['11:45:01', '14:00:00', '12:30:00', '14:00:00', 3];
		$rng[] = ['14:00:00', '16:00:00', '14:00:00', '16:00:00', 4];
		$rng[] = ['16:00:01', '18:00:00', '16:15:00', '18:00:00', 5];
		$rng[] = ['18:00:01', '22:00:00', '18:45:00', '22:00:00', 6];
		$rng[] = ['01:00:00', '05:00:00', '01:00:00', '05:00:00', 8];
		$rngs[]  = ['22:00:00', '23:59:59'];
		$rngs[]  = ['00:00:00', '01:00:00'];
		$ket2 = 'Tidak Ada';

		foreach ($rng as $k) {
			if ($time >= strtotime($k[0]) && $time <= strtotime($k[1])) {
				$ket2 = $k[2] . ' - ' . $k[3];
				$rng2 = $k[4];
				break;
			}
		}

		if ($ket2 == 'Tidak Ada') {
			foreach ($rngs as $k) {
				if ($time >= strtotime($k[0]) && $time <= strtotime($k[1])) {
					$ket2 = '22:00:00 - 01:00:00';
					$rng2 = 7;
					break;
				}
			}
		}

		$kode = substr($noind, 0, 1);
		$dat = $this->M_dtmasuk->getdetail_pkj_mkk($noind, $date);
		$kd_jabatan = $dat['kd_jabatan'];
		if ($kode == 'K' || $kode == 'P'  || $kode == 'R' || $kode = 'F') {
			$masakrj = $this->M_dtmasuk->getMasaKerja($noind, $tgl);
		} elseif ($kode == 'A' || $kode == 'B' || $kode == 'C' || $kode == 'H' || $kode == 'J' || $kode == 'T') {
			$masakrj = $this->M_dtmasuk->getMasaKerja3($noind, $tgl);
		} elseif ($kd_jabatan == '13' || $kd_jabatan == '19') {
			$masakrj = $this->M_dtmasuk->getMasaKerja2($noind, $tgl);
		} else {
			$masakrj = '-';
		}
		if ($masakrj != '-') {
			$masa = $masakrj['tahun'] . " tahun " . $masakrj['bulan'] . " bulan " . $masakrj['hari'] . " hari";
			// if ($masakrj['tahun'] > 0) {
			// 	$msa = 
			// }elseif ($masakrj['bulan'] >= 3 ) {
			// 	$msa = 
			// }else{

			// }
		} else {
			$masa = '-';
		}
		$data['masa'] = $dat['maskerja'];
		$data['masa_kerja'] = $masa;
		// print_r($ket2);
		$data['success'] = '1';
		$data['ket1'] = $ket1;
		$data['ket2'] = $ket2;
		$data['rng1'] = $rng1;
		$data['rng2'] = $rng2;
		echo json_encode($data);
	}

	/**
	 * 
	 * Submit kecelakaan kerja
	 * 
	 * 
	 */
	public function submit_monitoringKK()
	{
		$this->load->library('upload');
		$noind = $this->input->post('noind');
		$kodesie_berlaku = $this->input->post('kodesie_berlaku');
		$tgl_kecelakaan = $this->input->post('tgl_kecelakaan');
		$tgl_masuk_pos = $this->input->post('tgl_masuk_pos');
		// var_dump(date_diff(date_create($tgl_kecelakaan), date_create($tgl_masuk_pos))->format('%y Tahun %m Bulan %d Hari'));
		// die;
		$tkp = $this->input->post('tkp');
		$range1 = $this->input->post('range1');
		$range2 = $this->input->post('range2');
		$masa_kerja = $this->input->post('masa_kerja');
		$lokasi_kerja = $this->input->post('lokasi_kerja');
		$jenis_pekerjaan = $this->input->post('jenis_pekerjaan');
		$kasus = $this->input->post('kasus');
		$kronologi = $this->input->post('kronologi');
		$kondisi = $this->input->post('kondisi');
		$penyebab = $this->input->post('penyebab');
		$tindakan = $this->input->post('tindakan');
		$bsrl = $this->input->post('bsrl');
		$prosedur = $this->input->post('prosedur');
		$unsafe = $this->input->post('unsafe');
		$kriteria = $this->input->post('kriteria');
		$nama_pekerjaan = $this->input->post('nama_pekerjaan');
		// kodesie pekerja disaat itu (kodesie bisa berubah karena sedang diperbantukan)
		$user_kodesie = $this->input->post('user_kodesie');

		$lampiran_foto = $this->input->post('lampiran_foto');

		$error_log = [];

		$md5_string = md5(date('Ymdhis'));

		// lampiran foto
		$lampiran_list = [];
		if ($lampiran_foto && is_array($lampiran_foto)) {
			$path = 'assets/upload/P2K3v2/kecelakaan_kerja/foto/';
			foreach ($lampiran_foto as $i => $base64String) {
				if (empty($base64String)) continue;

				$filename = "accident-$md5_string-$i";
				$actualFilename = $this->StoreBase64Image($path, $base64String, $filename);

				$lampiran_list[] = $actualFilename;
			}
		}
		$tgl_car = $this->input->post('tgl_car') ?: null;
		$pic = $this->input->post('pic') ?: null;
		$target_car = $this->input->post('target_car') ?: null;
		$close_car = $this->input->post('close_car') ?: null;

		$kategori = $this->input->post('kategori');
		$bagian_tubuh = $this->input->post('bagian_tubuh');
		$apd = $this->input->post('apd');
		$faktor = $this->input->post('faktor');
		$datapkj = $this->M_dtmasuk->getdetail_pkj_mkk($noind);
		$kodesie = $datapkj['kodesie'];
		$lokasi = $datapkj['lokasi_kerja'];

		# :TODO -> Cari Aktual masa kerja di seksi

		$arr = array(
			'noind' => $noind, // 
			'kodesie' => $kodesie, // 
			// 'kodesie_berlaku' => $kodesie_berlaku, // seksi pekerja saat itu
			'lokasi_kerja' => $lokasi, // 
			'masa_kerja' => $masa_kerja, // string
			'waktu_kecelakaan' => $tgl_kecelakaan, // Y-m-d H:i:s
			'tgl_masuk_pos' => $tgl_masuk_pos, // Y-m-d
			'range_waktu1' => $range1, // 1|2|3
			'range_waktu2' => $range2, // 1-8
			'tkp' => $tkp, // string
			'lokasi_kerja_kecelakaan' => $lokasi_kerja, // 01-21
			'nama_pekerjaan' => $nama_pekerjaan, // string
			'jenis_pekerjaan' => $jenis_pekerjaan, // 1-3
			'kasus' => $kasus, // long text
			'kronologi' => $kronologi, // long text
			'kondisi' => $kondisi, // long text
			'penyebab' => $penyebab, // long text
			'tindakan' => $tindakan, // long text
			'prosedur' => $prosedur, // 1-3
			'bsrl' => $bsrl, // 1-6
			'unsafe' => $unsafe, // 1|2
			'kriteria_stop_six' => $kriteria, // 1-6
			'pic' => $pic, // noind
			'tgl_car' => $tgl_car, 	// Y-m-d H:i:s
			'tgl_selesai_car' => $target_car, // Y-m-d H:i:s
			'tgl_close_car' => $close_car, // Y-m-d H:i:s
			'lampiran_1' => isset($lampiran_list[0]) ? $lampiran_list[0] : null, // filename
			'lampiran_2' => isset($lampiran_list[1]) ? $lampiran_list[1] : null, // filename
			'car_is_created' => false, // filename
			'user_created_by' => $this->session->user, // string of noind
			'user_kodesie' => $user_kodesie // string of kodesie
		);

		$id_kecelakaan = $this->M_dtmasuk->insk3k_kecelakaan($arr); // int

		# Insert k3k_bagian_tubuh
		$arrB = array();
		if (!empty($bagian_tubuh)) {
			foreach ($bagian_tubuh as $organ) {
				$arrB[] = array(
					'id_kecelakaan' => $id_kecelakaan,
					'bagian_tubuh' => $organ,
				);
			}
			if (!empty($arrB))
				$ins2 = $this->M_dtmasuk->insk3k_kecelakaan_lain($arrB, 'k3.k3k_bagian_tubuh');
		}

		# Insert k3k_faktor_kecelakaan
		$arrF = array();
		if (!empty($faktor)) {
			foreach ($faktor as $k) {
				$arrF[] = array(
					'id_kecelakaan' => $id_kecelakaan,
					'faktor' => $k,
				);
			}
			if (!empty($arrF))
				$ins2 = $this->M_dtmasuk->insk3k_kecelakaan_lain($arrF, 'k3.k3k_faktor_kecelakaan');
		}

		# Insert k3k_kategori_kecelakaan
		if (!empty($kategori)) {
			$arrK = array();
			foreach ($kategori as $k) {
				$arrK[] = array(
					'id_kecelakaan' => $id_kecelakaan,
					'kategori' => $k,
				);
			}
			if (!empty($arrK))
				$ins2 = $this->M_dtmasuk->insk3k_kecelakaan_lain($arrK, 'k3.k3k_kategori_kecelakaan');
		}

		# Insert k3k_penggunaan_apd
		if (!empty($apd)) {
			$arrP = array();
			foreach ($apd as $k) {
				$arrP[] = array(
					'id_kecelakaan' => $id_kecelakaan,
					'penggunaan_apd' => $k,
				);
			}
			if (!empty($arrP))
				$ins2 = $this->M_dtmasuk->insk3k_kecelakaan_lain($arrP, 'k3.k3k_penggunaan_apd');
		}

		# Insert k3k_kecelakaan_apd

		// apd terdaftar
		$apd_digunakan = $this->input->post('apd_digunakan');
		$apd_digunakan = array_filter($apd_digunakan, 'filter_apd'); // filter valid user input

		// apd lain
		$apd_digunakan_lain = $this->input->post('apd_digunakan_lain');
		$apd_digunakan_lain = array_filter($apd_digunakan_lain, 'filter_apd'); // filter valid user input

		// merge all
		$all_apd_digunakan = array_merge($apd_digunakan, $apd_digunakan_lain);

		// map with true value
		// change standard & actual to TRUE
		$all_apd_digunakan = array_map(function ($apd) use ($id_kecelakaan) {
			return [
				'id_kecelakaan' => $id_kecelakaan,
				'nama_apd' => $apd['nama_apd'],
				'standard' => isset($apd['standard']),
				'actual'	 => isset($apd['actual'])
			];
		}, $all_apd_digunakan);

		// if array is not empty
		if (!empty($all_apd_digunakan)) {
			$this->M_dtmasuk->insertKecelakaanApd($table = 'k3.k3k_kecelakaan_apd', $data = $all_apd_digunakan);
		}

		# End reference

		return redirect('p2k3adm_V2/Admin/monitoringKK');
	}

	/**
	 * Delete all related Kecelakaan
	 * AJAX
	 */
	public function del_k3k()
	{
		$id = EncryptCar::decode($this->input->post('id'));

		try {
			if (!$this->isAdmin) throw new Exception("Anda tidak berwenang untuk menghapus data ini");
			$this->M_dtmasuk->delK3K('k3.k3k_kecelakaan', $id);
			$this->M_dtmasuk->delK3K('k3.k3k_bagian_tubuh', $id);
			$this->M_dtmasuk->delK3K('k3.k3k_faktor_kecelakaan', $id);
			$this->M_dtmasuk->delK3K('k3.k3k_kategori_kecelakaan', $id);
			$this->M_dtmasuk->delK3K('k3.k3k_penggunaan_apd', $id);
			$this->M_dtmasuk->delK3K('k3.k3k_kecelakaan_apd', $id);

			return response()->json([
				'code' => 200,
				'message' => "Success"
			]);
		} catch (Exception $e) {
			return response()->json([
				'code' => 400,
				'message' => $e->getMessage()
			], 400);
		}
	}

	/**
	 * Get kecelakaan with detail
	 * 
	 * @param Int $id
	 * 
	 * @return Array<Array>|Null
	 */
	private function getKecelakaanDetail($id)
	{
		$data['kecelakaan'] = $this->M_dtmasuk->getKecelakaan($id);
		$data['kecelakaan']['masa_masuk_pos'] = date_diff(date_create($data['kecelakaan']['waktu_kecelakaan']), date_create($data['kecelakaan']['tgl_masuk_pos']))->format('%y Tahun %m Bulan %d Hari');
		$created = $this->M_dtmasuk->getEmployeeByNoind($data['kecelakaan']['user_created_by']);
		$data['kecelakaan']['userName_created_by'] = !empty($created) ? $created->nama : '-';
		if (empty($data['kecelakaan'])) return NULL;

		$noind = $data['kecelakaan']['noind'];
		$data['pkj'] = $this->M_dtmasuk->getdetail_pkj_mkk($noind);

		$noind = $data['kecelakaan']['pic'];
		$data['pic'] = $this->M_dtmasuk->getdetail_pkj_mkk($noind);

		$data['bagian'] = $this->M_dtmasuk->getAllk3k('k3.k3k_bagian_tubuh', $id);
		$data['bagianc'] = array_column($data['bagian'], 'bagian_tubuh');

		$data['faktor'] = $this->M_dtmasuk->getAllk3k('k3.k3k_faktor_kecelakaan', $id);
		$data['faktorc'] = array_column($data['faktor'], 'faktor');

		$data['kategori'] = $this->M_dtmasuk->getAllk3k('k3.k3k_kategori_kecelakaan', $id);
		$data['kategoric'] = array_column($data['kategori'], 'kategori');


		$data['apd'] = $this->M_dtmasuk->getAllk3k('k3.k3k_penggunaan_apd', $id);
		$data['apdc'] = array_column($data['apd'], 'penggunaan_apd');

		$apd_digunakan_all = $this->M_dtmasuk->getAllk3k('k3.k3k_kecelakaan_apd', $id);

		$listOfAPD = require(__DIR__ . "/../Data/Apd.php");
		$listOfAPD_name = array_column($listOfAPD, 'name');

		$data['apd_list'] = $listOfAPD;
		$data['apd_list_chunk_3'] = array_chunk($listOfAPD, 7);

		// apd in list of apd
		$data['apd_digunakan'] = array_filter($apd_digunakan_all, function ($apd) use ($listOfAPD_name) {
			return in_array($apd['nama_apd'], $listOfAPD_name);
		});
		$data['apd_digunakan_name'] = array_column($data['apd_digunakan'], 'nama_apd');

		// apd not in fixed list of apd
		$data['apd_digunakan_lain'] = array_filter($apd_digunakan_all, function ($apd) use ($listOfAPD_name) {
			return !in_array($apd['nama_apd'], $listOfAPD_name);
		});

		return $data;
	}

	/**
	 * Convert image file to base64 string format
	 */
	private function imageToBase64($source)
	{
		if (empty($source) || !file_exists(str_replace(base_url(), './', $source))) return "";
		$type = pathinfo($source, PATHINFO_EXTENSION);
		$data = file_get_contents($source);

		if (empty($data)) return "";

		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

		return $base64;
	}

	/**
	 * Page
	 */
	public function edit_monitoringKK()
	{
		$data  = $this->general->loadHeaderandSidemenu('P2K2 - Monitoring Kecelakaan Kerja', 'Edit Data', 'Kecelakaan Kerja', '', '');
		$id = EncryptCar::decode($this->input->get('id'));

		$kecelakaan = $this->getKecelakaanDetail($id);
		if (empty($kecelakaan)) return $this->load->view('V_404');

		// merge
		$data = array_merge($data, $kecelakaan);

		$data['lokasi'] = array_column($this->M_pekerjakeluar->getLokasiKerja(), 'lokasi_kerja', 'id_');
		$data['lokasi'][999] = 'LAKA';

		if (isset($_GET['debug'])) {
			debug($data);
		}

		// lampiran photo in base64
		$attachment_path = "/assets/upload/P2K3v2/kecelakaan_kerja/foto/";
		$data['base64Attachment'] = [
			null, // because number on front end start from 1
			$this->imageToBase64(empty($kecelakaan['kecelakaan']['lampiran_1']) ? null : base_url($attachment_path . $kecelakaan['kecelakaan']['lampiran_1'])),
			$this->imageToBase64(empty($kecelakaan['kecelakaan']['lampiran_2']) ? null : base_url($attachment_path . $kecelakaan['kecelakaan']['lampiran_2'])),
		];
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/V_Edit', $data);
		$this->load->view('V_Footer', $data);
		$this->session->unset_userdata('update_mkk');
	}

	protected function StoreBase64Image($path, $base64String, $filename)
	{
		if (empty($base64String)) return '';
		list($type, $imageData) = explode(';', $base64String);
		list(, $extension) = explode('/', $type);
		list(, $imageData)      = explode(',', $imageData);
		$fileName = $filename . '.' . $extension;
		$fullFilename = $path . $fileName;
		$imageData = base64_decode($imageData);
		@file_put_contents($fullFilename, $imageData);

		return $fileName;
	}

	/**
	 * YPJ
	 * Need refactory, this code is not DRY n clean code
	 * 
	 * @method POST
	 */
	public function update_monitoringKK()
	{
		// var_dump($_POST);
		// die;
		$noind = $this->input->post('noind');
		$tgl_kecelakaan = $this->input->post('tgl_kecelakaan');
		$tgl_masuk_pos = $this->input->post('tgl_masuk_pos');

		$tkp = $this->input->post('tkp');
		$range1 = $this->input->post('range1') ?: null;
		$range2 = $this->input->post('range2') ?: null;
		$masa_kerja = $this->input->post('masa_kerja');
		$lokasi_kerja = $this->input->post('lokasi_kerja');
		$jenis_pekerjaan = $this->input->post('jenis_pekerjaan') ?: null;
		$kasus = $this->input->post('kasus');
		$kronologi = $this->input->post('kronologi');

		$kondisi = $this->input->post('kondisi');
		$penyebab = $this->input->post('penyebab');
		$tindakan = $this->input->post('tindakan');
		$bsrl = $this->input->post('bsrl');
		$prosedur = $this->input->post('prosedur') ?: null;
		$unsafe = $this->input->post('unsafe') ?: null;
		$kriteria = $this->input->post('kriteria') ?: null;

		$tgl_car = $this->input->post('tgl_car') ?: null;
		$pic = $this->input->post('pic') ?: null;
		$target_car = $this->input->post('target_car') ?: null;
		$close_car = $this->input->post('close_car') ?: null;

		$kategori = $this->input->post('kategori');
		$bagian_tubuh = $this->input->post('bagian_tubuh');
		$apd = $this->input->post('apd');
		$faktor = $this->input->post('faktor');
		$id_kecelakaan = $this->input->post('id_kecelakaan');

		$arr = array();

		$detail = $this->M_dtmasuk->getAllk3k('k3.k3k_kecelakaan', $id_kecelakaan)[0];

		$lampiran_foto = $this->input->post('lampiran_foto');
		$error_log = [];

		$md5_string = md5(date('Ymdhis'));
		// lampiran foto
		$lampiran_list = [];

		$currentLampiran = [NULL, $detail['lampiran_1'], $detail['lampiran_2']];
		if ($lampiran_foto && is_array($lampiran_foto)) {
			$path = 'assets/upload/P2K3v2/kecelakaan_kerja/foto/';
			foreach ($lampiran_foto as $i => $base64String) {
				$filename = "accident-$md5_string-$i";
				$actualFilename = $this->StoreBase64Image($path, $base64String, $filename);
				if (file_exists("./$path" . $currentLampiran[$i])) {
					unlink("./$path" . $currentLampiran[$i]);
				}
				$lampiran_list[] = $actualFilename;
			}
		}


		// file upload
		if (isset($lampiran_list[0])) {
			$arr['lampiran_1'] = $lampiran_list[0];
		}
		if (isset($lampiran_list[1])) {
			$arr['lampiran_2'] = $lampiran_list[1];
		}

		if (!empty($masa_kerja)) $arr['masa_kerja'] = $masa_kerja;
		if (!empty($tgl_kecelakaan)) $arr['waktu_kecelakaan'] = $tgl_kecelakaan;
		if (!empty($tgl_masuk_pos)) $arr['tgl_masuk_pos'] = $tgl_masuk_pos;
		if (!empty($tkp)) $arr['tkp'] = $tkp;
		if (!empty($lokasi_kerja)) $arr['lokasi_kerja_kecelakaan'] = $lokasi_kerja;
		if (!empty($kasus)) $arr['kasus'] = $kasus;
		if (!empty($kronologi)) $arr['kronologi'] = $kronologi;
		if (!empty($kondisi)) $arr['kondisi'] = $kondisi;
		if (!empty($penyebab)) $arr['penyebab'] = $penyebab;
		if (!empty($tindakan)) $arr['tindakan'] = $tindakan;
		if (!empty($tgl_car)) $arr['tgl_car'] = $tgl_car;
		if (!empty($pic)) $arr['pic'] = $pic;
		if (!empty($target_car)) $arr['tgl_selesai_car'] = $target_car;
		if (!empty($close_car)) $arr['tgl_close_car'] = $close_car;
		if (!empty($kodesie)) $arr['kodesie'] = $kodesie;

		if ($detail['range_waktu1'] != $range1) $arr['range_waktu1'] = $range1;
		if ($detail['range_waktu2'] != $range2) $arr['range_waktu2'] = $range2;
		if ($detail['bsrl'] != $bsrl) $arr['bsrl'] = $bsrl;
		if ($detail['prosedur'] != $prosedur)  $arr['prosedur'] = $prosedur;
		if ($detail['unsafe'] != $unsafe) $arr['unsafe'] = $unsafe;
		if ($detail['kriteria_stop_six'] != $kriteria) $arr['kriteria_stop_six'] = $kriteria;
		if ($detail['jenis_pekerjaan'] != $jenis_pekerjaan) $arr['jenis_pekerjaan'] = $jenis_pekerjaan;
		if ($detail['tgl_close_car'] != $close_car) $arr['tgl_close_car'] = $close_car;
		// var_dump($arr);
		// die;
		if (!empty($arr)) {
			$upd = $this->M_dtmasuk->upk3k_kecelakaan($arr, $id_kecelakaan);
		}

		// check on table first
		// if changes and data get is different, then do delete and insert again
		// i think this will make bad perfomance
		$getArB = $this->M_dtmasuk->getKKLain('k3.k3k_bagian_tubuh', 'bagian_tubuh', $id_kecelakaan);
		$getArB = array_column($getArB, 'bagian_tubuh');
		if ($getArB != $kategori) {
			$delK3K = $this->M_dtmasuk->delK3K_lain('k3.k3k_bagian_tubuh', $id_kecelakaan);
			$arrB = array();
			if (!empty($bagian_tubuh)) {
				foreach ($bagian_tubuh as $k) {
					$arrB[] = array(
						'id_kecelakaan' => $id_kecelakaan,
						'bagian_tubuh' => $k,
					);
				}
				if (!empty($arrB))
					$ins2 = $this->M_dtmasuk->insk3k_kecelakaan_lain($arrB, 'k3.k3k_bagian_tubuh');
			}
		}

		// check on table first
		// if changes and data get is different, then do delete and insert again
		// i think this will make bad perfomance
		$getArF = $this->M_dtmasuk->getKKLain('k3.k3k_faktor_kecelakaan', 'faktor', $id_kecelakaan);
		$getArF = array_column($getArF, 'faktor');
		if ($getArF != $kategori) {
			$delK3K = $this->M_dtmasuk->delK3K_lain('k3.k3k_faktor_kecelakaan', $id_kecelakaan);
			$arrF = array();
			if (!empty($faktor)) {
				foreach ($faktor as $k) {
					$arrF[] = array(
						'id_kecelakaan' => $id_kecelakaan,
						'faktor' => $k,
					);
				}
				if (!empty($arrF))
					$ins2 = $this->M_dtmasuk->insk3k_kecelakaan_lain($arrF, 'k3.k3k_faktor_kecelakaan');
			}
		}

		// check on table first
		// if changes and data get is different, then do delete and insert again
		// i think this will make bad perfomance
		$getArK = $this->M_dtmasuk->getKKLain('k3.k3k_kategori_kecelakaan', 'kategori', $id_kecelakaan);
		$getArK = array_column($getArK, 'kategori');
		if ($getArK != $kategori) {
			$delK3K = $this->M_dtmasuk->delK3K_lain('k3.k3k_kategori_kecelakaan', $id_kecelakaan);
			if (!empty($kategori)) {
				$arrK = array();
				foreach ($kategori as $k) {
					$arrK[] = array(
						'id_kecelakaan' => $id_kecelakaan,
						'kategori' => $k,
					);
				}
				if (!empty($arrK))
					$ins2 = $this->M_dtmasuk->insk3k_kecelakaan_lain($arrK, 'k3.k3k_kategori_kecelakaan');
			}
		}

		// check on table first
		// if changes and data get is different, then do delete and insert again
		// i think this will make bad perfomance
		$getArP = $this->M_dtmasuk->getKKLain('k3.k3k_penggunaan_apd', 'penggunaan_apd', $id_kecelakaan);
		$getArP = array_column($getArP, 'penggunaan_apd');
		if ($getArP != $kategori) {
			$delK3K = $this->M_dtmasuk->delK3K_lain('k3.k3k_penggunaan_apd', $id_kecelakaan);
			if (!empty($apd)) {
				$arrP = array();
				foreach ($apd as $k) {
					$arrP[] = array(
						'id_kecelakaan' => $id_kecelakaan,
						'penggunaan_apd' => $k,
					);
				}
				if (!empty($arrP))
					$ins2 = $this->M_dtmasuk->insk3k_kecelakaan_lain($arrP, 'k3.k3k_penggunaan_apd');
			}
		}

		// kecelakaan APD

		// delete
		$this->M_dtmasuk->delK3K_lain('k3.k3k_kecelakaan_apd', $id_kecelakaan);

		# Insert k3k_kecelakaan_apd

		// apd terdaftar
		$apd_digunakan = $this->input->post('apd_digunakan');
		$apd_digunakan = array_filter($apd_digunakan, 'filter_apd'); // filter valid user input

		// apd lain
		$apd_digunakan_lain = $this->input->post('apd_digunakan_lain');
		$apd_digunakan_lain = array_filter($apd_digunakan_lain, 'filter_apd'); // filter valid user input

		// merge all
		$all_apd_digunakan = array_merge($apd_digunakan, $apd_digunakan_lain);

		// map with true value
		// change standard & actual to TRUE
		$all_apd_digunakan = array_map(function ($apd) use ($id_kecelakaan) {
			return [
				'id_kecelakaan' => $id_kecelakaan,
				'nama_apd' => $apd['nama_apd'],
				'standard' => isset($apd['standard']),
				'actual'	 => isset($apd['actual'])
			];
		}, $all_apd_digunakan);

		// if array is not empty
		if (!empty($all_apd_digunakan)) {
			$this->M_dtmasuk->insertKecelakaanApd($table = 'k3.k3k_kecelakaan_apd', $data = $all_apd_digunakan);
		}

		# End reference

		$this->session->set_userdata('update_mkk', 'true');

		// add flash status
		// $this->session->set_flashdata('success', "Sukses mengupdate data kecelakaan");
		redirect('p2k3adm_V2/Admin/edit_monitoringKK?id=' . EncryptCar::encode($id_kecelakaan));
	}


	/**
	 * Export Kecelakaan kerja
	 */
	public function exportKecelakaanKerjaPDF()
	{
		set_time_limit(0);
		$id = EncryptCar::decode($this->input->get('id'));

		$data = $this->getKecelakaanDetail($id);
		if (isset($_GET['debug'])) {
			debug($data);
		}

		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('', 'F4', 8.7, '', 4, 4, 4, 4, 10, 3);
		$filename = 'P2K3Seksi.pdf';
		$html = $this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/Export/V_Pdf', $data, true);
		// echo $html;die;
		$footer = "
			Dicetak melalui Quick ERP - P2K3 Kecelakaan Kerja pada " . date('Y-m-d H:i:s') . " oleh " . $this->session->user . " - " . $this->session->employee . "
		";
		// $stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		// $pdf->WriteHTML($stylesheet1, 1);
		$pdf->SetFooter($footer);
		$pdf->WriteHTML($html, 0);
		$pdf->Output($filename, 'I');
	}

	/**
	 * Cari pekerja berdasarkan seksi, semua
	 * aktual seksi saat ini (apakah diperbantukan, jika iya maka tampilkan seksi diperbantukan)
	 * 
	 * // This can use by query, but creator is too lazy :D
	 * 
	 */
	public function getAllEmployees()
	{
		$start = microtime(true);
		$keyword = $this->input->get('keyword');
		$kodesie = false;

		try {
			if (!$keyword) throw new Exception("Bad Request");

			if (!$this->isAdmin) {
				$kodesie = $this->session->kodesie;
			}

			// find on hrd_khs.tpribadi
			$from_tpribadi = $this->M_dtmasuk->findActiveEmployeeWithKeyword($keyword, $kodesie);

			// find on Surat.tsurat_perbantuan
			$from_tperbantukan = $this->M_dtmasuk->findActivePerbantuanWithKeyword($keyword, $kodesie);

			// array_column didn't support array of object, so we convert to array of arrray
			$from_tperbantukan_array = json_decode(json_encode($from_tperbantukan), 1);
			$from_tperbantukan_noind = array_column($from_tperbantukan_array, 'noind');

			// filter tpribadi where not in from tperbantukan
			$from_tpribadi = array_filter($from_tpribadi, function ($employee) use ($from_tperbantukan_noind) {
				return !in_array($employee->noind, $from_tperbantukan_noind);
			});

			// merge it
			$allEmployee = array_merge($from_tpribadi, $from_tperbantukan);

			return response()->json([
				'code' => 200,
				'data' => $allEmployee
			]);
		} catch (Exception $e) {
			return response()->json([
				'code' => 500,
				'message' => $e->getMessage()
			], 500);
		}
	}

	/**
	 * Ajax Get Tempat Kejadian Perkara
	 */
	public function get_tkp()
	{
		$txt = $this->input->get('s');
		$data = $this->M_dtmasuk->getlistTKP($txt);
		echo json_encode($data);
	}

	public function excel_monitoringKK()
	{
		set_time_limit(0);
		// only P2K3 TIM can used
		if (!$this->isAdmin) return $this->load->view('V_404');

		$year = $this->input->get('y');
		if (strlen($year) != 4) {
			echo "Tahun Tidak di Temukan :(";
			exit();
		}
		// $bagian = $this->M_dtmasuk->getAllk3k2('k3.k3k_bagian_tubuh');
		// print_r($bagian);exit();

		$this->load->library(array('Excel', 'Excel/PHPExcel/IOFactory'));
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator('KHS ERP')
			->setTitle("DATA KECELAKAAN KERJA")
			->setSubject("DATA KECELAKAAN KERJA")
			->setDescription("P2K3 TIM - DATA KECELAKAAN KERJA")
			->setKeywords("P2K3 TIM - DATA TENAGA KERJA");
		$style_header = array(
			'font' => array('bold' => false),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'bababa')
			)
		);
		$style_title = array(
			'font' => array('bold' => false),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			)
		);

		$right = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
			)
		);
		$merah = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'f54040')
			)
		);
		$primary = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '67c1f5')
			)
		);
		$info = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '82e6ff')
			)
		);
		$border = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
			)
		);

		$head1 = array('NO', 'NAMA', 'NO INDUK', 'TKP', 'MASA KERJA', 'UNIT', 'SEKSI', 'TGL KEJADIAN', 'JAM KECELAKAAN');
		for ($i = 0; $i < count($head1); $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . '1', $head1[$i]);
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolom . '1:' . $kolom . '3');
			$objPHPExcel->getActiveSheet()->getStyle($kolom . '1')->applyFromArray($style_header);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . '2')->applyFromArray($style_header);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . '3')->applyFromArray($style_header);
		}
		//bulan tahun
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'Bulan (Th. 2020)');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('J1:BE1');
		for ($i = 0; $i < 48; $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($i + 9);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . '1')->applyFromArray($style_header);
		}
		$x = 1;
		$arrBSRL = array('B', 'S', 'R', 'L');
		for ($i = 9; $i < 57; $i += 4) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
			$kolom2 = PHPExcel_Cell::stringFromColumnIndex($i + 3);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . '2', date("M", strtotime("$x/12/10")));
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolom . '2:' . ($kolom2) . '2');
			for ($j = 0; $j < 4; $j++) {
				$kolom_k = PHPExcel_Cell::stringFromColumnIndex($j + $i);
				$objPHPExcel->getActiveSheet()->getStyle($kolom_k . '2')->applyFromArray($style_header);
				$objPHPExcel->getActiveSheet()->getStyle($kolom_k . '3')->applyFromArray($style_header);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom_k . '3', $arrBSRL[$j]);
			}
			$x++;
		}
		//kondisi
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BF1', 'Kondisi');
		$objPHPExcel->getActiveSheet()->getStyle('BF1:BF3')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('BF1:BF3');
		//bagian tubuh
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BG1', 'Bagian Tubuh');
		$objPHPExcel->getActiveSheet()->getStyle('BG1:BK2')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('BG1:BK2');
		$bagian = array('Kepala / Wajah', 'Mata', 'Tangan', 'Kaki', 'Lainya');
		$x = 0;
		for ($i = 58; $i < (58 + count($bagian)); $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . '3', $bagian[$x]);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . '3')->applyFromArray($style_header);
			$x++;
		}
		//bulan
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BL1', 'Bulan');
		$objPHPExcel->getActiveSheet()->getStyle('BL1:BL3')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('BL1:BL3');
		//penyebab
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BM1', 'Penyebab');
		$objPHPExcel->getActiveSheet()->getStyle('BM1:BM3')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('BM1:BM3');
		//Tindakan
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BN1', 'Tindakan');
		$objPHPExcel->getActiveSheet()->getStyle('BN1:BN3')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('BN1:BN3');
		//kategori
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BO1', 'Kategori');
		$objPHPExcel->getActiveSheet()->getStyle('BO1:BW2')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('BO1:BW2');
		$kategori = array('Tertusuk', 'Terjepit', 'Jatuhan/Jatuh', 'Terbentur', 'Terbakar', 'Kelilipan', 'Tersangkut', 'Tergores', 'Lain-lain');
		$x = 0;
		for ($i = 66; $i < (66 + count($kategori)); $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . '3', $kategori[$x]);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . '3')->applyFromArray($style_header);
			$x++;
		}
		//ket
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BX1', 'Ket');
		$objPHPExcel->getActiveSheet()->getStyle('BX1:BX3')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('BX1:BX3');
		//faktor
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BY1', 'Faktor Kecelakaan');
		$objPHPExcel->getActiveSheet()->getStyle('BY1:CD2')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('BY1:CD2');
		$faktor = array('Man', 'Machine', 'Method', 'Material', 'Working Area', 'Other');
		$x = 0;
		for ($i = 76; $i < (76 + count($faktor)); $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . '3', $faktor[$x]);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . '3')->applyFromArray($style_header);
			$x++;
		}
		//Tgl. CAR DITERIMA
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CE1', 'Tgl. CAR DITERIMA');
		$objPHPExcel->getActiveSheet()->getStyle('CE1:CE3')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('CE1:CE3');
		//Corrective Action
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CF1', 'Corrective Action');
		$objPHPExcel->getActiveSheet()->getStyle('CF1:CG1')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('CF1:CG1');
		$CA = array('PIC', 'Target Selesai');
		$x = 0;
		for ($i = 83; $i < (83 + count($CA)); $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . '2', $CA[$x]);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . '2:' . $kolom . '3')->applyFromArray($style_header);
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolom . '2:' . $kolom . '3');
			$x++;
		}
		//verifikasi
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CH1', 'Verifikasi');
		$objPHPExcel->getActiveSheet()->getStyle('CH1:CX1')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('CH1:CX1');
		$ver = array('TGL CLOSED', 'Status');
		for ($i = 1; $i <= 5; $i++) {
			$ver[] = 'Verifikasi ' . $i;
			$ver[] = 'Status';
			$ver[] = 'Due Date';
		}
		$x = 0;
		for ($i = 85; $i < (85 + count($ver)); $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . '2', $ver[$x]);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . '2:' . $kolom . '3')->applyFromArray($style_header);
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolom . '2:' . $kolom . '3');
			$x++;
		}
		//kehilangan waktu
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CY1', 'Kehilangan Waktu Kerja, Dalam Jam');
		$objPHPExcel->getActiveSheet()->getStyle('CY1:CY3')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('CY1:CY3');
		//tkp
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CZ1', 'Tempat Terjadinya Kecelakaan');
		$objPHPExcel->getActiveSheet()->getStyle('CZ1:CZ3')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('CZ1:CZ3');
		//kriteria
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('DA1', 'KRITERIA STOP SIX');
		$objPHPExcel->getActiveSheet()->getStyle('DA1:DF2')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('DA1:DF2');
		$six = array('A', 'B', 'C', 'D', 'E', 'F');
		$x = 0;
		for ($i = 104; $i < (104 + count($six)); $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . '3', $six[$x]);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . '3')->applyFromArray($style_header);
			$x++;
		}
		//bebas mkk
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('DG1', 'Hari bebas kecelakaan');
		$objPHPExcel->getActiveSheet()->getStyle('DG1:DG3')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('DG1:DG3');
		//range
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('DH1', 'RANGE WAKTU KECELAKAN');
		$objPHPExcel->getActiveSheet()->getStyle('DH1:DO2')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('DH1:DO2');
		$six = array('06:00:00 - 09:00:00', '09:15:00 - 11:45:00', '12:30:00 - 14:00:00', '14:00:00 - 16:00:00', '16:15:00 - 18:00:00', '18:45:00 - 22:00:00', '22:00:00 - 01:00:00', '01:00:00 - 05:00:00');
		$x = 0;
		for ($i = 111; $i < (111 + count($six)); $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . '3', $six[$x]);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . '3')->applyFromArray($style_header);
			$x++;
		}
		//unsave
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('DP1', 'UNSAFE');
		$objPHPExcel->getActiveSheet()->getStyle('DP1:DQ2')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('DP1:DQ2');
		$uns = array('Action', 'Condition');
		$x = 0;
		for ($i = 119; $i < (119 + count($uns)); $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . '3', $uns[$x]);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . '3')->applyFromArray($style_header);
			$x++;
		}
		//dept
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('DR1', 'DEPARTEMENT');
		$objPHPExcel->getActiveSheet()->getStyle('DR1:DS2')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('DR1:DS2');
		$dept = array('FAB', 'NON FAB');
		$x = 0;
		for ($i = 121; $i < (121 + count($dept)); $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . '3', $dept[$x]);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . '3')->applyFromArray($style_header);
			$x++;
		}
		//jenis pekerjaan
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('DT1', 'Jenis Pekerjaan');
		$objPHPExcel->getActiveSheet()->getStyle('DT1:DV2')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('DT1:DV2');
		$jp = array('REGULAR', 'NON REGULAR', 'LAIN-LAIN');
		$x = 0;
		for ($i = 123; $i < (123 + count($jp)); $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . '3', $jp[$x]);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . '3')->applyFromArray($style_header);
			$x++;
		}
		//Prosedure
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('DW1', 'Prosedure');
		$objPHPExcel->getActiveSheet()->getStyle('DW1:DY2')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('DW1:DY2');
		$pros = array('SESUAI', 'TDK SESUAI', 'TDK TRDPT STD');
		$x = 0;
		for ($i = 126; $i < (126 + count($pros)); $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . '3', $pros[$x]);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . '3')->applyFromArray($style_header);
			$x++;
		}
		//apd
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('DZ1', 'Penggunaan APD');
		$objPHPExcel->getActiveSheet()->getStyle('DZ1:EB2')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('DZ1:EB2');
		$apd = array('PAKAI', 'TDK PAKAI', 'TDK TRDPT STD');
		$x = 0;
		for ($i = 129; $i < (129 + count($apd)); $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . '3', $apd[$x]);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . '3')->applyFromArray($style_header);
			$x++;
		}
		//masa kerja
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('EC1', 'MASA KERJA');
		$objPHPExcel->getActiveSheet()->getStyle('EC1:EE2')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('EC1:EE2');
		$masa = array('< 3 BULAN', '3 – 12 BULAN', '> 12 BULAN');
		$x = 0;
		for ($i = 132; $i < (132 + count($masa)); $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . '3', $masa[$x]);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . '3')->applyFromArray($style_header);
			$x++;
		}
		//RANGE WAKTU KECELAKAAN
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('EF1', 'RANGE WAKTU KECELAKAAN');
		$objPHPExcel->getActiveSheet()->getStyle('EF1:EH2')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('EF1:EH2');
		$range = array('Awal – Break', 'Break – Istirahat', 'Istirahat – Pulang');
		$x = 0;
		for ($i = 135; $i < (135 + count($range)); $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . '3', $range[$x]);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . '3')->applyFromArray($style_header);
			$x++;
		}
		//info
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('EI1', 'INFO');
		$objPHPExcel->getActiveSheet()->getStyle('EI1:EI3')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('EI1:EI3');
		//ilu
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('EJ1', 'ILU / KON');
		$objPHPExcel->getActiveSheet()->getStyle('EJ1:EJ3')->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('EJ1:EJ3');

		//fetch data
		//init variabel untuk total tkp
		$laka = array();
		$kerja = array();
		$mass1 = 0;
		$mass2 = 0;
		$mass3 = 0;

		$this->load->library('KonversiBulan');
		$lokasi = array_column($this->M_pekerjakeluar->getLokasiKerja(), 'lokasi_kerja', 'id_');
		$lokasi[999] = 'LAKA';
		$row = 5;
		for ($z = 1; $z <= 12; $z++) {
			$mo = $z;
			if ($mo < 10) $mo = '0' . $mo;
			$ym = $year . '-' . $mo;
			$data = $this->M_dtmasuk->getDatak3k($ym);
			$bln = $this->konversibulan->KonversiKeBulanIndonesia(date('F', strtotime('2020-' . $mo . '-01')));
			//set bulan
			for ($i = 0; $i <= 139; $i++) {
				$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
				if ($i == '1') $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, $bln);
				if ($i < 3) $objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->applyFromArray($border);
				$objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->applyFromArray($info);
				$objPHPExcel->getActiveSheet()->getColumnDimension($kolom)->setAutoSize(true);
			}
			if (empty($data)) {
				for ($r = 0; $r < 2; $r++) {
					$row++;
					for ($i = 0; $i <= 139; $i++) {
						$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
						$objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->applyFromArray($border);
					}
				}
			}
			$row++;
			$x = 1;
			foreach ($data as $key) {
				$wkt = explode(' ', $key['waktu_kecelakaan']);
				$m = explode('-', $wkt[0])[1];
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $row, $x++);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $row, trim($key['nama']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $row, $key['noind']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $row, $key['tkp']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $row, $key['masa_kerja']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $row, trim($key['unit_name']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $row, trim($key['section_name']));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $row, date('d M Y', strtotime($wkt[0])));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $row, $wkt[1]);
				//bsrl
				$sbsrl = 9;
				for ($i = 1; $i <= 12; $i++) {
					for ($j = 1; $j <= 4; $j++) {
						$kolom = PHPExcel_Cell::stringFromColumnIndex($sbsrl);
						if ($key['bsrl'] == $j && intval($m) == $i && $key['lokasi_kerja_kecelakaan'] != '999') {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '✓');
							if (isset($kerja[$i][$j])) $kerja[$i][$j]++;
							else $kerja[$i][$j] = 1;
						} elseif ($key['bsrl'] == $j && intval($m) == $i) {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, 'O');
							if (isset($laka[$i][$j])) $laka[$i][$j]++;
							else $laka[$i][$j] = 1;
						} else {
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '');
						}
						$sbsrl++;
					}
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BF' . $row, $key['kondisi']);
				//bagian tubuh
				$sbagian = 58;
				$ttal = 0;
				$ttal_bagian = array();
				$arrB = explode(',', $key['bagian_tubuh']);
				for ($i = 1; $i <= 5; $i++) {
					$kolom = PHPExcel_Cell::stringFromColumnIndex($sbagian);
					if (in_array($i, $arrB)) {
						// $ttal_bagian[$i] +=
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '✓');
					} else {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '');
					}
					$sbagian++;
				}
				$bln = $this->konversibulan->KonversiKeBulanIndonesia(date('F', strtotime($wkt[0])));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BL' . $row, $bln);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BM' . $row, $key['penyebab']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BN' . $row, $key['tindakan']);
				//kategori
				$skategori = 66;
				$arrK = explode(',', $key['kategori']);
				for ($i = 1; $i <= 9; $i++) {
					$kolom = PHPExcel_Cell::stringFromColumnIndex($skategori);
					if (in_array($i, $arrK)) {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '✓');
					} else {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '');
					}
					$skategori++;
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BX' . $row, $lokasi[$key['lokasi_kerja_kecelakaan']]);
				if ($key['lokasi_kerja_kecelakaan'] == '999') {
					for ($i = 0; $i <= 139; $i++) {
						$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
						$objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->applyFromArray($primary);
						$objPHPExcel->getActiveSheet()->getColumnDimension($kolom)->setAutoSize(true);
					}
				}

				//faktor
				$sfaktor = 76;
				$arrK = explode(',', $key['faktor']);
				for ($i = 1; $i <= 6; $i++) {
					$kolom = PHPExcel_Cell::stringFromColumnIndex($sfaktor);
					if (in_array($i, $arrK)) {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '✓');
					} else {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '');
					}
					$sfaktor++;
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CE' . $row, $key['tgl_car']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CF' . $row, $key['nama_pic']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CG' . $row, $key['tgl_selesai_car']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CH' . $row, $key['tgl_close_car']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CZ' . $row, $lokasi[$key['lokasi_kerja_kecelakaan']]);
				//kriteria
				$skriteria = 104;
				$arrK = explode(',', $key['kriteria_stop_six']);
				for ($i = 1; $i <= 6; $i++) {
					$kolom = PHPExcel_Cell::stringFromColumnIndex($skriteria);
					if (in_array($i, $arrK)) {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '✓');
					} else {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '');
					}
					$skriteria++;
				}
				//range2
				$srange1 = 111;
				$arrK = explode(',', $key['range_waktu2']);
				for ($i = 1; $i <= 6; $i++) {
					$kolom = PHPExcel_Cell::stringFromColumnIndex($srange1);
					if (in_array($i, $arrK)) {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '✓');
					} else {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '');
					}
					$srange1++;
				}
				//unsafe
				$sunsafe = 119;
				$arrK = explode(',', $key['unsafe']);
				for ($i = 1; $i <= 2; $i++) {
					$kolom = PHPExcel_Cell::stringFromColumnIndex($sunsafe);
					if (in_array($i, $arrK)) {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '✓');
					} else {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '');
					}
					$sunsafe++;
				}
				//dept
				if (substr($key['kodesie'], 0, 1) == '3') {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('DR' . $row, '✓');
				} else {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('DS' . $row, '✓');
				}
				//jenis pekerjaan
				$sjp = 123;
				$arrK = explode(',', $key['jenis_pekerjaan']);
				for ($i = 1; $i <= 3; $i++) {
					$kolom = PHPExcel_Cell::stringFromColumnIndex($sjp);
					if (in_array($i, $arrK)) {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '✓');
					} else {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '');
					}
					$sjp++;
				}
				//prosedur
				$sprosedure = 126;
				$arrK = explode(',', $key['prosedur']);
				for ($i = 1; $i <= 3; $i++) {
					$kolom = PHPExcel_Cell::stringFromColumnIndex($sprosedure);
					if (in_array($i, $arrK)) {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '✓');
					} else {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '');
					}
					$sprosedure++;
				}
				//apd
				$sapd = 129;
				$arrK = explode(',', $key['apd']);
				for ($i = 1; $i <= 3; $i++) {
					$kolom = PHPExcel_Cell::stringFromColumnIndex($sapd);
					if (in_array($i, $arrK)) {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '✓');
					} else {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '');
					}
					$sapd++;
				}
				//masa kerja
				$mass = explode(' ', $key['masa_kerja']);

				if (!empty($mass) && $key['masa_kerja'] !== '-') {
					$tahun = $mass[0];
					$bulan = $mass[2];
					if ($tahun > 0) {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('EE' . $row, '✓');
						$mass1++;
					} elseif ($bulan > 2) {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('ED' . $row, '✓');
						$mass2++;
					} else {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('EC' . $row, '✓');
						$mass3++;
					}
				}
				//range1
				$srange2 = 135;
				$arrK = explode(',', $key['range_waktu1']);
				for ($i = 1; $i <= 3; $i++) {
					$kolom = PHPExcel_Cell::stringFromColumnIndex($srange2);
					if (in_array($i, $arrK)) {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '✓');
					} else {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '');
					}
					$srange2++;
				}
				//set border
				for ($i = 0; $i <= 139; $i++) {
					$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
					$objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->applyFromArray($border);
					$objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->getAlignment()->setWrapText(true);
					// $objPHPExcel->getActiveSheet()->getStyle($kolom.$row)->getAlignment()->setIndent(5);
					$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(40);
					if ($key['lokasi_kerja'] == '999') {
						$objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->applyFromArray($primary);
					}
				}
				$row++;
			}
		}
		//set warna merah
		for ($i = 0; $i <= 139; $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($i);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . '4')->applyFromArray($merah);
			$objPHPExcel->getActiveSheet()->getColumnDimension($kolom)->setAutoSize(true);
		}
		//bagian bawah
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CY' . $row, 'Pusat');
		$objPHPExcel->getActiveSheet()->getStyle('CY' . $row)->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
			'CZ' . $row,
			$this->M_dtmasuk->getTtlLoker('01', $year)
		);
		$objPHPExcel->getActiveSheet()->getStyle('CZ' . $row)->applyFromArray($style_header);

		$row++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CY' . $row, 'Tuksono');
		$objPHPExcel->getActiveSheet()->getStyle('CY' . $row)->applyFromArray($style_header);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
			'CZ' . $row,
			$this->M_dtmasuk->getTtlLoker('02', $year)
		);
		$objPHPExcel->getActiveSheet()->getStyle('CZ' . $row)->applyFromArray($style_header);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $row, 'Kecelakaan di lingkungan Kerja');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B' . $row . ':H' . $row);
		$objPHPExcel->getActiveSheet()->getStyle('B' . $row . ':H' . $row)->applyFromArray($style_title);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $row, 'Kerja');
		$sbsrl = 9;
		$ttal = 0;
		for ($i = 1; $i <= 12; $i++) {
			for ($j = 1; $j <= 4; $j++) {
				$kolom = PHPExcel_Cell::stringFromColumnIndex($sbsrl);
				$objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->applyFromArray($border);
				if (isset($kerja[$i][$j])) {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, $kerja[$i][$j]);
					$ttal += $kerja[$i][$j];
				} else {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '-');
				}
				$sbsrl++;
			}
		}
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BF' . $row, $ttal);
		//total bagian tubuh
		$sbagian = 58;
		for ($i = 1; $i <= 5; $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($sbagian);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
				$kolom . $row,
				$this->M_dtmasuk->getTtlBagian($i, $year)
			);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->applyFromArray($style_header);
			$sbagian++;
		}

		// total kategori
		$skategori = 66;
		for ($i = 1; $i <= 9; $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($skategori);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
				$kolom . $row,
				$this->M_dtmasuk->getTtlKategori($i, $year)
			);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->applyFromArray($style_header);
			$skategori++;
		}
		// total faktor
		$sfaktor = 76;
		for ($i = 1; $i <= 6; $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($sfaktor);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
				$kolom . $row,
				$this->M_dtmasuk->getTtlFaktor($i, $year)
			);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->applyFromArray($style_header);
			$sfaktor++;
		}
		//total stop six
		$ssix = 104;
		for ($i = 1; $i <= 6; $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($ssix);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
				$kolom . $row,
				$this->M_dtmasuk->getTtlStopsix($i, $year)
			);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->applyFromArray($style_header);
			$ssix++;
		}
		//range2
		$srange2 = 111;
		for ($i = 1; $i <= 8; $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($srange2);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
				$kolom . $row,
				$this->M_dtmasuk->getTtlrange2($i, $year)
			);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->applyFromArray($style_header);
			$srange2++;
		}
		//unsafe
		$sunsafe = 119;
		for ($i = 1; $i <= 2; $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($sunsafe);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
				$kolom . $row,
				$this->M_dtmasuk->getTtlunsafe($i, $year)
			);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->applyFromArray($style_header);
			$sunsafe++;
		}
		//dept
		$sdept = 121;
		for ($i = 1; $i <= 2; $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($sdept);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
				$kolom . $row,
				$this->M_dtmasuk->getTtldept($i, $year)
			);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->applyFromArray($style_header);
			$sdept++;
		}
		//jp
		$sjp = 123;
		for ($i = 1; $i <= 3; $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($sjp);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
				$kolom . $row,
				$this->M_dtmasuk->getTtljp($i, $year)
			);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->applyFromArray($style_header);
			$sjp++;
		}
		//prosedure
		$sprosedure = 126;
		for ($i = 1; $i <= 3; $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($sprosedure);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
				$kolom . $row,
				$this->M_dtmasuk->getTtlkolom($i, $year, 'prosedur')
			);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->applyFromArray($style_header);
			$sprosedure++;
		}
		//penggunaan apd
		$sapd = 129;
		for ($i = 1; $i <= 3; $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($sapd);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
				$kolom . $row,
				$this->M_dtmasuk->getTtlapd($i, $year)
			);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->applyFromArray($style_header);
			$sapd++;
		}
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('EC' . $row, $mass3);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('ED' . $row, $mass2);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('EE' . $row, $mass1);
		$objPHPExcel->getActiveSheet()->getStyle('EC' . $row)->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('ED' . $row)->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('EE' . $row)->applyFromArray($style_header);

		//range1
		$srange1 = 135;
		for ($i = 1; $i <= 3; $i++) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($srange1);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue(
				$kolom . $row,
				$this->M_dtmasuk->getTtlkolom($i, $year, 'range_waktu1')
			);
			$objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->applyFromArray($style_header);
			$srange1++;
		}


		$row++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $row, 'Kecelakaan Lalu Lintas');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B' . $row . ':H' . $row);
		$objPHPExcel->getActiveSheet()->getStyle('B' . $row . ':H' . $row)->applyFromArray($style_title);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $row, 'Laka');
		$sbsrl = 9;
		$ttal = 0;
		for ($i = 1; $i <= 12; $i++) {
			for ($j = 1; $j <= 4; $j++) {
				$kolom = PHPExcel_Cell::stringFromColumnIndex($sbsrl);
				$objPHPExcel->getActiveSheet()->getStyle($kolom . $row)->applyFromArray($style_header);
				if (isset($laka[$i][$j])) {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, $laka[$i][$j]);
					$ttal += $laka[$i][$j];
				} else {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, '-');
				}
				$sbsrl++;
			}
		}
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BF' . $row, $ttal);



		//kebawah
		// echo "<pre>";
		// print_r($kerja);exit();
		$b = 0;
		$s = 0;
		$r = 0;
		$l = 0;
		foreach ($kerja as $key => $value) {
			foreach ($value as $k => $v) {
				if ($k == '1') {
					$b += $v;
				}
				if ($k == '2') {
					$s += $v;
				}
				if ($k == '3') {
					$r += $v;
				}
				if ($k == '4') {
					$l += $v;
				}
			}
		}
		foreach ($laka as $key => $value) {
			foreach ($value as $k => $v) {
				if ($k == '1') {
					$b += $v;
				}
				if ($k == '2') {
					$s += $v;
				}
				if ($k == '3') {
					$r += $v;
				}
				if ($k == '4') {
					$l += $v;
				}
			}
		}
		// exit();
		$row++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $row, 'R');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $row, $r);
		$objPHPExcel->getActiveSheet()->getStyle('J' . $row)->applyFromArray($border);
		$objPHPExcel->getActiveSheet()->getStyle('K' . $row)->applyFromArray($border);
		$sbsrl = 8;
		// print_r($kerja);exit();
		for ($i = 1; $i <= 12; $i++) {
			$ttl = 0;
			for ($j = 1; $j <= 4; $j++) {
				if (isset($kerja[$i][$j])) {
					$ttl += $kerja[$i][$j];
				}
				$sbsrl++;
			}
			$kolom = PHPExcel_Cell::stringFromColumnIndex($sbsrl);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, $ttl);
		}

		$row++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $row, 'S');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $row, $s);
		$objPHPExcel->getActiveSheet()->getStyle('J' . $row)->applyFromArray($border);
		$objPHPExcel->getActiveSheet()->getStyle('K' . $row)->applyFromArray($border);
		$sbsrl = 8;
		for ($i = 1; $i <= 12; $i++) {
			$ttl = 0;
			for ($j = 1; $j <= 4; $j++) {
				if (isset($laka[$i][$j])) {
					$ttl += $laka[$i][$j];
				}
				$sbsrl++;
			}
			$kolom = PHPExcel_Cell::stringFromColumnIndex($sbsrl);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $row, $ttl);
		}

		$row++;
		$startChart = $row;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $row, 'B');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $row, $b);
		$objPHPExcel->getActiveSheet()->getStyle('J' . $row)->applyFromArray($border);
		$objPHPExcel->getActiveSheet()->getStyle('K' . $row)->applyFromArray($border);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CW' . $row, 'Aparatus');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CX' . $row, 'Kecelakaan Karena Mesin dan Peralatan');
		$objPHPExcel->getActiveSheet()->getStyle('CW' . $row)->applyFromArray($border);
		$objPHPExcel->getActiveSheet()->getStyle('CX' . $row)->applyFromArray($border);

		$row++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $row, 'L');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $row, $l);
		$objPHPExcel->getActiveSheet()->getStyle('J' . $row)->applyFromArray($border);
		$objPHPExcel->getActiveSheet()->getStyle('K' . $row)->applyFromArray($border);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CW' . $row, 'Big Heavy');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CX' . $row, 'Tertimpa dan terbentur benda berat');
		$objPHPExcel->getActiveSheet()->getStyle('CW' . $row)->applyFromArray($border);
		$objPHPExcel->getActiveSheet()->getStyle('CX' . $row)->applyFromArray($border);

		$row++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CW' . $row, 'Car');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CX' . $row, 'Tertabrak kendaraan');
		$objPHPExcel->getActiveSheet()->getStyle('CW' . $row)->applyFromArray($border);
		$objPHPExcel->getActiveSheet()->getStyle('CX' . $row)->applyFromArray($border);

		$row++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CW' . $row, 'Drop');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CX' . $row, 'Jatuh Dari Ketinggia');
		$objPHPExcel->getActiveSheet()->getStyle('CW' . $row)->applyFromArray($border);
		$objPHPExcel->getActiveSheet()->getStyle('CX' . $row)->applyFromArray($border);

		$row++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CW' . $row, 'Electrical');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CX' . $row, 'Terkena Sengatan Listrik');
		$objPHPExcel->getActiveSheet()->getStyle('CW' . $row)->applyFromArray($border);
		$objPHPExcel->getActiveSheet()->getStyle('CX' . $row)->applyFromArray($border);

		$row++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CW' . $row, 'Fire');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CX' . $row, 'Menyentuh Sumber panass');
		$objPHPExcel->getActiveSheet()->getStyle('CW' . $row)->applyFromArray($border);
		$objPHPExcel->getActiveSheet()->getStyle('CX' . $row)->applyFromArray($border);

		$ttlmkk = 0;
		$arrch1x = array();
		$arrch1y = array();
		$startChart2 = $startChart;
		for ($i = 1; $i <= 12; $i++) {
			if ($i < 10) $m = '0' . $i;
			else $m = $i;
			$ym = $year . '-' . $m;
			$ttlmkk = count($this->M_dtmasuk->getDatak3k($ym));
			$bln = $this->konversibulan->KonversiKeBulanIndonesia(date('F', strtotime('2020-' . $m . '-01')));
			// print_r($bln);exit();
			$arrch1x[$i - 1] = $bln;
			$arrch1y[$i - 1] = $ttlmkk;

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('CZ' . $startChart, $bln);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('DA' . $startChart, $ttlmkk);
			$startChart++;
		}
		$values = new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$DA$45:$DA$56');
		$categories = new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$CZ$45:$CZ$56');
		// print_r(array($values));exit();
		//chart pertama
		$series = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_BARCHART,
			PHPExcel_Chart_DataSeries::GROUPING_STACKED,
			array(0),
			array(),
			array($categories),
			array($values)
		);
		$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_VERTICAL);
		$layout = new PHPExcel_Chart_Layout();
		$plotarea = new PHPExcel_Chart_PlotArea($layout, array($series));
		$xTitle = new PHPExcel_Chart_Title('');
		$yTitle = new PHPExcel_Chart_Title('');
		$axis =  new PHPExcel_Chart_Axis();
		$axis->setAxisOptionsProperties('low', null, null, null, 1, null, null, 1, 1);

		$chart = new PHPExcel_Chart('sample', null, null, $plotarea, true, 0, $xTitle, $yTitle, $axis);
		$chart->setTopLeftPosition('DC' . $startChart2);
		$chart->setBottomRightPosition('DJ' . ($startChart2 + 11));
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->addChart($chart);

		//frezee
		$objPHPExcel->getActiveSheet()->freezePane('A5');
		$objPHPExcel->getActiveSheet()->setTitle('Data Kecelakaan Kerja');
		$filename = rawurlencode("Data Kecelakaan Kerja " . $year . ".xlsx");
		header('Content-Type: application/vnd.ms-excel'); // mime type
		header('Content-Disposition: attachment;filename="' . $filename . '"'); // tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		// $objWriter->writeAttribute('val', "low");
		// $objWriter->setIncludeCharts(TRUE); // This method is not exist
		$objWriter->save('php://output');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');

		//help im lost my mind :( this export is insane
		//dont forget to drink :) love ya

	}

	public function pdf_monitoringKK()
	{
		set_time_limit(0);

		// only P2K3 TIM can used
		if (!$this->isAdmin) return $this->load->view('V_404');

		require_once(APPPATH . 'libraries/SVGGraph/autoloader.php');

		$year = $this->input->get('y');
		$data['tahun'] = $year;

		$data['perbandingan1'] = $this->grapPerbandingan1($year);
		$data['perbandingan2'] = $this->grapPerbandingan2($year);

		$data['bagian1'] = $this->grapBagian1($year);
		$data['bagian2'] = $this->grapBagian2($year);

		$data['bsrl1'] = $this->grapbsrl1($year);
		$data['bsrl2'] = $this->grapbsrl2($year);

		$data['six1'] = $this->grapsix1($year);
		$data['six2'] = $this->grapsix2($year);

		$data['jp'] = $this->grapjp($year);
		$data['wicop'] = $this->grapwicop($year);
		$data['apd'] = $this->grapapd($year);
		$data['unit'] = $this->grapunit($year);
		$data['seksiP'] = $this->grapseksiP($year);
		$data['seksiT'] = $this->grapseksiT($year);
		$data['bebas'] = $this->grapbebas($year);

		$data['laka'] = $this->getlaka($year);
		// debug($data['laka']);
		// $data['glaka'] = $this->getlakaGraph($data['laka']);

		$this->load->library('Pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('', array(297, 420), 0, '', 10, 10, 10, 10, 0, 5, 'L');
		$pdf->setAutoTopMargin = 'stretch';
		$pdf->showImageErrors = true;
		$pdf->setAutoBottomMargin = 'stretch';
		$filename = $nomor_urut . '-Bon-Bppbg.pdf';
		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
		$html = $this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/V_Buletin', $data, true);
		// print_r($html);
		// exit();

		$pdf->WriteHTML($stylesheet, 1);
		$pdf->WriteHTML($html);
		$pdf->Output($filename, 'I');
	}

	function grapPerbandingan1($tahun)
	{
		for ($i = 1; $i <= 12; $i++) {
			if ($i < 10) $m = '0' . $i;
			else $m = $i;
			$d[] = $this->M_dtmasuk->getTtlLoker('', $tahun . '-' . $m);
		}



		for ($i = 1; $i <= 12; $i++) {
			if ($i < 10) $m = '0' . $i;
			else $m = $i;
			$e[] = $this->M_dtmasuk->getTtlLoker('', ($tahun - 1) . '-' . $m);
		}

		$shortMonth = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
		$dataValue = [array_combine($shortMonth, $e), array_combine($shortMonth, $d)];
		// print_r($values);
		// print_r($dataValue);
		// exit();
		$settings = $settings = $this->settingChart();
		$width = 450;
		$height = 135;
		$type = 'GroupedBarGraph';
		$colours = [['red'], ['blue']];
		$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
		$graph->colours($colours);
		$graph->values($dataValue);
		$data['chart'] = $this->clearXMLTag($graph->fetch($type));
		$data['tahunini'] = array_sum($d);
		$data['tahunlalu'] = array_sum($e);
		$data['arrini'] = array_combine($shortMonth, $d);
		$data['arrlalu'] = array_combine($shortMonth, $e);
		return $data;
	}

	function grapPerbandingan2($tahun)
	{
		for ($i = 1; $i <= 12; $i++) {
			if ($i < 10) $m = '0' . $i;
			else $m = $i;
			$d[] = $this->M_dtmasuk->getTtlLoker('01', $tahun . '-' . $m);
		}
		for ($i = 1; $i <= 12; $i++) {
			if ($i < 10) $m = '0' . $i;
			else $m = $i;
			$e[] = $this->M_dtmasuk->getTtlLoker('02', $tahun . '-' . $m);
		}
		$shortMonth = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
		$dataValue = [array_combine($shortMonth, $d), array_combine($shortMonth, $e)];
		// print_r($values);
		// print_r($dataValue);
		// exit();
		$settings = $this->settingChart();
		$width = 450;
		$height = 135;
		$type = 'GroupedBarGraph';
		$colours = [['purple'], ['orange']];
		$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
		$graph->colours($colours);
		$graph->values($dataValue);
		$data['chart'] = $this->clearXMLTag($graph->fetch($type));
		$data['pst'] = array_sum($d);
		$data['tks'] = array_sum($e);
		$data['arrP'] = array_combine($shortMonth, $d);
		$data['arrT'] = array_combine($shortMonth, $e);
		return $data;
	}

	function clearXMLTag($str)
	{
		return str_replace('<?xml version="1.0" encoding="UTF-8" standalone="no"?>', '', $str);
	}

	function settingChart($arr = null)
	{
		$data = [
			'minimum_units_y' => 1,
			'auto_fit' => true,
			'back_colour' => '#eee',
			'back_stroke_width' => 0,
			'back_stroke_colour' => '#eee',
			'stroke_colour' => '#000',
			'axis_colour' => '#333',
			'axis_overlap' => 2,
			'grid_colour' => '#666',
			'label_colour' => '#000',
			'axis_font' => 'Arial',
			'axis_font_size' => 10,
			'pad_right' => 20,
			'pad_left' => 20,
			'link_base' => '/',
			'link_target' => '_top',
			'minimum_grid_spacing' => 20,
			'grid_subdivision_colour' => '#ccc',
			'show_data_labels' => true,
			'data_label_position' => 'top',
			'data_label_font_size' => 7,
			'data_label_colour' => '#000',
			'data_label_type' => 'circle',
			'data_label_filter' => 'nonzero',
			'graph_title' => "",
			'label_font_size' => 15
		];
		if (is_array($arr)) {
			foreach ($arr as $k => $v) {
				$data[$k] = $v;
			}
		}

		return $data;
	}

	public function grapBagian1($tahun)
	{
		for ($i = 1; $i <= 5; $i++) {
			$d[] = $this->M_dtmasuk->getTtlBagian($i, $tahun);
		}

		$bagian = array('Kepala/Wajah', 'Mata', 'Tangan', 'Kaki', 'Lain-lain');
		$dataValue = [array_combine($bagian, $d)];

		$settings = $this->settingChart();
		$width = 450;
		$height = 135;
		$type = 'GroupedBarGraph';
		$colours = [['#337ab7']];
		$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
		$graph->colours($colours);
		$graph->values($dataValue);
		$data['chart'] = $this->clearXMLTag($graph->fetch($type));
		$data['ttl'] = array_sum($d);
		$data['arr'] = array_combine($bagian, $d);
		return $data;
	}

	public function grapBagian2($tahun)
	{
		for ($i = 1; $i <= 5; $i++) {
			$d[] = $this->M_dtmasuk->getTtlBagianLok($i, $tahun, '01');
		}
		for ($i = 1; $i <= 5; $i++) {
			$e[] = $this->M_dtmasuk->getTtlBagianLok($i, $tahun, '02');
		}

		$bagian = array('Kepala/Wajah', 'Mata', 'Tangan', 'Kaki', 'Lain-lain');
		$dataValue = [array_combine($bagian, $d), array_combine($bagian, $e)];

		$settings = $this->settingChart();
		$width = 450;
		$height = 135;
		$type = 'GroupedBarGraph';
		$colours = [['purple'], ['orange']];
		$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
		$graph->colours($colours);
		$graph->values($dataValue);
		$data['chart'] = $this->clearXMLTag($graph->fetch($type));
		$data['pst'] = array_sum($d);
		$data['tks'] = array_sum($e);
		$data['arrP'] = array_combine($bagian, $d);
		$data['arrT'] = array_combine($bagian, $e);
		return $data;
	}

	public function grapbsrl1($tahun)
	{
		for ($i = 1; $i <= 4; $i++) {
			$d[] = $this->M_dtmasuk->getTtlkolom($i, $tahun, 'bsrl');
		}

		$bagian = array('Berat', 'Sedang', 'Ringan', 'Lain-lain');
		$dataValue = [array_combine($bagian, $d)];

		$settings = $this->settingChart();
		$width = 450;
		$height = 135;
		$type = 'GroupedBarGraph';
		$colours = [['red']];
		$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
		$graph->colours($colours);
		$graph->values($dataValue);
		$data['chart'] = $this->clearXMLTag($graph->fetch($type));
		$data['ttl'] = array_sum($d);
		$data['arr'] = array_combine($bagian, $d);
		return $data;
	}

	public function grapbsrl2($tahun)
	{
		for ($i = 1; $i <= 4; $i++) {
			$d[] = $this->M_dtmasuk->getTtlkolomLok($i, $tahun, 'bsrl', '01');
		}
		for ($i = 1; $i <= 4; $i++) {
			$e[] = $this->M_dtmasuk->getTtlkolomLok($i, $tahun, 'bsrl', '02');
		}

		$bagian = array('Berat', 'Sedang', 'Ringan', 'Lain-lain');
		$dataValue = [array_combine($bagian, $d), array_combine($bagian, $e)];
		// print_r($dataValue);exit();

		$settings = $this->settingChart();
		$width = 450;
		$height = 135;
		$type = 'GroupedBarGraph';
		$colours = [['purple'], ['orange']];
		$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
		$graph->colours($colours);
		$graph->values($dataValue);
		$data['chart'] = $this->clearXMLTag($graph->fetch($type));
		$data['pst'] = array_sum($d);
		$data['tks'] = array_sum($e);
		$data['arrP'] =  array_combine($bagian, $d);
		$data['arrT'] =  array_combine($bagian, $e);
		return $data;
	}

	public function grapsix1($tahun)
	{
		for ($i = 1; $i <= 6; $i++) {
			$d[] = $this->M_dtmasuk->getTtlkolom($i, $tahun, 'kriteria_stop_six');
		}
		// print_r($d);exit();
		$bagian = array('Aparatus', 'Big Heavy', 'Car', 'Drop', 'Electrical', 'Fire');
		$dataValue = [array_combine($bagian, $d)];

		$settings = $this->settingChart();
		$width = 450;
		$height = 135;
		$type = 'GroupedBarGraph';
		$colours = [['red']];
		$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
		$graph->colours($colours);
		$graph->values($dataValue);
		$data['chart'] = $this->clearXMLTag($graph->fetch($type));
		$data['ttl'] = array_sum($d);
		$data['arr'] = array_combine($bagian, $d);
		return $data;
	}

	public function grapsix2($tahun)
	{
		for ($i = 1; $i <= 6; $i++) {
			$d[] = $this->M_dtmasuk->getTtlkolomLok($i, $tahun, 'kriteria_stop_six', '01');
		}
		for ($i = 1; $i <= 6; $i++) {
			$e[] = $this->M_dtmasuk->getTtlkolomLok($i, $tahun, 'kriteria_stop_six', '02');
		}
		// print_r($d);exit();
		$bagian = array('Aparatus', 'Big Heavy', 'Car', 'Drop', 'Electrical', 'Fire');
		$dataValue = [array_combine($bagian, $d), array_combine($bagian, $e)];

		$settings = $this->settingChart();
		$width = 450;
		$height = 135;
		$type = 'GroupedBarGraph';
		$colours = [['purple'], ['orange']];
		$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
		$graph->colours($colours);
		$graph->values($dataValue);
		$data['chart'] = $this->clearXMLTag($graph->fetch($type));
		$data['pst'] = array_sum($d);
		$data['tks'] = array_sum($e);
		$data['arrP'] = array_combine($bagian, $d);
		$data['arrT'] = array_combine($bagian, $e);
		return $data;
	}

	public function grapjp($tahun)
	{
		for ($i = 1; $i <= 3; $i++) {
			$d[] = $this->M_dtmasuk->getTtlkolom($i, $tahun, 'jenis_pekerjaan');
		}

		$bagian = array('Regular', 'Non Regular', 'Lain-lain');
		$dataValue = [array_combine($bagian, $d)];
		// print_r($dataValue);exit();
		$arr = array('bar_width' => 40);
		$settings = $this->settingChart($arr);
		$width = 550;
		$height = 135;
		$type = 'GroupedBarGraph';
		$colours = [['#337ab7']];
		$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
		$graph->colours($colours);
		$graph->values($dataValue);
		$data['chart'] = $this->clearXMLTag($graph->fetch($type));
		$data['ttl'] = array_sum($d);
		$data['arr'] = array_combine($bagian, $d);
		return $data;
	}

	public function grapwicop($tahun)
	{
		for ($i = 1; $i <= 3; $i++) {
			$d[] = $this->M_dtmasuk->getTtlkolom($i, $tahun, 'prosedur');
		}

		$bagian = array('Sesuai', 'Tidak Sesuai', 'Tidak Terdapat Standar');
		$dataValue = [array_combine($bagian, $d)];

		$arr = array('bar_width' => 40);
		$settings = $this->settingChart($arr);
		$width = 550;
		$height = 135;
		$type = 'GroupedBarGraph';
		$colours = [['orange']];
		$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
		$graph->colours($colours);
		$graph->values($dataValue);
		$data['chart'] = $this->clearXMLTag($graph->fetch($type));
		$data['ttl'] = array_sum($d);
		$data['arr'] = array_combine($bagian, $d);
		return $data;
	}

	public function grapapd($tahun)
	{
		for ($i = 1; $i <= 3; $i++) {
			$d[] = $this->M_dtmasuk->getTtlapd($i, $tahun);
		}

		$bagian = array('Pakai', 'Tidak Pakai', 'Tidak Terdapat Standar');
		$dataValue = [array_combine($bagian, $d)];

		$arr = array('bar_width' => 40);
		$settings = $this->settingChart($arr);
		$width = 550;
		$height = 135;
		$type = 'GroupedBarGraph';
		$colours = [['orange']];
		$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
		$graph->colours($colours);
		$graph->values($dataValue);
		$data['chart'] = $this->clearXMLTag($graph->fetch($type));
		$data['ttl'] = array_sum($d);
		$data['arr'] = array_combine($bagian, $d);
		return $data;
	}

	public function grapunit($year)
	{
		$unit = $this->M_dtmasuk->getKecelakaanUnit($year);
		$unit = array_column($unit, 'jml', 'unit_name');

		$dataValue = [$unit];
		// print_r($dataValue);exit();

		$arr = array('bar_width' => 40, 'axis_text_angle_h' => 10);
		$settings = $this->settingChart($arr);
		$width = 550;
		$height = 135;
		$type = 'GroupedBarGraph';
		$colours = [['yellow']];
		$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
		$graph->colours($colours);
		$graph->values($dataValue);
		$data['chart'] = $this->clearXMLTag($graph->fetch($type));
		return $data;
	}

	public function grapseksiP($year)
	{
		$seksi = $this->M_dtmasuk->getKecelakaanSeksi($year, '01');
		$seksi = array_column($seksi, 'jml', 'section_name');
		$dataValue = [$seksi];

		$arr = array('bar_width' => 40, 'axis_text_angle_h' => 10);
		$settings = $this->settingChart($arr);
		$width = 550;
		$height = 135;
		$type = 'GroupedBarGraph';
		$colours = [['green']];
		$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
		$graph->colours($colours);
		$graph->values($dataValue);
		$data['chart'] = $this->clearXMLTag($graph->fetch($type));
		return $data;
	}

	public function grapseksiT($year)
	{
		$seksi = $this->M_dtmasuk->getKecelakaanSeksi($year, '02');
		$seksi = array_column($seksi, 'jml', 'section_name');
		if (empty($seksi))
			$dataValue = [array('No Data' => '0')];
		else
			$dataValue = [$seksi];


		$arr = array('bar_width' => 40, 'axis_text_angle_h' => 10);
		$settings = $this->settingChart($arr);
		$width = 550;
		$height = 135;
		$type = 'GroupedBarGraph';
		$colours = [['red']];
		$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
		$graph->colours($colours);
		$graph->values($dataValue);
		$data['chart'] = $this->clearXMLTag($graph->fetch($type));
		return $data;
	}

	public function grapbebas($year)
	{
		$bebas = $this->M_dtmasuk->getTglKecelakaan($year);
		$bebas = array_column($bebas, 'tgl');
		array_unshift($bebas, $year . '-01-01');
		$d = array();
		for ($i = 0; $i < count($bebas) - 1; $i++) {
			$date1 = date_create($bebas[$i]);
			$date2 = date_create($bebas[$i + 1]);
			$diff = date_diff($date1, $date2);
			$mon = date('M d, Y', strtotime($bebas[$i + 1]));
			$d[$mon] = $diff->format("%a");
			// echo  $diff->format("%a").'|';
		}
		if (count($d) < 1)
			$dataValue = [array('No Data' => '0')];
		else
			$dataValue = [$d];

		$arr = array('bar_width' => 40, 'axis_text_angle_h' => 40, 'grid_division_h' => 1);
		$settings = $this->settingChart($arr);
		$width = 850;
		$height = 135;
		$type = 'LineGraph';
		$colours = [['red']];
		$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
		$graph->colours($colours);
		$graph->values($dataValue);
		$data['chart'] = $this->clearXMLTag($graph->fetch($type));
		$data['arr'] = $d;
		return $data;
	}

	/**
	 * ??
	 * 
	 * @param String $tahun Year
	 * @return Array
	 */
	public function getlaka($tahun)
	{
		$x = 0;

		if ($tahun == date('Y')) {
			$x = date('m');
		}

		for ($i = 1; $i <= 12; $i++) {
			$m = str_pad($i, 2, '0', STR_PAD_LEFT);

			$tm = "$tahun-$m-01";
			$tm2 = "$tahun-$m";


			$tgl = date('Y-m-t', strtotime($tm));
			$t1[] = $this->M_dtmasuk->getRekapLaka($tgl, '01');
			$t2[] = $this->M_dtmasuk->getRekapLaka($tgl, '02');

			$k1[] = $this->M_dtmasuk->getLaka($tm2, '01');
			$k2[] = $this->M_dtmasuk->getLaka($tm2, '02');

			$month[] = date('M', strtotime($tm));
			if ($x == $i) {
				break;
			}
		}
		// print_r($k1);
		// print_r($k2);exit();

		$data['break'] = $x;
		$data['jmlp'] = $t1;
		$data['jmlt'] = $t2;
		$data['lakap'] = $k1;
		$data['lakat'] = $k2;
		$data['bulan'] = $month;

		for ($i = 0; $i < count($k1); $i++) {
			$persenP[] = round($k1[$i] / $t1[$i] * 100, 1);
			$persenT[] = round($k2[$i] / $t2[$i] * 100, 1);
			$bulan[] = $month[$i];
		}

		$dataValue = [array_combine($bulan, $persenP), array_combine($bulan, $persenT)];
		$arr = array('minimum_units_y' => 0.1, 'axis_max_v' => 1);
		$settings = $this->settingChart($arr);
		$width = 450;
		$height = 335;
		$type = 'GroupedBarGraph';
		$colours = [['blue'], ['red']];
		$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
		$graph->colours($colours);
		$graph->values($dataValue);

		$data['chart'] = $this->clearXMLTag($graph->fetch($type));

		return $data;
	}

	public function getDetailSeksi()
	{
		$ks = $this->input->post('ks');
		$pr = $this->input->post('pr');
		$m = substr($pr, 0, 2);
		$y = substr($pr, 5, 5);
		$pr = $y . '-' . $m;

		if (isset($ks) and !empty($ks)) {
			$baru = '1999-01-01 01:10:10';
			$cek_terbaru = $this->M_dtmasuk->cek_terbaru($ks);
			if (!isset($cek_terbaru) || !empty($cek_terbaru)) {
				$baru = $cek_terbaru[0]['tgl_approve_tim'];
			}
			$data = $this->M_dtmasuk->getListAprove($ks, $baru);
			$getorder = $this->M_order->getTglInputOrder($ks, $pr);
			$tglinput = $getorder->tgl_input;
			echo '<p>Tanggal Order : ' . $tglinput . '</p>';
			echo '<p style = "color : red;">Merah : Pekerja keluar setelah tanggal order</p>';
			echo '<p style = "color : blue;">Biru   : Pekerja masuk setelah tanggal order</p>';
			$getPekerja = $this->M_order->getPekerjaforDetail($ks, $tglinput);
			if (empty($getPekerja)) {
				echo '<center><ul class="list-group"><li class="list-group-item">' . 'Kosong' . '</li></ul></center>';
			} else {
				echo '
				<div class="table-responsive">
				<table id="tbl_detailHitungOrderSeksi" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th width="3%">No</th>
						<th width="5%">Noind</th>
						<th width="10%">Nama</th>
						<th width="10%">Pekerjaan</th>';
				foreach ($data as $key => $value) {
					echo '<th>' . $value['item'] . '</th>';
				}

				echo '</tr></thead>';
				$i = 2;
				echo '
				<tbody>
				<tr>
				<td>1</td>
				<td>-</td>
				<td>-</td>
				<td>KEBUTUHAN UMUM</td>
				';
				foreach ($data as $key => $value) {
					echo '<td>' . $value['jml_kebutuhan_umum'] . '</td>';
				}
				echo '</tr>';
				foreach ($getPekerja as $key) {
					echo '
					<tr>
						<td style="color : ' . $key["color"] . ';">' . $i . '</td>
						<td style="color : ' . $key["color"] . ';">' . $key["noind"] . '</td>
						<td style="color : ' . $key["color"] . ';">' . $key["nama"] . '</td>
						<td style="color : ' . $key["color"] . ';">' . $key["pekerjaan"] . '</td>';
					foreach ($data as $key2 => $val) {
						$explode = explode(",", $val['kd_pekerjaan']);
						$explode2 = explode(",", $val['jml_item']);
						foreach ($explode as $key3 => $valkode) {
							foreach ($explode2 as $key4 => $valjml) {
								if ($valkode == $key['kdpekerjaan'] && $key3 == $key4 && $valkode != null) {
									echo '<td style="color : ' . $key['color'] . ';">';
									echo $key['color'] != 'blue' ? $valjml : '0' . '</td>';
								}
							}
						}
						if ($key['pekerjaan'] == 'STAFF') {
							echo '<td style="color : ' . $key['color'] . ';">';
							echo  $key['color'] != 'blue' ? $val['jml_kebutuhan_staff'] : '0' . '</td>';
						}
					}
					$i++;
					echo '</tr>';
				}
				echo '</tbody>';
				echo '<tfoot><tr>
				<td> </td>			
				<td> </td>			
				<td> </td>			
				<td>Jumlah</td>';
				foreach ($data as $key => $val) {
					$total = 0;
					$b = 0;
					$explode = explode(",", $val['kd_pekerjaan']);
					$explode2 = explode(",", $val['jml_item']);
					foreach ($getPekerja as $key) {
						foreach ($explode as $key3 => $valkode) {
							foreach ($explode2 as $key4 => $valjml) {
								if ($valkode == $key['kdpekerjaan'] && $key3 == $key4) {
									$key['color'] == 'blue' ? $total - $valjml : $total += $valjml;
								}
							}
						}
						if ($key['pekerjaan'] == 'STAFF') {
							$key['color'] == 'blue' ? $b - $val['jml_kebutuhan_staff'] : $b += $val['jml_kebutuhan_staff'];
						}
					}
					$sum = $total + $b + $val['jml_kebutuhan_umum'];
					echo '<td>' . round($sum) . '</td>';
				}
				echo '</tr></tfoot></table>
				</div>';
			}
		} else {
			echo '<center><ul class="list-group"><li class="list-group-item">' . 'Kodesie tidak ditemukan' . '</li></ul></center>';
		}
	}

	public function PeriodeSafetyShoes()
	{
		$user1 = $this->session->user;
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Setup';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Periode Safety Shoes';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['lseksi'] = $this->M_dtmasuk->getSeksiNotPeriode();

		$data['periode'] = $this->M_dtmasuk->GetPeriodeSepatu();
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('P2K3V2/P2K3Admin/APD/V_Admin_Setup_Periode_SafetyShoes', $data);
		$this->load->view('V_Footer', $data);
	}

	public function EditPeriodeSafetyShoes()
	{
		$kodesie = $this->input->post('kodesie');
		$periode = $this->input->post('periode');
		$this->M_dtmasuk->UpdatePeriodeSepatu($kodesie, $periode);
		redirect('p2k3adm_V2/Admin/PeriodeSafetyShoes');
	}

	public function ajaxGetKebSet()
	{
		$key = $this->input->get('kodeSie');
		$key2 = $this->input->get('kdPekerjaan');
		$apd = $this->M_dtmasuk->getItemPekerja($key, $key2);
		if (!empty($apd)) {
			$apd = array_filter($apd, function ($a) {
				return $a['jml_item'] > 0;
			});
			usort($apd, function ($a, $b) {
				return $a['urutan'] > $b['urutan'];
			});
			$kelompok_tubuh  = array_column($apd, 'kelompok_tubuh');
			$data['apd'] = [];

			foreach ($kelompok_tubuh as $kelTubuh) {
				$adp_filtered = array_filter($apd, function ($apdval) use ($kelTubuh) {
					return $apdval['kelompok_tubuh'] == $kelTubuh;
				});
				$data['apd'][$kelTubuh] = $adp_filtered;
			}

			$askaNit = $this->M_order->getTrefjabatanKanit($this->M_dtmasuk->getDataKop($key)[0]['noindaskanit'], substr($key, 0, 5));
			$data['pekerjaan'] = $this->input->get('pekerjaan');
			$data['seksiName'] = $this->input->get('seksiName');
			$data['kelompok_tubuh'] = $kelompok_tubuh;
			$data['person'] = 'PegawaiKHS.jpg';
			$data['data_kop'] = $this->M_dtmasuk->getDataKop($key)[0];
			$data['seksiUnit'] = $askaNit;
			$view_apd = $this->load->view('P2K3V2/P2K3Admin/APD/V_Standar_pdf', $data, TRUE);
			$this->session->set_userdata('view_apd', $view_apd);
			echo $this->load->view('P2K3V2/P2K3Admin/APD/V_Standar_apd', $data, TRUE);
		} else {
			echo "<h1 class='text-center'>APD KOSONG</h1>";
		}
	}

	public function getKebstaff()
	{
		$ks = $this->input->get('kodeSie');
		$data['seksiName'] = $this->input->get('seksiName');
		$data['pekerjaan'] = 'STAFF';
		$apd = $this->M_dtmasuk->getItemStaff($ks);
		$apd = array_filter($apd, function ($a) {
			return $a['jml_kebutuhan_staff'] > 0;
		});

		usort($apd, function ($a, $b) {
			return $a['urutan'] > $b['urutan'];
		});

		$kelompok_tubuh  = array_column($apd, 'kelompok_tubuh');

		$data['apd'] = [];

		foreach ($kelompok_tubuh as $kelTubuh) {
			$adp_filtered = array_filter($apd, function ($apdval) use ($kelTubuh) {
				return $apdval['kelompok_tubuh'] == $kelTubuh;
			});
			$data['apd'][$kelTubuh] = $adp_filtered;
		}

		$askaNit = $this->M_order->getTrefjabatanKanit($this->M_dtmasuk->getDataKop($ks)[0]['noindaskanit'], substr($ks, 0, 5));
		$data['data_kop'] = $this->M_dtmasuk->getDataKop($ks)[0];
		$data['seksiUnit'] = $askaNit;
		$data['person'] = 'PegawaiKHS.jpg';
		$view_apd =  $this->load->view('P2K3V2/P2K3Admin/APD/V_Standar_pdf', $data, TRUE);
		$this->session->set_userdata('view_apd', $view_apd);
		echo $this->load->view('P2K3V2/P2K3Admin/APD/V_Standar_apd', $data, TRUE);
	}

	public function exportPdf()
	{
		set_time_limit(0);
		$tanggal = date('Y-m-d H:i:s');
		$user = $this->session->user;
		$name = $this->session->employee;

		$pdf     =  $this->pdf->load();
		$standar_pdf = $this->session->view_apd;
		$pdf     =  new mPDF('utf-8', array(215, 330), 10, "Arial", 20, 20, 20, 20, 0, 0, 'P', ['default_font' => 'Arial']);
		$pdf->useSubstitutions = false;
		$pdf->AddPage();
		$pdf->WriteHTML($standar_pdf);
		$pdf->setTitle('KKK-KHS-01');
		$pdf->setFooter("Dicetak Melalui Quick ERP - P2K3 Pada $tanggal Oleh $user - $name");
		$pdf->Output('KKK-KHS-01.pdf', 'I');
	}
	public function AddPeriodeSafetyShoes()
	{
		$kodesie = $this->input->post('kodesie');
		$periode = $this->input->post('periode');
		$arr = [
			'kodesie'	=>	$kodesie,
			'periode'	=>	$periode,
		];
		$this->M_dtmasuk->addPeriodeSepatu($arr);
		redirect('p2k3adm_V2/Admin/PeriodeSafetyShoes');
	}
}
