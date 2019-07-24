<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_TransactKIB extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->helper(array('url','download'));
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('TransactKIB/M_transactkib');
        
        date_default_timezone_set('Asia/Jakarta');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			// $this->load->helper(array('url','file'));
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }

	public function checkSession()
	{
		if($this->session->is_logged){		
		}else{
			redirect();
		}
	}


// ------------------------------------------------- show the dashboard ----------------------------------------- //


public function index()
{
    $this->checkSession();
    $user_id = $this->session->userid;
    
    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
    $data['Title'] = '';
    $data['Menu'] = '';
    $data['SubMenuOne'] = '';
    $data['SubMenuTwo'] = '';

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('TransactKIB/V_Index',$data);
    $this->load->view('V_Footer',$data);
}

public function Transact()
{
    $this->checkSession();
    $user_id = $this->session->userid;

    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';
    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    // $this->load->view('V_Header',$data);
    // $this->load->view('V_Sidemenu',$data);
    // $this->load->view('TransactKIB/Transact/V_Input',$data);
    // $this->load->view('V_Footer',$data);

    $noind = $this->session->user;
    $data['usr_id'] = $this->M_transactkib->usrID($noind);

    $val = $this->M_transactkib->getNoind();
	$list = array_column($val, 'NOMOR_INDUK');
    $find = in_array($noind, $list);
    
    if($find) {
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('TransactKIB/Transact/V_Input',$data);
        $this->load->view('V_Footer',$data);
    }else{
        $this->load->view('TransactKIB/V_Call',$data);
    }
		// echo "<pre>";
		// echo $user_id;
		// echo "<pre>";
        // echo $noind;
        // echo "<pre>";
        // echo $data['usr_id'];
		// exit();
}

public function getData()
{
    $kib_code = $this->input->post('slcNoKIB');
    $to_transfer= $this->input->post('transfer');
    $sub_inv = $this->M_transactkib->findSubInvCode($kib_code);
    $qty_transaction = $this->M_transactkib->checkKIB($kib_code);
    $qty = $qty_transaction[0]['COUNT(KK.QTY_TRANSACTION)'];

    $org = $this->M_transactkib->ORG($kib_code);
    $orgID = $org[0]['ORGANIZATION_ID'];
    // echo "<pre>";
    // print_r($orgID);
    // exit();

    $inv_id = $this->M_transactkib->invID($kib_code);
    $inv = $inv_id[0]['INVENTORY_ITEM_ID'];
    // echo "<pre>";
    // print_r($inv);
    
    
    $sub_inventory = $this->M_transactkib->subINV($kib_code);
    $sub = $sub_inventory[0]['FROM_SUBINVENTORY_CODE'];
    // echo "<pre>";
    // print_r($sub);

    $loc_id = $this->M_transactkib->locID($kib_code);
    $loc = $loc_id[0]['FROM_LOCATOR_ID'];
    // echo "<pre>";
    // print_r($loc);
    // exit();

    if($qty == 1){
        echo $qty;
    }else{
        $org = $this->M_transactkib->getORG($kib_code);
        $data['hasil'] = $org[0]['KIB_GROUP'];
        // echo "<pre>";
        // print_r($org);
        
        $item_num = $this->M_transactkib->getItemNum($kib_code);
        $data['hasil1'] = $item_num[0]['SEGMENT1'];
        // echo "<pre>";
        // print_r($item_num);
        
        $desc = $this->M_transactkib->getItemDesc($kib_code);
        $data['hasil2'] = $desc[0]['DESCRIPTION'];
        // echo "<pre>";
		// print_r($desc);
        
        $warehouse = $this->M_transactkib->getToWarehouse($sub_inv[0]['TO_SUBINVENTORY_CODE']);
        $data['hasil3'] = $warehouse[0]['DESCRIPTION'];
        // print_r($sub_inv);
        // echo "<pre>";
		// print_r($warehouse);
        
        $plan = $this->M_transactkib->getPlan($kib_code);
        $data['hasil4'] = $plan[0]['SCHEDULED_QUANTITY'];
        // echo "<pre>";
        // print_r($plan);
        $org = $this->M_transactkib->ORG($kib_code);
        $orgID = $org[0]['ORGANIZATION_ID'];
    // echo "<pre>";
    // print_r($orgID);
    // exit();

        $inv_id = $this->M_transactkib->invID($kib_code);
        $inv = $inv_id[0]['INVENTORY_ITEM_ID'];
    // echo "<pre>";
    // print_r($inv);
    
    
        $sub_inventory = $this->M_transactkib->subINV($kib_code);
        $sub = $sub_inventory[0]['FROM_SUBINVENTORY_CODE'];
    // echo "<pre>";
    // print_r($sub);

        $loc_id = $this->M_transactkib->locID($kib_code);
        $loc = $loc_id[0]['FROM_LOCATOR_ID'];
        
        $att = $this->M_transactkib->getATT($org[0]['ORGANIZATION_ID'],$inv_id[0]['INVENTORY_ITEM_ID'],
                                            $sub_inventory[0]['FROM_SUBINVENTORY_CODE'],$loc_id[0]['FROM_LOCATOR_ID']);
        $data['hasil5'] = $att[0]['ATT'];
        // echo "<pre>";
		// print_r($att);

        $totf = $this->M_transactkib->getToTF($kib_code);
        $data['hasil6'] = $totf[0]['QTY_KIB'];
        // echo "<pre>";
        // print_r($totf);
        // c
        
        
        $tes = $this->load->view('TransactKIB/Transact/V_TransactKIB', $data, TRUE);
        echo $tes;
    }
}

public function Transaksi()
{
    $kib_code = $this->input->post('slcNoKIB');
    // echo "<pre>";
    // echo $kib_code;
    $to_transfer= $this->input->post('transfer');
    // echo "<pre>";
    // echo $to_transfer;
    // exit();
    $noind = $this->session->user;
    $data['usr_id'] = $this->M_transactkib->usrID($noind);
    $user_id = $this->M_transactkib->usrID($noind);
    $usr_id = $user_id[0]['USER_ID'];
    // echo $usr_id;
    // exit();
//---------------------------------------------------GETTING THE INSERT PARAMETERS--------------------------------------//

//################################################# nomor_organizationid_asal ############################################//
    $sic =$this->M_transactkib->subInvCode($kib_code);
    $subinv_code = $sic[0]['FROM_SUBINVENTORY_CODE'];

    $oc  =$this->M_transactkib->orgCode($subinv_code);
    $org_code = $oc[0]['ORGANIZATION_CODE'];

    $on =$this->M_transactkib->orgNumber($org_code);
    $org_number= $on[0]['ORGANIZATION_ID'];


//################################################### subinventory_code ###################################################//
    $sc =$this->M_transactkib->subInventoryCode($kib_code);
    $subinventory_code = $sc[0]['TO_SUBINVENTORY_CODE'];

//##################################################### to_organization_id ##############################################//
    $oi =$this->M_transactkib->orgID($subinventory_code);
    $organization_id = $oi[0]['ORGANIZATION_ID']; 

//####################################################### ItemNum ##########################################################//
    $in = $this->M_transactkib->getItemNum($kib_code);
    $item_num = $in[0]['SEGMENT1'];

//####################################################### order ID #####################################################//
    $oi = $this->M_transactkib->orderID($kib_code);
    $order_id = $oi[0]['ORDER_ID'];

//####################################################### organizationID ################################################//
    $oii = $this->M_transactkib->organizationID($order_id);
    $org_id = $oii[0]['ORGANIZATION_ID'];

//################################################### inventory_item_id #################################################//
    $it = $this->M_transactkib->inventoryItemID($item_num);
    $inventory_item_id = $it[0]['INVENTORY_ITEM_ID'];
 
//####################################################### ItemUOM #######################################################//
    $iu = $this->M_transactkib->itemUOM($inventory_item_id,$org_id);
    $item_uom = $iu[0]['PRIMARY_UOM_CODE'];

    if ($subinv_code == $organization_id){
        $item = '2';
    }else{
        $item = '3';
    }
//####################################################### trans_action_id ###############################################//
    $ti = $this->M_transactkib->transActionID($item);
    $trans_action_id = $ti[0]['TRANSACTION_ACTION_ID'];

//####################################################### trans_type_id ##################################################//
    $ty = $this->M_transactkib->transTypeID($item);
    $trans_type_id = $ty[0]['TRANSACTION_TYPE_ID'];

//####################################################### to_locator_id #################################################//
    $tl = $this->M_transactkib->toLocatorID($kib_code);
    $to_locator_id = $tl[0]['TO_LOCATOR_ID'];

//####################################################### vTransPrice #################################################//
    $vtp = $this->M_transactkib->vTransPrice($org_id,$organization_id,$inventory_item_id);
    $v_trans_price = (empty($vtp[0]['OPERAND'])) ? 0 : $vtp[0]['OPERAND'];

    // if(empty($vtp[0]['OPERAND'])) {
    //     $v_trans_price = 0;
    // } else {
    //     $v_trans_price = $vtp[0]['OPERAND'];
    // }
//####################################################### qtyTrans_KK_v #################################################//
    $qtk = $this->M_transactkib->qtyTransKK($kib_code);
    $qty_trans_kk = $qtk[0]['QTY_TRANSACTION'];

//######################################################### user id ######################################################//
    $user_id = $this->session->userid;
    // echo "<pre>";
    // print_r($user_id);
//######################################################### user id ######################################################//
    $kg = $this->M_transactkib->getORG($kib_code);
    $kib_group = $kg[0]['KIB_GROUP'];
    
    //   echo "<pre>";
    //   print_r($subinv_code);
    //   print_r('<br/>');
    //   print_r($org_code);
    //   print_r('<br/>');
    //   print_r($org_number); //for comparison
    //   print_r('<br/>');
    //   print_r($organization_id);//for comparison
    //   print_r('<br/>');
    //   print_r($subinventory_code);
    //   print_r('<br/>');
    //   print_r($item_num);
    //   print_r('<br/>');
    //   print_r($order_id);
    //   print_r('<br/>');
    //   print_r($org_id);//for comparison
    //   print_r('<br/>');
    //   print_r($item_uom);
    //   print_r('<br/>');
    //   print_r($trans_action_id);
    //   print_r('<br/>');
    //   print_r($trans_type_id);
    //   print_r('<br/>');
    //   print_r($to_locator_id);//kosong//emg
    //   print_r('<br/>');
    //   print_r($v_trans_price);//kosong//emg
    //   print_r('<br/>');
    //   print_r($qty_trans_kk);//kosong//emg
    //   print_r('<br/>');
    //   print_r($user_id);
    //   print_r('<br/>');
    //   print_r($kib_group);
    //   print_r('<br/>');
    //   print_r($order_id);
    //   print_r('<br/>');
    //   print_r($item);
    //   exit();

//-----------------------------------------------------Checking Before Transact---------------------------------------//
    $on_hand = $this->M_transactkib->onHand($kib_code);
    // print_r($on_hand);
    // exit();
    $hand = $on_hand[0]['QTY_TRANSACTIONS'];
    // echo "<pre>";
    // print_r($hand);
    // exit();

    $totf = $this->M_transactkib->M_transactkib->getToTF($kib_code);
    // print_r($totf);
    $tf = $totf[0]['QTY_KIB'];
    // echo "<pre>";
    // print_r($tf);

    $transaction = $this->M_transactkib->verification($kib_code);
    // print_r($transaction);
    $qtran =  $transaction[0]['QTY_TRANSACTIONS'];
    // echo "<pre>";
    // print_r($qtran);
    
    $org = $this->M_transactkib->ORG($kib_code);
    $orgID = $org[0]['ORGANIZATION_ID'];
    // echo "<pre>";
    // print_r($orgID);

    $inv_id = $this->M_transactkib->invID($kib_code);
    $inv = $inv_id[0]['INVENTORY_ITEM_ID'];
    // echo "<pre>";
    // print_r($inv);
    
    
    $sub_inventory = $this->M_transactkib->subINV($kib_code);
    $sub = $sub_inventory[0]['FROM_SUBINVENTORY_CODE'];
    // echo "<pre>";
    // print_r($sub);

    $loc_id = $this->M_transactkib->locID($kib_code);
    $loc = $loc_id[0]['FROM_LOCATOR_ID'];
    // echo "<pre>";
    // print_r($loc);
    // exit();
   

    $att = $this->M_transactkib->checkATT($org[0]['ORGANIZATION_ID'],$inv_id[0]['INVENTORY_ITEM_ID'],
                                          $sub_inventory[0]['FROM_SUBINVENTORY_CODE'],$loc_id[0]['FROM_LOCATOR_ID']);
    $result = $att[0]['ATT'];
    // echo "<pre>";
    // print_r($result);

    $ver = $this->M_transactkib->QtyVer($kib_code);
    $qtyVer = $ver[0]['HASIL'];
    // $qtyVer = $ver[0]['[QTY_TRANSACTIONS-NVL((SELECTSUM(MMT.TRANSACTION_QUANTITY)FROMMTL_MATERIAL_TRANSACTIONSMMTWHEREMMT.INVENTORY_ITEM_ID=(SELECTKK.PRIMARY_ITEM_IDFROMKHS_KIB_KANBANKKWHEREKK.KIBCODE='$kib_code')ANDMMT.TRANSACTION_SOURCE_NAME='$kib_code'ANDMMT.TRANSACTI]'];
    // echo "<pre>";
    // print_r($qtyVer);

    $cancel =  $this->M_transactkib->cancel($kib_code);
    $flag = $cancel[0]['COUNT(FLAG_CANCEL)'];
    // echo "<pre>";
    // print_r($flag);
    // exit();

    if ($hand < $tf) {
        echo "On Hand Kurang";
    }else if ($qtran <= 0){
        echo "Transaksi Kelebihan";
    }else if ($result <= $tf){
        echo "ATT Kurang";
    }else if ($tf < $qtyVer){
        echo "Transfer Kebanyakan";
    }else if ($flag > 0){
        echo "KIB Cancel";
    }else{ 
        $this->M_transactkib->insert($org_number,$subinv_code,$organization_id,$subinventory_code,$item_num,
        $to_transfer,$item_uom,$kib_code,$trans_action_id,$trans_type_id,$loc,
        $to_locator_id,$kib_group,$v_trans_price); 
        $this->M_transactkib->update($to_transfer,$user_id,$result,$kib_code,$org_number);
        $this->M_transactkib->Fnd($usr_id);
        echo "Sukses Transact";
    }

}


}
?>