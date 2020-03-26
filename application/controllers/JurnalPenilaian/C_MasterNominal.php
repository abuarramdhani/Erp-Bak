<?php 
defined('BASEPATH') or exit('No DIrect Access Allowed');
/**
* 
*/
class C_MasterNominal extends CI_COntroller
{
	
	function __construct()
	{
		parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->library('encryption');
		$this->load->library('General');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('JurnalPenilaian/M_nominal');
		  
		if($this->session->userdata('logged_in')!=TRUE) 
		{
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}

		$this->checkSession();
    }
	
	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Setup Nominal';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Setup Nominal';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		
		$data['gk'] = $this->M_nominal->getgk();
		$data['gn'] = $this->M_nominal->getgn();

		// print_r($data['skprestasi']);exist();
		$this->form_validation->Set_rules('required');
		if ($this->form_validation->run() == TRUE) {
			$gk = $this->input->post('txtgolKerja');
			$gn = $this->input->post('txtgolNilai');
			if (isset($gn) and !empty($gn)) {
				$data['nominal'] = $this->M_nominal->getnominal($gk,$gn);
			}else{
				$data['nominal'] = $this->M_nominal->getnominal($gk);
			}
			
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/Nominal/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Edit($id_kenaikan){
		$this->form_validation->Set_rules('required');
		if ($this->form_validation->run() == TRUE) {
			$kenaikan = $this->input->post('txtPengurangNominal');
			$this->M_nominal->updateKenaikanNominal($id_kenaikan,$kenaikan);
			redirect(site_url('PenilaianKinerja/MasterNominal'));
		}else{
			$user_id = $this->session->userid;

			$data['Title'] = 'Setup Nominal';
			$data['Menu'] = 'Master Data';
			$data['SubMenuOne'] = 'Setup Nominal';
			$data['SubMenuTwo'] = '';
			
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

			$data['nominal'] = $this->M_nominal->getNominalByID($id_kenaikan);

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('JurnalPenilaian/MasterData/Nominal/V_edit',$data);
			$this->load->view('V_Footer',$data);
		}
	}

	public function Delete($id_kenaikan){
		$this->M_nominal->deleteKenaikanNominal($id_kenaikan);
		redirect(site_url('PenilaianKinerja/MasterNominal'));
	}
}
?>