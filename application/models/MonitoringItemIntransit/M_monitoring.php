<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monitoring extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
    }
    public function getIo($param)
    {
        $sql = "SELECT   mp.organization_code, mp.organization_id
        FROM mtl_parameters mp
       WHERE mp.organization_id <> 81
       $param
    ORDER BY mp.organization_code";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function getSubinv($term)
    {
        $sql = "SELECT   msi.secondary_inventory_name, msi.description
        FROM mtl_secondary_inventories msi
       WHERE msi.organization_id = $term AND disable_date IS NULL
    ORDER BY msi.secondary_inventory_name";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function getDataItemItransit1($io_dari, $io_ke, $subdari, $subke, $date_nya)
    {
        $sql = "SELECT DISTINCT TO_CHAR (SYSDATE, 'DD-Mon-RR') tanggal_cetak,
        rsh.shipment_header_id, rsh.shipment_num,
        (SELECT attribute4
           FROM mtl_txn_request_headers
          WHERE request_number = rsh.shipment_num) comments,
        rsh.creation_date,
        (TRUNC (SYSDATE) - TO_DATE (rsh.creation_date)) days_count,
        rsh.receipt_num, rsl.line_num, msib.segment1,
        msib.description, mp1.organization_code from_io,
        ms.from_subinventory, mp2.organization_code to_io,
        ms.to_subinventory, rsl.quantity_shipped,
        rsl.quantity_received,
        (rsl.quantity_shipped - rsl.quantity_received
        ) quantity_intransit,
        (SELECT mil.segment1
           FROM mtl_item_locations mil,
                mtl_material_transactions mmt
          WHERE mmt.transaction_id = rsl.mmt_transaction_id
            AND mil.inventory_location_id = mmt.locator_id) from_loc,
        (SELECT mil.segment1
           FROM mtl_item_locations mil,
                mtl_material_transactions mmt
          WHERE mmt.transaction_id = rsl.mmt_transaction_id
            AND mil.inventory_location_id = mmt.transfer_locator_id)
                                                               to_loc,
        rsl.mmt_transaction_id, mut.serial_number
   FROM mtl_system_items_b msib,
        rcv_shipment_headers rsh,
        rcv_shipment_lines rsl LEFT JOIN mtl_unit_transactions mut
        ON mut.transaction_id = rsl.mmt_transaction_id
        ,
        mtl_parameters mp1,
        mtl_parameters mp2,
        mtl_supply ms
  WHERE rsh.shipment_header_id = rsl.shipment_header_id
    AND msib.inventory_item_id = rsl.item_id
    AND mp1.organization_id = ms.from_organization_id
    AND rsl.shipment_header_id = ms.shipment_header_id
    AND rsl.shipment_line_id = ms.shipment_line_id
    AND mp2.organization_id = ms.to_organization_id
    AND ms.supply_type_code = 'SHIPMENT'
    AND rsh.shipment_num != '3850756'
  $io_dari $subdari $io_ke $subke $date_nya
ORDER BY mp1.organization_code,
        mp2.organization_code,
        rsh.shipment_header_id,
        rsl.line_num";

        $query = $this->oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }
    public function getDataItemItransit2($io_dari, $io_ke, $subdari, $subke, $date_nya)
    {
        $sql = "SELECT   shipment_num, days_count, from_io, from_subinventory, from_loc,
            to_io, to_subinventory, to_loc,
            SUM (quantity_intransit) quantity_intransit, comments
       FROM (SELECT DISTINCT TO_CHAR (SYSDATE, 'DD-Mon-RR') tanggal_cetak,
                             rsh.shipment_header_id, rsh.shipment_num,
                             (SELECT attribute4
                                FROM mtl_txn_request_headers
                               WHERE request_number = rsh.shipment_num) comments,
                             rsh.creation_date,
                             (TRUNC (SYSDATE) - TO_DATE (rsh.creation_date)
                             ) days_count,
                             rsh.receipt_num, rsl.line_num, msib.segment1,
                             msib.description, mp1.organization_code from_io,
                             ms.from_subinventory, mp2.organization_code to_io,
                             ms.to_subinventory,
                             mp2.organization_code to_io_judul,
                             ms.to_subinventory to_subinventory_judul,
                             rsl.quantity_shipped, rsl.quantity_received,
                             (rsl.quantity_shipped - rsl.quantity_received
                             ) quantity_intransit,
                             (SELECT mil.segment1
                                FROM mtl_item_locations mil,
                                     mtl_material_transactions mmt
                               WHERE mmt.transaction_id = rsl.mmt_transaction_id
                                 AND mil.inventory_location_id = mmt.locator_id)
                                                                        from_loc,
                             (SELECT mil.segment1
                                FROM mtl_item_locations mil,
                                     mtl_material_transactions mmt
                               WHERE mmt.transaction_id = rsl.mmt_transaction_id
                                 AND mil.inventory_location_id =
                                                          mmt.transfer_locator_id)
                                                                          to_loc,
                             rsl.mmt_transaction_id, mut.serial_number
                        FROM mtl_system_items_b msib,
                             rcv_shipment_headers rsh,
                             rcv_shipment_lines rsl LEFT JOIN mtl_unit_transactions mut
                             ON mut.transaction_id = rsl.mmt_transaction_id
                             ,
                             mtl_parameters mp1,
                             mtl_parameters mp2,
                             mtl_supply ms,
                             khs_organization_locations kol
                       WHERE rsh.shipment_header_id = rsl.shipment_header_id
                         AND msib.inventory_item_id = rsl.item_id
                         AND mp1.organization_id = ms.from_organization_id
                         AND rsl.shipment_header_id = ms.shipment_header_id
                         AND rsl.shipment_line_id = ms.shipment_line_id
                         AND mp2.organization_id = ms.to_organization_id
                         AND ms.supply_type_code = 'SHIPMENT'
                         AND rsh.shipment_num != '3850756'
                         $io_dari $subdari $io_ke $subke $date_nya
                         AND mp2.organization_id = kol.organization_id
                         AND CASE
                                WHEN kol.TYPE = 'JAWA'
                                AND (TRUNC (SYSDATE)
                                     - TO_DATE (rsh.creation_date)
                                    ) > 7
                                   THEN 1
                                WHEN kol.TYPE = 'LUAR JAWA'
                                AND (TRUNC (SYSDATE)
                                     - TO_DATE (rsh.creation_date)
                                    ) > 14
                                   THEN 1
                                ELSE 0
                             END = 1
                    ORDER BY mp1.organization_code,
                             mp2.organization_code,
                             rsh.shipment_header_id,
                             rsl.line_num)
   GROUP BY shipment_num,
            days_count,
            from_io,
            from_subinventory,
            from_loc,
            to_io,
            to_subinventory,
            to_loc,
            comments
   ORDER BY from_io, to_io";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
}
