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
      $this->session->set_userdata('last_page', current_url());
      $this->session->set_userdata('Responsbility', 'some_value');
      redirect();
    }
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
    $percentage = $judged === 0 && $total === 0 ? 100 : round($judged / $total * 100);

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
      base_url('OrderKebutuhanBarangDanJasa/Pengelola/OpenedOrderSusulan')
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
    $this->load->view('V_Footer', $data);
  }

  public function directEmail($key)
  {
    $decrypt = str_replace(array('-', '_', '~'), array('+', '/', '='), $key);
    $decrypt = $this->encrypt->decode($decrypt);
    
    $user = $this->index->getDetail($decrypt);
      
    foreach($user as $user_item){
      $iduser       = $user_item->user_id;
      $password_default   = $user_item->password_default;
      $kodesie      = $user_item->section_code;
      $employee_name     = $user_item->employee_name; 
      $kode_lokasi_kerja   = $user_item->location_code;
    }
    $ses = array(
            'is_logged'     => 1,
            'userid'       => $iduser,
            'user'         => $decrypt,
            'employee'      => $employee_name,
            'kodesie'       => $kodesie,
            'kode_lokasi_kerja'  => $kode_lokasi_kerja,
          );
    $this->session->set_userdata($ses);

    $UserResponsibility = $this->user->getUserResponsibility($iduser, 2679);
    if (count($UserResponsibility)==0) {
      $UserResponsibility = $this->user->getUserResponsibility($iduser, 2681);
      
    }

    foreach($UserResponsibility as $UserResponsibility_item){
      $this->session->set_userdata('responsibility', $UserResponsibility_item['user_group_menu_name']);
      // if(empty($UserResponsibility_item['user_group_menu_id'])){
        // $UserResponsibility_item['user_group_menu_id'] = 0;
      // }
      $this->session->set_userdata('responsibility_id', $UserResponsibility_item['user_group_menu_id']);
      $this->session->set_userdata('module_link', $UserResponsibility_item['module_link']);
      $this->session->set_userdata('org_id', $UserResponsibility_item['org_id']);
    }

        $this->checkSession();
        
    $user_id = $this->session->userid;
    
    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';

    // print_r($this->session->responsibility_id);exit;
    
    $data['UserMenu'] = $this->user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->user->getMenuLv3($user_id,$this->session->responsibility_id);

    if (count($UserResponsibility)==0) {
      // $resp = $this->session->userdata['responsibility'];
      echo '<b>ERROR :</b> User ini tidak mempunyai akses ke aplikasi Order Kebutuhan barang Dan Jasa, silahkan tambahkan terlebih  dahulu agar ERP bisa diakses menggunakan akun ini!';
      exit;
    }
    
    $data['normal'] = array();
    $data['urgent'] = array();
    $data['susulan'] = array();

    $noind = $this->session->user;
    // $noind = '6355';
		$data['approver'] = $this->requisition->getPersonId($noind);

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    // if ($this->session->responsibility_id == 2664 || $this->session->responsibility_id == 2665) {
      $allOrder = $this->approver->getListDataOrder();
      
      foreach ($allOrder as $key => $order) {
        $checkOrder = $this->approver->checkOrder($order['ORDER_ID']);
        // echo'<pre>';
        // print_r($checkOrder);
        if (isset($checkOrder[0])) {
          if ($this->session->responsibility_id == 2681) {
            if ($checkOrder[0]['APPROVER_ID'] == $data['approver'][0]['PERSON_ID'] && $checkOrder[0]['APPROVER_TYPE'] == 7 ) {
              $orderSiapTampil = $this->approver->getOrderToApprove($order['ORDER_ID']);
              if ($orderSiapTampil[0]['ORDER_CLASS'] != '2') {
                if ($orderSiapTampil[0]['URGENT_FLAG'] == 'N' && $orderSiapTampil[0]['IS_SUSULAN'] =='N') {
                  array_push($data['normal'], $orderSiapTampil[0]);
                }elseif ($orderSiapTampil[0]['URGENT_FLAG'] == 'Y' && $orderSiapTampil[0]['IS_SUSULAN'] =='N') {
                  array_push($data['urgent'], $orderSiapTampil[0]);
                }elseif ($orderSiapTampil[0]['IS_SUSULAN'] =='Y') {
                  array_push($data['susulan'], $orderSiapTampil[0]);
                }
              }
            }
          }else{
            if ($checkOrder[0]['APPROVER_ID'] == $data['approver'][0]['PERSON_ID'] && $checkOrder[0]['APPROVER_TYPE'] != 7 ) {
              $orderSiapTampil = $this->approver->getOrderToApprove($order['ORDER_ID']);
              if ($orderSiapTampil[0]['ORDER_CLASS'] != '2') {
                if ($orderSiapTampil[0]['URGENT_FLAG'] == 'N' && $orderSiapTampil[0]['IS_SUSULAN'] =='N') {
                  array_push($data['normal'], $orderSiapTampil[0]);
                }elseif ($orderSiapTampil[0]['URGENT_FLAG'] == 'Y' && $orderSiapTampil[0]['IS_SUSULAN'] =='N') {
                  array_push($data['urgent'], $orderSiapTampil[0]);
                }elseif ($orderSiapTampil[0]['IS_SUSULAN'] =='Y') {
                  array_push($data['susulan'], $orderSiapTampil[0]);
                }
              }
            }
          }
        }


      }

      // $data['normalBelum'] = array();
      // $data['urgentBelum'] = array();
      // $data['susulanBelum'] = array();
      // $data['normalSelesai'] = array();
      // $data['urgentSelesai'] = array();
      // $data['susulanSelesai'] = array();

      $data['normalOrder'] = $this->approver->getDetailOrderNormalTotal($data['approver'][0]['PERSON_ID']);
      // foreach ($normalOrder as $key => $normal) {
      //   if ($normal['JUDGEMENT'] == null) {
      //     array_push($data['normalBelum'], $normalOrder[$key]);
      //   }elseif ($normal['JUDGEMENT'] != null) {
      //     array_push($data['normalSelesai'], $normalOrder[$key]);
      //   }
      // }
      $data['urgentOrder'] = $this->approver->getDetailOrderUrgentTotal($data['approver'][0]['PERSON_ID']);
      
      $data['susulanOrder'] = $this->approver->getDetailOrderSusulanTotal($data['approver'][0]['PERSON_ID']);
      
      
      $this->load->view('OrderKebutuhanBarangDanJasa/V_Index',$data);
    // }else {
    //   $this->load->view('OrderKebutuhanBarangDanJasa/V_Index2',$data);
    // }
        $this->load->view('V_Footer',$data);
    }
}

