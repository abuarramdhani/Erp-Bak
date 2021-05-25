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
			redirect('');
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

		// $data['Selep'] = $this->M_selep->getSelep(); // hehe

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Selep/V_index', $data);
		$this->load->view('V_Footer', $data);
	}

	public function buildSelepDataTable()
	{
		$post = $this->input->post();

		foreach ($post['columns'] as $val) {
			$post['search'][$val['data']]['value'] = $val['search']['value'];
		}

		$countall = $this->M_selep->countAllSelep()['count'];
		$countfilter = $this->M_selep->countFilteredSelep($post)['count'];

		$post['pagination']['from'] = $post['start'] + 1;
		$post['pagination']['to'] = $post['start'] + $post['length'];

		$protodata = $this->M_selep->selectSelep($post);

		$data = [];
		foreach ($protodata as $row) {

			$sub_array = [];
			$sub_array[] = '<center>'.$row['pagination'].'</center>';
			$sub_array[] = '<center>
											<a style="margin-right:4px" href="'.base_url('ManufacturingOperationUP2L/Selep/read/'.$row['selep_id'].'').'" data-toggle="tooltip" data-placement="bottom" title="Read Data"><span class="fa fa-list-alt fa-2x"></span></a>
											<a style="margin-right:4px" href="'.base_url('ManufacturingOperationUP2L/Selep/edit/'.$row['selep_id'].'').'" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
											<a href="'.base_url('ManufacturingOperationUP2L/Selep/delete/'.$row['selep_id'].'').'" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm(\'Are you sure you want to delete this item?\');"><span class="fa fa-trash fa-2x"></span></a>
										</center>';
			$sub_array[] = '<center>'.$row['selep_date'].'</center>';
			$sub_array[] = '<center>'.$row['component_code'].'</center>';
			$sub_array[] = '<center>'.$row['component_description'].'</center>';
			$sub_array[] = '<center>'.$row['selep_quantity'].'</center>';
			$sub_array[] = '<center>'.$row['scrap_quantity'].'</center>';
			$sub_array[] = '<center>'.$row['shift'].'</center>';
			$sub_array[] = '<center>'.$row['job_id'].'</center>';

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

		$data['Title'] = 'Selep';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Selep/V_create', $data);
		$this->load->view('V_Footer', $data);
	}
	public function create()
	{
		$emp = $this->input->post('txt_employee[]');
		$employee	= '';

		for ($i = 0; $i < sizeof($emp); $i++) {
			if ($i == 0) {
				$employee = substr($emp[$i], 0, 5);
			} else {
				$employee .= "," . substr($emp[$i], 0, 5);
			}
		}
		$selepData = array();
		$aksen1 = 0;
		foreach ($this->input->post('txtSelepQuantityHeader[]') as $a) {
			$selepData[$aksen1]['selep_quantity'] = $a;
			$aksen1++;
		}

		$aksen2 = 0;
		foreach ($this->input->post('component_code[]') as $b) {
			$pec = explode(' | ', $b);
			$selepData[$aksen2]['component_code'] = trim($pec[0]);
			$selepData[$aksen2]['component_description'] = trim($pec[1]);
			$selepData[$aksen2]['kode_proses'] = trim($pec[2]);
			$selepData[$aksen2]['selep_date'] = $this->input->post('txtSelepDateHeader');
			$selepData[$aksen2]['shift'] = $this->input->post('txtShift');
			$selepData[$aksen2]['scrap_quantity'] = '0';
			$selepData[$aksen2]['job_id'] = $employee;
			$selepData[$aksen2]['ket_pengurangan'] = $this->input->post('txtKeteranganPemotonganTarget');
			if ($selepData[$aksen2]['ket_pengurangan'] != '') {
				$selepData[$aksen2]['jam_pengurangan'] = $this->input->post('txtJamPemotonganTarget');
			} else {
				$selepData[$aksen2]['jam_pengurangan'] = '';
			}
			// $selepData[$aksen2]['jam_pengurangan'] = $this->input->post('txtJamPemotonganTarget');
			$aksen2++;
		}

		$aksen3 = 0;
		foreach ($this->input->post('txtKeterangan[]') as $c) {
			$selepData[$aksen3]['keterangan'] = $c;
			$aksen3++;
		}

		foreach ($selepData as $se) {
			$this->M_selep->setSelep($se);
		}

		redirect(site_url('ManufacturingOperationUP2L/Selep/view_create'));
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
		$component = explode(' | ', $this->input->post('cmbComponentCodeHeader', TRUE));
		$data = array(
			'component_code'		=> $component[0],
			'component_description' => $component[1],
			'kode_proses'			=> $component[2],
			'selep_date' => $this->input->post('txtSelepDateHeader', TRUE),
			'selep_quantity' => $this->input->post('txtSelepQuantityHeader', TRUE),
			'job_id' => $this->input->post('txtJobIdHeader', TRUE),
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
