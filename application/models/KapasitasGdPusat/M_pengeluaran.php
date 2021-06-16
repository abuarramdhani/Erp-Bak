<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_Pengeluaran extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();    
        $this->oracle = $this->load->database('oracle', true);
        // $this->oracle = $this->load->database('oracle_dev', true);
    }

//--------------------------------------------- Menu PENGELUARAN ---------------------------------------------
    
    public function getCek($subinv, $no_dokumen){
        $sql = "SELECT   mtrh.request_number no_dokumen, msib.segment1 kode_item,
        msib.description, mtrl.quantity, mtrl.from_subinventory_code,
        'PICKLIST' jenis_dokumen
   FROM mtl_txn_request_headers mtrh,
        mtl_txn_request_lines mtrl,
        mtl_system_items_b msib
  WHERE mtrh.header_id = mtrl.header_id
    AND mtrl.organization_id = msib.organization_id
    AND mtrl.inventory_item_id = msib.inventory_item_id
    AND mtrh.request_number LIKE 'D%'
    AND mtrh.request_number = '$no_dokumen'
    AND mtrl.from_subinventory_code = '$subinv'
UNION
SELECT   mtrh.request_number no_dokumen, msib.segment1 kode_item,
        msib.description, mtrl.quantity, mtrl.from_subinventory_code,
        'MO' jenis_dokumen
   FROM mtl_txn_request_headers mtrh,
        mtl_txn_request_lines mtrl,
        mtl_system_items_b msib
  WHERE mtrh.header_id = mtrl.header_id
    AND mtrl.organization_id = msib.organization_id
    AND mtrl.inventory_item_id = msib.inventory_item_id
    AND mtrh.request_number NOT LIKE 'D%'
    AND mtrh.request_number = '$no_dokumen'
    AND mtrl.from_subinventory_code = '$subinv'
UNION
SELECT   TO_CHAR (imb.no_bon) no_dokumen, imb.kode_barang kode_item,
        imb.nama_barang description, TO_NUMBER (imb.permintaan) quantity,
        imb.tujuan_gudang from_subinventory_code, 'BON' jenis_dokumen
   FROM im_master_bon imb
  WHERE TO_CHAR (imb.no_bon) = '$no_dokumen'
        AND imb.tujuan_gudang = '$subinv'
UNION
SELECT   mmt.shipment_number no_dokumen, msib.segment1 kode_item,
        msib.description, mmt.transaction_quantity * -1 qty,
        mmt.subinventory_code from_subinventory_code, 'IO' jenis_dokumen
   FROM mtl_material_transactions mmt, mtl_system_items_b msib
  WHERE msib.inventory_item_id = mmt.inventory_item_id
    AND msib.organization_id = mmt.organization_id
    AND mmt.shipment_number = '$no_dokumen'
    AND mmt.transaction_type_id = 21 -- Intransit Shipment
    AND mmt.organization_id IN (102, 225)
    AND mmt.subinventory_code = '$subinv'
UNION
SELECT   mtrh.request_number no_dokumen, msib.segment1 kode_item,
        msib.description, mtrl.quantity qty,
        mmt.subinventory_code from_subinventory_code, 'DO' jenis_dokumen
   FROM mtl_txn_request_headers mtrh,
        mtl_txn_request_lines mtrl,
        mtl_system_items_b msib,
        mtl_material_transactions mmt,
        wsh_delivery_details wdd
  WHERE mtrh.header_id = mtrl.header_id
    AND mtrl.organization_id = msib.organization_id
    AND mtrl.inventory_item_id = msib.inventory_item_id
    AND mmt.move_order_line_id = mtrl.line_id
    AND mmt.inventory_item_id = msib.inventory_item_id
    AND mmt.organization_id = msib.organization_id
    AND TO_CHAR (wdd.batch_id) = mtrh.request_number
    AND wdd.move_order_line_id = mtrl.line_id
    AND mmt.transaction_quantity LIKE '-%'
    AND mtrh.request_number = '$no_dokumen'
    AND mmt.subinventory_code = '$subinv'
ORDER BY 1, 2";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function cekdokumen($subinv, $no_dokumen){
        $sql = "SELECT no_dokumen
        FROM khs_inv_kapasitas_gudang_pusat
       WHERE no_dokumen LIKE '%$no_dokumen%'
         AND gudang = '$subinv'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function save($data){
        $sql = "INSERT INTO khs_inv_kapasitas_gudang_pusat
        (no_dokumen, jenis_dokumen, gudang,
         item, description, qty,
         creation_date
        )
 VALUES ('$data[NO_DOKUMEN]', '$data[JENIS_DOKUMEN]', '$data[GUDANG]',
         '$data[ITEM]', '$data[DESC]', $data[QTY],
         TO_DATE ('$data[CREATION_DATE]', 'YYYY/MM/DD HH24:MI:SS')
        )";
        $query = $this->oracle->query($sql);
        $query2 = $this->oracle->query("commit");
    }

    public function getData(){
        $sql = "SELECT   kikgp.no_dokumen, kikgp.jenis_dokumen, kikgp.gudang,
        COUNT (kikgp.item) jumlah_item, kikgp.creation_date, kikgp.pic,
        TO_CHAR (kikgp.mulai, 'YYYY-MM-DD HH24:MI:SS') mulai,
        TO_CHAR (kikgp.mulai, 'HH24:MI:SS') jam_mulai, kikgp.selesai,
        kikgp.waktu
   FROM khs_inv_kapasitas_gudang_pusat kikgp
  WHERE kikgp.selesai IS NULL
GROUP BY kikgp.no_dokumen,
        kikgp.jenis_dokumen,
        kikgp.gudang,
        kikgp.creation_date,
        kikgp.pic,
        TO_CHAR (kikgp.mulai, 'YYYY-MM-DD HH24:MI:SS'),
        TO_CHAR (kikgp.mulai, 'HH24:MI:SS'),
        kikgp.selesai,
        kikgp.waktu";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getPIC($term){
        $sql = "SELECT   pic
        FROM khs_tabel_user
       WHERE pic LIKE '%$term%'
    UNION
    SELECT   pic
        FROM khs_operator_pelayan
       WHERE pic LIKE '%$term%'
    ORDER BY 1";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function cekMulai($no_dokumen, $jenis_dokumen) {
        $sql = "SELECT *
        FROM khs_inv_kapasitas_gudang_pusat
       WHERE no_dokumen = '$no_dokumen' AND jenis_dokumen = '$jenis_dokumen'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function SavePengeluaran($date, $jenis_dokumen, $no_dokumen, $pic){
        $sql="UPDATE khs_inv_kapasitas_gudang_pusat
        SET mulai = TO_TIMESTAMP ('$date', 'DD-MM-YYYY HH24:MI:SS'),
            pic = '$pic'
      WHERE jenis_dokumen = '$jenis_dokumen' AND no_dokumen = '$no_dokumen'";
        $query = $this->oracle->query($sql);         
        $query2 = $this->oracle->query('commit');          
        echo $sql; 
    }

    public function SelesaiPengeluaran($date, $jenis_dokumen, $no_dokumen, $waktu, $pic){
        $sql="UPDATE khs_inv_kapasitas_gudang_pusat
        SET selesai = TO_TIMESTAMP ('$date', 'DD-MM-YYYY HH24:MI:SS'),
            waktu = '$waktu',
            pic = '$pic'
      WHERE jenis_dokumen = '$jenis_dokumen' AND no_dokumen = '$no_dokumen'";
        $query = $this->oracle->query($sql);            
        $query2 = $this->oracle->query('commit');       
        echo $sql; 
    }

    public function deleteDokumen($jenis_dokumen, $no_dokumen){
        $sql=" DELETE FROM khs_inv_kapasitas_gudang_pusat
      WHERE jenis_dokumen = '$jenis_dokumen' AND no_dokumen = '$no_dokumen'";
        $query = $this->oracle->query($sql);            
        $query2 = $this->oracle->query('commit');       
        echo $sql; 
    }

    public function dataDetail($no_dokumen){
        $sql = "SELECT   no_dokumen, item, description, qty, pic
        FROM khs_inv_kapasitas_gudang_pusat
       WHERE no_dokumen = '$no_dokumen'
    ORDER BY 2";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function dataDetailItem($no_dokumen){
        $sql = "SELECT   no_dokumen, item, description, qty
        FROM khs_inv_kapasitas_gudang_pusat
       WHERE no_dokumen = '$no_dokumen'
    ORDER BY 2";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function hpsDetailDok($no_dokumen, $item){
        $sql="DELETE FROM khs_inv_kapasitas_gudang_pusat
      WHERE no_dokumen = '$no_dokumen' AND item = '$item'";
        $query = $this->oracle->query($sql);            
        $query2 = $this->oracle->query('commit');       
        echo $sql; 
    }

    public function editQty($no_dokumen, $item, $qty){
        $sql="UPDATE khs_inv_kapasitas_gudang_pusat
        SET qty = $qty
      WHERE no_dokumen = '$no_dokumen' AND item = '$item'";
        $query = $this->oracle->query($sql);            
        $query2 = $this->oracle->query('commit');       
        echo $sql; 
    }

//----------------------------------------- Menu MONITORING PENGELUARAN -----------------------------------------

    public function getMonPengeluaran($no_dokumen, $jenis_dokumen, $tglAwal, $tglAkhir, $pic, $subinv){
        $no_dokumen == null? $nodoku = '' : $nodoku = "and no_dokumen = '$no_dokumen'";
        $pic == null ? $pic2 = '' : $pic2 = "and pic like '%$pic%'";
        $jenis_dokumen == null ? $dokudoku = '' : $dokudoku= "and jenis_dokumen = '$jenis_dokumen'";
        if ($tglAkhir != null && $tglAwal != null) {
            $tanggal = "and TRUNC(creation_date) BETWEEN TO_DATE('$tglAwal', 'DD/MM/YYYY') AND TO_DATE('$tglAkhir', 'DD/MM/YYYY')";
        } else {
            $tanggal = '';
        }

        $sql = "SELECT   kikgp.*, TO_CHAR (kikgp.mulai, 'DD Mon YYYY HH24:MI:SS') jam_mulai,
        TO_CHAR (kikgp.selesai, 'DD Mon YYYY HH24:MI:SS') jam_selesai
   FROM khs_inv_kapasitas_gudang_pusat kikgp
  WHERE gudang = '$subinv'
  $dokudoku $nodoku $tanggal $pic2
ORDER BY creation_date";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getDetail($no_dokumen){
        $sql = "SELECT kikgp.no_dokumen, kikgp.item kode_item, kikgp.description,
        kikgp.gudang from_subinventory_code, kikgp.qty quantity,
        (CASE
            WHEN mtrl.quantity_delivered = mtrl.quantity
               THEN 'Sudah terlayani'
            ELSE 'Belum terlayani'
         END
        ) status
   FROM mtl_txn_request_headers mtrh,
        mtl_txn_request_lines mtrl,
        mtl_system_items_b msib,
        khs_inv_kapasitas_gudang_pusat kikgp
  WHERE mtrh.header_id = mtrl.header_id
    AND mtrl.organization_id = msib.organization_id
    AND mtrl.inventory_item_id = msib.inventory_item_id
    AND mtrh.request_number = kikgp.no_dokumen
    AND msib.segment1 = kikgp.item
    -- AND kikgp.jenis_dokumen = 'PICKLIST'
    AND mtrh.request_number = '$no_dokumen'
UNION
SELECT bon.no_dokumen, bon.kode_item, bon.description,
       bon.from_subinventory_code, bon.quantity,
       (CASE
           WHEN bon.SOURCE IS NOT NULL
              THEN 'Sudah terlayani'
           ELSE 'Belum terlayani'
        END
       ) status
  FROM (SELECT kikgp.no_dokumen, kikgp.item kode_item, kikgp.description,
               kikgp.gudang from_subinventory_code, kikgp.qty quantity,
               (SELECT mmt.transaction_source_name
                  FROM mtl_system_items_b msib,
                       mtl_material_transactions mmt
                 WHERE imb.kode_barang = msib.segment1
                   AND SUBSTR (TRIM (mmt.transaction_source_name), 1, 5) = 'BPPBG'
                   AND mmt.organization_id = msib.organization_id
                   AND mmt.inventory_item_id = msib.inventory_item_id
                   AND SUBSTR (mmt.transaction_source_name, 7, 16) = TO_CHAR (imb.no_bon)) SOURCE
          FROM im_master_bon imb, khs_inv_kapasitas_gudang_pusat kikgp
         WHERE TO_CHAR (imb.no_bon) = '$no_dokumen'
           AND TO_CHAR (imb.no_bon) = kikgp.no_dokumen
           AND imb.kode_barang = kikgp.item
           AND kikgp.jenis_dokumen = 'BON') bon    
UNION
SELECT   io.no_dokumen, io.kode_item, io.description, 
        io.from_subinventory_code, io.quantity,
        (CASE
            WHEN io.receipt_num IS NOT NULL
               THEN 'Sudah terlayani'
            ELSE 'Belum terlayani'
         END
        ) status
   FROM (SELECT mmt.shipment_number no_dokumen, msib.segment1 kode_item,
                msib.description, mmt.transaction_quantity * -1 quantity,
                mmt.subinventory_code from_subinventory_code,
                (SELECT rsh.receipt_num
                   FROM rcv_shipment_headers rsh
                  WHERE mmt.shipment_number = rsh.shipment_num) receipt_num
           FROM mtl_material_transactions mmt, mtl_system_items_b msib
          WHERE msib.inventory_item_id = mmt.inventory_item_id
            AND msib.organization_id = mmt.organization_id
            AND mmt.shipment_number = '$no_dokumen'
            AND mmt.transaction_type_id = 21
            AND mmt.organization_id IN (102, 225)) io
ORDER BY 1, 2";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getKetPicklist($no_dokumen){
        $sql = "SELECT   mtrh.request_number no_dokumen, msib.segment1 kode_item,
        msib.description, mtrl.from_subinventory_code, mtrl.quantity,
        (CASE
            WHEN mtrl.quantity_delivered = mtrl.quantity
               THEN 'Sudah terlayani'
            ELSE 'Belum terlayani'
         END
        ) status
   FROM mtl_txn_request_headers mtrh,
        mtl_txn_request_lines mtrl,
        mtl_system_items_b msib
  WHERE mtrh.header_id = mtrl.header_id
    AND mtrl.organization_id = msib.organization_id
    AND mtrl.inventory_item_id = msib.inventory_item_id
    AND mtrh.request_number = '$no_dokumen'
    AND mtrl.quantity_delivered = mtrl.quantity";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getKetBon($no_dokumen){
        $sql = "SELECT mmt.subinventory_code subinventory, mil.segment1 LOCATOR,
        msib.segment1 item, msib.description deskripsi, 
        TO_CHAR(mmt.transaction_date, 'DD-Mon-YY HH24:MI:SS') transaction_date,
        mmt.transaction_uom uom, (mmt.transaction_quantity*-1) transfer_qty,
        mmt.transaction_source_name SOURCE, imb.pemakai seksi_pemakai,
        imb.cost_center cost_center_pemakai
   FROM mtl_material_transactions mmt,
        mtl_item_locations mil,
        mtl_system_items_b msib,
        im_master_bon imb
  WHERE SUBSTR (TRIM (mmt.transaction_source_name), 1, 5) = 'BPPBG'
    AND mmt.locator_id = mil.inventory_location_id(+)
    AND mmt.organization_id = msib.organization_id
    AND mmt.inventory_item_id = msib.inventory_item_id
    AND SUBSTR (mmt.transaction_source_name, 7, 16) = TO_CHAR (imb.no_bon)
    AND msib.segment1 = imb.kode_barang
    AND imb.no_bon = $no_dokumen";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getKetMo($no_dokumen){
        $sql = "SELECT   mtrh.request_number no_dokumen, msib.segment1 kode_item,
        msib.description, mtrl.from_subinventory_code, mtrl.quantity,
        (CASE
            WHEN mtrl.quantity_delivered = mtrl.quantity
               THEN 'Sudah terlayani'
            ELSE 'Belum terlayani'
         END
        ) status
   FROM mtl_txn_request_headers mtrh,
        mtl_txn_request_lines mtrl,
        mtl_system_items_b msib
  WHERE mtrh.header_id = mtrl.header_id
    AND mtrl.organization_id = msib.organization_id
    AND mtrl.inventory_item_id = msib.inventory_item_id
    AND mtrh.request_number = '$no_dokumen'
    AND mtrl.quantity_delivered = mtrl.quantity";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getKetIo($no_dokumen){
        $sql = "SELECT DISTINCT rt.*
        FROM rcv_shipment_headers rsh,
             rcv_shipment_lines rsl,
             mtl_material_transactions mmt,
             rcv_transactions rt
       WHERE mmt.shipment_number = rsh.shipment_num
         AND rsh.shipment_header_id = rsl.shipment_header_id
         AND rsh.receipt_num IS NOT NULL
         AND rt.shipment_header_id = rsh.shipment_header_id
         AND rt.shipment_line_id = rsl.shipment_line_id
         AND mmt.shipment_number = '$no_dokumen'
         AND rt.transaction_type = 'RECEIVE'
         AND mmt.transaction_type_id IN (21, 12)";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getKetDo($no_dokumen){
        $sql = "SELECT mtrh.request_number no_dokumen, msib.segment1 kode_item,
        msib.description, mtrl.quantity, 
        mmt.subinventory_code from_subinventory_code,
        (CASE
            WHEN mtrl.quantity_delivered = mtrl.quantity
               THEN 'Sudah terlayani'
            ELSE 'Belum terlayani'
         END
        ) status
   FROM mtl_txn_request_headers mtrh,
        mtl_txn_request_lines mtrl,
        mtl_system_items_b msib,
        mtl_material_transactions mmt,
        wsh_delivery_details wdd
  WHERE mtrh.header_id = mtrl.header_id
    AND mtrl.organization_id = msib.organization_id
    AND mtrl.inventory_item_id = msib.inventory_item_id
    AND mmt.move_order_line_id = mtrl.line_id
    AND mmt.inventory_item_id = msib.inventory_item_id
    AND mmt.organization_id = msib.organization_id
    AND TO_CHAR (wdd.batch_id) = mtrh.request_number
    AND wdd.move_order_line_id = mtrl.line_id
    AND mmt.transaction_quantity LIKE '-%'
    AND mtrh.request_number = '$no_dokumen'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getExport($jenis_dokumen, $tglAwal, $tglAkhir, $subinv){
        $sql = "SELECT   kikgp.*, TO_CHAR (kikgp.mulai, 'DD Mon YYYY HH24:MI:SS') jam_mulai,
        TO_CHAR (kikgp.selesai, 'DD Mon YYYY HH24:MI:SS') jam_selesai
        FROM khs_inv_kapasitas_gudang_pusat kikgp
       WHERE jenis_dokumen = '$jenis_dokumen'
         AND TRUNC (creation_date) BETWEEN TO_DATE ('$tglAwal', 'DD/MM/YYYY')
                                       AND TO_DATE ('$tglAkhir', 'DD/MM/YYYY')
         AND gudang = '$subinv'
    ORDER BY creation_date DESC";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    

}