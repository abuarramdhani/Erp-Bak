<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class C_Selep extends CI_Controller
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
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_selep');

		$this->checkSession();
	}

	public function checkSession()
	{
		if ($this->session->is_logged) { } else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Selep';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['Selep'] = $this->M_selep->getSelep();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Selep/V_index', $data);
		$this->load->view('V_Footer', $data);
	}

	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Selep';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$this->form_validation->set_rules('txtSelepDateHeader', 'SelepDate', 'required');
		$this->form_validation->set_rules('txtComponentCodeHeader', 'ComponentCode', 'required');
		$this->form_validation->set_rules('component_description', 'ComponentDescription', 'required');
		$this->form_validation->set_rules('txtSelepQuantityHeader', 'SelepQuantity', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu', $data);
			$this->load->view('ManufacturingOperationUP2L/Selep/V_create', $data);
			$this->load->view('V_Footer', $data);
		} else {

			$emp = $this->input->post('txt_employee[]');
			$employeed	= '';

			for ($i = 0; $i < sizeof($emp); $i++) {
				if ($i == 0) {
					$employeed = substr($emp[$i], 0, 5);
				} else {
					$employeed .= "," . substr($emp[$i], 0, 5);
				}
			}

			$component 		= $this->input->post('txtComponentCodeHeader');
			$component_code = explode(' | ', $component);

			$data = array(
				'selep_date' => $this->input->post('txtSelepDateHeader'),
				'component_code' => $component_code[0],
				'component_description' => $this->input->post('component_description'),
				'shift' => $this->input->post('txtShift'),
				'selep_quantity' => $this->input->post('txtSelepQuantityHeader'),
				'job_id' => $employeed,
				'created_by' => $this->session->userid,
				'scrap_quantity' => $this->input->post('txtScrapQuantityHeader'),
				'keterangan' => $this->input->post('txtKeterangan'),
			);

			$this->M_selep->setSelep($data);
			redirect(site_url('ManufacturingOperationUP2L/Selep'));
		}
	}

	public function edit($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Selep';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['id'] = $id;
		$data['Selep'] = $this->M_selep->getSelepById($id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Selep/V_update', $data);
		$this->load->view('V_Footer', $data);
	}

	public function update($id)
	{
		$comp_code = explode(' | ', $this->input->post('txtComponentCodeHeader'));
		$data = array(
			'selep_date' => $this->input->post('txtSelepDateHeader', TRUE),
			'component_code' => $comp_code[0],
			'component_description' => $this->input->post('component_description', TRUE),
			'selep_quantity' => $this->input->post('txtSelepQuantityHeader', TRUE),
			'job_id' => $this->input->post('txtJobIdHeader', TRUE),
			'last_updated_by' => $this->session->userid,
			'scrap_quantity' => $this->input->post('txtScrapQuantityHeader', TRUE),
			'keterangan' => $this->input->post('txtKeterangan', TRUE),
			'shift' => $this->input->post('txtShift', TRUE),
		);

		$this->M_selep->updateSelep($data, $id);
		redirect(site_url('ManufacturingOperationUP2L/Selep'));
	}

	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Selep';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['id'] = $id;
		$data['Selep'] = $this->M_selep->getSelepById($id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Selep/V_read', $data);
		$this->load->view('V_Footer', $data);
	}

	public function delete($id)
	{
		$this->M_selep->deleteSelep($id);
		redirect(site_url('ManufacturingOperationUP2L/Selep'));
	}

	public function delete2($id)
	{
		$this->M_selep->deleteSelep($id);
		redirect(base_url('ManufacturingOperationUP2L/QualityControl'));
	}
}