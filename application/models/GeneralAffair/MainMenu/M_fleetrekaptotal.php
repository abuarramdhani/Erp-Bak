<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetrekaptotal extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function rekapBiayaTotal($tahun, $bulan)
      {
        $biayaTotal     = "     select  (
                                            select      coalesce(sum(pjk.biaya),0) as total_biaya
                                            from        ga.ga_fleet_pajak as pjk
                                            where       extract(year from pjk.tanggal_pajak)='$tahun'
                                                        and     extract(month from pjk.tanggal_pajak)='$bulan'
                                                        and     pjk.end_date='9999-12-12 00:00:00'
                                        ) as total_biaya_pajak,
                                        (
                                            select      coalesce(sum(kir.biaya),0) as total_biaya
                                            from        ga.ga_fleet_kir as kir
                                            where       extract(year from kir.tanggal_kir)='$tahun'
                                                        and     extract(month from kir.tanggal_kir)='$bulan'
                                                        and     kir.end_date='9999-12-12 00:00:00'
                                        ) as total_biaya_kir,
                                        (
                                            select      coalesce(sum(mtckdrndtl.biaya),0) as total_biaya
                                            from        ga.ga_fleet_maintenance_kendaraan as mtckdrn
                                                        join    ga.ga_fleet_maintenance_kendaraan_detail as mtckdrndtl
                                                            on  mtckdrndtl.maintenance_kendaraan_id=mtckdrn.maintenance_kendaraan_id
                                            where       extract(year from mtckdrn.tanggal_maintenance)='$tahun'
                                                        and     extract(month from mtckdrn.tanggal_maintenance)='$bulan'
                                                        and     mtckdrn.end_date='9999-12-12 00:00:00'
                                                        and     mtckdrndtl.end_date='9999-12-12 00:00:00'
                                        ) as total_biaya_maintenance_kendaraan,
                                        (
                                            select      coalesce(
                                                            sum(kecelakaan.biaya_perusahaan)
                                                            + 
                                                            sum(kecelakaan.biaya_pekerja)
                                                        ,0) as total_biaya
                                            from        ga.ga_fleet_kecelakaan as kecelakaan
                                            where       extract(year from kecelakaan.tanggal_kecelakaan)='$tahun'
                                                        and     extract(month from kecelakaan.tanggal_kecelakaan)='$bulan'
                                                        and     kecelakaan.end_date='9999-12-12 00:00:00'
                                        ) as total_biaya_kecelakaan;";
        $query=$this->db->query($biayaTotal);
        return $query->result_array();
      }  

    public function rekapFrekuensiTotal($tahun, $bulan)
      {
        $frekuensiTotal = "     select  (
                                            select      coalesce(count(pjk.biaya),0) as total_frekuensi
                                            from        ga.ga_fleet_pajak as pjk
                                            where       extract(year from pjk.tanggal_pajak)='$tahun'
                                                        and     extract(month from pjk.tanggal_pajak)='$bulan'
                                                        and     pjk.end_date='9999-12-12 00:00:00'
                                        ) as total_frekuensi_pajak,
                                        (
                                            select      coalesce(count(kir.biaya),0) as total_frekuensi
                                            from        ga.ga_fleet_kir as kir
                                            where       extract(year from kir.tanggal_kir)='$tahun'
                                                        and     extract(month from kir.tanggal_kir)='$bulan'
                                                        and     kir.end_date='9999-12-12 00:00:00'
                                        ) as total_frekuensi_kir,
                                        (
                                            select      coalesce(count(mtckdrn.maintenance_kendaraan_id),0) as total_frekuensi
                                            from        ga.ga_fleet_maintenance_kendaraan as mtckdrn
                                                        join    ga.ga_fleet_maintenance_kendaraan_detail as mtckdrndtl
                                                            on  mtckdrndtl.maintenance_kendaraan_id=mtckdrn.maintenance_kendaraan_id
                                            where       extract(year from mtckdrn.tanggal_maintenance)='$tahun'
                                                        and     extract(month from mtckdrn.tanggal_maintenance)='$bulan'
                                                        and     mtckdrn.end_date='9999-12-12 00:00:00'
                                                        and     mtckdrndtl.end_date='9999-12-12 00:00:00'
                                        ) as total_frekuensi_maintenance_kendaraan,
                                        (
                                            select      coalesce(count(kecelakaan.kecelakaan_id),0) as total_frekuensi
                                            from        ga.ga_fleet_kecelakaan as kecelakaan
                                            where       extract(year from kecelakaan.tanggal_kecelakaan)='$tahun'
                                                        and     extract(month from kecelakaan.tanggal_kecelakaan)='$bulan'
                                                        and     kecelakaan.end_date='9999-12-12 00:00:00'
                                        ) as total_frekuensi_kecelakaan;";
        $query=$this->db->query($frekuensiTotal);
        return $query->result_array();
      }  

    public function dropdownTahun()
    {
        $dropdownTahun  = " select distinct extract(year from pjk.tanggal_pajak) as tahun
                            from            ga.ga_fleet_pajak as pjk
                            union
                            select distinct extract(year from kir.tanggal_kir) as tahun
                            from            ga.ga_fleet_kir as kir
                            union
                            select distinct extract(year from mtckdrn.tanggal_maintenance) as tahun
                            from            ga.ga_fleet_maintenance_kendaraan as mtckdrn
                            union
                            select distinct extract(year from kecelakaan.tanggal_kecelakaan) as tahun
                            from            ga.ga_fleet_kecelakaan as kecelakaan;";

        $query          =   $this->db->query($dropdownTahun);
        return $query->result_array();
    }
 
    public function dropdownBulan()
    {
        $dropdownBulan  = " select distinct extract(month from pjk.tanggal_pajak) as bulan_angka,
                                            to_char(pjk.tanggal_pajak::timestamp, 'Month') as bulan
                            from            ga.ga_fleet_pajak as pjk
                            union
                            select distinct extract(month from kir.tanggal_kir) as bulan_angka,
                                            to_char(kir.tanggal_kir::timestamp, 'Month') as bulan
                            from            ga.ga_fleet_kir as kir
                            union
                            select distinct extract(month from mtckdrn.tanggal_maintenance) as bulan_angka,
                                            to_char(mtckdrn.tanggal_maintenance::timestamp, 'Month') as bulan
                            from            ga.ga_fleet_maintenance_kendaraan as mtckdrn
                            union
                            select distinct extract(month from kecelakaan.tanggal_kecelakaan) as bulan_angka,
                                            to_char(kecelakaan.tanggal_kecelakaan::timestamp, 'Month') as bulan
                            from            ga.ga_fleet_kecelakaan as kecelakaan
                            order by        bulan_angka;";

        $query          =   $this->db->query($dropdownBulan);
        return $query->result_array();
    }

}