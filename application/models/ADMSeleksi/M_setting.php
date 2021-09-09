<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_setting extends CI_Model{
  	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	function get_max_id_tes(){
		$sql = $this->personalia->query("SELECT MAX(id_tes) as max_id FROM \"Adm_Seleksi\".tsetuppertanyaan");
		if ($sql->num_rows() > 0) {
			return $sql->result();
		} else {
			return null;
		}
	}

	function get_max_id_pertanyaan(){
		$sql = $this->personalia->query("SELECT MAX(id_pertanyaan) as max_id FROM \"Adm_Seleksi\".tspertanyaan");
		if ($sql->num_rows() > 0) {
			return $sql->result();
		} else {
			return null;
		}
	}

	function SetupPertanyaan($id_tes, $nama_tes, $jml_soal, $tipe_pilihan, $instruksi_tes, $menit, $detik, $checkinstruksi){
		$save_data = $this->personalia->query("INSERT INTO \"Adm_Seleksi\".tsetuppertanyaan (id_tes, nama_tes, jml_soal, tipe_pilihan, instruksi_tes, menit, detik, instruksi_flag) 
		VALUES ($id_tes, '$nama_tes', $jml_soal, '$tipe_pilihan', '$instruksi_tes', $menit, $detik, '$checkinstruksi')");
		return;
	}

	function save_file_question($id_pertanyaan, $docname, $docpath, $doctype){
		$save_data = $this->personalia->query("INSERT INTO \"Adm_Seleksi\".tsfilequestion (id_pertanyaan, doc_name, doc_type, doc_path) 
		VALUES ($id_pertanyaan, '$docname','$doctype','$docpath')");
		return;
	}

	function SavePertanyaan($id_tes, $id_pertanyaan, $pertanyaan){
		$save_data = $this->personalia->query("INSERT INTO \"Adm_Seleksi\".tspertanyaan (id_tes, id_pertanyaan, pertanyaan) 
		VALUES ($id_tes, $id_pertanyaan, '$pertanyaan')");
		return;
	}

	function SaveJawaban($id_pertanyaan, $jawaban, $isCorrect, $file_name, $file_type, $file_path){
		$save_data = $this->personalia->query("INSERT INTO \"Adm_Seleksi\".tsjawaban (id_pertanyaan, jawaban, status_correct, doc_name, doc_type, doc_path) 
		VALUES ($id_pertanyaan, '$jawaban', $isCorrect , '$file_name', '$file_type', '$file_path')");
		return;
	}

	function cek_pertanyaan($id_pertanyaan){
		$get_sql = $this->personalia->query("SELECT *,
		(SELECT COUNT(*) 
		FROM \"Adm_Seleksi\".tsfilequestion AS xx 
		WHERE xx.id_pertanyaan = b.id_pertanyaan) AS num_file 
		FROM \"Adm_Seleksi\".tspertanyaan AS b 
		WHERE b.id_pertanyaan = '$id_pertanyaan'");
		return $get_sql;
	}

	function update_question($id_pertanyaan, $rename_question){
		$update_record = $this->personalia->query("UPDATE \"Adm_Seleksi\".tspertanyaan 
		SET pertanyaan = '$rename_question' 
		WHERE id_pertanyaan = '$id_pertanyaan'");
		return;
	}

	function update_ans($txt_id, $rename_txt_ans, $txt_ans_status){
		$update_record = $this->personalia->query("UPDATE \"Adm_Seleksi\".tsjawaban 
		SET jawaban = '$rename_txt_ans', status_correct = $txt_ans_status
		WHERE id_jawaban = '$txt_id'");
		return;
	}

	// function update_file_image($id_image, $num_soal, $docname, $docpath, $doctype){
	function update_file_image($id_image, $docname, $docpath, $doctype){
		$update_record = $this->personalia->query("UPDATE \"Adm_Seleksi\".tsfilequestion 
		SET doc_name = '$docname', doc_type = '$doctype', doc_path = '$docpath' 
		-- SET no_soal = '$num_soal', doc_name = '$docname', doc_type = '$doctype', doc_path = '$docpath' 
		WHERE id = '$id_image'");
		return;
	}

	function update_file_image_ans($txt_id, $docname, $docpath, $doctype){
		$update_record = $this->personalia->query("UPDATE \"Adm_Seleksi\".tsjawaban 
		SET doc_name = '$docname', doc_type = '$doctype', doc_path = '$docpath' 
		WHERE id_jawaban = '$txt_id'");
		return;
	}

	function get_namates($id_tes){
		if ($id_tes === FALSE) {
			$sql = $this->personalia->query("SELECT * FROM \"Adm_Seleksi\".tsetuppertanyaan");
		} else {
			$sql = $this->personalia->query("SELECT * FROM \"Adm_Seleksi\".tsetuppertanyaan WHERE id_tes = $id_tes");
		}
		return $sql->result_array();
	}

	function get_pertanyaan($id_tes){
		$sql = $this->personalia->query("SELECT * FROM \"Adm_Seleksi\".tspertanyaan WHERE id_tes = $id_tes");
		return $sql->result_array();
	}

	function get_pertanyaan_by_id($id_pertanyaan){
		$sql = $this->personalia->query("SELECT * FROM \"Adm_Seleksi\".tspertanyaan WHERE id_pertanyaan = $id_pertanyaan");
		return $sql->result_array();
	}

	function get_file_pertanyaan($id_pertanyaan){
		$sql = $this->personalia->query("SELECT * FROM \"Adm_Seleksi\".tsfilequestion WHERE id_pertanyaan = $id_pertanyaan");
		return $sql->result_array();
	}

	function get_jawaban($id_pertanyaan){
		$sql = $this->personalia->query("SELECT * FROM \"Adm_Seleksi\".tsjawaban WHERE id_pertanyaan = $id_pertanyaan");
		return $sql->result_array();;
	}

	function update_setup($id_tes, $jml_soal){
		$update_record = $this->personalia->query("UPDATE \"Adm_Seleksi\".tsetuppertanyaan 
		SET jml_soal = '$jml_soal' 
		WHERE id_tes = '$id_tes'");
		return;
	}

}

?>