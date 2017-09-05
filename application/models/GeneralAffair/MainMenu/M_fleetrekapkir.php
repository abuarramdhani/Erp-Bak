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
        $totalKIR   = "     select      to_char(kir.tanggal_kir::timestamp, 'Month') as bulan,
                                        sum(kir.biaya) as total_biaya
                            from        ga.ga_fleet_kir as kir
                            where       extract(year from kir.tanggal_kir)='$tahun'
                                        and     kir.end_date='9999-12-12 00:00:00'
                            group by    bulan, extract(month from kir.tanggal_kir)
                            order by    extract(month from kir.tanggal_kir);";
        $query=$this->db->query($totalKIR);
        return $query->result_array();
      }  

    public function rekapFrekuensiKIR($tahun)
      {
        $frekuensiKIR = "   select      to_char(kir.tanggal_kir::timestamp, 'Month') as bulan,
                                        count(kir.biaya) as total_frekuensi
                            from        ga.ga_fleet_kir as kir
                            where       extract(year from kir.tanggal_kir)='$tahun'
                                        and     kir.end_date='9999-12-12 00:00:00'
                            group by    bulan, extract(month from kir.tanggal_kir)
                            order by    extract(month from kir.tanggal_kir);";
        $query=$this->db->query($frekuensiKIR);
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