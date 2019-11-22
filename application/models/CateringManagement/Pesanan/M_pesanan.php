<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pesanan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia',TRUE);
    }

    public function updatePlotting($ru_where,$array)
    {
        $this->personalia->where($ru_where);
        $this->personalia->update('"Catering".tplotting',$array);
        return;
    }
    public function ambilJadwal($tgl,$shift)
    {
        if ($shift == 1) {
            $shift = " tj.fs_tujuan_shift1 = 't' ";
        }elseif ($shift == 2) {
            $shift = " tj.fs_tujuan_shift2 = 't' ";
        }else{
            $shift = " tj.fs_tujuan_shift3 = 't' ";
        }
        $sql = "select tj.fd_tanggal,tj.fs_kd_katering,tk.fs_nama_katering
                from \"Catering\".tjadwal tj
                   inner join \"Catering\".tkatering tk
                    on tj.fs_kd_katering=tk.fs_kd_katering
                where tj.fd_tanggal='$tgl'
                  and $shift";
                  // print_r ($sql);
                  // exit();
        return $this->personalia->query($sql)->result_array();
    }
    public function ambilAll($tgl,$shift,$lokasi)
    {
        $sql = "select tpe.tgl_pesanan,
                   tpe.tempat_makan,
                   tpe.kd_shift,
                   tpe.jml_shift,
                   tpe.jml_bukan_shift,
                   tpe.jml_total,
                   tpe.lokasi_kerja,
                   (select tk.fs_nama_katering
                    from \"Catering\".tplotting tpl
                       inner join \"Catering\".tkatering tk
                         on tpl.fs_kd_katering=tk.fs_kd_katering
                    where tpe.tgl_pesanan=tpl.tgl_pesanan
                      and tpe.kd_shift=tpl.kd_shift
                      and tpe.lokasi_kerja=tpl.lokasi_kerja
                      and tpe.tempat_makan=tpl.tempat_makan) as katering
            from \"Catering\".tpesanan_erp tpe
            where tpe.tgl_pesanan='$tgl' and tpe.kd_shift='$shift' and tpe.lokasi_kerja='$lokasi'";
            // echo '<pre>';
            // print_r ($sql);
            // exit();
        return $this->personalia->query($sql)->result_array();
    }
    public function ambilPloting($ru_where)
    {
        $this->personalia->where($ru_where);
        return $this->personalia->get('"Catering".tplotting')->result_array();
    }
    public function insertPlotting($array)
    {
        $this->personalia->insert('"Catering".tplotting',$array);
        return;
    }
    public function ambilTempatPesan($p,$tgl,$shift)
    {

        if ($shift == 1) {
            $shift = " tj.fs_tujuan_shift1 = 't' ";
        }elseif ($shift == 2) {
            $shift = " tj.fs_tujuan_shift2 = 't' ";
        }else{
            $shift = " tj.fs_tujuan_shift3 = 't' ";
        }
        $sql = "select tj.fs_kd_katering,tk.fs_nama_katering
                from \"Catering\".tjadwal tj
                   inner join \"Catering\".tkatering tk
                    on tj.fs_kd_katering=tk.fs_kd_katering
                where tj.fd_tanggal='$tgl'
                  and $shift
                  and tk.fs_nama_katering like '%$p%'
                group by tj.fs_kd_katering,tk.fs_nama_katering";
        $result = $this->personalia->query($sql);
        return $result->result_array();
    }
    public function editTotalPesanan($jmltotal, $today, $kd_shift, $tempat_makan, $tambahkurang)
    {
        $sql = "UPDATE \"Catering\".tpesanan_erp set jml_total = '$jmltotal', jml_bukan_shift = '$tambahkurang'
                WHERE tgl_pesanan = '$today' AND kd_shift = '$kd_shift' AND tempat_makan = '$tempat_makan'";
        return $this->personalia->query($sql);
    }
    public function ambilPenambahan($ru_where)
    {
        $this->personalia->where($ru_where);
        return $this->personalia->get('"Catering".tpesanan_tambah_kurang')->result_array();
    }
    public function ambilPesananHariIni($today)
    {
        $sql = "SELECT * FROM \"Catering\".tpesanan_erp
        WHERE tgl_pesanan = '$today'";
        return $this->personalia->query($sql)->result_array();
    }
    public function ambilTambahanKatering($today)
    {
        $sql = "select * from \"Catering\".tpesanan_tambah_kurang where tgl_pesanan='$today'";
        return $this->personalia->query($sql)->result_array();
    }
    public function simpanTambahanKatering($array)
    {
        $this->personalia->insert('"Catering".tpesanan_tambah_kurang',$array);
        return;
    }
    public function ambilTempatMakan($p,$lokasi)
    {
        $sql = "select distinct fs_tempat_makan as nama from \"Catering\".ttempat_makan tm
                  inner join hrd_khs.tpribadi tp on tp.tempat_makan=tm.fs_tempat_makan
                where fs_tempat_makan like '%$p%' and tp.lokasi_kerja='$lokasi'";
        return $this->personalia->query($sql)->result_array();
    }
    public function getLocOp($noind)
    {
      $query7 = "select lokasi_kerja from hrd_khs.tpribadi where noind = '$noind'";
      return $this->personalia->query($query7)->row()->lokasi_kerja;
    }
    public function hapusLama($tgl,$shift,$lokasi)
    {
        $sql = "delete from \"Catering\".tpesanan_erp tpe
                where tpe.tgl_pesanan='$tgl' and tpe.lokasi_kerja='$lokasi' and tpe.kd_shift='$shift'";
        $this->personalia->query($sql);
        return;
    }
    public function insertDataPesanan($array)
    {
        $this->personalia->insert('"Catering".tpesanan_erp',$array);
        return;
    }
    public function cekData($tgl,$shift,$lokasi)
    {
      // print_r ($tgl);
      // print_r ($shift);
      // print_r ($lokasi);
        $sql = " SELECT distinct tpe.*,
                  (case when
                           (select count(tpl.tgl_pesanan)
                            from \"Catering\".tplotting tpl
                            where tpl.kd_shift=tpe.kd_shift and tpl.tgl_pesanan=tpe.tgl_pesanan
                                                            and tpl.lokasi_kerja=tpe.lokasi_kerja
                                                            and tpe.tempat_makan=tpl.tempat_makan
                            ) > 0
                        then 'sudah'
                        else 'belum'
                    end) as status
                from \"Catering\".tpesanan_erp tpe
                  -- inner join hrd_khs.tpribadi tp
                  --  on tp.lokasi_kerja = tpe.lokasi_kerja
                where tpe.tgl_pesanan='$tgl' and tpe.lokasi_kerja='$lokasi' and tpe.kd_shift='$shift'
                ORDER BY tpe.tempat_makan";
                // echo '<pre>';
                // print_r ($sql);
                // exit();
        return $this->personalia->query($sql)->result_array();
    }

    public function cekKatAll($tgl,$shift,$lokasi){
      // $sql="SELECT fs_tanda, sum(fn_jumlah_pesan),tuk.fs_nama_katering
      //       FROM \"Catering\".tpesanan tpe
      //         inner join \"Catering\".turutankatering tuk
      //             on tuk.fn_urutan = tpe.fs_tanda::int
      //             and tuk.fd_tanggal = tpe.fd_tanggal
      //             and tuk.fs_kd_shift = tpe.fs_kd_shift
      //       WHERE tpe.fd_tanggal = '$tgl'
      //       AND tpe.fs_kd_shift = '$shift'
      //       group by fs_tanda,tuk.fs_nama_katering
      //       order by 1";
      //       print_r($sql);exit();

        $sql = "SELECT tpe.tgl_pesanan,
                   tpe.tempat_makan,
                   tpe.kd_shift,
                   tpe.jml_shift,
                   tpe.jml_bukan_shift,
                   tpe.jml_total,
                   tpe.lokasi_kerja,
                   (select tk.fs_nama_katering
                    from \"Catering\".tplotting tpl
                       inner join \"Catering\".tkatering tk
                         on tpl.fs_kd_katering=tk.fs_kd_katering
                    where tpe.tgl_pesanan=tpl.tgl_pesanan
                      and tpe.kd_shift=tpl.kd_shift
                      and tpe.lokasi_kerja=tpl.lokasi_kerja
                      and tpe.tempat_makan=tpl.tempat_makan) as katering
            from \"Catering\".tpesanan_erp tpe
            where tpe.tgl_pesanan='$tgl' and tpe.kd_shift='$shift' and tpe.lokasi_kerja='$lokasi'";
      return $this->personalia->query($sql)->result_array();
    }

    public function ambilPesanan($tgl,$shift,$lokasi)
    {
       if ($shift == 1) {
                  $shift = " ('1','4','5','8','18') ";
                  $shiftnot = " ('1','4','5','8','18') ";
                  $batas=1;
              }elseif ($shift == 2) {
                  $shift = " ('2') ";
                  $shiftnot = " ('2','1','4','5','8','18') ";
                  $batas=2;
              }else{
                  $shift=" ('3') ";
                  $shiftnot=" ('3',2','1','4','5','8','18') ";
                  $batas=3;
              }
        $sql = "SELECT tp.tempat_makan,
                (SELECT tb_2.tb
                 FROM
                      (SELECT tb_1.tempat_makan, count(tb_1.noind) as tb
                       FROM
                           (SELECT tp.noind, tp.tempat_makan
                            FROM hrd_khs.tpribadi tp
                              INNER JOIN \"Presensi\".tshiftpekerja tsp
                                 ON tp.noind=tsp.noind
                              INNER JOIN \"FrontPresensi\".tpresensi tpr
                                 ON tp.noind=tpr.noind
                            WHERE tp.keluar='0' AND tp.lokasi_kerja='$lokasi'
                                                AND tsp.tanggal='$tgl'
                                                AND tpr.tanggal='$tgl'
                                                AND tsp.kd_shift in $shift
                            GROUP BY tp.tempat_makan,tp.noind) as tb_1
                       GROUP BY tb_1.tempat_makan) as tb_2
                  WHERE tb_2.tempat_makan=tp.tempat_makan) as jml_shift,
                  (CASE WHEN $batas=1
                        THEN
                          (SELECT tb_2.tb
                           FROM
                              (SELECT tb_1.tempat_makan, count(tb_1.noind) as tb
                               FROM
                                  (SELECT tp.noind, tp.tempat_makan
                                   FROM hrd_khs.tpribadi tp
                                       INNER JOIN \"Presensi\".tshiftpekerja tsp
                                         ON tp.noind=tsp.noind
                                       INNER JOIN \"FrontPresensi\".tpresensi tpr
                                         ON tp.noind=tpr.noind
                                   WHERE tp.keluar='0' AND tp.lokasi_kerja='$lokasi'
                                                       AND tsp.tanggal='$tgl'
                                                       AND tpr.tanggal='$tgl'
                                                       AND tsp.kd_shift not in $shiftnot
                                                       AND tpr.waktu::time < '11:45:00'::time
                                  GROUP BY tp.tempat_makan,tp.noind) as tb_1
                               GROUP BY tb_1.tempat_makan) as tb_2
                           WHERE tb_2.tempat_makan=tp.tempat_makan)
                         WHEN $batas=2
                         THEN
                          (SELECT tb_2.tb
                           FROM
                              (SELECT tb_1.tempat_makan, count(tb_1.noind) as tb
                               FROM
                                  (SELECT tp.noind, tp.tempat_makan
                                   FROM hrd_khs.tpribadi tp
                                       INNER JOIN \"Presensi\".tshiftpekerja tsp
                                         ON tp.noind=tsp.noind
                                       INNER JOIN \"FrontPresensi\".tpresensi tpr
                                         ON tp.noind=tpr.noind
                                   WHERE tp.keluar='0' AND tp.lokasi_kerja='$lokasi'
                                                       AND tsp.tanggal='$tgl'
                                                       AND tpr.tanggal='$tgl'
                                                       AND tsp.kd_shift not in $shiftnot
                                                       AND tpr.waktu::time < '18:00:00'::time
                                   GROUP BY tp.tempat_makan,tp.noind) as tb_1
                               GROUP BY tb_1.tempat_makan) as tb_2
                           WHERE tb_2.tempat_makan=tp.tempat_makan)
                           WHEN $batas=3
                           THEN
                              0
                         END) AS jml_bukan_shift


                FROM hrd_khs.tpribadi tp
                  INNER JOIN \"Presensi\".tshiftpekerja tsp
                    ON tp.noind=tsp.noind
                  INNER JOIN \"FrontPresensi\".tpresensi tpr
                    ON tp.noind=tpr.noind
                WHERE tp.keluar='0' AND tp.lokasi_kerja='$lokasi'
                                    AND tsp.tanggal='$tgl'
                                    AND tpr.tanggal='$tgl'
                                    AND tsp.kd_shift in $shift
                GROUP BY tp.tempat_makan
                ORDER BY tp.tempat_makan";

                // echo '<pre>' ;
                // print_r ($sql);
                // exit();
            return $this->personalia->query($sql)->result_array();
    }

    public function ambilapprove($today)
    {
      $sql = "SELECT * FROM \"Catering\".tapprove_tambah_makan
              WHERE tgl_pesanan = '$today'";
      return $this->personalia->query($sql)->result_array();
    }

    public function getUserforMail($id)
    {
      $sql = "SELECT user_ FROM \"Catering\".tapprove_tambah_makan tt
              WHERE tt.id = '$id'";
      return $this->personalia->query($sql)->row()->user_;
    }

    public function getMail($user)
    {
      $sql = "SELECT internal_mail FROM er.er_employee_all
              WHERE employee_code = '$user'";
      return $this->db->query($sql)->row()->internal_mail;
    }

    public function dataTambahan($today)
    {
      $sql = "SELECT *, cast(tgl_pesanan as date) tanggal FROM \"Catering\".tapprove_tambah_makan
              WHERE tgl_pesanan not in ('$today')";
      return $this->personalia->query($sql)->result_array();
    }

    public function ambildetail($id)
    {
      $sql = "SELECT *,
              (SELECT tp.nama
              FROM hrd_khs.tpribadi tp WHERE tp.noind=ta.user_) nama1,
              (SELECT tp.kodesie
              FROM hrd_khs.tpribadi tp WHERE tp.noind=ta.user_) kodesie
              FROM \"Catering\".tapprove_tambah_makan ta where id = '$id'";
      return $this->personalia->query($sql)->result_array();
    }

    public function updateapproval($id, $status)
    {
      $this->personalia->query("update \"Catering\".tapprove_tambah_makan set status='$status' where id = '$id'");
    }

    public function getSeksi($kodesie)
    {
      return $this->personalia->query("SELECT seksi FROM hrd_khs.tseksi WHERE kodesie = '$kodesie'")->row()->seksi;
    }

    public function getNamaSie()
    {
      $sql = "SELECT tp.noind, tp.nama, ts.seksi
              FROM hrd_khs.tpribadi tp INNER JOIN hrd_khs.tseksi ts on ts.kodesie=tp.kodesie
              INNER JOIN \"Catering\".tapprove_tambah_makan ta on ta.user_=tp.noind
              WHERE keluar = '0'";
      return $this->personalia->query($sql)->result_array();
    }
    public function updateStatus($today)
    {
      $this->personalia->query("update \"Catering\".tapprove_tambah_makan set status = '4' where status='1' and tgl_pesanan not in ('$today')");
    }

    public function getImail($inmail)
    {
      $sql = "SELECT id FROM internal_mail FROM er.er_employee_all where employee_code = '$inmail' ";
      return $this->db->query($sql)->row()->internal_mail;
    }

    public function insertpesantambahkurang($arrayIn)
    {
      $this->personalia->insert('"Catering".tpesanan_erp',$arrayIn);
      return;
    }

    public function insertTambahPesan($insertTambah)
    {
      $this->personalia->insert('"Catering".tpesanantambahan',$insertTambah);
      return;
    }

    public function getNamaa($params, $ket)
    {
      if($params == true){
        $noind = "in('$ket')";
      }else{
        $noind = "='$ket'";
      }
      $sql = "SELECT concat_ws(' - ', noind, nama) as nama from hrd_khs.tpribadi where noind $noind";
      // print_r($sql);exit();
      return $this->personalia->query($sql)->result_array();
    }

    public function getLokasiApprove($user)
    {
      $sql = "SELECT lokasi_kerja FROM hrd_khs.tpribadi where noind = '$user'";
      return $this->personalia->query($sql)->row()->lokasi_kerja;
    }

    public function getDataDinas($lok)
    {
      $today = date('Y-m-d');
      $sql="SELECT ti.tujuan FROM \"Surat\".taktual_izin ti left join \"Surat\".tperizinan tp on ti.izin_id::int = tp.izin_id
            where ti.tujuan not in ('', ' ', 'null') AND cast(ti.created_date as time) < '09:00:00' $lok
            AND cast(ti.created_date as date) IN ('$today')";
      return $this->personalia->query($sql)->result_array();
    }

    public function getRekapAllDinas($today, $lok, $param)
    {
      $sql="SELECT ti.tujuan FROM \"Surat\".taktual_izin ti left join \"Surat\".tperizinan tp on ti.izin_id::int = tp.izin_id
            where ti.tujuan not in ('', ' ', 'null') AND cast(ti.created_date as time) < '09:00:00' $lok $param
            AND cast(ti.created_date as date) NOT IN ('$today')";
      return $this->personalia->query($sql)->result_array();
    }


}
