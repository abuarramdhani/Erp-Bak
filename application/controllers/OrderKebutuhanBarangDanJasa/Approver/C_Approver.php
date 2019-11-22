<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Approver extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('OrderKebutuhanBarangDanJasa/Requisition/M_requisition');
		$this->load->model('OrderKebutuhanBarangDanJasa/Approver/M_approver');
        	  
		 if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
         }
        if($this->session->is_logged == FALSE){
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

	public function PermintaanApprove()
    {
        $user_id = $this->session->userid;

		$noind = $this->session->user;
		
		$data['Menu'] = 'Approver Order';
		$data['SubMenuOne'] = 'Daftar Permintaan Approve Order';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $data['approver'] = $this->M_requisition->getPersonId($noind);
        $data['listOrder'] = array();

        $allOrder = $this->M_approver->getListDataOrder();
        // echo'<pre>';
        // print_r($allOrder);exit;
        foreach ($allOrder as $key => $order) {
            $checkOrder = $this->M_approver->checkOrder($order['ORDER_ID']);
            // echo'<pre>';
            // print_r($checkOrder);
            if (isset($checkOrder[0])) {
                if ($checkOrder[0]['APPROVER_ID'] == $data['approver'][0]['PERSON_ID']) {
                    $orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
                    if ($orderSiapTampil[0]['ORDER_CLASS'] != '2') {
                        array_push($data['listOrder'], $orderSiapTampil[0]);
                    }
                }
            }
        }

    }
    public function PermintaanApproveNormal()
    {
        $user_id = $this->session->userid;

		$noind = $this->session->user;
		
		$data['Menu'] = 'Permintaan Approve Order';
		$data['SubMenuOne'] = 'Normal Order';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $data['approver'] = $this->M_requisition->getPersonId($noind);
        $data['listOrder'] = array();

        $data['panelStatOrder'] = 'panel-success';
        $data['statOrder'] = 'Normal';

        $and = "URGENT_FLAG ='N' AND IS_SUSULAN ='N'";

        $allOrder = $this->M_approver->getListDataOrderCondition($and);
        // echo'<pre>';
        // print_r($allOrder);exit;
        foreach ($allOrder as $key => $order) {
            $checkOrder = $this->M_approver->checkOrder($order['ORDER_ID']);
            // echo'<pre>';
            // print_r($checkOrder);
            if (isset($checkOrder[0])) {
                if ($checkOrder[0]['APPROVER_ID'] == $data['approver'][0]['PERSON_ID']) {
                    $orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
                    if ($orderSiapTampil[0]['ORDER_CLASS'] != '2') {
                        array_push($data['listOrder'], $orderSiapTampil[0]);
                    }
                }
            }
        }
		// exit;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Approver/V_PermintaanApprove',$data);
        $this->load->view('V_Footer',$data);
    }

    public function PermintaanApproveSusulan()
    {
        $user_id = $this->session->userid;

		$noind = $this->session->user;
		
		$data['Menu'] = 'Permintaan Approve Order';
		$data['SubMenuOne'] = 'Susulan Order';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $data['approver'] = $this->M_requisition->getPersonId($noind);
        $data['listOrder'] = array();

        $data['panelStatOrder'] = 'panel-warning';
        $data['statOrder'] = 'Susulan';

        $and = "IS_SUSULAN ='Y'";

        $allOrder = $this->M_approver->getListDataOrderCondition($and);
        // echo'<pre>';
        // print_r($allOrder);exit;
        foreach ($allOrder as $key => $order) {
            $checkOrder = $this->M_approver->checkOrder($order['ORDER_ID']);
            // echo'<pre>';
            // print_r($checkOrder);
            if (isset($checkOrder[0])) {
                if ($checkOrder[0]['APPROVER_ID'] == $data['approver'][0]['PERSON_ID']) {
                    $orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
                    if ($orderSiapTampil[0]['ORDER_CLASS'] != '2') {
                        array_push($data['listOrder'], $orderSiapTampil[0]);
                    }
                }
            }
        }
		// exit;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Approver/V_PermintaanApprove',$data);
        $this->load->view('V_Footer',$data);
    }

    public function PermintaanApproveUrgent()
    {
        $user_id = $this->session->userid;

		$noind = $this->session->user;
		
		$data['Menu'] = 'Permintaan Approve Order';
		$data['SubMenuOne'] = 'Urgent Order';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $data['approver'] = $this->M_requisition->getPersonId($noind);
        $data['listOrder'] = array();

        $data['panelStatOrder'] = 'panel-danger';
        $data['statOrder'] = 'Urgent';

        $and = "URGENT_FLAG ='Y' AND IS_SUSULAN ='N'";

        $allOrder = $this->M_approver->getListDataOrderCondition($and);
        // echo'<pre>';
        // print_r($allOrder);exit;
        foreach ($allOrder as $key => $order) {
            $checkOrder = $this->M_approver->checkOrder($order['ORDER_ID']);
            // echo'<pre>';
            // print_r($checkOrder);
            if (isset($checkOrder[0])) {
                if ($checkOrder[0]['APPROVER_ID'] == $data['approver'][0]['PERSON_ID']) {
                    $orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
                    if ($orderSiapTampil[0]['ORDER_CLASS'] != '2') {
                        array_push($data['listOrder'], $orderSiapTampil[0]);
                    }
                }
            }
        }
		// exit;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Approver/V_PermintaanApprove',$data);
        $this->load->view('V_Footer',$data);
    }

    public function ApproveOrder()
    {
        $orderid = $_POST['orderid'];
        $judgment = $_POST['judgment'];
        $person_id = $_POST['person_id'];

        for ($i=0; $i < count($orderid); $i++) { 
            $approval_position = $this->M_approver->checkPositionApprover($orderid[$i],$person_id);
            $orderStatus = $this->M_approver->checkFinishOrder($orderid[$i]);

            if (isset($_POST['note'])) {
                $approve = array(                           
                    'JUDGEMENT' => $judgment,
                    'NOTE' => $_POST['note'],
                 );
            }else {
                $approve = array(                           
                                    'JUDGEMENT' => $judgment,
                                 );
            }


            $this->M_approver->ApproveOrder($orderid[$i], $person_id, $approve);

            if ($person_id == $orderStatus[0]['APPROVER_ID']) {
                $orderPos = array(
                    'APPROVE_LEVEL_POS' => $approval_position[0]['APPROVER_TYPE'],
                    'ORDER_STATUS_ID' => '3',
                 );
            }else {
                
                $orderPos = array(
                                    'APPROVE_LEVEL_POS' => $approval_position[0]['APPROVER_TYPE'],
                                 );
            }
            
            $this->M_approver->updatePosOrder($orderid[$i],$orderPos);
        }

        echo 1;
    }

    public function PermintaanApprovePR()
    {
        $user_id = $this->session->userid;

		$noind = $this->session->user;
		
		$data['Menu'] = 'Approver PR';
		$data['SubMenuOne'] = 'Daftar Permintaan Approver PR';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $data['approver'] = $this->M_requisition->getPersonId($noind);
        $data['listOrder'] = array();

        $list = array();
        $orderList = $this->M_approver->checkOrderPR($data['approver'][0]['PERSON_ID']);
        // echo count($orderList);exit;
        if (count($orderList)!=0) {
            foreach ($orderList as $key => $order) {
                if ($order['APPROVER_TYPE']==5) {
                    $orderSiapTampil = $this->M_approver->getOrderToApprovePR($order['PRE_REQ_ID']);
                    array_push($data['listOrder'], $orderSiapTampil[0]);
                    // $data['listOrder'] = $orderSiapTampil;
                }else{
                    $approverStatus = $order['APPROVER_TYPE'];
                    if ($approverStatus == 8) {
                        $approverSebelumnya = $approverStatus-3;
                    }
                    // echo $approverSebelumnya;
                    $checkApproval = $this->M_approver->checkApprovalPR($order['PRE_REQ_ID'],$approverSebelumnya);
                    if ($checkApproval[0]['JUDGEMENT']=='A') {
                        // echo 'hallo';
                        $orderSiapTampil = $this->M_approver->getOrderToApprovePR($checkApproval[0]['PRE_REQ_ID']);
                        array_push($data['listOrder'], $orderSiapTampil[0]);
                        $data['listOrder'] = $orderSiapTampil;
                    }
                }
            }
        }
        // $data['listOrder'] = $this->M_approver->getListDataOrder();
        
        // echo '<pre>';
        // print_r($data['listOrder']);exit;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Approver/V_PermintaanApprovePR',$data);
        $this->load->view('V_Footer',$data);
    }

    public function ApproveOrderPR()
    {
        $pre_req_id = $_POST['pre_req_id'];
        $judgment = $_POST['judgment'];
        $person_id = $_POST['person_id'];

        
        for ($i=0; $i < count($pre_req_id); $i++) { 
            $approval_position = $this->M_approver->checkPositionApproverPR($pre_req_id[$i],$person_id);
            $orderStatus = $this->M_approver->checkFinishOrderPR($pre_req_id[$i]);

            if (isset($_POST['note'])) {
                $approve = array(                           
                    'JUDGEMENT' => $judgment,
                    'NOTE' => $_POST['note'],
                 );
            }else {
                $approve = array(                           
                                    'JUDGEMENT' => $judgment,
                                 );
            }


            $this->M_approver->ApproveOrderPR($pre_req_id[$i], $person_id, $approve);

            if ($person_id == $orderStatus[0]['APPROVER_ID']) {
                $orderPos = array(
                    'PRE_REQ_STATUS_ID' => '5',
                 );
                
                $this->M_approver->updatePosOrderPR($pre_req_id[$i],$orderPos);

                $pre_req_order = $this->M_approver->getPreReqOrdertoInterface($pre_req_id[$i]);
                // echo'<pre>';
                // print_r($pre_req_order);
                // exit;

                //  inset to inteface
                $order = array(
                                'INTERFACE_SOURCE_CODE' => $pre_req_order[0]['INTERFACE_SOURCE_CODE'],
                                'ORG_ID' => 82,
                                'DESTINATION_TYPE_CODE' => $pre_req_order[0]['DESTINATION_TYPE_CODE'],
                                'DESTINATION_ORGANIZATION_ID' => $pre_req_order[0]['DESTINATION_ORGANIZATION_ID'],
                                'DELIVER_TO_LOCATION_ID' => $pre_req_order[0]['DELIVER_TO_LOCATION_ID'],
                                'DESTINATION_SUBINVENTORY' => $pre_req_order[0]['DESTINATION_SUBINVENTORY'],
                                'ITEM_ID' => $pre_req_order[0]['INVENTORY_ITEM_ID'],
                                'ITEM_DESCRIPTION' => $pre_req_order[0]['ITEM_DESCRIPTION'],
                                'QUANTITY' => $pre_req_order[0]['QUANTITY'],
                                'UNIT_OF_MEASURE' => $pre_req_order[0]['UOM'],
                                'UNIT_PRICE' => 1,
                                'NEED_BY_DATE' => $pre_req_order[0]['NEED_BY_DATE'],
                                'CHARGE_ACCOUNT_ID' => $pre_req_order[0]['CHARGE_ACCOUNT_ID'],
                                'LINE_TYPE_ID' => 1,
                                'NOTE_TO_BUYER' => $pre_req_order[0]['NOTE_TO_AGENT'],
                                'CATEGORY_ID' => $pre_req_order[0]['CATEGORY_ID'],
                                'DELIVER_TO_REQUESTOR_ID' => $pre_req_order[0]['REQUESTOR_ID'],
                                'PREPARER_ID' => $pre_req_order[0]['REQUESTOR_ID'],
                                'SOURCE_TYPE_CODE' => 'VENDOR',
                                'AUTHORIZATION_STATUS' => 'APPROVED',
                                'HEADER_ATTRIBUTE1' => date("Y-M-d", strtotime($pre_req_order[0]['PRE_REQ_DATE'])),
                                'HEADER_ATTRIBUTE2' => date("Y-M-d"),
                                'LINE_ATTRIBUTE9' => $pre_req_order[0]['PRE_REQ_ID'],
                             );

                $this->M_approver->insertPo_Requisitions_Interface_all($order);
            }
        }

        echo 1;
    }

    public function ListApprovedOrder()
    {
        $user_id = $this->session->userid;

		$noind = $this->session->user;
		
		$data['Menu'] = 'My Action';
		$data['SubMenuOne'] = 'List Approved Order';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $data['approver'] = $this->M_requisition->getPersonId($noind);
        $data['listOrder'] = array();
        $data['panelStatOrder'] = 'panel-success';
        $data['statOrder'] = 'Approved';

        $judgement = "AND ooa.JUDGEMENT = 'A'";

        $allOrder = $this->M_approver->GetActionOrder($data['approver'][0]['PERSON_ID'], $judgement);

        foreach ($allOrder as $key => $order) {
            $orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
            array_push($data['listOrder'], $orderSiapTampil[0]);
        }
        
        $this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Approver/V_OrderApproved',$data);
        $this->load->view('V_Footer',$data);

    }

    public function ListRejectedOrder()
    {
        $user_id = $this->session->userid;

		$noind = $this->session->user;
		
		$data['Menu'] = 'My Action';
		$data['SubMenuOne'] = 'List Rejected Order';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $data['approver'] = $this->M_requisition->getPersonId($noind);
        $data['listOrder'] = array();

        $data['panelStatOrder'] = 'panel-danger';
        $data['statOrder'] = 'Rejected';

        $judgement = "AND ooa.JUDGEMENT = 'R'";

        $allOrder = $this->M_approver->GetActionOrder($data['approver'][0]['PERSON_ID'], $judgement);

        foreach ($allOrder as $key => $order) {
            $orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
            array_push($data['listOrder'], $orderSiapTampil[0]);
        }
        
        $this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Approver/V_OrderApproved',$data);
        $this->load->view('V_Footer',$data);
    }

    public function getStock()
    {
        $itemkode = $_POST['itemkode'];
        $data = $this->M_approver->getStock($itemkode);

        echo json_encode($data);
    }
	
}