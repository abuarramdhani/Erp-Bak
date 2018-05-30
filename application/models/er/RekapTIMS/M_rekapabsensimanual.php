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
			$rekapAbsensiManual 		= "	select 		presman.tanggal::date as tanggal_shift,
														trim(presman.noind) as noind,
														pri.nama,
														presman.kodesie,
														tseksi.dept,
														tseksi.bidang,
														tseksi.unit,
														tseksi.seksi,
														presman.masuk,
														presman.keluar,
														presman.ket as alasan
											from 		\"Presensi\".tinput_presensi_manual as presman
														join 	hrd_khs.v_hrd_khs_tpribadi as pri
																on 	pri.noind=trim(presman.noind)
														join 	hrd_khs.v_hrd_khs_tseksi as tseksi
																on 	tseksi.kodesie=trim(presman.kodesie)
											where 		presman.tanggal between '$tanggal_shift_1' and '$tanggal_shift_2'
											order by 	tanggal_shift desc";
			$queryRekapAbsensiManual 	= 	$this->personalia->query($rekapAbsensiManual);
			return $queryRekapAbsensiManual->result_array();
		}
	}
?>