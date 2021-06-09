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
                or mh.nama_handling like '%$term%'
              order by
                mh.kode_handling";
      $query = $this->erp->query($sql);
      return $query->result_array();
    }

    public function getDataMonitoring($subkon,$handling,$date,$status){
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

      $sql = "SELECT kmhs.*,
                     TO_CHAR (kmhs.transaction_date,'DD-MON-YYYY') tanggal,
                     TO_CHAR (kmhs.transaction_date,'HH24:MI:SS') waktu
                FROM khs_mon_handling_subkon kmhs
               WHERE kmhs.locator_name = '$subkon'
                     $code1
                     $code2
                     AND TRUNC (kmhs.transaction_date) BETWEEN TRUNC (TO_DATE ('$dateA')) AND TRUNC (TO_DATE ('$dateB'))
            ORDER BY kmhs.locator_name, kmhs.kis";
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
}
?>