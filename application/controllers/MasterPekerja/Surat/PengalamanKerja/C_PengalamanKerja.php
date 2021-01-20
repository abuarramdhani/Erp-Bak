<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');
set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_PengalamanKerja extends CI_Controller
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
		$this->load->model('MasterPekerja/Surat/PengalamanKerja/M_pengalamankerja');
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if (!($this->session->is_logged)) {
			redirect('');
		}
	}

	public function index()
	{
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Surat Pengalaman Kerja';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Pengalaman Kerja';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['data'] = $this->M_pengalamankerja->getSuratPengalamanKerjaAll();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPekerja/Surat/PengalamanKerja/V_index', $data);
		$this->load->view('V_Footer', $data);
	}

	public function Tambah()
	{
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Surat Pengalaman Kerja';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Pengalaman Kerja';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		$data['isisuratpengalaman'] = $this->M_pengalamankerja->isiSuratPengalaman();
		$data['nomor'] = $this->M_pengalamankerja->nomorSuratPengalaman();
		// $data['data']	=	$this->M_pengalamankerja->detailPekerja($noind);
		// kalau pakai ini nggak bisa ji tadi aku coba error
		// awalnya $data ini
		// berarti di view diilangi aja, nanti ngisi nya pas ganti noind
		// echo "<pre>";
		// print_r($data['nomor']);
		// echo "</pre>";
		// exit();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPekerja/Surat/PengalamanKerja/V_tambah', $data);
		$this->load->view('V_Footer', $data);
	}

	public function Pekerja()
	{
		$key = $this->input->get('term');
		$data = $this->M_pengalamankerja->getPekerjaByKey($key);
		echo json_encode($data);
	}

	public function DetailisiSuratPengalaman()
	{
		//aji aku masih belum tahu dapat kd_isi nya TxtIsiSuratPengalaman
		$kd =	$this->input->post('kd'); // ini ngambil dari ajax data 
		$data = $this->M_pengalamankerja->DetailisiSuratPengalaman($kd); // ini isisuratpengalaman
		echo json_encode($data);
	}

	public function TemplateisiSuratPengalaman()
	{
		//aji aku masih belum tahu dapat kd_isi nya TxtIsiSuratPengalaman
		$kd =	$this->input->post('kd'); // ini ngambil dari ajax data 
		$data = $this->M_pengalamankerja->DetailisiSuratPengalaman($kd); // ini isisuratpengalaman
		echo json_encode($data);
	}

	public function add_template()
	{
		$kd_isi = $this->input->post('kd_isi');
		$isi_surat = $this->input->post('isi_surat');

		// do insert
		$data = array(
			'kd_isi' => $kd_isi,
			'isi_surat' => $isi_surat
		);
		$this->M_pengalamankerja->add_template($data);
	}

	public function edit_template()
	{

		$kd_isi = $this->input->post('kd_isi');
		$isi_surat = $this->input->post('isi_surat');

		$this->M_pengalamankerja->edit_template($kd_isi, $isi_surat);
	}

	public function delete_template()
	{
		// template nya itu pakai nama atau pakai id ?
		$kd_isi = $this->input->post('kd_isi');
		$this->M_pengalamankerja->delete_template($kd_isi);
	}

	public function detailPekerja()
	{ //-> $noind ini masih dipakai ? kalo tidak, bisa dihapus, kalau masih, bisa diganti $noind=false maksude piye ji?
		$noind 				=	$this->input->post('noind');
		$data 		=	$this->M_pengalamankerja->detailPekerja($noind);
		echo json_encode($data);
	}

	public function Simpan()
	{

		$cetak = false;
		$tgl_cetak = "1900-01-01";

		$data_insert = array(
			'kd_surat' 	=> $this->input->post('txtMPSuratPengalamanKerjaKodeSurat'),
			'no_surat' 	=> $this->input->post('txtMPSuratPengalamanKerjaNoSurat'),
			'tgl_masuk'	=> $this->input->post('txtMPSuratPengalamanKerjaMasuk'),
			'tgl_kena' 	=> $this->input->post('txtMPSuratPengalamanKerjaSampai'),
			'noind' 		=> $this->input->post('slcMPSuratPengalamanKerjaPekerja'),
			'kodesie' 	=> $this->input->post('txtMPSuratPengalamanKerjaKodesie'),
			'isi_surat'	=> $this->input->post('txaPreview'),
			'cetak' 		=> $cetak,
			'tgl_cetak' => $tgl_cetak,
			'tgl_surat' => $this->input->post('txtMPSuratPengalamanKerjaTanggalSurat'),
			'alamat' 		=> $this->input->post('txtMPSuratPengalamanKerjaAlamat')
		);

		$this->M_pengalamankerja->insertSuratPengalamanKerja($data_insert);

		redirect(base_url('MasterPekerja/Surat/PengalamanKerja'));
	}

	/**
	 * 2020/07065 => ini nanti terbelah jadi dua karena ada /
	 * jadinya seperti dibawah ini
	 * 2020 => parameter 1
	 * 07065 => parameter 2
	 * supaya tidak terpisah maka / di replace - 
	 * nanti akan menjadi seperti ini 2020-07065
	 * terus untuk memisahkan bulan dan nomor surat, dikasih _
	 * nanti hasilnya akan seperti ini 2020-07_065
	 * untuk membuat seperti ini 2020-07_065 , dibuat di view nya
	 */
	public function Hapus($data)
	{
		// echo $data;
		// untuk mendaatkan bulantahun dan nomor seara terpisah gunakan explode
		$data12 = explode("_", $data);
		// $data12 ini isinya = ["2020-07","065"]
		// ambil array pertama 
		$data1 = $data12[0]; //2020-07
		// ini dikembalikan seperti sedia kala
		$data1 = str_replace("-", "/", $data1);
		// ambil array kedua
		$data2 = $data12[1]; //065

		// sudah jadi, jangan lupa di where pake trim, karena tadi di trim.

		$this->M_pengalamankerja->deleteSuratPengalamanKerja($data1, $data2);

		redirect(base_url('MasterPekerja/Surat/PengalamanKerja'));
	}

	public function Ubah($datane)
	{
		$data12 = explode("_", $datane);
		$data1 = $data12[0];
		$data1 = str_replace("-", "/", $data1);
		$data2 = $data12[1];

		$data['data'] = $this->M_pengalamankerja->getSuratPengalamanKerja($data1, $data2);
		$data['isisuratpengalaman'] = $this->M_pengalamankerja->isiSuratPengalaman();


		$data['datane'] = $datane;

		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Surat Pengalaman Kerja';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Pengalaman Kerja';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPekerja/Surat/PengalamanKerja/V_edit', $data);
		$this->load->view('V_Footer', $data);
	}

	public function Update($datane)
	{
		$data12 = explode("_", $datane);
		$data1 = $data12[0];
		$data1 = str_replace("-", "/", $data1);
		$data2 = $data12[1];

		$data_update = array(
			'kd_surat' 	=> $this->input->post('txtMPSuratPengalamanKerjaKodeSurat'),
			'no_surat' 	=> $this->input->post('txtMPSuratPengalamanKerjaNoSurat'),
			'tgl_masuk'	=> $this->input->post('txtMPSuratPengalamanKerjaMasuk'),
			'tgl_kena' 	=> $this->input->post('txtMPSuratPengalamanKerjaSampai'),
			'noind' 		=> $this->input->post('slcMPSuratPengalamanKerjaPekerja'),
			'kodesie' 	=> $this->input->post('txtMPSuratPengalamanKerjaKodesie'),
			'isi_surat' => $this->input->post('txaPreview'),
			'cetak' 		=> $this->input->post('txtMPSuratPengalamanKerjaCetak'),
			'tgl_cetak' => $this->input->post('txtMPSuratPengalamanKerjaTglCetak'),
			'tgl_surat' => $this->input->post('txtMPSuratPengalamanKerjaTanggalSurat'),
			'alamat' 		=> $this->input->post('txtMPSuratPengalamanKerjaAlamat')
		);

		$this->M_pengalamankerja->updateSuratPengalamanKerja($data_update, $data1, $data2);

		redirect(base_url('MasterPekerja/Surat/PengalamanKerja'));
	}

	/**
	 * Helper
	 * 
	 * convert date to indonesian date 
	 * @param  String $dateString
	 * @return String $dateStringIndonesian e.g: 12 Desember 2020
	 */
	private function _indonesianDate($dateString)
	{
		$year = date('Y', strtotime($dateString));
		$month = date('m', strtotime($dateString));
		$day = date('d', strtotime($dateString));

		$listOfMonthInIndonesian = "Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember";
		$listOfMonthInIndonesian = explode(' ', $listOfMonthInIndonesian);

		$monthName = $listOfMonthInIndonesian[intval($month) - 1];

		return "$day $monthName $year";
	}

	public function PDF()
	{
		set_time_limit(0);

		$jabatan_pengalaman = $this->input->post('jabatan_pengalaman');
		$status_jabatan = $this->input->post('status_jabatan');
		$datane = $this->input->post('link_pengalaman');
		$nik_pengalaman = $this->input->post('nik_pengalaman');
		$noind_pengalaman = $this->input->post('noind_pengalaman');
		$sampai_pengalaman = $this->input->post('sampai_pengalaman');
		$tanggal_masukkerja = $this->input->post('tgl_masuk');
		$checkbox_masukkerja = $this->input->post('cekTglMasuk');
		$pengalaman_tglCetak = $this->input->post('pengalaman_tglCetak');
		$checkboxNIK = $this->input->post('cekNIK');
		$approver = $this->input->post('approver'); // noind

		$link_pengalaman_explode = explode("_", $datane);

		$kd_surat = str_replace("-", "/", $link_pengalaman_explode[0]);
		$no_surat = $link_pengalaman_explode[1];

		// get pengalaman kerja from table 
		$data = $this->M_pengalamankerja->getSuratPengalamanKerja($kd_surat, $no_surat);
		if (!$data) return show_404();

		// get approver detail, name and jabatan
		$data['approver'] = $this->M_pengalamankerja->detailPekerja($approver)[0];

		$data['tgl_masuk'] = $data['masuk'] ? $data['masuk'] : $this->_indonesianDate($data['masukkerja']);

		// update to cetak with now date
		$data['update'] = $this->M_pengalamankerja->updateSuratPengalamanKerjaBy($kd_surat, $no_surat, $pengalaman_tglCetak);

		// insert log data
		$menu = 'SURAT - SURAT -> SURAT PENGALAMAN';
		$ket = 'NO.INDUK -> ';
		$jenis = 'CETAK -> SURAT PENGALAMAN KERJA';
		$program = 'PEKERJA';
		$noindbaru = 'NULL';

		$data_insert = array(
			'wkt' => 'now()',
			'menu' => $menu,
			'ket' => $ket . $noind_pengalaman,
			'noind' => $noind_pengalaman,
			'jenis' => $jenis,
			'program' => $program,
			'noind_baru' => $noindbaru
		);

		$this->M_pengalamankerja->insertLogCetak($data_insert);
		// end of insert 


		$sampai = ($sampai_pengalaman == '1900-01-01' || $sampai_pengalaman === NULL)
			? 'Tanggal dibuatnya surat keterangan ini dan masih bekerja'
			: $this->_indonesianDate($sampai_pengalaman);

		$waktucetak = $this->_indonesianDate($pengalaman_tglCetak);
		// custom
		$tanggal_masukkerja = $this->_indonesianDate($tanggal_masukkerja);


		// comment by dk 30 dec 2020
		// hope your day is good :)
		// like woody stand alone above the wood
		// don't forget to get a food
		// or you will be odd
		// and let's pray to the god
		// 
		// $noind = substr($noind_pengalaman, 0, 1);
		// $noind_c = substr($noind_pengalaman, 2, 1);
		// // Find golongan kerja
		// $stat = '';
		// if ($noind == 'H') {
		// 	$stat = 'Pekerja Kontrak Non Staff';
		// } elseif ($noind == 'A') {
		// 	$stat = 'Pekerja Tetap Non Staff';
		// } elseif ($noind == 'B') {
		// 	$stat = 'Pekerja Tetap Staff';
		// } elseif ($noind == 'J') {
		// 	$stat = 'Pekerja Kontrak Staff';
		// } elseif ($noind == 'D') {
		// 	$stat = 'Trainee Staff';
		// } elseif ($noind == 'E') {
		// 	$stat = 'Trainee Non Staff';
		// } elseif ($noind == 'G') {
		// 	$stat = 'Tenaga Kerja Paruh Waktu (TKPW)';
		// } elseif ($noind == 'T') {
		// 	$stat = 'Pekerja Kontrak Non Staff';
		// } elseif ($noind  == 'C') {
		// 	if ($noind_c == '1') {
		// 		$stat = 'Pekerja Tetap Cabang';
		// 	} elseif ($noind_c == '2') {
		// 		$stat = 'Pekerja Kontrak Cabang';
		// 	} elseif ($noind_c == '3') {
		// 		$stat = 'Pekerja Outsourcing Cabang';
		// 	} elseif ($noind_c == '4') {
		// 		$stat = 'Pekerja Harian Lepas Cabang';
		// 	}
		// }

		$data['data'] = $data;
		$data['pengalaman_tglCetak'] = $waktucetak;
		$data['nik_pengalaman'] = $nik_pengalaman;
		$data['checkbox_nik'] = $checkboxNIK;
		$data['tgl_masuk'] = $tanggal_masukkerja;
		$data['checkbox_tgl_masuk'] = $checkbox_masukkerja;
		$data['sampai_pengalaman'] = $sampai_pengalaman;
		$data['stat'] = $status_jabatan;
		$data['sampai'] = $sampai;
		$data['jabatan_pengalaman'] = $jabatan_pengalaman;

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4', 10, "verdana", 20, 20, 50, 20, 20, 5, ['default_font' => 'verdana']);
		$html = $this->load->view('MasterPekerja/Surat/PengalamanKerja/V_cetak', $data, true);
		$filename = 'Surat Pengalaman Kerja' . $datane . '.pdf';
		$pdf->WriteHTML($html);
		$pdf->Output($filename, 'I');
	}

	public function ModalPDF($datane)
	{
		$data12 = explode("_", $datane);
		$data1 = $data12[0];
		$data1 = str_replace("-", "/", $data1);
		$data2 = $data12[1];

		$data['data'] = $this->M_pengalamankerja->getSuratPengalamanKerja($data1, $data2);

		// Find golongan kerja
		$noind = $data['data']['noind'];

		$noind_c = substr($noind, 2, 1);
		$noind = substr($noind, 0, 1);

		$stat = '';
		if ($noind == 'H') {
			$stat = 'Pekerja Kontrak Non Staff';
		} elseif ($noind == 'A') {
			$stat = 'Pekerja Tetap Non Staff';
		} elseif ($noind == 'B') {
			$stat = 'Pekerja Tetap Staff';
		} elseif ($noind == 'J') {
			$stat = 'Pekerja Kontrak Staff';
		} elseif ($noind == 'D') {
			$stat = 'Trainee Staff';
		} elseif ($noind == 'E') {
			$stat = 'Trainee Non Staff';
		} elseif ($noind == 'G') {
			$stat = 'Tenaga Kerja Paruh Waktu (TKPW)';
		} elseif ($noind == 'T') {
			$stat = 'Pekerja Kontrak Non Staff';
		} elseif ($noind  == 'C') {
			if ($noind_c == '1') {
				$stat = 'Pekerja Tetap Cabang';
			} elseif ($noind_c == '2') {
				$stat = 'Pekerja Kontrak Cabang';
			} elseif ($noind_c == '3') {
				$stat = 'Pekerja Outsourcing Cabang';
			} elseif ($noind_c == '4') {
				$stat = 'Pekerja Harian Lepas Cabang';
			}
		}

		$data['data']['status_jabatan'] = $stat;
		echo json_encode($data);
	}

	public function insertLogCetak()
	{
		$menu = 'SURAT - SURAT -> SURAT PENGALAMAN';
		$ket = 'NO.INDUK -> ';
		$noind = $this->input->post('noindlog');
		$jenis = 'CETAK -> SURAT PENGALAMAN KERJA';
		$program = 'PEKERJA';
		$noindbaru = 'NULL';

		$data_insert = array(
			'wkt' => 'now()',
			'menu' => $menu,
			'ket' => $ket . $this->input->post('noindlog'),
			'noind' => $noind,
			'jenis' => $jenis,
			'program' => $program,
			'noind_baru' => $noindbaru
		);

		$this->M_pengalamankerja->insertLogCetak($data_insert);
	}
}
