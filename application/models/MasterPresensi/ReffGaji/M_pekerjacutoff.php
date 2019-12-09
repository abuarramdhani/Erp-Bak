<?php 
defined('BASEPATH') or exit('No Direct Script Access ALlowed');
/**
 *
 */
class M_pekerjacutoff extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	public function getPeriodeCutoff(){
		$sql = "select tanggal_proses,count(*) as jumlah 
				from \"Presensi\".tcutoff_custom_terproses 
				where terakhir = '1'
				group by tanggal_proses
				order by tanggal_proses desc";
		return $this->personalia->query($sql)->result_array();
	}

	public function getCutoffDetail($periode){
		$sql = "select a.noind,
					b.nama,
					(select concat(seksi,' / ',unit) from hrd_khs.tseksi c  where b.kodesie = c.kodesie) as seksi
				from \"Presensi\".tcutoff_custom_terproses a
				left join hrd_khs.tpribadi b
				on a.noind = b.noind
				where a.terakhir = '1'
				and a.tanggal_proses = '$periode'
				order by a.noind";
		return $this->personalia->query($sql)->result_array();
	}

	public function getPekerja($key){
		$sql = "select noind,nama from hrd_khs.tpribadi where upper(noind) like upper('%$key%') or upper(nama) like upper('%$key%')";
		return $this->personalia->query($sql)->result_array();
	}

	public function getCutoffDetailPekerja($noind){
		$sql = "select a.noind,
					b.nama,
					(select concat(seksi,' / ',unit) from hrd_khs.tseksi c  where b.kodesie = c.kodesie) as seksi,
					case when to_char(a.tanggal_proses,'mm') = '01' then 
						concat('Januari ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '02' then 
						concat('Februari ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '03' then 
						concat('Maret ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '04' then 
						concat('April ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '05' then 
						concat('Mei ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '06' then 
						concat('Juni ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '07' then 
						concat('Juli ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '08' then 
						concat('Agustus ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '09' then 
						concat('September ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '10' then 
						concat('Oktober ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '11' then 
						concat('November ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '12' then 
						concat('Desember ',to_char(a.tanggal_proses,'yyyy'))
					end 
					as periode,
					tanggal_proses
				from \"Presensi\".tcutoff_custom_terproses a
				left join hrd_khs.tpribadi b
				on a.noind = b.noind
				where a.terakhir = '1'
				and a.noind = '$noind'
				order by a.tanggal_proses";
		return $this->personalia->query($sql)->result_array();
	}

	public function getDetailPekerja($noind){
		$sql = "select b.noind,
					b.nama,
					(select concat(seksi,' / ',unit) from hrd_khs.tseksi c  where b.kodesie = c.kodesie) as seksi
				from hrd_khs.tpribadi b
				where b.noind = '$noind'";
		return $this->personalia->query($sql)->result_array();
	}

	public function getPekerjaCufOffAktif($periode,$noind){
		$sql = "select *
				from (
				select '*' remark_cutoff,'$periode'::date as tanggal, b.noind as noind, b.nama as nama, b.kodesie as kodesie, 
 						'0' as ipe, '0' as ika, '0' as ubt, '0' as upamk, '0' as um, 
 						case when left(a.noind,1) in ('B','D','J') then 
 							(
	 							select count(*)
								from generate_series(
									(select tanggal_akhir + interval '1 day' from \"Presensi\".tcutoff where periode = to_char('$periode'::date,'yyyymm') and os ='0'),
									(select to_char(tanggal_akhir,'yyyy-mm-01')::date + interval '1 month' - interval '1 day' from \"Presensi\".tcutoff where periode = to_char('$periode'::date,'yyyymm') and os ='0'),
									interval '1 day'
								) as dates
								left join \"Dinas_Luar\".tlibur as libur
								on libur.tanggal = dates.dates
								where libur.tanggal is null 
								and extract(isodow from dates.dates) <> '7'	
							)
						else 
							'0'
						end::varchar as ief, 
 						'0' as ims, '0' as imm, '0' as jam_lembur, '0' as ijin, 0 as pot, 
 						(
 							select 30 - count(*)
							from generate_series(
								(select tanggal_akhir + interval '1 day' from \"Presensi\".tcutoff where periode = to_char('$periode'::date,'yyyymm') and os ='0'),
								(select to_char(tanggal_akhir,'yyyy-mm-01')::date + interval '1 month' - interval '1 day' from \"Presensi\".tcutoff where periode = to_char('$periode'::date,'yyyymm') and os ='0'),
								interval '1 day'
							) as dates
							left join \"Dinas_Luar\".tlibur as libur
							on libur.tanggal = dates.dates
							where libur.tanggal is null 
							and extract(isodow from dates.dates) <> '7'	
						)::varchar as htm, 
 						0 as tamb_gaji, 0 as hl, 0 as ct, '0' as putkop, '0' as plain, '0' as pikop, 
 						'0' as pspsi, '0' as putang, '0' as dldobat, '0' as tkpajak, '0' as ttpajak, 
 						'0' as pduka, '0' as utambahan, '0' as btransfer, '0' as dendaik, '0' as plbhbayar, 
 						'0' as pgp, '0' as tlain, null as xduka, '-' as ket, 0 as cicil, '0' as ubs, 
 						'' as ubs_rp, '0' as um_puasa, b.noind_baru as noind_baru, '01' as jns_transaksi, 
 						'0' as angg_jkn, '0' as potongan_str, '0' as tambahan_str, '0' as reff_id, 
 						(select lokasi_kerja from hrd_khs.tlokasi_kerja where ID_ = b.lokasi_kerja) as lokasi_krj, 
 						'0' as ipet, 0 as um_cabang, null as susulan, 0 as jml_jkn, 0 as jml_jht, 0 as jml_jp,c.seksi
				from \"Presensi\".tcutoff_custom_terproses a
				left join hrd_khs.tpribadi b 
				on a.noind = b.noind
				left join hrd_khs.tseksi c 
				on b.kodesie = c.kodesie
				where a.terakhir = '1'
				and a.tanggal_proses = '$periode'
				and left(a.noind,1) in ($noind)
				and (
					b.keluar = '0'
					or 	(
						b.tglkeluar >= to_char('$periode'::date,'yyyy-mm-01')::date + interval '1 month'
						and b.keluar = '1'
						)
					)
				union all
				select  '' remark_cutoff,tanggal_keluar, b.noind as noind, b.nama as nama, b.kodesie, 
 						ipe, ika, ubt, upamk, um, ief, ims, imm, jam_lembur, ijin, pot, 
 						htm, tamb_gaji, hl, ct, putkop, plain, pikop, 
 						pspsi, putang, dldobat, tkpajak, ttpajak, 
 						pduka, utambahan, btransfer, dendaik, plbhbayar, 
 						pgp, tlain, xduka, ket, cicil, ubs, 
 						ubs_rp, um_puasa, b.noind_baru, jns_transaksi, 
 						angg_jkn, potongan_str, tambahan_str, reff_id, lokasi_krj, 
 						ipet, um_cabang,  susulan, jml_jkn, jml_jht, jml_jp,c.seksi
 				from \"Presensi\".treffgaji_keluar a 
 				left join hrd_khs.tpribadi b 
				on a.noind = b.noind
				left join hrd_khs.tseksi c 
				on b.kodesie = c.kodesie
	 			where tanggal_keluar between (
		 				select tanggal_akhir + interval '1 day' 
		 				from \"Presensi\".tcutoff 
		 				where periode = to_char('$periode'::date,'yyyymm') 
		 				and os = '0'
	 				) and  (
	 					select to_char(tanggal_akhir,'yyyy-mm-01')::date + interval '1 month' - interval '1 day'
	 					from \"Presensi\".tcutoff 
	 					where periode = to_char('$periode'::date,'yyyymm') 
	 					and os = '0'
	 				)
	 			and left(a.noind,1) in ($noind)
				) as tbl 
				order by kodesie,noind";
		return $this->personalia->query($sql)->result_array();
	}

	public function insertMemo($data){
		$this->personalia->insert('"Presensi".tcutoff_custom_memo',$data);
	}

	public function getNamaByNoind($noind){
		$sql = "select nama from hrd_khs.tpribadi where noind = '$noind'";
		$result = $this->personalia->query($sql)->row();
		if(!empty($result)){
			return $result->nama;
		}else{
			return "-";
		}
	}

	public function getSeksiByNoind($noind){
		$sql = "select b.seksi from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie = b.kodesie where noind = '$noind'";
		$result = $this->personalia->query($sql)->row();
		if(!empty($result)){
			return $result->seksi;
		}else{
			return "-";
		}
	}

	public function getJabByNoind($noind){
		$sql = "select jabatan from hrd_khs.tpribadi where noind = '$noind'";
		$result = $this->personalia->query($sql)->row();
		if(!empty($result)){
			return $result->jabatan;
		}else{
			return "-";
		}
	}

	public function getMemoList(){
		$sql = "select (select concat(noind,' - ',nama) from hrd_khs.tpribadi b where a.created_by = b.noind) as dibuat, 
				(select concat(noind,' - ',nama) from hrd_khs.tpribadi b where a.mengetahui = b.noind) as mengetahui, 
				kepada_nonstaff,kepada_staff, file_staff, file_nonstaff, nomor_surat, periode, created_timestamp
				from \"Presensi\".tcutoff_custom_memo a 
				order by created_timestamp desc";
		return $this->personalia->query($sql)->result_array();
	}

	public function getCutoffAwal($periode){
		$sql = "select tanggal_akhir + interval '1 day' as tanggal_awal 
 				from \"Presensi\".tcutoff 
 				where periode = to_char('$periode'::date,'yyyymm') 
 				and os = '0'";
 		$result = $this->personalia->query($sql)->row();
		if(!empty($result)){
			return $result->tanggal_awal;
		}else{
			return "-";
		}
	}

	public function getAkhirbulan($periode){
		$sql = "select to_char(tanggal_akhir,'yyyy-mm-01')::date + interval '1 month' - interval '1 day' as akhir_bulan
					from \"Presensi\".tcutoff 
					where periode = to_char('$periode'::date,'yyyymm') 
					and os = '0'";
		$result = $this->personalia->query($sql)->row();
		if(!empty($result)){
			return $result->akhir_bulan;
		}else{
			return "-";
		}
	}

}
?>