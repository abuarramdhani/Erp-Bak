<?php
	class M_rekapdatapresensitim extends CI_Model
	{
		
		public function __construct()
	    {
	        parent::__construct();
			$this->personalia = $this->load->database('personalia', TRUE );
	    }

		public function rekap_data_presensi_tim($tanggal_awal, $tanggal_akhir, $keterangan_presensi = FALSE, $noind = FALSE, $susulan = FALSE)
		{

			if (!empty($susulan)) {
				$join_susulan = 'inner join "Presensi".tsusulan sus on pres.noind = sus.noind and pres.tanggal = sus.tanggal';
				$select_susulan = ",'Susulan' susulan";
			}else{
				$join_susulan = '';
				$select_susulan = ",'-' susulan";
			}
			$rekap_data_presensi_tim 		= "		select 		pres.* $select_susulan
													from 		\"Presensi\".v_presensi_pekerja as pres ".$join_susulan." 
													where 		pres.tanggal between '$tanggal_awal' and '$tanggal_akhir'";
			if ( !(empty($keterangan_presensi)) )
			{
				$rekap_data_presensi_tim 	.= "	and 	pres.kode_keterangan in (".$keterangan_presensi.")";
			}

			if ( !(empty($noind)) )
			{
				$rekap_data_presensi_tim 	.= "	and 	pres.noind 
															in
															(
																select 		pri.noind
																from 		hrd_khs.v_hrd_khs_tpribadi as pri
																			join 	(
																						select 		pri.noind,
																									pri.tgllahir,
																									pri.nik,
																									pri.nama
																						from 		hrd_khs.v_hrd_khs_tpribadi as pri
																						where 		pri.noind in (".$noind.")
																					) as pri2
																					on 	pri2.tgllahir=pri.tgllahir
																						and 	pri2.nik=pri.nik
															)";
			}
			
			$query_rekap_data_presensi_tim 	=	$this->personalia->query($rekap_data_presensi_tim);
			return $query_rekap_data_presensi_tim->result_array();
		}

		public function daftar_keterangan_presensi($keyword)
		{
			$this->personalia->select('*');
			$this->personalia->from('"Presensi".tketerangan');
			$this->personalia->like('kd_ket', $keyword);
			$this->personalia->or_like('upper(keterangan)', $keyword);

			return $this->personalia->get()->result_array();
		}

		public function pekerja($keyword)
		{
			$this->personalia->select('*');
			$this->personalia->from('hrd_khs.v_hrd_khs_tpribadi');
			$this->personalia->where('keluar = ', FALSE);
			$this->personalia->group_start();
				$this->personalia->like('noind', $keyword);
				$this->personalia->or_like('nama', $keyword);
			$this->personalia->group_end();

			return $this->personalia->get()->result_array();
		}
	}
?>