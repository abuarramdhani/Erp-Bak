<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

    class M_rekap extends CI_Model {
        public function __construct() {
            parent::__construct();
            $this->load->database();    
            $this->oracle = $this->load->database('oracle', true);
            // $this->oracle = $this->load->database('oracle_dev', true);
        }

        public function getRekap($query){
            $sql = "SELECT   no_dokumen, jenis_dokumen, gudang, COUNT (item) jumlah_item,
            creation_date, pic, TO_CHAR (mulai, 'YYYY-MM-DD HH24:MI:SS') mulai,
            TO_CHAR (mulai, 'HH24:MI:SS') jam_mulai, selesai, waktu
       FROM khs_inv_kapasitas_gudang_pusat
     $query
   GROUP BY no_dokumen,
            jenis_dokumen,
            gudang,
            creation_date,
            pic,
            TO_CHAR (mulai, 'YYYY-MM-DD HH24:MI:SS'),
            TO_CHAR (mulai, 'HH24:MI:SS'),
            selesai,
            waktu";
           $query = $this->oracle->query($sql);
           return $query->result_array();
        }

        public function getTanggungan($query){
            $sql = "SELECT   no_dokumen, jenis_dokumen, gudang, COUNT (item) jumlah_item,
            creation_date, pic, TO_CHAR (mulai, 'YYYY-MM-DD HH24:MI:SS') mulai,
            TO_CHAR (mulai, 'HH24:MI:SS') jam_mulai, selesai, waktu
       FROM khs_inv_kapasitas_gudang_pusat
     $query
   GROUP BY no_dokumen,
            jenis_dokumen,
            gudang,
            creation_date,
            pic,
            TO_CHAR (mulai, 'YYYY-MM-DD HH24:MI:SS'),
            TO_CHAR (mulai, 'HH24:MI:SS'),
            selesai,
            waktu";
           $query = $this->oracle->query($sql);
           return $query->result_array();
        }

        public function getPasangBan($date, $jenis_ban){
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
                              -- AND TO_CHAR (selesai, 'DD/MM/YYYY') = '$date'
                              AND ket like 'pasang%'
                              AND jenis_ban = '$jenis_ban')
        GROUP BY num, ket
        ORDER BY num";
        $query = $this->oracle->query($sql);
        return $query->result_array();
        }


    }

?>