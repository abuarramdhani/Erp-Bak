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
		$sql = "
		select rtrim(dept),count(*)	from 
				(
				select distinct nik, nama ,dept,bidang,unit,seksi 
				from
				(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((keluar = '0' and masukkerja<='2019-$now'))
				and (masukkerja >= '1990-01-01') and rtrim(b.dept) = '$kodeDept' $sqlPKL $lokasi 
				union 
				select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and (masukkerja >= '1990-01-01') and rtrim(b.dept) = '$kodeDept' $sqlPKL $lokasi 
				 order by 5
				 ) tabel ) tabel group by rtrim(dept)";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function pekerjaUnit($now, $kodeUnit, $sqlPKL)
	{
		$sql = "
		select rtrim(dept),count(*)	from 
				(
				select distinct nik,nama,dept,bidang,unit,seksi 
				from
				(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((keluar = '0' and masukkerja<='2019-$now'))
				and b.unit != '-' and (masukkerja >= '1990-01-01') and rtrim(b.unit) like '%$kodeUnit%'  $sqlPKL
				union 
				select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and b.unit != '-' and (masukkerja >= '1990-01-01') and rtrim(b.unit) like '%$kodeUnit%'  $sqlPKL
				 ) tabel ) tabel group by rtrim(dept)";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function pekerjaSeksi($now, $kodeSeksi, $sqlPKL)
	{
		$sql = "
		select rtrim(seksi),count(*)	from 
				(
				select distinct nik, nama ,dept,bidang,unit,seksi 
				from
				(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((keluar = '0' and masukkerja<='2019-$now'))
				and (masukkerja >= '1990-01-01') and rtrim(b.seksi) = '$kodeSeksi' $sqlPKL 
				union 
				select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and (masukkerja >= '1990-01-01') and rtrim(b.seksi) = '$kodeSeksi' $sqlPKL
				 order by 5
				 ) tabel ) tabel group by rtrim(seksi)";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function pekerjaPasar($now, $sqlPKL, $kodeUnit)
	{
		$sql = "select rtrim(b.seksi), count(a.noind) 
		from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
		where (keluar = '0' or (tglkeluar >= '2019-$now' and keluar = '1')) 
		and b.unit != '-' and (masukkerja >= '1990-01-01') and rtrim(b.seksi) = '$kodeUnit' 
		and rtrim(b.bidang) = 'PEMASARAN 6' $sqlPKL
		group by rtrim(b.seksi) order by 1;";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function pekerjacabang($now, $sqlPKL, $kodeUnit)
	{
		$sql = "
		select count(*)	from 
				(
				select distinct nik, nama ,dept,bidang,unit,seksi 
				from
				(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((keluar = '0' and masukkerja<='2019-$now'))
				and b.unit != '-' and (masukkerja >= '1990-01-01') and rtrim(b.seksi) like '%$kodeUnit%'  $sqlPKL
				union
				select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and b.unit != '-' and (masukkerja >= '1990-01-01') and rtrim(b.seksi) like '%$kodeUnit%'  $sqlPKL
				 ) tabel ) tabel";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function pekerjanoncivil($now, $sqlPKL, $kodeUnit)
	{
		$sql = "select count(*)	from 
				(
				select distinct nama as nama ,dept,bidang,unit,seksi 
				from
				(select a.noind,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((keluar = '0' and masukkerja<='2019-$now') or (tglkeluar >= '2019-$now' and keluar = '1'))
				and b.unit != '-' and (masukkerja >= '1990-01-01') and left(b.kodesie,1)='4' and rtrim(b.seksi) not like '%$kodeUnit%'  $sqlPKL
				 order by 5
				 ) tabel ) tabel";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function pekerjaOperator($now, $sqlPKL, $kode)
	{
		$sql = "
		select count(*)	from 
				(
				select distinct nik,nama ,dept,bidang,unit,seksi 
				from
				(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,c.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi c on a.kodesie=c.kodesie 
				left join hrd_khs.tpekerjaan b on a.kd_pkj=b.kdpekerjaan
				where ((keluar = '0' and masukkerja<='2019-$now'))
				and (masukkerja >= '1990-01-01') $sqlPKL and c.kodesie LIKE '3%' $kode and left(a.noind,1) in ('H','P','K','T','A')
				union 
				select a.noind,nik,nama,masukkerja,tglkeluar,keluar,c.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi c on a.kodesie=c.kodesie 
				left join hrd_khs.tpekerjaan b on a.kd_pkj=b.kdpekerjaan
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and (masukkerja >= '1990-01-01') $sqlPKL and c.kodesie LIKE '3%' $kode and left(a.noind,1) in ('H','P','K','T','A')
				 order by 5
				 ) tabel ) tabel";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function pekerjaOperatorAll($now, $sqlPKL, $kode)
	{
		$sql = "
		select count(*)	from 
				(
				select distinct nik, nama ,dept,bidang,unit,seksi 
				from
				(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,c.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi c on a.kodesie=c.kodesie 
				left join hrd_khs.tpekerjaan b on a.kd_pkj=b.kdpekerjaan
				where ((keluar = '0' and masukkerja<='2019-$now'))
				and (masukkerja >= '1990-01-01') $sqlPKL $kode and left(a.noind,1) in ('H','P','K','T','A')
				union
				select a.noind,nik,nama,masukkerja,tglkeluar,keluar,c.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi c on a.kodesie=c.kodesie 
				left join hrd_khs.tpekerjaan b on a.kd_pkj=b.kdpekerjaan
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and (masukkerja >= '1990-01-01') $sqlPKL $kode and left(a.noind,1) in ('H','P','K','T','A')
				 order by 5
				 ) tabel ) tabel";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function semuaData($now, $sqlPKL)
	{
		$sql = "
		select count(*)	from 
				(
				select distinct nik,nama ,dept,bidang,unit,seksi 
				from
				(select a.noind,a.nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((keluar = '0' and masukkerja<='2019-$now'))
				and (masukkerja >= '1990-01-01') $sqlPKL 
				union
				select a.noind,a.nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and (masukkerja >= '1990-01-01') $sqlPKL 

				 ) tabel ) tabel";

		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function getData()
	{
		$sql = "select * from hrd_khs.tpribadi where tglkeluar >= '2019-01-01' or masukkerja >= '2018-01-01'";
		// $sql = "select * from hrd_khs.tpribadi where tglkeluar >= '2019-01-01'";
		// echo $sql;
		// exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function getDatav2()
	{
		$sql = "select noind, kodesie, tglkeluar, keluar from hrd_khs.tpribadi where tglkeluar >= '2019-01-01' and keluar = '0';";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function kosongkan()
	{
		// $sql = "TRUNCATE table hrd_khs.tpribadi";
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

	public function cekNoind($val)
	{
		$sql = "select * from hrd_khs.tpribadi where noind = '$val'";
		$query = $this->personalia->query($sql);
		return $query->num_rows();
	}

	public function hapus($noind)
	{
		$sql = "delete from hrd_khs.tpribadi where noind = '$noind'";
		// echo $sql;exit();
		$query = $this->personalia->query($sql);
	}

	public function hapusList($noindList)
	{
		$sql = "delete from hrd_khs.tpribadi where noind in ($noindList)";
		// echo $sql;exit();
		$query = $this->personalia->query($sql);
	}

	public function getTrend($tahun, $pkl)
	{
		$sql = "
		select 1 as urut,'Januari' as Bulan, 
(select count(*)	from 
	(
	select distinct nik, nama ,dept,bidang,unit,seksi 
	from
	(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((keluar = '0' and masukkerja<='$tahun-01-01'))
	and (masukkerja >= '1990-01-01') $pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-01-01') and (tglkeluar >= '$tahun-01-01' and keluar = '1'))
	and (masukkerja >= '1990-01-01') $pkl
	 ) tabel ) tabel) as tahun
union
select 2 as urut,'Februari' as Bulan, 
(select count(*)	from 
	(
	select distinct nik, nama ,dept,bidang,unit,seksi 
	from
	(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((keluar = '0' and masukkerja<='$tahun-02-01'))
	and (masukkerja >= '1990-01-01') $pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-02-01') and (tglkeluar >= '$tahun-02-01' and keluar = '1'))
	and (masukkerja >= '1990-01-01') $pkl
	 ) tabel ) tabel) as tahun
union
select 3 as urut,'Maret' as Bulan, 
(select count(*)	from 
	(
	select distinct nik, nama ,dept,bidang,unit,seksi 
	from
	(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((keluar = '0' and masukkerja<='$tahun-03-01'))
	and (masukkerja >= '1990-01-01') $pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-03-01') and (tglkeluar >= '$tahun-03-01' and keluar = '1'))
	and (masukkerja >= '1990-01-01') $pkl
	 ) tabel ) tabel) as tahun
union
select 4 as urut,'April' as Bulan, 
(select count(*)	from 
	(
	select distinct nik, nama ,dept,bidang,unit,seksi 
	from
	(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((keluar = '0' and masukkerja<='$tahun-04-01'))
	and (masukkerja >= '1990-01-01') $pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-04-01') and (tglkeluar >= '$tahun-04-01' and keluar = '1'))
	and (masukkerja >= '1990-01-01') $pkl
	 ) tabel ) tabel) as tahun
union
select 5 as urut,'Mei' as Bulan, 
(select count(*)	from 
	(
	select distinct nik, nama ,dept,bidang,unit,seksi 
	from
	(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((keluar = '0' and masukkerja<='$tahun-05-01'))
	and (masukkerja >= '1990-01-01') $pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-05-01') and (tglkeluar >= '$tahun-05-01' and keluar = '1'))
	and (masukkerja >= '1990-01-01') $pkl
	 ) tabel ) tabel) as tahun
union
select 6 as urut,'Juni' as Bulan, 
(select count(*)	from 
	(
	select distinct nik, nama ,dept,bidang,unit,seksi 
	from
	(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((keluar = '0' and masukkerja<='$tahun-06-01'))
	and (masukkerja >= '1990-01-01') $pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-06-01') and (tglkeluar >= '$tahun-06-01' and keluar = '1'))
	and (masukkerja >= '1990-01-01') $pkl
	 ) tabel ) tabel) as tahun
union
select 7 as urut,'Juli' as Bulan, 
(select count(*)	from 
	(
	select distinct nik, nama ,dept,bidang,unit,seksi 
	from
	(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((keluar = '0' and masukkerja<='$tahun-07-01'))
	and (masukkerja >= '1990-01-01') $pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-07-01') and (tglkeluar >= '$tahun-07-01' and keluar = '1'))
	and (masukkerja >= '1990-01-01') $pkl
	 ) tabel ) tabel) as tahun
union
select 8 as urut,'Agustus' as Bulan, 
(select count(*)	from 
	(
	select distinct nik, nama ,dept,bidang,unit,seksi 
	from
	(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((keluar = '0' and masukkerja<='$tahun-08-01'))
	and (masukkerja >= '1990-01-01') $pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-08-01') and (tglkeluar >= '$tahun-08-01' and keluar = '1'))
	and (masukkerja >= '1990-01-01') $pkl
	 ) tabel ) tabel) as tahun
union
select 9 as urut,'September' as Bulan, 
(select count(*)	from 
	(
	select distinct nik, nama ,dept,bidang,unit,seksi 
	from
	(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((keluar = '0' and masukkerja<='$tahun-09-01'))
	and (masukkerja >= '1990-01-01') $pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-09-01') and (tglkeluar >= '$tahun-09-01' and keluar = '1'))
	and (masukkerja >= '1990-01-01') $pkl
	 ) tabel ) tabel) as tahun
union
select 10 as urut,'Oktober' as Bulan, 
(select count(*)	from 
	(
	select distinct nik, nama ,dept,bidang,unit,seksi 
	from
	(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((keluar = '0' and masukkerja<='$tahun-10-01'))
	and (masukkerja >= '1990-01-01') $pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-10-01') and (tglkeluar >= '$tahun-10-01' and keluar = '1'))
	and (masukkerja >= '1990-01-01') $pkl
	 ) tabel ) tabel) as tahun
union
select 11 as urut,'November' as Bulan, 
(select count(*)	from 
	(
	select distinct nik, nama ,dept,bidang,unit,seksi 
	from
	(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((keluar = '0' and masukkerja<='$tahun-11-01'))
	and (masukkerja >= '1990-01-01') $pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-11-01') and (tglkeluar >= '$tahun-11-01' and keluar = '1'))
	and (masukkerja >= '1990-01-01') $pkl
	 ) tabel ) tabel) as tahun
union
select 12 as urut,'Desember' as Bulan, 
(select count(*)	from 
	(
	select distinct nik, nama ,dept,bidang,unit,seksi 
	from
	(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((keluar = '0' and masukkerja<='$tahun-12-01'))
	and (masukkerja >= '1990-01-01') $pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-12-01') and (tglkeluar >= '$tahun-12-01' and keluar = '1'))
	and (masukkerja >= '1990-01-01') $pkl
	 ) tabel ) tabel) as tahun
order by 1
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

}