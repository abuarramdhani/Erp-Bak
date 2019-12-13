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

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('upload');
		$this->load->library('General');
		$this->load->library('Personalia');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/Surat/Perbantuan/M_perbantuan');
		$this->load->model('MasterPekerja/Surat/Rotasi/M_Rotasi');

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
		$data['Title']			=	'Surat Perbantuan';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Perbantuan';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['DaftarSuratPerbantuan'] 	=	$this->M_perbantuan->ambilDaftarSuratPerbantuan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Perbantuan/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function create()
	{
		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Surat Perbantuan';
		$data['Menu'] 			= 	'Surat-Surat';
		$data['SubMenuOne'] 	= 	'Surat Perbantuan';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

      	// $data['DaftarPekerja']	=	$this->M_perbantuan->getAmbilPekerjaAktif();
      	// $data['DaftarSeksi']    =   $this->M_perbantuan->getSeksi();
      	// $data['DaftarPekerjaan'] = $this->M_perbantuan->DetailPekerjaan();
		$data['DaftarGolongan'] = $this->M_perbantuan->DetailGolongan();
      	$data['DaftarLokasiKerja'] = $this->M_perbantuan->DetailLokasiKerja();
      	$data['DaftarKdJabatan'] = $this->M_perbantuan->DetailKdJabatan();
      	$data['DaftarTempatMakan1'] = $this->M_perbantuan->DetailTempatMakan1();
      	$data['DaftarTempatMakan2'] = $this->M_perbantuan->DetailTempatMakan2();
		// echo "<pre>";
		// print_r($data['DaftarKdJabatan']);
		// echo "</pre>"; 
		// exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Perbantuan/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function selectKodesie()
	{
		$noind = $this->input->post('noind');
		$detailPekerja 			= $this->M_perbantuan->getDetailPekerja($noind);
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

	public function DaftarPekerja()
	{
		$keywordPencarianPekerja 	=	strtoupper($this->input->get('term'));

		$daftarPekerja 				=	$this->M_perbantuan->cariPekerja($keywordPencarianPekerja);
		echo json_encode($daftarPekerja);
	}

	public function DaftarSeksi()
	{
		$keywordPencarianSeksi	=	strtoupper($this->input->get('term'));

		$daftarseksi 			=	$this->M_perbantuan->cariseksi($keywordPencarianSeksi);
		echo json_encode($daftarseksi);
	}

	public function DaftarPekerjaan()
	{
		$keywordPencarianPekerjaan	=	strtoupper($this->input->get('term'));
		$kodeSeksi 					=	$this->input->get('kode_seksi');

		$daftarPekerjaan 			=	$this->M_perbantuan->cariPekerjaan($keywordPencarianPekerjaan, $kodeSeksi);
		echo json_encode($daftarPekerjaan);
	}

	public function cariGolonganPekerjaan()
	{
		$keywordPencarianGolKerja 	=	strtoupper($this->input->get('term'));
		$kodeStatusKerja 			=	$this->input->get('kode_status_kerja');

		$golonganPekerjaan 			=	$this->M_perbantuan->cariGolonganPekerjaan($keywordPencarianGolKerja, $kodeStatusKerja);
		echo json_encode($golonganPekerjaan);
	}


	public function prosesPreviewPerbantuan()
	{
		$nomor_induk 				=	$this->input->post('txtNoind');
		$seksi_lama 				=	substr($this->input->post('txtKodesieLama'), 0, 9);
		$golongan_pekerjaan_lama 	=	$this->input->post('txtGolonganPekerjaanLama');
		$pekerjaan_lama 		 	=	$this->input->post('txtPekerjaanLama');
		$kd_jabatan_lama 			=	substr($this->input->post('txtKdJabatanLama'),0, 2);
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


		$parameterTahun 	=	date('Y', strtotime($tanggal_cetak));
		$parameterBulan 	=	date('m', strtotime($tanggal_cetak));


		$lokasi_kerja_lama 			=	explode(' - ', $lokasi_kerja_lama);
		$lokasi_lama 				=	$lokasi_kerja_lama[1];
		$kd_lokasi_lama 			=	$lokasi_kerja_lama[0];

		$lokasi_kerja_baru 			=	explode(' - ', $lokasi_kerja_baru);
		$lokasi_baru				=	$lokasi_kerja_baru[1];
		$kd_lokasi_baru 			=	$lokasi_kerja_lama[0];

		$nama_pekerjaan_lama 		=	'';
		$nama_pekerjaan_baru 		=	'';

		$cekStaf 					=	$this->M_perbantuan->cekStaf($nomor_induk);
		if(empty($kode_surat))
		{
			if($cekStaf[0]['status']=='STAF')
			{
				$kode_surat 				=	'DU/KI-B';
			}
			else
			{
				$kode_surat 				=	'PS/KI-N';

			}
		}
		else
		{
			if($cekStaf[0]['status']=='STAF')
			{
				$kode_surat 				=	'DU/KI-B';
			}
			else
			{
				$kode_surat 				=	'PS/KI-N';

			}
			$kode_surat 	=	$kode_surat;
		}

		$stafff = '1';
		if($cekStaf[0]['status']=='STAF')
		{
			$stafff = '1';
		}else{
			$stafff = '0';
		}

		$templateMutasi 			=	$this->M_perbantuan->ambilLayoutSuratPerbantuan($stafff);
		// print_r($templateMutasi);exit();
		$tseksiBaru 				=	$this->M_perbantuan->cariTSeksi($seksi_baru);
		$tseksiLama 				=	$this->M_Rotasi->cariTSeksi($seksi_lama);

		$jabatanSurat 				=	$this->M_perbantuan->cekJabatanSurat($nomor_induk);
		$nama_pekerja 				=	$jabatanSurat[0]['nama'];
		$jabatan_surat 				=	$jabatanSurat[0]['jabatan_surat'];

		$posisiLama 				=	$this->M_perbantuan->ambilPosisi($nomor_induk);
		// print_r($posisiLama);
		$posisi_lama 				=	$posisiLama[0]['posisi'];

		$posisi_baru 				=	'';

		$tertanda 					= 	'';
		$nama_tanda_tangan 			=	'';
		$jabatan_tertanda 			=	'';

		if($cekStaf[0]['status']=='STAF')
		{
			$tertanda 					= 	'CV Karya Hidup Sentosa';
			$nama_tanda_tangan 			=	'Drs. Hendro Wijayanto, Akt';
			$jabatan_tertanda 			=	'Direktur Utama';
			$posisi_baru 				=	'Seksi '.$tseksiBaru['0']['seksi'].' / '.'Unit '.$tseksiBaru[0]['unit'].' / '.'Departemen '.$tseksiBaru[0]['dept'];
		}
		else
		{
			$tertanda 					= 	'CV Karya Hidup Sentosa<br/>Departemen Personalia';
			$nama_tanda_tangan 			=	'Rajiwan';
			$jabatan_tertanda 			=	'Asisten Kepala Unit General Affairs & Hubungan Kerja';

			$cekPekerjaan 				=	$this->M_perbantuan->cekPekerjaan($pekerjaan_baru);
			// $nama_pekerjaan_baru 		=	$cekPekerjaan[0]['pekerjaan'];
			// if(!(empty($nama_pekerjaan_baru)))
			// {
			// 	$nama_pekerjaan_baru 	.=	' / ';
			// }
			// else
			// {
			// 	$nama_pekerjaan_baru 	=	'';
			// }
			$posisi_baru 				=	'Seksi '.$tseksiBaru['0']['seksi'].' / '.'Unit '.$tseksiBaru[0]['unit'].' / '.'Departemen '.$tseksiBaru[0]['dept'];
		}

		// echo $kode_surat;exit();
		if($edit == '1')
			{
				$nomor_surat 	=	$nomor_surat;

			}
			else
			{
				$nomorSuratTerakhir 	= 	$this->M_perbantuan->ambilNomorSuratTerakhir($parameterTahun, $parameterBulan, $kode_surat);
			// print_r($nomorSuratTerakhir);
				$nomorSuratTerakhir 	=	$nomorSuratTerakhir[0]['jumlah'];
				// print_r($nomorSuratTerakhir);
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

		// echo $parameterTahunBulan;

		$tembusan 	=	$this->personalia->tembusanDuaPihak($kd_jabatan_lama, $seksi_lama, $kd_lokasi_lama, $kd_jabatan_baru, $seksi_baru, $kd_lokasi_baru);


		$tembusan_HTML 	=	'';
		foreach ($tembusan as $nembus)
		{
			$tembusan_HTML	.= '<li>'.ucwords(strtolower($nembus)).'</li>';
			// echo ucwords(strtolower($nembus)).'<br/>';
		}

		// echo 'ini tembus';
		// echo $tembusan_HTML;

		$tanggal_berlaku 			=	explode(' - ', $tanggal_berlaku);
		$tanggal_berlaku_awal 		=	$tanggal_berlaku[0];
		$tanggal_berlaku_akhir 		=	$tanggal_berlaku[1];

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
											'[tanggal_berlaku_awal]',
											'[tanggal_berlaku_akhir]',
											'[seksi_baru]',
											'[unit_baru]',
											'[departemen_baru]',
											'[tanggal_cetak]',
											'[tertanda]',
											'[nama_tanda_tangan]',
											'[jabatan_tertanda]',
											'[tembusan]',
											'[seksi_lama]',
											'[unit_lama]',
											'[departemen_lama]',
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
											$this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime($tanggal_berlaku_awal))),
											$this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime($tanggal_berlaku_akhir))),
											$seksiBaru,
											$unitBaru,
											$deptBaru,
											$this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime($tanggal_cetak))),
											$tertanda,
											$nama_tanda_tangan,
											$jabatan_tertanda,
											$tembusan_HTML,
											$tseksiLama[0]['seksi'],
											$tseksiLama[0]['unit'],
											$tseksiLama[0]['dept'],
										);

		$data['preview'] 	=	str_replace($parameterUbah, $parameterDiubah, $templateMutasi);
		$data['nomorSurat']	=	$nomor_surat;
		if(empty($hal_surat))
		{
			$data['halSurat']	=	'PERBANTUAN';
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
		$finger_pindah 				=	$this->input->post('finger_pindah');
		$finger_awal 				=	$this->input->post('txtFingerAwal');

		$finger_akhir 				=	$this->input->post('txtFingerGanti');

		$nomor_surat 				=	$this->input->post('txtNomorSurat');
		$hal_surat 					=	strtoupper($this->input->post('txtHalSurat'));
		$kodeSurat 					=	$this->input->post('txtKodeSurat');

		$isi_surat 					=	$this->input->post('txaPreview');

		$getNamaNoindBaru 			=	$this->M_perbantuan->getNamaNoindBaru($nomor_induk);

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

		$tanggal_berlaku 			= 	explode(' - ', $tanggal_berlaku);
		$tanggal_perbantuan_awal 	=	$tanggal_berlaku[0];
		$tanggal_perbantuan_akhir 	=	$tanggal_berlaku[1];

		$inputSuratPerbantuan			= 	array
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
											'tanggal_cetak'			=>  $tanggal_cetak,
											'nama'					=>	$nama,
											'noind_baru'			=>	$noind_baru,
											'isi_surat'				=>	$isi_surat,
											'kd_pkj_lama'           =>  $kd_pkj_lama,
											'kd_pkj_baru'           =>  $kd_pkj_baru,
											'tanggal_mulai_perbantuan'	=>	$tanggal_perbantuan_awal,
											'tanggal_selesai_perbantuan'=>	$tanggal_perbantuan_akhir,
											'nama_status_lama'		=>  $nama_status_lama,
											'nama_status_baru'		=>  $nama_status_baru,
											'nama_jabatan_upah_lama'=> 	$nama_jabatan_upah_lama,
											'nama_jabatan_upah_baru'=>	$nama_jabatan_upah_baru,
											'kd_status_lama'		=> 	$kd_status_lama,
											'kd_status_baru' 		=>	$kd_status_baru
										);
		$this->M_perbantuan->inputSuratPerbantuan($inputSuratPerbantuan);
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
												'jenis_surat'			=>	'PERBANTUAN',
											);
			$this->M_perbantuan->inputNomorSurat($inputNomorSurat);

		$inputFingerPerbantuan			= 	array
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
			
			$this->M_perbantuan->inputFingerPerbantuan($inputFingerPerbantuan);
			$inputFingerPindah = $this->M_perbantuan->inputFingerPerbantuan($inputFingerPerbantuan);
			if($finger_pindah == 't'){
				$this->kirim_email_ict($noind_baru,$nomor_induk,substr($finger_awal, 7),substr($finger_akhir, 7),'PERBANTUAN');
			}
			
		redirect('MasterPekerja/Surat/SuratPerbantuan');
	}

	public function previewcetak($no_surat)
	{
		$no_surat_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $no_surat);
		$no_surat_decode 	=	$this->encrypt->decode($no_surat_decode);

		$data['isiSuratPerbantuan']		=	$this->M_perbantuan->ambilIsiSuratPerbantuan($no_surat_decode);

		$this->load->library('pdf');
		$pdf 	=	$this->pdf->load();
		$pdf 	=	new mPDF('utf-8', array(216,297), 10, "timesnewroman", 20, 20, 40, 30, 0, 0, 'P');
		// $pdf 	=	new mPDF();

		$filename	=	'SuratPerbantuan-'.str_replace('/', '_', $no_surat_decode).'.pdf';

		$pdf->AddPage();
		$pdf->WriteHTML($data['isiSuratPerbantuan'][0]['isi_surat']);
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
		$data['SubMenuOne'] 	= 	'Surat Perbantuan';
		$data['SubMenuTwo'] 	= 	'';
		$data['id']				=	$no_surat;

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['editSuratPerbantuan'] 		= $this->M_perbantuan->editSuratPerbantuan($no_surat_decode);
		$data['editFinger'] 		= $this->M_perbantuan->editFinger($no_surat_decode);
			if (empty($data['editFinger'])) {
			$kosong  = 'tidakada';
				$array = array('finger_pindah' => $kosong, );
				$newaray[] = $array;
				$data['editFinger'] = $newaray;
			}
		$data['DaftarGolongan'] = $this->M_perbantuan->DetailGolongan();
      	$data['DaftarLokasiKerja'] = $this->M_perbantuan->DetailLokasiKerja();
      	$data['DaftarKdJabatan'] = $this->M_perbantuan->DetailKdJabatan();
      	$data['DaftarTempatMakan1'] = $this->M_perbantuan->DetailTempatMakan1();
      	$data['DaftarTempatMakan2'] = $this->M_perbantuan->DetailTempatMakan2();
		// echo "<pre>";
		// print_r($data['editSuratPerbantuan']);
		// print_r($data['editFinger']);
		// echo "</pre>";
		// exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Perbantuan/V_Update',$data);
		$this->load->view('V_Footer',$data);
	}

	public function edit($no_surat)
	{
		$no_surat_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $no_surat);
		$no_surat_decode 	=	$this->encrypt->decode($no_surat_decode);

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
		$status_lama 				= 	explode(' - ', $status_lama);
		$kd_status_lama				= 	$status_lama[0];
		$nama_status_lama			= 	$status_lama[1];

		$status_baru				= 	$this->input->post('txtStatusjabatanBaru');
		$status_baru 				= 	explode(' - ', $status_baru);
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

		$isi_surat 					=	$this->input->post('txaPreview');

		$getNamaNoindBaru 			=	$this->M_perbantuan->getNamaNoindBaru($nomor_induk);

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

		$tanggal_berlaku 			= 	explode(' - ', $tanggal_berlaku);
		$tanggal_perbantuan_awal 	=	$tanggal_berlaku[0];
		$tanggal_perbantuan_akhir 	=	$tanggal_berlaku[1];

		$updateSuratPerbantuan			= 	array
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
											'tanggal_cetak'			=>  $tanggal_cetak,
											'nama'					=>	$nama,
											'noind_baru'			=>	$noind_baru,
											'isi_surat'				=>	$isi_surat,
											'kd_pkj_lama'           =>  $kd_pkj_lama,
											'kd_pkj_baru'           =>  $kd_pkj_baru,
											'tanggal_mulai_perbantuan'	=>	$tanggal_perbantuan_awal,
											'tanggal_selesai_perbantuan'=>	$tanggal_perbantuan_akhir,
											'nama_status_lama'		=>  $nama_status_lama,
											'nama_status_baru'		=>  $nama_status_baru,
											'nama_jabatan_upah_lama'=> 	$nama_jabatan_upah_lama,
											'nama_jabatan_upah_baru'=>	$nama_jabatan_upah_baru,
											'kd_status_lama'		=> 	$kd_status_lama,
											'kd_status_baru' 		=>	$kd_status_baru
										);
		$this->M_perbantuan->updateSuratPerbantuan($updateSuratPerbantuan, $nomor_surat, $kodeSurat, $tanggal_cetak_asli);

		if ($paramater_finger == 'tidakada') {
			$inputFingerPerbantuan			= 	array
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
			
			$this->M_perbantuan->inputFingerPerbantuan($inputFingerPerbantuan);
			$inputFingerPindah = $this->M_perbantuan->inputFingerPerbantuan($inputFingerPerbantuan);
			if($finger_pindah == 't'){
				$this->kirim_email_ict($noind_baru,$nomor_induk,substr($finger_awal, 7),substr($finger_akhir, 7),'PERBANTUAN');
			}
		}else{
			$updateFingerSuratPerbantuan	= 	array
			(
				'finger_pindah'			=>	$finger_pindah,
				'finger_awal'			=>  substr($finger_awal, 0,5),
				'lokasifinger_awal'		=>  substr($finger_awal, 7),
				'finger_akhir'  		=>	substr($finger_akhir, 0,5),
				'lokasifinger_akhir'  	=>	substr($finger_akhir, 7),
			);

			$updateFingerPindah =  $this->M_perbantuan->updateFingerSuratPerbantuan($updateFingerSuratPerbantuan, $nomor_surat, $kodeSurat, $tanggal_cetak_asli);
			if($updateFingerPindah > 0){
				$this->kirim_email_ict($noind_baru,$nomor_induk,substr($finger_awal, 7),substr($finger_akhir, 7),'PERBANTUAN');
			}
		}
		redirect('MasterPekerja/Surat/SuratPerbantuan');
	}

	public function delete($no_surat)
	{
		$no_surat_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $no_surat);
		$no_surat_decode 	=	$this->encrypt->decode($no_surat_decode);
		// echo $no_surat_decode;exit();

		$this->M_perbantuan->deleteSuratPerbantuan($no_surat_decode);
		$this->M_perbantuan->deleteFingerSuratPerbantuan($no_surat_decode);

		$no_surat_decode 		=	explode('/', $no_surat_decode);
		$no_surat 				=	(int)$no_surat_decode[0];
		$kode_surat 			=	$no_surat_decode[1].'/'.$no_surat_decode[2];
		$tahun 					= 	'20'.$no_surat_decode[4];
		$bulan_surat			=	$no_surat_decode[3];
		// echo $bulan_surat;exit();

		$this->M_perbantuan->deleteArsipSuratPerbantuan($bulan_surat, $tahun, $kode_surat, $no_surat);

		redirect('MasterPekerja/Surat/SuratPerbantuan');

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

				Atas perhatiannya terima kasih.<br>
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
