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
                    if ($orderSiapTampil[0]['ORDER_STATUS_ID'] != '4' && $orderSiapTampil[0]['ORDER_STATUS_ID'] != '5') {
                        array_push($data['listOrder'], $orderSiapTampil[0]);
                    }
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
		$data['SubMenuOne'] = 'Daftar Opened Order Reguler';
		
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['approver'] = $this->M_requisition->getPersonId($noind);

        $data['listOrder'] = array();

        $data['panelStatOrder'] = 'panel-success';
        $data['statOrder'] = 'Reguler';

        $and = "URGENT_FLAG ='N' AND IS_SUSULAN ='N'";

        $allOrder = $this->M_approver->getListDataOrderCondition($and);

        foreach ($allOrder as $key => $order) {
            $checkOrder = $this->M_approver->checkOrder($order['ORDER_ID']);
            if(isset($checkOrder[0])){
                if ($checkOrder[0]['APPROVER_ID'] == $data['approver'][0]['PERSON_ID'] && $checkOrder[0]['APPROVER_TYPE'] == '7') {
                    $orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
                    if ($orderSiapTampil[0]['ORDER_STATUS_ID'] != '4' && $orderSiapTampil[0]['ORDER_STATUS_ID'] != '5') {
                        array_push($data['listOrder'], $orderSiapTampil[0]);
                    }
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
		$data['SubMenuOne'] = 'Daftar Opened Order Emergency';
		
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['approver'] = $this->M_requisition->getPersonId($noind);

        $data['listOrder'] = array();

        $data['panelStatOrder'] = 'panel-warning';
        $data['statOrder'] = 'Emergency';

        $and = "IS_SUSULAN ='Y'";

        $allOrder = $this->M_approver->getListDataOrderCondition($and);

        foreach ($allOrder as $key => $order) {
            $checkOrder = $this->M_approver->checkOrder($order['ORDER_ID']);
            if(isset($checkOrder[0])){
                if ($checkOrder[0]['APPROVER_ID'] == $data['approver'][0]['PERSON_ID'] && $checkOrder[0]['APPROVER_TYPE'] == '7') {
                    $orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
                    if ($orderSiapTampil[0]['ORDER_STATUS_ID'] != '4' && $orderSiapTampil[0]['ORDER_STATUS_ID'] != '5') {
                        // echo $orderSiapTampil[0]['ORDER_STATUS_ID'];
                        array_push($data['listOrder'], $orderSiapTampil[0]);
                    }
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
                    if ($orderSiapTampil[0]['ORDER_STATUS_ID'] != '4' && $orderSiapTampil[0]['ORDER_STATUS_ID'] != '5') {
                        array_push($data['listOrder'], $orderSiapTampil[0]);
                    }
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

        $data['panelStatOrder'] = 'panel-success';
        $data['statOrder'] = '';

        $data['listOrder'] = array();

        $checkOrderBeli = $this->M_pengelola->checkOrder($data['approver'][0]['PERSON_ID']);

        foreach ($checkOrderBeli as $key => $beli) {
            $orderSiapTampil = $this->M_pengelola->orderBeli($beli['ORDER_ID']);
            if (count($orderSiapTampil) != 0) {
                array_push($data['listOrder'], $orderSiapTampil[0]);
            }
        }
     
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Pengelola/V_OrderBeli',$data);
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

        $emailBatch = array();

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
        $noind = $this->session->user;
        $orderid = $_POST['orderid'];
        $orderClass = $_POST['orderClass'];
        $person_id = $_POST['person_id'];

        $emailBatch = array();
        $emailBackRequester = array();

        for ($i=0; $i < count($orderid); $i++) { 
            $ordid = explode("-", $orderid[$i]);

            if ($orderClass != 'R') {
                $judgement = 'A';
            }

            $approve = array('JUDGEMENT' => $judgement, );

            $this->M_approver->ApproveOrderKaDep($ordid[0], $person_id, $approve);
            
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

            $order = $this->M_approver->getOrderToApprove1($ordid[0]);

            $getNextApproval = $this->M_approver->getNextApproval($ordid[0]);

            if (!isset($emailBatch[$getNextApproval[0]['NATIONAL_IDENTIFIER']])) {
                $emailBatch[$getNextApproval[0]['NATIONAL_IDENTIFIER']] = array();
            }

            array_push($emailBatch[$getNextApproval[0]['NATIONAL_IDENTIFIER']], $order[0]);

            if (!isset($emailBackRequester[$order[0]['NATIONAL_IDENTIFIER']])) {
                $emailBackRequester[$order[0]['NATIONAL_IDENTIFIER']] = array();
            }

            array_push($emailBackRequester[$order[0]['NATIONAL_IDENTIFIER']], $order[0]);
        }
        foreach ($emailBatch as $key => $pesan) {
            $noindemail = $key;
            $normal = array();
            $urgent = array();
            $susulan = array();
                
            $nApprover = $this->M_requisition->getNamaUser($key);
            $namaApprover = $nApprover[0]['nama'];

            $encrypt = $this->encrypt->encode($key);
			$encrypt = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypt);

			$link = "<a href='".base_url("OrderKebutuhanBarangDanJasa/directEmail/$encrypt/")."'>Disini</a>";
                
            if ($nApprover[0]['jenkel'][0]=='L') {
                $jklApprover = 'Bapak ';
            }else {
                $jklApprover = 'Ibu ';
            };

            $cond = "WHERE ppf.NATIONAL_IDENTIFIER = '$key'";
            
            $getNoindFromOracle = $this->M_requisition->getNoind($cond);

            $allOrder = $this->M_approver->getListDataOrder();

            foreach ($allOrder as $key => $order) {
                $checkOrder = $this->M_approver->checkOrder($order['ORDER_ID']);
                if (isset($checkOrder[0])) {
                    if ($checkOrder[0]['APPROVER_ID'] == $getNoindFromOracle[0]['PERSON_ID']) {
                        $orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
                        if ($orderSiapTampil[0]['ORDER_CLASS'] != '2') {
                            if ($orderSiapTampil[0]['URGENT_FLAG'] == 'N' && $orderSiapTampil[0]['IS_SUSULAN'] =='N') {
                                array_push($normal, $orderSiapTampil[0]);
                            }elseif ($orderSiapTampil[0]['URGENT_FLAG'] == 'Y' && $orderSiapTampil[0]['IS_SUSULAN'] =='N') {
                                array_push($urgent, $orderSiapTampil[0]);
                            }elseif ($orderSiapTampil[0]['IS_SUSULAN'] =='Y') {
                                array_push($susulan, $orderSiapTampil[0]);
                            }
                        }
                    }
                }
            }

            $create = $pesan[0]['NATIONAL_IDENTIFIER'];
            // $getNoindFromOracle = $this->M_requisition->getNoind($create);
            $nCreator = $this->M_requisition->getNamaUser($create);
            $namaCreator = $nCreator[0]['nama'];
            
            if ($nCreator[0]['jenkel'][0]=='L') {
                $jklCreator = 'Bapak ';
            }else {
                $jklCreator = 'Ibu ';
            };

            $subject = '[PRE-LAUNCH]Persetujuan Order Kebutuhan Barang Dan jasa';
            $body = "<b>Yth. $jklApprover $namaApprover</b>,<br><br>";
            $body .= "$jklCreator $namaCreator meminta approval Anda terkait order barang-barang berikut : <br><br>";
            $body .= "	<table border='1' style=' border-collapse: collapse;'>
                            <thead>
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Deskripsi Barang</th>
                                    <th>Quantity</th>
                                    <th>UOM</th>
                                    <th>Status Order</th>
                                    <th>Alasan Pengadaan</th>
                                    <th>Alasan Urgensi</th>
                                </tr>
                            </thead>
                            <tbody>";
                        for ($i=0; $i < count($pesan); $i++) { 
                            if ($pesan[$i]['URGENT_FLAG']=='Y' && $pesan[$i]['IS_SUSULAN'] =='N') {
                                $statusOrder = 'Urgent';
                            }else if($pesan[$i]['URGENT_FLAG']=='N' && $pesan[$i]['IS_SUSULAN'] =='N'){
                                $statusOrder = 'Regular';
                            }elseif ($pesan[$i]['IS_SUSULAN'] =='Y') {
                                $statusOrder = 'Emergency';
                            }

                            if ($pesan[$i]['URGENT_REASON']=='') {
                                $urgentReason = '-';
                            }else{
                                $urgentReason = $pesan[$i]['URGENT_REASON'];
                            }

                            $emailSendDate = date("d-M-Y");
                            $pukul = date("h:i:sa");
                            
                            $itemDanDeskripsi = $pesan[$i]['SEGMENT1'].' - '.$pesan[$i]['DESCRIPTION'];
                            $kodeBarang = $itemDanDeskripsi;
                            $deskripsi = $pesan[$i]['ITEM_DESCRIPTION'];
                            $qty = $pesan[$i]['QUANTITY'];
                            $uom = $pesan[$i]['UOM'];
                            $alasanPengadaan = $pesan[$i]['ORDER_PURPOSE'];

                            $body .="<tr>
                                        <td>$kodeBarang</td>
                                        <td>$deskripsi</td>
                                        <td>$qty</td>
                                        <td>$uom</td>
                                        <td>$statusOrder</td>
                                        <td>$alasanPengadaan</td>
                                        <td>$urgentReason</td>
                                    </tr>";
                        }
                        $body .= "</body>";
                        $body .= "</table> <br><br>";
                        $body .= "<b>INFO :</b><br>";
                        $body .= "Terdapat <b>".count($normal)." order regular, ".count($susulan)." order susulan, dan ". count($urgent)." order urgent</b> menunggu keputusan Anda!<br>";
                        $body .= "Apabila Anda ingin mengambil tindakan terhadap Order tersebut, Anda dapat klik link <b>$link</b> <br><br>";
                        $body .= "Demikian yang dapat kami sampaikan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih. <br><br>";
                        $body .= "<span style='font-size:10px;'>*Email ini dikirimkan secara otomatis oleh aplikasi <b>Order Kebutuhan Barang Dan Jasa</b> pada $emailSendDate pukul $pukul<br>";
                        $body .= "*Apabila Anda menemukan kendala atau kesulitan maka dapat menghubungi Call Center ICT <b>12300 extensi 1. </span>";


                $this->EmailAlert($noindemail,$subject,$body);

        }

        foreach ($emailBackRequester as $key => $pesanRequester) {
            $noindemail = $key;
            $nRequester = $this->M_requisition->getNamaUser($key);
            $namaRequester = $nRequester[0]['nama'];

            if ($nRequester[0]['jenkel'][0]=='L') {
                $jklRequester = 'Bapak ';
            }else {
                $jklRequester = 'Ibu ';
            };

            $nApprover = $this->M_requisition->getNamaUser($noind);
            $namaApprover = $nApprover[0]['nama'];

            if ($nApprover[0]['jenkel'][0]=='L') {
                $jklApprover = 'Bapak ';
            }else {
                $jklApprover = 'Ibu ';
            };

            $subject = '[PRE-LAUNCH] Order Disetujui';
            $body = "<b>Yth. $jklRequester $namaRequester</b>,<br><br>";
            $body .= "Order anda terkait barang - barang berikut :<br><br>";
            $body .= "<table border='1' style=' border-collapse: collapse;'>
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Deskripsi Barang</th>
                                <th>Quantity</th>
                                <th>UOM</th>
                                <th>Status Order</th>
                                <th>Alasan Pengadaan</th>
                                <th>Alasan Urgensi</th>
                            </tr>
                        </thead>
                        <tbody>";
                            for ($i=0; $i < count($pesanRequester); $i++) { 
                                if ($pesanRequester[$i]['URGENT_FLAG']=='Y' && $pesanRequester[$i]['IS_SUSULAN'] =='N') {
                                    $statusOrder = 'Urgent';
                                }else if($pesanRequester[$i]['URGENT_FLAG']=='N' && $pesanRequester[$i]['IS_SUSULAN'] =='N'){
                                    $statusOrder = 'Reguler';
                                }elseif ($pesanRequester[$i]['IS_SUSULAN'] =='Y') {
                                    $statusOrder = 'Emergency';
                                }

                                if ($pesanRequester[$i]['URGENT_REASON']=='') {
                                    $urgentReason = '-';
                                }else{
                                    $urgentReason = $pesanRequester[$i]['URGENT_REASON'];
                                }

                                $emailSendDate = date("d-M-Y");
                                $pukul = date("h:i:sa");
                                
                                $itemDanDeskripsi = $pesanRequester[$i]['SEGMENT1'].' - '.$pesanRequester[$i]['DESCRIPTION'];
                                $kodeBarang = $itemDanDeskripsi;
                                $deskripsi = $pesanRequester[$i]['ITEM_DESCRIPTION'];
                                $qty = $pesanRequester[$i]['QUANTITY'];
                                $uom = $pesanRequester[$i]['UOM'];
                                $alasanPengadaan = $pesanRequester[$i]['ORDER_PURPOSE'];

                                $body .="<tr>
                                            <td>$kodeBarang</td>
                                            <td>$deskripsi</td>
                                            <td>$qty</td>
                                            <td>$uom</td>
                                            <td>$statusOrder</td>
                                            <td>$alasanPengadaan</td>
                                            <td>$urgentReason</td>
                                        </tr>";
                            }
            $body .= "</body>";
            $body .= "</table> <br><br>";
            $body .= "Telah Disetujui oleh $jklApprover $namaApprover <br><br>";

            $body .= "<span style='font-size:10px;'>*Email ini dikirimkan secara otomatis oleh aplikasi <b>Order Kebutuhan Barang Dan Jasa</b> pada $emailSendDate pukul $pukul<br>";
            $body .= "*Apabila Anda menemukan kendala atau kesulitan maka dapat menghubungi Call Center ICT <b>12300 extensi 1. </span>";


            $this->EmailAlert($noindemail,$subject,$body);
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

    public function EmailAlert($noind, $subject, $body)
	{
		//email
		$getEmail = $this->M_approver->getEmail($noind);
		// echo 
		// $emailUser = 'bondan_surya_n@quick.com';
		
        //send Email
        
        if ($getEmail) {
            $emailUser = $getEmail[0]['EMAIL_INTERNAL'];
            $this->load->library('PHPMailerAutoload');
            $mail = new PHPMailer();
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'html';
            
            // set smtp
            $mail->isSMTP();
            $mail->Host = 'm.quick.com';
            $mail->Port = 465;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->SMTPOptions = array(
                    'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true)
                    );
            $mail->Username = 'no-reply';
            $mail->Password = '123456';
            $mail->WordWrap = 50;
            
            // set email content
            $mail->setFrom('no-reply@quick.com', 'ERP OKEBAJA');
            $mail->addAddress($emailUser);
            $mail->Subject = $subject;
            $mail->msgHTML($body);
    
            
            if (!$mail->send()) {
                // echo "Mailer Error: " . $mail->ErrorInfo;
                exit();
            } else {
                // echo "Message sent!";
            }
        }

    }
    
    public function RejectedOrder()
    {
        $user_id = $this->session->userid;

		$noind = $this->session->user;
		
		$data['Menu'] = 'Pengelola';
		$data['SubMenuOne'] = 'Daftar Rejected Order';
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
        $data['judgement'] = 'R';

        // echo '<pre>';
        // print_r($data['approver']);exit;
        
        $this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Approver/V_OrderApproved',$data);
        $this->load->view('V_Footer',$data);
    }

}