<?php
Defined('BASEPATH') or exit("No Direct Script Access Allowed");

/**
 * 
 */
class M_datavaksinasi extends CI_Model
{
	
	function __construct()
	{
		$this->personalia = $this->load->database('personalia', true);
	}

	public function getData()
	{
		$query = "Select * from 
			hrd_khs.tvaksinasi
			order by tanggal_input desc";
		return $this->personalia->query($query)->result_array();
	}

	public function getPekerjaBykey($key)
	{
		$query = "select noind,nama 
			from hrd_khs.tpribadi
			where keluar = '0'
			and (
				noind like upper(concat(?,'%'))
				or nama like upper(concat('%',?,'%'))
			)";
		return $this->personalia->query($query,[$key,$key])->result_array();
	}

	public function getPesertaByNoindKey($noind,$key)
	{
		$query = "select *
			from (
			    select noind, nama, nik
			    from hrd_khs.tkeluarga
			    union
			    select noind, nama, nik
			    from hrd_khs.tpribadi
			) tbl
			where noind=?
			and (
			    nik like upper(concat(?,'%'))
				or nama like upper(concat('%',?,'%'))
			)";
		return $this->personalia->query($query,[$noind,$key,$key])->result_array();
	}

	public function getKelompok()
	{
		$query = "select *
			from hrd_khs.tkelompok_vaksinasi
			order by tanggal_vaksin asc";
		return $this->personalia->query($query)->result_array();
	}

	public function getJenis()
	{
		$query = "select *
			from hrd_khs.tjenis_vaksin
			order by nama_vaksin asc";
		return $this->personalia->query($query)->result_array();
	}

	public function getKelompokById($id)
	{
		$query = "select *
			from hrd_khs.tkelompok_vaksinasi
			where id = ?";
		return $this->personalia->query($query,[$id])->row();
	}

	public function insertDataVaksinasi($data)
	{
		$this->personalia->insert("hrd_khs.tvaksinasi",$data);
		return $this->personalia->insert_id();
	}

	public function insertLog($log)
	{
		$this->personalia->insert("hrd_khs.tlog",$log);
	}

	public function deleteDataVaksinasiById($id)
	{
		$this->personalia
			->where('id',$id)
			->delete("hrd_khs.tvaksinasi");
	}
}