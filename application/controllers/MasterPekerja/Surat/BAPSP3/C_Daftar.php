<?php defined('BASEPATH') or exit('No direct script access allowed');

class C_Daftar extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('MasterPekerja/Surat/BAPSP3/M_Daftar');
		$this->load->library('General');
		$this->load->library('Log_Activity');
		$this->load->library('Personalia');
		$this->load->library('encrypt');
		if (!($this->session->is_logged)) {
			redirect('');
		}
	}

	public function index()
	{
		$data =	$this->general->loadHeaderandSidemenu('BAP SP 3 - Master Pekerja - Quick ERP', 'BAP SP 3', 'Surat', 'BAP SP 3');
		$data['view'] =	$this->M_Daftar->ambilDataBAP();
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPekerja/Surat/BAPSP3/V_Index', $data);
		$this->load->view('V_Footer', $data);
	}

	public function create()
	{
		$data = $this->general->loadHeaderandSidemenu('BAP SP 3 - Master Pekerja - Quick ERP', 'BAP SP 3', 'Surat', 'BAP SP 3');
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPekerja/Surat/BAPSP3/V_Create', $data);
		$this->load->view('V_Footer', $data);
	}

	public function getPokokMasalahData()
	{
		$nomor_induk = $this->input->post('cmbNoind');
		$text_pokok_masalah = $this->input->post('txtPokokMasalah');
		$data = $this->M_Daftar->ambilDataSP3($nomor_induk);
		// WHAT ?? undefined $datasp3 variable
		$nama_pekerja =	$datasp3[0]['nama'];
		$tanggal_berlaku_mulai = $this->personalia->konversitanggalIndonesia($data[0]['berlaku_mulai']);
		$tanggal_berlaku_selesai = $this->personalia->konversitanggalIndonesia($data[0]['berlaku_selesai']);
		$key = array(
			'[nama_pekerja]',
			'[noind_pekerja]',
			'[tgl_berlaku_mulai]',
			'[tgl_berlaku_selesai]'
		);
		$value = array(
			$nama_pekerja,
			$nomor_induk,
			$tanggal_berlaku_mulai,
			$tanggal_berlaku_selesai
		);
		$data['result'] = str_replace($key, $value, $text_pokok_masalah);
		echo json_encode($data);
	}

	public function prosesPreviewBAPSP3()
	{
		$nomor_induk = trim($this->input->post('cmbNoind'));
		$alamat_pekerja = trim($this->input->post('txtAlamatPekerja'));
		$jabatan_pekerja = trim($this->input->post('txtCustomJabatan'));
		$nama_perusahaan = trim($this->input->post('txtNamaPerusahaan'));
		$alamat_perusahaan = trim($this->input->post('txtAlamatPerusahaan'));
		$wakil_perusahaan = empty($this->input->post('cmbWakilPerusahaan')) ? null : $this->M_Daftar->getPekerjaData($this->input->post('cmbWakilPerusahaan'))->nama;
		$tanggal_pemeriksaan = empty($this->input->post('txtTanggalPemeriksaan')) ? null : trim($this->input->post('txtTanggalPemeriksaan'));
		if (!empty($tanggal_pemeriksaan)) {
			$tanggal_pemeriksaan = $this->personalia->konversitanggalIndonesia($tanggal_pemeriksaan);
		}
		$tempat_pemeriksaan = trim($this->input->post('txtTempatPemeriksaan'));
		$keterangan_pekerja = trim($this->input->post('txtKeteranganPekerja'));
		$user_01 = empty($this->input->post('cmbTandaTangan1')) ? '' : $this->M_Daftar->getPekerjaData($this->input->post('cmbTandaTangan1'))->nama;
		$user_02 = empty($this->input->post('cmbTandaTangan2')) ? '' : $this->M_Daftar->getPekerjaData($this->input->post('cmbTandaTangan2'))->nama;
		// $tanggal_cetak = date('Y-m-d');
		// $tanggal_cetak = $this->personalia->konversitanggalIndonesia($tanggal_cetak);
		$tanggal_cetak = '..........................................';
		$datasp3 = $this->M_Daftar->ambilDataSP3($nomor_induk);
		$nama_pekerja = $datasp3[0]['nama'];
		$tanggal_berlaku_mulai = $datasp3[0]['berlaku_mulai'];
		$tanggal_berlaku_mulai = $this->personalia->konversitanggalIndonesia($tanggal_berlaku_mulai);
		$tanggal_berlaku_selesai = $datasp3[0]['berlaku_selesai'];
		$tanggal_berlaku_selesai = $this->personalia->konversitanggalIndonesia($tanggal_berlaku_selesai);
		$template = $this->M_Daftar->ambilLayoutSurat()[0]['isi_surat'];
		if (empty($wakil_perusahaan)) {
			$wakil_perusahaan =	'...............................................................................................................';
		}
		if (empty($tanggal_pemeriksaan)) {
			$tanggal_pemeriksaan = '................................................................................................................';
		}
		if (empty($tempat_pemeriksaan)) {
			$tempat_pemeriksaan = '...............................................................................................................';
		}
		if (empty($keterangan_pekerja)) {
			$keterangan_pekerja = '.....................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................';
		}
		$key = array(
			'[noind_pekerja]',
			'[nama_pekerja]',
			'[jabatan_pekerja]',
			'[alamat_pekerja]',
			'[nama_perusahaan]',
			'[alamat_perusahaan]',
			'[wakil_perusahaan]',
			'[tanggal_pemeriksaan]',
			'[tempat_pemeriksaan]',
			'[tgl_berlaku_mulai]',
			'[tgl_berlaku_selesai]',
			'[keterangan_pekerja]',
			'[tgl_cetak]',
			'[user_01]',
			'[user_02]'
		);
		$value = array(
			$nomor_induk,
			$nama_pekerja,
			$jabatan_pekerja,
			$alamat_pekerja,
			$nama_perusahaan,
			$alamat_perusahaan,
			$wakil_perusahaan,
			$tanggal_pemeriksaan,
			$tempat_pemeriksaan,
			$tanggal_berlaku_mulai,
			$tanggal_berlaku_selesai,
			$keterangan_pekerja,
			$tanggal_cetak,
			$user_01,
			$user_02
		);
		$data['template'] = $template;
		$data['wakil'] = $wakil_perusahaan;
		$data['preview'] = str_replace($key, $value, $template);
		echo json_encode($data);
	}

	public function add()
	{
		$nomor_induk 				=	$this->input->post('cmbNoind');
		$alamat_pekerja 			=	$this->input->post('txtAlamatPekerja');
		$jabatan_pekerja 			=	$this->input->post('txtCustomJabatan');
		$nama_perusahaan 			=	$this->input->post('txtNamaPerusahaan');
		$alamat_perusahaan 			=	$this->input->post('txtAlamatPerusahaan');
		$wakil_perusahaan 			=	empty($this->input->post('cmbWakilPerusahaan')) ? null : $this->input->post('cmbWakilPerusahaan');
		$tanggal_pemeriksaan 		=	empty($this->input->post('txtTanggalPemeriksaan')) ? null : $this->input->post('txtTanggalPemeriksaan');
		$tempat_pemeriksaan 		=	empty($this->input->post('txtTempatPemeriksaan')) ? null : $this->input->post('txtTempatPemeriksaan');
		$keterangan_pekerja 		=	empty($this->input->post('txtKeteranganPekerja')) ? null : $this->input->post('txtKeteranganPekerja');
		$user_01 					=	empty($this->input->post('cmbTandaTangan1')) ? null : $this->input->post('cmbTandaTangan1');
		$user_02 					=	empty($this->input->post('cmbTandaTangan2')) ? null : $this->input->post('cmbTandaTangan2');
		$tanggal_cetak				=   date('Y-m-d');
		$isi_surat 					=	$this->input->post('txaPreview');
		$inputdata					= 	array(
			'noind'					=>	$nomor_induk,
			'alamat'				=>	$alamat_pekerja,
			'pekerjaan_jabatan'		=>	$jabatan_pekerja,
			'wakil_perusahaan'		=>	$wakil_perusahaan,
			'tgl_pemeriksaan'		=>	$tanggal_pemeriksaan,
			'tempat_pemeriksaan'	=>	$tempat_pemeriksaan,
			'keterangan_pekerja'	=>	$keterangan_pekerja,
			'tgl'					=>	$tanggal_cetak,
			'pihak_a'				=>	$user_01,
			'pihak_b'				=>	$user_02,
			'isi_bap'				=>	$isi_surat
		);
		$this->M_Daftar->inputBAPSP3($inputdata);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Create BAP SP 3 Noind=' . $nomor_induk;
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect('MasterPekerja/Surat/BAPSP3');
	}

	public function previewcetak($data_id)
	{
		$this->load->library('pdf');
		$bap_id 	=	$this->general->dekripsi($data_id);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Cetak PDF BAP SP 3 ID=' . $bap_id;
		$this->log_activity->activity_log($aksi, $detail);
		//
		$isiBAP		=	$this->M_Daftar->ambilDataBAP($bap_id);
		$filename	=	'BAPSP3-' . str_replace('/', '_', $bap_id) . '.pdf';
		$pdf 		=	$this->pdf->load();
		$pdf 		=	new mPDF('utf-8', array(216, 297), 10, "timesnewroman", 20, 20, 20, 10, 0, 0, 'P');
		$pdf->AddPage();
		$pdf->WriteHTML($isiBAP[0]['isi_bap']);
		$pdf->setTitle($filename);
		$pdf->Output($filename, 'I');
	}

	public function update($data_id)
	{
		$user_id	=	$this->session->userid;
		$bap_id		=	$this->general->dekripsi($data_id);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Update BAP SP 3 ID=' . $bap_id;
		$this->log_activity->activity_log($aksi, $detail);
		//
		$data		=	$this->general->loadHeaderandSidemenu('BAP SP 3 - Master Pekerja - Quick ERP', 'BAP SP 3', 'Surat', 'BAP SP 3');
		$data['view'] = $this->M_Daftar->ambilDataBAP($bap_id);
		$data['wakilPerusahaan'] = $this->M_Daftar->getPekerjaData($data['view'][0]['wakil_perusahaan']);
		$data['tandaTangan1'] = empty($data['view'][0]['pihak_a']) ? null : $this->M_Daftar->getPekerjaData($data['view'][0]['pihak_a']);
		$data['tandaTangan2'] = empty($data['view'][0]['pihak_b']) ? null : $this->M_Daftar->getPekerjaData($data['view'][0]['pihak_b']);
		if ($data['view'][0]['location_code'] == "02") {
			$custom_alamatperusahaan = "Jl. Dudukan, Tuksono, Sentolo, Kulonporgo 55664";
		} else {
			$custom_alamatperusahaan = "Jl. Magelang No. 144 Yogyakarta 55241";
		}
		$data['view'][0]['nama_perusahaan']		=	"CV. Karya Hidup Sentosa";
		$data['view'][0]['alamat_perusahaan']	=	$custom_alamatperusahaan;
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPekerja/Surat/BAPSP3/V_Update', $data);
		$this->load->view('V_Footer', $data);
	}

	public function edit($data_id)
	{
		$bap_id 					=	$data_id;
		$nomor_induk 				=	$this->input->post('cmbNoind');
		$alamat_pekerja 			=	$this->input->post('txtAlamatPekerja');
		$jabatan_pekerja 			=	$this->input->post('txtCustomJabatan');
		$nama_perusahaan 			=	$this->input->post('txtNamaPerusahaan');
		$alamat_perusahaan 			=	$this->input->post('txtAlamatPerusahaan');
		$wakil_perusahaan 			=	empty($this->input->post('cmbWakilPerusahaan')) ? null : $this->M_Daftar->getPekerjaData($this->input->post('cmbWakilPerusahaan'))->nama;
		$tanggal_pemeriksaan 		=	empty($this->input->post('txtTanggalPemeriksaan')) ? null : $this->input->post('txtTanggalPemeriksaan');
		$tempat_pemeriksaan 		=	empty($this->input->post('txtTempatPemeriksaan')) ? null : $this->input->post('txtTempatPemeriksaan');
		$keterangan_pekerja 		=	empty($this->input->post('txtKeteranganPekerja')) ? null : $this->input->post('txtKeteranganPekerja');
		$user_01 					=	empty($this->input->post('cmbTandaTangan1')) ? null : $this->M_Daftar->getPekerjaData($this->input->post('cmbTandaTangan1'))->nama;
		$user_02 					=	empty($this->input->post('cmbTandaTangan2')) ? null : $this->M_Daftar->getPekerjaData($this->input->post('cmbTandaTangan2'))->nama;
		$tanggal_cetak				=   date('Y-m-d');
		$isi_surat 					=	$this->input->post('txaPreview');
		$updatedata					= 	array(
			'noind'					=>	$nomor_induk,
			'alamat'				=>	$alamat_pekerja,
			'pekerjaan_jabatan'		=>	$jabatan_pekerja,
			'wakil_perusahaan'		=>	$wakil_perusahaan,
			'tgl_pemeriksaan'		=>	$tanggal_pemeriksaan,
			'tempat_pemeriksaan'	=>	$tempat_pemeriksaan,
			'keterangan_pekerja'	=>	$keterangan_pekerja,
			'tgl'					=>	$tanggal_cetak,
			'pihak_a'				=>	$user_01,
			'pihak_b'				=>	$user_02,
			'isi_bap'				=>	$isi_surat
		);
		$this->M_Daftar->updateBAPSP3($bap_id, $updatedata);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Edit BAP SP 3 ID =' . $bap_id . ' Noind=' . $nomor_induk;
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect('MasterPekerja/Surat/BAPSP3');
	}

	public function delete($data_id)
	{
		$bap_id		=	$this->general->dekripsi($data_id);
		$this->M_Daftar->deleteBAPSP3($bap_id);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Delete BAP SP 3 ID=' . $bap_id;
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect('MasterPekerja/Surat/BAPSP3');
	}
}
