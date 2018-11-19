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
		// print_r($data['DetailGolongan']);
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
		$data['jabatan']	=	$detailPekerja[0]['jabatan'];
		$data['kd_jabatan']	=	$detailPekerja[0]['kd_jabatan'];
		$data['tempat_makan1']	=	$detailPekerja[0]['tempat_makan1'];
		$data['tempat_makan2']	=	$detailPekerja[0]['tempat_makan2'];


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
		$golongan_pekerjaan_baru	=	$this->input->post('txtGolonganPekerjaanLama');
		$pekerjaan_baru 			=	$this->input->post('txtPekerjaanBaru');
		$kd_jabatan_baru 			=	$this->input->post('txtKdJabatanBaru');
		$jabatan_baru 				=	$this->input->post('txtJabatanBaru');
		$lokasi_kerja_baru          =   $this->input->post('txtLokasiKerjaBaru');
		$tempat_makan1_baru         =   $this->input->post('txtTempatMakan1Baru');
		$tempat_makan2_baru         =   $this->input->post('txtTempatMakan2Baru');

		$tanggal_berlaku 			=	$this->input->post('txtTanggalBerlaku');
		$tanggal_cetak 				=	$this->input->post('txtTanggalCetak');

		$parameterTahunBulanPromosi 	=	date('Ym', strtotime($tanggal_berlaku));

		$templatePromosi 			=	$this->M_promosi->ambilLayoutSuratPromosi();
		$nomorSuratPromosiTerakhir 	= 	$this->M_promosi->ambilNomorSuratPromosiTerakhir($parameterTahunBulanPromosi);
		$nama_pekerja 				=	$this->M_promosi->cariPekerja($nomor_induk);
		$tseksiLama 				=	$this->M_promosi->cariTSeksi($seksi_lama);
		$tseksiBaru 				=	$this->M_promosi->cariTSeksi($seksi_baru);

		$nama_pekerja 				=	$nama_pekerja[0]['nama'];
		$nomorSuratPromosiTerakhir 	=	$nomorSuratPromosiTerakhir[0]['jumlah'];
		$nomorSuratPromosiTerakhir 	=	$nomorSuratPromosiTerakhir+1;

		if($nomorSuratPromosiTerakhir<1000)
		{
			for ($i=strlen($nomorSuratPromosiTerakhir); $i < 3; $i++) 
			{ 
				$nomorSuratPromosiTerakhir 	=	'0'.$nomorSuratPromosiTerakhir;
			}
		}

		$lokasi_kerja_lama 			=	explode(' - ', $lokasi_kerja_lama);
		$lokasi_lama 				=	$lokasi_kerja_lama[1];

		$lokasi_kerja_baru 			=	explode(' - ', $lokasi_kerja_baru);
		$lokasi_baru				=	$lokasi_kerja_baru[1];

		$nama_pekerjaan_lama 		=	'';
		if(empty($pekerjaan_lama))
		{
			$nama_pekerjaan_lama 		= 	'-';
		}
		else
		{
			$pekerjaan_lama 			=	explode(' - ', $pekerjaan_lama);
			$nama_pekerjaan_lama		=	$pekerjaan_lama[0];
		}

		$templatePromosi 			=	$templatePromosi[0]['isi_surat'];

		$parameterUbah 				=	array
										(
											'[no_surat]',
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
											'[tanggal_demosi]'
										);
		$parameterDiubah	  		=	array
										(
											$nomorSuratPromosiTerakhir,
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
											$pekerjaan_baru,
											$golongan_pekerjaan_baru,
											$tseksiBaru[0]['seksi'],
											$tseksiBaru[0]['unit'],
											$tseksiBaru[0]['dept'],
											$lokasi_baru,
											date('d F Y', strtotime($tanggal_cetak)),
											date('d F Y', strtotime($tanggal_berlaku))
										);

		$data['preview'] 	=	str_replace($parameterUbah, $parameterDiubah, $templatePromosi);
		$data['nomorSurat']	=	$nomorSuratPromosiTerakhir;
		$data['halSurat']	=	'Perubahan Ploting Pekerjaan';
		echo json_encode($data);
	}

	public function add()
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
		$golongan_pekerjaan_baru	=	$this->input->post('txtGolonganPekerjaanLama');
		$pekerjaan_baru 			=	$this->input->post('txtPekerjaanBaru');
		$kd_jabatan_baru 			=	$this->input->post('txtKdJabatanBaru');
		$jabatan_baru 				=	$this->input->post('txtJabatanBaru');
		$lokasi_kerja_baru          =   $this->input->post('txtLokasiKerjaBaru');
		$tempat_makan1_baru         =   $this->input->post('txtTempatMakan1Baru');
		$tempat_makan2_baru         =   $this->input->post('txtTempatMakan2Baru');

		$tanggal_berlaku 			=	$this->input->post('txtTanggalBerlaku');
		$tanggal_cetak 				=	$this->input->post('txtTanggalCetak');

		$nomor_surat 				=	$this->input->post('txtNomorSurat');
		$hal_surat 					=	strtoupper($this->input->post('txtHalSurat'));

		$isi_surat 					=	$this->input->post('txaPreview');

		$getNamaNoindBaru 			=	$this->M_promosi->getNamaNoindBaru($nomor_induk);

		$nama 						=	$getNamaNoindBaru[0]['nama'];
		$noind_baru 				=	$getNamaNoindBaru[0]['noind_baru'];

		$lokasi_kerja_lama 			=	explode(' - ', $lokasi_kerja_lama);
		$lokasi_kerja_baru 			=	explode(' - ', $lokasi_kerja_baru);

		$lokasi_lama 				=	$lokasi_kerja_lama[0];
		$lokasi_baru 				=	$lokasi_kerja_baru[0];

		$inputSuratPromosi			= 	array
										(
											'no_surat'				=>	$nomor_surat,
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
										);
		$this->M_promosi->inputSuratPromosi($inputSuratPromosi);
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
		$data['id']				=	$id_isi;
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['editSuratPromosi'] 		=	$this->M_promosi->editSuratPromosi($no_surat_decode);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/LayoutSurat/V_Update',$data);
		$this->load->view('V_Footer',$data);
	}

// 	public function edit($id_isi)
// 	{
// 		$id_isi_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $id_isi);
// 		$id_isi_decode 	=	$this->encrypt->decode($id_isi_decode);

// 		$jenisSurat 	=	$this->input->post('txtJenisSurat', TRUE);
// 		$formatSurat 	=	$this->input->post('txaFormatSurat', TRUE);

// 		$updateLayoutSurat 	=	array(
// 									'jenis_surat'	=>	$jenisSurat,
// 									'isi_surat'		=>	$formatSurat,
// 								);
// 		$this->M_LayoutSurat->updateLayoutSurat($updateLayoutSurat, $id_isi_decode);
// 		redirect('MasterPekerja/Surat/SuratLayout');
// 	}

	public function delete($no_surat)
	{
		$no_surat_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $no_surat);
		$no_surat_decode 	=	$this->encrypt->decode($no_surat_decode);

		$this->M_promosi->deleteSuratPromosi($no_surat_decode);
		redirect('MasterPekerja/Surat/SuratPromosi');

	}
}