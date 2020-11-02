<?php defined('BASEPATH') or exit('No direct script access allowed');


class M_cetakmemohasilorientasi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->personalia = $this->load->database('personalia', true);
    }

    public function getDaftarMemo()
    {
        $sql = $this->personalia->select("tm.nosurat,
        tm.hal,
        to_char(tm.tanggal,'YYYY-MM-DD') as tanggal,
        tm.periode,
        tm.jenis,
        tm.nmtujuan,
        tm.jbttujuan,
        tm.seksitujuan,
        tm.nmpengirim,
        tm.jbtpengirim,
        tm.seksipengirim,
        tm.tembusan1,
        tm.tembusan2,
        tm.tembusan3,
        tm.tembusan4,
        tm.tembusan5,
        tm.kdmemo,
        tm.cetak")
            ->from("Sie_Pelatihan.tmemo tm")
            ->order_by('tanggal', 'DESC')
            ->where("date_part('year', tanggal) = date_part('year', CURRENT_DATE)")
            ->get()
            ->result_array();
        return $sql;
    }

    //ini data awal
    public function getDaftarNilai()
    {
        $arr = array(array(
            "nama" => "-",
            "noind" => "-",
            "seksi" => "-",
            "kdmemo" => "-",
            "lulus" => "-",
            'cv' => '-',
            'cp' => '-',
            'ap' => '-',
            'nb' => '-',
            'sf' => '-',
            's5' => '-',
            'hdl' => '-',
            'bgab' => '-',
            'bcc1' => '-',
            'cc1' => '-',
            'cc2' => '-',
            'bcm1' => '-',
            'bcm2' => '-',
            'cm1' => '-',
            'cm2' => '-',
            'abu' => '-',
            'ncv' => '-',
            'ncp' => '-',
            'nap' => '-',
            'nnb' => '-',
            'nsf' => '-',
            'ns5' => '-',
            'nhdl' => '-',
            'nbgab' => '-',
            'nbcc1' => '-',
            'ncc1' => '-',
            'ncc2' => '-',
            'nbcm1' => '-',
            'nbcm2' => '-',
            'ncm1' => '-',
            'ncm2' => '-',
            'nabu' => '-'
        ));
        return $arr;
    }

    public function getDaftarMemoWithParam($kdmemo)
    {
        $sql = $this->personalia->select("tm.nosurat,
        tm.hal,
        to_char(tm.tanggal,'YYYY-MM-DD') as tanggal,
        tm.periode,
        tm.jenis,
        tm.nmtujuan,
        tm.jbttujuan,
        tm.seksitujuan,
        tm.nmpengirim,
        tm.jbtpengirim,
        tm.seksipengirim,
        tm.tembusan1,
        tm.tembusan2,
        tm.tembusan3,
        tm.tembusan4,
        tm.tembusan5,
        tm.kdmemo,
        tm.cetak")
            ->from("Sie_Pelatihan.tmemo tm")
            ->order_by('tanggal', 'DESC')
            ->where('kdmemo', $kdmemo)
            ->get()
            ->result_array();
        return $sql;
    }


    public function searchDaftarMemoWithParam($year)
    {
        $sql = $this->personalia->select("tm.nosurat,
        tm.hal,
        to_char(tm.tanggal,'YYYY-MM-DD') as tanggal,
        tm.periode,
        tm.jenis,
        tm.nmtujuan,
        tm.jbttujuan,
        tm.seksitujuan,
        tm.nmpengirim,
        tm.jbtpengirim,
        tm.seksipengirim,
        tm.tembusan1,
        tm.tembusan2,
        tm.tembusan3,
        tm.tembusan4,
        tm.tembusan5,
        tm.kdmemo,
        tm.cetak")
            ->from("Sie_Pelatihan.tmemo tm")
            ->where('date_part(\'year\',tanggal)', $year)
            ->order_by('tanggal', 'DESC')
            ->get()
            ->result_array();
        return $sql;
    }
    // ini data setelah diklik 2 kali
    public function getDaftarNilaiWithParam($kdmemo)
    {
        $where = "a.kdmateri = tm.kdmateri
        and tp.kodesie = ts.kodesie
        and a.noind = tp.noind
        and a.kdmemo = '$kdmemo'";
        $sql = $this->personalia->select("
            trim(tp.nama) nama, a.noind,ts.seksi,a.kdmemo,a.lulus,
            (select MAX(case when a.kdmateri = 'CV' then trim(a.nilai) else '-' end)) as cv,
            (select MAX(case when a.kdmateri = 'CP' then trim(a.nilai) else '-' end)) as cp,
            (select MAX(case when a.kdmateri = 'AP' then trim(a.nilai) else '-' end)) as ap,
            (select MAX(case when a.kdmateri = 'NB' then trim(a.nilai) else '-' end)) as nb,
            (select MAX(case when a.kdmateri = 'SF' then trim(a.nilai) else '-' end)) as sf,
            (select MAX(case when a.kdmateri = '5S' then trim(a.nilai) else '-' end)) as s5,
            (select MAX(case when a.kdmateri = 'HDL' then trim(a.nilai) else '-' end)) as hdl,
            (select MAX(case when a.kdmateri = 'BG AB' then trim(a.nilai) else '-' end)) as bgab,
            (select MAX(case when a.kdmateri = 'BCC1' then trim(a.nilai) else '-' end)) as bcc1,
            (select MAX(case when a.kdmateri = 'CC1' then trim(a.nilai) else '-' end)) as cc1,
            (select MAX(case when a.kdmateri = 'CC2' then trim(a.nilai) else '-' end)) as cc2,
            (select MAX(case when a.kdmateri = 'BCM1' then trim(a.nilai) else '-' end)) as bcm1,
            (select MAX(case when a.kdmateri = 'BCM2' then trim(a.nilai) else '-' end)) as bcm2,
            (select MAX(case when a.kdmateri = 'CM1' then trim(a.nilai) else '-' end)) as cm1,
            (select MAX(case when a.kdmateri = 'CM2' then trim(a.nilai) else '-' end)) as cm2,
            (select MAX(case when a.kdmateri = 'ABU' then trim(a.nilai) else '-' end)) as abu")
            ->from("Sie_Pelatihan.tdetilnilai a, hrd_khs.tseksi ts,
            Sie_Pelatihan.tmateri tm,hrd_khs.tpribadi tp")
            ->where($where)
            ->group_by("1,2,3,4,5")
            ->order_by("a.noind")
            ->get()->result_array();
        //buat nampilin array yang ada keterangan lulus == f (remidi) ? dibawah buat nampilin yang remidi
        $remidi = array();
        foreach ($sql as $row) {
            if ($row['lulus'] == 'f') {
                $remidi[] = $row;
            }
        }
        //untuk mengelompokkan noind
        $a = array_unique(array_column($sql, 'noind')); // ini yang semua
        $b = array_unique(array_column($remidi, 'noind')); //ini yang remidi
        $lulus = array_diff($a, $b); //ini hasilnya adalah yang tidak remidi
        $data = array();
        // $cek = array_count_values($b); //hitung jumlah remidi 
        foreach ($sql as $row) { //ini foreach semua data
            foreach ($remidi as $val) { // yang remidi
                // foreach ($cek as $key => $value) { // cek jumlah remidi
                if ($row['noind'] == $val['noind'] && $row['lulus'] == 't') {
                    $c = $d = $e = $f = $g = $h = $i = $j = $k = $l = $m = $n = $o = $p = $q = $r = '';
                    if ($val['cv'] != '-') $c .= $val['cv'] . "/";
                    if ($val['cp'] != '-') $d .= $val['cp'] . "/";
                    if ($val['ap'] != '-') $e .= $val['ap'] . "/";
                    if ($val['nb'] != '-') $f .= $val['nb'] . "/";
                    if ($val['sf'] != '-') $g .= $val['sf'] . "/";
                    if ($val['s5'] != '-') $h .= $val['s5'] . "/";
                    if ($val['hdl'] != '-') $i .= $val['hdl'] . "/";
                    if ($val['bgab'] != '-') $j .= $val['bgab'] . "/";
                    if ($val['bcc1'] != '-') $k .= $val['bcc1'] . "/";
                    if ($val['cc1'] != '-') $l .= $val['cc1'] . "/";
                    if ($val['cc2'] != '-') $m .= $val['cc2'] . "/";
                    if ($val['bcm1'] != '-') $n .= $val['bcm1'] . "/";
                    if ($val['bcm2'] != '-') $o .= $val['bcm2'] . "/";
                    if ($val['cm1'] != '-') $p .= $val['cm1'] . "/";
                    if ($val['cm2'] != '-') $q .= $val['cm2'] . "/";
                    if ($val['abu'] != '-') $r .= $val['abu'] . "/";

                    $data[] = array(
                        'nama' => $row['nama'],
                        'noind' => $row['noind'],
                        'seksi' => $row['seksi'],
                        'kdmemo' => $row['kdmemo'],
                        'lulus' => $row['lulus'],
                        'cv' => $c . $row['cv'],
                        'cp' => $d . $row['cp'],
                        'ap' => $e . $row['ap'],
                        'nb' => $f . $row['nb'],
                        'sf' => $g . $row['sf'],
                        's5' => $h . $row['s5'],
                        'hdl' => $i . $row['hdl'],
                        'bgab' => $j . $row['bgab'],
                        'bcc1' => $k . $row['bcc1'],
                        'cc1' => $l . $row['cc1'],
                        'cc2' => $m . $row['cc2'],
                        'bcm1' => $n . $row['bcm1'],
                        'bcm2' => $o . $row['bcm2'],
                        'cm1' => $p . $row['cm1'],
                        'cm2' => $q . $row['cm2'],
                        'abu' => $r . $row['abu']
                    );
                }
            }
            if (in_array($row['noind'], $lulus) && $row['lulus'] = 't') {
                $data[] = $row;
            }
        }
        $newarr = array();
        foreach ($data as $key => $value) {
            $newarr[$key]['nama'] = $value['nama'];
            $newarr[$key]['noind'] = $value['noind'];
            $newarr[$key]['seksi'] = $value['seksi'];
            $newarr[$key]['cv'] = $value['cv'];
            $newarr[$key]['cp'] = $value['cp'];
            $newarr[$key]['ap'] = $value['ap'];
            $newarr[$key]['nb'] = $value['nb'];
            $newarr[$key]['sf'] = $value['sf'];
            $newarr[$key]['s5'] = $value['s5'];
            $newarr[$key]['hdl'] = $value['hdl'];
            $newarr[$key]['bgab'] = $value['bgab'];
            $newarr[$key]['bcc1'] = $value['bcc1'];
            $newarr[$key]['cc1']  = $value['cc1'];
            $newarr[$key]['cc2']  = $value['cc2'];
            $newarr[$key]['bcm1']   = $value['bcm1'];
            $newarr[$key]['bcm2']   = $value['bcm2'];
            $newarr[$key]['cm1']  = $value['cm1'];
            $newarr[$key]['cm2']  = $value['cm2'];
            $newarr[$key]['abu'] = $value['abu'];

            ($newarr[$key]['cv'] == '-' ? $newarr[$key]['ncv'] = $value = '-' : $newarr[$key]['ncv'] = $value = 'CV');
            ($newarr[$key]['cp'] == '-' ? $newarr[$key]['ncp'] = $value = '-' : $newarr[$key]['ncp'] = $value = 'CP');
            ($newarr[$key]['ap'] == '-' ? $newarr[$key]['nap'] = $value = '-' : $newarr[$key]['nap'] = $value = 'AP');
            ($newarr[$key]['nb'] == '-' ? $newarr[$key]['nnb'] = $value = '-' : $newarr[$key]['nnb'] = $value = 'NB');
            ($newarr[$key]['sf'] == '-' ? $newarr[$key]['nsf'] = $value = '-' : $newarr[$key]['nsf'] = $value = 'SF');
            ($newarr[$key]['s5'] == '-' ? $newarr[$key]['ns5'] = $value = '-' : $newarr[$key]['ns5'] = $value = '5S');
            ($newarr[$key]['hdl'] == '-' ? $newarr[$key]['nhdl'] = $value = '-' : $newarr[$key]['nhdl'] = $value = 'HDL');
            ($newarr[$key]['bgab'] == '-' ? $newarr[$key]['nbgab'] = $value = '-' : $newarr[$key]['nbgab'] = $value = 'BG AB');
            ($newarr[$key]['bcc1'] == '-' ? $newarr[$key]['nbcc1'] = $value = '-' : $newarr[$key]['nbcc1'] = $value = 'BCC1');
            ($newarr[$key]['cc1'] == '-' ? $newarr[$key]['ncc1'] = $value = '-' : $newarr[$key]['ncc1'] = $value = 'CC1');
            ($newarr[$key]['cc2'] == '-' ? $newarr[$key]['ncc2'] = $value = '-' : $newarr[$key]['ncc2'] = $value = 'CC2');
            ($newarr[$key]['bcm1'] == '-' ? $newarr[$key]['nbcm1'] = $value = '-' : $newarr[$key]['nbcm1'] = $value = 'BCM1');
            ($newarr[$key]['bcm2'] == '-' ? $newarr[$key]['nbcm2'] = $value = '-' : $newarr[$key]['nbcm2'] = $value = 'BCM2');
            ($newarr[$key]['cm1'] == '-' ? $newarr[$key]['ncm1'] = $value = '-' : $newarr[$key]['ncm1'] = $value = 'CM1');
            ($newarr[$key]['cm2'] == '-' ? $newarr[$key]['ncm2'] = $value = '-' : $newarr[$key]['ncm2'] = $value = 'CM2');
            ($newarr[$key]['abu'] == '-' ? $newarr[$key]['nabu'] = $value = '-' : $newarr[$key]['nabu'] = $value = 'ABU');
        }
        return $newarr;
    }

    public function getMateri()
    {
        $sql = $this->personalia->select("*")
            ->from("Sie_Pelatihan.tmateri")
            ->order_by("nourut")
            ->get()->result_array();
        // print "<pre>";
        // print_r($sql);
        // die;

        return $sql;
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
        $exp =  explode("-", $tanggal);

        return $exp[2] . ' ' . $bulan[(int)$exp[1]] . ' ' . $exp[0];
    }
    //begini ? oalah ning model e to
    function updateCetak($kdmemo)
    {
        $this->personalia->set('cetak', 't');
        $this->personalia->where('kdmemo', $kdmemo);
        $this->personalia->update('Sie_Pelatihan.tmemo');
    }
}
