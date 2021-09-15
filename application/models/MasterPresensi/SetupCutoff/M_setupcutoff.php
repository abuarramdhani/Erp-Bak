<?php
Defined('BASEPATH') or exit("No DIrect Script Access Allowed");

/**
 * 
 */
class M_setupcutoff extends CI_Model
{

   public function __construct()
   {
      parent::__construct();
      $this->personalia = $this->load->database('personalia', true);
   }

   public function getCutoff()
   {
      $this->personalia->order_by('id_cutoff', 'desc');
      return $this->personalia->get('"Presensi".tcutoff')->result_object();
   }

   public function checkCutoff($id)
   {
      $this->personalia->where('id_cutoff', $id);
      return $this->personalia->get('"Presensi".tcutoff')->result_object();
   }

   public function insertCutoff($data)
   {
      $periode = $data['periode'];
      $os = $data['os'];
      $tanggal_awal = $data['tanggal_awal'];
      $tanggal_akhir = $data['tanggal_akhir'];

      $sql_query = "INSERT INTO 
                        \"Presensi\".tcutoff(id_cutoff,periode,os,tanggal_awal,tanggal_akhir,status)
                    VALUES ((SELECT max(id_cutoff)::INTEGER + 1 FROM \"Presensi\".tcutoff), '$periode', '$os', '$tanggal_awal', '$tanggal_akhir', '0')";
      $this->personalia->query($sql_query);
   }

   public function updateCutoff($data)
   {
      $this->personalia->where('id_cutoff', $data['id_cutoff']);
      $this->personalia->update('"Presensi".tcutoff', $data);
   }
   public function deleteCutoff($id)
   {
      $this->personalia->where('id_cutoff', $id);
      $this->personalia->delete('"Presensi".tcutoff');
   }
   public function insertLog($wkt, $menu, $ket, $noind, $jenis, $program)
   {
      $query_sql = "INSERT INTO hrd_khs.tlog (wkt,menu,ket,noind,jenis,program,noind_baru) VALUES('$wkt','$menu','$ket','$noind','$jenis','$program',null)";
      $this->personalia->query($query_sql);
   }
}
