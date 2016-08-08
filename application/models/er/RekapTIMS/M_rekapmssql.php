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
			SELECT a.noINd,a.nama,a.tgllahir,b.dept,b.bidang,b.unit,b.seksi,a.mASukkerja,a.NIK,
				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noINd = a.noINd AND kd_ket = 'TT' AND poINt <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekT,			
				
				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noINd IN
					(SELECT noINd FROM hrd_khs.dbo.tpribadi WHERE noINd IN
						(SELECT noINd FROM hrd_khs.dbo.tpribadi WHERE noINd LIKE 'H%' AND keluar = '1' AND tglkeluar BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir)
				AND kd_ket = 'TT' AND poINt<>'0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekTs,

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noINd = a.noINd AND kd_ket = 'TIK' AND poINt <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekI,

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noINd IN
					(SELECT noINd FROM hrd_khs.dbo.tpribadi WHERE noINd IN
						(SELECT noINd FROM hrd_khs.dbo.tpribadi WHERE noINd LIKE 'H%' AND keluar = '1' AND tglkeluar BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir)
				AND kd_ket = 'TIK' AND poINt<>'0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekIs,

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noINd = a.noINd AND kd_ket = 'TM' AND poINt <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekM,

				(SELECT count(*) FROM presensi.dbo.tdatatim WHERE noINd IN
					(SELECT noINd FROM hrd_khs.dbo.tpribadi WHERE noINd IN
						(SELECT noINd FROM hrd_khs.dbo.tpribadi WHERE noINd LIKE 'H%' AND keluar = '1' AND tglkeluar BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir)
				AND kd_ket = 'TM' AND poINt<>'0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekMs,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noINd = a.noINd AND kd_ket = 'PSK' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSK,

				(SELECT count(*) FROM presensi.dbo.tdatapresensi WHERE noINd IN
					(SELECT noINd FROM hrd_khs.dbo.tpribadi WHERE noINd IN
						(SELECT noINd FROM hrd_khs.dbo.tpribadi WHERE noINd LIKE 'H%' AND keluar = '1' AND tglkeluar BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir)
				AND kd_ket = 'PSK' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSKs
			
			FROM hrd_khs.dbo.tpribadi a
			INner joIN hrd_khs.dbo.tseksi b on a.kodesie=b.kodesie
			WHERE left(noINd,1) IN('K','P') AND keluar='0'
				AND nama IN(SELECT nama FROM hrd_khs.dbo.tpribadi WHERE noINd LIKE 'H%' AND keluar='1')
				AND tgllahir IN(SELECT tgllahir FROM hrd_khs.dbo.tpribadi WHERE noINd LIKE 'H%' AND keluar='1')
				AND a.kd_jabatan= '$status'
				AND b.dept 		= '$departemen'
				AND b.bidang 	= '$bidang'
				AND b.unit 		= '$unit'
				AND b.seksi 	= '$section'
			ORDER BY noINd
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
			SELECT a.NIK,a.nama,b.seksi,b.unit,b.bidang
			FROM hrd_khs.dbo.tpribadi a
			INner joIN hrd_khs.dbo.tseksi b on a.kodesie=b.kodesie
			WHERE left(a.noINd,1) IN('K','P') AND a.keluar='0'
				AND nama IN(SELECT nama FROM hrd_khs.dbo.tpribadi WHERE noINd LIKE 'H%' AND keluar='1')
				AND tgllahir IN(SELECT tgllahir FROM hrd_khs.dbo.tpribadi WHERE noINd LIKE 'H%' AND keluar='1')
				AND a.NIK = '$nik'
			ORDER BY a.noINd
		";
		$query = $this->mssql->query($sql);
		return $query->result_array();
	}
	public function rekapPersonTerlambat($nik)
	{
		$sql = "
			SELECT c.tanggal,c.masuk,c.keluar
			FROM Presensi.dbo.TDataTIM c, hrd_khs.dbo.tpribadi a
			INner joIN hrd_khs.dbo.tseksi b on a.kodesie=b.kodesie
			WHERE left(a.noINd,1) IN('K','P') AND a.keluar='0'
				AND nama IN(SELECT nama FROM hrd_khs.dbo.tpribadi WHERE noINd LIKE 'H%' AND keluar='1')
				AND tgllahir IN(SELECT tgllahir FROM hrd_khs.dbo.tpribadi WHERE noINd LIKE 'H%' AND keluar='1')
				AND a.NIK = '$nik'
				AND c.noind=a.noind
				AND c.kd_ket = 'TT'
			ORDER BY a.noINd
		";
		$query = $this->mssql->query($sql);
		return $query->result_array();
	}
	public function rekapPersonIjinPribadi($nik)
	{
		$sql = "
			SELECT c.tanggal,c.masuk,c.keluar
			FROM Presensi.dbo.TDataTIM c, hrd_khs.dbo.tpribadi a
			INner joIN hrd_khs.dbo.tseksi b on a.kodesie=b.kodesie
			WHERE left(a.noINd,1) IN('K','P') AND a.keluar='0'
				AND nama IN(SELECT nama FROM hrd_khs.dbo.tpribadi WHERE noINd LIKE 'H%' AND keluar='1')
				AND tgllahir IN(SELECT tgllahir FROM hrd_khs.dbo.tpribadi WHERE noINd LIKE 'H%' AND keluar='1')
				AND a.NIK = '$nik'
				AND c.noind=a.noind
				AND c.kd_ket = 'TIK'
			ORDER BY a.noINd
		";
		$query = $this->mssql->query($sql);
		return $query->result_array();
	}
	public function rekapPersonMangkir($nik)
	{
		$sql = "
			SELECT c.tanggal,c.masuk,c.keluar
			FROM Presensi.dbo.TDataTIM c, hrd_khs.dbo.tpribadi a
			INner joIN hrd_khs.dbo.tseksi b on a.kodesie=b.kodesie
			WHERE left(a.noINd,1) IN('K','P') AND a.keluar='0'
				AND nama IN(SELECT nama FROM hrd_khs.dbo.tpribadi WHERE noINd LIKE 'H%' AND keluar='1')
				AND tgllahir IN(SELECT tgllahir FROM hrd_khs.dbo.tpribadi WHERE noINd LIKE 'H%' AND keluar='1')
				AND a.NIK = '$nik'
				AND c.noind=a.noind
				AND c.kd_ket = 'TM'
			ORDER BY a.noINd
		";
		$query = $this->mssql->query($sql);
		return $query->result_array();
	}
	public function rekapPersonIjinPerusahaan($nik)
	{
		$sql = "
			SELECT c.tanggal,c.masuk,c.keluar
			FROM Presensi.dbo.TDataTIM c, hrd_khs.dbo.tpribadi a
			INner joIN hrd_khs.dbo.tseksi b on a.kodesie=b.kodesie
			WHERE left(a.noINd,1) IN('K','P') AND a.keluar='0'
				AND nama IN(SELECT nama FROM hrd_khs.dbo.tpribadi WHERE noINd LIKE 'H%' AND keluar='1')
				AND tgllahir IN(SELECT tgllahir FROM hrd_khs.dbo.tpribadi WHERE noINd LIKE 'H%' AND keluar='1')
				AND a.NIK = '$nik'
				AND c.noind=a.noind
				AND c.kd_ket = 'TT'
			ORDER BY a.noINd
		";
		$query = $this->mssql->query($sql);
		return $query->result_array();
	}
	public function rekapPersonSuratPeringatan($nik)
	{
		$sql = "
			SELECT c.tanggal,c.masuk,c.keluar
			FROM Presensi.dbo.TDataTIM c, hrd_khs.dbo.tpribadi a
			INner joIN hrd_khs.dbo.tseksi b on a.kodesie=b.kodesie
			WHERE left(a.noINd,1) IN('K','P') AND a.keluar='0'
				AND nama IN(SELECT nama FROM hrd_khs.dbo.tpribadi WHERE noINd LIKE 'H%' AND keluar='1')
				AND tgllahir IN(SELECT tgllahir FROM hrd_khs.dbo.tpribadi WHERE noINd LIKE 'H%' AND keluar='1')
				AND a.NIK = '$nik'
				AND c.noind=a.noind
				AND c.kd_ket = 'TT'
			ORDER BY a.noINd
		";
		$query = $this->mssql->query($sql);
		return $query->result_array();
	}

}
?>