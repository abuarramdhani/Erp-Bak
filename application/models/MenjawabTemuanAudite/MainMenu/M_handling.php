<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_handling extends CI_Model
{
  public function __construct()
  {
      parent::__construct();
      $this->load->database();
      $this->personalia = $this->load->database('personalia',true);
      // $this->oracle = $this->load->database('oracle', true);
  }

  // public function getSeksi($param)
  // {
    // return $this->personalia->query("SELECT DISTINCT hks.seksi seksi
    //                   FROM hrd_khs.tseksi hks
    //                   WHERE hks.seksi LIKE '%$param%'
    //                   AND hks.seksi != '-'
    //                   AND hks.seksi NOT LIKE '*%'
    //                   ORDER BY hks.seksi"
    //                   )->result_array();
    // return $this->oracle->query("SELECT DISTINCT ffvt.DESCRIPTION,
    //                              ffv.ATTRIBUTE10
    //                   FROM fnd_flex_values ffv,
    //                   fnd_flex_values_TL ffvt
    //                   WHERE ffvt.DESCRIPTION LIKE '%$param%'
    //                   AND ffv.FLEX_VALUE_SET_ID = 1013709
    //                   AND ffv.ATTRIBUTE10 != ' '
    //                   AND ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID
    //                   AND ffv.END_DATE_ACTIVE IS NULL
    //                   AND ffv.ENABLED_FLAG = 'Y'
    //                   -- ORDER BY ffv.FLEX_VALUE")->result_array();
  // }

  public function getSeksiLogged($no_induk)
  {
    return $this->personalia->select('seksi')
                               ->join('hrd_khs.tseksi', 'hrd_khs.tseksi.kodesie = hrd_khs.tpribadi.kodesie', 'left')
                               ->where('noind', $no_induk)
                               ->get('hrd_khs.tpribadi')
                               ->row_array();
  }

  public function getAuditOpen($area_handling)
  {
    // return $this->db->query("SELECT avht.id_audit id_audit,
    //                          avht.tanggal_audit tanggal_audit,
    //                          avht.poin_penyimpangan poin_penyimpangan,
    //                          avht.foto_before foto_before,
    //                          avhj.action_plan action_plan,
    //                          avhj.foto_after foto_after,
    //                          avht.alasan_open alasan_open
    //                   FROM avh.avh_temuan_audit avht
    //                   LEFT JOIN avh.avh_jawaban_audit avhj ON avht.id_audit = avhj.id_audit
    //                   WHERE avht.status = 'OPEN'
    //                   AND   avht.area = '$seksi_handling'
    //                   ORDER BY avht.id DESC, avhj.id DESC LIMIT 1")->result_array();

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
                      avha.area = '$area_handling'
                      AND avha.tim = 'Handling'
                      ORDER BY avha.status DESC, avht.id_audit DESC, avht.id DESC")->result_array();
  }

  public function getAudit($id_temuan)
  {
    // return $this->db->query("SELECT avht.id_audit id_audit,
    //                         avht.id id,
    //                         avht.poin_penyimpangan poin_penyimpangan,
    //                         avhj.tanggal_verif tanggal_verif,
    //                         avhj.action_plan action_plan,
    //                         avht.alasan_open alasan_open,
    //                         avht.foto_before foto_before,
    //                         avhj.foto_after foto_after,
    //                         avht.last_update_by last_update_by_temuan,
    //                         avhj.last_update_by last_update_by_jawaban,
    //                         avht.last_update_date last_update_date_temuan,
    //                         avhj.last_update_date last_update_date_jawaban,
    //                         avht.tanggal_audit tanggal_audit,
    //                         avht.sarana_handling sarana_handling,
    //                         avht.tim tim,
    //                         avht.area area,
    //                         avht.status status
    //                   FROM avh.avh_temuan_audit avht
    //                   LEFT JOIN avh.avh_jawaban_audit avhj ON avht.id_audit = avhj.id_audit
    //                   WHERE avht.id_audit = '$plaintext_string'
    //                   ORDER BY avht.id DESC, avhj.id DESC LIMIT 1")->result_array();

    return $this->db->query("SELECT DATE(avha.tanggal_audit) tanggal_audit,
                             avha.id id,
                             avht.id id_temuan,
                             avhj.id id_jawaban,
                             avha.poin_penyimpangan poin_penyimpangan,
                             avht.alasan_masih_open alasan_masih_open,
                             avht.foto_before foto_before,
                             avht.last_update_date last_update_date_temuan,
                             avht.last_update_by last_update_by_temuan
                      FROM (avh.avh_audit avha
                      LEFT JOIN avh.avh_temuan avht ON avha.id = avht.id_audit)
                      LEFT JOIN avh.avh_jawaban avhj ON avht.id = avhj.id_temuan
                      WHERE avht.id = '$id_temuan'
                      OR avhj.id_temuan = '$id_temuan'
                      ORDER BY avhj.id DESC--ORDER BY avht.id DESC, avhj.id DESC LIMIT 1")->result_array();
  }

  public function getAuditY($id_audit)
  {
    return $this->db->query("SELECT DISTINCT avhj.action_plan action_plan,
                             avhj.foto_after foto_after,
                             avhj.last_update_date last_update_date_jawaban,
                             avhj.last_update_by last_update_by_jawaban
                      FROM (avh.avh_audit avha
                      LEFT JOIN avh.avh_jawaban avhj ON avha.id = avhj.id_audit)
                      LEFT JOIN avh.avh_temuan avht ON avhj.id_audit = avht.id_audit
                      WHERE avhj.id_audit = '$id_audit'
                      AND avht.id_audit = '$id_audit'
                      ORDER BY avhj.last_update_date DESC")->result_array();
  }

  public function getAuditAlasan($id_audit)
  {
    return $this->db->query("SELECT DISTINCT avht.alasan_masih_open alasan_masih_open,
                                             avht.last_update_date last_update_date_temuan,
                                             avht.last_update_by last_update_by_temuan
                      FROM (avh.avh_audit avha
                      LEFT JOIN avh.avh_jawaban avhj ON avha.id = avhj.id_audit)
                      LEFT JOIN avh.avh_temuan avht ON avhj.id_audit = avht.id_audit
                      WHERE avhj.id_audit = '$id_audit'
                      AND avht.id_audit = '$id_audit'
                      AND avht.alasan_masih_open IS NOT NULL
                      ORDER BY last_update_date_temuan DESC")->result_array();
  }

  // public function getAuditLog($id_audit)
  // {
  //   return $this->db->query("SELECT avhj.action_plan action_plan,
  //                            avhj.last_update_date last_update_date_jawaban,
  //                            avhj.last_update_by last_update_by_jawaban,
  //                            avht.alasan_masih_open alasan_masih_open,
  //                            avht.last_update_date last_update_date_temuan,
  //                            avht.last_update_by last_update_by_temuan
  //                     FROM (avh.avh_audit avha
  //                     LEFT JOIN avh.avh_temuan avht ON avha.id = avht.id_audit)
  //                     LEFT JOIN avh.avh_jawaban avhj ON avht.id = avhj.id_temuan
  //                     WHERE avht.id_audit = '$id_audit'
  //                     ORDER BY avhj.id DESC")->result_array();
  // }

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
    // return $this->db->query("SELECT DATE(avha.tanggal_audit) tanggal_audit,
    //                          avha.tim tim,
    //                          avha.area area,
    //                          avha.sarana_handling sarana_handling,
    //                          avha.poin_penyimpangan poin_penyimpangan,
    //                          avhj.action_plan action_plan,
    //                          DATE(avhj.last_update_date) tanggal_verifikasi,
    //                          avha.status status
    //                   FROM avh.avh_audit avha,
    //                   avh.avh_temuan avht,
    //                   avh.avh_jawaban avhj
    //                   WHERE avha.id = '$plaintext_string'
    //                   AND avht.id = avhj.id_temuan,
    //                   AND avhj.id = avht.id_jawaban
    //                   ORDER BY avht.id DESC, avhj.id DESC LIMIT 3")->result_array();
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
    // return $this->db->query("SELECT avht.foto_before foto_before,
    //                         avhj.foto_jawaban foto_jawaban
    //                   FROM (avh.avh_audit
    //                   LEFT JOIN avh.avh_temuan avht ON avha.id = avht.id_audit)
    //                   LEFT JOIN avh.avh_jawaban avhj ON avht.id = avhj.id_temuan
    //                   WHERE avht.id = '$plaintext_string'
    //                   OR avhj.id_temuan = '$plaintext_string'")->result_array();
  }

  public function getGambarBefore($id_before)
  {
    return $this->db->query("SELECT avht.foto_before foto_before
                      FROM (avh.avh_audit avha
                      LEFT JOIN avh.avh_temuan avht ON avha.id = avht.id_audit)
                      LEFT JOIN avh.avh_jawaban avhj ON avht.id = avhj.id_temuan
                      WHERE avht.id = $id_before")->result_array();
  }

  public function getGambarAfter($id_after)
  {
    return $this->db->query("SELECT avhj.foto_after foto_after
                      FROM (avh.avh_audit avha
                      LEFT JOIN avh.avh_temuan avht ON avha.id = avht.id_audit)
                      LEFT JOIN avh.avh_jawaban avhj ON avht.id = avhj.id_temuan
                      WHERE avhj.id = $id_after")->result_array();
  }

  public function insMenjawabHandling($data)
  {
    return $this->db->insert('avh.avh_jawaban', $data);
    // $sql = "INSERT INTO avh.avh_jawaban_audit (id_audit, action_plan, foto_after,
    //         tanggal_verif, last_update_date, last_update_by, alasan_masih_open)
    //          VALUES ('$data')";
    // $query = $this->db->query($sql);
  }

  public function updMenjawabHandling($id_temuan, $id_jawaban)
  {
    return $this->db->query("UPDATE avh.avh_temuan
                      SET id_jawaban = '$id_jawaban'
                      WHERE id = '$id_temuan'");
  }

  public function insPoinPenyimpangan($data)
  {
    return $this->db->insert('avh.avh_penyimpangan', $data);
  }

  public function getPoinPenyimpangan()
  {
    return $this->db->query("SELECT avhp.id id,
                             avhp.poin poin,
                             avhp.last_update_date last_update_date,
                             avhp.last_update_by last_update_by
                      FROM avh.avh_penyimpangan avhp
                      ORDER BY id
                      ")->result_array();
  }

  public function deletePoinPenyimpangan($id)
  {
    return $this->db->query("DELETE FROM avh.avh_penyimpangan WHERE id = '$id'");
  }

  public function getPP($id)
  {
    return $this->db->query("SELECT avhp.id id,
                             avhp.poin poin,
                             avhp.last_update_date last_update_date,
                             avhp.last_update_by last_update_by
                      FROM avh.avh_penyimpangan avhp
                      WHERE id = '$id'")->row_array();
  }

  public function updatePP($id, $poin, $last_update_date, $last_update_by)
  {
    return $this->db->query("UPDATE avh.avh_penyimpangan
                      SET poin = '$poin',
                          last_update_date = '$last_update_date',
                          last_update_by = '$last_update_by'
                      WHERE id = '$id'");
  }
  // public function getKondisiAudit($id_audit)
  // {
  //   return $this->db->query("SELECT avhj.id_audit id_audit,
  //                           avhj.alasan_masih_open alasan_masih_open;
  //                     FROM avh.avh_temuan_audit avht,
  //                          avh.avh_jawaban_audit avhj
  //                     WHERE avht.status = 'OPEN'
  //                     AND avhj.alasan_masih_open IS NULL
  //                     AND avht.id_audit = '$id_audit'
  //                          ")->row_array();
  // }
}
