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

        date_default_timezone_set("Asia/Bangkok");
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
		$data['SubMenuOne'] = 'Reguler Order';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $data['approver'] = $this->M_requisition->getPersonId($noind);
        $data['listOrder'] = array();

        $data['panelStatOrder'] = 'panel-success';
        $data['statOrder'] = 'Reguler';

        $and = "URGENT_FLAG ='N' AND IS_SUSULAN ='N'";

        $allOrder = $this->M_approver->getListDataOrderCondition($and);
        // echo'<pre>';
        // print_r($allOrder);exit;
        foreach ($allOrder as $key => $order) {
            $checkOrder = $this->M_approver->checkOrder($order['ORDER_ID']);
            if (isset($checkOrder[0])) {
                if ($checkOrder[0]['APPROVER_ID'] == $data['approver'][0]['PERSON_ID'] && $checkOrder[0]['APPROVER_TYPE'] != 7) {
                    $orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
                    if ($orderSiapTampil[0]['ORDER_CLASS'] != '2' && $orderSiapTampil[0]['ORDER_STATUS_ID'] != '4' || $orderSiapTampil[0]['ORDER_STATUS_ID'] != '5') {
                        array_push($data['listOrder'], $orderSiapTampil[0]);
                    }
                }
            }
        }
        $data['position'] = $this->M_approver->checkPositionApproverIni($data['approver'][0]['PERSON_ID']);

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
		$data['SubMenuOne'] = 'Emergency Order';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $data['approver'] = $this->M_requisition->getPersonId($noind);
        $data['listOrder'] = array();

        $data['panelStatOrder'] = 'panel-warning';
        $data['statOrder'] = 'Emergency';

        $and = "IS_SUSULAN ='Y'";

        $allOrder = $this->M_approver->getListDataOrderCondition($and);
        // echo'<pre>';
        // print_r($allOrder);exit;
        foreach ($allOrder as $key => $order) {
            $checkOrder = $this->M_approver->checkOrder($order['ORDER_ID']);
            // echo'<pre>';
            // print_r($checkOrder);
            if (isset($checkOrder[0])) {
                if ($checkOrder[0]['APPROVER_ID'] == $data['approver'][0]['PERSON_ID'] && $checkOrder[0]['APPROVER_TYPE'] != 7) {
                    $orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
                    if ($orderSiapTampil[0]['ORDER_CLASS'] != '2' && $orderSiapTampil[0]['ORDER_STATUS_ID'] != '4' || $orderSiapTampil[0]['ORDER_STATUS_ID'] != '5') {
                        array_push($data['listOrder'], $orderSiapTampil[0]);
                    }
                }
            }
        }
        // exit;
        $data['position'] = $this->M_approver->checkPositionApproverIni($data['approver'][0]['PERSON_ID']);

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
                if ($checkOrder[0]['APPROVER_ID'] == $data['approver'][0]['PERSON_ID'] && $checkOrder[0]['APPROVER_TYPE'] != 7) {
                    $orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
                    if ($orderSiapTampil[0]['ORDER_CLASS'] != '2' && $orderSiapTampil[0]['ORDER_STATUS_ID'] != '4' || $orderSiapTampil[0]['ORDER_STATUS_ID'] != '5') {
                        array_push($data['listOrder'], $orderSiapTampil[0]);
                    }
                }
            }
        }
        // exit;
        $data['position'] = $this->M_approver->checkPositionApproverIni($data['approver'][0]['PERSON_ID']);
        
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Approver/V_PermintaanApprove',$data);
        $this->load->view('V_Footer',$data);
    }

    public function ApproveOrder()
    {
        $noind = $this->session->user;
        $orderid = $_POST['orderid'];
        $judgment = $_POST['judgment'];
        $person_id = $_POST['person_id'];
        // if ($judgment == 'R') {
        //     echo $judgment;
        // }exit;

        $emailBatch = array();
        $emailBackRequester = array();

        for ($i=0; $i < count($orderid); $i++) { 
            $approval_position = $this->M_approver->checkPositionApprover($orderid[$i],$person_id);
            $orderStatus = $this->M_approver->checkFinishOrder($orderid[$i]);

            if (isset($_POST['note'])) {
                $approve = array(                           
                    'JUDGEMENT' => $judgment,
                    'NOTE' => $_POST['note'],
                 );
                $note = $_POST['note'];
            }else {
                $approve = array(                           
                                    'JUDGEMENT' => $judgment,
                                 );
            }


            if ($person_id == '1513') {
                $approval_position = array_reverse($approval_position);
                $this->M_approver->ApproveOrderKaDep($orderid[$i], $person_id, $approve);
            }else{
                $this->M_approver->ApproveOrder($orderid[$i], $person_id, $approve, $approval_position[0]['APPROVER_TYPE']);
            }

            if ($person_id == $orderStatus[0]['APPROVER_ID']) {
                if ($judgment == 'A') {
                    $orderPos = array(
                        'APPROVE_LEVEL_POS' => $approval_position[0]['APPROVER_TYPE'],
                        'ORDER_STATUS_ID' => '3',
                    );
                }else {
                    $orderPos = array(
                        'APPROVE_LEVEL_POS' => $approval_position[0]['APPROVER_TYPE'],
                        'ORDER_STATUS_ID' => '4',
                    );
                }
                 $stat = 1;
            }else {
                if ($judgment == 'A') {
                    $orderPos = array(
                        'APPROVE_LEVEL_POS' => $approval_position[0]['APPROVER_TYPE'],
                    );

                }else {
                    $orderPos = array(
                        'APPROVE_LEVEL_POS' => $approval_position[0]['APPROVER_TYPE'],
                        'ORDER_STATUS_ID' => '4',
                    );

                }
                $stat = 0;
            }
            
            $this->M_approver->updatePosOrder($orderid[$i],$orderPos);

            if ($stat == 0 && $judgment == 'A') {

                $order = $this->M_approver->getOrderToApprove1($orderid[$i]);
    
                $getNextApproval = $this->M_approver->getNextApproval($orderid[$i]);
    
                if (!isset($emailBatch[$getNextApproval[0]['NATIONAL_IDENTIFIER']])) {
                    $emailBatch[$getNextApproval[0]['NATIONAL_IDENTIFIER']] = array();
                }
    
                array_push($emailBatch[$getNextApproval[0]['NATIONAL_IDENTIFIER']], $order[0]);
            }


                $order = $this->M_approver->getOrderToApprove1($orderid[$i]);

                if (!isset($emailBackRequester[$order[0]['NATIONAL_IDENTIFIER']])) {
                    $emailBackRequester[$order[0]['NATIONAL_IDENTIFIER']] = array();
                }

                array_push($emailBackRequester[$order[0]['NATIONAL_IDENTIFIER']], $order[0]);


            
        }
            if ($stat == 0 && $judgment == 'A') {

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
                                        $bgColor = '#d73925';
                                    }else if($pesan[$i]['URGENT_FLAG']=='N' && $pesan[$i]['IS_SUSULAN'] =='N'){
                                        $statusOrder = 'Reguler';
                                        $bgColor = '#009551';
                                    }elseif ($pesan[$i]['IS_SUSULAN'] =='Y') {
                                        $statusOrder = 'Emergency';
                                        $bgColor = '#da8c10';
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
                                                <td style='background-color:$bgColor;'>$statusOrder</td>
                                                <td>$alasanPengadaan</td>
                                                <td>$urgentReason</td>
                                            </tr>";
                                }
                                $body .= "</body>";
                                $body .= "</table> <br><br>";
                                $body .= "<b>INFO :</b><br>";
                                $body .= "Terdapat <b>".count($normal)." order reguler, ".count($susulan)." order susulan, dan ". count($urgent)." order urgent</b> menunggu keputusan Anda!<br>";
                                $body .= "Apabila Anda ingin mengambil tindakan terhadap Order tersebut, Anda dapat klik link <b>$link</b> <br><br>";
                                $body .= "Demikian yang dapat kami sampaikan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih. <br><br>";
                                $body .= "<span style='font-size:10px;'>*Email ini dikirimkan secara otomatis oleh aplikasi <b>Order Kebutuhan Barang Dan Jasa</b> pada $emailSendDate pukul $pukul<br>";
                                $body .= "*Apabila Anda menemukan kendala atau kesulitan maka dapat menghubungi Call Center ICT <b>12300 extensi 1. </span>";
    
    
                        $this->EmailAlert($noindemail,$subject,$body);
        
                }

            }

            if ($judgment == 'R') {
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
    
                    $subject = '[PRE-LAUNCH] Order Ditolak';
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
                                            $bgColor = '#d73925';
                                        }else if($pesanRequester[$i]['URGENT_FLAG']=='N' && $pesanRequester[$i]['IS_SUSULAN'] =='N'){
                                            $statusOrder = 'Reguler';
                                            $bgColor = '#009551';
                                        }elseif ($pesanRequester[$i]['IS_SUSULAN'] =='Y') {
                                            $statusOrder = 'Emergency';
                                            $bgColor = '#da8c10';
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
                                                    <td style='background-color:$bgColor;'>$statusOrder</td>
                                                    <td>$alasanPengadaan</td>
                                                    <td>$urgentReason</td>
                                                </tr>";
                                    }
                    $body .= "</body>";
                    $body .= "</table> <br><br>";
                    $body .= "Tidak Disetujui oleh $jklApprover $namaApprover dengan alasan : <b>$note</b><br><br>";
    
                    $body .= "<span style='font-size:10px;'>*Email ini dikirimkan secara otomatis oleh aplikasi <b>Order Kebutuhan Barang Dan Jasa</b> pada $emailSendDate pukul $pukul<br>";
                    $body .= "*Apabila Anda menemukan kendala atau kesulitan maka dapat menghubungi Call Center ICT <b>12300 extensi 1. </span>";
        
        
                    $this->EmailAlert($noindemail,$subject,$body);
                }
            }

            if ($judgment == 'A') {
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
                                            $bgColor = '#d73925';
                                        }else if($pesanRequester[$i]['URGENT_FLAG']=='N' && $pesanRequester[$i]['IS_SUSULAN'] =='N'){
                                            $statusOrder = 'Reguler';
                                            $bgColor = '#009551';
                                        }elseif ($pesanRequester[$i]['IS_SUSULAN'] =='Y') {
                                            $statusOrder = 'Emergency';
                                            $bgColor = '#da8c10';
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
                                                    <td style='background-color:$bgColor;'>$statusOrder</td>
                                                    <td>$alasanPengadaan</td>
                                                    <td>$urgentReason</td>
                                                </tr>";
                                    }
                    $body .= "</body>";
                    $body .= "</table> <br><br>";
                    $body .= "Telah Disetujui oleh $jklApprover $namaApprover <br><br>";
    
                    $body .= "<span style='font-size:10px;'>*Email ini dikirimkan secara otomatis oleh aplikasi <b>Order Kebutuhan Barang Dan Jasa</b> pada $emailSendDate pukul $pukul<br>";
                    $body .= "*Apabila Anda menemukan kendala atau kesulitan maka dapat menghubungi Call Center ICT <b>12300 extensi 1. </span>";
        
                    if ($namaApprover != $namaRequester) {
                        $this->EmailAlert($noindemail,$subject,$body);
                    }
                }
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

        $data['judgement'] = 'A';
        
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
        $data['judgement'] = 'R';
        
        $this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Approver/V_OrderApproved',$data);
        $this->load->view('V_Footer',$data);
    }

    public function getStock()
    {
        $itemkode = $_POST['itemkode'];
        $data['getStock'] = $this->M_approver->getStock($itemkode);
        $data['outstandingPO'] = $this->M_approver->getStandingPO($itemkode);

        $returnTable = $this->load->view('OrderKebutuhanBarangDanJasa/Approver/V_TableOfStock',$data,true);

        echo $returnTable;
    }

    public function getAttachment()
    {
        $order_id = $_POST['order_id'];

        $data = $this->M_approver->getAttachment($order_id);

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
    
    public function UbahDeskripsiOrder()
    {
        $person_id = $_POST['person_id'];
        $order_id = $_POST['order_id'];
        $desc_baru = $_POST['desc_baru'];
        $desc_lama = $_POST['desc_lama'];

        $ubah = array(
                        'ITEM_DESCRIPTION_BEFORE' => $desc_lama,
                        'ITEM_DESCRIPTION_AFTER' => $desc_baru,
                     );

        $data = array('ITEM_DESCRIPTION' => $desc_baru, );

        $this->M_approver->UbahApproverOrder($person_id,$order_id,$ubah);
        $this->M_approver->UbahOrderHeader($order_id,$data);

        echo 1;

    }

    public function UbahAlasanOrder()
    {
        $person_id = $_POST['person_id'];
        $order_id = $_POST['order_id'];
        $order_purp_baru = $_POST['order_purp_baru'];
        $order_purp_lama = $_POST['order_purp_lama'];


        $ubah = array(
                        'ORDER_PURPOSE_BEFORE' => $order_purp_lama,
                        'ORDER_PURPOSE_AFTER' => $order_purp_baru,
                     );
        
       $data = array('ORDER_PURPOSE' => $order_purp_baru, );

        $this->M_approver->UbahApproverOrder($person_id,$order_id,$ubah);
        $this->M_approver->UbahOrderHeader($order_id,$data);

        echo 1;

    }

    public function UbahQtyOrder()
    {
        $person_id = $_POST['person_id'];
        $order_id = $_POST['order_id'];
        $qty_baru = $_POST['qty_baru'];
        $qty_lama = $_POST['qty_lama'];

        $ubah = array(
            'QUANTITY_BEFORE' => $qty_lama,
            'QUANTITY_AFTER' => $qty_baru,
         );

        $data = array('QUANTITY' => $qty_baru, );

        $this->M_approver->UbahApproverOrder($person_id,$order_id,$ubah);
        $this->M_approver->UbahOrderHeader($order_id,$data);

        echo 1;
    }

    public function getHistoryEditOrder()
    {
        $order_id = $_POST['order_id'];

        $data = $this->M_approver->getHistoryEditOrder($order_id);

        echo json_encode($data);
    }

    public function getUnapprovedOrderCount()
    {
        $noind = $this->session->user;
        $total_unapproved_order = $this->M_approver->getUnapprovedOrderCount($noind, 'ALL');

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($total_unapproved_order));
    }
	
}