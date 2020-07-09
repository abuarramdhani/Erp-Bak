<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_JobDescriptionPekerja extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('DocumentStandarization/MainMenu/M_jobdescriptionpekerja');
		$this->load->model('DocumentStandarization/MainMenu/M_jobdeskdocument');
				$this->load->model('DocumentStandarization/MainMenu/M_general');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Job Description Pekerja';
		$data['Menu'] = 'Job Description';
		$data['SubMenuOne'] = 'Job Description Pekerja';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['JobDescriptionPekerja'] 	= $this->M_jobdescriptionpekerja->getJobdeskEmployee();
		$data['DocumentJobDescription']	=	$this->M_jobdeskdocument->ambilDokumenJobDescription();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/JobDescriptionPekerja/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Job Description Pekerja';
		$data['Menu'] = 'Job Description';
		$data['SubMenuOne'] = 'Job Description Pekerja';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('cmbDepartemen', 'Departemen', 'required');
		$this->form_validation->set_rules('cmbPekerja-JobDesc', 'Pekerja', 'required');
		$this->form_validation->set_rules('cmbJD', 'Job Description', 'required');

		if ($this->form_validation->run() === FALSE) {
			$data['ambilDepartemen'] 	= 	$this->M_general->ambilDepartemen();

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/JobDescriptionPekerja/V_create', $data);
			$this->load->view('V_Footer',$data);
		} else {


			$jobDescription 		= 	$this->input->post('cmbJD');
			$pekerja 				= 	$this->input->post('cmbPekerja-JobDesc');

			$data 	=	array(
							'jd_id' 			=> $jobDescription,
							'employee_code' 	=> $pekerja,
    					);
			$this->M_jobdescriptionpekerja->setJobdeskEmployee($data);
			$header_id = $this->db->insert_id();
			//insert to sys.log_activity
			$aksi = 'DOC STANDARIZATION';
			$detail = "Set Jobdesk Pekerja id=$header_id";
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect(site_url('DocumentStandarization/JobDescriptionPekerja'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Job Description Pekerja';
		$data['Menu'] = 'Job Description';
		$data['SubMenuOne'] = 'Job Description Pekerja';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['JobdeskEmployee'] = $this->M_jobdescriptionpekerja->getJobdeskEmployee($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/JobDescriptionPekerja/V_update', $data);
			$this->load->view('V_Footer',$data);
		} else {
			$data = array(
				'jd_id' => $this->input->post('txtJdIdHeader',TRUE),
				'employee_id' => $this->input->post('txtEmployeeIdHeader',TRUE),
    			);
			$this->M_jobdescriptionpekerja->updateJobdeskEmployee($data, $plaintext_string);
			//insert to sys.log_activity
			$aksi = 'DOC STANDARIZATION';
			$detail = "Update Jobdesk Pekerja id=$plaintext_string";
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect(site_url('DocumentStandarization/JobDescriptionPekerja'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Job Description Pekerja';
		$data['Menu'] = 'Job Description';
		$data['SubMenuOne'] = 'Job Description Pekerja';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['JobDescriptionPekerja'] 		= $this->M_jobdescriptionpekerja->getJobdeskEmployee($plaintext_string);
		$data['AmbilKodeJobDescription'] 	= $this->M_jobdescriptionpekerja->ambilKodeJobDescription($plaintext_string);
		$data['DocumentJobDescription'] 	= $this->M_jobdeskdocument->ambilDokumenJobDescription($data['AmbilKodeJobDescription']);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/JobDescriptionPekerja/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_jobdescriptionpekerja->deleteJobdeskEmployee($plaintext_string);
		//insert to sys.log_activity
		$aksi = 'DOC STANDARIZATION';
		$detail = "Delete Jobdesk Pekerja id=$plaintext_string";
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('DocumentStandarization/JobDescriptionPekerja'));
    }



}

/* End of file C_JobdeskEmployee.php */
/* Location: ./application/controllers/OTHERS/MainMenu/C_JobdeskEmployee.php */
/* Generated automatically on 2017-09-14 11:04:06 */
