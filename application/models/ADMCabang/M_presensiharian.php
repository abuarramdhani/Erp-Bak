<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 *
 */
class M_presensiharian extends Ci_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia', true);
	}

	public function ambilNamaPekerjaByNoind($noind)
	{
		$sql = "select nama from hrd_khs.tpribadi where noind = '$noind'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getSeksiByKodesie($kd)
	{
		$sql = "select kodesie,seksi from hrd_khs.tseksi where kodesie = '$kd'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	/**
	 * 
	 */
	public function getAksesByUser($user)
	{
		$sql = "select left(h.kodesie,7) as kodesie from \"Presensi\".t_hak_akses_presensi h where h.noind = '$user'";
		$result = $this->personalia->query($sql)->result_array();

		$akses = [];

		foreach ($result as $key) {
			array_push($akses, $key['kodesie']);
		}
		$akses = implode("','", $akses);

		$ak = "'" . "$akses" . "'";

		return $ak;
	}

	public function getNoindAkses()
	{

		$sql = "select distinct h.noind from \"Presensi\".t_hak_akses_presensi h";
		$result = $this->personalia->query($sql)->result_array();

		$noind = [];

		foreach ($result as $key) {
			array_push($noind, $key['noind']);
		}
		return $noind;
	}

	public function getPekerjaByKodesie($kd, $noind, $akses, $noind_akses)
	{
		if (in_array($noind, $noind_akses)) {
			$sql = "select a.noind,a.nama, b.seksi,left(b.kodesie,7) as kodesie
			from hrd_khs.tpribadi a
			left join hrd_khs.tseksi b on a.kodesie=b.kodesie
				where left(a.kodesie,7) in (left('$kd', 7), $akses)
				and a.keluar = false
			order by a.kodesie,a.noind;";
		} elseif ($noind == 'B0380') { // ada di ticket
			$sql = "select a.noind,a.nama, b.seksi,left(b.kodesie,7) as kodesie
				from hrd_khs.tpribadi a
				left join hrd_khs.tseksi b on a.kodesie=b.kodesie
				where (left(a.kodesie,7) = left('$kd',7) or a.noind in ('J1171','G1041','L8001'))
				and a.keluar = false
				order by a.kodesie,a.noind;";
		} elseif ($noind == 'B0370') { //ada di ticket
			$sql = "select a.noind,a.nama, b.seksi,left(b.kodesie,7) as kodesie
				from hrd_khs.tpribadi a
				left join hrd_khs.tseksi b on a.kodesie=b.kodesie
				where (left(a.kodesie,7) = left('$kd',7) or a.noind in ('D1535','P0426'))
				and a.keluar = false
				order by a.kodesie,a.noind;";
		} elseif ($noind == 'H7726') { //Order #972784 (PENAMBAHAN AKSES BUKA PRESENSI DI PROGRAM ERP)
			$sql = "select a.noind,a.nama, b.seksi,left(b.kodesie,7) as kodesie
				from hrd_khs.tpribadi a
				left join hrd_khs.tseksi b on a.kodesie=b.kodesie
		  		where left(a.kodesie,5) = left('$kd',5)
		  		and a.keluar = false
				order by a.kodesie,a.noind;";
		} elseif ($noind == 'J1378') { // Order #112817 (Pembuatan Login ERP)
			$sql = "select a.noind,a.nama, b.seksi,left(b.kodesie,7) as kodesie
				from hrd_khs.tpribadi a
				left join hrd_khs.tseksi b on a.kodesie=b.kodesie
		  		where left(a.kodesie,5) in ('10101','10102')
		  		and a.keluar = false
				order by a.kodesie,a.noind;";
		} elseif ($noind == 'J1338') { // Order #456799 (Pembuatan Login ERP)
			$sql = "select a.noind,a.nama, b.seksi,left(b.kodesie,7) as kodesie
				from hrd_khs.tpribadi a
				left join hrd_khs.tseksi b on a.kodesie=b.kodesie
		  		where left(a.kodesie,3) in ('302','324','325')
		  		and a.keluar = false
				order by a.kodesie,a.noind;";
		} elseif ($noind == 'B0901') { // Order #524240 (Pembukaan hak akses)
			$sql = "select a.noind,a.nama, b.seksi,left(b.kodesie,7) as kodesie
				from hrd_khs.tpribadi a
				left join hrd_khs.tseksi b on a.kodesie=b.kodesie
		  		where left(a.kodesie,4) = '3070'
		  		and a.keluar = false
				order by a.kodesie,a.noind;";
		} elseif ($noind == 'B0267') { // Nugroho Budi Utomo | #854719 akses seksi toolware house-tks(3240101) dan seksi assembling gear transmission-tks(3250201)
			$sql = "select a.noind,a.nama, b.seksi,left(b.kodesie,7) as kodesie
			 from hrd_khs.tpribadi a
			 left join hrd_khs.tseksi b on a.kodesie=b.kodesie
				 where left(a.kodesie, 7) in (left('$kd', 7), '3240101', '3250201')
				 or a.kodesie like trim(TRAILING '0' FROM '$kd') || '%'
				 and a.keluar = false
			 order by a.kodesie,a.noind;";
		} elseif ($noind == 'B0344') { // Enaryono Order #741867 akses semua seksi di bidang ENGINEERING
			$sql = "select a.noind,a.nama, b.seksi,left(b.kodesie,7) as kodesie
					from hrd_khs.tpribadi a
					left join hrd_khs.tseksi b on a.kodesie=b.kodesie
						where left(a.kodesie, 4) in ('3060')
						and a.keluar = false
					order by a.kodesie,a.noind;";
		} elseif ('306030' == substr($kd, 0, 6)) { // ada diticket
			$sql = "select a.noind,a.nama, b.seksi,left(b.kodesie,7) as kodesie
				from hrd_khs.tpribadi a
				left join hrd_khs.tseksi b on a.kodesie=b.kodesie
						where left(a.kodesie,6) = left('$kd',6)
						and a.keluar = false
						order by a.kodesie,a.noind;";
		} else {
			$sql = "select a.noind,a.nama, b.seksi,left(b.kodesie,7) as kodesie
			from hrd_khs.tpribadi a
			left join hrd_khs.tseksi b on a.kodesie=b.kodesie
					where left(a.kodesie,7) = left('$kd',7)
					and a.keluar = false
					order by a.kodesie,a.noind;";
		}

		$result = $this->personalia->query($sql);
		return $result->result_array();
	}
	public function getPresensiByNoind($noind, $tgl)
	{
		// RIA CAHYANI HARTONO
		if ($noind == 'L8001') {
			$sql = "select waktu
					from \"Presensi\".tprs_shift2 tp
					where tp.noind = '$noind'
					and tp.tanggal = '$tgl'
					order by tp.waktu";
		} else {
			$sql = "SELECT DISTINCT tp.waktu
					FROM \"Presensi\".tprs_shift tp
					WHERE tp.noind = '$noind' AND tp.tanggal = '$tgl' AND tp.waktu NOT IN ('0')
					UNION
					SELECT DISTINCT ftp.waktu
					FROM \"FrontPresensi\".tpresensi ftp
					WHERE ftp.noind = '$noind' AND ftp.tanggal = '$tgl'
					ORDER BY waktu";
		}
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getPresensiArrayNoind($noind, $tgl)
	{
		$tanggal = explode(" - ", $tgl);
		$tgl1 = $tanggal[0];
		$tgl2 = $tanggal[1];
		$sql = "select tp.noind,tp.tanggal,tp.waktu
				from \"Presensi\".tprs_shift tp
				where tp.noind in ($noind)
				and tp.tanggal between '$tgl1' and '$tgl2' and tp.waktu not in ('0')
				order by tp.noind,tp.tanggal,tp.waktu";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getTIMByNoind($noind, $tgl)
	{
		$sql = "select sum(point) point
				from \"Presensi\".tdatatim
				where noind = '$noind'
				and tanggal = '$tgl' and point != '0'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getTIMArrayNoind($noind, $tgl)
	{
		$tanggal = explode(" - ", $tgl);
		$tgl1 = $tanggal[0];
		$tgl2 = $tanggal[1];
		$sql = "select noind,tanggal,point
				from \"Presensi\".tdatatim
				where noind in ($noind)
				and tanggal between '$tgl1' and '$tgl2'
				order by noind,tanggal";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getKeteranganByNoind($noind, $tgl)
	{
		$sql = "select
					case when (
						select sum(point)
						from \"Presensi\".tdatatim
						where noind = '$noind'
						and tanggal = '$tgl'
						and kd_ket in ('TM', 'TIK')
						) = 0  and tp.kd_ket in ('TM', 'TIK')
					then '' else trim(tk.keterangan) end as keterangan
				from (
					select trim(kd_ket) as kd_ket
					from \"Presensi\".tdatapresensi
					where noind = '$noind'
					and tanggal = '$tgl'
					and kd_ket != 'PKJ'
					union
					select trim(kd_ket) as kd_ket
					from \"Presensi\".tdatatim
					where noind = '$noind'
					and tanggal = '$tgl'
				) as tp
				inner join \"Presensi\".tketerangan tk on tp.kd_ket = tk.kd_ket";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getKeteranganArrayNoind($noind, $tgl)
	{
		$tanggal = explode(" - ", $tgl);
		$tgl1 = $tanggal[0];
		$tgl2 = $tanggal[1];
		$sql = "select tp.noind,tp.tanggal,tk.keterangan
				from (
					select noind,tanggal,kd_ket
					from \"Presensi\".tdatapresensi
					where noind in ($noind)
					and tanggal between '$tgl1' and '$tgl2'
					and kd_ket != 'PKJ'
					union
					select noind,tanggal,kd_ket
					from \"Presensi\".tdatatim
					where noind in ($noind)
					and tanggal between '$tgl1' and '$tgl2'
				) as tp
				inner join \"Presensi\".tketerangan tk on tp.kd_ket = tk.kd_ket";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getShiftByNoind($noind, $tgl)
	{
		$tanggal = explode(" - ", $tgl);
		$tgl1 = $tanggal[0];
		$tgl2 = $tanggal[1];
		$sql = "select * from
				(
					select tsp.tanggal,
					to_char(tsp.tanggal,'dd/mm/yyyy') tgl,
					ts.shift
					from \"Presensi\".tshiftpekerja tsp
					inner join \"Presensi\".tshift ts
						on ts.kd_shift = tsp.kd_shift
					where tsp.noind = '$noind'
					and tsp.tanggal between '$tgl1' and '$tgl2'
					union
					select cast(dates as date) , to_char(dates,'dd/mm/yyyy') tgl, null
					from generate_series('$tgl1','$tgl2',interval '1 days') as dates
					where dates not in(
									select tsp.tanggal
									from \"Presensi\".tshiftpekerja tsp
									where tsp.noind = '$noind'
									and tsp.tanggal between '$tgl1' and '$tgl2'
										)
				) as shift
				order by shift.tanggal";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getCountWaktu($noind, $tgl)
	{
		$tanggal = explode(" - ", $tgl);
		$tgl1 = date('Y-m-d', strtotime($tanggal[0]));
		$tgl2 = date('Y-m-d', strtotime($tanggal[1]));
		if ($noind == 'L8001') {
			$sql = "SELECT max(waktu)
				from (select count(waktu) as waktu from \"Presensi\".tprs_shift2 tp
				where tp.noind = '$noind'
				and tp.tanggal between '$tgl1' and '$tgl2' group by tp.tanggal) as waktu";
		} else {
			$sql = "SELECT max(waktu)
				from (select count(waktu) as waktu from \"Presensi\".tprs_shift tp
				where tp.noind = '$noind'
				and tp.tanggal between '$tgl1' and '$tgl2' and tp.waktu not in ('0') group by tp.tanggal) as waktu";
		}
		$result = $this->personalia->query($sql);
		return $result->row()->max;
	}

	public function getShiftArrayNoind($noind, $tgl)
	{
		$tanggal = explode(" - ", $tgl);
		$tgl1 = $tanggal[0];
		$tgl2 = $tanggal[1];
		$sql = "select * from
				(
					select tsp.noind,tsp.tanggal,
					to_char(tsp.tanggal,'dd/mm/yyyy') tgl,
					ts.shift
					from \"Presensi\".tshiftpekerja tsp
					inner join \"Presensi\".tshift ts
						on ts.kd_shift = tsp.kd_shift
					where tsp.noind in ($noind)
					and tsp.tanggal between '$tgl1' and '$tgl2'
				) as shift
				order by shift.noind,shift.tanggal";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getSeksiByAkses($user, $ks)
	{
		$sql = "select 
							left(h.kodesie,7) as kodesie,
							ts.seksi
						from 
							\"Presensi\".t_hak_akses_presensi h 
						left join
							hrd_khs.tseksi ts using(kodesie)
						where 
							h.noind = '$user'
						union	
						select
							left(ts.kodesie,7) as kodesie,
							ts.seksi
						from 
							hrd_khs.tseksi ts
						where 
							ts.kodesie = '$ks'
						order by kodesie";
		$result = $this->personalia->query($sql)->result_array();

		return $result;
	}
}
