<?php
clASs M_rekapmssql extends CI_Model {

	var $mssql;
    public function __construct()
    {
        parent::__construct();
		$this->mssql = $this->load->database ( 'mssql', TRUE );
    }
	
	public function dataRekap($periode1,$periode2,$status,$departemen,$bidang,$unit,$section)
	{
		$sql="
			SELECT a.noind,a.nama,a.tgllahir,a.nik,a.kd_jabatan,c.nama_jabatan,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,
				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekT,

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TT' AND point<>'0') AS FrekTs,

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekI,

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TIK' AND point<>'0') AS FrekIs,

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind = a.noind AND kd_ket = 'TM' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekM,

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TM' AND point<>'0') AS FrekMs,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSK,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PSK') AS FrekSKs,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekIP,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PIP') AS FrekIPs,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSP,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PSP') AS FrekSPs

			FROM hrd_khs.dbo.tpribadi a

			inner join hrd_khs.dbo.tseksi b on a.kodesie=b.kodesie
			inner join hrd_khs.dbo.tb_master_jab c on a.kd_jabatan=c.kd_jabatan

			WHERE keluar = '0'
				AND a.kd_jabatan = '$status'
				AND dept = '$departemen'
				AND bidang = '$bidang'
				AND unit = '$unit'
				AND seksi = '$section'

			ORDER BY noind
		";
		$query = $this->mssql->query($sql);
		return $query->result_array();
	}

	public function dataRekapDetail($firstdate,$lastdate,$status,$departemen,$bidang,$unit,$section,$monthName)
	{
			$sql="
				SELECT a.noind,a.nama,a.tgllahir,a.nik,a.kd_jabatan,c.nama_jabatan,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,
					(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekT".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TT' AND point<>'0') AS FrekTs".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekI".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TIK' AND point<>'0') AS FrekIs".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind = a.noind AND kd_ket = 'TM' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekM".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TM' AND point<>'0') AS FrekMs".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekSK".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PSK') AS FrekSKs".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekIP".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PIP') AS FrekIPs".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekSP".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PSP') AS FrekSPs".$monthName."

				FROM hrd_khs.dbo.tpribadi a

				inner join hrd_khs.dbo.tseksi b on a.kodesie=b.kodesie
				inner join hrd_khs.dbo.tb_master_jab c on a.kd_jabatan=c.kd_jabatan

				WHERE keluar = '0'
					AND a.kd_jabatan = '$status'
					AND dept = '$departemen'
					AND bidang = '$bidang'
					AND unit = '$unit'
					AND seksi = '$section'

				ORDER BY noind
			";
			$query = $this->mssql->query($sql);
			return $query->result_array();
	}

	public function ExportRekap($periode1,$periode2,$status,$section)
	{
		$sql="
			SELECT a.noind,a.nama,a.tgllahir,a.nik,a.kd_jabatan,c.nama_jabatan,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,
				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekT,

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TT' AND point<>'0') AS FrekTs,

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekI,

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TIK' AND point<>'0') AS FrekIs,

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind = a.noind AND kd_ket = 'TM' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekM,

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TM' AND point<>'0') AS FrekMs,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSK,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PSK') AS FrekSKs,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekIP,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PIP') AS FrekIPs,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSP,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PSP') AS FrekSPs

			FROM hrd_khs.dbo.tpribadi a

			inner join hrd_khs.dbo.tseksi b on a.kodesie=b.kodesie
			inner join hrd_khs.dbo.tb_master_jab c on a.kd_jabatan=c.kd_jabatan

			WHERE keluar = '0'
				AND a.kd_jabatan = '$status'
				AND seksi = '$section'

			ORDER BY noind
		";
		$query = $this->mssql->query($sql);
		return $query->result_array();
	}

	public function ExportDetail($firstdate,$lastdate,$status,$section,$monthName)
	{
			$sql="
				SELECT a.noind,a.nama,a.tgllahir,a.nik,a.kd_jabatan,c.nama_jabatan,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,
					(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekT".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TT' AND point<>'0') AS FrekTs".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekI".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TIK' AND point<>'0') AS FrekIs".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind = a.noind AND kd_ket = 'TM' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekM".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TM' AND point<>'0') AS FrekMs".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekSK".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PSK') AS FrekSKs".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekIP".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PIP') AS FrekIPs".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekSP".$monthName.",

					(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PSP') AS FrekSPs".$monthName."

				FROM hrd_khs.dbo.tpribadi a

				inner join hrd_khs.dbo.tseksi b on a.kodesie=b.kodesie
				inner join hrd_khs.dbo.tb_master_jab c on a.kd_jabatan=c.kd_jabatan

				WHERE keluar = '0'
					AND a.kd_jabatan = '$status'
					AND seksi = '$section'

				ORDER BY noind
			";
			$query = $this->mssql->query($sql);
			return $query->result_array();
	}

	public function statusKerja()
	{
		$sql = "SELECT distinct(kd_jabatan) kd_jabatan, nama_jabatan FROM hrd_khs.dbo.tb_master_jab ORDER BY kd_jabatan";
		$query = $this->mssql->query($sql);
		return $query->result_array();
	}

	public function dept()
	{
		$sql = "SELECT distinct(Dept) Dept FROM hrd_khs.dbo.TSeksi WHERE Dept NOT LIKE '-'";
		$query = $this->mssql->query($sql);
		return $query->result_array();
	}

	public function bidang($value)
	{
		$sql = "SELECT distinct(Bidang) Bidang FROM hrd_khs.dbo.TSeksi WHERE Bidang NOT LIKE '-' AND Dept = '$value'";
		$query = $this->mssql->query($sql);
		return $query->result_array();
	}
	
	public function unit($value)
	{
		$sql = "SELECT distinct(Unit) Unit FROM hrd_khs.dbo.TSeksi WHERE Unit NOT LIKE '-' AND Bidang = '$value'";
		$query = $this->mssql->query($sql);
		return $query->result_array();
	}
	
	public function seksi($value)
	{
		$sql = "SELECT distinct(Seksi) Seksi FROM hrd_khs.dbo.TSeksi WHERE Seksi NOT LIKE '-' AND Unit = '$value'";
		$query = $this->mssql->query($sql);
		return $query->result_array();
	}

	//--------------------QUERY REKAP DATA TIMS TIAP PEKERJA--------------------
	public function rekapPersonInfo($nik)
	{
		$sql = "
			SELECT a.nik,a.nama,b.seksi,b.unit,b.bidang,b.dept,a.kode_status_kerja
			FROM hrd_khs.dbo.tpribadi a
			INNER join hrd_khs.dbo.tseksi b on a.kodesie=b.kodesie
			WHERE a.keluar='0'
				AND a.nik = '$nik'
			ORDER BY a.noind
		";
		$query = $this->mssql->query($sql);
		return $query->result_array();
	}

	public function rekapPersonTIM($nik,$keterangan)
	{
		$sql = "
			SELECT a.nama, b.tanggal, b.masuk, b.keluar, b.kd_ket
				FROM presensi.dbo.TDataTIM b
				LEFT JOIN hrd_khs.dbo.TPribadi a on b.noind = a.noind
				WHERE a.nik = '$nik'
					AND b.kd_ket = '$keterangan'
					AND b.point <> '0'
				ORDER BY b.tanggal ASC
		";
		$query = $this->mssql->query($sql);
		return $query->result_array();
	}

	public function rekapPersonSIPSP($nik,$keterangan)
	{
		$sql = "
			SELECT a.nama, b.tanggal, b.masuk, b.keluar, b.kd_ket
				FROM presensi.dbo.TDataPresensi b
				LEFT JOIN hrd_khs.dbo.TPribadi a on b.noind = a.noind
				WHERE a.nik = '$nik'
					AND b.kd_ket = '$keterangan'
				ORDER BY b.tanggal ASC
		";
		$query = $this->mssql->query($sql);
		return $query->result_array();
	}

	public function dataRekapMonth($periode1,$periode2,$status,$seksi)
	{
		$sql="
			SELECT a.noind,a.nama,a.tgllahir,a.nik,a.kd_jabatan,c.nama_jabatan,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,
				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekT,

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TT' AND point<>'0') AS FrekTs,

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekI,

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TIK' AND point<>'0') AS FrekIs,

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind = a.noind AND kd_ket = 'TM' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekM,

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TM' AND point<>'0') AS FrekMs,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSK,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PSK') AS FrekSKs,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekIP,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PIP') AS FrekIPs,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSP,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PSP') AS FrekSPs

			FROM hrd_khs.dbo.tpribadi a

			inner join hrd_khs.dbo.tseksi b on a.kodesie=b.kodesie
			inner join hrd_khs.dbo.tb_master_jab c on a.kd_jabatan=c.kd_jabatan

			WHERE keluar = '0'
				AND a.kd_jabatan = '$status'
				AND seksi = '$seksi'

			ORDER BY noind
		";
		$query = $this->mssql->query($sql);
		return $query->result_array();
	}

	public function dataRekapMonthDetail($periode1,$periode2,$status,$seksi,$date)
	{
		$sql="
			SELECT a.noind,a.nama,a.tgllahir,a.nik,a.kd_jabatan,c.nama_jabatan,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,
				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekT".$date.",

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TT' AND point<>'0') AS FrekTs".$date.",

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekI".$date.",

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TIK' AND point<>'0') AS FrekIs".$date.",

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind = a.noind AND kd_ket = 'TM' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekM".$date.",

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TM' AND point<>'0') AS FrekMs".$date.",

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSK".$date.",

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PSK') AS FrekSKs".$date.",

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekIP".$date.",

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PIP') AS FrekIPs".$date.",

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSP".$date.",

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.dbo.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PSP') AS FrekSPs".$date."

			FROM hrd_khs.dbo.tpribadi a

			inner join hrd_khs.dbo.tseksi b on a.kodesie=b.kodesie
			inner join hrd_khs.dbo.tb_master_jab c on a.kd_jabatan=c.kd_jabatan

			WHERE keluar = '0'
				AND a.kd_jabatan = '$status'
				AND seksi = '$seksi'

			ORDER BY noind
		";
		$query = $this->mssql->query($sql);
		return $query->result_array();
	}
}
?>