<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_handling extends CI_Model
{
  public function __construct()
  {
      parent::__construct();
      $this->load->database();
      $this->personalia = $this->load->database('personalia',true);
  }

  public function getSeksi($param)
  {
    return $this->personalia->query("SELECT DISTINCT hks.seksi seksi
                      FROM hrd_khs.tseksi hks
                      WHERE hks.seksi LIKE '%$param%'
                      AND hks.seksi != '-'
                      AND hks.seksi NOT LIKE '*%'
                      -- ORDER BY hks.seksi"
                      )->result_array();
  }

  public function getDataAudite($seksi_handling)
  {
    return $this->db->query("SELECT avha.id id,
                             avht.id id_temuan,
                             avhj.id id_jawaban,
                             DATE(avha.tanggal_audit) tanggal_audit,
                             avha.poin_penyimpangan poin_penyimpangan,
                             avht.foto_before foto_before,
                             avhj.action_plan action_plan,
                             avhj.foto_after foto_after,
                             avht.alasan_masih_open alasan_masih_open,
                             avha.status status
                      FROM (avh.avh_audit avha
                      LEFT JOIN avh.avh_temuan avht ON avha.id = avht.id_audit)
                      LEFT JOIN avh.avh_jawaban avhj ON avhj.id = avht.id_jawaban
                      WHERE --AND avha.status = 'CLOSE'
                      avha.area = '$seksi_handling'
                      AND avha.tim = 'Handling'
                      ORDER BY avha.status DESC, avht.id_audit DESC, avhj.id DESC")->result_array();
  }

  public function getGambarBefore($id_before)
  {
    return $this->db->query("SELECT DISTINCT avht.foto_before foto_before
                      FROM (avh.avh_audit avha
                      LEFT JOIN avh.avh_temuan avht ON avha.id = avht.id_audit)
                      LEFT JOIN avh.avh_jawaban avhj ON avht.id = avhj.id_temuan
                      WHERE avht.id = '$id_before'")->result_array();
  }

  public function getGambarAfter($id_after)
  {
    return $this->db->query("SELECT avhj.foto_after foto_after
                      FROM (avh.avh_audit avha
                      LEFT JOIN avh.avh_temuan avht ON avha.id = avht.id_audit)
                      LEFT JOIN avh.avh_jawaban avhj ON avht.id = avhj.id_temuan
                      WHERE avhj.id = $id_after")->result_array();
  }

  public function handlingPDF($id_audit)
  {
    return $this->db->query("SELECT DATE(avha.tanggal_audit) tanggal_audit,
                             DATE(avht.last_update_date) tanggal_verifikasi,
                             avht.last_update_date waktu_verifikasi,
                             avhj.last_update_date waktu_selesai,
                             avhj.last_update_by last_update_by_jawaban,
                             avht.last_update_by last_update_by_temuan,
                             avha.tim tim,
                             avha.area area,
                             avha.sarana_handling sarana_handling,
                             avha.poin_penyimpangan poin_penyimpangan,
                             avhj.action_plan action_plan,
                             DATE(avhj.last_update_date) tanggal_selesai,
                             avha.status status
                      FROM (avh.avh_audit avha
                      LEFT JOIN avh.avh_temuan avht ON avha.id = avht.id_audit)
                      LEFT JOIN avh.avh_jawaban avhj ON avhj.id = avht.id_jawaban--avht.id = avhj.id_temuan --avht.id_audit = avhj.id_audit
                      WHERE avha.id = '$id_audit'
                      ORDER BY avhj.last_update_date DESC, avht.id DESC, avhj.id DESC LIMIT 3")->result_array();
  }

  public function getSaranaHandling()
  {
    return $this->db->query("SELECT avhs.id id,
                             avhs.sarana_handling sarana,
                             avhs.last_update_date last_update_date,
                             avhs.last_update_by last_update_by
                      FROM avh.avh_sarana avhs
                      ORDER BY id")->result_array();
  }

  public function gambarHandlingPDF($id_temuan)
  {
    return $this->db->query("SELECT avht.foto_before foto_before,
                             avhj.foto_after foto_after
                      FROM (avh.avh_audit avha
                      LEFT JOIN avh.avh_temuan avht ON avha.id = avht.id_audit)
                      LEFT JOIN avh.avh_jawaban avhj ON avht.id_jawaban = avhj.id
                      WHERE avht.id = '$id_temuan'
                      ORDER BY avht.id DESC, avhj.id DESC LIMIT 1")->result_array();
  }

  public function getJumlahGeneralAudite()
  {
    return $this->db->query("SELECT count(*) AS jumlah_general FROM avh.avh_audit")->result_array();
  }

  public function getStatusGeneralAudite()
  {
    return $this->db->query("SELECT status,
                             count(*) jumlah_per_status,
                             round(count(*) * 100.00 / (select count(*) FROM avh.avh_audit),2)||'%' persen_per_status
                             FROM avh.avh_audit
                             GROUP BY status
                             ORDER BY status DESC")->result_array();
  }

  public function getGeneralPoinPenyimpangan()
  {
    return $this->db->query("SELECT poin_penyimpangan,
                             count(*) jumlah_per_pp,
                             round(count(*) * 100.00 / (select count(*) FROM avh.avh_audit),2)||'%' persen_per_pp
                             FROM avh.avh_audit
                             GROUP BY poin_penyimpangan
                             ORDER BY poin_penyimpangan")->result_array();
  }

  public function getJumlahSeksiAudite($seksi_handling)
  {
    return $this->db->query("SELECT count(*) AS jumlah_seksi FROM avh.avh_audit WHERE area = '$seksi_handling'")->result_array();
  }

  public function getStatusSeksiAudite($seksi_handling)
  {
    return $this->db->query("SELECT status,
                             count(*) jumlah_per_status_seksi,
                             round(count(*) * 100.00 / (select count(*) FROM avh.avh_audit WHERE area = '$seksi_handling'),2)||'%' persen_per_status_seksi
                             FROM avh.avh_audit WHERE area = '$seksi_handling'
                             GROUP BY status
                             ORDER BY status DESC")->result_array();
  }

  public function getSeksiPoinPenyimpangan($seksi_handling)
  {
    return $this->db->query("SELECT poin_penyimpangan,
                             count(*) jumlah_per_pp_seksi,
                             round(count(*) * 100.00 / (select count(*) FROM avh.avh_audit WHERE area = '$seksi_handling'),2)||'%' persen_per_pp_seksi
                             FROM avh.avh_audit WHERE area = '$seksi_handling'
                             GROUP BY poin_penyimpangan
                             ORDER BY poin_penyimpangan")->result_array();
  }
}
