<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 *
 */
class M_monitoringpresensi extends Ci_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia', true);
	}

	public function getAksesAtasanProduksi($noinduk)
	{
		$sql = "
			SELECT 
				a.noind,
				a.nama,
				a.kodesie,
				a.kd_jabatan,
				b.dept,b.pekerjaan
			FROM
				hrd_khs.tpribadi a 
				inner join hrd_khs.tseksi b on a.kodesie = b.kodesie
			WHERE
				a.keluar = false 
				and left(a.kodesie,1) = '3' 
				and a.kd_jabatan != '-' 
				and (a.kd_jabatan <= 13::varchar or a.kd_jabatan = '19')
		";
		$query = $this->personalia->query($sql)->result_array();
		$arrnoind = array();
		foreach ($query as $key => $value) {
			$arrnoind[] = $value['noind'];
		}
		if (!in_array($noinduk, $arrnoind)) {
			return false;
		}
		return true;
	}

	public function statusKerja()
	{
		$sql = "SELECT * FROM hrd_khs.tnoind ORDER BY fs_noind";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	/**
	 * Digunakan untuk mengatur hak akses
	 * semisal noind tertentu mempunyai hak akses ke berbagai seksi di bidang tertentu
	 * 
	 * @param String $noind
	 * @param String $kodesie
	 * 
	 * @return String Query of kodesie
	 */
	protected function getAccessQueryOfUser($noind, $kodesie)
	{
		if ($noind == 'B0380') {
			$whrKodesie = "(left(a.kodesie, 7) = left('$kodesie',7) or a.noind in ('J1171', 'G1041', 'L8001'))";
		} elseif ($noind == 'B0370') {
			$whrKodesie = "(left(a.kodesie, 7) = left('$kodesie',7) or a.noind in ('D1535', 'P0426'))";
		} elseif ($noind == 'H7726') {
			$whrKodesie = "left(a.kodesie, 5) = left('$kodesie',5)";
		} elseif ($noind == 'B0901') {
			$whrKodesie = "left(a.kodesie, 4) = '3070' ";
		} elseif ($noind == 'J1378') {
			$whrKodesie = "left(a.kodesie, 5) in ('10101','10102')";
		} elseif ($noind == 'J1338') {
			$whrKodesie = "left(a.kodesie, 3) in ('302','324','325')";
		} elseif ($noind == 'B0344') { // Enaryono Order #741867 akses semua seksi di bidang ENGINEERING
			$whrKodesie = "left(a.kodesie, 4) in ('3060')";
		} else {
			if ('306030' == substr($kodesie, 0, 6)) // ada diticket
			{
				$whrKodesie = "left(a.kodesie, 6) = left('$kodesie', 6)";
			} else {
				$whrKodesie = "left(a.kodesie, 7) = left('$kodesie', 7)";
			}
		}

		return $whrKodesie;
	}

	function ambilSeksi($keyKodesie)
	{
		$noind = $this->session->user;
		$kodesie = $this->session->kodesie;

		$whrKodesie = $this->getAccessQueryOfUser($noind, $kodesie);

		$sql = "
			SELECT 
				left(kodesie,7) as kodesie,
				seksi 
			FROM (
				select 
					a.kodesie,
					a.seksi 
				from 
					hrd_khs.tseksi a
				where 
					$whrKodesie 
					and substr(a.kodesie,7,1) != '0' 
					and substr(a.kodesie,1,5) = '$keyKodesie'
			) as tbl
			GROUP BY left(kodesie,7), seksi 
			ORDER BY kodesie";
		return $this->personalia->query($sql)->result_array();
	}

	function ambilUnit()
	{
		$noind = $this->session->user;
		$kodesie = $this->session->kodesie;

		$whrKodesie = $this->getAccessQueryOfUser($noind, $kodesie);

		$sql = "
			SELECT 
				left(kodesie,5) as kodesie, 
				unit 
			FROM (
				select 
					a.kodesie,
					a.unit 
				from 
					hrd_khs.tseksi a
				where 
					$whrKodesie 
					and substr(a.kodesie,5,1) != '0'
			) as tbl
			GROUP BY 
				left(kodesie,5), 
				unit";

		return $this->personalia->query($sql)->result_array();
	}

	function getDetailAbsensiPerhari($periode, $kd, $q_status, $q_unit, $q_seksi)
	{
		$sql = "select d.tanggal,a.noind,a.nama,a.kodesie,c.seksi,d.kd_ket,e.keterangan, CASE WHEN a.keluar = true then 'Sudah Keluar' else 'Aktif' end as status
						FROM hrd_khs.tpribadi a
						INNER JOIN hrd_khs.tseksi c ON a.kodesie = c.kodesie
						INNER JOIN \"Presensi\".tdatapresensi d ON a.noind = d.noind
						LEFT JOIN \"Presensi\".tketerangan e ON d.kd_ket = e.kd_ket
						WHERE (left(d.kodesie,7) = '$kd'
						AND d.tanggal = '$periode' AND d.kd_ket NOT LIKE '%C%'
						AND a.noind = d.noind
						$q_status
						$q_unit
						$q_seksi)

						UNION

						select d.tanggal,a.noind,a.nama,a.kodesie,c.seksi,d.kd_ket,e.keterangan, CASE WHEN a.keluar = true then 'Sudah Keluar' else 'Aktif' end as status
						FROM hrd_khs.tpribadi a
						INNER JOIN hrd_khs.tseksi c ON a.kodesie = c.kodesie
						INNER JOIN \"Presensi\".tdatatim d ON a.noind = d.noind
						LEFT JOIN \"Presensi\".tketerangan e ON d.kd_ket = e.kd_ket
						WHERE (left(d.kodesie,7) = '$kd'
						AND d.tanggal = '$periode' AND d.kd_ket NOT LIKE '%C%'
						AND a.noind = d.noind AND d.point <> '0'
						$q_status
						$q_unit
						$q_seksi)";

		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	function getDataAbsensiPerHari($periode, $kodesie, $q_status, $q_unit, $q_seksi)
	{
		$noind = $this->session->user;

		$whrKodesie = $this->getAccessQueryOfUser($noind, $kodesie);

		$sql2 = "select left(kodesie,7) as kodesie,seksi,sum(jumlah)
			from (
			SELECT a.kodesie,c.seksi,(select count(*) from \"Presensi\".tdatapresensi b WHERE b.tanggal='$periode' AND b.kd_ket='PKJ' AND b.kodesie = a.kodesie) as jumlah
			FROM hrd_khs.tpribadi a
			INNER JOIN hrd_khs.tseksi c ON a.kodesie = c.kodesie
			 WHERE $whrKodesie
			AND a.keluar=false $q_status $q_unit $q_seksi
			GROUP BY a.kodesie ,c.seksi
			) as tbl
			group by left(kodesie,7),seksi order by seksi";

		// $sql2 = "select COUNT(*) as jumlah_kerja_per_periode FROM (
		// 		SELECT a.noind,a.tanggal,a.kd_ket
		// 		FROM \"Presensi\".tdatapresensi a INNER JOIN hrd_khs.tpribadi b ON a.noind = b.noind
		// 		WHERE $whrKodesie AND a.tanggal='$periode' AND a.kd_ket='PKJ' AND b.keluar=false) as data";


		$query = $this->personalia->query($sql2);
		return $query->result_array();
	}

	function getDataAbsensiHarianTotal($periode, $periodeAkhir, $kodesie, $q_status, $q_unit, $q_seksi)
	{
		$noind = $this->session->user;

		$whrKodesie = $this->getAccessQueryOfUser($noind, $kodesie);

		$sql1 = "select left(kodesie,7) as kodesie,seksi,(sum(jumlah) + sum(jumlah2)) as sum
				from (
				SELECT a.kodesie,c.seksi,(select count(*) from \"Presensi\".tdatapresensi b WHERE b.tanggal='$periode' AND b.kd_ket NOT LIKE '%C%' AND b.kodesie = a.kodesie) as jumlah,
				(select count(*) from \"Presensi\".tdatatim b WHERE b.tanggal='$periode' AND (b.kd_ket LIKE '%TIK%' OR b.kd_ket LIKE '%TM%') AND b.point <> '0' AND b.kodesie = a.kodesie) as jumlah2
				FROM hrd_khs.tpribadi a
				INNER JOIN hrd_khs.tseksi c ON a.kodesie = c.kodesie
				 WHERE $whrKodesie $q_status $q_unit $q_seksi
				AND a.keluar=false GROUP BY a.kodesie ,c.seksi
				) as tbl
				group by left(kodesie,7),seksi order by seksi";


		$result = $this->personalia->query($sql1);
		return $result->result_array();
	}

	function getDetailAbsensiPerbulan($periode, $kd)
	{
		$sql = "
		select d.tanggal,b.noind,b.nama,b.kodesie,c.seksi,d.kd_ket,e.keterangan
		FROM hrd_khs.tpribadi b
		INNER JOIN hrd_khs.tseksi c ON b.kodesie = c.kodesie INNER JOIN \"Presensi\".tdatapresensi d ON b.noind = d.noind
		LEFT JOIN \"Presensi\".tketerangan e ON d.kd_ket = e.kd_ket
		 WHERE left(b.kodesie,7) in ('$kd') AND substr(TO_CHAR(d.tanggal,'yyyy-MM'),1,7) ='$periode' AND d.kd_ket NOT LIKE '%C%' AND d.kd_ket != ''
		AND b.keluar=false

		UNION

		select d.tanggal,b.noind,b.nama,b.kodesie,c.seksi,d.kd_ket,e.keterangan
		FROM hrd_khs.tpribadi b
		INNER JOIN hrd_khs.tseksi c ON b.kodesie = c.kodesie INNER JOIN \"Presensi\".tdatatim d ON b.noind = d.noind
		LEFT JOIN \"Presensi\".tketerangan e ON d.kd_ket = e.kd_ket
		 WHERE left(b.kodesie,7) in ('$kd') AND substr(TO_CHAR(d.tanggal,'yyyy-MM'),1,7) ='$periode' AND d.kd_ket NOT LIKE '%C%' AND d.kd_ket != '' AND d.point <> '0'
		AND b.keluar=false
		";

		$result = $this->personalia->query($sql);
		return $result->result_array();
	}


	function getDataAbsensiBulananPerPeriode($periode, $kodesie, $q_status, $q_unit, $q_seksi)
	{
		$noind = $this->session->user;
		$whrKodesie = $this->getAccessQueryOfUser($noind, $kodesie);

		$sql2 = "select left(kodesie,7) as kodesie,seksi,sum(jumlah)
			from (
			SELECT a.kodesie,c.seksi,(select count(*) from \"Presensi\".tdatapresensi b WHERE substr(TO_CHAR(b.tanggal,'yyyy-MM'),1,7) ='$periode' AND b.kd_ket='PKJ' AND b.kodesie = a.kodesie) as jumlah
			FROM hrd_khs.tpribadi a
			INNER JOIN hrd_khs.tseksi c ON a.kodesie = c.kodesie
			 WHERE $whrKodesie $q_status $q_unit $q_seksi
			AND a.keluar=false GROUP BY a.kodesie ,c.seksi
			) as tbl
			group by left(kodesie,7),seksi order by seksi";

		$query = $this->personalia->query($sql2);
		return $query->result_array();
	}

	function getDataAbsensiBulanan($periode, $kodesie, $q_status, $q_unit, $q_seksi)
	{
		$noind = $this->session->user;

		$whrKodesie = $this->getAccessQueryOfUser($noind, $kodesie);

		$sql1 = "select left(kodesie,7) as kodesie,seksi,(sum(jumlah) + sum(jumlah2)) as sum
			from (
			SELECT a.kodesie,c.seksi,(select count(*) from \"Presensi\".tdatapresensi b WHERE substr(TO_CHAR(b.tanggal,'yyyy-MM'),1,7) ='$periode' AND b.kd_ket NOT LIKE '%C%' AND b.kodesie = a.kodesie) as jumlah,
			(select count(*) from \"Presensi\".tdatatim b WHERE substr(TO_CHAR(b.tanggal,'yyyy-MM'),1,7) ='$periode' AND (b.kd_ket LIKE '%TIK%' OR b.kd_ket LIKE '%TM%') AND b.point <> '0' AND b.kd_ket != '' AND b.kodesie = a.kodesie) as jumlah2
			FROM hrd_khs.tpribadi a
			INNER JOIN hrd_khs.tseksi c ON a.kodesie = c.kodesie
			 WHERE $whrKodesie $q_status $q_unit $q_seksi
			AND a.keluar=false GROUP BY a.kodesie ,c.seksi
			) as tbl
			group by left(kodesie,7),seksi order by seksi";

		$result = $this->personalia->query($sql1);
		return $result->result_array();
	}

	function getDataPerTahun($periode, $kodesie, $q_status, $q_unit, $q_seksi)
	{
		$noind = $this->session->user;
		$whrKodesie = $this->getAccessQueryOfUser($noind, $kodesie);

		$sql1 = "select left(kodesie,7) as kodesie,seksi,sum(jumlah_bekerja) as total_bekerja,(sum(jumlah) + sum(jumlah2)) as total_absen
			from (
			SELECT a.kodesie,c.seksi,
			(select count(*) from \"Presensi\".tdatapresensi b WHERE substr(TO_CHAR(b.tanggal,'yyyy-MM'),1,4) ='$periode' AND b.kd_ket='PKJ' AND b.kodesie = a.kodesie) as jumlah_bekerja,
			(select count(*) from \"Presensi\".tdatapresensi b WHERE substr(TO_CHAR(b.tanggal,'yyyy-MM'),1,4) ='$periode' AND b.kd_ket NOT LIKE '%C%' AND b.kodesie = a.kodesie) as jumlah,
			(select count(*) from \"Presensi\".tdatatim b WHERE substr(TO_CHAR(b.tanggal,'yyyy-MM'),1,4) ='$periode' AND (b.kd_ket LIKE '%TIK%' OR b.kd_ket LIKE '%TM%') AND b.point <> '0' AND b.kd_ket != '' AND b.kodesie = a.kodesie) as jumlah2
			FROM hrd_khs.tpribadi a
			INNER JOIN hrd_khs.tseksi c ON a.kodesie = c.kodesie
			 WHERE $whrKodesie $q_status $q_unit $q_seksi
			AND a.keluar=false GROUP BY a.kodesie ,c.seksi
			) as tbl
			group by left(kodesie,7),seksi order by seksi";

		$result = $this->personalia->query($sql1);
		return $result->result_array();
	}

	function getDataPerBulanan($bulanAwal, $bulanAkhir, $kodesie, $q_status, $q_unit, $q_seksi)
	{
		$noind = $this->session->user;
		$whrKodesie = $this->getAccessQueryOfUser($noind, $kodesie);

		$sql1 = "
			SELECT 
				left(kodesie, 7) as kodesie,
				seksi,
				sum(jumlah_bekerja) as total_bekerja,
				(sum(jumlah) + sum(jumlah2)) as total_absen
			FROM (
				select 
					a.kodesie,
					c.seksi,
					(select count(*) from \"Presensi\".tdatapresensi b WHERE b.tanggal >=  date('$bulanAwal') AND b.tanggal <  date('$bulanAkhir') + INTERVAL '1 MONTH' AND b.kd_ket='PKJ' AND b.kodesie = a.kodesie) as jumlah_bekerja,
					(select count(*) from \"Presensi\".tdatapresensi b WHERE b.tanggal >=  date('$bulanAwal') AND b.tanggal < date('$bulanAkhir') + INTERVAL '1 MONTH'  AND b.kd_ket NOT LIKE '%C%' AND b.kodesie = a.kodesie) as jumlah,
					(select count(*) from \"Presensi\".tdatatim b WHERE b.tanggal >=  date('$bulanAwal') AND b.tanggal < date('$bulanAkhir') + INTERVAL '1 MONTH'  AND (b.kd_ket LIKE '%TIK%' OR b.kd_ket LIKE '%TM%') AND b.point <> '0' AND b.kd_ket != '' AND b.kodesie = a.kodesie) as jumlah2
				from 
					hrd_khs.tpribadi a
					inner join hrd_khs.tseksi c ON a.kodesie = c.kodesie
				where 
					$whrKodesie 
					$q_status 
					$q_unit 
					$q_seksi
					and a.keluar=false 
				group by 
					a.kodesie, 
					c.seksi
			) as tbl
			GROUP BY 
				left(kodesie,7),seksi 
			ORDER BY 
				seksi";

		$result = $this->personalia->query($sql1)->result_array();
		return $result;
	}

	function getDataPerHarian($periode, $periodeAkhir, $kodesie, $q_status, $q_unit, $q_seksi)
	{
		$noind = $this->session->user;
		$whrKodesie = $this->getAccessQueryOfUser($noind, $kodesie);

		$sql1 = "
			SELECT 
				left(kodesie,7) as kodesie,
				seksi,
				sum(jumlah_bekerja) as total_bekerja,
				(sum(jumlah) + sum(jumlah2)) as total_absen
			FROM (
				select 
					a.kodesie, 
					c.seksi,
					(select count(*) from \"Presensi\".tdatapresensi b WHERE b.tanggal BETWEEN '$periode' AND '$periodeAkhir' AND b.kd_ket='PKJ' AND b.kodesie = a.kodesie) as jumlah_bekerja,
					(select count(*) from \"Presensi\".tdatapresensi b WHERE b.tanggal BETWEEN '$periode' AND '$periodeAkhir' AND b.kd_ket NOT LIKE '%C%' AND b.kodesie = a.kodesie) as jumlah,
					(select count(*) from \"Presensi\".tdatatim b WHERE b.tanggal BETWEEN '$periode' AND '$periodeAkhir' AND (b.kd_ket LIKE '%TIK%' OR b.kd_ket LIKE '%TM%') AND b.point <> '0' AND b.kd_ket != '' AND b.kodesie = a.kodesie) as jumlah2
				from 
					hrd_khs.tpribadi a
					inner join hrd_khs.tseksi c ON a.kodesie = c.kodesie
				where 
					$whrKodesie 
					$q_status 
					$q_unit 
					$q_seksi
					and a.keluar=false 
				group by 
					a.kodesie,
					c.seksi
			) as tbl
			GROUP BY 
				left(kodesie,7), 
				seksi 
			ORDER BY 
				seksi";

		$result = $this->personalia->query($sql1)->result_array();
		return $result;
	}


	function getDataAbsensiTahunanPerPeriode($periode, $kodesie, $q_status, $q_unit, $q_seksi)
	{
		//jumlah semua keterangan absensi (kecuali cuti, ijin, mangkir, sakit, IP)
		$noind = $this->session->user;
		$whrKodesie = $this->getAccessQueryOfUser($noind, $kodesie);

		$sql2 = "
			SELECT 
				left(kodesie,7) as kodesie, 
				seksi, 
				sum(jumlah)
			FROM (
				select 
					a.kodesie,
					c.seksi,
					(select count(*) from \"Presensi\".tdatapresensi b WHERE substr(TO_CHAR(b.tanggal,'yyyy-MM'),1,7) ='$periode' AND b.kd_ket='PKJ' AND b.kodesie = a.kodesie) as jumlah
				from 
					hrd_khs.tpribadi a
					inner join hrd_khs.tseksi c on a.kodesie = c.kodesie
				where 
					$whrKodesie 
					$q_status 
					$q_unit 
					$q_seksi 
					and a.keluar=false 
				group by 
					a.kodesie, 
					c.seksi
			) as tbl
			group by left(kodesie,7),seksi order by seksi";

		$query = $this->personalia->query($sql2);
		return $query->result_array();
	}


	function getDataAbsensiTahunan($periode, $kodesie, $q_status, $q_unit, $q_seksi)
	{
		$noind = $this->session->user;
		$whrKodesie = $this->getAccessQueryOfUser($noind, $kodesie);

		//sq1 = jumlah semua keterangan absensi (kecuali cuti)

		$sql1 = "
			SELECT 
				left(kodesie, 7) as kodesie,
				seksi,
				(sum(jumlah) + sum(jumlah2)) as sum
			FROM (
				select 
					a.kodesie, 
					c.seksi, 
					(select count(*) from \"Presensi\".tdatapresensi b WHERE substr(TO_CHAR(b.tanggal,'yyyy-MM'),1,7) ='$periode' AND b.kd_ket NOT LIKE '%C%' AND b.kodesie = a.kodesie) as jumlah,
					(select count(*) from \"Presensi\".tdatatim b WHERE substr(TO_CHAR(b.tanggal,'yyyy-MM'),1,7) ='$periode' AND (b.kd_ket LIKE '%TIK%' OR b.kd_ket LIKE '%TM%') AND b.point <> '0' AND b.kd_ket != '' AND b.kodesie = a.kodesie) as jumlah2
				from 
					hrd_khs.tpribadi a
					inner join hrd_khs.tseksi c ON a.kodesie = c.kodesie
				where 
					$whrKodesie 
					$q_status 
					$q_unit 
					$q_seksi
					and a.keluar=false 
				group by a.kodesie, c.seksi
			) as tbl
			GROUP BY 
				left(kodesie,7), 
				seksi 
			ORDER BY 
				seksi
			";

		$result = $this->personalia->query($sql1);
		return $result->result_array();
	}


	function rekapPekerja($tanggal1, $tanggal2, $kodesie, $q_status, $q_unit, $q_seksi)
	{
		// ::param kodesie is useless

		$noind = $this->session->user;
		$kodesie = $this->session->kodesie;
		$whrKodesie = $this->getAccessQueryOfUser($noind, $kodesie);

		$sql = "
				SELECT 
					noind,
					nama,
					seksi,
					terlambat,
					izin_pribadi,
					mangkir,
					sakit,
					izin_pamit,
					izin_perusahaan,
					sum(bekerja1+non_mangkir) as bekerja
				FROM ( 
					select 
						a.noind,
						a.nama,
						b.seksi,
						(select count(*) from \"Presensi\".tdatatim c WHERE c.tanggal BETWEEN '$tanggal1' AND '$tanggal2' and c.noind = a.noind and c.kd_ket = 'TT' ) as terlambat,
		     		(select count(*) from \"Presensi\".tdatatim c WHERE c.tanggal BETWEEN '$tanggal1' AND '$tanggal2' and c.noind = a.noind and c.kd_ket = 'TIK' and c.point > 0 ) as izin_pribadi,
		     		(select count(*) from \"Presensi\".tdatatim c WHERE c.tanggal BETWEEN '$tanggal1' AND '$tanggal2' and c.noind = a.noind and c.kd_ket = 'TM' and c.point > 0) as mangkir,
		    		(select count(*) from \"Presensi\".tdatapresensi c WHERE c.tanggal BETWEEN '$tanggal1' AND '$tanggal2' and c.noind = a.noind and c.kd_ket IN ('PSP','PSK') ) as sakit,
		    		(select count(*) from \"Presensi\".tdatapresensi c WHERE c.tanggal BETWEEN '$tanggal1' AND '$tanggal2' and c.noind = a.noind and c.kd_ket IN ('PIP','CT') ) as izin_pamit,
		     		(select count(*) from \"Surat\".taktual_izin c WHERE c.waktu1 BETWEEN '$tanggal1' AND '$tanggal2' and c.noinduk = a.noind and c.status = 1 ) as izin_perusahaan,
						(select count(*) from \"Presensi\".tdatapresensi c WHERE c.tanggal BETWEEN '$tanggal1' AND '$tanggal2' and c.noind = a.noind and c.kd_ket IN ('PKJ','PLB') ) as bekerja1,
						(select count(*) from \"Presensi\".tdatatim c WHERE c.tanggal BETWEEN '$tanggal1' AND '$tanggal2' and c.noind = a.noind and c.kd_ket = 'TM' and c.point = 0) as non_mangkir
					from 
						hrd_khs.tpribadi a 
						inner join hrd_khs.tseksi b ON a.kodesie = b.kodesie
					where $whrKodesie AND a.keluar = false $q_status $q_unit $q_seksi
				) as tbl
				GROUP BY tbl.noind, tbl.nama, tbl.seksi, tbl.terlambat, tbl.izin_pribadi, tbl.mangkir, tbl.sakit, tbl.izin_pamit, tbl.izin_perusahaan order by seksi";

		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	function getGrafikPiePerPekerja($noinduk, $tanggal1, $tanggal2, $kodesie)
	{
		// ::param kodesie is useless

		$noind = $this->session->user;
		$kodesie = $this->session->kodesie;
		$whrKodesie = $this->getAccessQueryOfUser($noind, $kodesie);

		$sql = "
				SELECT 
					noind, 
					rtrim(nama) as nama, 
					masukkerja, 
					seksi, 
					terlambat, 
					izin_pribadi, 
					mangkir, 
					sakit, 
					izin_pamit, 
					izin_perusahaan, 
					bekerja, 
					tgl_bekerja, 
					tgl_terlambat,
					tgl_izin_pribadi,
					tgl_mangkir,
					tgl_sakit,
					tgl_izin_pamit,
					tgl_izin_perusahaan
				FROM 
					( select 
							a.noind,
							a.nama, 
							a.masukkerja, 
							b.seksi,
							(select count(*) from \"Presensi\".tdatatim c WHERE c.tanggal BETWEEN '$tanggal1' AND '$tanggal2' and c.noind = a.noind and c.kd_ket = 'TT' ) as terlambat,
							(select count(*) from \"Presensi\".tdatatim c WHERE c.tanggal BETWEEN '$tanggal1' AND '$tanggal2' and c.noind = a.noind and c.kd_ket = 'TIK' and c.point > 0 ) as izin_pribadi,
							(select count(*) from \"Presensi\".tdatatim c WHERE c.tanggal BETWEEN '$tanggal1' AND '$tanggal2' and c.noind = a.noind and c.kd_ket = 'TM' and c.point > 0 ) as mangkir,
							(select count(*) from \"Presensi\".tdatapresensi c WHERE c.tanggal BETWEEN '$tanggal1' AND '$tanggal2' and c.noind = a.noind and c.kd_ket IN ('PSP','PSK') ) as sakit,
							(select count(*) from \"Presensi\".tdatapresensi c WHERE c.tanggal BETWEEN '$tanggal1' AND '$tanggal2' and c.noind = a.noind and c.kd_ket in ('PIP','CT') ) as izin_pamit,
							(select count(*) from \"Surat\".taktual_izin c WHERE c.waktu1 BETWEEN '$tanggal1' AND '$tanggal2' and c.noinduk = a.noind and c.status = 1 ) as izin_perusahaan,
							(select count(*) from \"Presensi\".tdatapresensi c WHERE c.tanggal BETWEEN '$tanggal1' AND '$tanggal2' and c.noind = a.noind and c.kd_ket IN ('PKJ','PLB') ) as bekerja,
							(select coalesce(string_agg(to_char(c.tanggal,'YYYY-MM-DD'),' , '),'-') from \"Presensi\".tdatapresensi c WHERE c.tanggal BETWEEN '$tanggal1' AND '$tanggal2' and c.noind = a.noind and c.kd_ket IN ('PKJ','PLB') ) as tgl_bekerja,
							(select coalesce(string_agg(to_char(c.tanggal,'YYYY-MM-DD'),' , '),'-') from \"Presensi\".tdatatim c WHERE c.tanggal BETWEEN '$tanggal1' AND '$tanggal2' and c.noind = a.noind and c.kd_ket = 'TT' ) as tgl_terlambat,
							(select coalesce(string_agg(to_char(c.tanggal,'YYYY-MM-DD'),' , '),'-') from \"Presensi\".tdatatim c WHERE c.tanggal BETWEEN '$tanggal1' AND '$tanggal2' and c.noind = a.noind and c.kd_ket = 'TIK' and c.point > 0 ) as tgl_izin_pribadi,
							(select coalesce(string_agg(to_char(c.tanggal,'YYYY-MM-DD'),' , '),'-') from \"Presensi\".tdatatim c WHERE c.tanggal BETWEEN '$tanggal1' AND '$tanggal2' and c.noind = a.noind and c.kd_ket = 'TM' and c.point > 0 ) as tgl_mangkir,
							(select coalesce(string_agg(to_char(c.tanggal,'YYYY-MM-DD'),' , '),'-') from \"Presensi\".tdatapresensi c WHERE c.tanggal BETWEEN '$tanggal1' AND '$tanggal2' and c.noind = a.noind and c.kd_ket IN ('PSP','PSK') ) as tgl_sakit,
							(select coalesce(string_agg(to_char(c.tanggal,'YYYY-MM-DD'),' , '),'-') from \"Presensi\".tdatapresensi c WHERE c.tanggal BETWEEN '$tanggal1' AND '$tanggal2' and c.noind = a.noind and c.kd_ket in ('PIP','CT') ) as tgl_izin_pamit,
							(select coalesce(string_agg(to_char(c.waktu1,'YYYY-MM-DD'),' , '),'-') from \"Surat\".taktual_izin c WHERE c.waktu1 BETWEEN '$tanggal1' AND '$tanggal2' and c.noinduk = a.noind and c.status = 1 ) as tgl_izin_perusahaan
						from 
							hrd_khs.tpribadi a 
							inner join hrd_khs.tseksi b ON a.kodesie = b.kodesie
		    			-- where $whrKodesie AND a.keluar = false AND a.noind='$noinduk') as tbl order by seksi
						where 
							a.noind='$noinduk'
					) as tbl order by seksi
		";

		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function getLiburPerusahaan($tahun)
	{
		$sql = "SELECT tanggal::date from \"Dinas_Luar\".tlibur where tanggal::text like '$tahun%'";
		return $this->personalia->query($sql)->result_array();
	}
}
