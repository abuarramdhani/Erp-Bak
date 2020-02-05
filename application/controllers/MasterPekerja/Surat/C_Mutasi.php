<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Mutasi extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->library('Log_Activity');
		$this->load->library('General');
		$this->load->library('Personalia');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/Surat/M_surat');
		$this->load->model('MasterPekerja/Surat/M_mutasi');

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
		$data 			=	$this->general->loadHeaderandSidemenu('Surat Mutasi - Master Pekerja - Quick ERP', 'Surat Mutasi', 'Surat', 'Surat Mutasi');

		$data['view'] 	=	$this->M_mutasi->view();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Mutasi/V_Index',$data);
		$this->load->view('V_Footer',$data);
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
			// print_r( $data); exit();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MasterPekerja/Surat/Mutasi/V_Create',$data);
			$this->load->view('V_Footer',$data);
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

		public function preview()
		{
			$jenis_surat 			=	$this->input->post('txtFormatSurat', TRUE);
			$status_staf			=	$this->input->post('txtStatusStaf', TRUE);

			if ( empty($status_staf) )
			{
				$error = 'Anda belum memilih pekerja. Dimohon untuk memilih pekerja dahulu.';
				echo "<script>alert('$error');</script>";
				exit();
			}

			$tanggal_cetak 			=	$this->input->post('txtTanggalCetak', TRUE);
			$tanggal_berlaku 		=	$this->input->post('txtTanggalBerlaku', TRUE);

			$data['kode_surat']		=	'XXXXX';
			$data['nomor_surat']	=	0;
			$data['hal_surat']		=	'HALAL';
			$data['preview'] 		=	$this->prosesPreviewMutasi();

			// 	Kode, Nomor, dan Hal Surat
			//	{
			$status_staf_bool 	=	FALSE;
			if( strpos($status_staf, "NON") !== FALSE )
			{
				$status_staf_bool 	=	FALSE;
			}
			else
			{
				$status_staf_bool 	=	TRUE;
			}

			$tahun_cetak 	=	date('Y', strtotime($tanggal_cetak));
			$bulan_cetak 	=	date('n', strtotime($tanggal_cetak));
			$tahun_berlaku 	=	date('Y', strtotime($tanggal_berlaku));
			$bulan_berlaku 	=	date('n', strtotime($tanggal_berlaku));

					// 	Cek kode surat
					// 	{
			$tabel_kode_surat 	=	$this->M_surat->kode_surat($jenis_surat, $status_staf_bool);

			if( empty($tabel_kode_surat) )
			{
				echo 'Kode surat tidak ditemukan.<br/>Mohon input terlebih dahulu.';
				exit();
			}
			else
			{
				$data['kode_surat'] 	=	$tabel_kode_surat[0]['kode_surat'];
			}
					//	}

					// 	Ambil Nomor Surat Baru
					// 	{
			$tabel_arsip_nomor_surat 	=	$this->M_surat->nomor_surat($data['kode_surat'], 'max', $tahun_cetak, $bulan_cetak);


			if( empty($tabel_arsip_nomor_surat) )
			{
				$data['nomor_surat']	=	'001';
			}
			else
			{
				$data['nomor_surat']	=	$tabel_arsip_nomor_surat[0]['hitung']+1;
				if ($data['nomor_surat'] < 10) {
					$data['nomor_surat'] = '00'.$data['nomor_surat'];
				}elseif ($data['nomor_surat'] > 10 && $data['nomor_surat'] < 100) {
					$data['nomor_surat'] = '0'.$data['nomor_surat'];
				}
			}
					//	}

					//	Hal Surat
					// 	{
			$data['hal_surat']		=	$jenis_surat;
					//	}
			//	}

			// 	Preview Surat
			//	{

			//	}

			echo json_encode($data);
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
			$tempat_makan1_baru         =   $this->input->post('txtTempatMakan1Baru');
			$tempat_makan2_baru         =   $this->input->post('txtTempatMakan2Baru');

			$tanggal_berlaku 			=	$this->input->post('txtTanggalBerlaku');
			$tanggal_cetak 				=	$this->input->post('txtTanggalCetak');
			$nomor_surat 				=	$this->input->post('txtNomorSurat');
			$kode_surat 				=	$this->input->post('txtKodeSurat');
			$hal_surat 					=	$this->input->post('txtHalSurat');
			$staf					 	=   $this->input->post('txtStatusStaf');
			$edit					 	=   $this->input->post('txtStatusEdit');


			$parameterTahun 	=	date('Y', strtotime($tanggal_cetak));
			$parameterBulan 	=	date('m', strtotime($tanggal_cetak));


			// print_r($lokasi_kerja_lama);exit();
			$lokasi_kerja_lama 			=	explode(' - ', $lokasi_kerja_lama);
			$lokasi_lama 				=	$lokasi_kerja_lama[1];
			$kd_lokasi_lama 			=	$lokasi_kerja_lama[0];

			$lokasi_kerja_baru 			=	explode(' - ', $lokasi_kerja_baru);
			// print_r($lokasi_kerja_baru);
			$lokasi_baru				=	$lokasi_kerja_baru[1];
			$kd_lokasi_baru 			=	$lokasi_kerja_baru[0];

			$nama_pekerjaan_lama 		=	'';
			$nama_pekerjaan_baru 		=	'';

			$cekStaf 					=	$this->M_surat->cekStaf($nomor_induk);
			if(empty($kode_surat))
			{
				if($cekStaf[0]['status']=='STAF')
				{
					$kode_surat 				=	'DU/KI-B';
				}
				else
				{
					$kode_surat 				=	'PS/KI-M';

				}
			}
			else
			{
				$kode_surat 	=	$kode_surat;
			}
			if ($staf == 'STAF') {
				$staff = 'true';
			}else{
				$staff = 'false';
			}
			$templateMutasi 			=	$this->M_surat->ambilLayoutSuratMutasi($staff);
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

			if($cekStaf[0]['status']=='STAF')
			{
				$kode_surat 				=	'DU/KI-B';
				$tertanda 					= 	'CV Karya Hidup Sentosa';
				$nama_tanda_tangan 			=	'Drs. Hendro Wijayanto, Akt';
				$jabatan_tertanda 			=	'Direktur Utama';
				$posisi_baru 				=	$jabatan_baru;
			}
			else
			{
				$kode_surat 				=	'PS/KI-M';
				$tertanda 					= 	'CV Karya Hidup Sentosa<br/>Departemen Personalia';
				$nama_tanda_tangan 			=	'Rajiwan';
				$jabatan_tertanda 			=	'Asisten Kepala Unit General Affairs & Hubungan Kerja';

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

			if($edit == '1')
			{
				$nomor_surat 	=	$nomor_surat;
			}
			else
			{
				$nomorSuratTerakhir 	= 	$this->M_surat->ambilNomorSuratTerakhir($parameterTahun, $parameterBulan, $kode_surat);
			// print_r($nomorSuratTerakhir);
				$nomorSuratTerakhir 	=	$nomorSuratTerakhir[0]['jumlah'];
				$nomorSuratTerakhir 	=	$nomorSuratTerakhir+1;

				if($nomorSuratTerakhir<1000)
				{
					for ($i=strlen($nomorSuratTerakhir); $i < 3; $i++)
					{
						$nomorSuratTerakhir 	=	'0'.$nomorSuratTerakhir;
					}
				}

				$nomor_surat 	=	$nomorSuratTerakhir;
			}
			$kd_jabatan_lama = explode(' - ', $kd_jabatan_lama);
			$kd_jabatan_lama = $kd_jabatan_lama[0];
			$tembusan 	=	$this->personalia->tembusanDuaPihak($kd_jabatan_lama, $seksi_lama, $kd_lokasi_lama, $kd_jabatan_baru, $seksi_baru, $kd_lokasi_baru);


			$tembusan_HTML 	=	'';
			foreach ($tembusan as $nembus)
			{
				$tembusan_HTML	.= '<li>'.ucwords(strtolower($nembus)).'</li>';
				// echo ucwords(strtolower($nembus)).'<br/>';
			}

			// echo 'ini tembus';
			// echo $tembusan_HTML;

			$templateMutasi 			=	$templateMutasi[0]['isi_surat'];

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

			$parameterUbah 				=	array
			(
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
			$parameterDiubah	  		=	array
			(
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
				$seksiBaru,
				$unitBaru,
				$deptBaru,
				$this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime($tanggal_cetak))),
				$tertanda,
				$nama_tanda_tangan,
				$jabatan_tertanda,
				$tembusan_HTML,
				);

			$data['preview'] 	=	str_replace($parameterUbah, $parameterDiubah, $templateMutasi);
			$data['nomor_surat']	=	$nomor_surat;
			if(empty($hal_surat))
			{
				$data['hal_surat']	=	'MUTASI';
			}
			else
			{
				$data['hal_surat']	=	$hal_surat;
			}
			$data['kode_surat']	=	$kode_surat;

			echo json_encode($data);
		}

		public function add()
		{
			$nomor_induk 				=	$this->input->post('txtNoind');
			$seksi_lama 				=	substr($this->input->post('txtKodesieLama'), 0, 9);
			$golongan_pekerjaan_lama 	=	$this->input->post('txtGolonganPekerjaanLama');
			$kd_jabatan_lama 			=	substr($this->input->post('txtKdJabatanLama'), 0, 2);
			// echo $kd_jabatan_lama;exit();
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
			$tempat_makan1_baru         =   $this->input->post('txtTempatMakan1Baru');
			$tempat_makan2_baru         =   $this->input->post('txtTempatMakan2Baru');
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
			$finger_pindah 				=	$this->input->post('finger_pindah');
			$finger_awal 				=	$this->input->post('txtFingerAwal');
			$finger_akhir 				=	$this->input->post('txtFingerGanti');

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

			$inputSuratMutasi			= 	array
			(
				'no_surat'				=>	$nomor_surat,
				'kode' 					=>	$kodeSurat,
				'hal_surat'				=>	$hal_surat,
				'noind'					=>	$nomor_induk,
				'kodesie_lama'  		=>  $seksi_lama,
				'kodesie_baru'  		=>  $seksi_baru,
				'tempat_makan_1_lama' 	=>  rtrim($tempat_makan1_lama),
				'tempat_makan_1_baru' 	=>  rtrim($tempat_makan1_baru),
				'tempat_makan_2_lama' 	=>  rtrim($tempat_makan2_lama),
				'tempat_makan_2_baru' 	=>  rtrim($tempat_makan2_baru),
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
			// echo "<pre>";print_r($inputSuratMutasi);exit();
											// foreach ($inputSuratMutasi as $row) {
											// 	echo $row;

											// }
											// exit();
			$inputFingerMutasi			= 	array
			(
				'no_surat'				=>	$nomor_surat,
				'kode' 					=>	$kodeSurat,
				'hal_surat'				=>	$hal_surat,
				'noind'					=>	$nomor_induk,
				'finger_pindah'			=>	$finger_pindah,
				'finger_awal'			=>  substr($finger_awal, 0,5),
				'lokasifinger_awal'		=>  substr($finger_awal, 7),
				'finger_akhir'  		=>	substr($finger_akhir, 0,5),
				'lokasifinger_akhir'  	=>	substr($finger_akhir, 7),
				'created_date'			=>  $tanggal_cetak,
				'noind_baru'			=>	$noind_baru
				);

			$inputFingerPindah = $this->M_surat->inputFingerMutasi($inputFingerMutasi);
			if($finger_pindah == 't'){
				$this->kirim_email_ict($noind_baru,$nomor_induk,substr($finger_awal, 7),substr($finger_akhir, 7),'MUTASI');
			}
			$this->M_surat->inputSuratMutasi($inputSuratMutasi);
			$bulan_surat = date('m', strtotime($tanggal_cetak));
			$bulan_surat = substr($bulan_surat, 0, 2);
			$tahun_surat = date('Y', strtotime($tanggal_cetak));
											 // echo $tahun_surat;exit();
			$inputNomorSurat 			=	array
			(
				'bulan_surat' 			=>	$bulan_surat,
				'tahun_surat'			=>	$tahun_surat,
				'kode_surat' 			=>	$kodeSurat,
				'nomor_surat'			=>	$nomor_surat,
				'noind' 				=>	$nomor_induk,
				'jenis_surat'			=>	'MUTASI',
				);
			$this->M_surat->inputNomorSurat($inputNomorSurat);

			// echo "<pre>"; print_r($inputSuratMutasi);
			// echo "<pre>"; print_r($inputFingerMutasi);
			// echo "<pre>"; print_r($inputNomorSurat);
			// exit();
			redirect('MasterPekerja/Surat/SuratMutasi');
		}

		public function previewcetak($tanggal, $kode, $no_surat)
		{
			$no_surat_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $no_surat);
			$no_surat_decode 	=	$this->general->dekripsi($no_surat_decode);
			$kodeDekripsi 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $kode);
			$kodeDekripsi = $this->general->dekripsi($kodeDekripsi);
			//insert to t_log
		    $aksi = 'MASTER PEKERJA';
		    $detail = 'Cetak Surat Mutasi Nomor Surat='.$no_surat_decode.'/'.$kodeDekripsi;
		    $this->log_activity->activity_log($aksi, $detail);
		    //
			// echo $no_surat_decode;
			// echo $kodeDekripsi;
			// $waktu = date("d/m/Y h:i:s A T",$tanggal);
			// echo $waktu;
			// exit();

			$data['isiSuratMutasi']		=	$this->M_surat->ambilIsiSuratMutasi($tanggal,$kodeDekripsi,$no_surat_decode);
			// echo $isiSuratMutasi['isi_surat'];
			// print_r($data['isiSuratMutasi']);
			// exit();

			$this->load->library('pdf');
			$pdf 	=	$this->pdf->load();
			$pdf 	=	new mPDF('utf-8', array(216,297), 10, "timesnewroman", 20, 20, 50, 10, 0, 0, 'P');
			// $pdf 	=	new mPDF();

			$filename	=	'SuratMutasi-'.str_replace('/', '_', $no_surat_decode).'.pdf';

			$pdf->AddPage();
			$pdf->WriteHTML($data['isiSuratMutasi'][0]['isi_surat']);
			$pdf->setTitle($filename);
			$pdf->Output($filename, 'I');
			// $this->load->view('MasterPekerja/Surat/Mutasi/V_PDF');

		}

		public function update($tanggal, $kode, $no_surat)
		{
			$no_surat_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $no_surat);
			$no_surat_decode 	=	$this->general->dekripsi($no_surat_decode);

			$kodeDekripsi 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $kode);
			$kodeDekripsi = $this->general->dekripsi($kodeDekripsi);

			$user_id = $this->session->userid;

			$data['Header']			=	'Master Pekerja - Quick ERP';
			$data['Title']			=	'Master Pekerja';
			$data['Menu'] 			= 	'Surat-Surat';
			$data['SubMenuOne'] 	= 	'Surat Mutasi';
			$data['SubMenuTwo'] 	= 	'';
			$data['id']				=	$no_surat;

			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

			$data['editSuratMutasi'] 		= $this->M_surat->editSuratMutasi($tanggal, $kodeDekripsi, $no_surat_decode);
			$data['editFinger'] 		= $this->M_surat->editFinger($tanggal, $kodeDekripsi, $no_surat_decode);
			if (empty($data['editFinger'])) {
			$kosong  = 'tidakada';
				$array = array('finger_pindah' => $kosong, );
				$newaray[] = $array;
				$data['editFinger'] = $newaray;
			}
			$data['DaftarGolongan'] = $this->M_surat->golongan_pekerjaan($tanggal, $kodeDekripsi, $no_surat_decode);

			$data['DaftarLokasiKerja'] = $this->M_surat->DetailLokasiKerja($tanggal, $kodeDekripsi, $no_surat_decode);
			$data['DaftarKdJabatan'] = $this->M_surat->DetailKdJabatan($tanggal, $kodeDekripsi, $no_surat_decode);

			$data['DaftarTempatMakan1'] = $this->M_surat->DetailTempatMakan1($tanggal, $kodeDekripsi, $no_surat_decode);
			$data['DaftarTempatMakan2'] = $this->M_surat->DetailTempatMakan2($tanggal, $kodeDekripsi, $no_surat_decode);

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MasterPekerja/Surat/Mutasi/V_Update',$data);
			$this->load->view('V_Footer',$data);
		}

		public function edit($no_surat)
		{
			// print_r($_POST);exit();
			$no_surat_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $no_surat);
			$no_surat_decode 	=	$this->encrypt->decode($no_surat_decode);

			$nomor_induk 				=	substr($this->input->post('txtNoind'), 0, 5);
			$seksi_lama 				=	substr($this->input->post('txtKodesieLama'), 0, 9);
			$golongan_pekerjaan_lama 	=	$this->input->post('txtGolonganPekerjaanLama');
			$kd_jabatan_lama 			=	substr($this->input->post('txtKdJabatanLama'),0 ,2);
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
			$tempat_makan1_baru         =   $this->input->post('txtTempatMakan1Baru');
			$tempat_makan2_baru         =   $this->input->post('txtTempatMakan2Baru');
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
			$finger_pindah 				=	$this->input->post('finger_pindah');
			$finger_awal 				=	$this->input->post('txtFingerAwal');
			$finger_akhir 				=	$this->input->post('txtFingerGanti');
			$paramater_finger 			=	$this->input->post('txtFingerParameter');

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

			$updateSuratMutasi			= 	array
			(
				'hal_surat'				=>	$hal_surat,
				'noind'					=>	$nomor_induk,
				'kodesie_lama'  		=>  $seksi_lama,
				'kodesie_baru'  		=>  $seksi_baru,
				'tempat_makan_1_lama' 	=>  rtrim($tempat_makan1_lama),
				'tempat_makan_1_baru' 	=>  rtrim($tempat_makan1_baru),
				'tempat_makan_2_lama' 	=>  rtrim($tempat_makan2_lama),
				'tempat_makan_2_baru' 	=>  rtrim($tempat_makan2_baru),
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
			$this->M_surat->updateSuratMutasi($updateSuratMutasi, $nomor_surat, $kodeSurat, $tanggal_cetak_asli);

			if ($paramater_finger == 'tidakada') {
			$inputFingerMutasi			= 	array
			(
				'no_surat'				=>	$nomor_surat,
				'kode' 					=>	$kodeSurat,
				'hal_surat'				=>	$hal_surat,
				'noind'					=>	$nomor_induk,
				'finger_pindah'			=>	$finger_pindah,
				'finger_awal'			=>  substr($finger_awal, 0,5),
				'lokasifinger_awal'		=>  substr($finger_awal, 7),
				'finger_akhir'  		=>	substr($finger_akhir, 0,5),
				'lokasifinger_akhir'  	=>	substr($finger_akhir, 7),
				'created_date'			=>  $tanggal_cetak,
				'noind_baru'			=> 	$noind_baru
				);

			$this->M_surat->inputFingerMutasi($inputFingerMutasi);
			$inputFingerPindah = $this->M_surat->inputFingerMutasi($inputFingerMutasi);
			if($finger_pindah == 't'){
				$this->kirim_email_ict($noind_baru,$nomor_induk,substr($finger_awal, 7),substr($finger_akhir, 7),'MUTASI');
			}
		}else{
			$updateFingerSuratMutasi	= 	array
			(
				'finger_pindah'			=>	$finger_pindah,
				'finger_awal'			=>  substr($finger_awal, 0,5),
				'lokasifinger_awal'		=>  substr($finger_awal, 7),
				'finger_akhir'  		=>	substr($finger_akhir, 0,5),
				'lokasifinger_akhir'  	=>	substr($finger_akhir, 7),
			);

			$updateFingerPindah =  $this->M_surat->updateFingerSuratMutasi($updateFingerSuratMutasi, $nomor_surat, $kodeSurat, $tanggal_cetak_asli);
			if($updateFingerPindah > 0){
				$this->kirim_email_ict($noind_baru,$nomor_induk,substr($finger_awal, 7),substr($finger_akhir, 7),'MUTASI');
			}
		}
			//insert to t_log
			$aksi = 'MASTER PEKERJA';
			$detail = 'Update Surat Mutasi Noind='.$nomor_induk;
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect('MasterPekerja/Surat/SuratMutasi');
		}

		public function delete($tanggal,$kode,$no_surat)
		{
			$no_surat_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $no_surat);
			$no_surat_decode 	=	$this->general->dekripsi($no_surat_decode);
			$kodeDekripsi 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $kode);
			$kodeDekripsi = $this->general->dekripsi($kodeDekripsi);

			$no_surat 				=	intval($no_surat_decode);
			$bulan_surat = date('m', $tanggal);
			$bulan_surat1 = date('Y/m/d', $tanggal);
			$bulan_surat = intval($bulan_surat);

			$this->M_surat->deleteArsipSuratMutasi($bulan_surat, $kodeDekripsi, $no_surat);
			$this->M_surat->deleteSuratMutasi($tanggal,$kodeDekripsi,$no_surat_decode);
			$this->M_surat->deleteFingerSuratMutasi($tanggal,$kodeDekripsi,$no_surat_decode);
			//insert to t_log
		    $aksi = 'MASTER PEKERJA';
		    $detail = 'Delete Arsip, Finger & Surat Mutasi Nomor Surat='.$no_surat_decode.'/'.$kodeDekripsi.'/'.$bulan_surat1;
		    $this->log_activity->activity_log($aksi, $detail);
		    //
			redirect('MasterPekerja/Surat/SuratMutasi');
		}

		public function dapat_kolom()
		{
			echo "<pre>";
			$kolom = $this->M_surat->kolom();
			// print_r($kolom);
			foreach ($kolom as $key) {
				echo '<h4>'.$key['table_schema'].', '.$key['table_name'].'</h4>';
				// echo "<br>";
				$all = $this->M_surat->allt($key['table_schema'], $key['table_name']);
				foreach ($all as $key) {
					echo $key['column_name'];
					echo "<br>";
				}
			}
		}

		public function cronJob()
		{
			exit();
			date_default_timezone_set("Asia/Bangkok");
			$now = date('Y-m-d');
			$yesterday = date('Y-m-d',strtotime(date('Y-m-d') . "-1 days"));
			$cekMutasi = $this->M_surat->cekMutasi($now);
			$row = count($cekMutasi);

			if ($row > 0) {
				foreach ($cekMutasi as $key) {
					$noind 				= $key['noind'];
					$kodesie 			= $key['kodesie_baru'];
					$kodesie_lama 		= $key['kodesie_lama'];
					$jabatan 			= $key['jabatan_baru'];
					$jabatan_lama 		= $key['jabatan_lama'];
					$lokasi 			= $key['lokasi_kerja_baru'];
					$lokasi_lama 		= $key['lokasi_kerja_lama'];
					$golker 			= $key['golkerja_baru'];
					$golker_lama 		= $key['golkerja_lama'];
					$tmakan_1 			= $key['tempat_makan_1_baru'];
					$tmakan_1_lama 		= $key['tempat_makan_1_lama'];
					$tmakan_2 			= $key['tempat_makan_2_baru'];
					$tmakan_2_lama 		= $key['tempat_makan_2_lama'];
					$kd_pkj 			= $key['kd_pkj_baru'];
					$kd_pkj_lama 		= $key['kd_pkj_lama'];
					$kd_jabatan_baru 	= $key['kd_jabatan_baru'];
					$kd_jabatan_lama 	= $key['kd_jabatan_lama'];
					$action_date 		= date('Y-m-d H:i:s');
					$tgl_berlaku 		= $key['tanggal_berlaku'];
					$action 			= 'UPDATE';

					$updateMutasi = $this->M_surat->updateMutasi($noind, $kodesie, $kodesie_lama, $jabatan, $jabatan_lama, $lokasi, $lokasi_lama, $golker, $golker_lama, $tmakan_1 , $tmakan_1_lama, $tmakan_2, $tmakan_2_lama, $kd_pkj, $kd_pkj_lama, $kd_jabatan_baru, $kd_jabatan_lama, $action_date, $tgl_berlaku, $action);
				}
			}

			$cekPerbantuan = $this->M_surat->cekPerbantuan($now);
			$row = count($cekPerbantuan);

			if ($row > 0) {
				foreach ($cekPerbantuan as $key) {
					$noind 				= $key['noind'];
					$kodesie 			= $key['kodesie_baru'];
					$kodesie_lama 		= $key['kodesie_lama'];
					$jabatan 			= $key['jabatan_baru'];
					$jabatan_lama 		= $key['jabatan_lama'];
					$lokasi 			= $key['lokasi_kerja_baru'];
					$lokasi_lama 		= $key['lokasi_kerja_lama'];
					$golker 			= $key['golkerja_baru'];
					$golker_lama 		= $key['golkerja_lama'];
					$tmakan_1 			= $key['tempat_makan_1_baru'];
					$tmakan_1_lama 		= $key['tempat_makan_1_lama'];
					$tmakan_2 			= $key['tempat_makan_2_baru'];
					$tmakan_2_lama 		= $key['tempat_makan_2_lama'];
					$kd_pkj 			= $key['kd_pkj_baru'];
					$kd_pkj_lama 		= $key['kd_pkj_lama'];
					$kd_jabatan_baru 	= $key['kd_jabatan_baru'];
					$kd_jabatan_lama 	= $key['kd_jabatan_lama'];
					$action_date 		= date('Y-m-d H:i:s');
					$tgl_mulai 			= $key['tanggal_mulai_perbantuan'];
					$tgl_selesai 		= $key['tanggal_selesai_perbantuan'];

					$updatePerbantuan = $this->M_surat->updatePerbantuan($noind, $kodesie, $kodesie_lama, $jabatan, $jabatan_lama, $lokasi, $lokasi_lama, $golker, $golker_lama, $tmakan_1, $tmakan_1_lama, $tmakan_2, $tmakan_2_lama, $kd_pkj, $kd_pkj_lama, $kd_jabatan_baru, $kd_jabatan_lama, $action_date, $tgl_mulai, $tgl_selesai);
				}
			}

			$selesaiPerbantuan = $this->M_surat->selesaiPerbantuan($now);
			$row = count($selesaiPerbantuan);

			if ($row > 0) {
				foreach ($arr as $key) {
					$noind = trim($key['fs_noind']);
					$tmakan_1_lama = $key['fs_tempat_makan1_lm'];
					$tmakan_2_lama = $key['fs_tempat_makan2_lm'];

					$updateSelesai = $this->M_surat->updateSelesai($noind, $tmakan_1_lama, $tmakan_2_lama);
				}
			}

			$updateSelesaiPerbantuan = $this->M_surat->updateSelesaiPerbantuan($yesterday);
		}

		function kirim_email_ict($noind_baru,$nomor_induk,$finger_awal,$finger_akhir,$jenis_surat){
			$this->load->library('PHPMailerAutoload');
			$mail = new PHPMailer;
			$mail->isSMTP();
			$mail->SMTPDebug = 0;
			$mail->Debugoutput = 'html';
			$mail->Host = 'm.quick.com';
			$mail->Port = 465;
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl';
			$mail->SMTPOptions = array(
			'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
			));
			$mail->Username = 'no-reply@quick.com';
			$mail->Password = "123456";
			$mail->setFrom('noreply@quick.co.id', 'Notifikasi Pindah Finger');
			$mail->addAddress('kasie_ict_hrd@quick.com', 'Notifikasi Pindah Finger');
			$mail->Subject = 'Notifikasi Pindah Finger';
			$mail->msgHTML("
				Dengan detail sebagai berikut : <br> <br>

				<b>Nomor Induk Baru</b> : $noind_baru<br>
				<b>Nomor Induk</b> : $nomor_induk<br>
				<b>Lokasi Finger Awal</b> : $finger_awal <br>
				<b>Lokasi Finger Akhir</b> : $finger_akhir <br>
				<b>Jenis Surat</b> : $jenis_surat <br><br>

				Atas perhatiannya terima kasih. <br>
				<small style='color: red;'>Perpindahan finger akan terlaksana sesuai Cronjob</small>
				");
			//Replace the plain text body with one created manually
			//send the message, check for errors
			if (!$mail->send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
				//echo "Message sent!";
			}
		}
	}
