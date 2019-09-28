<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class C_Mixing extends CI_Controller
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
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_mixing');

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

		$data['Title'] = 'Mixing';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['Mixing'] = $this->M_mixing->getMixing();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Mixing/V_index', $data);
		$this->load->view('V_Footer', $data);
	}

	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Mixing';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$this->form_validation->set_rules('txtComponentCodeHeader', 'ComponentCode', 'required');
		$this->form_validation->set_rules('txtProductionDateHeader', 'ProductionDate', 'required');
		$this->form_validation->set_rules('txtMixingQuantityHeader', 'MixingQuantity', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu', $data);
			$this->load->view('ManufacturingOperationUP2L/Mixing/V_create', $data);
			$this->load->view('V_Footer', $data);
		} else {

			$emp = $this->input->post('txt_employee[]');
			$produksi = $this->input->post('txt_produksi[]');
			$lembur = $this->input->post('txt_lembur[]');
			$presensi = $this->input->post('txt_presensi[]');
			$ott = $this->input->post('txt_ott[]');
			$kode = $this->input->post('ottKodeP');
			$employeed	= '';

			for ($i = 0; $i < sizeof($emp); $i++) {
				if ($i == 0) {
					$employeed = substr($emp[$i], 0, 5);
				} else {
					$employeed .= "," . substr($emp[$i], 0, 5);
				}
			}

			$component_code = explode(' | ', $this->input->post('txtComponentCodeHeader'));
			$data = array(
				'component_code'		=> trim($component_code[0]),
				'component_description' => trim($component_code[1]),
				'production_date' => $this->input->post('txtProductionDateHeader'),
				'shift' => $this->input->post('txtShift'),
				'mixing_quantity' => $this->input->post('txtMixingQuantityHeader'),
				'job_id' => $employeed,
				'created_by' => $this->session->userid,
				'print_code' => $this->input->post('print_code')
			);
			$this->M_mixing->setMixing($data);
			$header_id = $this->db->insert_id();

			$i = 0;
			foreach ($emp as $val) {
				$employee = explode('|', $val);
				$no_induk = $employee[0];
				$nama = $employee[1];

				$data =  array(
					'nama' => $nama,
					'no_induk' => $no_induk,
					'category_produksi' => 'Mixing',
					'id_produksi' => $header_id,
					'presensi' => $presensi[$i],
					'produksi' => $produksi[$i],
					'nilai_ott' => $ott[$i],
					'lembur' => $lembur[$i],
					'kode' => $kode,
					'created_date' => $this->input->post('txtProductionDateHeader')
				);
				$this->M_mixing->setAbsensi($data);

				$i++;
			}
			redirect(site_url('ManufacturingOperationUP2L/Mixing/create'));
		}
	}

	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Mixing';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;
		$data['Mixing'] = $this->M_mixing->getMixingById($plaintext_string);

		$this->form_validation->set_rules('cmbComponentCodeHeader', 'ComponentCode', 'required');
		$this->form_validation->set_rules('txtProductionDateHeader', 'ProductionDate', 'required');
		$this->form_validation->set_rules('txtMixingQuantityHeader', 'MixingQuantity', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu', $data);
			$this->load->view('ManufacturingOperationUP2L/Mixing/V_update', $data);
			$this->load->view('V_Footer', $data);
		} else {
			$data = array(
				'component_code' => $this->input->post('cmbComponentCodeHeader', TRUE),
				'component_description' => $this->input->post('txtComponentDescriptionHeader', TRUE),
				'production_date' => $this->input->post('txtProductionDateHeader', TRUE),
				'shift' => $this->input->post('txtShift'),
				'mixing_quantity' => $this->input->post('txtMixingQuantityHeader', TRUE),
				'job_id' => $this->input->post('txtJobIdHeader', TRUE),
				'last_updated_by' => $this->session->userid,
				'print_code' => $this->input->post('print_code')
			);
			$this->M_mixing->updateMixing($data, $plaintext_string);

			redirect(site_url('ManufacturingOperationUP2L/Mixing'));
		}
	}

	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Mixing';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;
		$data['Mixing'] = $this->M_mixing->getMixingById($plaintext_string);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Mixing/V_read', $data);
		$this->load->view('V_Footer', $data);
	}
	
	public function delete($id)
	{
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_mixing->deleteMixing($plaintext_string);

		redirect(site_url('ManufacturingOperationUP2L/Mixing'));
	}

}