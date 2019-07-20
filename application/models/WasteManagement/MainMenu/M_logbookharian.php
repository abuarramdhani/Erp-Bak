<?php
Defined('BASEPATH') or exit('No Direct Access Allowed');
/**
 *
 */
class M_logbookharian extends CI_MODEL
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function getLimbahJenis(){
    $sql="select * from ga.ga_limbah_jenis
          order by jenis_limbah";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getLokasi(){
      $query2 = "select location_code,location_name
              from er.er_location
              order by location_code";
      $result = $this->db->query($query2);
      return $result->result_array();
  }

  public function getLokasiName($lokasi){
      $query3 = "select location_name lokasi
              from er.er_location where location_code = '$lokasi'
              order by location_code";
      $result = $this->db->query($query3);
      return $result->result_array();
  }

  public function getUser()
  {
      $sql = "select * from ga.ga_limbah_user Order by nama";
      $query = $this->db->query($sql);
      return $query->result_array();
  }

  public function filterLimbahMasuk($tanggalawal = FALSE,$tanggalakhir = FALSE, $jenislimbahNew = FALSE, $lokasi)
  {
      $condition = '';
      if($jenislimbahNew == '' && $tanggalawal == '') {
          $condition = '';
      } else if($jenislimbahNew == true || $tanggalawal == true) {
          if($jenislimbahNew == true && $tanggalawal == true) {
              $condition = "and limjen.id_jenis_limbah in ($jenislimbahNew) and limkir.tanggal_kirim BETWEEN '$tanggalawal' AND '$tanggalakhir'";
          } elseif($jenislimbahNew != '') {
              $condition = "and limjen.id_jenis_limbah in ($jenislimbahNew)";
          } elseif($tanggalawal != '') {
              $condition = "and limkir.tanggal_kirim BETWEEN '$tanggalawal' AND '$tanggalakhir'";
          }
      }
// echo $condition;exit();
      $sqlfilterData = "SELECT
                          limkir.id_kirim,
                          limjen.id_jenis_limbah,
                          limjen.jenis_limbah,
                          cast(limkir.tanggal_kirim as date) tanggal,
                           sec.section_name sumber,
                           concat_ws(
                                 ' ',
                                 limkir.jumlah_kirim,
                                 (select limbah_satuan
                                 from ga.ga_limbah_satuan limsat
                                 where limsat.id_jenis_limbah = limjen.id_jenis_limbah),
                                 '(',limkir.berat_kirim,'kg )'
                           ) jumlah,
                           cast(limkir.tanggal_kirim + INTERVAL '3' MONTH as date) tanggalmax
                      FROM ga.ga_limbah_kirim limkir
                        inner join ga.ga_limbah_jenis limjen
                          on limjen.id_jenis_limbah = limkir.id_jenis_limbah
                            left join er.er_section sec
                      				on sec.section_code = concat(limkir.kodesie_kirim,'00')
                            where limkir.lokasi_kerja = '$lokasi' $condition
                          order by tanggal ASC";
      $query = $this->db->query($sqlfilterData);
      return $query->result_array();
  }

  public function filterLimbahKeluar($tanggalawal = FALSE,$tanggalakhir = FALSE, $jenislimbahNew2 = FALSE, $lokasi){
      $condition = '';
      if($jenislimbahNew2 == '' && $tanggalawal == '') {
          $condition = '';
      } else if($jenislimbahNew2 == true || $tanggalawal == true) {
          if($jenislimbahNew2 == true && $tanggalawal == true) {
              $condition = "and limjen.id_jenis_limbah in($jenislimbahNew2) and limkir.tanggal_kirim BETWEEN '$tanggalawal' AND '$tanggalakhir'";
          } elseif($jenislimbahNew2 != '') {
              $condition = "and limjen.id_jenis_limbah in($jenislimbahNew2)";
          } elseif($tanggalawal != '') {
              $condition = "and limkir.tanggal_kirim BETWEEN '$tanggalawal' AND '$tanggalakhir'";
          }
      }

      $sqlfilterData = " SELECT limkir.id_kirim,
                                cast(limkir.tanggal_kirim as date) tanggal,
                                concat_ws(
                                      ' ',
                                      limkir.jumlah_kirim,
                                      (select limbah_satuan
                                      from ga.ga_limbah_satuan limsat
                                      where limsat.id_jenis_limbah = limjen.id_jenis_limbah),
                                      '(',limkir.berat_kirim,'kg )'
                                ) jumlah
                                FROM ga.ga_limbah_kirim limkir
                                  inner join ga.ga_limbah_jenis limjen
                                    on limjen.id_jenis_limbah = limkir.id_jenis_limbah
                                    where limkir.lokasi_kerja = '$lokasi' $condition
                                    order by tanggal ASC ";
      $query = $this->db->query($sqlfilterData);
      return $query->result_array();
  }



}

 ?>
