<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class M_monitoringcovid extends CI_Model {
	
	function __construct() {
		$this->load->database();
		$this->personalia = $this->load->database('personalia', true);
		$this->erp = $this->load->database('erp_db', true);
	}

	function getPekerjaBykey($key){
		$sql = "select noind,trim(nama) as nama
				from hrd_khs.tpribadi
				where (
					noind like upper(concat(?,'%'))
					or nama like upper(concat('%',?,'%'))
				) 
				and keluar = '0';";
		return $this->personalia->query($sql,array($key,$key))->result_array();
	}

	function getpekerjaDetailByNoind($noind){
		$sql = "select trim(b.dept) as dept, trim(b.seksi) as seksi
				from hrd_khs.tpribadi a
				inner join hrd_khs.tseksi b 
				on a.kodesie = b.kodesie
				where noind = ?";
		return $this->personalia->query($sql,array($noind))->row();
	}

	function insertPekerja($data){
		$this->erp->insert('cvd.cvd_pekerja',$data);
		return $this->erp->insert_id();
	}

	function getStatusKondisi(){
		$sql = "select *
				from cvd.cvd_status_kondisi
				order by 1 ";
		return $this->erp->query($sql)->result_array();
	}

	function getPekerjaAll(){
		$sql = "select a.cvd_pekerja_id,
					a.noind,
					b.employee_name as nama,
					c.section_name as seksi, 
					c.department_name as dept, 
					a.status_kondisi_id, 
					a.tgl_interaksi, 
					a.kasus, 
					a.keterangan, 
					a.mulai_isolasi, 
					a.selesai_isolasi,
					abs(extract(day from age(a.mulai_isolasi,a.selesai_isolasi))) as lama_isolasi,
					a.created_by
				from cvd.cvd_pekerja a
				inner join er.er_employee_all b 
				on a.noind = b.employee_code
				inner join er.er_section c 
				on b.section_code = c.section_code
				order by a.status_kondisi_id ";
		return $this->erp->query($sql)->result_array();
	}

	function getPekerjaByStatus($status){
		$sql = "select a.cvd_pekerja_id,
					a.noind,
					b.employee_name as nama,
					c.section_name as seksi, 
					c.department_name as dept, 
					a.status_kondisi_id, 
					a.tgl_interaksi, 
					a.kasus, 
					a.keterangan, 
					a.mulai_isolasi, 
					a.selesai_isolasi,
					abs(extract(day from age(a.mulai_isolasi,a.selesai_isolasi))) as lama_isolasi,
					a.created_by
				from cvd.cvd_pekerja a
				inner join er.er_employee_all b 
				on a.noind = b.employee_code
				inner join er.er_section c 
				on b.section_code = c.section_code
				where a.status_kondisi_id = ?
				order by a.status_kondisi_id ";
		return $this->erp->query($sql,array($status))->result_array();
	}

	function deletePekerjaById($id){
		$this->erp->where('cvd_pekerja_id',$id);
		$this->erp->delete('cvd.cvd_pekerja');
	}

	function updateStatusPekerjaById($status,$id){
		$data = array(
			'status_kondisi_id' => $status
		);
		$this->erp->where('cvd_pekerja_id',$id);
		$this->erp->update('cvd.cvd_pekerja',$data);
	}

	function getWawancaraIsolasiByPekerjaId($id){
		$sql = "select *
				from cvd.cvd_wawancara a
				where cvd_pekerja_id = ?
				and jenis = 1";
		return $this->erp->query($sql,array($id))->row();
	}

	function getWawancaraMasukByPekerjaId($id){
		$sql = "select *
				from cvd.cvd_wawancara a
				where cvd_pekerja_id = ?
				and jenis = 2";
		return $this->erp->query($sql,array($id))->row();
	}

	function getLampiranByPekerjaId($id){
		$sql = "select b.*
				from cvd.cvd_wawancara a 
				inner join cvd.cvd_wawancara_lampiran b 
				on a.wawancara_id = b.wawancara_id
				where a.cvd_pekerja_id = ?";
		return $this->erp->query($sql,array($id))->result_array();
	}

	function getLampiranByWawancaraId($id){
		$sql = "select *
				from cvd.cvd_wawancara_lampiran
				where wawancara_id = ?";
		return $this->erp->query($sql,array($id))->result_array();
	}

	function updateWawancaraById($data,$id){
		$this->erp->where('wawancara_id', $id);
		$this->erp->update('cvd.cvd_wawancara', $data);
	}

	function insertWawancara($data){
		$this->erp->insert('cvd.cvd_wawancara', $data);
		return $this->erp->insert_id();
	}

	function updateKeputusanByWawancaraId($data,$id){
		$this->erp->where('wawancara_id', $id);
		$this->erp->update('cvd.cvd_keputusan', $data);
	}

	function insertKeputusan($data){
		$this->erp->insert('cvd.cvd_keputusan',$data);
	}

	function insertLampiran($data){
		$this->erp->insert('cvd.cvd_wawancara_lampiran', $data);
	}

	function getPekerjaById($id){
		$sql = "select a.cvd_pekerja_id,
					a.noind,
					b.employee_name as nama,
					c.section_name as seksi, 
					c.department_name as dept, 
					a.status_kondisi_id, 
					a.tgl_interaksi, 
					a.kasus, 
					a.keterangan, 
					a.mulai_isolasi, 
					a.selesai_isolasi,
					a.keterangan,
					a.created_by
				from cvd.cvd_pekerja a
				inner join er.er_employee_all b 
				on a.noind = b.employee_code
				inner join er.er_section c 
				on b.section_code = c.section_code
				where cvd_pekerja_id = ?";
		return $this->erp->query($sql,array($id))->row();
	}

	function updatePekerjaById($data,$id){
		$this->erp->where('cvd_pekerja_id',$id);
		$this->erp->update('cvd.cvd_pekerja',$data);
	}

	function getKeputusanByWawancaraId($id){
		$sql = "select *
				from cvd.cvd_keputusan
				where wawancara_id = ?";
		return $this->erp->query($sql,array($id))->row();
	}

	function getMemoIsolasiMandiriByPekerjaid($id){
		$sql = "select isi_surat
			from \"Surat\".tsurat_isolasi_mandiri
			where cvd_pekerja_id = ? ";
		return $this->personalia->query($sql, array($id))->row();
	}

} ?>