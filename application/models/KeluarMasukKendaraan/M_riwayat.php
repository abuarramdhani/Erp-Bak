<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class M_riwayat extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->db 	= 	$this->load->database('default',true);
	}

	public function riwayatDL()
	{
		$sql = "select gh.waktu, gh.status_,gh.nomor_polisi, ea.employee_name, gm.merk_kendaraan, gm2.merk_kendaraan merk, gk2.nomor_polisi nopol, string_agg(ea.employee_name,',') pic, gh.tanggal from ga.ga_fleet_histori_pemakaian gh
                                left join ga.ga_fleet_kendaraan gk on gk.nomor_polisi = gh.nomor_polisi
                                left join ga.ga_fleet_kendaraan gk2 on gk2.kendaraan_id = gh.kendaraan_id
                                left join ga.ga_fleet_merk_kendaraan gm2 on gm2.merk_kendaraan_id = gk2.merk_kendaraan_id
                                left join ga.ga_fleet_merk_kendaraan gm on gm.merk_kendaraan_id = gk.merk_kendaraan_id
				left join er.er_employee_all ea on ea.employee_code = gh.noind
				where gh.spdl_id is not null
                                group by gh.noind, gh.waktu, ea.employee_name, gm.merk_kendaraan, gm2.merk_kendaraan, gk2.nomor_polisi
                                ,gh.tanggal, gh.status_,gh.nomor_polisi
				order by gh.tanggal desc, gh.waktu desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function riwayatUm()
	{
		$sql = "select gh.*, ea.employee_name, gm.merk_kendaraan, gm2.merk_kendaraan merk, gk2.nomor_polisi nopol, gh.tanggal from ga.ga_fleet_histori_pemakaian gh
                                left join ga.ga_fleet_kendaraan gk on gk.nomor_polisi = gh.nomor_polisi
                                left join ga.ga_fleet_kendaraan gk2 on gk2.kendaraan_id = gh.kendaraan_id
                                left join ga.ga_fleet_merk_kendaraan gm2 on gm2.merk_kendaraan_id = gk2.merk_kendaraan_id
                                left join ga.ga_fleet_merk_kendaraan gm on gm.merk_kendaraan_id = gk.merk_kendaraan_id
				left join er.er_employee_all ea on ea.employee_code = gh.noind
				where gh.spdl_id is null
				order by gh.tanggal desc, gh.waktu desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}