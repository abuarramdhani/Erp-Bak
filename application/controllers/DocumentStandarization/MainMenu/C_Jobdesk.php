<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Jobdesk extends CI_Controller
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
		$this->load->model('DocumentStandarization/MainMenu/M_jobdesk');

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

		$data['Title'] = 'Master Job Desk';
		$data['Menu'] = 'Job Desk';
		$data['SubMenuOne'] = 'Master Job Desk';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Jobdesk'] = $this->M_jobdesk->getJobdesk();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/Jobdesk/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Master Job Desk';
		$data['Menu'] = 'Job Desk';
		$data['SubMenuOne'] = 'Master Job Desk';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/Jobdesk/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'jd_name' => $this->input->post('txtJdNameHeader'),
				'jd_detail' => $this->input->post('txaJdDetailHeader'),
				'kodesie' => $this->input->post('txtKodesieHeader'),
    		);
			$this->M_jobdesk->setJobdesk($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('OTHERS/Jobdesk'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Master Job Desk';
		$data['Menu'] = 'Job Desk';
		$data['SubMenuOne'] = 'Master Job Desk';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Jobdesk'] = $this->M_jobdesk->getJobdesk($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/Jobdesk/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'jd_name' => $this->input->post('txtJdNameHeader',TRUE),
				'jd_detail' => $this->input->post('txaJdDetailHeader',TRUE),
				'kodesie' => $this->input->post('txtKodesieHeader',TRUE),
    			);
			$this->M_jobdesk->updateJobdesk($data, $plaintext_string);

			redirect(site_url('OTHERS/Jobdesk'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Master Job Desk';
		$data['Menu'] = 'Job Desk';
		$data['SubMenuOne'] = 'Master Job Desk';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Jobdesk'] = $this->M_jobdesk->getJobdesk($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/Jobdesk/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_jobdesk->deleteJobdesk($plaintext_string);

		redirect(site_url('OTHERS/Jobdesk'));
    }



}

/* End of file C_Jobdesk.php */
/* Location: ./application/controllers/OTHERS/MainMenu/C_Jobdesk.php */
/* Generated automatically on 2017-09-14 11:03:22 */