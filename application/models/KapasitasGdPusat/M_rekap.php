<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

    class M_rekap extends CI_Model {
        public function __construct() {
            parent::__construct();
            $this->load->database();    
            $this->oracle = $this->load->database('oracle', true);
        }

        public function getRekap($query){
            $sql = "SELECT no_dokumen, jenis_dokumen, gudang, jumlah_item,
            creation_date, pic, TO_CHAR (mulai, 'DD/MM/YYYY HH24:MI:SS') mulai,
            TO_CHAR (selesai, 'DD/MM/YYYY HH24:MI:SS') selesai, waktu
            FROM khs_inv_kapasitas_gudang_pusat
           $query";
           $query = $this->oracle->query($sql);
           return $query->result_array();
        }

        public function getTanggungan($query){
            $sql = "SELECT no_dokumen, jenis_dokumen, gudang, jumlah_item,
            creation_date, pic, TO_CHAR (mulai, 'DD/MM/YYYY HH24:MI:SS') mulai,
            TO_CHAR (selesai, 'DD/MM/YYYY HH24:MI:SS') selesai, waktu
            FROM khs_inv_kapasitas_gudang_pusat
           $query";
           $query = $this->oracle->query($sql);
           return $query->result_array();
        }

        public function getPasangBan($date){
            $sql = "SELECT   num, ket, SUM (jumlah) jumlah
            FROM (SELECT DISTINCT DECODE (ket,
                                        --   'siap1', 1,
                                        --   'siap2', 2,
                                          'pasang1', 1,
                                          'pasang2', 2
                                         ) num,
                                  ket, mulai, selesai, waktu, jumlah
                             FROM khs_inv_pasang_ban
                            WHERE TO_CHAR (mulai, 'DD/MM/YYYY') = '$date'
                              AND TO_CHAR (selesai, 'DD/MM/YYYY') = '$date'
                              AND ket like 'pasang%')
        GROUP BY num, ket
        ORDER BY num";
        $query = $this->oracle->query($sql);
        return $query->result_array();
        }


    }

?>