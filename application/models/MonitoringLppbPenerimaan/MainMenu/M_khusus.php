<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_khusus extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getSearch($atr=NULL,$atr2=NULL,$atr3=NULL) {
        $oracle = $this->load->database('oracle', true);
        $sql = "select distinct
        rsh.RECEIPT_NUM
       ,(select mp.ORGANIZATION_CODE
           from mtl_parameters mp
          where mp.ORGANIZATION_ID = rsh.SHIP_TO_ORG_ID)                         io
       ,decode(
               rrh.ROUTING_NAME,'Inspection Required',mp.ORGANIZATION_CODE
               ||rsh.RECEIPT_NUM
               ||'Q',mp.ORGANIZATION_CODE
               ||rsh.RECEIPT_NUM
               )                                                                 nolppb
       ,pha.SEGMENT1                                                             po
       ,decode(
               rt.SOURCE_DOCUMENT_CODE,'PO',pha.SEGMENT1
                                      ,'RMA',ooha.ORDER_NUMBER
                                      ,prha.SEGMENT1
                  )                                                              order_num
 --      ,rsh.SHIPMENT_NUM
       ,msib.SEGMENT1                                                            item
       ,msib.DESCRIPTION
       ,nvl(tt.transfer_qty,0)                                                   transfer_qty
       ,tt.transfer_date
       ,nvl(dd.deliver_qty,0)                                                    deliver_qty
       ,dd.deliver_date
       ,nvl(aa.accept_qty,0)                                                     accept_qty
       ,aa.accept_date
       ,nvl(rej.reject_qty,0)                                                    reject_qty
       ,rej.reject_date
       ,nvl(rec.receive_qty,0)                                                   receive_qty
       ,rec.receive_date
       ,rsh.CREATION_DATE                                                        receipt_date
       ,wkt.MINTIME                                                              transaction_date
       ,rsl.SHIPMENT_LINE_ID
       ,rt.TRANSACTION_ID
 from rcv_shipment_headers rsh
     ,rcv_shipment_lines rsl
     ,rcv_transactions rt   
     ,rcv_routing_headers rrh
     --
     ,po_headers_all pha
     ,po_lines_all pla
     ,po_line_locations_all plla
     ,po_vendors pov
     ,po_requisition_headers_all prha    
     ,po_requisition_lines_all prla
     ,po_vendor_sites_all povs
     ,oe_order_headers_all ooha
     ,hr_all_organization_units_tl haou
     ,hr_locations hrl
     --
     ,mtl_system_items_b msib
     ,mtl_parameters mp 
     --
     ,(select min(rt1.TRANSACTION_DATE) mintime
             ,rt1.SHIPMENT_HEADER_ID 
         from rcv_transactions rt1
 --         where rt1.SHIPMENT_HEADER_ID = rsh.SHIPMENT_HEADER_ID
     group by rt1.SHIPMENT_HEADER_ID) wkt
 ,(select rsh.RECEIPT_NUM receipt
         ,rt.CREATION_DATE transfer_date
         ,rt.TRANSACTION_ID line_id
         ,rt.UOM_CODE uom_transfer
         ,rt.QUANTITY + 
           decode(
                  (
                   select distinct rtt.QUANTITY    
                     from rcv_shipment_headers rsht
                         ,rcv_transactions rtt
                    where rsht.RECEIPT_NUM is not null
                      and rsht.SHIPMENT_HEADER_ID = rtt.SHIPMENT_HEADER_ID
                      and rtt.TRANSACTION_TYPE = 'CORRECT'
                      and rtt.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
                      and rsht.RECEIPT_NUM = rsh.RECEIPT_NUM
                      and rsht.SHIP_TO_ORG_ID = rsh.SHIP_TO_ORG_ID 
                   ),null,0,
                           (
                            select distinct rtt2.QUANTITY    
                              from rcv_shipment_headers rsht2
                                  ,rcv_transactions rtt2
                             where rsht2.RECEIPT_NUM is not null
                               and rsht2.SHIPMENT_HEADER_ID = rtt2.SHIPMENT_HEADER_ID
                               and rtt2.TRANSACTION_TYPE = 'CORRECT'
                               and rtt2.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
                               and rsht2.RECEIPT_NUM = rsh.RECEIPT_NUM
                               and rsht2.SHIP_TO_ORG_ID = rsh.SHIP_TO_ORG_ID
                             ))                                                  transfer_qty
 from rcv_transactions rt
     ,rcv_shipment_headers rsh
     ,rcv_shipment_lines rsl
 where rsh.SHIPMENT_HEADER_ID = rsl.SHIPMENT_HEADER_ID
   and rsh.SHIPMENT_HEADER_ID = rt.SHIPMENT_HEADER_ID
   and rsl.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
   --
 --  and rsh.RECEIPT_NUM = '260056'
   and rt.TRANSACTION_TYPE = 'TRANSFER') tt
 ,(select rsh.RECEIPT_NUM receipt
         ,rt.CREATION_DATE deliver_date
         ,rt.TRANSACTION_ID line_id
         ,rt.UOM_CODE uom_deliver
         ,rt.QUANTITY + 
           decode(
                  (
                   select distinct rtt.QUANTITY    
                     from rcv_shipment_headers rsht
                         ,rcv_transactions rtt
                    where rsht.RECEIPT_NUM is not null
                      and rsht.SHIPMENT_HEADER_ID = rtt.SHIPMENT_HEADER_ID
                      and rtt.TRANSACTION_TYPE = 'CORRECT'
                      and rtt.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
                      and rsht.RECEIPT_NUM = rsh.RECEIPT_NUM
                      and rsht.SHIP_TO_ORG_ID = rsh.SHIP_TO_ORG_ID 
                   ),null,0,
                           (
                            select distinct rtt2.QUANTITY    
                              from rcv_shipment_headers rsht2
                                  ,rcv_transactions rtt2
                             where rsht2.RECEIPT_NUM is not null
                               and rsht2.SHIPMENT_HEADER_ID = rtt2.SHIPMENT_HEADER_ID
                               and rtt2.TRANSACTION_TYPE = 'CORRECT'
                               and rtt2.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
                               and rsht2.RECEIPT_NUM = rsh.RECEIPT_NUM
                               and rsht2.SHIP_TO_ORG_ID = rsh.SHIP_TO_ORG_ID
                             ))                                                  deliver_qty
 from rcv_transactions rt
     ,rcv_shipment_headers rsh
     ,rcv_shipment_lines rsl
 where rsh.SHIPMENT_HEADER_ID = rsl.SHIPMENT_HEADER_ID
   and rsh.SHIPMENT_HEADER_ID = rt.SHIPMENT_HEADER_ID
   and rsl.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
   --
 --  and rsh.RECEIPT_NUM = '260056'
   and rt.TRANSACTION_TYPE = 'DELIVER') dd
 ,(select rsh.RECEIPT_NUM receipt
         ,rt.CREATION_DATE accept_date
         ,rt.TRANSACTION_ID line_id
         ,rt.UOM_CODE uom_accept
         ,rt.QUANTITY + 
           decode(
                  (
                   select distinct rtt.QUANTITY    
                     from rcv_shipment_headers rsht
                         ,rcv_transactions rtt
                    where rsht.RECEIPT_NUM is not null
                      and rsht.SHIPMENT_HEADER_ID = rtt.SHIPMENT_HEADER_ID
                      and rtt.TRANSACTION_TYPE = 'CORRECT'
                      and rtt.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
                      and rsht.RECEIPT_NUM = rsh.RECEIPT_NUM
                      and rsht.SHIP_TO_ORG_ID = rsh.SHIP_TO_ORG_ID 
                   ),null,0,
                           (
                            select distinct rtt2.QUANTITY    
                              from rcv_shipment_headers rsht2
                                  ,rcv_transactions rtt2
                             where rsht2.RECEIPT_NUM is not null
                               and rsht2.SHIPMENT_HEADER_ID = rtt2.SHIPMENT_HEADER_ID
                               and rtt2.TRANSACTION_TYPE = 'CORRECT'
                               and rtt2.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
                               and rsht2.RECEIPT_NUM = rsh.RECEIPT_NUM
                               and rsht2.SHIP_TO_ORG_ID = rsh.SHIP_TO_ORG_ID
                             ))                                                    accept_qty
 from rcv_transactions rt
     ,rcv_shipment_headers rsh
     ,rcv_shipment_lines rsl
 where rsh.SHIPMENT_HEADER_ID = rsl.SHIPMENT_HEADER_ID
   and rsh.SHIPMENT_HEADER_ID = rt.SHIPMENT_HEADER_ID
   and rsl.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
   --
 --  and rsh.RECEIPT_NUM = '260056'
   and rt.TRANSACTION_TYPE = 'ACCEPT') aa
 ,(select rsh.RECEIPT_NUM receipt
         ,rt.CREATION_DATE reject_date
         ,rt.TRANSACTION_ID line_id
         ,rt.UOM_CODE uom_reject
         ,rt.QUANTITY + 
           decode(
                  (
                   select distinct rtt.QUANTITY    
                     from rcv_shipment_headers rsht
                         ,rcv_transactions rtt
                    where rsht.RECEIPT_NUM is not null
                      and rsht.SHIPMENT_HEADER_ID = rtt.SHIPMENT_HEADER_ID
                      and rtt.TRANSACTION_TYPE = 'CORRECT'
                      and rtt.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
                      and rsht.RECEIPT_NUM = rsh.RECEIPT_NUM
                      and rsht.SHIP_TO_ORG_ID = rsh.SHIP_TO_ORG_ID 
                   ),null,0,
                           (
                            select distinct rtt2.QUANTITY    
                              from rcv_shipment_headers rsht2
                                  ,rcv_transactions rtt2
                             where rsht2.RECEIPT_NUM is not null
                               and rsht2.SHIPMENT_HEADER_ID = rtt2.SHIPMENT_HEADER_ID
                               and rtt2.TRANSACTION_TYPE = 'CORRECT'
                               and rtt2.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
                               and rsht2.RECEIPT_NUM = rsh.RECEIPT_NUM
                               and rsht2.SHIP_TO_ORG_ID = rsh.SHIP_TO_ORG_ID
                             ))                                                    reject_qty
 from rcv_transactions rt
     ,rcv_shipment_headers rsh
     ,rcv_shipment_lines rsl
 where rsh.SHIPMENT_HEADER_ID = rsl.SHIPMENT_HEADER_ID
   and rsh.SHIPMENT_HEADER_ID = rt.SHIPMENT_HEADER_ID
   and rsl.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
   --
 --  and rsh.RECEIPT_NUM = '260056'
   and rt.TRANSACTION_TYPE = 'REJECT') rej
 ,(select rsh.RECEIPT_NUM receipt
         ,rt.CREATION_DATE receive_date
         ,rt.TRANSACTION_ID line_id
         ,rt.UOM_CODE uom_receive
         ,rt.QUANTITY + 
           decode(
                  (
                   select distinct rtt.QUANTITY    
                     from rcv_shipment_headers rsht
                         ,rcv_transactions rtt
                    where rsht.RECEIPT_NUM is not null
                      and rsht.SHIPMENT_HEADER_ID = rtt.SHIPMENT_HEADER_ID
                      and rtt.TRANSACTION_TYPE = 'CORRECT'
                      and rtt.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
                      and rsht.RECEIPT_NUM = rsh.RECEIPT_NUM
                      and rsht.SHIP_TO_ORG_ID = rsh.SHIP_TO_ORG_ID 
                   ),null,0,
                           (
                            select distinct rtt2.QUANTITY    
                              from rcv_shipment_headers rsht2
                                  ,rcv_transactions rtt2
                             where rsht2.RECEIPT_NUM is not null
                               and rsht2.SHIPMENT_HEADER_ID = rtt2.SHIPMENT_HEADER_ID
                               and rtt2.TRANSACTION_TYPE = 'CORRECT'
                               and rtt2.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
                               and rsht2.RECEIPT_NUM = rsh.RECEIPT_NUM
                               and rsht2.SHIP_TO_ORG_ID = rsh.SHIP_TO_ORG_ID
                             ))                                                    receive_qty
 from rcv_transactions rt
     ,rcv_shipment_headers rsh
     ,rcv_shipment_lines rsl
 where rsh.SHIPMENT_HEADER_ID = rsl.SHIPMENT_HEADER_ID
   and rsh.SHIPMENT_HEADER_ID = rt.SHIPMENT_HEADER_ID
   and rsl.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
   --
 --  and rsh.RECEIPT_NUM = '260056'
   and rt.TRANSACTION_TYPE = 'RECEIVE') rec
 where rsh.RECEIPT_NUM is not null
   and rsh.VENDOR_ID = pov.VENDOR_ID(+)
   and rsh.ORGANIZATION_ID = haou.ORGANIZATION_ID(+)
   and rsh.VENDOR_SITE_ID = povs.VENDOR_SITE_ID(+)
   and rsh.SHIPMENT_HEADER_ID = rt.SHIPMENT_HEADER_ID    
   and rsl.SHIPMENT_LINE_ID = rt.SHIPMENT_LINE_ID
   and rrh.ROUTING_HEADER_ID(+) = rt.ROUTING_HEADER_ID
   and pha.PO_HEADER_ID(+) = rt.PO_HEADER_ID
   and prla.REQUISITION_LINE_ID(+) = rt.REQUISITION_LINE_ID
   and prha.REQUISITION_HEADER_ID(+) = prla.REQUISITION_HEADER_ID 
   --         
   and rt.LOCATION_ID = hrl.LOCATION_ID(+)
   and rt.OE_ORDER_HEADER_ID = ooha.HEADER_ID(+)
   and plla.CLOSED_CODE = 'OPEN'
   and USERENV('LANG') = haou.LANGUAGE(+)
   and nvl(prha.ORG_ID, -99) = nvl(prla.ORG_ID, -99)
   and rt.TRANSACTION_TYPE in ('TRANSFER','ACCEPT','REJECT','RECEIVE')
   --
   and msib.ORGANIZATION_ID = rsh.SHIP_TO_ORG_ID
   and msib.INVENTORY_ITEM_ID = rsl.ITEM_ID
   and mp.ORGANIZATION_ID = rsh.SHIP_TO_ORG_ID
   --Transaksi Reject Terakhir
 --  and rt.INTERFACE_TRANSACTION_ID = (SELECT MAX(RT1.INTERFACE_TRANSACTION_ID)
 --                   FROM RCV_TRANSACTIONS RT1
 --                     WHERE
 --                         RT1.SHIPMENT_HEADER_ID = RT.SHIPMENT_HEADER_ID
 --                     AND RT1.SHIPMENT_LINE_ID = RT.SHIPMENT_LINE_ID
 --                     AND RT1.DESTINATION_CONTEXT = 'RECEIVING' 
 --                     AND RT1.TRANSACTION_TYPE = 'REJECT')                     
     --Transaksi Terakhir
    /* AND RT.INTERFACE_TRANSACTION_ID = (SELECT MAX(RT1.INTERFACE_TRANSACTION_ID)
                      FROM RCV_TRANSACTIONS RT1
                      WHERE
                          RT1.SHIPMENT_HEADER_ID = RT.SHIPMENT_HEADER_ID
                      AND RT1.SHIPMENT_LINE_ID = RT.SHIPMENT_LINE_ID
                      AND RT1.DESTINATION_CONTEXT = 'RECEIVING'
                      ) */
   and pla.PO_HEADER_ID = pha.PO_HEADER_ID
   and rsl.PO_LINE_ID = pla.PO_LINE_ID
   and plla.PO_LINE_ID = pla.PO_LINE_ID 
   -- qty
   and tt.line_id(+) = rt.TRANSACTION_ID --rsl.SHIPMENT_LINE_ID
   and dd.line_id(+) = rt.TRANSACTION_ID --rsl.SHIPMENT_LINE_ID
   and aa.line_id(+) = rt.TRANSACTION_ID --rsl.SHIPMENT_LINE_ID
   and rej.line_id(+) = rt.TRANSACTION_ID --rsl.SHIPMENT_LINE_ID
   and rec.line_id(+) = rt.TRANSACTION_ID --rsl.SHIPMENT_LINE_ID 
   -- parameter
   and wkt.SHIPMENT_HEADER_ID = rsh.SHIPMENT_HEADER_ID
   $atr
   $atr2
   $atr3
 order by msib.SEGMENT1";

        $query = $oracle->query($sql);
        return $query->result_array();
        //  return $sql;
    }

    public function showIo()
    {$oracle = $this->load->database('oracle',true);
      $sql  = "SELECT ood.ORGANIZATION_ID, ood.ORGANIZATION_NAME
              , ood.ORGANIZATION_CODE 
              from org_organization_definitions ood";
      $query = $oracle->query($sql);
      return $query->result_array();
    }
    
    }
