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
     AND NVL (mmtt.subinventory_code, mmt.subinventory_code) = 'BLK-DM'