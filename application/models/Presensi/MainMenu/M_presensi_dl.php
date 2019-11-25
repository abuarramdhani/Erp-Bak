<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_presensi_dl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getPekerja($val)
    {
        $sqlserver = $this->load->database('personalia',true);
        $sql = $sqlserver->query("SELECT noind,nama FROM hrd_khs.tpribadi where noind like '%$val%' or nama like '%$val%' and keluar=false");
        return $sql->result_array();
    }

    public function getkendaraan($val)
    {
        $sql = $this->db->query("select a.nomor_polisi,b.merk_kendaraan,c.warna_kendaraan,d.jenis_kendaraan from ga.ga_fleet_kendaraan a 
                                    inner join ga.ga_fleet_merk_kendaraan b on a.merk_kendaraan_id=b.merk_kendaraan_id
                                    left join ga.ga_fleet_warna_kendaraan c on a.warna_kendaraan_id=c.warna_kendaraan_id
                                    left join ga.ga_fleet_jenis_kendaraan d on a.jenis_kendaraan_id=d.jenis_kendaraan_id
                                    where a.nomor_polisi like '%$val%' and a.end_date = '9999-12-12 00:00:00' ");
        return $sql->result_array();
    }

    public function deleteKendaraan($spdl,$id,$stat){
        $sql = $this->db->query("delete from ga.ga_fleet_histori_pemakaian where nomor_polisi='$id' and spdl_id='$spdl' and status_='$stat'");
        return;
    }

    public function insertKilometerKendaraan($nopol,$tgl,$wkt,$kat,$noind,$kodesie,$stat,$spdl,$transfer,$user_id,$kilometer){
        $sql = $this->db->query("insert into ga.ga_fleet_histori_pemakaian (nomor_polisi,tanggal,waktu,kategori_kend,noind,status_,spdl_id,transfer,user_id,kilometer) values ('$nopol','$tgl','$wkt','$kat','$noind','$stat','$spdl','$transfer','$user_id','$kilometer')");
        return;
    }

    public function getSeksi($val)
    {
        $sqlserver = $this->load->database('personalia',true);
        $sql = $sqlserver->query("SELECT kodesie,seksi FROM hrd_khs.tseksi where kodesie like '%$val%' or seksi like '%$val%' group by left(kodesie,7),seksi");
        return $sql->result_array();
    }

    public function getSeksi_byID($noind){
        $sqlserver = $this->load->database('personalia',true);
        $sql = $sqlserver->query("SELECT b.kodesie FROM hrd_khs.tpribadi a inner join hrd_khs.tseksi b on a.kodesie=b.kodesie where a.noind='$noind'");
        return $sql->row();
    }

    public function pencarian_pekerja_dl($where){
        $sqlserver = $this->load->database('personalia',true);
        $sql = $sqlserver->query("SELECT distinct * FROM \"Presensi\".tpresensi_dl $where");
        return $sql->result_array();
    }

    public function convert_pekerja_dl($where,$tanggal){
        if($tanggal>date('Y-m-d')){
            $tanggal=date('Y-m-d');
        }
        $sqlserver = $this->load->database('personalia',true);
        $sql = $sqlserver->query("SELECT td.spdl_id,td.noind,'' as kodesie,
    (case
        when
            count(td.spdl_id)=2
        then
            concat(
                concat(
                        to_char(min(td.tanggal)::date,'YYYY-MM-DD'),
                        ' ',
                        case
                            when
                                min(td.tanggal)=max(td.tanggal)
                            then
                                min(td.waktu)
                            else
                                (
                                    select distinct waktu from \"Presensi\".tpresensi_dl where spdl_id=td.spdl_id and tanggal=min(td.tanggal)
                                )
                        end
                    ),
                ' || ',
                concat(
                        to_char(max(td.tanggal)::date,'YYYY-MM-DD'),
                        ' ',
                        case
                            when
                                min(td.tanggal)=max(td.tanggal)
                            then
                                max(td.waktu)
                            else
                                (
                                    select distinct waktu from \"Presensi\".tpresensi_dl where spdl_id=td.spdl_id and tanggal=max(td.tanggal)
                                )
                        end
                    )
                )
        else
            concat(
                concat(
                    to_char(max(td.tanggal)::date,'YYYY-MM-DD'),
                    ' ',
                    max(td.waktu)
                ),
                ' || ',
                'belum pulang'
            )
    end) tanggal,
    (case
        when
            count(td.spdl_id)=2
        then
            concat(
                concat(
                        to_char(min(td.tgl_realisasi)::date,'YYYY-MM-DD'),
                        ' ',
                        case
                            when
                                min(td.tgl_realisasi)=max(td.tgl_realisasi)
                            then
                                min(td.wkt_realisasi)
                            else
                                (
                                    select distinct wkt_realisasi from \"Presensi\".tpresensi_dl where spdl_id=td.spdl_id and tgl_realisasi=min(td.tgl_realisasi)
                                )
                        end
                    ),
                ' || ',
                concat(
                        to_char(max(td.tgl_realisasi)::date,'YYYY-MM-DD'),
                        ' ',
                        case
                            when
                                min(td.tgl_realisasi)=max(td.tgl_realisasi)
                            then
                                max(td.wkt_realisasi)
                            else
                                (
                                    select distinct wkt_realisasi from \"Presensi\".tpresensi_dl where spdl_id=td.spdl_id and tgl_realisasi=max(td.tgl_realisasi)
                                )
                        end
                    )
                )
        else
            concat(
                concat(
                    to_char(max(td.tgl_realisasi)::date,'YYYY-MM-DD'),
                    ' ',
                    max(td.wkt_realisasi)
                ),
                ' || ',
                'belum pulang'
            )
    end) tanggal_realisasi,
    (
        select 
            (
                count(tsp.tanggal)
                -
                (case
                    when
                        min(td.tanggal)=max(td.tanggal)
                    then
                        case
                            when
                                min(td.waktu)<max(tsp.jam_plg)
                            then
                                case
                                    when
                                        max(td.waktu)<max(tsp.jam_plg)
                                    then
                                        0
                                    else
                                        0
                                end
                            else
                                1
                        end
                    else
                        (
                            select
                                (
                                    case
                                        when
                                            berangkat.waktu<max(tsp.jam_plg)
                                        then
                                            0
                                        else
                                            1
                                    end
                                ) from
                            (SELECT distinct td4.waktu FROM \"Presensi\".tpresensi_dl td4 where td4.spdl_id=td.spdl_id and td4.tanggal=min(td.tanggal)) as berangkat 
                        )
                end)
                -
                (
                    select
                        (
                            case
                                when
                                    (
                    case
                        when
                            count(td.tanggal)=1
                        then
                            max(tsp.jam_plg)
                        else
                           max(berangkat.waktu)
                    end
                )<max(tsp.jam_akhmsk)
                                then
                                    1
                                else
                                    0
                            end
                        ) from
                    (SELECT distinct td4.waktu FROM \"Presensi\".tpresensi_dl td4 where td4.spdl_id=td.spdl_id and td4.tanggal=(
                    case
                        when
                            count(td.tanggal)=1
                        then
                            current_date
                        else
                           max(td.tanggal)
                    end
                )) as berangkat 
            )
        )
        from \"Presensi\".tshiftpekerja tsp 
        where tsp.noind=td.noind and tsp.tanggal 
            between min(td.tanggal) and 
            (
                case
                    when
                        count(td.tanggal)=1
                    then
                        current_date
                    else
                        max(td.tanggal)
                end
            )
    ) as jml_dl,
    (
        select
        coalesce(sum(tdt.point),0)
        from \"Presensi\".tdatatim tdt
        where tdt.noind=td.noind and tdt.tanggal 
            between min(td.tanggal) and 
            (
                case
                    when
                        count(td.tanggal)=1
                    then
                        current_date
                    else
                        max(td.tanggal)
                end
            )
    ) as point_
FROM 
(SELECT distinct * FROM \"Presensi\".tpresensi_dl $where) as td
group by td.spdl_id,td.noind");
        return $sql->result_array();
    }

    public function monitoring_pekerja_dl($where,$condition)
    {
        $sqlserver = $this->load->database('personalia', true);
        $sql = $sqlserver->query("select    noind,
                                            nama,
                                            akhkontrak as akhir_kontrak,
                                            (select seksi 
                                            from hrd_khs.tseksi
                                            where hrd_khs.tseksi.kodesie=hrd_khs.tpribadi.kodesie) as seksi
                                    from    hrd_khs.tpribadi $where $condition");
        return $sql->result_array();
    }

    public function editSDPL($spdl){
        $sqlserver = $this->load->database('personalia',true);
        $sql = $sqlserver->query("select distinct * from \"Presensi\".tpresensi_dl where spdl_id='$spdl' order by stat asc");
        return $sql->result_array();
    }

    public function dataPekerja($id){
        $sqlserver = $this->load->database('personalia', true);
        $sql = $sqlserver->query("select * from hrd_khs.tpribadi where noind='$id'");
        return $sql->row();
    }

    public function updateRealisasi($spdl,$tanggal,$waktu,$stat){
        $sqlserver = $this->load->database('personalia', true);
        $sql = $sqlserver->query("update \"Presensi\".tpresensi_dl set tgl_realisasi='$tanggal',wkt_realisasi='$waktu' where spdl_id='$spdl' and stat='$stat'");
    }

    public function deletePresensi($spdl,$stat){
        $sqlserver = $this->load->database('personalia', true);
        $sql = $sqlserver->query("delete from \"Presensi\".tpresensi_dl where spdl_id='$spdl' $stat");
    }

    public function insertPresensi($date_now,$id,$kodesie,$time_now,$userid,$noind_baru,$trans,$spdl,$stat,$tglPulang,$timePulang){
        $sqlserver = $this->load->database('personalia', true);
        $sql = $sqlserver->query("insert into \"Presensi\".tpresensi_dl values ('$date_now','$id','$kodesie','$time_now','$userid','$noind_baru','$trans','$spdl','$stat','$tglPulang','$timePulang','')");
    }

    public function ambilPekerjaDL($where){
        $sqlserver = $this->load->database('dinas_luar', true);
        $sql = $sqlserver->query("select tab.spdl_id as spdl_id,
                                            tp.noind as noind,
                                            tp.nama,
                                            ts.seksi
                                    from (select spdl_id,min(aktual_dari) as aktual from t_surat_perintah_dl_realisasi GROUP by spdl_id) as tab
                                    join t_surat_perintah_dl as tspdl
                                        on tab.spdl_id=tspdl.spdl_id
                                    join t_pekerja as tp 
                                        on tp.noind=tspdl.noind
                                    join t_seksi as ts
                                        on tp.kodesie=ts.kodesie
                                    ".$where."");
        return $sql->result_array();
    }

    public function cekPresensiDL($where){
        $sqlserver = $this->load->database('personalia', true);
        $sql = $sqlserver->query("select distinct * from \"Presensi\".tpresensi_dl ".$where." ");
        return $sql->result_array();
    }

}
