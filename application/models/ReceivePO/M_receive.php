<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_receive extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();    
  }

  public function historyPO($datefrom,$dateto) {
    $oracle = $this->load->database('oracle_dev', true);
    $sql = " select distinct
               kpr.PO_NUMBER
              ,kpr.SHIPMENT_NUMBER
              ,kpr.LPPB_NUMBER
              ,kpr.INPUT_DATE
              from khs_po_receive kpr
              where (kpr.FLAG = 'D' OR kpr.FLAG = 'O')
            and kpr.input_date between to_date('$datefrom') and to_date('$dateto')
            ORDER BY INPUT_DATE ASC ";



    $query = $oracle->query($sql);
    return $query->result_array();
         // return $sql;
  }

    public function detailPO($po,$sj) {
    $oracle = $this->load->database('oracle_dev', true);
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
    $oracle = $this->load->database('oracle_dev', true);
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
  and krs.INVENTORY_ITEM_ID ='$id'";

    $query = $oracle->query($sql);
    return $query->result_array();
         // return $sql;
  }





  

}