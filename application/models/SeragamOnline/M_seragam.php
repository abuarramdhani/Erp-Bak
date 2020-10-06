<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class M_seragam extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
        $this->load->database();
	}

	public function getTipeBaju($tb, $val, $order = 'id')
	{
		$sql = "select $val from so.$tb order by $order";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function inMaster($table, $data)
	{
		if($this->db->insert('so.'.$table, $data))
			return 'oke';
		else
			return 'not oke';
	}

	public function upMaster($table, $data, $id)
	{
		$this->db->where('id', $id);
		if($this->db->update('so.'.$table, $data))
			return 'oke';
		else
			return 'not oke';
	}

	public function delMaster($table, $id)
	{
		$this->db->where('id', $id);
		if($this->db->delete('so.'.$table))
			return 'oke';
		else
			return 'not oke';
	}

	public function getJnsBaju()
	{
		$sql = "select
					tj.*,
					tp.id id_tipe,
					tp.tipe
				from
					so.tjenis_baju tj
				left join so.ttipe_baju tp on
					tj.id_tipe_baju = tp.id";
		return $this->db->query($sql)->result_array();
	}

	public function getJenisbyTipe($id_tipe)
	{
		$sql = "SELECT * FROM so.tjenis_baju
				where id_tipe_baju = $id_tipe";
		return $this->db->query($sql)->result_array();
	}

	public function listbajuMasuk()
	{
		$sql = "select
					tm.*,
					tb.tipe,
					tbu.jenis,
					tu.ukuran
				from
					so.tbaju_masuk tm
				left join so.ttipe_baju tb on
					tb.id = tm.id_tipe_baju
				left join so.tjenis_baju tbu on
					tbu.id = tm.id_jenis_baju
				left join so.tukuran tu on
					tu.id = tm.id_ukuran";
		return $this->db->query($sql)->result_array();
	}

	public function listcelanaMasuk()
	{
		$sql = "select
					tcm.*,
					tjc.jenis,
					tu.ukuran
				from
					so.tcelana_masuk tcm
				left join so.tjenis_celana tjc on
					tjc.id = tcm.id_jenis_celana
				left join so.tukuran tu on
					tu.id = tcm.id_ukuran";
		return $this->db->query($sql)->result_array();
	}

	public function listtopiMasuk()
	{
		$sql = "select
					tpm.*,
					tjp.jenis
				from
					so.ttopi_masuk tpm
				left join so.tjenis_topi tjp on
					tjp.id = tpm.id_jenis_topi";
		return $this->db->query($sql)->result_array();
	}
}