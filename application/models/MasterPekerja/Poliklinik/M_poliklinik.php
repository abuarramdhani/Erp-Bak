<?php
defined('BASEPATH') or exit('No Direct Script Access ALlowed');
/**
 *
 */
class M_poliklinik extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->erp = $this->load->database('default', TRUE);
	}

	public function getPekerjaByKey($key){
		$sql = "select employee_code as noind, trim(employee_name) as nama
				from er.er_employee_all
				where (
				upper(employee_code) like concat('%',upper(?),'%') 
				or upper(employee_name) like concat('%',upper(?),'%')
				) and resign = '0'";
		return $this->erp->query($sql,array($key,$key))->result_array();
	}

	public function getKeteranganByKey($key){
		$sql = "select distinct upper(keterangan) as keterangan
				from hr.hr_poliklinik_kunjungan_detail
				where upper(keterangan) like concat('%',upper(?),'%')";
		return $this->erp->query($sql,array($key))->result_array();
	}

	public function insertKunjungan($data){
		$this->erp->insert('hr.hr_poliklinik_kunjungan',$data);
		return $this->erp->insert_id();
	}

	public function insertKunjunganDetail($data_detail){
		$this->erp->insert('hr.hr_poliklinik_kunjungan_detail',$data_detail);
	}

	public function getDataKunjunganAll(){
		$sql = "select hpk.*, 
				(
					select string_agg(upper(hpkd.keterangan),', ')
					from hr.hr_poliklinik_kunjungan_detail hpkd
					where hpkd.id_kunjungan = hpk.id_kunjungan
				) as keterangan,
				eea.employee_name,
				es.*
				from hr.hr_poliklinik_kunjungan hpk
				left join er.er_employee_all eea 
				on hpk.noind = eea.employee_code
				left join er.er_section es 
				on eea.section_code = es.section_code
				order by hpk.created_timestamp desc ";
		return $this->erp->query($sql)->result_array();
	}

	public function getDataKunjunganById($id){
		$sql = "select hpk.*, 
				(
					select string_agg(upper(hpkd.keterangan),', ')
					from hr.hr_poliklinik_kunjungan_detail hpkd
					where hpkd.id_kunjungan = hpk.id_kunjungan
				) as keterangan,
				eea.employee_name
				from hr.hr_poliklinik_kunjungan hpk
				left join er.er_employee_all eea 
				on hpk.noind = eea.employee_code
				where hpk.id_kunjungan = ?";
		return $this->erp->query($sql,array($id))->row();
	}

	public function updateKunjunganById($data,$id){
		$this->erp->where('id_kunjungan',$id);
		$this->erp->update('hr.hr_poliklinik_kunjungan',$data);
	}

	public function deleteKunjunganDetailByIdKunjungan($id){
		$this->erp->where('id_kunjungan',$id);
		$this->erp->delete('hr.hr_poliklinik_kunjungan_detail');
	}

	public function deleteKunjunganById($id){
		$this->erp->where('id_kunjungan',$id);
		$this->erp->delete('hr.hr_poliklinik_kunjungan');
	}

	public function insertKunjunganHistory($data){
		$this->erp->insert('hr.hr_poliklinik_kunjungan_history',$data);
	}
}

?>