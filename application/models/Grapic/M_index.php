<?php defined('BASEPATH') OR die('No direct script access allowed');
/**
* 
*/
class M_index extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
	}

	public function banyak($now)
	{
		$sql = "select count(noind) from hrd_khs.tpribadi where (keluar = '0' or (tglkeluar >= '2019-$now' and keluar = '1')) and (masukkerja >= '1990-01-01') and left(noind, 1) not in ('L','M','Z') and kodesie NOT LIKE '101030%' order by 1";
		// echo $sql;
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function banyakPekerja($now, $ictSql)
	{
		$sql = "select count(noind) from hrd_khs.tpribadi a where (keluar = '0' or (tglkeluar >= '2019-$now' and keluar = '1')) and (masukkerja >= '1990-01-01') and left(noind, 1) not in ('L','M','Z') $ictSql order by 1";
		// echo $sql;
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}


	public function data($term, $dept)
	{
		$sql = "select distinct rtrim(dept) from hrd_khs.tseksi;
		select distinct rtrim(seksi) seksi, substring(kodesie,0,9) kodesie 
		from hrd_khs.tseksi where dept LIKE '%$dept%' and seksi !='-' and seksi like '%$term%'";
				// echo $sql;
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function banyakPekDept($now, $ictSql, $kodeDept)
	{
		$sql = "select 
		rtrim(b.dept), count(noind)
		from hrd_khs.tpribadi a 
		left join hrd_khs.tseksi b on a.kodesie=b.kodesie
		where (keluar = '0' or (tglkeluar >= '2019-$now' and keluar = '1')) and b.dept != '-'
		and (masukkerja >= '1990-01-01') $ictSql and rtrim(b.dept) = '$kodeDept'
		group by rtrim(b.dept)
		order by 1;";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function pekerjaDepartemen($now, $kodeDept, $sqlPKL, $lokasi)
	{
		$sql = "select 
		rtrim(b.dept), count(noind)
		from hrd_khs.tpribadi a 
		left join hrd_khs.tseksi b on a.kodesie=b.kodesie
		where (keluar = '0' or (tglkeluar >= '2019-$now' and keluar = '1')) and b.dept != '-'
		and (masukkerja >= '1990-01-01') and rtrim(b.dept) = '$kodeDept' $sqlPKL $lokasi
		group by rtrim(b.dept)
		order by 1;";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function pekerjaUnit($now, $kodeUnit, $sqlPKL)
	{
		$sql = "select rtrim(b.dept), count(a.noind) 
		from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
		where (keluar = '0' or (tglkeluar >= '2019-$now' and keluar = '1')) 
		and b.unit != '-' and (masukkerja >= '1990-01-01') and rtrim(b.unit) like '%$kodeUnit%' 
		$sqlPKL
		group by rtrim(b.dept) order by 1;";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function pekerjaPasar($now, $sqlPKL, $kodeUnit)
	{
		$sql = "select rtrim(b.seksi), count(a.noind) 
		from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
		where (keluar = '0' or (tglkeluar >= '2019-$now' and keluar = '1')) 
		and b.unit != '-' and (masukkerja >= '1990-01-01') and rtrim(b.unit) = '$kodeUnit' 
		and rtrim(b.bidang) = 'PEMASARAN 6' $sqlPKL
		group by rtrim(b.seksi) order by 1;";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function pekerjacabang($now, $sqlPKL, $kodeUnit)
	{
		$sql = "select rtrim(b.seksi), count(a.noind) 
		from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
		where (keluar = '0' or (tglkeluar >= '2019-$now' and keluar = '1')) 
		and b.unit != '-' and (masukkerja >= '1990-01-01') and rtrim(b.seksi) = '$kodeUnit' 
		$sqlPKL
		group by rtrim(b.seksi) order by 1;";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function pekerjaOperator($now, $sqlPKL, $kode)
	{
		$sql = "select
		count(noind)
		from
		hrd_khs.tpribadi a 
		left join hrd_khs.tpekerjaan b on a.kd_pkj=b.kdpekerjaan
		where
		(keluar = '0' or (tglkeluar >= '2019-$now' and keluar = '1'))
		and (masukkerja <= '2019-01-26' $sqlPKL)
		and kodesie LIKE '3%' $kode
		and left(a.noind,1) in ('H','P','K')
		order by 1;";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function semuaData($now, $sqlPKL)
	{
		$sql = "select count(noind) from hrd_khs.tpribadi where (keluar = '0' or (tglkeluar >= '2019-$now' and keluar = '1')) and (masukkerja >= '1990-01-01') $sqlPKL order by 1";
		// echo $sql;
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function getData()
	{
		$sql = "select * from hrd_khs.tpribadi";
		// echo $sql;
		// exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function kosongkan()
	{
		$sql = "TRUNCATE table hrd_khs.tpribadi";
		// $query = $this->personalia->query($sql);
	}

	public function addData($dataSql)
	{
		// echo "<pre>"
		// print_r($dataSql);exit();
		$query = $this->personalia->query($dataSql);
		// $sql = "select denahrumah from hrd_khs.tpribadi where denahrumah = '' limit 1";
		// // echo $sql;
		// // exit();
		// $query = $this->personalia->query($sql);
		// return $query->result_array();
	}

	public function cekdatabase()
	{
		if ($this->load->database('personalia', TRUE)) {
			return true;
		}else{
			return false;
		}
	}
}