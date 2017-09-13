<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetrekapkecelakaan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function rekapTotalKecelakaan($tahun)
      {
        $totalKecelakaan   = "          select      tblbulan.angka,
                                                    tblbulan.nama_bulan as bulan,
                                                    (
                                                        select  coalesce((sum(kecelakaan.biaya_pekerja)+sum(kecelakaan.biaya_perusahaan)),0)
                                                        from    ga.ga_fleet_kecelakaan as kecelakaan
                                                        where   extract(month from kecelakaan.tanggal_kecelakaan)=tblbulan.angka
                                                                and     extract(year from kecelakaan.tanggal_kecelakaan)='2017'
                                                                and     kecelakaan.end_date='9999-12-12 00:00:00'
                                                    ) as total_biaya
                                        from        (
                                                        select  angka.* as bulan_angka,
                                                                to_char(to_timestamp(angka::text, 'MM'), 'Month') as nama_bulan
                                                        from    generate_series(1,12) as angka  
                                                    ) as tblbulan
                                        group by    angka, bulan
                                        order by    angka;";
        $query=$this->db->query($totalKecelakaan);
        return $query->result_array();
      }  

    public function rekapFrekuensiKecelakaan($tahun)
      {
        $frekuensiKecelakaan = "    select      tblbulan.angka,
                                                tblbulan.nama_bulan as bulan,
                                                (
                                                    select  coalesce(count(kecelakaan.*),0)
                                                    from    ga.ga_fleet_kecelakaan as kecelakaan
                                                    where   extract(month from kecelakaan.tanggal_kecelakaan)=tblbulan.angka
                                                            and     extract(year from kecelakaan.tanggal_kecelakaan)='2017'
                                                            and     kecelakaan.end_date='9999-12-12 00:00:00'
                                                ) as total_frekuensi
                                    from        (
                                                    select  angka.* as bulan_angka,
                                                            to_char(to_timestamp(angka::text, 'MM'), 'Month') as nama_bulan
                                                    from    generate_series(1,12) as angka  
                                                ) as tblbulan
                                    group by    angka, bulan
                                    order by    angka;";
        $query=$this->db->query($frekuensiKecelakaan);
        return $query->result_array();
      }  

    public function dropdownTahun()
    {
        $dropdownTahun  = " select distinct extract(year from kecelakaan.tanggal_kecelakaan) as tahun
                            from            ga.ga_fleet_kecelakaan as kecelakaan;";

        $query          =   $this->db->query($dropdownTahun);
        return $query->result_array();
    }

}