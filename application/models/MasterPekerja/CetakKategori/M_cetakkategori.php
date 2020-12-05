<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_cetakkategori extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database("personalia", true);
    }

    public function GetNoinduk()
    {
        $sql = "SELECT * FROM hrd_khs.tnoind ORDER BY tnoind";
        return $this->personalia->query($sql)->result_array();
    }

    public function GetPendidikan()
    {
        $sql = "SELECT DISTINCT tpri.pendidikan FROM hrd_khs.tpribadi tpri
        WHERE tpri.pendidikan != '-' AND tpri.pendidikan != '' ORDER BY tpri.pendidikan";
        return $this->personalia->query($sql)->result_array();
    }

    public function GetJenkel()
    {
        $sql = "SELECT DISTINCT tpri.jenkel FROM hrd_khs.tpribadi tpri
        WHERE tpri.jenkel != '-' AND tpri.jenkel != ''";
        return $this->personalia->query($sql)->result_array();
    }

    public function GetLokasi()
    {
        $sql = "SELECT * FROM hrd_khs.tlokasi_kerja";
        return $this->personalia->query($sql)->result_array();
    }

    public function GetKategori($txt, $txt2)
    {
        if ($txt2 == "Dept") {
            $trim = 1;
        } else if ($txt2 == "Unit") {
            $trim = 5;
        } else {
            $trim = 7;
        }
        $sql = "SELECT DISTINCT TRIM ($txt2) $txt2, left(kodesie,$trim) kode FROM hrd_khs.tseksi WHERE TRIM($txt2) != '-' AND $txt2 LIKE '$txt%'";
        return $this->personalia->query($sql)->result_array();
    }

    public function GetStatus()
    {
        $sql = "SELECT DISTINCT tpri.keluar, CASE
        WHEN tpri.keluar= 't' THEN 'Keluar'
        WHEN tpri.keluar= 'f' THEN 'Aktif'
        END status
             FROM hrd_khs.tpribadi tpri";
        return $this->personalia->query($sql)->result_array();
    }

    public function GetFilter($kodeind, $pend, $jenkel,  $lokasi, $kategori, $select, $rangekeluarstart, $rangekeluarend,  $rangemasukstart, $rangemasukend, $status)
    {
        if ($rangekeluarstart == "1000-01-01" && $rangemasukstart == "1000-01-01") {
            $sql = "SELECT DISTINCT $select
            FROM hrd_khs.tseksi ts, hrd_khs.tpribadi tp
            left join hrd_khs.tbpjskes tb on tb.noind = tp.noind
            left join hrd_khs.tbpjstk ttk on ttk.noind=tp.noind 
            WHERE ts.kodesie = tp.kodesie 
            AND tp.kodesie LIKE '$kategori%' AND (tp.noind LIKE '$kodeind%') AND tp.pendidikan LIKE '$pend%' AND tp.jenkel 
            LIKE '$jenkel%' AND tp.lokasi_kerja LIKE '$lokasi%' AND tp.keluar = '$status' order by noind";
            return $this->personalia->query($sql)->result_array();
        } else {
            $sql = "SELECT DISTINCT $select
            FROM hrd_khs.tseksi ts, hrd_khs.tpribadi tp
            left join hrd_khs.tbpjskes tb on tb.noind = tp.noind
            left join hrd_khs.tbpjstk ttk on ttk.noind=tp.noind 
            WHERE ts.kodesie = tp.kodesie 
            AND tp.kodesie LIKE '$kategori%' AND (tp.noind LIKE '$kodeind%') AND tp.pendidikan LIKE '$pend%' AND tp.jenkel 
            LIKE '$jenkel%' AND tp.lokasi_kerja LIKE '$lokasi%' AND tp.keluar = '$status'
            AND (masukkerja > '$rangemasukstart' AND masukkerja < '$rangemasukend'  OR tglkeluar> '$rangekeluarstart' AND tglkeluar< '$rangekeluarend') order by noind";
            return $this->personalia->query($sql)->result_array();
        }
    }
}
