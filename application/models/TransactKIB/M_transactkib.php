<?php defined('BASEPATH') OR die('No direct script access allowed');

class M_transactkib extends CI_Model
{
	var $oracle;
	function __construct()
	{
		parent::__construct();
		$this->load->database();
      $this->load->library('encrypt');
      $this->oracle = $this->load->database('oracle', true);
   }

   function checkKIB($kib_code)
   {
   $sql = "SELECT count(kk.qty_transaction) FROM khs_kib_kanban kk 
           WHERE kk.KIBCODE='$kib_code' AND 
           (SELECT ka.qty_kib FROM khs_kib_kanban ka 
           WHERE ka.KIBCODE=kk.KIBCODE)=kk.qty_transaction";
//   echo $sql;
//   exit();
   
   $query = $this->oracle->query($sql);
   return  $query->result_array();
   }

//------------------------------------------------------get data---------------------------------------------------------//

   function getORG($kib_code)
   {
   $sql = "SELECT KIB_GROUP FROM khs_kib_kanban WHERE KIBCODE = '$kib_code'";
   
   $query = $this->oracle->query($sql);
   return  $query->result_array();
   }

   function getItemNum($kib_code)
   {
   $sql = "SELECT ms.segment1 FROM khs_kib_kanban kk, mtl_system_items_b ms 
           WHERE ms.ORGANIZATION_ID=kk.ORGANIZATION_ID AND ms.INVENTORY_ITEM_ID=kk.PRIMARY_ITEM_ID 
           AND kk.KIBCODE='$kib_code' and nvl(FLAG_CANCEL,'N')<>'Y'";
   
   $query = $this->oracle->query($sql);
   return  $query->result_array();
   }
 
   function getItemDesc($kib_code)
   {
   $sql = "SELECT ms.description from khs_kib_kanban kk, mtl_system_items_b ms 
           where  ms.ORGANIZATION_ID=kk.ORGANIZATION_ID 
           and ms.INVENTORY_ITEM_ID=kk.PRIMARY_ITEM_ID 
           and kk.KIBCODE='$kib_code' and nvl(FLAG_CANCEL,'N')<>'Y'";
   
   $query = $this->oracle->query($sql);
   return  $query->result_array();
   }

   function findSubInvCode($kib_code)
   {
      $sql = "SELECT kkk.to_subinventory_code FROM khs_kib_kanban kkk 
              WHERE kkk.KIBCODE = '$kib_code'";

        $query = $this->oracle->query($sql);
        return  $query->result_array();
   }

   function getToWarehouse($sub_inv)
   {
   $sql = "SELECT ms.DESCRIPTION from MTL_SECONDARY_INVENTORIES_FK_V ms 
           where  ms.SECONDARY_INVENTORY_NAME='$sub_inv'";
   
   $query = $this->oracle->query($sql);
   return  $query->result_array();
   }

   function getPlan($kib_code)
   {
   $sql = "SELECT kkk.SCHEDULED_QUANTITY FROM khs_kib_kanban kkk 
           WHERE  kkk.KIBCODE = '$kib_code'";
   
   $query = $this->oracle->query($sql);
   return  $query->result_array();
   }

   function getATT($org,$inv_id,$sub_inventory,$loc_id)
   {
   $sql ="SELECT KHS_INV_QTY_ATT($org,'$inv_id','$sub_inventory','$loc_id','') att
   FROM dual";
      //  echo $sql;
      //  exit();
   
   $query = $this->oracle->query($sql);
   return  $query->result_array();
   }

   function getToTF($kib_code)
   {
   $sql ="SELECT kkk.QTY_KIB FROM khs_kib_kanban kkk WHERE  kkk.KIBCODE = '$kib_code'";
   
   $query = $this->oracle->query($sql);
   return  $query->result_array();
   }

//---------------------------------------------start checking------------------------------------------------------//

   function onHand($kib_code)
   {
   $sql ="SELECT kkk.QTY_TRANSACTIONS FROM khs_kib_kanban kkk WHERE kkk.KIBCODE = '$kib_code'";
//    echo $sql;
//    exit();
   
   $query = $this->oracle->query($sql);
   return  $query->result_array();
   }

   function verification($kib_code)
   {
   $sql ="SELECT QTY_TRANSACTIONS FROM khs_kib_kanban WHERE KIBCODE = '$kib_code'";
   
   $query = $this->oracle->query($sql);
   return  $query->result_array();
   }
   
   function ORG($kib_code)
   {
   $sql ="SELECT ORGANIZATION_ID FROM khs_kib_kanban WHERE KIBCODE = '$kib_code'";
   
   $query = $this->oracle->query($sql);
   return  $query->result_array();
   }

   function invID($kib_code)
   {
   $sql ="SELECT INVENTORY_ITEM_ID FROM khs_kib_kanban kk, mtl_system_items_b ms 
          WHERE  ms.ORGANIZATION_ID=kk.ORGANIZATION_ID AND ms.INVENTORY_ITEM_ID=kk.PRIMARY_ITEM_ID 
          AND kk.KIBCODE='$kib_code' AND nvl(FLAG_CANCEL,'N')<>'Y'";
   
   $query = $this->oracle->query($sql);
   return  $query->result_array();
   }

   function subINV($kib_code)
   {
   $sql ="SELECT FROM_SUBINVENTORY_CODE FROM khs_kib_kanban WHERE KIBCODE = '$kib_code'";
   
   $query = $this->oracle->query($sql);
   return  $query->result_array();
   }

   function locID($kib_code)
   {
   $sql ="SELECT FROM_LOCATOR_ID FROM khs_kib_kanban WHERE KIBCODE = '$kib_code'";
   
   $query = $this->oracle->query($sql);
   return  $query->result_array();
   }
   
   function checkATT($org,$inv_id,$sub_inventory,$loc_id)
   {
   $sql ="SELECT KHS_INV_QTY_ATT($org,'$inv_id','$sub_inventory','$loc_id','') att
          FROM dual";
  
   
   $query = $this->oracle->query($sql);
   return  $query->result_array();
   }

   function QtyVer($kib_code)
   {
   $sql ="SELECT qty_transactions - NVL((SELECT SUM(mmt.TRANSACTION_QUANTITY) FROM mtl_material_transactions mmt 
   WHERE mmt.INVENTORY_ITEM_ID =(SELECT KK.PRIMARY_ITEM_ID FROM khs_kib_kanban KK WHERE KK.KIBCODE = '$kib_code')
   AND mmt.TRANSACTION_SOURCE_NAME = '$kib_code' 
   AND mmt.TRANSACTION_QUANTITY > 0), 0) hasil
   FROM khs_kib_kanban
   WHERE KIBCODE = '$kib_code'";
//    echo $sql;
//    exit();
 
   $query = $this->oracle->query($sql);
   return  $query->result_array();
   }

   function cancel($kib_code)
   {
   $sql ="SELECT count(FLAG_CANCEL) FROM khs_kib_kanban WHERE KIBCODE='$kib_code'";
   
   $query = $this->oracle->query($sql);
   return  $query->result_array();
   }

//--------------------------------------------------------------API----------------------------------------------------//
  
//#################################################from_subinventory_code##############################################//
   function subInvCode($kib_code)
   {
   $sql ="SELECT kkk.FROM_SUBINVENTORY_CODE FROM khs_kib_kanban kkk WHERE kkk.KIBCODE='$kib_code'";
   
   $query = $this->oracle->query($sql);
   return  $query->result_array(); 
   }  
//#################################################from_organization_code##############################################//
   function orgCode($subinv_code)
   {
   $sql ="SELECT DISTINCT(mp.organization_code)
          FROM mtl_secondary_inventories mil,
               mtl_parameters mp
          WHERE mil.organization_id = mp.organization_id
          AND mil.secondary_inventory_name = '$subinv_code'";

   $query = $this->oracle->query($sql);
   return  $query->result_array();      
   }
//#################################################nomor_organizationid_asal############################################//
   function orgNumber($org_code)
   {
   $sql ="SELECT organization_id FROM mtl_parameters 
          WHERE organization_code = '$org_code'";

   $query = $this->oracle->query($sql);
   return  $query->result_array();         
   }
//################################################# to_organization_id ###################################################//
   function orgID($subinventory_code)
   {
   $sql ="SELECT DISTINCT(mp.organization_ID)
          FROM mtl_secondary_inventories mil,
               mtl_parameters mp
          WHERE mil.organization_id = mp.organization_id
          AND mil.secondary_inventory_name = '$subinventory_code'";
   // echo $sql;
   // exit();
   $query = $this->oracle->query($sql);
   return  $query->result_array();         
   }
//###################################################subinventory_code###################################################//
   function subInventoryCode($kib_code)
   {
   $sql ="SELECT KKK.TO_SUBINVENTORY_CODE FROM KHS_KIB_KANBAN KKK WHERE KKK.KIBCODE = '$kib_code'";

   $query = $this->oracle->query($sql);
   return  $query->result_array();         
   }

//################################################### inventory_item_id #################################################//
   function inventoryItemID($item_num)
   {
   $sql ="SELECT INVENTORY_ITEM_ID FROM MTL_SYSTEM_ITEMS_B WHERE SEGMENT1 = '$item_num'";
//    echo $sql;
//    exit();

   $query = $this->oracle->query($sql);
   return  $query->result_array();         
   }

//################################################### order_id #######################################################//
   function orderID($kib_code)
   {
   $sql ="SELECT kk.ORDER_ID
          FROM khs_kib_kanban kk,
          mtl_system_items_b ms
          WHERE ms.ORGANIZATION_ID = kk.ORGANIZATION_ID
          AND ms.INVENTORY_ITEM_ID = kk.PRIMARY_ITEM_ID
          AND kk.KIBCODE = '$kib_code'
          AND NVL(FLAG_CANCEL, 'N')<> 'Y'";
// echo "<pre>";
// echo $sql;
// exit();

   $query = $this->oracle->query($sql);
   return  $query->result_array();         
   }

//################################################### organization_id #################################################//
   function organizationID($order_id)
   {
   $sql ="SELECT we.ORGANIZATION_ID from wip_entities we where we.WIP_ENTITY_ID = '$order_id'";
   // echo "<pre>";
   // echo $sql;
  

   $query = $this->oracle->query($sql);
   return  $query->result_array();         
   }

//####################################################### ItemUOM #######################################################//
   function itemUOM($inventory_item_id,$org_id)
   {
   $sql ="SELECT PRIMARY_UOM_CODE from mtl_system_items_b where INVENTORY_ITEM_ID='$inventory_item_id' 
          and ORGANIZATION_ID  = '$org_id'";
      //   echo "<pre>";
      //   echo $sql;  
      //   exit();

   $query = $this->oracle->query($sql);
   return  $query->result_array();         
   }

//####################################################### trans_action_id ###############################################//
   function transActionID($item)
   {
   $sql ="SELECT mtt.TRANSACTION_ACTION_ID
          FROM MTL_TRANSACTION_TYPES mtt
          WHERE mtt.TRANSACTION_ACTION_ID = '$item'
          AND mtt.TRANSACTION_SOURCE_TYPE_ID = 13
          AND mtt.TRANSACTION_TYPE_ID = '$item'
          AND mtt.DISABLE_DATE IS NULL";

   $query = $this->oracle->query($sql);
   return  $query->result_array();         
   }

//####################################################### trans_type_id ##################################################//
   function transTypeID($item)
   {
   $sql ="SELECT mtt.TRANSACTION_TYPE_ID
          FROM MTL_TRANSACTION_TYPES mtt
          WHERE mtt.TRANSACTION_ACTION_ID = '$item'
          AND mtt.TRANSACTION_SOURCE_TYPE_ID = 13
          AND mtt.TRANSACTION_TYPE_ID = '$item'
          AND mtt.DISABLE_DATE IS NULL";

   $query = $this->oracle->query($sql);
   return  $query->result_array();         
   }

//####################################################### to_locator_id #################################################//
   function toLocatorID($kib_code)
   {
   $sql ="SELECT KKK.TO_LOCATOR_ID FROM KHS_KIB_KANBAN KKK WHERE KKK.KIBCODE = '$kib_code'";
      //   echo "<pre>";
      //   echo $sql;  
      //   exit();

   $query = $this->oracle->query($sql);
   return  $query->result_array();         
   }

//####################################################### vTransPrice #################################################//
   function vTransPrice($org_id,$organization_id,$inventory_item_id)
   {
   $sql ="SELECT qlv.OPERAND
          FROM qp_list_lines_v qlv
          WHERE qlv.LIST_HEADER_ID IN (SELECT PRICELIST_ID
          FROM MTL_SHIPPING_NETWORK_VIEW
          WHERE FROM_ORGANIZATION_ID = '$org_id'
          AND TO_ORGANIZATION_ID = '$organization_id')
          AND qlv.PRODUCT_ID = '$inventory_item_id'";

// echo $sql;  
// exit();

   $query = $this->oracle->query($sql);
   return  $query->result_array();         
   }

//####################################################### insert #################################################//
   function insert($org_number,$subinv_code,$organization_id,$subinventory_code,$item_num,
                   $to_transfer,$item_uom,$kib_code,$trans_action_id,$trans_type_id,$loc,
                   $to_locator_id,$kib_group,$v_trans_price)
   {
   $sql = "INSERT INTO  MTL_TRANSACTIONS_INTERFACE (ORGANIZATION_ID,
                        SUBINVENTORY_CODE,
                        TRANSFER_ORGANIZATION,
                        TRANSFER_SUBINVENTORY,
                        SHIPMENT_NUMBER,
                        ITEM_SEGMENT1,
                        TRANSACTION_QUANTITY,
                        TRANSACTION_UOM,
                        TRANSACTION_DATE,
                        TRANSACTION_SOURCE_NAME,
                        ATTRIBUTE1,
                        TRANSACTION_SOURCE_TYPE_ID,
                        TRANSACTION_ACTION_ID,
                        TRANSACTION_TYPE_ID,
                        SOURCE_CODE,
                        TRANSACTION_MODE,
                        LOCK_FLAG,
                        SOURCE_HEADER_ID,
                        SOURCE_LINE_ID,
                        PROCESS_FLAG,
                        LAST_UPDATE_DATE,
                        LAST_UPDATED_BY,
                        CREATION_DATE,
                        CREATED_BY,
                        TRANSACTION_REFERENCE,
                        LOCATOR_ID,
                        TRANSFER_LOCATOR,
                        TRANSFER_PRICE)
	VALUES('$org_number',
	'$subinv_code',
	'$organization_id',
	'$subinventory_code',
	'',
	'$item_num',
	'$to_transfer',
	'$item_uom',
	SYSDATE,
	'$kib_code',
	'',
	4,
	'$trans_action_id',
	'$trans_type_id',
	'KIB QUICKDROID',
	3,
	2,
	-1,
	-1,
	1,
	SYSDATE,
	-1,
	SYSDATE,
	-1,
	'',
	'$loc','$to_locator_id',
   DECODE('$kib_group', 'ODM', '', '$v_trans_price'))";

   //   echo $sql;  
   //   exit();
                                                                                                  
   $query = $this->oracle->query($sql);
   }

//####################################################### qtyTrans_KK_v #################################################//
   function qtyTransKK($kib_code)
   {
   $sql ="SELECT qty_transaction FROM khs_kib_kanban WHERE kibcode = '$kib_code'";
   // echo $sql;  
   

   $query = $this->oracle->query($sql);
   return  $query->result_array();         
   }

//####################################################### update #################################################//

   function update($to_transfer,$user_id,$result,$kib_code,$org_number)
   {
   $sql ="UPDATE khs_kib_kanban 
   set QTY_TRANSACTION='$to_transfer',
   INVENTORY_TRANS_FLAG='Y',
   TRANSFER_BY='$user_id',
   QTY_ATR='$result '
   where KIBCODE='$kib_code'
   and ORGANIZATION_ID='$org_number'";
   // echo "<pre>";
   // echo $sql; 
   // exit();

   $query = $this->oracle->query($sql);    
  }

  function usrID($noind)
  {
     $oracle = $this->load->database('oracle',TRUE);
     $sql = "SELECT * FROM KHS_ALL_LOGIN_USER
     WHERE NOMOR_INDUK = '$noind'";
     // print_r($sql);exit();

     $query = $this->oracle->query($sql);
     return $query->result_array();
   //   return $query->row()->USER_ID;
  }

  function getNoind() {
   $sql = "SELECT NOMOR_INDUK FROM KHS_ALL_LOGIN_USER";
   // return $sql;

   $query = $this->oracle->query($sql);
   return $query->result_array();
}

  function Fnd($usr_id) {
      //   echo $usr_id;
      //   exit();
        $username = 'AA TECH TSR 01';
        $jan = 137;
      //   $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
        $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
          if (!$conn) {
               $e = oci_error();
              trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
          }
  
     //  $sql = "BEGIN Fnd_Global.apps_initialize(" + user + ",50630,20003); :x := apps.Fnd_Request.submit_request('INV','INCTCM','Interface Inventory Transactions'); END;";
         $sql = "BEGIN APPS.KHS_RUN_FND(:P_PARAM1);END;";
        //  echo $sql.'<br>';
        //  exit();
  
         //Statement does not change
         $stmt = oci_parse($conn,$sql);                     
         oci_bind_by_name($stmt,':P_PARAM1',$usr_id);
     
         $cursor = oci_new_cursor($conn);
         
         // Execute the statement as in your first try
         oci_execute($stmt);
         
         // and now, execute the cursor
         oci_execute($cursor);
     }

}
?>
