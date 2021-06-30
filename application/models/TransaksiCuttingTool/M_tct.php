<?php
class M_tct extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    // $this->oracle = $this->load->database('oracle_dev', true);
    $this->oracle = $this->load->database('oracle', true);
    $this->personalia = $this->load->database('personalia', true);
  }

  public function get()
  {
    return $this->oracle->query("SELECT msib.segment1 kode, msib.description nama, mmt.subinventory_code,
                                 mil.segment1 LOCATOR, mmt.transaction_date,
                                 (mmt.transaction_quantity * -1) transaction_quantity,
                                 mtst.transaction_source_type_name source_type,
                                 mmt.transaction_source_name source,
                                 mtt.transaction_type_name transaction_type,
                                 imbb.no_mesin, imbb.cost_center, imbb.desc_mesin, imbb.seksi_pengebon,
                                 imbb.komponen
                            FROM mtl_system_items_b msib,
                                 mtl_material_transactions mmt,
                                 mtl_item_locations mil,
                                 mtl_txn_source_types mtst,
                                 mtl_transaction_types mtt,
                                 im_master_bon_bppct imbb
                           WHERE SUBSTR (TRIM (mmt.transaction_source_name), 1, 6) = 'BPPBGT'
                             AND mmt.organization_id = msib.organization_id
                             AND mmt.inventory_item_id = msib.inventory_item_id
                             AND mmt.locator_id = mil.inventory_location_id(+)
                             AND mmt.transaction_source_type_id = mtst.transaction_source_type_id
                             AND mmt.transaction_type_id = mtt.transaction_type_id
                             AND SUBSTR (mmt.transaction_source_name, 8, 16) = TO_CHAR (imbb.no_bon)
                             AND msib.segment1 = imbb.item_cutting_tools
                             AND TRUNC(mmt.transaction_date) BETWEEN '1-Dec-2020' AND '29-Mar-2021'
                             AND imbb.no_bon = 210106034
                             AND imbb.seksi_pengebon = 'MACHINING A - TKS'
                             AND imbb.no_mesin = 'BOR46'
                             AND mtt.transaction_type_name = 'KHS_BON PRODUKSI'")->result_array();
  }

  public function getFilter($range_tanggal, $no_bppbgt , $seksi, $mesin, $trans_type)
  {
    $range = explode(' - ', $range_tanggal);
    if (!empty($no_bppbgt)) {
      $no_bppbgt__="AND imbb.no_bon = SUBSTR ('$no_bppbgt', 8, 16)";
      $seksi__="AND imbb.seksi_pengebon = '$seksi'";
      $mesin__="AND imbb.no_mesin = '$mesin'";
    }else {
      $no_bppbgt__="";
      $seksi__="";
      $mesin__="";
    }if (!empty($trans_type)) {
      $trans_type__="AND TO_CHAR(mtt.transaction_type_name) = '$trans_type'";
    }else {
      $trans_type__="";
    }
    return $this->oracle->query("SELECT msib.segment1 kode, msib.description nama, mmt.subinventory_code,
                                 mil.segment1 LOCATOR, mmt.transaction_date,
                                 (mmt.transaction_quantity * -1) transaction_quantity,
                                 mtst.transaction_source_type_name source_type,
                                 mmt.transaction_source_name source,
                                 mtt.transaction_type_name transaction_type,
                                 imbb.no_mesin, imbb.cost_center, imbb.desc_mesin, imbb.seksi_pengebon,
                                 imbb.komponen
                            FROM mtl_system_items_b msib,
                                 mtl_material_transactions mmt,
                                 mtl_item_locations mil,
                                 mtl_txn_source_types mtst,
                                 mtl_transaction_types mtt,
                                 im_master_bon_bppct imbb
                           WHERE SUBSTR (TRIM (mmt.transaction_source_name), 1, 6) = 'BPPBGT'
                             AND mmt.organization_id = msib.organization_id
                             AND mmt.inventory_item_id = msib.inventory_item_id
                             AND mmt.locator_id = mil.inventory_location_id(+)
                             AND mmt.transaction_source_type_id = mtst.transaction_source_type_id
                             AND mmt.transaction_type_id = mtt.transaction_type_id
                             AND SUBSTR (mmt.transaction_source_name, 8, 16) = TO_CHAR (imbb.no_bon)
                             AND msib.segment1 = imbb.item_cutting_tools
                             AND TRUNC(mmt.transaction_date) BETWEEN '{$range[0]}' AND '{$range[1]}'
                             $no_bppbgt__
                             $seksi__
                             $mesin__
                             $trans_type__")->result_array();
  }

  public function getBppbgt($param)
  {
    return $this->oracle->query("SELECT DISTINCT 'BPPBGT '||imbb.no_bon transaction_source_name
                                FROM im_master_bon_bppct imbb
                                WHERE imbb.no_bon LIKE '%$param%'
                                ORDER BY 1")->result_array();
    // return $this->oracle->query("SELECT DISTINCT mmt.transaction_source_name
    //                            FROM mtl_material_transactions mmt
    //                            WHERE mmt.transaction_source_name LIKE 'BPPBGT 21%'
    //                            AND mmt.transaction_source_name LIKE '%$param%'
    //                            ORDER BY 1")->result_array();
  }

  public function getSm($bppbgt)
  {
    return $this->oracle->query("SELECT DISTINCT imbb.seksi_pengebon, imbb.no_mesin
                                FROM im_master_bon_bppct imbb
                                WHERE TO_CHAR (imbb.no_bon) = SUBSTR ('$bppbgt', 8, 16)
                                ORDER BY 1")->result_array();
  }

  public function getTransactType()
  {
    return $this->oracle->query("SELECT DISTINCT mtt.transaction_type_name
                                FROM mtl_transaction_types mtt
                                WHERE mtt.transaction_source_type_id = 13
                                AND mtt.transaction_type_name LIKE 'KHS%'
                                AND mtt.disable_date IS NULL
                                ORDER BY 1")->result_array();
  }
}
