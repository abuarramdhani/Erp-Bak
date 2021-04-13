<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_prediksicatering extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', TRUE);
        $this->dinas_luar = $this->load->database('dinas_luar', TRUE);
    }

    public function getPrediksiCatering($tanggal, $lokasi, $shift)
    {
        if ($shift == 1) {
            $shift = "and tsp.kd_shift in ('1','4','7','8','9','10')";
        } else if ($shift == 2) {
            $shift = "and tsp.kd_shift in ('11','2','34')";
        } else if ($shift == 3) {
            $shift = "and tsp.kd_shift in ('3','12')";
        } else {
            $shift = "and tsp.kd_shift in ('1','2','3','4','7','8','10','11','12')";
        }

        if ($lokasi == 1) {
            $lokasi = "and ttm.fs_lokasi = '1'";
        } else if ($lokasi == 2) {
            $lokasi = "and ttm.fs_lokasi = '2'";
        } else {
            $lokasi = "";
        }

        $sql = "select 
                tp.tempat_makan,
                to_char(tsp.tanggal, 'DD-MM-YYYY') AS tanggal,
                count(*) as jumlah_shift,
                sum(case when tdp.kd_ket = 'PCZ' or left(tdp.kd_ket,1) = 'C' then 1 else 0 end) as cuti,
                sum(case when tdp.kd_ket = 'PRM' and trim(tdp.alasan) like '%- WFH' then 1 else 0 end) as wfh,
                sum(case when tdp.kd_ket = 'PRM' and trim(tdp.alasan) not like '%- WFH' then 1 else 0 end) as dirumahkan_nonwfh,
                sum(case when tdp.kd_ket = 'PSK' then 1 else 0 end) as sakit,
                0 as dinas_luar,
                (select count(*) from \"Catering\".tpuasa t2 
                inner join \"Presensi\".tshiftpekerja tsp2 on t2.fs_noind=tsp2.noind and t2.fd_tanggal=tsp2.tanggal
                where 
                trim(t2.fs_tempat_makan) = trim(tp.tempat_makan) and t2.fd_tanggal = tsp.tanggal
                and tsp2.kd_shift in ('11',
                '2',
                '34')
                ) puasa
                from hrd_khs.tpribadi tp 
                inner join \"Presensi\".tshiftpekerja tsp 
                on tp.noind = tsp.noind
                inner join \"Catering\".ttempat_makan ttm
                on tp.tempat_makan = ttm.fs_tempat_makan
                left join \"Presensi\".tdatapresensi tdp 
                on tp.noind = tdp.noind
                and tdp.tanggal = tsp.tanggal
                where tsp.tanggal = '$tanggal'
                $lokasi
                and trim(ttm.fs_tempat_makan) not like '%CABANG%'
                and tp.keluar = '0'
                $shift
                group by tp.tempat_makan,tsp.tanggal
                order by 1";
        // echo ($sql);
        // exit;
        return $this->personalia->query($sql)->result_array();
    }

    public function getDinasLuarByNoind($noind)
    {
        $sql = "select t1.spdl_id,t1.noind,max(t2.sampai) as tgl_pulang
				from t_surat_perintah_dl t1 
				inner join t_surat_perintah_dl_detail t2 
				on t1.spdl_id = t2.spdl_id
				where t1.request_approve_draft=1 
				and t1.draft_approved=1
				and t1.request_approve_realisasi=0
				and t1.realisasi_approved=0
				and t1.laporan_approved=0
				and t1.cetak_realisasi=0
				and t2.sampai >= '2020-01-01'
				and t1.noind = ?
				group by t1.spdl_id,t1.noind
				order by t1.spdl_id desc ";
        return $this->dinas_luar->query($sql, array($noind))->result_array();
    }

    public function getAbsenSetelahPulangByTimestampNoind($tgl_pulang, $noind)
    {
        $sql = "select *
				from \"Presensi\".tpresensi_riil
				where concat(tanggal::date,' ',waktu::time)::timestamp >= ?
				and noind = ?";
        return $this->personalia->query($sql, array($tgl_pulang, $noind))->result_array();
    }

    public function getNoindByTempatMakanShiftTanggal($tempat_makan, $shift, $tanggal)
    {
        if ($shift == 1) {
            $shift = "and tsp.kd_shift in ('1','4','7','8','10')";
        } else if ($shift == 2) {
            $shift = "and tsp.kd_shift in ('11','2')";
        } else if ($shift == 3) {
            $shift = "and tsp.kd_shift in ('3','12')";
        } else {
            $shift = "and tsp.kd_shift in ('1','2','3','4','7','8','10','11','12')";
        }


        $sql = "select tp.noind
				from hrd_khs.tpribadi tp 
				inner join \"Presensi\".tshiftpekerja tsp 
				on tp.noind = tsp.noind
				where tsp.tanggal = ?
				and tp.tempat_makan = ?
				$shift
				order by 1 ";
        return $this->personalia->query($sql, array($tanggal, $tempat_makan))->result_array();
    }
}
