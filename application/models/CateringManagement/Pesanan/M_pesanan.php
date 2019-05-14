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
        return $this->personalia->query($sql)->result_array();
    }
    public function editTotalPesanan($array_total,$ru_where)
    {
        $this->personalia->where($ru_where);
        $this->personalia->update('"Catering".tpesanan_erp',$array_total);
        return;
    }
    public function ambilPenambahan($ru_where)
    {
        $this->personalia->where($ru_where);
        return $this->personalia->get('"Catering".tpesanan_tambah_kurang')->result_array();
    }
    public function ambilPesananHariIni($ru_where)
    {
        $this->personalia->where($ru_where);
        return $this->personalia->get('"Catering".tpesanan_erp')->result_array();
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
    public function ambilTempatMakan($p)
    {
        $sql = "select fs_tempat_makan as nama from \"Catering\".ttempat_makan where fs_tempat_makan like '%$p%'";
        return $this->personalia->query($sql)->result_array();
    }
    public function hapusLama($tgl,$shift,$lokasi)
    {
        $sql = "delete from \"Catering\".tpesanan_erp where tgl_pesanan='$tgl' and lokasi_kerja='$lokasi' and kd_shift='$shift'";
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
        $sql = " select tpe.*, 
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
                where tpe.tgl_pesanan='$tgl' and tpe.lokasi_kerja='$lokasi' and tpe.kd_shift='$shift'";
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
        $sql = "select tp.tempat_makan, 
                (select tb_2.tb 
                  from 
                      (select tb_1.tempat_makan, count(tb_1.noind) as tb 
                       from 
                           (select tp.noind, tp.tempat_makan 
                            from hrd_khs.tpribadi tp 
                              inner join \"Presensi\".tshiftpekerja tsp 
                                 on tp.noind=tsp.noind 
                              inner join \"FrontPresensi\".tpresensi tpr 
                                 on tp.noind=tpr.noind 
                            where tp.keluar='0' and tp.lokasi_kerja='$lokasi' 
                                                and tsp.tanggal='$tgl' 
                                                and tpr.tanggal='$tgl' 
                                                and tsp.kd_shift in $shift
                            group by tp.tempat_makan,tp.noind) as tb_1 
                       group by tb_1.tempat_makan) as tb_2 
                  where tb_2.tempat_makan=tp.tempat_makan) as jml_shift, 
                  (case when $batas=1
                        then 
                          (select tb_2.tb 
                           from 
                              (select tb_1.tempat_makan, count(tb_1.noind) as tb 
                               from 
                                  (select tp.noind, tp.tempat_makan 
                                   from hrd_khs.tpribadi tp 
                                       inner join \"Presensi\".tshiftpekerja tsp 
                                         on tp.noind=tsp.noind 
                                       inner join \"FrontPresensi\".tpresensi tpr 
                                         on tp.noind=tpr.noind 
                                   where tp.keluar='0' and tp.lokasi_kerja='$lokasi' 
                                                       and tsp.tanggal='$tgl' 
                                                       and tpr.tanggal='$tgl' 
                                                       and tsp.kd_shift not in $shiftnot
                                                       and tpr.waktu::time < '11:45:00'::time
                                   group by tp.tempat_makan,tp.noind) as tb_1 
                               group by tb_1.tempat_makan) as tb_2 
                           where tb_2.tempat_makan=tp.tempat_makan)
                         when $batas=2
                         then 
                          (select tb_2.tb 
                           from 
                              (select tb_1.tempat_makan, count(tb_1.noind) as tb 
                               from 
                                  (select tp.noind, tp.tempat_makan 
                                   from hrd_khs.tpribadi tp 
                                       inner join \"Presensi\".tshiftpekerja tsp 
                                         on tp.noind=tsp.noind 
                                       inner join \"FrontPresensi\".tpresensi tpr 
                                         on tp.noind=tpr.noind 
                                   where tp.keluar='0' and tp.lokasi_kerja='$lokasi' 
                                                       and tsp.tanggal='$tgl' 
                                                       and tpr.tanggal='$tgl' 
                                                       and tsp.kd_shift not in $shiftnot 
                                                       and tpr.waktu::time < '18:00:00'::time
                                   group by tp.tempat_makan,tp.noind) as tb_1 
                               group by tb_1.tempat_makan) as tb_2 
                           where tb_2.tempat_makan=tp.tempat_makan) 
                           when $batas=3
                           then 
                              0
                         end) as jml_bukan_shift 


                from hrd_khs.tpribadi tp 
                  inner join \"Presensi\".tshiftpekerja tsp 
                    on tp.noind=tsp.noind 
                  inner join \"FrontPresensi\".tpresensi tpr 
                    on tp.noind=tpr.noind 
                where tp.keluar='0' and tp.lokasi_kerja='$lokasi' 
                                    and tsp.tanggal='$tgl' 
                                    and tpr.tanggal='$tgl' 
                                    and tsp.kd_shift in $shift
                group by tp.tempat_makan 
                order by tp.tempat_makan";
                // echo $sql;
                // exit();
            return $this->personalia->query($sql)->result_array();
    }

    public function tempatnya($shift,$tgl)
    {

    }
    
}

/* End of file M_printpp.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_printpp.php */
/* Generated automatically on 2017-09-23 07:56:39 */