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
		$this->load->model('KapasitasGdSparepart/M_arsip');
		$this->load->model('KapasitasGdSparepart/M_packing');
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
		$org_id = $this->M_dpb->getOrgID($noDPB);

		$data[0]['ORG_ID'] = $org_id[0]['ORGANIZATION_ID'];
		$data[0]['SUBINV'] = $org_id[0]['SUBINV'];

		echo json_encode($data);
	}

	public function listBarang()
	{
		$noDPB = $_POST['noDPB'];
		$org = $_POST['org'];
		$subinv = $_POST['subinv'];


		$data['list_barang'] = $this->M_dpb->listBarang($noDPB, $org, $subinv);

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
		$org = $_POST['org'];
		$subinv = $_POST['subinv'];
		$data = $this->M_dpb->cekStatusLine($noDPB, $org, $subinv);
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
		$ekspedisi = $_POST['ekspedisi'];
		$alamat_kirim = $_POST['alamat_kirim'];
		$org = $_POST['org'];
		$subinv = $_POST['subinv'];



		foreach ($lines as $line) {
			if ($line['reqQty'] != null) {
				echo '<pre>';
				print_r($line);
				$this->M_dpb->createDPBRequest($noDPB, $line['lineId'], $line['reqQty'], $creator);
			}
		}

		$this->M_dpb->createDPB($noDPB, $jenis, $creator, $forward, $keterangan, $alamat_kirim, $ekspedisi, $org, $subinv);

		echo 1;
	}

	public function reSubmitDPB()
	{
		$noDPB = $_POST['id'];
		print_r($noDPB);
		$this->M_dpb->reSubmitDPB($noDPB);
	}
	public function ArsipSPBDO()
	{
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
		$this->load->view('DPBSparepart/Admin/V_ArsipDpb', $data);
		$this->load->view('V_Footer', $data);
	}
	public function getArsipDPB()
	{
		$datenow = date('d/m/Y');
		$datebefore = date('d/m/Y', strtotime('- 30 days'));


		$getdata = $this->M_dpb->getDataArsipSPB($datebefore, $datenow);

		for ($i = 0; $i < sizeof($getdata); $i++) {
			$coly = $this->M_packing->cekPacking($getdata[$i]['NO_DOKUMEN']);
			$getdata[$i]['COLY'] = count($coly);
			$tgl_dibuat = strtotime($getdata[$i]['TGL_DIBUAT']);
			$selesai_packing = strtotime($getdata[$i]['PACKING_SELESAI']);
			$datediff = $selesai_packing - $tgl_dibuat;

			$getdata[$i]['TOTAL_WAKTU_PROSES'] = round($datediff / (60 * 60 * 24));
		}
		// echo "<pre>";
		// print_r($getdata);
		// exit();


		$data['getdata'] = $getdata;

		$this->load->view('DPBSparepart/Admin/V_ListArsip', $data);
	}
	public function getArsipDPBbyDate()
	{
		$datefrom = $_POST['datefrom'];
		$dateto = $_POST['dateto'];

		$datefrom2 = $_POST['dateinput1'];
		$dateto2 = $_POST['dateinput2'];

		if ($datefrom == null || $dateto == null) {
			$getdata = $this->M_dpb->getDataArsipSPB($datefrom2, $dateto2);
			$data['periode_arsip'] = $datefrom2 . ' - ' . $dateto2;
		} else if ($datefrom != null && $dateto != null) {
			if ($datefrom2 == null || $dateto2 == null) {
				$data['periode_arsip'] = $datefrom . ' - ' . $dateto;
				$getdata = $this->M_dpb->getDataSPB3($datefrom, $dateto);
			} else {
				$data['periode_arsip'] = $datefrom2 . ' - ' . $dateto2;
				$getdata = $this->M_dpb->getDataArsipSPB2($datefrom, $dateto, $datefrom2, $dateto2);
			}
		} else if ($datefrom2 == null || $dateto2 == null) {
			$data['periode_arsip'] = $datefrom . ' - ' . $dateto;
			$getdata = $this->M_dpb->getDataSPB3($datefrom, $dateto);
		}

		for ($i = 0; $i < sizeof($getdata); $i++) {
			$coly = $this->M_packing->cekPacking($getdata[$i]['NO_DOKUMEN']);
			$getdata[$i]['COLY'] = count($coly);
			$tgl_dibuat = strtotime($getdata[$i]['TGL_DIBUAT']);
			$selesai_packing = strtotime($getdata[$i]['PACKING_SELESAI']);
			$datediff = $selesai_packing - $tgl_dibuat;

			$getdata[$i]['TOTAL_WAKTU_PROSES'] = round($datediff / (60 * 60 * 24));
		}

		$data['getdata'] = $getdata;

		$this->load->view('DPBSparepart/Admin/V_ListArsip', $data);
	}
}
