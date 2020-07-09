<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class C_Index extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('upload');
		$this->load->library('General');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('session');

		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		$this->load->model('UserManual/M_um');
		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){
		} else {
			redirect('');
		}
	}

	public function index()
	{

		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UserManual/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function upload()
	{

		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['tabel'] = $this->M_um->tabel();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UserManual/V_Upload',$data);
		$this->load->view('V_Footer',$data);
	}

	public function mylist()
	{
		$id = $this->input->post('um_select');
		$keyword 			=	strtoupper($this->input->get('term'));
		$list = $this->M_um->mylist($id, $keyword);
		echo json_encode($list);
	}

	public function add()
	{
		// print_r($_POST);exit();
		$this->load->library('upload');
		$res = $this->input->post('um-select');
		$res = explode(' - ', $res);
		$res = $res[0];
		// echo $res;exit();
		$file = $this->input->post('um-input');
		$file = preg_replace('/[\.\s]+/', '_', $file);
		$user = $this->session->user;

		$config = array();
		$config['upload_path'] 	 = 'assets/upload/um';
		$config['allowed_types'] = 'pdf';
		$config['max_size']      = '20000';
		$config['file_name']     = $file;
		$config['overwrite'] 	 = TRUE;	

		// print_r($config);exit();		

		$this->upload->initialize($config);
		if ($this->upload->do_upload('fileum')) {

			$this->upload->data();
			$this->M_um->add($res, $file, $user);
			$nama = preg_replace('/\s+/', '_', $file);
			chmod('./assets/upload/um/'.$nama.'.pdf', 0777);
			redirect('usermanual/upload');
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
	echo "error";
	exit();
		// echo $res.','.$file;exit();
		// redirect('usermanual/upload');
}

public function delete($id)
{
	$no 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
	$no 	=	$this->general->dekripsi($no);
		// echo $no;exit();
	$nama  = $this->M_um->ceknama($no);
	$nama = $nama[0]['path_file'];
	$nama = preg_replace('/\s+/', '_', $nama);
	// echo $nama;exit();
	unlink('assets/upload/um/'.$nama.'.pdf');
	$this->M_um->delete($no);
	redirect('usermanual/upload');
}

public function edit()
{
	$res = $this->input->post('um-select-modal');
	$res = explode(' - ', $res);
	$res = $res[0];
	$file = $this->input->post('um-input-modal');
	$file = preg_replace('/\s+/', '_', $file);
	$path = $this->input->post('umRes');
	$path = preg_replace('/\s+/', '_', $path);
	$id = $this->input->post('um-id-modal');
	$id 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
	$id 	=	$this->general->dekripsi($id);
		// echo $res.$file.$id;exit();

	$oldDir = FCPATH.'assets/upload/um/'.$path.'.pdf';
	$newDir = FCPATH.'assets/upload/um/'.$file.'.pdf';
	rename($oldDir, $newDir);
	$this->M_um->edit($res, $file, $id);
	redirect('usermanual/upload');
}
}