<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_index extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', TRUE);
    }

    public function allowedAccess($jenis)
    {
        if ($jenis == '1') {
            $where = "AND a.kd_jabatan <= '13'";
        } else {
            $where = "AND left(a.noind, 1) != 'K'";
        }
        $sql = "SELECT distinct
                    a.noind
                from
                    hrd_khs.tpribadi a
                    left join hrd_khs.trefjabatan b on a.noind = b.noind
                where
                    (b.kodesie like '4010101%'
                    or a.noind in ('B0307','J1269','B0898','B0720'))
                    and a.keluar = '0'
                    $where";
        return $this->personalia->query($sql)->result_array();
    }

    public function getAllNama()
    {
        return $this->personalia->query("SELECT DISTINCT noind, trim(nama) as nama FROM hrd_khs.tpribadi")->result_array();
    }

    public function GetIzin($no_induk)
    {
        $sql = "SELECT a.*,
                (case when a.jenis_izin = '1' then 'DINAS PUSAT' when a.jenis_izin = '2' then 'DINAS TUKSONO' else 'DINAS MLATI' end) as to_dinas
                FROM \"Surat\".tperizinan a WHERE a.atasan_aproval LIKE '%$no_induk%'
                order by a.status, a.izin_id DESC";
        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

    public function getPerizinan($no_induk, $jenis)
    {
        $sql = "SELECT
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
                    where ip.atasan = '$no_induk' and ip.jenis_ijin = '$jenis'
                    order by
                        ip.appr_atasan desc, ip.id desc";
        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

    public function getMergeIzin($atasan)
    {
        $sql = "SELECT 'A-'||a.izin_id izin_id,
        a.created_date,
        a.noind,
        a.jenis_izin::int jenis_ijin,
        (case when a.jenis_izin = '1' then 'DINAS PUSAT' when a.jenis_izin = '2' then 'DINAS TUKSONO' else 'DINAS MLATI' end) as jenis_izin,
        case when a.status = '0' or a.status = '5' then 'Unapprove'
        when a.status = '1' then 'Approve'
        when a.status = '2' then 'Reject'
        else 'Nothing'
        end 
        status,
        a.keterangan,
        a.atasan_aproval,
        a.tujuan,
        a.berangkat
                        FROM \"Surat\".tperizinan a
                        WHERE a.atasan_aproval = '$atasan'
                            and a.status = '0'
                            and a.created_date::date = now()::date
        union
        select
        'B-'||ip.id izin_id,
        ip.created_date,
        ip.noind,
        ip.jenis_ijin,
        case when 
        ip.jenis_ijin = '1' then 'IZIN KELUAR PRIBADI'
        when ip.jenis_ijin = '2' then 'IZIN SAKIT PERUSAHAAN'
        when ip.jenis_ijin = '3' then 'IZIN DINAS KELUAR PERUSAHAAN'
        end jenis_izin,
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
                        end status,
        ip.keperluan,
        ip.atasan,
        ip.tujuan,
        ip.wkt_keluar
                    from
                        \"Surat\".tizin_pribadi ip
                    WHERE ip.status = '-'
                        and ip.created_date::date = now()::date
                        and ip.atasan = '$atasan'
                        and ip.appr_atasan is null
        order by created_date desc";
        return $this->personalia->query($sql)->result_array();
    }

    public function getTujuanTMP()
    {
        $sql = "SELECT distinct ti.izin_id, (select concat(noind, ' - ', trim(nama)) from hrd_khs.tpribadi where ti.noind = noind) as pekerja,
                (case when a.izin_id::int = ta.izin_id::int then ta.tujuan else ti.tujuan end) tujuan
                FROM \"Surat\".tperizinan a
                LEFT JOIN \"Surat\".tpekerja_izin ti on ti.izin_id::int = a.izin_id::int
                LEFT JOIN \"Surat\".taktual_izin ta on ta.izin_id::int = a.izin_id::int and ta.created_date::date = a.created_date::date and ti.noind = ta.noinduk";
        return $this->personalia->query($sql)->result_array();
    }
    public function getTujuanA()
    {
        $sql = "SELECT distinct 'A-'||ti.izin_id izin_id, (select concat(noind, ' - ', trim(nama)) from hrd_khs.tpribadi where ti.noind = noind) as pekerja,
        (case when a.izin_id::int = ta.izin_id::int then ta.tujuan else ti.tujuan end) tujuan
        FROM \"Surat\".tperizinan a
        LEFT JOIN \"Surat\".tpekerja_izin ti on ti.izin_id::int = a.izin_id::int
        LEFT JOIN \"Surat\".taktual_izin ta on ta.izin_id::int = a.izin_id::int 
        and ta.created_date::date = a.created_date::date and ti.noind = ta.noinduk
        union
        select 'B-'||ip.id izin_id,
        (select concat(noind, ' - ', trim(nama)) from hrd_khs.tpribadi where ip.noind = noind) as pekerja,
        ip.tujuan
        from \"Surat\".tizin_pribadi ip";
        return $this->personalia->query($sql)->result_array();
    }
    public function getTujuanApprove()
    {
        $sql = "SELECT distinct ti.izin_id, (select concat(noind, ' - ', trim(nama)) from hrd_khs.tpribadi where ti.noind = noind) as pekerja,
                (case when a.izin_id::int = ta.izin_id::int then ta.tujuan else ti.tujuan end) tujuan
                FROM \"Surat\".tperizinan a
                LEFT JOIN \"Surat\".tpekerja_izin ti on ti.izin_id::int = a.izin_id::int
                LEFT JOIN \"Surat\".taktual_izin ta on ta.izin_id::int = a.izin_id::int and ta.created_date::date = a.created_date::date and ti.noind = ta.noinduk
                where a.status = '1'";
        return $this->personalia->query($sql)->result_array();
    }
    public function getTujuanUnapprove()
    {
        $sql = "SELECT distinct ti.izin_id, (select concat(noind, ' - ', trim(nama)) from hrd_khs.tpribadi where ti.noind = noind) as pekerja,
                (case when a.izin_id::int = ta.izin_id::int then ta.tujuan else ti.tujuan end) tujuan
                FROM \"Surat\".tperizinan a
                LEFT JOIN \"Surat\".tpekerja_izin ti on ti.izin_id::int = a.izin_id::int
                LEFT JOIN \"Surat\".taktual_izin ta on ta.izin_id::int = a.izin_id::int and ta.created_date::date = a.created_date::date and ti.noind = ta.noinduk
                where a.status = '0'";
        return $this->personalia->query($sql)->result_array();
    }
    public function getTujuanReject()
    {
        $sql = "SELECT distinct ti.izin_id, (select concat(noind, ' - ', trim(nama)) from hrd_khs.tpribadi where ti.noind = noind) as pekerja,
                (case when a.izin_id::int = ta.izin_id::int then ta.tujuan else ti.tujuan end) tujuan
                FROM \"Surat\".tperizinan a
                LEFT JOIN \"Surat\".tpekerja_izin ti on ti.izin_id::int = a.izin_id::int
                LEFT JOIN \"Surat\".taktual_izin ta on ta.izin_id::int = a.izin_id::int and ta.created_date::date = a.created_date::date and ti.noind = ta.noinduk
                where a.status = '2' or a.status = '5'";
        return $this->personalia->query($sql)->result_array();
    }

    public function IzinApprove($no_induk)
    {
        $sql = "SELECT a.*
                FROM \"Surat\".tperizinan a WHERE a.atasan_aproval LIKE '%$no_induk%' and status = '1'
                order by a.created_date DESC";

        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

    public function IzinUnApprove($no_induk)
    {
        $today = date('Y-m-d');
        $sql = "SELECT a.*
                FROM \"Surat\".tperizinan a WHERE a.atasan_aproval LIKE '%$no_induk%' and status = '0' AND created_date::date = '$today'
                order by a.created_date DESC";

        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

    public function IzinReject($no_induk)
    {
        $today = date('Y-m-d');
        $sql = "SELECT a.*
                FROM \"Surat\".tperizinan a WHERE a.atasan_aproval LIKE '%$no_induk%' and status IN ('2', '5') OR (status = '0' AND created_date::date < '$today')
                order by a.created_date DESC";

        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

    public function update($status, $idizin)
    {
        $sql = "update \"Surat\".tperizinan
                set status ='$status'
                WHERE izin_id ='$idizin'";
        $query = $this->personalia->query($sql);
    }

    public function updatePekerja($status, $idizin)
    {
        $sql = "update \"Surat\".tpekerja_izin
                set status_jalan ='$status'
                WHERE izin_id ='$idizin'";
        $query = $this->personalia->query($sql);
    }

    public function update_tperizinan($noind, $status, $id, $imPlace)
    {
        $sql = "update \"Surat\".tperizinan
        set status ='$status', noind = '$noind', tujuan = '$imPlace'
        WHERE izin_id ='$id'";
        $query = $this->personalia->query($sql);
    }

    public function updatePekerjaBerangkat($noind, $status, $idizin)
    {
        $sql = "UPDATE \"Surat\".tpekerja_izin
                set status_jalan ='$status'
                WHERE izin_id ='$idizin' AND noind = '$noind'";
        $query = $this->personalia->query($sql);
    }

    public function cekIzin($idizin)
    {
        $sql = "SELECT * FROM \"Surat\".tperizinan WHERE izin_id::text = '$idizin'";

        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

    public function deletemakan($idizin)
    {
        $sql = "DELETE from \"Surat\".tpekerja_izin tpi
	                where tpi.izin_id='$idizin'";
        $this->personalia->query($sql);
        return;
    }

    public function getTujuanMakan($idizin)
    {
        $sql = "SELECT * FROM \"Surat\".tpekerja_izin WHERE izin_id = '$idizin'";
        return $this->personalia->query($sql)->result_array();
    }

    public function getTujuan($id, $noind, $param)
    {
        $new = '';
        if ($param == true) {
            $new = "AND noind IN ('$noind')";
        } else {
            $new = "AND noind = '$noind'";
        }
        $sql = "SELECT trim(tujuan) as tujuan FROM \"Surat\".tpekerja_izin WHERE izin_id = '$id' $new";
        return $this->personalia->query($sql)->result_array();
    }

    public function getPekerjaEdit($idizin)
    {
        $sql = "SELECT ti.*, (SELECT trim(nama) FROM hrd_khs.tpribadi where noind = ti.noind and keluar = '0') as nama, tper.keterangan, cast(tper.created_date as date), tper.berangkat
                FROM \"Surat\".tpekerja_izin ti
                LEFT JOIN \"Surat\".tperizinan tper ON tper.izin_id = ti.izin_id::int
                WHERE ti.izin_id = '$idizin'";
        return $this->personalia->query($sql)->result_array();
    }

    public function getDataPekerja($a, $b)
    {
        $sql = "SELECT * FROM \"Surat\".tpekerja_izin WHERE izin_id = '$b' AND noind = '$a'";
        return $this->personalia->query($sql)->result_array();
    }

    public function pekerja($noind)
    {
        $sql = "SELECT noind, trim(nama) as nama from hrd_khs.tpribadi where noind in ('$noind') ";
        return $this->personalia->query($sql)->result_array();
    }

    public function getImel($key)
    {
        $sql = "SELECT email_internal from hrd_khs.tpribadi where noind in ('$key')";
        return $this->personalia->query($sql)->row()->email_internal;
    }

    //insert

    public function taktual_izin($pekerja)
    {
        $this->personalia->insert('Surat.taktual_izin', $pekerja);
        return;
    }
}
