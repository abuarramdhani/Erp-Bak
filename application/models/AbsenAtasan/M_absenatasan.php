<?php 
Defined('BASEPATH') or exit('No Direct Sekrip Access Allowed');

class M_absenatasan extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();

		$this->personalia   =   $this->load->database('personalia', TRUE) ;
        $this->erp          =   $this->load->database('erp_db', TRUE);
	}

	public function getListAbsenById($id){
		$query = $this->db->query("SELECT absen.*,jenis.* FROM at.at_absen absen,at.at_jenis_absen jenis WHERE absen.absen_id='$id' AND absen.jenis_absen_id = jenis.jenis_absen_id");
        return $query->result_array();
	}

	
	public function getList($approver){
		// print_r($approver);exit();	
		$sql = "SELECT approval.approver, absen.*,jenis.* FROM at.at_absen_approval approval, at.at_absen absen,at.at_jenis_absen jenis WHERE approval.approver='$approver' AND approval.absen_id = absen.absen_id AND absen.jenis_absen_id = jenis.jenis_absen_id ORDER BY approval.status desc";
		$query = $this->db->query($sql);
		// print_r($sql);exit();
		return $query->result_array();
	}

	public function getJenisAbsen(){
		$sql = "SELECT aa.*, ja.* FROM at.at_absen aa LEFT JOIN at.at_jenis_absen ja ON aa.jenis_absen_id = ja.jenis_absen_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getEmployeeInfo($noinduk){
		$sql = "SELECT * FROM er.vi_er_employee_data WHERE employee_code='$noinduk'";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getFieldUnitInfo($sectionCode){
		$sql = "SELECT * FROM er.er_section WHERE section_code='$sectionCode'";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	public function getAtasan($absen_id){
		$sql 	= "SELECT approver FROM at.at_absen_approval WHERE absen_id='$absen_id'";
		$query 	= $this->db->query($sql);

		return $query->result_array();
	}

	public function approveAbsenApproval($id,$data1){
		$this->db->where('absen_id',$id);
		$this->db->update('at.at_absen_approval',$data1);
	}

	public function approveAbsen($id,$data2){
		$this->db->where('absen_id',$id);
		$this->db->update('at.at_absen',$data2);
	}

	public function rejectAbsenApproval($id,$data1){
		$this->db->where('absen_id',$id);
		$this->db->update('at.at_absen_approval',$data1);
	}
	public function rejectAbsen($id,$data2){
		$this->db->where('absen_id',$id);
		$this->db->update('at.at_absen',$data2);
	}

	public function getEmployeeEmail($noinduk){
		$sql = "SELECT * FROM er.er_employee_all WHERE employee_code='$noinduk'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getEmployeeEmailByNama($nama){
		$sql = "SELECT * FROM er.er_employee_all WHERE employee_name='$nama'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getEmailPersonalia(){
		$sql = "SELECT * FROM er.er_employee_all WHERE employee_code IN ('B0697','B0696','B0720','J1260','J1237') ";
		$query = $this->db->query($sql);
		return $query->result_array();		
	}




	

}


?>	