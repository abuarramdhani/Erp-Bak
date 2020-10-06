<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class M_datapekerjaaktif extends CI_Model
{
	
	function __construct()
	{
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);
	}

	public function dpa_getListSeksi()
	{
		$sql = "select
					left(ts.kodesie, 7) as kodesie,
					trim(ts.seksi) seksi,
					trim(ts.unit) unit,
					trim(ts.bidang) bidang,
					trim(ts.dept) dept 
				from
					hrd_khs.tseksi ts
				group by
					left(ts.kodesie, 7),
					trim(ts.seksi),
					trim(ts.unit),
					trim(ts.bidang),
					trim(ts.dept)
				order by
					left(ts.kodesie, 7);";
		return $this->personalia->query($sql)->result_array();
	}

	public function getPerRow($lokasi, $tgl)
	{
		$sql = "select (
						select count(*) from hrd_khs.tpribadi t where kodesie like '1010301%' and keluar = false and noind like 'A%' and lokasi_kerja like '$lokasi%') a,
						(select count(*) from hrd_khs.tpribadi t where kodesie like '1010301%' and keluar = false and noind like 'E%' and lokasi_kerja like '$lokasi%') e,
						(select count(*) from hrd_khs.tpribadi t where kodesie like '1010301%' and keluar = false and noind like 'F%' and lokasi_kerja like '$lokasi%') f,
						(select count(*) from hrd_khs.tpribadi t where kodesie like '1010301%' and keluar = false and noind like 'Q%' and lokasi_kerja like '$lokasi%') q,
						(select count(*) from hrd_khs.tpribadi t where kodesie like '1010301%' and keluar = false and noind like 'H%' and lokasi_kerja like '$lokasi%') h,
						(select count(*) from hrd_khs.tpribadi t where kodesie like '1010301%' and keluar = false and noind like 'B%' and lokasi_kerja like '$lokasi%') b,
						(select count(*) from hrd_khs.tpribadi t where kodesie like '1010301%' and keluar = false and noind like 'D%' and lokasi_kerja like '$lokasi%') d,
						(select count(*) from hrd_khs.tpribadi t where kodesie like '1010301%' and keluar = false and noind like 'G%' and lokasi_kerja like '$lokasi%') g,
						(select count(*) from hrd_khs.tpribadi t where kodesie like '1010301%' and keluar = false and noind like 'J%' and lokasi_kerja like '$lokasi%') j,
						(select count(*) from hrd_khs.tpribadi t where kodesie like '1010301%' and keluar = false and noind like 'L%' and lokasi_kerja like '$lokasi%') l,
						(select count(*) from hrd_khs.tpribadi t where kodesie like '1010301%' and keluar = false and (noind like 'K%' or noind like 'P%') and lokasi_kerja like '$lokasi%') kp,
						(select count(*) from hrd_khs.tpribadi t where kodesie like '1010301%' and keluar = false and noind like 'C%' and lokasi_kerja like '$lokasi%') c,
						(select count(*) from hrd_khs.tpribadi t where kodesie like '1010301%' and keluar = false and noind like 'T%' and lokasi_kerja like '$lokasi%') t,
						(select count(*) from hrd_khs.tpribadi t where kodesie like '1010301%' and keluar = false and left(noind,1) in ('A','E','F','Q','H','B','D','G','J','L','K','P','C','T') and lokasi_kerja like '$lokasi%') total";
		return $this->personalia->query($sql)->row_array();
	}

	public function getPerRow2($lokasi, $tgl, $ks)
	{
		$arr = array('A','E','F','Q','H','B', 'D','G','J','L','K','C','T');
		$sql = 'select ';
		$koma = ',';
		foreach ($arr as $key) {
			if ($key == "K") {
				$st = "left(tp.noind,1) in ('K','P')";
			}else{
				$st = "tp.noind like '$key%'";
			}
			if ($key == 'T') {
				$koma = '';
			}
			$whnoind = 
			$sql .= "(
				select
					count(*)
				from
					(
					select
						case
							when (
							select
								count(*)
							from
								\"Surat\".tsurat_pengangkatan tpeng
							where
								tpeng.noind = tp.noind
								and tpeng.tanggal_berlaku > '$tgl'
							limit 1) > 0 then (
							select
								noind
							from
								\"Surat\".tsurat_pengangkatan tpeng
							where
								tpeng.tanggal_berlaku > '$tgl'
							order by
								tanggal_berlaku asc
							limit 1)
							else tp.noind
						end as noind,
						case
							when (
							select
								count(*)
							from
								hrd_khs.tmutasi t2
							where
								t2.noind = tp.noind
								and t2.tglberlaku > '$tgl'
							limit 1) > 0 then (
							select
								kodesielm
							from
								hrd_khs.tmutasi t2
							where
								t2.noind = tp.noind
								and t2.tglberlaku > '$tgl'
							order by
								tglberlaku asc
							limit 1 )
							else tp.kodesie
						end kodesie,
						case
							when (
							select
								count(*)
							from
								hrd_khs.tmutasi t2
							where
								t2.noind = tp.noind
								and t2.tglberlaku > '$tgl'
							limit 1) > 0 then (
							select
								lokasilm
							from
								hrd_khs.tmutasi t2
							where
								t2.noind = tp.noind
								and t2.tglberlaku > '$tgl'
							order by
								tglberlaku asc
							limit 1 )
							else tp.kodesie
						end lokasi_kerja
					from
						hrd_khs.tpribadi tp
					where
						tp.kodesie like '$ks%'
						and $st
						and tp.lokasi_kerja like '$lokasi%'
						and tp.tglkeluar > '$tgl') t ) $key $koma";
		}
		// echo $sql;exit();
		return $this->personalia->query($sql)->row_array();	
	}

	public function getLokasiKerjabyID($id){
		$this->personalia->where('id_',$id);
		return $this->personalia->get('hrd_khs.tlokasi_kerja')->row_array();
	}
}