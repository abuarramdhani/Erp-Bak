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
			redirect('index');
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

				$config['upload_path']          = './assets/upload/IA/StandarisasiDokumen';
				$config['allowed_types'] 		= '*';
	        	// $config['file_name']		 	= filter_var($_FILES[$inputfile]['name'],  FILTER_SANITIZE_URL, FILTER_SANITIZE_EMAIL);
	        	$config['file_name']		 	= $fileDokumen;
	        	$config['overwrite'] 			= TRUE;


	        	$this->upload->initialize($config);

	    		if ($this->upload->do_upload($inputfile)) 
	    		{
            		$this->upload->data();
	        		$fileDokumen 	= 	$config['file_name'];
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

}

/* End of file C_BusinessProcess.php */
/* Location: ./application/controllers/DocumentStandarization/MainMenu/C_BusinessProcess.php */
/* Generated automatically on 2017-09-14 10:57:11 */