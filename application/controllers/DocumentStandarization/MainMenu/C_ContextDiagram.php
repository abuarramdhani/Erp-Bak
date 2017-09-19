<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_ContextDiagram extends CI_Controller
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
		$this->load->model('DocumentStandarization/MainMenu/M_contextdiagram');

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

		$data['Title'] = 'Context Diagram';
		$data['Menu'] = 'Dokumen';
		$data['SubMenuOne'] = 'Context Diagram';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['ContextDiagram'] = $this->M_contextdiagram->getContextDiagram();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/ContextDiagram/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Context Diagram';
		$data['Menu'] = 'Dokumen';
		$data['SubMenuOne'] = 'Context Diagram';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/ContextDiagram/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'cd_name' => $this->input->post('txtCdNameHeader'),
				'cd_file' => $this->input->post('txtCdFileHeader'),
				'no_kontrol' => $this->input->post('txtNoKontrolHeader'),
				'no_revisi' => $this->input->post('txtNoRevisiHeader'),
				'tanggal' => $this->input->post('txtTanggalHeader'),
				'dibuat' => $this->input->post('txtDibuatHeader'),
				'diperiksa_1' => $this->input->post('txtDiperiksa1Header'),
				'diperiksa_2' => $this->input->post('txtDiperiksa2Header'),
				'diputuskan' => $this->input->post('txtDiputuskanHeader'),
				'jml_halaman' => $this->input->post('txtJmlHalamanHeader'),
				'cd_info' => $this->input->post('txaCdInfoHeader'),
				'tgl_upload' => $this->input->post('txtTglUploadHeader'),
				'tgl_insert' => $this->input->post('txtTglInsertHeader'),
				'bp_id' => $this->input->post('txtBpIdHeader'),
    		);
			$this->M_contextdiagram->setContextDiagram($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('OTHERS/ContextDiagram'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Context Diagram';
		$data['Menu'] = 'Dokumen';
		$data['SubMenuOne'] = 'Context Diagram';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['ContextDiagram'] = $this->M_contextdiagram->getContextDiagram($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/ContextDiagram/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'cd_name' => $this->input->post('txtCdNameHeader',TRUE),
				'cd_file' => $this->input->post('txtCdFileHeader',TRUE),
				'no_kontrol' => $this->input->post('txtNoKontrolHeader',TRUE),
				'no_revisi' => $this->input->post('txtNoRevisiHeader',TRUE),
				'tanggal' => $this->input->post('txtTanggalHeader',TRUE),
				'dibuat' => $this->input->post('txtDibuatHeader',TRUE),
				'diperiksa_1' => $this->input->post('txtDiperiksa1Header',TRUE),
				'diperiksa_2' => $this->input->post('txtDiperiksa2Header',TRUE),
				'diputuskan' => $this->input->post('txtDiputuskanHeader',TRUE),
				'jml_halaman' => $this->input->post('txtJmlHalamanHeader',TRUE),
				'cd_info' => $this->input->post('txaCdInfoHeader',TRUE),
				'tgl_upload' => $this->input->post('txtTglUploadHeader',TRUE),
				'tgl_insert' => $this->input->post('txtTglInsertHeader',TRUE),
				'bp_id' => $this->input->post('txtBpIdHeader',TRUE),
    			);
			$this->M_contextdiagram->updateContextDiagram($data, $plaintext_string);

			redirect(site_url('OTHERS/ContextDiagram'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Context Diagram';
		$data['Menu'] = 'Dokumen';
		$data['SubMenuOne'] = 'Context Diagram';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['ContextDiagram'] = $this->M_contextdiagram->getContextDiagram($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/ContextDiagram/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_contextdiagram->deleteContextDiagram($plaintext_string);

		redirect(site_url('OTHERS/ContextDiagram'));
    }



}

/* End of file C_ContextDiagram.php */
/* Location: ./application/controllers/OTHERS/MainMenu/C_ContextDiagram.php */
/* Generated automatically on 2017-09-14 11:00:26 */