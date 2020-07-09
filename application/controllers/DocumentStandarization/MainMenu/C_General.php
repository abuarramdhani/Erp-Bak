<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_General extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('DocumentStandarization/MainMenu/M_businessprocess');
		$this->load->model('DocumentStandarization/MainMenu/M_general');

		$this->load->library('upload');

		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	// General Function ---------------------------start---
	public function ambilPekerja($list)
	{
		if($list=='all')
		{
			$data['pekerja'] 	= 	$this->M_general->ambilSemuaPekerja();
		}
		elseif($list=='min-kasie')
		{
			$data['pekerja'] 	= 	$this->M_general->ambilPekerjaMinKasie();
		}
		return $data['pekerja'];
	}

	public function konversiTanggalkeDatabase($tanggal, $format)
	{
		// Ubah tanggal jika menggunakan separator '/'
		$tanggal 	= 	str_replace('/', '-', $tanggal);
		// strtotime
		$tanggal 	= 	strtotime($tanggal);
		// Ubah tanggal sesuai format
		if($format=='tanggal')
		{
			$tanggal 	= 	date('Y-m-d', $tanggal);
		}
		elseif($format=='datetime' || $format=='timestamp')
		{
			$tanggal 	= 	date('Y-m-d H:i:s', $tanggal);
		}

		return $tanggal;
	}

	public function ambilWaktuEksekusi()
	{
		$tanggalEksekusi 	= 	date('Y-m-d H:i:s');
		return $tanggalEksekusi;
	}

	public function uploadDokumen($inputfile, $namafile = FALSE)
	{
		$fileDokumen = null;
		$errorinfo = null;
		// echo 'bisa';
		// exit();

    		if(!empty($_FILES[$inputfile]['name']))
    		{
    			$direktoriDokumen						= $_FILES[$inputfile]['name'];
    			$ekstensiDokumen						= pathinfo($direktoriDokumen,PATHINFO_EXTENSION);
    			$fileDokumen							= $namafile.".".$ekstensiDokumen;



    			// $nama_STNK 							= filter_var($_FILES[$inputfile]['name'],  FILTER_SANITIZE_URL, FILTER_SANITIZE_EMAIL);

				$config['upload_path']          = './assets/upload/PengembanganSistem/StandarisasiDokumen';
				$config['allowed_types'] 		= '*';
	        	// $config['file_name']		 	= filter_var($_FILES[$inputfile]['name'],  FILTER_SANITIZE_URL, FILTER_SANITIZE_EMAIL);
	        	$config['file_name']		 	= $fileDokumen;
	        	$config['overwrite'] 			= TRUE;


	        	$this->upload->initialize($config);

	    		if ($this->upload->do_upload($inputfile))
	    		{
            		$this->upload->data();
	        		$fileDokumen 	= 	$config['file_name'];
					//insert to sys.log_activity
					$aksi = 'DOC STANDARIZATION';
					$detail = "Upload Document filename=$fileDokumen";
					$this->log_activity->activity_log($aksi, $detail);
					//
        		}
        		else
        		{

        			$errorinfo = $this->upload->display_errors();
        		}
        	}
        	if(is_null($errorinfo)!=TRUE)
        	{
        		echo $errorinfo;
        		exit();
        	}

		return 	$fileDokumen;
	}
	// General Function -----------------------------end---

	/* LIST DATA */

	public function cariPekerjaPembuat()
	{

		$keywordPekerjaPembuat		= 	strtoupper($this->input->get('term'));

		$resultPekerjaPembuat 		= 	$this->M_general->ambilPekerjaPembuat($keywordPekerjaPembuat);
		echo json_encode($resultPekerjaPembuat);
	}

	public function cariPekerjaPemeriksa1()
	{

		$keywordPekerjaPemeriksa1		= 	strtoupper($this->input->get('term'));

		$resultPekerjaPemeriksa1 		= 	$this->M_general->ambilPekerjaPemeriksa1($keywordPekerjaPemeriksa1);
		echo json_encode($resultPekerjaPemeriksa1);
	}

	public function cariPekerjaPemeriksa2()
	{

		$keywordPekerjaPemeriksa2		= 	strtoupper($this->input->get('term'));

		$resultPekerjaPemeriksa2 		= 	$this->M_general->ambilPekerjaPemeriksa2($keywordPekerjaPemeriksa2);
		echo json_encode($resultPekerjaPemeriksa2);
	}

	public function cariPekerjaPemberiKeputusan()
	{

		$keywordPekerjaPemberiKeputusan		= 	strtoupper($this->input->get('term'));

		$resultPekerjaPemberiKeputusan 		= 	$this->M_general->ambilPekerjaPemberiKeputusan($keywordPekerjaPemberiKeputusan);
		echo json_encode($resultPekerjaPemberiKeputusan);
	}

	public function cariPekerjaAktifBerdasarHirarki()
	{
		$kodesie 				= 	substr(($this->input->get('kodesie')), 0, 7);
		$keywordPekerja 		= 	strtoupper($this->input->get('term'));

		$daftarNamaPekerja		= 	$this->M_general->ambilPekerjaAktifBerdasarHirarki($kodesie, $keywordPekerja);
		echo json_encode($daftarNamaPekerja);
	}

	public function cariDepartemen()
	{
		$keywordDepartemen 					= 	strtoupper($this->input->get('term'));

		$resultDepartemen 					= 	$this->M_general->ambilDepartemen($keywordDepartemen);
		echo json_encode($resultDepartemen);
	}

	public function cariBidang()
	{
		$keywordBidang 						= 	strtoupper($this->input->get('term'));
		$departemen 						=  	substr(($this->input->get('departemen')), 0, 2);
		$resultBidang 						= 	$this->M_general->ambilBidang($keywordBidang, $departemen);
		echo json_encode($resultBidang);
	}

	public function cariUnit()
	{
		$keywordUnit 						= 	strtoupper($this->input->get('term'));
		$departemen 						= 	substr(($this->input->get('bidang')), 0, 2);
		$bidang 							= 	substr(($this->input->get('bidang')), 2, 2);

		$resultUnit 						= 	$this->M_general->ambilUnit($keywordUnit, $departemen, $bidang);
		echo json_encode($resultUnit);
	}

	public function cariSeksi()
	{
		$keywordSeksi 						= 	strtoupper($this->input->get('term'));
		$departemen 						= 	substr(($this->input->get('unit')), 0, 2);
		$bidang 							= 	substr(($this->input->get('unit')), 2, 2);
		$unit 								= 	substr(($this->input->get('unit')), 4, 2);

		$resultSeksi						= 	$this->M_general->ambilSeksi($keywordSeksi, $departemen, $bidang, $unit);
		echo json_encode($resultSeksi);
	}

	public function cariJobDescription()
	{

		$keywordJobDescription		= 	strtoupper($this->input->get('term'));

		$resultJobDescription 		= 	$this->M_general->ambilJobDescription($keywordJobDescription);
		echo json_encode($resultJobDescription);
	}

	public function ambilSeksidariJobDesc()
	{
		$jobDescription 		= 	$this->input->post('jd');
		$kodesieJobDescription 	= 	$this->M_general->ambilKodesieJobDescription($jobDescription);

		$hirarki				= 	$this->M_general->ambilHirarki($kodesieJobDescription);
		echo json_encode($hirarki);
	}

	public function cariJobDesc()
	{
		$kodesie 				= 	substr(($this->input->get('kodesie')), 0, 7);
		$keywordJobDescription 	= 	strtoupper($this->input->get('term'));

		$daftarJobDescription	= 	$this->M_general->ambilJobDescriptionBerdasarKodesie($kodesie, $keywordJobDescription);
		echo json_encode($daftarJobDescription);
	}

	public function cariDokumenJobDescription()
	{
		$keywordDokumenJobDescription 	= 	strtoupper($this->input->get('term'));
		$resultDokumenJobDescription 	= 	$this->M_general->ambilDokumenJobDescription($keywordDokumenJobDescription);

		echo json_encode($resultDokumenJobDescription);
	}

}

/* End of file C_BusinessProcess.php */
/* Location: ./application/controllers/DocumentStandarization/MainMenu/C_BusinessProcess.php */
/* Generated automatically on 2017-09-14 10:57:11 */
