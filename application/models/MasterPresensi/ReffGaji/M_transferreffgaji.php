<?php 
defined('BASEPATH') or exit('No Direct Script Access ALlowed');
/**
 * 
 */
class M_transferreffgaji extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	public function getCutOff(){
		$sql = "select tanggal_awal,tanggal_akhir,
					left(periode,4) as tahun, right(periode,2) as bulan,periode,
					concat(right(periode,2),right(left(periode,4),2)) as per 
				from \"Presensi\".tcutoff 
				where os = '0' 
				order by id_cutoff desc
				limit 12 ";
		return $this->personalia->query($sql)->result_array();
	}

	public function getDataPkl($noind,$periode){
		$sql = "select * 
				from \"Presensi\".Treffgaji 
				where left(noind,1) = '$noind' 
				and to_char(tanggal,'mmyy') ='$periode' 
				and jns_transaksi in('01') 
				order by tanggal, kodesie, noind";
 		return $this->personalia->query($sql)->result_array();
	}

	public function getGolPkl(){
		$sql = "select golpkl from hrd_khs.tgolpkl order by golpkl";
		return $this->personalia->query($sql)->result_array();
	}

	public function getDataPkjPkl($noind,$periode,$golpkl){
		$sql = "select * from \"Presensi\".Treffgaji reff, hrd_khs.tpribadi pribadi 
				 where left(reff.noind,1) = '$noind' 
				 and reff.noind = pribadi.noind 
				 and pribadi.golkerja = '$golpkl' 
				 and to_char(tanggal,'mmyy') ='$periode' 
				 and reff.jns_transaksi in('01') 
				 order by reff.tanggal, reff.kodesie, reff.noind";
		return $this->personalia->query($sql)->result_array();
	}

	public function getDataStaff($periode){
		$sql = "select tbl.*,tpri.nik from (
				 select * from \"Presensi\".Treffgaji 
				 where (
				 			left(noind,1) = 'B' 
				 			or left(noind,1) = 'D' 
				 			or left(noind,1) = 'J' 
				 			or left(noind,1) = 'T' 
				 			or left(noind,1) = 'G'
				 			or left(noind,1) = 'Q'
				 		) 
				 and to_char(tanggal,'mmyy') ='$periode'
				 and jns_transaksi in('01')
				 union all 
				 select * from \"Presensi\".Treffgaji_keluar refkel
				 where (
				 			left(noind,1) = 'B' 
				 			or left(noind,1) = 'D' 
				 			or left(noind,1) = 'J' 
				 			or left(noind,1) = 'T' 
				 			or left(noind,1) = 'G'
				 			or left(noind,1) = 'Q'
				 		) 
				 and to_char(tanggal_keluar,'mmyy') ='$periode'
				 and (select count(*) from hrd_khs.tpribadi pri2 where (select nik from hrd_khs.tpribadi pri where refkel.noind = pri.noind) = pri2.nik and pri2.keluar = '0') = 0
				) as tbl 
				left join hrd_khs.tpribadi tpri 
					on tpri.noind = tbl.noind
				order by noind";
 		return $this->personalia->query($sql)->result_array();
	}

	public function getPekerjaKeluar($nik,$periode){
		$sql = "select reff.* 
				from \"Presensi\".treffgaji_keluar reff 
				inner join hrd_khs.tpribadi pri 
				on reff.noind = pri.noind
				where pri.nik = '$nik'
				and pri.sebabklr like '%NO INDUK BERUBAH%'
				and pri.tglkeluar between (select tanggal_awal from \"Presensi\".tcutoff where to_char(tanggal_akhir,'mmyy')='$periode' and os= '0') and 
 				(select tanggal_akhir from \"Presensi\".tcutoff where to_char(tanggal_akhir,'mmyy')='$periode' and os= '0')";
		$result = $this->personalia->query($sql);
		return $result->row();
	}

	public function getStatusJabatan($noind){
		$sql =  "select kd_jabatan from hrd_khs.tpribadi where noind = '$noind'";
		return $this->personalia->query($sql)->row()->kd_jabatan;
	}

	public function getPribadi($noind){
		$sql = "select * 
				 from hrd_khs.tseksi sie, hrd_khs.tpribadi tmp, hrd_khs.tpribadi pri 
				 where sie.kodesie = tmp.kodesie 
				 and tmp.noind = pri.noind
				 and tmp.noind = '$noind' ";
 		return $this->personalia->query($sql)->row();
	}

	public function getSeksi2($kodesie){
		$sql = "select * from hrd_khs.tseksi2 where kodesie = '$kodesie'";
		return $this->personalia->query($sql)->row();
	}

	public function getSeksi($kodesie){
		$sql = "select left(trim(seksi), 50) as seksi, left(trim(unit), 50) as unit, 
				 left(trim(bidang), 50) as bidang, left(trim(dept), 50) as dept 
				 from hrd_khs.tseksi where kodesie = '$kodesie'";
		return $this->personalia->query($sql)->row();
	}

	public function getDataNonStaff($periode){
		$sql = "select * from \"Presensi\".Treffgaji 
				 where (left(noind,1) = 'A' or left(noind,1) = 'C' or left(noind,1) = 'E' or left(noind,1) = 'H') 
				 and to_char(tanggal,'mmyy') ='$periode'
				 and jns_transaksi in('01') order by noind";
		return $this->personalia->query($sql)->result_array();
	}

	public function getDataOs($periode){
		$sql = "select * from \"Presensi\".Treffgaji 
				 where (left(noind,1) = 'K' or left(noind,1) = 'P') 
				 and to_char(tanggal,'mmyy') ='$periode'
				 and jns_transaksi in('01')  order by tanggal, left(noind, 1), kodesie, noind ";
 		return $this->personalia->query($sql)->result_array();
	}

	public function insertProgres($user,$periode){
		$sql = "delete from \"Presensi\".progress_transfer_reffgaji where user_ = '$user' and menu = 'transferreffgaji'";
		$this->personalia->query($sql);

		$sql ="insert into \"Presensi\".progress_transfer_reffgaji(user_,progress,total,menu)
				select '$user',0,
				 (
				 	select count(*) 
				 	from \"Presensi\".Treffgaji 
				 	where left(noind,1) in ('A','B','C','D','E','F','G','H','J','K','P','Q','T')
				 	and to_char(tanggal,'mmyy') ='$periode'
				 	and jns_transaksi in('01')
				 ) + 
				 (
				 	select count(*) from \"Presensi\".Treffgaji_keluar refkel
				 	where left(noind,1) in ('B','D','J','T','G','Q') 
				 	and (select count(*) from hrd_khs.tpribadi pri2 where (select nik from hrd_khs.tpribadi pri where refkel.noind = pri.noind) = pri2.nik and pri2.keluar = '0') = 0
				 	and to_char(tanggal_keluar,'mmyy') ='$periode'
				),'transferreffgaji'";
		$this->personalia->query($sql);
	}

	public function updateProgres($user,$progres){
		$sql = "update \"Presensi\".progress_transfer_reffgaji set progress = $progres where user_ = '$user' and menu = 'transferreffgaji' ";
		$this->personalia->query($sql);
	}

	public function getProgres($user){
		$sql = "select * from \"Presensi\".progress_transfer_reffgaji where user_ = '$user' and menu = 'transferreffgaji'";
		return $this->personalia->query($sql)->row();
	}

	public function deleteProgres($user){
		$sql = "delete from \"Presensi\".progress_transfer_reffgaji where user_ = '$user' and menu = 'transferreffgaji'";
		$this->personalia->query($sql);
	}

} ?>