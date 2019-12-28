<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->model('M_Index');		  
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('OrderKebutuhanBarangDanJasa/Approver/M_approver');
		$this->load->model('OrderKebutuhanBarangDanJasa/Requisition/M_requisition');
        	  
		 if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		 }
	}

	public function index()
	{
        $this->checkSession();
        
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['normal'] = array();
		$data['urgent'] = array();
		$data['susulan'] = array();

		$noind = $this->session->user;
		// $noind = '6355';
		$data['approver'] = $this->M_requisition->getPersonId($noind);
     
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		if ($this->session->responsibility_id == 2679 || $this->session->responsibility_id == 2681) {
			$allOrder = $this->M_approver->getListDataOrder();
			
			foreach ($allOrder as $key => $order) {
				$checkOrder = $this->M_approver->checkOrder($order['ORDER_ID']);
				// echo'<pre>';
				// print_r($checkOrder);
				if (isset($checkOrder[0])) {
					if ($checkOrder[0]['APPROVER_ID'] == $data['approver'][0]['PERSON_ID']) {
						$orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
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

			// $data['normalBelum'] = array();
			// $data['urgentBelum'] = array();
			// $data['susulanBelum'] = array();
			// $data['normalSelesai'] = array();
			// $data['urgentSelesai'] = array();
			// $data['susulanSelesai'] = array();

			$data['normalOrder'] = $this->M_approver->getDetailOrderNormalTotal($data['approver'][0]['PERSON_ID']);
			// foreach ($normalOrder as $key => $normal) {
			// 	if ($normal['JUDGEMENT'] == null) {
			// 		array_push($data['normalBelum'], $normalOrder[$key]);
			// 	}elseif ($normal['JUDGEMENT'] != null) {
			// 		array_push($data['normalSelesai'], $normalOrder[$key]);
			// 	}
			// }
			$data['urgentOrder'] = $this->M_approver->getDetailOrderUrgentTotal($data['approver'][0]['PERSON_ID']);
			
			$data['susulanOrder'] = $this->M_approver->getDetailOrderSusulanTotal($data['approver'][0]['PERSON_ID']);
			
			
			$this->load->view('OrderKebutuhanBarangDanJasa/V_Index',$data);
		}else {
			$this->load->view('OrderKebutuhanBarangDanJasa/V_Index2',$data);
		}
        $this->load->view('V_Footer',$data);
    }

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}

	public function directEmail($key)
	{
		$decrypt = str_replace(array('-', '_', '~'), array('+', '/', '='), $key);
		$decrypt = $this->encrypt->decode($decrypt);
		
		$user = $this->M_Index->getDetail($decrypt);
			
		foreach($user as $user_item){
			$iduser 			= $user_item->user_id;
			$password_default 	= $user_item->password_default;
			$kodesie			= $user_item->section_code;
			$employee_name 		= $user_item->employee_name; 
			$kode_lokasi_kerja 	= $user_item->location_code;
		}
		$ses = array(
						'is_logged' 		=> 1,
						'userid' 			=> $iduser,
						'user' 				=> $decrypt,
						'employee'  		=> $employee_name,
						'kodesie' 			=> $kodesie,
						'kode_lokasi_kerja'	=> $kode_lokasi_kerja,
					);
		$this->session->set_userdata($ses);

		$UserResponsibility = $this->M_user->getUserResponsibility($iduser, 2664);
		if (count($UserResponsibility)==0) {
			$UserResponsibility = $this->M_user->getUserResponsibility($iduser, 2665);
			
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
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

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
		$data['approver'] = $this->M_requisition->getPersonId($noind);
     
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		// if ($this->session->responsibility_id == 2679 || $this->session->responsibility_id == 2681) {
			$allOrder = $this->M_approver->getListDataOrder();
			
			foreach ($allOrder as $key => $order) {
				$checkOrder = $this->M_approver->checkOrder($order['ORDER_ID']);
				// echo'<pre>';
				// print_r($checkOrder);
				if (isset($checkOrder[0])) {
					if ($checkOrder[0]['APPROVER_ID'] == $data['approver'][0]['PERSON_ID']) {
						$orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
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

			// $data['normalBelum'] = array();
			// $data['urgentBelum'] = array();
			// $data['susulanBelum'] = array();
			// $data['normalSelesai'] = array();
			// $data['urgentSelesai'] = array();
			// $data['susulanSelesai'] = array();

			$data['normalOrder'] = $this->M_approver->getDetailOrderNormalTotal($data['approver'][0]['PERSON_ID']);
			// foreach ($normalOrder as $key => $normal) {
			// 	if ($normal['JUDGEMENT'] == null) {
			// 		array_push($data['normalBelum'], $normalOrder[$key]);
			// 	}elseif ($normal['JUDGEMENT'] != null) {
			// 		array_push($data['normalSelesai'], $normalOrder[$key]);
			// 	}
			// }
			$data['urgentOrder'] = $this->M_approver->getDetailOrderUrgentTotal($data['approver'][0]['PERSON_ID']);
			
			$data['susulanOrder'] = $this->M_approver->getDetailOrderSusulanTotal($data['approver'][0]['PERSON_ID']);
			
			
			$this->load->view('OrderKebutuhanBarangDanJasa/V_Index',$data);
		// }else {
		// 	$this->load->view('OrderKebutuhanBarangDanJasa/V_Index2',$data);
		// }
        $this->load->view('V_Footer',$data);
    }
}

