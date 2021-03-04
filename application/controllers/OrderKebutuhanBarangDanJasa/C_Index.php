<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_Index', 'index');  
    $this->load->model('SystemAdministration/MainMenu/M_user', 'user');
    $this->load->model('OrderKebutuhanBarangDanJasa/Approver/M_approver', 'approver');
    $this->load->model('OrderKebutuhanBarangDanJasa/Pengelola/M_pengelola', 'pengelola');
		$this->load->model('OrderKebutuhanBarangDanJasa/Puller/M_puller', 'puller');
    $this->load->model('OrderKebutuhanBarangDanJasa/Purchasing/M_purchasing', 'purchasing');
    $this->load->model('OrderKebutuhanBarangDanJasa/Requisition/M_requisition', 'requisition');
  }

  private function checkSession()
  {
    if (!$this->session->is_logged) {
      redirect();
    }
  }

  private function decrypt($encrypted_value)
  {
    $removed_salt = str_replace(['-', '_', '~'], ['+', '/', '='], $encrypted_value);
    $decoded_value = $this->encrypt->decode($removed_salt);

    return $decoded_value;
  }

  private function login($nomor_induk)
  {
    $user_detail = $this->index->getDetail($nomor_induk)[0];

    $user_session = [
      'is_logged' => 1,
      'userid' => $user_detail->user_id,
      'user' => $nomor_induk,
      'employee' => $user_detail->employee_name,
      'kodesie' => $user_detail->section_code,
      'kode_lokasi_kerja' => $user_detail->location_code,
    ];

    $this->session->set_userdata($user_session);
  }

  private function setActiveResponsibility($user_responsibility)
  {
    $responsibility_session = [
      'responsibility' => $user_responsibility->user_group_menu_name,
      'responsibility_id' => $user_responsibility->user_group_menu_id,
      'module_link' => $user_responsibility ->module_link,
      'org_id' => $user_responsibility->org_id,
    ];

    $this->session->set_userdata($responsibility_session);
  }

  public function index()
  {
    $this->checkSession();

    if ($this->session->responsibility === '(Approver)Order Kebutuhan Barang dan Jasa') {
      $this->approverDashboard();
    } else if ($this->session->responsibility === '(Pengelola)Order Kebutuhan Barang dan Jasa') {
      $this->pengelolaDashboard();
    } else if ($this->session->responsibility === '(Puller)Order Kebutuhan Barang dan Jasa') {
      $this->pullerDashboard();
    } else if ($this->session->responsibility === '(Purchasing)Order Kebutuhan Barang dan Jasa') {
      $this->purchasingDashboard();
    } else {
			$this->defaultDashboard();
		}
  }

  private function getUserMenu()
  {    
    $user_id = $this->session->userid;
    $resp_id = $this->session->responsibility_id;

    return (object) [
			'UserMenu' => $this->user->getUserMenu($user_id, $resp_id),
			'UserSubMenuOne' => $this->user->getMenuLv2($user_id, $resp_id),
			'UserSubMenuTwo' => $this->user->getMenuLv3($user_id, $resp_id),
		];
  }

  private function getOrderInformation($unapproved, $judged, $url)
  {
    $total = $unapproved + $judged;
    $percentage = $judged === 0 && $total === 0 ? 100 : floor($judged / $total * 100);

    return (object) [
      'Unapproved' => $unapproved,
      'Total' => $total,
      'Percentage' => $percentage,
      'URL' => $url,
    ];
  }

	public function defaultDashboard()
	{
		$view_data = $this->getUserMenu();
		
    $view_data->Menu = 'Dashboard';
		$view_data->SubMenuOne = '';

    $this->load->view('V_Header', $view_data);
    $this->load->view('V_Sidemenu', $view_data);
    $this->load->view('OrderKebutuhanBarangDanJasa/V_IndexDefault', $view_data);
    $this->load->view('V_Footer', $view_data);
	}

  public function approverDashboard()
  {
    $nomor_induk = $this->session->user;
    $view_data = $this->getUserMenu();

    $view_data->Menu = 'Dashboard';
    $view_data->SubMenuOne = '';

    $view_data->RegulerOrder = $this->getOrderInformation(
      $this->approver->getUnapprovedOrderCount($nomor_induk, 'NORMAL'),
      $this->approver->getJudgedOrderCount($nomor_induk, 'NORMAL'),
      base_url('OrderKebutuhanBarangDanJasa/Approver/PermintaanApproveNormal')
    );

    $view_data->EmergencyOrder = $this->getOrderInformation(
      $this->approver->getUnapprovedOrderCount($nomor_induk, 'SUSULAN'),
      $this->approver->getJudgedOrderCount($nomor_induk, 'SUSULAN'),
      base_url('OrderKebutuhanBarangDanJasa/Approver/PermintaanApproveSusulan')
    );

    $view_data->UrgentOrder = $this->getOrderInformation(
      $this->approver->getUnapprovedOrderCount($nomor_induk, 'URGENT'),
      $this->approver->getJudgedOrderCount($nomor_induk, 'URGENT'),
      base_url('OrderKebutuhanBarangDanJasa/Approver/PermintaanApproveUrgent')
    );

    $this->load->view('V_Header', $view_data);
    $this->load->view('V_Sidemenu', $view_data);
    $this->load->view('OrderKebutuhanBarangDanJasa/V_Index', $view_data);
    $this->load->view('V_Footer', $view_data);
  }

  public function pengelolaDashboard()
  {
    $nomor_induk = $this->session->user;
    $view_data = $this->getUserMenu();

    $view_data->Menu = 'Dashboard';
    $view_data->SubMenuOne = '';

    $view_data->RegulerOrder = $this->getOrderInformation(
      $this->pengelola->getUnapprovedOrderCount($nomor_induk, 'NORMAL'),
      $this->pengelola->getJudgedOrderCount($nomor_induk, 'NORMAL'),
      base_url('OrderKebutuhanBarangDanJasa/Pengelola/OpenedOrderNormal')
    );

    $view_data->EmergencyOrder = $this->getOrderInformation(
      $this->pengelola->getUnapprovedOrderCount($nomor_induk, 'SUSULAN'),
      $this->pengelola->getJudgedOrderCount($nomor_induk, 'SUSULAN'),
      base_url('OrderKebutuhanBarangDanJasa/Pengelola/OpenedOrderSusulan')
    );

    $view_data->UrgentOrder = $this->getOrderInformation(
      $this->pengelola->getUnapprovedOrderCount($nomor_induk, 'URGENT'),
      $this->pengelola->getJudgedOrderCount($nomor_induk, 'URGENT'),
      base_url('OrderKebutuhanBarangDanJasa/Pengelola/OpenedOrderUrgent')
    );

    $this->load->view('V_Header', $view_data);
    $this->load->view('V_Sidemenu', $view_data);
    $this->load->view('OrderKebutuhanBarangDanJasa/V_Index', $view_data);
    $this->load->view('V_Footer', $view_data);
  }

  public function pullerDashboard()
  {
    $nomor_induk = $this->session->user;
    $view_data = $this->getUserMenu();

    $view_data->Menu = 'Dashboard';
    $view_data->SubMenuOne = '';

    $view_data->RegulerOrder = $this->getOrderInformation(
      $this->puller->getUnapprovedOrderCount($nomor_induk, 'NORMAL'),
      $this->puller->getJudgedOrderCount($nomor_induk, 'NORMAL'),
      base_url('OrderKebutuhanBarangDanJasa/Puller/ListOrderNormal')
    );

    $view_data->EmergencyOrder = $this->getOrderInformation(
      $this->puller->getUnapprovedOrderCount($nomor_induk, 'SUSULAN'),
      $this->puller->getJudgedOrderCount($nomor_induk, 'SUSULAN'),
			base_url('OrderKebutuhanBarangDanJasa/Puller/ListOrderSusulan')
    );

    $view_data->UrgentOrder = $this->getOrderInformation(
      $this->puller->getUnapprovedOrderCount($nomor_induk, 'URGENT'),
      $this->puller->getJudgedOrderCount($nomor_induk, 'URGENT'),
			base_url('OrderKebutuhanBarangDanJasa/Puller/ListOrderUrgent')
    );

    $this->load->view('V_Header', $view_data);
    $this->load->view('V_Sidemenu', $view_data);
    $this->load->view('OrderKebutuhanBarangDanJasa/V_Index', $view_data);
    $this->load->view('V_Footer', $view_data);
  }

  public function purchasingDashboard()
  {
    $view_data = $this->getUserMenu();

    $view_data->Menu = 'Dashboard';
    $view_data->SubMenuOne = '';

    $view_data->RegulerOrder = $this->getOrderInformation(
      $this->purchasing->getUnapprovedOrderCount('NORMAL'),
      $this->purchasing->getJudgedOrderCount('NORMAL'),
      base_url('OrderKebutuhanBarangDanJasa/Purchasing/PermintaanApprove')
    );

    $view_data->EmergencyOrder = $this->getOrderInformation(
      $this->purchasing->getUnapprovedOrderCount('SUSULAN'),
      $this->purchasing->getJudgedOrderCount('SUSULAN'),
			base_url('OrderKebutuhanBarangDanJasa/Purchasing/PermintaanApprove')
    );

    $view_data->UrgentOrder = $this->getOrderInformation(
      $this->purchasing->getUnapprovedOrderCount('URGENT'),
      $this->purchasing->getJudgedOrderCount('URGENT'),
			base_url('OrderKebutuhanBarangDanJasa/Purchasing/PermintaanApprove')
    );

    $this->load->view('V_Header', $view_data);
    $this->load->view('V_Sidemenu', $view_data);
    $this->load->view('OrderKebutuhanBarangDanJasa/V_Index', $view_data);
    $this->load->view('V_Footer', $view_data);
  }

  public function directEmail($key)
  {
    $nomor_induk = $this->decrypt($key);

    $this->login($nomor_induk);

    $approver_responsibility = $this->user->getUserResponsibility($this->session->userid, 2679);
    $pengelola_responsibility = $this->user->getUserResponsibility($this->session->userid, 2681);
    $has_approver_responsibility = count($approver_responsibility) > 0;
    $has_pengelola_responsibility = count($pengelola_responsibility) > 0;

    if ($has_approver_responsibility) {
      $approver_responsibility = (object) $approver_responsibility[0];
      $this->setActiveResponsibility($approver_responsibility);
    } else if ($has_pengelola_responsibility) {
      $pengelola_responsibility = (object) $pengelola_responsibility[0];
      $this->setActiveResponsibility($pengelola_responsibility);
    } else {
      redirect(base_url());
    }

    redirect(base_url('OrderKebutuhanBarangDanJasa'));
  }
}
