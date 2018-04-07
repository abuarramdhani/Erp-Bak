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
        $sql = $sqlserver->query("SELECT noind,nama FROM hrd_khs.tpribadi where noind like '%$val%' or nama like '%$val%'");
    	return $sql->result_array();
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
        $sql = $sqlserver->query("SELECT * FROM \"Presensi\".tpresensi_dl $where");
        return $sql->result_array();
    }

    public function convert_pekerja_dl($where,$tanggal){
        if($tanggal>date('Y-m-d')){
            $tanggal=date('Y-m-d');
        }
        $sqlserver = $this->load->database('personalia',true);
        $sql = $sqlserver->query("SELECT td.spdl_id,td.noind,td.kodesie,
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
                                    select waktu from \"Presensi\".tpresensi_dl where spdl_id=td.spdl_id and tanggal=min(td.tanggal)
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
                                    select waktu from \"Presensi\".tpresensi_dl where spdl_id=td.spdl_id and tanggal=max(td.tanggal)
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
                                        1
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
                            (SELECT td4.waktu FROM \"Presensi\".tpresensi_dl td4 where td4.spdl_id=td.spdl_id and td4.tanggal=min(td.tanggal)) as berangkat 
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
                    (SELECT td4.waktu FROM \"Presensi\".tpresensi_dl td4 where td4.spdl_id=td.spdl_id and td4.tanggal=(
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
(SELECT * FROM \"Presensi\".tpresensi_dl $where) as td
group by td.spdl_id,td.noind,td.kodesie");
        return $sql->result_array();
    }

}
