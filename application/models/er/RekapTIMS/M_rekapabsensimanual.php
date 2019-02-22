<?php
	class M_rekapabsensimanual extends CI_Model
	{
		
		public function __construct()
	    {
	        parent::__construct();
			$this->personalia = $this->load->database('personalia', TRUE );
	    }

		public function rekapAbsensiManual($tanggal_shift_1, $tanggal_shift_2)
		{
			$rekapAbsensiManual 		= "	select 		presman.*,
														coalesce
														(
															presman.create_timestamp,
															(
																select 		tlog.wkt
																from 		hrd_khs.tlog as tlog
																where 		tlog.menu like '%MANUAL%'
																			and 	tlog.ket like '%' || presman.noind || '%'
																			and 	tlog.ket like '%' || presman.tanggal_shift_cari || '%'
																			and     tlog.jenis like '%' || presman.masuk || ' - ' || presman.keluar || '%' 
																			and 	tlog.jenis like '%' || 'TAMBAH' || '%'
															)
														)::date as waktu_input,
														presman.approve_timestamp::date as waktu_approve
											from 		(
															select 		presman.tanggal::date as tanggal_shift,
																		to_char(presman.tanggal::date, 'DD Mon YYYY') as tanggal_shift_cari,
																		trim(presman.noind) as noind,
																		pri.nama,
																		presman.kodesie,
																		tseksi.dept,
																		tseksi.bidang,
																		tseksi.unit,
																		tseksi.seksi,
																		presman.masuk,
																		presman.keluar,
																		presman.ket as alasan,
																		presman.user_ as user_input,
																		presman.appr_ as user_approve,
																		presman.approve_timestamp,
																		presman.create_timestamp
															from 		\"Presensi\".tinput_presensi_manual as presman
																		join 	hrd_khs.v_hrd_khs_tpribadi as pri
																				on 	pri.noind=trim(presman.noind)
																		join 	hrd_khs.v_hrd_khs_tseksi as tseksi
																				on 	tseksi.kodesie=trim(presman.kodesie)
															where 		presman.tanggal between '$tanggal_shift_1' and '$tanggal_shift_2'
														) as presman
											order by 	tanggal_shift desc,
														create_timestamp desc,
														approve_timestamp desc;";
			$queryRekapAbsensiManual 	= 	$this->personalia->query($rekapAbsensiManual);
			return $queryRekapAbsensiManual->result_array();
		}
	}
?>