<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monhansub extends CI_Model{
    public function __construct(){
      parent::__construct();
      $this->load->database();    
      $this->oracle = $this->load->database('oracle', true);
      $this->erp = $this->load->database('erp_db', true);
      $this->personalia = $this->load->database('personalia', true);
    }

    public function getSubkon($term){
      $sql = "SELECT mil.inventory_location_id, mil.segment1, mil.description
                FROM mtl_item_locations mil
               WHERE mil.subinventory_code = 'INT-SUB'
                 AND (mil.description LIKE '%$term%' OR mil.segment1 LIKE '%$term%')
            ORDER BY mil.description";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function getNewNumber($subkon){
      $sql = "SELECT 'KIS'
                     || '$subkon'
                     || NVL (LPAD (SUBSTR (MAX (kmhs.kis), -3, 3) + 1, 3, 0), '001') kis
                FROM khs_mon_handling_subkon kmhs
               WHERE kmhs.locator_name = '$subkon'";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function getHandling($term){
      $sql = "select
                mh.id_master_handling,
                mh.kode_handling,
                upper(mh.nama_handling) nama_handling
              from
                dbh.master_handling mh
              where
                mh.kode_handling like '%$term%'
                or UPPER(mh.nama_handling) like '%$term%'
              order by
                mh.kode_handling";
      $query = $this->erp->query($sql);
      return $query->result_array();
    }

    public function getDataMonitoring($subkon,$handling,$date,$status){
      if ($subkon == '') {
        $code = "LIKE '%%'";
      }
      else {
        $code = "= '$subkon'";
      }

      if ($handling == '') {
        $code1 = "";
      }
      else {
        $code1 = "AND kmhs.handling_code = '$handling'";
      }

      if ($status == 'ALL') {
        $code2 = "";
      }
      else {
        $code2 = "AND kmhs.transaction_type = '$status'";
      }

      $date2 = explode(' - ', $date);      
      $dateA = $date2[0];
      $dateB = $date2[1];

      $sql = "SELECT mil.description subkon, kmhs.*,
                     TO_CHAR (kmhs.transaction_date,'DD-MON-YYYY') tanggal,
                     TO_CHAR (kmhs.transaction_date,'HH24:MI:SS') waktu
                FROM khs_mon_handling_subkon kmhs, mtl_item_locations mil
               WHERE kmhs.locator_name = mil.segment1
                 AND kmhs.locator_name $code
                     $code1
                     $code2
                 AND TRUNC (kmhs.transaction_date) BETWEEN TRUNC (TO_DATE ('$dateA')) AND TRUNC (TO_DATE ('$dateB'))
            ORDER BY kmhs.transaction_date DESC, kmhs.locator_name, kmhs.kis";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function getDataPIC(){
      $sql = "select
                tp.noind,
                tp.nama
              from
                hrd_khs.tpribadi tp
              order by
                1";
      $query = $this->personalia->query($sql);
      return $query->result_array();
    }

    public function getDataStock($subkon,$handling){
      if ($subkon == '') {
        $code = "LIKE '%%'";
      }
      else {
        $code = "= '$subkon'";
      }

      if ($handling == '') {
        $code1 = "";
      }
      else {
        $code1 = "AND aa.handling_code = '$handling'";
      }

      $sql = "SELECT aa.*, CASE
                        WHEN aa.qty < 0
                           THEN aa.qty * -1
                        ELSE 0
                     END di_khs, CASE
                        WHEN aa.qty > 0
                           THEN aa.qty
                        ELSE 0
                     END di_subkon
                FROM (SELECT DISTINCT mil.description subkon, kmhs.locator_name,
                                      kmhs.handling_code, kmhs.handling_name,
                                      NVL (kshs.saldo_awal, 0) saldo_awal,
                                      NVL ((SELECT SUM (kmhs2.transaction_quantity)
                                              FROM khs_mon_handling_subkon kmhs2
                                             WHERE kmhs2.locator_name = kmhs.locator_name
                                               AND kmhs2.handling_code = kmhs.handling_code
                                               AND kmhs2.transaction_type = 'OUT'),
                                           0
                                          ) o,
                                      NVL ((SELECT SUM (kmhs2.transaction_quantity)
                                              FROM khs_mon_handling_subkon kmhs2
                                             WHERE kmhs2.locator_name = kmhs.locator_name
                                               AND kmhs2.handling_code = kmhs.handling_code
                                               AND kmhs2.transaction_type = 'IN'),
                                           0
                                          ) i,
                                        NVL (kshs.saldo_awal, 0)
                                      + NVL ((SELECT SUM (kmhs2.transaction_quantity)
                                                FROM khs_mon_handling_subkon kmhs2
                                               WHERE kmhs2.locator_name = kmhs.locator_name
                                                 AND kmhs2.handling_code =
                                                                          kmhs.handling_code
                                                 AND kmhs2.transaction_type = 'OUT'),
                                             0
                                            )
                                      - NVL ((SELECT SUM (kmhs2.transaction_quantity)
                                                FROM khs_mon_handling_subkon kmhs2
                                               WHERE kmhs2.locator_name = kmhs.locator_name
                                                 AND kmhs2.handling_code =
                                                                          kmhs.handling_code
                                                 AND kmhs2.transaction_type = 'IN'),
                                             0
                                            ) qty
                                 FROM khs_mon_handling_subkon kmhs,
                                      mtl_item_locations mil,
                                      khs_saldo_handling_subkon kshs
                                WHERE kmhs.locator_name = mil.segment1
                                  AND kshs.locator_name(+) = kmhs.locator_name
                                  AND kshs.handling_code(+) = kmhs.handling_code
                             GROUP BY mil.description,
                                      kmhs.locator_name,
                                      kmhs.handling_code,
                                      kmhs.handling_name,
                                      kshs.saldo_awal,
                                      kmhs.transaction_type) aa
               WHERE aa.locator_name $code
                     $code1
            ORDER BY aa.subkon, aa.handling_code";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function editSaldoAwal($subkon,$handling,$qty){
      $sql = "UPDATE khs_saldo_handling_subkon kshs
                 SET kshs.saldo_awal = $qty
               WHERE kshs.locator_name = '$subkon' AND kshs.handling_code = '$handling'";
      $query = $this->oracle->query($sql);
      return $query;
    }
}
?>