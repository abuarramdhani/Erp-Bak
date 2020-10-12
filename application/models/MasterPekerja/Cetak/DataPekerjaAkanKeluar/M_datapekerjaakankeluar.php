<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_datapekerjaakankeluar extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->personalia = $this->load->database('personalia', true);
    }
    public function getPekerjaAkanKeluar()
    {
        return $this->personalia
            ->select("
        tp.noind, 
        trim(tp.nama) nama, 
        trim(ts.seksi) seksi, 
        trim(ts.unit) unit, 
        ts.bidang, 
        trim(ts.dept) dept, 
        to_char(tp.masukkerja, 'YYYY-MM-DD') as masukkerja, 
        to_char(tp.diangkat, 'YYYY-MM-DD') as diangkat, 
        to_char(tp.tglkeluar, 'YYYY-MM-DD') as tglkeluar, 
        to_char(tp.akhkontrak, 'YYYY-MM-DD') as akhkontrak, 
        tp.lmkontrak,
        (case  
            when left(tp.noind,1) in ('A','B') or (left(tp.noind,1) = 'C' and substring(tp.noind,3,1) = '1') then tp.sebabklr 
            when left(tp.noind,1) not in ('J','H','C') then concat('-')
            when (tp.tglkeluar::date-tp.diangkat::date)::int > ceil(coalesce(nullif(replace(trim(tp.lmkontrak), '-', ''),  '')::int, 0)*30.4167)::int then 'Sudah Perpanjangan Kontrak'
            when (tp.tglkeluar::date-tp.diangkat::date)::int <= ceil(coalesce(nullif(replace(trim(tp.lmkontrak), '-', ''),  '')::int, 0)*30.4167)::int then 'Belum Perpanjangan Kontrak'
            when k.ket = '1' then concat('Tidak Perpanjangan')
            else concat('-')
        end) as ket,
        tp.asal_outsourcing,
        tk.lokasi_kerja, 
        tp.keluar
        ")
            ->from('hrd_khs.tpribadi tp')
            ->join('hrd_khs.tseksi ts', 'tp.kodesie = ts.kodesie', 'inner')
            ->join('hrd_khs.tlokasi_kerja tk', 'tp.lokasi_kerja = tk.id_', 'inner')
            ->join('hrd_khs.keterangan k', 'tp.noind = k.noind', 'left')
            ->where('tp.tglkeluar  between date_trunc(\'day\', current_date-interval \'10\' day) AND  current_date')
            ->order_by('tp.kodesie asc', 'tp.noind asc')
            ->limit(5)
            ->get()
            ->result_array();
    }

    public function getOS()
    {
        $a = $this->personalia
            ->select('*')
            ->from('hrd_khs.tasaloutsourcing')
            ->get()
            ->result_array();
        array_push($a, array("asal_outsourcing" => "ALL"));
        // debug($a);
        // die;
        return $a;
    }


    /**
     * @param Boolean, string, string, string
     * @return Array of Worker
     */

    public function getPekerjaKeluarWithParam($os, $os_name, $datepicker, $rangeDate)
    {
        // pekerja os kodenya 23 & 18

        $os_code = ['23', '18'];
        $a = '23';
        $query = $this->personalia
            ->select("
                tp.noind, 
                trim(tp.nama) nama, 
                trim(ts.seksi) seksi, 
                trim(ts.unit) unit, 
                ts.bidang, 
                trim(ts.dept) dept, 
                to_char(tp.masukkerja, 'YYYY-MM-DD') as masukkerja, 
                to_char(tp.diangkat, 'YYYY-MM-DD') as diangkat, 
                to_char(tp.tglkeluar, 'YYYY-MM-DD') as tglkeluar, 
                to_char(tp.akhkontrak, 'YYYY-MM-DD') as akhkontrak, 
                tp.lmkontrak,
                (case  
                    when left(tp.noind,1) not in ('J','H','C') then concat('-')
                    when left(tp.noind,1) in ('A','B') or (left(tp.noind,1) = 'C' and substring(tp.noind,3,1) = '1') then tp.sebabklr 
                    when k.ket = '1' then concat('Tidak Perpanjangan')
                    when (tp.tglkeluar::date-tp.diangkat::date)::int > ceil(coalesce(nullif(replace(trim(tp.lmkontrak), '-', ''),  '')::int, 0)*30.4167)::int then 'Sudah Perpanjangan Kontrak'
                    when (tp.tglkeluar::date-tp.diangkat::date)::int <= ceil(coalesce(nullif(replace(trim(tp.lmkontrak), '-', ''),  '')::int, 0)*30.4167)::int then 'Belum Perpanjangan Kontrak'
                    else concat('-')
                end) as ket,
                tp.asal_outsourcing,
                tk.lokasi_kerja, 
                tp.keluar
            ")
            ->from('hrd_khs.tpribadi tp')
            ->join('hrd_khs.tseksi ts', 'tp.kodesie = ts.kodesie', 'inner')
            ->join('hrd_khs.tlokasi_kerja tk', 'tp.lokasi_kerja = tk.id_', 'inner')
            ->join('hrd_khs.keterangan k', 'tp.noind = k.noind', 'left')
            ->order_by('tp.tglkeluar', 'asc')
            ->order_by('tp.noind', 'asc');

        if ($os) {
            // jika os dicentang, maka cari pekerja dengan kd_jabatan 23/18
            if ($os_name == 'ALL') {
                // debug("I m here :)");
                $query->where_in('tp.kd_jabatan', $os_code);
            } else {
                $query->where_in('tp.kd_jabatan', $os_code);
                $query->like('tp.asal_outsourcing', $os_name, 'both');
            } // tp.asal_outsourcing like '%namanya%'
        } else {
            $query->not_like('tp.asal_outsourcing', 'PT. PKSS');
            $query->not_like('tp.asal_outsourcing', 'PT. TUNAS KARYA');
            $query->not_like('tp.asal_outsourcing', 'PT. DHARMAMULIA PRIMA KARYA');
            $query->not_like('tp.asal_outsourcing', 'PT. SUMBERDAYA DIAN MANDIRI');
            $query->not_like('tp.asal_outsourcing', 'CV. PATIN SARI JAYA');
            $query->not_like('tp.asal_outsourcing', 'PT. SUMBER BERLIAN JAYA ABADI');
            $query->not_like('tp.asal_outsourcing', 'PT. CAHAYA MENTARI PERSADA');
            $query->not_like('tp.asal_outsourcing', 'PT. PRIMA KARYA MANDIRI SCRTY');
            $query->not_like('tp.asal_outsourcing', 'PT. KARYA WIBANGGA');
        }

        // TODO,

        if ($datepicker) {
            $query->where("to_char(tp.tglkeluar, 'MM/YYYY') = ", $datepicker);
        } elseif ($rangeDate) {
            // buat misah string 
            $split_date = explode(' - ', $rangeDate);

            $tgl1 = date_create_from_format('d/m/Y', $split_date[0])->format('Y-m-d');
            $tgl2 = date_create_from_format('d/m/Y', $split_date[1])->format('Y-m-d');

            $query->where("tp.tglkeluar >=", $tgl1);
            $query->where("tp.tglkeluar <=", $tgl2);
        }
        return $query->get()->result_array();
    }

    public function getPekerjaDiperbantukan()
    {
        return $this->personalia
            ->select("
            tp.noind, 
            trim(tp.nama) nama, 
            ts.seksi as seksi_awal, 
            (select seksi from hrd_khs.tseksi where kodesie = tpm.kodesie) as seksi_perbantuan,
            tpm.golkerja,
            ts.pekerjaan,
            to_char(tpm.fd_tgl_mulai,'YYYY-MM-DD') ||' s.d '|| to_char(tpm.fd_tgl_selesai, 'YYYY-MM-DD') as lama, 
            tpm.ket,tpm.berlaku,tpm.*
            ")
            ->from('Catering.tpindahmakan tpm')
            ->join('hrd_khs.tpribadi tp', 'tpm.fs_noind = tp.noind', 'inner')
            ->join('hrd_khs.tseksi ts', 'tp.kodesie = ts.kodesie', 'inner')
            ->order_by('tp.noind')
            ->where('tpm.fd_tgl_selesai between date_trunc(\'month\', current_date-interval \'10\' month) AND  current_date')
            ->limit(5)
            ->get()
            ->result_array();
    }

    public function getPekerjaDiperbantukanWithParam($with_os, $datepicker, $rangeDate)
    {
        $query = $this->personalia
            ->select("
        tp.noind, 
        trim(tp.nama) nama, 
        ts.seksi as seksi_awal, 
        (select seksi from hrd_khs.tseksi where kodesie = tpm.kodesie) as seksi_perbantuan,
        tpm.golkerja,
        trim(ts.pekerjaan) pekerjaan,
        to_char(tpm.fd_tgl_mulai,'YYYY-MM-DD') ||' s.d '|| to_char(tpm.fd_tgl_selesai, 'YYYY-MM-DD') as lama, 
        tpm.ket, tpm.*,tpm.berlaku
        ")
            ->from('Catering.tpindahmakan tpm')
            ->join('hrd_khs.tpribadi tp', 'tpm.fs_noind = tp.noind', 'inner')
            ->join('hrd_khs.tseksi ts', 'tp.kodesie = ts.kodesie', 'inner')
            ->order_by('tp.noind');

        if ($with_os) {
            $query->group_start();
            $query->like('tp.noind', 'K', 'after');
            $query->or_like('tp.noind', 'P', 'after');
            $query->group_end();
        } else {
            $query->not_like('tp.noind', 'K', 'after');
            $query->not_like('tp.noind', 'P', 'after');
        }

        if ($datepicker) {
            $query->where("to_char(tpm.fd_tgl_selesai,'MM/YYYY')= ", $datepicker);
        } elseif ($rangeDate) {
            $split_date = explode('-', $rangeDate);

            $date1 = date_create_from_format('d/m/Y', trim($split_date[0]))->format('Y-m-d');
            $date2 = date_create_from_format('d/m/Y', trim($split_date[1]))->format('Y-m-d');

            $query->where("tpm.fd_tgl_selesai >=", $date1);
            $query->where("tpm.fd_tgl_selesai <=", $date2);
        }
        $res = $query->get()->result_array();
        $arr = array_map("unserialize", array_unique(array_map("serialize", $res)));
        $arr_nw = array_values($arr);
        return $arr_nw;
    }

    public function getPekerjaDimutasi()
    {
        return $this->personalia
            ->select("
            tm.noind,
            trim(tp.nama) nama,
            (SELECT  unit from hrd_khs.tseksi where kodesie  = tm.kodesielm) as seksi_lama,
            (SELECT  unit from hrd_khs.tseksi where kodesie  = tm.kodesiebr) as seksi_baru,
            tm.golkerjabr,
            tsb.pekerjaan,
            to_char(tm.tglberlaku,'YYYY-MM-DD') as tglberlaku
        ")
            ->from("hrd_khs.tmutasi tm")
            ->join("hrd_khs.tpribadi tp", "tm.noind = tp.noind", "inner")
            ->join("hrd_khs.tseksi ts", "tm.kodesielm = ts.kodesie", "inner")
            ->join("hrd_khs.tseksi tsb", "tm.kodesiebr = tsb.kodesie", "inner")
            ->where('tm.tglberlaku between date_trunc(\'month\', current_date-interval \'10\' month) AND  current_date')
            ->order_by("tp.noind asc")
            ->limit(5)->get()->result_array();
    }

    public function getPekertaDimutasiWithParam($with_os, $datepicker, $rangeDate)
    {

        $query = $this->personalia
            ->select("
            tm.noind,
            trim(tp.nama) nama,
            (SELECT  unit from hrd_khs.tseksi where kodesie  = tm.kodesielm) as seksi_lama,
            (SELECT  unit from hrd_khs.tseksi where kodesie  = tm.kodesiebr) as seksi_baru,
            tm.golkerjabr,
            trim(tsb.pekerjaan) pekerjaan,
            to_char(tm.tglberlaku,'YYYY-MM-DD') as tglberlaku
            ")
            ->from("hrd_khs.tmutasi tm")
            ->join("hrd_khs.tpribadi tp", "tm.noind = tp.noind", "inner")
            ->join("hrd_khs.tseksi ts", "tm.kodesielm = ts.kodesie", "inner")
            ->join("hrd_khs.tseksi tsb", "tm.kodesiebr = tsb.kodesie", "inner")
            ->order_by("tp.noind asc"); // coba to jalannin

        if ($with_os) {
            $query->group_start(); //
            $query->like('tm.noind', 'K', 'after');
            $query->or_like('tm.noind', 'P', 'after');
            $query->group_end();
        } else {
            $query->not_like("tm.noind", "K", "after");
            $query->not_like("tm.noind", "P", "after");
        }

        if ($datepicker) {
            $query->where("to_char(tm.tglberlaku, 'MM/YYYY') = ", $datepicker);
        } elseif ($rangeDate) {
            $split_date = explode('-', $rangeDate);
            $date1 = date_create_from_format('d/m/Y', trim($split_date[0]))->format('Y-m-d');
            $date2 = date_create_from_format('d/m/Y', trim($split_date[1]))->format('Y-m-d');

            $query->where("tm.tglberlaku >=", $date1);
            $query->where("tm.tglberlaku <=", $date2);
        }

        return $query->get()->result_array();
    }

    function tgl_indo1($tanggal)
    {
        $bulan = array(
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $exp =  explode("/", $tanggal);

        return $bulan[(int)$exp[0]] . ' ' . $exp[1];
    }
}
