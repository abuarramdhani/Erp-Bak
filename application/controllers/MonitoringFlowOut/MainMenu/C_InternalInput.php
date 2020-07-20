<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_InternalInput extends CI_Controller
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
		$this->load->model('MonitoringFlowOut/M_internal');
		$this->load->model('MonitoringFlowOut/M_master');

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

		$data['Title'] = 'Internal Input';
		$data['Menu'] = 'Internal Input';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['fail'] = $this->M_master->getPoss();
		$data['seksi'] = $this->M_master->getSeksi();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MonitoringFlowOut/Internal/V_IntInput', $data);
		$this->load->view('V_Footer', $data);
	}

	public function create()
	{
		$arrPJ = $this->input->post('txtSeksiPenanggungJawab[]');
		$txtSeksiPenanggungJawab = implode(",", $arrPJ);

		if ($_FILES['upQr']['name'] != '') {
			$temp = explode(".", $_FILES["upQr"]["name"]);
			$newfilenameQr = "upQr_" . date('d-M-Y_h-i-a') . '.' . end($temp);
			mkdir('./assets/upload/MonitoringFlowOut/uploadQr/', 0777, true);
			move_uploaded_file($_FILES["upQr"]["tmp_name"], "./assets/upload/MonitoringFlowOut/uploadQr/" . $newfilenameQr);
			chmod('./assets/upload/MonitoringFlowOut/uploadQr/'.$newfilenameQr, 0777);
		} else {
			$newfilenameQr = NULL;
		}
		if ($_FILES['upCar']['name'] != '') {
			$temp = explode(".", $_FILES["upCar"]["name"]);
			$newfilenameCar = "upCar_" . date('d-M-Y_h-i-a') . '.' . end($temp);
			mkdir('./assets/upload/MonitoringFlowOut/uploadCar/', 0777, true);
			move_uploaded_file($_FILES["upCar"]["tmp_name"], "./assets/upload/MonitoringFlowOut/uploadCar/" . $newfilenameCar);
			chmod('./assets/upload/MonitoringFlowOut/uploadCar/' . $newfilenameCar, 0777);
		} else {
			$newfilenameCar = NULL;
		}
		if (!empty($this->input->post('txtComponentCode'))) {
			$component_code_int = $this->input->post('txtComponentCode');
		} else {
			$component_code_int = NULL;
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
		if (!empty($txtSeksiPenanggungJawab)) {
			$seksi_penanggungjawab = $txtSeksiPenanggungJawab;
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
		$dataInt = array(
			'component_code_int'	=> $component_code_int,
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
			'dater'					=> date("Y-m-d H:i:s")
		);

		$this->M_internal->createInternal($dataInt);

		$header_id = $this->db->insert_id();
		$noUrut = $this->input->post('hdnNomorUrut[]');

		for ($i = 0; $i < sizeof($noUrut); $i++) {
			$duedate[$i] =  date('Y-m-d', strtotime($this->input->post('txtVerDueDate[' . $i . ']')));
			$real[$i] =  date('Y-m-d', strtotime($this->input->post('txtRealisasi[' . $i . ']')));
			$pic[$i] = $this->input->post('txtPic[' . $i . ']');
			$catatan[$i] = $this->input->post('txtCat[' . $i . ']');

			if ($pic[$i]) {
				$this->M_internal->insQi(
					$duedate[$i],
					$real[$i],
					$pic[$i],
					$catatan[$i],
					$header_id
				);
			} else { }
		}

		redirect(base_url('MonitoringFlowOut/InternalView'));
	}

	public function getCode()
	{
		$term = $this->input->get('term', TRUE);
		$term = strtoupper($term);
		$data = $this->M_internal->getCode($term);
		echo json_encode($data);
	}

	public function getNameType()
	{
		$item = $this->input->POST('item');
		$data = $this->M_internal->getNameType($item);

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
