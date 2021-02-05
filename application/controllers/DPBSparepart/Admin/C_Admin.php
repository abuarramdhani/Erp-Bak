<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Admin extends  CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->library('encryption');
		$this->load->model('DPBSparepart/M_dpb');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		if ($this->session->userdata('logged_in') != TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			//redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if ($this->session->is_logged) {
		} else {
			redirect('');
		}
	}

	public function WaitingList()
	{

		$user = $this->session->user;

		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = 'Monitoring';
		$data['SubMenuOne'] = 'Waiting List Approve';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		// echo $this->session->responsibility_id; exit;

		$data['waiting_list'] = $this->M_dpb->getAllWaitingListApprove();

		// echo '<pre>';
		// print_r($data['waiting_list']);exit;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('DPBSparepart/Admin/V_WaitingList', $data);
		$this->load->view('V_Footer', $data);
	}

	public function ApprovedList()
	{
		$user = $this->session->user;

		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = 'Monitoring';
		$data['SubMenuOne'] = 'Approved List';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		// echo $this->session->responsibility_id; exit;

		$data['approved_list'] = $this->M_dpb->getAllApprovedList();

		// echo '<pre>';
		// print_r($data['approved_list']);exit;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('DPBSparepart/Approver/V_ApprovedList', $data);
		$this->load->view('V_Footer', $data);
	}

	public function RejectedList()
	{
		$user = $this->session->user;

		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = 'Monitoring';
		$data['SubMenuOne'] = 'Rejected List';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		// echo $this->session->responsibility_id; exit;

		$data['rejected_list'] = $this->M_dpb->getAllRejectedList();

		// echo '<pre>';
		// print_r($data['rejected_list']);exit;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('DPBSparepart/Approver/V_RejectedList', $data);
		$this->load->view('V_Footer', $data);
	}

	public function MonitoringDPB()
	{
		$user = $this->session->user;

		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = 'Monitoring';
		$data['SubMenuOne'] = 'Monitoring DPB';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		// echo $this->session->responsibility_id; exit;

		$data['monitoring_list'] = $this->M_dpb->getMonitoringList();

		// echo '<pre>';
		// print_r($data['monitoring_list']);exit;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('DPBSparepart/Approver/V_MonitoringList', $data);
		$this->load->view('V_Footer', $data);
	}

	public function InputDPB()
	{
		// $ip = $this->input->ip_address();
		// if ($ip != '192.168.168.134') {
		// 	echo 'Kami telah berusaha sebaik mungkin, halaman ini sedang dalam proses pembuatan. Silahkan kembali lagi besok atau lusa!';exit;
		// }
		$user = $this->session->user;

		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = 'Input DPB';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		// echo $this->session->responsibility_id; exit;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('DPBSparepart/Admin/V_InputDPB', $data);
		$this->load->view('V_Footer', $data);
	}

	public function checkNoDPB()
	{
		$noDPB = $_POST['noDPB'];

		$data = $this->M_dpb->checkDPB($noDPB);


		echo json_encode($data);
	}

	public function getAlamat()
	{
		$noDPB = $_POST['noDPB'];
		$data = $this->M_dpb->getAlamat($noDPB);
		echo json_encode($data);
	}

	public function listBarang()
	{
		$noDPB = $_POST['noDPB'];

		$data['list_barang'] = $this->M_dpb->listBarang($noDPB);

		$returnTable = $this->load->view('DPBSparepart/Admin/V_Table', $data, TRUE);

		echo $returnTable;
	}

	public function cekStok()
	{
		$noDPB = $_POST['noDPB'];
		$data = $this->M_dpb->cekStok($noDPB);
		echo json_encode($data);
	}

	public function cekStatusLine()
	{
		$noDPB = $_POST['noDPB'];
		$data = $this->M_dpb->cekStatusLine($noDPB);
		echo json_encode($data);
	}

	public function createDPB()
	{
		$noDPB = $_POST['noDPB'];
		$jenis = $_POST['jenis'];
		$creator = $this->session->user;
		$forward = $_POST['forward'];
		$keterangan = $_POST['keterangan'];
		$lines = $_POST['lines'];

		foreach ($lines as $line) {
			if ($line['reqQty'] != null) {
				echo '<pre>';
				print_r($line);
				$this->M_dpb->createDPBRequest($noDPB, $line['lineId'], $line['reqQty'], $creator);
			}
		}

		$this->M_dpb->createDPB($noDPB, $jenis, $creator, $forward, $keterangan);

		echo 1;
	}
}
