<?php 
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
* 
*/
class C_Penyesuaian extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('form');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('JurnalPenilaian/M_penyesuaian');

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

		$data['Title'] = 'Penyesuaian Nominal';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Nominal Penyesuaian';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['table'] = $this->M_penyesuaian->getPenyesuaian();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/V_penyesuaiannominal',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Save(){
		$tks = $this->input->post('txtNominalTuksono');
		$mlt = $this->input->post('txtNominalMlati');
		$sbt = $this->input->post('txtSubmit');
		if ($sbt == 'Save Tuksono') {
			$this->M_penyesuaian->updatePenyesuaian($tks,'tuksono');
		}else{
			$this->M_penyesuaian->updatePenyesuaian($mlt,'mlati');
		}

		redirect(base_url('PenilaianKinerja/Penyeseuaian'));
	}
}

?>