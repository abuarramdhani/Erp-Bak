<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_Pengeluaran extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();    
        $this->oracle = $this->load->database('oracle', true);
    }

//--------------------------------------------- Menu PENGELUARAN ---------------------------------------------
    
    public function getCek($subinv, $no_dokumen){
        $sql = "SELECT   mtrh.request_number no_dokumen, msib.segment1 kode_item,
        msib.description, mtrl.quantity, mtrl.from_subinventory_code
   FROM mtl_txn_request_headers mtrh,
        mtl_txn_request_lines mtrl,
        mtl_system_items_b msib
  WHERE mtrh.header_id = mtrl.header_id
    AND mtrl.organization_id = msib.organization_id
    AND mtrl.inventory_item_id = msib.inventory_item_id
    AND mtrh.request_number = '$no_dokumen'
    AND mtrl.from_subinventory_code = '$subinv'
UNION
SELECT   TO_CHAR (imb.no_bon) no_dokumen, imb.kode_barang kode_item,
        imb.nama_barang description, TO_NUMBER (imb.permintaan) quantity,
        imb.tujuan_gudang from_subinventory_code
   FROM im_master_bon imb
  WHERE TO_CHAR (imb.no_bon) = '$no_dokumen'
        AND imb.tujuan_gudang = '$subinv'
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

    public function save($no_dokumen, $jenis_dokumen, $subinv, $jumlah_item, $creation_date){
        $sql = "INSERT INTO khs_inv_kapasitas_gudang_pusat
        (no_dokumen, jenis_dokumen, gudang, jumlah_item,
         creation_date
        )
 VALUES ('$no_dokumen', '$jenis_dokumen', '$subinv', $jumlah_item,
         TO_DATE ('$creation_date', 'YYYY/MM/DD HH24:MI:SS')
        )";
        $query = $this->oracle->query($sql);
        $query2 = $this->oracle->query("commit");
    }

    public function getData(){
        $sql = "SELECT kikgp.no_dokumen, kikgp.jenis_dokumen, kikgp.gudang, kikgp.jumlah_item,
        kikgp.creation_date, kikgp.pic,
        TO_CHAR (kikgp.mulai, 'YYYY-MM-DD HH24:MI:SS') mulai,
        TO_CHAR (kikgp.mulai, 'HH24:MI:SS') jam_mulai, kikgp.selesai,
        kikgp.waktu
   FROM khs_inv_kapasitas_gudang_pusat kikgp
  WHERE kikgp.selesai IS NULL";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getPIC($term){
        $sql = "SELECT *
        FROM khs_tabel_user
       WHERE pic LIKE '%$term%'";
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
UNION
SELECT bon.no_dokumen, bon.kode_item, bon.description,
       bon.from_subinventory_code, bon.quantity,
       (CASE
           WHEN bon.SOURCE IS NOT NULL
              THEN 'Sudah terlayani'
           ELSE 'Belum terlayani'
        END
       ) status
  FROM (SELECT   TO_CHAR (imb.no_bon) no_dokumen, imb.kode_barang kode_item,
                 imb.nama_barang description,
                 imb.tujuan_gudang from_subinventory_code,
                 TO_NUMBER (imb.permintaan) quantity,
                 (SELECT mmt.transaction_source_name
                    FROM mtl_system_items_b msib,
                         mtl_material_transactions mmt
                   WHERE imb.kode_barang = msib.segment1
                     AND SUBSTR (TRIM (mmt.transaction_source_name), 1, 5) = 'BPPBG'
                     AND mmt.organization_id = msib.organization_id
                     AND mmt.inventory_item_id = msib.inventory_item_id
                     AND SUBSTR (mmt.transaction_source_name, 7, 16) = TO_CHAR (imb.no_bon)) SOURCE
            FROM im_master_bon imb
           WHERE TO_CHAR (imb.no_bon) = '$no_dokumen') bon
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