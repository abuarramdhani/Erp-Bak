<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Index extends CI_Controller
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
		$this->load->library('upload');
		$this->load->library('General');
		$this->load->library('Personalia');


		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/Surat/M_surat');

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

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Surat Mutasi';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Mutasi';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['DaftarSuratMutasi'] 	=	$this->M_surat->ambilDaftarSuratMutasi();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPekerja/Surat/Mutasi/V_Index', $data);
		$this->load->view('V_Footer', $data);
	}

	public function create()
	{
		/*$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Surat Mutasi';
		$data['Menu'] 			= 	'Surat-Surat';
		$data['SubMenuOne'] 	= 	'Surat Mutasi';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

      	// $data['DaftarPekerja']	=	$this->M_surat->getAmbilPekerjaAktif();
      	// $data['DaftarSeksi']    =   $this->M_surat->getSeksi();
      	// $data['DaftarPekerjaan'] = $this->M_surat->DetailPekerjaan();
		$data['DaftarGolongan'] = $this->M_surat->DetailGolongan();
      	$data['DaftarLokasiKerja'] = $this->M_surat->DetailLokasiKerja();
      	$data['DaftarKdJabatan'] = $this->M_surat->DetailKdJabatan();
      	$data['DaftarTempatMakan1'] = $this->M_surat->DetailTempatMakan1();
      	$data['DaftarTempatMakan2'] = $this->M_surat->DetailTempatMakan2();
		// echo "<pre>";
		// print_r($data['DaftarKdJabatan']);
		// echo "</pre>";
		// exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Mutasi/V_Create',$data);
		$this->load->view('V_Footer',$data);*/

		$data 	=	$this->general->loadHeaderandSidemenu('Surat Mutasi - Master Pekerja- Quick ERP', 'Surat Mutasi', 'Surat', 'Surat Mutasi');

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPekerja/Surat/Mutasi/V_Create', $data);
		$this->load->view('V_Footer', $data);
	}

	public function detailPekerja()
	{
		$noind 						=	$this->input->post('noind');
		$detailPekerja 				=	$this->M_surat->detailPekerja($noind);
		$data['seksi'] 				= 	$detailPekerja[0]['nama_seksi'];
		$data['pekerjaan']			=	$detailPekerja[0]['pekerjaan'];
		$data['lokasiKerja']		=	$detailPekerja[0]['lokasi_kerja'];
		$data['golonganPekerjaan']	=	$detailPekerja[0]['golongan_pekerjaan'];
		$data['jabatan']			=	$detailPekerja[0]['jabatan'];
		$data['kd_jabatan']			=	$detailPekerja[0]['kd_jabatan'];
		$data['tempat_makan1']		=	$detailPekerja[0]['tempat_makan1'];
		$data['tempat_makan2']		=	$detailPekerja[0]['tempat_makan2'];
		$data['status_staf'] 		=	$detailPekerja[0]['status_staf'];
	}

	/*public function selectKodesie()
	{
		$noind = $this->input->post('noind');
		$detailPekerja 			= $this->M_surat->getDetailPekerja($noind);
		$data['seksi'] 				= 	$detailPekerja[0]['nama_seksi'];
		$data['pekerjaan']			=	$detailPekerja[0]['pekerjaan'];
		$data['lokasiKerja']		=	$detailPekerja[0]['lokasi_kerja'];
		$data['golonganPekerjaan']	=	$detailPekerja[0]['golongan_pekerjaan'];
		$data['jabatan']			=	$detailPekerja[0]['jabatan'];
		$data['kd_jabatan']			=	$detailPekerja[0]['kd_jabatan'];
		$data['tempat_makan1']		=	$detailPekerja[0]['tempat_makan1'];
		$data['tempat_makan2']		=	$detailPekerja[0]['tempat_makan2'];
		$data['status_staf'] 		=	$detailPekerja[0]['status_staf'];


		echo json_encode($data);
	}*/

	public function DaftarPekerja()
	{
		$keywordPencarianPekerja 	=	strtoupper($this->input->get('term'));

		$daftarPekerja 				=	$this->M_surat->cariPekerja($keywordPencarianPekerja);
		echo json_encode($daftarPekerja);
	}

	public function DaftarSeksi()
	{
		$keywordPencarianSeksi	=	strtoupper($this->input->get('term'));

		$daftarseksi 			=	$this->M_surat->cariseksi($keywordPencarianSeksi);
		echo json_encode($daftarseksi);
	}

	public function DaftarPekerjaan()
	{
		$keywordPencarianPekerjaan	=	strtoupper($this->input->get('term'));
		$kodeSeksi 					=	$this->input->get('kode_seksi');

		$daftarPekerjaan 			=	$this->M_surat->cariPekerjaan($keywordPencarianPekerjaan, $kodeSeksi);
		echo json_encode($daftarPekerjaan);
	}

	public function cariGolonganPekerjaan()
	{
		$keywordPencarianGolKerja 	=	strtoupper($this->input->get('term'));
		$kodeStatusKerja 			=	$this->input->get('kode_status_kerja');

		$golonganPekerjaan 			=	$this->M_surat->cariGolonganPekerjaan($keywordPencarianGolKerja, $kodeStatusKerja);
		echo json_encode($golonganPekerjaan);
	}

	public function prosesPreviewMutasi()
	{
		$nomor_induk 				=	$this->input->post('txtNoind');
		$seksi_lama 				=	substr($this->input->post('txtKodesieLama'), 0, 9);
		$golongan_pekerjaan_lama 	=	$this->input->post('txtGolonganPekerjaanLama');
		$pekerjaan_lama 		 	=	$this->input->post('txtPekerjaanLama');
		$kd_jabatan_lama 			=	$this->input->post('txtKdJabatanLama');
		$jabatan_lama 				=	$this->input->post('txtJabatanLama');
		$lokasi_kerja_lama 			=	$this->input->post('txtLokasiKerja');
		$tempat_makan1_lama 		=	$this->input->post('txtTempatMakan1');
		$tempat_makan2_lama 		= 	$this->input->post('txtTempatMakan2');

		$seksi_baru 				=	$this->input->post('txtKodesieBaru');
		$golongan_pekerjaan_baru	=	$this->input->post('txtGolonganPekerjaanBaru');
		$pekerjaan_baru 			=	$this->input->post('txtPekerjaanBaru');
		$kd_jabatan_baru 			=	$this->input->post('txtKdJabatanBaru');
		$jabatan_baru 				=	$this->input->post('txtJabatanBaru');
		$lokasi_kerja_baru          =   $this->input->post('txtLokasiKerjaBaru');
		// $tempat_makan1_baru         =   $this->input->post('txtTempatMakan1Baru');
		// $tempat_makan2_baru         =   $this->input->post('txtTempatMakan2Baru');

		$tanggal_berlaku 			=	$this->input->post('txtTanggalBerlaku');
		$tanggal_cetak 				=	$this->input->post('txtTanggalCetak');
		$nomor_surat 				=	$this->input->post('txtNomorSurat');
		$kode_surat 				=	$this->input->post('txtKodeSurat');
		$hal_surat 					=	$this->input->post('txtHalSurat');
		$staf					 	=   $this->input->post('txtStatusStaf');


		$parameterTahunBulanMutasi 	=	date('Y-m', strtotime($tanggal_cetak));


		$lokasi_kerja_lama 			=	explode(' - ', $lokasi_kerja_lama);
		$lokasi_lama 				=	$lokasi_kerja_lama[1];
		$kd_lokasi_lama 			=	$lokasi_kerja_lama[0];

		$lokasi_kerja_baru 			=	explode(' - ', $lokasi_kerja_baru);
		$lokasi_baru				=	$lokasi_kerja_baru[1];
		$kd_lokasi_baru 			=	$lokasi_kerja_lama[0];

		$nama_pekerjaan_lama 		=	'';
		$nama_pekerjaan_baru 		=	'';

		$cekStaf 					=	$this->M_surat->cekStaf($nomor_induk);
		if (empty($kode_surat)) {
			if ($cekStaf[0]['status'] == 'STAF') {
				$kode_surat 				=	'DU/KI-B';
			} else {
				$kode_surat 				=	'PS/KI-M';
			}
		} else {
			$kode_surat 	=	$kode_surat;
		}

		$templateMutasi 			=	$this->M_surat->ambilLayoutSuratMutasi();
		$tseksiBaru 				=	$this->M_surat->cariTSeksi($seksi_baru);

		$jabatanSurat 				=	$this->M_surat->cekJabatanSurat($nomor_induk);
		$nama_pekerja 				=	$jabatanSurat[0]['nama'];
		$jabatan_surat 				=	$jabatanSurat[0]['jabatan_surat'];

		$posisiLama 				=	$this->M_surat->ambilPosisi($nomor_induk);
		$posisi_lama 				=	$posisiLama[0]['posisi'];

		$posisi_baru 				=	'';

		$tertanda 					= 	'';
		$nama_tanda_tangan 			=	'';
		$jabatan_tertanda 			=	'';

		if ($cekStaf[0]['status'] == 'STAF') {
			$kode_surat 				=	'DU/KI-B';
			$tertanda 					= 	'CV Karya Hidup Sentosa';
			$nama_tanda_tangan 			=	'Drs. Hendro Wijayanto, Akt';
			$jabatan_tertanda 			=	'Direktur Utama';
			$posisi_baru 				=	$jabatan_baru;
		} else {
			$kode_surat 				=	'PS/KI-M';
			$tertanda 					= 	'CV Karya Hidup Sentosa<br/>Departemen Personalia';
			$nama_tanda_tangan 			=	'Rajiwan';
			$jabatan_tertanda 			=	'Kepala Seksi Utama General Affairs & Hubungan Kerja';

			$cekPekerjaan 				=	$this->M_surat->cekPekerjaan($pekerjaan_baru);
			$nama_pekerjaan_baru 		=	$cekPekerjaan[0]['pekerjaan'];
			if (!(empty($nama_pekerjaan_baru))) {
				$nama_pekerjaan_baru 	.=	' / ';
			} else {
				$nama_pekerjaan_baru 	=	'';
			}
			$posisi_baru 				=	$nama_pekerjaan_baru . 'Golongan ' . $golongan_pekerjaan_baru . ' / ' . 'Seksi ' . $tseksiBaru['0']['seksi'] . ' / ' . 'Unit ' . $tseksiBaru[0]['unit'] . ' / ' . 'Departemen ' . $tseksiBaru[0]['dept'];
		}

		if (empty($nomor_surat)) {

			$nomorSuratMutasiTerakhir 	= 	$this->M_surat->ambilNomorSuratTerakhir($parameterTahunBulanMutasi, $kode_surat);
			$nomorSuratMutasiTerakhir 	=	$nomorSuratMutasiTerakhir[0]['jumlah'];
			$nomorSuratMutasiTerakhir 	=	$nomorSuratMutasiTerakhir + 1;

			if ($nomorSuratMutasiTerakhir < 1000) {
				for ($i = strlen($nomorSuratMutasiTerakhir); $i < 3; $i++) {
					$nomorSuratMutasiTerakhir 	=	'0' . $nomorSuratMutasiTerakhir;
				}
			}

			$nomor_surat 	=	$nomorSuratMutasiTerakhir;
		} else {
			$nomor_surat 	=	$nomor_surat;
		}

		$tembusan 	=	$this->personalia->tembusanDuaPihak($kd_jabatan_lama, $seksi_lama, $kd_lokasi_lama, $kd_jabatan_baru, $seksi_baru, $kd_lokasi_baru);


		$tembusan_HTML 	=	'';
		foreach ($tembusan as $nembus) {
			$tembusan_HTML	.= '<li>' . ucwords(strtolower($nembus)) . '</li>';
			// echo ucwords(strtolower($nembus)).'<br/>';
		}

		// echo 'ini tembus';
		// echo $tembusan_HTML;

		$templateMutasi 			=	$templateMutasi[0]['isi_surat'];

		$parameterUbah 				=	array(
			'[no_surat]',
			'[kode_surat]',
			'[bulan_cetak]',
			'[tahun_cetak]',
			'[nomor_induk]',
			'[nama_pekerja]',
			'[jabatan_surat]',
			'[posisi_lama]',
			'[posisi_baru]',
			'[lokasi_kerja_lama]',
			'[lokasi_kerja_baru]',
			'[tanggal_berlaku]',
			'[seksi_baru]',
			'[unit_baru]',
			'[departemen_baru]',
			'[tanggal_cetak]',
			'[tertanda]',
			'[nama_tanda_tangan]',
			'[jabatan_tertanda]',
			'[tembusan]',
		);
		$parameterDiubah	  		=	array(
			$nomor_surat,
			$kode_surat,
			date('m', strtotime($tanggal_cetak)),
			date('y', strtotime($tanggal_cetak)),
			$nomor_induk,
			$nama_pekerja,
			$jabatan_surat,
			$posisi_lama,
			$posisi_baru,
			$lokasi_lama,
			$lokasi_baru,
			$this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime($tanggal_berlaku))),
			$tseksiBaru[0]['seksi'],
			$tseksiBaru[0]['unit'],
			$tseksiBaru[0]['dept'],
			$this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime($tanggal_cetak))),
			$tertanda,
			$nama_tanda_tangan,
			$jabatan_tertanda,
			$tembusan_HTML,
		);

		$data['preview'] 	=	str_replace($parameterUbah, $parameterDiubah, $templateMutasi);
		$data['nomorSurat']	=	$nomor_surat;
		if (empty($hal_surat)) {
			$data['halSurat']	=	'MUTASI';
		} else {
			$data['halSurat']	=	$hal_surat;
		}
		$data['kodeSurat']	=	$kode_surat;

		echo json_encode($data);
	}

	public function add()
	{
		$nomor_induk 				=	$this->input->post('txtNoind');
		$seksi_lama 				=	substr($this->input->post('txtKodesieLama'), 0, 9);
		$golongan_pekerjaan_lama 	=	$this->input->post('txtGolonganPekerjaanLama');
		$kd_jabatan_lama 			=	$this->input->post('txtKdJabatanLama');
		$jabatan_lama 				=	$this->input->post('txtJabatanLama');
		$lokasi_kerja_lama 			=	$this->input->post('txtLokasiKerja');
		$tempat_makan1_lama 		=	$this->input->post('txtTempatMakan1');
		$tempat_makan2_lama 		= 	$this->input->post('txtTempatMakan2');
		$pekerjaan_lama             =   $this->input->post('txtPekerjaanLama');

		$seksi_baru 				=	$this->input->post('txtKodesieBaru');
		$golongan_pekerjaan_baru	=	$this->input->post('txtGolonganPekerjaanLama');
		$kd_jabatan_baru 			=	$this->input->post('txtKdJabatanBaru');
		$jabatan_baru 				=	$this->input->post('txtJabatanBaru');
		$lokasi_kerja_baru          =   $this->input->post('txtLokasiKerjaBaru');
		// $tempat_makan1_baru         =   $this->input->post('txtTempatMakan1Baru');
		// $tempat_makan2_baru         =   $this->input->post('txtTempatMakan2Baru');
		$pekerjaan_baru             =   $this->input->post('txtPekerjaanBaru');

		$tanggal_berlaku 			=	$this->input->post('txtTanggalBerlaku');
		$tanggal_cetak 				=	$this->input->post('txtTanggalCetak');

		$nomor_surat 				=	$this->input->post('txtNomorSurat');
		$hal_surat 					=	strtoupper($this->input->post('txtHalSurat'));
		$kodeSurat 					=	$this->input->post('txtKodeSurat');
		$staf					 	=   $this->input->post('txtStatusStaf');

		$isi_surat 					=	$this->input->post('txaPreview');

		$getNamaNoindBaru 			=	$this->M_surat->getNamaNoindBaru($nomor_induk);

		$nama 						=	$getNamaNoindBaru[0]['nama'];
		$noind_baru 				=	$getNamaNoindBaru[0]['noind_baru'];

		$lokasi_kerja_lama 			=	explode(' - ', $lokasi_kerja_lama);
		$lokasi_kerja_baru 			=	explode(' - ', $lokasi_kerja_baru);

		$lokasi_lama 				=	$lokasi_kerja_lama[0];
		$lokasi_baru 				=	$lokasi_kerja_baru[0];


		$pekerjaan_lama 			=	explode(' - ', $pekerjaan_lama);
		$kd_pkj_lama		      	=	$pekerjaan_lama[0];

		$pekerjaan_baru			   =	explode(' - ', $pekerjaan_baru);
		$kd_pkj_baru		      	=	$pekerjaan_baru[0];

		$inputSuratMutasi			= 	array(
			'no_surat'				=>	$nomor_surat,
			'kode' 					=>	$kodeSurat,
			'hal_surat'				=>	$hal_surat,
			'noind'					=>	$nomor_induk,
			'kodesie_lama'  		=>  $seksi_lama,
			'kodesie_baru'  		=>  $seksi_baru,
			'tempat_makan_1_lama' 	=>  rtrim($tempat_makan1_lama),
			// 'tempat_makan_1_baru' 	=>  rtrim($tempat_makan1_baru),
			'tempat_makan_2_lama' 	=>  rtrim($tempat_makan2_lama),
			// 'tempat_makan_2_baru' 	=>  rtrim($tempat_makan2_baru),
			'lokasi_kerja_lama'		=>	$lokasi_lama,
			'lokasi_kerja_baru'		=>  $lokasi_baru,
			'golkerja_lama'  		=>	$golongan_pekerjaan_lama,
			'golkerja_baru'  		=>	$golongan_pekerjaan_baru,
			'kd_jabatan_lama'		=>  $kd_jabatan_lama,
			'kd_jabatan_baru'		=>  $kd_jabatan_baru,
			'jabatan_lama'          =>  $jabatan_lama,
			'jabatan_baru'          =>  rtrim($jabatan_baru),
			'tanggal_berlaku'       =>	$tanggal_berlaku,
			'tanggal_cetak'			=>  $tanggal_cetak,
			'nama'					=>	$nama,
			'noind_baru'			=>	$noind_baru,
			'isi_surat'				=>	$isi_surat,
			'kd_pkj_lama'           =>  $kd_pkj_lama,
			'kd_pkj_baru'           =>  $kd_pkj_baru,
			'status_staf' 			=>	$staf,
		);
		$this->M_surat->inputSuratMutasi($inputSuratMutasi);

		$inputNomorSurat 			=	array(
			'bulan_surat' 			=>	date('Y-m', strtotime($tanggal_cetak)),
			'kode_surat' 			=>	$kodeSurat,
			'nomor_surat'			=>	$nomor_surat,
			'noind' 				=>	$nomor_induk,
			'jenis_surat'			=>	'MUTASI',
		);
		$this->M_surat->inputNomorSurat($inputNomorSurat);

		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Input Surat Mutasi Nomor Surat=' . $nomor_surat . ' Noind= ' . $nomor_induk;
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect('MasterPekerja/Surat/SuratMutasi');
	}

	public function previewcetak($no_surat)
	{
		$no_surat_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $no_surat);
		$no_surat_decode 	=	$this->encrypt->decode($no_surat_decode);

		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Cetak Surat Mutasi Nomor Surat=' . $no_surat_decode;
		$this->log_activity->activity_log($aksi, $detail);
		//

		$data['isiSuratMutasi']		=	$this->M_surat->ambilIsiSuratMutasi($no_surat_decode);

		$this->load->library('pdf');
		$pdf 	=	$this->pdf->load();
		$pdf 	=	new mPDF('utf-8', array(216, 297), 10, "timesnewroman", 20, 20, 40, 30, 0, 0, 'P');
		// $pdf 	=	new mPDF();

		$filename	=	'SuratMutasi-' . str_replace('/', '_', $no_surat_decode) . '.pdf';

		$pdf->AddPage();
		$pdf->WriteHTML($data['isiSuratMutasi'][0]['isi_surat']);
		$pdf->setTitle($filename);
		$pdf->Output($filename, 'I');
	}

	public function update($no_surat)
	{
		$no_surat_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $no_surat);
		$no_surat_decode 	=	$this->encrypt->decode($no_surat_decode);

		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Master Pekerja';
		$data['Menu'] 			= 	'Surat-Surat';
		$data['SubMenuOne'] 	= 	'Surat Mutasi';
		$data['SubMenuTwo'] 	= 	'';
		$data['id']				=	$no_surat;

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['editSuratMutasi'] 		= $this->M_surat->editSuratMutasi($no_surat_decode);
		$data['DaftarGolongan'] = $this->M_surat->DetailGolongan();
		$data['DaftarLokasiKerja'] = $this->M_surat->DetailLokasiKerja();
		$data['DaftarKdJabatan'] = $this->M_surat->DetailKdJabatan();
		$data['DaftarTempatMakan1'] = $this->M_surat->DetailTempatMakan1();
		$data['DaftarTempatMakan2'] = $this->M_surat->DetailTempatMakan2();
		// echo "<pre>";
		// print_r($data['editSuratMutasi']);
		// echo "</pre>";
		// exit();
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPekerja/Surat/Mutasi/V_Update', $data);
		$this->load->view('V_Footer', $data);
	}

	public function edit($no_surat)
	{
		$no_surat_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $no_surat);
		$no_surat_decode 	=	$this->encrypt->decode($no_surat_decode);

		$nomor_induk 				=	$this->input->post('txtNoind');
		$seksi_lama 				=	substr($this->input->post('txtKodesieLama'), 0, 9);
		$golongan_pekerjaan_lama 	=	$this->input->post('txtGolonganPekerjaanLama');
		$kd_jabatan_lama 			=	$this->input->post('txtKdJabatanLama');
		$jabatan_lama 				=	$this->input->post('txtJabatanLama');
		$lokasi_kerja_lama 			=	$this->input->post('txtLokasiKerja');
		$tempat_makan1_lama 		=	$this->input->post('txtTempatMakan1');
		$tempat_makan2_lama 		= 	$this->input->post('txtTempatMakan2');
		$pekerjaan_lama             =   $this->input->post('txtPekerjaanLama');

		$seksi_baru 				=	$this->input->post('txtKodesieBaru');
		$golongan_pekerjaan_baru	=	$this->input->post('txtGolonganPekerjaanLama');
		$kd_jabatan_baru 			=	$this->input->post('txtKdJabatanBaru');
		$jabatan_baru 				=	$this->input->post('txtJabatanBaru');
		$lokasi_kerja_baru          =   $this->input->post('txtLokasiKerjaBaru');
		// $tempat_makan1_baru         =   $this->input->post('txtTempatMakan1Baru');
		// $tempat_makan2_baru         =   $this->input->post('txtTempatMakan2Baru');
		$pekerjaan_baru             =   $this->input->post('txtPekerjaanBaru');

		$tanggal_berlaku 			=	$this->input->post('txtTanggalBerlaku');
		$tanggal_cetak 				=	$this->input->post('txtTanggalCetak');

		$nomor_surat 				=	$this->input->post('txtNomorSurat');
		$hal_surat 					=	strtoupper($this->input->post('txtHalSurat'));
		$kodeSurat 					=	$this->input->post('txtKodeSurat');
		$staf					 	=   $this->input->post('txtStatusStaf');

		$isi_surat 					=	$this->input->post('txaPreview');

		$getNamaNoindBaru 			=	$this->M_surat->getNamaNoindBaru($nomor_induk);

		$nama 						=	$getNamaNoindBaru[0]['nama'];
		$noind_baru 				=	$getNamaNoindBaru[0]['noind_baru'];

		$lokasi_kerja_lama 			=	explode(' - ', $lokasi_kerja_lama);
		$lokasi_kerja_baru 			=	explode(' - ', $lokasi_kerja_baru);

		$lokasi_lama 				=	$lokasi_kerja_lama[0];
		$lokasi_baru 				=	$lokasi_kerja_baru[0];


		$pekerjaan_lama 			=	explode(' - ', $pekerjaan_lama);
		$kd_pkj_lama		      	=	$pekerjaan_lama[0];

		$pekerjaan_baru			   =	explode(' - ', $pekerjaan_baru);
		$kd_pkj_baru		      	=	$pekerjaan_baru[0];

		$updateSuratMutasi			= 	array(
			'hal_surat'				=>	$hal_surat,
			'noind'					=>	$nomor_induk,
			'kodesie_lama'  		=>  $seksi_lama,
			'kodesie_baru'  		=>  $seksi_baru,
			'tempat_makan_1_lama' 	=>  rtrim($tempat_makan1_lama),
			// 'tempat_makan_1_baru' 	=>  rtrim($tempat_makan1_baru),
			'tempat_makan_2_lama' 	=>  rtrim($tempat_makan2_lama),
			// 'tempat_makan_2_baru' 	=>  rtrim($tempat_makan2_baru),
			'lokasi_kerja_lama'		=>	$lokasi_lama,
			'lokasi_kerja_baru'		=>  $lokasi_baru,
			'golkerja_lama'  		=>	$golongan_pekerjaan_lama,
			'golkerja_baru'  		=>	$golongan_pekerjaan_baru,
			'kd_jabatan_lama'		=>  $kd_jabatan_lama,
			'kd_jabatan_baru'		=>  $kd_jabatan_baru,
			'jabatan_lama'          =>  $jabatan_lama,
			'jabatan_baru'          =>  rtrim($jabatan_baru),
			'tanggal_berlaku'       =>	$tanggal_berlaku,
			'tanggal_cetak'			=>  $tanggal_cetak,
			'nama'					=>	$nama,
			'noind_baru'			=>	$noind_baru,
			'isi_surat'				=>	$isi_surat,
			'kd_pkj_lama'           =>  $kd_pkj_lama,
			'kd_pkj_baru'           =>  $kd_pkj_baru,
			'status_staf' 			=>	$staf,
		);
		$this->M_surat->updateSuratMutasi($updateSuratMutasi, $nomor_surat, $kodeSurat);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Update Surat Mutasi Nomor Surat=' . $no_surat_decode;
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect('MasterPekerja/Surat/SuratMutasi');
	}

	public function delete($no_surat)
	{
		$no_surat_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $no_surat);
		$no_surat_decode 	=	$this->encrypt->decode($no_surat_decode);

		$this->M_surat->deleteSuratMutasi($no_surat_decode);

		$no_surat_decode 		=	explode('/', $no_surat_decode);
		$no_surat 				=	(int)$no_surat_decode[0];
		$kode_surat 			=	$no_surat_decode[1] . '/' . $no_surat_decode[2];
		$bulan_surat 			= 	'20' . $no_surat_decode[4] . '-' . $no_surat_decode[3];

		$this->M_surat->deleteArsipSuratMutasi($bulan_surat, $kode_surat, $no_surat);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Delete Surat Mutasi Nomor Surat=' . $no_surat_decode;
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect('MasterPekerja/Surat/SuratMutasi');
	}
}
