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
	function insertZonaKhsDetail($data){
		$this->erp->insert('cvd.cvd_zona_khs_detail', $data);
		return $this->erp->insert_id();
	}

	function getZonaKhsAll(){
		$sql = "select a.id_zona,a.nama_seksi,a.lokasi, 
				case when (
					select count(*)
					from cvd.cvd_zona_khs_detail b
					where a.id_zona = b.id_zona
					and current_date between b.tgl_awal_isolasi and b.tgl_akhir_isolasi
				) > 0 then 'Ya' else 'Tidak' end as isolasi,
				c.tgl_awal_isolasi,c.tgl_akhir_isolasi,c.kasus
			from cvd.cvd_zona_khs a
			left join cvd.cvd_zona_khs_detail c 
			on a.id_zona = c.id_zona
			order by a.id_zona,c.tgl_awal_isolasi,c.tgl_akhir_isolasi desc";
		return $this->erp->query($sql)->result_array();
	}

	function getZonaKhsByIdZona($id_zona){
		$sql = "select *
			from cvd.cvd_zona_khs
			where id_zona = ?";
		return $this->erp->query($sql,array($id_zona))->row();
	}

	function getKasusByIdZona($id_zona){
		$sql = "select *
			from cvd.cvd_zona_khs_detail
			where id_zona = ?
			order by tgl_awal_isolasi,tgl_akhir_isolasi";
		return $this->erp->query($sql,array($id_zona))->result_array();
	}

	function deleteZonaKhsByIdZona($id_zona){
		$this->erp->where('id_zona', $id_zona);
		$this->erp->delete('cvd.cvd_zona_khs');
	}

	function deleteZonaKhsDetailByIdZona($id_zona){
		$this->erp->where('id_zona', $id_zona);
		$this->erp->delete('cvd.cvd_zona_khs_detail');
	}

	function updateZonaKhsByIdZona($data,$id_zona){
		$this->erp->where('id_zona', $id_zona);
		$this->erp->update('cvd.cvd_zona_khs', $data);
	}

	function getSummaryZonaKHS(){
		$sql = "select (
				select count(*)
				from cvd.cvd_zona_khs a
				where lokasi = 'JOGJA'
				and (
					select count(*)
					from cvd.cvd_zona_khs_detail b
					where a.id_zona = b.id_zona
					and current_date between b.tgl_awal_isolasi and b.tgl_akhir_isolasi
				) > 0
			) as is_jogja,
			(
				select count(*)
				from cvd.cvd_zona_khs a
				where lokasi = 'TUKSONO'
				and (
					select count(*)
					from cvd.cvd_zona_khs_detail b
					where a.id_zona = b.id_zona
					and current_date between b.tgl_awal_isolasi and b.tgl_akhir_isolasi
				) > 0
			) as is_tuksono,
			(
				select count(*)
				from cvd.cvd_zona_khs a
				where lokasi = 'JOGJA'
				and (
					select count(*)
					from cvd.cvd_zona_khs_detail b
					where a.id_zona = b.id_zona
					and current_date = b.tgl_akhir_isolasi
				) > 0
			) as is_jogja_finish,
			(
				select count(*)
				from cvd.cvd_zona_khs a
				where lokasi = 'TUKSONO'
				and (
					select count(*)
					from cvd.cvd_zona_khs_detail b
					where a.id_zona = b.id_zona
					and current_date = b.tgl_akhir_isolasi
				) > 0
			) as is_tuksono_finish";
		return $this->erp->query($sql)->row();
	}

	function insertZonaKhsHistory($id_zona,$user,$action){
		$sql = "insert into cvd.cvd_zona_khs_history
			(id_zona,nama_seksi, lokasi, tgl_awal_isolasi, tgl_akhir_isolasi, kasus, koordinat, last_tgl_akhir_isolasi, created_history_by, created_history_timestamp,action_history)
			select a.id_zona,a.nama_seksi,a.lokasi,b.tgl_awal_isolasi,b.tgl_akhir_isolasi,b.kasus,a.koordinat,a.last_tgl_akhir_isolasi,?,now(), ?
			from cvd.cvd_zona_khs a
			inner join cvd.cvd_zona_khs_detail b 
			on a.id_zona = b.id_zona
			where a.id_zona = ?";
		$this->erp->query($sql,array($user,$action,$id_zona));
	}

	function getAreaIsolasiByKey($key){
		$sql = "select a.*
			from cvd.cvd_zona_khs a
			where upper(nama_seksi) like upper(concat('%',?,'%'))";
		return $this->erp->query($sql,array($key))->result_array();
	}

	function getIsolasiBerakhirHariIni(){
		$sql = "select *
			from cvd.cvd_zona_khs a
			inner join cvd.cvd_zona_khs_detail b 
			on a.id_zona = b.id_zona
			where current_date = b.tgl_akhir_isolasi
			order by a.id_zona,b.tgl_awal_isolasi";
		return $this->erp->query($sql)->result_array();
	}

	function getKasusByKeyIdZona($key,$id_zona){
		$sql = "select a.*
			from cvd.cvd_zona_khs_detail a
			where upper(kasus) like upper(concat('%',?,'%'))
			and id_zona = ?";
		return $this->erp->query($sql,array($key,$id_zona))->result_array();
	}

	function getPeriodeByIdZonaDetail($id_zona_detail){
		$sql = "select *
			from cvd.cvd_zona_khs_detail 
			where id_zona_detail = ?";
		return $this->erp->query($sql,array($id_zona_detail))->row();
	}

	function getKasusZonaKhsByIdZonaIdZonaDetail($id_zona, $id_zona_detail){
		$sql = "select *
			from cvd.cvd_zona_khs a
			inner join cvd.cvd_zona_khs_detail b 
			on a.id_zona = b.id_zona
			where a.id_zona = ?
			and b.id_zona_detail = ?";
		return $this->erp->query($sql,array($id_zona, $id_zona_detail))->row();
	}

}

?>