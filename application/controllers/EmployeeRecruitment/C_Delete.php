<?php defined('BASEPATH')OR exit('No direct script access allowed');
class C_Delete extends CI_Controller
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->helper('html');

			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->library('encrypt');
			$this->load->library('upload');
			$this->load->library('General');
			$this->load->model('SystemAdministration/MainMenu/M_user');

			  //$this->load->library('Database');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('EmployeeRecruitment/m_testcorrection');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
					  //redirect('');
				$this->session->set_userdata('Responsbility', 'some_value');
			}
		}

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}

	public function index()
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$user_name = $this->session->user;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['result'] = $this->m_testcorrection->getResult();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('EmployeeRecruitment/Delete/V_Index',$data);
			$this->load->view('V_Footer',$data);
		}

	public function delete()
		{
			$id = $this->input->post('id');
			if ($id) :
			foreach ($id as $key) {
				$getIdJwb = $this->m_testcorrection->getIdJwb($key);
				foreach ($getIdJwb as $idj) {
					$this->m_testcorrection->delResult($idj['jawaban_id']);
				}
			$this->m_testcorrection->delByBatch($key);
			}
			endif;
			$this->index();
		}

}