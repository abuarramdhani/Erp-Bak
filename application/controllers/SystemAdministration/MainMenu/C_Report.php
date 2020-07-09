<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Report extends CI_Controller {

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
		  $this->load->model('SystemAdministration/MainMenu/M_report');
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
	}

	public function index()
	{

		//Data utama yang diperlukan untuk memanggil sebuah halaman
		$user = $this->session->username;
		//$data['HeaderMenu'] = $this->M_index->getSideMenuHeader($user);
		//$data['SubMenu'] = $this->M_index->getSideMenuSubHeader($user);
		$user_id = $this->session->userid;

		$data['Title'] = 'List Report';
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Report';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		//$data['SubMenuOne'] = 'user';

		//Variabel tambahan pada halaman index (data seluruh user)
		$data['AllReport'] = $this->M_report->getReport();

		//Load halaman
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemAdministration/MainMenu/Report/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function CreateReport()
	{

		//Data utama yang diperlukan untuk memanggil sebuah halaman
		$user_id = $this->session->userid;

		$data['Title'] = 'Create Report';
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Report';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Responsibility'] = $this->M_responsibility->getResponsibility();


		$this->form_validation->set_rules('txtReportName', 'repotname', 'required');

		if ($this->form_validation->run() === FALSE)
		{
				//$this->load->view('templates/header', $data);
				//Load halaman
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('SystemAdministration/MainMenu/Report/V_create',$data);
				$this->load->view('V_Footer',$data);
				//$this->load->view('templates/footer');

		}
		else
		{
				$data = array(
					'report_name' 	=> $this->input->post('txtReportName'),
					'report_link'		=> $this->input->post('txtReportLink'),
					'creation_date'	=>  $this->input->post('hdnDate'),
					'created_by'	=>  $this->input->post('hdnUser')
				);

				$this->M_report->setReport($data);

				$aksi = 'Create Report Administration';
				$detail = 'Membuat Report '.$this->input->post('txtReportName');
				$this->log_activity->activity_log($aksi, $detail);

				redirect('SystemAdministration/Report');
		}




	}

	public function UpdateReport($id)
	{	$user_id = $this->session->userid;

		$data['Title'] = 'Update Report';
		$data['Menu'] = 'Report';//menu title
		$data['SubMenuOne'] = 'Report';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Responsibility'] = $this->M_responsibility->getResponsibility();


		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['UserResponsibility'] = $this->M_user->getUserResponsibility($plaintext_string);
		//echo $plaintext_string;

		$data['Report'] = $this->M_report->getReport($plaintext_string);
		$data['id'] = $id;

		$this->form_validation->set_rules('txtReportName', 'reportname', 'required');

		if ($this->form_validation->run() === FALSE)
		{
				//$this->load->view('templates/header', $data);

				//Load halaman
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('SystemAdministration/MainMenu/Report/V_update',$data);
				$this->load->view('V_Footer',$data);

		}
		else
		{	$data = array(
					'report_name' 	=> $this->input->post('txtReportName'),
					'report_link'		=> $this->input->post('txtReportLink'),
					'last_update_date'	=>  $this->input->post('hdnDate'),
					'last_updated_by'	=>  $this->input->post('hdnUser')
				);

			$this->M_report->updateReport($data,$plaintext_string);

			$aksi = 'Update Report Administration';
			$detail = 'Update Report '.$this->input->post('txtReportName');
			$this->log_activity->activity_log($aksi, $detail);

			redirect('SystemAdministration/Report');
		}


	}



}
