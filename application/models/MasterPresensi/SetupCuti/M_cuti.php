<?php
Defined('BASEPATH') or exit("No DIrect Script Access Allowed");

/**
 * 
 */
class M_cuti extends CI_Model
{

   public function __construct()
   {
      parent::__construct();
      $this->personalia = $this->load->database('personalia', true);
   }

   public function getCuti()
   {
      $sql_query = "SELECT * FROM \"Presensi\".tcuti ORDER BY kd_cuti";

      return $this->personalia->query($sql_query)->result_object();
   }

   public function checkCuti($kd_cuti, $nama_cuti)
   {
      $sql_query = "SELECT * FROM \"Presensi\".tcuti where kd_cuti = '$kd_cuti' and nama_cuti = '$nama_cuti'";

      return $this->personalia->query($sql_query)->result_array();
   }

   public function insertCuti($data)
   {
      list($kodeCuti, $namaCuti, $maxHari) = $data;
      $query = "
         INSERT INTO 
               \"Presensi\".tcuti (kd_cuti, nama_cuti, hari_maks) 
         VALUES ('$kodeCuti', '$namaCuti', '$maxHari'); 
         INSERT INTO 
               \"Presensi\".tketerangan (kd_ket, keterangan) 
         VALUES ('$kodeCuti', '$namaCuti');
      ";
      $this->personalia->query($query);
   }

   public function updateCuti($current_cuti = false, $kode_cuti, $nama_cuti, $max_hari)
   {
      $cur_kode_cuti = $current_cuti['kd_cuti'];
      $cur_nama_cuti = $current_cuti['nama_cuti'];
      $query = "
               UPDATE \"Presensi\".tcuti 
               SET 
                  kd_cuti = '$kode_cuti', 
                  nama_cuti='$nama_cuti', 
                  hari_maks = '$max_hari' 
               WHERE 
                  kd_cuti = '$cur_kode_cuti' AND 
                  nama_cuti='$cur_nama_cuti';
                  
               UPDATE \"Presensi\".tketerangan 
               SET 
                  kd_ket = '$kode_cuti', 
                  keterangan='$nama_cuti' 
               WHERE 
                  kd_ket = '$cur_kode_cuti' AND 
                  keterangan='$cur_nama_cuti';
               ";
      $this->personalia->query($query);
   }

   public function deleteCuti($kode_cuti, $nama_cuti)
   {
      $query_sql = "
            DELETE FROM 
               \"Presensi\".tcuti 
            WHERE kd_cuti = '$kode_cuti' AND nama_cuti = '$nama_cuti';
            DELETE FROM 
            \"Presensi\".tketerangan 
            WHERE kd_ket = '$kode_cuti' AND keterangan = '$nama_cuti';
            ";
      $this->personalia->query($query_sql);
   }

   /**
    * @param $wkt
    * @param $menu
    * @param $ket
    * @param $noind
    * @param $jeni
    * @param $program
    */
   public function insertLog($wkt, $menu, $ket, $noind, $jenis, $program)
   {
      $query_sql = "INSERT INTO hrd_khs.tlog (wkt,menu,ket,noind,jenis,program,noind_baru) VALUES('$wkt','$menu','$ket','$noind','$jenis','$program',null)";
      $this->personalia->query($query_sql);
   }
}
