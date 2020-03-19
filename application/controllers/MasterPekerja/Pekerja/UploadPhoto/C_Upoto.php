<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class C_Upoto extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');

		$this->load->library('General');
		$this->load->library('Log_Activity');

		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/Pekerja/UploadPhoto/M_upoto');

		$this->checkSession();
	}

	public function checkSession(){
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}

	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data  = $this->general->loadHeaderandSidemenu('Master Pekerja', 'Upload Photo', 'Pekerja', 'Upload Photo', '');

		$data['getInfo'] = $this->M_upoto->getInfo();
		// echo "<pre>";
		// print_r($data['getInfo']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Pekerja/UploadPhoto/V_Index_U',$data);
		$this->load->view('V_Footer',$data);
	}

	public function cekFileFoto(){
		$noInd = $this->input->post('noind');
		$dir    = './assets/img/foto';
        $files2  = array_diff(scandir($dir), array('..', '.'));
        $nama_foto = $noInd.'.JPG';
        if (in_array($nama_foto, $files2)){
        	echo "1";
        }else{
        	echo "0";
        }
	}

	public function doUpload()
	{
		$this->load->library('upload');
		$noInd = $this->input->post('txtNoInd');
		// echo "<pre>";
		$path = $_FILES["txtPhoto"]["name"];
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		// print_r($ext);exit();
		//upload an image options
		$config = array();
		$config['upload_path'] = './assets/img/foto';
		$config['allowed_types'] = '*';
		$config['max_size']      = '1000';
		$config['file_name']     = $noInd;
		$config['overwrite'] 	 = TRUE;	

		////UPDATE LINK PHOTO AND PATH_PHOTO ON DATABASE.QUICK.COM
		$link=$this->M_upoto->insert_link($noInd);

		//UPLOAD
		$this->upload->initialize($config);
		if ($this->upload->do_upload('txtPhoto')) {
        	$this->upload->data();
       		$pat = './assets/img/foto/'.$noInd.'.'.$ext;
			$out = './assets/img/foto/'.$noInd.'.JPG';
			$conv = $this->convertImagetoJPG($pat, $out, 100);
    		if($conv){
    			if ($ext != 'JPG') {
					unlink('./assets/img/foto/'.$noInd.'.'.$ext);
    			}
	    		redirect('MasterPekerja/upload-photo');
    		}
       	} else {
       		$errorinfo = $this->upload->display_errors();
           	echo $errorinfo;
           	exit();
       	}

	}

	function convertImagetoJPG($originalImage, $outputImage, $quality)
	{
    // jpg, png, gif or bmp?
		$ext = exif_imagetype($originalImage);

		if ($ext == 2)
			$imageTmp=imagecreatefromjpeg($originalImage);
		else if ($ext == 3)
			$imageTmp=imagecreatefrompng($originalImage);
		else if ($ext == 1)
			$imageTmp=imagecreatefromgif($originalImage);
		else if ($ext == 6)
			$imageTmp=imagecreatefrombmp($originalImage);
		else{
			unlink($originalImage);
			echo "<h1>Error !!</h1>";
			echo "Jenis Image tidak di kenal";
			exit();
		}

    	// quality is a value from 0 (worst) to 100 (best)
		imagejpeg($imageTmp, $outputImage, $quality);
		imagedestroy($imageTmp);

		return 1;
	}

	public function getFileFoto()
	{
		$noind = $this->input->post('dt');
		$path = './assets/img/not_found.png';
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$dat = file_get_contents($path);
		$base64_default = 'data:image/' . $type . ';base64,' .base64_encode($dat);
		// banyak if :)
		if (empty($noind)) {
			echo $base64_default;
			return;
		}else{
			$data = $this->M_upoto->getInfo($noind);
			if (empty($data)) {
				echo $base64_default;
				return;
			}elseif (empty(trim($data[0]['photo']))) {
				echo $base64_default;
				return;
			}else{
				$link = $data[0]['photo'];
				$headers = get_headers($link, 1);
				if (strpos($headers['Content-Type'], 'image/') !== false) {
				    $path = $link;
					$type = pathinfo($path, PATHINFO_EXTENSION);
					$dat = file_get_contents($path);
					$base64 = 'data:image/' . $type . ';base64,' .base64_encode($dat);
					echo $base64;
					return;
				} else {
				    echo $base64_default;
					return;
				}
			}
		}

	}

}