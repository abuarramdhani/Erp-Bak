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

	function getPekerjaByFilter($filter,$tanggal)
	{
		$where = "";
		if (isset($filter['lokasi_kerja']) && !empty($filter['lokasi_kerja'])) {
			$where .= "and lokasi_kerja in (".$filter['lokasi_kerja'].")";
		}
		if (isset($filter['kode_induk']) && !empty($filter['kode_induk'])) {
			$where .= " and  left(noind,1) in (".$filter['kode_induk'].") ";
		}
		$sql = "select a.nama,a.noind,b.seksi,b.unit 
			from hrd_khs.tpribadi a 
			inner join hrd_khs.tseksi b 
			on a.kodesie = b.kodesie
			where (
				keluar = '0'
				or (
					keluar = '1'
					and tglkeluar >= '$tanggal'
				)
			)
			and left(noind,1) not in ('M','Z')
			$where
			order by a.kodesie,a.noind";
		return $this->personalia->query($sql)->result_array();
	}

	function getShiftPekerjaByNoindPeriode($noind,$tgl_awal,$tgl_akhir)
	{
		$sql = "select tgl.tgl::date as tanggal,replace(b.shift,'SHIFT','') as shift
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
}
?>