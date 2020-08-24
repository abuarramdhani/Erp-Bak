<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class M_rekapkecelakaan extends CI_Model
{
	
	function __construct()
	{
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);
	}

	public function rkGetKecelakaan($awal, $akhir)
	{
		$sql = "SELECT
					tk.*,
					trim(tp.nama) nama,
					ts.seksi,
					ts.dept,
					tp.keluar
				from
					hrd_khs.tkecelakaan_kerja tk
				left join hrd_khs.tpribadi tp on
					tp.noind = tk.noind
				left join hrd_khs.tseksi ts on
					ts.kodesie = tk.kodesie
				where
					tk.tanggal::date between '$awal' and '$akhir'
				order by tk.id_rkk desc";
		return $this->personalia->query($sql)->result_array();
	}

	public function getLastrck()
	{
		$sql = "SELECT max(id_rkk) id from hrd_khs.tkecelakaan_kerja";
		return $this->personalia->query($sql)->row()->id+1;
	}

	public function addrkc($data)
	{
		$this->personalia->insert('hrd_khs.tkecelakaan_kerja', $data);
		return $this->personalia->affected_rows() > 0;
	}

	public function delrkkc($id)
	{
		$this->personalia->where('id_rkk', $id);
		$this->personalia->delete('hrd_khs.tkecelakaan_kerja');
		return $this->personalia->affected_rows() > 0;
	}

	public function getRkk($id)
	{
		$sql = "SELECT
					tk.*,
					trim(tp.nama) nama,
					ts.seksi,
					ts.dept
				from
					hrd_khs.tkecelakaan_kerja tk
				left join hrd_khs.tpribadi tp on
					tp.noind = tk.noind
				left join hrd_khs.tseksi ts on
					ts.kodesie = tk.kodesie
				where
					tk.id_rkk = '$id'";
		return $this->personalia->query($sql)->result_array();
	}

	public function up_rkkc($data, $id)
	{
		$this->personalia->where('id_rkk', $id);
		$this->personalia->update('hrd_khs.tkecelakaan_kerja', $data);
		return $this->personalia->affected_rows() > 0;
	}

	public function insrkklog($data)
	{
		$this->personalia->insert('hrd_khs.tlog', $data);
	}
}