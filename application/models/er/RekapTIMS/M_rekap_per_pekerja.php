<?php
clASs M_rekap_per_pekerja extends CI_Model {

	var $personalia;
    public function __construct()
    {
        parent::__construct();
		$this->personalia = $this->load->database ( 'personalia', TRUE );
    }
	
	public function data_per_pekerja($periode1,$periode2,$noinduk,$status){

		if ($status == '0') {
			$sql = "
				SELECT a.noind,a.nama,a.tgllahir,a.nik,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,c.fs_ket,
					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekT,

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TT' AND point<>'0') AS FrekTs,

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekI,

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TIK' AND point<>'0') AS FrekIs,

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TM' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekM,

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TM' AND point<>'0') AS FrekMs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSK,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PSK') AS FrekSKs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekPSP,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PSP') AS FrekPSPs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekIP,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PIP') AS FrekIPs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'CT' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekCT,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'CT') AS FrekCTs,

					(SELECT count(*) FROM
						(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
						UNION ALL
						SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
						) AS SP
						WHERE noind = a.noind AND (tgl_cetak <= '$periode1' OR tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR(tgl_cetak + interval '5 month') >= '$periode2')
					) AS FrekSP,

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TT' AND point<>'0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekTs,

				FROM hrd_khs.tpribadi a

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TIK' AND point<>'0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekIs,

				WHERE keluar = '0'
					AND a.noind IN
						(
							$noinduk
						)

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TM' AND point<>'0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekMs,

					'0' AS FrekTs,

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PSK' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSKs,

					'0' AS FrekIs,

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PIP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekIPs,

					'0' AS FrekMs,

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'CT' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekCTs,

					'0' AS FrekSKs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekPSP,

					'0' AS FrekPSPs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekIP,

					'0' AS FrekIPs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'CT' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekCT,

					'0' AS FrekCTs,

					(SELECT count(*) FROM
						(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
						UNION ALL
						SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
						) AS SP
						WHERE noind = a.noind AND (tgl_cetak <= '$periode1' OR tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR(tgl_cetak + interval '5 month') >= '$periode2')
					) AS FrekSP,

					'0' AS FrekSPs,

					CASE
						WHEN  ('$periode1' < '2016-01-01 00:00:00' AND a.masukkerja < '2016-01-01 00:00:00')
						THEN
							'0'
						ELSE 
							(SELECT count(*) FROM \"Presensi\".tshiftpekerja WHERE noind = a.noind AND tanggal BETWEEN '$periode1' AND '$periode2')
					END AS TotalHK,

					'0' AS TotalHKs

				FROM hrd_khs.tpribadi a

				inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
				inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

				WHERE keluar = '1'
					AND a.noind IN
						(
							$noinduk
						)

				ORDER BY noind
				";
		}
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function data_per_pekerja_detail($firstdate,$lastdate,$noinduk,$monthName,$status){
		if ($status == '0') {
			$sql="
				SELECT a.noind,a.nama,a.tgllahir,a.nik,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,c.fs_ket,
					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekT".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TT' AND point<>'0') AS FrekTs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekI".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TIK' AND point<>'0') AS FrekIs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TM' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekM".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TM' AND point<>'0') AS FrekMs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekSK".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PSK') AS FrekSKs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekPSP".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PSP') AS FrekPSPs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekIP".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PIP') AS FrekIPs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'CT' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekCT".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'CT') AS FrekCTs".$monthName.",

					(SELECT count(*) FROM
						(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
						UNION ALL
						SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
						) AS SP
						WHERE noind = a.noind AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak + interval '5 month') >= '$firstdate' OR(tgl_cetak + interval '5 month') >= '$lastdate')
					) AS FrekSP".$monthName.",

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TT' AND point<>'0'  AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekTs".$monthName.",

					FROM hrd_khs.tpribadi a

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TIK' AND point<>'0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekIs".$monthName.",

					WHERE keluar = '0'
						AND a.noind IN
						(
							$noinduk
						)

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TM' AND point<>'0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekMs".$monthName.",

					'0' AS FrekTs".$monthName.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PSK' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekSKs".$monthName.",

					'0' AS FrekIs".$monthName.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PIP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekIPs".$monthName.",

					'0' AS FrekMs".$monthName.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'CT'  AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekCTs".$monthName.",

				(SELECT max(sp_ke) FROM
					(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SP
					WHERE noind = a.noind AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak + interval '5 month') >= '$firstdate' OR(tgl_cetak + interval '5 month') >= '$lastdate')
				) AS FrekSP".$monthName.",

				(SELECT max(sp_ke) FROM
					(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SP
				WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak + interval '5 month') >= '$firstdate' OR(tgl_cetak + interval '5 month') >= '$lastdate'))
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				) AS FrekSPs".$monthName."

				FROM hrd_khs.tpribadi a

				inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
				inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

				WHERE keluar = '0'
						AND a.noind IN
						(
							$NoInduk
						)

				ORDER BY noind
			";
		} else {
			$sql="
				SELECT a.noind,a.nama,a.tgllahir,a.nik,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,c.fs_ket,
					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekT,

					'0' AS FrekTs,

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TT' AND point<>'0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekTs,

					'0' AS FrekIs,

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TIK' AND point<>'0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekIs,

					'0' AS FrekMs,

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TM' AND point<>'0'  AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekMs,

					'0' AS FrekSKs,

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PSK' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSKs,

					'0' AS FrekPSPs,

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PIP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekIPs,

					'0' AS FrekIPs,

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'CT' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekCTs,

					'0' AS FrekCTs,

					(SELECT count(*) FROM
						(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
						UNION ALL
						SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
						) AS SP
						WHERE noind = a.noind AND (tgl_cetak <= '$periode1' OR tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR(tgl_cetak + interval '5 month') >= '$periode2')
					) AS FrekSP,

					'0' AS FrekSPs,

					CASE
						WHEN  ('$periode1' < '2016-01-01 00:00:00' AND a.masukkerja < '2016-01-01 00:00:00')
						THEN
							'0'
						ELSE 
							(SELECT count(*) FROM \"Presensi\".tshiftpekerja WHERE noind = a.noind AND tanggal BETWEEN '$periode1' AND '$periode2')
					END AS TotalHK,

					'0' AS TotalHKs

				FROM hrd_khs.tpribadi a

				inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
				inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

				WHERE keluar = '1'
						AND a.noind IN
						(
							$NoInduk
						)

				ORDER BY noind
			";
		}
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function ExportDetail($firstdate,$lastdate,$NoInduk,$monthName, $status)
	{
		if ($status == '0') {
			$sql="
				SELECT a.noind,a.nama,a.tgllahir,a.nik,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,c.fs_ket,
					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekT".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TT' AND point<>'0') AS FrekTs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekI".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TIK' AND point<>'0') AS FrekIs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TM' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekM".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TM' AND point<>'0') AS FrekMs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekSK".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PSK') AS FrekSKs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekPSP".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PSP') AS FrekPSPs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekIP".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PIP') AS FrekIPs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'CT' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekCT".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'CT') AS FrekCTs".$monthName.",

					(SELECT count(*) FROM
						(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
						UNION ALL
						SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
						) AS SP
						WHERE noind = a.noind AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak + interval '5 month') >= '$firstdate' OR(tgl_cetak + interval '5 month') >= '$lastdate')
					) AS FrekSP".$monthName.",

					(SELECT count(*) FROM
						(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
						UNION ALL
						SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
							) AS SP
					WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak + interval '5 month') >= '$firstdate' OR(tgl_cetak + interval '5 month') >= '$lastdate'))
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					) AS FrekSPs".$monthName."

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TT' AND point<>'0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekTs".$monthName.",

				inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
				inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TIK' AND point<>'0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekIs".$monthName.",

				ORDER BY noind
			";
		} else {
			$sql="
				SELECT a.noind,a.nama,a.tgllahir,a.nik,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,c.fs_ket,
					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekT".$monthName.",

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TM' AND point<>'0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekMs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekI".$monthName.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PSK' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekSKs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TM' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekM".$monthName.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PIP'  AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekIPs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekSK".$monthName.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'CT' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekCTs".$monthName.",

				(SELECT max(sp_ke) FROM
					(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SP
					WHERE noind = a.noind AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak + interval '5 month') >= '$firstdate' OR(tgl_cetak + interval '5 month') >= '$lastdate')
				) AS FrekSP".$monthName.",

				(SELECT max(sp_ke) FROM
					(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
						) AS SP
						WHERE noind = a.noind AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak + interval '5 month') >= '$firstdate' OR(tgl_cetak + interval '5 month') >= '$lastdate')
					) AS FrekSP".$monthName.",

					'0' AS FrekSPs".$monthName."

				FROM hrd_khs.tpribadi a

				inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
				inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

				WHERE keluar = '1'
						AND a.noind IN
						(
							$NoInduk
						)

				ORDER BY noind
			";
		}
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function dataRekapMonth($periode1,$periode2,$NoInduk)
	{
		$sql="
			SELECT a.noind,a.nama,a.tgllahir,a.nik,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,c.fs_ket,
				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekT,

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TT' AND point<>'0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekTs,

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekI,

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TIK' AND point<>'0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekIs,

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TM' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekM,

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TM' AND point<>'0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekMs,

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSK,

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PSK' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSKs,

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekIP,

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PIP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekIPs,

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'CT' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekCT,

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'CT' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekCTs,

				(SELECT count(*) FROM
					(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SP
					WHERE noind = a.noind AND (tgl_cetak <= '$periode1' OR tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR(tgl_cetak + interval '5 month') >= '$periode2')
				) AS FrekSP,

				(SELECT count(*) FROM
					(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SP
				WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND (tgl_cetak <= '$periode1' OR tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR(tgl_cetak + interval '5 month') >= '$periode2'))
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				) AS FrekSPs

			FROM hrd_khs.tpribadi a

			inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
			inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

			WHERE keluar = '0'
					AND a.noind IN
					(
						$NoInduk
					)

			ORDER BY noind
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function dataRekapMonthDetail($firstdate,$lastdate,$NoInduk,$date)
	{
		$sql="
			SELECT a.noind,a.nama,a.tgllahir,a.nik,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,c.fs_ket,
				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekT".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TT' AND point<>'0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekTs".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekI".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TIK' AND point<>'0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekIs".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TM' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekM".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TM' AND point<>'0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekMs".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekSK".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PSK' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekSKs".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekIP".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PIP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekIPs".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'CT' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekCT".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' )
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'CT' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekCTs".$date.",

				(SELECT count(*) FROM
					(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SP
					WHERE noind = a.noind AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak + interval '5 month') >= '$firstdate' OR(tgl_cetak + interval '5 month') >= '$lastdate')
				) AS FrekSP".$date.",

				(SELECT count(*) FROM
					(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SPs
				WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak + interval '5 month') >= '$firstdate' OR(tgl_cetak + interval '5 month') >= '$lastdate'))
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				) AS FrekSPs".$date."

			FROM hrd_khs.tpribadi a

			inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
			inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

			WHERE keluar = '0'
					AND a.noind IN
					(
						$NoInduk
					)

			ORDER BY noind
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function GetNoInduk($term, $status){
		if ($status == '0'){			
			if ($term === FALSE) {
				$sql = "
					SELECT * FROM hrd_khs.tpribadi WHERE keluar = '0' ORDER BY noind ASC
				";
			}
			else{
				$sql = "
					SELECT * FROM hrd_khs.tpribadi WHERE keluar = '0' AND (noind ILIKE '%$term%' OR nama ILIKE '%$term%') ORDER BY noind ASC
				";
			}
		} else {
			if ($term === FALSE) {
				$sql = "
					SELECT *
					FROM hrd_khs.tpribadi 
					WHERE keluar = '1'
					AND nik NOT IN 
						(
							SELECT nik
							FROM hrd_khs.tpribadi
							WHERE keluar = '0'
							and nik not in ('', '-')
						)
					ORDER BY noind ASC
				";
			}
			else{
				$sql = "
					SELECT *
					FROM hrd_khs.tpribadi 
					WHERE keluar = '1'
					AND (noind ILIKE '%$term%' OR nama ILIKE '%$term%' )
					AND nik NOT IN 
						(
							SELECT nik
							FROM hrd_khs.tpribadi
							WHERE keluar = '0'
							and nik not in ('', '-')
						)
					ORDER BY noind ASC
				";
			}
		}
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

		public function rekapPersonInfo($nik)
	{
		$sql = "
			SELECT a.noind,a.nik,a.nama,b.seksi,b.unit,b.bidang,b.dept,a.kode_status_kerja,c.fs_ket
			FROM hrd_khs.tpribadi a
			INNER join hrd_khs.tseksi b on a.kodesie=b.kodesie
			inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind
			WHERE a.keluar='0'
				AND a.nik = '$nik'
			ORDER BY a.noind
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function rekapPersonTIM($periode1,$periode2,$nik,$keterangan)
	{
		$sql = "
			SELECT a.noind,a.nama, b.tanggal, b.masuk, b.keluar, b.kd_ket
				FROM \"Presensi\".TDataTIM b
				LEFT JOIN hrd_khs.TPribadi a on b.noind = a.noind
				WHERE a.nik = '$nik'
					AND b.tanggal BETWEEN '$periode1 00:00:00' AND '$periode2 23:59:59'
					AND b.kd_ket = '$keterangan'
					AND b.point <> '0'
				ORDER BY b.tanggal DESC
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function rekapPersonSIP($periode1,$periode2,$nik,$keterangan)
	{
		$sql = "
			SELECT a.noind,a.nama, b.tanggal, b.masuk, b.keluar, b.kd_ket
				FROM \"Presensi\".TDataPresensi b
				LEFT JOIN hrd_khs.TPribadi a on b.noind = a.noind
				WHERE a.nik = '$nik'
					AND b.tanggal BETWEEN '$periode1 00:00:00' AND '$periode2 00:00:00'
					AND b.kd_ket = '$keterangan'
				ORDER BY b.tanggal DESC
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function rekapPersonSP($periode1,$periode2,$nik)
	{
		$sql = "
			SELECT a.noind, a.no_surat, a.tgl_cetak, a.sp_ke, a.nT, a.nIK, a.nM, a.bobot, 'Absensi' as Status FROM \"Surat\".tsp a
			left join hrd_khs.TPribadi b on a.noind = b.noind
			where b.nik = '$nik'
			AND (a.tgl_cetak <= '$periode1' OR a.tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR (tgl_cetak + interval '5 month') >= '$periode2')
			union all
			SELECT a.noind, a.no_surat, a.tgl_cetak, a.sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen a
			left join hrd_khs.TPribadi b on a.noind = b.noind
			where b.nik = '$nik'
			AND (a.tgl_cetak <= '$periode1' OR a.tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR (tgl_cetak + interval '5 month') >= '$periode2')
			order by tgl_cetak DESC
			
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function data_rekap_masakerja($periode2, $noinduk, $status){
		if ($status == '0') {
			$sql = "
				(
				SELECT noind, nik, nama, masukkerja, '$periode2' tglkeluar, keluar
					FROM hrd_khs.tpribadi a
					WHERE
						noind IN ($noinduk)
						AND keluar = '0'
				)

				UNION ALL

				(
				SELECT noind, nik, nama, masukkerja, tglkeluar, keluar
					FROM hrd_khs.tpribadi a
					WHERE
						(
							nama IN (
								SELECT nama
									FROM hrd_khs.tpribadi a
									WHERE
										noind IN ($noinduk)
										AND keluar = '0'
							)
						AND
							nik IN (
								SELECT nik
									FROM hrd_khs.tpribadi a
									WHERE
										noind IN ($noinduk)
										AND keluar = '0'
								)
						)

					AND keluar = '1'
			)
			ORDER BY nik,nama,masukkerja, keluar desc
			
			
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}
}
}

?>