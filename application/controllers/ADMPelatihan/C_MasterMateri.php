<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterMateri extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		//load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		// $this->load->model('ADMPelatihan/M_mastermateri');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
    //HALAMAN INDEX
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Materi Training';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}

		$dir    		= 'assets/upload/ADMPelatihan_Materi_File';
        $files2  		= array_diff(scandir($dir), array('..', '.'));
        $data['file'] 	= $files2;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterMateri/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function upload($toast=FALSE)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Materi Training';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['konfirmasi'] = $toast;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterMateri/V_Upload',$data);
		$this->load->view('V_Footer',$data);
	}

	public function doUpload()
	{
		$this->load->library('upload');
		$nama_materi = $this->input->post('txtNamaMateri');
		
		//upload an image options
		$config = array();
		$config['upload_path'] 	 = 'assets/upload/ADMPelatihan_Materi_File';
		$config['allowed_types'] = 'pdf';
		$config['max_size']      = '20000';
		$config['file_name']     = $nama_materi;
		$config['overwrite'] 	 = TRUE;			

		$this->upload->initialize($config);
		if ($this->upload->do_upload('txtFile')) {
        	$this->upload->data();
			redirect('ADMPelatihan/MasterTrainingMaterial');
        	$toast = "<script type='text/javascript'>
							window.onload = function() {
								$.toaster('Upload Materi Sukses!', name, 'success');
							}
					  </script>";
			$this->upload($toast);
       	} else {
       		$errorinfo = $this->upload->display_errors();
           	echo $errorinfo;
       	}
	}

	public function delete($f)
	{
		unlink('assets/upload/ADMPelatihan_Materi_File/'.$f);
		redirect('ADMPelatihan/MasterTrainingMaterial');
	}

	public function checkSession(){
		if($this->session->is_logged){
		}else{
			redirect('');
		}
	}
}
