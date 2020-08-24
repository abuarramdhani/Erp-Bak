<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 *
 */
class M_index extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function getKotaLahir($p)
	{
		$query = "select (case when substring(nama,6,3)='ADM'
		then substring(nama,11)
		else substring(nama,6)
			end) as nama from kabupaten where nama like '%$p%'
		order by 1";
		return $this->recruitment->query($query)->result_array();
	}

	function dataKota2($q)
	{
		$sql = "select kota_id, upper(kokab_nama) kokab_nama, provinsi_id from tb_kokab where kokab_nama like '%$q%'
		order by 2";
		$query = $this->recruitment->query($sql);
		return $query->result_array();
	}

	function dataInstitusi($q)
	{
		$sql = "select distinct(nama_univ) as institusi from tb_univ where nama_univ like '%$q%' order by nama_univ";
		$to_query = $this->recruitment->query($sql);
		return $to_query->result();
	}

	function dataJurusan($q)
	{
		$sql = "select distinct(nama_jurusan) jurusan from tb_jurusan2 where nama_jurusan like '%$q%' order by nama_jurusan";
		$to_query = $this->recruitment->query($sql);
		return $to_query->result();
	}

	function dataPenempatan($q)
	{
		$sql = "select id, upper(penempatan) as penempatan from tb_penempatan where penempatan like '%$q%' order by id";
		$to_query = $this->recruitment->query($sql);
		return $to_query->result();
	}

	function getIdPenempatan($penempatan)
	{
		$query = "select id from tb_penempatan where penempatan='$penempatan'";
		$data = $this->recruitment->query($query);
		return $data->result_array();
	}

	function dataJenjang($q)
	{
		$query = "select * from tb_jenjang where jenjang like '%$q%'";
		$data = $this->recruitment->query($query);
		return $data->result_array();
	}

	function pekerjaan_j($p, $id)
	{
		$query = "select upper(j.job_nama) job_nama from tb_data_job_available ja inner join tb_job j on ja.id_job=j.id where ja.id_penempatan='$id' and j.job_nama like '%$p%' order by 1";
		$data =  $this->recruitment->query($query);
		return $data->result_array();
	}

	public function insertBiodata($data)
	{
		$this->recruitment->insert('fr_biodata', $data);
		return true;
	}

	public function insertAkun($akun)
	{
		$this->recruitment->insert('tb_account', $akun);
		return true;
	}

	public function checkBiodata($nik)
	{
		$this->recruitment->select('*');
		$this->recruitment->from('fr_biodata');
		$this->recruitment->where('no_id', $nik);
		$query = $this->recruitment->get();
		return $query->num_rows();
	}

	public function checkAccount($nik)
	{
		$this->recruitment->select('*');
		$this->recruitment->from('tb_account');
		$this->recruitment->where('no_id', $nik);
		$query = $this->recruitment->get();
		return $query->num_rows();
	}
}
