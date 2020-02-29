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
				where seksi not like '-%'
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
		$this->db->insert('cs.t_setting_cc', $data);
		$this->dl->insert('t_cost_center', $data);
	}

	public function upCC($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('cs.t_setting_cc', $data);
		
		$this->dl->where('id', $id);
		$this->dl->update('t_cost_center', $data);
	}

	public function deleteCC($id)
	{
		$this->db->delete('cs.t_setting_cc', array('id' => $id));
		$this->dl->delete('t_cost_center', array('id' => $id));
	}

	public function getListCC($id = false)
	{
		if ($id !== false) {
			$id = "where id in ('$id')";
		}
		$sql = "select
					tc.*,
					(
					select
						section_name
					from
						er.er_section es
					where
						substring(es.section_code::text, 1, 7) = tc.seksi::text
					limit 1) nama_seksi,
					null nama_branch
				from
					cs.t_setting_cc tc
				$id;";
		return $this->db->query($sql)->result_array();
	}

	public function cekSeksi()
	{
		$sql = "select
					distinct substring(section_code, 1, 7) kodesie,
					unit_name unit,
					section_name seksi
				from
					er.er_section
				where
					section_name not like '-'
					and section_name not like '**%'
					and substring(section_code, 1, 7) not in (
						select seksi::varchar
					from
						cs.t_setting_cc)
				order by
					unit_name,
					section_name";
		return $this->db->query($sql)->result_array();
	}
}