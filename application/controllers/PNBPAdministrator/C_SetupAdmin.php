<?php 
defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class C_SetupAdmin extends CI_Controller
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
		$this->load->model('PNBPAdministrator/M_setupadmin');

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

		$data['Title'] = 'Setup Admin';
		$data['Menu'] = 'Set Admin';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['user'] = $this->M_setupadmin->getUser();
		

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PNBPAdministrator/SetupAdmin/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getUser(){
		$noind = $this->input->get('term');
		$data = $this->M_setupadmin->getWorker($noind);
		echo json_encode($data);
	}

	public function Create(){
		$user = $this->input->post('user');
		$aktif = $this->input->post('aktif');
		$this->M_setupadmin->insertUser($user,$aktif);
		echo "Sukses";
	}

	public function Edit($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_setupadmin->updateUser($plaintext_string);
		redirect(base_url('PNBP/SetupAdmin'));
	}

	public function Delete($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_setupadmin->deleteUser($plaintext_string);
		redirect(base_url('PNBP/SetupAdmin'));
	}
}
?>