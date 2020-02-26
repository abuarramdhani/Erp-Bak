<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_receive extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();    
  }

  public function historyPO($datefrom,$dateto) {
    $oracle = $this->load->database('oracle', true);
    $sql = " select distinct
               kpr.PO_NUMBER
              ,kpr.SHIPMENT_NUMBER
              ,kpr.LPPB_NUMBER
             -- ,kpr.INPUT_DATE
        from khs_po_receive kpr
        where (kpr.FLAG = 'D' OR kpr.FLAG = 'O')
         and  kpr.input_date between TO_DATE('$datefrom"." 00:00:00', 'DD/MM/YYYY HH24:MI:SS') and TO_DATE('$dateto"." 23:59:59', 'DD/MM/YYYY HH24:MI:SS')
      ORDER BY PO_NUMBER ASC";



    $query = $oracle->query($sql);
    return $query->result_array();
         // return $sql;
  }

    public function detailPO($po,$sj) {
    $oracle = $this->load->database('oracle', true);
    $sql = " select distinct  kpr.PO_NUMBER
                ,kpr.SHIPMENT_NUMBER
                ,kpr.QUANTITY_RECEIPT qty_recipt
                ,kpr.LPPB_NUMBER
                , kpr.INVENTORY_ITEM_ID id
                ,msib.SEGMENT1 item
                ,msib.DESCRIPTION
                ,kpr.SERIAL_STATUS
                from khs_po_receive kpr                  
              ,mtl_system_items_b msib
               where kpr.ORGANIZATION_ID = msib.ORGANIZATION_ID
             and kpr.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
--              and kpr.FLAG = 'D'
             and kpr.SHIPMENT_NUMBER = '$sj'
             and kpr.PO_NUMBER = '$po' ";

    $query = $oracle->query($sql);
    return $query->result_array();
         // return $sql;
  }
    public function serial_number($po,$id,$sj) {
    $oracle = $this->load->database('oracle', true);
    $sql = " select distinct krs.PO_NUMBER
      ,krs.INVENTORY_ITEM_ID
      ,krs.SERIAL_NUMBER
from khs_receipt_serial krs
    ,khs_po_receive kpr
where krs.ORGANIZATION_ID = kpr.ORGANIZATION_ID
  and krs.INVENTORY_ITEM_ID = kpr.INVENTORY_ITEM_ID
  and krs.PO_NUMBER = kpr.PO_NUMBER
  and krs.PO_HEADER_ID = kpr.PO_HEADER_ID
  and krs.PO_LINE_ID = kpr.PO_LINE_ID
  and krs.PO_NUMBER = '$po'
  and krs.SHIPMENT_NUMBER ='$sj'
  and krs.INVENTORY_ITEM_ID ='$id'
  ORDER BY SERIAL_NUMBER";

    $query = $oracle->query($sql);
    return $query->result_array();
         // return $sql;
  }
   public function lppb_number($po,$sj) {
    $oracle = $this->load->database('oracle', true);
    $sql = "select DISTINCT rsh.RECEIPT_NUM
    from rcv_shipment_lines rsl
        ,rcv_shipment_headers rsh
        ,po_headers_all pha
    where pha.SEGMENT1 = '$po'
      and rsh.SHIPMENT_NUM = nvl('$sj',rsh.SHIPMENT_NUM)
      and rsl.PO_HEADER_ID = pha.PO_HEADER_ID
      and rsl.SHIPMENT_HEADER_ID = rsh.SHIPMENT_HEADER_ID
      and rsh.CREATION_DATE IN (select rsh.CREATION_DATE
                                 from rcv_shipment_headers rsh
                                     ,rcv_shipment_lines rsl
                                where rsh.SHIPMENT_HEADER_ID = rsl.SHIPMENT_HEADER_ID
                                  and rsl.PO_HEADER_ID = pha.PO_HEADER_ID)";

    $query = $oracle->query($sql);
    return $query->result_array();
         // return $sql;
  }
  public function getPO($nolppb) {
    $oracle = $this->load->database('oracle', true);
    $sql = "select DISTINCT 
                pha.SEGMENT1            PO
                ,rsh.SHIPMENT_NUM     SP
                from rcv_shipment_lines rsl
                        ,rcv_shipment_headers rsh
                        ,po_headers_all pha
                    where rsh.RECEIPT_NUM = '$nolppb'
                      and rsl.PO_HEADER_ID = pha.PO_HEADER_ID
                      and rsl.SHIPMENT_HEADER_ID = rsh.SHIPMENT_HEADER_ID
                      and rsh.CREATION_DATE IN (select rsh.CREATION_DATE
                                                 from rcv_shipment_headers rsh
                                                     ,rcv_shipment_lines rsl
                                                where rsh.SHIPMENT_HEADER_ID = rsl.SHIPMENT_HEADER_ID
                                                  and rsl.PO_HEADER_ID = pha.PO_HEADER_ID)";

    $query = $oracle->query($sql);
    return $query->result_array();
         // return $sql;
  }
    public function getLocator($kodeitem) {
    $oracle = $this->load->database('oracle', true);
    $sql = " SELECT distinct mil.segment1 LOCATOR
                      FROM mtl_item_locations mil, mtl_system_items_b msib, khs_po_receive kpr
                     WHERE mil.organization_id = msib.organization_id
                       AND mil.inventory_item_id = msib.inventory_item_id
                       AND kpr.ORGANIZATION_ID = mil.ORGANIZATION_ID
                       AND msib.segment1 = '$kodeitem'";

    $query = $oracle->query($sql);
    return $query->result_array();
         // return $sql;
  }
 

  public function insertserial($lppbnumber,$iddelive,$qtydelive,$podelive,$commentsdelive,$serialnumdelive,$pilihloc) {
    $oracle = $this->load->database('oracle', true);
    $sql = "insert into KHS_DELIVERY_PO_TEMP_SERIAL(NO_RECEIPT,INVENTORY_ITEM_ID,QUANTITY,PO_NUMBER,STATUS, LOCATOR,COMMENTS,SERIAL)
                values ('$lppbnumber', $iddelive, '$qtydelive', '$podelive', 'DELIVER', '$pilihloc', '$commentsdelive', '$serialnumdelive')";

    $query = $oracle->query($sql);
  }

  public function insertnonserial($lppbnumber,$iddelive,$qtydelive,$podelive,$commentsdelive,$pilihloc) {
    $oracle = $this->load->database('oracle', true);
    $sql = "insert into khs_delivery_po_temp3(NO_RECEIPT,INVENTORY_ITEM_ID,QUANTITY,PO_NUMBER,STATUS, LOCATOR,COMMENTS)
                values ('$lppbnumber', $iddelive, '$qtydelive', '$podelive', 'DELIVER', '$pilihloc', '$commentsdelive')";

    $query = $oracle->query($sql);
  }

  public function runAPI($lppb,$po)
  {
      // $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
      $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');

        if (!$conn) {
             $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
  
      $sql = "BEGIN APPS.khs_trial_deliver2 (:P_PARAM1,:P_PARAM2); END;";

      //Statement does not change
      $stmt = oci_parse($conn,$sql);                     
      oci_bind_by_name($stmt,':P_PARAM1',$lppb);
      oci_bind_by_name($stmt,':P_PARAM2',$po);

      // But BEFORE statement, Create your cursor
      $cursor = oci_new_cursor($conn);
      
      // Execute the statement as in your first try
      oci_execute($stmt);
      
      // and now, execute the cursor
      oci_execute($cursor);

    // $query = $oracle->query($sql);
    // echo "<pre>";print_r($sql);exit();
  }
  public function deletefromtemporaryserial()
  {
   $oracle = $this->load->database('oracle', true);
    $sql = "DELETE FROM KHS_DELIVERY_PO_TEMP_SERIAL";

    $query = $oracle->query($sql);
  }
    public function deletefromtemporary()
  {
   $oracle = $this->load->database('oracle', true);
    $sql = "DELETE FROM khs_delivery_po_temp3";

    $query = $oracle->query($sql);
  }

}