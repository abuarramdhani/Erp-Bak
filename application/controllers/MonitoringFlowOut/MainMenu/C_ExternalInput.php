<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_ExternalInput extends CI_Controller
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
		$this->load->model('MonitoringFlowOut/M_external');
		$this->load->model('MonitoringFlowOut/M_master');

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

		$data['Title'] = 'External Input';
		$data['Menu'] = 'External Input';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['fail'] = $this->M_master->getPoss();
		$data['seksi'] = $this->M_master->getSeksi();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MonitoringFlowOut/External/V_ExtInput', $data);
		$this->load->view('V_Footer', $data);
	}

	public function create()
	{
		if ($_FILES['upQr']['name'] != '') {
			$temp = explode(".", $_FILES["upQr"]["name"]);
			$newfilenameQr = "upQr_" . date('d-M-Y_h-i-a') . '.' . end($temp);
			move_uploaded_file($_FILES["upQr"]["tmp_name"], "./assets/upload/MonitoringFlowOut/uploadQr/" . $newfilenameQr);
		} else {
			$newfilenameQr = NULL;
		}

		if ($_FILES['upCar']['name'] != '') {
			$temp = explode(".", $_FILES["upCar"]["name"]);
			$newfilenameCar = "upCar_" . date('d-M-Y_h-i-a') . '.' . end($temp);
			move_uploaded_file($_FILES["upCar"]["tmp_name"], "./assets/upload/MonitoringFlowOut/uploadCar/" . $newfilenameCar);
		} else {
			$newfilenameCar = NULL;
		}

		if (!empty($this->input->post('txtComponentCode'))) {
			$component_code_ext = $this->input->post('txtComponentCode');
		} else {
			$component_code_ext = NULL;
		}
		if (!empty($this->input->post('txtComponentName'))) {
			$component_name = $this->input->post('txtComponentName');
		} else {
			$component_name = NULL;
		}
		if (!empty($this->input->post('txtType'))) {
			$type = $this->input->post('txtType');
		} else {
			$type = NULL;
		}
		if (!empty($this->input->post('txtTanggal'))) {
			$tanggal2 = $this->input->post('txtTanggal');
			$tanggal = date('Y-m-d', strtotime($tanggal2));
		} else {
			$tanggal = NULL;
		}
		if (!empty($this->input->post('txtKronologiPerm'))) {
			$kronologi_p = $this->input->post('txtKronologiPerm');
		} else {
			$kronologi_p = NULL;
		}
		if (!empty($this->input->post('txtSeksiPenemu'))) {
			$seksi_penemu = $this->input->post('txtSeksiPenemu');
		} else {
			$seksi_penemu = NULL;
		}
		if (!empty($this->input->post('txtStatus'))) {
			$status = $this->input->post('txtStatus');
		} else {
			$status = NULL;
		}
		if (!empty($this->input->post('txtSeksiPenanggungJawab'))) {
			$seksi_penanggungjawab = $this->input->post('txtSeksiPenanggungJawab');
		} else {
			$seksi_penanggungjawab = NULL;
		}
		if (!empty($this->input->post('txtJumlah'))) {
			$jumlah = $this->input->post('txtJumlah');
		} else {
			$jumlah = NULL;
		}
		if (!empty($this->input->post('tglDistr'))) {
			$tgl_distr2 = $this->input->post('tglDistr');
			$tgl_distr = date('Y-m-d', strtotime($tgl_distr2));
		} else {
			$tgl_distr = NULL;
		}
		if (!empty($this->input->post('tglKirim'))) {
			$tgl_kirim2 = $this->input->post('tglKirim');
			$tgl_kirim = date('Y-m-d', strtotime($tgl_kirim2));
		} else {
			$tgl_kirim = NULL;
		}
		if (!empty($this->input->post('txtDueDateActCar'))) {
			$due_date2 = $this->input->post('txtDueDateActCar');
			$due_date = date('Y-m-d', strtotime($due_date2));
		} else {
			$due_date = NULL;
		}
		if (!empty($this->input->post('txtMeth'))) {
			$metode = $this->input->post('txtMeth');
		} else {
			$metode = NULL;
		}
		if (!empty($this->input->post('txtQC'))) {
			$status_fo = $this->input->post('txtQC');
		} else {
			$status_fo = NULL;
		}
		if (!empty($this->input->post('txtPoss'))) {
			$possible_fail = $this->input->post('txtPoss');
		} else {
			$possible_fail = NULL;
		}
		if (!empty($this->input->post('txtPoss'))) {
			$possible_fail = $this->input->post('txtPoss');
		} else {
			$possible_fail = NULL;
		}
		if (!empty($this->input->post('txtVendor'))) {
			$vendor = $this->input->post('txtVendor');
		} else {
			$vendor = NULL;
		}

		$dataExt = array(
			'component_code_ext'	=> $component_code_ext,
			'component_name'		=> $component_name,
			'type'					=> $type,
			'tanggal'				=> $tanggal,
			'kronologi_p'			=> $kronologi_p,
			'seksi_penemu'			=> $seksi_penemu,
			'status'				=> $status,
			'seksi_penanggungjawab'	=> $seksi_penanggungjawab,
			'jumlah'				=> $jumlah,
			'tgl_distr'				=> $tgl_distr,
			'tgl_kirim'				=> $tgl_kirim,
			'due_date'				=> $due_date,
			'metode'				=> $metode,
			'upload_qr'				=> $newfilenameQr,
			'upload_car'			=> $newfilenameCar,
			'status_fo'				=> $status_fo,
			'possible_fail'			=> $possible_fail,
			'vendor'				=> $vendor,
			'dater'					=> date("Y-m-d H:i:s")
		);
		$this->M_external->createExternal($dataExt);

		$header_id = $this->db->insert_id();
		$noUrut = $this->input->post('hdnNomorUrut[]');

		for ($i = 0; $i < sizeof($noUrut); $i++) {
			$duedate[$i] =  date('Y-m-d', strtotime($this->input->post('txtVerDueDate[' . $i . ']')));
			$real[$i] =  date('Y-m-d', strtotime($this->input->post('txtRealisasi[' . $i . ']')));
			$pic[$i] = $this->input->post('txtPic[' . $i . ']');
			$catatan[$i] = $this->input->post('txtCat[' . $i . ']');

			if ($pic[$i]) {
				$this->M_external->insQi(
					$duedate[$i],
					$real[$i],
					$pic[$i],
					$catatan[$i],
					$header_id
				);
			} else { }
		}
		
		redirect(base_url('MonitoringFlowOut/ExternalView'));
	}

	public function getCode()
	{
		$term = $this->input->get('term', TRUE);
		$term = strtoupper($term);
		$data = $this->M_external->getCode($term);
		echo json_encode($data);
	}

	public function getNameType()
	{
		$item = $this->input->POST('item');
		$data = $this->M_external->getNameType($item);

		if (!empty($data)) {
			$callback = array(
				'status' => 'success',
				'DESCRIPTION' => $data[0]['DESCRIPTION'],
				'JENIS_BARANG' => $data[0]['JENIS_BARANG']
			);
		} else {
			$callback = array('status' => 'failed');
		}
		echo json_encode($callback);
	}
}
