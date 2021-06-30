<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_kronologiskk extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->personalia = $this->load->database('personalia', TRUE);
		$this->erp =	$this->load->database('erp_db', TRUE);
	}

	function getNoKPJ($noind)
	{
		$sql = "SELECT * from hrd_khs.tbpjstk t where noind = '$noind' limit 1";
		return $this->personalia->query($sql)->row_array();
	}

	function insKronologis($data)
	{
		$this->personalia->insert('"Surat".tsurat_kronologis_kecelakaan_kerja', $data);
		return $this->personalia->affected_rows() > 0;
	}

	function getAllKronologis()
	{
		$sql = "SELECT tkkk.*, trim(tp.nama) nama from \"Surat\".tsurat_kronologis_kecelakaan_kerja tkkk
				left join hrd_khs.tpribadi tp on tp.noind = tkkk.pekerja";
		return $this->personalia->query($sql)->result_array();
	}

	function getKronologisbyID($id)
	{
		$sql = "SELECT tkkk.*, trim(tp.nama) nama from \"Surat\".tsurat_kronologis_kecelakaan_kerja tkkk
				left join hrd_khs.tpribadi tp on tp.noind = tkkk.pekerja where tkkk.id = '$id'";
		return $this->personalia->query($sql)->row_array();
	}

	function upKronologiskk($data, $id)
	{
		$this->personalia->where('id', $id);
		$this->personalia->update('"Surat".tsurat_kronologis_kecelakaan_kerja', $data);
		return $this->personalia->affected_rows() > 0;
	}
}