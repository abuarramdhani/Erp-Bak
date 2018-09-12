<?php
Defined('BASEPATH')	or exit('No direct script access allowed');

/**
 * 
 */
class C_LimbahKelola extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('upload');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('WasteManagement/MainMenu/M_limbahkelola');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index(){

		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Kiriman Masuk';
		$data['Menu'] = 'Kelola Limbah';
		$data['SubMenuOne'] = 'Kiriman Masuk';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Kiriman'] = $this->M_limbahkelola->getLimbahKirim();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahKelola/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Read($id){
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['Title'] = 'Read Kiriman Masuk';
		$data['Menu'] = 'Kelola Limbah';
		$data['SubMenuOne'] = 'Kiriman Masuk';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['LimbahKirim'] = $this->M_limbahkelola->getLimbahKirimById($plaintext_string);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahKelola/V_read',$data);
		$this->load->view('V_Footer',$data);
	}
	public function Delete($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_limbahkelola->DeleteLimbahKirim($plaintext_string);

		redirect(site_url('WasteManagement/KirimanMasuk'));
	}

	public function Approve($id){

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$berat = $this->input->post('txtberat');
		$this->M_limbahkelola->updateLimbahBerat($berat,$plaintext_string);

		$this->M_limbahkelola->updateLimbahStatus('1',$plaintext_string);

		redirect(site_url('WasteManagement/KirimanMasuk'));
	}

	public function Reject($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_limbahkelola->updateLimbahStatus('2',$plaintext_string);

		redirect(site_url('WasteManagement/KirimanMasuk'));
	}

	public function Pending($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_limbahkelola->updateLimbahStatus('3',$plaintext_string);

		redirect(site_url('WasteManagement/KirimanMasuk'));
	}
}

?>