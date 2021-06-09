<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_bppbg extends CI_Model{
    public function __construct(){
      parent::__construct();
      $this->load->database();    
      $this->oracle = $this->load->database('oracle', true);
    }

    public function search($term){
      $sql = "SELECT imb.no_bon
                FROM im_master_bon imb
               WHERE imb.no_bon LIKE '%$term%'";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function getData($bppbg){
      $sql = "SELECT   imb.*,
                       NVL ((SELECT    ffvt.description
                                    || ' - '
                                    || DECODE (imb.kode_cabang,
                                               'AA', 'PUSAT',
                                               'AC', 'TUKSONO',
                                               NULL
                                              )
                               FROM fnd_flex_values_tl ffvt
                              WHERE imb.pemakai = ffvt.flex_value_meaning),
                            imb.pemakai
                           ) seksi_pemakai,
                       CASE
                          WHEN (SELECT mmt.transaction_id
                                  FROM mtl_material_transactions mmt
                                 WHERE mmt.inventory_item_id = msib.inventory_item_id
                                   AND SUBSTR (mmt.transaction_source_name, 7, 9) =
                                                                        TO_CHAR (imb.no_bon)) IS NOT NULL
                             THEN 'Y'
                          ELSE 'N'
                       END mmt,
                       CASE
                          WHEN (SELECT mti.transaction_source_name
                                  FROM mtl_transactions_interface mti
                                 WHERE mti.inventory_item_id = msib.inventory_item_id
                                   AND SUBSTR (mti.transaction_source_name, 7, 9) =
                                                                        TO_CHAR (imb.no_bon)) IS NULL
                             THEN 'N'
                          ELSE 'Y'
                       END mti
                  FROM im_master_bon imb, mtl_system_items_b msib
                 WHERE imb.kode_barang = msib.segment1
                   AND msib.organization_id = 81
                   AND imb.no_bon = $bppbg
              ORDER BY 1";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function getSubinv($term){
      $sql = "SELECT   msi.secondary_inventory_name, msi.secondary_inventory_name subinv,
                       msi.description, msi.organization_id
                  FROM mtl_secondary_inventories msi
                 WHERE msi.secondary_inventory_name IN (
                                              SELECT DISTINCT imb.tujuan_gudang
                                                                               subinventory
                                                         FROM im_master_bon imb
                                                        WHERE imb.tujuan_gudang IS NOT NULL)
                   AND msi.disable_date IS NULL
                   AND msi.secondary_inventory_name LIKE '%$term%'
              ORDER BY 1 NULLS FIRST";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function getItem($term){
      $sql = "SELECT   NULL urut, 'SEMUA' segment1, 'SEMUA ITEM' description
                  FROM DUAL
              UNION
              SELECT DISTINCT imb.kode_barang urut, imb.kode_barang, imb.nama_barang
                         FROM im_master_bon imb
                        WHERE imb.kode_barang LIKE '%$term%' OR imb.nama_barang LIKE '%$term%'
                     ORDER BY 1 NULLS FIRST";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function getDataMonitoring($subinv,$item,$status,$date){
      if ($subinv == 'SEMUA SUBINVENTORY') {
        $line1 = "imb.tujuan_gudang LIKE '%%'";
      }
      else {
        $line1 = "imb.tujuan_gudang = '$subinv'";
      }

      if ($item == 'SEMUA' || $item == '') {
        $line2 = "";
      }
      else {
        $line2 = "AND imb.kode_barang = '$item'";
      }

      if ($status == 'SEMUA') {
        $line3 = "";
      }
      else {
        $line3 = "AND imb.flag = '$status'";
      }

      $date2 = explode(' - ', $date);      
      $dateA = $date2[0];
      $dateB = $date2[1];

      $sql = "SELECT DISTINCT imb.no_bon, imb.seksi_bon, imb.tujuan_gudang, imb.flag,
                              imb.tanggal,
                              NVL ((SELECT    ffvt.description
                                           || ' - '
                                           || DECODE (imb.kode_cabang,
                                                      'AA', 'PUSAT',
                                                      'AC', 'TUKSONO',
                                                      NULL
                                                     )
                                      FROM fnd_flex_values_tl ffvt
                                     WHERE imb.pemakai = ffvt.flex_value_meaning),
                                   imb.pemakai
                                  ) seksi_pemakai,
                              CASE
                                 WHEN (SELECT mmt.transaction_id
                                         FROM mtl_material_transactions mmt
                                        WHERE mmt.inventory_item_id =
                                                                 msib.inventory_item_id
                                          AND SUBSTR (mmt.transaction_source_name, 7, 9) =
                                                                        TO_CHAR (imb.no_bon)
                                          AND ROWNUM = 1) IS NOT NULL
                                    THEN 'Y'
                                 ELSE 'N'
                              END mmt
                         FROM im_master_bon imb, mtl_system_items_b msib
                        WHERE imb.kode_barang = msib.segment1 AND msib.organization_id = 81
                          AND $line1
                              $line2
                              $line3
                          AND TRUNC (TO_DATE (imb.tanggal)) BETWEEN TRUNC (TO_DATE ('$dateA')) AND TRUNC (TO_DATE ('$dateB'))
                     ORDER BY TRUNC (TO_DATE (imb.tanggal)), 1";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

}
?>