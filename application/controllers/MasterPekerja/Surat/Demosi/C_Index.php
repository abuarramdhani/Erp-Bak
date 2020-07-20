<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
		$this->load->model('MasterPekerja/Surat/Demosi/M_demosi');
		$this->load->model('MasterPekerja/Surat/M_surat');


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

	public function index()
	{
		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Surat Demosi';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Demosi';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['DaftarSuratDemosi'] 	=	$this->M_demosi->ambilDaftarSuratDemosi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Demosi/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function create()
	{
		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Surat Demosi';
		$data['Menu'] 			= 	'Surat-Surat';
		$data['SubMenuOne'] 	= 	'Surat Demosi';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['DaftarGolongan'] = $this->M_demosi->DetailGolongan();
      	$data['DaftarLokasiKerja'] = $this->M_demosi->DetailLokasiKerja();
      	$data['DaftarKdJabatan'] = $this->M_demosi->DetailKdJabatan();
      	$data['DaftarTempatMakan1'] = $this->M_demosi->DetailTempatMakan1();
      	$data['DaftarTempatMakan2'] = $this->M_demosi->DetailTempatMakan2();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Demosi/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function selectKodesie()
	{
		$noind = $this->input->post('noind');
		$detailPekerja 			= $this->M_demosi->getDetailPekerja($noind);
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
	}

	public function jabatan()
	{
		$jab = $this->input->post('name');
		$kd = $this->input->post('kd');
		$job = $this->input->post('job');
		$tex = $this->M_demosi->KdJabatan($jab, $job, $kd);
		foreach ($tex as $key) {
			$seksi = '';
			if (strlen(trim($tex[0]['bidang'])) < 2) {
				$seksi = trim($tex[0]['dept']);
			}elseif (strlen(trim($tex[0]['unit'])) < 2) {
				$seksi = trim($tex[0]['bidang']);
			}elseif (strlen(trim($tex[0]['seksi'])) < 2) {
				$seksi = trim($tex[0]['unit']);
			}else{
				$seksi = trim($tex[0]['seksi']);
			}
			echo trim($tex[0]['jabatan']).' '.$seksi;
		}
	}

	public function DaftarPekerja()
	{
		$keywordPencarianPekerja 	=	strtoupper($this->input->get('term'));

		$daftarPekerja 				=	$this->M_demosi->cariPekerja($keywordPencarianPekerja);
		echo json_encode($daftarPekerja);
	}

	public function DaftarSeksi()
	{
		$keywordPencarianSeksi	=	strtoupper($this->input->get('term'));

		$daftarseksi 			=	$this->M_demosi->cariseksi($keywordPencarianSeksi);
		echo json_encode($daftarseksi);
	}

	public function DaftarPekerjaan()
	{
		$keywordPencarianPekerjaan	=	strtoupper($this->input->get('term'));
		$kodeSeksi 					=	$this->input->get('kode_seksi');

		$daftarPekerjaan 			=	$this->M_demosi->cariPekerjaan($keywordPencarianPekerjaan, $kodeSeksi);
		echo json_encode($daftarPekerjaan);
	}

	public function cariGolonganPekerjaan()
	{
		$keywordPencarianGolKerja 	=	strtoupper($this->input->get('term'));
		$kodeStatusKerja 			=	$this->input->get('kode_status_kerja');

		$golonganPekerjaan 			=	$this->M_demosi->cariGolonganPekerjaan($keywordPencarianGolKerja, $kodeStatusKerja);
		echo json_encode($golonganPekerjaan);
	}

	// public function prosesPreviewDemosi()
	// {
	// 	$nomor_induk 				=	$this->input->post('txtNoind');
	// 	$seksi_lama 				=	substr($this->input->post('txtKodesieLama'), 0, 9);
	// 	$golongan_pekerjaan_lama 	=	$this->input->post('txtGolonganPekerjaanLama');
	// 	$pekerjaan_lama 		 	=	$this->input->post('txtPekerjaanLama');
	// 	$kd_jabatan_lama 			=	$this->input->post('txtKdJabatanLama');
	// 	$jabatan_lama 				=	$this->input->post('txtJabatanLama');
	// 	$lokasi_kerja_lama 			=	$this->input->post('txtLokasiKerja');
	// 	$tempat_makan1_lama 		=	$this->input->post('txtTempatMakan1');
	// 	$tempat_makan2_lama 		= 	$this->input->post('txtTempatMakan2');

	// 	$seksi_baru 				=	$this->input->post('txtKodesieBaru');
	// 	$golongan_pekerjaan_baru	=	$this->input->post('txtGolonganPekerjaanBaru');
	// 	$pekerjaan_baru 			=	$this->input->post('txtPekerjaanBaru');
	// 	$kd_jabatan_baru 			=	$this->input->post('txtKdJabatanBaru');
	// 	$jabatan_baru 				=	$this->input->post('txtJabatanBaru');
	// 	$lokasi_kerja_baru          =   $this->input->post('txtLokasiKerjaBaru');
	// 	$tempat_makan1_baru         =   $this->input->post('txtTempatMakan1Baru');
	// 	$tempat_makan2_baru         =   $this->input->post('txtTempatMakan2Baru');

	// 	$tanggal_berlaku 			=	$this->input->post('txtTanggalBerlaku');
	// 	$tanggal_cetak 				=	$this->input->post('txtTanggalCetak');
	// 	$nomor_surat 				=	$this->input->post('txtNomorSurat');
	// 	$kode_surat 				=	$this->input->post('txtKodeSurat');
	// 	$hal_surat 					=	$this->input->post('txtHalSurat');
	// 	$staf					 	=   $this->input->post('txtStatusStaf');


	// 	$parameterTahunBulanDemosi 	=	date('Ym', strtotime($tanggal_berlaku));



	// 	$lokasi_kerja_lama 			=	explode(' - ', $lokasi_kerja_lama);
	// 	$lokasi_lama 				=	$lokasi_kerja_lama[1];

	// 	$lokasi_kerja_baru 			=	explode(' - ', $lokasi_kerja_baru);
	// 	$lokasi_baru				=	$lokasi_kerja_baru[1];

	// 	$nama_pekerjaan_lama 		=	'';
	// 	if(empty($pekerjaan_lama))
	// 	{
	// 		$nama_pekerjaan_lama 		= 	'-';
	// 	}
	// 	else
	// 	{
	// 		$pekerjaan_lama 			=	explode(' - ', $pekerjaan_lama);
	// 		$nama_pekerjaan_lama		=	$pekerjaan_lama[1];
	// 		$kd_pkj_lama             	=   $pekerjaan_lama[0];
	// 	}

	// 	$nama_pekerjaan_baru 		=	'';
	// 	if(empty($kode_surat))
	// 	{
	// 		if((int) $kd_jabatan_lama<17)
	// 		{
	// 			$kode_surat 	=	'DU/KI-C';
	// 		}
	// 		else
	// 		{
	// 			$kode_surat 	=	'PS/KI-N';
	// 		}
	// 	}
	// 	else
	// 	{
	// 		$kode_surat 	=	$kode_surat;
	// 	}

	// 	$templateDemosi 			=	$this->M_demosi->ambilLayoutSuratDemosi($kode_surat);
	// 	$nama_pekerja 				=	$this->M_demosi->cariPekerja($nomor_induk);
	// 	$tseksiLama 				=	$this->M_demosi->cariTSeksi($seksi_lama);
	// 	$tseksiBaru 				=	$this->M_demosi->cariTSeksi($seksi_baru);
	// 	$pekerjaan_baru 			=	$this->M_demosi->cariPekerjaan('', $pekerjaan_baru);

	// 	$nama_pekerjaan_baru 		=	$pekerjaan_baru[0]['pekerjaan'];

	// 	$nama_pekerja 				=	$nama_pekerja[0]['nama'];

	// 	if(empty($nomor_surat))
	// 	{

	// 		$nomorSuratDemosiTerakhir 	= 	$this->M_demosi->ambilNomorSuratDemosiTerakhir($parameterTahunBulanDemosi, $kode_surat);
	// 		$nomorSuratDemosiTerakhir 	=	$nomorSuratDemosiTerakhir[0]['jumlah'];
	// 		$nomorSuratDemosiTerakhir 	=	$nomorSuratDemosiTerakhir+1;

	// 		if($nomorSuratDemosiTerakhir<1000)
	// 		{
	// 			for ($i=strlen($nomorSuratDemosiTerakhir); $i < 3; $i++)
	// 			{
	// 				$nomorSuratDemosiTerakhir 	=	'0'.$nomorSuratDemosiTerakhir;
	// 			}
	// 		}

	// 		$nomor_surat 	=	$nomorSuratDemosiTerakhir;
	// 	}
	// 	else
	// 	{
	// 		$nomor_surat 	=	$nomor_surat;
	// 	}


	// 	$templateDemosi 			=	$templateDemosi[0]['isi_surat'];

	// 	$parameterUbah 				=	array
	// 									(
	// 										'[no_surat]',
	// 										'[kode_surat]',
	// 										'[bulan_cetak]',
	// 										'[tahun_cetak]',
	// 										'[nomor_induk]',
	// 										'[nama_pekerja]',
	// 										'[pekerjaan_lama]',
	// 										'[golongan_pekerjaan_lama]',
	// 										'[seksi_lama]',
	// 										'[unit_lama]',
	// 										'[departemen_lama]',
	// 										'[lokasi_kerja_lama]',
	// 										'[pekerjaan_baru]',
	// 										'[golongan_pekerjaan_baru]',
	// 										'[seksi_baru]',
	// 										'[unit_baru]',
	// 										'[departemen_baru]',
	// 										'[lokasi_kerja_baru]',
	// 										'[tanggal_cetak]',
	// 										'[tanggal_promosi]'
	// 									);
	// 	$parameterDiubah	  		=	array
	// 									(
	// 										$nomor_surat,
	// 										$kode_surat,
	// 										date('m', strtotime($tanggal_cetak)),
	// 										date('y', strtotime($tanggal_cetak)),
	// 										$nomor_induk,
	// 										$nama_pekerja,
	// 										$nama_pekerjaan_lama,
	// 										$golongan_pekerjaan_lama,
	// 										$tseksiLama[0]['seksi'],
	// 										$tseksiLama[0]['unit'],
	// 										$tseksiLama[0]['dept'],
	// 										$lokasi_lama,
	// 										$nama_pekerjaan_baru,
	// 										$golongan_pekerjaan_baru,
	// 										$tseksiBaru[0]['seksi'],
	// 										$tseksiBaru[0]['unit'],
	// 										$tseksiBaru[0]['dept'],
	// 										$lokasi_baru,
	// 										date('d F Y', strtotime($tanggal_cetak)),
	// 										date('d F Y', strtotime($tanggal_berlaku))
	// 									);

	// 	$data['preview'] 	=	str_replace($parameterUbah, $parameterDiubah, $templateDemosi);
	// 	$data['nomorSurat']	=	$nomor_surat;
	// 	if(empty($hal_surat))
	// 	{
	// 		$data['halSurat']	=	'PERUBAHAN PLOTING PEKERJAAN';
	// 	}
	// 	else
	// 	{
	// 		$data['halSurat']	=	$hal_surat;
	// 	}
	// 	$data['kodeSurat']	=	$kode_surat;
	// 	echo json_encode($data);
	// }

		public function prosesPreviewDemosi()
	{
		$nomor_induk 				=	$this->input->post('txtNoind');
		$seksi_lama 				=	substr($this->input->post('txtKodesieLama'), 0, 9);
		$golongan_pekerjaan_lama 	=	$this->input->post('txtGolonganPekerjaanLama');
		$pekerjaan_lama 		 	=	$this->input->post('txtPekerjaanLama');
		$kd_jabatan_lama 			=	substr($this->input->post('txtKdJabatanLama'),0,2);
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
		$edit					 	=   $this->input->post('txtStatusEdit');


		$parameterTahunDemosi 	=	date('Y', strtotime($tanggal_cetak));
		$parameterBulanDemosi 	=	date('m', strtotime($tanggal_cetak));



		$lokasi_kerja_lama 			=	explode(' - ', $lokasi_kerja_lama);
		$lokasi_lama 				=	$lokasi_kerja_lama[1];
		$kd_lokasi_lama 			=	$lokasi_kerja_lama[0];

		$lokasi_kerja_baru 			=	explode(' - ', $lokasi_kerja_baru);
		$lokasi_baru				=	$lokasi_kerja_baru[1];
		$kd_lokasi_baru 			=	$lokasi_kerja_baru[0];

		$nama_pekerjaan_lama 		=	'';
		if(empty($pekerjaan_lama))
		{
			$nama_pekerjaan_lama 		= 	'-';
		}
		else
		{
			$pekerjaan_lama 			=	explode(' - ', $pekerjaan_lama);
			$nama_pekerjaan_lama		=	$pekerjaan_lama[1];
			$kd_pkj_lama             	=   $pekerjaan_lama[0];
		}

		$posisiLama 				=	$this->M_demosi->ambilPosisi($nomor_induk);
		$posisi_lama 				=	$posisiLama[0]['posisi'];
		$cekStaf 					=	$this->M_demosi->cekStaf($nomor_induk);
		$nama_pekerjaan_baru 		=	'';
		if(empty($kode_surat))
		{
			if($cekStaf[0]['status']=='STAF')
			{
				$kode_surat 	=	'DU/KI-C';
			}
			else
			{
				$kode_surat 	=	'PS/KI-N';
			}
		}
		else
		{
			if($cekStaf[0]['status']=='STAF')
			{
				$kode_surat 	=	'DU/KI-C';
			}
			else
			{
				$kode_surat 	=	'PS/KI-N';
			}
			$kode_surat 	=	$kode_surat;
		}
		$posisi_baru = '';
		$tseksiBaru 				=	$this->M_surat->cariTSeksi($seksi_baru);
		if($cekStaf[0]['status']=='STAF')
			{
				$kode_surat 				=	'DU/KI-C';
				$tertanda 					= 	'CV Karya Hidup Sentosa';
				$nama_tanda_tangan 			=	'Drs. Hendro Wijayanto, Akt';
				$jabatan_tertanda 			=	'Direktur Utama';
				$posisi_baru 				=	$jabatan_baru;
			}
			else
			{
				$kode_surat 				=	'PS/KI-N';
				$tertanda 					= 	'Cv Karya Hidup Sentosa<br/>Departemen Personalia';
				$nama_tanda_tangan 			=	'Rajiwan';
				$jabatan_tertanda 			=	'Kepala Seksi Utama General Affairs & Hubungan Kerja';

				$cekPekerjaan 				=	$this->M_surat->cekPekerjaan($pekerjaan_baru);
				$nama_pekerjaan_baru 		=	$cekPekerjaan[0]['pekerjaan'];
				if(!(empty($nama_pekerjaan_baru)))
				{
					$nama_pekerjaan_baru 	.=	' / ';
				}
				else
				{
					$nama_pekerjaan_baru 	=	'';
				}
				$posisi_baru 				=	$nama_pekerjaan_baru.'Golongan '.$golongan_pekerjaan_baru.' / '.'Seksi '.$tseksiBaru['0']['seksi'].' / '.'Unit '.$tseksiBaru[0]['unit'].' / '.'Departemen '.$tseksiBaru[0]['dept'];
			}

		$stafff = '1';
		if($cekStaf[0]['status']=='STAF')
		{
			$stafff = '1';
		}else{
			$stafff = '0';
		}

		$templateDemosi 			=	$this->M_demosi->ambilLayoutSuratDemosi($stafff);
		$nama_pekerja 				=	$this->M_demosi->cariPekerja($nomor_induk);
		$tseksiLama 				=	$this->M_demosi->cariTSeksi($seksi_lama);
		$tseksiBaru 				=	$this->M_demosi->cariTSeksi($seksi_baru);

		$nama_pekerja 				=	$nama_pekerja[0]['nama'];

		if(empty($pekerjaan_baru))
		{
			$nama_pekerjaan_baru 		= 	'-';
		}
		else
		{
			$pekerjaan_baru 			=	$this->M_demosi->cariPekerjaan('', $pekerjaan_baru);

			$nama_pekerjaan_baru 		=	$pekerjaan_baru[0]['pekerjaan'];
		}

			// echo 'edit = '.$edit;
		if($edit == '1')
		{
			$nomor_surat 	=	$nomor_surat;
		}
		else
		{
			$nomorSuratDemosiTerakhir 	= 	$this->M_demosi->ambilNomorSuratDemosiTerakhir($parameterTahunDemosi, $parameterBulanDemosi, $kode_surat);
			// print_r($nomorSuratDemosiTerakhir);
			$nomorSuratDemosiTerakhir 	=	$nomorSuratDemosiTerakhir[0]['jumlah'];
			$nomorSuratDemosiTerakhir 	=	$nomorSuratDemosiTerakhir+1;

			if($nomorSuratDemosiTerakhir<1000)
			{
				for ($i=strlen($nomorSuratDemosiTerakhir); $i < 3; $i++)
				{
					$nomorSuratDemosiTerakhir 	=	'0'.$nomorSuratDemosiTerakhir;
				}
			}

			$nomor_surat 	=	$nomorSuratDemosiTerakhir;
		}

		// echo 'ini ambil tembusan';
		// echo $kd_jabatan_lama. $seksi_lama. $lokasi_lama. $kd_jabatan_baru. $seksi_baru. $lokasi_baru;
		$tembusan 	=	$this->personalia->tembusanDuaPihak($kd_jabatan_lama, $seksi_lama, $kd_lokasi_lama, $kd_jabatan_baru, $seksi_baru, $kd_lokasi_baru);


		$tembusan_HTML 	=	'';
		foreach ($tembusan as $nembus)
		{
			$tembusan_HTML	.= '<li>'.ucwords(strtolower($nembus)).'</li>';
			// echo ucwords(strtolower($nembus)).'<br/>';
		}

		// echo 'ini tembus';
		// echo $tembusan_HTML;

		$templateDemosi 			=	$templateDemosi[0]['isi_surat'];

		$seksiBaru = ' ';
			$unitBaru = ' ';
			$deptBaru = ' ';
			if (strlen($tseksiBaru[0]['seksi']) > 2) {
				$seksiBaru = ' Seksi '.$tseksiBaru[0]['seksi'].', ';
			}
			if (strlen($tseksiBaru[0]['unit']) > 2) {
				$unitBaru = 'Unit '.$tseksiBaru[0]['unit'].', ';
			}
			if (strlen($tseksiBaru[0]['dept']) > 2) {
				$deptBaru = 'Departemen '.$tseksiBaru[0]['dept'].',';
			}

			$seksiNew = $tseksiBaru[0]['seksi'];
			$unitNew = $tseksiBaru[0]['unit'];
			$deptNew = $tseksiBaru[0]['dept'];

		$parameterUbah 				=	array
										(
											'[no_surat]',
											'[kode_surat]',
											'[bulan_cetak]',
											'[tahun_cetak]',
											'[nomor_induk]',
											'[nama_pekerja]',
											'[pekerjaan_lama]',
											'[golongan_pekerjaan_lama]',
											'[seksi_lama]',
											'[unit_lama]',
											'[departemen_lama]',
											'[lokasi_kerja_lama]',
											'[pekerjaan_baru]',
											'[golongan_pekerjaan_baru]',
											'[seksi_baru]',
											'[unit_baru]',
											'[departemen_baru]',
											'[lokasi_kerja_baru]',
											'[tanggal_cetak]',
											'[tanggal_demosi]',
											'[tembusan]',
											'[jabatan_lama]',
											'[jabatan_baru]',
											'[posisi_baru]',
											'[unit_new]',
											'[departemen_new]'
										);
		$parameterDiubah	  		=	array
										(
											$nomor_surat,
											$kode_surat,
											date('m', strtotime($tanggal_cetak)),
											date('y', strtotime($tanggal_cetak)),
											$nomor_induk,
											$nama_pekerja,
											$nama_pekerjaan_lama,
											$golongan_pekerjaan_lama,
											$tseksiLama[0]['seksi'],
											$tseksiLama[0]['unit'],
											$tseksiLama[0]['dept'],
											$lokasi_lama,
											$nama_pekerjaan_baru,
											$golongan_pekerjaan_baru,
											$seksiBaru,
											$unitBaru,
											$deptBaru,
											$lokasi_baru,
											$this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime($tanggal_cetak))),
											$this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime($tanggal_berlaku))),
											$tembusan_HTML,
											$jabatan_lama,
											$jabatan_baru,
											$posisi_baru,
											$unitNew,
											$deptNew
										);

		$data['preview'] 	=	str_replace($parameterUbah, $parameterDiubah, $templateDemosi);
		$data['nomorSurat']	=	$nomor_surat;
		if(empty($hal_surat))
		{
			$data['halSurat']	=	'Demosi';
		}
		else
		{
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
		$kd_jabatan_lama 			=	substr($this->input->post('txtKdJabatanLama'),0,2);
		$jabatan_lama 				=	$this->input->post('txtJabatanLama');
		$lokasi_kerja_lama 			=	$this->input->post('txtLokasiKerja');
		$tempat_makan1_lama 		=	$this->input->post('txtTempatMakan1');
		$tempat_makan2_lama 		= 	$this->input->post('txtTempatMakan2');
		$pekerjaan_lama             =   $this->input->post('txtPekerjaanLama');

		$seksi_baru 				=	$this->input->post('txtKodesieBaru');
		$golongan_pekerjaan_baru	=	$this->input->post('txtGolonganPekerjaanBaru');
		if($golongan_pekerjaan_baru == null){
				$golongan_pekerjaan_baru = $golongan_pekerjaan_lama;
			}
		$kd_jabatan_baru 			=	$this->input->post('txtKdJabatanBaru');
		$jabatan_baru 				=	$this->input->post('txtJabatanBaru');
		$lokasi_kerja_baru          =   $this->input->post('txtLokasiKerjaBaru');
		// $tempat_makan1_baru         =   $this->input->post('txtTempatMakan1Baru');
		// $tempat_makan2_baru         =   $this->input->post('txtTempatMakan2Baru');
		$pekerjaan_baru             =   $this->input->post('txtPekerjaanBaru');
		if($pekerjaan_baru == null){
				$pekerjaan_baru = $pekerjaan_lama;
			}

		$status_lama				= 	$this->input->post('txtStatusJabatanlama');

		$status_baru				= 	$this->input->post('txtStatusjabatanBaru');

		if($status_baru != null or $status_baru != "" ){
			$status_baru 			= 	explode(' - ', $status_baru);
		}else{
			$status_baru 			= 	explode(' - ', $status_lama);
		}

		$status_lama 				= 	explode(' - ', $status_lama);
		$kd_status_lama				= 	$status_lama[0];
		$nama_status_lama			= 	$status_lama[1];

		$kd_status_baru 			= 	$status_baru[0];
		$nama_status_baru			= 	$status_baru[1];

		$nama_jabatan_upah_lama     =   $this->input->post('txtNamaJabatanUpahlama');
		$nama_jabatan_upah_baru     =   $this->input->post('txtNamaJabatanUpahBaru');

		$tanggal_berlaku 			=	$this->input->post('txtTanggalBerlaku');
		$tanggal_cetak 				=	$this->input->post('txtTanggalCetak');

		$nomor_surat 				=	$this->input->post('txtNomorSurat');
		$hal_surat 					=	strtoupper($this->input->post('txtHalSurat'));
		$kodeSurat 					=	$this->input->post('txtKodeSurat');
		$staf					 	=   $this->input->post('txtStatusStaf');

		$isi_surat 					=	$this->input->post('txaPreview');

		$getNamaNoindBaru 			=	$this->M_demosi->getNamaNoindBaru($nomor_induk);

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

		$inputSuratDemosi			= 	array
										(
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
											'nama_status_lama'		=>  $nama_status_lama,
											'nama_status_baru'		=>  $nama_status_baru,
											'nama_jabatan_upah_lama'=> 	$nama_jabatan_upah_lama,
											'nama_jabatan_upah_baru'=>	$nama_jabatan_upah_baru,
											'kd_status_lama'		=> 	$kd_status_lama,
											'kd_status_baru' 		=>	$kd_status_baru,
											'created_by'			=>  $this->session->user ,
											'created_date'			=> 	date('Y-m-d H:i:s'),
											'last_update_by'		=> NULL,
											'last_update_date'		=> NULL
										);
		$this->M_demosi->inputSuratDemosi($inputSuratDemosi);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Add Surat Demosi Nomor Surat='.$nomor_surat.' Noind='.$nomor_induk;
		$this->log_activity->activity_log($aksi, $detail);
		//

		$bulan_surat = date('m', strtotime($tanggal_cetak));
		$bulan_surat = substr($bulan_surat, 0, 2);
		$tahun_surat = date('Y', strtotime($tanggal_cetak));
		$inputNomorSurat 			=	array
											(
												'bulan_surat' 			=>	$bulan_surat,
												'tahun_surat'			=>	$tahun_surat,
												'kode_surat' 			=>	$kodeSurat,
												'nomor_surat'			=>	$nomor_surat,
												'noind' 				=>	$nomor_induk,
												'jenis_surat'			=>	'DEMOSI',
											);

			$this->M_demosi->inputNomorSurat($inputNomorSurat);
		redirect('MasterPekerja/Surat/SuratDemosi');
	}

	public function previewcetak($no_surat)
	{
		$no_surat_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $no_surat);
		$no_surat_decode 	=	$this->encrypt->decode($no_surat_decode);

		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Cetak Surat Demosi Nomor Surat='.$no_surat_decode;
		$this->log_activity->activity_log($aksi, $detail);
		//

		$data['isiSuratDemosi']		=	$this->M_demosi->ambilIsiSuratDemosi($no_surat_decode);

		$this->load->library('pdf');
		$pdf 	=	$this->pdf->load();
		$pdf 	=	new mPDF('utf-8', array(216,297), 0, "timesnewroman", 20, 20, 48, 40, 0, 0, 'P');
		$stylesheet = file_get_contents(base_url('assets/css/surat.css'));
		// $pdf 	=	new mPDF();

		$filename	=	'SuratDemosi-'.str_replace('/', '_', $no_surat_decode).'.pdf';

		$pdf->AddPage();
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($data['isiSuratDemosi'][0]['isi_surat']);
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
		$data['SubMenuOne'] 	= 	'Surat Demosi';
		$data['SubMenuTwo'] 	= 	'';
		$data['id']				=	$no_surat;

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['editSuratDemosi'] 		= $this->M_demosi->editSuratDemosi($no_surat_decode);
		$data['DaftarGolongan'] = $this->M_demosi->DetailGolongan();
      	$data['DaftarLokasiKerja'] = $this->M_demosi->DetailLokasiKerja();
      	$data['DaftarKdJabatan'] = $this->M_demosi->DetailKdJabatan();
      	$data['DaftarTempatMakan1'] = $this->M_demosi->DetailTempatMakan1();
      	$data['DaftarTempatMakan2'] = $this->M_demosi->DetailTempatMakan2();
		// echo "<pre>";
		// print_r($data['editSuratDemosi']);
		// echo "</pre>";
		// exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Demosi/V_Update',$data);
		$this->load->view('V_Footer',$data);
	}

	public function edit($no_surat)
	{
		$no_surat_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $no_surat);
		$no_surat_decode 	=	$this->encrypt->decode($no_surat_decode);

		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Update Surat Demosi Nomor Surat='.$no_surat_decode;
		$this->log_activity->activity_log($aksi, $detail);
		//

		$nomor_induk 				=	substr($this->input->post('txtNoind'), 0, 5);
		$seksi_lama 				=	substr($this->input->post('txtKodesieLama'), 0, 9);
		$golongan_pekerjaan_lama 	=	$this->input->post('txtGolonganPekerjaanLama');
		$kd_jabatan_lama 			=	$this->input->post('txtKdJabatanLama');
		$jabatan_lama 				=	$this->input->post('txtJabatanLama');
		$lokasi_kerja_lama 			=	$this->input->post('txtLokasiKerja');
		$tempat_makan1_lama 		=	$this->input->post('txtTempatMakan1');
		$tempat_makan2_lama 		= 	$this->input->post('txtTempatMakan2');
		$pekerjaan_lama             =   $this->input->post('txtPekerjaanLama');

		$seksi_baru 				=	$this->input->post('txtKodesieBaru');
		$golongan_pekerjaan_baru	=	$this->input->post('txtGolonganPekerjaanBaru');
		if($golongan_pekerjaan_baru == null){
				$golongan_pekerjaan_baru = $golongan_pekerjaan_lama;
			}
		$kd_jabatan_baru 			=	$this->input->post('txtKdJabatanBaru');
		$jabatan_baru 				=	$this->input->post('txtJabatanBaru');
		$lokasi_kerja_baru          =   $this->input->post('txtLokasiKerjaBaru');
		// $tempat_makan1_baru         =   $this->input->post('txtTempatMakan1Baru');
		// $tempat_makan2_baru         =   $this->input->post('txtTempatMakan2Baru');
		$pekerjaan_baru             =   $this->input->post('txtPekerjaanBaru');
		if($pekerjaan_baru == null){
				$pekerjaan_baru = $pekerjaan_lama;
			}

		$status_lama				= 	$this->input->post('txtStatusJabatanlama');

		$status_baru				= 	$this->input->post('txtStatusjabatanBaru');

		if($status_baru != null or $status_baru != "" ){
			$status_baru 			= 	explode(' - ', $status_baru);
		}else{
			$status_baru 			= 	explode(' - ', $status_lama);
		}

		$status_lama 				= 	explode(' - ', $status_lama);
		$kd_status_lama				= 	$status_lama[0];
		$nama_status_lama			= 	$status_lama[1];

		$kd_status_baru 			= 	$status_baru[0];
		$nama_status_baru			= 	$status_baru[1];

		$nama_jabatan_upah_lama     =   $this->input->post('txtNamaJabatanUpahlama');
		$nama_jabatan_upah_baru     =   $this->input->post('txtNamaJabatanUpahBaru');

		$tanggal_berlaku 			=	$this->input->post('txtTanggalBerlaku');
		$tanggal_cetak 				=	$this->input->post('txtTanggalCetak');
		$tanggal_cetak_asli			=	$this->input->post('txtTanggalCetakAsli');

		$nomor_surat 				=	$this->input->post('txtNomorSurat');
		$hal_surat 					=	strtoupper($this->input->post('txtHalSurat'));
		$kodeSurat 					=	$this->input->post('txtKodeSurat');
		$staf					 	=   $this->input->post('txtStatusStaf');

		$isi_surat 					=	$this->input->post('txaPreview');

		$getNamaNoindBaru 			=	$this->M_demosi->getNamaNoindBaru($nomor_induk);

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

		$updateSuratDemosi			= 	array
										(
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
											'nama_status_lama'		=>  $nama_status_lama,
											'nama_status_baru'		=>  $nama_status_baru,
											'nama_jabatan_upah_lama'=> 	$nama_jabatan_upah_lama,
											'nama_jabatan_upah_baru'=>	$nama_jabatan_upah_baru,
											'kd_status_lama'		=> 	$kd_status_lama,
											'kd_status_baru' 		=>	$kd_status_baru,
											'status_update'			=> '0',
											'last_update_by'			=>  $this->session->user ,
											'last_update_date'			=> 	date('Y-m-d H:i:s')
										);
		$this->M_demosi->updateSuratDemosi($updateSuratDemosi, $nomor_surat, $kodeSurat, $tanggal_cetak_asli);
		redirect('MasterPekerja/Surat/SuratDemosi');
	}

	public function delete($no_surat)
	{
		$no_surat_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $no_surat);
		$no_surat_decode 	=	$this->encrypt->decode($no_surat_decode);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Delete Surat Demosi Nomor Surat='.$no_surat_decode;
		$this->log_activity->activity_log($aksi, $detail);
		//

		$this->M_demosi->deleteSuratDemosi($no_surat_decode);

		$no_surat_decode 		=	explode('/', $no_surat_decode);
		$no_surat 				=	(int)$no_surat_decode[0];
		$kode_surat 			=	$no_surat_decode[1].'/'.$no_surat_decode[2];
		$tahun 					= 	'20'.$no_surat_decode[4];
		$bulan_surat			=	$no_surat_decode[3];
		// echo $no_surat;exit();

		$this->M_demosi->deleteArsipSuratDemosi($bulan_surat, $tahun, $kode_surat, $no_surat);
		redirect('MasterPekerja/Surat/SuratDemosi');

	}

	// public function ujicobanembus($kd_jabatan, $kodesie)
	// {
	// 	$kd_jabatan 	=	$kd_jabatan;
	// 	$kodesie 		=	$kodesie;

	// 	for ($tingkat=1; $tingkat < strlen($kodesie); $tingkat++)
	// 	{
	// 		$kodeTingkatan 	=	substr($kodesie, 0, $tingkat);
	// 		echo $kodeTingkatan.'<br/>';
	// 		for ($panjangKarakter=strlen($kodeTingkatan); $panjangKarakter < 9; $panjangKarakter++)
	// 		{
	// 			$kodeTingkatan 	.= 	'0';
	// 		}
	// 		echo $kodeTingkatan.'<br/>';
	// 		$tingkat++;
	// 	}
	// }
}
