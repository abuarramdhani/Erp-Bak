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

	public function cekCutoffPeriode($periode){
		$sql = "select *
				from \"Presensi\".tcutoff t
				where periode = '$periode'
				and os = '0'";
		return $this->personalia->query($sql)->result_array();
	}

	public function cekCutoffPeriodePlus1($periode){
		$sql = "select *
				from \"Presensi\".tcutoff t2
				where tanggal_awal = (select tanggal_akhir + interval '1 day'
				from \"Presensi\".tcutoff t
				where periode = '$periode'
				and os = '0')
				and os = '0'";
		return $this->personalia->query($sql)->result_array();
	}

	public function getPekerja($key){
		$sql = "select noind,nama from hrd_khs.tpribadi where upper(noind) like upper('%$key%') or upper(nama) like upper('%$key%')";
		return $this->personalia->query($sql)->result_array();
	}

	public function getPekerjaAktif($key){
		$sql = "select noind,nama from hrd_khs.tpribadi where keluar = '0' and (upper(noind) like upper('%$key%') or upper(nama) like upper('%$key%'))";
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

	public function getPekerjaCufOffAktif($periode,$kode_noind,$noind){
		$sql = "select  case when keluar = '1' then to_char(tglkeluar,'yyyy-mm-dd') else '-' end as tanggal, b.noind as noind, b.nama as nama, b.kodesie as kodesie, 
 						'0' as ipe, '0' as ika, '0' as ubt, '0' as upamk, '0' as um, 
 						'0' ief, 
 						'0' as ims, '0' as imm, '0' as jam_lembur, '0' as ijin, 0 as pot, 
 						'0' as htm, 
 						0 as tamb_gaji, 0 as hl, 0 as ct, '0' as putkop, '0' as plain, '0' as pikop, 
 						'0' as pspsi, '0' as putang, '0' as dldobat, '0' as tkpajak, '0' as ttpajak, 
 						'0' as pduka, '0' as utambahan, '0' as btransfer, '0' as dendaik, '0' as plbhbayar, 
 						'0' as pgp, '0' as tlain, null as xduka, '-' as ket, 0 as cicil, '0' as ubs, 
 						'' as ubs_rp, '0' as um_puasa, b.noind_baru as noind_baru, '01' as jns_transaksi, 
 						'0' as angg_jkn, '0' as potongan_str, '0' as tambahan_str, '0' as reff_id, 
 						(select lokasi_kerja from hrd_khs.tlokasi_kerja where ID_ = b.lokasi_kerja) as lokasi_krj, 
 						'0' as ipet, 0 as um_cabang, null as susulan, 0 as jml_jkn, 0 as jml_jht, 0 as jml_jp,c.seksi
				from hrd_khs.tpribadi b 
				left join hrd_khs.tseksi c 
				on b.kodesie = c.kodesie
				where left(b.noind,1) in ($kode_noind)
				and b.noind in ($noind)";
		return $this->personalia->query($sql)->result_array();
	}
	
	public function cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai){
		$jam_ijin = 0;
		// echo $jam_ijin;
		// echo $keluar;exit();
		if ($keluar >= $ist_mulai && $masuk >= $ist_mulai) {
			if ($ist_selesai <= $keluar && $ist_selesai <= $masuk) {
				$lama_ijin = $masuk - $keluar;
				// $lama_ist = $ist_selesai - $ist_mulai;
				// $jam_ijin = $lama_ijin - $lama_ist;
				$jam_ijin = $lama_ijin;
				// 	echo "hai";
				// echo $jam_ijin;
				// exit();
			}else if($keluar >= $ist_selesai && $masuk >= $ist_selesai){
				$jam_ijin = $masuk - $keluar;
			}else if($masuk >= $ist_selesai){
				$jam_ijin = $masuk - $ist_selesai;
			}
		}else if($keluar <= $ist_mulai && $masuk >= $ist_mulai){
			if ($ist_selesai >= $keluar && $ist_selesai >= $masuk) {
				if ($keluar <= $break_mulai && $keluar <= $break_selesai) {
					$setelah_break = $masuk - $break_selesai;
					$sebelum_break = $break_mulai - $keluar;
					$jam_ijin = $setelah_break + $sebelum_break;
				}else if($keluar > $break_mulai && $masuk){
					$jam_ijin = $ist_mulai - $break_selesai;
				}else{
					$jam_ijin = $ist_mulai - $keluar;
					if ($jam_ijin <= 30) {
						$jam_ijin = 0;
					}
				}
			}else if($keluar <= $ist_selesai && $masuk > $ist_selesai){
				if ($keluar <= $break_mulai) {
					$sebelum_break = $break_mulai - $keluar;
					$setelah_break = $ist_mulai - $break_selesai;
					$setelah_ist = $masuk - $ist_selesai;
					if ($sebelum_break < 0) {
						$sebelum_break = 0;
					}
					if ($setelah_break < 0) {
						$setelah_break = 0;
					}
					if ($setelah_ist < 0) {
						$setelah_ist = 0;
					}
					$jam_ijin = $sebelum_break + $setelah_break + $setelah_ist;
				}else if( $keluar >= $break_selesai){
					$sebelum_ist = $ist_mulai - $keluar;
					$setelah_ist = $masuk - $ist_selesai;
					$jam_ijin = $sebelum_ist + $setelah_ist;
				}else if($keluar >= $break_mulai && $keluar <= $break_selesai){
					$sebelum_ist = $ist_mulai - $break_selesai;
					$setelah_ist = $masuk - $ist_selesai;
					$jam_ijin = $sebelum_ist + $setelah_ist;
				}
			}
		}else{
			if ($keluar >= $break_mulai && $masuk >= $break_mulai) {
				if ($break_selesai >= $keluar && $break_selesai >= $masuk) {
					$jam_ijin = 0;
				}else if($keluar >= $break_selesai && $masuk >= $break_selesai){
					$jam_ijin = $masuk - $keluar;
				}else{
					$jam_ijin = $masuk - $break_selesai;
				}
			}else if($keluar <= $break_mulai && $masuk >= $break_mulai){
				if ($break_selesai >= $keluar && $break_selesai >= $masuk) {
					$jam_ijin = $break_mulai - $keluar;
				}else{
					$sebelum_break = $break_mulai - $keluar;
					$setelah_break = $masuk - $break_selesai;
					$jam_ijin = $setelah_break + $sebelum_break;
				}
			}else{
				$jam_ijin = $masuk - $keluar;
			}
		}
		if ($jam_ijin > 0 && $jam_ijin < 60) {
			$jam_ijin = $jam_ijin/60;
		}else if($jam_ijin >= 60){
			$jam_ijin = $jam_ijin/60;
		}
		// echo $jam_ijin."<br>";
		return $jam_ijin;
	}
	
	public function cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai){
		$hasil = false;
		if ($keluar < $ist_mulai && $keluar < $ist_selesai) {
			if($masuk <= $ist_selesai) {
				$hit = $ist_selesai - $keluar;
				if ($hit <= 1800) {
					$hasil = true;
				}else{
					$hasil = false;
				}
			}
		}
		return $hasil;
	}

	public function insertMemo($data){
		$this->personalia->insert('"Presensi".tcutoff_custom_memo',$data);
	}

	public function insertMemoDetail($data){
		$this->personalia->insert('"Presensi".tcutoff_custom_memo_detail',$data);
	}

	public function getMemoID($dibuat,$periode,$nomor_surat,$mengetahui,$to_staff,$to_nonstaff,$file_staff,$file_nonstaff){
		$sql = "select * 
				from \"Presensi\".tcutoff_custom_memo 
				where nomor_surat = '$nomor_surat' and 
				mengetahui = '$mengetahui' and 
				kepada_staff = '$to_staff' and 
				kepada_nonstaff = '$to_nonstaff' and 
				created_by = '$dibuat' and 
				file_staff = '$file_staff' and 
				file_nonstaff = '$file_nonstaff' and 
				periode = '$periode'";
		return $this->personalia->query($sql)->row()->id_memo;
	}

	public function deleteMemo($id){
		$sql = "update \"Presensi\".tcutoff_custom_memo set status = 2 where id_memo = $id ";
		$this->personalia->query($sql);
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
				kepada_nonstaff,kepada_staff, file_staff, file_nonstaff, nomor_surat, periode, created_timestamp,id_memo
				from \"Presensi\".tcutoff_custom_memo a 
				where a.status = 1
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

	public function getPeriodeCutoffSusulan(){
		$sql = "select periode ,
					(
						select count(*) 
						from \"Presensi\".tcutoff_custom_susulan b 
						where b.periode = a.periode
					) as jumlah 
				from \"Presensi\".tcutoff a 
				group by periode
				order by periode desc ";
		return $this->personalia->query($sql)->result_array();
	}

	public function getDetailCutoffSusulan($periode){
		$sql = "select a.noind,b.nama,c.seksi,concat(a.created_by,' (',to_char(a.created_timestamp,'yyyy-mm-dd'),')') as dibuat
				from \"Presensi\".tcutoff_custom_susulan a 
				inner join hrd_khs.tpribadi b 
				on a.noind = b.noind 
				inner join hrd_khs.tseksi c 
				on b.kodesie = c.kodesie
				where periode = '$periode'";
		return $this->personalia->query($sql)->result_array();		
	}

	public function cekCutoffSusulan($noind,$periode){
		$sql = "select *
				from \"Presensi\".tcutoff_custom_susulan 
				where noind = '$noind' and periode ='$periode'";
		return $this->personalia->query($sql)->result_array();
	}
	public function insertCutOffSusulan($noind,$periode,$user){
		$sql = "insert into \"Presensi\".tcutoff_custom_susulan
				(noind,created_by,noind_baru,periode)
				select noind,'$user',noind_baru,'$periode'
				from hrd_khs.tpribadi 
				where noind = '$noind'";
		$this->personalia->query($sql);
	}

	public function hapusPekerjaCutoffSusulan($periode,$noind){
		$sql = "delete from \"Presensi\".tcutoff_custom_susulan
				where noind = '$noind' and periode = '$periode'";
		$this->personalia->query($sql);
	}

	public function getPekerjaCutoffAll($periode){
		$sql = "select tbl.asal, tp.noind, tp.nama, 
					case when tp.keluar = '0' then 'Pekerja Aktif' 
					else concat('Keluar ',tp.tglkeluar::date) 
					end as status_keluar,
					ts.seksi
				from (
				select 'Cutoff Terproses' as asal,noind 
				from \"Presensi\".tcutoff_custom_terproses 
				where terakhir = '1'
				and to_char(tanggal_proses,'yyyymm') = '$periode'
				union 
				select 'Cutoff Susulan' as asal,noind 
				from \"Presensi\".tcutoff_custom_susulan
				where periode = '$periode'
				) as tbl 
				left join hrd_khs.tpribadi tp 
				on tbl.noind = tp.noind
				left join hrd_khs.tseksi ts
				on tp.kodesie = ts.kodesie
				where tp.keluar = '0' or  (
					(
						tp.tglkeluar < (
											select tanggal_akhir + interval '1 day' 
											from \"Presensi\".tcutoff 
											where periode = '$periode' limit 1
										) 
						or tp.tglkeluar >= concat(
												left('$periode',4),
												'-',
												right('$periode',2),'-01'
											)::date + interval '1 month'
					)  
					and tp.keluar = '1'
				)
				order by tbl.noind";
		return $this->personalia->query($sql)->result_array();
	}

	public function getcutoffByPeriode($periode){
		$sql = "select tanggal_akhir::date as tanggal_akhir
				from \"Presensi\".tcutoff 
				where periode = '$periode'";
		$result = $this->personalia->query($sql)->row();
		if (!empty($result)) {
			return $result->tanggal_akhir;
		}else{
			return substr($periode,0,4).'-'.substr($periode, 4,2).'-20';
		}
	}

	public function hitung_if_dipilih($periode,$noind){
		$nilai = 0;
		$sql = "select tanggal_awal::date as tanggal_awal,tanggal_akhir::date as tanggal_akhir 
				from \"Presensi\".tcutoff 
				where periode = to_char(to_char('$periode'::date,'yyyy-mm-01')::date + interval '1 month','yyyymm')";
		$cutoff = $this->personalia->query($sql)->row();
		$cutoff_awal = $cutoff->tanggal_awal;
		$cutoff_akhir = $cutoff->tanggal_akhir;

		$sql = "select noind,
					(
						select count(distinct tanggal)
						from \"Presensi\".tdatapresensi b
						where b.noind = a.noind
						and b.tanggal between to_char('$cutoff_akhir'::date,'yyyy-mm-01')::date and '$cutoff_akhir'::date
						and trim(b.kd_ket) in ('PKJ','PDL','PDB','PLB','PID','PSK', 'PSP', 'CT', 'CB', 'CBA', 'CD', 'CH', 'CIK', 'CIM', 'CK', 'CM', 'CPA', 'CPP', 'CS', 'PCZ', 'PRM', 'PKK' )
					)  -
					(select count(tanggal) as jml from
					(
						SELECT b.tanggal FROM \"Presensi\".TDataTIM b
						WHERE b.noind = a.noind
						AND b.tanggal between '$cutoff_awal'::date AND to_char('$cutoff_akhir'::date,'yyyy-mm-01')::date - interval '1 day'
						AND (b.kd_ket = 'TM')
						UNION
						SELECT c.tanggal from \"Presensi\".TDataPresensi c
						WHERE c.noind = a.noind
						AND c.tanggal between '$cutoff_awal'::date AND to_char('$cutoff_akhir'::date,'yyyy-mm-01')::date - interval '1 day'
						AND (
								c.kd_ket = 'PSK' 
								or c.kd_ket = 'PRM'
								or c.kd_ket = 'PIP'
								or left(c.kd_ket,1) = 'C'
								or c.kd_ket = 'PCZ'
							)
						) as DERIVEDTBL
					)
					as total
				from hrd_khs.tpribadi a
				where a.noind = '$noind'";
				// echo $sql."<br>";exit();
		$result1 = $this->personalia->query($sql)->result_array();

		$sql = "SELECT a.tanggal, a.noind,
						concat(a.tanggal::date,' ',a.keluar)::timestamp as keluar,
						case when a.masuk::time < a.keluar::time then
							concat((a.tanggal + interval '1 day')::date,' ',a.masuk)::timestamp
						else
							concat(a.tanggal::date,' ',a.masuk)::timestamp
						end as masuk,
						a.kd_ket,
						b.jam_kerja,
						case when b.jam_msk::time > b.ist_mulai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.ist_mulai)::timestamp
						else
							concat(a.tanggal::date,' ',b.ist_mulai)::timestamp
						end as ist_mulai,
						case when b.jam_msk::time > b.ist_selesai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.ist_selesai)::timestamp
						else
							concat(a.tanggal::date,' ',b.ist_selesai)::timestamp
						end as ist_selesai,
						case when b.jam_msk::time > b.break_mulai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.break_mulai)::timestamp
						else
							concat(a.tanggal::date,' ',b.break_mulai)::timestamp
						end as break_mulai,
						case when b.jam_msk::time > b.break_selesai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.break_selesai)::timestamp
						else
							concat(a.tanggal::date,' ',b.break_selesai)::timestamp
						end as break_selesai
				FROM \"Presensi\".TDataTIM a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal >= '$cutoff_awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= to_char('$cutoff_akhir'::date,'yyyy-mm-01')::date - interval '1 day')
				UNION
				SELECT a.tanggal, a.noind,
								concat(a.tanggal::date,' ',a.keluar)::timestamp as keluar,
								case when a.masuk::time < a.keluar::time then
									concat((a.tanggal + interval '1 day')::date,' ',a.masuk)::timestamp
								else
									concat(a.tanggal::date,' ',a.masuk)::timestamp
								end as masuk,
								a.kd_ket,
								b.jam_kerja,
								case when b.jam_msk::time > b.ist_mulai::time then
									concat((a.tanggal + interval '1 day')::date,' ',b.ist_mulai)::timestamp
								else
									concat(a.tanggal::date,' ',b.ist_mulai)::timestamp
								end as ist_mulai,
								case when b.jam_msk::time > b.ist_selesai::time then
									concat((a.tanggal + interval '1 day')::date,' ',b.ist_selesai)::timestamp
								else
									concat(a.tanggal::date,' ',b.ist_selesai)::timestamp
								end as ist_selesai,
								case when b.jam_msk::time > b.break_mulai::time then
									concat((a.tanggal + interval '1 day')::date,' ',b.break_mulai)::timestamp
								else
									concat(a.tanggal::date,' ',b.break_mulai)::timestamp
								end as break_mulai,
								case when b.jam_msk::time > b.break_selesai::time then
									concat((a.tanggal + interval '1 day')::date,' ',b.break_selesai)::timestamp
								else
									concat(a.tanggal::date,' ',b.break_selesai)::timestamp
								end as break_selesai
						FROM \"Presensi\".TDataPresensi a INNER JOIN
						\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
						WHERE (a.tanggal >= to_char('$cutoff_akhir'::date,'yyyy-mm-01')::date) AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND (a.tanggal <= '$cutoff_akhir')
				ORDER BY tanggal";
		$result2 = $this->personalia->query($sql)->result_array();
		$nilai = $result1['0']['total'];
		$simpan_tgl = "";
		$lanjut = false;
		foreach ($result2 as $tik) {
			if ($tik['tanggal'] !== $simpan_tgl) {
				$lanjut = false;
			}
			$keluar = strtotime($tik['keluar']);
			$masuk = strtotime($tik['masuk']);
			$ist_mulai = strtotime($tik['ist_mulai']);
			$ist_selesai = strtotime($tik['ist_selesai']);
			$break_mulai = strtotime($tik['break_mulai']);
			$break_selesai = strtotime($tik['break_selesai']);
			if ($ist_mulai < $break_mulai) {
				$simpan_ist_mulai = $ist_mulai;
				$simpan_ist_selesai = $ist_selesai;
				$ist_mulai = $break_mulai;
				$ist_selesai = $break_selesai;
				$break_mulai = $simpan_ist_mulai;
				$break_selesai = $simpan_ist_selesai;
			}

			$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai) / ($tik['jam_kerja'] * 60);
			$ijin = number_format($ijin, 2);
			// echo "ijine:".$ijin."<br>";
			if ($ijin <= 0) {
				$nilai = $nilai;
			}else if($ijin > 0 && $ijin <= 30){
				$cek_denda = $this->cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai);
				if ($cek_denda == false) {
					if($lanjut == false) {
						$nilai -= $ijin;
					}
				}
			}else{
				if($lanjut == false){
					$nilai -= $ijin;
				}
			}

			$simpan_tgl = $tik['tanggal'];
		}

		return $nilai;
	}

	public function hitung_htm_dipilih($periode,$noind){
		$nilai = 0;
		$sql = "select tanggal_awal::date as tanggal_awal,tanggal_akhir::date as tanggal_akhir 
				from \"Presensi\".tcutoff 
				where periode = to_char(to_char('$periode'::date,'yyyy-mm-01')::date + interval '1 month','yyyymm')";
		$cutoff = $this->personalia->query($sql)->row();
		$cutoff_awal = $cutoff->tanggal_awal;
		$cutoff_akhir = $cutoff->tanggal_akhir;

		$sql = "select noind,
						(30 -
						(extract(day from a.tglkeluar) - 1) +
						(select count(tanggal) as jml from
							(
							SELECT b.tanggal FROM \"Presensi\".TDataTIM b
							WHERE b.noind = a.noind
							AND b.tanggal between to_char('$cutoff_akhir'::date,'yyyy-mm-01')::date AND '$cutoff_akhir'::date
							AND (b.kd_ket = 'TM')
							) as DERIVEDTBL
						) +
						(select count(tanggal) as jml from
							(
							SELECT b.tanggal FROM \"Presensi\".TDataTIM b
							WHERE b.noind = a.noind
							AND b.tanggal between '$cutoff_awal'::date AND to_char('$cutoff_akhir'::date,'yyyy-mm-01')::date - interval '1 day'
							AND (b.kd_ket = 'TM')
							) as DERIVEDTBL
						)
						) as total
				from hrd_khs.tpribadi a
				where noind = '$noind'";
		$result1 = $this->personalia->query($sql)->result_array();

		$sql = "SELECT a.tanggal, a.noind,
						concat(a.tanggal::date,' ',a.keluar)::timestamp as keluar,
						case when a.masuk::time < a.keluar::time then
							concat((a.tanggal + interval '1 day')::date,' ',a.masuk)::timestamp
						else
							concat(a.tanggal::date,' ',a.masuk)::timestamp
						end as masuk,
						a.kd_ket,
						b.jam_kerja,
						case when b.jam_msk::time > b.ist_mulai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.ist_mulai)::timestamp
						else
							concat(a.tanggal::date,' ',b.ist_mulai)::timestamp
						end as ist_mulai,
						case when b.jam_msk::time > b.ist_selesai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.ist_selesai)::timestamp
						else
							concat(a.tanggal::date,' ',b.ist_selesai)::timestamp
						end as ist_selesai,
						case when b.jam_msk::time > b.break_mulai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.break_mulai)::timestamp
						else
							concat(a.tanggal::date,' ',b.break_mulai)::timestamp
						end as break_mulai,
						case when b.jam_msk::time > b.break_selesai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.break_selesai)::timestamp
						else
							concat(a.tanggal::date,' ',b.break_selesai)::timestamp
						end as break_selesai
				FROM \"Presensi\".TDataTIM a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal >= to_char('$cutoff_akhir'::date,'yyyy-mm-01')::date) AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$cutoff_akhir')
				ORDER BY tanggal";

		$result2 = 	$this->personalia->query($sql)->result_array();
		$nilai = $result1['0']['total'];
		$simpan_tgl = "";
		$lanjut = false;
		foreach ($result2 as $tik) {
			if ($tik['tanggal'] !== $simpan_tgl) {
				$lanjut = false;
			}
			$keluar = strtotime($tik['keluar']);
			$masuk = strtotime($tik['masuk']);
			$ist_mulai = strtotime($tik['ist_mulai']);
			$ist_selesai = strtotime($tik['ist_selesai']);
			$break_mulai = strtotime($tik['break_mulai']);
			$break_selesai = strtotime($tik['break_selesai']);
			if ($ist_mulai < $break_mulai) {
				$simpan_ist_mulai = $ist_mulai;
				$simpan_ist_selesai = $ist_selesai;
				$ist_mulai = $break_mulai;
				$ist_selesai = $break_selesai;
				$break_mulai = $simpan_ist_mulai;
				$break_selesai = $simpan_ist_selesai;
			}

			$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai) / ($tik['jam_kerja'] * 60);
			$ijin = number_format($ijin, 2);
			$nilai += $ijin;

			$simpan_tgl = $tik['tanggal'];
		}

		$sql = "SELECT a.tanggal, a.noind,
						concat(a.tanggal::date,' ',a.keluar)::timestamp as keluar,
						case when a.masuk::time < a.keluar::time then
							concat((a.tanggal + interval '1 day')::date,' ',a.masuk)::timestamp
						else
							concat(a.tanggal::date,' ',a.masuk)::timestamp
						end as masuk,
						a.kd_ket,
						b.jam_kerja,
						case when b.jam_msk::time > b.ist_mulai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.ist_mulai)::timestamp
						else
							concat(a.tanggal::date,' ',b.ist_mulai)::timestamp
						end as ist_mulai,
						case when b.jam_msk::time > b.ist_selesai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.ist_selesai)::timestamp
						else
							concat(a.tanggal::date,' ',b.ist_selesai)::timestamp
						end as ist_selesai,
						case when b.jam_msk::time > b.break_mulai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.break_mulai)::timestamp
						else
							concat(a.tanggal::date,' ',b.break_mulai)::timestamp
						end as break_mulai,
						case when b.jam_msk::time > b.break_selesai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.break_selesai)::timestamp
						else
							concat(a.tanggal::date,' ',b.break_selesai)::timestamp
						end as break_selesai
				FROM \"Presensi\".TDataTIM a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal >= '$cutoff_awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= to_char('$cutoff_akhir'::date,'yyyy-mm-01')::date - interval '1 day')
				ORDER BY tanggal";

		$result3 = 	$this->personalia->query($sql)->result_array();
		$simpan_tgl = "";
		$lanjut = false;
		foreach ($result3 as $tik) {
			if ($tik['tanggal'] !== $simpan_tgl) {
				$lanjut = false;
			}
			$keluar = strtotime($tik['keluar']);
			$masuk = strtotime($tik['masuk']);
			$ist_mulai = strtotime($tik['ist_mulai']);
			$ist_selesai = strtotime($tik['ist_selesai']);
			$break_mulai = strtotime($tik['break_mulai']);
			$break_selesai = strtotime($tik['break_selesai']);
			if ($ist_mulai < $break_mulai) {
				$simpan_ist_mulai = $ist_mulai;
				$simpan_ist_selesai = $ist_selesai;
				$ist_mulai = $break_mulai;
				$ist_selesai = $break_selesai;
				$break_mulai = $simpan_ist_mulai;
				$break_selesai = $simpan_ist_selesai;
			}

			$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai) / ($tik['jam_kerja'] * 60);
			$ijin = number_format($ijin, 2);
			$nilai += $ijin;

			$simpan_tgl = $tik['tanggal'];
		}

		return $nilai;
	}

	public function hitung_htm_aktif($periode){
		$sql = "select extract(day from tanggal_akhir) as jumlah
				from \"Presensi\".tcutoff t 
				where periode = to_char('$periode'::date,'yyyymm')
				and os='0'";
		$result = $this->personalia->query($sql)->row();
		if (!empty($result)) {
			return $result->jumlah;
		}else{
			return 0;
		}
	}

	public function hitung_if_aktif($periode){
		$sql = "select count(*) as jumlah
				from pg_catalog.generate_series(
						'$periode'::date + interval '1 day',
						to_char('$periode'::date,'yyyy-mm-01')::date + interval '1 month' - interval '1 day',
						interval '1 day'
					) as dates  
				left join \"Dinas_Luar\".tlibur tl 
				on dates.dates = tl.tanggal 
				where tl.tanggal is null 
				and extract(isodow from dates.dates) != 7";
		$result = $this->personalia->query($sql)->row();
		if (!empty($result)) {
			return $result->jumlah;
		}else{
			return 0;
		}
	}

}
?>