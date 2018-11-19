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
		$this->load->model('MasterPekerja/Surat/Promosi/M_promosi');

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
		$data['Title']			=	'Surat Promosi';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Promosi';
		$data['SubMenuTwo'] 	= 	'';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['DaftarSuratPromosi'] 	=	$this->M_promosi->ambilDaftarSuratPromosi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Promosi/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function create()
	{
		$user_id = $this->session->userid;
		
		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Surat Promosi';
		$data['Menu'] 			= 	'Surat-Surat';
		$data['SubMenuOne'] 	= 	'Surat Promosi';
		$data['SubMenuTwo'] 	= 	'';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
      	// $data['DaftarPekerja']	=	$this->M_promosi->getAmbilPekerjaAktif();
      	// $data['DaftarSeksi']    =   $this->M_promosi->getSeksi();
      	// $data['DaftarPekerjaan'] = $this->M_promosi->DetailPekerjaan();
		$data['DaftarGolongan'] = $this->M_promosi->DetailGolongan();
      	$data['DaftarLokasiKerja'] = $this->M_promosi->DetailLokasiKerja();
      	$data['DaftarKdJabatan'] = $this->M_promosi->DetailKdJabatan();
      	$data['DaftarTempatMakan1'] = $this->M_promosi->DetailTempatMakan1();
      	$data['DaftarTempatMakan2'] = $this->M_promosi->DetailTempatMakan2();
		// echo "<pre>";
		// print_r($data['DaftarKdJabatan']);
		// echo "</pre>";
		// exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Promosi/V_Create',$data);
		$this->load->view('V_Footer',$data);		
	}

	public function selectKodesie()
	{
		$noind = $this->input->post('noind');
		$detailPekerja 			= $this->M_promosi->getDetailPekerja($noind);
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

		$daftarPekerja 				=	$this->M_promosi->cariPekerja($keywordPencarianPekerja);
		echo json_encode($daftarPekerja);
	}

	public function DaftarSeksi()
	{
		$keywordPencarianSeksi	=	strtoupper($this->input->get('term'));

		$daftarseksi 			=	$this->M_promosi->cariseksi($keywordPencarianSeksi);
		echo json_encode($daftarseksi);
	}

	public function DaftarPekerjaan()
	{
		$keywordPencarianPekerjaan	=	strtoupper($this->input->get('term'));
		$kodeSeksi 					=	$this->input->get('kode_seksi');

		$daftarPekerjaan 			=	$this->M_promosi->cariPekerjaan($keywordPencarianPekerjaan, $kodeSeksi);
		echo json_encode($daftarPekerjaan);
	}

	public function cariGolonganPekerjaan()
	{
		$keywordPencarianGolKerja 	=	strtoupper($this->input->get('term'));
		$kodeStatusKerja 			=	$this->input->get('kode_status_kerja');

		$golonganPekerjaan 			=	$this->M_promosi->cariGolonganPekerjaan($keywordPencarianGolKerja, $kodeStatusKerja);
		echo json_encode($golonganPekerjaan);
	}

	public function prosesPreviewPromosi()
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


		$parameterTahunBulanPromosi 	=	date('Y-m', strtotime($tanggal_cetak));

		

		$lokasi_kerja_lama 			=	explode(' - ', $lokasi_kerja_lama);
		$lokasi_lama 				=	$lokasi_kerja_lama[1];
		$kd_lokasi_lama 			=	$lokasi_kerja_lama[0];

		$lokasi_kerja_baru 			=	explode(' - ', $lokasi_kerja_baru);
		$lokasi_baru				=	$lokasi_kerja_baru[1];
		$kd_lokasi_baru 			=	$lokasi_kerja_lama[0];

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

		$nama_pekerjaan_baru 		=	'';
		if(empty($kode_surat))
		{
			if((int) $kd_jabatan_lama<17)
			{
				$kode_surat 	=	'DU/KI-A';
			}
			else
			{
				$kode_surat 	=	'PS/KI-N';
			}
		}
		else
		{
			$kode_surat 	=	$kode_surat;
		}

		$templatePromosi 			=	$this->M_promosi->ambilLayoutSuratPromosi($kode_surat);
		$nama_pekerja 				=	$this->M_promosi->cariPekerja($nomor_induk);
		$tseksiLama 				=	$this->M_promosi->cariTSeksi($seksi_lama);
		$tseksiBaru 				=	$this->M_promosi->cariTSeksi($seksi_baru);
		

		$nama_pekerja 				=	$nama_pekerja[0]['nama'];

		if(empty($pekerjaan_baru))
		{
			$nama_pekerjaan_baru 		= 	'-';
		}
		else
		{
			$pekerjaan_baru 			=	$this->M_promosi->cariPekerjaan('', $pekerjaan_baru);

			$nama_pekerjaan_baru 		=	$pekerjaan_baru[0]['pekerjaan'];
		}

		if(empty($nomor_surat))
		{

			$nomorSuratPromosiTerakhir 	= 	$this->M_promosi->ambilNomorSuratPromosiTerakhir($parameterTahunBulanPromosi, $kode_surat);
			$nomorSuratPromosiTerakhir 	=	$nomorSuratPromosiTerakhir[0]['jumlah'];
			$nomorSuratPromosiTerakhir 	=	$nomorSuratPromosiTerakhir+1;

			if($nomorSuratPromosiTerakhir<1000)
			{
				for ($i=strlen($nomorSuratPromosiTerakhir); $i < 3; $i++) 
				{ 
					$nomorSuratPromosiTerakhir 	=	'0'.$nomorSuratPromosiTerakhir;
				}
			}

			$nomor_surat 	=	$nomorSuratPromosiTerakhir;
		}
		else
		{
			$nomor_surat 	=	$nomor_surat;
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

		$templatePromosi 			=	$templatePromosi[0]['isi_surat'];

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
											'[tanggal_promosi]',
											'[tembusan]'
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
											$tseksiBaru[0]['seksi'],
											$tseksiBaru[0]['unit'],
											$tseksiBaru[0]['dept'],
											$lokasi_baru,
											$this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime($tanggal_cetak))),
											$this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime($tanggal_berlaku))),
											$tembusan_HTML
										);

		$data['preview'] 	=	str_replace($parameterUbah, $parameterDiubah, $templatePromosi);
		$data['nomorSurat']	=	$nomor_surat;
		if(empty($hal_surat))
		{
			$data['halSurat']	=	'Promosi';
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
		$tempat_makan1_baru         =   $this->input->post('txtTempatMakan1Baru');
		$tempat_makan2_baru         =   $this->input->post('txtTempatMakan2Baru');
		$pekerjaan_baru             =   $this->input->post('txtPekerjaanBaru');

		$tanggal_berlaku 			=	$this->input->post('txtTanggalBerlaku');
		$tanggal_cetak 				=	$this->input->post('txtTanggalCetak');

		$nomor_surat 				=	$this->input->post('txtNomorSurat');
		$hal_surat 					=	strtoupper($this->input->post('txtHalSurat'));
		$kodeSurat 					=	$this->input->post('txtKodeSurat');
		$staf					 	=   $this->input->post('txtStatusStaf');

		$isi_surat 					=	$this->input->post('txaPreview');

		$getNamaNoindBaru 			=	$this->M_promosi->getNamaNoindBaru($nomor_induk);

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

		$inputSuratPromosi			= 	array
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
										);
		$this->M_promosi->inputSuratPromosi($inputSuratPromosi);

		$inputNomorSurat 			=	array
										(
											'bulan_surat' 			=>	date('Y-m', strtotime($tanggal_cetak)),
											'kode_surat' 			=>	$kodeSurat,
											'nomor_surat'			=>	$nomor_surat,
											'noind' 				=>	$nomor_induk,
											'jenis_surat'			=>	'PROMOSI',
										);
		$this->M_promosi->inputNomorSurat($inputNomorSurat);
		redirect('MasterPekerja/Surat/SuratPromosi');
	}

	public function previewcetak($no_surat)
	{
		$no_surat_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $no_surat);
		$no_surat_decode 	=	$this->encrypt->decode($no_surat_decode);

		$data['isiSuratPromosi']		=	$this->M_promosi->ambilIsiSuratPromosi($no_surat_decode);

		$this->load->library('pdf');
		$pdf 	=	$this->pdf->load();
		$pdf 	=	new mPDF('utf-8', array(216,297), 10, "timesnewroman", 20, 20, 40, 40, 0, 0, 'P');
		// $pdf 	=	new mPDF();

		$filename	=	'SuratPromosi-'.str_replace('/', '_', $no_surat_decode).'.pdf';

		$pdf->AddPage();
		$pdf->WriteHTML($data['isiSuratPromosi'][0]['isi_surat']);

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
		$data['SubMenuOne'] 	= 	'Surat Promosi';
		$data['SubMenuTwo'] 	= 	'';
		$data['id']				=	$no_surat;
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['editSuratPromosi'] 		= $this->M_promosi->editSuratPromosi($no_surat_decode);
		$data['DaftarGolongan'] = $this->M_promosi->DetailGolongan();
      	$data['DaftarLokasiKerja'] = $this->M_promosi->DetailLokasiKerja();
      	$data['DaftarKdJabatan'] = $this->M_promosi->DetailKdJabatan();
      	$data['DaftarTempatMakan1'] = $this->M_promosi->DetailTempatMakan1();
      	$data['DaftarTempatMakan2'] = $this->M_promosi->DetailTempatMakan2();
		// echo "<pre>";
		// print_r($data['editSuratPromosi']);
		// echo "</pre>";
		// exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Promosi/V_Update',$data);
		$this->load->view('V_Footer',$data);
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
		$tempat_makan1_baru         =   $this->input->post('txtTempatMakan1Baru');
		$tempat_makan2_baru         =   $this->input->post('txtTempatMakan2Baru');
		$pekerjaan_baru             =   $this->input->post('txtPekerjaanBaru');

		$tanggal_berlaku 			=	$this->input->post('txtTanggalBerlaku');
		$tanggal_cetak 				=	$this->input->post('txtTanggalCetak');

		$nomor_surat 				=	$this->input->post('txtNomorSurat');
		$hal_surat 					=	strtoupper($this->input->post('txtHalSurat'));
		$kodeSurat 					=	$this->input->post('txtKodeSurat');
		$staf					 	=   $this->input->post('txtStatusStaf');

		$isi_surat 					=	$this->input->post('txaPreview');

		$getNamaNoindBaru 			=	$this->M_promosi->getNamaNoindBaru($nomor_induk);

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

		$updateSuratPromosi			= 	array
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
										);
		$this->M_promosi->updateSuratPromosi($updateSuratPromosi, $nomor_surat, $kodeSurat);
		redirect('MasterPekerja/Surat/SuratPromosi');
	}

	public function delete($no_surat)
	{
		$no_surat_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $no_surat);
		$no_surat_decode 	=	$this->encrypt->decode($no_surat_decode);

		$this->M_promosi->deleteSuratPromosi($no_surat_decode);

		$no_surat_decode 		=	explode('/', $no_surat_decode);
		$no_surat 				=	(int)$no_surat_decode[0];
		$kode_surat 			=	$no_surat_decode[1].'/'.$no_surat_decode[2];
		$bulan_surat 			= 	'20'.$no_surat_decode[4].'-'.$no_surat_decode[3];

		$this->M_promosi->deleteArsipSuratPromosi($bulan_surat, $kode_surat, $no_surat);

		redirect('MasterPekerja/Surat/SuratPromosi');

	}
}