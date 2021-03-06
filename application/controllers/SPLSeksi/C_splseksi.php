<?php
defined('BASEPATH') or exit('No direct script access allowed');
set_time_limit(0);
class C_splseksi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		// another way to load
		$this->load->library('../controllers/SPLSeksi/Pusat/Lembur');

		$this->load->model('SPLSeksi/M_splseksi');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		date_default_timezone_set('Asia/Jakarta');
	}

	public function checkSession()
	{
		if ($this->session->is_logged) {
			// any
		} else {
			redirect('');
		}
	}

	public function menu($a, $b, $c)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = $a;
		$data['SubMenuOne'] = $b;
		$data['SubMenuTwo'] = $c;

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		return $data;
	}

	public function index()
	{
		$this->checkSession();
		$this->session->sex = $this->M_splseksi->getSexEmployee($this->session->user);
		$data = $this->menu('', '', '');
		$data['responsibility_id'] = $this->session->responsibility_id;
		$data['jari'] = $this->M_splseksi->getJari($this->session->userid);

		$wkt_validasi_kasie = $this->session->spl_validasi_waktu_kasie;
		$wkt_validasi_asska = $this->session->spl_validasi_waktu_asska;
		$wkt_validasi_operator = $this->session->spl_validasi_waktu_operator;

		$exp_time = 120; // default value is 120 or 2 minutes

		if ($this->session->spl_validasi_kasie !== TRUE) {
			$this->session->spl_validasi_kasie = FALSE;
		} else {
			if (time() - $wkt_validasi_kasie > $exp_time) {
				$this->session->spl_validasi_kasie = FALSE;
			}
		}
		if ($this->session->spl_validasi_asska !== TRUE) {
			$this->session->spl_validasi_asska = FALSE;
		} else {
			if (time() - $wkt_validasi_asska > $exp_time) {
				$this->session->spl_validasi_asska = FALSE;
			}
		}
		if ($this->session->spl_validasi_operator !== TRUE) {
			$this->session->spl_validasi_operator = FALSE;
		} else {
			if (time() - $wkt_validasi_operator > $exp_time) {
				$this->session->spl_validasi_operator = FALSE;
			}
		}

		// echo $data['responsibility_id']; die;
		$akses_sie = array();
		$akses_kue = $this->M_splseksi->show_pekerja('', $this->session->user, '');
		$akses_spl = $this->M_splseksi->show_akses_seksi($this->session->user);
		foreach ($akses_kue as $ak) {
			$akses_sie[] = $this->cut_kodesie($ak['kodesie']);
			foreach ($akses_spl as $as) {
				$akses_sie[] = $this->cut_kodesie($as['kodesie']);
			}
		}

		if ($data['responsibility_id'] == 2592) { // KASIE
			// $data['rekap_spl'] = $this->M_splseksi->getRekapSpl($this->session->user,'7');
			$data['baru'] = $this->M_splseksi->getCountDashboard($akses_sie, "'01'");
			$data['reject'] = $this->M_splseksi->getCountDashboard($akses_sie, "'35'");
			$data['total'] = $this->M_splseksi->getCountDashboard($akses_sie);
			// get akses seksi


			if ($this->session->spl_validasi_kasie == TRUE) {
				$this->load->view('V_Header', $data);
				$this->load->view('V_Sidemenu', $data);
				$this->load->view('SPLSeksi/Seksi/V_Index', $data);
				$this->load->view('V_Footer', $data);
			} else {
				$this->load->view('V_Header', $data);
				$this->load->view('SPLSeksi/Seksi/V_Index', $data);
				$this->load->view('V_Footer', $data);
			}
		} elseif ($data['responsibility_id'] == 2593) { // ASKA
			// $data['rekap_spl'] = $this->M_splseksi->getRekapSpl($this->session->user,'5');
			$data['baru'] = $this->M_splseksi->getCountDashboard($akses_sie, "'01','21'");
			$data['reject'] = $this->M_splseksi->getCountDashboard($akses_sie, "'35'");
			$data['total'] = $this->M_splseksi->getCountDashboard($akses_sie);

			if ($this->session->spl_validasi_asska == TRUE) {
				$this->load->view('V_Header', $data);
				$this->load->view('V_Sidemenu', $data);
				$this->load->view('SPLSeksi/Seksi/V_Index', $data);
				$this->load->view('V_Footer', $data);
			} else {
				$this->load->view('V_Header', $data);
				$this->load->view('SPLSeksi/Seksi/V_Index', $data);
				$this->load->view('V_Footer', $data);
			}
		} elseif ($data['responsibility_id'] == 2587) {
			$data['rekap_spl'] = $this->M_splseksi->getRekapSpl($this->session->user, '7');
			if ($this->session->spl_validasi_operator == TRUE) {
				$this->load->view('V_Header', $data);
				$this->load->view('V_Sidemenu', $data);
				$this->load->view('SPLSeksi/Seksi/V_Index', $data);
				$this->load->view('V_Footer', $data);
			} else {
				$this->load->view('V_Header', $data);
				$this->load->view('SPLSeksi/Seksi/V_Index', $data);
				$this->load->view('V_Footer', $data);
			}
		} else {
			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu', $data);
			$this->load->view('SPLSeksi/Seksi/V_Index', $data);
			$this->load->view('V_Footer', $data);
		}
	}

	public function data_spl()
	{
		$this->checkSession();
		$wkt_validasi_operator = $this->session->spl_validasi_waktu_operator;
		if (time() - $wkt_validasi_operator > 120) {
			$this->session->spl_validasi_operator = FALSE;
			redirect(site_url('SPL'));
		}
		$this->session->spl_validasi_waktu_operator = time();
		$data = $this->menu('', '', '');
		$data['lokasi'] = $this->M_splseksi->show_lokasi();
		if ($this->input->get('stat')) {
			$status = $this->input->get('stat');
			$data_spl = array();
			if ($status == 'Baru') {
				$show_list_spl = $this->M_splseksi->show_spl2('0%', $this->session->user, '7');
			} elseif ($status == 'Tolak') {
				$show_list_spl = $this->M_splseksi->show_spl2('2%', $this->session->user, '7');
			} else {
				$show_list_spl = $this->M_splseksi->show_spl2('%', $this->session->user, '7');
			}
			foreach ($show_list_spl as $sls) {
				$index = array();
				$btn_hapus = "";
				if ($sls['Status'] == '01' or $sls['Status'] == '31' or $sls['Status'] == '35') {
					$btn_hapus = "<a data-id='{$sls['ID_SPL']}' data-noind='{$sls['Noind']}' data-nama='{$sls['nama']}' onclick='deleteLembur($(this))' title='Hapus'><i class='fa fa-fw fa-trash'></i></a>";
				}
				$index[] = "<a href='" . site_url('SPL/EditLembur/' . $sls['ID_SPL']) . "' title='Detail'><i class='fa fa-fw fa-search'></i></a>
					$btn_hapus";
				$index[] = $sls['Deskripsi'] . " " . $sls['User_'] . " (" . $sls['user_approve'] . ")";
				$index[] = $sls['Tgl_Lembur'];
				$index[] = $sls['Noind'];
				$index[] = $sls['nama'];
				// $index[] = $sls['kodesie'];
				// $index[] = $sls['seksi'];
				$index[] = $this->convertUnOrderedlist($sls['Pekerjaan']);
				$index[] = $sls['nama_lembur'];
				$index[] = $sls['Jam_Mulai_Lembur'];
				$index[] = $sls['Jam_Akhir_Lembur'];
				$index[] = $this->hitung_jam_lembur($sls['Noind'], $sls['Kd_Lembur'], $sls['Tgl_Lembur'], $sls['Jam_Mulai_Lembur'], $sls['Jam_Akhir_Lembur'], $sls['Break'], $sls['Istirahat']);
				$index[] = $sls['Break'];
				$index[] = $sls['Istirahat'];
				$index[] = $this->convertUnOrderedlist($sls['target']);
				$index[] = $this->convertUnOrderedlist($sls['realisasi']);
				$index[] = $sls['alasan_lembur'];
				$index[] = $sls['Tgl_Berlaku'];

				$data_spl[] = $index;
			}
			$data['data'] = $data_spl;
		}
		// print_r($data['data']);exit();
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('SPLSeksi/Seksi/V_data_spl', $data);
		$this->load->view('V_Footer', $data);
	}

	public function hitung_jam_lembur($noind, $kode_lembur, $tgl, $mulai, $selesai, $break, $istirahat)
	{
		return $this->lembur->hitung_jam_lembur($noind, $kode_lembur, $tgl, $mulai, $selesai, $break, $istirahat);
	}

	public function show_pekerja()
	{
		$this->checkSession();
		$this->session->spl_validasi_waktu_operator = time();
		$key = $_GET['key'];
		$key2 = $_GET['key2'];
		$user = $this->session->user;

		// get akses seksi
		$akses_sie = array();
		$akses_kue = $this->M_splseksi->show_pekerja('', $user, '');
		$akses_spl = $this->M_splseksi->show_akses_seksi($user);
		foreach ($akses_kue as $ak) {
			$akses_sie[] = $this->cut_kodesie(substr($ak['kodesie'], 0, 7) . '00');
			foreach ($akses_spl as $as) {
				$akses_sie[] = $this->cut_kodesie($as['kodesie']);
			}
		}

		$data = $this->M_splseksi->show_pekerja($key, $key2, $akses_sie);
		echo json_encode($data);
	}

	public function show_pekerja2()
	{
		$this->checkSession();
		$this->session->spl_validasi_waktu_operator = time();
		$key = $_GET['key'];

		$data = $this->M_splseksi->show_pekerja2($key);
		echo json_encode($data);
	}

	public function show_pekerja3()
	{
		$this->checkSession();
		$this->session->spl_validasi_waktu_operator = time();
		$key = $_GET['key'];
		$key2 = $_GET['key2'];
		$noind = explode(".", $key2);
		$ni = "";
		foreach ($noind as $val) {
			if ($ni == "") {
				$ni .= "'$val'";
			} else {
				$ni .= ",'$val'";
			}
		}

		$user = $this->session->user;

		// get akses seksi
		// $akses_sie = array();
		// $akses_kue = $this->M_splseksi->show_pekerja('', $user, '');
		// $akses_spl = $this->M_splseksi->show_akses_seksi($user);
		// foreach($akses_kue as $ak){
		// 	$akses_sie[] = $this->cut_kodesie($ak['kodesie']);
		// 	foreach($akses_spl as $as){
		// 		$akses_sie[] = $this->cut_kodesie($as['kodesie']);
		// 	}
		// }
		// $data = $this->M_splseksi->show_pekerja3($key,$ni,$akses_sie);

		$data = $this->M_splseksi->show_pekerja4($key, $ni); //hanya pekerja 1 seksi
		echo json_encode($data);
	}

	public function show_shift()
	{
		$this->checkSession();
		$this->session->spl_validasi_waktu_operator = time();
		$key = $_GET['key'];
		$tgl = $_GET['key2'];
		$data = $this->M_splseksi->getShiftMemo($key, $tgl);
		echo json_encode($data);
	}

	public function show_seksi()
	{
		$this->checkSession();
		$this->session->spl_validasi_waktu_operator = time();
		$key = $_GET['key'];
		$key2 = $_GET['key2'];
		$user = $this->session->user;

		// get akses seksi
		$akses_sie = array();
		$akses_kue = $this->M_splseksi->show_pekerja('', $user, '');
		$akses_spl = $this->M_splseksi->show_akses_seksi($user);
		foreach ($akses_kue as $ak) {
			$akses_sie[] = $this->cut_kodesie($ak['kodesie']);
			foreach ($akses_spl as $as) {
				$akses_sie[] = $this->cut_kodesie($as['kodesie']);
			}
		}

		$data = $this->M_splseksi->show_seksi($key, $key2, $akses_sie);
		echo json_encode($data);
	}

	public function cut_kodesie($id)
	{
		$z = 0;
		for ($x = -1; $x >= -strlen($id); $x--) {
			if (substr($id, $x, 1) == "0") {
				$z++;
			} else {
				break;
			}
		}

		$data = substr($id, 0, strlen($id) - $z);
		return $data;
	}

	public function data_spl_filter()
	{
		$this->checkSession();
		$this->session->spl_validasi_waktu_operator = time();
		$user = $this->session->user;
		$dari = $this->input->post('dari');
		$dari = date_format(date_create($dari), "Y-m-d");
		$sampai = $this->input->post('sampai');
		$sampai = date_format(date_create($sampai), "Y-m-d");
		$status = $this->input->post('status');
		$lokasi = $this->input->post('lokasi');
		$noind = $this->input->post('noind');

		// get akses seksi
		$akses_sie = array();
		$akses_kue = $this->M_splseksi->show_pekerja('', $user, '');
		$akses_spl = $this->M_splseksi->show_akses_seksi($user);
		foreach ($akses_kue as $ak) {
			$akses_sie[] = $this->cut_kodesie(substr($ak['kodesie'], 0, 7) . '00');
			foreach ($akses_spl as $as) {
				$akses_sie[] = $this->cut_kodesie($as['kodesie']);
			}
		}

		$data_spl = array();
		$show_list_spl = $this->M_splseksi->show_spl($dari, $sampai, $status, $lokasi, $noind, $akses_sie);
		foreach ($show_list_spl as $sls) {
			$index = array();
			$btn_hapus = "";
			if ($sls['Status'] == '01' or $sls['Status'] == '31' or $sls['Status'] == '35') {
				$btn_hapus = "<a data-id='{$sls['ID_SPL']}' data-noind='{$sls['Noind']}' data-nama='{$sls['nama']}' onclick='deleteLembur($(this))' title='Hapus'><i class='fa fa-fw fa-trash'></i></a>";
			}
			$index[] = "<a href='" . site_url('SPL/EditLembur/' . $sls['ID_SPL']) . "' title='Detail'><i class='fa fa-fw fa-search'></i></a>
				$btn_hapus";
			$index[] = $sls['Deskripsi'] . " " . $sls['User_'] . " (" . $sls['user_approve'] . ")";
			$index[] = $sls['Tgl_Lembur'];
			$index[] = $sls['Noind'];
			$index[] = $sls['nama'];
			// $index[] = $sls['kodesie'];
			// $index[] = $sls['seksi'];
			$index[] = $this->convertUnOrderedlist($sls['Pekerjaan']);
			$index[] = $sls['nama_lembur'];
			$index[] = $sls['Jam_Mulai_Lembur'];
			$index[] = $sls['Jam_Akhir_Lembur'];
			$index[] = $sls['Break'];
			$index[] = $sls['Istirahat'];
			$index[] = $this->hitung_jam_lembur($sls['Noind'], $sls['Kd_Lembur'], $sls['Tgl_Lembur'], $sls['Jam_Mulai_Lembur'], $sls['Jam_Akhir_Lembur'], $sls['Break'], $sls['Istirahat']);
			$index[] = $this->convertUnOrderedlist($sls['target']);
			$index[] = $this->convertUnOrderedlist($sls['realisasi']);
			$index[] = $sls['alasan_lembur'];
			$index[] = $sls['Tgl_Berlaku'];

			$data_spl[] = $index;
		}
		echo json_encode($data_spl);
	}

	function convertUnOrderedlist($data)
	{
		//separator ; (semicolon)
		$item = explode(';', $data);
		$html = "<ul>";
		foreach ($item as $key) {
			$html .= "<li>$key</li>";
		}
		$html .= "</ul>";
		return $html;
	}

	public function data_spl_cetak()
	{
		$this->checkSession();
		$this->session->spl_validasi_waktu_operator = time();
		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$user = $this->session->user;
		$dari = $this->input->post('dari');
		$dari = date_format(date_create($dari), "Y-m-d");
		$sampai = $this->input->post('sampai');
		$sampai = date_format(date_create($sampai), "Y-m-d");
		$status = $this->input->post('status');
		$lokasi = $this->input->post('lokasi');
		$noind = $this->input->post('noind');

		// get akses seksi
		$akses_sie = array();
		$akses_kue = $this->M_splseksi->show_pekerja('', $user, '');
		$akses_spl = $this->M_splseksi->show_akses_seksi($user);
		foreach ($akses_kue as $ak) {
			$akses_sie[] = $this->cut_kodesie(substr($ak['kodesie'], 0, 7) . '00');
			foreach ($akses_spl as $as) {
				$akses_sie[] = $this->cut_kodesie($as['kodesie']);
			}
		}

		$data['data_spl'] = $this->M_splseksi->show_spl($dari, $sampai, $status, $lokasi, $noind, $akses_sie);
		$arrSk = array();
		$arrSk2 = array();
		$x = 0;

		//dapatkan seksi tanpa duplikat
		foreach ($data['data_spl'] as $key) {
			if (empty($arrSk)) {
				$arrSk[$x]['seksi'] = $key['seksi'];
				$arrSk[$x]['unit'] = $key['unit'];
				$arrSk[$x]['dept'] = $key['dept'];

				$arrSk2[] = $key['seksi'];
				$x++;
			} elseif (in_array($key['seksi'], $arrSk2) === false) {
				$arrSk[$x]['seksi'] = $key['seksi'];
				$arrSk[$x]['unit'] = $key['unit'];
				$arrSk[$x]['dept'] = $key['dept'];

				$arrSk2[] = $key['seksi'];
				$x++;
			}
		}

		//isi tanggal berapa saja seksi tersebut muncul
		for ($i = 0; $i < count($arrSk); $i++) {
			foreach ($data['data_spl'] as $key) {
				if ($arrSk[$i]['seksi'] == $key['seksi']) {
					$arrSk[$i]['tanggal'][] = $key['Tgl_Lembur'];
				}
			}
		}

		$data['sk'] = $arrSk;
		$data['tgl'] = array_values(array_unique(array_column($data['data_spl'], 'Tgl_Lembur')));

		// echo "<pre>";
		// print_r($arrSk);exit();

		$filename = 'Surat Perintah Lembur.pdf';
		$pdf = new mPDF('', 'A4-L', 0, '', 5, 5, 5, 5);
		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));

		$pdf->WriteHTML($stylesheet, 1);
		$html = $this->load->view('SPLSeksi/Seksi/V_cetak_spl', $data, true);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

	public function hapus_spl($idspl)
	{
		$this->checkSession();
		$this->session->spl_validasi_waktu_operator = time();
		$to_hapus = $this->M_splseksi->drop_spl($idspl);
		redirect(base_url('SPL/ListLembur'));
	}

	public function edit_spl($idspl)
	{
		$this->checkSession();
		$wkt_validasi_operator = $this->session->spl_validasi_waktu_operator;
		if (time() - $wkt_validasi_operator > 120) {
			$this->session->spl_validasi_operator = FALSE;
			redirect(site_url('SPL'));
		}
		$this->session->spl_validasi_waktu_operator = time();
		$data = $this->menu('', '', '');
		$data['jenis_lembur'] = $this->M_splseksi->show_jenis_lembur();
		$data['lembur'] = $this->M_splseksi->show_current_spl('', '', '', $idspl);
		$data['result'] = $this->input->get('result');
		// echo "<pre>";print_r($data);exit();
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('SPLSeksi/Seksi/V_edit_spl', $data);
		$this->load->view('V_Footer', $data);
	}

	public function edit_spl_submit()
	{
		$this->checkSession();
		$this->session->spl_validasi_waktu_operator = time();
		$user_id = $this->session->user;
		$tanggal = $this->input->post('tanggal_0');
		$tanggal = date_format(date_create($tanggal), "Y-m-d");
		$mulai = $this->input->post('waktu_0');
		$mulai = date_format(date_create($mulai), "H:i:s");
		$selesai = $this->input->post('waktu_1');
		$selesai = date_format(date_create($selesai), "H:i:s");
		$lembur = $this->input->post('kd_lembur');
		$istirahat = $this->input->post('istirahat');
		$break = $this->input->post('break');
		$alasan = str_replace("'", '', $this->input->post('alasan'));
		$noind = $this->input->post("noind[0]");
		$target_arr = $this->input->post("target");
		$target_satuan_arr = $this->input->post("target_satuan");
		$noind_baru = $this->M_splseksi->getNoindBaru($noind);

		//menyatukan target
		$i = 0;
		for ($i; $i < count($target_arr); $i++) {
			$target[] = $target_arr[$i] . " " . $target_satuan_arr[$i];
		}
		$target = implode(';', $target);

		$realisasi_arr = $this->input->post("realisasi");
		$realisasi_satuan_arr = $this->input->post("realisasi_satuan");

		//menyatukan realisasi
		$i = 0;
		for ($i; $i < count($target_arr); $i++) {
			$realisasi[] = $realisasi_arr[$i] . " " . $realisasi_satuan_arr[$i];
		}
		$realisasi = implode(';', $realisasi);

		$pekerjaan = $this->input->post("pekerjaan");
		$pekerjaan = str_replace("'", '', implode(';', $pekerjaan));
		$spl_id = $this->input->post('id_spl');
		$old_spl = $this->M_splseksi->show_current_spl('', '', '', $spl_id);

		// Generate ID Riwayat
		// $maxid = $this->M_splseksi->show_maxid("splseksi.tspl_riwayat", "ID_Riwayat");
		// if (empty($maxid)) {
		// 	$splr_id = "0000000001";
		// } else {
		// 	$splr_id = $maxid->id;
		// 	$splr_id = substr("0000000000", 0, 10 - strlen($splr_id)) . $splr_id;
		// }

		// Insert data
		$log_ket = "";
		foreach ($old_spl as $os) {
			$log_ket = "Noind:" . $os['Noind'] . "->" . $noind .
				" Tgl:" . date_format(date_create($os['Tgl_Lembur']), "Y-m-d") . "->" . $tanggal .
				" Kd:" . $os['Kd_Lembur'] . "->" . $lembur .
				" Jam:" . date_format(date_create($os['Jam_Mulai_Lembur']), "H:i:s") . "-" . date_format(date_create($os['Jam_Akhir_Lembur']), "H:i:s") . "->" . $mulai . "-" . $selesai .
				" Break:" . $os['Break'] . "->" . $break .
				" Ist:" . $os['Istirahat'] . "->" . $istirahat . "<br />";
		}

		$data_log = array(
			"wkt" => date('Y-m-d H:i:s'),
			"menu" => "Operator",
			"jenis" => "Ubah",
			"ket" => $log_ket,
			"noind" => $user_id
		);
		$to_log = $this->M_splseksi->save_log($data_log);

		$data_spl = array(
			"Tgl_Berlaku" => date('Y-m-d H:i:s'),
			"Tgl_Lembur" => $tanggal,
			"Noind" => $noind,
			"Noind_Baru" => $noind_baru,
			"Kd_Lembur" => $lembur,
			"Jam_Mulai_Lembur" => $mulai,
			"Jam_Akhir_Lembur" => $selesai,
			"Break" => $break,
			"Istirahat" => $istirahat,
			"Pekerjaan" => $pekerjaan,
			"Status" => "01",
			"User_" => $user_id,
			"target" => $target,
			"realisasi" => $realisasi,
			"alasan_lembur" => $alasan
		);
		$to_spl = $this->M_splseksi->update_spl($data_spl, $spl_id);

		$data_splr = array(
			// "ID_Riwayat" => $splr_id,
			"ID_SPL" => $spl_id,
			"Tgl_Berlaku" => date('Y-m-d H:i:s'),
			"Tgl_Tdk_Berlaku" => date('Y-m-d H:i:s'),
			"Tgl_Lembur" => $tanggal,
			"Noind" => $noind,
			"Noind_Baru" => $noind_baru,
			"Kd_Lembur" => $lembur,
			"Jam_Mulai_Lembur" => $mulai,
			"Jam_Akhir_Lembur" => $selesai,
			"Break" => $break,
			"Istirahat" => $istirahat,
			"Pekerjaan" => $pekerjaan,
			"Status" => "01",
			"User_" => $user_id,
			"Revisi" => "0",
			"Keterangan" => "(Ubah)",
			"target" => $target,
			"realisasi" => $realisasi,
			"alasan_lembur" => $alasan
		);
		$to_splr = $this->M_splseksi->save_splr($data_splr);

		redirect(base_url('SPL/ListLembur/'));
	}

	public function new_spl()
	{
		$this->checkSession();
		$wkt_validasi_operator = $this->session->spl_validasi_waktu_operator;
		// if (time() - $wkt_validasi_operator > 120) {
		// 	$this->session->spl_validasi_operator = FALSE;
		// 	redirect(site_url('SPL'));
		// }
		$this->session->spl_validasi_waktu_operator = time();
		$data = $this->menu('', '', '');
		$data['jenis_lembur'] = $this->M_splseksi->show_jenis_lembur();
		$data['result'] = $this->input->get('result');

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('SPLSeksi/Seksi/V_new_spl', $data);
		$this->load->view('V_Footer', $data);
	}

	public function cek_anonymous()
	{
		$this->checkSession();
		$this->session->spl_validasi_waktu_operator = time();
		$error = "";
		$waktu0 = $this->input->post("waktu0");
		$waktu1 = $this->input->post("waktu1");
		$lembur = $this->input->post("lembur");
		$noind = $this->input->post("noind");
		$tanggal = $this->input->post("tanggal");
		$tanggal = date_format(date_create($tanggal), 'Y-m-d');

		$shift = $this->M_splseksi->show_current_shift($tanggal, $noind);
		if (!empty($shift)) {
			if ($lembur != "004") {
				foreach ($shift as $s) {
					// jam lembur
					if ($waktu1 < $waktu0 || ($s['jam_plg'] < $s['jam_msk'] && $lembur == "002")) {
						if ($s['jam_plg'] < $s['jam_msk'] && $lembur == "002") {
							$tanggal0 = date_format(date_add(date_create($tanggal), date_interval_create_from_date_string('1 days')), "Y-m-d");
							$tanggal1 = date_format(date_add(date_create($tanggal), date_interval_create_from_date_string('1 days')), "Y-m-d");
						} else {
							$tanggal0 = $tanggal;
							$tanggal1 = date_format(date_add(date_create($tanggal), date_interval_create_from_date_string('1 days')), "Y-m-d");
						}
					} else {
						$tanggal0 = $tanggal;
						$tanggal1 = $tanggal;
					}
					$mulai = date_format(date_create($tanggal0), "Y-m-d") . " " . $waktu0;
					$mulai = date_format(date_create($mulai), 'Y-m-d H:i:s');
					$selesai = date_format(date_create($tanggal1), "Y-m-d") . " " . $waktu1;
					$selesai = date_format(date_create($selesai), 'Y-m-d H:i:s');

					// jam shift
					if ($s['jam_plg'] < $s['jam_msk']) {
						$tanggal0 = $tanggal;
						$tanggal1 = date_format(date_add(date_create($tanggal), date_interval_create_from_date_string('1 days')), "Y-m-d");
					} else {
						$tanggal0 = $tanggal;
						$tanggal1 = $tanggal;
					}
					$mangkat = date_format(date_create($tanggal0), "Y-m-d") . " " . $s['jam_msk'];
					$mangkat = date_format(date_create($mangkat), 'Y-m-d H:i:s');
					$pulang = date_format(date_create($tanggal1), "Y-m-d") . " " . $s['jam_plg'];
					$pulang = date_format(date_create($pulang), 'Y-m-d H:i:s');

					// cocokkkan
					if ($mulai < $mangkat && $selesai > $pulang) {
						$error = "[0] Waktu lembur melewati shift -> $mulai@$selesai@$mangkat@$pulang";
					} elseif ($lembur == "002" && ($mulai < $pulang || $selesai < $pulang)) {
						$error = "[1] Waktu lembur tidak sesuai -> $mulai@$selesai@$mangkat@$pulang";
					} elseif ($lembur == "003" && ($mulai > $mangkat || $selesai > $mangkat)) {
						$error = "[2] Waktu lembur tidak sesuai -> $mulai@$selesai@$mangkat@$pulang";
					}
				}
			} else {
				$error = "[0] Bukan merupakan hari libur";
			}
		} else {
			if ($lembur != "004") {
				$error = "[1] Seharusnya merupakan hari libur";
			}
		}

		$lembur = $this->M_splseksi->show_current_spl($tanggal, $noind, $lembur, '');
		if (!empty($lembur)) {
			$error = "Data lembur pernah di input";
		}

		echo $error;
	}

	public function cek_anonymous2()
	{
		$this->checkSession();
		$this->session->spl_validasi_waktu_operator = time();

		$error = "0";
		$errortext = "";
		$aktual_awal = "";
		$aktual_akhir = "";
		$masuk_shift = "";
		$keluar_shift = "";
		$masuk_absen = "";
		$keluar_absen = "";
		$awal_lembur = "";
		$awal_lembur = "";
		$akhir_lembur = "";
		$akhir_lembur = "";
		$mulai_ist = "";
		$selesai_ist = "";

		$waktu0 = $this->input->post("waktu0");
		$waktu1 = $this->input->post("waktu1");
		$lembur = $this->input->post("lembur");
		$noind = $this->input->post("noind");
		$tanggal = $this->input->post("tanggal");
		$tanggal = date_format(date_create($tanggal), 'Y-m-d');

		$tim = $this->M_splseksi->getTim($noind, $tanggal);
		if (!empty($tim->point) && count($tim->point) > 0) {
			foreach ($tim as $tm) {
				if ($tm['point'] == '1') {
					$error = "1";
					$errortext = "Jam Absen Tidak Lengkap. <a target='_blank' href='" . site_url('SPLSeksi/C_splseksi/create_memo?noind=' . $noind . '&tanggal=' . $tanggal) . "'>klik disini</a> untuk membuat memo";
				} else {
					$error = "1";
					$errortext = "Kirim SPL Manual ke Seksi Hubungan Kerja";
				}
			}
		} else {
			$presensi = $this->M_splseksi->getPresensi($noind, $tanggal);
			if (!empty($presensi) && count($presensi) > 0) {
				foreach ($presensi as $datapres) {
					$masuk_shift = date_format(date_create($datapres['jam_msk']), 'Y-m-d H:i:s');
					$keluar_shift = date_format(date_create($datapres['jam_plg']), 'Y-m-d H:i:s');
					$masuk_absen = date_format(date_create($datapres['masuk']), 'Y-m-d H:i:s');
					$keluar_absen = date_format(date_create($datapres['keluar']), 'Y-m-d H:i:s');
					$awal_lembur = date_format(date_create($tanggal), "Y-m-d") . " " . $waktu0;
					$awal_lembur = date_format(date_create($awal_lembur), 'Y-m-d H:i:s');
					$akhir_lembur = date_format(date_create($tanggal), "Y-m-d") . " " . $waktu1;
					$akhir_lembur = date_format(date_create($akhir_lembur), 'Y-m-d H:i:s');
					$mulai_ist = date_format(date_create($datapres['ist_mulai']), 'Y-m-d H:i:s');
					$selesai_ist = date_format(date_create($datapres['ist_selesai']), 'Y-m-d H:i:s');

					if ($lembur == '001') { // lembur istirahat
						if ($mulai_ist <= $awal_lembur && $awal_lembur <= $selesai_ist) {
							$aktual_awal = $awal_lembur;
							if ($mulai_ist <= $akhir_lembur && $akhir_lembur <= $selesai_ist) {
								$aktual_akhir = $akhir_lembur;
							} elseif ($akhir_lembur > $selesai_ist) {
								$aktual_akhir = $selesai_ist;
							} else {
								$error = "1";
								$errortext = "Jam Akhir Lembur Tidak Sesuai";
							}
						} elseif ($awal_lembur < $mulai_ist) {
							$aktual_awal = $mulai_ist;
							if ($mulai_ist <= $akhir_lembur && $akhir_lembur <= $selesai_ist) {
								$aktual_akhir = $akhir_lembur;
							} elseif ($akhir_lembur > $selesai_ist) {
								$aktual_akhir = $selesai_ist;
							} else {
								$error = "1";
								$errortext = "Jam Akhir Lembur Tidak Sesuai";
							}
						} else {
							$error = "1";
							$errortext = "Jam Awal Lembur Tidak Sesuai";
						}
					} elseif ($lembur == '002') { // lembur pulang
						if ($keluar_shift <= $awal_lembur && $awal_lembur <= $keluar_absen) {
							$aktual_awal = $awal_lembur;
							if ($keluar_shift <= $akhir_lembur && $akhir_lembur <= $keluar_absen) {
								$aktual_akhir = $akhir_lembur;
							} elseif ($akhir_lembur > $keluar_absen) {
								$aktual_akhir = $keluar_absen;
							} else {
								$error = "1";
								$errortext = "Jam Akhir Lembur Tidak Sesuai";
							}
						} elseif ($awal_lembur < $keluar_shift) {
							$aktual_awal = $keluar_shift;
							if ($keluar_shift <= $akhir_lembur && $akhir_lembur <= $keluar_absen) {
								$aktual_akhir = $akhir_lembur;
							} elseif ($akhir_lembur > $keluar_absen) {
								$aktual_akhir = $keluar_absen;
							} else {
								$error = "1";
								$errortext = "Jam Akhir Lembur Tidak Sesuai";
							}
						} else {
							$error = "1";
							$errortext = "Jam Awal Lembur Tidak Sesuai";
						}
					} elseif ($lembur == '003') { //lembur datang
						if ($masuk_absen <= $awal_lembur && $awal_lembur <= $masuk_shift) {
							$aktual_awal = $awal_lembur;
							if ($masuk_absen <= $akhir_lembur && $akhir_lembur <= $masuk_shift) {
								$aktual_akhir = $akhir_lembur;
							} elseif ($akhir_lembur > $masuk_shift) {
								$aktual_akhir = $masuk_shift;
							} else {
								$error = "1";
								$errortext = "Jam Akhir Lembur Tidak Sesuai";
							}
						} elseif ($awal_lembur <= $masuk_absen) {
							$aktual_awal = $masuk_absen;
							if ($masuk_absen <= $akhir_lembur && $akhir_lembur <= $masuk_shift) {
								$aktual_akhir = $akhir_lembur;
							} elseif ($akhir_lembur > $masuk_shift) {
								$aktual_akhir = $masuk_shift;
							} else {
								$error = "1";
								$errortext = "Jam Akhir Lembur Tidak Sesuai";
							}
						} else {
							$error = "1";
							$errortext = "Jam Awal Lembur Tidak Sesuai";
						}
					} elseif ($lembur == '005') { // lembur datang dan pulang
						if ($masuk_absen <= $awal_lembur && $awal_lembur <= $masuk_shift) {
							$aktual_awal = $awal_lembur;
							if ($keluar_shift <= $akhir_lembur && $akhir_lembur <= $keluar_absen) {
								$aktual_akhir = $akhir_lembur;
							} elseif ($akhir_lembur > $keluar_absen) {
								$aktual_akhir = $keluar_absen;
							} else {
								$error = "1";
								$errortext = "Jam Akhir Lembur Tidak Sesuai";
							}
						} elseif ($awal_lembur <= $masuk_absen) {
							$aktual_awal = $masuk_absen;
							if ($keluar_shift <= $akhir_lembur && $akhir_lembur <= $keluar_absen) {
								$aktual_akhir = $akhir_lembur;
							} elseif ($akhir_lembur > $keluar_absen) {
								$aktual_akhir = $keluar_absen;
							} else {
								$error = "1";
								$errortext = "Jam Akhir Lembur Tidak Sesuai";
							}
						} else {
							$error = "1";
							$errortext = "Jam Awal Lembur Tidak Sesuai";
						}
					} else {
						$error = "1";
						$errortext = "Bukan Merupakan Hari Libur ";
					}
				}
			} else {
				if ($lembur == '004') {
					$awal_lembur = date_format(date_create($tanggal), "Y-m-d") . " " . $waktu0;
					$awal_lembur = date_format(date_create($awal_lembur), 'Y-m-d H:i:s');
					$akhir_lembur = date_format(date_create($tanggal), "Y-m-d") . " " . $waktu1;
					$akhir_lembur = date_format(date_create($akhir_lembur), 'Y-m-d H:i:s');
					$shiftpekerja = $this->M_splseksi->getShiftpekerja($noind, $tanggal);
					if ($shiftpekerja == 0) {
						$aktual_awal = $awal_lembur;
						$aktual_akhir = $akhir_lembur;
					} else {
						$error = "1";
						$errortext = "Lembur Tidak Valid";
					}
				} else {
					$error = "1";
					$errortext = "Tidak Bisa Input Lembur";
				}
			}
		}


		$presensi = array(
			'awal' 	=> date_format(date_create($aktual_awal), "H:i:s"),
			'akhir' => date_format(date_create($aktual_akhir), "H:i:s"),
			'error' => $error,
			'text'	=> $errortext,
			'masuk_shift' => $masuk_shift,
			'keluar_shift' => $keluar_shift,
			'masuk_absen' => $masuk_absen,
			'keluar_absen' => $keluar_absen,
			'awal_lembur' => $awal_lembur,
			'awal_lembur' => $awal_lembur,
			'akhir_lembur' => $akhir_lembur,
			'akhir_lembur' => $akhir_lembur,
			'mulai_ist' => $mulai_ist,
			'selesai_ist' => $selesai_ist
		);
		echo json_encode($presensi);
	}

	public function new_spl_submit()
	{
		$this->checkSession();
		$user_id = $this->session->user;
		$tanggal = $this->input->post('tanggal_simpan');
		$tanggal = date_format(date_create($tanggal), "Y-m-d");
		$mulai = $this->input->post('waktu_0_simpan');
		$mulai = date_format(date_create($mulai), "H:i:s");
		$selesai = $this->input->post('waktu_1_simpan');
		$selesai = date_format(date_create($selesai), "H:i:s");
		$lembur = $this->input->post('kd_lembur_simpan');
		$istirahat = $this->input->post('istirahat_simpan');
		$break = $this->input->post('break_simpan');
		$alasan = $this->input->post('pekerjaan_simpan');
		$size = sizeof($this->input->post('noind'));
		$sendmail_splid = "";

		if ($mulai == $selesai) {
			redirect(base_url('SPL/Pusat/InputLembur?result=3'));
			return false;
		}

		//checking pekerja yang ada spl di tanggal yg daiambil
		$is_notvalid = [];

		for ($x = 0; $x < $size; $x++) {
			$noind = $this->input->post("noind[$x]");

			$checkSPL = $this->M_splseksi->checkSPL($noind, $tanggal);
			if ($checkSPL) {
				$is_notvalid[] = $noind;
				continue;
			}

			$target = $this->input->post("target[$x]") . " " . $this->input->post("target_satuan[$x]");
			$realisasi = $this->input->post("realisasi[$x]") . " " . $this->input->post("realisasi_satuan[$x]");;
			$pekerjaan = $this->input->post("alasan[$x]");
			$mulai = $this->input->post("lembur_awal[$x]");
			$selesai = $this->input->post("lembur_akhir[$x]");
			$noind_baru = $this->M_splseksi->getNoindBaru($noind);

			// Generate ID SPL
			$maxid = $this->M_splseksi->show_maxid("splseksi.tspl", "ID_SPL");
			// if (empty($maxid)) {
			// 	$spl_id = "0000000001";
			// } else {
			// 	$spl_id = $maxid->id;
			// 	$spl_id = substr("0000000000", 0, 10 - strlen($spl_id)) . $spl_id;
			// }
			// if ($sendmail_splid == "") {
			// 	$sendmail_splid = "'$spl_id'";
			// } else {
			// 	$sendmail_splid .= ",'$spl_id'";
			// }
			// Generate ID Riwayat
			// $maxid = $this->M_splseksi->show_maxid("splseksi.tspl_riwayat", "ID_Riwayat");
			// if (empty($maxid)) {
			// 	$splr_id = "0000000001";
			// } else {
			// 	$splr_id = $maxid->id;
			// 	$splr_id = substr("0000000000", 0, 10 - strlen($splr_id)) . $splr_id;
			// }

			// Insert data
			$log_ket = "Noind:" . $noind . " Tgl:" . $tanggal . " Kd:" . $lembur . " Jam:" . $mulai . "-" . $selesai .
				" Break:" . $break . " Ist:" . $istirahat . " Pek:" . $pekerjaan . " Stat:01 <br />";

			$data_log = array(
				"wkt" => date('Y-m-d H:i:s'),
				"menu" => "Operator",
				"jenis" => "Tambah",
				"ket" => $log_ket,
				"noind" => $user_id
			);
			$to_log = $this->M_splseksi->save_log($data_log);

			$data_spl = array(
				// "ID_SPL" => $spl_id,
				"Tgl_Berlaku" => date('Y-m-d H:i:s'),
				"Tgl_Lembur" => $tanggal,
				"Noind" => $noind,
				"Noind_Baru" => $noind_baru,
				"Kd_Lembur" => $lembur,
				"Jam_Mulai_Lembur" => $mulai,
				"Jam_Akhir_Lembur" => $selesai,
				"Break" => $break,
				"Istirahat" => $istirahat,
				"Pekerjaan" => $pekerjaan,
				"Status" => "01",
				"User_" => $user_id,
				"target" => $target,
				"realisasi" => $realisasi,
				"alasan_lembur" => $alasan
			);
			$to_spl = $this->M_splseksi->save_spl($data_spl);
			if ($sendmail_splid == "") {
				$sendmail_splid = "'$to_spl'";
			} else {
				$sendmail_splid .= ",'$to_spl'";
			}

			$data_splr = array(
				// "ID_Riwayat" => $splr_id,
				"ID_SPL" => $to_spl,
				"Tgl_Berlaku" => date('Y-m-d H:i:s'),
				"Tgl_Tdk_Berlaku" => date('Y-m-d H:i:s'),
				"Tgl_Lembur" => $tanggal,
				"Noind" => $noind,
				"Noind_Baru" => $noind_baru,
				"Kd_Lembur" => $lembur,
				"Jam_Mulai_Lembur" => $mulai,
				"Jam_Akhir_Lembur" => $selesai,
				"Break" => $break,
				"Istirahat" => $istirahat,
				"Pekerjaan" => $pekerjaan,
				"Status" => "01",
				"User_" => $user_id,
				"Revisi" => "0",
				"Keterangan" => "(Tambah)",
				"target" => $target,
				"realisasi" => $realisasi,
				"alasan_lembur" => $alasan
			);
			$to_splr = $this->M_splseksi->save_splr($data_splr);
		}

		//mencegah agar spl tidak dapat diinput ketika pekerja memiliki spl dihari yg sama
		if (count($is_notvalid) > 0 && $size == count($is_notvalid)) {
			$exist = implode('_', $is_notvalid);
			redirect(base_url('SPL/Pusat/InputLembur?result=2&exist=' . $exist)); //tidak muncul notif sukses, tapi muncul danger noind
			return false;
		} else if (count($is_notvalid) > 0) {
			$exist = implode('_', $is_notvalid);
			redirect(base_url('SPL/Pusat/InputLembur?result=1&exist=' . $exist)); //muncul notif sukses, dan muncul danger noind
			$this->send_email($sendmail_splid);
			return false;
		}

		$this->send_email($sendmail_splid);

		redirect(base_url('SPL/Pusat/InputLembur?result=1'));
	}

	public function rekap_spl()
	{
		$this->checkSession();
		$wkt_validasi_operator = $this->session->spl_validasi_waktu_operator;
		if (time() - $wkt_validasi_operator > 120) {
			$this->session->spl_validasi_operator = FALSE;
			redirect(site_url('SPL'));
		}
		$this->session->spl_validasi_waktu_operator = time();
		$data = $this->menu('', '', '');
		$data['noind'] = $this->M_splseksi->show_noind();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('SPLSeksi/Seksi/V_rekap_spl', $data);
		$this->load->view('V_Footer', $data);
	}

	public function rekap_spl_filter()
	{
		$this->checkSession();
		$this->session->spl_validasi_waktu_operator = time();
		$user = $this->session->user;
		$dari = date("Y-m-d", strtotime($this->input->post('dari')));
		$sampai = date("Y-m-d", strtotime($this->input->post('sampai')));
		$noi = $this->input->post('noi');
		$noind = $this->input->post('noind');

		if ($noind == "") {
			$noind = $noi;
		}

		// get akses seksi
		$akses_sie = array();
		$akses_kue = $this->M_splseksi->show_pekerja('', $user, '');
		$akses_spl = $this->M_splseksi->show_akses_seksi($user);
		foreach ($akses_kue as $ak) {
			$akses_sie[] = $this->cut_kodesie(substr($ak['kodesie'], 0, 7) . '00');
			foreach ($akses_spl as $as) {
				$akses_sie[] = $this->cut_kodesie($as['kodesie']);
			}
		}

		$x = 1;
		$data_spl = array();
		$show_list_spl = $this->M_splseksi->show_rekap($dari, $sampai, $noind, $akses_sie);
		foreach ($show_list_spl as $sls) {
			$index = array();

			$index[] = $x;
			$index[] = $sls['tanggal'];
			$index[] = $sls['noind'];
			$index[] = $sls['nama'];
			$index[] = $sls['nama_lembur'];
			$index[] = $sls['jam_msk'];
			$index[] = $sls['jam_klr'];
			$index[] = $sls['total_lembur'];

			$x++;
			$data_spl[] = $index;
		}
		echo json_encode($data_spl);
	}

	public function send_email($spl_id)
	{
		$this->checkSession();
		$this->session->spl_validasi_waktu_operator = time();
		$akses_sie = array();
		$user = $this->session->user;
		$akses_kue = $this->M_splseksi->show_pekerja('', $user, '');
		$akses_spl = $this->M_splseksi->show_akses_seksi($user);
		foreach ($akses_kue as $ak) {
			$akses_sie[] = substr($this->cut_kodesie($ak['kodesie']), 0, 7);

			foreach ($akses_spl as $as) {
				$akses_sie[] = substr($this->cut_kodesie($as['kodesie']), 0, 7);
			}
		}

		$data[] = "email atasan ???";
		foreach ($akses_sie as $as) {
			$e_asska = $this->M_splseksi->show_email_addres($as);
			foreach ($e_asska as $ea) {
				$data[] = $ea['internal_mail'];
			}
		}

		$isiPesan = "<table style='border-collapse: collapse;width: 100%'>";
		$pesan = $this->M_splseksi->show_spl_byid($spl_id);
		$tgl_lembur = "";
		$pkj_lembur = "";
		$brk_lembur = "";
		$ist_lembur	= "";
		$jns_lembur = "";
		$no = 1;
		foreach ($pesan as $key) {
			if ($tgl_lembur !== $key['tgl_lembur'] or $pkj_lembur !== $key['Pekerjaan'] or $brk_lembur !== $key['Break'] or $ist_lembur !== $key['Istirahat'] or $jns_lembur !== $key['Kd_Lembur']) {
				$no = 1;
				$isiPesan .= "	<tr><td>&nbsp;</td></tr><tr><td>Tanggal</td>
								<td colspan='7'> : " . $key['tgl_lembur'] . "</td></tr>
								<tr><td>jenis</td><td colspan='7'> : " . $key['nama_lembur'] . "</td></tr>
								<tr><td>Istirahat</td><td colspan='7'> : " . $key['Istirahat'] . "</td></tr>
								<tr><td>Break</td><td colspan='7'> : " . $key['Break'] . "</td></tr>
								<tr><td>Pekerjaan</td><td colspan='7'> : " . $key['Pekerjaan'] . "</td></tr>
								<tr>
									<td style='border: 1px solid black'>No</td>
									<td style='border: 1px solid black'>Pekerja</td>
									<td style='border: 1px solid black'>Kodesie</td>
									<td style='border: 1px solid black'>Seksi</td>
									<td style='border: 1px solid black'>Unit</td>
									<td style='border: 1px solid black'>Waktu Lembur</td>
									<td style='border: 1px solid black'>Target</td>
									<td style='border: 1px solid black'>Realisasi</td>
									<td style='border: 1px solid black'>Alasan</td>
								</tr>";
			}
			$isiPesan .= "<tr>
			<td style='border: 1px solid black;text-align: center'>$no</td>
			<td style='border: 1px solid black'>" . $key['Noind'] . " " . $key['nama'] . "</td>
			<td style='border: 1px solid black;text-align: center'>" . $key['kodesie'] . "</td>
			<td style='border: 1px solid black'>" . $key['seksi'] . "</td>
			<td style='border: 1px solid black'>" . $key['unit'] . "</td>
			<td style='border: 1px solid black'>" . $key['jam_mulai_lembur'] . " - " . $key['Jam_Akhir_Lembur'] . "</td>
			<td style='border: 1px solid black;text-align: center'>" . $key['target'] . "</td>
			<td style='border: 1px solid black;text-align: center'>" . $key['realisasi'] . "</td>
			<td style='border: 1px solid black'>" . $key['alasan_lembur'] . "</td>
			</tr>";
			$no++;
			$tgl_lembur = $key['tgl_lembur'];
			$pkj_lembur = $key['Pekerjaan'];
			$brk_lembur = $key['Break'];
			$ist_lembur = $key['Istirahat'];
			$jns_lembur = $key['Kd_Lembur'];
		}
		$isiPesan .= "</table>";

		$email[] = array(
			"actn" => "offline",
			"host" => "m.quick.com",
			"port" => 465,
			"user" => "no-reply",
			"pass" => "123456",
			"from" => "no-reply@quick.com",
			"adrs" => ""
		);

		foreach ($email as $e) {
			$this->load->library('PHPMailerAutoload');
			$mail = new PHPMailer;
			//Tell PHPMailer to use SMTP
			$mail->isSMTP();
			//Enable SMTP debugging
			// 0 = off (for production use)
			// 1 = client messages
			// 2 = client and server messages
			$mail->SMTPDebug = 0;
			//Ask for HTML-friendly debug output
			$mail->Debugoutput = 'html';
			//Set the hostname of the mail server
			$mail->Host = $e['host'];
			//Set the SMTP port number - likely to be 25, 465 or 587
			$mail->Port = $e['port'];
			//Whether to use SMTP authentication
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl';
			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);
			//Username to use for SMTP authentication
			$mail->Username = $e['user'];
			//Password to use for SMTP authentication
			$mail->Password = $e['pass'];
			//Set who the message is to be sent from
			$mail->setFrom($e['from'], 'Email Sistem');
			//Set an alternative reply-to address
			// $mail->addReplyTo('it.sec3@quick.com', 'Khoerul Amri');
			//Set who the message is to be sent to
			$mail->addAddress($e['adrs'], 'Monitoring Transaction');
			foreach ($data as $d) {
				$mail->addAddress($d, 'Lembur (Approve Kasie)');
			}
			//Set the subject line
			$mail->Subject = 'Anda telah menerima permintaan approval spl';
			//convert HTML into a basic plain-text alternative body
			$mail->msgHTML("
			<h4>Lembur (Appove Kasie)</h4><hr>
			Kepada Yth Bapak/Ibu<br><br>

			Kami informasikan bahwa anda telah menerima permintaan<br>
			approval untuk keperluan lembur pekerja<br><br>
			$isiPesan
			<br>
			Anda dapat melakukan pengecekan di link berikut :<br>
			- http://erp.quick.com atau klik <a href='http://erp.quick.com'>disini</a><br><br>

			<small>Email ini digenerate melalui sistem erp.quick.com pada " . date('d-m-Y H:i:s') . ".<br>
			Apabila anda mengalami kendala dapat menghubungi Seksi ICT (12300)</small>");
			//send the message, check for errors
			if (!$mail->send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
				echo "Message sent!";
			}
		}
	}

	public function create_memo()
	{
		$this->checkSession();
		$wkt_validasi_operator = $this->session->spl_validasi_waktu_operator;
		$this->session->spl_validasi_waktu_operator = time();
		$noind = $this->input->get('noind');
		$tanggal = $this->input->get('tanggal');

		$data = $this->menu('', '', '');

		$data['data'] = $this->M_splseksi->getDataForMemo($noind, $tanggal);
		$data['alasan'] = $this->M_splseksi->getAlasanMemo();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('SPLSeksi/Seksi/V_create_memo', $data);
		$this->load->view('V_Footer', $data);
	}

	public function submit_memo()
	{
		$this->checkSession();

		$data = array(
			'noind' => $this->input->post('txtNoind'),
			'tgl' => $this->input->post('txtTanggal'),
			'shift' => $this->input->post('txtShift'),
			'masuk' => $this->input->post('txtMasuk'),
			'pulang' => $this->input->post('txtKeluar'),
			'atasan' => $this->input->post('txtAtasan'),
			'atasan_dua' => $this->input->post('txtAtasan2'),
			'saksi' => $this->input->post('txtSaksi')
		);

		$id = $this->M_splseksi->insertMemo($data);

		$alasan = $this->input->post('txtAlasan');
		$alasan_info = $this->input->post('txtAlasanInfo');
		$a = 0;
		foreach ($alasan as $als) {
			$info = "";
			if (isset($alasan_info[$als])) {
				$info = $alasan_info[$als];
			}
			$data_dua[$a] = array(
				'absen_manual_id' => $id,
				'alasan_id' => $als,
				'info' => $info
			);
			$id_dua = $this->M_splseksi->insertAlasanMemo($data_dua[$a]);

			$a++;
		}


		echo $id;
	}

	public function pdf_memo()
	{
		$this->checkSession();
		$id = $this->input->get('id');
		$data['alasan_memo'] = $this->M_splseksi->show_AlasanMemo($id);
		$data['alasan_master'] = $this->M_splseksi->getAlasanMemo();
		$data['memo'] = $this->M_splseksi->show_memo($id);
		$data['tpribadi'] = $this->M_splseksi->show_pekerjamemo($data['memo']->noind);
		$data['shift'] = $this->M_splseksi->show_shiftmemo($data['memo']->shift, $data['memo']->tgl);
		$data['atasan'] = $this->M_splseksi->show_atasan($data['memo']->atasan, $data['memo']->atasan_dua, $data['memo']->noind);

		// echo "<pre>";print_r($data['memo']);echo "</pre><br>";echo "<pre>";print_r($data['alasan_memo']);echo "</pre><br>";exit();

		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('', 'A5', 0, '', 0, 0, 0, 0, 0, 0);
		$filename = 'Memo Prensensi ' . time() . '.pdf';

		$html = $this->load->view('SPLSeksi/Seksi/V_pdf_memo', $data, true);

		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->WriteHTML($stylesheet1, 1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');

		// $this->load->view('SPLSeksi/Seksi/V_pdf_memo', $data);
	}

	public function export_excel()
	{
		$this->load->library(array('Excel', 'Excel/PHPExcel/IOFactory'));
		$dari = $this->input->get('dari');
		$dari = date_format(date_create($dari), "Y-m-d");

		$sampai = $this->input->get('sampai');
		$sampai = date_format(date_create($sampai), "Y-m-d");

		$status = $this->input->get('status');
		$noind = $this->input->get('noind');
		$lokasi = $this->input->get('lokasi');
		$user = $this->session->user;

		$akses_sie = array();
		$akses_kue = $this->M_splseksi->show_pekerja('', $user, '');
		$akses_spl = $this->M_splseksi->show_akses_seksi($user);
		foreach ($akses_kue as $ak) {
			$akses_sie[] = $this->cut_kodesie(substr($ak['kodesie'], 0, 7) . '00');
			foreach ($akses_spl as $as) {
				$akses_sie[] = $this->cut_kodesie($as['kodesie']);
			}
		}

		$data_spl = array();
		$show_list_spl = $this->M_splseksi->show_spl($dari, $sampai, $status, $lokasi, $noind, $akses_sie);

		$arrSeksi = array_values(array_unique(array_column($show_list_spl, 'seksi')));
		$arrHead = array('No', 'Status', 'Tgl Lembur', 'Noind', 'Nama', 'Pekerjaan', 'Jenis Lembur', 'Mulai', 'Selesai', 'Break', 'Istirahat', 'Estimasi', 'Target/Pcs/%', 'Realisasi/Pcs/%', 'Alasan Lembur', 'Tanggal Proses');
		// echo "<pre>";
		// print_r($arrSeksi);
		// exit();

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator('KHS ERP')
			->setTitle("Rekap Lembur")
			->setSubject("Rekap Lembur")
			->setDescription("Rekap Lembur")
			->setKeywords("Rekap Lembur");

		$style_col = array(
			'font' => array('bold' => true),
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
				// 'color' => array('rgb' => 'bababa')
			)
		);
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
			)
		);

		$a = 1;
		for ($i = 0; $i < count($arrSeksi); $i++) {
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $a . ':B' . $a);
			$objPHPExcel->getActiveSheet()->getStyle('A' . $a)->getFont()->setBold(true);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $a, $arrSeksi[$i]);

			$a++;
			$b = 0;
			foreach ($arrHead as $ah) {
				$kolom = PHPExcel_Cell::stringFromColumnIndex($b);
				$objPHPExcel->getActiveSheet()->getStyle($kolom . $a)->applyFromArray($style_col);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $a, $ah);
				$objPHPExcel->getActiveSheet()->getColumnDimension($kolom)->setAutoSize(true);
				$b++;
			}

			$a++;
			$no = 1;
			foreach ($show_list_spl as $key) {
				if ($arrSeksi[$i] != $key['seksi']) continue;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $a, $no);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $a, $key['Deskripsi'] . ' ' . $key['Noind'] . ' (' . $key['nama'] . ')');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $a, $key['Tgl_Lembur']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $a, $key['Noind']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $a, $key['nama']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $a, $key['Pekerjaan']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $a, $key['nama_lembur']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $a, $key['Jam_Mulai_Lembur']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $a, $key['Jam_Akhir_Lembur']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $a, $key['Break']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $a, $key['Istirahat']);
				$est = $this->hitung_jam_lembur($key['Noind'], $key['Kd_Lembur'], $key['Tgl_Lembur'], $key['Jam_Mulai_Lembur'], $key['Jam_Akhir_Lembur'], $key['Break'], $key['Istirahat']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $a, $est);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $a, $key['target']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $a, $key['realisasi']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $a, $key['alasan_lembur']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $a, $key['Tgl_Berlaku']);

				//style
				$objPHPExcel->getActiveSheet()->getStyle('A' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('B' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('C' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('D' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('E' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('F' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('G' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('H' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('I' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('J' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('K' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('L' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('M' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('N' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('O' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('P' . $a)->applyFromArray($style_row);
				$a++;
				$no++;
			}
			$a++;
		}

		$objPHPExcel->setActiveSheetIndex(0);
		$filename = urlencode("List_Lembur_" . $dari . '-' . $sampai . ".ods");

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}

	public function export_rekap_excel()
	{
		$this->load->library(array('Excel', 'Excel/PHPExcel/IOFactory'));
		$dari = $this->input->get('dari');
		$dari = date_format(date_create($dari), "Y-m-d");

		$sampai = $this->input->get('sampai');
		$sampai = date_format(date_create($sampai), "Y-m-d");

		$status = $this->input->get('status');
		$noind = $this->input->get('noind');
		$noi = $this->input->get('noi');
		$lokasi = $this->input->get('lokasi');
		$user = $this->session->user;
		if ($noind == "") {
			$noind = $noi;
		}

		// get akses seksi
		$akses_sie = array();
		$akses_kue = $this->M_splseksi->show_pekerja('', $user, '');
		$akses_spl = $this->M_splseksi->show_akses_seksi($user);
		foreach ($akses_kue as $ak) {
			$akses_sie[] = $this->cut_kodesie(substr($ak['kodesie'], 0, 7) . '00');
			foreach ($akses_spl as $as) {
				$akses_sie[] = $this->cut_kodesie($as['kodesie']);
			}
		}

		$x = 1;
		$data_spl = array();
		$show_list_spl = $this->M_splseksi->show_rekap($dari, $sampai, $noind, $akses_sie);
		// echo "<pre>";
		// print_r($show_list_spl);

		$arrSeksi = array_values(array_unique(array_column($show_list_spl, 'seksi')));
		$arrHead = array('No', 'Tanggal', 'Noind', 'Nama', 'Jenis Lembur', 'Mulai', 'Selesai', 'Total');
		// echo "<pre>";
		// print_r($arrSeksi);
		// exit();

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator('KHS ERP')
			->setTitle("Rekap Lembur")
			->setSubject("Rekap Lembur")
			->setDescription("Rekap Lembur")
			->setKeywords("Rekap Lembur");

		$style_col = array(
			'font' => array('bold' => true),
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
				// 'color' => array('rgb' => 'bababa')
			)
		);
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
			)
		);

		$a = 1;
		for ($i = 0; $i < count($arrSeksi); $i++) {
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $a . ':D' . $a);
			$objPHPExcel->getActiveSheet()->getStyle('A' . $a)->getFont()->setBold(true);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $a, $arrSeksi[$i]);

			$a++;
			$b = 0;
			foreach ($arrHead as $ah) {
				$kolom = PHPExcel_Cell::stringFromColumnIndex($b);
				$objPHPExcel->getActiveSheet()->getStyle($kolom . $a)->applyFromArray($style_col);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom . $a, $ah);
				$objPHPExcel->getActiveSheet()->getColumnDimension($kolom)->setAutoSize(true);
				$b++;
			}

			$a++;
			$no = 1;
			foreach ($show_list_spl as $key) {
				if ($arrSeksi[$i] != $key['seksi']) continue;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $a, $no);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $a, $key['tanggal']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $a, $key['noind']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $a, $key['nama']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $a, $key['nama_lembur']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $a, $key['jam_msk']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $a, $key['jam_klr']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $a, $key['total_lembur']);

				//style
				$objPHPExcel->getActiveSheet()->getStyle('A' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('B' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('C' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('D' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('E' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('F' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('G' . $a)->applyFromArray($style_row);
				$objPHPExcel->getActiveSheet()->getStyle('H' . $a)->applyFromArray($style_row);

				$a++;
				$no++;
			}
			$a++;
		}

		$objPHPExcel->setActiveSheetIndex(0);
		$filename = urlencode("Rekap_Lembur_" . $dari . '-' . $sampai . ".ods");

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
}
