<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Approver extends  CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('session');
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
		$data['Menu'] = 'Approver';
		$data['SubMenuOne'] = 'Waiting List Approve';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		// echo $this->session->responsibility_id; exit;

		$data['waiting_list'] = $this->M_dpb->getWaitingListApprove($user);

		// echo '<pre>';
		// print_r($data['waiting_list']);exit;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('DPBSparepart/Approver/V_WaitingList', $data);
		$this->load->view('V_Footer', $data);
	}

	public function ApprovedList()
	{
		$user = $this->session->user;

		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = 'Approver';
		$data['SubMenuOne'] = 'Approved List';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		// echo $this->session->responsibility_id; exit;

		$data['approved_list'] = $this->M_dpb->getApprovedList($user);

		// echo '<pre>';
		// print_r($data['waiting_list']);exit;

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
		$data['Menu'] = 'Approver';
		$data['SubMenuOne'] = 'Rejected List';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		// echo $this->session->responsibility_id; exit;

		$data['rejected_list'] = $this->M_dpb->getRejectedList($user);

		// echo '<pre>';
		// print_r($data['rejected_list']);exit;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('DPBSparepart/Approver/V_RejectedList', $data);
		$this->load->view('V_Footer', $data);
	}

	public function getDetail()
	{
		$reqNumber = $_POST['reqNumber'];
		$data['detail_dpb'] = $this->M_dpb->getDetail($reqNumber);

		$return = $this->load->view('DPBSparepart/V_Table', $data, true);

		echo $return;
	}

	public function MonitoringDPB()
	{
		$user = $this->session->user;

		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = 'Approver';
		$data['SubMenuOne'] = 'Monitoring DPB';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		// echo $this->session->responsibility_id; exit;

		$monitoring_list = $this->M_dpb->getMonitoringList();

		// $ecer = array();
		// $normal = array();
		// $urgent = array();
		// for ($i = 0; $i < sizeof($monitoring_list); $i++) {
		// 	if ($monitoring_list[$i]['TIPE'] == 'ECERAN') {
		// 		array_push($ecer, $monitoring_list[$i]);
		// 	} else if ($monitoring_list[$i]['TIPE'] == 'NORMAL') {
		// 		array_push($normal, $monitoring_list[$i]);
		// 	} else if ($monitoring_list[$i]['TIPE'] == 'URGENT') {
		// 		array_push($urgent, $monitoring_list[$i]);
		// 	}
		// }

		$data['monitoring_list'] = $monitoring_list;
		// $data['monitoring_list_normal'] = $normal;
		// $data['monitoring_list_urgent'] = $urgent;


		// echo '<pre>';
		// print_r($data['monitoring_list']);exit;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('DPBSparepart/Approver/V_MonitoringList', $data);
		$this->load->view('V_Footer', $data);
	}
	public function getNormal()
	{
		$monitoring_list = $this->M_dpb->getMonitoringList();

		$normal = array();
		for ($i = 0; $i < sizeof($monitoring_list); $i++) {
			if ($monitoring_list[$i]['TIPE'] == 'NORMAL') {
				array_push($normal, $monitoring_list[$i]);
			}
		}

		$data['monitoring_list'] = $normal;

		$this->load->view('DPBSparepart/Approver/V_TblMonitoringList', $data);
	}
	public function geturgent()
	{
		$monitoring_list = $this->M_dpb->getMonitoringList();

		$urgent = array();
		for ($i = 0; $i < sizeof($monitoring_list); $i++) {
			if ($monitoring_list[$i]['TIPE'] == 'URGENT') {
				array_push($urgent, $monitoring_list[$i]);
			}
		}

		$data['monitoring_list'] = $urgent;

		$this->load->view('DPBSparepart/Approver/V_TblMonitoringList', $data);
	}
	public function geteceran()
	{
		$monitoring_list = $this->M_dpb->getMonitoringList();

		$eceran = array();
		for ($i = 0; $i < sizeof($monitoring_list); $i++) {
			if ($monitoring_list[$i]['TIPE'] == 'ECERAN') {
				array_push($eceran, $monitoring_list[$i]);
			}
		}

		$data['monitoring_list'] = $eceran;

		$this->load->view('DPBSparepart/Approver/V_TblMonitoringList', $data);
	}
	public function getbagro()
	{
		$monitoring_list = $this->M_dpb->getMonitoringList();

		$bagro = array();
		for ($i = 0; $i < sizeof($monitoring_list); $i++) {
			if ($monitoring_list[$i]['TIPE'] == 'BEST AGRO') {
				array_push($bagro, $monitoring_list[$i]);
			}
		}

		$data['monitoring_list'] = $bagro;

		$this->load->view('DPBSparepart/Approver/V_TblMonitoringList', $data);
	}
	public function getecommerce()
	{
		$monitoring_list = $this->M_dpb->getMonitoringList();

		$ecommerce = array();
		for ($i = 0; $i < sizeof($monitoring_list); $i++) {
			if ($monitoring_list[$i]['TIPE'] == 'E-COMMERCE') {
				array_push($ecommerce, $monitoring_list[$i]);
			}
		}

		$data['monitoring_list'] = $ecommerce;

		$this->load->view('DPBSparepart/Approver/V_TblMonitoringList', $data);
	}
	public function updateStatus()
	{
		$reqNumber = $_POST['reqNum'];
		$status = $_POST['status'];

		$this->M_dpb->updateStatus($reqNumber, $status);

		echo 1;
	}
	public function MdlEditEkspedisi()
	{
		$reqNumber = $_POST['req'];
		$eks = $_POST['eks'];

		$eks = '
		<div class="panel-body">
		<input type="hidden" id="reqNuMber" value ="' . $reqNumber . '"/>
			<div class="col-md-3" style="text-align:center">
				<label>Ekspedisi</label>
			</div>
			<div class="col-md-4">
				<select class="form-control" id="EkspedisiEdit" data-placeholder="Select" style="width:100%">
					<option value="' . $eks . '">' . $eks . '</option>
					<option value="ADEX">ADEX</option>
					<option value="BARANG TRUK">BARANG TRUK</option>
					<option value="INDIE">INDIE</option>
					<option value="KGP">KGP</option>
					<option value="POS KILAT KHUSUS">POS KILAT KHUSUS</option>
					<option value="QDS 1">QDS 1</option>
					<option value="QDS 2">QDS 2</option>
					<option value="SADANA">SADANA</option>
					<option value="TAM">TAM</option>
					<option value="JPM">JPM</option>
					<option value="JNE OKE">JNE OKE</option>
					<option value="JNE REGULER">JNE REGULER</option>
					<option value="JNE YES">JNE YES</option>
					<option value="JNE TRUCKING">JNE TRUCKING</option>
					<option value="J&T REGULER / EZ">J&T REGULER / EZ</option>
					<option value="J&T DFOD">J&T DFOD</option>
					<option value="TIKI ECO">TIKI ECO</option>
					<option value="TIKI REGULER">TIKI REGULER</option>
					<option value="TIKI ONS">TIKI ONS</option>
					<option value="SICEPAT GOKIL">SICEPAT GOKIL</option>
					<option value="SICEPAT REGULER">SICEPAT REGULER</option>
					<option value="SICEPAT SIUNTUNG">SICEPAT SIUNTUNG</option>
					<option value="LION PARCEL">LION PARCEL</option>
					<option value="GRAB / GOJEK">GRAB / GOJEK</option>
					<option value="PENGAMBILAN DI KANTOR">PENGAMBILAN DI KANTOR</option>
					<option value="JNE CTC YES">JNE CTC YES</option>
				</select>
			</div>
			<div class="col-md-2">
				<button class="btn btn-success" onclick="updateEkspedisi()">Update</button>
			</div>
		</div>
		';

		echo $eks;
	}
	public function UpdateEkspedisi()
	{
		$reqNumber = $_POST['req'];
		$ekspedisi = $_POST['eks'];

		$this->M_dpb->updateEkspedisi($reqNumber, $ekspedisi);
	}
}
