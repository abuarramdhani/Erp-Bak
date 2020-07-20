<?php 
defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class C_SetupIndikator extends CI_Controller
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
		$this->load->model('PNBPAdministrator/M_setupindikator');

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

		$data['Title'] = 'Setup Indikator';
		$data['Menu'] = 'Indikator';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['indikator'] = $this->M_setupindikator->getIndikator();
		

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PNBPAdministrator/SetupIndikator/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getKelompok(){
		$kel = $this->input->get('term');
		$data = $this->M_setupindikator->getKelompok($kel);
		echo json_encode($data);
	}

	public function Create(){
		$kelompok = $this->input->post('kelompok');
		$indikator = $this->input->post('indikator');
		$this->M_setupindikator->insertIndikator($kelompok,$indikator);
		echo "Sukses";
	}

	public function Edit($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$idkelompok = $this->input->post('idkelompok');
		$aspek = $this->input->post('aspek');

		$this->M_setupindikator->updateIndikator($idkelompok,$aspek,$plaintext_string);

		echo "sukses";
	}

	public function Delete($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_setupindikator->deleteIndikator($plaintext_string);
		redirect(base_url('PNBP/SetupIndikator'));
	}
}
?>