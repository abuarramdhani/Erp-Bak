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
        $rekapPajak = "     select      to_char(pjk.tanggal_pajak::timestamp, 'Month') as bulan,
                                        sum(pjk.biaya) as total_biaya
                            from        ga.ga_fleet_pajak as pjk
                            where       extract(year from pjk.tanggal_pajak)='$tahun'
                                        and     pjk.end_date='9999-12-12 00:00:00'
                            group by    bulan, extract(month from pjk.tanggal_pajak)
                            order by    extract(month from pjk.tanggal_pajak);";
        $query=$this->db->query($rekapPajak);
        return $query->result_array();
      }  

    public function rekapFrekuensiPajak($tahun)
      {
        $rekapPajak = "     select      to_char(pjk.tanggal_pajak::timestamp, 'Month') as bulan,
                                        count(pjk.biaya) as total_frekuensi
                            from        ga.ga_fleet_pajak as pjk
                            where       extract(year from pjk.tanggal_pajak)='$tahun'
                                        and     pjk.end_date='9999-12-12 00:00:00'
                            group by    bulan, extract(month from pjk.tanggal_pajak)
                            order by    extract(month from pjk.tanggal_pajak);";
        $query=$this->db->query($rekapPajak);
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