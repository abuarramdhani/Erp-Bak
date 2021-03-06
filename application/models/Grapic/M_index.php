<?php defined('BASEPATH') OR die('No direct script access allowed');

class M_index extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	public function banyak($now)
	{
		$sql = "select count(noind) from hrd_khs.tpribadi where (keluar = '0' or (tglkeluar >= '2019-$now' and keluar = '1')) and left(noind, 1) not in ('L','M','Z') and kodesie NOT LIKE '101030%' order by 1";
		// echo $sql;
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function banyakPekerja($now, $ictSql)
	{
		$sql = "select count(noind) from hrd_khs.tpribadi a where (keluar = '0' or (tglkeluar >= '2019-$now' and keluar = '1')) and left(noind, 1) not in ('L','M','Z') $ictSql order by 1";
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
		$ictSql and rtrim(b.dept) = '$kodeDept'
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
				and rtrim(b.kodesie) like '$kodeDept%' $sqlPKL $lokasi 
				union 
				select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and (masukkerja >= '1945-01-01') and rtrim(b.kodesie) like '$kodeDept%' $sqlPKL $lokasi 
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
				and b.unit != '-' and rtrim(b.unit) like '%$kodeUnit%'  $sqlPKL
				union 
				select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and b.unit != '-' and (masukkerja >= '1945-01-01') and rtrim(b.unit) like '%$kodeUnit%'  $sqlPKL
				 ) tabel ) tabel group by rtrim(dept)";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}


	public function pekerjaUnitKeuangan($now, $kodeUnit, $sqlPKL) {
		$sql = "
		select rtrim(unit),count(*)	from 
				(
				select distinct nik,nama,dept,bidang,unit,seksi 
				from
				(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((keluar = '0' and masukkerja<='2019-$now'))
				and rtrim(b.kodesie) like '1%' and rtrim(b.unit) = '$kodeUnit'  $sqlPKL
				union 
				select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and (masukkerja >= '1945-01-01') and rtrim(b.kodesie) like '1%' and rtrim(b.unit) = '$kodeUnit'  $sqlPKL
				 ) tabel ) tabel group by rtrim(unit)";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function pekerjaUnitPemasaran($now, $kodeUnit, $sqlPKL)
	{
		$sql = "
		select rtrim(unit),count(*)	from 
				(
				select distinct nik,nama,dept,bidang,unit,seksi 
				from
				(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((keluar = '0' and masukkerja<='2019-$now'))
				and rtrim(b.kodesie) like '2%' and rtrim(b.unit) = '$kodeUnit'  $sqlPKL
				union 
				select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and (masukkerja >= '1945-01-01') and rtrim(b.kodesie) like '2%' and rtrim(b.unit) = '$kodeUnit'  $sqlPKL
				 ) tabel ) tabel group by rtrim(unit)";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function pekerjaUnitPersonalia($now, $kodeUnit, $sqlPKL)
	{
		$sql = "
		select rtrim(unit),count(*)	from 
				(
				select distinct nik,nama,dept,bidang,unit,seksi 
				from
				(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((keluar = '0' and masukkerja<='2019-$now'))
				and rtrim(b.kodesie) like '4%' and rtrim(b.unit) = '$kodeUnit'  $sqlPKL
				union 
				select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and (masukkerja >= '1945-01-01') and rtrim(b.kodesie) like '4%' and rtrim(b.unit) ='$kodeUnit'  $sqlPKL
				 ) tabel ) tabel group by rtrim(unit)";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function pekerjaUnitProduksi($now, $kodeUnit, $sqlPKL)
	{
		$sql = "
		select rtrim(unit),count(*)	from 
				(
				select distinct nik,nama,dept,bidang,unit,seksi 
				from
				(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((keluar = '0' and masukkerja<='2019-$now'))
				and rtrim(b.kodesie) like '3%' and rtrim(b.unit) = '$kodeUnit'  $sqlPKL
				union 
				select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and (masukkerja >= '1945-01-01') and rtrim(b.kodesie) like '3%' and rtrim(b.unit) ='$kodeUnit'  $sqlPKL
				 ) tabel ) tabel group by rtrim(unit)";
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
				and rtrim(b.seksi) = '$kodeSeksi' $sqlPKL 
				union 
				select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and (masukkerja >= '1945-01-01') and rtrim(b.seksi) = '$kodeSeksi' $sqlPKL
				 order by 5
				 ) tabel ) tabel group by rtrim(seksi)";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function pekerjaSeksiDeptProduksi($now, $kodeSeksi, $sqlPKL)
	{
		$sql = "
		select rtrim(seksi),count(*)	from 
				(
				select distinct nik, nama ,dept,bidang,unit,seksi 
				from
				(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((keluar = '0' and masukkerja<='2019-$now'))
				and rtrim(b.kodesie) like '3%' and rtrim(b.seksi) = '$kodeSeksi' $sqlPKL 
				union 
				select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and (masukkerja >= '1945-01-01') and rtrim(b.kodesie) like '3%' and rtrim(b.seksi) = '$kodeSeksi' $sqlPKL
				 order by 5
				 ) tabel ) tabel group by rtrim(seksi)";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function pekerjaSeksiDeptPemasaran($now, $kodeSeksi, $sqlPKL) {
		$sql = "select rtrim(seksi),count(*) from (
				select distinct nik, nama ,dept,bidang,unit,seksi 
				from
				(select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((keluar = '0' and masukkerja<='2019-$now'))
				and rtrim(b.kodesie) like '2%' and rtrim(b.seksi) = '$kodeSeksi' $sqlPKL 
				union 
				select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and (masukkerja >= '1945-01-01') and rtrim(b.kodesie) like '2%' and rtrim(b.seksi) = '$kodeSeksi' $sqlPKL
				 order by 5
				 ) tabel ) tabel group by rtrim(seksi)";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function pekerjaAllSeksiDeptProduksi($now, $tdklangsung, $langsung, $sqlPKL) {
		$sql = "select
					trim(seksi1.bidang) bidang,
					trim(seksi1.unit) unit,
					trim(seksi1.seksi) seksi,
					count(seksi1.*) tidak_langsung,
					coalesce(lsng.langsung,'0') langsung,
					(count(seksi1.*) + coalesce(lsng.langsung,'0')) total 
				from (select distinct nik, nama ,dept,bidang,unit,seksi 
                        from (select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.* 
                                        from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie left join hrd_khs.tpekerjaan c on a.kd_pkj=c.kdpekerjaan 
                                        where ((keluar = '0' and masukkerja<='2019-$now'))
                                        and rtrim(b.kodesie) like '3%' $tdklangsung $sqlPKL
                                  union 
                                  select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.* 
                                  from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie left join hrd_khs.tpekerjaan c on a.kd_pkj=c.kdpekerjaan 
                                  where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1')) and (masukkerja >= '1945-01-01') 
                                  and rtrim(b.kodesie) like '3%' $tdklangsung $sqlPKL order by 5 ) tabel) seksi1
			    		left join (select rtrim(seksi2.seksi) seksi_langsung
			               ,count(seksi2.*) langsung
			                from (select distinct nik, nama ,dept,bidang,unit,seksi 
                                from (select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.* 
                                                from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie left join hrd_khs.tpekerjaan c on a.kd_pkj=c.kdpekerjaan 
                                                where ((keluar = '0' and masukkerja<='2019-$now'))
                                                and rtrim(b.kodesie) like '3%' $langsung $sqlPKL
                                        union 
                                        select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.* 
                                        from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie left join hrd_khs.tpekerjaan c on a.kd_pkj=c.kdpekerjaan 
                                        where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1')) and (masukkerja >= '1945-01-01') 
                                        and rtrim(b.kodesie) like '3%' $langsung $sqlPKL order by 5 ) tabel ) seksi2
					    group by rtrim(seksi2.seksi)
					    order by seksi_langsung) lsng on rtrim(seksi1.seksi) = lsng.seksi_langsung
					group by bidang, unit, seksi, lsng.langsung
					order by bidang";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function pekerjaPasar($now, $sqlPKL, $kodeUnit)
	{
		$sql = "select rtrim(b.seksi), count(a.noind) 
		from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
		where (keluar = '0' or (tglkeluar >= '2019-$now' and keluar = '1')) 
		and b.unit != '-' and rtrim(b.seksi) = '$kodeUnit' 
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
				and b.unit != '-' and rtrim(b.seksi) like '%$kodeUnit%'  $sqlPKL
				union
				select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and b.unit != '-' and (masukkerja >= '1945-01-01') and rtrim(b.seksi) like '%$kodeUnit%'  $sqlPKL
				 ) tabel ) tabel";
				echo $sql;exit();
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
				and b.unit != '-' and left(b.kodesie,1)='4' and rtrim(b.seksi) not like '%$kodeUnit%'  $sqlPKL
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
				$sqlPKL and c.kodesie LIKE '3%' $kode 
				union 
				select a.noind,nik,nama,masukkerja,tglkeluar,keluar,c.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi c on a.kodesie=c.kodesie 
				left join hrd_khs.tpekerjaan b on a.kd_pkj=b.kdpekerjaan
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and (masukkerja >= '1945-01-01') $sqlPKL and c.kodesie LIKE '3%' $kode 
				 order by 5
				 ) tabel ) tabel";
				// echo $sql; exit();
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
				$sqlPKL $kode 
				union
				select a.noind,nik,nama,masukkerja,tglkeluar,keluar,c.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi c on a.kodesie=c.kodesie 
				left join hrd_khs.tpekerjaan b on a.kd_pkj=b.kdpekerjaan
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and (masukkerja >= '1945-01-01') $sqlPKL $kode 
				 order by 5
				 ) tabel ) tabel";
				// echo $sql;exit();cc
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function semuaData($now, $sqlPKL) {
		$sql = "
		select count(*)	from 
				(
				select distinct nik,nama ,dept,bidang,unit,seksi 
				from
				(select a.noind,a.nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((keluar = '0' and masukkerja<='2019-$now'))
				$sqlPKL 
				union
				select a.noind,a.nik,nama,masukkerja,tglkeluar,keluar,b.*
				from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
				where ((masukkerja<='2019-$now') and (tglkeluar >= '2019-$now' and keluar = '1'))
				and (masukkerja >= '1945-01-01') $sqlPKL 

				 ) tabel ) tabel";
				// echo $sql;exit();

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
	$pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-01-01') and (tglkeluar >= '$tahun-01-01' and keluar = '1'))
	and (masukkerja >= '1945-01-01') $pkl
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
	$pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-02-01') and (tglkeluar >= '$tahun-02-01' and keluar = '1'))
	and (masukkerja >= '1945-01-01') $pkl
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
	$pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-03-01') and (tglkeluar >= '$tahun-03-01' and keluar = '1'))
	and (masukkerja >= '1945-01-01') $pkl
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
	$pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-04-01') and (tglkeluar >= '$tahun-04-01' and keluar = '1'))
	and (masukkerja >= '1945-01-01') $pkl
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
	$pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-05-01') and (tglkeluar >= '$tahun-05-01' and keluar = '1'))
	and (masukkerja >= '1945-01-01') $pkl
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
	$pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-06-01') and (tglkeluar >= '$tahun-06-01' and keluar = '1'))
	and (masukkerja >= '1945-01-01') $pkl
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
	$pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-07-01') and (tglkeluar >= '$tahun-07-01' and keluar = '1'))
	and (masukkerja >= '1945-01-01') $pkl
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
	$pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-08-01') and (tglkeluar >= '$tahun-08-01' and keluar = '1'))
	and (masukkerja >= '1945-01-01') $pkl
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
	$pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-09-01') and (tglkeluar >= '$tahun-09-01' and keluar = '1'))
	and (masukkerja >= '1945-01-01') $pkl
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
	$pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-10-01') and (tglkeluar >= '$tahun-10-01' and keluar = '1'))
	and (masukkerja >= '1945-01-01') $pkl
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
	$pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-11-01') and (tglkeluar >= '$tahun-11-01' and keluar = '1'))
	and (masukkerja >= '1945-01-01') $pkl
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
	$pkl
	union 
	select a.noind,nik,nama,masukkerja,tglkeluar,keluar,b.*
	from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie=b.kodesie 
	where ((masukkerja<='$tahun-12-01') and (tglkeluar >= '$tahun-12-01' and keluar = '1'))
	and (masukkerja >= '1945-01-01') $pkl
	 ) tabel ) tabel) as tahun
order by 1
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

}