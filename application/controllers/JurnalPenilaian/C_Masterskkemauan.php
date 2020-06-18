<?php 
defined('BASEPATH') or exit('No DIrect Access Allowed');
/**
* 
*/
class C_Masterskkemauan extends CI_COntroller
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
		$this->load->model('JurnalPenilaian/M_skkemauan');
		  
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

		$data['Title'] = 'SK Kemauan';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'SK Kemauan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['skkemauan'] = $this->M_skkemauan->getskkemauan();

		// print_r($data['skprestasi']);exist();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/SKKemauan/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create(){
		$this->form_validation->Set_rules('required');
		if ($this->form_validation->run() == TRUE) {
			// print_r($_POST);
			$bbb = $this->input->post('txtBulanBatasBawahKemauan');
			$bba = $this->input->post('txtBulanBatasAtasKemauan');
			$p 	 = $this->input->post('txtPengurangKemauan');

			$this->M_skkemauan->insertSKKemauan($bbb,$bba,$p);
			redirect(site_url('PenilaianKinerja/Masterskkemauan/'));
		}else{
			$user_id = $this->session->userid;

			$data['Title'] = 'SK Kemauan';
			$data['Menu'] = 'Master Data';
			$data['SubMenuOne'] = 'SK Kemauan';
			$data['SubMenuTwo'] = '';
			
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

			// $data['skkemauan'] = $this->M_skkemauan->getskkemauan();

			// print_r($data['skprestasi']);exist();

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('JurnalPenilaian/MasterData/SKKemauan/V_create',$data);
			$this->load->view('V_Footer',$data);
		}
	}

	public function Edit($id){
		$this->form_validation->Set_rules('required');
		if ($this->form_validation->run() == TRUE) {
			// print_r($_POST);
			$p 	 = $this->input->post('txtPengurangKemauan');

			$this->M_skkemauan->updateSKKemauan($id,$p);
			redirect(site_url('PenilaianKinerja/Masterskkemauan/'));
		}else{
			$user_id = $this->session->userid;

			$data['Title'] = 'SK Kemauan';
			$data['Menu'] = 'Master Data';
			$data['SubMenuOne'] = 'SK Kemauan';
			$data['SubMenuTwo'] = '';
			
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

			$data['rekap'] = $this->M_skkemauan->getskkemauanByID($id);

			// print_r($data['skprestasi']);exist();

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('JurnalPenilaian/MasterData/SKKemauan/V_edit',$data);
			$this->load->view('V_Footer',$data);
		}
	}

	public function Delete($id){
		$this->M_skkemauan->deleteSKKemauan($id);
		redirect(site_url('PenilaianKinerja/Masterskkemauan/'));
	}
}
?>