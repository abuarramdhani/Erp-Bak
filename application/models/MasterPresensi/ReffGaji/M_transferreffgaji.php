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
		$sql = "select *
 				from (
 				select tanggal, noind, nama, kodesie, 
 						ipe, ika, ief, ubt, upamk, um, 
 						ims, imm, jam_lembur, htm, ijin, pot, 
 						tamb_gaji, hl, ct, putkop, plain, pikop, 
 						pspsi, putang, dldobat, tkpajak, ttpajak, 
 						pduka, utambahan, btransfer, dendaik, plbhbayar, 
 						pgp, tlain, xduka, ket, cicil, ubs, 
 						ubs_rp, um_puasa, noind_baru, jns_transaksi, 
 						angg_jkn, potongan_str, tambahan_str, reff_id, 
 						lokasi_krj, 
 						ipet, um_cabang, susulan, jml_jkn, jml_jht, jml_jp
 				from \"Presensi\".Treffgaji 
 				where left(noind,1) in ('K','P') 
 				and to_char(tanggal,'mmyy') ='$periode'
 				and jns_transaksi in('01')  
 				union all 
 				select '2019-11-21' as tanggal, noind as noind, nama as nama, kodesie as kodesie, 
 						'0' as ipe, '0' as ika, '0' as ief, '0' as ubt, '0' as upamk, '0' as um, 
 						'0' as ims, '0' as imm, '0' as jam_lembur, '0' as htm, '0' as ijin, 0 as pot, 
 						0 as tamb_gaji, 0 as hl, 0 as ct, '0' as putkop, '0' as plain, '0' as pikop, 
 						'0' as pspsi, '0' as putang, '0' as dldobat, '0' as tkpajak, '0' as ttpajak, 
 						'0' as pduka, '0' as utambahan, '0' as btransfer, '0' as dendaik, '0' as plbhbayar, 
 						'0' as pgp, '0' as tlain, null as xduka, '-' as ket, 0 as cicil, '0' as ubs, 
 						'' as ubs_rp, '0' as um_puasa, noind_baru as noind_baru, '01' as jns_transaksi, 
 						'0' as angg_jkn, '0' as potongan_str, '0' as tambahan_str, '0' as reff_id, 
 						(select lokasi_kerja from hrd_khs.tlokasi_kerja where ID_ = tp.lokasi_kerja) as lokasi_krj, 
 						'0' as ipet, 0 as um_cabang, null as susulan, 0 as jml_jkn, 0 as jml_jht, 0 as jml_jp
 				from hrd_khs.tpribadi tp 
 				where left(noind,1) in ('K','P')
 				and to_char(tglkeluar,'yy')::int = right('$periode',2)::int
 				and to_char(tglkeluar,'mm')::int = left('$periode',2)::int - 1
 				and keluar = '1'
 				and noind not in (select noind
 								 	from \"Presensi\".Treffgaji 
 								 	where left(noind,1) in ('K','P')
 								 	and to_char(tanggal,'mmyy') ='$periode'
 								 	and jns_transaksi in('01')
 								 )
 				) as tbl
 				order by tanggal, left(noind, 1), kodesie, noind";
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
				) + (
 				 	select count(*) from hrd_khs.tpribadi 
 				 	where left(noind,1) in ('K','P')
 					and to_char(tglkeluar,'yy')::int = right('$periode',2)::int
 					and to_char(tglkeluar,'mm')::int = left('$periode',2)::int - 1
 					and keluar = '1'
 					and noind not in (	select noind
 									 	from \"Presensi\".Treffgaji 
 									 	where left(noind,1) in ('K','P')
 									 	and to_char(tanggal,'mmyy') ='$periode'
 									 	and jns_transaksi in('01')
 									 )
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