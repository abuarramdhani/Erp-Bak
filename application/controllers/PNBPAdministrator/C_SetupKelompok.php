<?php 
defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class C_SetupKelompok extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PNBPAdministrator/M_setupkelompok');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Setup Kelompok';
		$data['Menu'] = 'Kelompok';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['kelompok'] = $this->M_setupkelompok->getKelompok();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PNBPAdministrator/SetupKelompok/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create(){
		$kelompok = $this->input->post('kelompok');
		$this->M_setupkelompok->insertKelompok($kelompok);
		echo "Sukses";
	}

	public function Edit($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$kelompok = $this->input->post('kelompok');

		$this->M_setupkelompok->updateKelompok($kelompok,$plaintext_string);

		echo "sukses";
	}

	public function Delete($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_setupkelompok->deleteKelompok($plaintext_string);
		redirect(base_url('PNBP/SetupKelompok'));
	}
}
?>