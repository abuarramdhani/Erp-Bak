<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetrekapmaintenance extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function rekapTotalMaintenance($tahun)
      {
        $totalMaintenance   = "     select      tblbulan.angka,
                                                tblbulan.nama_bulan as bulan,
                                                (
                                                    select  coalesce(sum(mtckdrndtl.biaya),0)
                                                    from    ga.ga_fleet_maintenance_kendaraan as mtckdrn
                                                            join    ga.ga_fleet_maintenance_kendaraan_detail as mtckdrndtl
                                                                on  mtckdrndtl.maintenance_kendaraan_id=mtckdrn.maintenance_kendaraan_id
                                                    where   extract(month from mtckdrn.tanggal_maintenance)=tblbulan.angka
                                                            and     extract(year from mtckdrn.tanggal_maintenance)='$tahun'
                                                            and     mtckdrn.end_date='9999-12-12 00:00:00'
                                                            and     mtckdrndtl.end_date='9999-12-12 00:00:00'
                                                ) as total_biaya
                                    from        (
                                                    select  angka.* as bulan_angka,
                                                            to_char(to_timestamp(angka::text, 'MM'), 'Month') as nama_bulan
                                                    from    generate_series(1,12) as angka  
                                                ) as tblbulan
                                    group by    angka, bulan
                                    order by    angka;";
        $query=$this->db->query($totalMaintenance);
        return $query->result_array();
      } 

    public function rekapTotalMaintenanceCabang($tahun,$lokasi)
    {
        $query = $this->db->query("select      tblbulan.angka,
                                                tblbulan.nama_bulan as bulan,
                                                (
                                                    select  coalesce(sum(mtckdrndtl.biaya),0)
                                                    from    ga.ga_fleet_maintenance_kendaraan as mtckdrn
                                                            join    ga.ga_fleet_maintenance_kendaraan_detail as mtckdrndtl
                                                                on  mtckdrndtl.maintenance_kendaraan_id=mtckdrn.maintenance_kendaraan_id
                                                    where   extract(month from mtckdrn.tanggal_maintenance)=tblbulan.angka
                                                            and     extract(year from mtckdrn.tanggal_maintenance)='$tahun'
                                                            and     mtckdrn.end_date='9999-12-12 00:00:00'
                                                            and     mtckdrndtl.end_date='9999-12-12 00:00:00'
                                                            and     mtckdrn.kode_lokasi_kerja='$lokasi'
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

    public function rekapFrekuensiMaintenance($tahun)
      {
        $frekuensiMaintenance = "   select      tblbulan.angka,
                                                tblbulan.nama_bulan as bulan,
                                                (
                                                    select  coalesce(count(mtckdrn.*),0)
                                                    from    ga.ga_fleet_maintenance_kendaraan as mtckdrn
                                                            join    ga.ga_fleet_maintenance_kendaraan_detail as mtckdrndtl
                                                                on  mtckdrndtl.maintenance_kendaraan_id=mtckdrn.maintenance_kendaraan_id
                                                    where   extract(month from mtckdrn.tanggal_maintenance)=tblbulan.angka
                                                            and     extract(year from mtckdrn.tanggal_maintenance)='$tahun'
                                                            and     mtckdrn.end_date='9999-12-12 00:00:00'
                                                            and     mtckdrndtl.end_date='9999-12-12 00:00:00'
                                                ) as total_frekuensi
                                    from        (
                                                    select  angka.* as bulan_angka,
                                                            to_char(to_timestamp(angka::text, 'MM'), 'Month') as nama_bulan
                                                    from    generate_series(1,12) as angka  
                                                ) as tblbulan
                                    group by    angka, bulan
                                    order by    angka;";
        $query=$this->db->query($frekuensiMaintenance);
        return $query->result_array();
      }  

    public function rekapFrekuensiMaintenanceCabang($tahun,$lokasi)
    {
        $query = $this->db->query("select      tblbulan.angka,
                                                tblbulan.nama_bulan as bulan,
                                                (
                                                    select  coalesce(count(mtckdrn.*),0)
                                                    from    ga.ga_fleet_maintenance_kendaraan as mtckdrn
                                                            join    ga.ga_fleet_maintenance_kendaraan_detail as mtckdrndtl
                                                                on  mtckdrndtl.maintenance_kendaraan_id=mtckdrn.maintenance_kendaraan_id
                                                    where   extract(month from mtckdrn.tanggal_maintenance)=tblbulan.angka
                                                            and     extract(year from mtckdrn.tanggal_maintenance)='$tahun'
                                                            and     mtckdrn.end_date='9999-12-12 00:00:00'
                                                            and     mtckdrndtl.end_date='9999-12-12 00:00:00'
                                                            and     mtckdrn.kode_lokasi_kerja='$lokasi'
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
        $dropdownTahun  = " select distinct extract(year from mtckdrn.tanggal_maintenance) as tahun
                            from            ga.ga_fleet_maintenance_kendaraan as mtckdrn;";

        $query          =   $this->db->query($dropdownTahun);
        return $query->result_array();
    }

}