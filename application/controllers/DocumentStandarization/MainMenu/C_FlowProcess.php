<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FlowProcess extends CI_Controller
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
		$this->load->model('DocumentStandarization/MainMenu/M_flowprocess');

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

		$data['Title'] = 'Flow Process';
		$data['Menu'] = 'O T H E R S';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['FlowProcess'] = $this->M_flowprocess->getFlowProcess();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/FlowProcess/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Flow Process';
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
			$this->load->view('DocumentStandarization/FlowProcess/V_create', $data);
			$this->load->view('V_Footer',$data);
		} else {
			$data = array(
				'fp_name' => $this->input->post('txtFpNameHeader'),
				'fp_file' => $this->input->post('txtFpFileHeader'),
				'no_kontrol' => $this->input->post('txtNoKontrolHeader'),
				'no_revisi' => $this->input->post('txtNoRevisiHeader'),
				'tanggal' => $this->input->post('txtTanggalHeader'),
				'dibuat' => $this->input->post('txtDibuatHeader'),
				'diperiksa_1' => $this->input->post('txtDiperiksa1Header'),
				'diperiksa_2' => $this->input->post('txtDiperiksa2Header'),
				'diputuskan' => $this->input->post('txtDiputuskanHeader'),
				'jml_halaman' => $this->input->post('txtJmlHalamanHeader'),
				'fp_info' => $this->input->post('txaFpInfoHeader'),
				'tgl_upload' => $this->input->post('txtTglUploadHeader'),
				'tgl_insert' => $this->input->post('txtTglInsertHeader'),
    		);
			$this->M_flowprocess->setFlowProcess($data);
			$header_id = $this->db->insert_id();
			//insert to sys.log_activity
			$aksi = 'DOC STANDARIZATION';
			$detail = "Set Flowprocess id=$header_id";
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect(site_url('OTHERS/FlowProcess'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Flow Process';
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
		$data['FlowProcess'] = $this->M_flowprocess->getFlowProcess($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/FlowProcess/V_update', $data);
			$this->load->view('V_Footer',$data);
		} else {
			$data = array(
				'fp_name' => $this->input->post('txtFpNameHeader',TRUE),
				'fp_file' => $this->input->post('txtFpFileHeader',TRUE),
				'no_kontrol' => $this->input->post('txtNoKontrolHeader',TRUE),
				'no_revisi' => $this->input->post('txtNoRevisiHeader',TRUE),
				'tanggal' => $this->input->post('txtTanggalHeader',TRUE),
				'dibuat' => $this->input->post('txtDibuatHeader',TRUE),
				'diperiksa_1' => $this->input->post('txtDiperiksa1Header',TRUE),
				'diperiksa_2' => $this->input->post('txtDiperiksa2Header',TRUE),
				'diputuskan' => $this->input->post('txtDiputuskanHeader',TRUE),
				'jml_halaman' => $this->input->post('txtJmlHalamanHeader',TRUE),
				'fp_info' => $this->input->post('txaFpInfoHeader',TRUE),
				'tgl_upload' => $this->input->post('txtTglUploadHeader',TRUE),
				'tgl_insert' => $this->input->post('txtTglInsertHeader',TRUE),
    			);
			$this->M_flowprocess->updateFlowProcess($data, $plaintext_string);
			//insert to sys.log_activity
			$aksi = 'DOC STANDARIZATION';
			$detail = "Update FlowProcess id=$plaintext_string";
			$this->log_activity->activity_log($aksi, $detail);
			//
			redirect(site_url('OTHERS/FlowProcess'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Flow Process';
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
		$data['FlowProcess'] = $this->M_flowprocess->getFlowProcess($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/FlowProcess/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_flowprocess->deleteFlowProcess($plaintext_string);
		//insert to sys.log_activity
		$aksi = 'DOC STANDARIZATION';
		$detail = "Delete FlowProcess id=$plaintext_string";
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('OTHERS/FlowProcess'));
    }



}

/* End of file C_FlowProcess.php */
/* Location: ./application/controllers/OTHERS/MainMenu/C_FlowProcess.php */
/* Generated automatically on 2017-09-14 11:02:53 */
