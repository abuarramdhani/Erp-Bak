<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_ordermobile extends CI_Model
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->database();
			$this->db2 = $this->load->database('dl_153', true);
		}

	function check($no_order)
		{
			$sql ="SELECT * FROM sm.sm_order where no_order = '$no_order'";
			$query = $this->db->query($sql);
			return $query->num_rows();
		}

	function Update($tgl_terima, $no_order)
		{
			$sql = "update sm.sm_order set status=1, tgl_terima='$tgl_terima' where no_order='$no_order'";
			$query = $this->db->query($sql);
		}
	public function dataKenaraan($nopol)
	{
		$sql = "select gk.nomor_polisi, gj.jenis_kendaraan, gm.merk_kendaraan
				from ga.ga_fleet_kendaraan gk
				inner join ga.ga_fleet_jenis_kendaraan gj on gj.jenis_kendaraan_id = gk.jenis_kendaraan_id
				inner join ga.ga_fleet_merk_kendaraan gm on gm.merk_kendaraan_id = gk.merk_kendaraan_id
				where gk.nomor_polisi = '$nopol'
				order by gk.tahun_pembuatan desc limit 1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function kend_id($nopol)
	{
		$sql = "select * from ga.ga_fleet_kendaraan where nomor_polisi = '$nopol'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function user_id($noind)
	{
		$sql = "select user_id from sys.sys_user where user_name = '$noind';";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function spdl_id($noind)
	{
	$sql = "select spdl_id from t_surat_perintah_dl where request_approve_realisasi = '0' and draft_approved = '1' and noind = '$noind'";
	$query = $this->db2->query($sql);

	return $query->result_array();		
	}

	public function simpan($input)
	{
		$this->db->insert('"ga".ga_fleet_histori_pemakaian', $input);
		return true;
	}

	public function riwayat($tgl)
	{
		$sql = "select gh.*, ea.employee_name, gm.merk_kendaraan, gm2.merk_kendaraan merk, gk2.nomor_polisi nopol from ga.ga_fleet_histori_pemakaian gh
                                left join ga.ga_fleet_kendaraan gk on gk.nomor_polisi = gh.nomor_polisi
                                left join ga.ga_fleet_kendaraan gk2 on gk2.kendaraan_id = gh.kendaraan_id
                                left join ga.ga_fleet_merk_kendaraan gm2 on gm2.merk_kendaraan_id = gk2.merk_kendaraan_id
                                left join ga.ga_fleet_merk_kendaraan gm on gm.merk_kendaraan_id = gk.merk_kendaraan_id
				left join er.er_employee_all ea on ea.employee_code = gh.noind
				where gh.tanggal = '$tgl' and gh.spdl_id is null
				order by gh.tanggal desc, gh.waktu desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function riwayatDinas($tgl)
	{
		$sql = "select gh.waktu, gh.status_,gh.nomor_polisi, ea.employee_name, gm.merk_kendaraan, gm2.merk_kendaraan merk, gk2.nomor_polisi nopol, string_agg(ea.employee_name,',') pic from ga.ga_fleet_histori_pemakaian gh
                                left join ga.ga_fleet_kendaraan gk on gk.nomor_polisi = gh.nomor_polisi
                                left join ga.ga_fleet_kendaraan gk2 on gk2.kendaraan_id = gh.kendaraan_id
                                left join ga.ga_fleet_merk_kendaraan gm2 on gm2.merk_kendaraan_id = gk2.merk_kendaraan_id
                                left join ga.ga_fleet_merk_kendaraan gm on gm.merk_kendaraan_id = gk.merk_kendaraan_id
				left join er.er_employee_all ea on ea.employee_code = gh.noind
				where gh.tanggal = '$tgl' and gh.spdl_id is not null
                                group by gh.noind, gh.waktu, ea.employee_name, gm.merk_kendaraan, gm2.merk_kendaraan, gk2.nomor_polisi
                                ,gh.tanggal, gh.status_,gh.nomor_polisi
				order by gh.tanggal desc, gh.waktu desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function getAllpekerja()
	{
		$sql = "select RTRIM(concat(employee_code, ' - ', employee_name)) pekerja from er.er_employee_all where resign = '0'";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getNoind($pj)
	{
		$sql = "SELECT CASE WHEN COUNT(1) > 0 THEN S.noind ELSE 'null' END AS noinduk
				FROM t_surat_perintah_dl S
				WHERE S.spdl_id = '$pj'";

		$query = $this->db2->query($sql);
		return $query->result_array();
	}

	public function verify_spdl($pj)
	{
		$sql = "select CASE WHEN COUNT(1) > 0 THEN spdl_id ELSE 'null' END AS spdl_id 
				from t_surat_perintah_dl 
				where request_approve_realisasi = '0' and draft_approved = '1' and spdl_id = '$pj'";

		$query = $this->db2->query($sql);
		return $query->result_array();
	}
}