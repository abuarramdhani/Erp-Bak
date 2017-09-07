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
        $totalMaintenance   = "     select      to_char(mtckdrn.tanggal_maintenance::timestamp, 'Month') as bulan,
                                                sum(mtckdrndtl.biaya) as total_biaya
                                    from        ga.ga_fleet_maintenance_kendaraan as mtckdrn
                                                join    ga.ga_fleet_maintenance_kendaraan_detail as mtckdrndtl
                                                    on  mtckdrndtl.maintenance_kendaraan_id=mtckdrn.maintenance_kendaraan_id
                                    where       extract(year from mtckdrn.tanggal_maintenance)='$tahun'
                                                and     mtckdrn.end_date='9999-12-12 00:00:00'
                                                and     mtckdrndtl.end_date='9999-12-12 00:00:00'
                                    group by    bulan, extract(month from mtckdrn.tanggal_maintenance)
                                    order by    extract(month from mtckdrn.tanggal_maintenance);";
        $query=$this->db->query($totalMaintenance);
        return $query->result_array();
      }  

    public function rekapFrekuensiMaintenance($tahun)
      {
        $frekuensiMaintenance = "   select      to_char(mtckdrn.tanggal_maintenance::timestamp, 'Month') as bulan,
                                                count(mtckdrn.maintenance_kendaraan_id) as total_frekuensi
                                    from        ga.ga_fleet_maintenance_kendaraan as mtckdrn
                                    where       extract(year from mtckdrn.tanggal_maintenance)='$tahun'
                                                and     mtckdrn.end_date='9999-12-12 00:00:00'
                                    group by    bulan, extract(month from mtckdrn.tanggal_maintenance)
                                    order by    extract(month from mtckdrn.tanggal_maintenance);";
        $query=$this->db->query($frekuensiMaintenance);
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