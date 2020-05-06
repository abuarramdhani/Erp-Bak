<?php 
Defined('BASEPATH') or exit('No Direct Sekrip Access Allowed');

class M_pekerjalaju extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia', true);
	}

	public function getPekerjaLajuAll(){
		$sql = "select *, (select trim(employee_name) from er.er_employee_all where employee_code = al.user_input) as nama_user from at.at_laju al";
		return $this->db->query($sql)->result_array();
	}

	public function insertPekerjaLaju($data){
		$this->db->insert('at.at_laju',$data);
	}

	public function getPekerjaByKey($key){
		$sql = "select employee_code as noind, trim(employee_name) as nama
				from er.er_employee_all 
				where (
					employee_code like upper(concat('%',?,'%'))
					or employee_name like upper(concat('%',?,'%'))
					)
				and resign = '0'";
		return $this->db->query($sql,array($key,$key))->result_array();
	}

	public function getPekerjaDetailByNoind($noind){
		$sql = "select trim(nama) as nama,
					trim(alamat) as alamat,
					trim(desa) as desa,
					trim(kec) as kecamatan,
					trim(kab) as kabupaten,
					trim(prop) as provinsi
				from hrd_khs.tpribadi
				where noind = ?";
		return $this->personalia->query($sql,array($noind))->row();
	}

	public function getjenisTransportasi(){
		$sql = "select jenis_transportasi,id_transportasi
				from at.at_jenis_transportasi";
		return $this->db->query($sql)->result_array();
	}

	public function deletePekerjaLajubyID($id){
		$this->db->where('laju_id',$id);
		$this->db->delete('at.at_laju');
	}

	public function getPekerjaLajuByID($id){
		$sql = "select *
				from at.at_laju
				where laju_id = ?";
		return $this->db->query($sql,array($id))->row();
	}

	public function updatePekerjaLaju($data,$id){
		$this->db->where('laju_id',$id);
		$this->db->update('at.at_laju',$data);
	}

}

?>