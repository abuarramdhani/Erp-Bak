<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pasangban extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
        $this->personalia = $this->load->database('personalia', true);
    }
    
    public function getUsername($term){
        $sql = "SELECT DISTINCT noind, nama
        FROM hrd_khs.tpribadi 
        WHERE noind LIKE '%$term%'
        OR nama LIKE '%$term%'";
        // echo "<pre>";print_r($sql);exit();
        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

    public function getPasang($ket){
        $sql = "SELECT kipb.no_induk, kipb.nama, kipb.ket,
        TO_CHAR (kipb.mulai, 'YYYY-MM-DD HH24:MI:SS') mulai,
        TO_CHAR (kipb.mulai, 'HH24:MI:SS') jam_mulai, kipb.selesai, kipb.waktu,
        kipb.jumlah
   FROM khs_inv_pasang_ban kipb
  WHERE kipb.selesai IS NULL AND kipb.ket = '$ket'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getJamMulai($ket){
        $sql = "SELECT DISTINCT kipb.ket,
        TO_CHAR (kipb.mulai, 'YYYY-MM-DD HH24:MI:SS') mulai,
        TO_CHAR (kipb.mulai, 'HH24:MI:SS') jam_mulai, kipb.selesai, kipb.waktu,
        kipb.jumlah
   FROM khs_inv_pasang_ban kipb
  WHERE kipb.selesai IS NULL AND kipb.ket = '$ket'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function SaveMulai($data){
        $sql = "INSERT INTO khs_inv_pasang_ban
                 (no_induk, nama, ket, mulai
                 )
         VALUES ('$data[NO_INDUK]', '$data[NAMA]', '$data[KET]', TO_TIMESTAMP ('$data[DATE]', 'DD-MM-YYYY HH24:MI:SS')
                 )";
        $query = $this->oracle->query($sql);
        $query2 = $this->oracle->query("commit");
        echo $sql;
    }

    public function cekMulai($data){
        $sql = "SELECT kipb.*, TO_CHAR (kipb.mulai, 'YYYY-MM-DD HH24:MI:SS') AS jam_mulai
        FROM khs_inv_pasang_ban kipb
       WHERE kipb.no_induk = '$data[NO_INDUK]' AND kipb.ket = '$data[KET]'";
    //     $sql = "SELECT *
    //     FROM khs_inv_pasang_ban
    //    WHERE no_induk = '$data[NO_INDUK]' AND ket = '$data[KET]'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function SaveSelesai($data, $slsh){
        $sql = "UPDATE khs_inv_pasang_ban
        SET selesai = TO_TIMESTAMP ('$data[DATE]', 'DD-MM-YYYY HH24:MI:SS'),
            jumlah = '$data[JUMLAH]',
            waktu = '$slsh'
      WHERE no_induk = '$data[NO_INDUK]' AND ket = '$data[KET]'";
        $query = $this->oracle->query($sql);            
        $query2 = $this->oracle->query('commit');       
        echo $sql;
    }

    // public function SaveJumlah($data){
    //     $sql = "UPDATE khs_inv_pasang_ban
    //     SET jumlah = '$data[JUMLAH]'
    //   WHERE no_induk = '$data[NO_INDUK]' AND ket = '$data[KET]'";
    //     $query = $this->oracle->query($sql);            
    //     $query2 = $this->oracle->query('commit');       
    //     echo $sql;
    // }


}


?>