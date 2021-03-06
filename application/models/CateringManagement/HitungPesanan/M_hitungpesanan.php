<?php
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 * 
 */
class M_hitungpesanan extends Ci_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia',TRUE);
		$this->spl = $this->load->database('quickcom',TRUE);
		$this->erp = $this->load->database('erp_db',TRUE);
	}

	public function getFinger($userid){
		$sql = "select * from splseksi.tfinger_php tf
				inner join fp_distribusi.tb_jari tj
				on tj.id_finger = tf.kd_finger
				where tf.user_id = ?";
		return $this->spl->query($sql,$userid)->result_array();
	}

	public function show_finger_user($fill){
		$this->spl->where($fill);
		$query = $this->spl->get('splseksi.tfinger_php');
		return $query->row();
	}

	public function show_finger_activation($filter){
		$this->spl->where($filter);
		$query = $this->spl->get('splseksi.tcode_fingerprint');
		return $query->row();
	}

	public function getFingerName($jari){
		$sql = "select jari 
				from fp_distribusi.tb_jari 
				where id_finger = ?";
		$query = $this->spl->query($sql,$jari);
		return $query->row()->jari;
	}

	public function getPesananByTanggalShiftLokasi($tanggal,$shift,$lokasi){
		$sql = "select *
				from \"Catering\".tpesanan
				where fd_tanggal = ?
				and fs_kd_shift = ?
				and lokasi = ?";
		return $this->personalia->query($sql,array($tanggal,$shift,$lokasi))->result_array();
	}

	public function getKateringByLokasi($lokasi){
		$sql = "select fs_kd_katering
				from \"Catering\".tkatering 
				where fb_status = '1' 
				and lokasi_kerja::int::varchar = ?";
		return $this->personalia->query($sql,array($lokasi))->result_array();
	}

	public function getJadwalByTanggalLokasi($tanggal,$lokasi){
		$sql = "select fs_kd_katering 
			    from \"Catering\".tjadwal 
			    where fd_tanggal = ?
			    and lokasi = ?
			    group by fs_kd_katering";
		return $this->personalia->query($sql,array($tanggal,$lokasi))->result_array();
	}

	public function getBatasDatangByTanggalShift($tanggal,$shift){
		$sql = "select * 
				 from \"Catering\".tbatas_datang_shift 
				 where fs_hari = extract(isodow from ?::date)::varchar
				 and fs_kd_shift = ? ";
 		return $this->personalia->query($sql,array($tanggal,$shift))->result_array();
	}

	public function getAbsenShiftSatuByTanggalLokasi($tanggal,$lokasi,$jenis){
		if ($jenis == "Snack") {
			$sql = "select 	tempat_makan, count(tempat_makan) as jumlah 
					from (
							select 	trim(tpres.noind) as noind, 
									tpri.tempat_makan as tempat_makan, 
									count(tpri.tempat_makan) as jumlah_karyawan 
							from hrd_khs.tpribadi tpri
							inner join \"Catering\".tpresensi tpres 
								ON trim(tpres.noind) = trim(tpri.noind) 
								and left(tpres.waktu, 5) >= (
									 select left(fs_jam_awal,5)
									 from \"Catering\".tbatas_datang_shift 
									 where fs_kd_shift = '1' 
									 and fs_hari = (extract(dow from ?::date)+1)::varchar
								)
								and left(tpres.waktu, 5) <= (
									 select left(fs_jam_akhir,5)
									 from \"Catering\".tbatas_datang_shift 
									 where fs_kd_shift = '1' 
									 and fs_hari = (extract(dow from ?::date)+1)::varchar
								) 
								and tpres.tanggal = ?
							inner join \"Catering\".ttempat_makan tmkn 
								on tpri.tempat_makan = tmkn.fs_tempat_makan 
								and tmkn.fs_lokasi = ?
							Where 
							trim(tpres.noind) not in (
								select trim(fs_noind) as noind 
								from \"Catering\".tpuasa 
								where fd_tanggal = ?::date
								and fb_status = '1'
							) 
							and trim(tpres.noind) not in (
								select trim(noind) as noind 
								from \"Presensi\".tshiftPekerja 
								where tanggal in (?::date - interval '1 day', ?::date) 
								and kd_shift in ('3', '12')
							) 
							and left(trim(tpres.noind), 1) not in ('M','Z') 
							and trim(tpres.noind) not in (
								select distinct trim(t.noind) as noind 
								from \"Presensi\".tshiftpekerja t  
								where kd_shift = '2' 
								and tanggal = ?::date - interval '1 day' 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and ts.waktu::time < t.jam_msk::time + interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) > 0 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) = 1
							) 
							group by tpri.tempat_makan, trim(tpres.noind)
						) derivedtbl 
					group by tempat_makan 
					order by tempat_makan, jumlah ";
			return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$lokasi,$tanggal,$tanggal,$tanggal,$tanggal))->result_array();
		}else{
			$sql = "select 	tempat_makan, count(tempat_makan) as jumlah 
					from (
							select 	trim(tpres.noind) as noind, 
									tpri.tempat_makan as tempat_makan, 
									count(tpri.tempat_makan) as jumlah_karyawan 
							from hrd_khs.tpribadi tpri
							inner join \"Catering\".tpresensi tpres 
								ON trim(tpres.noind) = trim(tpri.noind) 
								and left(tpres.waktu, 5) >= (
									 select left(fs_jam_awal,5)
									 from \"Catering\".tbatas_datang_shift 
									 where fs_kd_shift = '1' 
									 and fs_hari = (extract(dow from ?::date)+1)::varchar
								)
								and left(tpres.waktu, 5) <= (
									 select left(fs_jam_akhir,5)
									 from \"Catering\".tbatas_datang_shift 
									 where fs_kd_shift = '1' 
									 and fs_hari = (extract(dow from ?::date)+1)::varchar
								) 
								and tpres.tanggal = ?
							inner join \"Catering\".ttempat_makan tmkn 
								on tpri.tempat_makan = tmkn.fs_tempat_makan 
								and tmkn.fs_lokasi = ?
							Where 
							trim(tpres.noind) not in (
								select trim(fs_noind) as noind 
								from \"Catering\".tpuasa 
								where fd_tanggal = ?::date
								and fb_status = '1'
							) 
							and trim(tpres.noind) not in (
								select trim(noind) as noind 
								from \"Presensi\".tshiftPekerja 
								where tanggal in (?::date - interval '1 day', ?::date) 
								and kd_shift in ('3', '12')
							) 
							and left(trim(tpres.noind), 1) not in ('M','Z') 
							and trim(tpres.noind) not in (
								select distinct trim(t.noind) as noind 
								from \"Presensi\".tshiftpekerja t  
								where kd_shift = '2' 
								and tanggal = ?::date - interval '1 day' 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and ts.waktu::time < t.jam_msk::time + interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) > 0 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) = 1
							) 
							group by tpri.tempat_makan, trim(tpres.noind)
							union 
							select trim(a.noind) as noind,a.tempat_makan,count(a.tempat_makan) as jumlah_karyawan 
							from hrd_khs.tpribadi a 
							inner join \"Presensi\".tshiftpekerja b 
								on trim(a.noind)=trim(b.noind) 
							inner join \"Catering\".ttempat_makan tmkn 
								on a.tempat_makan = tmkn.fs_tempat_makan 
								and tmkn.fs_lokasi = ?
							left join \"Catering\".tpuasa p 
								on b.tanggal=p.fd_tanggal 
								and trim(b.noind)=trim(p.fs_noind) 
							where b.tanggal = ? 
								and b.kd_shift in('5','8','18') 
								and (
									p.fb_status is null 
									or p.fb_status<>'1'
								) 
							group by a.tempat_makan, a.nama,trim(a.noind),b.jam_msk
							union
							select noind, tempat_makan, count(*)
							from hrd_khs.tpribadi a
							inner join \"Catering\".ttempat_makan tmkn 
								on a.tempat_makan = tmkn.fs_tempat_makan 
								and tmkn.fs_lokasi = ?
							where noind = 'G1043'
							and (
								select count(*)
								from \"Catering\".tpresensi b 
								where b.noind = a.noind
								and b.tanggal = ?
								and left(b.waktu, 5) >= (
									select left(c.fs_jam_akhir,5)
									from \"Catering\".tbatas_datang_shift c
									where c.fs_kd_shift = '1' 
									and c.fs_hari = (extract(dow from b.tanggal::date)+1)::varchar
								) 
								and left(b.waktu,5) <= (
									select left(d.jam_akhmsk,5)
									from \"Presensi\".tjamshift d
									where d.kd_shift = '8'
									and d.hari = (
										case extract(dow from b.tanggal::date)
											when 0 then 'Minggu'
											when 1 then 'Senin'
											when 2 then 'Selasa'
											when 3 then 'Rabu'
											when 4 then 'Kamis'
											when 5 then 'Jumat'
											when 6 then 'Sabtu'
										end
									)
								)
							) > 0
							group by a.noind, a.tempat_makan
						) derivedtbl 
					group by tempat_makan 
					order by tempat_makan, jumlah ";
			return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$lokasi,$tanggal,$tanggal,$tanggal,$tanggal,$lokasi,$tanggal,$lokasi,$tanggal))->result_array();
		}
	}

	public function getAbsenShiftSatuStaffByTanggalLokasiTempatMakan($tanggal,$lokasi,$tempat_makan,$jenis){
		if ($jenis == "Snack") {
			$sql = "select 	tempat_makan, count(tempat_makan) as jumlah 
					from (
							select 	trim(tpres.noind) as noind, 
									tpri.tempat_makan as tempat_makan, 
									count(tpri.tempat_makan) as jumlah_karyawan 
							from hrd_khs.tpribadi tpri
							inner join \"Catering\".tpresensi tpres 
								ON trim(tpres.noind) = trim(tpri.noind) 
								and left(tpres.waktu, 5) >= (
									 select left(fs_jam_awal,5)
									 from \"Catering\".tbatas_datang_shift 
									 where fs_kd_shift = '1' 
									 and fs_hari = (extract(dow from ?::date)+1)::varchar
								)
								and left(tpres.waktu, 5) <= (
									 select left(fs_jam_akhir,5)
									 from \"Catering\".tbatas_datang_shift 
									 where fs_kd_shift = '1' 
									 and fs_hari = (extract(dow from ?::date)+1)::varchar
								) 
								and tpres.tanggal = ?
							inner join \"Catering\".ttempat_makan tmkn 
								on tpri.tempat_makan = tmkn.fs_tempat_makan 
								and tmkn.fs_lokasi = ?
							Where 
							trim(tpres.noind) not in (
								select trim(fs_noind) as noind 
								from \"Catering\".tpuasa 
								where fd_tanggal = ?::date
								and fb_status = '1'
							) 
							and trim(tpres.noind) not in (
								select trim(noind) as noind 
								from \"Presensi\".tshiftPekerja 
								where tanggal in (?::date - interval '1 day', ?::date) 
								and kd_shift in ('3', '12')
							) 
							and left(trim(tpres.noind), 1) IN ('B', 'D', 'J', 'L', 'G')
							and trim(tpres.noind) not in (
								select distinct trim(t.noind) as noind 
								from \"Presensi\".tshiftpekerja t  
								where kd_shift = '2' 
								and tanggal = ?::date - interval '1 day' 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and ts.waktu::time < t.jam_msk::time + interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) > 0 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) = 1
							) 
							and tpri.tempat_makan = ?
							group by tpri.tempat_makan, trim(tpres.noind)
						) derivedtbl 
					group by tempat_makan 
					order by tempat_makan, jumlah ";
			return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$lokasi,$tanggal,$tanggal,$tanggal,$tanggal,$tempat_makan))->result_array();
		}else{
			$sql = "select 	tempat_makan, count(tempat_makan) as jumlah 
					from (
							select 	trim(tpres.noind) as noind, 
									tpri.tempat_makan as tempat_makan, 
									count(tpri.tempat_makan) as jumlah_karyawan 
							from hrd_khs.tpribadi tpri
							inner join \"Catering\".tpresensi tpres 
								ON trim(tpres.noind) = trim(tpri.noind) 
								and left(tpres.waktu, 5) >= (
									 select left(fs_jam_awal,5)
									 from \"Catering\".tbatas_datang_shift 
									 where fs_kd_shift = '1' 
									 and fs_hari = (extract(dow from ?::date)+1)::varchar
								)
								and left(tpres.waktu, 5) <= (
									 select left(fs_jam_akhir,5)
									 from \"Catering\".tbatas_datang_shift 
									 where fs_kd_shift = '1' 
									 and fs_hari = (extract(dow from ?::date)+1)::varchar
								) 
								and tpres.tanggal = ?
							inner join \"Catering\".ttempat_makan tmkn 
								on tpri.tempat_makan = tmkn.fs_tempat_makan 
								and tmkn.fs_lokasi = ?
							Where 
							trim(tpres.noind) not in (
								select trim(fs_noind) as noind 
								from \"Catering\".tpuasa 
								where fd_tanggal = ?::date
								and fb_status = '1'
							) 
							and trim(tpres.noind) not in (
								select trim(noind) as noind 
								from \"Presensi\".tshiftPekerja 
								where tanggal in (?::date - interval '1 day', ?::date) 
								and kd_shift in ('3', '12')
							) 
							and left(trim(tpres.noind), 1) IN ('B', 'D', 'J', 'L', 'G')
							and trim(tpres.noind) not in (
								select distinct trim(t.noind) as noind 
								from \"Presensi\".tshiftpekerja t  
								where kd_shift = '2' 
								and tanggal = ?::date - interval '1 day' 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and ts.waktu::time < t.jam_msk::time + interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) > 0 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) = 1
							) 
							and tpri.tempat_makan = ?
							group by tpri.tempat_makan, trim(tpres.noind)
							union 
							select trim(a.noind) as noind,a.tempat_makan,count(a.tempat_makan) as jumlah_karyawan 
							from hrd_khs.tpribadi a 
							inner join \"Presensi\".tshiftpekerja b 
								on trim(a.noind)=trim(b.noind) 
							inner join \"Catering\".ttempat_makan tmkn 
								on a.tempat_makan = tmkn.fs_tempat_makan 
								and tmkn.fs_lokasi = ?
							left join \"Catering\".tpuasa p 
								on b.tanggal=p.fd_tanggal 
								and trim(b.noind)=trim(p.fs_noind) 
							where b.tanggal = ? 
								and b.kd_shift in('5','8','18') 
								and left(trim(a.noind), 1) IN ('B', 'D', 'J', 'L', 'G')
								and (
									p.fb_status is null 
									or p.fb_status<>'1'
								) 
								and a.tempat_makan = ?
							group by a.tempat_makan, a.nama,trim(a.noind),b.jam_msk
							union
							select noind, tempat_makan, count(*)
							from hrd_khs.tpribadi a
							inner join \"Catering\".ttempat_makan tmkn 
								on a.tempat_makan = tmkn.fs_tempat_makan 
								and tmkn.fs_lokasi = ?
							where noind = 'G1043'
							and (
								select count(*)
								from \"Catering\".tpresensi b 
								where b.noind = a.noind
								and b.tanggal = ?
								and left(b.waktu, 5) >= (
									select left(c.fs_jam_akhir,5)
									from \"Catering\".tbatas_datang_shift c
									where c.fs_kd_shift = '1' 
									and c.fs_hari = (extract(dow from b.tanggal::date)+1)::varchar
								) 
								and left(b.waktu,5) <= (
									select left(d.jam_akhmsk,5)
									from \"Presensi\".tjamshift d
									where d.kd_shift = '8'
									and d.hari = (
										case extract(dow from b.tanggal::date)
											when 0 then 'Minggu'
											when 1 then 'Senin'
											when 2 then 'Selasa'
											when 3 then 'Rabu'
											when 4 then 'Kamis'
											when 5 then 'Jumat'
											when 6 then 'Sabtu'
										end
									)
								)
							) > 0
							and a.tempat_makan = ?
							group by a.noind, a.tempat_makan
						) derivedtbl 
					group by tempat_makan 
					order by tempat_makan, jumlah ";
			return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$lokasi,$tanggal,$tanggal,$tanggal,$tanggal,$tempat_makan,$lokasi,$tanggal,$tempat_makan,$lokasi,$tanggal,$tempat_makan))->result_array();
		}
	}

	public function getAbsenShiftSatuByTanggalLokasiTempatMakanNoind($tanggal,$lokasi,$tempat_makan,$noind,$jenis = false){
		if ($jenis == "Snack") {
			$sql = "select *
					from (
							select 	trim(tpres.noind) as noind, 
									tpri.tempat_makan as tempat_makan, 
									count(tpri.tempat_makan) as jumlah_karyawan 
							from hrd_khs.tpribadi tpri
							inner join \"Catering\".tpresensi tpres 
								ON trim(tpres.noind) = trim(tpri.noind) 
								and left(tpres.waktu, 5) >= (
									 select left(fs_jam_awal,5)
									 from \"Catering\".tbatas_datang_shift 
									 where fs_kd_shift = '1' 
									 and fs_hari = (extract(dow from ?::date)+1)::varchar
								)
								and left(tpres.waktu, 5) <= (
									 select left(fs_jam_akhir,5)
									 from \"Catering\".tbatas_datang_shift 
									 where fs_kd_shift = '1' 
									 and fs_hari = (extract(dow from ?::date)+1)::varchar
								) 
								and tpres.tanggal = ?
							inner join \"Catering\".ttempat_makan tmkn 
								on tpri.tempat_makan = tmkn.fs_tempat_makan 
								and tmkn.fs_lokasi = ?
							Where 
							trim(tpres.noind) not in (
								select trim(fs_noind) as noind 
								from \"Catering\".tpuasa 
								where fd_tanggal = ?::date
								and fb_status = '1'
							) 
							and trim(tpres.noind) not in (
								select trim(noind) as noind 
								from \"Presensi\".tshiftPekerja 
								where tanggal in (?::date - interval '1 day', ?::date) 
								and kd_shift in ('3', '12')
							) 
							and left(trim(tpres.noind), 1) not in ('M','Z') 
							and trim(tpres.noind) not in (
								select distinct trim(t.noind) as noind 
								from \"Presensi\".tshiftpekerja t  
								where kd_shift = '2' 
								and tanggal = ?::date - interval '1 day' 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and ts.waktu::time < t.jam_msk::time + interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) > 0 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) = 1
							) 
							and tpri.tempat_makan = ?
							group by tpri.tempat_makan, trim(tpres.noind)
						) derivedtbl 
					where trim(noind) = ?
					order by tempat_makan ";
			return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$lokasi,$tanggal,$tanggal,$tanggal,$tanggal,$tempat_makan,$noind))->result_array();
		}else{
			$sql = "select *
					from (
							select 	trim(tpres.noind) as noind, 
									tpri.tempat_makan as tempat_makan, 
									count(tpri.tempat_makan) as jumlah_karyawan 
							from hrd_khs.tpribadi tpri
							inner join \"Catering\".tpresensi tpres 
								ON trim(tpres.noind) = trim(tpri.noind) 
								and left(tpres.waktu, 5) >= (
									 select left(fs_jam_awal,5)
									 from \"Catering\".tbatas_datang_shift 
									 where fs_kd_shift = '1' 
									 and fs_hari = (extract(dow from ?::date)+1)::varchar
								)
								and left(tpres.waktu, 5) <= (
									 select left(fs_jam_akhir,5)
									 from \"Catering\".tbatas_datang_shift 
									 where fs_kd_shift = '1' 
									 and fs_hari = (extract(dow from ?::date)+1)::varchar
								) 
								and tpres.tanggal = ?
							inner join \"Catering\".ttempat_makan tmkn 
								on tpri.tempat_makan = tmkn.fs_tempat_makan 
								and tmkn.fs_lokasi = ?
							Where 
							trim(tpres.noind) not in (
								select trim(fs_noind) as noind 
								from \"Catering\".tpuasa 
								where fd_tanggal = ?::date
								and fb_status = '1'
							) 
							and trim(tpres.noind) not in (
								select trim(noind) as noind 
								from \"Presensi\".tshiftPekerja 
								where tanggal in (?::date - interval '1 day', ?::date) 
								and kd_shift in ('3', '12')
							) 
							and left(trim(tpres.noind), 1) not in ('M','Z') 
							and trim(tpres.noind) not in (
								select distinct trim(t.noind) as noind 
								from \"Presensi\".tshiftpekerja t  
								where kd_shift = '2' 
								and tanggal = ?::date - interval '1 day' 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and ts.waktu::time < t.jam_msk::time + interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) > 0 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) = 1
							) 
							and tpri.tempat_makan = ?
							group by tpri.tempat_makan, trim(tpres.noind)
							union 
							select trim(a.noind) as noind,a.tempat_makan,count(a.tempat_makan) as jumlah_karyawan 
							from hrd_khs.tpribadi a 
							inner join \"Presensi\".tshiftpekerja b 
								on trim(a.noind)=trim(b.noind) 
							inner join \"Catering\".ttempat_makan tmkn 
								on a.tempat_makan = tmkn.fs_tempat_makan 
								and tmkn.fs_lokasi = ?
							left join \"Catering\".tpuasa p 
								on b.tanggal=p.fd_tanggal 
								and trim(b.noind) =trim(p.fs_noind) 
							where b.tanggal = ? 
								and b.kd_shift in('5','8','18') 
								and left(trim(a.noind), 1) not in ('M','Z') 
								and (
									p.fb_status is null 
									or p.fb_status<>'1'
								) 
								and a.tempat_makan = ?
							group by a.tempat_makan, a.nama,trim(a.noind),b.jam_msk
							union
							select noind, tempat_makan, count(*)
							from hrd_khs.tpribadi a
							inner join \"Catering\".ttempat_makan tmkn 
								on a.tempat_makan = tmkn.fs_tempat_makan 
								and tmkn.fs_lokasi = ?
							where noind = 'G1043'
							and (
								select count(*)
								from \"Catering\".tpresensi b 
								where b.noind = a.noind
								and b.tanggal = ?
								and left(b.waktu, 5) >= (
									select left(c.fs_jam_akhir,5)
									from \"Catering\".tbatas_datang_shift c
									where c.fs_kd_shift = '1' 
									and c.fs_hari = (extract(dow from b.tanggal::date)+1)::varchar
								) 
								and left(b.waktu,5) <= (
									select left(d.jam_akhmsk,5)
									from \"Presensi\".tjamshift d
									where d.kd_shift = '8'
									and d.hari = (
										case extract(dow from b.tanggal::date)
											when 0 then 'Minggu'
											when 1 then 'Senin'
											when 2 then 'Selasa'
											when 3 then 'Rabu'
											when 4 then 'Kamis'
											when 5 then 'Jumat'
											when 6 then 'Sabtu'
										end
									)
								)
							) > 0
							and a.tempat_makan = ?
							group by a.noind, a.tempat_makan
						) derivedtbl 
					where trim(noind) = ?
					order by tempat_makan ";
			return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$lokasi,$tanggal,$tanggal,$tanggal,$tanggal,$tempat_makan,$lokasi,$tanggal,$tempat_makan,$lokasi,$tanggal,$tempat_makan,$noind))->result_array();
		}
	}

	public function getAbsenShiftDuaByTanggalLokasi($tanggal,$lokasi,$jenis){
		if ($jenis == "Snack") {
			$sql = "select tempat_makan, count(tempat_makan) as jumlah 
					from (
						select trim(tpres.noind) as noind, tpri.tempat_makan as tempat_makan, count(tpri.tempat_makan) as jumlah_karyawan 
						from hrd_khs.tpribadi tpri 
						inner join \"Catering\".tpresensi tpres 
							on trim(tpres.noind) = trim(tpri.noind) 
							and left(tpres.waktu, 5) >= (
								 select left(fs_jam_awal,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '2' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							) 
							and left(tpres.waktu, 5) <= (
								 select left(fs_jam_akhir,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '2' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							)  
							and tpres.tanggal = ? 
						inner join \"Catering\".ttempat_makan tmkn 
							on tpri.tempat_makan = tmkn.fs_tempat_makan 
							and tmkn.fs_lokasi = ?
						where trim(tpres.noind) not in (
							select trim(noind) as noind
							from \"Catering\".tpresensi
							where left(waktu, 5) >= (
								 select left(fs_jam_awal,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '1' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							)   
							and left(waktu, 5) <= (
								 select left(fs_jam_akhir,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '1' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							)   
							and tanggal = ?::date
							and trim(noind) not in ( 
								select trim(noind) as noind 
								from (
									select trim(t.noind) as noind, count(trim(t.noind)) as jml 
									from \"Catering\".tpresensi t, \"Presensi\".tshiftPekerja s 
									where t.tanggal in (?::date - interval '1 day', ?::date) 
									and t.waktu < '23:00:00'
									and t.waktu > '20:30:00' 
									and s.kd_shift in ('3', '12')  
									and trim(t.noind) = trim(s.noind) 
									group by trim(t.noind)
								) derivedtbl 
								where jml = '1' and trim(noind) not in (
									select trim(noind) as noind
									from \"Catering\".tpresensi 
									where waktu <= '20:30:00' 
									and waktu >= '11:00:00'
									and tanggal = ?::date
								) 
							) 
							and trim(tpres.noind) not in (
								select distinct trim(t.noind) as noind
								from \"Presensi\".tshiftpekerja t  
								where kd_shift = '2' 
								and tanggal = ?::date - interval '1 day' 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and ts.waktu::time < t.jam_msk::time + interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) > 0 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) = 1
							)  
						) 
						and left(trim(tpres.noind), 1) not in ('M','Z') 
						group by tpri.tempat_makan, trim(tpres.noind)
					) derivedtbl 
					group by tempat_makan 
					order by tempat_makan, jumlah ";
			return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$lokasi,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal))->result_array();
		}else{
			$sql = "select tempat_makan, count(tempat_makan) as jumlah 
					from (
						select trim(tpres.noind) as noind, tpri.tempat_makan as tempat_makan, count(tpri.tempat_makan) as jumlah_karyawan 
						from hrd_khs.tpribadi tpri 
						inner join \"Catering\".tpresensi tpres 
							on trim(tpres.noind) = trim(tpri.noind) 
							and left(tpres.waktu, 5) >= (
								 select left(fs_jam_awal,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '2' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							) 
							and left(tpres.waktu, 5) <= (
								 select left(fs_jam_akhir,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '2' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							)  
							and tpres.tanggal = ? 
						inner join \"Catering\".ttempat_makan tmkn 
							on tpri.tempat_makan = tmkn.fs_tempat_makan 
							and tmkn.fs_lokasi = ?
						where trim(tpres.noind) not in (
							select trim(noind) as noind 
							from \"Catering\".tpresensi
							where left(waktu, 5) >= (
								 select left(fs_jam_awal,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '1' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							)   
							and left(waktu, 5) <= (
								 select left(fs_jam_akhir,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '1' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							)   
							and tanggal = ?::date
							and trim(noind) not in ( 
								select trim(noind) as noind 
								from (
									select trim(t.noind) as noind, count(trim(t.noind)) as jml 
									from \"Catering\".tpresensi t, \"Presensi\".tshiftPekerja s 
									where t.tanggal in (?::date - interval '1 day', ?::date) 
									and t.waktu < '23:00:00'
									and t.waktu > '20:30:00' 
									and s.kd_shift in ('3', '12')  
									and trim(t.noind) = trim(s.noind) 
									group by trim(t.noind)
								) derivedtbl 
								where jml = '1' and trim(noind) not in (
									select trim(noind) as noind 
									from \"Catering\".tpresensi 
									where waktu <= '20:30:00' 
									and waktu >= '11:00:00'
									and tanggal = ?::date
								) 
							) 
							and trim(tpres.noind) not in (
								select distinct trim(t.noind) as noind 
								from \"Presensi\".tshiftpekerja t  
								where kd_shift = '2' 
								and tanggal = ?::date - interval '1 day' 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and ts.waktu::time < t.jam_msk::time + interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) > 0 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) = 1
							) 
							union 
							select trim(noind) as noind 
							from \"Presensi\".tshiftpekerja 
							where kd_shift in('5','8','18') 
							and tanggal= ? 
						) 
						and left(trim(tpres.noind), 1) not in ('M','Z') 
						group by tpri.tempat_makan, trim(tpres.noind)
					) derivedtbl 
					group by tempat_makan 
					order by tempat_makan, jumlah ";
			return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$lokasi,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal))->result_array();
		}
	}

	public function getAbsenShiftDuaStaffByTanggalLokasiTempatMakan($tanggal,$lokasi,$tempat_makan,$jenis){
		if ($jenis == "Snack") {
			$sql = "select tempat_makan, count(tempat_makan) as jumlah 
					from (
						select trim(tpres.noind) as noind, tpri.tempat_makan as tempat_makan, count(tpri.tempat_makan) as jumlah_karyawan 
						from hrd_khs.tpribadi tpri 
						inner join \"Catering\".tpresensi tpres 
							on trim(tpres.noind) = trim(tpri.noind) 
							and left(tpres.waktu, 5) >= (
								 select left(fs_jam_awal,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '2' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							) 
							and left(tpres.waktu, 5) <= (
								 select left(fs_jam_akhir,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '2' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							)  
							and tpres.tanggal = ? 
						inner join \"Catering\".ttempat_makan tmkn 
							on tpri.tempat_makan = tmkn.fs_tempat_makan 
							and tmkn.fs_lokasi = ?
						where trim(tpres.noind) not in (
							select trim(noind) as noind 
							from \"Catering\".tpresensi
							where left(waktu, 5) >= (
								 select left(fs_jam_awal,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '1' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							)   
							and left(waktu, 5) <= (
								 select left(fs_jam_akhir,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '1' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							)   
							and tanggal = ?::date
							and trim(noind) not in ( 
								select trim(noind) as noind 
								from (
									select trim(t.noind) as noind, count(trim(t.noind)) as jml 
									from \"Catering\".tpresensi t, \"Presensi\".tshiftPekerja s 
									where t.tanggal in (?::date - interval '1 day', ?::date) 
									and t.waktu < '23:00:00'
									and t.waktu > '20:30:00' 
									and s.kd_shift in ('3', '12')  
									and trim(t.noind) = trim(s.noind) 
									group by trim(t.noind)
								) derivedtbl 
								where jml = '1' and trim(noind) not in (
									select trim(noind) as noind 
									from \"Catering\".tpresensi 
									where waktu <= '20:30:00' 
									and waktu >= '11:00:00'
									and tanggal = ?::date
								) 
							) 
							and trim(tpres.noind) not in (
								select distinct trim(t.noind) as noind 
								from \"Presensi\".tshiftpekerja t  
								where kd_shift = '2' 
								and tanggal = ?::date - interval '1 day' 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and ts.waktu::time < t.jam_msk::time + interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) > 0 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) = 1
							)  
						) 
						and left(trim(tpres.noind), 1) IN ('B', 'D', 'J', 'L', 'G')
						and tpri.tempat_makan = ?
						group by tpri.tempat_makan, trim(tpres.noind)
					) derivedtbl 
					group by tempat_makan 
					order by tempat_makan, jumlah ";
			return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$lokasi,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tempat_makan))->result_array();
		}else{
			$sql = "select tempat_makan, count(tempat_makan) as jumlah 
					from (
						select trim(tpres.noind) as noind, tpri.tempat_makan as tempat_makan, count(tpri.tempat_makan) as jumlah_karyawan 
						from hrd_khs.tpribadi tpri 
						inner join \"Catering\".tpresensi tpres 
							on trim(tpres.noind) = trim(tpri.noind) 
							and left(tpres.waktu, 5) >= (
								 select left(fs_jam_awal,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '2' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							) 
							and left(tpres.waktu, 5) <= (
								 select left(fs_jam_akhir,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '2' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							)  
							and tpres.tanggal = ? 
						inner join \"Catering\".ttempat_makan tmkn 
							on tpri.tempat_makan = tmkn.fs_tempat_makan 
							and tmkn.fs_lokasi = ?
						where trim(tpres.noind) not in (
							select trim(noind) as noind 
							from \"Catering\".tpresensi
							where left(waktu, 5) >= (
								 select left(fs_jam_awal,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '1' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							)   
							and left(waktu, 5) <= (
								 select left(fs_jam_akhir,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '1' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							)   
							and tanggal = ?::date
							and trim(noind) not in ( 
								select trim(noind) as noind 
								from (
									select trim(t.noind) as noind, count(trim(t.noind)) as jml 
									from \"Catering\".tpresensi t, \"Presensi\".tshiftPekerja s 
									where t.tanggal in (?::date - interval '1 day', ?::date) 
									and t.waktu < '23:00:00'
									and t.waktu > '20:30:00' 
									and s.kd_shift in ('3', '12')  
									and trim(t.noind) = trim(s.noind) 
									group by trim(t.noind)
								) derivedtbl 
								where jml = '1' and trim(noind) not in (
									select trim(noind) as noind 
									from \"Catering\".tpresensi 
									where waktu <= '20:30:00' 
									and waktu >= '11:00:00'
									and tanggal = ?::date
								) 
							) 
							and trim(tpres.noind) not in (
								select distinct trim(t.noind) as noind 
								from \"Presensi\".tshiftpekerja t  
								where kd_shift = '2' 
								and tanggal = ?::date - interval '1 day' 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and ts.waktu::time < t.jam_msk::time + interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) > 0 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) = 1
							) 
							union 
							select trim(noind) as noind 
							from \"Presensi\".tshiftpekerja 
							where kd_shift in('5','8','18') 
							and tanggal= ? 
						) 
						and left(trim(tpres.noind), 1) IN ('B', 'D', 'J', 'L', 'G')
						and tpri.tempat_makan = ?
						group by tpri.tempat_makan, trim(tpres.noind)
					) derivedtbl 
					group by tempat_makan 
					order by tempat_makan, jumlah ";
			return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$lokasi,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tempat_makan))->result_array();
		}
	}

	public function getAbsenShiftDuaByTanggalLokasiTempatMakanNoind($tanggal,$lokasi,$tempat_makan,$noind){
		$sql = "select *
				from (
					select trim(tpres.noind) as noind, tpri.tempat_makan as tempat_makan, count(tpri.tempat_makan) as jumlah_karyawan 
					from hrd_khs.tpribadi tpri 
					inner join \"Catering\".tpresensi tpres 
						on trim(tpres.noind) = trim(tpri.noind) 
						and left(tpres.waktu, 5) >= (
							 select left(fs_jam_awal,5)
							 from \"Catering\".tbatas_datang_shift 
							 where fs_kd_shift = '2' 
							 and fs_hari = (extract(dow from ?::date)+1)::varchar
						) 
						and left(tpres.waktu, 5) <= (
							 select left(fs_jam_akhir,5)
							 from \"Catering\".tbatas_datang_shift 
							 where fs_kd_shift = '2' 
							 and fs_hari = (extract(dow from ?::date)+1)::varchar
						)  
						and tpres.tanggal = ? 
					inner join \"Catering\".ttempat_makan tmkn 
						on tpri.tempat_makan = tmkn.fs_tempat_makan 
						and tmkn.fs_lokasi = ?
					where trim(tpres.noind) not in (
						select trim(noind) as noind 
						from \"Catering\".tpresensi
						where left(waktu, 5) >= (
							 select left(fs_jam_awal,5)
							 from \"Catering\".tbatas_datang_shift 
							 where fs_kd_shift = '1' 
							 and fs_hari = (extract(dow from ?::date)+1)::varchar
						)   
						and left(waktu, 5) <= (
							 select left(fs_jam_akhir,5)
							 from \"Catering\".tbatas_datang_shift 
							 where fs_kd_shift = '1' 
							 and fs_hari = (extract(dow from ?::date)+1)::varchar
						)   
						and tanggal = ?::date
						and trim(noind) not in ( 
							select trim(noind) as noind 
							from (
								select trim(t.noind) as noind, count(trim(t.noind)) as jml 
								from \"Catering\".tpresensi t, \"Presensi\".tshiftPekerja s 
								where t.tanggal in (?::date - interval '1 day',?::date) 
								and t.waktu < '23:00:00'
								and t.waktu > '20:30:00' 
								and s.kd_shift in ('3', '12')  
								and trim(t.noind) = trim(s.noind) 
								group by trim(t.noind)
							) derivedtbl 
							where jml = '1' and trim(noind) not in (
								select trim(noind) as noind 
								from \"Catering\".tpresensi 
								where waktu <= '20:30:00' 
								and waktu >= '11:00:00'
								and tanggal = ?::date
							) 
						) 
						and trim(tpres.noind) not in (
							select distinct trim(t.noind) as noind 
							from \"Presensi\".tshiftpekerja t  
							where kd_shift = '2' 
							and tanggal = ?::date - interval '1 day' 
							and ( 
								select count(*) 
								from \"Presensi\".tprs_shift ts  
								where ts.tanggal = t.tanggal  
								and trim(ts.noind) = trim(t.noind)  
								and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
								and ts.waktu::time < t.jam_msk::time + interval '1 hours' 
								and trim(ts.waktu) not in ('0') 
							) > 0 
							and ( 
								select count(*) 
								from \"Presensi\".tprs_shift ts  
								where ts.tanggal = t.tanggal  
								and trim(ts.noind) = trim(t.noind)  
								and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
								and trim(ts.waktu) not in ('0') 
							) = 1
						) 
						union 
						select trim(noind) 
						from \"Presensi\".tshiftpekerja 
						where kd_shift in('5','8','18') 
						and tanggal= ? 
					) 
					and left(trim(tpres.noind), 1) IN ('B', 'D', 'J', 'L', 'G')
					and tpri.tempat_makan = ?
					group by tpri.tempat_makan, trim(tpres.noind)
				) derivedtbl 
				where trim(noind) = ?
				order by tempat_makan ";
		return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$lokasi,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tempat_makan,$noind))->result_array();
	}

	public function getAbsenShiftTigaByTanggalLokasi($tanggal,$lokasi){
		$sql = "select tpri.tempat_makan as tempat_makan, 
					kd_shift as kodeshift, 
					count(tempat_makan) as jumlah 
				from \"Presensi\".tshiftpekerja tsp, hrd_khs.tpribadi tpri
				inner join \"Catering\".ttempat_makan tmkn 
					on tpri.tempat_makan = tmkn.fs_tempat_makan 
					and tmkn.fs_lokasi = ?
				where trim(tsp.noind) = (tpri.noind) 
				and tanggal = ?
				and kd_shift in ('3', '12') 
				and left(tpri.noind, 1) not in ('M','Z') 
				group by tempat_makan, kd_shift 
				order by tempat_makan, jumlah ";
		return $this->personalia->query($sql,array($lokasi,$tanggal))->result_array();
	}

	public function getAbsenShiftTigaStaffByTanggalLokasiTempatMakan($tanggal,$lokasi,$tempat_makan){
		$sql = "select tpri.tempat_makan as tempat_makan, 
					kd_shift as kodeshift, 
					count(tempat_makan) as jumlah 
				from \"Presensi\".tshiftpekerja tsp, hrd_khs.tpribadi tpri
				inner join \"Catering\".ttempat_makan tmkn 
					on tpri.tempat_makan = tmkn.fs_tempat_makan 
					and tmkn.fs_lokasi = ?
				where trim(tsp.noind) = trim(tpri.noind) 
				and tanggal = ?
				and kd_shift in ('3', '12') 
				and left(trim(tpri.noind), 1) IN ('B', 'D', 'J', 'L', 'G')
				and tempat_makan = ?
				group by tempat_makan, kd_shift 
				order by tempat_makan, jumlah ";
		return $this->personalia->query($sql,array($lokasi,$tanggal,$tempat_makan))->result_array();
	}

	public function getAbsenShiftTigaByTanggalLokasiTempatMakanNoind($tanggal,$lokasi,$tempat_makan,$noind){
		$sql = "select *
				from \"Presensi\".tshiftpekerja tsp, hrd_khs.tpribadi tpri
				inner join \"Catering\".ttempat_makan tmkn 
					on tpri.tempat_makan = tmkn.fs_tempat_makan 
					and tmkn.fs_lokasi = ?
				where trim(tsp.noind) = trim(tpri.noind) 
				and tanggal = ?
				and kd_shift in ('3', '12') 
				and left(trim(tpri.noind), 1) not in ('M','Z') 
				and tempat_makan = ?
				and trim(tpri.noind) = ?
				order by tempat_makan ";
		return $this->personalia->query($sql,array($lokasi,$tanggal,$tempat_makan,$noind))->result_array();
	}

	public function getPesananTambahanByTanggalShiftTempatMakan($tanggal,$shift,$tempat_makan){
		$sql = "select coalesce(
                    (
                        select sum(fn_jumlah_pesanan)
                        from \"Catering\".tpesanantambahan
                        where fd_tanggal = ?
                        and fs_tempat_makan = ?
                        and fs_kd_shift = ?
                    ),0) +
                    coalesce(
                    (
                        select sum(fn_jml_tdkpesan)
                        from \"Catering\".tpenguranganpesanan
                        where fb_kategori = '2'
                        and fd_tanggal = ?
                        and fs_tempat_makanpg = ?
                        and fs_kd_shift = ?
                    ),0) as jumlah";
		return $this->personalia->query($sql,array($tanggal,$tempat_makan,$shift,$tanggal,$tempat_makan,$shift))->result_array();
	}

	public function getPesananTambahanByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempat_makan,$kategori){
		$sql = "select * 
				 from \"Catering\".tpesanantambahan 
				 Where fd_tanggal = ?  
				 and fs_kd_shift = ? 
				 and fs_tempat_makan = ?
				 and fb_kategori = ? ";
		return $this->personalia->query($sql,array($tanggal,$shift,$tempat_makan,$kategori))->result_array();
	}

	public function getPesananTambahanNonAbsensiByTanggalShiftLokasi($tanggal,$shift,$lokasi){
		$sql = "select tempat_makan, sum(jumlah) as jumlah
				from (
					select tpt.fs_tempat_makan as tempat_makan, sum(tpt.fn_jumlah_pesanan ) as jumlah  
					from \"Catering\".tpesanantambahan tpt
					left join \"Catering\".ttempat_makan ttm 
					on trim(tpt.fs_tempat_makan) = (ttm.fs_tempat_makan)
					where tpt.fd_tanggal = ?
					and tpt.fs_kd_shift = ? 
					and tpt.fs_tempat_makan not in (
						select tp.fs_tempat_makan 
						from \"Catering\".tpesanan tp
						where tp.fs_kd_shift = tpt.fs_kd_shift
						and tp.fd_tanggal = tpt.fd_tanggal
						and tp.lokasi = ttm.fs_lokasi
					) 
					and ttm.fs_lokasi = ?
					group by tpt.fs_tempat_makan
					union
					select tpt.fs_tempat_makanpg as tempat_makan, sum(tpt.fn_jml_tdkpesan ) as jumlah  
					from \"Catering\".tpenguranganpesanan tpt
					left join \"Catering\".ttempat_makan ttm 
					on trim(tpt.fs_tempat_makanpg) = (ttm.fs_tempat_makan)
					where tpt.fd_tanggal = ?
					and tpt.fs_kd_shift = ? 
					and tpt.fb_kategori = '2'
					and tpt.fs_tempat_makanpg not in (
						select tp.fs_tempat_makan
						from \"Catering\".tpesanan tp
						where tp.fs_kd_shift = tpt.fs_kd_shift
						and tp.fd_tanggal = tpt.fd_tanggal
						and tp.lokasi = ttm.fs_lokasi
					) 
					and ttm.fs_lokasi = ?
					group by tpt.fs_tempat_makanpg 
				 ) as tbl 
				group by tempat_makan";
 		return $this->personalia->query($sql,array($tanggal,$shift,$lokasi,$tanggal,$shift,$lokasi))->result_array();
	}

	public function insertPesananTambahanRencanaLembur($tanggal,$tempat_makan,$shift){
		$sql = "insert into \"Catering\".tpesanantambahan 
				(fd_tanggal,fs_tempat_makan,fs_kd_shift,fn_jumlah_pesanan,fb_kategori) 
				values(?,?,?,0,'1')";
		$this->personalia->query($sql,array($tanggal,$tempat_makan,$shift));
	}

	public function getPesananTambahanDetailByIdTambahanNoind($id_tambahan,$noind){
		$sql = "select * 
				from \"Catering\".tpesanantambahan_detail 
				where id_tambahan =  ?
				and trim(fs_noind) = trim(?)";
		return $this->personalia->query($sql,array($id_tambahan,$noind))->result_array();
	}

	public function insertPesananTambahanDetail($id_tambahan,$noind){
		$sql = "insert into \"Catering\".tpesanantambahan_detail 
				(id_tambahan,fs_noind,fs_nama,fs_ket) 
				select ?,trim(noind),nama,jabatan 
				From hrd_khs.tpribadi 
				where trim(noind) = trim(?) ";
 		$this->personalia->query($sql,array($id_tambahan,$noind));
	}

	public function updatePesananTambahanByIdTambahan($id_tambahan){
		$sql = "update \"Catering\".tpesanantambahan tpt
				set fn_jumlah_pesanan = ( 
				select count(*) 
				from \"Catering\".tpesanantambahan_detail tptd
				where tptd.id_tambahan = tpt.id_tambahan 
				) 
				Where id_tambahan = ? ";
		$this->personalia->query($sql,array($id_tambahan));
	}

	public function updatePesananTambahanTotalByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempat_makan,$kategori){
		$sql = "update \"Catering\".tpesanantambahan tpt
				set fn_jumlah_pesanan = ( 
				select count(*) 
				from \"Catering\".tpesanantambahan_detail tptd
				where tptd.id_tambahan = tpt.id_tambahan 
				) 
				Where fd_tanggal = ?
				  and fs_kd_shift = ?
				  and fs_tempat_makan = ?
				  and fb_kategori = ? ";
		$this->personalia->query($sql,array($tanggal,$shift,$tempat_makan,$kategori));
	}

	public function getPesananPenguranganByTanggalShiftTempatMakan($tanggal,$shift,$tempat_makan){
		$sql = "select sum(fn_jml_tdkpesan) as jumlah 
				from \"Catering\".tpenguranganpesanan 
				where fd_tanggal = ?
				  and fs_kd_shift = ?
				  and fs_tempat_makan = ?
				group by fs_tempat_makan, fs_kd_shift, fd_tanggal ";
		return $this->personalia->query($sql,array($tanggal,$shift,$tempat_makan))->result_array();
	}

	public function getPesananPenguranganByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempat_makan,$kategori){
		$sql = "select *
				from \"Catering\".tpenguranganpesanan 
				where fd_tanggal = ?
				  and fs_kd_shift = ?
				  and fs_tempat_makan = ?
				  and fb_kategori = ?";
		return $this->personalia->query($sql,array($tanggal,$shift,$tempat_makan,$kategori))->result_array();
	}

	public function deletePesananByTanggalShiftLokasi($tanggal,$shift,$lokasi){
		$sql = "delete from \"Catering\".tpesanan as tp 
				where tp.fd_tanggal = ? 
				and tp.fs_kd_shift = ? 
				and lokasi = ?";
		return $this->personalia->query($sql,array($tanggal,$shift,$lokasi));
	}

	public function deletePesananByTanggalShiftTempatMakan($tanggal,$shift,$tempat_makan){
		$sql = "delete from \"Catering\".tpesanan 
				where fd_tanggal = ?
				and fs_kd_shift = ? 
				and fs_tempat_makan = ? ";
		return $this->personalia->query($sql,array($tanggal,$shift,$tempat_makan));
	}
	
	public function deleteUrutanKateringByTanggalShiftLokasi($tanggal,$shift,$lokasi){
		$sql = "delete from \"Catering\".turutankatering as tp 
				where tp.fd_tanggal = ? 
				and tp.fs_kd_shift = ? 
				and lokasi = ?";
		return $this->personalia->query($sql,array($tanggal,$shift,$lokasi));
	}

	public function UpdateWaktuHitungByShift($shift,$status){
		if ($status == '0') {
			$sql = "update \"Catering\".twaktuhitung SET fb_status = '0' WHERE fs_kd_shift = ? ";
		}elseif($status == '1'){
			$sql = " update \"Catering\".twaktuhitung 
					 set fb_status = '1', 
					     fd_tanggal = to_char(current_timestamp,'yyyy-mm-dd')::date, 
					     fs_waktu = to_char(current_timestamp,'HH24:MI:ss') 
					 where fs_kd_shift = ? ";
		}
		return $this->personalia->query($sql,array($shift));
	}

	public function getRencanaLemburShiftSatuByTanggalTempatMakan($tanggal,$tempat_makan){
		$sql = "select trim(trl.noind) as noind,trl.tempat_makan 
				from \"Presensi\".t_rencana_lembur trl 
				left join \"Presensi\".tshiftpekerja tsp 
				on trl.tanggal_lembur = tsp.tanggal 
				and trim(trl.noind) = trim(tsp.noind) 
				Where 
				    ( 
				        ( 
				            trim(tsp.kd_shift) = '3' 
				            and tsp.tanggal = ?::date - interval '1 day' 
				        ) or 
				        ( 
				            trim(tsp.kd_shift) = '2' 
				            and tsp.tanggal = ? 
				        ) 
				    ) 
				    and concat(?,' 12:00:00')::timestamp between trl.mulai and trl.selesai 
				    and trl.makan = 1 
				    and trl.status_approve = 1 
				    and trl.tempat_makan = ?";
		return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$tempat_makan))->result_array();
	}

	public function getRencanaLemburShiftSatuNonAbsensiByTanggalLokasi($tanggal,$lokasi){
		$sql = "select trim(trl.noind) as noind,trl.tempat_makan 
				from \"Presensi\".t_rencana_lembur trl 
				left join \"Presensi\".tshiftpekerja tsp 
				on trl.tanggal_lembur = tsp.tanggal 
				and trim(trl.noind) = trim(tsp.noind) 
				Where 
				    ( 
				        ( 
				            trim(tsp.kd_shift) = '3' 
				            and tsp.tanggal = ?::date - interval '1 day' 
				        ) or 
				        ( 
				            trim(tsp.kd_shift) = '2' 
				            and tsp.tanggal = ? 
				        ) 
				    ) 
				    and concat(?,' 12:00:00')::timestamp between trl.mulai and trl.selesai 
				    and trl.makan = 1 
				    and trl.status_approve = 1 
				    and trl.tempat_makan not in (
				    	select tp.fs_tempat_makan 
				       	from \"Catering\".tpesanan tp
				       	where tp.fs_kd_shift = '1'
				        and tp.fd_tanggal = ?
				        and tp.lokasi = ?
					)
					and trl.tempat_makan in (
						select fs_tempat_makan
						from \"Catering\".ttempat_makan
						where fs_lokasi = ?
					)";
		return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$tanggal,$lokasi,$lokasi))->result_array();
	}

	public function getRencanaLemburShiftDuaByTanggalTempatMakan($tanggal,$tempat_makan){
		$sql = "select trim(trl.noind) as noind,trl.tempat_makan 
				from \"Presensi\".t_rencana_lembur trl 
				left join \"Presensi\".tshiftpekerja tsp 
				on trl.tanggal_lembur = tsp.tanggal 
				and trim(trl.noind) = trim(tsp.noind) 
				Where 
				    ( 
				        ( 
				            trim(tsp.kd_shift) in ('1','4','7','9') 
				            and concat(?,' 18:00:00')::timestamp between trl.mulai and trl.selesai 
				        ) or 
				        ( 
				            trim(tsp.kd_shift) = '2' 
				            and concat(?,' 12:00:00')::timestamp between trl.mulai and trl.selesai 
				        ) 
				    ) 
				    and tsp.tanggal = ?
				    and trl.makan = 1 
				    and trl.status_approve = 1 
				    and trl.tempat_makan = ?";
		return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$tempat_makan))->result_array();
	}

	public function getRencanaLemburShiftDuaNonAbsensiByTanggalLokasi($tanggal,$lokasi){
		$sql = "select trim(trl.noind) as noind,trl.tempat_makan 
				from \"Presensi\".t_rencana_lembur trl 
				left join \"Presensi\".tshiftpekerja tsp 
				on trl.tanggal_lembur = tsp.tanggal 
				and trim(trl.noind) = trim(tsp.noind) 
				Where 
				    ( 
				        ( 
				            trim(tsp.kd_shift) in ('1','4','7','9') 
				            and concat(?,' 18:00:00')::timestamp between trl.mulai and trl.selesai 
				        ) or 
				        ( 
				            trim(tsp.kd_shift) = '2' 
				            and concat(?,' 12:00:00')::timestamp between trl.mulai and trl.selesai 
				        ) 
				    ) 
				    and tsp.tanggal = ?
				    and trl.makan = 1 
				    and trl.status_approve = 1 
				    and trl.tempat_makan not in ( 
					    select fs_tempat_makan 
					    from \"Catering\".tpesanan t 
					    where fs_kd_shift ='2' 
					    and fd_tanggal = ? 
					    and lokasi = ?
				    )
				    and trl.tempat_makan in (
						select fs_tempat_makan
						from \"Catering\".ttempat_makan
						where fs_lokasi = ?
					)";
		return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$tanggal,$lokasi,$lokasi))->result_array();
	}

	public function getRencanaLemburShiftTigaByTanggalTempatMakan($tanggal,$tempat_makan){
		$sql = "select trim(trl.noind) as noind,trl.tempat_makan 
				from \"Presensi\".t_rencana_lembur trl 
				left join \"Presensi\".tshiftpekerja tsp 
				on trl.tanggal_lembur = tsp.tanggal 
				and trim(trl.noind) = trim(tsp.noind) 
				Where 
				    ( 
				        ( 
				            trim(tsp.kd_shift) in ('1','4') 
				            and tsp.tanggal = ?::date + interval '1 day' 
				        ) or 
				        ( 
				            trim(tsp.kd_shift) = '2' 
				            and tsp.tanggal = ? 
				        ) 
				    ) 
				    and concat(?,' 01:30:00')::timestamp + interval '1 day' between trl.mulai and trl.selesai 
				    and trl.makan = 1 
				    and trl.status_approve = 1 
				    and trl.tempat_makan = ?";
		return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$tempat_makan))->result_array();
	}

	public function getRencanaLemburShiftTigaNonAbsensiByTanggalLokasi($tanggal,$lokasi){
		$sql = "select trim(trl.noind) as noind,trl.tempat_makan 
				from \"Presensi\".t_rencana_lembur trl 
				left join \"Presensi\".tshiftpekerja tsp 
				on trl.tanggal_lembur = tsp.tanggal 
				and trim(trl.noind) = trim(tsp.noind) 
				Where 
				    ( 
				        ( 
				            trim(tsp.kd_shift) in ('1','4') 
				            and tsp.tanggal = ?::date + interval '1 day' 
				        ) or 
				        ( 
				            trim(tsp.kd_shift) = '2' 
				            and tsp.tanggal = ? 
				        ) 
				    ) 
				    and concat(?,' 01:30:00')::timestamp + interval '1 day' between trl.mulai and trl.selesai 
				    and trl.makan = 1 
				    and trl.status_approve = 1 
				    and trl.tempat_makan not in ( 
				     select fs_tempat_makan 
				     from \"Catering\".tpesanan t 
				     where fs_kd_shift ='3' 
				     and fd_tanggal = ?
				     and lokasi = ? 
				    )
				    and trl.tempat_makan in (
						select fs_tempat_makan
						from \"Catering\".ttempat_makan
						where fs_lokasi = ?
					)";
		return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$tanggal,$lokasi,$lokasi))->result_array();
	}

	public function insertPesananCatering($data){
		$this->personalia->insert("\"Catering\".tpesanan",$data);
	}

	public function getWaktuHitungStatusByTanggalShift($tanggal,$shift){
		$sql = "select fb_status 
				from \"Catering\".twaktuhitung 
				where fd_tanggal = ?
				and fs_kd_shift = ? ";
		return $this->personalia->query($sql,array($tanggal,$shift))->result_array();
	}

	public function updateWaktuHitungStatusByShift($shift,$status){
		$sql = "update \"Catering\".twaktuhitung 
				set fb_status = ? 
				where fs_kd_shift = ?";
		return $this->personalia->query($sql,array($status,$shift));
	}

	public function getViPesananByTanggalShiftLokasi($tanggal,$shift,$lokasi){
		$sql = "select tp.* 
			   from \"Catering\".vi_tpesanan as tp 
			   where tp.fd_tanggal = ?
			   and tp.fs_kd_shift = ? 
			   and tp.fs_lokasi = ?";
		return $this->personalia->query($sql,array($tanggal,$shift,$lokasi))->result_array();
	}

	public function getUrutanKateringByTanggalShiftLokasi($tanggal,$shift,$lokasi){
		$sql = "select * 
			   from \"Catering\".turutankatering 
			   where fd_tanggal = ? 
			   and fs_kd_shift = ?  
			   and lokasi = ?";
   		return $this->personalia->query($sql,array($tanggal,$shift,$lokasi))->result_array();
	}

	public function updatePesananTandaByTanggalShiftLokasi($tanggal,$shift,$lokasi){
		$sql = "update \"Catering\".tpesanan as tp 
				set fs_tanda = '0' 
				where tp.fs_kd_shift = ?
				and tp.lokasi = ?
				and tp.fd_tanggal = ? ";
		return $this->personalia->query($sql,array($shift,$lokasi,$tanggal));
	}

	public function getKateringJadwalShiftSatuByTanggal($tanggal){
		$sql = "select count(fs_kd_katering) as jumlah 
				from \"Catering\".tjadwal 
				where fs_tujuan_shift1 = '1'
				and fd_tanggal = ?
				group by fs_tujuan_shift1 ";
		return $this->personalia->query($sql,array($tanggal))->result_array();
	}

	public function getKateringJadwalShiftDuaByTanggal($tanggal){
		$sql = "select count(fs_kd_katering) as jumlah 
				from \"Catering\".tjadwal 
				where fs_tujuan_shift2 = '1'
				and fd_tanggal = ?
				group by fs_tujuan_shift2 ";
		return $this->personalia->query($sql,array($tanggal))->result_array();
	}

	public function getKateringJadwalShiftTigaByTanggal($tanggal){
		$sql = "select count(fs_kd_katering) as jumlah 
				from \"Catering\".tjadwal 
				where fs_tujuan_shift3 = '1'
				and fd_tanggal = ?
				group by fs_tujuan_shift3 ";
		return $this->personalia->query($sql,array($tanggal))->result_array();
	}

	public function getJumlahPesananByTanggalShiftLokasi($tanggal,$shift,$lokasi){
		$sql = "select sum(fn_jumlah_pesan) as total 
				from \"Catering\".vi_tpesanan as tp 
				where tp.fd_tanggal = ?
				and tp.fs_kd_shift = ? 
				and tp.fs_lokasi = ?";
		return $this->personalia->query($sql,array($tanggal,$shift,$lokasi))->result_array();
	}

	public function getUrutanJadwalShiftSatuByTanggalLokasi($tanggal,$lokasi){
		$sql = "select distinct tuj.fn_urutan_jadwal, tk.fs_nama_katering, tj.fs_kd_katering 
				from \"Catering\".tjadwal tj
				inner join \"Catering\".tkatering tk 
				on tj.fs_kd_katering = tk.fs_kd_katering 
				inner join \"Catering\".turutanjadwal tuj 
				on tj.fs_kd_katering = tuj.fs_kd_katering 
				and tj.fd_tanggal = tuj.fd_tanggal
				where tj.fs_tujuan_shift1 = '1' 
				and tj.fd_tanggal = ? 
				and tj.lokasi = ?
				order by tuj.fn_urutan_jadwal ";
		return $this->personalia->query($sql,array($tanggal,$lokasi))->result_array();
	}

	public function getUrutanJadwalShiftDuaByTanggalLokasi($tanggal,$lokasi){
		$sql = "select distinct tuj.fn_urutan_jadwal, tk.fs_nama_katering, tj.fs_kd_katering 
				from \"Catering\".tjadwal tj
				inner join \"Catering\".tkatering tk 
				on tj.fs_kd_katering = tk.fs_kd_katering 
				inner join \"Catering\".turutanjadwal tuj 
				on tj.fs_kd_katering = tuj.fs_kd_katering 
				and tj.fd_tanggal = tuj.fd_tanggal
				where tj.fs_tujuan_shift2 = '1' 
				and tj.fd_tanggal = ? 
				and tj.lokasi = ?
				order by tuj.fn_urutan_jadwal ";
		return $this->personalia->query($sql,array($tanggal,$lokasi))->result_array();
	}

	public function getUrutanJadwalShiftTigaByTanggalLokasi($tanggal,$lokasi){
		$sql = "select distinct tuj.fn_urutan_jadwal, tk.fs_nama_katering, tj.fs_kd_katering 
				from \"Catering\".tjadwal tj
				inner join \"Catering\".tkatering tk 
				on tj.fs_kd_katering = tk.fs_kd_katering 
				inner join \"Catering\".turutanjadwal tuj 
				on tj.fs_kd_katering = tuj.fs_kd_katering 
				and tj.fd_tanggal = tuj.fd_tanggal
				where tj.fs_tujuan_shift3 = '1' 
				and tj.fd_tanggal = ? 
				and tj.lokasi = ?
				order by tuj.fn_urutan_jadwal ";
		return $this->personalia->query($sql,array($tanggal,$lokasi))->result_array();
	}

	public function cekPengajuanLiburByTanggalKateringLibur($tanggal,$katering){
		$sql = "select fs_kd_katering_libur, fs_kd_katering_pengganti 
				from \"Catering\".tpengajuanlibur 
				where fd_tanggal = ?
				and fs_kd_katering_libur = ?";
 		return $this->personalia->query($sql,array($tanggal,$katering))->result_array();
	}

	public function getPesananBelumDitandaiPerTempatMakanByTanggalShiftLokasi($tanggal,$shift,$lokasi){
		$sql = "select tp.*, tp.fs_tempat as urutan 
				from \"Catering\".vi_tpesanan as tp 
				where tp.fd_tanggal = ? 
				and tp.fs_tanda = '0' 
				and tp.fs_kd_shift = ? 
				and tp.fs_lokasi = ?
				order by tp.fs_tempat, tp.fn_jumlah_pesan desc, tp.fs_tempat_makan ";
		return $this->personalia->query($sql,array($tanggal,$shift,$lokasi))->result_array();
	}

	public function getPesananSudahDitandaiPerTempatMakanByTanggalShiftLokasiTanda($tanggal,$shift,$lokasi,$tanda){
		$sql = "select tp.* 
				from \"Catering\".vi_tpesanan tp
				where tp.fd_tanggal = ?
				and tp.fs_kd_shift = ?
				and tp.fs_lokasi = ?
				and tp.fs_tanda::int = ?
				order by tp.fn_jumlah_pesan desc, tp.fs_tempat_makan  ";
		return $this->personalia->query($sql,array($tanggal,$shift,$lokasi,$tanda))->result_array();
	}

	public function geturutankateringByTanggalShiftLokasiUrutan($tanggal,$shift,$lokasi,$urutan){
		$sql = "select fs_nama_katering 
				from \"Catering\".turutankatering 
				where fd_tanggal = ?
				and fs_kd_shift = ? 
				and lokasi = ?
				and fn_urutan = ?";
		return $this->personalia->query($sql,array($tanggal,$shift,$lokasi,$urutan))->result_array();
	}

	public function updatePesananTandaByTanggalShiftLokasiTempatMakan($urutan,$tanggal,$shift,$lokasi,$tempat_makan){
		$sql = "update \"Catering\".tpesanan 
				set fs_tanda = ? 
				where fd_tanggal = ?
				and fs_kd_shift = ? 
				and lokasi = ?
				and fs_tempat_makan = ?";
		$this->personalia->query($sql,array($urutan,$tanggal,$shift,$lokasi,$tempat_makan));
	}

	public function updatePesananTandaBiggerThanByTanggalShiftLokasi($jumlah_katering,$tanggal,$shift,$lokasi){
		$sql = "update \"Catering\".tpesanan 
				set fs_tanda = ? 
				where fd_tanggal = ?
				and fs_kd_shift = ? 
				and lokasi = ?
				and coalesce(fs_tanda,'0')::int > ?";
		$this->personalia->query($sql,array($jumlah_katering,$tanggal,$shift,$lokasi,$jumlah_katering));
	}

	public function getPembagianByTanggalShiftLokasiTanggalCopy($tanggal,$shift,$lokasi,$tanggal_copy){
		$sql = "select a.fd_tanggal,a.fs_kd_shift,a.fs_tempat_makan,a.fs_tanda as tanda_sekarang, 
				b.fs_nama_katering as katering_sekarang, 
				c.fs_tempat_makan,c.fs_tanda as tanda_dulu, 
				d.fs_nama_katering as katering_dulu, 
				coalesce(e.fn_urutan,0) as tanda_baru, e.fs_nama_katering as katering_baru 
				from \"Catering\".tpesanan a 
				left join \"Catering\".turutankatering b 
				on a.fd_tanggal = b.fd_tanggal and a.fs_tanda::int = b.fn_urutan and a.fs_kd_shift = b.fs_kd_shift and a.lokasi = b.lokasi 
				left join \"Catering\".tpesanan c 
				on a.fs_tempat_makan = c.fs_tempat_makan and a.fs_kd_shift = c.fs_kd_shift and c.fd_tanggal = ? and a.lokasi = c.lokasi 
				left join \"Catering\".turutankatering d 
				on c.fd_tanggal = d.fd_tanggal and c.fs_tanda::int = d.fn_urutan and c.fs_kd_shift = d.fs_kd_shift and c.lokasi = d.lokasi 
				left join \"Catering\".turutankatering e 
				on a.fd_tanggal = e.fd_tanggal and a.fs_kd_shift = e.fs_kd_shift and d.fs_nama_katering = e.fs_nama_katering and d.lokasi = e.lokasi 
				where a.fd_tanggal = ?
				and a.fs_kd_shift = ? 
				and a.lokasi::int = ?::int 
				order by e.fn_urutan ";
		return $this->personalia->query($sql,array($tanggal_copy,$tanggal,$shift,$lokasi))->result_array();
	}

	public function insertPesananHistory($data){
		$this->personalia->insert('"Catering".tpesanan_history',$data);
	}

	public function insertTlog($data){
		$this->personalia->insert('hrd_khs.tlog',$data);
	}

	public function getPesananHistoryByTanggalShiftLokasi($tanggal,$shift,$lokasi){
		$sql = "select *
				from \"Catering\".tpesanan_history as tp 
				where tp.fd_tanggal = ? 
				and tp.fs_kd_shift = ? 
				and tp.lokasi = ?";
		return $this->personalia->query($sql,array($tanggal,$shift,$lokasi))->result_array();
	}

	public function getMenuDetailByTanggalBulanTahunShiftLokasi($tanggal,$bulan,$tahun,$shift,$lokasi){
		$sql = "select *
				from \"Catering\".t_menu tm 
				left join \"Catering\".t_menu_detail tmd 
				on tm.menu_id = tmd.menu_id
				where tmd.tanggal = ?
				and tm.bulan = ?
				and tm.tahun = ?
				and tm.shift = ?
				and tm.lokasi = ?";
		return $this->personalia->query($sql,array($tanggal,$bulan,$tahun,$shift,$lokasi))->row();
	}

	public function getPekerjaTidakMakanByTanggalTempatMakan($tanggal,$tempat_makan){
		$sql = "select tptm.pekerja,tp.tempat_makan
				from \"Catering\".t_permintaan_tidak_makan tptm
				left join hrd_khs.tpribadi tp 
				on trim(tp.noind) = trim(tptm.pekerja)
				where ?::date between tptm.dari and tptm.sampai
				and tp.tempat_makan = ?
				order by tptm.pekerja";
		return $this->personalia->query($sql,array($tanggal,$tempat_makan))->result_array();
	}

	public function getPesananPenguranganByIdPengurangan($id_pengurangan){
		$sql = "select * 
				from \"Catering\".tpenguranganpesanan_detail 
				where id_pengurangan =  ?
				and trim(fs_noind) = trim(?)";
		return $this->personalia->query($sql,array($id_pengurangan,$noind))->result_array();
	}

	public function getPesananPenguranganByIdPenguranganNoind($id_pengurangan,$noind){
        $sql = "select *
                from \"Catering\".tpenguranganpesanan_detail
                where id_pengurangan = ?
                and fs_noind = ? ";
        return $this->personalia->query($sql,array($id_pengurangan,$noind))->result_array();
    }

	public function insertPesananPenguranganDetail($id_pengurangan,$noind){
		$sql = "insert into \"Catering\".tpenguranganpesanan_detail 
				(id_pengurangan,fs_noind,fs_nama,fs_ket) 
				select ?,trim(noind),nama,jabatan 
				From hrd_khs.tpribadi 
				where trim(noind) = trim(?) ";
 		$this->personalia->query($sql,array($id_pengurangan,$noind));
	}

	public function insertPesananPenguranganTidakMakan($tanggal,$tempat_makan,$shift){
		$sql = "insert into \"Catering\".tpenguranganpesanan 
				(fd_tanggal,fs_tempat_makan,fs_kd_shift,fn_jml_tdkpesan,fb_kategori) 
				values(?,?,?,0,'8')";
		$this->personalia->query($sql,array($tanggal,$tempat_makan,$shift));
	}

	public function updatePesananPenguranganTotalByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempat_makan,$kategori){
		$sql = "update \"Catering\".tpenguranganpesanan tpt
				set fn_jml_tdkpesan = ( 
				select count(*) 
				from \"Catering\".tpenguranganpesanan_detail tptd
				where tptd.id_pengurangan = tpt.id_pengurangan 
				) 
				Where fd_tanggal = ?
				  and fs_kd_shift = ?
				  and fs_tempat_makan = ?
				  and fb_kategori = ? ";
		$this->personalia->query($sql,array($tanggal,$shift,$tempat_makan,$kategori));
	}

	public function deletePesananDetailByTanggalShiftLokasi($tanggal,$shift,$lokasi,$jenis){
		$sql = "delete from \"Catering\".t_pesanan_detail 
				where tanggal = ?
				and shift = ?
				and lokasi = ?
				and jenis = ?";
		$this->personalia->query($sql,array($tanggal,$shift,$lokasi,$jenis));
	}

	public function getPesananTambahanDetailByTanggalShiftLokasi($tanggal,$shift,$lokasi){
		$sql = "select 
					t.fd_tanggal,
					t.fs_kd_shift,
					tt.fs_lokasi,
					t.fs_tempat_makan,
					trim(td.fs_noind) as fs_noind,
					fb_kategori
				from \"Catering\".tpesanantambahan t 
				inner join \"Catering\".tpesanantambahan_detail td 
				on t.id_tambahan = td.id_tambahan
				inner join \"Catering\".ttempat_makan tt 
				on t.fs_tempat_makan = tt.fs_tempat_makan
				where t.fd_tanggal = ?
				and t.fs_kd_shift = ?
				and tt.fs_lokasi = ?";
		return $this->personalia->query($sql,array($tanggal,$shift,$lokasi))->result_array();
	}

	public function getPesananDetailByTanggalShiftLokasiNoind($tanggal,$shift,$lokasi,$noind){
		$sql = "select *
				from \"Catering\".t_pesanan_detail 
				where tanggal = ?
				anf shift = ?
				and lokasi = ?
				and trim(noind) = trim(?) ";
		return $this->personalia->query($sql,array($tanggal,$shift,$lokasi,$noind))->result_array();
	}

	public function insertPesananDetail($data){
		$this->personalia->insert('"Catering".t_pesanan_detail',$data);
	}

	public function getAbsenShiftSatuDetailByTanggalLokasi($tanggal,$lokasi,$jenis){
		if ($jenis == "Snack") {
			$sql = "select *
					from (
							select 	trim(tpres.noind) as noind, 
									tpri.tempat_makan as tempat_makan, 
									count(tpri.tempat_makan) as jumlah_karyawan,
									'absen' as keterangan
							from hrd_khs.tpribadi tpri
							inner join \"Catering\".tpresensi tpres 
								ON trim(tpres.noind) = trim(tpri.noind) 
								and left(tpres.waktu, 5) >= (
									 select left(fs_jam_awal,5)
									 from \"Catering\".tbatas_datang_shift 
									 where fs_kd_shift = '1' 
									 and fs_hari = (extract(dow from ?::date)+1)::varchar
								)
								and left(tpres.waktu, 5) <= (
									 select left(fs_jam_akhir,5)
									 from \"Catering\".tbatas_datang_shift 
									 where fs_kd_shift = '1' 
									 and fs_hari = (extract(dow from ?::date)+1)::varchar
								) 
								and tpres.tanggal = ?
							inner join \"Catering\".ttempat_makan tmkn 
								on tpri.tempat_makan = tmkn.fs_tempat_makan 
								and tmkn.fs_lokasi = ?
							Where 
							trim(tpres.noind) not in (
								select trim(fs_noind) as noind 
								from \"Catering\".tpuasa 
								where fd_tanggal = ?::date
								and fb_status = '1'
							) 
							and trim(tpres.noind) not in (
								select trim(noind) as noind 
								from \"Presensi\".tshiftPekerja 
								where tanggal in (?::date - interval '1 day', ?::date) 
								and kd_shift in ('3', '12')
							) 
							and left(trim(tpres.noind), 1) not in ('M','Z') 
							and trim(tpres.noind) not in (
								select distinct trim(t.noind) as noind 
								from \"Presensi\".tshiftpekerja t  
								where kd_shift = '2' 
								and tanggal = ?::date - interval '1 day' 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and ts.waktu::time < t.jam_msk::time + interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) > 0 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) = 1
							) 
							group by tpri.tempat_makan, trim(tpres.noind)
						) derivedtbl 
					order by tempat_makan ";
			return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$lokasi,$tanggal,$tanggal,$tanggal,$tanggal))->result_array();
		}else{
			$sql = "select *
					from (
							select 	trim(tpres.noind) as noind, 
									tpri.tempat_makan as tempat_makan, 
									count(tpri.tempat_makan) as jumlah_karyawan,
									'absen' as keterangan
							from hrd_khs.tpribadi tpri
							inner join \"Catering\".tpresensi tpres 
								ON trim(tpres.noind) = trim(tpri.noind) 
								and left(tpres.waktu, 5) >= (
									 select left(fs_jam_awal,5)
									 from \"Catering\".tbatas_datang_shift 
									 where fs_kd_shift = '1' 
									 and fs_hari = (extract(dow from ?::date)+1)::varchar
								)
								and left(tpres.waktu, 5) <= (
									 select left(fs_jam_akhir,5)
									 from \"Catering\".tbatas_datang_shift 
									 where fs_kd_shift = '1' 
									 and fs_hari = (extract(dow from ?::date)+1)::varchar
								) 
								and tpres.tanggal = ?
							inner join \"Catering\".ttempat_makan tmkn 
								on tpri.tempat_makan = tmkn.fs_tempat_makan 
								and tmkn.fs_lokasi = ?
							Where 
							trim(tpres.noind) not in (
								select trim(fs_noind) as noind 
								from \"Catering\".tpuasa 
								where fd_tanggal = ?::date 
								and fb_status = '1'
							) 
							and trim(tpres.noind) not in (
								select trim(noind) as noind 
								from \"Presensi\".tshiftPekerja 
								where tanggal in (?::date - interval '1 day', ?::date) 
								and kd_shift in ('3', '12')
							) 
							and left(trim(tpres.noind), 1) not in ('M','Z') 
							and trim(tpres.noind) not in (
								select distinct trim(t.noind) as noind 
								from \"Presensi\".tshiftpekerja t  
								where kd_shift = '2' 
								and tanggal = ?::date - interval '1 day' 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and ts.waktu::time < t.jam_msk::time + interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) > 0 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) = 1
							) 
							and trim(tpres.noind) not in (
								select 	trim(a.noind)
								from hrd_khs.tpribadi a 
								inner join \"Presensi\".tshiftpekerja b 
									on trim(a.noind) = trim(b.noind) 
								inner join \"Catering\".ttempat_makan tmkn 
									on a.tempat_makan = tmkn.fs_tempat_makan 
									and tmkn.fs_lokasi = ?
								left join \"Catering\".tpuasa p 
									on b.tanggal=p.fd_tanggal 
									and trim(b.noind) = trim(p.fs_noind) 
								where b.tanggal = ? 
									and b.kd_shift in('5','8','18') 
									and left(trim(a.noind), 1) not in ('M','Z') 
									and (
										p.fb_status is null 
										or p.fb_status<>'1'
									) 
							)
							group by tpri.tempat_makan, trim(tpres.noind)
							union 
							select 	trim(a.noind) as noind,
									a.tempat_makan,
									count(a.tempat_makan) as jumlah_karyawan,
									'Shift Tanggung' as  keterangan
							from hrd_khs.tpribadi a 
							inner join \"Presensi\".tshiftpekerja b 
								on trim(a.noind) = trim(b.noind) 
							inner join \"Catering\".ttempat_makan tmkn 
								on a.tempat_makan = tmkn.fs_tempat_makan 
								and tmkn.fs_lokasi = ?
							left join \"Catering\".tpuasa p 
								on b.tanggal=p.fd_tanggal 
								and trim(b.noind) = trim(p.fs_noind) 
							where b.tanggal = ? 
								and b.kd_shift in('5','8','18') 
								and left(trim(a.noind), 1) not in ('M','Z') 
								and (
									p.fb_status is null 
									or p.fb_status<>'1'
								) 
							group by a.tempat_makan, a.nama,trim(a.noind),b.jam_msk
							union
							select noind, tempat_makan, count(*), 'TKPW G'
							from hrd_khs.tpribadi a
							inner join \"Catering\".ttempat_makan tmkn 
								on a.tempat_makan = tmkn.fs_tempat_makan 
								and tmkn.fs_lokasi = ?
							where noind = 'G1043'
							and (
								select count(*)
								from \"Catering\".tpresensi b 
								where b.noind = a.noind
								and b.tanggal = ?
								and left(b.waktu, 5) >= (
									select left(c.fs_jam_akhir,5)
									from \"Catering\".tbatas_datang_shift c
									where c.fs_kd_shift = '1' 
									and c.fs_hari = (extract(dow from b.tanggal::date)+1)::varchar
								) 
								and left(b.waktu,5) <= (
									select left(d.jam_akhmsk,5)
									from \"Presensi\".tjamshift d
									where d.kd_shift = '8'
									and d.hari = (
										case extract(dow from b.tanggal::date)
											when 0 then 'Minggu'
											when 1 then 'Senin'
											when 2 then 'Selasa'
											when 3 then 'Rabu'
											when 4 then 'Kamis'
											when 5 then 'Jumat'
											when 6 then 'Sabtu'
										end
									)
								)
							) > 0
							group by a.noind, a.tempat_makan
						) derivedtbl 
					order by tempat_makan ";
			return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$lokasi,$tanggal,$tanggal,$tanggal,$tanggal,$lokasi,$tanggal,$lokasi,$tanggal,$lokasi,$tanggal))->result_array();
		}
	}

	public function getAbsenShiftDuaDetailByTanggalLokasi($tanggal,$lokasi,$jenis){
		if ($jenis == "Snack") {
			$sql = "select *
					from (
						select trim(tpres.noind) as noind, 
								tpri.tempat_makan as tempat_makan, 
								count(tpri.tempat_makan) as jumlah_karyawan,
								'absen' as keterangan 
						from hrd_khs.tpribadi tpri 
						inner join \"Catering\".tpresensi tpres 
							on trim(tpres.noind) = tpri.noind 
							and left(tpres.waktu, 5) >= (
								 select left(fs_jam_awal,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '2' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							) 
							and left(tpres.waktu, 5) <= (
								 select left(fs_jam_akhir,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '2' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							)  
							and tpres.tanggal = ? 
						inner join \"Catering\".ttempat_makan tmkn 
							on tpri.tempat_makan = tmkn.fs_tempat_makan 
							and tmkn.fs_lokasi = ?
						where trim(tpres.noind) not in (
							select trim(noind) as noind 
							from \"Catering\".tpresensi
							where left(waktu, 5) >= (
								 select left(fs_jam_awal,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '1' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							)   
							and left(waktu, 5) <= (
								 select left(fs_jam_akhir,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '1' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							)   
							and tanggal = ?::date
							and trim(noind) not in ( 
								select trim(noind) as noind 
								from (
									select trim(t.noind) as noind, count(trim(t.noind)) as jml 
									from \"Catering\".tpresensi t, \"Presensi\".tshiftPekerja s 
									where t.tanggal in (?::date - interval '1 day', ?::date) 
									and t.waktu < '23:00:00'
									and t.waktu > '20:30:00' 
									and s.kd_shift in ('3', '12')  
									and trim(t.noind) = trim(s.noind) 
									group by trim(t.noind)
								) derivedtbl 
								where jml = '1' and trim(noind) not in (
									select trim(noind) as noind 
									from \"Catering\".tpresensi 
									where waktu <= '20:30:00' 
									and waktu >= '11:00:00'
									and tanggal = ?::date
								) 
							) 
							and trim(tpres.noind) not in (
								select distinct trim(t.noind) as noind 
								from \"Presensi\".tshiftpekerja t  
								where kd_shift = '2' 
								and tanggal = ?::date - interval '1 day' 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and ts.waktu::time < t.jam_msk::time + interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) > 0 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) = 1
							)  
						) 
						and left(trim(tpres.noind), 1) not in ('M','Z') 	
						group by tpri.tempat_makan, trim(tpres.noind)
					) derivedtbl 
					order by tempat_makan ";
			return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$lokasi,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal))->result_array();
		}else{
			$sql = "select *
					from (
						select trim(tpres.noind) as noind, 
								tpri.tempat_makan as tempat_makan, 
								count(tpri.tempat_makan) as jumlah_karyawan,
								'absen' as keterangan 
						from hrd_khs.tpribadi tpri 
						inner join \"Catering\".tpresensi tpres 
							on trim(tpres.noind) = trim(tpri.noind) 
							and left(tpres.waktu, 5) >= (
								 select left(fs_jam_awal,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '2' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							) 
							and left(tpres.waktu, 5) <= (
								 select left(fs_jam_akhir,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '2' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							)  
							and tpres.tanggal = ? 
						inner join \"Catering\".ttempat_makan tmkn 
							on tpri.tempat_makan = tmkn.fs_tempat_makan 
							and tmkn.fs_lokasi = ?
						where trim(tpres.noind) not in (
							select trim(noind) as noind 
							from \"Catering\".tpresensi
							where left(waktu, 5) >= (
								 select left(fs_jam_awal,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '1' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							)   
							and left(waktu, 5) <= (
								 select left(fs_jam_akhir,5)
								 from \"Catering\".tbatas_datang_shift 
								 where fs_kd_shift = '1' 
								 and fs_hari = (extract(dow from ?::date)+1)::varchar
							)   
							and tanggal = ?::date
							and trim(noind) not in ( 
								select trim(noind) as noind 
								from (
									select trim(t.noind) as noind, count(t.noind) as jml 
									from \"Catering\".tpresensi t, \"Presensi\".tshiftPekerja s 
									where t.tanggal in (?::date - interval '1 day', ?::date) 
									and t.waktu < '23:00:00'
									and t.waktu > '20:30:00' 
									and s.kd_shift in ('3', '12')  
									and trim(t.noind) = trim(s.noind) 
									group by trim(t.noind)
								) derivedtbl 
								where jml = '1' and trim(noind) not in (
									select trim(noind) as noind 
									from \"Catering\".tpresensi 
									where waktu <= '20:30:00' 
									and waktu >= '11:00:00'
									and tanggal = ?::date
								) 
							) 
							and trim(tpres.noind) not in (
								select distinct trim(t.noind) as noind 
								from \"Presensi\".tshiftpekerja t  
								where kd_shift = '2' 
								and tanggal = ?::date - interval '1 day' 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and ts.waktu::time < t.jam_msk::time + interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) > 0 
								and ( 
									select count(*) 
									from \"Presensi\".tprs_shift ts  
									where ts.tanggal = t.tanggal  
									and trim(ts.noind) = trim(t.noind)  
									and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
									and trim(ts.waktu) not in ('0') 
								) = 1
							) 
							union 
							select trim(noind) as noind 
							from \"Presensi\".tshiftpekerja 
							where kd_shift in('5','8','18') 
							and tanggal= ? 
						) 
						and left(trim(tpres.noind), 1) not in ('M','Z') 	
						group by tpri.tempat_makan, trim(tpres.noind)
					) derivedtbl 
					order by tempat_makan ";
			return $this->personalia->query($sql,array($tanggal,$tanggal,$tanggal,$lokasi,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal,$tanggal))->result_array();	
		}
	}

	public function getAbsenShiftTigaDetailByTanggalLokasi($tanggal,$lokasi){
		$sql = "select trim(tsh.noind) as noind, 'absen' as keterangan,tpri.tempat_makan
				from \"Presensi\".tshiftpekerja tsh, hrd_khs.tpribadi tpri
				inner join \"Catering\".ttempat_makan tmkn 
					on tpri.tempat_makan = tmkn.fs_tempat_makan 
					and tmkn.fs_lokasi = ?
				where trim(tsh.noind) = trim(tpri.noind) 
				and tanggal = ?
				and kd_shift in ('3', '12') 
				and left(trim(tpri.noind), 1) not in ('M','Z') 
				order by tempat_makan ";
		return $this->personalia->query($sql,array($lokasi,$tanggal))->result_array();
	}

	public function getPesananPenguranganDetailByTanggalShiftLokasi($tanggal,$shift,$lokasi){
		$sql = "select 
					t.fd_tanggal,
					t.fs_kd_shift,
					tt.fs_lokasi,
					ttpg.fs_lokasi as fs_lokasipg,
					t.fs_tempat_makan,
					t.fs_tempat_makanpg,
					trim(td.fs_noind) as fs_noind,
					t.fb_kategori
				from \"Catering\".tpenguranganpesanan t 
				inner join \"Catering\".tpenguranganpesanan_detail td 
				on t.id_pengurangan = td.id_pengurangan
				inner join \"Catering\".ttempat_makan tt 
				on t.fs_tempat_makan = tt.fs_tempat_makan
				left join \"Catering\".ttempat_makan ttpg 
				on t.fs_tempat_makanpg = ttpg.fs_tempat_makan
				where t.fd_tanggal = ?
				and t.fs_kd_shift = ?
				and (
					tt.fs_lokasi = ?
					or ttpg.fs_lokasi = ?
				)";
		return $this->personalia->query($sql,array($tanggal,$shift,$lokasi,$lokasi))->result_array();
	}

	public function getMenuPenggantiByTanggalShiftLokasiTempatMakan($tanggal,$shift,$lokasi,$tempat_makan,$custom_condition){
		$sql = "select tpd.*,tpmk.*,trim(tp.nama) as nama
				from \"Catering\".t_pesanan_detail tpd
				inner join \"Catering\".t_pekerja_menu_khusus tpmk
				on trim(tpd.noind) = trim(tpmk.noind)
				and tpd.tanggal between tpmk.tanggal_mulai and tpmk.tanggal_selesai
				left join hrd_khs.tpribadi tp 
				on trim(tpd.noind) = trim(tp.noind)
				where tpd.tanggal = ?
				and tpd.shift = ?
				and tpd.lokasi = ?
				and tpd.tempat_makan = ?
				and tpd.noind not in (
					select tpd2.noind
					from \"Catering\".t_pesanan_detail tpd2
					where tpd2.tanggal = tpd.tanggal
					and tpd2.tempat_makan = tpd.tempat_makan
					and tpd2.shift = tpd.shift
					and left(lower(tpd2.keterangan),11) = 'pengurangan'
				)
				and (
					lower(tpd.keterangan) in ('absen', 'shift tanggung')
					or left(lower(tpd.keterangan),8) = 'tambahan'
				)
				and ( 
					( 
						1 = 1 $custom_condition 
					)
					or 
					(
						(tpmk.menu_sayur = 'Semua Sayur' and tpmk.menu_sayur <> tpmk.pengganti_sayur)
						or (tpmk.menu_lauk_utama = 'Semua Lauk Utama' and tpmk.menu_lauk_utama <> tpmk.pengganti_lauk_utama)
						or (tpmk.menu_lauk_pendamping = 'Semua Lauk Pendamping' and tpmk.menu_lauk_pendamping <> tpmk.pengganti_lauk_pendamping)
						or (tpmk.menu_buah = 'Semua Buah' and tpmk.menu_buah <> tpmk.pengganti_buah)
					)
				)
				order by trim(tpmk.noind) ";
		return $this->personalia->query($sql,array($tanggal,$shift,$lokasi,$tempat_makan))->result_array();
	}

	public function insertUrutanKatering($data){
		$this->personalia->insert('"Catering".turutankatering', $data);
	}

	public function getTempatMakanKemarinBelumAda($tanggal,$shift,$lokasi){
			$sql = "select *  
			from ( 
				select a.fs_tempat_makan,a.fs_kd_shift,a.fn_jumlah_pesan, 
				( 
					select count(*) from \"Catering\".tpesanan b  
					where a.fs_tempat_makan = b.fs_tempat_makan  
					and a.fs_kd_shift = b.fs_kd_shift  
					and a.fd_tanggal + interval '1 day' = b.fd_tanggal
				) as jumlah 
				from \"Catering\".tpesanan a  
				inner join \"Catering\".ttempat_makan c  
				on a.fs_tempat_makan = c.fs_tempat_makan  
				where a.fd_tanggal = ?::date - interval '1 day' 
				and a.fs_kd_shift = ? 
				and a.lokasi = ?
				) as tbl  
			where jumlah =  0"; 
		return $this->personalia->query($sql,array($tanggal,$shift,$lokasi))->result_array();
	}

	public function cekPassword($user,$password){
		$sql = "select *
				from sys.sys_user
				where user_name = ?
				and user_password = md5(?)";
		return $this->erp->query($sql,array($user,$password))->result_array();
	}
}

?>