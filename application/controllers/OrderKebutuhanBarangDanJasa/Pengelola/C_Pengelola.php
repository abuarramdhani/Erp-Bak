<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Pengelola extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('session');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('OrderKebutuhanBarangDanJasa/Requisition/M_requisition');
		$this->load->model('OrderKebutuhanBarangDanJasa/Approver/M_approver');
		$this->load->model('OrderKebutuhanBarangDanJasa/Pengelola/M_pengelola');
        	  
        if ( $this->session->userdata('logged_in') != TRUE ) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }

        if ( $this->session->is_logged == FALSE ) {
            redirect();
        }
    }
    
    public function index()
	{   
		$user_id = $this->session->userid;
		
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
     
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/V_Index',$data);
        $this->load->view('V_Footer',$data);
    }

    public function OpenedOrder()
    {
        $user_id = $this->session->userid;

        $noind = $this->session->user;
		
		$data['Menu']       = 'Pengelola';
		$data['SubMenuOne'] = 'Daftar Opened Order';
		
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['approver'] = $this->M_requisition->getPersonId($noind);

        $data['listOrder'] = array();

        $allOrder = $this->M_approver->getListDataOrder();

        foreach ($allOrder as $key => $order) {
            $checkOrder = $this->M_approver->checkOrder($order['ORDER_ID']);
            if(isset($checkOrder[0])){
                if ($checkOrder[0]['APPROVER_ID'] == $data['approver'][0]['PERSON_ID'] && $checkOrder[0]['APPROVER_TYPE'] == '7') {
                    $orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
                    array_push($data['listOrder'], $orderSiapTampil[0]);
                }
            }
        }

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Pengelola/V_OpenedOrder', $data);
        $this->load->view('V_Footer', $data);
    }

    public function OpenedOrderNormal()
    {
        $user_id = $this->session->userid;

        $noind = $this->session->user;
		
		$data['Menu']       = 'Opened Order';
		$data['SubMenuOne'] = 'Daftar Opened Order Normal';
		
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['approver'] = $this->M_requisition->getPersonId($noind);

        $data['listOrder'] = array();

        $data['panelStatOrder'] = 'panel-success';
        $data['statOrder'] = 'Normal';

        $and = "URGENT_FLAG ='N' AND IS_SUSULAN ='N'";

        $allOrder = $this->M_approver->getListDataOrderCondition($and);

        foreach ($allOrder as $key => $order) {
            $checkOrder = $this->M_approver->checkOrder($order['ORDER_ID']);
            if(isset($checkOrder[0])){
                if ($checkOrder[0]['APPROVER_ID'] == $data['approver'][0]['PERSON_ID'] && $checkOrder[0]['APPROVER_TYPE'] == '7') {
                    $orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
                    array_push($data['listOrder'], $orderSiapTampil[0]);
                }
            }
        }

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Pengelola/V_OpenedOrder', $data);
        $this->load->view('V_Footer', $data);
    }

    public function OpenedOrderSusulan()
    {
        $user_id = $this->session->userid;

        $noind = $this->session->user;
		
		$data['Menu']       = 'Opened Order';
		$data['SubMenuOne'] = 'Daftar Opened Order Susulan';
		
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['approver'] = $this->M_requisition->getPersonId($noind);

        $data['listOrder'] = array();

        $data['panelStatOrder'] = 'panel-warning';
        $data['statOrder'] = 'Susulan';

        $and = "IS_SUSULAN ='Y'";

        $allOrder = $this->M_approver->getListDataOrderCondition($and);

        foreach ($allOrder as $key => $order) {
            $checkOrder = $this->M_approver->checkOrder($order['ORDER_ID']);
            if(isset($checkOrder[0])){
                if ($checkOrder[0]['APPROVER_ID'] == $data['approver'][0]['PERSON_ID'] && $checkOrder[0]['APPROVER_TYPE'] == '7') {
                    $orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
                    array_push($data['listOrder'], $orderSiapTampil[0]);
                }
            }
        }

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Pengelola/V_OpenedOrder', $data);
        $this->load->view('V_Footer', $data);
    }

    public function OpenedOrderUrgent()
    {
        $user_id = $this->session->userid;

        $noind = $this->session->user;
		
		$data['Menu']       = 'Opened Order';
		$data['SubMenuOne'] = 'Daftar Opened Order Urgent';
		
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['approver'] = $this->M_requisition->getPersonId($noind);

        $data['listOrder'] = array();

        $data['panelStatOrder'] = 'panel-danger';
        $data['statOrder'] = 'Urgent';

        $and = "URGENT_FLAG ='Y' AND IS_SUSULAN ='N'";

        $allOrder = $this->M_approver->getListDataOrderCondition($and);

        foreach ($allOrder as $key => $order) {
            $checkOrder = $this->M_approver->checkOrder($order['ORDER_ID']);
            if(isset($checkOrder[0])){
                if ($checkOrder[0]['APPROVER_ID'] == $data['approver'][0]['PERSON_ID'] && $checkOrder[0]['APPROVER_TYPE'] == '7') {
                    $orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
                    array_push($data['listOrder'], $orderSiapTampil[0]);
                }
            }
        }

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Pengelola/V_OpenedOrder', $data);
        $this->load->view('V_Footer', $data);
    }

    public function OrderBeli()
    {
        $user_id = $this->session->userid;

        $noind = $this->session->user;
		
		$data['Menu']       = 'Pengelola';
		$data['SubMenuOne'] = 'Daftar Order Beli';
		
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['approver'] = $this->M_requisition->getPersonId($noind);

        $data['listOrder'] = array();

        $checkOrderBeli = $this->M_pengelola->checkOrder($data['approver'][0]['PERSON_ID']);

        foreach ($checkOrderBeli as $key => $beli) {
            $orderSiapTampil = $this->M_pengelola->orderBeli($beli['ORDER_ID']);
            if (count($orderSiapTampil) != 0) {
                array_push($data['listOrder'], $orderSiapTampil[0]);
            }
        }

        // echo '<pre>';
        // print_r($data['listOrder']);exit;
     
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Pengelola/V_OrderBeli', $data);
        $this->load->view('V_Footer', $data);
    }

    public function TindakanPengelola()
    {
        // $orderid = $_POST['orderid'];
        // $orderClass = $_POST['orderClass'];
        // $person_id = $_POST['person_id'];

        // for ($i=0; $i < count($orderid); $i++) { 
            
        //     $this->M_pengelola->TindakanPengelola($orderid[$i], $orderClass);
        //     $approval_position = $this->M_approver->checkPositionApprover($orderid[$i],$person_id);
        //     $orderStatus = $this->M_approver->checkFinishOrder($orderid[$i]);

        //     $approve =  array(                           
        //                     'JUDGEMENT' => 'A',
        //                 );
        //     $this->M_approver->ApproveOrder($orderid[$i], $person_id, $approve);

        //     if ($person_id == $orderStatus[0]['APPROVER_ID']) {
        //         $orderPos = array(
        //             'APPROVE_LEVEL_POS' => $approval_position[0]['APPROVER_TYPE'],
        //             'ORDER_STATUS_ID' => '3',
        //          );
        //     }else {
                
        //         $orderPos = array(
        //                             'APPROVE_LEVEL_POS' => $approval_position[0]['APPROVER_TYPE'],
        //                          );
        //     }
            
        //     $this->M_approver->updatePosOrder($orderid[$i],$orderPos);
            
        // }

        $orderid = $_POST['orderid'];
        $orderClass = $_POST['orderClass'];
        $person_id = $_POST['person_id'];

        for ($i=0; $i < count($orderid); $i++) { 
            if ($orderClass != 'R') {
                $judgement = 'A';
            }

            $approve = array('JUDGEMENT' => $judgement, );

            $this->M_approver->ApproveOrder($orderid[$i], $person_id, $approve);
            
            if (isset($_POST['note'])) {
                $classOrder = array(
                    'ORDER_CLASS' => $orderClass, 
                    'NOTE_TO_BUYER' => $_POST['note'], 
                );
            } else {
                $classOrder = array(
                    'ORDER_CLASS' => $orderClass, 
                );
            }      

            $this->M_pengelola->updateOrderClass($orderid[$i], $classOrder);
        }

        echo 1;
    }

    public function TindakanPengelola2()
    {

        $orderid = $_POST['orderid'];
        $orderClass = $_POST['orderClass'];
        $person_id = $_POST['person_id'];

        for ($i=0; $i < count($orderid); $i++) { 
            $ordid = explode("-", $orderid[$i]);

            if ($orderClass != 'R') {
                $judgement = 'A';
            }

            $approve = array('JUDGEMENT' => $judgement, );

            $this->M_approver->ApproveOrder($ordid[0], $person_id, $approve);
            
            // if ($ordid[1] != '' || $ordid[1]!= null) {
                $classOrder = array(
                    'ORDER_CLASS' => $orderClass, 
                    'NOTE_TO_BUYER' => $ordid[1], 
                );
            // } else {
            //     $classOrder = array(
            //         'ORDER_CLASS' => $orderClass, 
            //     );
            // }      

            $this->M_pengelola->updateOrderClass($ordid[0], $classOrder);
        }

        echo 1;
    }

    public function PengelolaCreatePR()
    {
        $noind = $this->session->user;
        $pengelola = $this->M_requisition->getPersonId($noind);

        $orderid = $_POST['orderid'];
        $itemkode = $_POST['itemkode'];
        $nbd = $_POST['nbd'];
        $quantity = $_POST['quantity'];
        $uom = $_POST['uom'];
        $note = $_POST['note'];
        $desc = $_POST['desc'];
        $dest = $_POST['dest'];
        $org = $_POST['org'];
        $loc = $_POST['loc'];

        $interface_source_code = $this->M_pengelola->getInterfaceSourceCode($itemkode);
        $category_id = $this->M_pengelola->getCategoryId($itemkode);
        $charge_account_id = $this->M_pengelola->getChargeAccountId($itemkode);

        $order = array(
                        'REQUESTOR_ID' => $pengelola[0]['PERSON_ID'],
                        'INVENTORY_ITEM_ID' => $itemkode,
                        'ITEM_DESCRIPTION' => $desc,
                        'QUANTITY' => $quantity,
                        'UOM' => $uom,
                        'NOTE_TO_AGENT' => $note,
                        'DESTINATION_TYPE_CODE' => $dest,
                        'DESTINATION_ORGANIZATION_ID' => $org,
                        'DELIVER_TO_LOCATION_ID' => $loc,
                        'INTERFACE_SOURCE_CODE' => $interface_source_code[0]['INTERFACE_SOURCE_CODE'],
                        'CHARGE_ACCOUNT_ID' => $charge_account_id[0]['CHARGE_ACCOUNT_ID'],
                        'CATEGORY_ID' => $category_id[0]['CATEGORY_ID'],
                        'PRE_REQ_STATUS_ID' => 4
                    );

        $pre_requisition_id = $this->M_pengelola->PengelolaCreatePR($order, date("Y-m-d", strtotime($nbd)));
        $approverPR = $this->M_pengelola->ApproverPR($noind,$itemkode);

        foreach ($approverPR as $key => $approver) {
            
            $appPR = array(
                        'PRE_REQ_ID' => $pre_requisition_id[0]['PRE_REQ_ID'],
                        'APPROVER_ID' => $approver['APPROVER'],
                        'APPROVER_TYPE' => $approver['APPROVER_LEVEL'],
                     );
            $this->M_pengelola->setApproverPR($appPR);
        }
        
        for ($i=0; $i < count($orderid); $i++) { 
            
            $orderHead = array('PRE_REQ_ID' => $pre_requisition_id[0]['PRE_REQ_ID'], );
            $this->M_pengelola->updatePreReqId($orderid[$i], $orderHead);
        }

        echo 1;
    }

    public function DaftarRequisition()
    {
        $user_id = $this->session->userid;

        $noind = $this->session->user;
		
		$data['Menu']       = 'Pengelola';
		$data['SubMenuOne'] = 'Daftar Requisition';
		
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['approver'] = $this->M_requisition->getPersonId($noind);

        $data['monitoringRequisition'] = $this->M_pengelola->listRequisition($data['approver'][0]['PERSON_ID']);
        // echo '<pre>';
        // print_r($data['monitoringRequisition']);exit;
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Pengelola/V_DaftarRequisition', $data);
        $this->load->view('V_Footer', $data);
    }

    public function getHistoryRequisition()
    {
        $pre_req = $this->input->post('pre_req_id');
		$data	 = $this->M_pengelola->getHistoryRequisition($pre_req);

		echo json_encode($data);
    }

}