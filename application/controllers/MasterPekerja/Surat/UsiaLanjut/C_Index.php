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
		$this->load->model('MasterPekerja/Surat/UsiaLanjut/M_usialanjut');

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
		// echo "<pre>"; print_r($sisawaktu); exit();

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Surat Pemberitahuan Usia Lanjut';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Pemberitahuan Usia Lanjut';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['DaftarPekerjaUsiaLanjut'] 	=	$this->M_usialanjut->ambilDaftarPekerjaUsiaLanjut();
		$data['DaftarSuratUsiaLanjut'] 	=	$this->M_usialanjut->ambilDaftarSuratUsiaLanjut();
		// echo "<pre>"; print_r($data['DaftarSuratUsiaLanjut']); exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/UsiaLanjut/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}
	public function create($noind)
	{
		// echo "<pre>"; print_r($noind); exit();
		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Surat Pemberitahuan Usia Lanjut';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Pemberitahuan Usia Lanjut';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['PekerjaUsiaLanjut'] 	=	$this->M_usialanjut->ambilPekerjaUsiaLanjut($noind);
		// echo "<pre>"; print_r($data['PekerjaUsiaLanjut']); exit();

		// print_r($data['DaftarKdJabatan']);
		// echo "</pre>";
		// exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/UsiaLanjut/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update($noind)
	{
		// echo "<pre>"; print_r($noind); exit();
		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Surat Pemberitahuan Usia Lanjut';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Pemberitahuan Usia Lanjut';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['PekerjaUsiaLanjut'] 	=	$this->M_usialanjut->ambilPekerjaUsiaLanjut($noind);
		$data['isiSuratUsiaLanjut']		=	$this->M_usialanjut->ambilIsiSuratUsiaLanjut($noind);
		// echo "<pre>"; print_r($data['isiSuratUsiaLanjut']); exit();

		// print_r($data['DaftarKdJabatan']);
		// echo "</pre>";
		// exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/UsiaLanjut/V_Update',$data);
		$this->load->view('V_Footer',$data);
	}

	public function prosesPreviewUsiaLanjut()
	{
		$nama					=	$this->input->post('txtnama');
		$nomor_induk			= 	substr($nama, 0, 5);
		$nama_pekerja			= 	ucwords(strtolower(substr($nama, 7)));
		$kodesie				=	$this->input->post('txtKodesie');
		$seksi					=	strtolower($this->input->post('txtSeksi'));
		$usia					=	$this->input->post('txtUsia');
		$tanggalusia			=	$this->input->post('txtTanggalUsia');
		$sisakerja				=	$this->input->post('txtSisaKerja');
		$aproval1				=	$this->input->post('txtAproval1');
		$aproval2				=	$this->input->post('txtAproval2');
		$gender 				= 	$this->M_usialanjut->ambilgenderpekerja(substr($nama, 0, 5));

		if ($gender == 'P') {
			$gender = 'Ibu.';
		}else{
			$gender = 'Bpk.';
		}
		// echo "<pre>"; print_r($gender); exit();

		$tanggal_berlaku 			=	$this->input->post('txtTanggalBerlaku');
		$tanggal_cetak 				=	$this->input->post('txtTanggalCetak');
		$nomor_surat 				=	$this->input->post('txtNomorSurat');
		$kode_surat 				=	$this->input->post('txtKodeSurat');
		$hal_surat 					=	$this->input->post('txtHalSurat');

		$queryatasan1 = $this->M_usialanjut->ambilseksiatasan(substr($aproval1, 0, 5));
		$queryatasan2 = $this->M_usialanjut->ambilseksiatasan(substr($aproval2, 0, 5));

		$seksiatasan1			=	strtolower($queryatasan1[0]['seksi']);
		if ($seksiatasan1 == '-') {
			$seksiatasan1  		=	strtolower($queryatasan1[0]['unit']);
			$seksiatasan1 		= 'Unit'.' '.ucwords($seksiatasan1);
			if ($seksiatasan1 == 'Unit -') {
				$seksiatasan1  	=	strtolower($queryatasan1[0]['bidang']);
				$seksiatasan1 	= 'Bidang'.' '.ucwords($seksiatasan1);
				if ($seksiatasan1 == 'Bidang -') {
				$seksiatasan1  	=	strtolower($queryatasan1[0]['departemen']);
				$seksiatasan1 	= 'Departemen'.' '.ucwords($seksiatasan1);
				}
			}
		}else{
			$seksiatasan1 = 'Seksi'.' '.ucwords($seksiatasan1);
		}
		$namaatasan1			=	strtolower($queryatasan1[0]['nama']);
		$jabatanatasan1			=	strtolower($queryatasan1[0]['jbtn']);

		$seksiatasan2			=	strtolower($queryatasan2[0]['departemen']);
		$seksiatasan2			=	'Departemen'.' '.ucwords($seksiatasan2);
		$namaatasan2			=	strtolower($queryatasan2[0]['nama']);
		$jabatanatasan2			=	strtolower($queryatasan2[0]['jabatan']);



		$templateUsiaLanjut 		=	$this->M_usialanjut->ambilLayoutSuratUsiaLanjut();

		$templateUsiaLanjut			=	$templateUsiaLanjut[0]['isi_surat'];

		$parameterUbah 				=	array
										(
											'[no_surat]',
											'[kode_surat]',
											'[bulan_cetak]',
											'[tahun_cetak]',
											'[nomor_induk]',
											'[nama_pekerja]',
											'[seksi]',
											'[namaseksi1]',
											'[namaseksi2]',
											'[namaatasan1]',
											'[namaatasan2]',
											'[jabatanatasan1]',
											'[jabatanatasan2]',
											'[usia]',
											'[gender]',
											'[tanggal]',
											'[sisa_waktu]',
											'[tanggal_cetak]',
										);
		$parameterDiubah	  		=	array
										(
											$nomor_surat,
											$kode_surat,
											date('m', strtotime($tanggal_cetak)),
											date('y', strtotime($tanggal_cetak)),
											$nomor_induk,
											$nama_pekerja,
											ucwords($seksi),
											$seksiatasan1,
											$seksiatasan2,
											ucwords($namaatasan1),
											ucwords($namaatasan2),
											ucwords($jabatanatasan1),
											ucwords($jabatanatasan2),
											$usia,
											$gender,
											$this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime($tanggalusia))),
											$sisakerja,
											$this->personalia->konversitanggalIndonesia(date('Y-m-d', strtotime($tanggal_cetak))),
										);

		$data['preview'] 	=	str_replace($parameterUbah, $parameterDiubah, $templateUsiaLanjut);
		$data['nomorSurat']	=	$nomor_surat;
		// $data['halSurat']	=	$hal_surat;

		echo json_encode($data);
	}

	public function add()
	{
		$nama					=	$this->input->post('txtnama');
		$nomor_induk			= 	substr($nama, 0, 5);
		$nama_pekerja			= 	substr($nama, 7);
		$kodesie				=	$this->input->post('txtKodesie');
		$usia					=	$this->input->post('txtUsia');
		$tanggalusia			=	$this->input->post('txtTanggalUsia');
		$sisakerja				=	$this->input->post('txtSisaKerja');
		$aproval1				=	$this->input->post('txtAproval1');
		$aproval2				=	$this->input->post('txtAproval2');
		$tanggalhariini 		=	date('Y-m-d H:i:s');
		// echo "<pre>"; print_r($gender); exit();
		$isi_surat				=	$this->input->post('txaPreview');
		$tanggal_cetak 			=	$this->input->post('txtTanggalCetak');
		$nomor_surat 			=	$this->input->post('txtNomorSurat');
		$kode_surat 			=	$this->input->post('txtKodeSurat');
		$hal_surat 				=	$this->input->post('txtHalSurat');

		$inputSuratUsiaLAnjut			= 	array
										(
											'no_surat'		=>	$nomor_surat,
											'kode' 			=>	$kode_surat,
											'hal_surat'		=>	'USIALANJUT',
											'nama'			=>	$nama_pekerja,
											'noind'  		=>  $nomor_induk,
											'kodesie'  		=>  $kodesie,
											'isi_surat'		=>	$isi_surat,
											'atasan_1'		=>  $aproval1,
											'atasan_2'		=>  $aproval2,
											'tanggal_cetak'	=>	$tanggalhariini
										);
		$this->M_usialanjut->inputSuratUsiaLAnjut($inputSuratUsiaLAnjut);

		$inputNomorSurat 			=	array
										(
											'bulan_surat' 			=>	date('n', strtotime($tanggal_cetak)),
											'tahun_surat' 			=>	date('Y', strtotime($tanggal_cetak)),
											'kode_surat' 			=>	$kode_surat,
											'nomor_surat'			=>	$nomor_surat,
											'noind' 				=>	$nomor_induk,
											'jenis_surat'			=>	'USIALANJUT',
										);
		$this->M_usialanjut->inputNomorSurat($inputNomorSurat);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Create Surat Usia Lanjut Noind='.$nomor_induk;
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect('MasterPekerja/Surat/SuratUsiaLanjut');
	}

	public function edit()
	{
		$nama					=	$this->input->post('txtnama');
		$nomor_induk			= 	substr($nama, 0, 5);
		$nama_pekerja			= 	substr($nama, 7);
		$kodesie				=	$this->input->post('txtKodesie');
		$usia					=	$this->input->post('txtUsia');
		$tanggalusia			=	$this->input->post('txtTanggalUsia');
		$sisakerja				=	$this->input->post('txtSisaKerja');
		$aproval1				=	$this->input->post('txtAproval1');
		$aproval2				=	$this->input->post('txtAproval2');
		$tanggalhariini 		=	date('Y-m-d H:i:s');
		// echo "<pre>"; print_r($gender); exit();
		$isi_surat				=	$this->input->post('txaPreview');
		$tanggal_cetak 			=	$this->input->post('txtTanggalCetak');
		$nomor_surat 			=	$this->input->post('txtNomorSurat');
		$kode_surat 			=	$this->input->post('txtKodeSurat');
		$hal_surat 				=	$this->input->post('txtHalSurat');

		$updateSuratUsiaLanjut			= 	array
										(
											'no_surat'			=>	$nomor_surat,
											'kode' 				=>	$kode_surat,
											'isi_surat'			=>	$isi_surat,
											'atasan_1'			=>  substr($aproval1, 0, 5),
											'atasan_2'			=>  substr($aproval2, 0, 5),
											'terakhir_update'	=>	$tanggalhariini
										);
		$this->M_usialanjut->updateSuratUsiaLanjut($updateSuratUsiaLanjut, $nomor_induk);

		$UpdateNomorSurat 			=	array
										(
											'bulan_surat' 			=>	date('n', strtotime($tanggal_cetak)),
											'tahun_surat' 			=>	date('Y', strtotime($tanggal_cetak)),
											'kode_surat' 			=>	$kode_surat,
											'nomor_surat'			=>	$nomor_surat,
											'noind' 				=>	$nomor_induk
										);
		$this->M_usialanjut->UpdateNomorSurat($UpdateNomorSurat, $nomor_induk);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Update Surat Usia Lanjut Noind='.$nomor_induk;
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect('MasterPekerja/Surat/SuratUsiaLanjut');
	}

	public function previewcetak($noind)
	{
		$data['isiSuratUsiaLanjut']		=	$this->M_usialanjut->ambilIsiSuratUsiaLanjut($noind);
		// echo "<pre>"; print_r($data['isiSuratUsiaLanjut']); exit();
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Cetak PDF Surat Usia Lanjut Noind='.$noind;
		$this->log_activity->activity_log($aksi, $detail);
		//

		$this->load->library('pdf');
		$pdf 	=	$this->pdf->load();
		$pdf 	=	new mPDF('utf-8', array(216,297), 10, "timesnewroman", 20, 20, 50, 30, 0, 0, 'P');
		// $pdf 	=	new mPDF();

		$filename	=	'SuratUsiaLanjut - '.$data['isiSuratUsiaLanjut'][0]['no_surat'].'/'.$data['isiSuratUsiaLanjut'][0]['kode'].'/'.date('m', strtotime($data['isiSuratUsiaLanjut'][0]['tanggal_cetak'])).'/'.date('Y', strtotime($data['isiSuratUsiaLanjut'][0]['tanggal_cetak'])).'.pdf';

		$pdf->AddPage();
		$pdf->WriteHTML($data['isiSuratUsiaLanjut'][0]['isi_surat']);
		$pdf->setTitle($filename);
		$pdf->Output($filename, 'I');
	}

	public function delete($noind)
	{
		$data['isiSuratUsiaLanjut']		=	$this->M_usialanjut->ambilIsiSuratUsiaLanjut($noind);

		$this->M_usialanjut->deleteSuratUsiaLanjut($noind);

		// $no_surat 				=	$data['isiSuratUsiaLanjut'][0]['no_surat'];
		// $kode_surat 			=	$data['isiSuratUsiaLanjut'][0]['kode'];
		// $bulan_surat 			= 	date('n', strtotime($data['isiSuratUsiaLanjut'][0]['tanggal_cetak']));

		// $this->M_usialanjut->deleteArsipSuratUsiaLanjut($bulan_surat, $kode_surat, $no_surat);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Delete Arsip & Surat Usia Lanjut Noind='.$noind;
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect('MasterPekerja/Surat/SuratUsiaLanjut');

	}
}
