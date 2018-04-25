<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetrekappajak extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function rekapTotalPajak($tahun)
      {
        $rekapPajak = "     select      tblbulan.angka,
                                        tblbulan.nama_bulan as bulan,
                                        (
                                            select  coalesce(sum(pjk.biaya),0)
                                            from    ga.ga_fleet_pajak as pjk
                                            where   extract(month from pjk.tanggal_pajak)=tblbulan.angka
                                                    and     extract(year from pjk.tanggal_pajak)='$tahun'
                                                    and     pjk.end_date='9999-12-12 00:00:00'
                                        ) as total_biaya
                            from        (
                                            select  angka.* as bulan_angka,
                                                    to_char(to_timestamp(angka::text, 'MM'), 'Month') as nama_bulan
                                            from    generate_series(1,12) as angka  
                                        ) as tblbulan
                            group by    angka, bulan
                            order by    angka;";
        $query=$this->db->query($rekapPajak);
        return $query->result_array();
      } 

    public function rekapTotalPajakCabang($tahun,$lokasi)
    {
        $query = $this->db->query("select      tblbulan.angka,
                                        tblbulan.nama_bulan as bulan,
                                        (
                                            select  coalesce(sum(pjk.biaya),0)
                                            from    ga.ga_fleet_pajak as pjk
                                            where   extract(month from pjk.tanggal_pajak)=tblbulan.angka
                                                    and     extract(year from pjk.tanggal_pajak)='$tahun'
                                                    and     pjk.end_date='9999-12-12 00:00:00'
                                                    and     pjk.kode_lokasi_kerja=$lokasi
                                        ) as total_biaya
                            from        (
                                            select  angka.* as bulan_angka,
                                                    to_char(to_timestamp(angka::text, 'MM'), 'Month') as nama_bulan
                                            from    generate_series(1,12) as angka  
                                        ) as tblbulan
                            group by    angka, bulan
                            order by    angka");
        return $query->result_array();
    } 

    public function rekapFrekuensiPajak($tahun)
      {
        $rekapPajak = "     select      tblbulan.angka,
                                        tblbulan.nama_bulan as bulan,
                                        (
                                            select  coalesce(count(pjk.*),0)
                                            from    ga.ga_fleet_pajak as pjk
                                            where   extract(month from pjk.tanggal_pajak)=tblbulan.angka
                                                    and     extract(year from pjk.tanggal_pajak)='$tahun'
                                                    and     pjk.end_date='9999-12-12 00:00:00'
                                        ) as total_frekuensi
                            from        (
                                            select  angka.* as bulan_angka,
                                                    to_char(to_timestamp(angka::text, 'MM'), 'Month') as nama_bulan
                                            from    generate_series(1,12) as angka  
                                        ) as tblbulan
                            group by    angka, bulan
                            order by    angka;";
        $query=$this->db->query($rekapPajak);
        return $query->result_array();
      } 

    public function rekapFrekuensiPajakCabang($tahun,$lokasi)
    {
        $query = $this->db->query("select      tblbulan.angka,
                                        tblbulan.nama_bulan as bulan,
                                        (
                                            select  coalesce(count(pjk.*),0)
                                            from    ga.ga_fleet_pajak as pjk
                                            where   extract(month from pjk.tanggal_pajak)=tblbulan.angka
                                                    and     extract(year from pjk.tanggal_pajak)='$tahun'
                                                    and     pjk.end_date='9999-12-12 00:00:00'
                                                    and     pjk.kode_lokasi_kerja=$lokasi
                                        ) as total_frekuensi
                            from        (
                                            select  angka.* as bulan_angka,
                                                    to_char(to_timestamp(angka::text, 'MM'), 'Month') as nama_bulan
                                            from    generate_series(1,12) as angka  
                                        ) as tblbulan
                            group by    angka, bulan
                            order by    angka");
        return $query->result_array();
    } 

    public function dropdownTahun()
    {
        $dropdownTahun  = " select distinct extract(year from pjk.tanggal_pajak) as tahun
                            from            ga.ga_fleet_pajak as pjk;";

        $query          =   $this->db->query($dropdownTahun);
        return $query->result_array();
    }

}