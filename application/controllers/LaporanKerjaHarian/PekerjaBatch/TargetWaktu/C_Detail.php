<?php defined('BASEPATH') OR exit('No direct script access allowed');

class C_Detail extends CI_Controller {
	
	function __construct() {
		parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('LaporanKerjaHarian/PekerjaBatch/M_lkhtargetwaktu');
		if($this->session->userdata('logged_in') != TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }

	public function index() {
		if(!$this->session->is_logged) { redirect(''); }
		$user_id = $this->session->userid;
		$data['filterPeriode'] = (empty($this->input->post('filterPeriode'))) ? date('m/Y') : $this->input->post('filterPeriode');
		$data['filterPekerja'] = $this->input->post('filterPekerja');
		if(empty($data['filterPekerja'])) { echo('Terjadi kesalahan saat memuat detail data LKH. [ID Pekerja tidak ditemukan].'); exit(); }

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		$data['Menu'] = $data['UserMenu'][0]['menu_title'];
		$data['Title'] = 'Detail Data LKH Pekerja';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['EmployeeInfo'] = $data['filterPekerja'] .' - '. $this->M_lkhtargetwaktu->getEmployeeName($data['filterPekerja']);
		$data['EmployeeName'] = $this->M_lkhtargetwaktu->getEmployeeName($data['filterPekerja']);
		$data['dateList'] = $this->M_lkhtargetwaktu->getShiftDateList($data['filterPeriode'], $data['filterPekerja']);
		$data['dataList'] = $this->M_lkhtargetwaktu->getLkhDetailDataList($data['filterPeriode'], $data['filterPekerja']);
		$data['recordPekerjaan'] = $this->M_lkhtargetwaktu->getRecordPekerjaanDetailLkh($data['filterPeriode'], $data['filterPekerja']);
		$data['nilaiInsentifKondite'] = $this->M_lkhtargetwaktu->getNilaiInsentifKonditeDetailLkh($data['filterPeriode'], $data['filterPekerja']);
		$data['warningSP'] = $this->M_lkhtargetwaktu->getWarningSpDetailLkh($data['filterPeriode'], $data['filterPekerja']);
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('LaporanKerjaHarian/PekerjaBatch/TargetWaktu/V_Detail', $data);
		$this->load->view('V_Footer', $data);
	}

	public function getData() {
		$lkh_id = $this->input->post('lkh_id');
		$column = $this->input->post('column');
		$value = $this->input->post('value');
		$response['status'] = 'error';
		if(isset($lkh_id) && isset($column)) { if($this->M_lkhtargetwaktu->getDataLkhDetailCell($lkh_id, $column, $value)) { $response['status'] = 'success'; } }
		echo json_encode($response);
	}

	public function getGolKondite() {
		$lkh_id = $this->input->post('lkh_id');
		$response['status'] = 'error';
		if(isset($lkh_id)) { $gol_kondite = $this->M_lkhtargetwaktu->getGolKonditeLkhDetailCell($lkh_id); if(isset($gol_kondite)) { $response['status'] = 'success'; $response['gol_kondite'] = $gol_kondite; } }
		echo json_encode($response);
	}
}