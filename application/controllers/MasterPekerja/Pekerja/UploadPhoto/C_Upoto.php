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

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Pekerja/UploadPhoto/V_Index_U',$data);
		$this->load->view('V_Footer',$data);
	}

	public function cekFileFoto(){
		$noInd = $this->input->post('noind');
		$dir    = './assets/img/photo';
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
		$config['upload_path'] = './assets/img/photo';
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
       		$pat = './assets/img/photo/'.$noInd.'.'.$ext;
			$out = './assets/img/photo/'.$noInd.'.JPG';
			$conv = $this->convertImagetoJPG($pat, $out, 100);
    		if($conv){
				unlink('./assets/img/photo/'.$noInd.'.png');
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
		$exploded = explode('.',$originalImage);
		$ext = $exploded[count($exploded) - 1]; 

		if (preg_match('/jpg|jpeg/i',$ext))
			$imageTmp=imagecreatefromjpeg($originalImage);
		else if (preg_match('/png/i',$ext))
			$imageTmp=imagecreatefrompng($originalImage);
		else if (preg_match('/gif/i',$ext))
			$imageTmp=imagecreatefromgif($originalImage);
		else if (preg_match('/bmp/i',$ext))
			$imageTmp=imagecreatefrombmp($originalImage);
		else
			return 0;

    	// quality is a value from 0 (worst) to 100 (best)
		imagejpeg($imageTmp, $outputImage, $quality);
		imagedestroy($imageTmp);

		return 1;
	}

}