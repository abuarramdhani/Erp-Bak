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
		$data['Title']			=	'Surat Rotasi';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Rotasi';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['DaftarSuratRotasi'] 	=	$this->M_Rotasi->ambilDaftarSuratRotasi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Rotasi/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function create()
	{
		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Surat Rotasi';
		$data['Menu'] 			= 	'Surat-Surat';
		$data['SubMenuOne'] 	= 	'Surat Rotasi';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

      	// $data['DaftarPekerja']	=	$this->M_Rotasi->getAmbilPekerjaAktif();
      	// $data['DaftarSeksi']    =   $this->M_Rotasi->getSeksi();
      	// $data['DaftarPekerjaan'] = $this->M_Rotasi->DetailPekerjaan();
		$data['DaftarGolongan'] = $this->M_Rotasi->DetailGolongan();
      	$data['DaftarLokasiKerja'] = $this->M_Rotasi->DetailLokasiKerja();
      	$data['DaftarKdJabatan'] = $this->M_Rotasi->DetailKdJabatan();
      	$data['DaftarTempatMakan1'] = $this->M_Rotasi->DetailTempatMakan1();
      	$data['DaftarTempatMakan2'] = $this->M_Rotasi->DetailTempatMakan2();
		// echo "<pre>";
		// print_r($data['DaftarKdJabatan']);
		// echo "</pre>";
		// exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Rotasi/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function selectKodesie()
	{
		$noind = $this->input->post('noind');
		$detailPekerja 			= $this->M_Rotasi->getDetailPekerja($noind);
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

		$daftarPekerja 				=	$this->M_Rotasi->cariPekerja($keywordPencarianPekerja);
		echo json_encode($daftarPekerja);
	}

	public function DaftarSeksi()
	{
		$keywordPencarianSeksi	=	strtoupper($this->input->get('term'));

		$daftarseksi 			=	$this->M_Rotasi->cariseksi($keywordPencarianSeksi);
		echo json_encode($daftarseksi);
	}

	public function DaftarPekerjaan()
	{
		$keywordPencarianPekerjaan	=	strtoupper($this->input->get('term'));
		$kodeSeksi 					=	$this->input->get('kode_seksi');

		$daftarPekerjaan 			=	$this->M_Rotasi->cariPekerjaan($keywordPencarianPekerjaan, $kodeSeksi);
		echo json_encode($daftarPekerjaan);
	}

	public function cariGolonganPekerjaan()
	{
		$keywordPencarianGolKerja 	=	strtoupper($this->input->get('term'));
		$kodeStatusKerja 			=	$this->input->get('kode_status_kerja');

		$golonganPekerjaan 			=	$this->M_Rotasi->cariGolonganPekerjaan($keywordPencarianGolKerja, $kodeStatusKerja);
		echo json_encode($golonganPekerjaan);
	}

	public function prosesPreviewRotasi()
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
		$edit					 	=   $this->input->post('txtStatusEdit');


		$parameterTahun 	=	date('Y', strtotime($tanggal_cetak));
		$parameterBulan 	=	date('m', strtotime($tanggal_cetak));



		$lokasi_kerja_lama 			=	explode(' - ', $lokasi_kerja_lama);
		$lokasi_lama 				=	$lokasi_kerja_lama[1];

		$lokasi_kerja_baru 			=	explode(' - ', $lokasi_kerja_baru);
		$lokasi_baru				=	$lokasi_kerja_baru[1];
		$kd_lokasi_lama 			=	$lokasi_kerja_lama[0];
		$kd_lokasi_baru 			=	$lokasi_kerja_lama[0];

		$posisiLama 				=	$this->M_Rotasi->ambilPosisi($nomor_induk);
		$posisi_lama 				=	$posisiLama[0]['posisi'];
		$cekStaf 					=	$this->M_Rotasi->cekStaf($nomor_induk);

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

		$stafff = '1';
		if($cekStaf[0]['status']=='STAF')
		{
			$stafff = '1';
		}else{
			$stafff = '0';
		}

		$templateRotasi 			=	$this->M_Rotasi->ambilLayoutSuratRotasi($stafff);
		$nama_pekerja 				=	$this->M_Rotasi->cariPekerja($nomor_induk);
		$tseksiLama 				=	$this->M_Rotasi->cariTSeksi($seksi_lama);
		$tseksiBaru 				=	$this->M_Rotasi->cariTSeksi($seksi_baru);
		$pekerjaan_baru 			=	$this->M_Rotasi->cariPekerjaan('', $pekerjaan_baru);

		$nama_pekerjaan_baru 		=	$pekerjaan_baru[0]['pekerjaan'];

		$nama_pekerja 				=	$nama_pekerja[0]['nama'];

		if($edit == '1')
			{
				$nomor_surat 	=	$nomor_surat;
			}
			else
			{
				$nomorSuratTerakhir 	= 	$this->M_Rotasi->ambilNomorSuratTerakhir($parameterTahun, $parameterBulan, $kode_surat);
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
		$tembusan 	=	$this->personalia->tembusanDuaPihak($kd_jabatan_lama, $seksi_lama, $kd_lokasi_lama, $kd_jabatan_baru, $seksi_baru, $kd_lokasi_baru);


		$tembusan_HTML 	=	'';
		foreach ($tembusan as $nembus)
		{
			$tembusan_HTML	.= '<li>'.ucwords(strtolower($nembus)).'</li>';
			// echo ucwords(strtolower($nembus)).'<br/>';
		}


		$templateRotasi 			=	$templateRotasi[0]['isi_surat'];

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

		$seksiNew = ' ';
		$unitNew = ' ';
		$deptNew = ' ';
		if (strlen($tseksiBaru[0]['seksi']) > 2) {
			$seksiNew = ' '.$tseksiBaru[0]['seksi'].' / ';
		}
		if (strlen($tseksiBaru[0]['unit']) > 2) {
			$unitNew = $tseksiBaru[0]['unit'].' / ';
		}
		if (strlen($tseksiBaru[0]['dept']) > 2) {
			$deptNew = $tseksiBaru[0]['dept'];
		}

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
											'[tanggal_rotasi]',
											'[tembusan]',
											'[seksibaru]',
											'[unitbaru]',
											'[deptbaru]',
											'[seksiNew]',
											'[unitNew]',
											'[deptNew]'
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
											date('d F Y', strtotime($tanggal_cetak)),
											date('d F Y', strtotime($tanggal_berlaku)),
											$tembusan_HTML,
											$seksiBaru,
											$unitBaru,
											$deptBaru,
											$seksiNew,
											$unitNew,
											$deptNew,
										);

		$data['preview'] 	=	str_replace($parameterUbah, $parameterDiubah, $templateRotasi);
		$data['nomorSurat']	=	$nomor_surat;
		if(empty($hal_surat))
		{
			$data['halSurat']	=	'ROTASI';
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
		$kd_jabatan_lama			= 	substr($kd_jabatan_lama, 0,2);
		// echo $kd_jabatan_lama;exit();
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

		$getNamaNoindBaru 			=	$this->M_Rotasi->getNamaNoindBaru($nomor_induk);

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

		$inputSuratRotasi			= 	array
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
											'cetak'					=> 'false',
										);
		$this->M_Rotasi->inputSuratRotasi($inputSuratRotasi);

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
												'jenis_surat'			=>	'ROTASI',
											);
			$this->M_Rotasi->inputNomorSurat($inputNomorSurat);
		redirect('MasterPekerja/Surat/SuratRotasi');
	}

	public function previewcetak($no_surat)
	{
		$no_surat_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $no_surat);
		$no_surat_decode 	=	$this->encrypt->decode($no_surat_decode);

		$data['isiSuratRotasi']		=	$this->M_Rotasi->ambilIsiSuratRotasi($no_surat_decode);

		$this->load->library('pdf');
		$pdf 	=	$this->pdf->load();
		$pdf 	=	new mPDF('utf-8', array(216,297), 10, "timesnewroman", 20, 20, 40, 40, 0, 0, 'P');
		// $pdf 	=	new mPDF();

		$filename	=	'SuratRotasi-'.str_replace('/', '_', $no_surat_decode).'.pdf';

		$pdf->AddPage();
		$pdf->WriteHTML($data['isiSuratRotasi'][0]['isi_surat']);
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
		$data['SubMenuOne'] 	= 	'Surat Rotasi';
		$data['SubMenuTwo'] 	= 	'';
		$data['id']				=	$no_surat;

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['editSuratRotasi'] 		= $this->M_Rotasi->editSuratRotasi($no_surat_decode);
		$data['DaftarGolongan'] = $this->M_Rotasi->DetailGolongan();
      	$data['DaftarLokasiKerja'] = $this->M_Rotasi->DetailLokasiKerja();
      	$data['DaftarKdJabatan'] = $this->M_Rotasi->DetailKdJabatan();
      	$data['DaftarTempatMakan1'] = $this->M_Rotasi->DetailTempatMakan1();
      	$data['DaftarTempatMakan2'] = $this->M_Rotasi->DetailTempatMakan2();
		// echo "<pre>";
		// print_r($data['editSuratRotasi']);
		// echo $no_surat_decode;
		// echo "</pre>";
		// exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Rotasi/V_Update',$data);
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
		$golongan_pekerjaan_baru	=	$this->input->post('txtGolonganPekerjaanLama');
		$kd_jabatan_baru 			=	$this->input->post('txtKdJabatanBaru');
		$jabatan_baru 				=	$this->input->post('txtJabatanBaru');
		$lokasi_kerja_baru          =   $this->input->post('txtLokasiKerjaBaru');
		// $tempat_makan1_baru         =   $this->input->post('txtTempatMakan1Baru');
		// $tempat_makan2_baru         =   $this->input->post('txtTempatMakan2Baru');
		$pekerjaan_baru             =   $this->input->post('txtPekerjaanBaru');

		$tanggal_berlaku 			=	$this->input->post('txtTanggalBerlaku');
		$tanggal_cetak 				=	$this->input->post('txtTanggalCetak');
		$tanggal_cetak_asli			=	$this->input->post('txtTanggalCetakAsli');

		$nomor_surat 				=	$this->input->post('txtNomorSurat');
		$hal_surat 					=	strtoupper($this->input->post('txtHalSurat'));
		$kodeSurat 					=	$this->input->post('txtKodeSurat');
		$staf					 	=   $this->input->post('txtStatusStaf');

		$isi_surat 					=	$this->input->post('txaPreview');

		$getNamaNoindBaru 			=	$this->M_Rotasi->getNamaNoindBaru($nomor_induk);

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

		$updateSuratRotasi			= 	array
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
										);
		$this->M_Rotasi->updateSuratRotasi($updateSuratRotasi, $nomor_surat, $kodeSurat, $tanggal_cetak_asli);
		redirect('MasterPekerja/Surat/SuratRotasi');
	}

	public function delete($no_surat)
	{
		$no_surat_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $no_surat);
		$no_surat_decode 	=	$this->encrypt->decode($no_surat_decode);

		$this->M_Rotasi->deleteSuratRotasi($no_surat_decode);
		redirect('MasterPekerja/Surat/SuratRotasi');

	}
}
