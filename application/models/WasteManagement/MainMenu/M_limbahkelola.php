<?php
Defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 */
class M_limbahkelola extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // public function getJenisLimbah()
    // {
    //     $sql = "SELECT trim(jenis_limbah),id_jenis_limbah
    //     FROM ga.ga_limbah_jenis
    //     order by jenis_limbah";
    //     $result = $this->db->query($sql);
    //     return $result->result_array();
    // }

    // public function getSeksiPengirim()
    // {
    //     $sql = "SELECT distinct section_name
    //     FROM er.er_section sect,ga.ga_limbah_kirim limkir
    //     where left(sect.section_code,7) = limkir.kodesie_kirim and sect.section_code like '%00'
    //     order by sect.section_name";
    //     $result = $this->db->query($sql);
    //     return $result->result_array();
    // }

    public function getLimbahKirim($lokasi = '')
    {
        $approveByWasteManagement = 1;
        $approveByKasie = 4;
        // print_r("<pre>");
        // print_r($periode2);
        // die;

        if ($lokasi == 'yogyakarta') {
            $filterLokasi = "and limkir.lokasi_kerja = '01' ";
        } else if ($lokasi == 'tuksono') {
            $filterLokasi = "and limkir.lokasi_kerja = '02' ";
        } else if ($lokasi == 'all' || $lokasi == '' || $lokasi == null) {
            $filterLokasi = "";
        }

        // if ($limbah != 'all') {
        //     $filterLimbah = "and limjen.jenis_limbah like '$limbah'";
        // } else {
        //     $filterLimbah = "";
        // }

        // if ($pengirim != 'all') {
        //     $filterPengirim = "and ers.section_name like '$pengirim'";
        // } else {
        //     $filterPengirim = "";
        // }

        // if ($periode1 != '' && $periode2 != '') {
        //     $periode1 = date('Y-m-d', strtotime($periode1));
        //     $periode2 = date('Y-m-d', strtotime($periode2));
        //     $per = "and limkir.tanggal_kirim::date between '$periode1' and '$periode2'";
        // } else {
        //     $per = '';
        // }

        $query = "SELECT limkir.id_kirim, 
                    limkir.kodesie_kirim, ers.section_name as seksi,
                                to_char(limkir.tanggal_kirim, 'YYYY-MM-DD') as tanggal,
                                cast(limkir.tanggal_kirim as time) waktu,
                                limjen.jenis_limbah,concat(limkir.jumlah_kirim, ' ',(select limbah_satuan
                                from ga.ga_limbah_satuan limsat
                                where limsat.id_jenis_limbah = limjen.id_jenis_limbah)) jumlah,
                    concat(limkir.jumlah_kirim, ' ',(select limbah_satuan_all
                    from ga.ga_limbah_satuan_all limsatall
                    where limsatall.id_satuan_all = limkir.id_satuan)) jumlahall,
                                limkir.lokasi_kerja,
                                limkir.berat_kirim,
                                limkir.status_kirim,
                    limkir.id_satuan,
                                (select concat(employee_code,' - ',employee_name) from er.er_employee_all where employee_code = limkir.noind_pengirim)
                                pekerja,
                                (select concat(location_code,' - ',location_name) from er.er_location where location_code = limkir.lokasi_kerja) noind_location
                            FROM 
                                ga.ga_limbah_kirim limkir
                                inner join ga.ga_limbah_jenis limjen on limjen.id_jenis_limbah = limkir.id_jenis_limbah
                                inner join er.er_employee_all ema on ema.employee_code = limkir.noind_pengirim
                                left join er.er_section ers on ers.section_code = ema.section_code
                            WHERE limkir.status_kirim in('1','2','4', '3') $filterLokasi 
                    order by limkir.tanggal_kirim desc";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getLimbahKirimById($id)
    {
        $query =     "select limkir.id_kirim,
                        cast(limkir.tanggal_kirim as date) tanggal,
                        cast(limkir.tanggal_kirim as time) waktu,
                        limjen.jenis_limbah,
                        (select sect.section_name from er.er_section sect where left(sect.section_code,7) = limkir.kodesie_kirim and sect.section_code like '%00') seksi,
                        concat(limkir.jumlah_kirim, ' ',(select limbah_satuan
                        from ga.ga_limbah_satuan limsat
                        where limsat.id_jenis_limbah = limjen.id_jenis_limbah)) jumlah,
												(select sect.section_name from er.er_section sect where left(sect.section_code,7) = limkir.kodesie_kirim and sect.section_code like '%00') seksi,
												concat(limkir.jumlah_kirim, ' ',(select limbah_satuan_all
												from ga.ga_limbah_satuan_all limsatall
												where limsatall.id_satuan_all = limkir.id_satuan)) jumlahall,
                        limkir.lokasi_kerja,
                        limkir.berat_kirim,
                        limkir.bocor,
                        limkir.ket_kirim,
                        limkir.status_kirim,
												limkir.id_satuan,
                        (select concat(employee_code,' - ',employee_name) from er.er_employee_all where employee_code = limkir.noind_pengirim and resign = '0')
                        pekerja,
                        (select concat(location_code,' - ',location_name) from er.er_location where location_code = limkir.lokasi_kerja) noind_location
                    from ga.ga_limbah_kirim limkir
                    inner join ga.ga_limbah_jenis limjen on limjen.id_jenis_limbah = limkir.id_jenis_limbah
                    where id_kirim = '$id'
                    order by limkir.tanggal_kirim desc";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function DeleteLimbahKirim($id)
    {
        $query = "delete from ga.ga_limbah_kirim where id_kirim = '$id'";
        $this->db->query($query);
    }
    public function getLokasi()
    {
        $query2 = "select location_code,location_name
                from er.er_location
                order by location_code";

        $result = $this->db->query($query2);
        return $result->result_array();
    }

    public function updateLimbahStatus($status, $id)
    {
        $query = "update ga.ga_limbah_kirim set status_kirim = '$status' where id_kirim = '$id'";
        $this->db->query($query);
    }

    public function updateLimbahberat($berat, $id)
    {
        $query = "update ga.ga_limbah_kirim set berat_kirim = '$berat' where id_kirim = '$id'";
        $this->db->query($query);
    }

    public function getSeksiEmail($id)
    {
        $query = "select created_by from ga.ga_limbah_kirim where id_kirim = '$id'";
        $hasil = $this->db->query($query);
        $userseksi = $hasil->result_array();
        $user = $userseksi['0']['created_by'];

        $query = "select email_kirim,seksi_kirim from ga.ga_limbah_kirim_email where user_seksi = '$user'";
        $result = $this->db->query($query);

        return $result->result_array();
    }

    public function getLimKirimMin($id)
    {
        $query = "select limjen.jenis_limbah,
                    cast(limkir.tanggal_kirim as date) tanggal,
                    (select sect.section_name from er.er_section sect where left(sect.section_code,7) = limkir.kodesie_kirim and sect.section_code like '%00') seksi,
                    (select concat(location_code,' - ',location_name) from er.er_location where location_code = limkir.lokasi_kerja) noind_location,
                    concat(limkir.jumlah_kirim,' ',limsat.limbah_satuan) jumlah,
                    limkir.lokasi_kerja,
                    limkir.berat_kirim berat
                    from ga.ga_limbah_kirim limkir
                    inner join ga.ga_limbah_jenis limjen on limjen.id_jenis_limbah = limkir.id_jenis_limbah
                    inner join ga.ga_limbah_satuan limsat on limsat.id_jenis_limbah = limjen.id_jenis_limbah
                    where id_kirim = '$id';";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    function getDataLimbah($start, $end, $limbah, $lokasi, $detailed, $seksi)
    {
        $start = date('Y-m-d', strtotime($start));
        $end = date('Y-m-d', strtotime($end));

        $filterLimbah = '';
        if (count($limbah)) {
            $limbah = array_map(function ($item) {
                return "'$item'";
            }, $limbah);
            $limbah = implode(',', $limbah);
            $filterLimbah = "and limkir.id_jenis_limbah in ($limbah)";
        }
        $filterLokasi = '';
        if (count($lokasi)) {
            $lokasi = array_map(function ($item) {
                return "'$item'";
            }, $lokasi);
            $lokasi = implode(',', $lokasi);
            $filterlokasi = "and limkir.lokasi_kerja in ($lokasi)";
        }
        $filterseksi = '';
        // if ($seksi != 'all') {
        //     $filterseksi = "and sect.section_name = ($seksi)";
        // } else {
        //     $filterseksi = '';
        // }
        if (count($seksi)) {
            $seksi = array_map(function ($item) {
                return "'$item'";
            }, $seksi);
            $seksi = implode(',', $seksi);
            $filterseksi = "and section_name in ($seksi)";
        }


        // not detailed
        //if($detailed == 'false') {
        // $sql = "SELECT 
        //       distinct limkir.id_jenis_limbah,
        //      limjen.jenis_limbah,
        //      (select trunc(sum(berat_kirim)::numeric, 3) from ga.ga_limbah_kirim where id_jenis_limbah = limkir.id_jenis_limbah and tanggal_kirim::date between '$start' and '$end') as berat_kirim
        //    FROM ga.ga_limbah_kirim limkir inner join ga.ga_limbah_jenis limjen 
        //        on limkir.id_jenis_limbah = limjen.id_jenis_limbah
        //   WHERE limkir.status_kirim = '1' and limkir.tanggal_kirim::date between '$start' and '$end' $filterLimbah $filterlokasi
        //   ORDER BY jenis_limbah";
        // } else {
        // detailed
        //$sql = "SELECT
        //      limjen.jenis_limbah,
        //     to_char(limkir.tanggal_kirim, 'YYYY-MM-DD') as tanggal_kirim,
        //    (select sect.section_name from er.er_section sect where left(sect.section_code,7) = limkir.kodesie_kirim and sect.section_code like '%00') section_name,
        //   trunc(limkir.berat_kirim::numeric, 3) as berat_kirim
        //FROM ga.ga_limbah_kirim limkir inner join ga.ga_limbah_jenis limjen 
        //       on limkir.id_jenis_limbah = limjen.id_jenis_limbah
        // WHERE limkir.status_kirim = '1' and limkir.tanggal_kirim::date between '$start' and '$end' $filterLimbah $filterlokasi
        //ORDER BY limkir.tanggal_kirim"; // 1 adalah yg sudah diapprove oleh waste management
        //}

        // not detailed
        if ($detailed == 'false') {
            $sql = "SELECT 
                    limkir.id_jenis_limbah,
                    limjen.jenis_limbah,
                     trunc (sum(limkir.berat_kirim)::numeric, 3) as berat_kirim
                    FROM ga.ga_limbah_kirim limkir inner join ga.ga_limbah_jenis limjen 
                    on limkir.id_jenis_limbah = limjen.id_jenis_limbah
                    WHERE limkir.status_kirim = '1' and limkir.tanggal_kirim::date between '$start' and '$end'
                    $filterLimbah $filterlokasi 
                    group by limkir.id_jenis_limbah, limjen.jenis_limbah
                    ORDER BY jenis_limbah";
        } else {
            // detailed
            $sql = "SELECT 
                        distinct limkir.id_jenis_limbah,
                        (select concat(employee_code,' - ',employee_name) from er.er_employee_all where employee_code = limkir.noind_pengirim and resign = '0') pekerja,
                        limjen.jenis_limbah,
                        to_char(limkir.tanggal_kirim, 'YYYY-MM-DD') as tanggal_kirim,
                        cast(limkir.tanggal_kirim as time) waktu,
                        trim(sect.section_name) section_name,
                        concat(limkir.jumlah_kirim, ' ',(select limbah_satuan_all
                          from ga.ga_limbah_satuan_all limsatall
                          where limsatall.id_satuan_all = limkir.id_satuan)) jumlahall,
                        trunc(limkir.berat_kirim::numeric, 3) as berat_kirim
                    FROM ga.ga_limbah_kirim limkir 
                        inner join ga.ga_limbah_jenis limjen  on limkir.id_jenis_limbah = limjen.id_jenis_limbah
                        left join er.er_section sect on left(sect.section_code,7) = limkir.kodesie_kirim 
                    WHERE limkir.status_kirim = '1'  and limkir.tanggal_kirim::date between '$start' and '$end' $filterLimbah $filterlokasi  $filterseksi
                        group by limkir.id_jenis_limbah, limjen.jenis_limbah,limkir.tanggal_kirim,sect.section_name,pekerja,limkir.berat_kirim,waktu,jumlahall
                    ORDER BY tanggal_kirim desc
                    ";
        }
        // echo $sql;exit();
        return $this->db->query($sql)->result_array();
    }
}
