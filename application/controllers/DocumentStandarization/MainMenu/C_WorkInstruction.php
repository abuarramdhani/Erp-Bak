<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_WorkInstruction extends CI_Controller
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
		$this->load->model('DocumentStandarization/MainMenu/M_workinstruction');

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

		$data['Title'] = 'Work Instruction';
		$data['Menu'] = 'Dokumen';
		$data['SubMenuOne'] = 'Work Instruction';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['WorkInstruction'] = $this->M_workinstruction->getWorkInstruction();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/WorkInstruction/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Work Instruction';
		$data['Menu'] = 'Dokumen';
		$data['SubMenuOne'] = 'Work Instruction';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/WorkInstruction/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'wi_name' => $this->input->post('txtWiNameHeader'),
				'wi_file' => $this->input->post('txtWiFileHeader'),
				'no_kontrol' => $this->input->post('txtNoKontrolHeader'),
				'no_revisi' => $this->input->post('txtNoRevisiHeader'),
				'tanggal' => $this->input->post('txtTanggalHeader'),
				'dibuat' => $this->input->post('txtDibuatHeader'),
				'diperiksa_1' => $this->input->post('txtDiperiksa1Header'),
				'diperiksa_2' => $this->input->post('txtDiperiksa2Header'),
				'diputuskan' => $this->input->post('txtDiputuskanHeader'),
				'jml_halaman' => $this->input->post('txtJmlHalamanHeader'),
				'wi_info' => $this->input->post('txaWiInfoHeader'),
				'tgl_upload' => $this->input->post('txtTglUploadHeader'),
				'tgl_insert' => $this->input->post('txtTglInsertHeader'),
				'bp_id' => $this->input->post('txtBpIdHeader'),
				'cd_id' => $this->input->post('txtCdIdHeader'),
				'sop_id' => $this->input->post('txtSopIdHeader'),
    		);
			$this->M_workinstruction->setWorkInstruction($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('OTHERS/WorkInstruction'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Work Instruction';
		$data['Menu'] = 'Dokumen';
		$data['SubMenuOne'] = 'Work Instruction';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['WorkInstruction'] = $this->M_workinstruction->getWorkInstruction($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/WorkInstruction/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'wi_name' => $this->input->post('txtWiNameHeader',TRUE),
				'wi_file' => $this->input->post('txtWiFileHeader',TRUE),
				'no_kontrol' => $this->input->post('txtNoKontrolHeader',TRUE),
				'no_revisi' => $this->input->post('txtNoRevisiHeader',TRUE),
				'tanggal' => $this->input->post('txtTanggalHeader',TRUE),
				'dibuat' => $this->input->post('txtDibuatHeader',TRUE),
				'diperiksa_1' => $this->input->post('txtDiperiksa1Header',TRUE),
				'diperiksa_2' => $this->input->post('txtDiperiksa2Header',TRUE),
				'diputuskan' => $this->input->post('txtDiputuskanHeader',TRUE),
				'jml_halaman' => $this->input->post('txtJmlHalamanHeader',TRUE),
				'wi_info' => $this->input->post('txaWiInfoHeader',TRUE),
				'tgl_upload' => $this->input->post('txtTglUploadHeader',TRUE),
				'tgl_insert' => $this->input->post('txtTglInsertHeader',TRUE),
				'bp_id' => $this->input->post('txtBpIdHeader',TRUE),
				'cd_id' => $this->input->post('txtCdIdHeader',TRUE),
				'sop_id' => $this->input->post('txtSopIdHeader',TRUE),
    			);
			$this->M_workinstruction->updateWorkInstruction($data, $plaintext_string);

			redirect(site_url('OTHERS/WorkInstruction'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Work Instruction';
		$data['Menu'] = 'Dokumen';
		$data['SubMenuOne'] = 'Work Instruction';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['WorkInstruction'] = $this->M_workinstruction->getWorkInstruction($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/WorkInstruction/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_workinstruction->deleteWorkInstruction($plaintext_string);

		redirect(site_url('OTHERS/WorkInstruction'));
    }



}

/* End of file C_WorkInstruction.php */
/* Location: ./application/controllers/OTHERS/MainMenu/C_WorkInstruction.php */
/* Generated automatically on 2017-09-14 11:01:40 */