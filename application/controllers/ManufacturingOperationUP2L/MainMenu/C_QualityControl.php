<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class C_QualityControl extends CI_Controller
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
		$this->load->library('Excel');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_qualitycontrol');
		$this->load->model('ProductionPlanning/MainMenu/M_dataplan');
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_moulding');

		$this->checkSession();
	}

	public function checkSession()
	{
		if ($this->session->is_logged) { } else {
			redirect('');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Quality Control';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['QualityControl'] = $this->M_qualitycontrol->getQualityControl();
		$data['Selep'] = $this->M_qualitycontrol->getSelep();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/QualityControl/V_index', $data);
		$this->load->view('V_Footer', $data);
	}

	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Quality Control';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);

		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;
		$data['QualityControl'] = $this->M_qualitycontrol->getEditQualityControl($id);

		$this->form_validation->set_rules('txtCheckingQuantityHeader', 'CheckingQuantity', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu', $data);
			$this->load->view('ManufacturingOperationUP2L/QualityControl/V_update', $data);
			$this->load->view('V_Footer', $data);
		} else {
			$data = array(
				'checking_quantity' => $this->input->post('txtCheckingQuantityHeader', TRUE)
			);
			
			$id_fix = $this->input->post('id_fix');
			$qty_qc_ok = $this->input->post('txtCheckingQuantityHeader');

			$this->M_qualitycontrol->updateQualityControl($data, $id);
			$this->M_qualitycontrol->update_qty_qc($qty_qc_ok, $id_fix);

			redirect(site_url('ManufacturingOperationUP2L/QualityControl'));
		}
	}

	public function read($id)
	{

		$user_id = $this->session->userid;

		$data['Title'] = 'Quality Control';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		$data['QualityControl'] = $this->M_qualitycontrol->getQualityControlbyId($id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/QualityControl/V_read', $data);
		$this->load->view('V_Footer', $data);
	}
	
	public function selectByDate1()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Quality Control';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		$data['tmpl'] = 'A1';
		$dateQCUp2l = $this->input->post('dateSQCUp2l');
		$data['Selep'] = $this->M_qualitycontrol->selectByDate1($dateQCUp2l);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/QualityControl/V_index_search', $data);
		$this->load->view('V_Footer', $data);
	}
	public function selectByDate2()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Quality Control';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		$data['tmpl'] = 'A2';
		$dateQCUp2l = $this->input->post('dateQCUp2l');
		$data['QualityControl'] = $this->M_qualitycontrol->selectByDate2($dateQCUp2l);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/QualityControl/V_index_search', $data);
		$this->load->view('V_Footer', $data);
	}

	public function swnKuburan($id)
	{
		$QualityControlDetail = $this->M_qualitycontrol->getQualityControlDetail($id);
		echo json_encode($QualityControlDetail);
	}

	public function delete($id, $sid)
	{
		$this->M_qualitycontrol->deleteQualityControl($id, $sid);
		redirect(site_url('ManufacturingOperationUP2L/QualityControl'));
	}
}
