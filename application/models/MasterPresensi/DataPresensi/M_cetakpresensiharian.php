<?php 
defined('BASEPATH') or exit('No Direct Script Access Allowed');

/**
 * 
 */
class M_cetakpresensiharian extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->personalia = $this->load->database('personalia', true);
	}

	function getLokasiKerja()
	{
		$sql = "select id_ as kode_lokasi,lokasi_kerja as nama_lokasi
			from hrd_khs.tlokasi_kerja
			order by id_";
		return $this->personalia->query($sql)->result_array();
	}
	
	function getKodeInduk()
	{
		$sql = "select fs_noind as noind,fs_ket as ket
			from hrd_khs.tnoind
			order by fs_noind";
		return $this->personalia->query($sql)->result_array();
	}

	function getKodesie($key,$kodesie,$tingkat)
	{
		$panjang = strlen($kodesie);
		$where_kodesie = " and left(kodesie,$panjang) = '$kodesie' ";

		switch ($tingkat) {
			case '1':
				$where_kodesie = "";
				$where_key = " and (dept like '%$key%' or kodesie like '$key%') ";
				$select = " left(kodesie,$tingkat) as kode, dept as nama";
				$tambahan = "";
				break;
			case '3':
				$where_key = " and (bidang like '%$key%' or kodesie like '$key%') ";
				$select = " left(kodesie,$tingkat) as kode, 
					case when trim(bidang) = '-' then 'Hanya tingkat Departemen' else bidang end as nama";
				$tambahan = " union select '$kodesie' as kode, 'Semua Bidang' as nama";
				break;
			case '5':
				$where_key = " and (unit like '%$key%' or kodesie like '$key%') ";
				$select = " left(kodesie,$tingkat) as kode, 
					case when trim(unit) = '-' then 'Hanya tingkat Bidang' else unit end as nama";
				$tambahan = " union select '$kodesie' as kode, 'Semua Unit' as nama";
				break;
			case '7':
				$where_key = " and (seksi like '%$key%' or kodesie like '$key%') ";
				$select = " left(kodesie,$tingkat) as kode, 
					case when trim(seksi) = '-' then 'Hanya tingkat Unit' else seksi end as nama";
				$tambahan = " union select '$kodesie' as kode, 'Semua Seksi' as nama";
				break;
			case '9':
				$where_key = " and (pekerjaan like '%$key%' or kodesie like '$key%') ";
				$select = " left(kodesie,$tingkat) as kode, 
					case when trim(pekerjaan) = '-' then 'Hanya tingkat Seksi' else pekerjaan end as nama";
				$tambahan = " union select '$kodesie' as kode, 'Semua Pekerjaan' as nama";
				break;
			default:
				$where_kodesie = "";
				$where_key = "";
				$select = " kodesie as kode, dept as nama";
				break;
		}
		$sql = "select distinct $select
			from hrd_khs.tseksi
			where kodesie != '-'
			$where_kodesie
			$where_key
			$tambahan
			order by 1";
		return $this->personalia->query($sql)->result_array();
	}

	function getSeksiByKodesie($kodesie)
	{
		$panjang = strlen($kodesie);
		$sql = "select kodesie,dept,bidang,unit,seksi,pekerjaan
			from hrd_khs.tseksi
			where left(kodesie,$panjang) = '$kodesie'";
		return $this->personalia->query($sql)->result_array();
	}

	function getPekerjaByFilter($filter,$awal,$akhir)
	{
		$where = "";
		if (isset($filter['lokasi_kerja']) && !empty($filter['lokasi_kerja']) && $filter['lokasi_kerja'] !== false) {
			$where .= "and a.lokasi_kerja in (".$filter['lokasi_kerja'].")";
		}
		if (isset($filter['kode_induk']) && !empty($filter['kode_induk']) && $filter['kode_induk'] !== false) {
			$where .= " and left(a.noind,1) in (".$filter['kode_induk'].") ";
		}
		if (isset($filter['kodesie']) && !empty($filter['kodesie']) && $filter['kodesie'] !== false) {
			$where .= " and a.kodesie in (".$filter['kodesie'].") ";
		}
		if (isset($filter['noind']) && !empty($filter['noind']) && $filter['noind'] !== false) {
			$where .= " and a.noind in (".$filter['noind'].")";
		}
		
		$sql = "select a.nama,a.noind,b.seksi,b.unit 
			from hrd_khs.tpribadi a 
			inner join hrd_khs.tseksi b 
			on a.kodesie = b.kodesie
			where (
				keluar = '0'
				or (
					keluar = '1'
					and tglkeluar >= '$awal'
				)
			)
			and masukkerja <= '$akhir'
			and left(noind,1) not in ('M','Z')
			$where
			order by a.kodesie,a.noind";
		return $this->personalia->query($sql)->result_array();
	}

	function getShiftPekerjaByNoindPeriode($noind,$tgl_awal,$tgl_akhir)
	{
		$sql = "select tgl.tgl::date as tanggal,b.shift as shift
			from generate_series(?,?,interval '1 day') as tgl
			left join \"Presensi\".tshiftpekerja a
			on a.tanggal = tgl.tgl
			and a.noind = ?
			left join \"Presensi\".tshift b 
			on a.kd_shift = b.kd_shift
			order by tgl.tgl";
		return $this->personalia->query($sql,array($tgl_awal,$tgl_akhir,$noind))->result_array();
	}

	function getPresensiHarianByNoindTanggal($noind,$tanggal)
	{
		$sql = "select waktu
			from \"Presensi\".tprs_shift
			where noind = ?
			and tanggal = ?
			order by waktu";
		return $this->personalia->query($sql,array($noind,$tanggal))->result_array();
	}

	function getPointByNoindTanggal($noind,$tanggal)
	{
		$sql = "select coalesce(sum(point),0) as point
			from \"Presensi\".tdatatim
			where noind = ?
			and tanggal = ?";
		$result = $this->personalia->query($sql,array($noind,$tanggal))->row();
		return !empty($result) ? $result->point : 0;
	}

	function getPekerjaByKey($key)
	{
		$sql = "select a.noind, a.nama
			from hrd_khs.tpribadi a
			where a.keluar = '0'
			and (
				a.noind like concat(?,'%')
				or a.nama like concat('%',?,'%')
			)
			order by a.noind";
		return $this->personalia->query($sql,array(strtoupper($key),strtoupper($key)))->result_array();
	}

	function getketeranganByNoindTanggal($noind,$tanggal)
	{
		$sql = "select string_agg(trim(tk.keterangan),', ' order by tp.kd_ket) as keterangan
			from (
				select trim(kd_ket) as kd_ket
				from \"Presensi\".tdatapresensi
				where noind = ?
				and tanggal = ?
				and kd_ket != 'PKJ'
				union
				select trim(kd_ket) as kd_ket
				from \"Presensi\".tdatatim
				where noind = ?
				and tanggal = ?
				and point > 0
			) as tp
			inner join \"Presensi\".tketerangan tk 
			on tp.kd_ket = tk.kd_ket";
		$result = $this->personalia->query($sql,array($noind,$tanggal,$noind,$tanggal))->row();
		return !empty($result) ? $result->keterangan : '';
	}
}
?>