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
        $totalKecelakaan   = "          select      to_char(kecelakaan.tanggal_kecelakaan::timestamp, 'Month') as bulan,
                                                    (
                                                        sum(kecelakaan.biaya_perusahaan)
                                                        + 
                                                        sum(kecelakaan.biaya_pekerja)
                                                    ) as total_biaya
                                        from        ga.ga_fleet_kecelakaan as kecelakaan
                                        where       extract(year from kecelakaan.tanggal_kecelakaan)='$tahun'
                                                    and     kecelakaan.end_date='9999-12-12 00:00:00'
                                        group by    bulan, extract(month from kecelakaan.tanggal_kecelakaan)
                                        order by    extract(month from kecelakaan.tanggal_kecelakaan);";
        $query=$this->db->query($totalKecelakaan);
        return $query->result_array();
      }  

    public function rekapFrekuensiKecelakaan($tahun)
      {
        $frekuensiKecelakaan = "    select      to_char(kecelakaan.tanggal_kecelakaan::timestamp, 'Month') as bulan,
                                                count(kecelakaan.kecelakaan_id) as total_frekuensi
                                    from        ga.ga_fleet_kecelakaan as kecelakaan
                                    where       extract(year from kecelakaan.tanggal_kecelakaan)='$tahun'
                                                and     kecelakaan.end_date='9999-12-12 00:00:00'
                                    group by    bulan, extract(month from kecelakaan.tanggal_kecelakaan)
                                    order by    extract(month from kecelakaan.tanggal_kecelakaan);";
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