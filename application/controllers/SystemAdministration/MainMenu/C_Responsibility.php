<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Responsibility extends CI_Controller
{

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
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('SystemAdministration/MainMenu/M_responsibility');
		$this->load->model('SystemAdministration/MainMenu/M_module');
		$this->load->model('SystemAdministration/MainMenu/M_menugroup');
		$this->load->model('SystemAdministration/MainMenu/M_reportgroup');
		$this->load->model('SystemAdministration/MainMenu/M_organization');
		//$this->load->model('Setting/M_usermenu');
		//$this->load->library('encryption');
		$this->checkSession();
	}

	public function checkSession()
	{
		if ($this->session->is_logged) {
			//redirect('Home');
		} else {
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

		$data['Title'] = 'List Responsibility';
		$data['Menu'] = 'Responsibility';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		//$data['SubMenuOne'] = 'user';

		//Variabel tambahan pada halaman index (data seluruh user)
		$data['AllResponsibility'] = $this->M_responsibility->getResponsibility();

		if ($this->input->get('debug')) {
			echo "<pre>";
			print_r($data['AllResponsibility']);
			die;
		}

		//Load halaman
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('SystemAdministration/MainMenu/Responsibility/V_Index', $data);
		$this->load->view('V_Footer', $data);
	}

	public function CreateResponsibility()
	{

		//Data utama yang diperlukan untuk memanggil sebuah halaman
		$user_id = $this->session->userid;

		$data['Title'] = 'Create Responsibility';
		$data['Menu'] = 'Responsibility';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['Module'] = $this->M_module->getModule();
		$data['MenuGroup'] = $this->M_menugroup->getMenuGroup();
		$data['ReportGroup'] = $this->M_reportgroup->getReportGroup();
		$data['Organization'] = $this->M_organization->getOrganization();

		$this->form_validation->set_rules('txtResponsibilityName', 'responsibilityname', 'required');

		if ($this->form_validation->run() === FALSE) {
			//$this->load->view('templates/header', $data);
			//Load halaman
			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu', $data);
			$this->load->view('SystemAdministration/MainMenu/Responsibility/V_create', $data);
			$this->load->view('V_Footer', $data);
			//$this->load->view('templates/footer');

		} else {
			$data = array(
				'user_group_menu_name' 	=> $this->input->post('txtResponsibilityName'),
				'module_id'				=> $this->input->post('slcModule'),
				'group_menu_id'			=> $this->input->post('slcMenuGroup'),
				'report_group_id'		=> intval($this->input->post('slcRepotGroup')),
				'org_id'				=> $this->input->post('slcOrganization'),
				'creation_date'			=> $this->input->post('hdnDate'),
				'created_by'			=> $this->input->post('hdnUser'),
				'required_javascript'	=> $this->input->post('txtJavascript')
			);

			$this->M_responsibility->setResponsibility($data);

			$aksi = 'Create Responsibility';
			$detail = 'Membuat Responsibility ' . $this->input->post('txtResponsibilityName');
			$this->log_activity->activity_log($aksi, $detail);

			redirect('SystemAdministration/Responsibility');
		}
	}

	public function UpdateResponsibility($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Update Responsibility';
		$data['Menu'] = 'Responsibility'; //menu title
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['Responsibility'] = $this->M_responsibility->getResponsibility($plaintext_string);

		$data['Module'] = $this->M_module->getModule();
		$data['MenuGroup'] = $this->M_menugroup->getMenuGroup();
		$data['ReportGroup'] = $this->M_reportgroup->getReportGroup();
		$data['Organization'] = $this->M_organization->getOrganization();

		$data['id'] = $id;

		$this->form_validation->set_rules('txtResponsibilityName', 'responsibilityname', 'required');

		if ($this->form_validation->run() === FALSE) {
			//$this->load->view('templates/header', $data);

			//Load halaman
			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu', $data);
			$this->load->view('SystemAdministration/MainMenu/Responsibility/V_update', $data);
			$this->load->view('V_Footer', $data);
		} else {
			$data = array(
				'user_group_menu_name' 	=> $this->input->post('txtResponsibilityName'),
				'module_id'				=> $this->input->post('slcModule'),
				'group_menu_id'			=> $this->input->post('slcMenuGroup'),
				'report_group_id'		=> intval($this->input->post('slcRepotGroup')),
				'org_id'				=> $this->input->post('slcOrganization'),
				'last_update_date'		=> $this->input->post('hdnDate'),
				'last_updated_by'		=> $this->input->post('hdnUser'),
				'required_javascript'	=> $this->input->post('txtJavascript')
			);

			$this->M_responsibility->updateResponsibility($data, $plaintext_string);

			$aksi = 'Update Responsibility';
			$detail = 'Update Responsibility ' . $this->input->post('txtResponsibilityName');
			$this->log_activity->activity_log($aksi, $detail);

			redirect('SystemAdministration/Responsibility');
		}
	}
}
