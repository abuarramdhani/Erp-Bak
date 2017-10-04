<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_JobdeskEmployee extends CI_Controller
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

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('DocumentStandarization/MainMenu/M_jobdeskemployee');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Jobdesk Employee';
		$data['Menu'] = 'O T H E R S';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['JobdeskEmployee'] = $this->M_jobdeskemployee->getJobdeskEmployee();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/JobdeskEmployee/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Jobdesk Employee';
		$data['Menu'] = 'O T H E R S';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/JobdeskEmployee/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'jd_id' => $this->input->post('txtJdIdHeader'),
				'employee_id' => $this->input->post('txtEmployeeIdHeader'),
    		);
			$this->M_jobdeskemployee->setJobdeskEmployee($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('OTHERS/JobdeskEmployee'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Jobdesk Employee';
		$data['Menu'] = 'O T H E R S';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['JobdeskEmployee'] = $this->M_jobdeskemployee->getJobdeskEmployee($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/JobdeskEmployee/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'jd_id' => $this->input->post('txtJdIdHeader',TRUE),
				'employee_id' => $this->input->post('txtEmployeeIdHeader',TRUE),
    			);
			$this->M_jobdeskemployee->updateJobdeskEmployee($data, $plaintext_string);

			redirect(site_url('OTHERS/JobdeskEmployee'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Jobdesk Employee';
		$data['Menu'] = 'O T H E R S';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['JobdeskEmployee'] = $this->M_jobdeskemployee->getJobdeskEmployee($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/JobdeskEmployee/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_jobdeskemployee->deleteJobdeskEmployee($plaintext_string);

		redirect(site_url('OTHERS/JobdeskEmployee'));
    }



}

/* End of file C_JobdeskEmployee.php */
/* Location: ./application/controllers/OTHERS/MainMenu/C_JobdeskEmployee.php */
/* Generated automatically on 2017-09-14 11:04:06 */