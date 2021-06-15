<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monpentrx extends CI_Model{
    public function __construct(){
      parent::__construct();
      $this->load->database();    
      $this->oracle = $this->load->database('oracle', true);
    }

    public function getSubinv($term,$user){
      $sql = "SELECT kba.*
                FROM khs_bon_account kba
               WHERE kba.subinv LIKE '%$term%' AND kba.induk = '$user'
            ORDER BY kba.subinv, kba.induk";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function getLocator($term,$subinv){
      $sql = "SELECT mil.inventory_location_id, mil.segment1, mil.description
                FROM mtl_item_locations mil
               WHERE mil.subinventory_code = '$subinv' AND mil.disable_date IS NULL
                 AND mil.segment1 LIKE '%$term%'
            ORDER BY mil.segment1";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function checkLocator($subinv){
      $sql = "SELECT mil.inventory_location_id, mil.segment1, mil.description
                FROM mtl_item_locations mil
               WHERE mil.subinventory_code = '$subinv' AND mil.disable_date IS NULL
            ORDER BY mil.segment1";
      $query = $this->oracle->query($sql)->num_rows();

      print_r($query);
    }

    public function getDataMonitoring($subinv,$loc){
      if ($loc == '') {
        $code1 = "";
        $code2 = "";
        $code3 = "";
        $code4 = "";
        $code5 = "";
        $code6 = "";
      }
      else {
        $code1 = "AND mtrl.from_locator_id = $loc";
        $code2 = "AND mtrl.to_locator_id = $loc";
        $code3 = "AND kkk.from_locator_id = $loc";
        $code4 = "AND kkk.to_locator_id = $loc";
        $code5 = "AND rsl.locator_id = $loc";
        $code6 = "AND mmt.locator_id = $loc";
      }

      $sql = "SELECT DISTINCT mtrh.request_number, mtrl.from_subinventory_code,
                     NVL (mil.segment1,'-') from_locator, mp.organization_code to_organization, mtrl.to_subinventory_code,
                     NVL (mil2.segment1,'-') to_locator, 'MOVE ORDER' jenis, mtrh.creation_date,
                     TO_CHAR (mtrh.creation_date, 'DD-MON-YYYY HH24:MI:SS') creation_date2
                FROM mtl_txn_request_headers mtrh,
                     mtl_txn_request_lines mtrl,
                     mtl_item_locations mil,
                     mtl_item_locations mil2,
                     mtl_system_items_b msib,
                     mtl_parameters mp
               WHERE mtrh.header_id = mtrl.header_id
                 AND mtrl.from_locator_id = mil.inventory_location_id(+)
                 AND mtrl.to_locator_id = mil2.inventory_location_id(+)
                 AND mtrl.inventory_item_id = msib.inventory_item_id
                 AND mtrl.organization_id = msib.organization_id
                 AND mtrl.organization_id = mp.organization_id
                 AND mtrl.from_subinventory_code = '$subinv'
                 AND mtrl.line_status NOT IN (1, 5, 6)
                 $code1
            UNION
            SELECT DISTINCT mtrh.request_number, mtrl.from_subinventory_code,
                     NVL (mil.segment1,'-') from_locator, mp.organization_code to_organization, mtrl.to_subinventory_code,
                     NVL (mil2.segment1,'-') to_locator, 'MOVE ORDER' jenis, mtrh.creation_date,
                     TO_CHAR (mtrh.creation_date, 'DD-MON-YYYY HH24:MI:SS') creation_date2
                FROM mtl_txn_request_headers mtrh,
                     mtl_txn_request_lines mtrl,
                     mtl_item_locations mil,
                     mtl_item_locations mil2,
                     mtl_system_items_b msib,
                     mtl_parameters mp
               WHERE mtrh.header_id = mtrl.header_id
                 AND mtrl.from_locator_id = mil.inventory_location_id(+)
                 AND mtrl.to_locator_id = mil2.inventory_location_id(+)
                 AND mtrl.inventory_item_id = msib.inventory_item_id
                 AND mtrl.organization_id = msib.organization_id
                 AND mtrl.organization_id = mp.organization_id
                 AND mtrl.to_subinventory_code = '$subinv'
                 AND mtrl.line_status NOT IN (1, 5, 6)
                 $code2
            UNION
            SELECT DISTINCT kkk.kibcode, kkk.from_subinventory_code, NVL (mil.segment1,'-') from_locator,
                     mp.organization_code to_organization, kkk.to_subinventory_code, NVL (mil2.segment1,'-') to_locator,
                     'KIB' jenis, kkk.creation_date,
                     TO_CHAR (kkk.creation_date, 'DD-MON-YYYY HH24:MI:SS') creation_date2
                FROM khs_kib_kanban kkk,
                     mtl_item_locations mil,
                     mtl_item_locations mil2,
                     mtl_system_items_b msib,
                     mtl_parameters mp
               WHERE kkk.from_locator_id = mil.inventory_location_id(+)
                 AND kkk.to_locator_id = mil2.inventory_location_id(+)
                 AND kkk.primary_item_id = msib.inventory_item_id
                 AND msib.organization_id = 81
                 AND kkk.organization_id = mp.organization_id
                 AND kkk.inventory_trans_flag <> 'Y'
                 AND kkk.kibcode NOT LIKE 'SET%'
                 AND kkk.from_subinventory_code = '$subinv'
                 $code3
            UNION
            SELECT DISTINCT kkk.kibcode, kkk.from_subinventory_code, NVL (mil.segment1,'-') from_locator,
                     mp.organization_code to_organization, kkk.to_subinventory_code, NVL (mil2.segment1,'-') to_locator,
                     'KIB' jenis, kkk.creation_date,
                     TO_CHAR (kkk.creation_date, 'DD-MON-YYYY HH24:MI:SS') creation_date2
                FROM khs_kib_kanban kkk,
                     mtl_item_locations mil,
                     mtl_item_locations mil2,
                     mtl_system_items_b msib,
                     mtl_parameters mp
               WHERE kkk.from_locator_id = mil.inventory_location_id(+)
                 AND kkk.to_locator_id = mil2.inventory_location_id(+)
                 AND kkk.primary_item_id = msib.inventory_item_id
                 AND msib.organization_id = 81
                 AND kkk.to_org_id = mp.organization_id
                 AND kkk.inventory_trans_flag <> 'Y'
                 AND kkk.kibcode NOT LIKE 'SET%'
                 AND kkk.to_subinventory_code = '$subinv'
                 $code4
            UNION
            SELECT DISTINCT rsh.shipment_num, mmt.subinventory_code from_subinventory_code,
                     NVL (mil.segment1,'-') from_locator, mp.organization_code to_organization, rsl.to_subinventory,
                     NVL (mil2.segment1,'-') to_locator, 'INTERORG' jenis, rsh.creation_date,
                     TO_CHAR (rsh.creation_date, 'DD-MON-YYYY HH24:MI:SS') creation_date2
                FROM rcv_shipment_headers rsh,
                     rcv_shipment_lines rsl,
                     mtl_material_transactions mmt,
                     mtl_item_locations mil,
                     mtl_item_locations mil2,
                     mtl_system_items_b msib,
                     mtl_parameters mp
               WHERE rsh.shipment_header_id = rsl.shipment_header_id
                 AND rsh.shipment_num IS NOT NULL
                 AND rsl.mmt_transaction_id = mmt.transaction_id
                 AND mmt.locator_id = mil.inventory_location_id(+)
                 AND rsl.locator_id = mil2.inventory_location_id(+)
                 AND rsl.item_id = msib.inventory_item_id
                 AND msib.organization_id = 81
                 AND rsl.to_organization_id = mp.organization_id
                 AND rsh.receipt_source_code = 'INVENTORY'
                 AND rsl.shipment_line_status_code <> 'FULLY RECEIVED'
                 AND rsl.to_subinventory = '$subinv'
                 $code5
            UNION
            SELECT DISTINCT rsh.shipment_num, mmt.subinventory_code from_subinventory_code,
                     NVL (mil.segment1,'-') from_locator, mp.organization_code to_organization, rsl.to_subinventory,
                     NVL (mil2.segment1,'-') to_locator, 'INTERORG' jenis, rsh.creation_date,
                     TO_CHAR (rsh.creation_date, 'DD-MON-YYYY HH24:MI:SS') creation_date2
                FROM rcv_shipment_headers rsh,
                     rcv_shipment_lines rsl,
                     mtl_material_transactions mmt,
                     mtl_item_locations mil,
                     mtl_item_locations mil2,
                     mtl_system_items_b msib,
                     mtl_parameters mp
               WHERE rsh.shipment_header_id = rsl.shipment_header_id
                 AND rsh.shipment_num IS NOT NULL
                 AND rsl.mmt_transaction_id = mmt.transaction_id
                 AND mmt.locator_id = mil.inventory_location_id(+)
                 AND rsl.locator_id = mil2.inventory_location_id(+)
                 AND rsl.item_id = msib.inventory_item_id
                 AND msib.organization_id = 81
                 AND rsl.to_organization_id = mp.organization_id
                 AND rsh.receipt_source_code = 'INVENTORY'
                 AND rsl.shipment_line_status_code <> 'FULLY RECEIVED'
                 AND mmt.subinventory_code = '$subinv'
                 $code6
            ORDER BY 8";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function getDetailMonitoring($request_number){
      $sql = "SELECT mtrh.request_number, mtrl.from_subinventory_code,
                     NVL (mil.segment1,'-') from_locator, mp.organization_code to_organization, mtrl.to_subinventory_code,
                     NVL (mil2.segment1,'-') to_locator, msib.segment1 item_code, msib.description,
                     mtrl.quantity, mtrl.quantity_detailed, mtrl.quantity_delivered,
                     mtrl.uom_code, 'MOVE ORDER' jenis
                FROM mtl_txn_request_headers mtrh,
                     mtl_txn_request_lines mtrl,
                     mtl_item_locations mil,
                     mtl_item_locations mil2,
                     mtl_system_items_b msib,
                     mtl_parameters mp
               WHERE mtrh.header_id = mtrl.header_id
                 AND mtrl.from_locator_id = mil.inventory_location_id(+)
                 AND mtrl.to_locator_id = mil2.inventory_location_id(+)
                 AND mtrl.inventory_item_id = msib.inventory_item_id
                 AND mtrl.organization_id = msib.organization_id
                 AND mtrl.organization_id = mp.organization_id
                 AND mtrl.line_status NOT IN (5, 6)
                 AND mtrh.request_number = '$request_number'
            UNION
            SELECT   kkk.kibcode, kkk.from_subinventory_code, NVL (mil.segment1,'-') from_locator,
                     mp.organization_code to_organization, kkk.to_subinventory_code, NVL (mil2.segment1,'-') to_locator,
                     msib.segment1 item_code, msib.description,
                     kkk.qty_transactions qty_diminta, NULL qty_detailed,
                     kkk.qty_transaction qty_delivered, msib.primary_uom_code,
                     'KIB' jenis
                FROM khs_kib_kanban kkk,
                     mtl_item_locations mil,
                     mtl_item_locations mil2,
                     mtl_system_items_b msib,
                     mtl_parameters mp
               WHERE kkk.from_locator_id = mil.inventory_location_id(+)
                 AND kkk.to_locator_id = mil2.inventory_location_id(+)
                 AND kkk.primary_item_id = msib.inventory_item_id
                 AND msib.organization_id = 81
                 AND kkk.to_org_id = mp.organization_id
                 AND kkk.inventory_trans_flag <> 'Y'
                 AND kkk.kibcode NOT LIKE 'SET%'
                 AND kkk.kibcode = '$request_number'
            UNION
            SELECT   rsh.shipment_num, mmt.subinventory_code from_subinventory_code,
                     NVL (mil.segment1,'-') from_locator, mp.organization_code to_organization, rsl.to_subinventory,
                     NVL (mil2.segment1,'-') to_locator, msib.segment1 item_code, msib.description,
                     rsl.quantity_shipped, NULL, rsl.quantity_received,
                     rsl.primary_unit_of_measure, 'INTERORG' jenis
                FROM rcv_shipment_headers rsh,
                     rcv_shipment_lines rsl,
                     mtl_material_transactions mmt,
                     mtl_item_locations mil,
                     mtl_item_locations mil2,
                     mtl_system_items_b msib,
                     mtl_parameters mp
               WHERE rsh.shipment_header_id = rsl.shipment_header_id
                 AND rsh.shipment_num IS NOT NULL
                 AND rsl.mmt_transaction_id = mmt.transaction_id
                 AND mmt.locator_id = mil.inventory_location_id(+)
                 AND rsl.locator_id = mil2.inventory_location_id(+)
                 AND rsl.item_id = msib.inventory_item_id
                 AND msib.organization_id = 81
                 AND rsl.to_organization_id = mp.organization_id
                 AND rsh.receipt_source_code = 'INVENTORY'
                 AND rsl.shipment_line_status_code <> 'FULLY RECEIVED'
                 AND rsh.shipment_num = '$request_number'
            ORDER BY 1";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }


    public function getRekapDari($subinv,$loc){
      if ($loc == '') {
        $code1 = "";
        $code2 = "";
        $code3 = "";
      }
      else {
        $code1 = "AND mtrl.from_locator_id = $loc";
        $code2 = "AND kkk.from_locator_id = $loc";
        $code3 = "AND mmt.locator_id = $loc";
      }

      $sql = "SELECT dari.to_subinventory_code, SUM (dari.jml) jml
                FROM (SELECT   mtrl.to_subinventory_code, COUNT (msib.segment1) jml
                          FROM mtl_txn_request_headers mtrh,
                               mtl_txn_request_lines mtrl,
                               mtl_item_locations mil,
                               mtl_item_locations mil2,
                               mtl_system_items_b msib,
                               mtl_parameters mp
                         WHERE mtrh.header_id = mtrl.header_id
                           AND mtrl.from_locator_id = mil.inventory_location_id(+)
                           AND mtrl.to_locator_id = mil2.inventory_location_id(+)
                           AND mtrl.inventory_item_id = msib.inventory_item_id
                           AND mtrl.organization_id = msib.organization_id
                           AND mtrl.organization_id = mp.organization_id
                           AND mtrl.from_subinventory_code = '$subinv'
                           AND mtrl.line_status NOT IN (1, 5, 6)
                           $code1
                      GROUP BY mtrl.to_subinventory_code
                      UNION
                      SELECT   kkk.to_subinventory_code, COUNT (msib.segment1) jml
                          FROM khs_kib_kanban kkk,
                               mtl_item_locations mil,
                               mtl_item_locations mil2,
                               mtl_system_items_b msib,
                               mtl_parameters mp
                         WHERE kkk.from_locator_id = mil.inventory_location_id(+)
                           AND kkk.to_locator_id = mil2.inventory_location_id(+)
                           AND kkk.primary_item_id = msib.inventory_item_id
                           AND msib.organization_id = 81
                           AND kkk.organization_id = mp.organization_id
                           AND kkk.inventory_trans_flag <> 'Y'
                           AND kkk.kibcode NOT LIKE 'SET%'
                           AND kkk.from_subinventory_code = '$subinv'
                           $code2
                      GROUP BY kkk.to_subinventory_code
                      UNION
                      SELECT   rsl.to_subinventory, COUNT (msib.segment1) jml
                          FROM rcv_shipment_headers rsh,
                               rcv_shipment_lines rsl,
                               mtl_material_transactions mmt,
                               mtl_item_locations mil,
                               mtl_item_locations mil2,
                               mtl_system_items_b msib,
                               mtl_parameters mp
                         WHERE rsh.shipment_header_id = rsl.shipment_header_id
                           AND rsh.shipment_num IS NOT NULL
                           AND rsl.mmt_transaction_id = mmt.transaction_id
                           AND mmt.locator_id = mil.inventory_location_id(+)
                           AND rsl.locator_id = mil2.inventory_location_id(+)
                           AND rsl.item_id = msib.inventory_item_id
                           AND msib.organization_id = 81
                           AND rsl.to_organization_id = mp.organization_id
                           AND rsh.receipt_source_code = 'INVENTORY'
                           AND rsl.shipment_line_status_code <> 'FULLY RECEIVED'
                           AND mmt.subinventory_code = '$subinv'
                           $code3
                      GROUP BY rsl.to_subinventory) dari
            GROUP BY dari.to_subinventory_code
            ORDER BY 1";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }


    public function getRekapKe($subinv,$loc){
      if ($loc == '') {
        $code1 = "";
        $code2 = "";
        $code3 = "";
      }
      else {
        $code1 = "AND mtrl.to_locator_id = $loc";
        $code2 = "AND kkk.to_locator_id = $loc";
        $code3 = "AND rsl.locator_id = $loc";
      }

      $sql = "SELECT ke.from_subinventory_code, SUM (ke.jml) jml
                FROM (SELECT   mtrl.from_subinventory_code, COUNT (msib.segment1) jml
                          FROM mtl_txn_request_headers mtrh,
                               mtl_txn_request_lines mtrl,
                               mtl_item_locations mil,
                               mtl_item_locations mil2,
                               mtl_system_items_b msib,
                               mtl_parameters mp
                         WHERE mtrh.header_id = mtrl.header_id
                           AND mtrl.from_locator_id = mil.inventory_location_id(+)
                           AND mtrl.to_locator_id = mil2.inventory_location_id(+)
                           AND mtrl.inventory_item_id = msib.inventory_item_id
                           AND mtrl.organization_id = msib.organization_id
                           AND mtrl.organization_id = mp.organization_id
                           AND mtrl.to_subinventory_code = '$subinv'
                           AND mtrl.line_status NOT IN (1, 5, 6)
                           $code1
                      GROUP BY mtrl.from_subinventory_code, 'MO'
                      UNION
                      SELECT   kkk.from_subinventory_code, COUNT (msib.segment1) jml
                          FROM khs_kib_kanban kkk,
                               mtl_item_locations mil,
                               mtl_item_locations mil2,
                               mtl_system_items_b msib,
                               mtl_parameters mp
                         WHERE kkk.from_locator_id = mil.inventory_location_id(+)
                           AND kkk.to_locator_id = mil2.inventory_location_id(+)
                           AND kkk.primary_item_id = msib.inventory_item_id
                           AND msib.organization_id = 81
                           AND kkk.to_org_id = mp.organization_id
                           AND kkk.inventory_trans_flag <> 'Y'
                           AND kkk.kibcode NOT LIKE 'SET%'
                           AND kkk.to_subinventory_code = '$subinv'
                           $code2
                      GROUP BY kkk.from_subinventory_code
                      UNION
                      SELECT   mmt.subinventory_code, COUNT (msib.segment1) jml
                          FROM rcv_shipment_headers rsh,
                               rcv_shipment_lines rsl,
                               mtl_material_transactions mmt,
                               mtl_item_locations mil,
                               mtl_item_locations mil2,
                               mtl_system_items_b msib,
                               mtl_parameters mp
                         WHERE rsh.shipment_header_id = rsl.shipment_header_id
                           AND rsh.shipment_num IS NOT NULL
                           AND rsl.mmt_transaction_id = mmt.transaction_id
                           AND mmt.locator_id = mil.inventory_location_id(+)
                           AND rsl.locator_id = mil2.inventory_location_id(+)
                           AND rsl.item_id = msib.inventory_item_id
                           AND msib.organization_id = 81
                           AND rsl.to_organization_id = mp.organization_id
                           AND rsh.receipt_source_code = 'INVENTORY'
                           AND rsl.shipment_line_status_code <> 'FULLY RECEIVED'
                           AND rsl.to_subinventory = '$subinv'
                           $code3
                      GROUP BY mmt.subinventory_code) ke
            GROUP BY ke.from_subinventory_code
            ORDER BY 1";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }


    public function exportData($from_subinv,$to_subinv,$to_loc){
      if ($to_loc == '') {
        $code1 = "";
        $code2 = "";
        $code3 = "";
      }
      else {
        $code1 = "AND mtrl.to_locator_id = $to_loc";
        $code2 = "AND kkk.to_locator_id = $to_loc";
        $code3 = "AND rsl.locator_id = $to_loc";
      }

      $sql = "SELECT mtrh.request_number, mtrl.from_subinventory_code,
                     NVL (mil.segment1, '-') from_locator,
                     mp.organization_code to_organization, mtrl.to_subinventory_code,
                     NVL (mil2.segment1, '-') to_locator, msib.segment1 item_code,
                     msib.description, mtrl.quantity, mtrl.quantity_detailed,
                     mtrl.quantity_delivered, mtrl.uom_code, 'MOVE ORDER' jenis
                FROM mtl_txn_request_headers mtrh,
                     mtl_txn_request_lines mtrl,
                     mtl_item_locations mil,
                     mtl_item_locations mil2,
                     mtl_system_items_b msib,
                     mtl_parameters mp
               WHERE mtrh.header_id = mtrl.header_id
                 AND mtrl.from_locator_id = mil.inventory_location_id(+)
                 AND mtrl.to_locator_id = mil2.inventory_location_id(+)
                 AND mtrl.inventory_item_id = msib.inventory_item_id
                 AND mtrl.organization_id = msib.organization_id
                 AND mtrl.organization_id = mp.organization_id
                 AND mtrl.line_status NOT IN (5, 6)
                 AND mtrl.from_subinventory_code = '$from_subinv'
                 AND mtrl.to_subinventory_code = '$to_subinv'
                 AND mil2.segment1 = '$to_loc'
            UNION
            SELECT   kkk.kibcode, kkk.from_subinventory_code,
                     NVL (mil.segment1, '-') from_locator,
                     mp.organization_code to_organization, kkk.to_subinventory_code,
                     NVL (mil2.segment1, '-') to_locator, msib.segment1 item_code,
                     msib.description, kkk.qty_transactions qty_diminta,
                     NULL qty_detailed, kkk.qty_transaction qty_delivered,
                     msib.primary_uom_code, 'KIB' jenis
                FROM khs_kib_kanban kkk,
                     mtl_item_locations mil,
                     mtl_item_locations mil2,
                     mtl_system_items_b msib,
                     mtl_parameters mp
               WHERE kkk.from_locator_id = mil.inventory_location_id(+)
                 AND kkk.to_locator_id = mil2.inventory_location_id(+)
                 AND kkk.primary_item_id = msib.inventory_item_id
                 AND msib.organization_id = 81
                 AND kkk.to_org_id = mp.organization_id
                 AND kkk.inventory_trans_flag <> 'Y'
                 AND kkk.kibcode NOT LIKE 'SET%'
                 AND kkk.from_subinventory_code = '$from_subinv'
                 AND kkk.to_subinventory_code = '$to_subinv'
                 AND mil2.segment1 = '$to_loc'
            UNION
            SELECT   rsh.shipment_num, mmt.subinventory_code from_subinventory_code,
                     NVL (mil.segment1, '-') from_locator,
                     mp.organization_code to_organization, rsl.to_subinventory,
                     NVL (mil2.segment1, '-') to_locator, msib.segment1 item_code,
                     msib.description, rsl.quantity_shipped, NULL, rsl.quantity_received,
                     rsl.primary_unit_of_measure, 'INTERORG' jenis
                FROM rcv_shipment_headers rsh,
                     rcv_shipment_lines rsl,
                     mtl_material_transactions mmt,
                     mtl_item_locations mil,
                     mtl_item_locations mil2,
                     mtl_system_items_b msib,
                     mtl_parameters mp
               WHERE rsh.shipment_header_id = rsl.shipment_header_id
                 AND rsh.shipment_num IS NOT NULL
                 AND rsl.mmt_transaction_id = mmt.transaction_id
                 AND mmt.locator_id = mil.inventory_location_id(+)
                 AND rsl.locator_id = mil2.inventory_location_id(+)
                 AND rsl.item_id = msib.inventory_item_id
                 AND msib.organization_id = 81
                 AND rsl.to_organization_id = mp.organization_id
                 AND rsh.receipt_source_code = 'INVENTORY'
                 AND rsl.shipment_line_status_code <> 'FULLY RECEIVED'
                 AND mmt.subinventory_code = '$from_subinv'
                 AND rsl.to_subinventory = '$to_subinv'
                 AND mil2.segment1 = '$to_loc'
            ORDER BY jenis, 1";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }
}
?>