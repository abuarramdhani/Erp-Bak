<?php defined('BASEPATH') OR exit('No direct script access allowed');

class C_Daftar extends CI_Controller {

	function __construct() {
        parent::__construct();
		
		$this->load->model('MasterPekerja/Surat/BAPSP3/M_Daftar');
		
		$this->load->library('General');
		$this->load->library('Personalia');
		$this->load->library('encrypt');
		
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
		$data 			=	$this->general->loadHeaderandSidemenu('BAP SP 3 - Master Pekerja - Quick ERP', 'BAP SP 3', 'Surat', 'BAP SP 3');
		$data['view'] 	=	$this->M_Daftar->ambilDataBAP('');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/BAPSP3/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function create()
	{
		$data 			=	$this->general->loadHeaderandSidemenu('BAP SP 3 - Master Pekerja - Quick ERP', 'BAP SP 3', 'Surat', 'BAP SP 3');
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/BAPSP3/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function prosesPreviewBAPSP3()
	{
			$nomor_induk 				=	$this->input->post('txtNoind');
			$alamat_pekerja 			=	$this->input->post('txtAlamatPekerja');
			$jabatan_pekerja 			=	$this->input->post('txtCustomJabatan');
			$nama_perusahaan 			=	$this->input->post('txtNamaPerusahaan');
			$alamat_perusahaan 			=	$this->input->post('txtAlamatPerusahaan');
			$wakil_perusahaan 			=	$this->input->post('txtWakilPerusahaan');
			$tanggal_pemeriksaan 		=	$this->input->post('txtTanggalPemeriksaan');
			$tanggal_pemeriksaan 		=	$this->personalia->konversitanggalIndonesia($tanggal_pemeriksaan);
			$tempat_pemeriksaan 		=	$this->input->post('txtTempatPemeriksaan');
			$keterangan_pekerja 		=	$this->input->post('txtKeteranganPekerja');
			$user_01 					=	$this->input->post('txtUser01');
			$user_02 					=	$this->input->post('txtUser02');
			$tanggal_cetak				=   date('Y-m-d');
			$tanggal_cetak				=   $this->personalia->konversitanggalIndonesia($tanggal_cetak);
			
			$datasp3					=	$this->M_Daftar->ambilDataSP3($nomor_induk);
			$nama_pekerja				=	$datasp3[0]['nama'];
			$tanggal_berlaku_mulai		=	$datasp3[0]['berlaku_mulai'];
			$tanggal_berlaku_mulai		=	$this->personalia->konversitanggalIndonesia($tanggal_berlaku_mulai);
			$tanggal_berlaku_selesai	=	$datasp3[0]['berlaku_selesai'];
			$tanggal_berlaku_selesai	=	$this->personalia->konversitanggalIndonesia($tanggal_berlaku_selesai);
			
			$templateisi 				=	$this->M_Daftar->ambilLayoutSurat();
			$templateisi 				=	$templateisi[0]['isi_surat'];
			
			if(empty($wakil_perusahaan)){
				$wakil_perusahaan		=		"............................................................................................................................................................ ";
			}
			if(empty($tanggal_pemeriksaan)){
				$tanggal_pemeriksaan	=	"............................................................................................................................................................ ";
			}
			if(empty($tempat_pemeriksaan)){
				$tempat_pemeriksaan		=	"............................................................................................................................................................ ";
			}
			if(empty($keterangan_pekerja)){
				$keterangan_pekerja		=	"..............................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................";
			}
			
			$parameterUbah 				=	array(
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
				'[user_02]');
			$parameterDiubah	  		=	array(
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
				$user_02);

			$data['preview'] 			=	str_replace($parameterUbah, $parameterDiubah, $templateisi);
			
			echo json_encode($data);
	}

	public function add()
	{
			$nomor_induk 				=	$this->input->post('txtNoind');
			$alamat_pekerja 			=	$this->input->post('txtAlamatPekerja');
			$jabatan_pekerja 			=	$this->input->post('txtCustomJabatan');
			$nama_perusahaan 			=	$this->input->post('txtNamaPerusahaan');
			$alamat_perusahaan 			=	$this->input->post('txtAlamatPerusahaan');
			$wakil_perusahaan 			=	$this->input->post('txtWakilPerusahaan');
			$tanggal_pemeriksaan 		=	$this->input->post('txtTanggalPemeriksaan');
			$tempat_pemeriksaan 		=	$this->input->post('txtTempatPemeriksaan');
			$keterangan_pekerja 		=	$this->input->post('txtKeteranganPekerja');
			$user_01 					=	$this->input->post('txtUser01');
			$user_02 					=	$this->input->post('txtUser02');
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
				'isi_bap'				=>	$isi_surat);
			$this->M_Daftar->inputBAPSP3($inputdata);
			
			redirect('MasterPekerja/Surat/BAPSP3');
	}

	public function previewcetak($data_id)
	{
			$bap_id 		=	$this->general->dekripsi($data_id);
			$isiBAP			=	$this->M_Daftar->ambilDataBAP($bap_id);
			$filename		=	'BAPSP3-'.str_replace('/', '_', $bap_id).'.pdf';
			
			$this->load->library('pdf');
			$pdf 			=	$this->pdf->load();
			$pdf 			=	new mPDF('utf-8', array(216,297), 10, "timesnewroman", 20, 20, 20, 10, 0, 0, 'P');

			$pdf->AddPage();
			$pdf->WriteHTML($isiBAP[0]['isi_bap']);
			$pdf->setTitle($filename);
			$pdf->Output($filename, 'I');
	}

	public function update($data_id)
	{
			$user_id 								= 	$this->session->userid;
			$bap_id 								=	$this->general->dekripsi($data_id);
			
			$data 									=	$this->general->loadHeaderandSidemenu('BAP SP 3 - Master Pekerja - Quick ERP', 'BAP SP 3', 'Surat', 'BAP SP 3');
			$data['view'] 							=	$this->M_Daftar->ambilDataBAP($bap_id);
			
			if($data['view'][0]['location_code'] == "02"){
				$custom_alamatperusahaan = "Jl. Dudukan, Tuksono, Sentolo, Kulonporgo 55664";
			}else{
				$custom_alamatperusahaan = "Jl. Magelang No. 144 Yogyakarta 55241";
			}
			$data['view'][0]['nama_perusahaan']		=	"CV. Karya Hidup Sentosa";
			$data['view'][0]['alamat_perusahaan']	=	$custom_alamatperusahaan;

			
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MasterPekerja/Surat/BAPSP3/V_Update',$data);
			$this->load->view('V_Footer',$data);
	}

	public function edit($data_id)
	{
			$bap_id 					=	$data_id;
			$nomor_induk 				=	$this->input->post('txtNoind');
			$alamat_pekerja 			=	$this->input->post('txtAlamatPekerja');
			$jabatan_pekerja 			=	$this->input->post('txtCustomJabatan');
			$nama_perusahaan 			=	$this->input->post('txtNamaPerusahaan');
			$alamat_perusahaan 			=	$this->input->post('txtAlamatPerusahaan');
			$wakil_perusahaan 			=	$this->input->post('txtWakilPerusahaan');
			$tanggal_pemeriksaan 		=	$this->input->post('txtTanggalPemeriksaan');
			$tempat_pemeriksaan 		=	$this->input->post('txtTempatPemeriksaan');
			$keterangan_pekerja 		=	$this->input->post('txtKeteranganPekerja');
			$user_01 					=	$this->input->post('txtUser01');
			$user_02 					=	$this->input->post('txtUser02');
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
				'isi_bap'				=>	$isi_surat);
			$this->M_Daftar->updateBAPSP3($bap_id, $updatedata);
			
			redirect('MasterPekerja/Surat/BAPSP3');
	}

	public function delete($data_id)
	{
			$bap_id		=	$this->general->dekripsi($data_id);
			
			$this->M_Daftar->deleteBAPSP3($bap_id);
			redirect('MasterPekerja/Surat/BAPSP3');
	}

}