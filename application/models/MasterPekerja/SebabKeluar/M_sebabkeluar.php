<?php 
defined("BASEPATH") or exit("No Direct Script Access Allowed");

/**
 * 
 */
class M_sebabkeluar extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->erp = $this->load->database('erp_db', true);
		$this->personalia = $this->load->database('personalia', true);
	}

	function getSebabKeluarAll()
	{
		$sql = "select *
			from hrd_khs.t_sebab_keluar
			order by urutan";
		return $this->personalia->query($sql)->result_array();
	}

	function getSebabKeluarById($id)
	{
		$sql = "select *,
				(
					select count(*)
					from hrd_khs.tpribadi b
					where trim(b.sebabklr) = a.kode
				) as digunakan
			from hrd_khs.t_sebab_keluar a
			where id = ?";
		return $this->personalia->query($sql,array($id))->row();
	}

	function updateSebabKeluarById($data,$id)
	{
		$this->personalia->where('id',$id);
		$this->personalia->update("hrd_khs.t_sebab_keluar", $data);
	}

	function insertSebabKeluar($data)
	{
		$this->personalia->insert("hrd_khs.t_sebab_keluar", $data);
	}

	function insertLog($action,$data)
	{
		$user = $this->session->user;
		$ip = $_SERVER['REMOTE_ADDR'];
		$sql = "INSERT INTO sys.sys_log_activity 
			(log_time, log_user, log_aksi, log_detail, ip_address) 
			VALUES(
				current_timestamp, 
				'$user', 
				'Master Pekerja => Setup Master => Sebab Keluar => $action', 
				'$data', 
				'$ip')";
		$this->erp->query($sql);
	}

	function updateUrutanBetween($awal,$akhir,$action)
	{
		$sql = "update hrd_khs.t_sebab_keluar
			set urutan = urutan $action 1
			where urutan between $awal and $akhir";
		$this->personalia->query($sql);
	}

	function updateUrutanAfter($urutan)
	{
		$sql = "update hrd_khs.t_sebab_keluar
			set urutan = urutan + 1
			where urutan >= $urutan";
		$this->personalia->query($sql);
	}

	function getSebabKeluarByUrutan($urutan)
	{
		$sql = "select *
			from hrd_khs.t_sebab_keluar
			where urutan = $urutan";
		return $this->personalia->query($sql)->result_array();
	}

}