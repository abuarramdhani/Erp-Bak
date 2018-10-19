<?php defined('BASEPATH')OR exit('No direct script access allowed');
class m_testcorrection extends CI_Model
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

	function getRule($jenis)
		{
			$sql = "SELECT * FROM er.er_rule WHERE jenis_soal = '$jenis' order by nomor asc";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function getBatch()
		{
			$sql = "SELECT MAX(batch_upload) batch FROM er.er_jawaban";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function saveKoreksi($data)
		{
			$this->db->insert('er.er_jawaban',$data);
			return $this->db->insert_id();
		}

	function getJawaban($id)
		{
			if ($id != "") {
				$sql ="SELECT * FROM er.er_jawaban WHERE batch_upload = $id";
			}else{
				$sql ="SELECT * FROM er.er_jawaban";
			}
			$query= $this->db->query($sql);
			return $query->result_array();
		}

	function getResult()
		{
			$sql = "SELECT distinct(batch_upload) batch_upload, tgl_upload, jenis_soal FROM er.er_jawaban ORDER BY batch_upload";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function getJenisSoal()
		{
			$sql = "SELECT distinct(jenis_soal) jenis_soal FROM er.er_rule";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function getJumlahSoal($id)
		{
			$sql = "SELECT * FROM er.er_rule WHERE jenis_soal =  '$id'";
			$query = $this->db->query($sql);
			return $query->num_rows();
		}

	function updateRule($id,$data)
		{
			$this->db->where('rule_id',$id);
			$this->db->update('er.er_rule',$data);
		}

	function insertRule($data)
		{
			$this->db->insert('er.er_rule',$data);
			return $this->db->insert_id();
		}

	function deleteRule($id,$jenis)
		{
			$sql = "DELETE FROM er.er_rule WHERE rule_id NOT IN ('$id') AND jenis_soal ='$jenis'";
			$query = $this->db->query($sql);
		}

	function delete($id)
		{
			$sql = "DELETE FROM er.er_rule WHERE jenis_soal ='$id'";
			$query = $this->db->query($sql);
		}

	function delByBatch($id)
		{
			$sql = "DELETE FROM er.er_jawaban WHERE batch_upload ='$id'";
			$query = $this->db->query($sql);
		}

	function saveResult($data)
		{
			$this->db->insert('er.er_hasil_check',$data);
		}

	function getIdJwb($id)
		{
			$sql = "SELECT jawaban_id FROM er.er_jawaban WHERE batch_upload ='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function delResult($id)
		{
			$sql = "DELETE FROM er.er_hasil_check WHERE jawaban_id ='$id'";
			$query = $this->db->query($sql);
		}
		
}