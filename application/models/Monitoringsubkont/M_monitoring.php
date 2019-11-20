<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monitoring extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();    
  }

  public function caridong($job,$tanggal,$subkontname, $komponen) {
    $oracle = $this->load->database('oracle', true);
    $sql = "
            SELECT distinct --msib.segment1 item, msib.description, 
               we.wip_entity_name no_job, 
               bd.department_class_code department_job, mtrh.request_number no_mo, 
               -- mtrl.quantity qty_mo_komp, (mmt.transaction_quantity*-1) qty_transact,
               to_char(mtrh.creation_date, 'dd/mm/yyyy hh24:mi:ss') tgl_dibuat_mo, to_char(mmt.transaction_date, 'dd/mm/yyyy hh24:mi:ss') tgl_transact_mo,
              -- mtrh.creation_date tgl_dibuat_mo, mmt.transaction_date tgl_transact_mo,
               msib2.segment1 assy, msib2.description assy_desc, wdj.START_QUANTITY qty_job, pv.vendor_name,
               mtrh.CREATION_DATE
          FROM mtl_system_items_b msib,
               wip_entities we,
               wip_requirement_operations wro,
               bom_departments bd,
               mtl_txn_request_headers mtrh,
               mtl_txn_request_lines mtrl,
               mtl_material_transactions mmt,
               mtl_system_items_b msib2,
               wip_discrete_jobs wdj,
               po_vendors pv,
               po_headers_all pha,
               po_lines_all pla,
               po_distributions_all pda
         WHERE wro.wip_entity_id = we.wip_entity_id
           AND wro.organization_id = we.organization_id
           AND wro.inventory_item_id = msib.inventory_item_id
           AND wro.organization_id = msib.organization_id
           --
           AND we.primary_item_id = msib2.inventory_item_id
           AND we.organization_id = msib2.organization_id
           AND we.wip_entity_id = wdj.wip_entity_id
           AND we.organization_id = wdj.organization_id
           --
           AND wro.department_id = bd.department_id
           AND bd.department_class_code = 'SUBKT'
           --
           AND mtrh.header_id = mtrl.header_id
           AND mtrl.inventory_item_id = msib.inventory_item_id
           AND mtrl.organization_id = msib.organization_id
           AND mtrh.attribute1 = we.wip_entity_id
           --
           and pla.PO_LINE_ID = pda.PO_LINE_ID
           and pda.wip_entity_id = we.wip_entity_id
           AND pha.vendor_id = pv.vendor_id
           and pha.po_header_id = pda.po_header_id
           --
           AND mmt.move_order_line_id = mtrl.line_id
           AND mmt.transfer_subinventory LIKE '%INT%'
           --
        --   and mtrh.request_number = 'PL191100021'
        $job $tanggal $subkontname $komponen
           order by 3, 1";

    $query = $oracle->query($sql);
    return $query->result_array();
               // return $sql;
}

public function detail($no_job)
{
  $oracle = $this->load->database('oracle',true);
  $sql  = " 
         SELECT DISTINCT rt.quantity qty_receipt,
                 to_char(rt.transaction_date, 'dd/mm/yyyy hh24:mi:ss') tgl_receipt, rsh.receipt_num no_receipt,
                pha.segment1 no_po, we.wip_entity_name no_job
           FROM po_headers_all pha,
                po_lines_all pla,
                po_distributions_all pda,
                wip_entities we,
                mtl_system_items_b msib,
                wip_discrete_jobs wdj,
                wip_requirement_operations wro,
                po_vendors pv,
                rcv_transactions rt,
                rcv_shipment_headers rsh,
                mfg_lookups mfg,
                mtl_material_transactions mmt,
                mtl_txn_request_headers mtrh,
                mtl_txn_request_lines mtrl
          WHERE pha.po_header_id = pda.po_header_id
            AND pla.po_line_id = pda.po_line_id
            AND pda.wip_entity_id = we.wip_entity_id
            AND we.wip_entity_id = wdj.wip_entity_id
            AND we.organization_id = wdj.organization_id
            AND wro.wip_entity_id = wdj.wip_entity_id
            AND wro.organization_id = wdj.organization_id
            AND wro.inventory_item_id = msib.inventory_item_id
            AND wro.organization_id = msib.organization_id
            --
            AND pha.vendor_id = pv.vendor_id
            --
            AND mtrh.header_id = mtrl.header_id
            AND mtrl.inventory_item_id = msib.inventory_item_id
            AND mtrh.attribute1 = we.wip_entity_id
            AND mmt.move_order_line_id = mtrl.line_id
            AND mmt.transfer_subinventory LIKE '%INT%'
            --
            AND rsh.shipment_header_id = rt.shipment_header_id
            AND rt.transaction_type = 'RECEIVE'
            AND pla.po_header_id = pha.po_header_id
            AND pla.po_header_id = rt.po_header_id
            AND pla.po_line_id = rt.po_line_id
            --
            AND mfg.lookup_code = wdj.status_type
            AND mfg.lookup_type = 'WIP_JOB_STATUS'
            --
            AND rsh.receipt_num NOT IN (
                   SELECT rsh1.receipt_num
                     FROM rcv_transactions rt1,
                          rcv_shipment_headers rsh1,
                          rcv_shipment_lines rsl1
                    WHERE rsl1.shipment_header_id = rsh1.shipment_header_id
                      AND rsh1.shipment_header_id = rt1.shipment_header_id
                      AND rsl1.shipment_line_id = rt1.shipment_line_id
                      --
                      AND (rt1.transaction_type = 'CORRECT' OR rt1.transaction_type LIKE 'RETURN%')
                      AND rsh1.receipt_num = rsh.receipt_num)
            AND we.wip_entity_name = '$no_job'               
           ORDER BY  rsh.receipt_num";
    $query = $oracle->query($sql);
    return $query->result_array();
}

public function deliv($no_po,$no_receipt){
  $oracle = $this->load->database('oracle',true);
  $sql  = " SELECT distinct rsh.receipt_num no_receipt, pha.segment1 no_po, rt.quantity qty_deliver
            FROM rcv_shipment_headers rsh,
            rcv_transactions rt,
            po_headers_all pha,
            po_lines_all pla
            WHERE rsh.shipment_header_id = rt.shipment_header_id
            AND rt.transaction_type = 'DELIVER'
            AND pla.po_header_id = pha.po_header_id
            AND pla.po_header_id = rt.po_header_id
            AND pla.po_line_id = rt.po_line_id
             --
             AND rsh.receipt_num = '$no_receipt'
             AND pha.segment1 = '$no_po' ";
   $query = $oracle->query($sql);
   return $query->result_array();

 }

 public function detailplus ($no_receipt,$no_job){

  $oracle = $this->load->database('oracle',true);
  $sql  = " 
            SELECT DISTINCT msib.segment1 item, msib.description, rt.quantity qty_receipt,
                rt.transaction_date tgl_receipt, rsh.receipt_num no_receipt,
                pha.segment1 no_po, we.wip_entity_name no_job,
                wro.quantity_per_assembly, --wro.quantity_issued,
                pv.vendor_name, mfg.meaning status_job,
                (wro.quantity_per_assembly * rt.quantity) qty_recipt_kom,
                (mmt.transaction_quantity * -1) qty_transact_komp,
                mmt.creation_date, mtrl.quantity qty_komponen
           FROM po_headers_all pha,
                po_lines_all pla,
                po_distributions_all pda,
                wip_entities we,
                mtl_system_items_b msib,
                wip_discrete_jobs wdj,
                wip_requirement_operations wro,
                po_vendors pv,
                rcv_transactions rt,
                rcv_shipment_headers rsh,
                mfg_lookups mfg,
                mtl_material_transactions mmt,
                mtl_txn_request_headers mtrh,
                mtl_txn_request_lines mtrl
          WHERE pha.po_header_id = pda.po_header_id
            AND pla.po_line_id = pda.po_line_id
            AND pda.wip_entity_id = we.wip_entity_id
            AND we.wip_entity_id = wdj.wip_entity_id
            AND we.organization_id = wdj.organization_id
            AND wro.wip_entity_id = wdj.wip_entity_id
            AND wro.organization_id = wdj.organization_id
            AND wro.inventory_item_id = msib.inventory_item_id
            AND wro.organization_id = msib.organization_id
            --
            AND pha.vendor_id = pv.vendor_id
            --
            AND mtrh.header_id = mtrl.header_id
            AND mtrl.inventory_item_id = msib.inventory_item_id
            AND mtrh.attribute1 = we.wip_entity_id
            AND mmt.move_order_line_id = mtrl.line_id
            AND mmt.transfer_subinventory LIKE '%INT%'
            --
            AND rsh.shipment_header_id = rt.shipment_header_id
            AND rt.transaction_type = 'RECEIVE'
            AND pla.po_header_id = pha.po_header_id
            AND pla.po_header_id = rt.po_header_id
            AND pla.po_line_id = rt.po_line_id
            --
            AND mfg.lookup_code = wdj.status_type
            AND mfg.lookup_type = 'WIP_JOB_STATUS'
            --
            AND rsh.receipt_num NOT IN (
                   SELECT rsh1.receipt_num
                     FROM rcv_transactions rt1,
                          rcv_shipment_headers rsh1,
                          rcv_shipment_lines rsl1
                    WHERE rsl1.shipment_header_id = rsh1.shipment_header_id
                      AND rsh1.shipment_header_id = rt1.shipment_header_id
                      AND rsl1.shipment_line_id = rt1.shipment_line_id
                      --
                      AND (rt1.transaction_type = 'CORRECT' OR rt1.transaction_type LIKE 'RETURN%')
                      AND rsh1.receipt_num = rsh.receipt_num)
           AND rsh.receipt_num = '$no_receipt'
           AND we.wip_entity_name = '$no_job'                  
           ORDER BY 5, 1";
            $query = $oracle->query($sql);
            return $query->result_array();
}


     public function subkontt($subkont)
     {

      $oracle = $this->load->database('oracle',true);
      $sql  = " SELECT pv.vendor_name FROM po_vendors pv WHERE pv.VENDOR_NAME LIKE '%$subkont%' ";
      $query = $oracle->query($sql);
      return $query->result_array();
       // return $sql;
    }
     public function assy($assyassy)
     {

      $oracle = $this->load->database('oracle',true);
      $sql  = " SELECT distinct msib2.segment1 assy FROM mtl_system_items_b msib2 WHERE msib2.segment1 LIKE '%$assyassy%' ";
      $query = $oracle->query($sql);
      return $query->result_array();
       // return $sql;
    }

 //------------//

}
