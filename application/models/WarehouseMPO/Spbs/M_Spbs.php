<?php defined('BASEPATH') OR die('No direct script access allowed');

class M_Spbs extends CI_Model
{
	var $oracle;
	function __construct()
	{
		parent::__construct();
		$this->load->database();
      $this->load->library('encrypt');
      $this->oracle = $this->load->database('oracle', true);
   }
   
   function insertData($NO_SPBS, $INVENTORY_ITEM_ID, $TGL_MULAI, $TGL_SELESAI, $NO_MOBIL) {
      $sql = "INSERT INTO khs_mon_gdg_keluar (no_spbs, inventory_item_id, tgl_mulai, tgl_selesai, no_mobil)
      values ('$NO_SPBS', '$INVENTORY_ITEM_ID', TO_DATE('$TGL_MULAI', 'yyyy/mm/dd hh24:mi:ss'), TO_DATE('$TGL_SELESAI', 'yyyy/mm/dd hh24:mi:ss'), '$NO_MOBIL')";
      $this->oracle->query($sql);
   }

    function getNomorCar()
    {
        $oracle = $this->load->database('oracle',TRUE);
        $sql = "SELECT knm.* FROM khs_no_mobil knm";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    function updateData($NO_SPBS,$INVENTORY_ITEM_ID,$NO_MOBIL,$date_start,$date_end,$QTY_KIRIM) {
      $oracle = $this->load->database('oracle',TRUE);
      $sql = 'UPDATE "KHS_MON_GDG_KELUAR" SET "NO_SPBS" = '.$NO_SPBS.',
         "INVENTORY_ITEM_ID" = '.$INVENTORY_ITEM_ID.', "TGL_MULAI" = TO_DATE(\''.$date_start.'\', \'YYYY/MM/DD HH:Mi:ss\'),
         "TGL_SELESAI" = TO_DATE(\''.$date_end.'\', \'YYYY/MM/DD HH:Mi:ss\') , "NO_MOBIL" = \''.$NO_MOBIL.'\',
         "QTY_KIRIM" = \''.$QTY_KIRIM.'\'
         WHERE "NO_SPBS" = '.$NO_SPBS.' AND "INVENTORY_ITEM_ID" = '.$INVENTORY_ITEM_ID;
         // echo $sql;exit;
         // print_r($sql);exit;
      $oracle->query($sql);
   }
   
   function updateDataKet($KETERANGAN,$NO_SPBS,$INVENTORY_ITEM_ID) {
//       $oracle = $this->load->database('oracle',TRUE);
//       $sql = "begin khs_mon_gdg_keluar_ext_p('.$KETERANGAN.','.$NO_SPBS.','.$INVENTORY_ITEM_ID.')   
//   end;";
//          // echo $sql;exit;
//       $oracle->query($sql);

      // $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');

// echo "<pre>";
// print_r($KETERANGAN);
// exit();

      $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
        if (!$conn) {
             $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        
      $sql =  "begin khs_mon_gdg_keluar_ext_p(:P_PARAM1,:P_PARAM2,:P_PARAM3); END;";

      //Statement does not change
      $stmt = oci_parse($conn,$sql);                     
      oci_bind_by_name($stmt,':P_PARAM1',$NO_SPBS);
      oci_bind_by_name($stmt,':P_PARAM2',$INVENTORY_ITEM_ID);
      oci_bind_by_name($stmt,':P_PARAM3',$KETERANGAN);
//---
    // if (!$data) {
    // $e = oci_error($conn);  // For oci_parse errors pass the connection handle
    // trigger_error(htmlentities($e['message']), E_USER_ERROR);
    // }
//---
      // But BEFORE statement, Create your cursor
      $cursor = oci_new_cursor($conn);
      
      // Execute the statement as in your first try
      oci_execute($stmt);
      
      // and now, execute the cursor
      oci_execute($cursor);
   }

	function getWarehouse()
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT distinct msi.SECONDARY_INVENTORY_NAME subinv from
mtl_secondary_inventories msi where msi.ORGANIZATION_ID IN (102,386,486,101)
and msi.DISABLE_DATE is null order by 1";
		$query = $oracle->query($sql);
      return $query->result_array();
	}

    function getSubkont()
    {
        $oracle = $this->load->database('oracle',TRUE);
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
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    //--------------------------------------------------------------------- SEARCH ------------------------------------------ //

	function search($warehouseQ)
    {
    $oracle = $this->load->database('oracle',TRUE);
    $sql2 = "SELECT * FROM KHS_MON_GDG_KELUAR ";
   //  $sql2 = "SELECT * FROM osp.osp_testing_mpo ";
    $sql = "SELECT pov.vendor_name nama_subkon, 
    knm.no_mobil,
    mtrh.request_number no_spbs,
    mtrl.line_number,
   gbh.batch_no no_job,
   mtrh.creation_date tgl_spbs,
   tmp.tgl_terima,
   tmp.inventory_item_id, 
   tmp.tgl_mulai tgl_kirim, 
   msib.segment1 item_code,
   msib.description item_desc,
   decode(tmp.qty_kirim,'',NVL (mmtt.transaction_quantity, mtrl.quantity),tmp.qty_kirim) qty_diminta,
   tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
   NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
   tmp.tgl_mulai, 
   tmp.tgl_selesai,
   tmp.keterangan,
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
           kmtb.tgl_terima, kmgx.KETERANGAN
      FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk, khs_mon_gdg_keluar_ext kmgx
     WHERE kmtb.no_spbs = kmgk.no_spbs(+)
     AND kmgx.NO_SPBS = kmgk.NO_SPBS
    UNION
    SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
           kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
           kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
           kmtb.tgl_terima, kmgx.KETERANGAN
      FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk, khs_mon_gdg_keluar_ext kmgx
     WHERE kmtb.no_spbs(+) = kmgk.no_spbs
     AND kmgx.NO_SPBS = kmgk.NO_SPBS) tmp
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
-- AND NVL (mmtt.subinventory_code, mmt.subinventory_code) = 'BLK-DM'
$warehouseQ
UNION
--part dua
SELECT   pov.vendor_name nama_subkon, 
   knm.no_mobil,
   mtrh.request_number no_spbs, 
   mtrl.line_number,
   we.wip_entity_name NO_JOB, 
   mtrh.creation_date tgl_spbs,
   tmp.tgl_terima,
   tmp.inventory_item_id, 
   tmp.tgl_mulai tgl_kirim, 
   msib.segment1 item_code,
   msib.description item_desc,
   decode(tmp.qty_kirim,'',NVL (mmtt.transaction_quantity, mtrl.quantity),tmp.qty_kirim) qty_diminta,
   tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
   NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
   tmp.tgl_mulai, 
   tmp.tgl_selesai,
   tmp.keterangan,
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
           kmtb.tgl_terima, kmgx.KETERANGAN
      FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk, khs_mon_gdg_keluar_ext kmgx
     WHERE kmtb.no_spbs = kmgk.no_spbs(+)
     AND kmgx.NO_SPBS = kmgk.NO_SPBS
    UNION
    SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
           kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
           kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
           kmtb.tgl_terima, kmgx.KETERANGAN
      FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk, khs_mon_gdg_keluar_ext kmgx
     WHERE kmtb.no_spbs(+) = kmgk.no_spbs
     AND kmgx.NO_SPBS = kmgk.NO_SPBS) tmp
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
--AND NVL (mmtt.subinventory_code, mmt.subinventory_code) = 'BLK-DM'
$warehouseQ
UNION
--part tiga
SELECT   pov.vendor_name nama_subkon, 
   knm.no_mobil,
   mtrh.request_number no_spbs,
   mtrl.line_number,
   gbh.batch_no NO_JOB, 
   mtrh.creation_date tgl_spbs,
   tmp.tgl_terima,
   tmp.inventory_item_id, 
   tmp.tgl_mulai tgl_kirim, 
   msib.segment1 item_code,
   msib.description item_desc,
   decode(tmp.qty_kirim,'',NVL (mmtt.transaction_quantity, mtrl.quantity),tmp.qty_kirim) qty_diminta,
   tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
   NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
   tmp.tgl_mulai, 
   tmp.tgl_selesai,
   tmp.keterangan,
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
           kmtb.tgl_terima, kmgx.KETERANGAN
      FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk, khs_mon_gdg_keluar_ext kmgx
     WHERE kmtb.no_spbs = kmgk.no_spbs(+)
     AND kmgx.NO_SPBS = kmgk.NO_SPBS
    UNION
    SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
           kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
           kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
           kmtb.tgl_terima, kmgx.KETERANGAN
      FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk, khs_mon_gdg_keluar_ext kmgx
     WHERE kmtb.no_spbs(+) = kmgk.no_spbs
     AND kmgx.NO_SPBS = kmgk.NO_SPBS) tmp
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
--AND NVL (mmtt.subinventory_code, mmt.subinventory_code) = 'BLK-DM'
$warehouseQ
UNION
--part empat
SELECT   pov.vendor_name nama_subkon, 
   knm.no_mobil,
   mtrh.request_number no_spbs, 
   mtrl.line_number,
   we.wip_entity_name NO_JOB, 
   mtrh.creation_date tgl_spbs,
   tmp.tgl_terima,
   tmp.inventory_item_id, 
   tmp.tgl_mulai tgl_kirim, 
   msib.segment1 item_code,
   msib.description item_desc,
   decode(tmp.qty_kirim,'',NVL (mmtt.transaction_quantity, mtrl.quantity),tmp.qty_kirim) qty_diminta,
   tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
   NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
   tmp.tgl_mulai, 
   tmp.tgl_selesai,
   tmp.keterangan,
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
           kmtb.tgl_terima, kmgx.KETERANGAN
      FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk, khs_mon_gdg_keluar_ext kmgx
     WHERE kmtb.no_spbs = kmgk.no_spbs(+)
     AND kmgx.NO_SPBS = kmgk.NO_SPBS
    UNION
    SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
           kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
           kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
           kmtb.tgl_terima, kmgx.KETERANGAN
      FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk, khs_mon_gdg_keluar_ext kmgx
     WHERE kmtb.no_spbs(+) = kmgk.no_spbs
     AND kmgx.NO_SPBS = kmgk.NO_SPBS) tmp
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
--     AND NVL (mmtt.subinventory_code, mmt.subinventory_code) = 'BLK-DM'
$warehouseQ
ORDER BY 6 DESC";

    // $query = $this->db->query($sql);
    $query = $oracle->query($sql);
    return $query->result_array();
   //return $sql;
    }

    //---------------------------------------------------------------- FILTER SEARCH ------------------------------------------ //

    function filterSearch($warehouseQ, $spbsQ, $kirimQ, $nomorSpbsQ, $namaSubQ, $queryJob1, $queryJob2, $komponenQ)
    {
        $oracle = $this->load->database('oracle',TRUE);
        $sql ="SELECT pov.vendor_name nama_subkon, 
        tmp.plat NO_MOBIL,
        mtrh.request_number no_spbs,
        mtrl.line_number,
       gbh.batch_no no_job,
       mtrh.creation_date tgl_spbs,
       tmp.tgl_terima, 
       tmp.inventory_item_id, 
       tmp.tgl_mulai tgl_kirim, 
       msib.segment1 item_code,
       msib.description item_desc,
       NVL (mmtt.transaction_quantity, mtrl.quantity) qty_diminta,
       tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
       NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
       tmp.tgl_mulai, 
       tmp.tgl_selesai,
       tmp.ktr keterangan ,
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
       END keterangan2,
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
         kmtb.tgl_terima, kmgx.KETERANGAN ktr, kmgk.no_mobil plat
    FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk, khs_mon_gdg_keluar_ext kmgx
   WHERE kmtb.no_spbs = kmgk.no_spbs(+)
   AND kmgx.NO_SPBS = kmgk.NO_SPBS
  UNION
  SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
         kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
         kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
         kmtb.tgl_terima, kmgx.KETERANGAN ktr, kmgk.no_mobil plat
    FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk, khs_mon_gdg_keluar_ext kmgx
   WHERE kmtb.no_spbs(+) = kmgk.no_spbs
   AND kmgx.NO_SPBS = kmgk.NO_SPBS) tmp
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
   $spbsQ --
   $kirimQ --
   $nomorSpbsQ --
   $namaSubQ --
   $queryJob2 --
   $warehouseQ --
   $komponenQ --
UNION
SELECT   pov.vendor_name nama_subkon, 
       tmp.plat NO_MOBIL,
       mtrh.request_number no_spbs, 
       mtrl.line_number,
       we.wip_entity_name NO_JOB, 
       mtrh.creation_date tgl_spbs,
       tmp.tgl_terima, 
       tmp.inventory_item_id, 
       tmp.tgl_mulai tgl_kirim, 
       msib.segment1 item_code,
       msib.description item_desc,
       NVL (mmtt.transaction_quantity, mtrl.quantity) qty_diminta,
       tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
       NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
       tmp.tgl_mulai, 
       tmp.tgl_selesai,
       tmp.ktr keterangan,
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
       END keterangan2,
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
         kmtb.tgl_terima, kmgx.KETERANGAN ktr, kmgk.no_mobil plat
    FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk, khs_mon_gdg_keluar_ext kmgx
   WHERE kmtb.no_spbs = kmgk.no_spbs(+)
   AND kmgx.NO_SPBS = kmgk.NO_SPBS
  UNION
  SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
         kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
         kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
         kmtb.tgl_terima, kmgx.KETERANGAN ktr, kmgk.no_mobil plat
    FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk, khs_mon_gdg_keluar_ext kmgx
   WHERE kmtb.no_spbs(+) = kmgk.no_spbs
   AND kmgx.NO_SPBS = kmgk.NO_SPBS) tmp
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
   $spbsQ --
   $kirimQ --
   $nomorSpbsQ --
   $namaSubQ --
   $queryJob2 --
   $warehouseQ --
   $komponenQ --
UNION
SELECT   pov.vendor_name nama_subkon, 
       tmp.plat NO_MOBIL,
       mtrh.request_number no_spbs,
       mtrl.line_number,
       gbh.batch_no NO_JOB, 
       mtrh.creation_date tgl_spbs,
       tmp.tgl_terima, 
       tmp.inventory_item_id, 
       tmp.tgl_mulai tgl_kirim, 
       msib.segment1 item_code,
       msib.description item_desc,
       NVL (mmtt.transaction_quantity, mtrl.quantity) qty_diminta,
       tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
       NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
       tmp.tgl_mulai, 
       tmp.tgl_selesai,
       tmp.ktr keterangan,
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
       END keterangan2,
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
         kmtb.tgl_terima, kmgx.KETERANGAN ktr, kmgk.NO_MOBIL plat
    FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk, khs_mon_gdg_keluar_ext kmgx
   WHERE kmtb.no_spbs = kmgk.no_spbs(+)
   AND kmgx.NO_SPBS = kmgk.NO_SPBS
  UNION
  SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
         kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
         kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
         kmtb.tgl_terima, kmgx.KETERANGAN ktr, kmgk.NO_MOBIL plat
    FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk, khs_mon_gdg_keluar_ext kmgx
   WHERE kmtb.no_spbs(+) = kmgk.no_spbs
   AND kmgx.NO_SPBS = kmgk.NO_SPBS) tmp
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
   $spbsQ --
   $kirimQ --
   $nomorSpbsQ --
   $namaSubQ --
   $queryJob2 --
   $warehouseQ --
   $komponenQ --
UNION
SELECT   pov.vendor_name nama_subkon, 
       tmp.plat NO_MOBIL,
       mtrh.request_number no_spbs, 
       mtrl.line_number,
       we.wip_entity_name NO_JOB, 
       mtrh.creation_date tgl_spbs,
       tmp.tgl_terima, 
       tmp.inventory_item_id, 
       tmp.tgl_mulai tgl_kirim, 
       msib.segment1 item_code,
       msib.description item_desc,
       NVL (mmtt.transaction_quantity, mtrl.quantity) qty_diminta,
       tmp.qty_kirim, NVL (mmtt.transaction_uom, mtrl.uom_code) uom,
       NVL (mmtt.subinventory_code, mmt.subinventory_code) subinv,
       tmp.tgl_mulai, 
       tmp.tgl_selesai,
       tmp.ktr keterangan,
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
       END keterangan2,
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
         kmtb.tgl_terima, kmgx.KETERANGAN ktr, kmgk.no_mobil plat
    FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk, khs_mon_gdg_keluar_ext kmgx
   WHERE kmtb.no_spbs = kmgk.no_spbs(+)
   AND kmgx.NO_SPBS = kmgk.NO_SPBS
  UNION
  SELECT NVL (kmgk.no_spbs, kmtb.no_spbs), kmgk.line_id,
         kmgk.no_mobil, kmgk.inventory_item_id, kmgk.tgl_mulai,
         kmgk.tgl_selesai, kmgk.qty_kirim, kmgk.subinv,
         kmtb.tgl_terima, kmgx.KETERANGAN ktr, kmgk.NO_MOBIL plat
    FROM khs_mon_terima_barang kmtb, khs_mon_gdg_keluar kmgk, khs_mon_gdg_keluar_ext kmgx
   WHERE kmtb.no_spbs(+) = kmgk.no_spbs
   AND kmgx.NO_SPBS = kmgk.NO_SPBS) tmp
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
   $spbsQ --
   $kirimQ --
   $nomorSpbsQ --
   $namaSubQ --
   $queryJob2 --
   $warehouseQ --
   $komponenQ --

--part lima (insert query)


ORDER BY 6 DESC";
    $query = $oracle->query($sql);
    return $query->result_array();
   //  return $sql;
    }

   //  function gabunganData(){
   //    $oracle = $this->load->database('oracle',TRUE);
   //    $sql ="SELECT DISTINCT * FROM KHS_MON_GDG_KELUAR"
   //    // $query = $oracle->query($sql);
   //    return $query->result_array();
   //  }
 // tutup class
   }
?>