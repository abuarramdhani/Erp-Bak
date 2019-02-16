<?php 
defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class C_SetupPernyataan extends CI_Controller
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
		$this->load->model('PNBPAdministrator/M_setuppernyataan');

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
		$user_id = $this->session->userid;

		$data['Title'] = 'Setup Pernyataan';
		$data['Menu'] = 'Pernyataan';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['pernyataan'] = $this->M_setuppernyataan->getPernyataan();
		

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PNBPAdministrator/SetupPernyataan/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getIndikator(){
		$ind = $this->input->get('term');
		$data = $this->M_setuppernyataan->getIndikator($ind);
		echo json_encode($data);
	}

	public function Create(){
		$pernyataan = $this->input->post('pernyataan');
		$indikator = $this->input->post('indikator');
		$this->M_setuppernyataan->insertPernyataan($pernyataan,$indikator);
		echo "Sukses";
	}

	public function Edit($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$pernyataan = $this->input->post('pernyataan');
		$idaspek = $this->input->post('idaspek');

		$this->M_setuppernyataan->updatePernyataan($pernyataan,$idaspek,$plaintext_string);

		echo "sukses";
	}

	public function Delete($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_setuppernyataan->deletePernyataan($plaintext_string);
		redirect(base_url('PNBP/SetupPernyataan'));
	}
}
?>