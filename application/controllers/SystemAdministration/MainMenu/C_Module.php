<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Module extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
      parent::__construct();

      $this->load->helper('form');
      $this->load->helper('url');
      $this->load->helper('html');
      $this->load->library('form_validation');
			$this->load->library('Log_Activity');
          //load the login model
		  $this->load->library('session');
		  $this->load->library('encrypt');
		  $this->load->model('M_index');
		  $this->load->model('SystemAdministration/MainMenu/M_module');
		  $this->load->model('SystemAdministration/MainMenu/M_user');
		  $this->load->model('SystemAdministration/MainMenu/M_responsibility');
		  //$this->load->model('Setting/M_usermenu');
		  //$this->load->library('encryption');
		  $this->checkSession();
    }

	public function checkSession()
	{
		if($this->session->is_logged){
			//redirect('Home');
		}else{
			redirect('');
		}
		if($this->session->userLevel == 'U'){
			redirect('');
		}
	}

	public function index()
	{

		//Data utama yang diperlukan untuk memanggil sebuah halaman
		$user = $this->session->username;
		//$data['HeaderMenu'] = $this->M_index->getSideMenuHeader($user);
		//$data['SubMenu'] = $this->M_index->getSideMenuSubHeader($user);
		$user_id = $this->session->userid;

		$data['Menu'] = 'User';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		//$data['SubMenuOne'] = 'user';

		//Variabel tambahan pada halaman index (data seluruh user)
		$data['AllModule'] = $this->M_module->getModule();

		//Load halaman
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemAdministration/MainMenu/Module/V_Index',$data);
		$this->load->view('V_Footer',$data);

	}

	public function CreateModule()
	{

		//Data utama yang diperlukan untuk memanggil sebuah halaman
		$user_id = $this->session->userid;

		$data['Menu'] = 'Module';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Responsibility'] = $this->M_responsibility->getResponsibility();


		$this->form_validation->set_rules('txtModuleName', 'modulename', 'required');

		$data['title'] = 'Create Module';

		if ($this->form_validation->run() === FALSE)
		{
				//$this->load->view('templates/header', $data);
				//Load halaman
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('SystemAdministration/MainMenu/Module/V_create',$data);
				$this->load->view('V_Footer',$data);
				//$this->load->view('templates/footer');

		}
		else
		{
				$data = array(
					'module_name' 	=> $this->input->post('txtModuleName'),
					'module_image' 	=> $this->input->post('txtMenuIcon'),
					'module_link' 	=> $this->input->post('txtModuleLink'),
					'module_shortname' 	=> $this->input->post('txtShortName'),
					'creation_date'=>  $this->input->post('hdnDate'),
					'created_by'=>  $this->input->post('hdnUser')
				);

				$this->M_module->createModule($data);

				$aksi = 'Create Modul';
				$detail = 'Membuat Modul '.$this->input->post('txtModuleName');
				$this->log_activity->activity_log($aksi, $detail);

				redirect('SystemAdministration/Module');
		}




	}

	public function UpdateModule($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Update Module';
		$data['Menu'] = 'Menu';//menu title
		$data['SubMenuOne'] = 'Menu';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Responsibility'] = $this->M_responsibility->getResponsibility();


		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['UserResponsibility'] = $this->M_user->getUserResponsibility($plaintext_string);
		//echo $plaintext_string;

		$data['Module'] = $this->M_module->getModule($plaintext_string);
		$data['id'] = $id;

		$this->form_validation->set_rules('txtModuleName', 'modulename', 'required');

		if ($this->form_validation->run() === FALSE)
		{
				//$this->load->view('templates/header', $data);

				//Load halaman
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('SystemAdministration/MainMenu/Module/V_update',$data);
				$this->load->view('V_Footer',$data);

		}
		else
		{	$data = array(
					'module_name' 	=> $this->input->post('txtModuleName'),
					'module_image' 	=> $this->input->post('txtMenuIcon'),
					'module_link' 	=> $this->input->post('txtModuleLink'),
					'module_shortname' 	=> $this->input->post('txtShortName'),
					'last_update_date'=>  $this->input->post('hdnDate'),
					'last_updated_by'=>  $this->input->post('hdnUser')
				);

			$this->M_module->updateModule($data,$plaintext_string);

			$aksi = 'Update Modul';
			$detail = 'Update Modul '.$this->input->post('txtModuleName');
			$this->log_activity->activity_log($aksi, $detail);

			redirect('SystemAdministration/Module');
		}
	}


}
