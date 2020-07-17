<?php
defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 *
 */
class M_permohonancuti extends CI_MODEL
{
  public function __construct()
  {
    parent::__construct();
    $this->personalia = $this->load->database('personalia', TRUE);
    $this->load->database();
    $this->load->library('encrypt');
  }

  // -------------- --------------------------global function fOR menu cuti----------------------------------------------- //
  public function getPekerja($noind)
  {
    $query  = "SELECT tp.nama, tp.noind, ts.seksi, ts.unit, ts.dept, ts.kodesie, tp.kd_jabatan
               FROM hrd_khs.tpribadi tp inner join hrd_khs.tseksi ts on tp.kodesie = ts.kodesie
               WHERE tp.noind = '$noind'";
    $result = $this->personalia->query($query);
    return $result->result_array();
  }

  public function getAllUser()
  { //maybe not needed
    $query = $this->db->get('sys.sys_user');
    return $query->result_array();
  }

  public function getApproval($noind, $kodesie)
  { //to get approval next
    $jabatan = "SELECT kd_jabatan, lokasi_kerja
                FROM hrd_khs.tpribadi
                WHERE noind = '$noind'";
    $jbtn    = $this->personalia->query($jabatan)->row()->kd_jabatan;
    $loker   = $this->personalia->query($jabatan)->row()->lokasi_kerja;
    $query1  = "SELECT tp.noind, tp.nama, tp.kd_jabatan, tp.jabatan
                FROM hrd_khs.tpribadi tp
                 inner join hrd_khs.torganisasi c on c.kd_jabatan=tp.kd_jabatan
                 inner join hrd_khs.tseksi ts on ts.kodesie = tp.kodesie
                 inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind
                WHERE tp.keluar = '0' AND CASE
                         WHEN '$jbtn' in('14','15','16','17') then
                            CASE
                              WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('13') AND tp.keluar = '0' AND left('$kodesie',7) = left(tj.kodesie,7) limit 1) = '0' then tp.kd_jabatan in('13') AND left('$kodesie',7) = left(tj.kodesie,7)
                              WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('10','11','12') AND tp.keluar = '0' AND left('$kodesie',7) = left(tj.kodesie,7) limit 1) = '0' then tp.kd_jabatan in('10','11','12') AND left('$kodesie',7) = left(tj.kodesie,7)
                              WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('08','09') AND tp.keluar = '0' AND left('$kodesie',5) = left(tj.kodesie,5) limit 1) = '0' then tp.kd_jabatan in('08','09') AND left('$kodesie',5) = left(tj.kodesie,5)
                              WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('07','06','05') AND tp.keluar = '0' AND left('$kodesie',3) = left(tj.kodesie,3) limit 1) = '0' then tp.kd_jabatan in('05','06','07') AND left('$kodesie',3) = left(tj.kodesie,3)
                              WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('02','03','04') AND tp.keluar = '0' AND left('$kodesie',1) = left(tj.kodesie,1) limit 1) = '0' then tp.kd_jabatan in('02','03','04') AND left('$kodesie',1) = left(tj.kodesie,1)
                             ELSE tp.noind = 'a'
                            END
                          WHEN '$jbtn' in('13') then
                             CASE
                               WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('10','11','12') AND tp.keluar = '0' AND left('$kodesie',7) = left(tj.kodesie,7) limit 1) = '0' then tp.kd_jabatan in('10','11','12') AND left('$kodesie',7) = left(tj.kodesie,7)
                               WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('08','09') AND tp.keluar = '0' AND left('$kodesie',5) = left(tj.kodesie,5) limit 1) = '0' then tp.kd_jabatan in('08','09') AND left('$kodesie',5) = left(tj.kodesie,5)
                               WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('07','06','05') AND tp.keluar = '0' AND left('$kodesie',3) = left(tj.kodesie,3) limit 1) = '0' then tp.kd_jabatan in('05','06','07') AND left('$kodesie',3) = left(tj.kodesie,3)
                               WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('02','03','04') AND tp.keluar = '0' AND left('$kodesie',1) = left(tj.kodesie,1) limit 1) = '0' then tp.kd_jabatan in('02','03','04') AND left('$kodesie',1) = left(tj.kodesie,1)
                              ELSE tp.noind = 'a'
                             END
                         WHEN '$jbtn' in('11','12') then
                            CASE
                             WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('10') AND tp.keluar = '0' AND left('$kodesie',7) = left(tj.kodesie,7) limit 1) = '0' then tp.kd_jabatan in('10') AND left('$kodesie',7) = left(tj.kodesie,7)
                             WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('08','09') AND tp.keluar = '0' AND left('$kodesie',5) = left(tj.kodesie,5) limit 1) = '0' then tp.kd_jabatan in('08','09') AND left('$kodesie',5) = left(tj.kodesie,5)
                             WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('07','06','05') AND tp.keluar = '0' AND left('$kodesie',3) = left(tj.kodesie,3) limit 1) = '0' then tp.kd_jabatan in('05','06','07') AND left('$kodesie',3) = left(tj.kodesie,3)
                             WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('02','03','04') AND tp.keluar = '0' AND left('$kodesie',1) = left(tj.kodesie,1) limit 1) = '0' then tp.kd_jabatan in('02','03','04') AND left('$kodesie',1) = left(tj.kodesie,1)
                             ELSE tp.noind = 'a'
                            END
                         WHEN '$jbtn' in('10') then
                            CASE
                              WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('08','09') AND tp.keluar = '0' AND left('$kodesie',5) = left(tj.kodesie,5) limit 1) = '0' then tp.kd_jabatan in('08','09') AND left('$kodesie',5) = left(tj.kodesie,5)
                              WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('07','06','05') AND tp.keluar = '0' AND left('$kodesie',3) = left(tj.kodesie,3) limit 1) = '0' then tp.kd_jabatan in('05','06','07') AND left('$kodesie',3) = left(tj.kodesie,3)
                              WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('02','03','04') AND tp.keluar = '0' AND left('$kodesie',1) = left(tj.kodesie,1) limit 1) = '0' then tp.kd_jabatan in('02','03','04') AND left('$kodesie',1) = left(tj.kodesie,1)
                             ELSE tp.noind = 'a'
                            END
                         WHEN '$jbtn' in('09') then
                            CASE
                              WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('08') AND tp.keluar = '0' AND left('$kodesie',5) = left(tj.kodesie,5) limit 1) = '0' then tp.kd_jabatan in('08') AND left('$kodesie',5) = left(tj.kodesie,5)
                              WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('07','06','05') AND tp.keluar = '0' AND left('$kodesie',3) = left(tj.kodesie,3) limit 1) = '0' then tp.kd_jabatan in('05','06','07') AND left('$kodesie',3) = left(tj.kodesie,3)
                              WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('02','03','04') AND tp.keluar = '0' AND left('$kodesie',1) = left(tj.kodesie,1) limit 1) = '0' then tp.kd_jabatan in('02','03','04') AND left('$kodesie',1) = left(tj.kodesie,1)
                             ELSE tp.noind = 'a'
                            END
                         WHEN '$jbtn' in('08') then
                            CASE
                              WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('07','06','05') AND tp.keluar = '0' AND left('$kodesie',3) = left(tj.kodesie,3) limit 1) = '0' then tp.kd_jabatan in('05','06','07') AND left('$kodesie',3) = left(tj.kodesie,3)
                              WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('02','03','04') AND tp.keluar = '0' AND left('$kodesie',1) = left(tj.kodesie,1) limit 1) = '0' then tp.kd_jabatan in('02','03','04') AND left('$kodesie',1) = left(tj.kodesie,1)
                             ELSE tp.noind = 'a'
                            END
                         WHEN '$jbtn' in('07') then
                            CASE
                              WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('06','05') AND tp.keluar = '0' AND left('$kodesie',3) = left(tj.kodesie,3) limit 1) = '0' then tp.kd_jabatan in('05','06') AND left('$kodesie',3) = left(tj.kodesie,3)
                              WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('02','03','04') AND tp.keluar = '0' AND left('$kodesie',1) = left(tj.kodesie,1) limit 1) = '0' then tp.kd_jabatan in('02','03','04') AND left('$kodesie',1) = left(tj.kodesie,1)
                             ELSE tp.noind = 'a'
                            END
                         WHEN '$jbtn' in('06') then
                            CASE
                             WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('05') AND tp.keluar = '0' AND left('$kodesie',3) = left(tj.kodesie,3) limit 1) = '0' then tp.kd_jabatan in('05') AND left('$kodesie',3) = left(tj.kodesie,3)
                             WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('02','03','04') AND tp.keluar = '0' AND left('$kodesie',1) = left(tj.kodesie,1) limit 1) = '0' then tp.kd_jabatan in('02','03','04') AND left('$kodesie',1) = left(tj.kodesie,1)
                             ELSE tp.noind = 'a'
                            END
                         WHEN '$jbtn' in('05') then
                             CASE
                              WHEN (SELECT tp.keluar FROM hrd_khs.tpribadi tp inner join hrd_khs.trefjabatan tj on tp.noind = tj.noind  WHERE tp.kd_jabatan in('02','03','04') AND tp.keluar = '0' AND left('$kodesie',1) = left(tj.kodesie,1) limit 1) = '0' then tp.kd_jabatan in('02','03','04') AND left('$kodesie',1) = left(tj.kodesie,1)
                              ELSE tp.noind = 'a'
                             END
                         ELSE tp.noind = 'a'
                       END ORDER BY tp.noind ASC";
    $result = $this->personalia->query($query1);
    return $result->result_array();
  }

  // ----------------------------------------Tahunan---------------------------------------------//
  public function getSisaCuti($noind, $periode)
  {
    $SisaCuti = "SELECT sisa_cuti
                 FROM \"Presensi\".tdatacuti
                 WHERE noind = '$noind' AND periode =  '$periode'";
    $result   = $this->personalia->query($SisaCuti);
    return $result->result_array();
  }

  public function getTglBlhAmbil($noind, $periode)
  {
    $query  = "SELECT tgl_boleh_ambil
               FROM \"Presensi\".tdatacuti
               WHERE noind = '$noind' AND periode =  '$periode'";
    $result = $this->personalia->query($query);
    return $result->result_array();
  }

  public function getCutiTahunan()
  {
    $tahunan = "SELECT jenis_cuti,lm_jenis_cuti_id
                FROM lm.lm_jenis_cuti jc
                WHERE jc.lm_tipe_cuti_id = '1' ORDER BY jc.jenis_cuti ASC ";
    $result  = $this->db->query($tahunan);
    return $result->result_array();
  }

  public function getKeperluan()
  {
    $keperluan = "SELECT lm_keperluan_id, keperluan FROM lm.lm_keperluan WHERE  lm_jenis_cuti_id = '13' ORDER BY keperluan ASC";
    $result    = $this->db->query($keperluan);
    return $result->result_array();
  }

  public function getTglAmbil($noind)
  {
    $tglbolehambil = "SELECT tgl_boleh_ambil FROM \"Presensi\".tdatacuti WHERE noind = '$noind'";
    $result        = $this->personalia->query($tglbolehambil);
    return $result->result_array();
  }

  public function cekPKJ($tgl, $noind)
  {
    return $this->personalia->query("SELECT kd_ket FROM \"Presensi\".tdatapresensi WHERE tanggal='$tgl' AND noind='$noind' AND kd_ket IN('PKJ')")->num_rows();
  }

  public function cekTM($tgl, $noind)
  {
    return $this->personalia->query("SELECT kd_ket FROM \"Presensi\".tdatatim WHERE tanggal='$tgl' AND noind='$noind' AND kd_ket IN('TM')")->num_rows();
  }

  public function get_libur($for, $until)
  {
    $schema = '"Dinas_Luar".tlibur';
    $holiday = "SELECT tanggal FROM $schema WHERE tanggal BETWEEN '$for' AND '$until' ";
    $data =  $this->personalia->query($holiday)->result_array();

    if (!empty($data)) {
      $holiday = array();
      foreach ($data as $key) {
        $holiday[] = date('Y-m-d', strtotime($key['tanggal']));
      }
      return $holiday;
    } else {
      return $data;
    }
  }


  //-------------------------------------Insert New Cuti-----------------------------------------//
  public function insertCuti($data)
  {
    $this->db->insert('lm.lm_pengajuan_cuti', $data);
  }

  public function insertTglAmbil($data)
  {
    $this->db->insert('lm.lm_pengajuan_cuti_tgl_ambil', $data);
  }

  public function insertApproval($data)
  {
    $this->db->insert('lm.lm_approval_cuti', $data);
  }

  public function insertThread($data)
  {
    $this->db->insert('lm.lm_pengajuan_cuti_thread', $data);
  }


  // ----------------------------------------Istimewa---------------------------------------------//
  public function getCutiIstimewa()
  {
    $istimewa = "SELECT jenis_cuti, lm_jenis_cuti_id FROM lm.lm_jenis_cuti jc WHERE jc.lm_tipe_cuti_id = '2' ORDER BY jc.jenis_cuti ASC ";
    $result   = $this->db->query($istimewa);
    return $result->result_array();
  }

  public function getHakCuti($ket)
  {
    $query = "SELECT hari_maks FROM \"Presensi\".tcuti WHERE kd_cuti = '$ket'";
    return $this->personalia->query($query)->result_array();
  }


  // -------------------------------------------Draft----------------------------------------------//

  public function getDraft($noind)
  {
    $draft = "SELECT pc.lm_tipe_cuti_id, (SELECT tipe_cuti FROM lm.lm_tipe_cuti WHERE lm_tipe_cuti_id = pc.lm_tipe_cuti_id) as tipe_cuti, pc.tgl_pengajuan, pc.lm_pengajuan_cuti, pc.noind || ' - ' || emp.employee_name as nama, jc.jenis_cuti, kp.keperluan as kp, pc.status, pc.tanggal_status, pc.keperluan,
    (SELECT alasan FROM lm.lm_approval_cuti where status = '3' and lm_pengajuan_cuti_id=pc.lm_pengajuan_cuti) as alasan
              FROM lm.lm_pengajuan_cuti pc
                inner join lm.lm_jenis_cuti jc
                  on pc.lm_jenis_cuti_id = jc.lm_jenis_cuti_id
                left join lm.lm_keperluan kp
                  on pc.lm_keperluan_id = kp.lm_keperluan_id
                inner join er.er_employee_all emp
                  on pc.noind = emp.employee_code
              WHERE noind = '$noind' ORDER BY pc.lm_pengajuan_cuti desc";

    $result = $this->db->query($draft);
    return $result->result_array();
  }

  public function getNama($noind)
  {
    $nama   = "SELECT employee_name as nama FROM er.er_employee_all emp WHERE emp.employee_code ='$noind'";
    $result = $this->db->query($nama);
    return $result->result_array();
  }

  public function getEdit($id)
  { //not yet needed
    $draft = "SELECT pc.*, emp.employee_name as nama, jc.jenis_cuti, kp.keperluan
              FROM lm.lm_pengajuan_cuti pc inner join lm.lm_jenis_cuti jc on pc.lm_jenis_cuti_id = jc.lm_jenis_cuti_id
              inner join lm.lm_keperluan kp on pc.lm_keperluan_id = kp.lm_keperluan_id
              inner join er.er_employee_all emp on pc.noind = emp.employee_code
              WHERE pc.lm_pengajuan_cuti = $id";

    $result = $this->db->query($draft);
    return $result->result_array();
  }

  public function getApproval_cuti($id_cuti)
  {
    $query  = "SELECT status, approver, ready FROM lm.lm_approval_cuti WHERE lm_pengajuan_cuti_id = '$id_cuti' ORDER BY approval_id ASC";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  public function getDetailPengajuan($id)
  {
    $detail = "SELECT pc.lm_pengajuan_cuti as id_cuti, pc.noind, emp.employee_name as nama ,pc.keterangan, tc.tipe_cuti as tipe, pc.tgl_pengajuan, jc.jenis_cuti as jenis, pc.lm_jenis_cuti_id as jenis_id, kp.keperluan kp, pc.keperluan , pc.status , pc.tanggal_status
              FROM lm.lm_pengajuan_cuti pc
                inner join lm.lm_jenis_cuti jc
                  on pc.lm_jenis_cuti_id = jc.lm_jenis_cuti_id
                left join lm.lm_keperluan kp
                  on pc.lm_keperluan_id = kp.lm_keperluan_id
                inner join lm.lm_tipe_cuti tc
                  on pc.lm_tipe_cuti_id = tc.lm_tipe_cuti_id
                inner join er.er_employee_all emp
                  on pc.noind  = emp.employee_code
              WHERE pc.lm_pengajuan_cuti = '$id'";
    $result = $this->db->query($detail);
    return $result->result_array();
  }

  public function getDetailApprover($id)
  {
    $detail = "SELECT ap.approver, emp.employee_name
                FROM lm.lm_approval_cuti ap inner join er.er_employee_all emp
                on ap.approver = emp.employee_code
                WHERE lm_pengajuan_cuti_id = '$id'";
    $result = $this->db->query($detail);
    return $result->result_array();
  }

  public function getDetailThread($id)
  {
    $thread = "SELECT detail, waktu, status FROM lm.lm_pengajuan_cuti_thread WHERE lm_pengajuan_cuti_id = $id ORDER BY lm_pengajuan_cuti_thread_id desc";
    $result = $this->db->query($thread);
    return $result->result_array();
  }

  public function getDetailTglAmbil($id)
  {
    $tglambil = "SELECT tgl_pengambilan FROM lm.lm_pengajuan_cuti_tgl_ambil WHERE lm_pengajuan_cuti_id = $id ";
    $result   = $this->db->query($tglambil);
    return $result->result_array();
  }

  public function getJenisCuti($id)
  {
    return $this->db->query("SELECT lm_jenis_cuti_id jenis FROM lm.lm_pengajuan_cuti WHERE lm_pengajuan_cuti = '$id'")->row()->jenis;
  }

  public function updateEdit()
  { // not yet needed

  }

  public function changeKep($jenis, $id_cuti, $data)
  {
    if ($jenis == '13') {
      $SET = "lm_keperluan_id = '$data'";
    } else {
      $SET = "keperluan = '$data'";
    }

    $query = "UPDATE lm.lm_pengajuan_cuti SET $SET WHERE lm_pengajuan_cuti = '$id_cuti'";
    return $this->db->query($query);
  }

  public function reSETTglCuti($id_cuti)
  {
    $this->db->query("delete FROM lm.lm_pengajuan_cuti_tgl_ambil WHERE lm_pengajuan_cuti_id ='$id_cuti'");
  }

  public function updateRequest($id_cuti, $time, $thread, $thread2, $approval1)
  {
    $this->db->insert('lm.lm_pengajuan_cuti_thread', $thread);
    $this->db->insert('lm.lm_pengajuan_cuti_thread', $thread2);
    $pengajuan = "UPDATE lm.lm_pengajuan_cuti SET status = '1', tanggal_status = '$time' WHERE lm_pengajuan_cuti = '$id_cuti'";
    $approval  = "UPDATE lm.lm_approval_cuti SET status  = '1' WHERE lm_pengajuan_cuti_id = '$id_cuti' AND approver ='$approval1'";

    $this->db->query($pengajuan);
    $this->db->query($approval);
  }

  public function deleteCuti($id_cuti)
  {
    $query  = "DELETE FROM lm.lm_pengajuan_cuti WHERE lm_pengajuan_cuti = '$id_cuti'";
    $this->db->query($query);
    $query1 = "DELETE FROM lm.lm_pengajuan_cuti_thread WHERE lm_pengajuan_cuti_id = '$id_cuti'";
    $this->db->query($query1);
    $query2 = "DELETE FROM lm.lm_pengajuan_cuti_tgl_ambil WHERE lm_pengajuan_cuti_id = '$id_cuti'";
    $this->db->query($query2);
    $query3 = "DELETE FROM lm.lm_approval_cuti WHERE lm_pengajuan_cuti_id = '$id_cuti'";
    $this->db->query($query3);
  }

  public function getDataLampiran($id_cuti)
  {
    $query = "SELECT pc.noind,
                     (SELECT emp.employee_name FROM er.er_employee_all emp WHERE emp.employee_code = pc.noind) nama,
                     (SELECT min(tgl.tgl_pengambilan) FROM lm.lm_pengajuan_cuti_tgl_ambil tgl WHERE tgl.lm_pengajuan_cuti_id = '$id_cuti') tgl,
                     (SELECT ap.approver FROM lm.lm_approval_cuti ap WHERE ap.level = '1' AND ap.lm_pengajuan_cuti_id = '$id_cuti') atasan,
                     pc.tgl_hpl
              FROM lm.lm_pengajuan_cuti pc
              WHERE pc.lm_pengajuan_cuti = '$id_cuti'";
    $cuti = $this->db->query($query)->result_array();

    $noind = $cuti['0']['noind'];
    $query2 = "SELECT tp.alamat, (SELECT seksi FROM hrd_khs.tseksi WHERE kodesie = tp.kodesie) seksi
               FROM hrd_khs.tpribadi tp
               WHERE noind = '$noind'";
    $personal = $this->personalia->query($query2)->result_array();

    $atasan = $cuti['0']['atasan'];
    $query3 = "SELECT employee_name FROM er.er_employee_all WHERE employee_code = '$atasan'";
    $atasan = $this->db->query($query3)->row()->employee_name;

    $real_alamat = "SELECT CASE
                              WHEN POSITION(desa in alamat) > '0' THEN substr(alamat, 0, POSITION(desa in alamat)) || desa ||', '||kec||', '||kab
                              ELSE alamat||', '||desa||', '||kec||', '||kab
                            END as alamat
                    FROM hrd_khs.tpribadi
                    WHERE noind = '$noind'";
    $real_alamat = $this->personalia->query($real_alamat)->row()->alamat;

    $bulanId = array(
      '0'  => '-',
      '01' => 'Januari',
      '02' => 'Februari',
      '03' => 'Maret',
      '04' => 'April',
      '05' => 'Mei',
      '06' => 'Juni',
      '07' => 'Juli',
      '08' => 'Agustus',
      '09' => 'September',
      '10' => 'Oktober',
      '11' => 'November',
      '12' => 'Desember',
    );
    $tglkerja = date('Y-m-d', strtotime($cuti['0']['tgl'] . '-1 days'));

    $bulanAmbil = $bulanId[date('m', strtotime($tglkerja))];
    $tglambil   = date('d', strtotime($tglkerja)) . ' ' . $bulanAmbil . ' ' . date('Y', strtotime($tglkerja));

    $bulanHpl   = $bulanId[date('m', strtotime($cuti['0']['tgl_hpl']))];
    $tglHpl     = date('d', strtotime($cuti['0']['tgl_hpl'])) . ' ' . $bulanHpl . ' ' . date('Y', strtotime($cuti['0']['tgl_hpl']));

    $bulanNow   = $bulanId[date('m')];
    $tglNow     = date('d') . ' ' . $bulanNow . ' ' . date('Y');


    $data = array();
    $data['noind']   = $noind;
    $data['nama']    = $cuti['0']['nama'];
    $data['tgl']     = $tglambil;
    $data['tgl_hpl'] = $tglHpl;
    $data['atasan']  = $atasan;
    $data['alamat']  = $real_alamat;
    $data['seksi']   = $personal['0']['seksi'];
    $data['now']     = $tglNow;
    return $data;
  }

  public function updateAlamat($alamat, $id_cuti)
  { // update alamat on cuti istimewa (Istirahat melahirkan) / ajax
    $sql = "UPDATE lm.lm_pengajuan_cuti SET alamat = '$alamat' WHERE lm_pengajuan_cuti = '$id_cuti'";
    $this->db->query($sql);
  }

  public function getAuthApproval($id)
  { //maybe not needed, u can delete this
    return $this->db->query("SELECT approver FROM lm.lm_approval_cuti WHERE lm_pengajuan_cuti_id = '$id'")->result_array();
  }
  //-------------------------------------------------------------------------------------------------//
}
