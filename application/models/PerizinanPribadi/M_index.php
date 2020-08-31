<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class M_index extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database();
        $this->personalia = $this->load->database('personalia', true);
    }

    public function GetIzin($noind, $jenis)
    {
        $sql = "select
                ip.*,
                ipd.noind,
                trim(tp.nama) nama,
                ip.atasan,
                trim(tp2.nama) nama_atasan,
                ip.keperluan ket_pekerja,
                case
                    when ip.jenis_ijin in (1,3) then
                    case
                        when ip.verifikasi_satpam = '1' then 'Izin Keluar'
                        when ip.verifikasi_satpam is null
                        and ip.appr_atasan = '1' then 'Belum Verifikasi Satpam'
                        when ip.verifikasi_satpam is null
                        and ip.appr_atasan = '0' then 'Rejected Atasan'
                        when ip.appr_atasan is null then 'Menunggu Approval Atasan'
                    end
                    when ip.jenis_ijin = 2 then
                    case
                        when ip.verifikasi_satpam = '1' then 'Izin Pulang'
                        when ip.verifikasi_satpam is null
                        and ip.appr_paramedik = '1' then 'Belum Verifikasi Satpam'
                        when ip.verifikasi_satpam is null
                        and ip.appr_paramedik = '0' then 'Rejected Paramedik'
                        when ip.appr_paramedik is null
                        and ip.appr_atasan = '1' then 'Periksa Paramedik'
                        when ip.appr_paramedik is null
                        and ip.appr_atasan = '0' then 'Rejected Atasan'
                        when ip.appr_atasan is null then 'Menunggu Approval Atasan'
                    end
                end status
            from
                \"Surat\".tizin_pribadi ip,
                \"Surat\".tizin_pribadi_detail ipd,
                hrd_khs.tpribadi tp,
                hrd_khs.tpribadi tp2
            where
                ip.id = ipd.id
                and ipd.noind = tp.noind
                and ip.atasan = tp2.noind
                and ip.atasan = '$noind'
            order by
                ip.id desc";

        $sql2 = "select
                *,
                (select trim(nama) from hrd_khs.tpribadi where noind = ip.atasan) nama_atasan,
                (select string_agg(concat(noind,' - ',trim(nama)),',') from hrd_khs.tpribadi where noind in 
                (select noind from \"Surat\".tizin_pribadi_detail tpd where tpd.id = ip.id)
                ) nama_pkj,
                case
                    when ip.jenis_ijin in (1,
                    3) then
                    case
                        when ip.verifikasi_satpam = '1' then 'Izin Keluar'
                        when ip.verifikasi_satpam is null
                        and ip.appr_atasan = '1' then 'Belum Verifikasi Satpam'
                        when ip.verifikasi_satpam is null
                        and ip.appr_atasan = '0' then 'Rejected Atasan'
                        when ip.appr_atasan is null then 'Menunggu Approval Atasan'
                    end
                    when ip.jenis_ijin = 2 then
                    case
                        when ip.verifikasi_satpam = '1' then 'Izin Pulang'
                        when ip.verifikasi_satpam is null
                        and ip.appr_paramedik = '1' then 'Belum Verifikasi Satpam'
                        when ip.verifikasi_satpam is null
                        and ip.appr_paramedik = '0' then 'Rejected Paramedik'
                        when ip.appr_paramedik is null
                        and ip.appr_atasan = '1' then 'Periksa Paramedik'
                        when ip.appr_paramedik is null
                        and ip.appr_atasan = '0' then 'Rejected Atasan'
                        when ip.appr_atasan is null then 'Menunggu Approval Atasan'
                    end
                end status from \"Surat\".tizin_pribadi ip
                order by id desc";
        if ($jenis) {
            $where = "and ip.jenis_ijin = '$jenis'";
        } else {
            $where = '';
        }

        $sql3 = "select
        *,
        (select trim(nama) from hrd_khs.tpribadi where noind = ip.atasan) nama_atasan,
        (select string_agg(concat(noind,' - ',trim(nama)),',') from hrd_khs.tpribadi where noind in 
        (select noind from \"Surat\".tizin_pribadi_detail tpd where tpd.id = ip.id)
        ) nama_pkj,
                case
                    when ip.jenis_ijin in (1,3) then
                    case
                        when ip.verifikasi_satpam = '1' then 'Izin Keluar'
                        when ip.verifikasi_satpam is null
                        and ip.appr_atasan = '1' then 'Belum Verifikasi Satpam'
                        when ip.verifikasi_satpam is null
                        and ip.appr_atasan = '0' then 'Rejected Atasan'
                        when ip.appr_atasan is null then 'Menunggu Approval Atasan'
                    end
                    when ip.jenis_ijin = 2 then
                    case
                        when ip.verifikasi_satpam = '1' then 'Izin Pulang'
                        when ip.verifikasi_satpam is null
                        and ip.appr_paramedik = '1' then 'Belum Verifikasi Satpam'
                        when ip.verifikasi_satpam is null
                        and ip.appr_paramedik = '0' then 'Rejected Paramedik'
                        when ip.appr_paramedik is null
                        and ip.appr_atasan = '1' then 'Periksa Paramedik'
                        when ip.appr_paramedik is null
                        and ip.appr_atasan = '0' then 'Rejected Atasan'
                        when ip.appr_atasan is null then 'Menunggu Approval Atasan'
                    end
                end status
            from
                \"Surat\".tizin_pribadi ip
            where ip.atasan = '$noind'
                $where
            order by
                ip.appr_atasan desc, ip.id desc";
        // echo $sql;exit();
        return $this->personalia->query($sql3)->result_array();
    }

    public function updatePekerja($status, $idizin)
    {
        $sql = "update \"Surat\".tpekerja_izin
                set status_jalan ='$status'
                WHERE izin_id ='$idizin'";
        $query = $this->personalia->query($sql);
    }

    public function update($status, $idizin, $kptsn)
    {
        $sql = "update \"Surat\".tizin_pribadi
                set appr_atasan ='$status', tgl_appr_atasan = now(), status = '$kptsn'
                WHERE id ='$idizin'";
        $query = $this->personalia->query($sql);
    }

    public function updateTizinPribadiDetail($id_izin, $keputusan)
    {
        $sql = "update \"Surat\".tizin_pribadi_detail
                set status = '$keputusan'
                WHERE id ='$id_izin'";
        $query = $this->personalia->query($sql);
    }

    public function getPekerja($id)
    {
        $sql = "SELECT * from \"Surat\".tizin_pribadi_detail
                Where id = '$id'";
        return $this->personalia->query($sql)->result_array();
    }

    public function getSerahkan($implode, $id)
    {
        $sql = "SELECT diserahkan from \"Surat\".tizin_pribadi_detail
                Where id = '$id' AND noind in ('$implode')";
        return $this->personalia->query($sql)->result_array();
    }

    public function taktual_pribadi($pekerja)
    {
        $this->personalia->insert('Surat.taktual_pribadi', $pekerja);
        return;
    }

    public function getPekerjaEdit($idizin)
    {
        $sql = "SELECT ti.*, (SELECT trim(nama) FROM hrd_khs.tpribadi where noind = ti.noind and keluar = '0') as nama, tper.keperluan, cast(tper.created_date as date), tper.wkt_keluar
                FROM \"Surat\".tizin_pribadi_detail ti
                LEFT JOIN \"Surat\".tizin_pribadi tper ON tper.id = ti.id
                WHERE ti.id = '$idizin'";
        return $this->personalia->query($sql)->result_array();
    }

    public function updatePekerjaBerangkat($noind, $status, $idizin)
    {
        $sql = "UPDATE \"Surat\".tizin_pribadi_detail
                set status ='$status'
                WHERE id ='$idizin' AND noind = '$noind'";
        return $this->personalia->query($sql);
    }

    public function getDataPekerja($a, $b)
    {
        $sql = "SELECT * FROM \"Surat\".tizin_pribadi_detail WHERE id = '$b' AND noind = '$a'";
        return $this->personalia->query($sql)->result_array();
    }

    public function update_tperizinan($noind, $status, $id, $serahkan)
    {
        $sql = "UPDATE \"Surat\".tizin_pribadi
                set appr_atasan ='$status', noind = '$noind', diserahkan = '$serahkan'
                WHERE id ='$id'";
        return $this->personalia->query($sql);
    }

    public function getAllNama()
    {
        return $this->personalia->query("SELECT DISTINCT noind, trim(nama) as nama FROM hrd_khs.tpribadi")->result_array();
    }

    public function getNamaByNoind($noind)
    {
        return $this->personalia->query("SELECT trim(nama) as nama FROM hrd_khs.tpribadi where noind = '$noind'")->row()->nama;
    }

    public function GetIzinPribadi($periode, $end, $jenis)
    {
        $user = $this->session->userdata('user');
        if (!empty($periode) && !empty($end)) {
            $where = 'where ' . $periode . $end;
        } elseif (empty($periode) && !empty($end)) {
            $where = 'where' . $end;
        } else {
            $where = '';
        }

        if ($jenis) {
            $and = $jenis;
        } else {
            $and = "";
        }
        $sql3 = "SELECT
                ip.id,
                ip.created_date,
                ip.keperluan,
                ip.wkt_keluar,
                case when ip.jenis_ijin = '1' then 'Izin Keluar Pribadi'
                    when ip.jenis_ijin = '2' then 'Izin Sakit Perusahaan'
                    else 'Izin Dinas Keluar Perusahaan' end jenis_ijin,
                ip.kembali,
                ip.back_timestamp,
                (select concat(ip.atasan,' - ',trim(nama)) from hrd_khs.tpribadi where noind = ip.atasan) nama_atasan,
                (select string_agg(concat(noind,' - ',trim(nama)),',') from hrd_khs.tpribadi where noind in 
                (select noind from \"Surat\".tizin_pribadi_detail tpd where tpd.id = ip.id)
                ) nama_pkj,
                case
                    when ip.jenis_ijin in (1,3) then
                    case
                        when ip.verifikasi_satpam = '1' then 'Izin Keluar'
                        when ip.verifikasi_satpam is null
                        and ip.appr_atasan = '1' then 'Belum Verifikasi Satpam'
                        when ip.verifikasi_satpam is null
                        and ip.appr_atasan = '0' then 'Rejected Atasan'
                        when ip.appr_atasan is null then 'Menunggu Approval Atasan'
                    end
                    when ip.jenis_ijin = 2 then
                    case
                        when ip.verifikasi_satpam = '1' then 'Izin Pulang'
                        when ip.verifikasi_satpam is null
                        and ip.appr_paramedik = '1' then 'Belum Verifikasi Satpam'
                        when ip.verifikasi_satpam is null
                        and ip.appr_paramedik = '0' then 'Rejected Paramedik'
                        when ip.appr_paramedik is null
                        and ip.appr_atasan = '1' then 'Periksa Paramedik'
                        when ip.appr_paramedik is null
                        and ip.appr_atasan = '0' then 'Rejected Atasan'
                        when ip.appr_atasan is null then 'Menunggu Approval Atasan'
                    end
                end status
            from
                \"Surat\".tizin_pribadi ip
            $where $and
            order by
                ip.appr_atasan desc, ip.id desc";
        // echo $sql;exit();
        return $this->personalia->query($sql3)->result_array();
    }

    public function approveAtasan($atasan)
    {
        $today = date('Y-m-d');
        $sql = "SELECT * from \"Surat\".tizin_pribadi where atasan = '$atasan' Order BY id DESC";

        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

    public function IzinUnApprove($no_induk)
    {
        $today = date('Y-m-d');
        $sql = "SELECT * from \"Surat\".tizin_pribadi where atasan = '$no_induk' and created_date::date = '$today' Order BY id DESC";

        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

    public function IzinReject($no_induk)
    {
        $today = date('Y-m-d');
        $sql = "SELECT * from \"Surat\".tizin_pribadi where atasan = '$no_induk' and (created_date::date < '$today') Order BY id DESC";

        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

    public function getPekerjarekap($tanggal)
    {
        if (!empty($tanggal)) {
            $new = "WHERE $tanggal";
        } else {
            $new = "";
        }
        $sql = "SELECT ti.*, (SELECT trim(nama) as nama FROM hrd_khs.tpribadi WHERE noind = ti.noind) as nama, tp.atasan, tp.keperluan, ti.status, tp.created_date
				FROM \"Surat\".tizin_pribadi_detail ti
                LEFT JOIN \"Surat\".tizin_pribadi tp ON tp.id = ti.id::int $new
				ORDER BY ti.id DESC, ti.status, ti.noind";
        return $this->personalia->query($sql)->result_array();
    }

    public function getList2()
    {
        $sql = "select
                    *
                from
                    \"Surat\".tizin_pribadi tzp
                where
                    tzp.jenis_ijin = '2'
                order by id desc";
        return $this->personalia->query($sql)->result_array();
    }

    public function updateTizin($id, $arr)
    {
        $this->personalia->where('id', $id);
        $this->personalia->update('"Surat".tizin_pribadi', $arr);
    }

    public function GetIzinbyId($id)
    {
        $sql = "select
                    tzp.*, rtrim(tp.nama) nama_pkj, tp2.email_internal, rtrim(tp2.nama) nama_atasan
                from
                    \"Surat\".tizin_pribadi tzp
                    left join hrd_khs.tpribadi tp on tp.noind = tzp.noind
                    left join hrd_khs.tpribadi tp2 on tp2.noind = tzp.atasan
                where
                    id = '$id'";
        return $this->personalia->query($sql);
    }

    public function getLIzin($kolom)
    {
        $sql = "Select $kolom from \"Surat\".tizin_pribadi order by id desc";
        return $this->personalia->query($sql);
    }

    public function getLIzinNoind()
    {
        $sql = "select
                    distinct(tp.noind),
                    rtrim(tp.nama) nama
                from
                    \"Surat\".tizin_pribadi_detail tpd
                left join hrd_khs.tpribadi tp on
                    tp.noind = tpd.noind";
        return $this->personalia->query($sql);
    }

    public function allowedParamedik()
    {
        $sql = "select
                    noind
                from
                    hrd_khs.tpribadi
                where
                    (kodesie like '4010101%'
                    or noind = 'B0307'
                    or noind = 'J1269'
                    or noind = 'B0898'
                    or noind = 'B0720')
                    and keluar = '0'
                    and kd_jabatan <= '13'";
        return $this->personalia->query($sql)->result_array();
    }

    public function updateManualHubker($id, $status)
    {
        $sql = "UPDATE \"Surat\".tizin_pribadi set manual = '$status' where id='$id'";
        $this->personalia->query($sql);
        return true;
    }
}
