<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetrekapkir extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function rekapTotalKIR($tahun)
      {
        $totalKIR   = "     select      tblbulan.angka,
                                        tblbulan.nama_bulan as bulan,
                                        (
                                            select  coalesce(sum(kir.biaya),0)
                                            from    ga.ga_fleet_kir as kir
                                            where   extract(month from kir.tanggal_kir)=tblbulan.angka
                                                    and     extract(year from kir.tanggal_kir)='$tahun'
                                                    and     kir.end_date='9999-12-12 00:00:00'
                                        ) as total_biaya
                            from        (
                                            select  angka.* as bulan_angka,
                                                    to_char(to_timestamp(angka::text, 'MM'), 'Month') as nama_bulan
                                            from    generate_series(1,12) as angka  
                                        ) as tblbulan
                            group by    angka, bulan
                            order by    angka;";
        $query=$this->db->query($totalKIR);
        return $query->result_array();
      } 

    public function rekapTotalKIRCabang($tahun,$lokasi)
    {
        $query = $this->db->query("select      tblbulan.angka,
                                        tblbulan.nama_bulan as bulan,
                                        (
                                            select  coalesce(sum(kir.biaya),0)
                                            from    ga.ga_fleet_kir as kir
                                            where   extract(month from kir.tanggal_kir)=tblbulan.angka
                                                    and     extract(year from kir.tanggal_kir)='$tahun'
                                                    and     kir.end_date='9999-12-12 00:00:00'
                                                    and     kir.kode_lokasi_kerja='$lokasi'
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

    public function rekapFrekuensiKIR($tahun)
      {
        $frekuensiKIR = "   select      tblbulan.angka,
                                        tblbulan.nama_bulan as bulan,
                                        (
                                            select  coalesce(count(kir.*),0)
                                            from    ga.ga_fleet_kir as kir
                                            where   extract(month from kir.tanggal_kir)=tblbulan.angka
                                                    and     extract(year from kir.tanggal_kir)='$tahun'
                                                    and     kir.end_date='9999-12-12 00:00:00'
                                        ) as total_frekuensi
                            from        (
                                            select  angka.* as bulan_angka,
                                                    to_char(to_timestamp(angka::text, 'MM'), 'Month') as nama_bulan
                                            from    generate_series(1,12) as angka  
                                        ) as tblbulan
                            group by    angka, tblbulan.nama_bulan
                            order by    angka;";
        $query=$this->db->query($frekuensiKIR);
        return $query->result_array();
      }  

    public function rekapFrekuensiKIRCabang($tahun,$lokasi)
    {
        $query = $this->db->query("select      tblbulan.angka,
                                        tblbulan.nama_bulan as bulan,
                                        (
                                            select  coalesce(count(kir.*),0)
                                            from    ga.ga_fleet_kir as kir
                                            where   extract(month from kir.tanggal_kir)=tblbulan.angka
                                                    and     extract(year from kir.tanggal_kir)='$tahun'
                                                    and     kir.end_date='9999-12-12 00:00:00'
                                                    and     kir.kode_lokasi_kerja='$lokasi'
                                        ) as total_frekuensi
                            from        (
                                            select  angka.* as bulan_angka,
                                                    to_char(to_timestamp(angka::text, 'MM'), 'Month') as nama_bulan
                                            from    generate_series(1,12) as angka  
                                        ) as tblbulan
                            group by    angka, tblbulan.nama_bulan
                            order by    angka");
        return $query->result_array();
    }

    public function dropdownTahun()
    {
        $dropdownTahun  = " select distinct extract(year from kir.tanggal_kir) as tahun
                            from            ga.ga_fleet_kir as kir;";

        $query          =   $this->db->query($dropdownTahun);
        return $query->result_array();
    }

}