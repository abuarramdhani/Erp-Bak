<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class C_Core extends CI_Controller
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
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_core');
		$this->load->model('ManufacturingOperationUP2L/Ajax/M_ajax');

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

		$data['Title'] = 'Core';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Core/V_index', $data);
		$this->load->view('V_Footer', $data);
	}

	// edit rozin
	public function buildCDataTable()
	{
		$post = $this->input->post();

		foreach ($post['columns'] as $val) {
			$post['search'][$val['data']]['value'] = $val['search']['value'];
		}

		$countall = $this->M_core->countAllC()['count'];
		$countfilter = $this->M_core->countFilteredC($post)['count'];

		$post['pagination']['from'] = $post['start'] + 1;
		$post['pagination']['to'] = $post['start'] + $post['length'];

		$protodata = $this->M_core->SelectC($post);

		$data = [];
		foreach ($protodata as $row) {
		$encrypted_string = $this->encrypt->encode($row['core_id']);
		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

			$sub_array = [];
			$sub_array[] = '<center>'.$row['pagination'].'</center>';
			$sub_array[] = '<center>
											<a style="margin-right:4px" href="'.base_url('ManufacturingOperationUP2L/Core/read/'.$encrypted_string.'').'" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
											<a style="margin-right:4px" href="'.base_url('ManufacturingOperationUP2L/Core/update/'.$encrypted_string.'').'" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
											<a href="'.base_url('ManufacturingOperationUP2L/Core/delete/'.$encrypted_string.'').'" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm("Are you sure you want to delete this item?");"><span class="fa fa-trash fa-2x"></span></a>
										</center>';
			$sub_array[] = '<center>'.$row['component_code'].'</center>';
			$sub_array[] = '<center>'.$row['component_description'].'</center>';
			$sub_array[] = '<center>'.$row['production_date'].'</center>';
			$sub_array[] = '<center>'.$row['core_quantity'].'</center>';
			$sub_array[] = '<center>'.$row['print_code'].'</center>';
			$sub_array[] = '<center>'.$row['kode'].'</center>';
			$sub_array[] = '<center>'.$row['shift'].'</center>';
			$sub_array[] = '<center>'.$row['employee_id'].'</center>';

			$data[] = $sub_array;
		}

		$output = [
			'draw' => $post['draw'],
			'recordsTotal' => $countall,
			'recordsFiltered' => $countfilter,
			'data' => $data,
		];

		die($this->output
						->set_status_header(200)
						->set_content_type('application/json')
						->set_output(json_encode($output))
						->_display());
	}

	public function view_create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Core';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		$data['employee']		= $this->M_ajax->getEmployee();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Core/V_create', $data);
		$this->load->view('V_Footer', $data);
	}

	public function create()
	{
		$emp			= $this->input->post('txt_employee[]');
		$employeed		= '';
		for ($i = 0; $i < sizeof($emp); $i++) {
			if ($i == 0) {
				$employeed = substr($emp[$i], 0, 5);
			} else {
				$employeed .= "," . substr($emp[$i], 0, 5);
			}
		}

		$coreData = array();
		$aksen1 = 0;
		foreach ($this->input->post('txtCoreQuantityHeader[]') as $a) {
			$coreData[$aksen1]['core_quantity'] = $a;
			$aksen1++;
		}

		$aksen2 = 0;
		foreach ($this->input->post('component_code[]') as $b) {
			$pecCore = explode(' | ', $b);
			$coreData[$aksen2]['component_code'] = trim($pecCore[0]);
			$coreData[$aksen2]['component_description'] = trim($pecCore[1]);
			$coreData[$aksen2]['kode_proses'] = trim($pecCore[2]);
			$coreData[$aksen2]['production_date'] = $this->input->post('production_date');
			$coreData[$aksen2]['shift'] = $this->input->post('txtShift');
			$coreData[$aksen2]['print_code'] = $this->input->post('print_code');
			$coreData[$aksen2]['employee_id'] = $employeed;
			$coreData[$aksen2]['ket_pengurangan'] = $this->input->post('txtKeteranganPemotonganTarget');
			if (array_key_exists('txtJamPemotonganTarget', $_POST)) {
				$coreData[$aksen2]['jam_pengurangan'] = str_replace(' ', '', $this->input->post('txtJamPemotonganTarget')) ;
			} else {
				$coreData[$aksen2]['jam_pengurangan'] = '';
			}
			$aksen2++;
		}

		foreach ($coreData as $co) {
			$this->M_core->setCore($co);
			$header_id = $this->db->insert_id();

			$emp = $this->input->post('txt_employee[]');
			$produksi = $this->input->post('txt_produksi[]');
			$lembur = $this->input->post('txt_lembur[]');
			$presensi = $this->input->post('txt_presensi[]');
			$ott = $this->input->post('txt_ott[]');
			$kode = $this->input->post('kode_kel');

			$i = 0;
			foreach ($emp as $val) {
				$employee = explode('|', $val);
				$no_induk = $employee[0];
				$nama = $employee[1];
				$data =  array(
					'nama'		=> $nama,
					'no_induk' => $no_induk,
					'category_produksi' => 'Core',
					'id_produksi' => $header_id,
					'presensi' => $presensi[$i],
					'produksi' => $produksi[$i],
					'nilai_ott' => $ott[$i],
					'lembur' => $lembur[$i],
					'kode' => $kode,
					'created_date' =>  $this->input->post('production_date')
				);
				$this->M_core->setAbsensi($data);
				$i++;
			}
		}
		redirect(site_url('ManufacturingOperationUP2L/Core/view_create'));
	}

	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Core';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id']			= $id;
		$data['employee']	= $this->M_ajax->getEmployee();

		$this->form_validation->set_rules('component_code', 'required');
		$this->form_validation->set_rules('component_description', 'required');
		$this->form_validation->set_rules('production_date', 'required');
		$this->form_validation->set_rules('core_quantity', 'required');
		$this->form_validation->set_rules('print_code', 'required');
		$this->form_validation->set_rules('shift', 'required');
		$this->form_validation->set_rules('employee_id', 'required');


		$data['Core'] = $this->M_core->getCoreById($plaintext_string);
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu', $data);
			$this->load->view('ManufacturingOperationUP2L/Core/V_update', $data);
			$this->load->view('V_Footer', $data);
		} else {
				$component = explode(' | ', $this->input->post('cmbComponentCodeHeader', TRUE));
			$data = array(
				'component_code'		=> $component[0],
				'component_description' => $component[1],
				'kode_proses'			=> $component[2],
				'production_date'		=> $this->input->post('txtProductionDateHeader', TRUE),
				'core_quantity'			=> $this->input->post('txtCoreQuantityHeader', TRUE),
				'print_code'			=> $this->input->post('print_code'),
				'shift'					=> $this->input->post('txtShift'),
				'employee_id'			=> $this->input->post('txtJobIdHeader', TRUE),
			);

			$this->M_core->updateCore($plaintext_string, $data);

			redirect(site_url('ManufacturingOperationUP2L/Core'));
		}
	}

	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Core';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;
		$data['Core'] = $this->M_core->getCoreById($plaintext_string);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Core/V_read', $data);
		$this->load->view('V_Footer', $data);
	}

	public function delete($id)
	{
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$this->M_core->deleteCore($plaintext_string);
		redirect(site_url('ManufacturingOperationUP2L/Core'));
	}

}
