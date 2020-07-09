<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Order extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('SiteManagement/MainMenu/M_order');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{ 
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function OrderMasuk()
	{	$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Order Masuk';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->M_order->RejectbySystem();

		$data['list_order'] = $this->M_order->listOrder($user_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Order/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function getSeksi()
	{
		$seksi = $_GET['s'];
		$data = $this->M_order->getSeksi($seksi);
		echo json_encode($data);
	}

	public function FilterData()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Order Masuk';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$periode = $this->input->post('sm_tglorder');
		$seksi = $this->input->post('order_seksi');
		$jenis = $this->input->post('sm_jenisorder');

		if ($periode=='') {
			$tgl1 = '';
			$tgl2 = '';
		}else{
			$tanggal = explode('-', $periode);
			$tgl1 = date('Y-m-d', strtotime($tanggal[0]));
			$tgl2 = date('Y-m-d',strtotime($tanggal[1]));
		}

		if ($seksi == "") {
			$query_sk = "";
		}else{
			$query_sk = "and so.seksi_order='$seksi'";
		}

		if ($jenis == "") {
			$query_jn = "";
		}else{
			$query_jn = "and so.jenis_order='$jenis'";
		}

		$data['filterdata'] = $this->M_order->FilterDataOrder($tgl1,$tgl2,$query_sk,$query_jn);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Order/V_Index', $data);
		$this->load->view('V_Footer',$data);	 	
	}

	public function readData($id)
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Order Masuk';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['header'] = $this->M_order->ReadHeader($plaintext_string);
		$data['lines'] = $this->M_order->ReadLines($plaintext_string);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Order/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

	public function RemarkSOrder()
	{
		$id = $this->input->post('id_order');

		$this->M_order->CekStatusOrder($id);
	}

	public function RejectFromAdmin()
	{
		$id = $this->input->post('id');
		$this->M_order->RejectFromAdmin($id);
	}

	public function SimpanKeteranganOM($id)
	{
		$ket = $this->input->post('OM_keterangan');
		$this->M_order->SimpanKeteranganOM($ket,$id);
		redirect(site_url('SiteManagement/Order/OrderMasuk'));
	}

	public function DeleteOrderMasuk($id)
	{
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_order->deleteOrderMasuk($plaintext_string);

		redirect(site_url('SiteManagement/Order/OrderMasuk'));
	}
	//Order Keluar 

	//Civil Maintenanance

	public function CivilMaintenance()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Order Keluar';
		$data['SubMenuTwo'] = 'Civil Maintenance';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$id = 1;
		$data['OrderKeluar'] = $this->M_order->getOrderKeluar($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Order/V_civil_maintenance', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function createCivilMaintenance()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Order Keluar';
		$data['SubMenuTwo'] = 'Civil Maintenance';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtNoOrderHeader', 'no_order', 'required');

		$re_date = $this->input->post('txtRemarksDate');
		if ($re_date=='' || $re_date==null) {
			$date = null;
		}else{
			$date = $this->input->post('txtRemarksDate');
		}

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SiteManagement/Order/V_create_cm', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'no_order' => $this->input->post('txtNoOrderHeader'),
				'tgl_order' => $this->input->post('txtTglOrderHeader'),
				'ket_order' => $this->input->post('txtKetOrderHeader'),
				'due_date' => $this->input->post('txtDueDateHeader'),
				'remarks' => $this->input->post('chkRemarksHeader'),
				'created_date' => date('Y-m-d h:i:s'),
				'created_by' => $this->session->userid,
				'seksi_order' => 1,
				'ket_order_detail' => $this->input->post('txtKetOrderDetail'),
				'remarks_date' => $date,
    		);
			$this->M_order->setOrderKeluar($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('SiteManagement/Order/CivilMaintenance'));
		}
	}

	/* UPDATE DATA */
	public function updateCivilMaintenance($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Order Keluar';
		$data['SubMenuTwo'] = 'Civil Maintenance';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['OrderKeluar'] = $this->M_order->OrderKeluar($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtNoOrderHeader', 'no_order', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SiteManagement/Order/V_update_cm', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'no_order' => $this->input->post('txtNoOrderHeader',TRUE),
				'tgl_order' => $this->input->post('txtTglOrderHeader',TRUE),
				'ket_order' => $this->input->post('txtKetOrderHeader',TRUE),
				'due_date' => $this->input->post('txtDueDateHeader',TRUE),
				'remarks' => $this->input->post('chkRemarksHeader',TRUE),
				'created_date' => date('Y-m-d h:i:s'),
				'created_by' => $this->session->userid,
				'ket_order_detail' => $this->input->post('txtKetOrderDetail', TRUE),
				'remarks_date' => $this->input->post('txtRemarksDate', TRUE),
    			);
			$this->M_order->updateOrderKeluar($data, $plaintext_string);

			redirect(site_url('SiteManagement/Order/CivilMaintenance'));
		}
	}

    /* DELETE DATA */
    public function deleteCivilMaintenance($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_order->deleteOrderKeluar($plaintext_string);

		redirect(site_url('SiteManagement/Order/CivilMaintenance'));
    }

    //maintenance listrik

    public function MaintenanceListrik()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Order Keluar';
		$data['SubMenuTwo'] = 'Maintenance Listrik';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$id = 2;
		$data['OrderKeluar'] = $this->M_order->getOrderKeluar($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Order/V_maintenance_listrik', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function createMaintenanceListrik()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Order Keluar';
		$data['SubMenuTwo'] = 'Maintenance Listrik';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtNoOrderHeader', 'no_order', 'required');

		$re_date = $this->input->post('txtRemarksDate');
		if ($re_date=='' || $re_date==null) {
			$date = null;
		}else{
			$date = $this->input->post('txtRemarksDate');
		}

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SiteManagement/Order/V_create_cm', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'no_order' => $this->input->post('txtNoOrderHeader'),
				'tgl_order' => $this->input->post('txtTglOrderHeader'),
				'ket_order' => $this->input->post('txtKetOrderHeader'),
				'due_date' => $this->input->post('txtDueDateHeader'),
				'remarks' => $this->input->post('chkRemarksHeader'),
				'created_date' => date('Y-m-d h:i:s'),
				'created_by' => $this->session->userid,
				'seksi_order' => 2,
				'ket_order_detail' => $this->input->post('txtKetOrderDetail'),
				'remarks_date' => $date,
    		);
			$this->M_order->setOrderKeluar($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('SiteManagement/Order/MaintenanceListrik'));
		}
	}

	/* UPDATE DATA */
	public function updateMaintenanceListrik($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Order Keluar';
		$data['SubMenuTwo'] = 'Maintenance Listrik';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['OrderKeluar'] = $this->M_order->OrderKeluar($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtNoOrderHeader', 'no_order', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SiteManagement/Order/V_update_cm', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'no_order' => $this->input->post('txtNoOrderHeader',TRUE),
				'tgl_order' => $this->input->post('txtTglOrderHeader',TRUE),
				'ket_order' => $this->input->post('txtKetOrderHeader',TRUE),
				'due_date' => $this->input->post('txtDueDateHeader',TRUE),
				'remarks' => $this->input->post('chkRemarksHeader',TRUE),
				'created_date' => date('Y-m-d h:i:s'),
				'created_by' => $this->session->userid,
				'ket_order_detail' => $this->input->post('txtKetOrderDetail'),
				'remarks_date' => $this->input->post('txtRemarksDate'),
    			);
			$this->M_order->updateOrderKeluar($data, $plaintext_string);

			redirect(site_url('SiteManagement/Order/MaintenanceListrik'));
		}
	}

    /* DELETE DATA */
    public function deleteMaintenanceListrik($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_order->deleteOrderKeluar($plaintext_string);

		redirect(site_url('SiteManagement/Order/MaintenanceListrik'));
    }

	//mpa

	public function MPA()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Order Keluar';
		$data['SubMenuTwo'] = 'MPA';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$id = 3;
		$data['OrderKeluar'] = $this->M_order->getOrderKeluar($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Order/V_maintenance_pa', $data);
		$this->load->view('V_Footer',$data);
	}	

	/* NEW DATA */
	public function createMPA()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Order Keluar';
		$data['SubMenuTwo'] = 'MPA';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtNoOrderHeader', 'no_order', 'required');

		$re_date = $this->input->post('txtRemarksDate');
		if ($re_date=='' || $re_date==null) {
			$date = null;
		}else{
			$date = $this->input->post('txtRemarksDate');
		}

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SiteManagement/Order/V_create_mpa', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'no_order' => $this->input->post('txtNoOrderHeader'),
				'tgl_order' => $this->input->post('txtTglOrderHeader'),
				'ket_order' => $this->input->post('txtKetOrderHeader'),
				'due_date' => $this->input->post('txtDueDateHeader'),
				'remarks' => $this->input->post('chkRemarksHeader'),
				'created_date' => date('Y-m-d h:i:s'),
				'created_by' => $this->session->userid,
				'seksi_order' => 3,
				'ket_order_detail' => $this->input->post('txtKetOrderDetail'),
				'remarks_date' => $date,
    		);
			$this->M_order->setOrderKeluar($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('SiteManagement/Order/MPA'));
		}
	}

	/* UPDATE DATA */
	public function updateMPA($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Order Keluar';
		$data['SubMenuTwo'] = 'MPA';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['OrderKeluar'] = $this->M_order->OrderKeluar($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtNoOrderHeader', 'no_order', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SiteManagement/Order/V_update_mpa', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'no_order' => $this->input->post('txtNoOrderHeader',TRUE),
				'tgl_order' => $this->input->post('txtTglOrderHeader',TRUE),
				'ket_order' => $this->input->post('txtKetOrderHeader',TRUE),
				'due_date' => $this->input->post('txtDueDateHeader',TRUE),
				'remarks' => $this->input->post('chkRemarksHeader',TRUE),
				'created_date' => date('Y-m-d h:i:s'),
				'created_by' => $this->session->userid,
				'ket_order_detail' => $this->input->post('txtKetOrderDetail'),
				'remarks_date' => $this->input->post('txtRemarksDate'),
    			);
			$this->M_order->updateOrderKeluar($data, $plaintext_string);

			redirect(site_url('SiteManagement/Order/MPA'));
		}
	}

    /* DELETE DATA */
    public function deleteMPA($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_order->deleteOrderKeluar($plaintext_string);

		redirect(site_url('SiteManagement/Order/MPA'));
    }

	//lain-lain

	public function LainLain()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Order Keluar';
		$data['SubMenuTwo'] = 'Lain - Lain';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$id = 4;
		$data['OrderKeluar'] = $this->M_order->getOrderKeluar($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Order/V_lain_lain', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function createLainLain()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Order Keluar';
		$data['SubMenuTwo'] = 'Lain - Lain';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtNoOrderHeader', 'no_order', 'required');

		$re_date = $this->input->post('txtRemarksDate');
		if ($re_date=='' || $re_date==null) {
			$date = null;
		}else{
			$date = $this->input->post('txtRemarksDate');
		}

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SiteManagement/Order/V_create_ll', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'no_order' => $this->input->post('txtNoOrderHeader'),
				'tgl_order' => $this->input->post('txtTglOrderHeader'),
				'ket_order' => $this->input->post('txtKetOrderHeader'),
				'due_date' => $this->input->post('txtDueDateHeader'),
				'remarks' => $this->input->post('chkRemarksHeader'),
				'created_date' => date('Y-m-d h:i:s'),
				'created_by' => $this->session->userid,
				'seksi_order' => 4,
				'ket_order_detail' => $this->input->post('txtKetOrderDetail'),
				'remarks_date' => $date,
    		);
			$this->M_order->setOrderKeluar($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('SiteManagement/Order/LainLain'));
		}
	}

	/* UPDATE DATA */
	public function updateLainLain($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Order Keluar';
		$data['SubMenuTwo'] = 'Lain - Lain';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['OrderKeluar'] = $this->M_order->OrderKeluar($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtNoOrderHeader', 'no_order', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SiteManagement/Order/V_update_ll', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'no_order' => $this->input->post('txtNoOrderHeader',TRUE),
				'tgl_order' => $this->input->post('txtTglOrderHeader',TRUE),
				'ket_order' => $this->input->post('txtKetOrderHeader',TRUE),
				'due_date' => $this->input->post('txtDueDateHeader',TRUE),
				'remarks' => $this->input->post('chkRemarksHeader',TRUE),
				'created_date' => date('Y-m-d h:i:s'),
				'created_by' => $this->session->userid,
				'ket_order_detail' => $this->input->post('txtKetOrderDetail'),
				'remarks_date' => $this->input->post('txtRemarksDate'),
    			);
			$this->M_order->updateOrderKeluar($data, $plaintext_string);

			redirect(site_url('SiteManagement/Order/LainLain'));
		}
	}

    /* DELETE DATA */
    public function deleteLainLain($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_order->deleteOrderKeluar($plaintext_string);

		redirect(site_url('SiteManagement/Order/LainLain'));
    }

    public function allSeksi()
    {	
    	$lokasi  = strtoupper($this->input->get('lokasi', TRUE));
    	$term 	 	=	strtoupper($this->input->get('term', TRUE));
    	$allSeksi = $this->M_order->allSeksi($term, $lokasi);
    	echo json_encode($allSeksi);
    }

    public function allLokasi()
    {
    	$term 	 	=	strtoupper($this->input->get('term', TRUE));
    	$allSeksi = $this->M_order->allLokasi($term);
    	echo json_encode($allSeksi);
    }

}