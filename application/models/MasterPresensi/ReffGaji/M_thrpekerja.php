<?php
defined('BASEPATH') or exit('No Direct Script Access ALlowed');
/**
 *
 */
class M_thrpekerja extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	function getPekerjaByKey($key){
		$sql = "select noind,trim(nama) as nama
				from hrd_khs.tpribadi
				where keluar = '0'
				and (
					upper(trim(noind)) like upper(concat('%',?,'%'))
					or 
					upper(trim(nama)) like upper(concat('%',?,'%'))
				)";
		return $this->personalia->query($sql,array($key,$key))->result_array();
	}

	function getPekerjaSP3($tgl){
		$sql = "select 
					tp.noind,
					trim(nama) as nama, 
					ts.seksi,
					tp.masukkerja::date,
					tp.diangkat::date,
					tp.kode_status_kerja,
					ot.jabatan,
					tp.kd_jabatan
				from hrd_khs.tpribadi tp 
				left join hrd_khs.tseksi ts 
				on tp.kodesie = ts.kodesie
				left join hrd_khs.torganisasi ot 
				on tp.kd_jabatan = ot.kd_jabatan
				where left(tp.noind,1) in ('A', 'B', 'H', 'J', 'K', 'P', 'T')
				and tp.keluar = '0'
				and tp.akhkontrak >= ?
				and noind in (
					select noind
					from \"Surat\".v_surat_tsp_rekap
					where sp_ke = '3'
					and ? between tanggal_awal_berlaku and tanggal_akhir_berlaku
				)
				order by tp.noind	";
		return $this->personalia->query($sql,array($tgl,$tgl))->result_array();
	}

	function getPekerjaReguler($tgl){
		$sql = "select 
					tp.noind,
					trim(nama) as nama, 
					ts.seksi,
					tp.masukkerja::date,
					tp.diangkat::date,
					tp.kode_status_kerja,
					ot.jabatan,
					tp.kd_jabatan
				from hrd_khs.tpribadi tp 
				left join hrd_khs.tseksi ts 
				on tp.kodesie = ts.kodesie
				left join hrd_khs.torganisasi ot 
				on tp.kd_jabatan = ot.kd_jabatan
				where left(tp.noind,1) in ('A', 'B', 'H', 'J', 'K', 'P', 'T')
				and tp.keluar = '0'
				and tp.akhkontrak >= ?
				and noind not in (
					select noind
					from \"Surat\".v_surat_tsp_rekap
					where sp_ke = '3'
					and ? between tanggal_awal_berlaku and tanggal_akhir_berlaku
				)
				order by tp.noind";
		return $this->personalia->query($sql,array($tgl,$tgl))->result_array();
	}

	function getTHRAll(){
		$sql = "select t1.*,
					trim(t2.nama) as mengetahui_nama, 
					trim(t3.nama) as created_by_nama
				from \"Presensi\".t_thr t1 
				left join hrd_khs.tpribadi t2 
					on t1.mengetahui = t2.noind
				left join hrd_khs.tpribadi t3 
					on t1.created_by = t3.noind
				where t1.status = 1
				order by t1.created_timestamp";
		return $this->personalia->query($sql)->result_array();
	}

	function getTHRById($id){
		$sql = "select t1.*,
					trim(t2.nama) as mengetahui_nama, 
					trim(t3.nama) as created_by_nama,
					t2.jabatan as mengetahui_jab,
					t3.jabatan as created_by_jab
				from \"Presensi\".t_thr t1 
				left join hrd_khs.tpribadi t2 
					on t1.mengetahui = t2.noind
				left join hrd_khs.tpribadi t3 
					on t1.created_by = t3.noind
				where t1.id_thr = ?
				order by t1.created_timestamp";
		return $this->personalia->query($sql,array($id))->result_array();
	}

	function insertTHR($data){
		$this->personalia->insert('"Presensi".t_thr',$data);
		return $this->personalia->insert_id();
	}

	function insertTHRDetail($data){
		$this->personalia->insert('"Presensi".t_thr_detail',$data);
		return $this->personalia->insert_id();
	}

	function getTHRDetailByIdTHR($id_thr){
		$sql = "select t1.*,t2.kodesie,t2.lokasi_kerja
				from \"Presensi\".t_thr_detail t1 
				left join hrd_khs.tpribadi t2 
				on t1.noind = t2.noind
				where t1.id_thr = ?
				order by t1.noind";
		return $this->personalia->query($sql,array($id_thr))->result_array();
	}

	function hapusTHRByID($id){
		$sql = "update \"Presensi\".t_thr
				set status = '2'
				where id_thr = ?";
		$this->personalia->query($sql,array($id));
	}

}

?>