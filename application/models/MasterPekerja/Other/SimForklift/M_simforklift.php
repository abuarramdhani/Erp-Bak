<?php
defined('BASEPATH') or exit('No Direct Script Access ALlowed');
/**
 *
 */
class M_simforklift extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	function getPekerjaByKey($key){
		$sql = "select noind,trim(nama) as nama
			from hrd_khs.tpribadi
			where (
				noind like concat(?,'%')
				or lower(nama) like lower(concat('%',?,'%'))
			)	
			and keluar = '0'
			order by noind";
		return $this->personalia->query($sql,array($key,$key))->result_array();
	}

	function getPekerjaByNoind($noind){
		$sql = "select tp.noind,trim(tp.nama) as nama,trim(ts.seksi) as seksi
			from hrd_khs.tpribadi tp 
			left join hrd_khs.tseksi ts 
			on tp.kodesie = ts.kodesie
			where noind = ?";
		return $this->personalia->query($sql,array($noind))->row();
	}

	function insertSimForklift($data){
		$this->personalia->insert('"Surat".t_sim_forklift',$data);
	}

	function getSimForkliftAll(){
		$sql = "select *
			from \"Surat\".t_sim_forklift";
		return $this->personalia->query($sql)->result_array();
	}

	function getSimForkliftById($id){
		$sql = "select a.*,trim(b.photo) as photo
			from \"Surat\".t_sim_forklift a 
			left join hrd_khs.tpribadi b 
			on a.noind = b.noind
			where id_sim = ?";
		return $this->personalia->query($sql, array($id))->row();
	}

}
?>