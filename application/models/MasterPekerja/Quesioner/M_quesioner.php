<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_quesioner extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
    }

    public function getAllData()
    {
        $mysql_pendataan = $this->load->database('mysql_pendataan',true);
        $query = $mysql_pendataan->query("SELECT
        tbl1.id
        ,gcr.creation_by
        ,tp.noind
        ,tp.nama
        ,qts.seksi
        ,(tbl1.question_1
        +tbl1.question_2
        +tbl1.question_3
        +tbl1.question_4
        +tbl1.question_5
        +tbl1.question_6
        +tbl1.question_7
        +tbl1.question_8
        +tbl1.question_9
        +tbl1.question_10) r_luar_rumah
        ,(tbl1.question_11
        +tbl1.question_12
        +tbl1.question_13
        +tbl1.question_14
        +tbl1.question_15
        +tbl1.question_16) r_dalam_rumah
        ,(tbl1.question_17
        +tbl1.question_18
        +tbl1.question_19
        +tbl1.question_20
        +tbl1.question_21) r_imun
        ,(tbl1.question_22
        +tbl1.question_23
        +tbl1.question_24
        +tbl1.question_25
        +tbl1.question_26
        +tbl1.question_27
        +tbl1.question_28
        +tbl1.question_29
        +tbl1.question_30) r_kesehatan
        ,(tbl1.question_1
        +tbl1.question_2
        +tbl1.question_3
        +tbl1.question_4
        +tbl1.question_5
        +tbl1.question_6
        +tbl1.question_7
        +tbl1.question_8
        +tbl1.question_9
        +tbl1.question_10
        +tbl1.question_11
        +tbl1.question_12
        +tbl1.question_13
        +tbl1.question_14
        +tbl1.question_15
        +tbl1.question_16
        +tbl1.question_17
        +tbl1.question_18
        +tbl1.question_19
        +tbl1.question_20
        +tbl1.question_21
        +tbl1.question_22
        +tbl1.question_23
        +tbl1.question_24
        +tbl1.question_25
        +tbl1.question_26
        +tbl1.question_27
        +tbl1.question_28
        +tbl1.question_29
        +tbl1.question_30) total
        ,tbl1.question_1
        ,tbl1.question_2
        ,tbl1.question_3
        ,tbl1.question_4
        ,tbl1.question_5
        ,tbl1.question_6
        ,tbl1.question_7
        ,tbl1.question_8
        ,tbl1.question_9
        ,tbl1.question_10
        ,tbl1.question_11
        ,tbl1.question_12
        ,tbl1.question_13
        ,tbl1.question_14
        ,tbl1.question_15
        ,tbl1.question_16
        ,tbl1.question_17
        ,tbl1.question_18
        ,tbl1.question_19
        ,tbl1.question_20
        ,tbl1.question_21
        ,tbl1.question_22
        ,tbl1.question_23
        ,tbl1.question_24
        ,tbl1.question_25
        ,tbl1.question_26
        ,tbl1.question_27
        ,tbl1.question_28
        ,tbl1.question_29
        ,tbl1.question_30
        ,tbl1.last_update
        FROM
        (SELECT
        gcr.id
        ,gcr.creation_by
        ,(SELECT CASE WHEN question_1 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1) question_1
        ,(SELECT CASE WHEN question_2 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_2
        ,(SELECT CASE WHEN question_3 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_3
        ,(SELECT CASE WHEN question_4 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_4
        ,(SELECT CASE WHEN question_5 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_5
        ,(SELECT CASE WHEN question_6 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_6
        ,(SELECT CASE WHEN question_7 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_7
        ,(SELECT CASE WHEN question_8 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_8
        ,(SELECT CASE WHEN question_9 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_9
        ,(SELECT CASE WHEN question_10 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_10
        ,(SELECT CASE WHEN question_11 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_11
        ,(SELECT CASE WHEN question_12 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_12
        ,(SELECT CASE WHEN question_13 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_13
        ,(SELECT CASE WHEN question_14 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_14
        ,(SELECT CASE WHEN question_15 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_15
        ,(SELECT CASE WHEN question_16 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_16
        ,(SELECT CASE WHEN question_17 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_17
        ,(SELECT CASE WHEN question_18 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_18
        ,(SELECT CASE WHEN question_19 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_19
        ,(SELECT CASE WHEN question_20 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_20
        ,(SELECT CASE WHEN question_21 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_21
        ,(SELECT CASE WHEN question_22 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id DESC LIMIT 1)  question_22
        ,(SELECT CASE WHEN question_23 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id DESC LIMIT 1)  question_23
        ,(SELECT CASE WHEN question_24 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id DESC LIMIT 1)  question_24
        ,(SELECT CASE WHEN question_25 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id DESC LIMIT 1)  question_25
        ,(SELECT CASE WHEN question_26 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id DESC LIMIT 1)  question_26
        ,(SELECT CASE WHEN question_27 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id DESC LIMIT 1)  question_27
        ,(SELECT CASE WHEN question_28 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id DESC LIMIT 1)  question_28
        ,(SELECT CASE WHEN question_29 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id DESC LIMIT 1)  question_29
        ,(SELECT CASE WHEN question_30 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id DESC LIMIT 1)  question_30
        ,(SELECT creation_date FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id DESC LIMIT 1)  last_update
        FROM
        pendataan.ga_covid19_risk gcr
        GROUP BY gcr.creation_by) tbl1
        inner JOIN pendataan.ga_covid19_risk gcr ON tbl1.id = gcr.id 
        inner JOIN pendataan.tpribadi tp ON gcr.creation_by = tp.noind
        inner JOIN quickc01_dinas_luar_online.t_seksi qts ON tp.kodesie = qts.kodesie
        order by tp.kodesie,tp.noind");

        return $query->result_array();
    }

    public function getAllDataRekapKondisiKesehatan()
    {
        $mysql_pendataan = $this->load->database('mysql_pendataan',true);
        $query = $mysql_pendataan->query("SELECT
        tbl2.dept
        ,tbl2.unit
        ,qtlk.lokasi_kerja
        ,tbl3.total
        ,count(tbl2.dept) sudah_isi
        ,(tbl3.total - count(tbl2.dept)) belum_isi
        ,sum(tbl2.bptd) bapil
        ,sum(tbl2.bptds) bapilsak
        ,sum(tbl2.rasa) matira
        ,IFNULL(tbl4.nonsk,0) nonsk
        ,IFNULL(tbl5.skbapil,0) skbapil
        ,IFNULL(tbl6.skbapilsak,0) skbapilsak
        FROM
        (SELECT
        qts.dept
        ,qts.unit
        -- ,qtlk.lokasi_kerja
        ,tp.kodesie
        ,tp.lokasi_kerja kode_lokasi
        ,CASE when (tbl1.question_22 + tbl1.question_23 + tbl1.question_24 + tbl1.question_25)>0 then 1 else 0 end bptd
        ,CASE when ((tbl1.question_22 + tbl1.question_23 + tbl1.question_24 + tbl1.question_25)>0 and tbl1.question_26 = 1) then 1 else 0 end bptds
        ,case when (tbl1.question_27 + tbl1.question_28)>0 then 1 else 0 end rasa
        FROM
        (SELECT
        gcr.id
        ,gcr.creation_by
        ,(SELECT CASE WHEN question_1 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1) question_1
        ,(SELECT CASE WHEN question_2 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_2
        ,(SELECT CASE WHEN question_3 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_3
        ,(SELECT CASE WHEN question_4 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_4
        ,(SELECT CASE WHEN question_5 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_5
        ,(SELECT CASE WHEN question_6 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_6
        ,(SELECT CASE WHEN question_7 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_7
        ,(SELECT CASE WHEN question_8 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_8
        ,(SELECT CASE WHEN question_9 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_9
        ,(SELECT CASE WHEN question_10 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_10
        ,(SELECT CASE WHEN question_11 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_11
        ,(SELECT CASE WHEN question_12 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_12
        ,(SELECT CASE WHEN question_13 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_13
        ,(SELECT CASE WHEN question_14 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_14
        ,(SELECT CASE WHEN question_15 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_15
        ,(SELECT CASE WHEN question_16 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_16
        ,(SELECT CASE WHEN question_17 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_17
        ,(SELECT CASE WHEN question_18 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_18
        ,(SELECT CASE WHEN question_19 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_19
        ,(SELECT CASE WHEN question_20 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_20
        ,(SELECT CASE WHEN question_21 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id LIMIT 1)  question_21
        ,(SELECT CASE WHEN question_22 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id DESC LIMIT 1)  question_22
        ,(SELECT CASE WHEN question_23 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id DESC LIMIT 1)  question_23
        ,(SELECT CASE WHEN question_24 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id DESC LIMIT 1)  question_24
        ,(SELECT CASE WHEN question_25 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id DESC LIMIT 1)  question_25
        ,(SELECT CASE WHEN question_26 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id DESC LIMIT 1)  question_26
        ,(SELECT CASE WHEN question_27 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id DESC LIMIT 1)  question_27
        ,(SELECT CASE WHEN question_28 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id DESC LIMIT 1)  question_28
        ,(SELECT CASE WHEN question_29 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id DESC LIMIT 1)  question_29
        ,(SELECT CASE WHEN question_30 = 'Y' THEN 1 ELSE 0 END FROM ga_covid19_risk xx WHERE xx.creation_by=gcr.creation_by ORDER BY id DESC LIMIT 1)  question_30
        FROM
        pendataan.ga_covid19_risk gcr
        GROUP BY gcr.creation_by) tbl1
        INNER JOIN pendataan.tpribadi tp on tbl1.creation_by = tp.noind
        INNER JOIN quickc01_dinas_luar_online.t_seksi qts on tp.kodesie = qts.kodesie
        -- INNER JOIN quickc01_dinas_luar_online.t_lokasi_kerja qtlk on tp.lokasi_kerja = qtlk.lokasi_id
        ) tbl2
        INNER JOIN
        (SELECT
        COUNT(tp2.noind) total
        ,qts2.dept
        ,qts2.unit
        ,tp2.lokasi_kerja
        FROM
        pendataan.tpribadi tp2
        INNER JOIN quickc01_dinas_luar_online.t_seksi qts2 on tp2.kodesie = qts2.kodesie
        WHERE tp2.keluar = '0'
        GROUP BY
        qts2.dept
        ,qts2.unit
        ,tp2.lokasi_kerja) tbl3 on tbl2.dept = tbl3.dept and tbl2.unit = tbl3.unit and tbl2.kode_lokasi = tbl3.lokasi_kerja
        LEFT JOIN
        (SELECT
        COUNT(pts.noind) nonsk
        ,qts.dept
        ,qts.unit
        ,ptp.lokasi_kerja
        FROM
        pendataan.tpendataan_sakit pts
        INNER JOIN pendataan.tpribadi ptp on pts.noind = ptp.noind
        INNER JOIN quickc01_dinas_luar_online.t_seksi qts on ptp.kodesie = qts.kodesie
        WHERE
        pts.sk is NULL or pts.sk = 0
        GROUP BY
        qts.dept
        ,qts.unit
        ,ptp.lokasi_kerja) tbl4 on tbl2.dept = tbl4.dept and tbl2.unit = tbl4.unit and tbl2.kode_lokasi = tbl4.lokasi_kerja
        LEFT JOIN
        (SELECT
        COUNT(pts.noind) skbapil
        ,qts.dept
        ,qts.unit
        ,ptp.lokasi_kerja
        FROM
        pendataan.tpendataan_sakit pts
        INNER JOIN pendataan.tpribadi ptp on pts.noind = ptp.noind
        INNER JOIN quickc01_dinas_luar_online.t_seksi qts on ptp.kodesie = qts.kodesie
        WHERE
        pts.sk = 1
        and (pts.batuk + pts.pilek + pts.demam) > 1
        GROUP BY
        qts.dept
        ,qts.unit
        ,ptp.lokasi_kerja) tbl5 on tbl2.dept = tbl5.dept and tbl2.unit = tbl5.unit and tbl2.kode_lokasi = tbl5.lokasi_kerja
        LEFT JOIN
        (SELECT
        COUNT(pts.noind) skbapilsak
        ,qts.dept
        ,qts.unit
        ,ptp.lokasi_kerja
        FROM
        pendataan.tpendataan_sakit pts
        INNER JOIN pendataan.tpribadi ptp on pts.noind = ptp.noind
        INNER JOIN quickc01_dinas_luar_online.t_seksi qts on ptp.kodesie = qts.kodesie
        WHERE
        pts.sk = 1
        and (pts.batuk + pts.pilek + pts.demam) > 1
        and pts.sesak = 1
        GROUP BY
        qts.dept
        ,qts.unit
        ,ptp.lokasi_kerja) tbl6 on tbl2.dept = tbl6.dept and tbl2.unit = tbl6.unit and tbl2.kode_lokasi = tbl6.lokasi_kerja
        INNER JOIN quickc01_dinas_luar_online.t_lokasi_kerja qtlk on tbl2.kode_lokasi = qtlk.lokasi_id
        GROUP BY
        tbl2.dept
        ,tbl2.unit
        ,qtlk.lokasi_kerja
        ,tbl3.total
        ,tbl4.nonsk
        ,tbl5.skbapil
        ,tbl6.skbapilsak");

        return $query->result_array();
    }

    public function getAllDataPekerjaBelumInput(){
        $this->pendataan = $this->load->database('dinas_luar',true);
        $sql = "
            select t1.noind, 
            t1.nama, 
            t2.seksi, 
            t2.unit, 
            t3.lokasi_kerja,
            case when trim(t1.nohp) = '' then 
                'kosong'
            when trim(t1.nohp) = '-' then 
                'kosong'
            else 
                trim(t1.nohp)
            end as nomor,
            case when trim(t1.jenkel) = 'L' then 
                'Bapak'
            when trim(t1.jenkel) = 'P' then 
                'Ibu'
            else 
                'Bapak / Ibu'
            end as panggil
            from pendataan.tpribadi t1 
            left join quickc01_dinas_luar_online.t_seksi t2 
            on t1.kodesie = t2.kodesie
            left join quickc01_dinas_luar_online.t_lokasi_kerja t3 
            on t1.lokasi_kerja = t3.lokasi_id
            where keluar = '0'
            and left(noind,1) not in ('M','Z','L')
            and noind not in (
                select noind
                from pendataan.ga_covid19_risk t4 
                where t1.noind = t4.creation_by
                and question_1 != ''
            )
            order by t1.lokasi_kerja,left(t1.kodesie,7),t1.noind";
        return $this->pendataan->query($sql)->result_array();
    }

    public function getAllDataPekerjaTidakHadirBelumInput(){
        $this->personalia = $this->load->database('personalia',true);
        $sql = "select t1.noind, 
                t1.nama, 
                t2.seksi, 
                t2.unit, 
                t3.lokasi_kerja,
                case when trim(t1.nohp) = '' then 
                    'kosong'
                when trim(t1.nohp) = '-' then 
                    'kosong'
                else 
                    trim(t1.nohp)
                end as nomor,
                t4.tanggal::date as tanggal,
                trim(t5.shift) as shift,
                t4.jam_msk,
                t4.jam_akhmsk,
                case when trim(t1.jenkel) = 'L' then 
                    'Bapak'
                when trim(t1.jenkel) = 'P' then 
                    'Ibu'
                else 
                    'Bapak / Ibu'
                end as panggil
                from hrd_khs.tpribadi t1 
                inner join hrd_khs.tseksi t2 
                on t1.kodesie = t2.kodesie
                inner join hrd_khs.tlokasi_kerja t3 
                on t1.lokasi_kerja = t3.id_
                inner join \"Presensi\".tshiftpekerja t4
                on t1.noind = t4.noind
                and t4.tanggal = current_date
                left join \"Presensi\".tshift t5 
                on t4.kd_shift = t5.kd_shift
                where t1.keluar = '0'
                and left(t1.noind,1) not in ('M','Z','L')
                and t1.noind not in (
                    select noind
                    from \"Presensi\".tprs_shift t6 
                    where t6.noind = t1.noind
                    and trim(t6.waktu) not in ('__:__:__','','0')
                    and t6.tanggal = t4.tanggal
                    and concat(t6.tanggal::date,' ',t6.waktu)::timestamp between concat(t4.tanggal::date,' ',t4.jam_akhmsk)::timestamp - interval '3 hours' and concat(t4.tanggal::date,' ',t4.jam_akhmsk)::timestamp
                )
                and concat(t4.tanggal::date,' ',t4.jam_akhmsk)::timestamp < current_timestamp
                order by t4.kd_shift,t1.lokasi_kerja,left(t1.kodesie,7),t1.noind";
        return $this->personalia->query($sql)->result_array();
    }
}