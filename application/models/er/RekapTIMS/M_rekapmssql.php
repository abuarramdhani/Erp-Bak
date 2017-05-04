<?php
clASs M_rekapmssql extends CI_Model {

	var $personalia;
    public function __construct()
    {
        parent::__construct();
		$this->personalia = $this->load->database('personalia', TRUE );
    }
	
	public function dataRekap($periode1,$periode2,$status,$departemen,$bidang,$unit,$seksi)
	{
		if ($status == 'All') {
			$status = "a.kode_status_kerja";
		}
		else{
			$status = "'$status'";
		}
		if ($departemen == 'All') {
			$departemen = "rtrim(dept)";
		}
		else{
			$departemen = "rtrim('$departemen')";
		}
		if ($bidang == 'All') {
			$bidang = "rtrim(bidang)";
		}
		else{
			$bidang = "rtrim('$bidang')";
		}
		if ($unit == 'All') {
			$unit = "rtrim(unit)";
		}
		else{
			$unit = "rtrim('$unit')";
		}
		if ($seksi == 'All') {
			$section = "rtrim(seksi)";
		}
		else{
			$section = "rtrim('$seksi')";
		}
		$sql="
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
					(SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SP
					WHERE noind = a.noind AND (tgl_cetak <= '$periode1' OR tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR (tgl_cetak + interval '5 month') >= '$periode2')
				) AS FrekSP,

				(SELECT count(*) FROM
					(SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SP
				WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND (tgl_cetak <= '$periode1' OR tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR (tgl_cetak + interval '5 month') >= '$periode2'))
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				) AS FrekSPs,

				(SELECT count(*) FROM \"Presensi\".tshiftpekerja WHERE noind = a.noind AND tanggal BETWEEN '$periode1' AND '$periode2') AS TotalHK,

				(SELECT count(*) FROM \"Presensi\".tshiftpekerja WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				) AS TotalHKs

			FROM hrd_khs.tpribadi a

			inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
			inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

			WHERE keluar = '0'
				AND a.kode_status_kerja = $status
				AND rtrim(dept) = $departemen
				AND rtrim(bidang) = $bidang
				AND rtrim(unit) = $unit
				AND rtrim(seksi) = $section

			ORDER BY noind
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function dataRekapDetail($firstdate,$lastdate,$status,$departemen,$bidang,$unit,$seksi,$monthName)
	{
		if ($status == 'All') {
			$status = "a.kode_status_kerja";
		}
		else{
			$status = "'$status'";
		}
		if ($departemen == 'All') {
			$departemen = "rtrim(dept)";
		}
		else{
			$departemen = "rtrim('$departemen')";
		}
		if ($bidang == 'All') {
			$bidang = "rtrim(bidang)";
		}
		else{
			$bidang = "rtrim('$bidang')";
		}
		if ($unit == 'All') {
			$unit = "rtrim(unit)";
		}
		else{
			$unit = "rtrim('$unit')";
		}
		if ($seksi == 'All') {
			$section = "rtrim(seksi)";
		}
		else{
			$section = "rtrim('$seksi')";
		}
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
					(SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SP
					WHERE noind = a.noind AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak + interval '5 month') >= '$firstdate' OR (tgl_cetak + interval '5 month') >= '$lastdate')
				) AS FrekSP".$monthName.",

				(SELECT count(*) FROM
					(SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SP
				WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak + interval '5 month') >= '$firstdate' OR (tgl_cetak + interval '5 month') >= '$lastdate'))
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				) AS FrekSPs".$monthName."

				FROM hrd_khs.tpribadi a

				inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
				inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

				WHERE keluar = '0'
					AND a.kode_status_kerja = $status
					AND rtrim(dept) = $departemen
					AND rtrim(bidang) = $bidang
					AND rtrim(unit) = $unit
					AND rtrim(seksi) = $section

				ORDER BY noind
			";
			$query = $this->personalia->query($sql);
			return $query->result_array();
	}

	public function ExportRekap($periode1,$periode2,$status,$seksi)
	{
		if ($seksi == 'All') {
			$section = "rtrim(seksi)";
		}
		else{
			$section = "rtrim('$seksi')";
		}
		$sql="
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
					(SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SP
					WHERE noind = a.noind AND (tgl_cetak <= '$periode1' OR tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR (tgl_cetak + interval '5 month') >= '$periode2')
				) AS FrekSP,

				(SELECT count(*) FROM
					(SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SP
				WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND (tgl_cetak <= '$periode1' OR tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR (tgl_cetak + interval '5 month') >= '$periode2'))
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				) AS FrekSPs,

				(SELECT count(*) FROM \"Presensi\".tshiftpekerja WHERE noind = a.noind AND tanggal BETWEEN '$periode1' AND '$periode2') AS TotalHK,

				(SELECT count(*) FROM \"Presensi\".tshiftpekerja WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				) AS TotalHKs

			FROM hrd_khs.tpribadi a

			inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
			inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

			WHERE keluar = '0'
				AND a.kode_status_kerja = '$status'
				AND rtrim(seksi) = $section

			ORDER BY noind
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function ExportDetail($firstdate,$lastdate,$status,$seksi,$monthName)
	{
		if ($seksi == 'All') {
			$section = "rtrim(seksi)";
		}
		else{
			$section = "rtrim('$seksi')";
		}
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
					(SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SP
					WHERE noind = a.noind AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak + interval '5 month') >= '$firstdate' OR (tgl_cetak + interval '5 month') >= '$lastdate')
				) AS FrekSP".$monthName.",

				(SELECT count(*) FROM
					(SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
						) AS SP
				WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak + interval '5 month') >= '$firstdate' OR (tgl_cetak + interval '5 month') >= '$lastdate'))
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				) AS FrekSPs".$monthName."

			FROM hrd_khs.tpribadi a

			inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
			inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

			WHERE keluar = '0'
				AND a.kode_status_kerja = '$status'
				AND rtrim(seksi) = $section

			ORDER BY noind
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function statusKerja()
	{
		$sql = "SELECT * FROM hrd_khs.tnoind ORDER BY fs_noind";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function dept()
	{
		$sql = "SELECT distinct(rtrim(Dept)) Dept FROM hrd_khs.tseksi WHERE Dept!='-' ";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function bidang($value)
	{
		if ($value == 'All') {
			$value = "Dept";
		}
		else{
			$value = "'$value'";
		}
		$this->session->set_userdata('departemen_filter',$value);
		$sql = "SELECT distinct(rtrim(Bidang)) Bidang FROM hrd_khs.tseksi WHERE Bidang!='-' AND Dept = $value";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}
	
	public function unit($value)
	{
		if ($value == 'All') {
			$value = "Bidang";
		}
		else{
			$value = "'$value'";
		}
		$this->session->set_userdata('bidang_filter',$value);
		$dept = $this->session->userdata('departemen_filter');
		$sql = "SELECT distinct(rtrim(Unit)) Unit FROM hrd_khs.tseksi WHERE Unit!='-' AND Bidang = $value AND Dept = $dept ";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}
	
	public function seksi($value)
	{
		if ($value == 'All') {
			$value = "Unit";
		}
		else{
			$value = "'$value'";
		}
		$dept = $this->session->userdata('departemen_filter');
		$bid = $this->session->userdata('bidang_filter');
		$sql = "SELECT distinct(rtrim(Seksi)) Seksi FROM hrd_khs.tseksi WHERE Seksi!='-' AND Unit = $value AND Dept = $dept AND Bidang = $bid";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	//--------------------QUERY REKAP DATA TIMS TIAP PEKERJA--------------------
	public function rekapPersonInfo($nik)
	{
		$sql = "
			SELECT a.nik,a.nama,b.seksi,b.unit,b.bidang,b.dept,a.kode_status_kerja,c.fs_ket
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
			SELECT a.nama, b.tanggal, b.masuk, b.keluar, b.kd_ket
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
			SELECT a.nama, b.tanggal, b.masuk, b.keluar, b.kd_ket
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
			AND (a.tgl_cetak <= '$periode1' OR a.tgl_cetak <= '$periode2') AND (DATEADD(month, 6, a.tgl_cetak) >= '$periode1' OR DATEADD(month, 6, a.tgl_cetak) >= '$periode2')
			union all
			SELECT a.noind, a.no_surat, a.tgl_cetak, a.sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen a
			left join hrd_khs.TPribadi b on a.noind = b.noind
			where b.nik = '$nik'
			AND (a.tgl_cetak <= '$periode1' OR a.tgl_cetak <= '$periode2') AND (DATEADD(month, 6, a.tgl_cetak) >= '$periode1' OR DATEADD(month, 6, a.tgl_cetak) >= '$periode2')
			order by a.tgl_cetak DESC
			
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function dataRekapMonth($periode1,$periode2,$status,$seksi)
	{
		if ($seksi == 'All') {
			$section = "rtrim(seksi)";
		}
		else{
			$section = "rtrim('$seksi')";
		}
		$sql="
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
					(SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SP
					WHERE noind = a.noind AND (tgl_cetak <= '$periode1' OR tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR (tgl_cetak + interval '5 month') >= '$periode2')
				) AS FrekSP,

				(SELECT count(*) FROM
					(SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SP
				WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND (tgl_cetak <= '$periode1' OR tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR (tgl_cetak + interval '5 month') >= '$periode2'))
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				) AS FrekSPs

			FROM hrd_khs.tpribadi a

			inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
			inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

			WHERE keluar = '0'
				AND a.kode_status_kerja = '$status'
				AND rtrim(seksi) = $section

			ORDER BY noind
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function dataRekapMonthDetail($firstdate,$lastdate,$status,$seksi,$date)
	{
		if ($seksi == 'All') {
			$section = "rtrim(seksi)";
		}
		else{
			$section = "rtrim('$seksi')";
		}
		$sql="
			SELECT a.noind,a.nama,a.tgllahir,a.nik,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,c.fs_ket,
				
				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekT".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TT' AND point<>'0') AS FrekTs".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekI".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TIK' AND point<>'0') AS FrekIs".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TM' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekM".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TM' AND point<>'0') AS FrekMs".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekSK".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PSK') AS FrekSKs".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekIP".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PIP') AS FrekIPs".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'CT' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekCT".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'CT') AS FrekCTs".$date.",

				(SELECT count(*) FROM
					(SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SP
					WHERE noind = a.noind AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak + interval '5 month') >= '$firstdate' OR (tgl_cetak + interval '5 month') >= '$lastdate')
				) AS FrekSP".$date.",

				(SELECT count(*) FROM
					(SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak, (tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SPs
				WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak + interval '5 month') >= '$firstdate' OR (tgl_cetak + interval '5 month') >= '$lastdate'))
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				) AS FrekSPs".$date."

			FROM hrd_khs.tpribadi a

			inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
			inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

			WHERE keluar = '0'
				AND a.kode_status_kerja = '$status'
				AND rtrim(seksi) = $section

			ORDER BY noind
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function data_rekap_masakerja($periode2,$status,$departemen,$bidang,$unit,$seksi){
		if ($status == 'All') {
			$status = "a.kode_status_kerja";
		}
		else{
			$status = "'$status'";
		}
		if ($departemen == 'All' || $departemen == NULL) {
			$departemen = "rtrim(dept)";
		}
		else{
			$departemen = "rtrim('$departemen')";
		}
		if ($bidang == 'All' || $bidang == NULL) {
			$bidang = "rtrim(bidang)";
		}
		else{
			$bidang = "rtrim('$bidang')";
		}
		if ($unit == 'All' || $unit == NULL) {
			$unit = "rtrim(unit)";
		}
		else{
			$unit = "rtrim('$unit')";
		}
		if ($seksi == 'All' || $seksi == NULL) {
			$section = "rtrim(seksi)";
		}
		else{
			$section = "rtrim('$seksi')";
		}
		$sql = "
			(
			SELECT a.noind, a.nik, a.nama, a.masukkerja, '$periode2' tglkeluar, a.keluar
				FROM hrd_khs.tpribadi a
				INNER JOIN hrd_khs.tseksi b on a.kodesie=b.kodesie
				WHERE
					a.kode_status_kerja = $status
					AND rtrim(dept) = $departemen
					AND rtrim(bidang) = $bidang
					AND rtrim(unit) = $unit
					AND rtrim(seksi) = $section
					AND a.keluar = '0'
			)

			UNION ALL

			(
			SELECT noind, nik, nama, masukkerja, tglkeluar, keluar
				FROM hrd_khs.tpribadi a
				INNER JOIN hrd_khs.tseksi b on a.kodesie=b.kodesie
				WHERE
					(
						nama IN (
							SELECT nama
								FROM hrd_khs.tpribadi a
								WHERE
									a.kode_status_kerja = $status
									AND rtrim(dept) = $departemen
									AND rtrim(bidang) = $bidang
									AND rtrim(unit) = $unit
									AND rtrim(seksi) = $section
									AND a.keluar = '0'
						)
					AND
						nik IN (
							SELECT nik
								FROM hrd_khs.tpribadi a
								WHERE
									a.kode_status_kerja = $status
									AND rtrim(dept) = $departemen
									AND rtrim(bidang) = $bidang
									AND rtrim(unit) = $unit
									AND rtrim(seksi) = $section
									AND a.keluar = '0'
							)
					)

					AND keluar = '1'
			)
			ORDER BY nik, nama, masukkerja DESC, tglkeluar DESC
			
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

}
?>