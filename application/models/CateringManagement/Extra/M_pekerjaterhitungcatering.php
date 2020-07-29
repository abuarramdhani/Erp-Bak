<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pekerjaterhitungcatering extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia',TRUE);
    }

    public function getTempatMakanAll(){
    	$sql = "select *,
    				case when fs_lokasi = '1' then 
						'YGY'
					when fs_lokasi = '2' then 
						'TKS'
					else 'N?A' 
					end as lokasi
				from \"Catering\".ttempat_makan";
		return $this->personalia->query($sql)->result_array();
    }

    public function getListShiftSatu($tanggal,$tempat_makan,$lokasi){
    	$sql = "select *, 
					case when ( 
				       select count(*) 
				       from \"Catering\".tpesanantambahan t5 
				       inner join \"Catering\".tpesanantambahan_detail t6 
				       on t5.id_tambahan = t6.id_tambahan 
				       where t5.fd_tanggal = '$tanggal' 
				       and t5.fs_kd_shift = '1' 
				       and t6.fs_noind = tbl.noind 
				       and t5.fs_tempat_makan = tbl.tempat_makan 
					) > 0 then
				    	( 
					       select 
					       		string_agg(
									case when t5.fb_kategori = '1' then 
										'TAMBAHAN - LEMBUR'
									when t5.fb_kategori = '2' then
										'TAMBAHAN - SHIFT TANGGUNG'
									when t5.fb_kategori = '3' then
										'TAMBAHAN - TUGAS KE PUSAT'
									when t5.fb_kategori = '4' then
										'TAMBAHAN - TUGAS KE TUKSONO'
									when t5.fb_kategori = '5' then
										'TAMBAHAN - TUGAS KE MLATI'
									when t5.fb_kategori = '6' then
										'TAMBAHAN - TAMU'
									when t5.fb_kategori = '7' then
										'TAMBAHAN - CADANGAN'
									else
										'TAMBAHAN - tidak terkategori'
									end
									,';'
								)
					       from \"Catering\".tpesanantambahan t5 
					       inner join \"Catering\".tpesanantambahan_detail t6 
					       on t5.id_tambahan = t6.id_tambahan 
					       where t5.fd_tanggal = '$tanggal' 
					       and t5.fs_kd_shift = '1' 
					       and t6.fs_noind = tbl.noind 
					       and t5.fs_tempat_makan = tbl.tempat_makan 
						)
					when ( 
				       select count(*) 
				       from \"Catering\".tpenguranganpesanan t7 
				       inner join \"Catering\".tpenguranganpesanan_detail t8 
				       on t7.id_pengurangan = t8.id_pengurangan 
				       where t7.fd_tanggal = '$tanggal' 
				       and t7.fs_kd_shift = '1' 
				       and t8.fs_noind = tbl.noind 
				       and t7.fs_tempat_makan = tbl.tempat_makan 
					) > 0 then 
					    ( 
					       select string_agg(
									case when t7.fb_kategori = '1' then 
										'PENGURANGAN - TIDAK MAKAN ( GANTI UANG )'
									when t7.fb_kategori = '2' then
										'PENGURANGAN - PINDAH MAKAN'
									when t7.fb_kategori = '3' then
										'PENGURANGAN - TUGAS KE PUSAT'
									when t7.fb_kategori = '4' then
										'PENGURANGAN - TUGAS KE TUKSONO'
									when t7.fb_kategori = '5' then
										'PENGURANGAN - TUGAS KE MLATI'
									when t7.fb_kategori = '6' then
										'PENGURANGAN - TUGAS LUAR'
									when t7.fb_kategori = '7' then
										'PENGURANGAN - DINAS PERUSAHAAN ( KUNJUNGAN KERJA / LAYAT / DLL )'
									when t7.fb_kategori = '8' then
										'PENGURANGAN - TIDAK MAKAN ( TIDAK DIGANTI UANG )'
									else
										'PENGURANGAN - tidak terkategori'
									end
									,';'
								)
					       from \"Catering\".tpenguranganpesanan t7 
					       inner join \"Catering\".tpenguranganpesanan_detail t8 
					       on t7.id_pengurangan = t8.id_pengurangan 
					       where t7.fd_tanggal = '$tanggal' 
					       and t7.fs_kd_shift = '1' 
					       and t8.fs_noind = tbl.noind 
					       and t7.fs_tempat_makan = tbl.tempat_makan 
						)
					when ( 
				       select count(*) 
				       from \"Catering\".tpenguranganpesanan t7 
				       inner join \"Catering\".tpenguranganpesanan_detail t8 
				       on t7.id_pengurangan = t8.id_pengurangan 
				       where t7.fd_tanggal = '$tanggal' 
				       and t7.fs_kd_shift = '1' 
				       and t8.fs_noind = tbl.noind 
				       and t7.fs_tempat_makanpg = tbl.tempat_makan 
				       and t7.fb_kategori = '2'
					) > 0 then 
					    'TAMBAHAN - PINDAH MAKAN' 
					Else 
					    'ABSEN' 
					end As status 
				from ( 
					SELECT 
						tpres.noind AS noind, 
						tp.Nama AS nama, 
						tpres.waktu,
				   		tp.tempat_makan AS tempat_makan, 
				   		COUNT(tp.tempat_makan) AS jumlah_karyawan,
				   		coalesce(tpres.user_,'-') as user_, 
						(
							select xx.seksi 
							from hrd_khs.tseksi xx 
							where xx.kodesie = tp.kodesie
						) as seksi, 
						coalesce(
							(
								select replace(upper(zz.shift),'SHIFT ','') as shift 
								from \"Presensi\".tshiftpekerja xxx 
								left join \"Presensi\".tshift zz 
								on xxx.kd_shift = zz.kd_shift 
								where xxx.noind = tpres.noind 
								and xxx.tanggal = tpres.tanggal
							),
							'Blm ada Shift'
						) as shift 
					FROM hrd_khs.tPribadi tp 
					INNER JOIN \"Catering\".tpresensi tpres ON tpres.noind = tp.noind 
				   	AND LEFT(tpres.waktu, 5) >= (
				   			select fs_jam_awal
							from \"Catering\".tbatas_datang_shift
							where fs_kd_shift = '1'
							and fs_hari = extract(isodow from tpres.tanggal)::varchar
					)
				   	AND LEFT(tpres.waktu, 5) <= (
				   			select fs_jam_akhir
							from \"Catering\".tbatas_datang_shift
							where fs_kd_shift = '1'
							and fs_hari = extract(isodow from tpres.tanggal)::varchar
					) 
				   	AND tpres.tanggal = '$tanggal'
					INNER JOIN \"Catering\".ttempat_makan tmkn 
					on tp.tempat_makan = tmkn.fs_tempat_makan 
					and tmkn.fs_lokasi in ($lokasi)
					WHERE tpres.noind NOT IN (
						SELECT fs_noind 
						FROM \"Catering\".tpuasa 
					   	WHERE (fd_tanggal = '$tanggal') 
					  	AND (fb_status = '1')
					) 
					AND tpres.noind NOT IN (
						select distinct t.noind 
					    from \"Presensi\".tshiftpekerja t  
						where kd_shift = '2' 
						and tanggal = '$tanggal'::date - interval '1 day' 
						and ( 
					        select count(*) 
					        from \"Presensi\".tprs_shift ts  
							where ts.tanggal = t.tanggal  
							and ts.noind = t.noind  
							and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
					 		and ts.waktu::time < t.jam_msk::time + interval '1 hours' 
							and trim(ts.waktu) not in ('0') 
						) > 0 
					    and ( 
					    	select count(*) 
					    	from \"Presensi\".tprs_shift ts  
							where ts.tanggal = t.tanggal  
							and ts.noind = t.noind  
							and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
							and trim(ts.waktu) not in ('0') 
					   	) = 1
					) 
					AND tpres.noind NOT IN (
						SELECT noind 
						FROM \"Presensi\".tshiftPekerja 
						WHERE tanggal IN ('$tanggal'::date - interval '1 day', '$tanggal') 
						AND kd_shift IN ('3', '12')
					)  
					AND trim(tp.tempat_makan) = '$tempat_makan' 
					AND LEFT(tp.noind, 1) NOT IN ('M', 'Z') 
					GROUP BY 
						tp.tempat_makan, 
						tp.Nama, 
						tpres.noind, 
						tpres.waktu,
						tpres.user_,
						tp.kodesie,
						tpres.tanggal 
					union 
					select 
						t2.fs_noind,
						t2.fs_nama,
						'-' as waktu,
						t.fs_tempat_makan,
						1 as jumlah_karyawan,
						'-' as user_,
						(
							select t4.seksi 
							from hrd_khs.tpribadi t3 
							left join hrd_khs.tseksi t4 
							on t3.kodesie = t4.kodesie 
							where t3.noind = t2.fs_noind 
						) as seksi, 
						coalesce(
							(
								select replace(upper(zz.shift),'SHIFT ','') as shift 
								from \"Presensi\".tshiftpekerja xxx 
								left join \"Presensi\".tshift zz 
								on xxx.kd_shift = zz.kd_shift 
								where xxx.noind = t2.fs_noind 
								and xxx.tanggal = t.fd_tanggal
							),
							'Blm ada Shift'
						) as shift 
					from \"Catering\".tpesanantambahan t 
					inner join \"Catering\".tpesanantambahan_detail t2 
					on t.id_tambahan = t2.id_tambahan 
					where trim(t.fs_tempat_makan) = '$tempat_makan' 
					and t.fd_tanggal = '$tanggal' 
					and t.fs_kd_shift = '1'
					union 
					select 
						t2.fs_noind,
						t2.fs_nama,
						'-' as waktu,
						t.fs_tempat_makanpg,
						1 as jumlah_karyawan,
						'-' as user_,
						(
							select t4.seksi 
							from hrd_khs.tpribadi t3 
							left join hrd_khs.tseksi t4 
							on t3.kodesie = t4.kodesie 
							where t3.noind = t2.fs_noind 
						) as seksi, 
						coalesce(
							(
								select replace(upper(zz.shift),'SHIFT ','') as shift 
								from \"Presensi\".tshiftpekerja xxx 
								left join \"Presensi\".tshift zz 
								on xxx.kd_shift = zz.kd_shift 
								where xxx.noind = t2.fs_noind 
								and xxx.tanggal = t.fd_tanggal
							),
							'Blm ada Shift'
						) as shift 
					from \"Catering\".tpenguranganpesanan t 
					inner join \"Catering\".tpenguranganpesanan_detail t2 
					on t.id_pengurangan = t2.id_pengurangan
					where trim(t.fs_tempat_makanpg) = '$tempat_makan' 
					and t.fd_tanggal = '$tanggal' 
					and t.fs_kd_shift = '1'
					and t.fb_kategori = '2'
					union
					select 
						a.noind,
						a.nama,
						b.jam_msk as waktu,
						a.tempat_makan,
						COUNT(a.tempat_makan) AS jumlah_karyawan,
						'-' as user_, 
						(
							select xx.seksi 
							from hrd_khs.tseksi xx 
							where xx.kodesie = a.kodesie
						) as seksi, 
						coalesce(
							(
								select replace(upper(zz.shift),'SHIFT ','') as shift 
								from \"Presensi\".tshiftpekerja xxx 
								left join \"Presensi\".tshift zz 
								on xxx.kd_shift = zz.kd_shift  
								where xxx.noind = a.noind 
								and xxx.tanggal = b.tanggal
							),
							'Blm ada Shift'
						) as shift 
					FROM hrd_khs.tPribadi a 
					inner join \"Presensi\".tshiftpekerja b 
					on a.noind=b.noind 
					left join \"Catering\".tpuasa p 
					on b.tanggal=p.fd_tanggal 
					and b.noind=p.fs_noind 
					INNER JOIN \"Catering\".ttempat_makan tmkn 
					on a.tempat_makan = tmkn.fs_tempat_makan 
					and tmkn.fs_lokasi in ($lokasi)
					where b.tanggal = '$tanggal' 
					and (
						p.fb_status is null 
						or p.fb_status<>'1'
					) 
					and b.kd_shift in('5','8','18') 
					and trim(a.tempat_makan) = '$tempat_makan' 
					GROUP BY 
						a.tempat_makan, 
						a.Nama,
						a.noind,
						b.jam_msk,
						a.kodesie,
						b.tanggal 
				) as tbl 
				ORDER BY 
					tbl.tempat_makan, 
					tbl.noind";
		return $this->personalia->query($sql)->result_array();
    }

    public function getListShiftDua($tanggal,$tempat_makan,$lokasi){
    	$sql = "select *, 
				case when ( 
			        select count(*) 
			        from \"Catering\".tpesanantambahan t5 
			        inner join \"Catering\".tpesanantambahan_detail t6 
			        on t5.id_tambahan = t6.id_tambahan 
			        where t5.fd_tanggal = '$tanggal' 
			        and t5.fs_kd_shift = '2' 
			        and t6.fs_noind = tbl.noind 
			        and t5.fs_tempat_makan = tbl.tempat_makan 
			    ) > 0 then 
			        'Tambahan' 
			    when ( 
			        select count(*) 
			        from \"Catering\".tpenguranganpesanan t7 
			        inner join \"Catering\".tpenguranganpesanan_detail t8 
			        on t7.id_pengurangan = t8.id_pengurangan 
			        where t7.fd_tanggal = '$tanggal' 
			        and t7.fs_kd_shift = '2' 
			        and t8.fs_noind = tbl.noind 
			        and t7.fs_tempat_makan = tbl.tempat_makan 
			    ) > 0 then 
			        'Pengurangan' 
			    Else 
			        'Absen' 
			    end As StAtUs 
			from ( 
				SELECT 
					tpres.noind AS noind, 
					tp.Nama AS nama, 
					tpres.waktu, 
					tp.tempat_makan AS tempat_makan, 
					COUNT(tp.tempat_makan) AS jumlah_karyawan,
					coalesce(tpres.user_,'-') as user_, 
					(
						select xx.seksi 
						from hrd_khs.tseksi xx 
						where xx.kodesie = tp.kodesie
					) as seksi, 
					coalesce(
						(
							select replace(upper(zz.shift),'SHIFT ','') as shift 
							from \"Presensi\".tshiftpekerja xxx 
							left join \"Presensi\".tshift zz 
							on xxx.kd_shift = zz.kd_shift 
							where xxx.noind = tpres.noind 
							and xxx.tanggal = tpres.tanggal
						),
						'Blm ada Shift'
					) as shift 
				FROM hrd_khs.tPribadi tp 
				INNER JOIN \"Catering\".tpresensi tpres 
				ON tpres.noind = tp.noind 
			   	AND LEFT(tpres.waktu, 5) >= (
				   			select fs_jam_awal
							from \"Catering\".tbatas_datang_shift
							where fs_kd_shift = '2'
							and fs_hari = extract(isodow from tpres.tanggal)::varchar
					) 
			   	AND LEFT(tpres.waktu, 5) <= (
				   			select fs_jam_akhir
							from \"Catering\".tbatas_datang_shift
							where fs_kd_shift = '2'
							and fs_hari = extract(isodow from tpres.tanggal)::varchar
					)  
			   	AND tpres.tanggal = '$tanggal' 
				INNER JOIN \"Catering\".ttempat_makan tmkn 
				on tp.tempat_makan = tmkn.fs_tempat_makan 
				and tmkn.fs_lokasi in ($lokasi)
				WHERE tpres.noind NOT IN (
					SELECT noind 
					FROM \"Catering\".tpresensi 
				   	WHERE LEFT(waktu, 5) >= (
				   			select fs_jam_awal
							from \"Catering\".tbatas_datang_shift
							where fs_kd_shift = '1'
							and fs_hari = extract(isodow from tpres.tanggal)::varchar
					) 
				   	AND LEFT(waktu, 5) <= (
				   			select fs_jam_akhir
							from \"Catering\".tbatas_datang_shift
							where fs_kd_shift = '1'
							and fs_hari = extract(isodow from tpres.tanggal)::varchar
					) 
				   	AND (tanggal = '$tanggal')
				   	AND noind NOT IN (
				   		SELECT noind 
                  		FROM (
                  			SELECT t.noind, COUNT(t.noind) AS jml 
	                        FROM \"Catering\".tpresensi t, \"Presensi\".tshiftpekerja s 
	                        WHERE t.tanggal = '$tanggal'::date - interval '1 day' 
	                        AND t.waktu < '23:00:00' 
	                        AND t.waktu > '20:30:00' 
	                        AND s.kd_shift IN ('3', '12') 
	                        AND t.noind = s.noind 
	                        GROUP BY t.noind
	                    ) DERIVEDTBL 
                  		WHERE jml = '1' 
                    	AND noind NOT IN 
                        (
                        	SELECT noind 
                        	FROM \"Catering\".tpresensi 
                         	WHERE waktu <= '20:30:00' 
                         	and waktu >= '11:00:00' 
                           	AND tanggal = '$tanggal'::date - interval '1 day'
                        ) 
                 	) 
       				AND tpres.noind NOT IN (
       					select distinct t.noind 
                 		from \"Presensi\".tshiftpekerja t  
                 		where kd_shift = '2' 
                 		and tanggal = '$tanggal'::date - interval '1 day' 
                 		and ( 
                     		select count(*) 
                     		from \"Presensi\".tprs_shift ts  
                     		where ts.tanggal = t.tanggal  
                     		and ts.noind = t.noind  
                     		and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
               				and ts.waktu::time < t.jam_msk::time + interval '1 hours' 
                 	   		and trim(ts.waktu) not in ('0') 
                 		) > 0 
                 		and ( 
                 		    select count(*) 
                 		    from \"Presensi\".tprs_shift ts  
                 		    where ts.tanggal = t.tanggal  
                 		    and ts.noind = t.noind  
                 		    and ts.waktu::time > t.jam_msk::time - interval '1 hours' 
                 		    and trim(ts.waktu) not in ('0') 
                 		) = 1
                 	)
				    union 
				    select noind 
				    from \"Presensi\".tshiftpekerja 
				    where kd_shift in('5','8','18') 
				    and tanggal='$tanggal'
				   ) 
				AND trim(tp.tempat_makan) = '$tempat_makan' 
				AND LEFT(tp.noind, 1) NOT IN ('M', 'Z') 
				GROUP BY 
					tp.tempat_makan, 
					tp.Nama,
					tp.kodesie, 
					tpres.noind, 
					tpres.waktu,
					tpres.user_,
					tpres.tanggal 
				union 
				select 
					t2.fs_noind,
					t2.fs_nama,
					'-' as waktu,
					t.fs_tempat_makan,
					1 as jumlah_karyawan,
					'TAMBAHAN' as user_, 
					(
						select t4.seksi 
						from hrd_khs.tpribadi t3 
						left join hrd_khs.tseksi t4 
						on t3.kodesie = t4.kodesie 
						where t3.noind = t2.fs_noind 
					) as seksi, 
					coalesce(
						(
							select replace(upper(zz.shift),'SHIFT ','') as shift 
							from \"Presensi\".tshiftpekerja xxx 
							left join \"Presensi\".tshift zz 
							on xxx.kd_shift = zz.kd_shift 
							where xxx.noind = t2.fs_noind 
							and xxx.tanggal = t.fd_tanggal
						),
						'Blm ada Shift'
					) as shift 
				from \"Catering\".tpesanantambahan t 
				inner join \"Catering\".tpesanantambahan_detail t2 
				on t.id_tambahan = t2.id_tambahan 
				where trim(fs_tempat_makan) = '$tempat_makan' 
				and fd_tanggal = '$tanggal' 
				and t.fs_kd_shift = '2' 
				union 
				select 
					t2.fs_noind,
					t2.fs_nama,
					'-' as waktu,
					t.fs_tempat_makanpg,
					1 as jumlah_karyawan,
					'TAMBAHAN' as user_, 
					(
						select t4.seksi 
						from hrd_khs.tpribadi t3 
						left join hrd_khs.tseksi t4 
						on t3.kodesie = t4.kodesie 
						where t3.noind = t2.fs_noind 
					) as seksi, 
					coalesce(
						(
							select replace(upper(zz.shift),'SHIFT ','') as shift 
							from \"Presensi\".tshiftpekerja xxx 
							left join \"Presensi\".tshift zz 
							on xxx.kd_shift = zz.kd_shift 
							where xxx.noind = t2.fs_noind 
							and xxx.tanggal = t.fd_tanggal
						),
						'Blm ada Shift'
					) as shift 
				from \"Catering\".tpenguranganpesanan t 
				inner join \"Catering\".tpenguranganpesanan_detail t2 
				on t.id_pengurangan = t2.id_pengurangan 
				where trim(fs_tempat_makanpg) = '$tempat_makan' 
				and fd_tanggal = '$tanggal' 
				and t.fs_kd_shift = '2' 
				and t.fb_kategori = '2'
			) as tbl 
			ORDER BY 4,1";
		return $this->personalia->query($sql)->result_array();
    }

    function getPesananDetailByTanggalShiftLokasiTempatMakan($tanggal,$shift,$lokasi,$tempat_makan){
    	$sql = "select tpd.noind,trim(tp.nama) as nama,'-' as waktu,tpd.tempat_makan,'-' as user_,ts.seksi,coalesce(tsh.shift,'Blm ada shift') as shift,tpd.keterangan as status
				from \"Catering\".t_pesanan_detail tpd
				inner join hrd_khs.tpribadi tp 
				on tpd.noind = tp.noind
				left join \"Presensi\".tshiftpekerja tsp 
				on tpd.noind = tsp.noind
				and tpd.tanggal = tsp.tanggal
				left join \"Presensi\".tshift tsh 
				on tsh.kd_shift = tsp.kd_shift
				inner join hrd_khs.tseksi ts 
				on ts.kodesie = tp.kodesie
				where tpd.tanggal = ?
				and tpd.shift = ?
				and tpd.lokasi = ?
				and tpd.tempat_makan = ?
				and tpd.jenis = 'Makan'
				and tpd.noind not in 
				(
					select tpd2.noind
					from \"Catering\".t_pesanan_detail tpd2 
					where tpd2.tanggal = tpd.tanggal
					and tpd2.lokasi = tpd.lokasi
					and tpd2.shift = tpd.shift
					and tpd2.tempat_makan = tpd.tempat_makan
					and tpd2.jenis = tpd.jenis
					and tpd2.keterangan like 'PENGURANGAN%'
					and tpd2.noind = tpd.noind
					and tpd2.keterangan <> tpd.keterangan
				)";
		return $this->personalia->query($sql,array($tanggal,$shift,$lokasi,$tempat_makan))->result_array();
    }
}

?>