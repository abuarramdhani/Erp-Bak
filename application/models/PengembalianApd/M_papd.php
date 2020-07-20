<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class M_papd extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->personalia   =   $this->load->database('personalia', TRUE) ;
        $this->erp          =   $this->load->database('erp_db', TRUE);
        $this->oracle       =   $this->load->database('oracle', TRUE);
	}

	public function ListSemuaPkjTpribadi($param)
	{
		$this->personalia->like('noind', $param);
		$this->personalia->or_like('nama', $param);
		$this->personalia->limit(10);
		return $this->personalia->get('hrd_khs.tpribadi')->result_array();
	}

	public function insertAPD($data)
	{
		$this->personalia->insert('"Surat".tpengembalian_apd', $data);
		return $this->personalia->insert_id();
	}

	public function updateAPD($data, $id)
	{
		$this->personalia->where('id', $id);
		$this->personalia->update('"Surat".tpengembalian_apd', $data);
		return $this->personalia->affected_rows() > 0;
	}

	public function insertAPDdetail($data)
	{
		$this->personalia->insert_batch('"Surat".tpengembalian_apd_detail', $data);
	}

	public function getListPengembalian()
	{
		$sql = "SELECT
					ta.*,
					trim(tp.nama) nama,
					trim(ts.seksi) seksi,
					case
						when ta.status = 0 then 'New'
						when ta.status = 1 then 'Approved'
						when ta.status = 2 then 'Rejected' end as stat
				from
					\"Surat\".tpengembalian_apd ta
				left join hrd_khs.tpribadi tp on
					tp.noind = ta.noind
				left join hrd_khs.tseksi ts on
					ts.kodesie = tp.kodesie
					order by ta.id desc";
		return $this->personalia->query($sql)->result_array();
	}

	public function getListPengembalianPekerja($ks)
	{
		$sql = "SELECT
					ta.*,
					trim(tp.nama) nama,
					trim(ts.seksi) seksi,
					(select count(*) from \"Surat\".tpengembalian_apd_detail where id_apd = ta.id) item,
					case
						when ta.status = 0 then 'New'
						when ta.status = 1 then 'Approved'
						when ta.status = 2 then 'Rejected' end as stat
				from
					\"Surat\".tpengembalian_apd ta
				left join hrd_khs.tpribadi tp on
					tp.noind = ta.noind
				left join hrd_khs.tseksi ts on
					ts.kodesie = tp.kodesie
					where tp.kodesie like '$ks%'
					order by ta.id desc";
					// echo $sql; exit();
		return $this->personalia->query($sql)->result_array();
	}

	public function getListPengembalianbyStat($stat)
	{
		$sql = "SELECT
					ta.*,
					trim(tp.nama) nama,
					trim(ts.seksi) seksi,
					case
						when ta.status = 0 then 'New'
						when ta.status = 1 then 'Approved'
						when ta.status = 2 then 'Rejected' end as stat
				from
					\"Surat\".tpengembalian_apd ta
				left join hrd_khs.tpribadi tp on
					tp.noind = ta.noind
				left join hrd_khs.tseksi ts on
					ts.kodesie = tp.kodesie where ta.status = $stat";
		return $this->personalia->query($sql)->result_array();
	}

	public function getListPengembalianById($id)
	{
		$sql = "SELECT
					ta.*,
					trim(tp.nama) nama,
					trim(ts.seksi) seksi,
					case
						when ta.status = 0 then 'New'
						when ta.status = 1 then 'Approved'
						when ta.status = 2 then 'Rejected' end as stat
				from
					\"Surat\".tpengembalian_apd ta
				left join hrd_khs.tpribadi tp on
					tp.noind = ta.noind
				left join hrd_khs.tseksi ts on
					ts.kodesie = tp.kodesie
				where ta.id = $id";
		return $this->personalia->query($sql)->result_array();
	}

	public function getListAPDbyID($id)
	{
		$this->personalia->where('id_apd', $id);
		$this->personalia->order_by('id', 'ASC');
		return $this->personalia->get('"Surat".tpengembalian_apd_detail')->result_array();
	}

	public function deleteAPDdetail($id)
	{
		$this->personalia->where('id_apd', $id);
		$this->personalia->delete('"Surat".tpengembalian_apd_detail');
		return $this->personalia->affected_rows() > 0;
	}

	public function deleteAPDdata($id)
	{
		$this->personalia->where('id', $id);
		$this->personalia->delete('"Surat".tpengembalian_apd');
		return $this->personalia->affected_rows() > 0;
	}

	public function countStatusApd($status)
	{
		$sql = "select count(*) jumlah from \"Surat\".tpengembalian_apd where status = $status";
		return $this->personalia->query($sql)->row()->jumlah;
	}
}