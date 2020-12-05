<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_namaaktif extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database("personalia", true);
    }
    public function GetNoinduk()
    {
        $sql = "SELECT * FROM hrd_khs.tnoind";
        return $this->personalia->query($sql)->result_array();
    }

    public function GetLokasikerja()
    {
        $sql = "SELECT * FROM hrd_khs.tlokasi_kerja";
        return $this->personalia->query($sql)->result_array();
    }

    public function GetIsiRadio($txt, $txt2)
    {
        if ($txt2 == "dept") {
            $trim = 1;
        } else if ($txt2 == "unit") {
            $trim = 5;
        } else {
            $trim = 7;
        }
        $sql = "SELECT DISTINCT TRIM ($txt2) $txt2, left(kodesie,$trim) kode FROM hrd_khs.tseksi WHERE TRIM($txt2) != '-' AND $txt2 LIKE '$txt%'";
        return $this->personalia->query($sql)->result_array();
    }


    public function viewAll($kodeinduk, $kodesie, $lokasi, $tanggal)
    {

        $sql = "SELECT tbl.noind, tbl.nama, ts.dept, ts.bidang, ts.unit, ts.seksi
        FROM ( SELECT CASE WHEN ( SELECT count(noind) 
        from \"Surat\".tsurat_pengangkatan where tanggal_berlaku > '$tanggal' and noind = tpri.noind ) > 0 
        then ( select noind from  \"Surat\".tsurat_pengangkatan where tanggal_berlaku > '$tanggal' and noind = tpri.noind order by tanggal_berlaku limit 1)
        else tpri.noind end noind, nama, case when ( select count(noind) from hrd_khs.tmutasi where tglberlaku > '$tanggal' and noind = tpri.noind ) > 0
        then ( select lokasilm from hrd_khs.tmutasi where tglberlaku > '$tanggal' and noind = tpri.noind order by tglberlaku limit 1) 
        else tpri.lokasi_kerja end lokasi_kerja, case when ( select count(noind) 
        from hrd_khs.tmutasi where tglberlaku > '$tanggal' and noind = tpri.noind ) > 0 then ( select kodesielm from hrd_khs.tmutasi where tglberlaku > '$tanggal'
        and noind = tpri.noind order by tglberlaku limit 1) else tpri.kodesie end kodesie from hrd_khs.tpribadi tpri where tglkeluar > '$tanggal' AND masukkerja < '$tanggal' ) tbl 
        left join hrd_khs.tseksi ts on ts.kodesie = tbl.kodesie where tbl.lokasi_kerja like '$lokasi%' and tbl.kodesie like '$kodesie%' and (tbl.noind LIKE '$kodeinduk%') order by noind";

        return $this->personalia->query($sql)->result_array();
    }
}
