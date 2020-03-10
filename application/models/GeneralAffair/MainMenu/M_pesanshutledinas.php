<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pesanshutledinas extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', true);
    }

    public function get89($tgl)
    {
        $sql = "SELECT concat(tpi.noind,' - ',split_part(tp.nama, ' ', 1),'<br>') as pekerja
                from \"Surat\".tperizinan a
                left join \"Surat\".tpekerja_izin tpi on tpi.izin_id::int = a.izin_id
                left join hrd_khs.tpribadi tp on tp.noind = tpi.noind
                where tpi.status_jalan not in ('5') and a.status in ('1') and a.created_date::date = '$tgl'
                and tp.keluar = '0' and a.psn_shtl = '1' and a.wkt_shtl_1 = '08:00:00' and wkt_shtl_2 = '09:00:00'";
        return $this->personalia->query($sql)->result_array();
    }
    public function get910($tgl)
    {
        $sql = "SELECT concat(tpi.noind,' - ',split_part(tp.nama, ' ', 1),'<br>') as pekerja
                from \"Surat\".tperizinan a
                left join \"Surat\".tpekerja_izin tpi on tpi.izin_id::int = a.izin_id
                left join hrd_khs.tpribadi tp on tp.noind = tpi.noind
                where tpi.status_jalan not in ('5') and a.status in ('1') and a.created_date::date = '$tgl'
                and tp.keluar = '0' and a.psn_shtl = '1' and a.wkt_shtl_1 = '09:00:00' and wkt_shtl_2 = '10:00:00'";
        return $this->personalia->query($sql)->result_array();
    }
    public function get913($tgl)
    {
        $sql = "SELECT concat(tpi.noind,' - ',split_part(tp.nama, ' ', 1),'<br>') as pekerja
                from \"Surat\".tperizinan a
                left join \"Surat\".tpekerja_izin tpi on tpi.izin_id::int = a.izin_id
                left join hrd_khs.tpribadi tp on tp.noind = tpi.noind
                where tpi.status_jalan not in ('5') and a.status in ('1') and a.created_date::date = '$tgl'
                and tp.keluar = '0' and a.psn_shtl = '1' and a.wkt_shtl_1 = '09:00:00' and wkt_shtl_2 = '13:00:00'";
        return $this->personalia->query($sql)->result_array();
    }
    public function get900($tgl)
    {
        $sql = "SELECT concat(tpi.noind,' - ',split_part(tp.nama, ' ', 1),'<br>') as pekerja
                from \"Surat\".tperizinan a
                left join \"Surat\".tpekerja_izin tpi on tpi.izin_id::int = a.izin_id
                left join hrd_khs.tpribadi tp on tp.noind = tpi.noind
                where tpi.status_jalan not in ('5') and a.status in ('1') and a.created_date::date = '$tgl'
                and tp.keluar = '0' and a.psn_shtl = '1' and a.wkt_shtl_1 = '00:00:00' and wkt_shtl_2 = '09:00:00'";
        return $this->personalia->query($sql)->result_array();
    }
    public function get811($tgl)
    {
        $sql = "SELECT concat(tpi.noind,' - ',split_part(tp.nama, ' ', 1),'<br>') as pekerja
                from \"Surat\".tperizinan a
                left join \"Surat\".tpekerja_izin tpi on tpi.izin_id::int = a.izin_id
                left join hrd_khs.tpribadi tp on tp.noind = tpi.noind
                where tpi.status_jalan not in ('5') and a.status in ('1') and a.created_date::date = '$tgl'
                and tp.keluar = '0' and a.psn_shtl = '1' and a.wkt_shtl_1 = '08:00:00' and wkt_shtl_2 = '11:00:00'";
        return $this->personalia->query($sql)->result_array();
    }
    public function get1011($tgl)
    {
        $sql = "SELECT concat(tpi.noind,' - ',split_part(tp.nama, ' ', 1),'<br>') as pekerja
                from \"Surat\".tperizinan a
                left join \"Surat\".tpekerja_izin tpi on tpi.izin_id::int = a.izin_id
                left join hrd_khs.tpribadi tp on tp.noind = tpi.noind
                where tpi.status_jalan not in ('5') and a.status in ('1') and a.created_date::date = '$tgl'
                and tp.keluar = '0' and a.psn_shtl = '1' and a.wkt_shtl_1 = '10:00:00' and wkt_shtl_2 = '11:00:00'";
        return $this->personalia->query($sql)->result_array();
    }
    public function get1113($tgl)
    {
        $sql = "SELECT concat(tpi.noind,' - ',split_part(tp.nama, ' ', 1),'<br>') as pekerja
                from \"Surat\".tperizinan a
                left join \"Surat\".tpekerja_izin tpi on tpi.izin_id::int = a.izin_id
                left join hrd_khs.tpribadi tp on tp.noind = tpi.noind
                where tpi.status_jalan not in ('5') and a.status in ('1') and a.created_date::date = '$tgl'
                and tp.keluar = '0' and a.psn_shtl = '1' and a.wkt_shtl_1 = '11:00:00' and wkt_shtl_2 = '13:00:00'";
        return $this->personalia->query($sql)->result_array();
    }
    public function get1100($tgl)
    {
        $sql = "SELECT concat(tpi.noind,' - ',split_part(tp.nama, ' ', 1),'<br>') as pekerja
                from \"Surat\".tperizinan a
                left join \"Surat\".tpekerja_izin tpi on tpi.izin_id::int = a.izin_id
                left join hrd_khs.tpribadi tp on tp.noind = tpi.noind
                where tpi.status_jalan not in ('5') and a.status in ('1') and a.created_date::date = '$tgl'
                and tp.keluar = '0' and a.psn_shtl = '1' and a.wkt_shtl_1 = '00:00:00' and wkt_shtl_2 = '11:00:00'";
        return $this->personalia->query($sql)->result_array();
    }
    public function get814($tgl)
    {
        $sql = "SELECT concat(tpi.noind,' - ',split_part(tp.nama, ' ', 1),'<br>') as pekerja
                from \"Surat\".tperizinan a
                left join \"Surat\".tpekerja_izin tpi on tpi.izin_id::int = a.izin_id
                left join hrd_khs.tpribadi tp on tp.noind = tpi.noind
                where tpi.status_jalan not in ('5') and a.status in ('1') and a.created_date::date = '$tgl'
                and tp.keluar = '0' and a.psn_shtl = '1' and a.wkt_shtl_1 = '08:00:00' and wkt_shtl_2 = '14:00:00'";
        return $this->personalia->query($sql)->result_array();
    }
    public function get1014($tgl)
    {
        $sql = "SELECT concat(tpi.noind,' - ',split_part(tp.nama, ' ', 1),'<br>') as pekerja
                from \"Surat\".tperizinan a
                left join \"Surat\".tpekerja_izin tpi on tpi.izin_id::int = a.izin_id
                left join hrd_khs.tpribadi tp on tp.noind = tpi.noind
                where tpi.status_jalan not in ('5') and a.status in ('1') and a.created_date::date = '$tgl'
                and tp.keluar = '0' and a.psn_shtl = '1' and a.wkt_shtl_1 = '10:00:00' and wkt_shtl_2 = '14:00:00'";
        return $this->personalia->query($sql)->result_array();
    }
    public function get1314($tgl)
    {
        $sql = "SELECT concat(tpi.noind,' - ',split_part(tp.nama, ' ', 1),'<br>') as pekerja
                from \"Surat\".tperizinan a
                left join \"Surat\".tpekerja_izin tpi on tpi.izin_id::int = a.izin_id
                left join hrd_khs.tpribadi tp on tp.noind = tpi.noind
                where tpi.status_jalan not in ('5') and a.status in ('1') and a.created_date::date = '$tgl'
                and tp.keluar = '0' and a.psn_shtl = '1' and a.wkt_shtl_1 = '13:00:00' and wkt_shtl_2 = '14:00:00'";
        return $this->personalia->query($sql)->result_array();
    }
    public function get1400($tgl)
    {
        $sql = "SELECT concat(tpi.noind,' - ',split_part(tp.nama, ' ', 1),'<br>') as pekerja
                from \"Surat\".tperizinan a
                left join \"Surat\".tpekerja_izin tpi on tpi.izin_id::int = a.izin_id
                left join hrd_khs.tpribadi tp on tp.noind = tpi.noind
                where tpi.status_jalan not in ('5') and a.status in ('1') and a.created_date::date = '$tgl'
                and tp.keluar = '0' and a.psn_shtl = '1' and a.wkt_shtl_1 = '00:00:00' and wkt_shtl_2 = '14:00:00'";
        return $this->personalia->query($sql)->result_array();
    }
    public function get8($tgl)
    {
        $sql = "SELECT concat(tpi.noind,' - ',split_part(tp.nama, ' ', 1),'<br>') as pekerja
                from \"Surat\".tperizinan a
                left join \"Surat\".tpekerja_izin tpi on tpi.izin_id::int = a.izin_id
                left join hrd_khs.tpribadi tp on tp.noind = tpi.noind
                where tpi.status_jalan not in ('5') and a.status in ('1') and a.created_date::date = '$tgl'
                and tp.keluar = '0' and a.psn_shtl = '1' and a.wkt_shtl_1 = '08:00:00' and wkt_shtl_2 = '00:00:00'";
        return $this->personalia->query($sql)->result_array();
    }
    public function get10($tgl)
    {
        $sql = "SELECT concat(tpi.noind,' - ',split_part(tp.nama, ' ', 1),'<br>') as pekerja
                from \"Surat\".tperizinan a
                left join \"Surat\".tpekerja_izin tpi on tpi.izin_id::int = a.izin_id
                left join hrd_khs.tpribadi tp on tp.noind = tpi.noind
                where tpi.status_jalan not in ('5') and a.status in ('1') and a.created_date::date = '$tgl'
                and tp.keluar = '0' and a.psn_shtl = '1' and a.wkt_shtl_1 = '10:00:00' and wkt_shtl_2 = '00:00:00'";
        return $this->personalia->query($sql)->result_array();
    }
    public function get13($tgl)
    {
        $sql = "SELECT concat(tpi.noind,' - ',split_part(tp.nama, ' ', 1),'<br>') as pekerja
                from \"Surat\".tperizinan a
                left join \"Surat\".tpekerja_izin tpi on tpi.izin_id::int = a.izin_id
                left join hrd_khs.tpribadi tp on tp.noind = tpi.noind
                where tpi.status_jalan not in ('5') and a.status in ('1') and a.created_date::date = '$tgl'
                and tp.keluar = '0' and a.psn_shtl = '1' and a.wkt_shtl_1 = '13:00:00' and wkt_shtl_2 = '00:00:00'";
        return $this->personalia->query($sql)->result_array();
    }
    public function get0($tgl)
    {
        $sql = "SELECT concat(tpi.noind,' - ',split_part(tp.nama, ' ', 1),'<br>') as pekerja
                from \"Surat\".tperizinan a
                left join \"Surat\".tpekerja_izin tpi on tpi.izin_id::int = a.izin_id
                left join hrd_khs.tpribadi tp on tp.noind = tpi.noind
                where tpi.status_jalan not in ('5') and a.status in ('1') and a.created_date::date = '$tgl'
                and tp.keluar = '0' and a.psn_shtl = '1' and a.wkt_shtl_1 = '00:00:00' and wkt_shtl_2 = '00:00:00'";
        return $this->personalia->query($sql)->result_array();
    }

    public function getUser($noind)
    {
        $sql = "SELECT concat(tp.noind,' - ',trim(tp.nama)) as pekerja from hrd_khs.tpribadi tp where noind = '$noind'";
        return $this->personalia->query($sql)->row()->pekerja;
    }
}

/* End of file M_fleetbengkel.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_pesanshutledinas.php */
/* Generated automatically on 2020-02-13 */
