<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_DocumentJobDescription extends CI_Controller
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
		$this->load->model('DocumentStandarization/MainMenu/M_jobdeskdocument');

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

		$data['Title'] = 'Dokumen Job Description';
		$data['Menu'] = 'Job Description';
		$data['SubMenuOne'] = 'Dokumen Job Description';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['JobdeskDocument'] = $this->M_jobdeskdocument->getJobdeskDocument();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/DocumentJobDescription/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Dokumen Job Description';
		$data['Menu'] = 'Job Description';
		$data['SubMenuOne'] = 'Dokumen Job Description';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/DocumentJobDescription/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'jd_id' => $this->input->post('txtJdIdHeader'),
				'document_id' => $this->input->post('txtDocumentIdHeader'),
				'document_type' => $this->input->post('txtDocumentTypeHeader'),
    		);
			$this->M_jobdeskdocument->setJobdeskDocument($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('DocumentStandarization/DocumentJobDescription'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Dokumen Job Description';
		$data['Menu'] = 'Job Description';
		$data['SubMenuOne'] = 'Dokumen Job Description';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['JobdeskDocument'] = $this->M_jobdeskdocument->getJobdeskDocument($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/DocumentJobDescription/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'jd_id' => $this->input->post('txtJdIdHeader',TRUE),
				'document_id' => $this->input->post('txtDocumentIdHeader',TRUE),
				'document_type' => $this->input->post('txtDocumentTypeHeader',TRUE),
    			);
			$this->M_jobdeskdocument->updateJobdeskDocument($data, $plaintext_string);

			redirect(site_url('DocumentStandarization/DocumentJobDescription'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Dokumen Job Description';
		$data['Menu'] = 'Job Description';
		$data['SubMenuOne'] = 'Dokumen Job Description';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['JobdeskDocument'] = $this->M_jobdeskdocument->getJobdeskDocument($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/DocumentJobDescription/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_jobdeskdocument->deleteJobdeskDocument($plaintext_string);

		redirect(site_url('DocumentStandarization/DocumentJobDescription'));
    }



}

/* End of file C_JobdeskDocument.php */
/* Location: ./application/controllers/OTHERS/MainMenu/C_JobdeskDocument.php */
/* Generated automatically on 2017-09-14 11:03:46 */