<?php

class M_blankoevaluasi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->personalia = $this->load->database('personalia', true);
        // $this->load->database();
    }

    public function getWorkers($keyword, $withCode = [], $filterSie = null)
    {
        // $kodesie = substr($this->session->kodesie,0,7);
        function parseToString($item)
        {
            return "'$item'";
        }

        $stringWithJabatan = "";
        if ($withCode) {
            $withCode = array_map('parseToString', $withCode);
            $withCode = implode(', ', $withCode);
            $stringWithJabatan = "AND substring(tp.noind, 1, 1) in ($withCode)";
        }

        $stringFilterSie = '';
        $userLogged = $this->session->user;
        if ($filterSie) {
            $refJabatan = $this->getRefJabatan($userLogged);
            function trimSie($arrSie)
            {
                return " tp.kodesie like '" . rtrim($arrSie, '0') . "%' OR";
            }

            $trimmedSie = array_map('trimSie', $refJabatan);
            $stringFilterSie = 'AND (' . rtrim(implode('', $trimmedSie), ' OR') . ')';
        }

        $queryNoind  = "SELECT trim(tp.nama) nama,
                         tp.noind,
                         ts.seksi 
                        FROM hrd_khs.tpribadi tp 
                            inner join hrd_khs.tseksi ts on tp.kodesie = ts.kodesie 
                        WHERE (tp.noind like '%$keyword%' or tp.nama like '%$keyword%') AND tp.keluar='0' $stringWithJabatan $stringFilterSie
                        ORDER BY tp.nama
                        LIMIT 5";
        $result = $this->personalia->query($queryNoind)->result_array();

        return $result;
    }

    public function getStaffWorker($filterSie = null)
    {
        $stringFilterSie = '';
        $userLogged = $this->session->user;
        if ($filterSie) {
            $refJabatan = $this->getRefJabatan($userLogged);
            function trimSie($arrSie)
            {
                return " tp.kodesie like '" . rtrim($arrSie, '0') . "%' OR";
            }

            $trimmedSie = array_map('trimSie', $refJabatan);
            $stringFilterSie = 'AND (' . rtrim(implode('', $trimmedSie), ' OR') . ')';
        }

        $queryNoind  =
            "SELECT 
                trim(tp.nama) nama, 
                tp.noind, 
                ts.seksi 
            FROM 
                hrd_khs.tpribadi tp 
                inner join hrd_khs.tseksi ts on tp.kodesie = ts.kodesie 
            WHERE 
                tp.keluar='0' 
                AND substring(tp.noind, 1, 1) in ('G', 'J') 
                $stringFilterSie 
            ORDER BY tp.nama LIMIT 5";

        $result = $this->personalia->query($queryNoind)->result_array();
        return $result;
    }

    public function getWorkerInformation($noind)
    {
        $query = "SELECT 
                tp.noind,
                tp.kodesie,
                tp.kd_jabatan,
                tp.jabatan,
                (
                    CASE 
                        WHEN substring(tp.noind, 1, 1) in ('K', 'P') then 'os'
                        ELSE 'nonstaff'
                    END
                ) jenis_kode,
                trim(tp.nama) nama, 
                concat(coalesce(nullif(ts.seksi, '-'), nullif(ts.unit, '-'), nullif(ts.bidang, '-'), nullif(ts.dept, '-')), ' / ', ts.dept) as seksi,
                ts.dept as departemen,
                tpkj.pekerjaan,
                (select nama_status from hrd_khs.tb_status_jabatan where noind = tp.noind limit 1) status_jabatan,
                (SELECT to_char((tanggal_akhir::date + INTERVAL '1 DAY')::date, 'dd-mm-yyyy') from \"Surat\".tevaluasi_nonstaff where noind = tp.noind and deleted = '0' order by tanggal_akhir desc limit 1) periode_awal,
                null as periode_akhir,
                null as presensi_ok,
                (
                    CASE 
                        WHEN tp.diangkat >= tp.masukkerja AND tp.diangkat < now() then
                            CASE
                                when date_part('year',age(CURRENT_DATE, tp.diangkat)) > 0 then concat(date_part('year',age(CURRENT_DATE, tp.diangkat)), ' Tahun ', date_part('month',age(CURRENT_DATE, tp.diangkat)), ' Bulan ', date_part('day',age(CURRENT_DATE, tp.diangkat)), ' Hari')
                                when date_part('month',age(CURRENT_DATE, tp.diangkat)) > 0 then concat(date_part('month',age(CURRENT_DATE, tp.diangkat)), ' Bulan ', date_part('day',age(CURRENT_DATE, tp.diangkat)), ' Hari')
                                else concat(date_part('day',age(CURRENT_DATE, tp.diangkat)), ' Hari')
                            END
                        ELSE 
                            CASE
                                when date_part('year',age(CURRENT_DATE, tp.masukkerja)) > 0 then concat(date_part('year',age(CURRENT_DATE, tp.masukkerja)), ' Tahun ', date_part('month',age(CURRENT_DATE, tp.masukkerja)), ' Bulan ', date_part('day',age(CURRENT_DATE, tp.masukkerja)), ' Hari')
                                when date_part('month',age(CURRENT_DATE, tp.masukkerja)) > 0 then concat(date_part('month',age(CURRENT_DATE, tp.masukkerja)), ' Bulan ', date_part('day',age(CURRENT_DATE, tp.masukkerja)), ' Hari')
                                else concat(date_part('day',age(CURRENT_DATE, tp.masukkerja)), ' Hari')
                            END
                            
                    END
                ) as masa_kerja,
                to_char(tp.akhkontrak::date, 'DD-MM-YYYY') akhir_kontrak
            FROM 
                hrd_khs.tpribadi tp 
                inner join hrd_khs.tseksi ts on ts.kodesie = tp.kodesie
                left join hrd_khs.tpekerjaan tpkj on tp.kd_pkj = tpkj.kdpekerjaan
            WHERE 
                tp.noind = '$noind' and 
                tp.keluar = '0'
        ";

        $result = $this->personalia->query($query)->row();
        if (!$result) return [];

        $allSupervisor = $this->getAllAtasan($result->kodesie);
        $result->atasan = $allSupervisor;

        return $result;
    }


    private function getAllAtasan($kodesie = null)
    {
        if (!$kodesie) return [];

        $supervisor = "SELECT distinct tr.noind, trim(tp.nama) as nama, (case when tp.kd_jabatan = '13' then 'supervisor' else 'kasie' end) as jabatan from hrd_khs.trefjabatan tr inner join hrd_khs.tpribadi tp on tp.noind = tr.noind WHERE substring(tr.kodesie, 1 ,7) = substring('$kodesie', 1, 7) and tp.kd_jabatan in ('13', '11', '12') and tp.keluar = '0';";
        $kasie = "SELECT distinct tr.noind, trim(tp.nama) as nama from hrd_khs.trefjabatan tr inner join hrd_khs.tpribadi tp on tp.noind = tr.noind WHERE substring(tr.kodesie, 1 ,7) = substring('$kodesie', 1, 7) and tp.kd_jabatan in ('11', '12') and tp.keluar = '0';";
        //  == personalia(4) 
        if (substr($kodesie, 0, 1) == 4) {
            $unit = "SELECT distinct tr.noind, trim(tp.nama) as nama from hrd_khs.trefjabatan tr inner join hrd_khs.tpribadi tp on tp.noind = tr.noind WHERE substring(tr.kodesie, 1 ,5) = substring('$kodesie', 1, 5) and tp.kd_jabatan in ('08', '09', '10') and tp.keluar = '0'";
        } else {
            $unit = "SELECT distinct tr.noind, trim(tp.nama) as nama from hrd_khs.trefjabatan tr inner join hrd_khs.tpribadi tp on tp.noind = tr.noind WHERE substring(tr.kodesie, 1 ,5) = substring('$kodesie', 1, 5) and tp.kd_jabatan in ('08', '09') and tp.keluar = '0'";
        }

        $bidang = "SELECT distinct tr.noind, trim(tp.nama) as nama from hrd_khs.trefjabatan tr inner join hrd_khs.tpribadi tp on tp.noind = tr.noind WHERE substring(tr.kodesie, 1 ,3) = substring('$kodesie', 1, 3) and tp.kd_jabatan in ('05', '06', '07') and tp.keluar = '0'";
        $dept = "SELECT distinct tr.noind, trim(tp.nama) as nama from hrd_khs.trefjabatan tr inner join hrd_khs.tpribadi tp on tp.noind = tr.noind WHERE substring(tr.kodesie, 1 ,1) = substring('$kodesie', 1, 1) and tp.kd_jabatan in ('02', '03', '04') and tp.keluar = '0';";

        $supervisor = $this->personalia->query($supervisor)->result_array();
        $kasie = $this->personalia->query($kasie)->result_array();
        $unit = $this->personalia->query($unit)->result_array();
        $bidang = $this->personalia->query($bidang)->result_array();
        $dept = $this->personalia->query($dept)->result_array();

        $result = array(
            'supervisor' => $supervisor,
            'kasie' => $kasie,
            'unit' => $unit ?: $bidang,
            'bidang' => $bidang,
            'dept' => $dept
        );

        return $result;
    }

    private function getRefJabatan($noind = [])
    {
        if (!$noind) return [];
        $query = "SELECT kodesie FROM hrd_khs.trefjabatan where noind = '$noind'";
        $result = $this->personalia->query($query)->result_array();

        function flattenArray($item)
        {
            return $item['kodesie'];
        }

        $result = array_map('flattenArray', $result);

        return $result;
    }

    public function insertBlanko($data)
    {
        // schema Surat
        if (!$data) throw "error";

        $this->personalia->insert('Surat.tevaluasi_nonstaff', $data);
    }

    /* 
        blanko untuk nonstaff & outsourcing
    */
    public function getBlanko($id = null)
    {
        $filterKodesie = "";
        $userLogged = $this->session->user;

        if (!$id) {
            $refJabatan = $this->getRefJabatan($userLogged);
            function trimSie($arrSie)
            {
                return " kodesie like '" . rtrim($arrSie, '0') . "%' OR";
            }

            $trimmedSie = array_map('trimSie', $refJabatan);
            $filterKodesie = rtrim(implode('', $trimmedSie), ' OR');

            $query = "
                SELECT ten.*, tp.kodesie 
                FROM \"Surat\".tevaluasi_nonstaff ten inner join hrd_khs.tpribadi tp on ten.noind = tp.noind 
                WHERE $filterKodesie and ten.deleted = '0'
                ORDER BY ten.created_time desc";
            return $this->personalia->query($query);
        }

        $query = "
            SELECT ten.*, tp.kodesie , tp.kd_jabatan
            FROM \"Surat\".tevaluasi_nonstaff ten inner join hrd_khs.tpribadi tp on ten.noind = tp.noind 
            WHERE ten.id = '$id'
            ORDER BY ten.created_time desc";

        return $this->personalia->query($query);
    }

    /*
        Insert blanko staff
    */
    public function insertStaffBlanko($data)
    {
        if (!$data) throw 'error';
        $this->personalia->insert('Surat.tevaluasi_staff', $data);
    }

    /*
        Blanko staff
    */
    public function getStaffBlanko($id = null)
    {
        $id = intval($id);
        $filterKodesie = "";
        $userLogged = $this->session->user;

        if (!$id) {
            $refJabatan = $this->getRefJabatan($userLogged);
            function trimSie($arrSie)
            {
                return " tp.kodesie like '" . rtrim($arrSie, '0') . "%' OR";
            }

            $trimmedSie = array_map('trimSie', $refJabatan);
            $filterKodesie = rtrim(implode('', $trimmedSie), ' OR');

            $query = "
                SELECT tes.*, tp.kodesie 
                FROM \"Surat\".tevaluasi_staff tes inner join hrd_khs.tpribadi tp on tes.noind = tp.noind 
                WHERE $filterKodesie and tes.deleted = '0'
                ORDER BY tes.created_time desc";
            return $this->personalia->query($query);
        }

        $query = "
            SELECT tes.*, tp.kodesie , tp.kd_jabatan
            FROM \"Surat\".tevaluasi_staff tes inner join hrd_khs.tpribadi tp on tes.noind = tp.noind 
            WHERE tes.id = '$id'
            ORDER BY tes.created_time desc";

        return $this->personalia->query($query);
    }

    public function getTIMS($noind, $awal, $akhir)
    {
        $awal = date('Y-m-d', strtotime($awal));
        $akhir = date('Y-m-d', strtotime($akhir));

        $q_terlambat = "SELECT tanggal::date FROM \"Presensi\".tdatatim where kd_ket = 'TT' and point <> '0' and noind = '$noind' and tanggal between '$awal' and '$akhir '";
        $q_izin = "SELECT tanggal::date FROM \"Presensi\".tdatatim where kd_ket = 'TIK' and point <> '0' and noind = '$noind' and tanggal between '$awal' and '$akhir '";
        $q_mangkir = "SELECT tanggal::date FROM \"Presensi\".tdatatim where kd_ket = 'TM' and point <> '0' and noind = '$noind' and tanggal between '$awal' and '$akhir '";
        $q_sakit = "SELECT tanggal::date FROM \"Presensi\".tdatapresensi where kd_ket in ('PSP', 'PSK') and noind = '$noind' and tanggal between '$awal' and '$akhir '";
        $q_pamit = "SELECT tanggal::date FROM \"Presensi\".tdatapresensi where kd_ket in ('PIP') and noind = '$noind' and tanggal between '$awal' and '$akhir '";
        // $q_freq_all = "SELECT count(*) FROM \"Presensi\".tdatatim where kd_ket in ('PSP', 'PSK', 'TM', 'TT', 'TIK') and point <> '0' and noind = '$noind' and tanggal between '$awal' and '$akhir '";

        $terlambat = $this->personalia->query($q_terlambat)->result_array();
        $izin = $this->personalia->query($q_izin)->result_array();
        $mangkir = $this->personalia->query($q_mangkir)->result_array();
        $sakit = $this->personalia->query($q_sakit)->result_array();
        $pamit = $this->personalia->query($q_pamit)->result_array();
        // $freq_all = $this->personalia->query($q_freq_all);

        $dataTIMS =  array(
            'periode' => "$awal - $akhir",
            'data' => [
                'T' => $terlambat,
                'I' => $izin,
                'M' => $mangkir,
                'S' => $sakit,
                'P' => $pamit
            ],
            'total' => count($terlambat) + count($izin) + count($mangkir) + count($sakit) + count($pamit),
            'total_tim' => count($terlambat) + count($izin) + count($mangkir),
            'total_tims' => count($terlambat) + count($izin) + count($mangkir) + count($sakit)
        );

        $plusOneYear = date('Y-m-d', strtotime('+1 year ' . $awal));
        $plusThreeMonth = date('Y-m-d', strtotime('+3 month ' . $awal));
        $params = [$plusOneYear, $plusThreeMonth];

        $dataTIMS['data'] = array_map(function ($item) use ($params) {
            $next1Year = $params[0];
            $next3Month = $params[1];

            $threeMonth = [];
            $year1 = [];
            $year2 = [];

            foreach ($item as $e) {
                if ($e['tanggal'] <= $next3Month) {
                    array_push($threeMonth, $e['tanggal']);
                }

                if ($e['tanggal'] < $next1Year) {
                    array_push($year1, $e['tanggal']);
                } else {
                    array_push($year2, $e['tanggal']);
                }
            }

            return array(
                'bulan3' => count($threeMonth),
                'tahun1' => count($year1),
                'tahun2' => count($year2),
                'jumlah' => count($item)
            );
        }, $dataTIMS['data']);

        return $dataTIMS;
    }

    public function calculationTIMS($noind, $awal, $akhir, $position)
    {
        $awal = date('Y-m-d', strtotime($awal));
        $akhir = date('Y-m-d', strtotime($akhir));

        $tims = $this->getTIMS($noind, $awal, $akhir);

        $ok = false;
        if ($position == 'staff') {
        } else if ($position == 'nonstaff') {
            if ($tims['total_tim'] <= 15 && $tims['total_tims'] <= 20) {
                $ok = true;
            }
        } else { // os
            if ($tims['total'] <= 5) {
                $ok = true;
            }
        }

        return $ok;
    }

    public function getSP($noind, $awal, $akhir)
    {
        $awal = date('Y-m-d', strtotime($awal));
        $akhir = date('Y-m-d', strtotime($akhir));

        $query = "SELECT sp_ke, berlaku, tanggal_awal_berlaku as awal, jenis
        from \"Surat\".v_surat_tsp_rekap
        where current_date between '$awal' and '$akhir'
        and noind = '$noind' and tanggal_cetak is not null
        order by berlaku desc";

        return $this->personalia->query($query)->result_array();
    }

    public function deleteStaffBlanko($id, $user)
    {
        $data = $this->personalia
            ->where('id', $id)
            ->update('"Surat".tevaluasi_staff', [
                'deleted' => true,
                'deleted_time' => date('Y-m-d H:i:s'),
                'deleted_by' => $user
            ]);
        return;
    }

    public function deleteNonStaffBlanko($id, $user)
    {
        $data = $this->personalia
            ->where('id', $id)
            ->update('"Surat".tevaluasi_nonstaff', [
                'deleted' => true,
                'deleted_time' => date('Y-m-d H:i:s'),
                'deleted_by' => $user
            ]);
        return;
    }
}
