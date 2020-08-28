<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_index extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', TRUE);
    }

    public function allowedAccess()
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

    public function GetIzin($today)
    {
        $sql = "SELECT a.*,
                (case when a.jenis_izin = '1' then 'DINAS PUSAT' when a.jenis_izin = '2' then 'DINAS TUKSONO' else 'DINAS MLATI' end) as to_dinas,
                (select string_agg(concat(noind,' - ',trim(nama)),'<br>') from hrd_khs.tpribadi b where position(b.noind in a.atasan_aproval)>0) as atasan
                FROM \"Surat\".tperizinan a
                WHERE a.created_date::date = '$today'
                AND a.status = '0'
                order by a.status, a.izin_id DESC";

        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

    public function getTujuanA($today)
    {
        $sql = "SELECT ti.izin_id, (select concat(noind, ' - ', trim(nama)) from hrd_khs.tpribadi where ti.noind = noind) as pekerja, ti.tujuan
                FROM \"Surat\".tperizinan a
                LEFT JOIN \"Surat\".tpekerja_izin ti on ti.izin_id::int = a.izin_id::int
                WHERE a.created_date::date = '$today'
                AND a.status = '0'";
        return $this->personalia->query($sql)->result_array();
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

    public function taktual_izin($pekerja)
    {
        $this->personalia->insert('Surat.taktual_izin', $pekerja);
        return;
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

    public function getAtasanEdit($id)
    {
        $sql = "SELECT atasan_aproval FROM \"Surat\".tperizinan where izin_id = '$id'";
        return $this->personalia->query($sql)->row()->atasan_aproval;
    }

    public function updateAtasan($atasan, $id)
    {
        $sql = "UPDATE \"Surat\".tperizinan set atasan_aproval = '$atasan' where izin_id = '$id'";
        return $this->personalia->query($sql);
    }

    public function updateAtasanPribadi($atasan, $id)
    {
        $sql = "UPDATE \"Surat\".tizin_pribadi set atasan = '$atasan' where id = '$id'";
        return $this->personalia->query($sql);
    }

    public function getPekerjaEdit($idizin)
    {
        $sql = "SELECT ti.*, (SELECT trim(nama) FROM hrd_khs.tpribadi where noind = ti.noind and keluar = '0') as nama, tper.keterangan, cast(tper.created_date as date), tper.berangkat, tper.atasan_aproval
                FROM \"Surat\".tpekerja_izin ti
                LEFT JOIN \"Surat\".tperizinan tper ON tper.izin_id = ti.izin_id::int
                WHERE ti.izin_id = '$idizin'";
        return $this->personalia->query($sql)->result_array();
    }

    public function getPekerjaEditPribadi($id)
    {
        $sql = "SELECT ti.*, (SELECT trim(nama) FROM hrd_khs.tpribadi where noind = ti.noind and keluar = '0') as nama, tper.keperluan, cast(tper.created_date as date), tper.wkt_keluar, tper.atasan, tper.jenis_ijin
                FROM \"Surat\".tizin_pribadi_detail ti
                LEFT JOIN \"Surat\".tizin_pribadi tper ON tper.id = ti.id
                where tper.id = '$id'";
        return $this->personalia->query($sql)->result_array();
    }
    public function getDataPekerja($a, $b)
    {
        $sql = "SELECT * FROM \"Surat\".tpekerja_izin WHERE izin_id = '$b' AND noind = '$a'";
        return $this->personalia->query($sql)->result_array();
    }

    public function getAtasan($noind = FALSE, $text = FALSE)
    {
        $today = date('Y-m-d');
        if ($noind == FALSE) {
            $kondisi = "AND c.kd_jabatan between '01' and '13'";
        } else {
            $kondisi = "AND c.kd_jabatan::int < (
                    SELECT min(f.kd_jabatan::int)
                    FROM hrd_khs.tpribadi d
                        INNER JOIN hrd_khs.tseksi e on d.kodesie = e.kodesie
                        INNER JOIN hrd_khs.torganisasi f on d.kd_jabatan=f.kd_jabatan
                    WHERE d.noind in ($noind))
                    and (a.noind like upper('%$text%') or a.nama like upper('%$text%')) and c.kd_jabatan <= '13' ";
        }
        $sql = "SELECT distinct a.noind employee_code
                    ,trim(a.nama) employee_name
					,c.kd_jabatan
					,trim(c.jabatan) jabatan
                    ,trim(b.bidang) bidang
                    ,a.kd_jabatan
                FROM hrd_khs.tpribadi a
                    INNER JOIN hrd_khs.tseksi b on a.kodesie = b.kodesie
                    INNER JOIN hrd_khs.torganisasi c on a.kd_jabatan = c.kd_jabatan
					INNER JOIN \"Presensi\".tprs_shift tpr on tpr.noind = a.noind
                WHERE a.keluar ='0'
				AND tpr.tanggal::date = '$today' and tpr.waktu not in ('0')
                $kondisi
                ORDER BY a.kd_jabatan";
        // echo $sql;exit();
        return $this->personalia->query($sql)->result_array();
    }

    public function pekerja($noind, $params)
    {
        if ($params == true) {
            $noind = "in ('$noind')";
        } elseif ($params == false) {
            $noind = "= '$noind'";
        }
        $sql = "SELECT noind, trim(nama) as nama FROM hrd_khs.tpribadi WHERE keluar = '0' and noind $noind";
        return $this->personalia->query($sql)->result_array();
    }

    function getEmail($noindatasan)
    {
        $query = "SELECT internal_mail FROM er.er_employee_all WHERE employee_code = '$noindatasan'";

        return $this->db->query($query)->result_array();
    }

    public function GetIzinPribadi($noind, $jenis)
    {
        if ($jenis) {
            $where = "and ip.jenis_ijin = '$jenis'";
        } else {
            $where = '';
        }
        $today = date('Y-m-d');
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
            where created_date::date = '$today' and tgl_appr_atasan is null and ip.atasan = '$noind'
                $where
            order by
                ip.appr_atasan desc, ip.id desc";
        // echo $sql;exit();
        return $this->personalia->query($sql3)->result_array();
    }
}
