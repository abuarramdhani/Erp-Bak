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
                ,kpr.INPUT_DATE
                 from khs_po_receive kpr
                  where kpr.FLAG = 'D'
                and to_char(kpr.INPUT_DATE,'DD/MM/YY') between nvl('$datefrom',to_char(kpr.INPUT_DATE,'DD/MM/YY'))
                                                       and nvl('$dateto',to_char(kpr.INPUT_DATE,'DD/MM/YY'))  ";



    $query = $oracle->query($sql);
    return $query->result_array();
         // return $sql;
  }

    public function detailPO($po) {
    $oracle = $this->load->database('oracle_dev', true);
    $sql = " select distinct
                 kpr.PO_NUMBER
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
              and kpr.FLAG = 'D'
              and kpr.PO_NUMBER = '$po'
              order by 1 ";

    $query = $oracle->query($sql);
    return $query->result_array();
         // return $sql;
  }
    public function serial_number($po,$id) {
    $oracle = $this->load->database('oracle_dev', true);
    $sql = " select krs.PO_NUMBER
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
  and krs.INVENTORY_ITEM_ID = '$id'";

    $query = $oracle->query($sql);
    return $query->result_array();
         // return $sql;
  }





  

}