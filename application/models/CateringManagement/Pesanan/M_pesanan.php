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

    public function getDataDinas($lok, $noind)
    {
      $sql="SELECT DISTINCT * FROM \"Catering\".tpesanantambahan_erp_detail ted
            LEFT JOIN \"Catering\".tpesanantambahan_erp tpt ON tpt.id_tambahan = ted.id_tambahan
            LEFT JOIN \"Surat\".tperizinan tp ON tp.created_date::date = current_date
            WHERE ted.fs_noind = '$noind' AND ted.fs_ket = tp.keterangan AND tp.created_date::date = current_date $lok";
      return $this->personalia->query($sql)->result_array();
    }

    public function getDataDinasMin($lok, $noind)
    {
      $sql="SELECT DISTINCT * FROM \"Catering\".tpenguranganpesanan_erp_detail ted
            LEFT JOIN \"Catering\".tpenguranganpesanan_erp tpt ON tpt.id_pengurangan = ted.id_pengurangan
            LEFT JOIN \"Surat\".tperizinan tp ON tp.created_date::date = current_date
            LEFT JOIN hrd_khs.tpribadi tpri on tpri.noind = ted.fs_noind
            WHERE fs_noind = '$noind' AND ted.fs_ket = tp.keterangan AND tp.created_date::date = current_date $lok";
      return $this->personalia->query($sql)->result_array();
    }

    public function getRekapAllDinas($lok, $param)
    {
      $sql="SELECT DISTINCT ted.*, tpt.fd_tanggal, tpt.fs_tempat_makan FROM \"Catering\".tpesanantambahan_erp_detail ted
              LEFT JOIN \"Catering\".tpesanantambahan_erp tpt ON tpt.id_tambahan = ted.id_tambahan
              LEFT JOIN \"Surat\".tperizinan tp ON tp.created_date::date = current_date
              LEFT JOIN hrd_khs.tpribadi tpri on tpri.noind = ted.fs_noind
              WHERE ted.fs_ket = tp.keterangan $lok $param
              ORDER BY fd_tanggal DESC, fs_tempat_makan, fs_noind";
      return $this->personalia->query($sql)->result_array();
    }

    public function getDetailPekerjaDinasPlus($isi, $tanggal, $lok)
    {
        $sql = "SELECT DISTINCT ted.*, tpt.fd_tanggal, tpt.fs_tempat_makan FROM \"Catering\".tpesanantambahan_erp_detail ted
                LEFT JOIN \"Catering\".tpesanantambahan_erp tpt ON tpt.id_tambahan = ted.id_tambahan
                LEFT JOIN \"Surat\".tperizinan tp ON tp.created_date::date = current_date
                LEFT JOIN hrd_khs.tpribadi tpri on tpri.noind = ted.fs_noind
                WHERE ted.fs_ket = tp.keterangan AND tp.created_date::date = current_date AND tpt.fd_tanggal::date = current_date AND tpt.fs_tempat_makan = '$isi' $lok
                ORDER BY fs_noind";
        return $this->personalia->query($sql)->result_array();
    }

    public function getDetailPekerjaDinasMin($isi, $tanggal, $lok)
    {
        $sql = "SELECT DISTINCT ted.*, tpt.fd_tanggal, tpt.fs_tempat_makan FROM \"Catering\".tpenguranganpesanan_erp_detail ted
                LEFT JOIN \"Catering\".tpenguranganpesanan_erp tpt ON tpt.id_pengurangan = ted.id_pengurangan
                LEFT JOIN \"Surat\".tperizinan tp ON tp.created_date::date = current_date
                LEFT JOIN hrd_khs.tpribadi tpri on tpri.noind = ted.fs_noind
                WHERE ted.fs_ket = tp.keterangan AND tp.created_date::date = current_date AND tpt.fd_tanggal::date = current_date AND tpt.fs_tempat_makan = '$isi' $lok
                ORDER BY fs_noind";
        return $this->personalia->query($sql)->result_array();
    }

    public function getPekerjaAsal($today, $lokasi)
    {
        $sql = "SELECT DISTINCT ted.*, tpt.fd_tanggal, tpt.fs_tempat_makan FROM \"Catering\".tpenguranganpesanan_erp_detail ted
                LEFT JOIN \"Catering\".tpenguranganpesanan_erp tpt ON tpt.id_pengurangan = ted.id_pengurangan
                LEFT JOIN \"Surat\".tperizinan tp ON tp.created_date::date = current_date
                LEFT JOIN hrd_khs.tpribadi tpri on tpri.noind = ted.fs_noind
                WHERE ted.fs_ket = tp.keterangan AND tp.created_date::date = current_date $lokasi $today
                ORDER BY fd_tanggal DESC, fs_tempat_makan, fs_noind";
        return $this->personalia->query($sql)->result_array();
    }

    public function getDataBelumDiProses($lok)
    {
        $sql = "SELECT *
                from (
                    select tai.izin_id,tpi.noind,trim(tpri.nama) as nama,tpi.makan,tai.tujuan,trim(tpri.tempat_makan) as tempat_makan,tp.keterangan,
                    case when tp.jenis_izin = '1' then 'PUSAT'
                    when tp.jenis_izin = '2' then 'TUKSONO'
                    when tp.jenis_izin = '3' then 'MLATI'
                    else 'TIDAK DIKETAHUI'
                    end as jenis_dinas,
                    (select count(*)
                    from \"Catering\".tpesanantambahan_erp_detail tptd
                    inner join \"Catering\".tpesanantambahan_erp tpt
                    on tptd.id_tambahan = tpt.id_tambahan
                    Where tpt.fd_tanggal = current_date
                    and tptd.fs_noind = tai.noinduk) as diproses
                    from \"Surat\".taktual_izin tai
                     inner join \"Surat\".tpekerja_izin tpi
                     on tai.noinduk = tpi.noind
                     and tai.izin_id = tpi.izin_id
                     inner join \"Surat\".tperizinan tp
                     on tai.izin_id::int = tp.izin_id
                     left join hrd_khs.tpribadi tpri
                     on tpri.noind = tai.noinduk
                     Where tai.created_date:: Date = current_date
                     and tpi.makan = '1' AND cast(tai.created_date as time) <= '09:30:00' AND tai.tujuan not in ('', ' ', 'null') $lok
                 ) as tbl
                 order by diproses,jenis_dinas,tujuan,izin_id,noind";

        return $this->personalia->query($sql)->result_array();
    }

    public function checking($noind)
    {
        $sql = "SELECT * from (
                                SELECT tpres.noind AS noind, hrd_khs.tpribadi.Nama AS nama, tpres.waktu,
                                    hrd_khs.tpribadi.tempat_makan AS tempat_makan,
                                    COUNT(hrd_khs.tpribadi.tempat_makan) AS jumlah_karyawan
                                FROM hrd_khs.tpribadi
                                INNER JOIN \"Catering\".tpresensi tpres ON tpres.noind = hrd_khs.tpribadi.noind
                                    AND LEFT(tpres.waktu, 5) >= '03:59:59'
                                    AND LEFT(tpres.waktu, 5) <= '08:30:00'
                                    AND tpres.tanggal::date = current_date
                                WHERE tpres.noind NOT IN
                                    (SELECT fs_noind FROM \"Catering\".tpuasa
                                        WHERE (fd_tanggal::date = current_date)
                                        AND (fb_status = '1')
                                        )
                                    AND tpres.noind NOT IN
                                        (
                                            SELECT noind
                                            FROM \"Presensi\".tshiftPekerja
                                            WHERE tanggal::date IN (current_date - interval '1 day', current_date)
                                            AND kd_shift IN ('3', '12')
                                        )
                                    AND LEFT(hrd_khs.tpribadi.noind, 1) NOT IN ('M', 'Z')
                                    GROUP BY hrd_khs.tpribadi.tempat_makan, hrd_khs.tpribadi.Nama, tpres.noind, tpres.waktu,tpres.user_,hrd_khs.tpribadi.kodesie,tpres.tanggal
                                union
                                select a.noind,a.nama,b.jam_msk as waktu,a.tempat_makan,COUNT(a.tempat_makan) AS jumlah_karyawan
                                FROM hrd_khs.tpribadi a
                                inner join \"Presensi\".tshiftpekerja b on a.noind=b.noind
                                left join \"Catering\".tpuasa p on b.tanggal=p.fd_tanggal and b.noind=p.fs_noind
                                where b.tanggal::date = current_date
                                    and (p.fb_status is null or p.fb_status<>'1')
                                    and b.kd_shift in('5','8','18')
                                GROUP BY a.tempat_makan, a.Nama,a.noind,b.jam_msk,a.kodesie,b.tanggal
                            ) as tbl where noind = '$noind' ORDER BY tbl.tempat_makan, tbl.noind ";
        return $this->personalia->query($sql)->result_array();
    }


//Tambahan Pesanan
    public function getDataPEsanantoday($tempat_makan)
    {
        $sql = "SELECT * FROM \"Catering\".tpesanantambahan_erp
                WHERE fd_tanggal::date = current_date AND fs_kd_shift = '1' AND fs_tempat_makan = '$tempat_makan'";
        return $this->personalia->query($sql)->result_array();
    }
    public function insertTambahCateringDinas($data)
    {
        $this->personalia->insert('"Catering".tpesanantambahan_erp',$data);
        return;
    }
    public function insertToDetail($data)
    {
        $this->personalia->insert('"Catering".tpesanantambahan_erp_detail',$data);
        return;
    }
    public function getDetailPlus($id)
    {
        $sql = "SELECT count(*) FROM \"Catering\".tpesanantambahan_erp_detail
                WHERE id_tambahan = '$id'";
        return $this->personalia->query($sql)->row()->count;
    }
    public function updateDetailTambahan($id, $tujuan, $jumlah)
    {
        $sql = "UPDATE \"Catering\".tpesanantambahan_erp set fn_jumlah_pesanan = '$jumlah'
                WHERE id_tambahan = '$id' AND fd_tanggal::date = current_date AND fs_kd_shift = '1' AND fs_tempat_makan = '$tujuan'";
        return $this->personalia->query($sql);
    }
    public function checkingPekerjaDinas($id, $noind, $nama, $keterangan)
    {
        $sql = "SELECT * FROM \"Catering\".tpesanantambahan_erp_detail WHERE id_tambahan = '$id'::int AND fs_noind = '$noind' AND fs_nama = '$nama' AND fs_ket='$keterangan'";
        // print_r($id);die;
        return $this->personalia->query($sql)->result_array();
    }
    public function countPekerjaDinas($id)
    {
        $sql = "SELECT count(*) FROM \"Catering\".tpesanantambahan_erp_detail WHERE id_tambahan = '$id'";
        // print_r($sql);die;
        return $this->personalia->query($sql)->result_array();
    }
    public function updateJumlahCatering($id, $tempat, $jml)
    {
        $sql = "UPDATE \"Catering\".tpesanantambahan_erp set fn_jumlah_pesanan = '$jml' WHERE id_tambahan = '$id' AND fs_tempat_makan = '$tempat' AND fd_tanggal = current_date";
        return $this->personalia->query($sql);
    }

//Pengurangan Pesanan
    public function getDataPengurangantoday($tempat_makan)
    {
        $sql = "SELECT * FROM \"Catering\".tpenguranganpesanan_erp
        WHERE fd_tanggal::date = current_date AND fs_kd_shift = '1' AND fs_tempat_makan = '$tempat_makan'";
        return $this->personalia->query($sql)->result_array();
    }
    public function insertPenguranganCateringDinas($data)
    {
        $this->personalia->insert('"Catering".tpenguranganpesanan_erp',$data);
        return;
    }
    public function insertToDetailKurang($data)
    {
        $this->personalia->insert('"Catering".tpenguranganpesanan_erp_detail',$data);
        return;
    }
    public function getDetailMin($id)
    {
        $sql = "SELECT count(*) FROM \"Catering\".tpenguranganpesanan_erp_detail
                WHERE id_pengurangan = '$id'";
        return $this->personalia->query($sql)->result_array();
    }
    public function updateDetailPengurangan($id, $tujuan, $jumlah)
    {
        $sql = "UPDATE \"Catering\".tpenguranganpesanan_erp set fn_jml_tdkpesan = '$jumlah'
                WHERE id_pengurangan = '$id' AND fd_tanggal::date = current_date AND fs_kd_shift = '1' AND fs_tempat_makan = '$tujuan'";
        return $this->personalia->query($sql);
    }
    public function checkingPekerjaDinasMin($id, $noind)
    {
        $sql = "SELECT fs_noind as noind FROM \"Catering\".tpenguranganpesanan_erp_detail WHERE id_pengurangan = '$id' AND fs_noind = '$noind'";
        return $this->personalia->query($sql)->result_array();
    }
    public function countPekerjaDinasMin($id)
    {
        $sql = "SELECT count(*) FROM \"Catering\".tpenguranganpesanan_erp_detail WHERE id_pengurangan = '$id'";
        // print_r($sql);die;
        return $this->personalia->query($sql)->result_array();
    }
    public function updateJumlahCateringMin($id, $tempat, $jml)
    {
        $sql = "UPDATE \"Catering\".tpenguranganpesanan_erp set fn_jml_tdkpesan = '$jml' WHERE id_pengurangan = '$id' AND fs_tempat_makan = '$tempat' AND fd_tanggal = current_date";
        return $this->personalia->query($sql);
    }

//Untuk Update di Pesanan ERP
    public function getDetailJumlah($tempat_makan)
    {
        $sql = "SELECT  SUM(
                    jml_shift::int +
                    jml_bukan_shift::int +
                    coalesce((
                    select fn_jumlah_pesanan
                    from \"Catering\".tpesanantambahan_erp tpt
                    Where tp.tgl_pesanan = tpt.fd_tanggal
                    and tp.kd_shift = tpt.fs_kd_shift
                    and tp.tempat_makan = tpt.fs_tempat_makan
                    ),0) -
                    coalesce((
                    select fn_jml_tdkpesan
                    from \"Catering\".tpenguranganpesanan_erp tpp
                    Where tp.tgl_pesanan = tpp.fd_tanggal
                    and tp.kd_shift = tpp.fs_kd_shift
                    and tp.tempat_makan = tpp.fs_tempat_makan
                    ),0)
                    ) as pesanan
                from \"Catering\".tpesanan_erp tp
                Where tp.tgl_pesanan::date = current_date
                and tp.kd_shift = '1'
                and tp.tempat_makan = '$tempat_makan'";
        return $this->personalia->query($sql)->result_array();
    }

    public function UpdatePesanan($tempat_makan, $jumlah)
    {
        $sql = "UPDATE \"Catering\".tpesanan_erp set jml_total = '$jumlah'
                WHERE tgl_pesanan::date = current_date AND tempat_makan = '$tempat_makan' AND kd_shift = '1'";
        return $this->personalia->query($sql);
    }
}
