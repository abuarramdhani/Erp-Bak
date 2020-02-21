<?php
/**
* 
*/
class M_sweep extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia', true);
		$this->sweeping = $this->load->database('sweeping', true);
	}

	public function getDataUser($string)
	{
		$sql = "SELECT tp.noind, tp.nama,
				case when ts.seksi = '-' then ts.unit
				when ts.seksi != '-' then ts.seksi end seksi
				FROM hrd_khs.tpribadi tp, hrd_khs.tseksi ts
				where tp.kodesie = ts.kodesie
				and tp.noind like '$string%'";
		$query = $this->personalia->query($sql);

		return $query->result_array();
	}

	public function getDescriptionUser($noInduk)
	{
		$sql = "SELECT tp.noind, tp.nama, tp.email_internal, tp.pidgin_account,
				case when ts.seksi = '-' then ts.unit
				when ts.seksi != '-' then ts.seksi end seksi
				FROM hrd_khs.tpribadi tp, hrd_khs.tseksi ts
				where tp.kodesie = ts.kodesie
				and tp.noind = '$noInduk'";
		$query = $this->personalia->query($sql);

		return $query->result_array();
	}

	public function saveDataUmum($dataUmum)
	{
		$this->sweeping->insert('data_umum', $dataUmum);
	}

	public function getData()
	{
		$query = $this->sweeping->get('data_umum');

		return $query->result_array();
	}

	public function getDetailData($checkId)
	{
		$query = $this->sweeping->where('check_id', $checkId);
		return $this->sweeping->get('data_umum')->result_array();
	}

	public function deleteKey($checkId)
	{
		$query = $this->sweeping->set('windows_key', '');
		$query = $this->sweeping->where('check_id', $checkId);
		$query = $this->sweeping->update('data_umum');
	}

	public function getSlc()
	{
		$sql = "SELECT bajakan_1,bajakan_2,bajakan_3,bajakan_4,bajakan_5,bajakan_6,bajakan_7,bajakan_8,bajakan_9,bajakan_10 FROM data_umum";
		$query = $this->sweeping->query($sql);
		return $query->result_array();
	}

	public function updateDataUmum($check_id, $dataUmum)
	{
		$this->sweeping->where('check_id', $check_id);
		$this->sweeping->update('data_umum', $dataUmum);
	}

	public function insertHistory($imArr, $values)
	{
		$sql = "INSERT into data_umum_history ($imArr) values ('$values');";
		$this->sweeping->query($sql);
	}
}