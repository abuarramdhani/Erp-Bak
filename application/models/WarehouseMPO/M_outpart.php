<?php
class M_outpart extends CI_Model {

  var $oracle;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('encrypt');
        $this->oracle = $this->load->database('oracle', true);
    }

    public function getWarehouse()
    {
      $sql = "SELECT distinct msi.SECONDARY_INVENTORY_NAME subinv
                from mtl_secondary_inventories msi
               where msi.ORGANIZATION_ID IN (102,386,486,101)
                 and msi.DISABLE_DATE is null
            order by 1";

      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function getSubkont()
    {
      $sql = "SELECT DISTINCT pov.vendor_name
                FROM po_requisition_headers_all prh,
                     po_requisition_lines_all prl,
                     po_headers_all pha,
                     po_distributions_all pod,
                     po_req_distributions_all pord,
                     po_vendors pov
               WHERE prh.interface_source_code = 'WIP'
                 AND pord.distribution_id = pod.req_distribution_id
                 AND pord.requisition_line_id = prl.requisition_line_id
                 AND prl.requisition_header_id = prh.requisition_header_id
                 AND pod.po_header_id = pha.po_header_id
                 AND pha.vendor_id = pov.vendor_id
            ORDER BY 1";

      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function indexOut()
    {
        $sql = "SELECT pov.vendor_name nama_subkon, 
          knm.no_mobil,
          mtrh.request_number no_spbs,
          mtrl.line_number,
         gbh.batch_no no_job,
         mtrh.creation_date tgl_spbs,
         tmp.tgl_terima, 
         tmp.tgl_mulai tgl_kirim, 
         msib.segment1 item_code,
         msib.description item_desc,
         NVL (mmtt.transaction_quantity, mtrl.quantity) qty_diminta,
         tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
         NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
         tmp.tgl_mulai, 
         tmp.tgl_selesai,
         TO_CHAR(tmp.tgl_mulai,'HH24:MI:SS') jam_mulai,
         TO_CHAR(tmp.tgl_selesai,'HH24:MI:SS') jam_selesai,
        ROUND (((tmp.tgl_selesai - tmp.tgl_mulai) * 1440), 2) lama,
         ROUND
            (AVG ((tmp.tgl_selesai - tmp.tgl_mulai) * 1440) OVER (PARTITION BY tmp.subinv, pov.vendor_name),
             2
            ) average,
         CASE
            WHEN mtrl.line_status = 5
            AND mtrl.quantity_delivered IS NULL
               THEN 'B'
            WHEN mtrl.line_status = 5 AND mtrl.quantity_delivered IS NOT NULL
               THEN 'O'
            ELSE 'X'
         END keterangan,
         TO_CHAR(mmt.transaction_date,'DD-MON-YYYY HH24:MI:SS') transaction_date
    FROM mtl_txn_request_headers mtrh,
         mtl_txn_request_lines mtrl,
         mtl_material_transactions_temp mmtt,
         mtl_material_transactions mmt,
         mtl_system_items_b msib,
         po_requisition_lines_all prl,
         po_headers_all poh,
         po_distributions_all pod,
         po_req_distributions_all pord,
         po_vendors pov,
         khs_no_mobil knm,
         gme_batch_header gbh,
         (SELECT NVL (kmgk.no_spbs, kmtb.no_spbs) no_spbs, kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs = kmgk.no_spbs(+)
          UNION
          SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs(+) = kmgk.no_spbs) tmp
   WHERE mtrh.header_id = mtrl.header_id
     AND mtrl.line_id = mmtt.move_order_line_id(+)
     AND mtrl.line_id = mmt.move_order_line_id(+)
     AND mtrl.inventory_item_id = msib.inventory_item_id
     AND mtrl.organization_id = msib.organization_id
     AND tmp.no_spbs = mtrh.request_number
     AND NVL (tmp.line_id, mtrl.line_id) = mtrl.line_id
     AND mtrl.txn_source_id = gbh.batch_id
     AND SUBSTR (prl.reference_num, 10, 10) = gbh.batch_no
     AND prl.requisition_line_id(+) = pord.requisition_line_id
     AND pord.distribution_id(+) = pod.req_distribution_id
     AND pod.po_header_id(+) = poh.po_header_id
     AND poh.vendor_id = pov.vendor_id
     AND knm.vendor_id = poh.vendor_id
     AND (mmt.transaction_quantity IS NULL OR mmt.transaction_quantity < 0)
UNION
SELECT   pov.vendor_name nama_subkon, 
         knm.no_mobil,
         mtrh.request_number no_spbs, 
         mtrl.line_number,
         we.wip_entity_name NO_JOB, 
         mtrh.creation_date tgl_spbs,
         tmp.tgl_terima, 
         tmp.tgl_mulai tgl_kirim, 
         msib.segment1 item_code,
         msib.description item_desc,
         NVL (mmtt.transaction_quantity, mtrl.quantity) qty_diminta,
         tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
         NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
         tmp.tgl_mulai, 
         tmp.tgl_selesai,
         TO_CHAR(tmp.tgl_mulai,'HH24:MI:SS') jam_mulai,
        TO_CHAR(tmp.tgl_selesai,'HH24:MI:SS') jam_selesai,
         ROUND (((tmp.tgl_selesai - tmp.tgl_mulai) * 1440), 2) lama,
         ROUND
            (AVG ((tmp.tgl_selesai - tmp.tgl_mulai) * 1440) OVER (PARTITION BY tmp.subinv, pov.vendor_name),
             2
            ) average,
         CASE
            WHEN mtrl.line_status = 5
            AND mtrl.quantity_delivered IS NULL
               THEN 'B'
            WHEN mtrl.line_status = 5 AND mtrl.quantity_delivered IS NOT NULL
               THEN 'O'
            ELSE 'X'
         END keterangan,
         TO_CHAR(mmt.transaction_date,'DD-MON-YYYY HH24:MI:SS') transaction_date
    FROM mtl_txn_request_headers mtrh,
         mtl_txn_request_lines mtrl,
         mtl_material_transactions_temp mmtt,
         mtl_material_transactions mmt,
         mtl_system_items_b msib,
         po_requisition_lines_all prl,
         wip_entities we,
         po_headers_all poh,
         po_distributions_all pod,
         po_req_distributions_all pord,
         po_vendors pov,
         khs_no_mobil knm,
         (SELECT NVL (kmgk.no_spbs, kmtb.no_spbs) no_spbs, kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs = kmgk.no_spbs(+)
          UNION
          SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs(+) = kmgk.no_spbs) tmp
   WHERE mtrh.header_id = mtrl.header_id
     AND mtrl.line_id = mmtt.move_order_line_id(+)
     AND mtrl.line_id = mmt.move_order_line_id(+)
     AND mtrl.inventory_item_id = msib.inventory_item_id
     AND mtrl.organization_id = msib.organization_id
     AND tmp.no_spbs = mtrh.request_number
     AND NVL (tmp.line_id, mtrl.line_id) = mtrl.line_id
     AND mtrl.txn_source_id = we.wip_entity_id
     AND prl.wip_entity_id = we.wip_entity_id
     AND prl.requisition_line_id(+) = pord.requisition_line_id
     AND pord.distribution_id(+) = pod.req_distribution_id
     AND pod.po_header_id(+) = poh.po_header_id
     AND poh.vendor_id = pov.vendor_id
     AND knm.vendor_id = poh.vendor_id
     AND (mmt.transaction_quantity IS NULL OR mmt.transaction_quantity < 0)
UNION
SELECT   pov.vendor_name nama_subkon, 
         knm.no_mobil,
         mtrh.request_number no_spbs,
         mtrl.line_number,
         gbh.batch_no NO_JOB, 
         mtrh.creation_date tgl_spbs,
         tmp.tgl_terima, 
         tmp.tgl_mulai tgl_kirim, 
         msib.segment1 item_code,
         msib.description item_desc,
         NVL (mmtt.transaction_quantity, mtrl.quantity) qty_diminta,
         tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
         NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
         tmp.tgl_mulai, 
         tmp.tgl_selesai,
         TO_CHAR(tmp.tgl_mulai,'HH24:MI:SS') jam_mulai,
        TO_CHAR(tmp.tgl_selesai,'HH24:MI:SS') jam_selesai,
         ROUND (((tmp.tgl_selesai - tmp.tgl_mulai) * 1440), 2) lama,
         ROUND
            (AVG ((tmp.tgl_selesai - tmp.tgl_mulai) * 1440) OVER (PARTITION BY tmp.subinv, pov.vendor_name),
             2
            ) average,
         CASE
            WHEN mtrl.line_status = 5
            AND mtrl.quantity_delivered IS NULL
               THEN 'B'
            WHEN mtrl.line_status = 5 AND mtrl.quantity_delivered IS NOT NULL
               THEN 'O'
            ELSE 'X'
         END keterangan,
         TO_CHAR(mmt.transaction_date,'DD-MON-YYYY HH24:MI:SS') transaction_date
    FROM mtl_txn_request_headers mtrh,
         mtl_txn_request_lines mtrl,
         mtl_material_transactions_temp mmtt,
         mtl_material_transactions mmt,
         mtl_system_items_b msib,
         po_requisition_lines_all prl,
         po_headers_all poh,
         po_distributions_all pod,
         po_req_distributions_all pord,
         po_vendors pov,
         khs_no_mobil knm,
         gme_batch_header gbh,
         (SELECT DISTINCT fcr.argument1 spbs_dari, fcr.argument2 spbs_sampai,
                          fcr.argument3 no_po
                     FROM fnd_concurrent_requests fcr
                    WHERE fcr.concurrent_program_id in (142629,434696)) komb,
         (SELECT NVL (kmgk.no_spbs, kmtb.no_spbs) no_spbs, kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs = kmgk.no_spbs(+)
          UNION
          SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs(+) = kmgk.no_spbs) tmp
   WHERE mtrh.header_id = mtrl.header_id
     AND mtrh.request_number BETWEEN komb.spbs_dari AND komb.spbs_sampai
     AND mtrl.line_id = mmtt.move_order_line_id(+)
     AND mtrl.line_id = mmt.move_order_line_id(+)
     AND mtrl.inventory_item_id = msib.inventory_item_id
     AND mtrl.organization_id = msib.organization_id
     AND tmp.no_spbs = mtrh.request_number
     AND NVL (tmp.line_id, mtrl.line_id) = mtrl.line_id
     AND poh.segment1 = komb.no_po
     AND mtrl.txn_source_id = gbh.batch_id
     AND prl.requisition_line_id(+) = pord.requisition_line_id
     AND pord.distribution_id(+) = pod.req_distribution_id
     AND pod.po_header_id(+) = poh.po_header_id
     AND poh.vendor_id = pov.vendor_id
     AND knm.vendor_id = poh.vendor_id
     AND (mmt.transaction_quantity IS NULL OR mmt.transaction_quantity < 0)
UNION
SELECT   pov.vendor_name nama_subkon, 
         knm.no_mobil,
         mtrh.request_number no_spbs, 
         mtrl.line_number,
         we.wip_entity_name NO_JOB, 
         mtrh.creation_date tgl_spbs,
         tmp.tgl_terima, 
         tmp.tgl_mulai tgl_kirim, 
         msib.segment1 item_code,
         msib.description item_desc,
         NVL (mmtt.transaction_quantity, mtrl.quantity) qty_diminta,
         tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
         NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
         tmp.tgl_mulai, 
         tmp.tgl_selesai,
         TO_CHAR(tmp.tgl_mulai,'HH24:MI:SS') jam_mulai,
        TO_CHAR(tmp.tgl_selesai,'HH24:MI:SS') jam_selesai,
         ROUND (((tmp.tgl_selesai - tmp.tgl_mulai) * 1440), 2) lama,
         --ROUND (((tmp.tgl_selesai - tmp.tgl_mulai) * 1440), 2) lama,
         ROUND
            (AVG ((tmp.tgl_selesai - tmp.tgl_mulai) * 1440) OVER (PARTITION BY tmp.subinv, pov.vendor_name),
             2
            ) average,
         CASE
            WHEN mtrl.line_status = 5
            AND mtrl.quantity_delivered IS NULL
               THEN 'B'
            WHEN mtrl.line_status = 5 AND mtrl.quantity_delivered IS NOT NULL
               THEN 'O'
            ELSE 'X'
         END keterangan,
         TO_CHAR(mmt.transaction_date,'DD-MON-YYYY HH24:MI:SS') transaction_date
    FROM mtl_txn_request_headers mtrh,
         mtl_txn_request_lines mtrl,
         mtl_material_transactions_temp mmtt,
         mtl_material_transactions mmt,
         mtl_system_items_b msib,
         po_requisition_lines_all prl,
         po_headers_all poh,
         po_distributions_all pod,
         po_req_distributions_all pord,
         po_vendors pov,
         khs_no_mobil knm,
         wip_entities we,
         (SELECT DISTINCT fcr.argument1 spbs_dari, fcr.argument2 spbs_sampai,
                          fcr.argument3 no_po
                     FROM fnd_concurrent_requests fcr
                    WHERE fcr.concurrent_program_id in (142629,434696)) komb,
         (SELECT NVL (kmgk.no_spbs, kmtb.no_spbs) no_spbs, kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs = kmgk.no_spbs(+)
          UNION
          SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs(+) = kmgk.no_spbs) tmp
   WHERE mtrh.header_id = mtrl.header_id
     AND mtrh.request_number BETWEEN komb.spbs_dari AND komb.spbs_sampai
     AND mtrl.line_id = mmtt.move_order_line_id(+)
     AND mtrl.line_id = mmt.move_order_line_id(+)
     AND mtrl.inventory_item_id = msib.inventory_item_id
     AND mtrl.organization_id = msib.organization_id
     AND tmp.no_spbs = mtrh.request_number
     AND NVL (tmp.line_id, mtrl.line_id) = mtrl.line_id
     AND poh.segment1 = komb.no_po
     AND prl.requisition_line_id(+) = pord.requisition_line_id
     AND pord.distribution_id(+) = pod.req_distribution_id
     AND pod.po_header_id(+) = poh.po_header_id
     AND poh.vendor_id = pov.vendor_id
     AND knm.vendor_id = poh.vendor_id
     AND (mmt.transaction_quantity IS NULL OR mmt.transaction_quantity < 0)
     AND mtrl.txn_source_id = we.wip_entity_id
     AND prl.wip_entity_id = we.wip_entity_id
ORDER BY 3, 4 ASC";

        // echo "<pre>";
        // echo $sql;
        // exit();

        $query = $this->oracle->query($sql);
        return $query->result_array();

    }

    public function indexWarehouse($compile)
    {

        $sql = "SELECT pov.vendor_name nama_subkon, 
          knm.no_mobil,
          mtrh.request_number no_spbs,
          mtrl.line_number,
         gbh.batch_no no_job,
         mtrh.creation_date tgl_spbs,
         tmp.tgl_terima, 
         tmp.tgl_mulai tgl_kirim, 
         msib.segment1 item_code,
         msib.description item_desc,
         NVL (mmtt.transaction_quantity, mtrl.quantity) qty_diminta,
         tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
         NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
         tmp.tgl_mulai, 
         tmp.tgl_selesai,
         TO_CHAR(tmp.tgl_mulai,'HH24:MI:SS') jam_mulai,
         TO_CHAR(tmp.tgl_selesai,'HH24:MI:SS') jam_selesai,
         ROUND (((tmp.tgl_selesai - tmp.tgl_mulai) * 1440), 2) lama,
         ROUND
            (AVG ((tmp.tgl_selesai - tmp.tgl_mulai) * 1440) OVER (PARTITION BY tmp.subinv, pov.vendor_name),
             2
            ) average,
         CASE
            WHEN mtrl.line_status = 5
            AND mtrl.quantity_delivered IS NULL
               THEN 'B'
            WHEN mtrl.line_status = 5 AND mtrl.quantity_delivered IS NOT NULL
               THEN 'O'
            ELSE 'X'
         END keterangan,
         TO_CHAR(mmt.transaction_date,'DD-MON-YYYY HH24:MI:SS') transaction_date
    FROM mtl_txn_request_headers mtrh,
         mtl_txn_request_lines mtrl,
         mtl_material_transactions_temp mmtt,
         mtl_material_transactions mmt,
         mtl_system_items_b msib,
         po_requisition_lines_all prl,
         po_headers_all poh,
         po_distributions_all pod,
         po_req_distributions_all pord,
         po_vendors pov,
         khs_no_mobil knm,
         gme_batch_header gbh,
         (SELECT NVL (kmgk.no_spbs, kmtb.no_spbs) no_spbs, kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs = kmgk.no_spbs(+)
          UNION
          SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs(+) = kmgk.no_spbs) tmp
   WHERE mtrh.header_id = mtrl.header_id
     AND mtrl.line_id = mmtt.move_order_line_id(+)
     AND mtrl.line_id = mmt.move_order_line_id(+)
     AND mtrl.inventory_item_id = msib.inventory_item_id
     AND mtrl.organization_id = msib.organization_id
     AND tmp.no_spbs = mtrh.request_number
     AND NVL (tmp.line_id, mtrl.line_id) = mtrl.line_id
     AND mtrl.txn_source_id = gbh.batch_id
     AND SUBSTR (prl.reference_num, 10, 10) = gbh.batch_no
     AND prl.requisition_line_id(+) = pord.requisition_line_id
     AND pord.distribution_id(+) = pod.req_distribution_id
     AND pod.po_header_id(+) = poh.po_header_id
     AND poh.vendor_id = pov.vendor_id
     AND knm.vendor_id = poh.vendor_id
     AND (mmt.transaction_quantity IS NULL OR mmt.transaction_quantity < 0)
UNION
SELECT   pov.vendor_name nama_subkon, 
         knm.no_mobil,
         mtrh.request_number no_spbs, 
         mtrl.line_number,
         we.wip_entity_name NO_JOB, 
         mtrh.creation_date tgl_spbs,
         tmp.tgl_terima, 
         tmp.tgl_mulai tgl_kirim, 
         msib.segment1 item_code,
         msib.description item_desc,
         NVL (mmtt.transaction_quantity, mtrl.quantity) qty_diminta,
         tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
         NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
         tmp.tgl_mulai, 
         tmp.tgl_selesai,
         TO_CHAR(tmp.tgl_mulai,'HH24:MI:SS') jam_mulai,
        TO_CHAR(tmp.tgl_selesai,'HH24:MI:SS') jam_selesai,
         ROUND (((tmp.tgl_selesai - tmp.tgl_mulai) * 1440), 2) lama,
         ROUND
            (AVG ((tmp.tgl_selesai - tmp.tgl_mulai) * 1440) OVER (PARTITION BY tmp.subinv, pov.vendor_name),
             2
            ) average,
         CASE
            WHEN mtrl.line_status = 5
            AND mtrl.quantity_delivered IS NULL
               THEN 'B'
            WHEN mtrl.line_status = 5 AND mtrl.quantity_delivered IS NOT NULL
               THEN 'O'
            ELSE 'X'
         END keterangan,
         TO_CHAR(mmt.transaction_date,'DD-MON-YYYY HH24:MI:SS') transaction_date
    FROM mtl_txn_request_headers mtrh,
         mtl_txn_request_lines mtrl,
         mtl_material_transactions_temp mmtt,
         mtl_material_transactions mmt,
         mtl_system_items_b msib,
         po_requisition_lines_all prl,
         wip_entities we,
         po_headers_all poh,
         po_distributions_all pod,
         po_req_distributions_all pord,
         po_vendors pov,
         khs_no_mobil knm,
         (SELECT NVL (kmgk.no_spbs, kmtb.no_spbs) no_spbs, kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs = kmgk.no_spbs(+)
          UNION
          SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs(+) = kmgk.no_spbs) tmp
   WHERE mtrh.header_id = mtrl.header_id
     AND mtrl.line_id = mmtt.move_order_line_id(+)
     AND mtrl.line_id = mmt.move_order_line_id(+)
     AND mtrl.inventory_item_id = msib.inventory_item_id
     AND mtrl.organization_id = msib.organization_id
     AND tmp.no_spbs = mtrh.request_number
     AND NVL (tmp.line_id, mtrl.line_id) = mtrl.line_id
     AND mtrl.txn_source_id = we.wip_entity_id
     AND prl.wip_entity_id = we.wip_entity_id
     AND prl.requisition_line_id(+) = pord.requisition_line_id
     AND pord.distribution_id(+) = pod.req_distribution_id
     AND pod.po_header_id(+) = poh.po_header_id
     AND poh.vendor_id = pov.vendor_id
     AND knm.vendor_id = poh.vendor_id
     AND (mmt.transaction_quantity IS NULL OR mmt.transaction_quantity < 0)
UNION
SELECT   pov.vendor_name nama_subkon, 
         knm.no_mobil,
         mtrh.request_number no_spbs,
         mtrl.line_number,
         gbh.batch_no NO_JOB, 
         mtrh.creation_date tgl_spbs,
         tmp.tgl_terima, 
         tmp.tgl_mulai tgl_kirim, 
         msib.segment1 item_code,
         msib.description item_desc,
         NVL (mmtt.transaction_quantity, mtrl.quantity) qty_diminta,
         tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
         NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
         tmp.tgl_mulai, 
         tmp.tgl_selesai,
         TO_CHAR(tmp.tgl_mulai,'HH24:MI:SS') jam_mulai,
        TO_CHAR(tmp.tgl_selesai,'HH24:MI:SS') jam_selesai,
         ROUND (((tmp.tgl_selesai - tmp.tgl_mulai) * 1440), 2) lama,
         ROUND
            (AVG ((tmp.tgl_selesai - tmp.tgl_mulai) * 1440) OVER (PARTITION BY tmp.subinv, pov.vendor_name),
             2
            ) average,
         CASE
            WHEN mtrl.line_status = 5
            AND mtrl.quantity_delivered IS NULL
               THEN 'B'
            WHEN mtrl.line_status = 5 AND mtrl.quantity_delivered IS NOT NULL
               THEN 'O'
            ELSE 'X'
         END keterangan,
         TO_CHAR(mmt.transaction_date,'DD-MON-YYYY HH24:MI:SS') transaction_date
    FROM mtl_txn_request_headers mtrh,
         mtl_txn_request_lines mtrl,
         mtl_material_transactions_temp mmtt,
         mtl_material_transactions mmt,
         mtl_system_items_b msib,
         po_requisition_lines_all prl,
         po_headers_all poh,
         po_distributions_all pod,
         po_req_distributions_all pord,
         po_vendors pov,
         khs_no_mobil knm,
         gme_batch_header gbh,
         (SELECT DISTINCT fcr.argument1 spbs_dari, fcr.argument2 spbs_sampai,
                          fcr.argument3 no_po
                     FROM fnd_concurrent_requests fcr
                    WHERE fcr.concurrent_program_id in (142629,434696)) komb,
         (SELECT NVL (kmgk.no_spbs, kmtb.no_spbs) no_spbs, kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs = kmgk.no_spbs(+)
          UNION
          SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs(+) = kmgk.no_spbs) tmp
   WHERE mtrh.header_id = mtrl.header_id
     AND mtrh.request_number BETWEEN komb.spbs_dari AND komb.spbs_sampai
     AND mtrl.line_id = mmtt.move_order_line_id(+)
     AND mtrl.line_id = mmt.move_order_line_id(+)
     AND mtrl.inventory_item_id = msib.inventory_item_id
     AND mtrl.organization_id = msib.organization_id
     AND tmp.no_spbs = mtrh.request_number
     AND NVL (tmp.line_id, mtrl.line_id) = mtrl.line_id
     AND poh.segment1 = komb.no_po
     AND mtrl.txn_source_id = gbh.batch_id
     AND prl.requisition_line_id(+) = pord.requisition_line_id
     AND pord.distribution_id(+) = pod.req_distribution_id
     AND pod.po_header_id(+) = poh.po_header_id
     AND poh.vendor_id = pov.vendor_id
     AND knm.vendor_id = poh.vendor_id
     AND (mmt.transaction_quantity IS NULL OR mmt.transaction_quantity < 0)
UNION
SELECT   pov.vendor_name nama_subkon, 
         knm.no_mobil,
         mtrh.request_number no_spbs, 
         mtrl.line_number,
         we.wip_entity_name NO_JOB, 
         mtrh.creation_date tgl_spbs,
         tmp.tgl_terima, 
         tmp.tgl_mulai tgl_kirim, 
         msib.segment1 item_code,
         msib.description item_desc,
         NVL (mmtt.transaction_quantity, mtrl.quantity) qty_diminta,
         tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
         NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
         tmp.tgl_mulai, 
         tmp.tgl_selesai,
         TO_CHAR(tmp.tgl_mulai,'HH24:MI:SS') jam_mulai,
        TO_CHAR(tmp.tgl_selesai,'HH24:MI:SS') jam_selesai,
         ROUND (((tmp.tgl_selesai - tmp.tgl_mulai) * 1440), 2) lama,
         --ROUND (((tmp.tgl_selesai - tmp.tgl_mulai) * 1440), 2) lama,
         ROUND
            (AVG ((tmp.tgl_selesai - tmp.tgl_mulai) * 1440) OVER (PARTITION BY tmp.subinv, pov.vendor_name),
             2
            ) average,
         CASE
            WHEN mtrl.line_status = 5
            AND mtrl.quantity_delivered IS NULL
               THEN 'B'
            WHEN mtrl.line_status = 5 AND mtrl.quantity_delivered IS NOT NULL
               THEN 'O'
            ELSE 'X'
         END keterangan,
         TO_CHAR(mmt.transaction_date,'DD-MON-YYYY HH24:MI:SS') transaction_date
    FROM mtl_txn_request_headers mtrh,
         mtl_txn_request_lines mtrl,
         mtl_material_transactions_temp mmtt,
         mtl_material_transactions mmt,
         mtl_system_items_b msib,
         po_requisition_lines_all prl,
         po_headers_all poh,
         po_distributions_all pod,
         po_req_distributions_all pord,
         po_vendors pov,
         khs_no_mobil knm,
         wip_entities we,
         (SELECT DISTINCT fcr.argument1 spbs_dari, fcr.argument2 spbs_sampai,
                          fcr.argument3 no_po
                     FROM fnd_concurrent_requests fcr
                    WHERE fcr.concurrent_program_id in (142629,434696)) komb,
         (SELECT NVL (kmgk.no_spbs, kmtb.no_spbs) no_spbs, kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs = kmgk.no_spbs(+)
          UNION
          SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs(+) = kmgk.no_spbs) tmp
   WHERE mtrh.header_id = mtrl.header_id
     AND mtrh.request_number BETWEEN komb.spbs_dari AND komb.spbs_sampai
     AND mtrl.line_id = mmtt.move_order_line_id(+)
     AND mtrl.line_id = mmt.move_order_line_id(+)
     AND mtrl.inventory_item_id = msib.inventory_item_id
     AND mtrl.organization_id = msib.organization_id
     AND tmp.no_spbs = mtrh.request_number
     AND NVL (tmp.line_id, mtrl.line_id) = mtrl.line_id
     AND poh.segment1 = komb.no_po
     AND prl.requisition_line_id(+) = pord.requisition_line_id
     AND pord.distribution_id(+) = pod.req_distribution_id
     AND pod.po_header_id(+) = poh.po_header_id
     AND poh.vendor_id = pov.vendor_id
     AND knm.vendor_id = poh.vendor_id
     AND (mmt.transaction_quantity IS NULL OR mmt.transaction_quantity < 0)
     AND mtrl.txn_source_id = we.wip_entity_id
     AND prl.wip_entity_id = we.wip_entity_id
     AND NVL (mmtt.subinventory_code, mmt.subinventory_code) = '$compile'
ORDER BY 3, 4 ASC";

        $query = $this->oracle->query($sql);
        return $query->result_array();

    }

    public function allPengeluaran($spbs_awal = false,$spbs_akhir = false ,$kirim_awal = false ,$kirim_akhir = false ,$spbs_num = false,$subname = false,$job = false)
    {
        
        if ($spbs_awal==FALSE && $spbs_akhir==FALSE) {
          $spbs_date = "";
        }else{
          $spbs_date = "AND TRUNC(mtrh.creation_date) between '$spbs_awal' and '$spbs_akhir'";
        }

        if ($kirim_awal==FALSE && $kirim_akhir==FALSE) {
          $send_date = "";
        }else{
          $send_date = "AND TRUNC(tmp.tgl_mulai) between '$kirim_awal' and '$kirim_akhir'";
        }

        if ($spbs_num==FALSE) {
          $no_spbs = "";
        }else{
          $no_spbs = "AND mtrh.request_number LIKE '%$spbs_num%'";
        }

        if ($subname==FALSE) {
          $subkon = "";
        }else{
          $subkon = "AND pov.vendor_name LIKE '%$subname%'";
        }

        if ($job==FALSE) {
          $w_job_1 = "";
          $w_job_2 = "";
        }else{
          $w_job_1 = "AND gbh.batch_no LIKE '%$job%'";
          $w_job_2 = "AND we.wip_entity_name LIKE '%$job%'";
        }

                



        $sql = "SELECT pov.vendor_name nama_subkon, 
          knm.no_mobil,
          mtrh.request_number no_spbs,
          mtrl.line_number,
         gbh.batch_no no_job,
         mtrh.creation_date tgl_spbs,
         tmp.tgl_terima, 
         tmp.tgl_mulai tgl_kirim, 
         msib.segment1 item_code,
         msib.description item_desc,
         NVL (mmtt.transaction_quantity, mtrl.quantity) qty_diminta,
         tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
         NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
         tmp.tgl_mulai, 
         tmp.tgl_selesai,
         TO_CHAR(tmp.tgl_mulai,'HH24:MI:SS') jam_mulai,
         TO_CHAR(tmp.tgl_selesai,'HH24:MI:SS') jam_selesai,
         ROUND (((tmp.tgl_selesai - tmp.tgl_mulai) * 1440), 2) lama,
         ROUND
            (AVG ((tmp.tgl_selesai - tmp.tgl_mulai) * 1440) OVER (PARTITION BY tmp.subinv, pov.vendor_name),
             2
            ) average,
         CASE
            WHEN mtrl.line_status = 5
            AND mtrl.quantity_delivered IS NULL
               THEN 'B'
            WHEN mtrl.line_status = 5 AND mtrl.quantity_delivered IS NOT NULL
               THEN 'O'
            ELSE 'X'
         END keterangan,
         TO_CHAR(mmt.transaction_date,'DD-MON-YYYY HH24:MI:SS') transaction_date
    FROM mtl_txn_request_headers mtrh,
         mtl_txn_request_lines mtrl,
         mtl_material_transactions_temp mmtt,
         mtl_material_transactions mmt,
         mtl_system_items_b msib,
         po_requisition_lines_all prl,
         po_headers_all poh,
         po_distributions_all pod,
         po_req_distributions_all pord,
         po_vendors pov,
         khs_no_mobil knm,
         gme_batch_header gbh,
         (SELECT NVL (kmgk.no_spbs, kmtb.no_spbs) no_spbs, kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs = kmgk.no_spbs(+)
          UNION
          SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs(+) = kmgk.no_spbs) tmp
   WHERE mtrh.header_id = mtrl.header_id
     AND mtrl.line_id = mmtt.move_order_line_id(+)
     AND mtrl.line_id = mmt.move_order_line_id(+)
     AND mtrl.inventory_item_id = msib.inventory_item_id
     AND mtrl.organization_id = msib.organization_id
     AND tmp.no_spbs = mtrh.request_number
     AND NVL (tmp.line_id, mtrl.line_id) = mtrl.line_id
     AND mtrl.txn_source_id = gbh.batch_id
     AND SUBSTR (prl.reference_num, 10, 10) = gbh.batch_no
     AND prl.requisition_line_id(+) = pord.requisition_line_id
     AND pord.distribution_id(+) = pod.req_distribution_id
     AND pod.po_header_id(+) = poh.po_header_id
     AND poh.vendor_id = pov.vendor_id
     AND knm.vendor_id = poh.vendor_id
     AND (mmt.transaction_quantity IS NULL OR mmt.transaction_quantity < 0)
     $spbs_date --
     $send_date --
     $no_spbs --
     $subkon --
     $w_job_1 --
UNION
SELECT   pov.vendor_name nama_subkon, 
         knm.no_mobil,
         mtrh.request_number no_spbs, 
         mtrl.line_number,
         we.wip_entity_name NO_JOB, 
         mtrh.creation_date tgl_spbs,
         tmp.tgl_terima, 
         tmp.tgl_mulai tgl_kirim, 
         msib.segment1 item_code,
         msib.description item_desc,
         NVL (mmtt.transaction_quantity, mtrl.quantity) qty_diminta,
         tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
         NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
         tmp.tgl_mulai, 
         tmp.tgl_selesai,
         TO_CHAR(tmp.tgl_mulai,'HH24:MI:SS') jam_mulai,
        TO_CHAR(tmp.tgl_selesai,'HH24:MI:SS') jam_selesai,
         ROUND (((tmp.tgl_selesai - tmp.tgl_mulai) * 1440), 2) lama,
         ROUND
            (AVG ((tmp.tgl_selesai - tmp.tgl_mulai) * 1440) OVER (PARTITION BY tmp.subinv, pov.vendor_name),
             2
            ) average,
         CASE
            WHEN mtrl.line_status = 5
            AND mtrl.quantity_delivered IS NULL
               THEN 'B'
            WHEN mtrl.line_status = 5 AND mtrl.quantity_delivered IS NOT NULL
               THEN 'O'
            ELSE 'X'
         END keterangan,
         TO_CHAR(mmt.transaction_date,'DD-MON-YYYY HH24:MI:SS') transaction_date
    FROM mtl_txn_request_headers mtrh,
         mtl_txn_request_lines mtrl,
         mtl_material_transactions_temp mmtt,
         mtl_material_transactions mmt,
         mtl_system_items_b msib,
         po_requisition_lines_all prl,
         wip_entities we,
         po_headers_all poh,
         po_distributions_all pod,
         po_req_distributions_all pord,
         po_vendors pov,
         khs_no_mobil knm,
         (SELECT NVL (kmgk.no_spbs, kmtb.no_spbs) no_spbs, kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs = kmgk.no_spbs(+)
          UNION
          SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs(+) = kmgk.no_spbs) tmp
   WHERE mtrh.header_id = mtrl.header_id
     AND mtrl.line_id = mmtt.move_order_line_id(+)
     AND mtrl.line_id = mmt.move_order_line_id(+)
     AND mtrl.inventory_item_id = msib.inventory_item_id
     AND mtrl.organization_id = msib.organization_id
     AND tmp.no_spbs = mtrh.request_number
     AND NVL (tmp.line_id, mtrl.line_id) = mtrl.line_id
     AND mtrl.txn_source_id = we.wip_entity_id
     AND prl.wip_entity_id = we.wip_entity_id
     AND prl.requisition_line_id(+) = pord.requisition_line_id
     AND pord.distribution_id(+) = pod.req_distribution_id
     AND pod.po_header_id(+) = poh.po_header_id
     AND poh.vendor_id = pov.vendor_id
     AND knm.vendor_id = poh.vendor_id
     AND (mmt.transaction_quantity IS NULL OR mmt.transaction_quantity < 0)
     $spbs_date --
     $send_date --
     $no_spbs --
     $subkon --
     $w_job_2 --
UNION
SELECT   pov.vendor_name nama_subkon, 
         knm.no_mobil,
         mtrh.request_number no_spbs,
         mtrl.line_number,
         gbh.batch_no NO_JOB, 
         mtrh.creation_date tgl_spbs,
         tmp.tgl_terima, 
         tmp.tgl_mulai tgl_kirim, 
         msib.segment1 item_code,
         msib.description item_desc,
         NVL (mmtt.transaction_quantity, mtrl.quantity) qty_diminta,
         tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
         NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
         tmp.tgl_mulai, 
         tmp.tgl_selesai,
         TO_CHAR(tmp.tgl_mulai,'HH24:MI:SS') jam_mulai,
        TO_CHAR(tmp.tgl_selesai,'HH24:MI:SS') jam_selesai,
         ROUND (((tmp.tgl_selesai - tmp.tgl_mulai) * 1440), 2) lama,
         ROUND
            (AVG ((tmp.tgl_selesai - tmp.tgl_mulai) * 1440) OVER (PARTITION BY tmp.subinv, pov.vendor_name),
             2
            ) average,
         CASE
            WHEN mtrl.line_status = 5
            AND mtrl.quantity_delivered IS NULL
               THEN 'B'
            WHEN mtrl.line_status = 5 AND mtrl.quantity_delivered IS NOT NULL
               THEN 'O'
            ELSE 'X'
         END keterangan,
         TO_CHAR(mmt.transaction_date,'DD-MON-YYYY HH24:MI:SS') transaction_date
    FROM mtl_txn_request_headers mtrh,
         mtl_txn_request_lines mtrl,
         mtl_material_transactions_temp mmtt,
         mtl_material_transactions mmt,
         mtl_system_items_b msib,
         po_requisition_lines_all prl,
         po_headers_all poh,
         po_distributions_all pod,
         po_req_distributions_all pord,
         po_vendors pov,
         khs_no_mobil knm,
         gme_batch_header gbh,
         (SELECT DISTINCT fcr.argument1 spbs_dari, fcr.argument2 spbs_sampai,
                          fcr.argument3 no_po
                     FROM fnd_concurrent_requests fcr
                    WHERE fcr.concurrent_program_id in (142629,434696)) komb,
         (SELECT NVL (kmgk.no_spbs, kmtb.no_spbs) no_spbs, kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs = kmgk.no_spbs(+)
          UNION
          SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs(+) = kmgk.no_spbs) tmp
   WHERE mtrh.header_id = mtrl.header_id
     AND mtrh.request_number BETWEEN komb.spbs_dari AND komb.spbs_sampai
     AND mtrl.line_id = mmtt.move_order_line_id(+)
     AND mtrl.line_id = mmt.move_order_line_id(+)
     AND mtrl.inventory_item_id = msib.inventory_item_id
     AND mtrl.organization_id = msib.organization_id
     AND tmp.no_spbs = mtrh.request_number
     AND NVL (tmp.line_id, mtrl.line_id) = mtrl.line_id
     AND poh.segment1 = komb.no_po
     AND mtrl.txn_source_id = gbh.batch_id
     AND prl.requisition_line_id(+) = pord.requisition_line_id
     AND pord.distribution_id(+) = pod.req_distribution_id
     AND pod.po_header_id(+) = poh.po_header_id
     AND poh.vendor_id = pov.vendor_id
     AND knm.vendor_id = poh.vendor_id
     AND (mmt.transaction_quantity IS NULL OR mmt.transaction_quantity < 0)
     $spbs_date --
     $send_date --
     $no_spbs --
     $subkon --
     $w_job_1 --
UNION
SELECT   pov.vendor_name nama_subkon, 
         knm.no_mobil,
         mtrh.request_number no_spbs, 
         mtrl.line_number,
         we.wip_entity_name NO_JOB, 
         mtrh.creation_date tgl_spbs,
         tmp.tgl_terima, 
         tmp.tgl_mulai tgl_kirim, 
         msib.segment1 item_code,
         msib.description item_desc,
         NVL (mmtt.transaction_quantity, mtrl.quantity) qty_diminta,
         tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
         NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
         tmp.tgl_mulai, 
         tmp.tgl_selesai,
         TO_CHAR(tmp.tgl_mulai,'HH24:MI:SS') jam_mulai,
        TO_CHAR(tmp.tgl_selesai,'HH24:MI:SS') jam_selesai,
         ROUND (((tmp.tgl_selesai - tmp.tgl_mulai) * 1440), 2) lama,
         --ROUND (((tmp.tgl_selesai - tmp.tgl_mulai) * 1440), 2) lama,
         ROUND
            (AVG ((tmp.tgl_selesai - tmp.tgl_mulai) * 1440) OVER (PARTITION BY tmp.subinv, pov.vendor_name),
             2
            ) average,
         CASE
            WHEN mtrl.line_status = 5
            AND mtrl.quantity_delivered IS NULL
               THEN 'B'
            WHEN mtrl.line_status = 5 AND mtrl.quantity_delivered IS NOT NULL
               THEN 'O'
            ELSE 'X'
         END keterangan,
         TO_CHAR(mmt.transaction_date,'DD-MON-YYYY HH24:MI:SS') transaction_date
    FROM mtl_txn_request_headers mtrh,
         mtl_txn_request_lines mtrl,
         mtl_material_transactions_temp mmtt,
         mtl_material_transactions mmt,
         mtl_system_items_b msib,
         po_requisition_lines_all prl,
         po_headers_all poh,
         po_distributions_all pod,
         po_req_distributions_all pord,
         po_vendors pov,
         khs_no_mobil knm,
         wip_entities we,
         (SELECT DISTINCT fcr.argument1 spbs_dari, fcr.argument2 spbs_sampai,
                          fcr.argument3 no_po
                     FROM fnd_concurrent_requests fcr
                    WHERE fcr.concurrent_program_id in (142629,434696)) komb,
         (SELECT NVL (kmgk.no_spbs, kmtb.no_spbs) no_spbs, kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs = kmgk.no_spbs(+)
          UNION
          SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
                 kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
                 kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
                 kmtb.tgl_terima
            FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk
           WHERE kmtb.no_spbs(+) = kmgk.no_spbs) tmp
   WHERE mtrh.header_id = mtrl.header_id
     AND mtrh.request_number BETWEEN komb.spbs_dari AND komb.spbs_sampai
     AND mtrl.line_id = mmtt.move_order_line_id(+)
     AND mtrl.line_id = mmt.move_order_line_id(+)
     AND mtrl.inventory_item_id = msib.inventory_item_id
     AND mtrl.organization_id = msib.organization_id
     AND tmp.no_spbs = mtrh.request_number
     AND NVL (tmp.line_id, mtrl.line_id) = mtrl.line_id
     AND poh.segment1 = komb.no_po
     AND prl.requisition_line_id(+) = pord.requisition_line_id
     AND pord.distribution_id(+) = pod.req_distribution_id
     AND pod.po_header_id(+) = poh.po_header_id
     AND poh.vendor_id = pov.vendor_id
     AND knm.vendor_id = poh.vendor_id
     AND (mmt.transaction_quantity IS NULL OR mmt.transaction_quantity < 0)
     AND mtrl.txn_source_id = we.wip_entity_id
     AND prl.wip_entity_id = we.wip_entity_id
     $spbs_date --
     $send_date --
     $no_spbs --
     $subkon --
     $w_job_2 --
ORDER BY 3, 4 ASC";


        // echo "<pre>";
        // echo $sql;
        // exit();

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

}
?>