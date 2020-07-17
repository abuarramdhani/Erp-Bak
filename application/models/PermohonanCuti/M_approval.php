<?php
defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 *
 */
class M_approval extends CI_MODEL
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->library('encrypt');
    $this->personalia = $this->load->database('personalia', TRUE);
  }

  public function getHubker($status)
  {
    $istimewa = '';
    if ($status == 'all') {
      $where = '';
    } else if ($status == '1') {
      $where = "ap.status = '$status' AND";
      $istimewa = "AND ap.ready = '1' AND pc.lm_jenis_cuti_id in('4','5','6','7','12')";
    } else {
      $where = "ap.status = '$status' AND";
    }
    $edp = "SELECT
              ap.lm_pengajuan_cuti_id as id_cuti, pc.noind, ap.status, ea.employee_name as name, jc.jenis_cuti, ap.alasan, pc.tanggal_status tgl, (select tipe_cuti from lm.lm_tipe_cuti where lm_tipe_cuti_id = pc.lm_tipe_cuti_id) as tipe, ap.alasan
            FROM lm.lm_pengajuan_cuti pc
              inner join er.er_employee_all ea
                on pc.noind = ea.employee_code
              inner join lm.lm_approval_cuti ap
                on pc.lm_pengajuan_cuti = ap.lm_pengajuan_cuti_id
              inner join lm.lm_jenis_cuti jc
                on pc.lm_jenis_cuti_id = jc.lm_jenis_cuti_id
            WHERE $where ap.level = '3' $istimewa order by pc.lm_pengajuan_cuti desc";
    return $this->db->query($edp)->result_array();
  }

  public function getCuti($noind, $status)
  {
    if ($status == 'all') {
      $status = "ap.status in('2','3') AND";
    } else {
      $status = "ap.status = '$status' AND";
    }
    $cuti = "SELECT
                    ap.lm_pengajuan_cuti_id as id_cuti, pc.noind, ap.status, ea.employee_name as name, jc.jenis_cuti, ap.alasan, pc.tgl_pengajuan tgl, pc.status, (select tipe_cuti from lm.lm_tipe_cuti where lm_tipe_cuti_id = pc.lm_tipe_cuti_id) as tipe, ap.alasan
                  FROM lm.lm_pengajuan_cuti pc
                    inner join er.er_employee_all ea
                      on pc.noind = ea.employee_code
                    inner join lm.lm_approval_cuti ap
                      on pc.lm_pengajuan_cuti = ap.lm_pengajuan_cuti_id
                    inner join lm.lm_jenis_cuti jc
                      on pc.lm_jenis_cuti_id = jc.lm_jenis_cuti_id
                  WHERE $status ap.approver = '$noind' and ap.ready = '1' order by pc.lm_pengajuan_cuti asc";
    $result = $this->db->query($cuti);
    return $result->result_array();
  }

  public function getDetail($id, $noind)
  {
    $detail = "SELECT pc.lm_pengajuan_cuti as id_cuti, pc.noind, emp.employee_name as nama ,pc.keterangan, tc.tipe_cuti as tipe, pc.tgl_pengajuan, jc.lm_jenis_cuti_id as id_jenis, jc.jenis_cuti as jenis, kp.keperluan as kp, pc.keperluan, pc.status , pc.tanggal_status, ap.alasan, ap.level
              FROM lm.lm_pengajuan_cuti pc
                inner join lm.lm_jenis_cuti jc
                  on pc.lm_jenis_cuti_id = jc.lm_jenis_cuti_id
                left join lm.lm_keperluan kp
                  on pc.lm_keperluan_id = kp.lm_keperluan_id
                inner join lm.lm_tipe_cuti tc
                  on pc.lm_tipe_cuti_id = tc.lm_tipe_cuti_id
                inner join er.er_employee_all emp
                  on pc.noind  = emp.employee_code
                inner join lm.lm_approval_cuti ap
                  on pc.lm_pengajuan_cuti = ap.lm_pengajuan_cuti_id
              WHERE pc.lm_pengajuan_cuti = '$id' and ap.approver = '$noind'";

    $result = $this->db->query($detail);
    return $result->result_array();
  }

  public function getKeterangan($kode)
  {
    return $this->personalia->query("SELECT kd_ket, keterangan FROM \"Presensi\".tketerangan WHERE kd_ket = '$kode'")->result_array();
  }

  public function getDataCuti($id_cuti)
  {
    $query = "SELECT pc.lm_tipe_cuti_id tipe, pc.lm_jenis_cuti_id jenis, pc.noind, (select employee_name from er.er_employee_all where employee_code = pc.noind) as nama FROM lm.lm_pengajuan_cuti pc WHERE lm_pengajuan_cuti = '$id_cuti'";
    return $this->db->query($query)->result_array();
  }

  public function getMail($who, $noind = false)
  {
    if ($who == 'user') {
      $params = "employee_code = '$noind'";
    } else {
      $params = "section_code like '401010100%' and internal_mail not like '-%'";
    }
    $query = "SELECT internal_mail FROM er.er_employee_all WHERE $params";
    return $this->db->query($query);
  }

  public function ApproverStatus($noind, $cuti_id)
  {
    $query = "SELECT status
              FROM lm.lm_approval_cuti
              WHERE approver = '$noind' and lm_pengajuan_cuti_id = '$cuti_id'";
    return $this->db->query($query)->result_array();
  }

  public function getApproverLevel($noind, $cuti_id)
  {
    $query = "SELECT level
              FROM lm.lm_approval_cuti
              WHERE approver = '$noind' and lm_pengajuan_cuti_id = '$cuti_id'";
    return $this->db->query($query)->row()->level;
  }

  public function getKdJbtn($noind)
  {
    return $this->personalia->query("SELECT kd_jabatan FROM hrd_khs.tpribadi WHERE noind = '$noind'")->row()->kd_jabatan;
  }

  public function updateApprove($id_cuti, $level, $approve, $thread, $alasan, $threadEDP, $threadEnd, $tipe, $jenis, $kdjabatanLv1, $noindCuti)
  {
    date_default_timezone_set('Asia/Jakarta');
    $now = date('d-M-Y H:i:s');
    $this->db->insert('lm.lm_pengajuan_cuti_thread', $thread);

    $nextAppr = '4,5,6,7'; // untuk cuti yg membutuhkan approver EDP

    //Level 1 -> if user clicked the button is lv1 on approval cuti
    if ($level == '1') {
      if (strstr("02,03,04", $kdjabatanLv1)) {
        $query = "UPDATE lm.lm_approval_cuti
                  SET status = '$approve', alasan = '$alasan'
                  WHERE level = '1' and lm_pengajuan_cuti_id = '$id_cuti' ";
        $this->db->query($query);

        if ($approve == '2') {
          if (strstr($nextAppr, $jenis)) {
            $this->db->insert('lm.lm_pengajuan_cuti_thread', $threadEDP);
            $toEDP = "UPDATE lm.lm_approval_cuti
                       SET ready = '1'
                       WHERE level = '3' and lm_pengajuan_cuti_id = '$id_cuti' ";
            $this->db->query($toEDP);
          } else {
            $statusrjct = "UPDATE lm.lm_pengajuan_cuti
                           SET status = '$approve', tanggal_status = '$now'
                           WHERE lm_pengajuan_cuti = '$id_cuti' ";
            $this->db->query($statusrjct);
          }
          $this->updateDataPresensi($id_cuti);
          if ($tipe == '1') {
            $this->perhitunganCutOff($id_cuti);
            $this->updateDataCutiTahunan($noindCuti, $id_cuti);
          }
        } else {
          $statusrjct = "UPDATE lm.lm_pengajuan_cuti
                         SET status = '$approve', tanggal_status = '$now'
                         WHERE lm_pengajuan_cuti = '$id_cuti' ";
          $this->db->query($statusrjct);
        }
      } else {
        $query = "UPDATE lm.lm_approval_cuti
                  SET status = '$approve', alasan = '$alasan'
                  WHERE level = '1' and lm_pengajuan_cuti_id = '$id_cuti' ";
        $this->db->query($query);
        if ($approve == '2') {
          $query1 = "UPDATE lm.lm_approval_cuti
                     SET ready = '1'
                     WHERE level = '2' and lm_pengajuan_cuti_id = '$id_cuti' ";
          $this->db->query($query1);
        } else {
          $statusrjct = "UPDATE lm.lm_pengajuan_cuti
                         SET status = '$approve', tanggal_status = '$now'
                         WHERE lm_pengajuan_cuti = '$id_cuti' ";
          $this->db->query($statusrjct);
        }
      }
    }
    //Level 2 -> also like that
    elseif ($level == '2') {
      $query4 = "UPDATE lm.lm_approval_cuti
                 SET status = '$approve', alasan = '$alasan'
                 WHERE level = '2' and lm_pengajuan_cuti_id = '$id_cuti' ";
      $this->db->query($query4);
      if ($approve == '2') {
        if (strstr($nextAppr, $jenis)) {
          $this->db->insert('lm.lm_pengajuan_cuti_thread', $threadEDP);
          $toEDP = "UPDATE lm.lm_approval_cuti
                     SET ready = '1'
                     WHERE level = '3' and lm_pengajuan_cuti_id = '$id_cuti' ";
          $this->db->query($toEDP);
        } else { //end approval
          $statusapproved = "UPDATE lm.lm_pengajuan_cuti
                             SET status = '2', tanggal_status = '$now'
                             WHERE lm_pengajuan_cuti = '$id_cuti'";
          $this->db->query($statusapproved);
          $this->db->insert('lm.lm_pengajuan_cuti_thread', $threadEnd);
          $updateEDP = "UPDATE lm.lm_approval_cuti
                        SET status = '2'
                        WHERE lm_pengajuan_cuti_id = '$id_cuti' AND level = '3'";
          $this->db->query($updateEDP);
          if ($tipe == '1') {
            $this->perhitunganCutOff($id_cuti);
            $this->updateDataCutiTahunan($noindCuti, $id_cuti);
          }
          $this->updateDataPresensi($id_cuti);
        }
      } else {
        $statusrjct2 = "UPDATE lm.lm_pengajuan_cuti
                        SET status = '3', tanggal_status = '$now'
                        WHERE lm_pengajuan_cuti = '$id_cuti' ";
        $this->db->query($statusrjct2);
        $this->db->insert('lm.lm_pengajuan_cuti_thread', $threadEnd);
      }
    }

    //Level 3 -> this is EDP
    else {
      $query = "UPDATE lm.lm_approval_cuti
                SET status = '$approve', alasan = '$alasan'
                WHERE level ='3' and lm_pengajuan_cuti_id = '$id_cuti' ";
      $this->db->query($query);
      $statusEDP = "UPDATE lm.lm_pengajuan_cuti
                     SET status = '$approve', tanggal_status = '$now'
                     WHERE lm_pengajuan_cuti = '$id_cuti' ";
      $this->db->query($statusEDP);
      $this->db->insert('lm.lm_pengajuan_cuti_thread', $threadEnd);
      $this->perhitunganCutOff($id_cuti);
      $this->updateDataPresensi($id_cuti);
    }
  }

  public function getReadyNextApprover($level, $id_cuti)
  {
    if ($level == 'EDP') {
      return '0';
    } else {
      $level = intval($level) + 1;
      return $this->db->query("select ready from lm.lm_approval_cuti where lm_pengajuan_cuti_id = '$id_cuti' and level = '$level' and ready = '1'")->num_rows();
    }
  }

  public function cancelCuti($noind, $id, $tipe, $alasan)
  {
    $year = date('Y');
    $now = date('d-M-Y H:i:s');
    $session = $this->session->user;

    $reject = "UPDATE lm.lm_pengajuan_cuti SET status = '4' WHERE lm_pengajuan_cuti = '$id'";
    $this->db->query($reject);
    $selectTgl = "SELECT tgl_pengambilan FROM lm.lm_pengajuan_cuti_tgl_ambil WHERE lm_pengajuan_cuti_id = '$id'";
    $getdate = $this->db->query($selectTgl)->result_array();
    $noind_baru = $this->personalia->query("select noind_baru from hrd_khs.tpribadi where noind = '$noind'")->row()->noind_baru;

    //delete tgl & insert tlog//
    foreach ($getdate as $key) {
      $date = $key['tgl_pengambilan'];
      $checkPresensi = $this->personalia->query("SELECT count(tanggal) FROM \"Presensi\".tdatapresensi WHERE noind = '$noind' AND tanggal = '$date'")->row()->count;
      if ($checkPresensi > 0) {
        $log = "INSERT INTO hrd_khs.tlog (wkt, menu, ket, noind, jenis, program, noind_baru) VALUES (now(), 'ERP CUTI -> HAPUS DATA PRES', 'NOIND -> $noind TANGGAL -> $date', '$session', 'HAPUS -> PRESENSI CUTI', 'CUTI', '$noind_baru')";
        $this->personalia->query($log);
      }
      $delete = "DELETE FROM \"Presensi\".tdatapresensi where noind = '$noind' and tanggal = '$date'";
      $this->personalia->query($delete);
    }

    //update back sisacuti if CT//
    if ($tipe == 'Cuti Tahunan') {
      $countTgl = count($getdate);
      $sisa = "UPDATE \"Presensi\".tdatacuti SET
                sisa_cuti_tot = (select sisa_cuti_tot from \"Presensi\".tdatacuti where noind = '$noind' and periode = '$year') + '" . $countTgl . "',
                sisa_cuti = (select sisa_cuti from \"Presensi\".tdatacuti where noind = '$noind' and periode = '$year')+'" . $countTgl . "'
               WHERE noind = '$noind' AND periode = '$year'";
      $this->personalia->query($sisa);
    }

    //update reason edp//
    $this->db->query("UPDATE lm.lm_approval_cuti set alasan = '$alasan', status = '4' where lm_pengajuan_cuti_id = '$id' and level = '3'");

    //insert thread//
    $threadCancel = array(
      'lm_pengajuan_cuti_id' => $id,
      'status' => '3',
      'detail' => '(Pembatalan Cuti) - Seksi EDP (Electronic Data Processing) telah membatalkan cuti ini dengan alasan "' . $alasan . '"',
      'waktu'  => $now
    );
    $this->db->insert('lm.lm_pengajuan_cuti_thread', $threadCancel);
  }

  public function updateDataCutiTahunan($noind, $id_cuti)
  {
    $periode     = date('Y');
    $jumlahambil = "SELECT tgl_pengambilan FROM lm.lm_pengajuan_cuti_tgl_ambil WHERE lm_pengajuan_cuti_id = '$id_cuti'";
    $jumlahambil = $this->db->query($jumlahambil)->result_array();
    $jumlahambil = count($jumlahambil);
    $datacuti    = "SELECT sisa_cuti, sisa_cuti_tot FROM \"Presensi\".tdatacuti WHERE noind = '$noind' and periode = '$periode'";
    $datacuti    = $this->personalia->query($datacuti)->result_array();
    $sisacuti    = $datacuti['0']['sisa_cuti'];
    $cutiakhir   = $sisacuti - $jumlahambil;
    $sisacutitotal = $datacuti['0']['sisa_cuti_tot'] - $jumlahambil;

    $query = "UPDATE \"Presensi\".tdatacuti SET sisa_cuti = '$cutiakhir', sisa_cuti_tot = '$sisacutitotal' where noind = '$noind' and periode = '$periode'";
    $this->personalia->query($query);
  }

  public function updateDataPresensi($id_cuti)
  {
    $query = "SELECT
                  pc.noind, pc.keterangan, pc.keperluan, (select section_code from er.er_employee_all emp where emp.employee_code = noind) kodesie
              FROM lm.lm_pengajuan_cuti pc
              WHERE lm_pengajuan_cuti = '$id_cuti'";
    $id    = $this->db->query($query)->result_array();

    $tglambil = "SELECT
                    tgl_pengambilan
                 FROM lm.lm_pengajuan_cuti_tgl_ambil
                 WHERE lm_pengajuan_cuti_id = '$id_cuti'";
    $date = $this->db->query($tglambil)->result_array();

    $session    = $this->session->user;
    $noind      = $id['0']['noind'];
    $kodesie    = $id['0']['kodesie'];
    $keterangan = $id['0']['keterangan'];
    $keperluan  = strtoupper($id['0']['keperluan']);
    $kd_ket     = $id['0']['keterangan'];
    $noind_baru = $this->personalia->query("SELECT noind_baru FROM hrd_khs.tpribadi WHERE noind = '$noind'")->row()->noind_baru;

    for ($i = 0; $i < count($date); $i++) {
      $tanggal = $date[$i]['tgl_pengambilan'];

      $checkShift = "SELECT count(tanggal) FROM \"Presensi\".tshiftpekerja WHERE tanggal = '$tanggal' AND noind = '$noind'";
      $checkShift = $this->personalia->query($checkShift)->result_array();

      $checkPresensi = "SELECT count(tanggal) FROM \"Presensi\".tdatapresensi WHERE tanggal = '$tanggal' AND noind = '$noind'";
      $checkPresensi = $this->personalia->query($checkPresensi)->result_array();

      $data = array(
        'tanggal'       => $date[$i]['tgl_pengambilan'],
        'noind'         => $id['0']['noind'],
        'kodesie'       => $id['0']['kodesie'],
        'masuk'         => '0',
        'keluar'        => '0',
        'kd_ket'        => $id['0']['keterangan'],
        'total_lembur'  => '0',
        'user_'         => 'ERPCT',
        'noind_baru'    => $noind_baru,
        'alasan'        => strtoupper($id['0']['keperluan'])
      );

      if ($checkShift['0']['count'] > '0') {
        if ($checkPresensi['0']['count'] > '0') {
          $getKetBefore = "SELECT kd_ket FROM \"Presensi\".tdatapresensi WHERE tanggal = '$tanggal' and noind = '$noind'";
          $ketBefore    = $this->personalia->query($getKetBefore)->row()->kd_ket;

          $logupdate = "INSERT INTO hrd_khs.tlog (wkt, menu, ket, noind, jenis, program, noind_baru) VALUES (now(), 'ERP CUTI -> UPDATE DATA PRES', 'NOIND -> $noind TANGGAL -> $tanggal', '$session', 'UBAH -> KETERANGAN $ketBefore -> $keterangan', 'CUTI', '$noind_baru')";
          $this->personalia->query($logupdate);

          $update = "UPDATE \"Presensi\".tdatapresensi SET
                      tanggal = '$tanggal', noind = '$noind', kodesie = '$kodesie', masuk = '0', keluar = '0', kd_ket = '$keterangan', total_lembur = '0', user_ = 'ERPCT', noind_baru = '$noind_baru', create_timestamp = now(), alasan = '$keperluan'
                     WHERE tanggal = '$tanggal' AND noind = '$noind'";
          $this->personalia->query($update);
        } else {
          $this->personalia->insert("\"Presensi\".tdatapresensi", $data);
          $logupdate = "INSERT INTO hrd_khs.tlog (wkt, menu, ket, noind, jenis, program, noind_baru) VALUES (now(), 'ERP CUTI -> INSERT DATA PRES', 'NOIND ->$noind TANGGAL -> $tanggal', '$session', 'SIMPAN -> CUTI $keterangan', 'CUTI', '$noind_baru')";
          $this->personalia->query($logupdate);
        }
      }
    }
  }

  function perhitunganCutOff($id_cuti)
  {
    // select end cutoff terakhir
    $akhir_cut_off = $this->personalia->query("SELECT tanggal_akhir FROM tcutoff WHERE to_char(tanggal_akhir, 'YYYY-MM') = to_char(now(), 'YYYY-MM') LIMIT 1;")->row()->tanggal_akhir;
    $today = date('Y-m-d'); //tgl approval terakhir / hari ini
    // cek tgl approve approval terakhir apakah melebihi tgl akhir cutoff
    if ($today > $akhir_cut_off) {
      //change to cuti susulan
      $this->db->query("UPDATE lm.lm_pengajuan_cuti SET lm_jenis_cuti_id = '13' WHERE lm_pengajuan_cuti = '$id_cuti'");
      //select tgl cuti <= cut_off
      $tgl = "SELECT tgl_pengambilan FROM lm.lm_pengajuan_cuti_tgl_ambil WHERE lm_pengajuan_cuti_id = '$id_cuti' AND tgl_pengambilan <= '$akhir_cut_off'";
      $all_date = $this->db->query($tgl)->result_array();

      if (!empty($all_date)) {
        //select noind cuti
        $noind = $this->db->query("SELECT noind FROM lm.lm_pengajuan_cuti WHERE lm_pengajuan_cuti = '$id_cuti'")->row()->noind;
        //insert ke tsusulan
        foreach ($all_date as $key) {
          $tgl  = $key['tgl_pengambilan'];
          $data = array(
            'noind'       => $noind,
            'tanggal'     => $tgl,
            'stat'        => false,
            'reffgaji'    => null,
            'ket'         => 'CT',
            'user_'       => $this->session->user,
            'noind_baru'  => null
          );
          // cek presensi dimana yg susulan cuma dimana hari mangkir
          $insertSusulan = $this->personalia->insert('Presensi.tsusulan', $data);
        }
      }
    }
  }
}
// end class
