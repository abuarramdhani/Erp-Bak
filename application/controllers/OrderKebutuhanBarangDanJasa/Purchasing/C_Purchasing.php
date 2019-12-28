<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Purchasing extends CI_Controller {
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
		$this->load->model('OrderKebutuhanBarangDanJasa/Pengelola/M_pengelola');
		$this->load->model('OrderKebutuhanBarangDanJasa/Puller/M_puller');
		$this->load->model('OrderKebutuhanBarangDanJasa/Purchasing/M_purchasing');
        	  
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
		
		$data['Menu'] = 'Approve Order';
		$data['SubMenuOne'] = 'Daftar Permintaan Approve Order';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['approver'] = $this->M_requisition->getPersonId($noind);
        $person_id = $data['approver'][0]['PERSON_ID'];

        $data['listOrder'] = $this->M_purchasing->getReleasedOrder();
     
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Purchasing/V_PermintaanApprove',$data);
        $this->load->view('V_Footer',$data);
    }

    public function ReleaseOrder()
    {
        $noind = $this->session->user;

        $data['approver'] = $this->M_requisition->getPersonId($noind);
        $person_id = $data['approver'][0]['PERSON_ID'];

        $order_id = $_POST['order_id'];

        $pre_req = array(
                            'CREATED_BY' => $person_id,
                        );

        $pre_req_id = $this->M_puller->releaseOrder($pre_req);

        for ($i=0; $i < count($order_id); $i++) { 
            
            $order = array(
                            'PRE_REQ_ID' => $pre_req_id[0]['PRE_REQ_ID'],
                         );
            
            $this->M_puller->updateOrder($order_id[$i],$order);
        }
        

        echo 1;
    }
    
    public function ShowDetailReleasedOrder()
    {
        $pre_req_id = $_POST['pre_req_id'];
        $data['listOrder'] = $this->M_puller->getDetailReleasedOrder($pre_req_id);
        $returnTable = $this->load->view('OrderKebutuhanBarangDanJasa/Puller/V_ReleasedOrderTable',$data, true);

        echo($returnTable);
    }

    public function ApproveOrder()
    {
        $pre_req_id = $_POST['pre_req_id'];
        $judgement = $_POST['judgement'];
        $person_id = $_POST['person_id'];

        for ($i=0; $i < count($pre_req_id); $i++) { 
            $order = array(
                            'APPROVED_FLAG' => $judgement,
                            'APPROVED_BY' => $person_id,
                         );
            $this->M_purchasing->updateReleasedOrder($pre_req_id[$i], $order);

            if ($judgement == 'Y') {
                $dataOrder = $this->M_purchasing->getOrder($pre_req_id[$i]);
                // echo '<pre>';
                // print_r($dataOrder);

                foreach ($dataOrder as $key => $data) {
                    // echo $data['DESTINATION_TYPE_CODE'];
                    $interface_source_code = $this->M_pengelola->getInterfaceSourceCode($data['INVENTORY_ITEM_ID']);
                    $category_id = $this->M_pengelola->getCategoryId($data['INVENTORY_ITEM_ID']);
                    $charge_account_id = $this->M_pengelola->getChargeAccountId($data['INVENTORY_ITEM_ID']);

                    $orderPR = array(
                        'INTERFACE_SOURCE_CODE' => $interface_source_code[0]['INTERFACE_SOURCE_CODE'],
                        'ORG_ID' => 82,
                        'DESTINATION_TYPE_CODE' => $data['DESTINATION_TYPE_CODE'],
                        'DESTINATION_ORGANIZATION_ID' => $data['DESTINATION_ORGANIZATION_ID'],
                        'DELIVER_TO_LOCATION_ID' => $data['DELIVER_TO_LOCATION_ID'],
                        'DESTINATION_SUBINVENTORY' => $data['DESTINATION_SUBINVENTORY'],
                        'ITEM_ID' => $data['INVENTORY_ITEM_ID'],
                        'ITEM_DESCRIPTION' => $data['ITEM_DESCRIPTION'],
                        'QUANTITY' => $data['QUANTITY'],
                        'UNIT_OF_MEASURE' => $data['UOM'],
                        'UNIT_PRICE' => 1,
                        'NEED_BY_DATE' => $data['NEED_BY_DATE'],
                        'CHARGE_ACCOUNT_ID' => $charge_account_id[0]['CHARGE_ACCOUNT_ID'],
                        'LINE_TYPE_ID' => 1,
                        'NOTE_TO_BUYER' => $data['NOTE_TO_BUYER'],
                        'CATEGORY_ID' => $category_id[0]['CATEGORY_ID'],
                        'DELIVER_TO_REQUESTOR_ID' => $data['REQUESTER'],
                        'PREPARER_ID' => $data['REQUESTER'],
                        'SOURCE_TYPE_CODE' => 'VENDOR',
                        'AUTHORIZATION_STATUS' => 'APPROVED',
                        'HEADER_ATTRIBUTE1' => date("Y-M-d", strtotime($data['NEED_BY_DATE'])),
                        'HEADER_ATTRIBUTE2' => date("Y-M-d"),
                        'LINE_ATTRIBUTE9' => $data['ORDER_ID'],
                        'HEADER_ATTRIBUTE4' => $data['PRE_REQ_ID'],
                     );

                    $this->M_approver->insertPo_Requisitions_Interface_all($orderPR);
                }
            }
        }


        echo 1;
    }

    public function ListApprovedPurchasing()
    {
        $user_id = $this->session->userid;
        $noind = $this->session->user;
		
		$data['Menu'] = 'My Action';
		$data['SubMenuOne'] = 'List Approved Order';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['approver'] = $this->M_requisition->getPersonId($noind);
        $person_id = $data['approver'][0]['PERSON_ID'];

        $data['stat'] = 'Approved';

        $data['panel'] = 'panel-success';

        $cond = "AND oprh.APPROVED_FLAG = 'Y'";

        $data['listOrder'] = $this->M_purchasing->getActOrder($person_id, $cond);
     
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Purchasing/V_ApprovedPurchasing',$data);
        $this->load->view('V_Footer',$data);
    }

    public function ListRejectedPurchasing()
    {
        $user_id = $this->session->userid;
        $noind = $this->session->user;
		
		$data['Menu'] = 'My Action';
		$data['SubMenuOne'] = 'List Rejected Order';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['approver'] = $this->M_requisition->getPersonId($noind);
        $person_id = $data['approver'][0]['PERSON_ID'];

        $data['stat'] = 'Rejected';

        $data['panel'] = 'panel-danger';

        $cond = "AND oprh.APPROVED_FLAG = 'N'";

        $data['listOrder'] = $this->M_purchasing->getActOrder($person_id, $cond);
     
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Purchasing/V_ApprovedPurchasing',$data);
        $this->load->view('V_Footer',$data);
    }
    
}