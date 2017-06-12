<?php

	class M_datamutasipekerja extends CI_Model
	{
		function __construct()
		{
			parent::__construct();			
		}

		function get_data_mutasi($awal, $akhir)
		{
			$sql = "
				SELECT tb_mutasi.tanggal AS tanggal,
					tb_mutasi.noind AS no_induk,
					tb_pekerja.nama AS nama,
					tb_seksi_lama.seksi AS seksi_lama,
					tb_seksi_baru.seksi AS seksi_baru
				FROM pr.pr_mutasi_pekerja AS tb_mutasi
				JOIN pr.pr_master_pekerja AS tb_pekerja
					ON tb_mutasi.noind = tb_pekerja.noind
				JOIN pr.pr_master_seksi AS tb_seksi_lama
					ON tb_mutasi.kodesie_lama = tb_seksi_lama.kodesie
				JOIN pr.pr_master_seksi AS tb_seksi_baru
					ON tb_mutasi.kodesie_baru = tb_seksi_baru.kodesie
				WHERE tb_mutasi.tanggal >= DATE('$awal')
					AND tb_mutasi.tanggal <= DATE('$akhir')
			";

			return $this->db->query($sql)->result_array();
		}
	}

?>