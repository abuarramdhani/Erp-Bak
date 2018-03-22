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
        $sql = $sqlserver->query("SELECT spdl_id,noind,kodesie,
                                    ( 
                                     SELECT 
                                        CONCAT(
                                                concat(to_char(min(td2.tanggal)::date,'YYYY-MM-DD'),' ',
                                                (SELECT td3.waktu from \"Presensi\".tpresensi_dl td3 where td3.spdl_id=td1.spdl_id and td3.tanggal=min(td2.tanggal))),' - ',
                                                case
                                                    when
                                                        count(td1.tanggal)=1
                                                    then
                                                        'belum pulang'
                                                    else
                                                        (concat(to_char(max(td2.tanggal)::date,'YYYY-MM-DD'),' ',
                                                        (SELECT td4.waktu FROM \"Presensi\".tpresensi_dl td4 where td4.spdl_id=td1.spdl_id and td4.tanggal=max(td2.tanggal))))
                                                end
                                            ) FROM \"Presensi\".tpresensi_dl td2 where td2.spdl_id=td1.spdl_id
                                     ) as tanggal,
                                    (
                                        (
                                            select
                                            count(tsp.tanggal)
                                            -
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
                                                (SELECT td4.waktu FROM \"Presensi\".tpresensi_dl td4 where td4.spdl_id=td1.spdl_id and td4.tanggal=min(td1.tanggal)) as berangkat 
                                            )
                                            -
                                            (
                                                select
                                                    (
                                                        case
                                                            when
                                                                (
                                                case
                                                    when
                                                        count(td1.tanggal)=1
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
                                                (SELECT td4.waktu FROM \"Presensi\".tpresensi_dl td4 where td4.spdl_id=td1.spdl_id and td4.tanggal=(
                                                case
                                                    when
                                                        count(td1.tanggal)=1
                                                    then
                                                        current_date
                                                    else
                                                       max(td1.tanggal)
                                                end
                                            )) as berangkat 
                                            )
                                            from 
                                            \"Presensi\".tshiftpekerja tsp where tsp.noind=td1.noind and tsp.tanggal between min(td1.tanggal) and 
                                                (
                                                    case
                                                        when
                                                            count(td1.tanggal)=1
                                                        then
                                                            current_date
                                                        else
                                                            max(td1.tanggal)
                                                    end
                                                )
                                        )
                                    ) as jml_dl
                                    FROM 
                                    (SELECT * FROM \"Presensi\".tpresensi_dl $where) as td1
                                    group by spdl_id,noind,kodesie");
        return $sql->result_array();
    }

}
