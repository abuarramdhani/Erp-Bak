<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class M_zonacovidkhs extends CI_Model {
	
	function __construct() {
		$this->load->database();
		$this->personalia = $this->load->database('personalia', true);
		$this->erp = $this->load->database('erp_db', true);
	}

	function getLokasiKerja(){
		$sql = "select *
			from hrd_khs.tlokasi_kerja
			where id_ in ('01','02')";
		return $this->personalia->query($sql)->result_array();
	}

	function insertZonaKhs($data){
		$this->erp->insert('cvd.cvd_zona_khs', $data);
		return $this->erp->insert_id();
	}

	function getZonaKhsAll(){
		$sql = "select id_zona,nama_seksi,lokasi, 
					case when isolasi = '1' then 'Ya' else 'Tidak' end as isolasi,
					tgl_awal_isolasi,tgl_akhir_isolasi,kasus,created_by,created_timestamp
			from cvd.cvd_zona_khs
			order by isolasi desc";
		return $this->erp->query($sql)->result_array();
	}

	function getZonaKhsByIdZona($id_zona){
		$sql = "select id_zona,nama_seksi,lokasi, 
					case when isolasi = '1' then '1' else '0' end as isolasi,
					tgl_awal_isolasi,tgl_akhir_isolasi,kasus,created_by,created_timestamp,koordinat
			from cvd.cvd_zona_khs
			where id_zona = ?
			order by isolasi desc";
		return $this->erp->query($sql,array($id_zona))->row();
	}

	function deleteZonaKhsByIdZona($id_zona){
		$this->erp->where('id_zona', $id_zona);
		$this->erp->delete('cvd.cvd_zona_khs');
	}

	function updateZonaKhsByIdZona($data,$id_zona){
		$this->erp->where('id_zona', $id_zona);
		$this->erp->update('cvd.cvd_zona_khs', $data);
	}

	function getSummaryZonaKHS(){
		$sql = "select (
				select count(*)
				from cvd.cvd_zona_khs
				where lokasi = 'JOGJA'
				and isolasi = '1'
				and tgl_akhir_isolasi >= current_date
			) as is_jogja,
			(
				select count(*)
				from cvd.cvd_zona_khs
				where lokasi = 'TUKSONO'
				and isolasi = '1'
				and tgl_akhir_isolasi >= current_date
			) as is_tuksono,
			(
				select count(*)
				from cvd.cvd_zona_khs
				where lokasi = 'JOGJA'
				and isolasi = '1'
				and tgl_akhir_isolasi = current_date
			) as is_jogja_finish,
			(
				select count(*)
				from cvd.cvd_zona_khs
				where lokasi = 'TUKSONO'
				and isolasi = '1'
				and tgl_akhir_isolasi = current_date
			) as is_tuksono_finish";
		return $this->erp->query($sql)->row();
	}

	function insertZonaKhsHistory($id_zona,$user){
		$sql = "insert into cvd.cvd_zona_khs_history
			(id_zona,nama_seksi, lokasi, isolasi, tgl_awal_isolasi, tgl_akhir_isolasi, kasus, koordinat, last_tgl_akhir_isolasi, created_history_by, created_history_timestamp)
			select id_zona,nama_seksi, lokasi, isolasi, tgl_awal_isolasi, tgl_akhir_isolasi, kasus, koordinat,last_tgl_akhir_isolasi,?,now()
			from cvd.cvd_zona_khs
			where id_zona = ?";
		$this->erp->query($sql,array($user,$id_zona));
	}

	function getAreaIsolasiByKey($key){
		$sql = "select *
			from cvd.cvd_zona_khs
			where upper(nama_seksi) like upper(concat('%',?,'%'))
			and isolasi = '1'";
		return $this->erp->query($sql,array($key))->result_array();
	}

	function getIsolasiBerakhirHariIni(){
		$sql = "select *
				from cvd.cvd_zona_khs
				where isolasi = '1'
				and tgl_akhir_isolasi = current_date
				order by lokasi,nama_seksi";
		return $this->erp->query($sql)->result_array();
	}

}

?>