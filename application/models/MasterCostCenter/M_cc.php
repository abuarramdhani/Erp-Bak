<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_cc extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia 	= $this->load->database('personalia',TRUE);
		$this->dl 			= $this->load->database('dl_153',TRUE);
	}

	public function getSeksi($ks = false)
	{
		$sql2 = '';
		if ($ks !== false) {
			$sql2 = "and SUBSTRING(kodesie,1,7) not in ('$ks')";
		}
		$sql = "select distinct CONCAT('[',trim(unit),']  ',trim(seksi)) seksi, SUBSTRING(kodesie,1,7) kodesie
				from hrd_khs.tseksi
				where trim(seksi) != '-'
				and seksi not like '%**%'
				$sql2
				order by 1";
		return $this->personalia->query($sql)->result_array();
	}

	public function getCC()
	{
		$db  = $this->load->database('oracle', TRUE);
		$sql = "SELECT
					flex_value,
					flex_value_meaning CC,
					description DSCR,
					enabled_flag,
					flex_value_set_id
				FROM
					FND_FLEX_VALUES_VL	
				WHERE
					flex_value_set_id = 1013709
					AND enabled_flag = 'Y'
				ORDER BY
					1";
		$query = $db->query($sql);

		return $query->result_array();
	}

	public function getBranch($branch = false)
	{
		$br = '';
		if ($branch !== false) {
			$br = "AND flex_value in ('$branch')";
		}
		$db  = $this->load->database('oracle', TRUE);
		$sql = "SELECT
					flex_value,
					flex_value_meaning,
					description,
					enabled_flag
				FROM
					FND_FLEX_VALUES_VL
				WHERE
					flex_value_set_id = 1013707
					AND flex_value <> '00'
					AND enabled_flag = 'Y'
					$br
				ORDER BY
					1";
		$query = $db->query($sql);

		return $query->result_array();
	}

	public function insCC($data)
	{
		// $this->personalia->insert('hrd_khs.t_setting_cc', $data);
		$this->dl->insert('t_cost_center', $data);
	}

	public function upCC($id, $cost_center, $nama_cost_center, $branch, $jenis_akun)
	{
		$sql = "UPDATE hrd_khs.tseksi set cost_center = '$cost_center', nama_cost_center = '$nama_cost_center', branch = '$branch', jenis_akun = '$jenis_akun' where kodesie like '$id%'";
		$this->personalia->query($sql);
	}

	public function deleteCC($id)
	{
		$this->personalia->delete('hrd_khs.t_setting_cc', array('id' => $id));
		$this->dl->delete('t_cost_center', array('id' => $id));
	}

	public function getListCC($id = false)
	{
		if ($id !== false) {
			$id = "and kodesie like '$id%'";
		}
		$sql = "select
					substring(kodesie, 1, 7) kodesie,
					dept,bidang,unit,
					seksi,
					flag,
					alasan,
					cost_center,
					nama_cost_center,
					branch,
					jenis_akun
				from
					hrd_khs.tseksi
				where
					kodesie not like '%-%'
					and trim(seksi) != '-'
					$id
				group by
					substring(kodesie, 1, 7),dept,bidang,unit,
					seksi,
					flag,
					alasan,
					cost_center,
					nama_cost_center,
					branch,
					jenis_akun 
				order by
					2;";
		return $this->personalia->query($sql)->result_array();
	}

	public function cekSeksi()
	{
		$sql = "select
					distinct substring(kodesie, 1, 7) kodesie,
					unit,
					seksi
				from
					hrd_khs.tseksi
				where
					seksi not like '-'
					and seksi not like '**%'
					and substring(kodesie, 1, 7) not in (
						select seksi::varchar
					from
						hrd_khs.t_setting_cc)
				order by
					unit,
					seksi";
		return $this->personalia->query($sql)->result_array();
	}

	public function cekTcc($kodesie)
	{
		$this->dl->select('*');
		$this->dl->where('seksi', $kodesie);
		return $this->dl->get('t_cost_center')->result_array();
	}
	public function upCCdl($id, $cost_center, $nama_cost_center, $branch, $jenis_akun)
	{
		$sql = "UPDATE t_cost_center set cost_center = '$cost_center', nama_cost_center = '$nama_cost_center', branch = '$branch', jenis_akun = '$jenis_akun' where seksi like '$id%'";
		$this->dl->query($sql);
	}

	public function get_jumlah()
	{
		$sql = "select
					count(substring(kodesie,1,7)) sudah,
					(select count(substring(kodesie,1,7)) from hrd_khs.tseksi) as semua
				from
					hrd_khs.tseksi
				where
					cost_center is not null
					and cost_center != ''";
		return $this->personalia->query($sql)->row_array();
	}
}