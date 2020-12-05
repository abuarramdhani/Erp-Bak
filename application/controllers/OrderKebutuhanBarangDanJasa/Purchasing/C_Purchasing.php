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

        // echo $judgement;exit;

        for ($i=0; $i < count($pre_req_id); $i++) { 
            if ($judgement == 'Y') {
                $order = array(
                                'APPROVED_FLAG' => $judgement,
                                'APPROVED_BY' => $person_id,
                             );
                $this->M_purchasing->updateReleasedOrder($pre_req_id[$i], $order);
            }elseif ($judgement == 'N') {
                $order = array(
                    'APPROVED_FLAG' => $judgement,
                    'APPROVED_BY' => $person_id,
                    'NOTE' => $_POST['note'],
                 );
                $this->M_purchasing->updateReleasedOrder($pre_req_id[$i], $order);
            }
            
            if ($judgement == 'Y') {
                $dataOrder = $this->M_purchasing->getOrder($pre_req_id[$i]);
                $puller = $this->M_purchasing->getPuller($pre_req_id[$i]);

                foreach ($dataOrder as $key => $data) {
                    // echo $data['DESTINATION_TYPE_CODE'];
                    $interface_source_code = $this->M_pengelola->getInterfaceSourceCode($data['INVENTORY_ITEM_ID']);
                    $category_id = $this->M_pengelola->getCategoryId($data['INVENTORY_ITEM_ID']);
                    $charge_account_id = $this->M_pengelola->getChargeAccountId($data['ORDER_ID']);
                    $desc = $this->M_purchasing->getDescItem($data['INVENTORY_ITEM_ID']);

                    if ($desc[0]['ALLOW_ITEM_DESC_UPDATE_FLAG'] == 'N') {
                        $itemdesc = $data['ITEM_DESCRIPTION'];
                    }else {
                        $itemdesc = $desc[0]['DESCRIPTION'].' '.$data['ITEM_DESCRIPTION'];
                    }

                    $orderPR = array(
                        'INTERFACE_SOURCE_CODE' => $interface_source_code[0]['INTERFACE_SOURCE_CODE'],
                        'ORG_ID' => 82,
                        'DESTINATION_TYPE_CODE' => $data['DESTINATION_TYPE_CODE'],
                        'DESTINATION_ORGANIZATION_ID' => $data['DESTINATION_ORGANIZATION_ID'],
                        'DELIVER_TO_LOCATION_ID' => $data['DELIVER_TO_LOCATION_ID'],
                        'DESTINATION_SUBINVENTORY' => $data['DESTINATION_SUBINVENTORY'],
                        'ITEM_ID' => $data['INVENTORY_ITEM_ID'],
                        'ITEM_DESCRIPTION' => $itemdesc,
                        'QUANTITY' => $data['QUANTITY'],
                        'UNIT_OF_MEASURE' => $data['UOM'],
                        'UNIT_PRICE' => 1,
                        'NEED_BY_DATE' => $data['NEED_BY_DATE'],
                        'CHARGE_ACCOUNT_ID' => $charge_account_id[0]['CHARGE_ACCOUNT_ID'],
                        'LINE_TYPE_ID' => 1,
                        'NOTE_TO_BUYER' => $data['NOTE_TO_BUYER'],
                        'CATEGORY_ID' => $category_id[0]['CATEGORY_ID'],
                        'DELIVER_TO_REQUESTOR_ID' => $data['REQUESTER'],
                        'PREPARER_ID' => $puller[0]['CREATED_BY'],
                        'SOURCE_TYPE_CODE' => 'VENDOR',
                        'AUTHORIZATION_STATUS' => 'APPROVED',
                        'HEADER_ATTRIBUTE1' => date("Y-M-d", strtotime($data['ORDER_DATE'])),
                        'HEADER_ATTRIBUTE2' => date("Y-M-d"),
                        'LINE_ATTRIBUTE9' => $data['ORDER_ID'],
                        'HEADER_ATTRIBUTE4' => $data['PRE_REQ_ID'],
                        'REFERENCE_NUM' => $data['ORDER_ID'],
                     );

                    $this->M_approver->insertPo_Requisitions_Interface_all($orderPR);
                }
                $orderHead = array(
                    'ORDER_STATUS_ID' => '7', 
                );
                // print_r($orderHead);exit;
                $this->M_purchasing->UpdateOrder($pre_req_id[$i],$orderHead);

            }elseif ($judgement == 'N') {

                $orderHead = array(
                    'ORDER_STATUS_ID' => '8',
                );

                $this->M_purchasing->UpdateOrder($pre_req_id[$i], $orderHead);

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
        $this->load->view('OrderKebutuhanBarangDanJasa/Purchasing/V_RejectedPurchasing',$data);
        $this->load->view('V_Footer',$data);
    }

    public function ShowAttachment($orderid)
    {
        $data = $this->M_approver->getAttachment($orderid);
        // print_r($data);exit;
        if (count($data) == 0) {
            echo '<span><i class="fa fa-warning"></i>Tidak ada attachment</span><br>';
        }else {
            foreach ($data as $key => $att) {
                
                if ($att['FILE_NAME'] == null) {
                    echo '<span><i class="fa fa-warning"></i>Tidak ada attachment</span><br>';
                }else {
                    $file = explode('.',$att['FILE_NAME']);
                    if ($file[1] == 'pdf' || $file[1] == 'doc' || $file[1] == 'xls' || $file[1] == 'ppt' || $file[1] == 'docx' || $file[1] == 'xlsx' || $file[1] == 'pptx' || $file[1] == 'ods'){

                        redirect(base_url('assets/upload/Okebaja/'.$att['FILE_NAME']));
                    }else {
                        echo '<img src="'.base_url('assets/upload/Okebaja/'.$att['FILE_NAME']).'">';
                    }
                }
            }            
        }
        
    }

    public function ListDetailApprovedPurchasing()
    {
        $user_id = $this->session->userid;
        $noind = $this->session->user;
		
		$data['Menu'] = 'My Action';
		$data['SubMenuOne'] = 'List Detail Approved Order';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['list_detail'] = $this->M_purchasing->DetailApprovedOrder();

        $this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Purchasing/V_DetailApprovedPurchasing',$data);
        $this->load->view('V_Footer',$data);
    }

    public function ShowDetailOrderApproved()
    {
        $order_id = $_POST['order_id'];
        $data['listOrder'] = $this->M_purchasing->getDetailApprovedOrder($order_id);
        $returnTable = $this->load->view('OrderKebutuhanBarangDanJasa/Puller/V_ReleasedOrderTable',$data, true);

        echo $returnTable;
    }

    public function cetakOrder($pre_req_id)
    {
        $this->load->library('pdf');
		$pdf = $this->pdf->load();
		$filename = 'Okebaja-pre_req_id-'.$pre_req_id.'-tanggal_cetak-'.date('d-m-Y').'.pdf';
		$pdf = new mPDF('utf-8', 'A4-L', 0, 'arial',3, 3, 43, 3, 3, 3);
        
        $lines = $this->M_purchasing->cetakOrder($pre_req_id);

        $finishLines = array();
        for ($i=0; $i < count($lines); $i++) { 
            $approver = $this->M_purchasing->cetakApprover($lines[$i]['ORDER_ID']);

            if (!isset($lines[$i]['APPROVER'])) {        
				$lines[$i]['APPROVER'] = $approver;    
			}
            array_push($finishLines,$lines[$i]);
        }
        $data['headers'] = $this->M_purchasing->cetakHeader($pre_req_id);
        $data['lines'] = $finishLines;

        // echo '<pre>';
        // print_r($data['lines']);
        // exit;

        $header = $this->load->view('OrderKebutuhanBarangDanJasa/Purchasing/V_CetakOrderHeader',$data,true);
        $line = $this->load->view('OrderKebutuhanBarangDanJasa/Purchasing/V_CetakOrderLine',$data,true);

        $pdf->setHeader($header, 2);
        $pdf->writeHTML($line, 2);
		$pdf->setTitle($filename);
		$pdf->Output($filename, 'I');
    }
    
}